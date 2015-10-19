 <?php
  session_start();
  
  $link = mysqli_connect("localhost","cl56-example-0it","73thH6fK-","cl56-example-0it");
   
   if ($_POST['submit']== "Sign Up") {
	   
	  if (!$_POST['email']) $error.= "<br />Please enter your email";  
		else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
			$error.="<br />Please enter a valid email address";
	  
	  
	 if (!$_POST['password'])$error.="<br />Please enter a password";
	  else {
		
		if(strlen($_POST['password'])<8)
		 $error.="<br />Please enter a password with at least 8 characters";
	 
	    if (!preg_match('`[A-Z]`', $_POST['password']))
		 $error.="<br />Please enter at least one capital letter in your password";
			
	  }
	  
	  if($error)
		 echo "There were error(s) in your Sign Up details: ".$error;
	 
	  else{
		
		/* echo mysqli_connect_error();
	    if(mysqli_connect_error()){
			die("COULD NOT CONNECT");
		} */
		
        $query ="SELECT * FROM `user` WHERE email ='".mysqli_real_escape_string($link,$_POST['email'])."'";
			
        $result = mysqli_query($link,$query);
			
	    if($results = mysqli_num_rows($result)>0)
			echo "That email is already registered.Do you want to login";
		
		else{
			
	    $query = "INSERT INTO user(`email`, `password`) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".md5(md5($_POST['email']).$_POST['password'])."')";
		
		mysqli_query($link, $query);
		
		echo "You have been signed up!";
			
		$_SESSION['id'] = mysqli_insert_id($link);
		
		print_r($_SESSION);
		
		//Redirect to logged in page
			
		}
			

	 }  
		  
	  
    } 

    if ($_POST['submit']=="Log In"){
		
		echo "hello";
		
	    $query="SELECT * FROM user WHERE email='".mysqli_real_escape_string($link,$_POST['emailLogin'])."'AND password = '".md5(md5($_POST['emailLogin']).$_POST['passwordLogin'])."'LIMIT 1";
		
		 $result = mysqli_query($link, $query);
		
		$row = mysqli_fetch_array($result);
		
		print_r($row); 
		
		
	}		


?>

<form method = "post">

  <input type = "email" name = "email" id = "email" value = "<?php echo addslashes($_POST['email']); ?>" />
  
  <input type = "password" name = "password" id = "password" value = "<?php echo addslashes($_POST['password']); ?>" />
  
  <input type = "submit" name = "submit" value = "Sign Up" />
  
</form>

<form method = "post">
  
  <input type = "email" name = "emailLogin" id = "emailLogin" value = "<?php echo addslashes($_POST['emailLogin']); ?>" />
  
  <input type = "password" name = "passwordLogin" value = "<?php echo addslashes($_POST['passwordLogin']); ?>" />
  
  <input type = "submit" name = "submit" value = "Log In" />
  
</form>