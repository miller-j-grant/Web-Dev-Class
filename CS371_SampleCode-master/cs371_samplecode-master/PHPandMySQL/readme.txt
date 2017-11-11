These programs demonstrate how to use PHP to access a database.

displayProfs.php:
  * Demonstrates the basics of connecting to a database and
    displaying the contents of each row in the table.
  * Web page also contains an overview of using mysqli functions.

displayProfs2.php:
  * Demonstrates how to move database code to a helper file
    (see dbHelper.php).
  * Demonstrates how to update a database.  (See profsSubmit.php.)

dbHelper.php:
  Contains the database code for displayProfs2.php.

updateProfs.php:
  Responds to displayProfs2.php's form submission.