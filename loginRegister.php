<?php
   require('scriptPHP.php');

   session_start();
    $alertForgot="";
    $passChanged="";
  $tabs =  tabs('registerError');

  if(isset($_GET['forgot'])){
    unset($_GET['forgot']);
    $email = $_POST['emailForget'];
    $taskMail = "SELECT Nick FROM `Users` WHERE `E-mail`='$email'";
    $queryMail = mysqli_query($connect, $taskMail);
    $success = 2;
    
    if(mysqli_num_rows($queryMail)>0)
    {
    $fetchMail = mysqli_fetch_assoc($queryMail); 
    $userName = $fetchMail['Nick'];
    $subject = "GigStore zmiana hasła";
    $key = substr(md5(time()), 0, 20);
    $task = "INSERT INTO `Forget_Password` VALUES (NULL,'$userName','$key')";
    $query = mysqli_query($connect,$task);
    $subject = "GigStor zmiana hasła";
    $message = "Czesc $userName jeśli chcesz zmienić hasło to kliknij w link ponirzej  http://gigistor.pim.usermd.net/inzynier/forgetPass.php?Key=$key";
    sendEmail($email,$subject,$message);
    $success = 1;
    header("Location: loginRegister.php?success=$success");    
    

    }else{
        header("Location: loginRegister.php?success=$success");
       
    }  
  }
  if(isset($_GET['success'])){
    $success = $_GET['success'];
    if($success==1){
    $alertForgot = '<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:5px;">
            Email został wysłany.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
    }elseif($success==2)
    {
        $alertForgot = '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top:5px;">
        Podałeśc zły adres E-mail.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    }
}
if(isset($_GET['passChanged'])){
    $passChanged = '<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:5px;">
    Hasło zostało zmienione możesz się zalogować.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
 

   echo $nav;
?>
<script>
function zmiana() {
  document.getElementById("register").className = "tab-pane fade show active";
  document.getElementById("login").className = "tab-pane fade ";
  document.getElementById("login-tab").className = "nav-link ";
  document.getElementById("register-tab").className = "nav-link active ";

  
}
</script>

<div class="container text-white">
    <div class="card text-center  ">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?=$tabs['cardHeaderClassTab_1']?>" id="login-tab" data-toggle="tab" href="#login" role="tab"
                        aria-controls="login" aria-selected="<?=$tabs['cardHeaderAriaSelTab_1']?>">zaloguj</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$tabs['cardHeaderClassTab_2']?>" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register"
                        aria-selected="<?=$tabs['cardHeaderAriaSelTab_2']?>">zarejestruj</a>
                </li>

            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?=$tabs['cardBodyClassTab_1']?>" id="login" role="tabpanel" aria-labelledby="login-tab">

                    <form action="login.php" method="post">
                        
                            
                           
                            <?php
                               
                                alerts("error", "danger");
                                alerts("success", "success");
                                echo $alertForgot;
                                echo $passChanged;
                               

                            ?>
                            <div class="form-group">
                                <label for="username">Nazwa uzytkownika</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    aria-describedby="username" placeholder="Wpisz nazwe użytkownika" required>
                                <small id="username" class="form-text text-muted">W powyższym polu wpisujesz swoją
                                    nazwe.</small>
                            </div>

                            <div class="form-group">
                                <label for="passLogin">Hasło</label>
                                <input type="password" class="form-control" name="passLogin" id="passLogin"
                                    placeholder="Wpisz hasło" required>
                                <small id="passLogin" class="form-text text-muted">W powyższym polu wpisujesz swoje
                                    hasło.</small>

                            </div>
                            <button type="submit" class="btn btn-success">Zaloguj</button>
                            <a onclick="zmiana()" class="btn btn-primary">zarejestruj Się</a>
                            </form>
                            <a href="" data-toggle="modal" data-target="#forgotPass">Zapomniałem hasła</a>

                            <div class="modal" id="forgotPass" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method ="post" action = "loginRegister.php?forgot">
                                    <div class="modal-body" id="forgotPass1">
                                        <label>Podaj adres podany przy rejestracjii konta</Label>
                                        <input type="text" id="emailForget" name="emailForget">   
                                                                         
                                    </div>
                                    <div class="modal-footer">
                                        <a href="loginRegister.php" class="btn btn-secondary" data-dismiss="modal">Zamknij</a>
                                        <input type="submit" class="btn btn-success" value="Wyślij">                                
                                    </div>
                                    </form>
                                   
                                </div>
                                </div>
                            </div>
                   
                   




                </div>
                <div class="tab-pane fade <?=$tabs['cardBodyClassTab_2']?>" id="register" role="tabpanel" aria-labelledby="register-tab">
                    <form action="register.php" method="post">
                    <?php
                               
                               alerts("e_email", "danger");
                               alerts("e_username", "danger");
                               alerts("e_pass", "danger");
                               alerts("e_email", "danger");
                               alerts("e_regulamin", "danger");
                               


                           ?>

                        <div class="form-group">
                            <label for="email">Adres Email</label>
                            <input type="text" class="form-control" id="email"
                                aria-describedby="email" placeholder="Wpisz Email" name="email" required>
                            <small id="email" class="form-text text-muted">W powyższym polu wpisujesz swój
                                adres email.</small>
                        </div>

                        <div class="form-group">
                            <label for="username">Nazwa uzytkownika</label>
                            <input type="text" class="form-control" id="username" aria-describedby="username"
                                placeholder="Wpisz nazwe" name="username" required>
                            <small id="username" class="form-text text-muted">W powyższym polu wpisujesz swoją
                                 nazwe użytkownika.</small>
                        </div>

                        <div class="form-group">
                            <label for="pass1">Hasło</label>
                            <input type="password" class="form-control" id="pass1" name="pass1"
                                placeholder="Wpisz hasło" required>
                                <small id="pass1" class="form-text text-muted">W powyższym polu wpisujesz hasło.</small>
                        </div>
                        <div class="form-group">
                            <label for="pass2">Potwierdz hasło</label>
                            <input type="password" class="form-control" id="pass2" placeholder="Potwierdz hasło"
                                name="pass2" required>
                                <small id="pass1" class="form-text text-muted">W powyższym polu potwierdz hasło.</small>
                        </div>
                        <div class="row justify-content-around">
                        <div class="align-self-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="ch_regulamin" name="regulamin" required>
                            <label class="form-check-label" for="ch_regulamin">Zaakceptuj <a
                                    href="#">Regulamin</a></label>
                            <div class="g-recaptcha" data-sitekey="6LeoteIZAAAAANY813356Z_ET1GsFrSBELjEV3oe"
                                data-action='submit' data-callback='onSubmit'></div>

                        </div>
                        </div>
                        </div>

                        <button type="submit" class="btn btn-success">Wyślij</button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>



<?php



echo $end;


?>