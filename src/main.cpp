// Phase 0: a minimal server that answers curl with a valid HTTP response.
//
// Your job, in order (man 2 <name> for each):
//   1. socket()      - create a TCP socket (AF_INET, SOCK_STREAM)
//   2. setsockopt()  - SO_REUSEADDR, so restarts don't fail with "address in use"
//   3. bind()        - attach it to 127.0.0.1:8080
//   4. listen()      - ONCE, before the loop
//   5. loop: accept() -> read() -> write() a response -> close()
//
// Every call can fail. Check each return value (-1 means error, see errno).

#include <iostream>

int main() {
    std::cout << "TODO: write the server\n";
    return 0;
}
