cmake_minimum_required(VERSION 3.20)
project(HTTPServer CXX)

set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)
set(CMAKE_EXPORT_COMPILE_COMMANDS ON)

# Catch mistakes early: warnings on, plus AddressSanitizer + UBSan in Debug
add_compile_options(-Wall -Wextra -Wpedantic)
if(CMAKE_BUILD_TYPE STREQUAL "Debug" OR NOT CMAKE_BUILD_TYPE)
  add_compile_options(-g -fsanitize=address,undefined)
  add_link_options(-fsanitize=address,undefined)
endif()

add_executable(server src/main.cpp)
