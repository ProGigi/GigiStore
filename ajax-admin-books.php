<?php
if (!isset($_POST['id']) OR !isset($_POST['ajax']) OR $_POST['ajax'] != 'edit') {
    die();
}

$id=$_POST['id'];
include_once "scriptPHP.php";

	$task = "SELECT * FROM Book 
	LEFT JOIN Categories ON Book.Book_Category = Categories.Id_Categories WHERE Id_Book = $id";
	$query=mysqli_query($connect,$task);
	$fetch=mysqli_fetch_assoc($query);
	$ID = $fetch['Id_Book'];
	$Book_Title = $fetch['Book_Title'];
	$Book_Category = $fetch['Book_Category'];
	$exAutors = explode(',',$fetch['Book_Id_Autor']);
	$autorInputs = '';
	foreach($exAutors AS $idAutor){
		$task2 = "SELECT * FROM Autor WHERE Id_Autor =$idAutor";
		$query2=mysqli_query($connect,$task2);
		$fetch2=mysqli_fetch_assoc($query2);
		$autorName = $fetch2['Name_Autor'].' '.$fetch2['SName_Autor'];

		$autorInputs .= '<div class="form-check">
		<input type="checkbox" class="form-check-input" id="autor'.$idAutor.'" name="autor'.$idAutor.'" value="a">
		<label for="autor'.$idAutor.'" class="form-check-label text-dark">'.$idAutor.' '.$autorName.'</label>
		</div>';

	}


$daneEmp=[];
$daneEmp['ID']=$ID;
$daneEmp['Book_Title']=$Book_Title;
$daneEmp['Book_Category']=$Book_Category;
$daneEmp['autors']=$autors;
$daneEmp['autorInputs']=$autorInputs;
    die(json_encode($daneEmp));
    
?>