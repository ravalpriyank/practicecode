/*
Template Name: GT Solution - GT Developers Template
Author: GT Developers
Website: https://gtdeveloper.com/
Contact: gtsolution@outlook.in
File: datatable for pages Js File
*/


// datatable
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: false
    });
    $(".dataTables_length select").addClass('form-select form-select-sm');
});