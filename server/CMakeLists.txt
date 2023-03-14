cmake_minimum_required(VERSION 3.0)
project(tcp_perf_test_server)

set(CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -std=c++11")
set(CMAKE_MODULE_PATH "${CMAKE_SOURCE_DIR}/../cmake")

find_package(Threads REQUIRED)

## SOURCES  ####################################################################
set(SOURCE_FILES

tcp_perf_test_server.cpp

task.h
task.cpp

mutex.h
mutex.cpp

log.h
log.cpp

SynchronousSocket.cpp
SynchronousSocket.h
)
##################################################################################

link_libraries(stdc++ ${CMAKE_THREAD_LIBS_INIT})

add_executable(tcp_perf_test_server ${SOURCE_FILES} ./tcp_perf_test_server.cpp)

