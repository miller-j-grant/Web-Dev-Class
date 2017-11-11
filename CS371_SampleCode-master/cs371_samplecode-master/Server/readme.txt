The files in this directory demonstrate how to write a Java program
that responds to incoming network requests.  All programs are "echo
servers", which means that they simply take all data from the input
and repeat it on the output.

SingleConnectionEchoServer.java:
  Handles exactly one incoming connection, then terminates

SequentialConnectionEchoServer.java:
  Handles connections in series.  After one connection ends, main()
  loops around and listens for the next connection.  Notice that, at
  any one time, only one client may be connected.

ParallelConnectionEchoServer.java:
  Handles multiple connections in parallel.  When a connection request
  comes in, the program launches a new thread to handle that
  connection.
