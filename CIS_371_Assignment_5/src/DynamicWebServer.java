import java.net.*;
import java.io.*;

public class DynamicWebServer {

	public static void main(String[] args) throws IOException {

		final int DEFAULT_PORT = 8080; // For security reasons, only root can use ports < 1024.
		int portNumber = args.length > 1 ? Integer.parseInt(args[0]) : DEFAULT_PORT;
		String prefix = "C://Users/CrispyToast/Dropbox/Assignment-5/src/";


		//Create Server Socket, Accept Connection, Set Up Input and Output
		ServerSocket serverSocket = new ServerSocket(portNumber);
		Socket clientSocket = serverSocket.accept();
		PrintStream out =
				new PrintStream(clientSocket.getOutputStream(), true);
		BufferedReader in = new BufferedReader(
				new InputStreamReader(clientSocket.getInputStream()));

		//Read GET line and and all the request headers
		String inLine;
		inLine = in.readLine();
		String lineGET = inLine;
		while(inLine.isEmpty()){
			//System.out.println(inLine);
			inLine = in.readLine();
		}

		//Parse the GET line (e.g. using String.split)
		String []splitLine = lineGET.split(" ",3);
		String action = splitLine[0];
		String path = splitLine[1].substring(splitLine[1].indexOf("/")+1);
		String version = splitLine[2];
		
		String []splitPath = path.split("\\.",2);
		String fRequested = splitPath[0];
		
		String []splitQuery = splitPath[1].split("\\?", 2);
		String fileType = splitQuery[0];
		String query = splitQuery[1];

		System.out.println("Action: " + action +
				"\nPath: " + path +
				"\nVersion: " + version +
				"\nRequested " + fRequested +
				"\nfileType " + fileType + 
				"\nQuery " + query);

		//Open the requested file.
		File file = new File(prefix + fRequested + "." + fileType);

		//Check to see if file really exists.
		if (!file.exists()) {
			out.println("HTTP/1.1 404 NOT FOUND");
			out.println("");
			serverSocket.close();
		}

		//Print the required response headers (content-type and content-length)
		String contentType = null;
		if(fileType.equals("txt") || fileType.equals("html")){
			contentType = "text/html";
		}
		if(fileType.equals("jpg")){
			contentType = "image/x-citrix-jpeg";
		}
		if(fileType.equals("gif")){
			contentType = "image/gif";
		}
		
		//If a the requested file is a ruby file, send info to Ruby.java for execution.
		//Receive a string output back.
		if(fileType.equals("rb")){
			System.out.println("DOING RUBY");
			
			contentType = "text/html";
			
			String rubyString = null;
			rubyString = Ruby.runRuby(prefix + fRequested + "." + fileType, query);
			
			String response = "HTTP/1.1 200 OK\n" 
					+ "Content-Type: " + contentType + "\n"
					+ "Content-Length: " + rubyString.length() + "\n"
					+ "Connection: close\n";
			out.println(response);
			
			out.println(rubyString);
		}else{
			String response = "HTTP/1.1 200 OK\n" 
					+ "Content-Type: " + contentType + "\n"
					+ "Content-Length: " + file.length() + "\n"
					+ "Connection: close\n";
			out.println(response);

			//Use a loop to read a block of data from the file then ---> write the data to the socket.
			FileInputStream fInStream = new FileInputStream(file);
			int k;
			while((k = fInStream.read()) != -1){
				out.write(k);
			}
			
			fInStream.close();
		}

		//Close streams and sockets.
		out.close();
		in.close();
		serverSocket.close();
	}
}
