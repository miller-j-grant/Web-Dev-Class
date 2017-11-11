Java uses the idea of "streams" to abstract the sending and receiving
of data.  An InputStream represents a data source (keyboard, file,
network connection, etc.) from which a program can read data; and
OutputStream represents a destination to which a program can send data
(a text terminal, a File, another program, etc.)

In Java, InputStream (https://docs.oracle.com/javase/7/docs/api/java/io/InputStream.html)
is an abstract class that provides all the methods needed for a
program to interact with a data source.  In particular, it provides
methods that can retrieve one or more bytes from the data source.
Similarly, OutputStream (https://docs.oracle.com/javase/7/docs/api/java/io/OutputStream.html)
is an abstract class that provides all the methods needed for a
program to interact with a data sink (i.e., destination).  In
particular, it provides method that can send one or more bytes of data
to the destination.  The rest of this document will focus on input. In
each case, output will have an analogous class.


****************************************************************
*
* RawSystemIn.java:  Interacting with an InputStream object
*
****************************************************************

RawSystemIn.java demonstrates how to read one byte of data at a time
from System.in.  System.in is the name of an InputStream whose data
source is the program's standard input (typically the keyboard). You
have probably used System.in many times without really thinking about
what it is.  Look at the the javadoc page for the System class
(https://docs.oracle.com/javase/7/docs/api/java/lang/System.html):
Notice that "in" is the name of a public static variable in the System
class.  When you launch a Java program, The Java runtime creates an
InputStream object attached to the standard input and assigns it to
the variable System.in.


****************************************************************
*
* RawInputStream.java: Coding to an interface
*
****************************************************************

If you look at the documentation you will see that InputStream is an
abstract class .  This means that InputStream's primary role is to
provide a common interface to all data sources.  The objects that
actually interact with the data sources are subclasses such as
FileInputStream, ByteArrayInputStream, and PipedInputStream.  Because
they are subclasses, these objects have the same interface as
InputStream --- every method that can be called on an InputStream
object can also be called on its subclasses.  This means that code
written using InputStream methods will also work given any object that
is a subclass of InputStream.

RawInputStream.java demonstrates how to write code that works with any
data source.  Notice that the method displayRawInputStream takes an
InputStream object as input.  Because subclasses provide the same
interface, the parameter can also be any subclass of InputStream.
Notice how main passes System.in as a parameter in one case and a
FileInputStream object in the other case.

*****************************************************************
*
* WrappingInputStreams.java: Providing additional functionality
*
*****************************************************************

The "plain" InputStream interface has some limitations.  First, it can
only retrieve bytes.  It doesn't provide any convenient methods for
retrieving data as an int, double, or String.  Subclasses like
DataInputStream (https://docs.oracle.com/javase/7/docs/api/java/io/DataInputStream.html)
address this limitation by providing additional methods like
readInt(), and readDouble().  Classes like DataInputStream provide
these methods by "wrapping" another InputStream.  When you call
readInt(), DataInputStream calls the read() method on the "wrapped"
InputStream object, asks for 4 bytes, then assembles those bytes into
an integer.  By designing the class as a wrapper, it can be applied to
any InputStream, regardless of the data source.

Another limitation of the "plain" InputStream is that it can be
inefficient: It will request just one byte at a time from the data
source.  In many cases, it is much more efficient to read many bytes
at once.  The BufferedInputStream
(https://docs.oracle.com/javase/7/docs/api/java/io/BufferedInputStream.html)
reads many bytes at once and store them in an internal buffer to
reduce the number of read() calls to the "wrapped" input stream.

WrappingInputStreams.java demonstrates how to wrap an InputStream
object in several layers to get the benefit of multiple classes.
Notice how the underlying InputStream is first wrapped in a
BufferedInputStream to improve performance, then wrapped in a
DataInputStream to provide the additional read...() methods.


*****************************************************************
*
* BufferedReaderDemo.java: Handling text correctly
*
*****************************************************************

If you look carefully (either in your IDE or at the output of javac),
you will notice that the method DataInputStream.readLine() is
deprecated.  This is because early versions of Java made the incorrect
simplifying assumption that all characters are one byte long.  This
was true in the early days of computing when we only encoded letters
in the Roman alphabet.  As computer programs began using more
characters (e.g., Chinese), 8 bits was no longer enough to encode all
characters. Java characters are 16 bits. InputStreams naively assume
that every 8-bits of input corresponds to exactly one character.  This
assumption holds for documents encoded in ASCII, and also for those
UTF-8 documents that use only letters in the Roman alphabet; but it
doesn't work for documents that use those characters that are encoded
using more than 8-bits.

To address this limitation, Java provides a parallel set of classes
called Readers (https://docs.oracle.com/javase/7/docs/api/java/io/Reader.html).
Readers have a similar set of methods to InputStreams.  The primary
difference is that the read() methods retrieve characters, not bytes.
More importantly, they consume the correct number of bytes for any
given character.

Most InputStream classes have a corresponding Reader class:
FileInputStream -> FileReader,
BufferedInputStream -> BufferedReader
ByteArrayInputStream -> CharacterArrayReader
StringBufferInputStream -> StringReader

You can "convert" an InputStream to a Reader by wrapping it in an
InputStreamReader.

BufferedReaderDemo.txt demonstrates the correct way to read lines of
text from an InputStream.  First, "convert" the InputStream to a
Reader by using an InputStreamReader.  Then wrap the InputStreamReader
with a BufferedReader.  The BufferedReader class provides a readLine()
method that returns an entire line of text.
