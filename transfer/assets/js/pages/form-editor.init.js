/*
Template Name: GT Solution - GT Developers Template
Author: GT Developers
Website: https://gtdeveloper.com/
Contact: gtsolution@outlook.in
File: Form editor Init Js File
*/


ClassicEditor
    .create( document.querySelector( '#ckeditor-classic' ) )
    .then( function(editor) {
        editor.ui.view.editable.element.style.height = '200px';
    } )
    .catch( function(error) {
        console.error( error );
    } );


