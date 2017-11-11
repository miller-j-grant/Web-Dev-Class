import java.util.Map;

/**
 * Created by kurmasz on 5/12/15.
 */
public class PrintEnvironment {

    public static void main(String[] args) {
        Map<String, String> env = System.getenv();
        for (String envName : env.keySet()) {
            System.out.format("%s=%s%n",
                    envName,
                    env.get(envName));
        }



       if (env.containsKey("myName")) {
           System.out.println("\n\n\n");
           System.out.printf("Hello, %s.  Have a nice day.\n", env.get("myName"));
       }
    }
}
