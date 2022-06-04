<?php
require('scriptPHP.php');


function row($query)
{
    
    $row="";
    while($fetchBook = mysqli_fetch_assoc($query))
    {   
    $BookID = $fetchBook['Id_Book'];                        
    $BookTittle = $fetchBook['Book_Title'];
    $BookImg = $fetchBook['Img_Book'];
    $BookCategory = $fetchBook['Book_Category'];
    $BookInfo =substr($fetchBook['Book_Info'],0,200);
    $BookCategory = $fetchBook['Name_categories'];
    $bookRating = $fetchBook['Rating_book'];
    $row .= '<div class="col-lg-6">
    <div class="card card-body indexRow">
    <h3 class="card-title text-white">'.$BookTittle.'</h3>
    <h5 class="text-white">Ocena urzytkowników: '.$bookRating.'/10</h5>
    <p class="text-white">'.$BookCategory.'</p>
    <p class="card-text">
        <div class="row">
        <div class="col-sm-6">
            <img src="'.$BookImg.'" class="img-fluid" alt="">
        </div>
        <div class="col-sm-6">
            <span class="text-white">'.$BookInfo.'</span>
        </div>
        </div>
    </p>
    <a href="rowBook.php?ID='.$BookID.'" class="btn btn-primary">Więcej Informacji</a>
    </div>
    </div>';

    }

    return $row;

}


echo $nav;
?>
<div class ="container">

        <div class="card text-center">

            <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="true">Dla dzieci</a>
                        </li>
                    
                    </ul>
                </div>

            <div class="card-body">
                <div class="tab-content" id="myTabContent">

            <!-- -----------------------------------------------< TAB 1 >----------------------------------------------- -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h1 class="text-white">Dla dzieci</h1>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sortuj
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="forKids.php?sort=1">Ocena rosnąco</a>
                            <a class="dropdown-item" href="forKids.php?sort=2">Ocena malejąco</a>
                            <a class="dropdown-item" href="forKids.php?sort=3">Alfabetycznie od A-Z</a>
                            <a class="dropdown-item" href="forKids.php?sort=4">Alfabetycznie od Z-A</a>                             
                        </div>
                        </div>
                    <hr>
                    <div class="row">
                    <?php
                        
                        if($_GET['sort']==2){              
                            $taskBook = "SELECT Book.* , Categories.Name_categories, Users.Nick FROM `Book` INNER JOIN Categories ON Categories.Id_categories = Book_Category INNER JOIN Users ON Users.ID_users=Book_user_Id WHERE Book_Category = 1 ORDER BY `Book`.`Rating_book` ASC";
                        }elseif($_GET['sort']==3){
                            $taskBook = "SELECT Book.* , Categories.Name_categories, Users.Nick FROM `Book` INNER JOIN Categories ON Categories.Id_categories = Book_Category INNER JOIN Users ON Users.ID_users=Book_user_Id WHERE Book_Category = 1 ORDER BY `Book`.`Book_Title` ASC";

                        }elseif($_GET['sort']==4){
                            $taskBook = "SELECT Book.* , Categories.Name_categories, Users.Nick FROM `Book` INNER JOIN Categories ON Categories.Id_categories = Book_Category INNER JOIN Users ON Users.ID_users=Book_user_Id WHERE Book_Category = 1 ORDER BY `Book`.`Book_Title` DESC";

                        }else $taskBook = "SELECT Book.* , Categories.Name_categories, Users.Nick FROM `Book` INNER JOIN Categories ON Categories.Id_categories = Book_Category INNER JOIN Users ON Users.ID_users=Book_user_Id WHERE Book_Category = 1 ORDER BY `Book`.`Rating_book` DESC";

                        $queryBook = mysqli_query($connect, $taskBook);                     
                        echo row($queryBook);
                    ?>
                    </div>
                       
                    </div>
    <!-- -----------------------------------------------</ TAB 1 >----------------------------------------------- -->
                </div>
            </div>
        </div>
</div>            


<?php
echo $end;

?>