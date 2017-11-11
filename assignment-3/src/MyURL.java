public class MyURL {
	
	private String scheme = "http";
	private String domainName = null;
	private int port = 80;
	private String path = "/";
	private String stURL = null;

	/**
	 * Split {@code url} into the various components of a URL
	 *
	 * @param url the {@code String} to parse
	 */
	public MyURL(String url){

		// TODO:  Split the url into scheme, domainName, port, and path.
		// Only the domainName is required.  Default values given above.
		// See the test file for examples of correct and incorrect behavior.
		// Hints:  (1) My implementation is mostly calls to String.indexOf and String.substring.
		// (2) indexOf can take a String as a parameter (it need not be a single character).
		
		this.stURL = url;
		String temp = url;
		
		if(temp.equals("")){
			throw new RuntimeException();
		}
		
		//scheme parse
		if(temp.contains("://")){
			this.scheme = temp.substring(temp.indexOf(0)+1, temp.indexOf("://"));
			temp = temp.substring(temp.indexOf("://") + 3);
		} else{
			this.scheme = "http";
		}
		
		//path parse
		if(temp.contains("/")){
			this.path = temp.substring(temp.indexOf("/"), temp.length());
			temp = temp.substring(temp.indexOf(0)+1, temp.indexOf("/"));
		} else{
			this.path = "/";
		}
		
		//port parse
		if(temp.contains(":")){
			String portTemp = temp.substring(temp.indexOf(":") + 1, temp.length());
			this.port = Integer.parseInt(portTemp);
			temp = temp.substring(temp.indexOf(0)+1, temp.indexOf(":"));
		} else{
			this.port = 80;
		}
		
		this.domainName = temp;
		
		if(this.domainName.equals("")){
			throw new RuntimeException();
		}
	}

	/**
	 * If {@code newURL} has a scheme (e.g., begins with "http://", "ftp://", etc), then parse {@code newURL} 
	 * and ignore {@code currentURL}.  If {@code newURL} does not have a scheme, then assume it is intended 
	 * to be a relative link and replace the file component of {@code currentURL}'s path with {@code newURL}.
	 *
	 * @param newURL     a {@code String} representing the new URL.
	 * @param currentURL the current URL
	 */
	public MyURL(String newURL, MyURL currentURL) {

		// TODO: If newURL has a scheme, then take the same action as the other constructor.
		// If newURL does not have a scheme
		// (1) Make a copy of currentURL
		// (2) Replace the filename (i.e., the last segment of the path) with the relative link.
		// See the test file for examples of correct and incorrect behavior.
		// Hint:  Consider using String.lastIndexOf
		
		this.stURL = newURL;
		String newTemp = newURL;
		
		//scheme parse
		if(newTemp.contains("://")){
			this.scheme = newTemp.substring(newTemp.indexOf(0)+1, newTemp.indexOf("://"));
			newTemp = newTemp.substring(newTemp.indexOf("://") + 3);
			
			//path parse
			if(newTemp.contains("/")){
				this.path = newTemp.substring(newTemp.indexOf("/"), newTemp.length());
				newTemp = newTemp.substring(newTemp.indexOf(0)+1, newTemp.indexOf("/"));
			} else{
				this.path = "/";
			}
			
			//port parse
			if(newTemp.contains(":")){
				String portTemp = newTemp.substring(newTemp.indexOf(":") + 1, newTemp.length());
				this.port = Integer.parseInt(portTemp);
				newTemp = newTemp.substring(newTemp.indexOf(0)+1, newTemp.indexOf(":"));
			} else{
				this.port = 80;
			}
			
			this.domainName = newTemp;
			
			if(this.domainName.equals("")){
				throw new RuntimeException();
			}
		} else{
			this.domainName = currentURL.domainName();
			this.port = currentURL.port();
			this.scheme = currentURL.scheme();
			this.path = currentURL.path();
			
			this.path = this.path.substring(this.path.indexOf(0)+1, this.path.lastIndexOf("/"));
			this.path = this.path + "/" + newTemp;
		}
	}


	public String scheme() {
		return scheme;
	}

	public String domainName() {
		return domainName;
	}

	public int port() {
		return port;
	}

	public String path() {
		return path;
	}

	/**
	 * Format this URL as a {@code String}
	 *
	 * @return this URL formatted as a string.
	 */
	public String toString() {
		// TODO:  Format this URL as a string
		return String.format(this.stURL);
	}

	// Needed in order to use MyURL as a key to a HashMap
	@Override
	public int hashCode() {
		return toString().hashCode();
	}

	// Needed in order to use MyURL as a key to a HashMap
	@Override
	public boolean equals(Object other) {
		if (other instanceof MyURL) {
			MyURL otherURL = (MyURL) other;
			return this.scheme.equals(otherURL.scheme) &&
					this.domainName.equals(otherURL.domainName) &&
					this.port == otherURL.port() &&
					this.path.equals(otherURL.path);
		} else {
			return false;
		}
	}
}
