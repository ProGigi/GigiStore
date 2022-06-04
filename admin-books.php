<?php
require('scriptPHP.php');






if(isset($_GET['del'])){
    $id = $_POST['del_id'];

    $delTask = "DELETE FROM Book WHERE Id_Book=$id";
    $query = mysqli_query($connect, $delTask);
    //echo "<b>KWERENDA: </b>".$delTask;

    header("Location:admin-books.php?deleted");

}


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
                    <div class="col-12 text-white">
                <div class="row text-light bg-dark">
                    
                </div>
                <?php

                if (isset($_GET['added']))
                {
                    echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Pozycja została dodana do słownika</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                unset($_GET['added']);
                } 
                if (isset($_GET['edited']))
                {
                    echo '
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Zapisano zmiany</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                unset($_GET['edited']);
                } 
                if (isset($_GET['deleted']))
                    {
                        echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Pozycja została usunięta</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    unset($_GET['deleted']);
                    } 
                ?>
                
                
                <!-- LISTA JOS -->
                    <!-- WYSZUKIWARKA -->
                <form action="admin-books.php" method="GET">
                    <div class="input-group">
                        <?php
                        $where = '';
                        $value = '';
                        if(isset($_GET['szukaj'])){
                            $fr = $_GET['szukaj'];
                            $value = 'value="'.$fr.'"';
                            $where = " WHERE Book_Title LIKE '%$fr%'";
                        }
                        ?>
                        <input type="text" class="form-control form-control-sm" placeholder="Wpisz nazwę jednostki lub symbol"
                         name="szukaj" id="szukaj" aria-label="szukaj" aria-describedby="basic-addon2" <?=$value?>>
                        <div class="input-group-append">
                            <input class="btn btn-success btn-sm" type="submit" value="Szukaj">
                            <a href="admin-books.php" class="btn btn-danger btn-sm" type="button">&times;</a>
                        </div>
                        
                    </div>
                </form>
                <br>
                    <!-- END WYSZUKIWARKA -->
                <div class="table-responsive table-sm table-hover">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Tytuł</th>
                        <th>Kategoria</th>
                        <th>Status</th>
                        <th>Akcje</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        

                        $curPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $limit = 20; //Liczba wyników na stronę
                        $skip = (($curPage - 1) * $limit); //liczba pomijanych wierszy na potrzeby stronicowania
                        
                        $task = "SELECT * FROM Book 
                        LEFT JOIN Categories ON Book.Book_Category = Categories.Id_Categories 
                        LEFT JOIN Autor ON Book.Book_Id_Autor = Autor.Id_Autor $where";

                        $queryCount=mysqli_query($connect, $task);
                        $allRows = mysqli_num_rows($queryCount);
                        if ($allRows==0){
                            echo "BRAK WYNIKÓW";
                        }else
                    {
                        $NumOfPages = ceil($allRows / $limit); 
                        $task .= " LIMIT $skip, $limit";
                        $query=mysqli_query($connect,$task);
                        $i=$curPage*$limit-($limit-1);
                        //print_r("<br />".$task."<br />");
                        $lp=0;
                        $butStyle = "padding-top:0; padding-bottom:1px; margin:0; padding-left:5px; padding-right:5px; font-size:10px; height:16px;";
                        while($fetch=mysqli_fetch_assoc($query)){
                            echo '
                            <tr>
                                <th>'.$fetch['Id_Book'].'</th>
                                <td>'.$fetch['Book_Title'].'</td>
                                <td>'.$fetch['Name_categories'].'</td>
                                <td>'.$fetch['Status_Book'].'</th>
                                <td>
                                <a href="admin-book-edit.php?id='.$fetch['Id_Book'].'" role="button" aria-disabled="true" style="'.$butStyle.'" 
                                class="podpowiedz btn btn-warning btn-sm"><b>E</b>
                                <span class="border border-warning">Edytuj</span></a>

                                    <a href="#" role="button" aria-disabled="true" style="'.$butStyle.'" 
                                    class="podpowiedz btn btn-danger btn-sm open-delete-modal-with-id" id="'.$fetch['Id_Book'].'">
                                        &times;
                                        <span class="border border-danger">Usuń</span>
                                    </a>
                                </td>
                            </tr>
                            ';
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php //paginacja('admin-books.php', '1', $curPage, $NumOfPages) ?>
                <!-- MODALE -->
             <!-- -----------------MODAL usuwania rekordów-------------------------------------- -->
<div class="modal" id="deleteMod" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">USUWANIE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="admin-books.php?del" method="post" name="formDel" id="formDel">
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                    <div class="col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
                        </div>
                        <input id="del_id" hidden type="" name="del_id" value="">
                        <span class="input-group-text bg-dark text-white" id="del_span_id"></span>
                    </div>
                    </div>
                    </div>
                    <br />
                    <div class="row justify-content-md-center">
                        <div class="col">
                            <div class="alert alert-danger" role="alert">
                                <b><center>Napewno chcesz usunąć tą pozycje?<br><small style="color:red;"><u>UWAGA!! Ta operacja jest nieodwracalna!</u></small></center></b>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                        <input type="submit" id="delSubmit" name="delSubmit" class="btn btn-danger" value="Usuń">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Obsługa modala usuwania
    $(document).ready(function () {
        $('.open-delete-modal-with-id').on('click', function (event) {
            event.preventDefault();
            $('#del_id').val($(this).prop('id'));
            $('#del_span_id').text($(this).prop('id'));
            $('#deleteMod').modal('toggle');
        });
    });
</script>


            <!-- END MODALE -->
                </div>

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