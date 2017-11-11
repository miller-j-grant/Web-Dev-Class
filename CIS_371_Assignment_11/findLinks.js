function findLinks() {
    // return all link elements on webpage
    console.log("****************************************");
    console.log("Finding the links: ");

    var answer = [];
    var links = document.getElementsByTagName("a");
    for(var i=0; i<links.length-1; i++) {
        answer.push(links[i].href);
    }
    if(answer.length){
        answer[0] = answer[0].substring(answer[0].indexOf("#"), answer[0].length);
        for(var i=1; i<answer.length; i++){
            answer[i] = answer[i].substring(0, answer[i].length-1);
        }
    }

    return answer;
}

/**
 * Compare two arrays and display a message at the bottom of the document indicating success or failure.
 * @param observed
 * @param expected
 */
function verifyResult(observed, expected) {

    // If observed is undefined, then do nothing.
    if (typeof(observed) == "undefined") {
        console.log("findLinks doesn't appear to be ready yet.");
        return;
    }

    console.log(observed);
    console.log(expected);

    var message = "Success";
    var detail = "";
    if (observed.length != expected.length) {
        message = "Fail:  Lengths differ.";
    } else {
        expected.forEach(function (element, index) {
            if (element != observed[index]) {
                message = "Fail";
                detail += "<br/>Element " + index + " differs.";
                console.log("Element " + index + " differs: ");
                console.log(element);
                console.log(observed[index]);
            }
        });
    }

    // This code demonstrates how one can add a completely new element to the DOM.
    // It shows how to add both content and styling to the new element.
    //
    // I chose this technique to keep the .html files as simple as possible.  However, in practice,
    // it is more common to add a hidden, styled "placeholding" element to the DOM, and only use JavaScript to
    // add the content an "unhide" the element when desired.
    var newItem = document.createElement("div");
    newItem.innerHTML = message + detail;
    newItem.style.display = "inline-block";
    newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
    newItem.style.padding = "15px";
    document.getElementsByTagName("body")[0].appendChild(newItem);
}

