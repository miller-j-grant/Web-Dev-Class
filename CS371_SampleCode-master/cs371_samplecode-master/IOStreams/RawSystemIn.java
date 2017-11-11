import java.io.IOException;

/**
 * Demonstrates the simplest use of an InputStream by reading one byte at a time from System.in and
 * printing that byte to the screen (both as an integer and as a character).
 *
 * Look at the the javadoc page for the System class (https://docs.oracle.com/javase/7/docs/api/java/lang/System.html):
 * Notice that "in" is the name of a public static variable in the System class.  When you launch a Java
 * program, The Java runtime creates an InputStream object attached to the standard input and assigns it to
 * the variable System.in.
 *
 * Created by kurmasz on 4/27/15.
 */
public class RawSystemIn {

  public static void main(String[] args) throws IOException, NoSuchFieldException, IllegalAccessException {

    int val;
    do {
      // Get a byte and print it out
      val = System.in.read();
      System.out.printf("Byte as int: %3d", val);

      // Covert the byte to a character and print it out.
      System.out.print(" Byte as char: ");
      char c = (char) val;
      System.out.println(c);
    } while (val != -1);
  }

}
