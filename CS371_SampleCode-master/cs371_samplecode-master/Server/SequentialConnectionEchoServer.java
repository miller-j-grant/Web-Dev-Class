import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;

/**
 * A simple echo server to demonstrate how to set up a server.
 * <p/>
 * This server handles multiple connections sequentially: After the handleConnection() method finishes serving
 * one client, main() loops back around and listens for the next connection request. This program can handle only
 * one client at a time --- Only one client may be connected at a time; other requests are queued.
 * <p/>
 * Created by kurmasz on 5/4/15.
 */
public class SequentialConnectionEchoServer {

  public static void handleConnection(Socket socket) throws IOException {

    // Created a BufferedReader that can read from the socket
    BufferedReader input = new BufferedReader(new InputStreamReader(socket.getInputStream()));

    // Create a PrintStream than can write to the socket
    // Passing "true" as the second parameter causes each write to be followed by a flush.
    PrintStream output = new PrintStream(socket.getOutputStream(), true);


    // While there is input, read it in, and simply echo it back
    String line;
    line = input.readLine();
    while (line != null) {
      if (line.toLowerCase().trim().equals("bye")) {
        output.println("Good bye.\n");
        socket.close();
        break;
      }

      System.out.println("I heard: " + line);
      output.printf("You said: \"%s\"\n", line);
      line = input.readLine();
    }
  }


  public static void main(String[] args) throws IOException {

    // Create a socket that listens on port 8354.
    ServerSocket serverSocket = new ServerSocket(8354);

    // This time, when the connection ends, the server loops around and handles
    // the next connection in the queue.
    while (true) {
      handleConnection(serverSocket.accept());
    }
  }
}
