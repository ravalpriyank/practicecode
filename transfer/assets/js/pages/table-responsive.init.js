/*
Template Name: GT Solution - GT Developers Template
Author: GT Developers
Website: https://gtdeveloper.com/
Contact: gtsolution@outlook.in
File: Table responsive Init Js File
*/

$(function() {
    $('.table-responsive').responsiveTable({
        addDisplayAllBtn: 'btn btn-secondary'
    });

    $('.btn-toolbar [data-toggle=dropdown]').attr('data-bs-toggle', "dropdown");
});