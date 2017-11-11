/**
 * Created by G-Man on 6/3/2017.
 */
function sortProfTable() {
    var rows = document.getElementById("profs").getElementsByTagName("tr");
    var lastnames = [];

    for(var i = 1; i < rows.length; i++){
        var subStr = rows[i].innerHTML.substring
            (rows[i].innerHTML.indexOf("</td>")+5, rows[i].innerHTML.length);
        subStr = subStr.substring(subStr.indexOf("<td>")+4, subStr.indexOf("</td>"));
        lastnames[i] = subStr;
    }

    var bool = true;
    var tempStr;
    var tempRow;

    while(bool){
        bool = false;
        for(var i = 1; i < lastnames.length-1; i++){
            if(lastnames[i] > lastnames[i+1]){
                tempStr = lastnames[i];
                lastnames[i] = lastnames[i+1];
                lastnames[i+1] = tempStr;

                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                bool = true;
            }
        }
    }

    console.log(rows);
    console.log(lastnames);
}