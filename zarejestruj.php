<?php
require('zmienne.php');
session_start();

echo $nawigacja;
?>
<div class="container"> 

<div class="row">
  <div class="col-8">
  <form action="potwierdzenieRejestracji.php" method="post">


<div class="form-group">
  <label for="przykladowyEmail">Adres Email</label>
  <input type="text" class="form-control" id="przykladowyEmail" aria-describedby="podpowiedzEmail" placeholder="Wpisz Email" name = "email">
  <small id="podpowiedzEmail" class="form-text text-muted">W powyższym polu wpisujesz swój adres email.</small>
</div>

<div class="form-group">
    <label for="username">Nazwa uzytkownika</label>
    <input type="text" class="form-control" id="username" aria-describedby="podpowiedzUser" placeholder="Wpisz nazwe" name = "username">
    <small id="podpowiedzUser" class="form-text text-muted">W powyższym polu wpisujesz swoją nazwe.</small>
  </div>

<div class="form-group">
  <label for="Haslo">Hasło</label>
  <input type="password"  class="form-control" id="Haslo" name="haslo1" placeholder="Wpisz hasło">
</div>
<div class="form-group">
    <label for="Haslo">Potwierdz hasło</label>
    <input type="password" class="form-control" id="Haslo" placeholder="Potwierdz hasło" name = "haslo2">
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="ch_regulamin" name="regulamin">
    <label class="form-check-label" for="ch_regulamin">Zaakceptuj <a href="#">Regulamin</a></label>
      <div class="g-recaptcha" data-sitekey="6LeoteIZAAAAANY813356Z_ET1GsFrSBELjEV3oe" data-action='submit' data-callback='onSubmit'></div>

  </div>

<button type="submit" class="btn">Wyślij</button>
</form>
  </div>
  <div class="col-4">
      <?php 
      if(isset($_SESSION['e_username'])){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:5px;">
          '.$_SESSION['e_username'].'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        unset($_SESSION['e_username']);
      }

      if(isset($_SESSION['e_email'])){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:5px;">
          '.$_SESSION['e_email'].'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        unset($_SESSION['e_email']);
      }

      if(isset($_SESSION['e_haslo'])){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:5px;">
          '.$_SESSION['e_haslo'].'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        unset($_SESSION['e_haslo']);
      }
      
      if(isset($_SESSION['e_capcha'])){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:5px;">
          '.$_SESSION['e_capcha'].'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        unset($_SESSION['e_capcha']);
      }

      if(isset($_SESSION['e_regulamin'])){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:5px;">
          '.$_SESSION['e_regulamin'].'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        unset($_SESSION['e_regulamin']);
      }
      ?>
    
  </div>
</div>

</div>



<?php
echo $koniec;
?>