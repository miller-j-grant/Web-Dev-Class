<?php
// Start the session
session_start();

if(!isset($_SESSION['login'])){ //if login session variable is not set
    header("Location: loginPage.php");
}

unset($_SESSION['organization']);
?>

<!DOCTYPE html>
<?php require('dbHelper.php'); ?>
<html lang="en">
<head>
    <link rel="stylesheet" href="dbPageCSS.css" type="text/css"/>
    <script type="text/javascript">
        function validateForm() {
            var oName = document.forms["createForm"]["createName"].value;

            var message = "Success";
            var newItem = document.createElement("div");
            newItem.innerHTML = message;
            newItem.style.display = "inline-block";
            newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
            newItem.style.padding = "15px";
            
            if (oName === "") {
                message = "Please enter a name for the new organization.";
                newItem.innerHTML = message;
                newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
                document.getElementsByTagName("body")[0].appendChild(newItem);
                return false;
            }

            document.getElementsByTagName("body")[0].appendChild(newItem);
        }

        function sortFunction(column){
            var rows = document.getElementById("organizations").getElementsByTagName("tr");
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
    <h1>Organization DB Page</h1>

    <table id="organizations">
        <tr>
            <th><button onclick="sortFunction(0)">Organization Name</button></th>
            <th><button onclick="sortFunction(1)">Location Name</button></th>
            <th><button onclick="sortFunction(2)">Sector Name</button></th>
            <th><button onclick="sortFunction(3)">World Name</button></th>
            <th><button onclick="sortFunction(4)">Owner</button></th>
        </tr>

        <?php
        $c = connect();
        foreach (getAllFromTableWhereUsername($c, "organizations") as $row) {
            echo "<tr>";

            $keys = array("oName", "lName", "sName", "wName", "username");
            foreach ($keys as $key) {
                $string = str_replace(' ', '', $row[$key]);
                if($key === "oName") {
                    echo "<td><a href=organizationDescPage.php?organization=".$string.">" . $row[$key] . "</a></td>";
                }
                else if($key === "lName") {
                    echo "<td><a href=locationDescPage.php?location=".$string.">" . $row[$key] . "</a></td>";
                }
                else if($key === "sName") {
                    echo "<td><a href=sectorDescPage.php?sector=".$string.">" . $row[$key] . "</a></td>";
                }
                else if($key === "wName"){
                    echo "<td><a href=worldDescPage.php?world=".$string.">" . $row[$key] . "</a></td>";
                }
                else{
                    echo "<td>" . $row[$key] . "</td>";
                }
            }
            echo "</tr>\n";
        }
        $c->close();
        ?>
    </table>

    <br>

    <form name="createForm" action="dbUpdate.php" onsubmit="return validateForm()" method="post">
        <label for="createName">Create New Organization (DO NOT USE SPACES):</label><br>
        <input type="text" name="createName" id="createName">
        <input type="hidden" name="hidden" value="organization">
        <br><br>
        <input type="submit" value="Submit">
        <br><br>
    </form>

    <form action="loginLogout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>