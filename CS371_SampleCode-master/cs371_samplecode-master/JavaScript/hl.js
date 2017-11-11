"use strict";

/**
 * One way of implementing "flippy triangles".  Note:  This is only partially complete.
 * A "real" implementation would have more styling and a some sort of encapsulation.ß
 *
 * Created by kurmasz on 2/6/15.
 */


function toggleList(event) {

    var ul = this.getElementsByTagName("ul")[0];
    console.log(ul.style.display);

    if (ul.style.display == "none") {
        ul.style.display = "block";
        openTriangle(this.getElementsByClassName("triangle")[0]);
    } else {
        ul.style.display = "none";
        closedTriangle(this.getElementsByClassName("triangle")[0]);
    }
}

function closedTriangle(canvas) {
    var height = 10;
    var width = 10;
    canvas.height = height;
    canvas.width = width;
    var ctx = canvas.getContext("2d");
    ctx.fillStyle = "grey";
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineTo(0, height);
    ctx.lineTo(width, height / 2);
    ctx.closePath();
    ctx.fill();
}


function openTriangle(canvas) {
    var height = 10;
    var width = 10;
    canvas.height = height;
    canvas.width = width;
    var ctx = canvas.getContext("2d");
    ctx.fillStyle = "grey";
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineTo(width, 0);
    ctx.lineTo(width / 2, height);
    ctx.closePath();
    ctx.fill();
}

function applyHideable() {
    var hidable = document.getElementsByClassName("hideableList");
    for (var i = 0; i < hidable.length; i++) {
        var item = hidable[i];
        // Notice that the entire "hideableList" object is clickable.
        item.addEventListener("click", toggleList);
        openTriangle(item.getElementsByClassName("triangle")[0]);
    }
}