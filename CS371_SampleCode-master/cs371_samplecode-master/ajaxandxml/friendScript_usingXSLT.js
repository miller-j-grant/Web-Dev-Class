/**
 * This is similar to friendScript.js, except that it posts to oneFriend_usingXSLT.php.  This php script
 * returns html instead of XML.   Notice how this greatly simplifies the updateFriend method.
 *
 * Created by kurmasz on 3/11/15.
 */

function updateFriend(friend) {
    document.getElementById("friendDetails").innerHTML = friend.firstChild.innerHTML;
}


window.onload = function () {
    var friends = document.getElementsByClassName("friendName");
    for (var i = 0; i < friends.length; i++) {
        friends[i].addEventListener("click", function () {
            var full_id = this.getAttribute("id");
            var id = /^friend(\d+)$/.exec(full_id)[1];

            var ajax = new XMLHttpRequest();
            ajax.open("GET", "oneFriend_usingXSLT.php?id=" + id);
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