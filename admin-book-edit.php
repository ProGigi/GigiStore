<?php
require('scriptPHP.php');

if(!isset($_GET['id'])){

    die('brak dostępu');
        
}
$ID = $_GET['id'];
if(isset($_GET['edit'])){
    $idBook = $_POST['bookID'];
    $i=NULL;
    $title = $_POST['bookTitle'];
    $category = $_POST['bookCategories'];
    $tags = $_POST['bookTags'];
    $autors = '';
    while($i <= 5){
        $postName = 'bookAutor'.$i;
        if(isset($_POST[$postName])){
            $exAutorID = explode(' ',$_POST[$postName]);

            $autors .= $exAutorID['0'].',';
        }
        $i++;
    }
$autors = substr($autors, 0, -1);
    $task = "UPDATE Book SET Book_Title = '$title', Book_Category = $category, Book_Id_Autor = '$autors' WHERE Id_Book= $idBook";
    echo $task;
    $queryUpdate = mysqli_query($connect,$task);
}




$task = "SELECT * FROM Book WHERE Id_Book = $ID";
$query = mysqli_query($connect, $task);
$fetch = mysqli_fetch_assoc($query);

$exAutors = explode(',',$fetch['Book_Id_Autor']);
$a = NULL;
$autorInputs = '';
	foreach($exAutors AS $idAutor){
		$task2 = "SELECT * FROM Autor WHERE Id_Autor =$idAutor";
		$query2=mysqli_query($connect,$task2);
		$fetch2=mysqli_fetch_assoc($query2);
		$autorName = $fetch2['Name_Autor'].' '.$fetch2['SName_Autor'];

		$autorInputs .= '<input type="text" class="form-control" id="bookAutor'.$a.'" name="bookAutor'.$a.'" value="'.$idAutor.' '.$autorName.'">';
        $a++;
	}

echo $nav;
?>
<script>

var i = 6;
function addField() {
if(i<12)
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
                        <img src="<?=$fetch['Img_Book']?>" class="img-thumbnail img-fluid">
                        </div>
                        <div class="col-8">
                            <form action="admin-book-edit.php?edit&id=<?=$ID?>" method="POST">
                            <input type="text" name="bookID" class="form-control" value="<?=$ID?>" >
                            <label class="text-white" for="bookTitle">Tytuł</label>
                            <input type="text" name="bookTitle" class="form-control" id="bookTitle" placeholder="Podaj tytuł" value="<?=$fetch['Book_Title']?>" >
                            <hr>
                            <label class="text-white" for="bookAutor">Autorzy</label>
                            <?=$autorInputs?>
                            <div id="formFields">
                                <a onclick="addField()" href="#">+ Dodaj kolejnego autora</a>
                            </div>
                            <hr>
                            <label class="text-white" for="bookCategories">Kategorie</label>
                            <select name="bookCategories" id="bookCategories" class="form-control"  >          
                            <?php 
                                $task2 = "SELECT * FROM `Categories`";
                                $query2 = mysqli_query($connect, $task2);
                                
                                $categories ="<option disabled>Wybierz Kategorie</option>";
                                while($row = mysqli_fetch_assoc($query2))
                                {
                                    $sel = '';
                                    if($row['Id_categories']==$fetch['Book_Category']){
                                        $sel = 'selected';
                                    }
                                    $categories .= '<option '.$sel.' value="'.$row['Id_categories'].'">'.$row['Name_categories'].'</option>';
                                }
                                echo $categories;
                            ?>
                            </select>
                            <label class="text-white" for="bookTags">Tagi</label>
                            <input type="text" name="bookTags" class="form-control" id="bookTags" placeholder="Tagi" value="">
                            <small class="text-white" for="bookTags">do dodawania kolejych tagów stosuj znak hash "#"(podowiedz: #najlepszykomiks#Iron-man)</small>
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