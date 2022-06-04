<?php
//BUDOWANIE znaczników HTML
$title = "Książka adresowa";

$HTML_HEAD = '
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>'.$title.'</title>
    <link rel="Shortcut icon"  type="image/png" href="favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="css/own-style.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
';
/* <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> */
$HTML_SCRIPTS = '
    <script src="css/jquery-3.4.0.min.js"></script>

    <script src="css/popper.min.js"></script>

    <script src="css/bootstrap.min.js"></script> 

    <script src="css/jquery-ui.js"></script>
';
/* $HTML_SCRIPTS = '
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" 
    crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" 
    crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" 
    crossorigin="anonymous"></script>
'; */


$HTML_BG = 'background="tlo.png"';
$classSG = 'primary';
$classWp = 'primary';
$classDW = 'primary';
$classSlJ = 'primary';
$classSlT = 'primary';
// MENU
$href = $_SERVER['PHP_SELF'];
if($href == '/ksiazka_adresowa/index.php'){
    $classSG = 'warning';
}
if($href == '/ksiazka_adresowa/admin.php'){
    $classWp = 'warning';
}
if($href == '/ksiazka_adresowa/dodaj.php'){
    $classDW = 'warning';
}
if($href == '/ksiazka_adresowa/sl-jos.php'){
    $classSlJ = 'warning';
}
if($href == '/ksiazka_adresowa/sl-typ.php'){
    $classSlT = 'warning';
}

$nav = '<center>
<strong><span style="font-size:30px; color: white;">Książka adresowa - PANEL</span> <br /> </strong>
<h6 style="margin-top:5px;"><a href="index.php" class="badge badge-'.$classSG.'">Strona główna</a>
<a href="admin.php" class="badge badge-'.$classWp.'">Wpisy</a>
<a href="dodaj.php" class="badge badge-'.$classDW.'">Dodaj wpis</a>
<a href="sl-jos.php" class="badge badge-'.$classSlJ.'">Słownik JOS-ów</a>
<a href="sl-typ.php" class="badge badge-'.$classSlT.'">Słownik typów</a>
<a href="admin.php?logout" class="badge badge-danger">Wyloguj</a></h6>
</center>';
// END MENU

//FUNKCJE

