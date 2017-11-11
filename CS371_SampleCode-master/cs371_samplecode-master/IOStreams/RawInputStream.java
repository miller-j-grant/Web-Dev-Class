import java.io.*;


/**
 * Demonstrates how to write a method that will work with input from any source (keyboard, file, etc.)
 * <p/>
 * Created by kurmasz on 4/27/15.
 */


public class RawInputStream {

  /**
   * Reads one byte at a time from an InputStream and prints it on the screen.
   * Notice that this method does not care about the source of the data.  The
   * source can be the keyboard, a File, a network connection, a String, or
   * anything else that can appear as a stream of bytes.
   *
   * @param in the {@code InputStream}
   */
  public static void displayRawInputStream(InputStream in) throws IOException {

    int val;
    do {
      // Get a byte and print it out
      val = in.read();
      System.out.printf("Byte as int: %3d", val);

      // Covert the byte to a character and print it out.
      System.out.print(" Byte as char: ");
      char c = (char) val;
      System.out.println(c);
    } while (val != -1);
  }


  public static void main(String[] args) throws IOException {
    // If there are no command-line parameters, then print from System.in,
    // else the first parameter is the name of the file.
    if (args.length == 0) {
      displayRawInputStream(System.in);
    } else {
      System.out.println("Reading data from " + args[0]);
      displayRawInputStream(new FileInputStream(args[0]));
    }
  }
}
