<?php
function sprawdz_bledy()
{
  if ($_FILES['zdj']['error'] > 0)
  {
    echo 'problem: ';
    switch ($_FILES['zdj']['error'])
    {
      // jest większy niż domyślny maksymalny rozmiar,
      // podany w pliku konfiguracyjnym
      case 1: {echo 'Rozmiar pliku jest zbyt duży.'; break;} 

      // jest większy niż wartość pola formularza 
      // MAX_FILE_SIZE
      case 2: {echo 'Rozmiar pliku jest zbyt duży.'; break;}

      // plik nie został wysłany w całości
      case 3: {echo 'Plik wysłany tylko częściowo.'; break;}

      // plik nie został wysłany
      case 4: {echo 'Nie wysłano żadnego pliku.'; break;}

      // pozostałe błędy
      default: {echo 'Wystąpił błąd podczas wysyłania.';
        break;}
    }
    return false;
  }
  return true;
}

function sprawdz_typ()
{
    if ($_FILES['zdj']['type'] != 'image/jpeg')
    {
        echo "zlyt typ";
		return false;
    }else
        {
        return true;
        echo "dobry";
        }
}
function zapisz_plik()
{
  $lokalizacja = './temp/plik_obrazkowy.jpeg';

  if(is_uploaded_file($_FILES['zdj']['tmp_name']))
  {
    if(!move_uploaded_file($_FILES['zdj']['tmp_name'], $lokalizacja))
    {
      echo 'problem: Nie udało się skopiować pliku do katalogu.';
        return false;  
    }
  }
  else
  {
    echo 'problem: Możliwy atak podczas przesyłania pliku.';
	echo 'Plik nie został zapisany.';
    return false;
  }
  return true;
}

sprawdz_bledy();
sprawdz_typ();
zapisz_plik();

?>

<form enctype="multipart/form-data" action="test1.php" 
		 method="post" >
<input type="hidden" name="MAX_FILE_SIZE" value="512000" />
<input type="file" name="zdj" />
<input type="submit" value="wyślij" />
</form>