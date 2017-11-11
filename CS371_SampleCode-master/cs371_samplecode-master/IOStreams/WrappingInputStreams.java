import java.io.*;

/**
 * Created by kurmasz on 4/28/16.
 */
public class WrappingInputStreams {


  /**
   * Wrap an InputStream inside a BufferedInputStream for performance, then wrap that
   * BufferedInputStream in an DataInputStream.
   *
   * @param in the raw InputStream
   * @return an DataInputStream
   * @throws IOException
   */
  public static DataInputStream wrapItUp(InputStream in) throws IOException {
    BufferedInputStream bis = new BufferedInputStream(in);
    DataInputStream dis = new DataInputStream(bis);
    return dis;
  }

  /**
   * Use an DataInputStream to read an entire line at once.
   * @param in the InputStream
   * @throws IOException
   */
  public static void displayWithLineNumbers(InputStream in) throws IOException {
    DataInputStream dis = wrapItUp(in);

    String line;
    int lineNumber = 1;
    // Notice that the call to dis.readLine() is deprecated.  See the readme.txt for an explanation.
    while ((line = dis.readLine()) != null) {
      System.out.printf("%3d %s\n", lineNumber, line);
      lineNumber++;
    }
  }


  public static void main(String[] args) throws IOException {
    // If there are no command-line parameters, then print from System.in,
    // else the first parameter is the name of the file.
    if (args.length == 0) {
      displayWithLineNumbers(System.in);
    } else {
      System.out.println("Reading data from " + args[0]);
      displayWithLineNumbers(new FileInputStream(args[0]));
    }
  }


}
