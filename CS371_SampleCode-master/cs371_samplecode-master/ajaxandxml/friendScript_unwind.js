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

function ajaxCallback() {
    if (ajax.readyState == 4) {
        console.log(ajax.responseText);
        updateFriend(ajax.responseXML);
    }
}


function clickHandler() {
    var full_id = this.getAttribute("id");
    var id = /^friend(\d+)$/.exec(full_id)[1];

    var ajax = new XMLHttpRequest();
    ajax.open("GET", "oneFriend.php?id=" + id);
    ajax.onreadystatechange = ajaxCallback();
    ajax.send();
}


window.onload = function () {
    var friends = document.getElementsByClassName("friendName");
    for (var i = 0; i < friends.length; i++) {
        friends[i].addEventListener("click", clickHandler);
    }
};