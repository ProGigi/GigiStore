<?php
$username="m1188_gigi";
$password="Django0812";
$localhost="mysql29.mydevil.net";
$database= "m1188_gigistor";

$connect = @new mysqli($localhost,$username, $password, $database);
$connect->set_charset("utf8");


session_start();
$actIndex = '';
$actKomiksy = '';
$actTop = '';
$actDD = '';
$actDlaD = '';
$actSuper = '';
$actInne = '';
$actregister = '';
$actLogin = '';
$actDodaj = '';

$self = $_SERVER['PHP_SELF'];
if($self == "/index.php"){
  $actIndex = "actBtn";
}elseif($self == "/top.php"){
  $actTop = "actBtn";
}elseif($self == "/dladoroslych.php"){
  $actKomiksy = "actBtn";
  $actDD = "actBtn";
}elseif($self == "/dladzieci.php"){
  $actKomiksy = "actBtn";
  $actDlaD = "actBtn";
}elseif($self == "/superbohaterowie.php"){
  $actKomiksy = "actBtn";
  $actSuper = "actBtn";
}elseif($self == "/inne.php"){
  $actKomiksy = "actBtn";
  $actInne = "actBtn";
}elseif($self == "/loginRegister.php"){
  $actregister = "actBtn";
}elseif($self == "/loginRegister.php"){
  $actLogin = "actBtn";
}elseif($self == "/addNew.php"){
  $actDodaj = "actBtn";
}


if(isset($_SESSION['login']))
{
  $userId = $_SESSION['userId'];
  $taskAdmin = "SELECT Permission From Users Where ID_users=$userId";
  $queryAdmin = mysqli_query($connect,$taskAdmin);
  $fetchADmin = mysqli_fetch_assoc($queryAdmin);
  if($fetchADmin['Permission']==1){
  $dAdmin = "";   
  }else $dAdmin = " d-none";
  
  $login = '<a class="nav-link" href="users.php?">Witaj '.$_SESSION['username'].'</a>';
  $logout ='<a class="nav-link " href="logout.php">Wyloguj Się</a>';
  $d = "";
}else{
  $login = '<a class="nav-link  '.$actLogin.'" href="loginRegister.php">Zaloguj się</a>';
  $logout ='<a class="nav-link '.$actregister.'" href="loginRegister.php">zarejestruj się</a>';
 $d =" d-none";
 
}

function alerts($sessionName, $color){

  if(isset($_SESSION[$sessionName])){
    echo '
    <div class="alert alert-'.$color.' alert-dismissible fade show" role="alert" style="margin-top:5px;">
    '.$_SESSION[$sessionName].'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';
   
}
unset($_SESSION[$sessionName]);
}


function tabs($showTab){

  $tabs = [];
  if(isset($_SESSION[$showTab])||isset($_GET[$showTab])){
    $tabs['cardHeaderAriaSelTab_1']=false;
    $tabs['cardHeaderAriaSelTab_2']=true;
    

    $tabs['cardHeaderClassTab_1']="";
    $tabs['cardHeaderClassTab_2']="active";
    

    $tabs['cardBodyClassTab_1']="";
    $tabs['cardBodyClassTab_2']="show active";
    

  

}else{
    $tabs['cardHeaderAriaSelTab_1']=true;
    $tabs['cardHeaderAriaSelTab_2']=false;
   

    $tabs['cardHeaderClassTab_1']="active";
    $tabs['cardHeaderClassTab_2']="";
   

    $tabs['cardBodyClassTab_1']="show active";
    $tabs['cardBodyClassTab_2']="";
   
}
unset($_SESSION[$showTab]);
unset($_GET[$showTab]);
return $tabs;
}


