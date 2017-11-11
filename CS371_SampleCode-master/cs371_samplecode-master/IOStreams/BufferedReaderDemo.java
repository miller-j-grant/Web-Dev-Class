import java.io.*;

/**
 * Demonstrates how to wrap an InputStream with a BufferedReader.
 *
 * Created by kurmasz on 4/27/15.
 */
public class BufferedReaderDemo {

  public static void main(String[] args) throws IOException {

    ///////////////////////////////////////////////////////////////////////////////////////
    //
    // Step 1: Choose the source of the data.
    //
    ///////////////////////////////////////////////////////////////////////////////////////

    InputStream istream;
    // If there are no command-line parameters, then print from System.in, 
    // else the first parameter is the name of the file.
    if (args.length == 0) {
      System.out.println("Reading data from the standard input");
      istream = System.in;
    } else {
      System.out.println("Reading data from " + args[0]);
      istream = new FileInputStream(args[0]);
    }


    ///////////////////////////////////////////////////////////////////////////////////////
    //
    // Step 2: "Wrap" the InputStream in an InputStreamReader and BufferedReader 
    //
    ///////////////////////////////////////////////////////////////////////////////////////


    // Create an InputStreamReader object.  This object will correctly
    // convert the bytes from the underlying InputStream into characters.
    InputStreamReader reader = new InputStreamReader(istream);

    // Create a BufferedReader.  This object will read characters from the underlying 
    // reader and group them into lines.  The BufferedReader object provides
    // the getLine() method that a "raw" Reader object does not.
    BufferedReader input = new BufferedReader(reader);

    ///////////////////////////////////////////////////////////////////////////////////////
    //
    // Step 3: Use the BufferedReader to read the text one line at a time.
    //
    ///////////////////////////////////////////////////////////////////////////////////////

    //
    // Count and display the data one line at a time.
    //

    int i = 1;
    String nextLine = input.readLine();
    while (nextLine != null) {
      System.out.printf("%5d: %s\n", i, nextLine);
      i++;
      nextLine = input.readLine();
    }
  } // end main


  /**
   * Demonstrates some short-cuts for creating {@code BufferedReader}s.
   * @param filename
   * @throws FileNotFoundException
   */
  @SuppressWarnings("unused")
  public static void shortCuts(String filename) throws FileNotFoundException {
    
    BufferedReader stdin = new BufferedReader(new InputStreamReader(System.in));
    
    BufferedReader file_in1 = new BufferedReader(new InputStreamReader(new FileInputStream(filename)));
    BufferedReader file_in2 = new BufferedReader(new FileReader(filename));
  }
  
} // end class
