<?php namespace HTTPServer;

use Exception;

class Server {
    protected $host = null;
    protected $port = null;
    protected $socket = null;

    /**
     * @param null $host
     * @param null $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = (int) $port;

        //Create a socket
        $this->createSocket();

        //Bind the socket
        $this->bindSocket();
    }


    protected function createSocket() {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
    }

    /**
     * @throws Exception
     */
    protected function bindSocket() {
        if (!socket_bind($this->socket, $this->host, $this->port)) {
            throw new Exception('Could not bind: ' .$this->host.':'.$this->port.' - '.socket_strerror(socket_last_error()));
        }
    }

    /**
     * @throws Exception
     */
    public function listen($callback) {
        //Check if the callback is valid. If not, throw an exception
        if(!is_callable($callback)){
            throw new Exception('This given argument should be callable.');
        }

        while(1){
            socket_listen($this->socket); //Listen for connections

            if (!$client = socket_accept($this->socket)){
                socket_close($client);
                continue;
            }

            //Create a new request instance with the clients header
            $request = Request::withHeaderString(socket_read($client, 1024));

            //execute the callback
            $response = call_user_func($callback, $request);

            //If a response object wasn't received, return a 404 response object
            if (!$response || !$response instanceof Response ){
                $response = Response::error(404);
            }

            //Convert the response to a string
            $response = (string) $response;

            //Write the response to the clients socket
            socket_write($client, $response, strlen($response));

            //Close the connection so we can accept new ones
            socket_close($client);        
        }
    }
}