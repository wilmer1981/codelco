<?
 if ($CookieTipoUsuario == "1")
  {
  header("Location:Fundicion.php");
  } 
  elseif($CookieTipoUsuario == "2")
  {
  header("Location:Refino.php");
  }
  elseif($CookieTipoUsuario == "3")
  {
  header("Location:PlantaAcid.php");
  }
  elseif($CookieTipoUsuario == "4")
  {
  header("Location:TermOxig.php");
  } 
?>
