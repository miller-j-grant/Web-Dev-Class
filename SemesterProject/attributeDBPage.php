<?php
// Start the session
session_start();

if(!isset($_SESSION['login'])){ //if login session variable is not set
    header("Location: loginPage.php");
}
?>

<!DOCTYPE html>
<?php require('dbHelper.php'); ?>
<html lang="en">
<head>
    <link rel="stylesheet" href="dbPageCSS.css" type="text/css"/>
    <script type="text/javascript">
        function sortFunction(column){
            var rows = document.getElementById("worlds").getElementsByTagName("tr");
            var sortValues = [];

            for(var i = 1; i < rows.length; i++){
                var cells = rows[i].getElementsByTagName("td");
                sortValues[i] = cells[column].innerText;
            }

            var bool = true;
            var tempStr;

            while(bool){
                bool = false;
                for(var i = 1; i < sortValues.length-1; i++){
                    if(sortValues[i] > sortValues[i+1]){
                        tempStr = sortValues[i];
                        sortValues[i] = sortValues[i+1];
                        sortValues[i+1] = tempStr;

                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        bool = true;
                    }
                }
            }
        }
    </script>
    <title>Semester Project</title>
</head>

<body>
    <h1>Attributes DB Page</h1>

    <table id="attributes">
        <tr>
            <th><button onclick="sortFunction(0)">Character</button></th>
            <th><button onclick="sortFunction(1)">Strength</button></th>
            <th><button onclick="sortFunction(2)">Dexterity</button></th>
            <th><button onclick="sortFunction(3)">Constitution</button></th>
            <th><button onclick="sortFunction(4)">Intelligence</button></th>
            <th><button onclick="sortFunction(5)">Wisdom</button></th>
            <th><button onclick="sortFunction(6)">Charisma</button></th>
            <th><button onclick="sortFunction(7)">Owner</button></th>
        </tr>

        <?php
        $c = connect();
        foreach (getAllFromTableWhereUsername($c, "attributes") as $row) {
            echo "<tr>";

            $keys = array("cName", "strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma", "username");
            foreach ($keys as $key) {
                $string = str_replace(' ', '', $row[$key]);
                if($key === "cName") {
                    echo "<td><a href=pcDescPage.php?pc=".$string.">" . $row[$key] . "</a></td>";
                }else{
                    echo "<td>" . $row[$key] . "</td>";
                }
            }
            echo "</tr>\n";
        }
        $c->close();
        ?>
    </table>

    <br>

    <form action="loginLogout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>