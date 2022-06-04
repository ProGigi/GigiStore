<?php
require('scriptPHP.php');

if(isset($_GET['addAutor']) || isset($_GET['addAutor1'])){

    if(isset($_GET['addAutor1'])) {
        $autorName = $_POST['autorName'];
        $autorSName = $_POST['autorSName'];
        $info = $_POST['autorInfo'];
        $userId = $_SESSION['userId'];
        $patch=$_POST['autorImg'];
        $task = "INSERT INTO `Autor` VALUES (null,'$autorName','$autorSName','$patch','$info',null,1,$userId)";
        $query = mysqli_query($connect, $task);
        $_SESSION['zdj']= $patch;
        header("Location:addNew.php?autorAdded&autorTab");
        $_SESSION['autorTab'] = true;
    
    }
    
    if(isset($_GET['addAutor'])){
        $autorName = $_POST['autorName'];
        $autorSName = $_POST['autorSName'];
        $info = $_POST['autorInfo'];
        $userId = $_SESSION['userId'];
        $patch=save_img('autorImg', $autorName.$autorSName, 'imgAutor');
        $_SESSION['autorData']=$autorName.'~'.$autorSName.'~'.$info.'~'.$patch;
        header("Location:addNew.php?confirmAutor&autorTab");
        $_SESSION['autorTab'] = true;
    }




}else header("Location:index.php");
?>