"use strict";

/**
 * One way of implementing "flippy triangles".
 *
 * In contrast to hl.js, this implementation:
 * (1) Uses encapsulation to limit the pollution of the global name space
 * (2) Only allows users to click on the list header (instead of the entire list).
 *     To make this happen, we put the event handler on the <p> inside the <div>, then
 *     use a closure to store a reference to the <div>
 *
 * Created by kurmasz on 2/6/15.
 */


var HidableList = (function () {

    function makeHandler(hideableDiv) {
        return function toggleList(event) {
            var ul = hideableDiv.getElementsByTagName("ul")[0];
            if (ul.style.display == "none") {
                ul.style.display = "block";
                openTriangle(hideableDiv.getElementsByClassName("triangle")[0]);
            } else {
                ul.style.display = "none";
                closedTriangle(hideableDiv.getElementsByClassName("triangle")[0]);
            }
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
        var hideable = document.getElementsByClassName("hideableList");
        for (var i = 0; i < hideable.length; i++) {
            var item = hideable[i];

            // put the listener on the <p> only; but,
            // use a closure to save a reference to the entire
            // hideable div
            var paragraph = item.getElementsByTagName("p")[0];
            paragraph.addEventListener("click", makeHandler(item));
            openTriangle(item.getElementsByClassName("triangle")[0]);
        }
    }

    return {
        apply: applyHideable
    }


})();
