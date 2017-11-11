"use strict";
/*
 Prints the DOM tree to the console.  This code is a JavaScript implementation of the
 Java code in XHTMLExplorer.java
 */

// Some spaces for indentation purposes.
var spaces = "                                                                  ";


// IMPORTANT!  This code is written to demonstrate how the DOM is structured and what classes it uses.
// I also wrote it to parallel to the code in XHTMLExplorer.java.
// JavaScript provides easier ways to access data from the DOM.  Learn those
// techniques instead of naively copying this code!
function examineNode(node) {

    console.log("****************************************");
    console.log("Examining a node: ");
    console.log(node);
    printAttributes(node);
    
    var children = node.childNodes;
    for (var i = 0; i < children.length; i++) {
        var child = children[i];
        console.log("------------------------------");
        console.log("child " + i + ":");
        console.log(child);
        console.log("Node Type: " +  child.nodeType + " (" + nodeTypeName(child.nodeType) + ")");
        console.log("Node name: '" + child.nodeName + "'");
        console.log("Node value: '" + cleanUp(child.nodeValue) + "'");
        console.log("Text content:  '" + cleanUp(child.textContent) + "'");
        console.log("innerHTML:  '" + child.innerHTML + "'");
    }
}

function printAttributes(node) {
    var attributes = node.attributes;
    console.log(attributes);
    for (var i = 0; i < attributes.length; i++) {
        var attribute = attributes[i];
        console.log(attribute.nodeName + " ==> " + attribute.nodeValue);
    }
}


function nodeTypeName(typeNumber) {
    switch (typeNumber) {
        case Node.ATTRIBUTE_NODE:
            return "Attribute";
        case Node.TEXT_NODE:
            return "Text";
        case Node.ELEMENT_NODE:
            return "Element";
        case Node.COMMENT_NODE:
            return "Comment";
        default:
            return "<unknown>";
    }
}

function cleanUp(input) {

    if (input == null) {
        return "<null>";
    } else {
        return input.replace(/\n/g, "<cr>");
    }

}



function printElement(element, depth) {

    var indentSize = 3;
    var indent = spaces.substr(0, depth * indentSize);
    var indent2 = spaces.substr(0, (depth + 1) * (indentSize));

    // Print the tag
    console.log(indent + "<" + element.nodeName + ">");

    // print the attributes
    for (var i = 0; i < element.attributes.length; i++) {
        var item = element.attributes.item(i);
        console.log(indent2 + "* " + item.nodeName + ": " + item.value);
    }

    // print the children
    for (var i = 0; i < element.childNodes.length; i++) {
        var item = element.childNodes[i];
        // recursively handle other tags
        if (item.nodeType == Node.ELEMENT_NODE) {
            printElement(item, depth + 1);
        } else if (item.nodeType == Node.TEXT_NODE) {
            var value = item.nodeValue.replace(/\n/g, "\\n");
            console.log(indent2 + "->" + value + "<-");
        } else {
            console.log("Oops!  Unrecognized node type");
        }
    }
} // end printElement

//printElement(document.documentElement, 0);
