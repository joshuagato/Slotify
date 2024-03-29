<?php

	function sanitizeFormUsername($inputText){
		$inputText = strip_tags($inputText);  //strips $inputText off all tags
		$inputText = str_replace(" ", "", $inputText); //replaces all instances of spaces with empty character
		return $inputText;
	}

	function sanitizeFormString($inputText){
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		$inputText = ucfirst(strtolower($inputText));
		return $inputText;
	}

	function sanitizeFormEmail($inputText){
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		return $inputText;
	}

	function sanitizeFormPassword($inputText){
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		return $inputText;
	}

	if(isset($_POST['registerButton'])){
		//Register button was pressed
		$username = sanitizeFormUsername($_POST['username']);
		$firstName = sanitizeFormString($_POST['firstName']);
		$lastName = sanitizeFormString($_POST['lastName']);
		$email = sanitizeFormEmail($_POST['email']);
		$email2 = sanitizeFormEmail($_POST['email2']);
		$password = sanitizeFormPassword($_POST['password']);
		$password2 = sanitizeFormPassword($_POST['password2']);

		$wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);
		if($wasSuccessful == true){
			$_SESSION['userLoggedIn'] = $username;
			header("Location: index.php");
		}
	}
?>