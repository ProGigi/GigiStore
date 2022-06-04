<?php
    session_start();
   
 
  
    require('scriptPHP.php');

   
    if ($connect->connect_errno) {
        echo "Error: ".$connect->connect_errno;
    exit();
    } 
    else {
       
        $login = $_POST['username'];
        $pass = $_POST['passLogin'];      

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        echo "tu ";
          


        $sqlo =  "SELECT * FROM `Users` WHERE `Nick`='%s'" ;
        if ($rezults = @$connect->query(sprintf($sqlo,
        mysqli_real_escape_string($connect,$login))))
            {
                echo " tu2";
                echo $ilu_userow = $rezults->num_rows;
                if($ilu_userow==1)
                {
                    echo " tu3";
                    $rows = $rezults->fetch_assoc();
                    echo $pass;
                    if(password_verify($pass, $rows['Pass']))
                    {  
                        echo " tu4";              
                    $_SESSION['login'] = true;
                    
                   
                    $_SESSION['username'] = $rows['Nick'];
                    $_SESSION['userId']= $rows['ID_users'];
                    
                    
                    unset($_SESSION['error']);
                    $rezults->free_result();
                    header('Location: index.php');
                    }else 
                    {
                        
                        $_SESSION['error'] = 'błędne hasło';
                        header('Location: loginRegister.php');
                        
                    }

                    
                    
                }
                else {
                    echo " tu5";
                    $_SESSION['error'] = "błąd";
                    header('Location: loginRegister.php');
                    
                }
                
            }
            
}


    $connect -> close();

?>