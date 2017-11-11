/**
 * Created by CrispyToast on 6/8/2017.
 */
function updateEvent(event) {

    var title = event.getElementsByTagName("title")[0];
    document.getElementById("eventTitle").innerHTML = title.firstChild.data;

    var date = event.getElementsByTagName("date")[0];
    document.getElementById("eventDate").innerHTML = date.getAttribute("month") + "/" + date.getAttribute("day") + "/" + date.getAttribute("year");

    var start = event.getElementsByTagName("start")[0];
    document.getElementById("eventStart").innerHTML = start.firstChild.data;

    var stop = event.getElementsByTagName("stop")[0];
    document.getElementById("eventStop").innerHTML = stop.firstChild.data;

    var desc = event.getElementsByTagName("description")[0];
    if (desc) {
        document.getElementById("eventDescription").innerHTML = desc.firstChild.data;
    } else {
        document.getElementById("eventDescription").innerHTML = "";

    }
}

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
            updateEvent(ajax.responseXML);
        }
    };

    // Each li element has a unique id on it of the form
    // "friendXXX" where XXX is the unique id of the friend in the XML file.
    // The regular expression below extracts the XXX from the string "friendXXX"
    var full_id = this.getAttribute("id");
    var id = /^event(\d+)$/.exec(full_id)[1];

    // XMLHttpRequest is the built-in JavaScript object that handles AJAX calls.
    var ajax = new XMLHttpRequest();

    // Prepare a GET request to the page "oneFriend.php".
    // Notice that this GET request also has a query string containing the id of the desired friend.
    ajax.open("GET", "oneEvent.php?id=" + id);

    // Specify which function to call whenever something happens
    // (i.e., when the request moves from one stage to the next.)
    ajax.onreadystatechange = ajaxCallback;

    // execute the request.
    ajax.send();
};

var sparseOnload = function () {

    // each li element has the class "friendName" on it.
    var events = document.getElementsByClassName("eventTitle");
    for (var i = 0; i < events.length; i++) {
        events[i].addEventListener("click", clickHandler);
    }
};

window.onload = sparseOnload;