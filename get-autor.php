<?php


// if (!isset($_POST['idJos']) OR !isset($_POST['action'])) {
//     die('brak dostępu');
// }

include_once "scriptPHP.php";
// Pobierz dane o jednym firmaie
if ($_POST['action'] == 'getData') {
    $idautor = $_POST['idJos'];
    $task = "SELECT * FROM Autor WHERE Id_Autor=$idautor;";
    $query = mysqli_query($connect,$task);
    if (mysqli_num_rows($query) == 1) {
        die(json_encode(mysqli_fetch_assoc($query)));
    } else {
        die(json_encode(array('error'=>'Error with SQL query, no results.')));
    }
}
// Pobierz podpowiedzi
$lvl=$_SESSION['lvl'];

if ($_POST['action'] == 'getHints') {
    $task = "SELECT* FROM Autor";
    $query = mysqli_query($connect,$task);
    if (mysqli_num_rows($query) > 0) {
        $returnArray = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $returnArray[] =$row;
        }
        die(json_encode($returnArray));
    } else {
        die(json_encode(array('error'=>'Error with SQL query, no results.')));
    }
}