import java.net.*;
import java.io.*;

public class WebServer {
	
	public static void main(String[] args) throws IOException {
		
		final int DEFAULT_PORT = 8080; // For security reasons, only root can use ports < 1024.
	    int portNumber = args.length > 1 ? Integer.parseInt(args[0]) : DEFAULT_PORT;
	    
	    String response = 
	    "HTTP/1.1 200 OK\r\n"
        + "Content-Type: text/plain\r\n"
        + "Content-Length: 70\r\n"
        + "Connection: close\r\n"
        + "\r\n"
        + "This is not the real content because this server is not yet complete.\r\n";

	    try {
	        ServerSocket serverSocket = new ServerSocket(portNumber);
	        Socket clientSocket = serverSocket.accept();
	        PrintWriter out =
	            new PrintWriter(clientSocket.getOutputStream(), true);
	        BufferedReader in = new BufferedReader(
	            new InputStreamReader(clientSocket.getInputStream()));
	        
	        String inLine;
	        inLine = in.readLine();
	        while(inLine != null){
	        	System.out.println(inLine);
	        	inLine = in.readLine();
	        }
	        
	        out.println(response);
	        
	        serverSocket.close();
	     } catch (IOException e) {
	        System.err.println("Oops!  " + e);
	     }
	}
}
