<?php
require('scriptPHP.php');
session_start();
$disabled ="";
$check=false;
$login = "<small>Zaloguj się żeby ocenić</small> ";
$userId = 0;
$like = "";

if(isset($_GET['confirm'])){
    $id= $_GET['ID'];
    $task = "UPDATE Autor SET status_Autor=1 WHERE Id_Autor=$id";

    $query = mysqli_query($connect,$task);
    header("Location:rowAutor.php?ID=$id");
}

if(isset($_GET['ID']))
{
    

    $idRow= $_GET['ID'];
    $task = "SELECT * FROM `Autor` WHERE Id_Autor = '$idRow'";
    $query = mysqli_query($connect, $task);
    $count = mysqli_num_rows($query);
    $none = "d-none";
    
       
    if( $count ==1 )
    {
        
        $fetch = mysqli_fetch_assoc($query);

        $rowImg = $fetch['img_Autor'];
        $rowName = $fetch['Name_Autor']." ".$fetch['SName_Autor'];
        $rowInfo = $fetch['Info_Autor'];
        $rowTags= $fetch['Tags_Autor'];
        $rowRating = $fetch['Rating_Autor'];
        $rowStatus = $fetch['status_Autor'];
        $rowUser = $_SESSION['username'];
        $rowUserID = $fetch['user_Id'];
        
       

      
        
        if(isset($_SESSION['userId']))
    {
        $none = "";   
        $login ="";  
        $like = '<a href="rowAutor.php?ID='.$idRow.'&like" class ="btn btn-primary" id="like" neme="like">Lubie to</a>';       
        $userId = $_SESSION['userId'];
        $taskCheck = "SELECT * FROM `Rating_Author` WHERE `Users_Rating_Autor`=$userId AND `Autor_Id_Rating`=$idRow ";
        $queryCheck = mysqli_query($connect,$taskCheck);
        $taskLikeCheck = "SELECT * FROM `Users` WHERE ID_users= $userId AND Favorite_Autor LIKE '%,$idRow' or Favorite_Autor LIKE '$idRow,%' or Favorite_Autor LIKE '%,$idRow,%'";
        $queryLikeCheck = mysqli_query($connect,$taskLikeCheck);
        
        if(mysqli_num_rows($queryLikeCheck)==1){
            $like = '<a href="rowAutor.php?ID='.$idRow.'&like" class ="btn btn-primary disabled" id="like" neme="like" >Lubie to</a>';
        }
       
       
          
            if(isset($_POST['star']))
            {
                
                $ratingUser= $_POST['star'];
                $taskRating = "INSERT INTO `Rating_Author` VALUES ('','$userId','$ratingUser','$idRow')";
                $queryRating = mysqli_query($connect, $taskRating);
                $taskAVG = "SELECT avg(Rating) FROM Rating_Author WHERE Autor_Id_Rating = $idRow";
                $queryAVG = mysqli_query($connect, $taskAVG);
                $fetchAVG = mysqli_fetch_assoc($queryAVG);
                $ratingAVG = $fetchAVG['avg(Rating)'];
                $ratingAVG = round($ratingAVG,2);
                $taskUpdate = "UPDATE `Autor` SET `Rating_Autor`='$ratingAVG' WHERE Id_Autor = '$idRow'";
                $queryUpdate = mysqli_query($connect, $taskUpdate);
                $rowRating = $ratingAVG;
                $none = "";
                header("Location:rowAutor.php?ID=$idRow&ocena=$rowRating");
                
                        
            }
         if(mysqli_num_rows($queryCheck) == 1){
            $fetchCheck = mysqli_fetch_assoc($queryCheck);
            $ratingUser = $fetchCheck['Rating'];
            $disabled ="disabled";
            $check = true;
            $none="";
            
            


        }
        if(isset($_GET['like'])){
            $favorite2 = $idRow;
            $taskLike = "SELECT  Favorite_Autor FROM Users WHERE ID_users= $userId";
            $queryLike = mysqli_query($connect,$taskLike);
            $fetchLike = mysqli_fetch_assoc($queryLike);
            $favorite1 = $fetchLike['Favorite_Autor'];
            $favorite2 = $favorite1.$idRow.',';
            $taskLikeUP = "UPDATE Users SET Favorite_Autor = '$favorite2' WHERE ID_users = $userId";
            $queryLikeUP = mysqli_query($connect,$taskLikeUP);
            
            header("Location:rowAutor.php?ID=$idRow");
            


        
        }
      
    }

        

        if(isset($_GET['Comm']))
        {
            $comm = $_POST['comments'];
            $dateAdd = date("Y-m-d H:i:s");
            $taskAddComm = "INSERT INTO `Comments_Autor`(`Id_Comm`, `Id_Autor`, `Body`, `Date`) VALUES ('','$idRow','$comm','$dateAdd')";
            $queryAddComm = mysqli_query($connect, $taskAddComm);
        }


    }else echo "cos nie tak";

   
    
}
else header('Location: index.php');


echo $nav;
?>
<div class ="container">
  <div class="card text-center">

        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Autor</a>
                </li>               
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="myTabContent">

