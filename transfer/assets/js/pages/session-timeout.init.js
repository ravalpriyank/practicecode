/*
Template Name: GT Solution - GT Developers Template
Author: GT Developers
Website: https://gtdeveloper.com/
Contact: gtsolution@outlook.in
File: Session Timeout Js File
*/

$.sessionTimeout({
	keepAliveUrl: 'pages-starter.php',
	logoutButton:'Logout',
	logoutUrl: 'auth-login.php',
	redirUrl: 'auth-lock-screen.php',
	warnAfter: 3000,
	redirAfter: 30000,
	countdownMessage: 'Redirecting in {timer} seconds.'
});

$('#session-timeout-dialog  [data-dismiss=modal]').attr("data-bs-dismiss", "modal");