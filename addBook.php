<?php
require('scriptPHP.php');
session_start();

function inputAutor()
{
    $inputAutor = 0;
    for ($i = 0; $i < 6; $i++) {
        if (isset($_POST['bookAutor' . $i . ''])) {
            $inputAutor++;
        }
    }
    return $inputAutor;
}

if (isset($_GET['delBack'])) {

    $id = $_GET['delBack'];
    $img = $_GET['img'];
    $task = "DELETE FROM Book WHERE Id_Book = $id";
    $query = mysqli_query($connect, $task);
    unlink($img);
    header("Location:addBook.php?del");
}

if (isset($_GET['addBook'])) {

    $inputAutor = inputAutor();
    $i = 0;
    $idAutor = '';
    while ($i < $inputAutor) {
        $exAutors = explode(',', $exConfirmBook[0]);

        $postName = 'bookAutor' . $i;
        $autor = explode(" ", $_POST[$postName]);
        $idAutor .= $autor[0] . ',';
        $i++;
    }
    $idAutor = substr($idAutor, 0, -1);
    $IdCategories = $_POST['bookCategories'];
    $task = "SELECT * FROM Categories WHERE Id_categories=$IdCategories";
    $query = mysqli_query($connect, $task);
    $fetch = mysqli_fetch_assoc($query);
    $catName = $fetch['Name_categories'];
    $bookTitle = $_POST['bookTitle'];
    $info = $_POST['bookInfo'];
    $bookTags = $_POST['bookTags'];
    $userId = $_SESSION['userId'];
    $patch = save_img('bookImg', $bookTitle, 'imgBook');
    echo $taskAdd = "INSERT INTO Book VALUES (NULL, '$idAutor', '$bookTitle', '$patch', $IdCategories, '$info', NULL, 0, $userId, '$bookTags')";
    $queryAdd = mysqli_query($connect, $taskAdd);

    $taskLast = "SELECT Id_Book FROM Book WHERE Book_user_Id = $userId ORDER BY Id_Book DESC LIMIT 1";
    $queryLast = mysqli_query($connect, $taskLast);
    $fetchLast = mysqli_fetch_assoc($queryLast);

    $ID = $fetchLast['Id_Book'];
    header("Location:rowBook.php?ID=$ID");
}

echo $nav;
?>

<div class="container">
    <?php

    $tabs = tabs('autorTab');

    ?>
    <script>
        var i = 1;

        function addField() {
            if (i < 6) {
                formFieldsDiv = document.getElementById('formFields');
                formFieldsDiv.innerHTML = formFieldsDiv.innerHTML + '<input type="text" name="bookAutor' + i + '" class="form-control" id="bookAutor" placeholder="Autor" value="" ></br>';
                formFieldsDiv.innerHTML = formFieldsDiv.innerHTML + '<input type="text" name="UnbookAutor' + i + '" class="form-control d-none" id="UnbookAutor" placeholder="Autor" value="" >';
                i++;
                hintsAutor();
            } else alert("Możesz dodać tylko 6 autorów");
        }
    </script>

    <div class="card text-center">

        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Książka</a>
                </li>

            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="myTabContent">

                <!-- -----------------------------------------------< TAB 1 >----------------------------------------------- -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?php
                    if (isset($_GET['del'])) {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:5px;">
                        Książka została usuniętaw
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        unset($_GET['del']);
                    }
                    ?>
                    <form method="post" action="addBook.php?addBook" enctype="multipart/form-data">

                        <label class="text-white" for="bookImg">Dodaj zdjęcie</label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bookImg" placeholder="wybierz" name="bookImg" value="<?= $imgSrc ?>" accept="image/*">
                                <label class="custom-file-label" for="bookImg" style="text-align:left">Wybierz plik</label>
                            </div>
                        </div>

                        <label class="text-white" for="bookTitle">Tytuł</label>
                        <input type="text" name="bookTitle" class="form-control" id="bookTitle" placeholder="Podaj tytuł" value="<?= $title ?>">
                        <hr>
                        <label class="text-white" for="bookAutor">Autor</label>
                        <input type="text" name="bookAutor0" class="form-control" id="bookAutor" placeholder="Autor" value="<?= $idAutor ?>">

                        <div id="formFields">
                            <a onclick="addField()" href="#">+ Dodaj kolejnego autora</a>
                        </div>
                        <hr>
                        <label class="text-white" for="bookCategories">Kategorie</label>
                        <select name="bookCategories" id="bookCategories" class="form-control">
                            <?php
                            $task2 = "SELECT * FROM `Categories`";
                            $query2 = mysqli_query($connect, $task2);
                            $categories = "<option $selected disabled>Wybierz Kategorie</option>";
                            while ($row = mysqli_fetch_assoc($query2)) {

                                if ($exConfirmBook['6'] == $row['Id_categories']) {
                                    $categories .= '<option selected value="' . $row['Id_categories'] . '">' . $row['Name_categories'] . '</option>';
                                } else  $categories .= '<option  value="' . $row['Id_categories'] . '">' . $row['Name_categories'] . '</option>';
                            }
                            echo $categories
                            ?>
                        </select>
                        <label class="text-white" for="bookTags">Tagi</label>
                        <input type="text" name="bookTags" class="form-control" id="bookTags" placeholder="Tagi" value="<?= $tags ?>">
                        <p class="text-white" for="bookTags">do dodawania kolejych tagów stosuj znak hash "#"(podowiedz: #najlepszykomiks#Iron-man)</p>
                        <label class="text-white" for="bookInfo">Opis książki</label>

                        <textarea name="bookInfo" class="form-control" id="bookInfo"><?= $info ?></textarea>

                        <label></label>
                        <input class="btn btn-success fluid" type="submit" value="Wyślij">

                    </form>
                </div>
                <!-- -----------------------------------------------</ TAB 1 >----------------------------------------------- -->
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="hints-autor.js"></script>
<?php echo $end;


?>