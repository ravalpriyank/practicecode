/*
Template Name: GT Solution - GT Developers Template
Author: GT Developers
Website: https://gtdeveloper.com/
Contact: gtsolution@outlook.in
File: Password Addon Js File
*/

// show password input value
$("#password-addon").on('click', function () {
	if ($(this).siblings('input').length > 0) {
		$(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
	}
})
