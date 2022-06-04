<?php 
// ini_set( 'display_errors', 'On' ); 
// error_reporting( E_ALL );
require('scriptPHP.php');
$exConfirmBook = [];
$exConfirmAutor = [];

if(isset($_GET['confirm'])){
    $exConfirmBook = explode('~', $_SESSION['bookData']);
    $exAutors = explode(',',$exConfirmBook[0]);
    $i = 0;
    $autorInputs = '';
    foreach($exAutors AS $autorArr){
        $exAutor = explode(':',$autorArr);
        $idAutor = $exAutor[0];
        $nameAutor = $exAutor[1];
        $input1 = 'bookAutor'.$i;
        $autorInputs .= '<label class="text-white" for="'.$input1.'">Imie i Nazwisko Autora</label>
        <input type="text" name="'.$input1.'" class="form-control d-none" id="'.$input1.'"value="'.$idAutor.'">
          
        <input type="text" name="bookAutorName" class="form-control" id="bookAutorName"value="'.$nameAutor.'" readonly>';
    }
}
if(isset($_GET['back']))
{
    $bookData = $_SESSION['bookData'];
    $exConfirmBook = explode('~', $bookData);
    unset($_SESSION['bookData']);
}

if(isset($_GET['confirmAutor'])){
    $exConfirmAutor = explode('~', $_SESSION['autorData']);
   
}
if(isset($_GET['backAutor']))
{
    $autorData = $_SESSION['autorData'];
    $exConfirmAutor = explode('~', $autorData);
    unset($_SESSION['autorData']);
}





 //szybkie wyświetlanie kategorii
 $task2 = "SELECT * FROM `Categories`";
 $query2 = mysqli_query($connect, $task2);
 $selected = "selected";
 if(isset($_GET['back']))
 {
     $selected = "";
 }

 $categories ="<option $selected disabled>Wybierz Kategorie</option>";
 while($row = mysqli_fetch_assoc($query2))
 {

     if($exConfirmBook['6']==$row['Id_categories'])
     {
     $categories .= '<option selected value="'.$row['Id_categories'].'">'.$row['Name_categories'].'</option>';
     }else  $categories .= '<option  value="'.$row['Id_categories'].'">'.$row['Name_categories'].'</option>';


 }


 $formBook = '<form method="post" action="addBook.php?addBook" enctype="multipart/form-data">

<label class="text-white" for="bookImg">Dodaj zdjęcie</label>
<div class="input-group mb-3">
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="bookImg" placeholder="wybierz" name="bookImg" value="'.$exConfirmBook['3'].'" accept="image/*" >
        <label class="custom-file-label" for="bookImg" style="text-align:left">Wybierz plik</label>
    </div>
