<?php
require('scriptPHP.php');
session_start();
$disabled ="disabled";
$disabledComm ="disabled";
$check=false;
$login = "<small>Zaloguj się żeby ocenić</small> ";
$userId = 0;
$userId = $_SESSION['userId'];
$like = "";
$read = "";
$wantsRead= "";
$none = "d-none";

if(isset($_GET['confirm'])){
    $id= $_GET['ID'];
    $task = "UPDATE Book SET Status_Book=1 WHERE Id_Book=$id";

    $query = mysqli_query($connect,$task);
    header("Location:rowBook.php?ID=$id");
}

if(isset($_GET['ID']))
{
    

    $idRow= $_GET['ID'];
    $task = "SELECT Book.*, Categories.Name_categories, Users.Nick FROM `Book` INNER JOIN Categories ON Categories.Id_categories = Book.Book_Category INNER JOIN Users ON Users.ID_users = Book.Book_user_Id WHERE Id_Book='$idRow'";
    $query = mysqli_query($connect, $task);
    $count = mysqli_num_rows($query);
    
    
       
    if( $count ==1 )
    {
        
        $fetch = mysqli_fetch_assoc($query);

        $rowImg = $fetch['Img_Book'];
        $rowTitle = $fetch['Book_Title'];
        $rowInfo = $fetch['Book_Info'];
        $rowTags= $fetch['Tags_Book'];
        $rowCategory = $fetch['Name_categories'];
        $rowRating = $fetch['Rating_book'];
        $rowStatus = $fetch['Status_Book'];
        $rowUser = $_SESSION['username'];
        $rowUserID = $fetch['Book_user_Id'];
       
        
        $rowAutor = explode(',',$fetch['Book_Id_Autor']);
        $autorName ="";
        foreach($rowAutor as $idAutor)
        {
            $taskAutor = "SELECT Name_Autor, SName_Autor FROM `Autor` WHERE Id_Autor=$idAutor";
            $queryAutor = mysqli_query($connect,$taskAutor);
            $fetchAutor = mysqli_fetch_assoc($queryAutor);
            $autorName .='<a href="rowAutor.php?ID='.$idAutor.'"><span name="rowTitle" class="text-white" id="rowTitle"><h3>'.$fetchAutor['Name_Autor'].' '.$fetchAutor['SName_Autor'].'</h3></span></a>';

        }

        if(isset($_SESSION['userId'])){
        $none = "";   
        $login ="";     
        $like = '<a href="rowBook.php?ID='.$idRow.'&like" class ="btn btn-primary" id="like" neme="like">Lubie to</a>';
        $read = '<a href="rowBook.php?ID='.$idRow.'&read" class ="btn btn-primary" id="like" neme="like">Przeczytane</a>';
        $wantsRead = '<a href="rowBook.php?ID='.$idRow.'&wantsRead" class ="btn btn-primary" id="like" neme="like">Chce Przeczytać</a>';
        $disabled =""; 
        $disabledComm= "";  
        
        $taskCheck = "SELECT * FROM `Rating_Book` WHERE `Users_Reing_Book`=$userId AND `Book_Id_Rating`=$idRow ";
        $queryCheck = mysqli_query($connect,$taskCheck);
        $taskLikeCheck = "SELECT * FROM `Users` WHERE ID_users= $userId AND Favorite_Book LIKE '%,$idRow' or Favorite_Book LIKE '$idRow,%' or Favorite_Book LIKE '%,$idRow,%'";
        $queryLikeCheck = mysqli_query($connect,$taskLikeCheck);
        
        if(mysqli_num_rows($queryLikeCheck)==1){
            $like = '<a href="rowBook.php?ID='.$idRow.'&like" class ="btn btn-primary disabled" id="like" neme="like" >Lubie to2</a>';
        }

        $taskReadBookCheck = "SELECT * FROM `Users` WHERE ID_users= $userId AND ReadBook LIKE '%,$idRow' or ReadBook LIKE '$idRow,%' or ReadBook LIKE '%,$idRow,%'";
        $queryReadBookCheck = mysqli_query($connect,$taskReadBookCheck);
        
        if(mysqli_num_rows($queryReadBookCheck)==1){
            $read = '<a href="rowBook.php?ID='.$idRow.'&read" class ="btn btn-primary disabled" id="like" neme="like">Przeczytane</a>';
        }
        $taskWantsReadCheck = "SELECT * FROM `Users` WHERE ID_users= $userId AND WantsRead LIKE '%,$idRow' or WantsRead LIKE '$idRow,%' or WantsRead LIKE '%,$idRow,%'";
        $queryWantsReadCheck = mysqli_query($connect,$taskWantsReadCheck);
        
        if(mysqli_num_rows($queryWantsReadCheck)==1){
            $wantsRead = '<a href="rowBook.php?ID='.$idRow.'&wantsRead" class ="btn btn-primary disabled" id="like" neme="like">Chce Przeczytać</a>';
        }
        
       
          
            if(isset($_POST['star']))
            {
                
                $ratingUser= $_POST['star'];
                $taskRating = "INSERT INTO `Rating_Book`(`ID_Rating_Book`, `Users_Reing_Book`, `Book_Id_Rating`, `Rating`) VALUES ('','$userId','$idRow','$ratingUser')";
                $queryRating = mysqli_query($connect, $taskRating);
                $taskAVG = "SELECT avg(Rating) FROM Rating_Book WHERE Book_Id_Rating = $idRow ";
                $queryAVG = mysqli_query($connect, $taskAVG);
                $fetchAVG = mysqli_fetch_assoc($queryAVG);
                $ratingAVG = $fetchAVG['avg(Rating)'];
                $ratingAVG = round($ratingAVG,2);
                $taskUpdate = "UPDATE `Book` SET `Rating_book`='$ratingAVG' WHERE Id_Book = '$idRow'";
                $queryUpdate = mysqli_query($connect, $taskUpdate);
                $rowRating = $ratingAVG;
                $none = "";
                header("Location:rowBook.php?ID=$idRow");
                        
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
            $taskLike = "SELECT Favorite_Book FROM Users WHERE ID_users= $userId";
            $queryLike = mysqli_query($connect,$taskLike);
            $fetchLike = mysqli_fetch_assoc($queryLike);
            $favorite1 = $fetchLike['Favorite_Book'];
            $favorite2 = $favorite1.$idRow.',';
            $taskLikeUP = "UPDATE Users SET Favorite_Book = '$favorite2' WHERE ID_users = $userId";
            $queryLikeUP = mysqli_query($connect,$taskLikeUP);
            
            header("Location:rowBook.php?ID=$idRow");
            


        
        }
        if(isset($_GET['read'])){
            $favorite2 = $idRow;
            $taskRead = "SELECT ReadBook FROM Users WHERE ID_users= $userId";
            $queryRead = mysqli_query($connect,$taskRead);
            $fetchRead = mysqli_fetch_assoc($queryRead);
            $favorite1 = $fetchLike['ReadBook'];
            $favorite2 = $favorite1.$idRow.',';
            $taskReadUP = "UPDATE Users SET ReadBook = '$favorite2' WHERE ID_users = $userId";
            $queryReadUP = mysqli_query($connect,$taskReadUP);
           
            header("Location:rowBook.php?ID=$idRow");
            


        
        }
        if(isset($_GET['wantsRead'])){
            $favorite2 = $idRow;
            $taskWantsRead = "SELECT WantsRead FROM Users WHERE ID_users= $userId";
            $queryWantsRead = mysqli_query($connect,$taskWantsRead);
            $fetchWantsRead = mysqli_fetch_assoc($queryLike);
            $favorite1 = $fetchWantsRead['WantsRead'];
            $favorite2 = $favorite1.$idRow.',';
            $taskWantsReadUP = "UPDATE Users SET WantsRead = '$favorite2' WHERE ID_users = $userId";
            $queryWantsReadUP = mysqli_query($connect,$taskWantsReadUP);
           
            header("Location:rowBook.php?ID=$idRow");
            


        
        }
    }

        

        if(isset($_GET['Comm']))
        {
            $comm = $_POST['comments'];
            $dateAdd = date("Y-m-d H:i:s");
            $taskAddComm = "INSERT INTO `Comments`(`Id_Comm`, `Id_Book`, `Body`, `Date`) VALUES ('','$idRow','$comm','$dateAdd')";
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
                    aria-selected="true">Książka</a>
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
                        
                        echo '
                        <div class="row">
                            <a href="rowBook.php?ID='.$idRow.'&confirm" class="btn btn-success">Zatwierdź</a>
                            <a href="addBook.php?delBack='.$idRow.'&img='.$rowImg.'" class="btn btn-danger">Usuń</a>
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
                                    <label class="text-white" for="rowTitle">Tytuł:</label><br>
                                    <span name="rowTitle" class="text-white" id="rowTitle"><h3><?=$rowTitle?></h3></span>
                                    <label class="text-white" for="rowName">Autor</label><br>
                                    <?=$autorName?>
                                    <label class="text-white" for="rowCategory">Kategoria</label><br>
                                    <span  name="rowCategory" class="text-white" id="rowCategory"><h3><?=$rowCategory?></h3></span>
                                </div>
                                <div class = " col-lg-5">
                                    <label class="text-white" from ="stars" ><?=$rowUser?> jeśli czytałeś to jaka jest twoja ocena?</label>
                                    <div class="rating text-white"> 
                                        <form method="post" action="rowBook.php?ID=<?=$idRow?>">
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
                                        <span>Aktualna ocena: <?=$rowRating?></span>    
                                        <form method="post" action="rowBook.php?ID=<?=$idRow?>">
                                            <?php
                                            echo $like;
                                            echo $read;
                                            echo $wantsRead;
                                            ?>
                                        </form>
                                                                
                                    </div>
                                   
                                </div>
                             
                         
                    </div>
                    <div>
                        <hr>
                        <label class="text-white" for="rowTahs">Tagi</label>
                        <span name="rowTahs" class ="text-white" readonly id="rowTahs"><h3><?=$rowTags?></h3> </span>
                        <hr>
                        <label class="text-white" for="rowInfo">Opis Komiksu</label>
                        <br/>
                        <span name="rowInfo" class ="text-white" readonly id="rowInfo"><h4><?=$rowInfo?></h4> </span><label></label>
                    </div>
                    <hr>
                    <form method= "post" action = "rowBook.php?ID=<?=$idRow?>&Comm">
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
                           <input class="btn btn-success fluid" type="submit" value="Dodaj Komentarz" <?=$disabledComm?>> 
                        

                     <div>
                    </form>
            
                <hr>
                <?php 
                $taskComm = "SELECT * FROM Comments WHERE Id_Book = $idRow ORDER BY `Comments`.`Date` DESC";
                $queryComm = mysqli_query($connect, $taskComm);
                while($fetchComm = mysqli_fetch_assoc($queryComm)){
                    $date = $fetchComm['Date'];
                    $body = $fetchComm['Body'];
                    echo '<div class="list-group">
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">'.$rowTitle.'</h5>
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