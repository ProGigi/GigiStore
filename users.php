<?php
 session_start();
 require('scriptPHP.php');

 if(isset($_SESSION['userId'])){
     $userid= $_SESSION['userId'];
     $taskUser = "SELECT * FROM Users Where ID_users";
     $queryUser = mysqli_query($connect,$taskUser);
     $fetchUser = mysqli_fetch_assoc($queryUser);

     



 }
 else header('Location: index.php');





?>