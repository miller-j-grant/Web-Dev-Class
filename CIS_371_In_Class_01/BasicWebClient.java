import java.io.*;
import java.net.*;

public class BasicWebClient {

	public static void main(String[] args) throws IOException {
		
		String host = "www.cis.gvsu.edu";
		int port = 80;
		
		String file0 = "/~kurmasz/Humor/stupid.html";
		String file1 = "/~kurmasz/Distiller/HowTo.txt";
		String file2 = "/~kurmasz/NoSuchFile.html";
		String file3 = "/~kurmasz/buzz1.jpg";
		
		String line = null;
		
		//Create socket for connection, writer and reader for data transfer.
		Socket socket = new Socket(host, port);
		PrintWriter output = new PrintWriter(socket.getOutputStream(), true);
		BufferedReader input = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		
		File file = new File("E://Homework/CIS 371/InClass1/fileOutput.txt");
		FileOutputStream fout = new FileOutputStream(file);
		OutputStreamWriter fileWriter = new OutputStreamWriter(fout);
		if(!file.exists()){
			file.createNewFile();
		}
		
		//Send HTTP request.
		output.println("GET " + file0 + " HTTP/1.1\r\n" + "Host: " + host + "\r\n");
		output.flush();
		line = input.readLine();
		while(line != null){
			fileWriter.write(line);
			System.out.println("server: " + line);
			line = input.readLine();
		}
		
		System.out.println("\n");
		
		//Close socket when done.
		socket.close();
		
		//Start again for second file.
		socket = new Socket(host, port);
		output = new PrintWriter(socket.getOutputStream(), true);
		input = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		
		output.println("GET " + file1 + " HTTP/1.1\r\n" + "Host: " + host + "\r\n");
		output.flush();
		line = input.readLine();
		while(line != null){
			fileWriter.write(line);
			System.out.println("server: " + line);
			line = input.readLine();
		}
		
		System.out.println("\n");
		
		socket.close();
		
		//Third file.
		socket = new Socket(host, port);
		output = new PrintWriter(socket.getOutputStream(), true);
		input = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		
		output.println("GET " + file2 + " HTTP/1.1\r\n" + "Host: " + host + "\r\n");
		output.flush();
		line = input.readLine();
		while(line != null){
			fileWriter.write(line);
			System.out.println("server: " + line);
			line = input.readLine();
		}
		
		System.out.println("\n");
		
		socket.close();
		
		//Fourth file.
		socket = new Socket(host, port);
		output = new PrintWriter(socket.getOutputStream(), true);
		input = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		
		output.println("GET " + file3 + " HTTP/1.1\r\n" + "Host: " + host + "\r\n");
		output.flush();
		line = input.readLine();
		while(line != null){
			fileWriter.write(line);
			System.out.println("server: " + line);
			line = input.readLine();
		}
		
		socket.close();
		output.close();
		input.close();
		fileWriter.close();
		fout.close();
	}

}
