<?

function cambiar ($cod)
{
  switch ($cod) {
    case 1 : $nom = "H. Basc.";
             break;
    case 2 : $nom = "H. Eléc.";
             break;
    case 3 : $nom = "H. Reten";	     
             break;
    case 4 : $nom = "H. Secado";
             break;
    case 5 : $nom = "CT";
             break;
    case 6 : $nom = "CPS ";
             break;
    case 7 : $nom = "CPS 1";
             break;
    case 8 : $nom = "CPS 2";
             break;
    case 9 : $nom = "CPS 3";
             break;
    case 10 : $nom = "Piso ";
              break;
    case 11 : $nom = "Pozo";
              break;
    case 12 : $nom = "R. Fuego";
              break;
    case 13 : $nom = "P. Acido";
              break;     
  }     
  return $nom;	     
}

function cambiar_unidad ($unidad)
{
  switch ($unidad){
    case 1: $nom = "Ollas";
            break;
    case 2: $nom = "T";
            break;
    case 3: $nom = "M3";
            break;   
    case 4: $nom = "ºC";
            break;
    case 5: $nom = "Hrs";
            break;
    case 6: $nom = "%";
            break;
    case 7: $nom = "Nm3";
            break;  	    
  }
  return $nom;
}

?>
