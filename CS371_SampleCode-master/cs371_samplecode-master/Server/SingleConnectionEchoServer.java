import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;

/**
 * A simple echo server to demonstrate how to set up a server.
 * This server handles one connection then terminates.
 * Created by kurmasz on 5/4/15.
 */
public class SingleConnectionEchoServer {

  public static void main(String[] args) throws IOException {

    // Create a socket that listens on port 8354.
    ServerSocket serverSocket = new ServerSocket(8354);

    // Return a Socket object for the next connection in the queue 
    Socket socket = serverSocket.accept();

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

    // When the connection ends, so does this program.
  }
}
