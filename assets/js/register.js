// $(document).ready(function(){
// 	// console.log("document is ready")
// 	$("#hideLogin").click(function(){
// 		$("#loginForm").hide();
// 		$("#registerForm").show();
// 	});

// 	$("#hideRegister").click(function(){
// 		$("#loginForm").show();
// 		$("#registerForm").hide();
// 	});
// });

window.onload = function(){
	// console.log('document is ready!');
	var hideLogin = document.querySelector('#hideLogin');
	var hideRegister = document.querySelector('#hideRegister');
	var loginForm = document.querySelector('#loginForm');
	var registerForm = document.querySelector('#registerForm');

	hideLogin.onclick = function(){
		loginForm.style.display = 'none';
		registerForm.style.display = 'block';
	};

	hideRegister.onclick = function(){
		loginForm.style.display = 'block';
		registerForm.style.display = 'none';
	};

};