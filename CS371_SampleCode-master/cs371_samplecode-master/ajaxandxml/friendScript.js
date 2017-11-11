/**
 * Created by kurmasz on 3/11/15.
 */

function updateFriend(friend) {

    var name = friend.getElementsByTagName("name")[0];
    document.getElementById("friendName").innerHTML = name.firstChild.data;

    var phone = friend.getElementsByTagName("phone")[0];
    document.getElementById("friendPhone").innerHTML = phone.firstChild.data;

    var hobby = friend.getElementsByTagName("hobby")[0];
    if (hobby) {
        document.getElementById("friendHobby").innerHTML = hobby.firstChild.data;
    } else {
        document.getElementById("friendHobby").innerHTML = "";

    }

    var note = friend.getElementsByTagName("note")[0];
    if (note) {
        document.getElementById("friendNote").innerHTML = note.firstChild.data;
    } else {
        document.getElementById("friendNote").innerHTML = "";
    }
}


//
// Nested callbacks.
//
// This is how most professionals would write this code, with the functions 
// defined anonymously inline.
var denseOnload = function () {
    var friends = document.getElementsByClassName("friendName");
    for (var i = 0; i < friends.length; i++) {
        friends[i].addEventListener("click", function () {
            var full_id = this.getAttribute("id");
            var id = /^friend(\d+)$/.exec(full_id)[1];

            var ajax = new XMLHttpRequest();
            ajax.open("GET", "oneFriend.php?id=" + id);
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4) {
                    console.log(ajax.responseText);
                    updateFriend(ajax.responseXML);
                }
            };
            ajax.send();
        });
    }
};
//window.onload = denseOnload;


//
// Sparse onload
//
// To make this easier to understand, I've separated all the different functions.
//

var clickHandler = function () {

    // Called when the AJAX connection changes state
    var ajaxCallback = function () {
        // State 4 is when the request is effectively complete.  
        // (For this program, we don't care about the other states.)
        if (ajax.readyState == 4) {
            // Notice that we can ask for the response as either plain text, or XML
            console.log(ajax.responseText);

            //
            // Here is how to parse the XML "by hand"
            //
            /*
             var parser = new DOMParser();
             var xml = parser.parseFromString(ajax.responseText, "text/xml");
             console.log(xml);
             updateFriend(xml);
             */

            // But, in this case, it makes more sense to let the AJAX system do it for us.
            //updateFriend(ajax.responseXML);
            updateFriend(ajax.responseXML);
        }
    };

    // Each li element has a unique id on it of the form 
    // "friendXXX" where XXX is the unique id of the friend in the XML file.    
    // The regular expression below extracts the XXX from the string "friendXXX" 
    var full_id = this.getAttribute("id");
    var id = /^friend(\d+)$/.exec(full_id)[1];

    // XMLHttpRequest is the built-in JavaScript object that handles AJAX calls.
    var ajax = new XMLHttpRequest();

    // Prepare a GET request to the page "oneFriend.php".  
    // Notice that this GET request also has a query string containing the id of the desired friend.
    ajax.open("GET", "oneFriend.php?id=" + id);

    // Specify which function to call whenever something happens 
    // (i.e., when the request moves from one stage to the next.)
    ajax.onreadystatechange = ajaxCallback;

    // execute the request.
    ajax.send();
};

var sparseOnload = function () {

    // each li element has the class "friendName" on it.
    var friends = document.getElementsByClassName("friendName");
    for (var i = 0; i < friends.length; i++) {
        friends[i].addEventListener("click", clickHandler);
    }
};

window.onload = sparseOnload;





