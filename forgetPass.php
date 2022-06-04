<?php
require('scriptPHP.php');


if(isset($_GET["Key"])){
    $key = $_GET['Key'];
    $taskForget = "SELECT * FROM Forget_Password Where Forget_Key = '$key'";
    echo "tu0";
    $queryForget = mysqli_query($connect,$taskForget);

    if(mysqli_num_rows($queryForget)==1)
    {
        echo "tu1";
        $fetchForget = mysqli_fetch_assoc($queryForget);
        $userName = $fetchForget['Forget_Nick'];
        if(isset($_GET['forget'])){
            
            $pass1 = $_POST['forgetPass1'];
            echo $pass1;
            $pass2 = $_POST['forgetPass2'];
            $all_ok = true;
            if ((strlen($pass1)<8) || (strlen($pass1)>20))
            {
                $all_ok=false;
                echo "to tu";
                $_SESSION['e_forget']="Hasło musi posiadać od 8 do 20 znaków!";
            }
            
            if ($pass1!=$pass2)
            {
                $all_ok=false;
                echo "to tru2";
                $_SESSION['e_forget']="Podane hasła nie są identyczne!";
            }	
    
        $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
        
        if ($all_ok)
        {
            $taskUpPass = "UPDATE Users SET Pass='$pass_hash' Where Nick ='$userName'";
            $queryUpPass = mysqli_query($connect,$taskUpPass);
            header("Location:loginRegister.php?passChanged");
        }
    }
    }
}
else {
    header("Location:index.php");
}

echo $nav;
?>

<div class ="container">

        <div class="card text-center">

            <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="true">Zmień hasło</a>
                        </li>
                    
                    </ul>
                </div>

            <div class="card-body">
                <div class="tab-content" id="myTabContent">

            <!-- -----------------------------------------------< TAB 1 >----------------------------------------------- -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form method="post" action="forgetPass.php?Key=<?=$key?>&forget">
                        <h2 class="text-white">Witaj <?=$userName?></h2>
                        <?=alerts("e_forget", "danger")?>
                        <label class="text-white" from="forgetPass1">Podaj nowe hasło</label>
                        <input type="password" class="form-control" id="forgetPass1" name="forgetPass1">
                        <label class="text-white" from="forgetPass2">Powtóż hasło</label>
                        <input type="password" class="form-control" id="forgetPass2" name="forgetPass2">
                        <input type="submit" class="btn btn-success" value="Wyślij">  
                    </form>
                       
                    </div>
    <!-- -----------------------------------------------</ TAB 1 >----------------------------------------------- -->
                </div>
            </div>
        </div>
</div>            

<?php
echo $end;

?>