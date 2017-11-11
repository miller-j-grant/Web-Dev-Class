import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;
import java.io.BufferedReader;
import java.io.DataInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;


public class WebTransactionClient {


	private PrintWriter out;
	private DataInputStream in;
	private Socket socket;
	private String response = "";   // The entire response string (e.g., "HTTP/1.1 200 Ok")
	private HashMap<String, String> headers = new HashMap<String, String>();


	public WebTransactionClient(MyURL url) throws IOException {

		//TODO:  Create the sockets and get the data streams.  Then read and store the response and response headers.
		// The code here will be similar to the code from BasicWebTransaction; however,
		// wrap the socket's InputStream in a DataInputStream.  (The DataInputStream will allow you to 
		// read both text data and binary data from the InputStream.  You'll get "deprecated" warnings 
		// when using the readLine() method.  Ignore them.)
		
		socket = new Socket(url.domainName(), url.port());
		out = new PrintWriter(socket.getOutputStream(), true);
		in = new DataInputStream(socket.getInputStream());
		
		out.println("GET " + url.path() + " HTTP/1.1\r\n" + "Host: " + url.domainName() + "\r\n");
		String inLine;
		int k = 0;
        inLine = in.readLine();
        while(!inLine.isEmpty()){
        	response = response + inLine + "\n";
        	inLine = in.readLine();
        	k++;
        }
        
        response = response.substring(response.indexOf(0)+1, response.lastIndexOf("\n"));
		
		// This function should read the response headers and store them in the headers Map. Stop before
		// reading the content.

        String temp = response;
        ArrayList<String> splitArray = new ArrayList<String>();

        temp = temp.substring(temp.indexOf("\n")+1);

        String []splitLine = temp.split(": |\\\n",k*2);
        
        for(int y = 0; y < splitLine.length; y++){
        	splitArray.add(splitLine[y]);
        }

        for(int i = 0; i < splitArray.size(); i=i+2){
        	headers.put(splitArray.get(i).toLowerCase(), splitArray.get(i+1).toLowerCase());
        }

		// When storing the headers, convert the key to *lower case*

		// For context:  My solution is about 30 lines of Java code.

		// The following String methods may be helpful:  split, trim, and toLowerCase

	}

	public String getText() throws IOException {

		StringBuffer result = new StringBuffer();

		// TODO: Read the rest of the data from the InputStream as text and return it as a single string.
		// (In this case, using a StringBuffer is more efficient that concatenating String objects.)
		
		String inLine;
        inLine = in.readLine();
        result.append(inLine + "\n");
        while(in.available() > 0){
        	//System.out.println(inLine);
        	inLine = in.readLine();
        	result.append(inLine + "\n");
        }
		
        //System.out.println(result);
        
		return result.toString();
	} // end getText

	public BufferedImage getImage() throws IOException {

		// This function is complete.  The ImageIO class can build an Image object directly from the InputStream.
		// This is why it was important to use a DataInputStream:  The ImageIO class will read binary data from the stream.
		// Had you used BufferedReader or something similar when reading the headers, then it is possible some of the 
		// necessary binary data would have been incorrectly loaded into the buffer.

		return ImageIO.read(in);
	}


	public String response() {
		return response;
	}

	public int responseCode() {

		// TODO: retrieve the response code (e.g., 200) from the response string and return it as an integer.
		String temp = response.substring(response.indexOf("HTTP"),response.indexOf("\n"));
		//System.out.println("LINE 108 TEST: " + temp);
		temp = temp.substring(temp.indexOf(0)+10, temp.indexOf(0)+13);
		//System.out.println("LINE 108 TEST: " + temp);
		return Integer.parseInt(temp);
	}

	public Map<String, String> responseHeaders() {
		// This method is complete.
		return headers;
	}

	public String getHeader(String key) {
		// This method is complete.
		// I convert the key to lower case to avoid problems caused when different web servers use different capitalization.
		return headers.get(key.toLowerCase());
	}


	@Override
	protected void finalize() throws Throwable {
		// This method is complete.
		super.finalize();
		in.close();
		out.close();
		socket.close();
	}
} // end WebTransactionClient