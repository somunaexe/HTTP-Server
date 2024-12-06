<?php namespace HTTPServer;

class Request {
    protected $method = null;
    protected $uri = null;
    protected $headers = [];
    protected $parameters = [];

    public function __construct($method, $uri, $headers = []){
        $this->headers = $headers;
        $this->method = strtoupper($method);
        [$this->uri, $params] = explode('?', $uri);

        //parse the parameters
        parse_str($params, $this->parameters);
    }
    public static function withHeaderString($header){
        //Explode the string into lines
        $lines = explode("\n", $header);

        //Extract the method and uri
        [$method, $uri] = explode(' ', array_shift($lines));

        $headers = [];

        foreach ($lines as $line){
            //clean the line
            $line = trim($line);

            if(strpos($line, ': ' !== false)){
                [$key, $value] = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        //Create a new request object
        return new static($method, $uri, $headers);
    }

    public function method(){
        return $this->method;
    }

    public function uri(){
        return $this->uri;
    }

    public function header($key, $default = null){
        if(!isset($this->headers[$key])){
            return $default;
        }
        return $this->headers[$key];
    }

    public function param($key, $default = null){
        if(!isset($this->parameters[$key])){
            return $default;
        }
        return $this->parameters[$key];
    }
}