<!-- -----------------------------------------------< TAB 1 >----------------------------------------------- -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <input type="text" class="d-none" id="rowImg" value="'.$exConfirmAutor['3'].'" name="rowImg">
                    
                    <?php
                    if($rowStatus==0 && $userId = $rowUserID){
                        echo "sesja: $userId";
                        echo '
                        <div class="row">
                            <a href="rowAutor.php?ID='.$idRow.'&confirm" class="btn btn-success">Zatwierdź</a>
                            <a href="addAutor.php?delBack='.$idRow.'&img='.$rowImg.'" class="btn btn-danger">Usuń</a>
                        </div>
                        <hr>
                        ';
                    }
                    ?>
                    <div class="row">

                        <div class="col-lg-3">
                            <img src="<?=$rowImg?>" class="img-fluid">
                        </div>
                        
                           
                                <div class="col-lg-4 ">
                                    <label class="text-white" for="rowName">Imie i Nazwisko:</label><br>
                                    <span name="rowName" class="text-white" id="rowName"><h3><?=$rowName?></h3></span>
                                    
                                    <label class="text-white" for="rowBookTittle">Komiksy</label><br>
                                    <?php
                                         $taskBook = "SELECT * FROM `Book` WHERE Book_Id_Autor LIKE '%,$idRow' or Book_Id_Autor LIKE '$idRow,%' or Book_Id_Autor LIKE '%,$idRow,%' or Book_Id_Autor =$idRow ";
                                         $queryBook = mysqli_query($connect, $taskBook);
                                         while($fetchBook = mysqli_fetch_assoc($queryBook)){
                                             $bookTitle= $fetchBook['Book_Title'];
                                             $bookID = $fetchBook['Id_Book'];
                                             echo '<a href="rowBook.php?ID='.$bookID.'"><span name="rowBookTittle" class="text-white" id="rowBookTittle"><h3>'.$bookTitle.'</h3></span></a><br>';
                                         }

                                    ?>
                                </div>
                                <div class = " col-lg-5">
                                    <label class="text-white <?=$none?>" from ="stars" ><?=$rowUser?> jeśli czytałeś to jaka jest twoja ocena?</label>
                                    <div class="rating text-white "> 
                                        <form method="post" action="rowAutor.php?ID=<?=$idRow?>">
                                        <div class="stars">
                                            <?php
                                            for($i=10;$i>0;$i--)
                                            {
                                               
                                                if($check){
                                                if($ratingUser == $i){                                               
                                                $radio = '<input class="h1-xl" type="radio" id="star'.$i.'" name="star" value="'.$i.'" checked disabled> <label for="star'.$i.'">'.$i.'</label>';
                                                }else $radio = '<input class="h1-xl" type="radio" id="star'.$i.'" name="star" value="'.$i.'" disabled> <label for="star'.$i.'">'.$i.'</label>';

                                                }else {
                                                    $radio = '<input class="h1-xl" type="radio" id="star'.$i.'" name="star" value="'.$i.'" '.$dnone.' > <label for="star'.$i.'">'.$i.'</label>';
                                                    
                                                }
                                                
                                                echo $radio;
                                            }

                                            ?>
                                            
                                        </div>
                                        <input class="btn btn-success fluid" type="submit" value="Wyślij Ocene" <?=$disabled?>> 
                                        </form>
                                        <?=$login?>    
                                        <span id="userRating" class = "<?=$none?>" >Twoja ocena to: <?=$ratingUser?></span>
                                        <br/>
                                        <span>Aktualna ocena: <?=$rowRating?></span><br>
                                        <?=$like?>  
                                                                
                                    </div>
                                   
                                </div>
                             
                         
                    </div>
                    <div>
                        <hr>
                        <label class="text-white" for="rowTahs">Tagi</label>
                        <span name="rowTahs" class ="text-white" readonly id="rowTahs"><h3><?=$rowTags?></h3> </span>
                        <hr>
                        <label class="text-white" for="rowInfo">Opis Autora</label>
                        <br/>
                        <span name="rowInfo" class ="text-white" readonly id="rowInfo"><h4><?=$rowInfo?></h4> </span><label></label>
                    </div>
                    <hr>
                    <form method= "post" action = "rowAutor.php?ID=<?=$idRow?>&Comm">
                    <div class="row">
                        <div class ="form-gruop col-4">
                        <label class="text-white" from="userComment">Nick</label>
                        <input type="text" class="form-control" id="userComment" name="userComment" readonly value="<?=$rowUser?>">
                        </div>
                        <div class ="form-gruop col-8">
                        </div>                       
                    </div>
                    <div>
                           
                           <label class="text-white" for="comments">Wpisz swój komendarz</label>
                           <textarea class="form-control" name="comments" id="comments" rows="3" required></textarea>
                           <input class="btn btn-success fluid" type="submit" value="Dodaj Komentarz"> 
                        

                     <div>
                    </form>
            
                <hr>
                <?php 
                $taskComm = "SELECT * FROM Comments_Autor WHERE Id_Autor = $idRow ORDER BY `Comments_Autor`.`Date` DESC";
                $queryComm = mysqli_query($connect, $taskComm);
                while($fetchComm = mysqli_fetch_assoc($queryComm)){
                    $date = $fetchComm['Date'];
                    $body = $fetchComm['Body'];
                    echo '<div class="list-group">
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">'.$rowName.'</h5>
                        <small>'.$date.'</small>
                        </div>
                        <p class="mb-1">'.$body.'</p>
                        <small>'.$rowUser.'</small>
                    </a>
                </div>';
                } 
                    
                ?>
                </div>
<!-- -----------------------------------------------</ TAB 1 >----------------------------------------------- -->
                

            </div>
        </div>
    </div>
</div>
</div>

<?php
echo $end;

?>