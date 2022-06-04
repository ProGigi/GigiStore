<?php
  session_start();
  require('scriptPHP.php');

  if(isset($_POST['username']))
  {
    
  //ustawienie flagi
  $all_ok=true;
  //pobranie wartosci z formularza
  $email = $_POST['email'];
  $username = $_POST['username'];
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  //walidacja email
  $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
  if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
  {
    $all_ok=false;

    $_SESSION['e_email']="Podaj poprawny adres e-mail!";
    header('Location: loginRegister.php');
  }

    $task = "SELECT * FROM `Users` WHERE `E-mail`='$email'";
    $query = mysqli_query($connect, $task);
    $i = mysqli_num_rows($query);
    if($i>0){
      $all_ok=false;
  
      $_SESSION['e_email']="Adres e-mail jest zajęty";
    }
  
    //Walidacji username
    $task = "SELECT * FROM Users WHERE Nick='$username'";
    $query = mysqli_query($connect, $task);
    $i = mysqli_num_rows($query);
    if($i>0){
      $all_ok=false;
  
      $_SESSION['e_username']="Nick jest zajęty";
    }

    if ((strlen($username)<3) || (strlen($username)>20))
		{
      $all_ok=false;
  
      $_SESSION['e_username']="Nick musi posiadać od 3 do 20 znaków!";
    }
		
		if (ctype_alnum($username)==false)
		{
      $all_ok=false;
  
      $_SESSION['e_username']="Nick może składać się tylko z liter i cyfr (bez polskich znaków i znaków specialnych)";
    }

    //walidacja hasla
    if ((strlen($pass1)<8) || (strlen($pass1)>20))
		{
      $all_ok=false;
  
			$_SESSION['e_pass']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($pass1!=$pass2)
		{
      $all_ok=false;
  
			$_SESSION['e_pass']="Podane hasła nie są identyczne!";
		}	

    $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);

    //walidacja regulamin
    if (!isset($_POST['regulamin']))
		{
      $all_ok=false;
  
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
    }	

    //walidacj recaptcha
    $sekret = "6LeoteIZAAAAAGIQ5Q77SqTQ64Blw2JKz3hBt1NL";
		
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
    $reply = json_decode($check);
    if ($reply->success==false)
		{	
      $all_ok=false;
  

      $_SESSION['e_capcha']="jesteś gosciu robotem";
    }

    if($all_ok==TRUE){
      $suject = "Witaj w GigStor '$username'";
      $message = "Witaj '$username'. Twoje konto jest już aktywne możesz się zalogować:http://gigistor.pim.usermd.net/inzynier/loginRegister.php";
      sendEmail($email, $suject, $message);
      $data = date("Y-m-d H:i:s");
      $taskRegister ="INSERT INTO `Users`(`ID_users`, `Nick`, `E-mail`, `Pass`, `Data`, `Permission`, `Favorite_Book`, `Favorite_Autor`, `ReadBook`, `WantsRead`) VALUES (NULL,'$username','$email','$pass_hash','$data',2,'','','','')";
      $queryRegister = mysqli_query($connect, $taskRegister);
      $_SESSION['success']="Rejestracja udana";
      header("Location: loginRegister.php?"); 
    }else
    $_SESSION['registerError'] = TRUE;
  } 


 

?>