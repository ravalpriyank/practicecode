/*
Template Name: GT Solution - GT Developers Template
Author: GT Developers
Website: https://gtdeveloper.com/
Contact: gtsolution@outlook.in
File: two step verification Init Js File
*/


// move next
function moveToNext(elem, count){
    if(elem.value.length > 0) {
        $("#digit"+count+"-input").focus();
    }
}