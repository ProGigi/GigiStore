<?php
require('scriptPHP.php');

if(!isset($_GET['id'])){

    die('brak dostępu');
        
}
$ID = $_GET['id'];
if(isset($_GET['edit'])){
    $idAutor = $_POST['autorID'];
    
    $autorName = $_POST['autorName'];
    $autorSName = $_POST['autorSName'];
    $autorStatus = $_POST['autorStatus'];
    $autorTags=$_POST['autorTags'];
    $autorInfo = $_POST['autorInfo'];

 
$autors = substr($autors, 0, -1);
    $task = 'UPDATE `Autor` SET `Name_Autor`="'.$autorName.'",`SName_Autor`="'.$autorSName.'",`Info_Autor`="'.$autorInfo.'",`status_Autor`="'.$autorStatus.'",`Tags_Autor`="'.$autorTags.'" WHERE Id_Autor = '.$idAutor.'';
    $queryUpdate = mysqli_query($connect, $task);
}




$task = "SELECT * FROM `Autor` LEFT JOIN Users ON Autor.user_Id = Users.ID_users  WHERE Id_Autor = $ID";
$query = mysqli_query($connect, $task);
$fetch = mysqli_fetch_assoc($query);


echo $nav;
?>

<div class ="container">

    <div class="card text-center">

        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Książki</a>
                </li>
                
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="myTabContent">

        <!-- -----------------------------------------------< TAB 1 >----------------------------------------------- -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row text-light bg-dark">
                        <div class="col-4">
                        <img src="<?=$fetch['img_Autor']?>" class="img-thumbnail img-fluid">
                        </div>
                        <div class="col-8">
                            <form action="admin-autor-edit.php?edit&id=<?=$ID?>" method="POST">
                            <input type="text" name="autorID" class="form-control" value="<?=$ID?>" >
                            <label class="text-white" for="autorName">Imie</label>
                            <input type="text" name="autorName" class="form-control" id="autorName" placeholder="Podaj Imie" value="<?=$fetch['Name_Autor']?>" >
                            <label class="text-white" for="autorSName">Nazwisko</label>
                            <input type="text" name="autorSName" class="form-control" id="autorSName" placeholder="Podaj Nazwisko" value="<?=$fetch['SName_Autor']?>" >
                            <hr>
                            <label class="text-white" for="autorStatus">Status</label>
                            <input type="text" name="autorStatus" class="form-control" id="autorStatus" placeholder="Podaj Status" value="<?=$fetch['status_Autor']?>" >                                                        
                            <hr>
                            <label class="text-white" for="autorUserAdd">Kto Dodał</label>
                            <input type="text" name="autorUserAdd" class="form-control" id="autorUserAdd" placeholder="Podaj Nick" value="<?=$fetch['Nick']?>" >
                            <hr>
                            <label class="text-white" for="autorRating">Kto Dodał</label>
                            <input type="text" name="autorRating" class="form-control" id="autorRating" placeholder="Podaj Ocene" value="<?=$fetch['Ratind_Autor']?>" >
                            <hr>
                            <label class="text-white" for="autorTags">Tagi</label>
                            <input type="text" name="autorTags" class="form-control" id="autorTags" placeholder="Tagi" value="<?=$fetch['Tags_Autor']?>">
                            <small class="text-white" for="autorTags">do dodawania kolejych tagów stosuj znak hash "#"(podowiedz: #najlepszykomiks#Iron-man)</small>
                            <hr>
                            <label class="text-white" for="autorInfo">Informacje</label>
                            <textarea name="autorInfo" class="form-control" id="autorInfo" placeholder="Podaj tytuł"><?=$fetch['Info_Autor']?></textarea>
                            <hr>
                            <br>
                            <input class="btn btn-success fluid" type="submit" value="Zapisz">
                            </form>
                        </div>
                    </div>
                </div>
        
<!-- -----------------------------------------------</ TAB 1 >----------------------------------------------- -->
            </div>
        </div>
    </div>
</div>            
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="hints-autor.js"></script>
<?php
echo $end;

?>