</div>

    <label class="text-white" for="bookTitle">Tytuł</label>
    <input type="text" name="bookTitle" class="form-control" id="bookTitle" placeholder="Podaj tytuł" value="'.$exConfirmBook['1'].'" >

    <label class="text-white" for="bookAutor">Autor</label>
    <input type="text" name="bookAutor" class="form-control" id="bookAutor" placeholder="Autor" value="'.$exConfirmBook['0'].' '.$exConfirmBook['4'].'" >
    <input type="text" name="UnbookAutor" class="form-control d-none" id="UnbookAutor" placeholder="Autor" value="'.$exConfirmBook['0'].'" >
    <div id="formFields">
    <a onclick="addField()" href="#">+ Dodaj kolejnego autora</a>
    </div>
    <label class="text-white" for="bookCategories">Kategorie</label>
    <select name="bookCategories" id="bookCategories" class="form-control"  >          
            '.$categories.'	
    </select>
    <label class="text-white" for="bookTags">Tagi</label>
    <input type="text" name="bookTags" class="form-control" id="bookTags" placeholder="Tagi" value="'.$exConfirmBook['7'].'">
    <p class="text-white" for="bookTags">do dodawania kolejych tagów stosuj znak hash "#"(podowiedz: #najlepszykomiks#Iron-man)</p>
    <label class="text-white" for="bookInfo">Opis książki</label>
    
    <textarea name="bookInfo" class="form-control"  id="bookInfo"  >'.$exConfirmBook['2'].'</textarea>

    <label></label>
    <input class="btn btn-success fluid" type="submit" value="Wyślij">

</form>
';
 
$confBook  = '
    <form method="post" action="addBook.php?addBook1">
        <input type="text"  class="d-none" id="bookImg" value="'.$exConfirmBook['3'].'" name="bookImg">
        <div class="row">
            <div class="col-3">
                <img src="'.$exConfirmBook['3'].'" class="img-fluid">
            </div>
            <div class="col-9 ">
                <label class="text-white" for="bookTitle">Tytuł</label>
                <input type="text" name="bookTitle" class="form-control" id="bookTitle" value="'.$exConfirmBook['8'].'"
                    readonly>
                '.$autorInputs.'
                    <label class="text-white" for="bookCategories">Kategoria</label>
                    <input type="text" name="bookCategories" class="form-control" id="bookCategories"   value="'.$exConfirmBook['5'].'" readonly>
                    <label class="text-white" for="bookTags">Tagi</label>
                    <input type="text" name="bookTags" class="form-control" id="bookTags" placeholder="Tagi" value="'.$exConfirmBook['7'].'" readonly>
                    <label class="text-white" for="bookInfo">Opis Książki</label>
                    <textarea name="bookInfo" class="form-control" id="bookInfo" placeholder="dodaj opis" readonly>'.$exConfirmBook['2'].'</textarea>
                    <label></label>
               
                
                    <input class="btn btn-success fluid" type="submit" value="Wyślij">
    
                    <a class="btn btn-danger" href="addNew.php?back">Anuluj</a>
            </div>
        </div>
    </form>
    ';

   
$formAutor= '<form method="post" action="addAutor.php?addAutor" enctype="multipart/form-data">

<label class="text-white" for="autorImg">Dodaj zdjęcie</label>
<div class="input-group mb-3">
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="autorImg" placeholder="wybierz" name="autorImg" accept="image/*" >
        <label class="custom-file-label" for="autorImg" style="text-align:left">Wybierz plik</label>
    </div>
</div>

    <label class="text-white" for="autorName">Imię</label>
    <input type="text" name="autorName" class="form-control" id="autorName" placeholder="Podaj imię autora" value="'.$exConfirmAutor['0'].'" >

    <label class="text-white" for="autorSName">Nazwisko</label>
    <input type="text" name="autorSName" class="form-control" id="autorSName" placeholder="Podaj nazwisko autora" value="'.$exConfirmAutor['1'].'" >
    <label class="text-white" for="autorTags">tagi</label>
    <input type="text" name="autorTags" class="form-control" id="autorTags" placeholder="Tagi" value="">
    <p class="text-white" for="autorTags">do dodawania kolejych tagów stosuj znak hash "#"(podowiedz: #najlepszyAutor#mistrz)</p>

    <label class="text-white" for="autorInfo">Opis autora</label>
    
    <textarea name="autorInfo" class="form-control"  id="autorInfo" >'.$exConfirmAutor['2'].'</textarea>

    <label></label>
    <input class="btn btn-success fluid" type="submit" value="Wyślij">

</form>
';
if(isset($exConfirmAutor)){


$confAutor ='
<form method="post" action="addAutor.php?addAutor1">
<input type="text"  class="d-none" id="autorImg" value="'.$exConfirmAutor['3'].'" name="autorImg">
<div class="row">
<div class="col-3">
    <img src="'.$exConfirmAutor['3'].'" class="img-fluid">
</div>
<div class="col-9 ">
        <label class="text-white" for="autorName">Imie</label><input type="text" name="autorName" class="form-control"
        id="autorName" value="'.$exConfirmAutor['0'].' " readonly><label class="text-white" for="autorSName">Nazwisko</label><input
        type="text" name="autorSName" class="form-control" id="autorSName" value="'.$exConfirmAutor['1'].'"  readonly><label
        class="text-white" for="autorInfo">Opis
        Autora</label><textarea name="autorInfo" class="form-control" readonly id="autorInfo"
        >'.$exConfirmAutor['2'].' </textarea><label></label> 
        <div class="btn-group mr-2" role="group" aria-label="Trzecia grupa">
        <input type="submit" class="btn btn-success" value="Zapisz">
        <a href="addNew.php?backAutor&autorTab" type="button" class="btn btn-warning"> Cofnij</a>
      </div>
</div>
</div>

</form>';
}

echo $nav;
?>

<div class="container">
    <?php

    $tabs = tabs('autorTab');

    ?>
    <script>

var i = 0;
function addField() {
if(i<5)
{
formFieldsDiv = document.getElementById('formFields');
formFieldsDiv.innerHTML =  formFieldsDiv.innerHTML+'<input type="text" name="bookAutor'+i+'" class="form-control" id="bookAutor" placeholder="Autor" value="" ></br>';
formFieldsDiv.innerHTML =  formFieldsDiv.innerHTML+'<input type="text" name="UnbookAutor'+i+'" class="form-control d-none" id="UnbookAutor" placeholder="Autor" value="" >';
i++;
hintsAutor();
}
else alert("Możesz dodać tylko 6 autorów");
}

</script>

    <div class="card text-center">

        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo $tabs['cardHeaderClassTab_1'];?>" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="<?php echo $tabs['cardHeaderAriaSelTab_1']; ?>">Książka</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $tabs['cardHeaderClassTab_2'];?>" id="view-tab-1" data-toggle="tab" href="#view1" role="tab" aria-controls="view1"
                    aria-selected="<?php echo $tabs['cardHeaderAriaSelTab_2']; ?>">Autor</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="myTabContent">

<!-- -----------------------------------------------< TAB 1 >----------------------------------------------- -->
                <div class="tab-pane fade <?php echo $tabs['cardBodyClassTab_1'];?>" id="home" role="tabpanel" aria-labelledby="home-tab">
                <?php
                if(isset($_GET['bookAdded'])){
                    echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:5px;">
                    Książka została dodana
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                    unset($_GET['bookAdded']);
                }

                
                        if(isset($_GET['confirm'])){
                           
                            echo $confBook;
                        }else echo $formBook;

                    ?>
                </div>
<!-- -----------------------------------------------</ TAB 1 >----------------------------------------------- -->


<!-- -----------------------------------------------< TAB 2 >----------------------------------------------- -->
                <div class="tab-pane fade <?php echo $tabs['cardBodyClassTab_2'];?>" id="view1" role="tabpanel" aria-labelledby="view-tab-1">
                <?php
                if(isset($_GET['autorAdded'])){
                    echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:5px;">
                      Autor został dodany
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
                    unset($_GET['autorAdded']);
                  }
                        if(isset($_GET['confirmAutor']))
                        {
                            echo $confAutor;
                        }else echo $formAutor;
                        ?>
                </div>
<!-- -----------------------------------------------</ TAB 2 >----------------------------------------------- -->

            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="hints-autor.js"></script>
<?php echo $end;


?>