function paginacja($href, $tab, $curPage, $NumOfPages){
    
    if($curPage<=1){
        $poprzednia = ' disabled';
    }else $poprzednia = ''; 

    if($curPage==$NumOfPages){
        $nastepna = 'disabled';
    }else $nastepna = ''; 

    if(isset($_GET['op'])){
        $op = "op=2&";
    }else $op = "";

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else $page = 0;

    $strony='';
    for($i=1;$i<=$NumOfPages;$i++){
        if(isset($_GET['page']) && $_GET['page'] == $i){
            $active = "active";
        }else $active = "";
        $strony .= '<li class="page-item '.$active.'"><a class="page-link" href="'.$href.'?page='.$i.'">'.($i).'</a></li>';
    }

    $paginacja= '
    <nav>
        <ul class="pagination justify-content-center">
            
        '.$strony.'
            
        </ul>
    </nav>
    ';

    echo $paginacja;

}
//karty akordeonu
function akord_card($lok, $cardName){
    include "connect.php";
    $where = '';
    $colaps = ' in';
    if(isset($_GET['szukaj'])){
        $fraza = $_GET['szukaj'];
        $where = "AND (imie LIKE '%$fraza%' OR nazwisko LIKE '%$fraza%' OR jos.nazwa LIKE '%$fraza%' OR jos.symbol LIKE '%$fraza%')";
        $colaps = " show";
        $_SESSION['fraza']=$fraza;
    }
    echo '<div class="card">
        <div class="card-header" role="tab" id="'.$lok.'" style="background-color: 	dfdfdf">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#akordeon-faq" href="#card-body-'.$lok.'"
                    aria-expanded="true" aria-controls="card-body-'.$lok.'">
                    '.$cardName.'
                </a>
            </h5>
        </div>

        <div id="card-body-'.$lok.'" class="collapse'.$colaps.'" role="tabpanel"
            aria-labelledby="card-head-'.$lok.'">
            <div class="card-body" style="padding-top:0; padding-right:0; background-color: dfdfdf">';
        $taskJos = "SELECT jos.symbol AS SYMBOL, wpisy.id_jos AS ID_JOS, jos.nazwa AS NAZWA_JOS, jos.email_gr AS EMAIL_GR, count(wpisy.id_jos) AS LICZNIK_WPISY 
        FROM wpisy 
        LEFT JOIN jos ON wpisy.id_jos = jos.id_jos 
        WHERE wpisy.lok='$lok' $where
        GROUP BY wpisy.id_jos";
        //echo $taskJos."<br";
        //echo "<br>lok: $lok<br>cardName:$cardName";
        echo '<div id="#jos" role="tablist" aria-multiselectable="true">';  
        $queryJos = mysqli_query($connect, $taskJos);
        while($fetchJos = mysqli_fetch_assoc($queryJos)){
            $idJos = $fetchJos['ID_JOS'];
            $nazwaJos = $fetchJos['NAZWA_JOS'];
            $emailJos = $fetchJos['EMAIL_GR'];

            if(strlen($fetchJos['SYMBOL'])>0){
                $symbol = '<b>'.$fetchJos['SYMBOL'].'</b> | ';
            }else $symbol = '';
            $mail_badge = '';
            if(strlen($nazwaJos)<1){
            break;
            }
            $counterJos = $fetchJos['LICZNIK_WPISY'];
            if(strlen($emailJos)>0){
                $mail_badge = '<a href="mailto:'.$emailJos.'" class="badge badge-primary" style="float:right;">'.$emailJos.'</a>';
            }
            
            echo 
            '
            
                <div class="card-header" role="tab" id="drugie" style="background-color: f4f4f4">
                    <h6 class="mb-0">
                        <a data-toggle="collapse" data-parent="#jos'.$lok.''.$idJos.'" href="#jos'.$lok.'-'.$idJos.'" aria-expanded="true" aria-controls="jos'.$lok.'-'.$idJos.'">
                            '.$symbol.$nazwaJos.'
                        </a>
                        '.$mail_badge.'
                    </h6>
                    <div id="jos'.$lok.'-'.$idJos.'" class="collapse in" role="tabpanel" aria-labelledby="drugie">
                        <div class="card-body"><table class="table table-responsive-sm table-bordered">
            ';

            $taskTyp = "SELECT wpisy.id_typ AS ID_TYP, typy.nazwa_typ AS NAZWA_TYP, count(wpisy.id_typ) AS LICZNIK_TYP FROM wpisy
            LEFT JOIN typy ON wpisy.id_typ = typy.id_typ 
            WHERE lok='$lok' AND wpisy.id_jos = $idJos GROUP BY wpisy.id_typ ORDER BY wpisy.id_typ";
            $queryTyp = mysqli_query($connect, $taskTyp);
            $poprzedniIdTyp='';
            while($fetchTyp = mysqli_fetch_assoc($queryTyp)){
                $idTyp = $fetchTyp['ID_TYP'];
                $nazwaTyp = $fetchTyp['NAZWA_TYP'];
                $counterTyp = $fetchTyp['LICZNIK_TYP'];

                $task = "SELECT * FROM wpisy
                 LEFT JOIN jos ON wpisy.id_jos = jos.id_jos
                 LEFT JOIN typy ON wpisy.id_typ = typy.id_typ  
                 WHERE lok='$lok' AND wpisy.id_jos=$idJos AND wpisy.id_typ=$idTyp $where";
                $query = mysqli_query($connect, $task);
                while($fetch=mysqli_fetch_assoc($query)){
                    $imie = $fetch['imie'];
                    $nazwisko = $fetch['nazwisko'];
                    $tel_wew = $fetch['tel_wew'];
                    $tel_kom = $fetch['tel_kom'];
                    $email_ind = $fetch['email_ind'];
                    if($idTyp == $poprzedniIdTyp){
                        $th = '';
                    }else $th = '<th rowspan="'.$counterTyp.'" style="margin: 0 auto; vertical-align: middle; ">'.$nazwaTyp.'</th>';
                    echo 
                        '    <tr>
                                '.$th.'
                                <td>'.$imie.' '.$nazwisko.'</td>
                                <td><a href="mailto:'.$email_ind.'">'.$email_ind.'</a></td>
                                <td>'.$tel_kom.'</td>
                                <td>'.$tel_wew.'</td>
                            </tr>
                    ';
                    $poprzedniIdTyp = $idTyp;
                }

            }
            echo "</table></div></div></div>";
        }
        echo'</div></div></div>';

}

//obsługa kart 
function carts(){

    if(isset($_GET['showTab3'])){
        $cardHeaderAriaSelTab_1=false;
        $cardHeaderAriaSelTab_2=false;
        $cardHeaderAriaSelTab_3=true;

        $cardHeaderClassTab_1="";
        $cardHeaderClassTab_2="";
        $cardHeaderClassTab_3="active";

        $cardBodyClassTab_1="";
        $cardBodyClassTab_2="";
        $cardBodyClassTab_3="show active";

        unset($_GET['showTab3']);

    } else
    if(isset($_GET['showTab2'])){
        $cardHeaderAriaSelTab_1=false;
        $cardHeaderAriaSelTab_2=true;
        $cardHeaderAriaSelTab_3=false;

        $cardHeaderClassTab_1="";
        $cardHeaderClassTab_2="active";
        $cardHeaderClassTab_3="";

        $cardBodyClassTab_1="";
        $cardBodyClassTab_2="show active";
        $cardBodyClassTab_3="";

        unset($_GET['showTab2']);
    
    }else{
        $cardHeaderAriaSelTab_1=true;
        $cardHeaderAriaSelTab_2=false;
        $cardHeaderAriaSelTab_3=false;

        $cardHeaderClassTab_1="active";
        $cardHeaderClassTab_2="";
        $cardHeaderClassTab_3="";

        $cardBodyClassTab_1="show active";
        $cardBodyClassTab_2="";
        $cardBodyClassTab_3="";
    }

}

?>