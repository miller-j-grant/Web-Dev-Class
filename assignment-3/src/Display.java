import javax.swing.*;
import java.awt.*;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Scanner;

/**
 * This class demonstrates a simple technique of laying out text "by hand"
 * <p/>
 * Also demonstrates how to change fonts and colors.
 * <p/>
 * Created by kurmasz on 12/17/14.
 */
public class Display extends JPanel {

	private static final int MARGIN = 10; // the margin around the edge of the window.
	private List<String> content;  // the text that is to be displayed.
	private Color defaultColor; // the default text color


	// This Map is what makes links:  Each Rectangle is a link --- an area on the screen that can be clicked.
	// The rectangle is the Key.  The Value, in this case, is the color that should be used when the link is clicked.
	// When building a "real" browser, the links are also areas on the screen, but the corresponding value is the URL
	// that should be loaded when the link is clicked.
	private Map<Rectangle, String> links = new HashMap<Rectangle, String>();


	/**
	 * Set the text that is to be displayed.
	 *
	 * @param text_in the text that is to be displayed
	 */
	public void setText(List<String> text_in) {
		content = text_in;
		defaultColor = Color.black;
	}

	/**
	 * Set the text color
	 *
	 * @param c the desired text color
	 */
	public void setColor(Color c) {
		defaultColor = c;
	}

	/**
	 * Actually "draws" the text on the window.
	 *
	 * @param g
	 */
	@Override
	public void paintComponent(Graphics g) {
		super.paintComponent(g);
		// If no file has been loaded yet, then do nothing.
		if (content == null) {
			return;
		}

		// The FontMetrics object can compute the size of text in the window.
		// You must get a new FontMetrics object every time you change or modify the font (e.g., use bold or italics).
		FontMetrics metrics = g.getFontMetrics();
		int line_height = metrics.getHeight();
		int panel_width = getWidth() - MARGIN * 2;

		int x = MARGIN;
		int y = line_height;

		// save the original font in case we change it.
		Font originalFont = g.getFont();

		int boldFlag = 0;
		int italicsFlag = 0;
		int linkFlag = 0;

		// Iterate over each line.
		for (String line : content) {
			Scanner words = new Scanner(line);

			// iterate over each word.
			while (words.hasNext()) {

				int style = Font.PLAIN;
				String nextWord = words.next();
				

				// A simple example of how to handle a *one-word* markup 
				// Remember, your assignment will use multi-word markup.
				if (nextWord.startsWith("*") && nextWord.length() > 1) {
					// remove the markup.
					nextWord = nextWord.substring(1);
					style = Font.BOLD;
					boldFlag = 1;
				}
				if(boldFlag==1){
					style = Font.BOLD;
				}
				if(nextWord.endsWith("*") && nextWord.length() > 1){
					// remove the markup.
					nextWord = nextWord.substring(0, nextWord.length() - 1);
					style = Font.BOLD;
					boldFlag = 0;
				}
				
				//Handles the italics markup.
				if(nextWord.startsWith("_") && nextWord.length() > 1){
					nextWord = nextWord.substring(1);
					style = Font.ITALIC;
					italicsFlag = 1;
				}
				if(italicsFlag==1){
					style = Font.ITALIC;
				}
				if(nextWord.endsWith("_") && nextWord.length() > 1){
					nextWord = nextWord.substring(0, nextWord.length() - 1);
					style = Font.ITALIC;
					italicsFlag = 0;
				}

				String wordAndSpace = nextWord + " ";
				int word_width = metrics.stringWidth(wordAndSpace);

				// If there isn't room for this word, go to the next line
				if (x + word_width > panel_width) {
					x = MARGIN;
					y += line_height;
				}

				// A simple example of how to handle links. A word of the form (#123456) will be
				// represented as a link that, when clicked on, will change the text color.
				Color color = getColor(nextWord);
				Rectangle rect = new Rectangle();
				
				if(wordAndSpace.startsWith("[[") && wordAndSpace.length() > 1){
//					g.setColor(color);
					wordAndSpace = wordAndSpace.substring(2);
//					rect = new Rectangle(x, y - line_height, word_width, line_height);
					rect.setBounds(x, y - line_height, word_width, line_height);
					links.put(rect, wordAndSpace.substring(0, wordAndSpace.length()-1));
					linkFlag=1;
				}
				if(linkFlag==1){
					g.setColor(color);
//					rect = new Rectangle(x, y - line_height, word_width, line_height);
					rect.setSize((int) (rect.getWidth() + word_width), line_height);
				}
				if((wordAndSpace.endsWith("]] ") || wordAndSpace.endsWith("]]")) && wordAndSpace.length() > 1){
//					g.setColor(color);
					wordAndSpace = wordAndSpace.substring(0, wordAndSpace.length() - 3);
//					rect = new Rectangle(x, y - line_height, word_width, line_height);
					rect.setSize(word_width, line_height);
					linkFlag = 0;
				}

				g.drawRect(rect.x, rect.y, rect.width, rect.height);
				
				// draw the word
				g.setFont(originalFont.deriveFont(style));
				g.drawString(wordAndSpace, x, y);


				x += word_width;

			} // end of the line

			// move to the next line
			x = MARGIN;
			y += line_height;
		} // end of all ines

		for (Map.Entry<Rectangle, String> entry : links.entrySet()) {
			System.out.println(entry.getValue());
		}
		
		// make this JPanel bigger if necessary.
		// Calling re-validate causes the scroll bars to adjust, if necessary.
		if (y > getHeight()) {
			setPreferredSize(new Dimension(x, y + line_height + 2 * MARGIN));
			revalidate();
		}
	}

	/**
	 * Determine if the {@code word} represents a color.
	 *
	 * @param word the next word to be displayed
	 * @return the {@code Color} represented by {@code word}, or {@code null} if {@code word} does not represent a color
	 */

	private static Color getColor(String word) {
		if (word.length() == 9 && word.startsWith("(#") && word.endsWith(")")) {
			return new Color(Integer.parseInt(word.substring(2, 8), 16));
		} else {
			return null;
		}
	}

	/**
	 * Return the color value of the color link at {@code point}, or
	 * return {@code null} if {@code point} doesn't point to a color link.
	 *
	 * @param point the {@code Point} that was clicked.
	 * @return the color value of the color link at {@code point}, or
	 * return {@code null} if {@code point} doesn't point to a color link.
	 */
	// 
//	public Color getColor(Point point) {
//		for (Map.Entry<Rectangle, String> entry : links.entrySet()) {
//			if (entry.getKey().contains(point)) {
//				return entry.getValue();
//			}
//		}
//		return null;
//	}
	
	// LOOK THROUGH THE LINK MAP CHECKING EACH RECTANGLE KEY USING .contains(Point p)
	// WHEN THE RECTANGLE THAT CONTAINS THAT POINT IS FOUND, SEND BACK THE ASSOCIATED LINK STRING.
	public String getLink(Point point){
		for (Map.Entry<Rectangle, String> entry : links.entrySet()) {
			if (entry.getKey().contains(point)) {
				return entry.getValue();
			}
		}
		return null;
	}
}