$nav = '<!doctype html>
<html lang="pl_PL">
  <head>
    <title>GigStore</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Bootstrap CSS -->
    
    <link rel="Shortcut icon"  type="image/png" href="favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" href="css/bootstrap.css">
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Stalinist+One&display=swap" rel="stylesheet"> 
  </head>
  <body>
  <script src="css/jquery-3.4.0.min.js"></script>

  <script src="css/popper.min.js"></script>

  <script src="css/bootstrap.min.js"></script> 

  <script src="css/jquery-ui.js"></script>
  
    <nav class="navbar navbar-expand-lm  navColor" style="padding:0;">
        
        <button class="navbar-toggler logo" type="button" data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navigation">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
          </svg>
        </button>
        <a class="navbar-brand logo pl-3 " href="index.php"> GigiStor</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <div class="navbar-toggler-icon logo pl-sm-0 ">M</div>
        </button>
       
      
        
        <div class="collapse navbar-collapse px-3" id="navbarNav" style="height:100%">
          <ul class="navbar-nav">
            <li class="nav-item '.$actIndex.'" style="height:100%;">
              <a class="nav-link" href="index.php">Strona Główna<span class="sr-only">(current)</span></a>
            </li>
           
              <li class="nav-item '.$actDD.'">
              <a class="nav-link " href="forAdults.php">Dla dorosłych</a>
              </li>            
              <li class="nav-item  '.$actDlaD. '">
              <li><a class="nav-link " href="forKids.php">Dla dzieci</a></li>
              </li>
              <li class="nav-item '.$actSuper.'">
              <a class="nav-link  " href="superHeroes.php">Superbohaterowie</a>
              </li>
              <li class="nav-item '.$actInne.'">
              <a class="nav-link" href="other.php">Inne</a>
              </li>
            
            <li class="nav-item dropdown '.$d.' '.$actDodaj.'">
              <a class="nav-link dropdown-toggle " href="#" id="addNew" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dodaj
              </a>
              <div class="dropdown-menu btn-drop-list" aria-labelledby="addNew">
                <a class="dropdown-item btn-drop-list" href="addBook.php">Dodaj Komiks</a>
                <a class="dropdown-item btn-drop-list" href="addAutor.php">Dodaj Autora</a>                
              </div>
            </li>
            <li class="nav-item'.$dAdmin.'">
            <a class="nav-link" href="admin-autor.php">admin Autor</a>
          </li>
            <li class ="nav-item '.$dAdmin.'">
              <a class="nav-link" href="admin-books.php">admin Komiksy<a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
          
          <li class="nav-item">
          '.$login.'
        </li>
        <li class="nav-item">
        '.$logout.'
      </li>      
          </ul>
        </div>
        <div class="collapse navbar-collapse p-3 p-lg-0" id="navbarSearch" >
          <form action="search.php" method="POST"> 
            
              <div class="input-group input-group-sm ">
                <input type="text" name="search"class="form-control bg-dark text-white" style="border:0; color:white; " placeholder="wyszukaj" aria-label="wyszukaj" aria-describedby="basic-addon2" >
              
                <div class="input-group-append">
                  <input class="btn logo" style="color: #143970;"  type="submit" value="Szukaj">
                </div>
                </div>
            </div>
          
            
          </form>
        </div>
       
      </nav>';
           
    

$end ='
  </body>
</html>';





function check_login(){
  if (!isset($_SESSION['zalogowany'])){
    header('location:index.php');
    
    exit();
  }
}



//walidacja i dodawanie zdjecia
function save_img($inputName, $fileName, $targetDir){
  if(is_uploaded_file($_FILES[$inputName]['tmp_name'])) {
      $target_dir=$targetDir.'/';
      $target_file=$target_dir . basename($_FILES[$inputName]["name"]);
      $uploadOk=1;
      $date=date("Y-m-d-H-i-s");
     
      $imageFileType=strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $target_file=$target_dir .$fileName.'_'.$date .'.'. $imageFileType;

      // Allow certain file formats
      if($imageFileType !="jpg"&& $imageFileType !="png"&& $imageFileType !="jpeg"&& $imageFileType !="gif") {
          echo "Możesz przesłać pliki tylko w formatach .jpg, .jpeg, .png oraz .gif";

          $uploadOk=0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk==0) {
          echo " Twój plik nie został wysłany";
          // if everything is ok, try to upload file
      }

      else {
          if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_file)) {
              $patch=$target_file;
          }

          else {
              echo "Wystąpił bład";
          }
      }
     
  }

  else {
      $patch="brak";
  }
  return $patch;
}


//wysyłanie meili
function  sendEmail($email, $subject, $message){
      
      $header = "From: gigi@pim.usermd.net \nContent-Type:".
      ' text/plain;charset="UTF-8"'.
      "\nContent-Transfer-Encoding: 8bit";
      $to = $email;
      $subject = $subject;
      $message = $message;
      mail($to, $subject, $message, $header);
}

?> 