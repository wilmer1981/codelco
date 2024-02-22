<html>
<head><title>Menu - Horno Electrico</title>
<Script language=JavaScript>
function enviar(f)
{

  if (document.forms[0].radio1[0].checked)  //movimiento
    r = document.forms[0].radio1[0].value;  
  else if (document.forms[0].radio1[1].checked)  //peso
         r = document.forms[0].radio1[1].value;
  	   
   
  if ((f.ley.value == 1) || (f.ley.value == 2))
  {
    if (document.forms[0].radio1[2].checked)  //cobre
      r = document.forms[0].radio1[2].value;  
  }    

  if (f.ley.value == 2) 
  {
    if (document.forms[0].radio1[3].checked)  //azufre
      r = document.forms[0].radio1[3].value;
    if (document.forms[0].radio1[4].checked)  //fierro
      r = document.forms[0].radio1[4].value;
    if (document.forms[0].radio1[5].checked)  //silice
      r = document.forms[0].radio1[5].value;
    if (document.forms[0].radio1[6].checked)  //magnetita
      r = document.forms[0].radio1[6].value;
  }		     
		    
		     
  parametros = "fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value+"&radio1="+r+"&cod_eq="+f.cod_eq.value + "&cod_pro="+ f.cod_pro.value +"&opc="+f.opc.value;

  if (f.opc.value == 1)
     parametros = parametros + "&destino=" + f.destino.value;

  open("graficar_he.php?"+parametros,"","toolbar=yes,directories=yes,menubar=yes,status=yes,resizable=yes");   
}
</Script>
</head>

<body>
<form name=form1 action="" method="post">
<div>Seleccione el dato a graficar</div>
<?
 
  echo "<input type=radio name=radio1 value=1 checked>Cantidad de Movimientos<br>";
  echo "<input type=radio name=radio1 value=2>Peso Movimiento<br>";
 
  if (($ley == 1) or ($ley == 2))
  {
    echo "<input type=radio name=radio1 value=3>Cobre<br>";
  }  
    
  if ($ley == 2)
  {
    echo "<input type=radio name=radio1 value=4>Azufre<br>";
    echo "<input type=radio name=radio1 value=5>Fierro<br>";
    echo "<input type=radio name=radio1 value=6>Silice<br>";
    echo "<input type=radio name=radio1 value=7>Magnetita<br>";
  }
  echo "<br>";
?>

<?
  echo "<input type=hidden name=fecha_inicio value=$fecha_inicio>";
  echo "<input type=hidden name=fecha_final  value=$fecha_final>";
  echo "<input type=hidden name=opc value=$opc>";
  echo "<input type=hidden name=ley value=$ley>";
  echo "<input type=hidden name=cod_eq value=$cod_eq>";
  echo "<input type=hidden name=cod_pro value=$cod_pro>";
  if ($opc == 1)
    echo "<input type=hidden name=destino value=$destino>";

?>
<input type=button value=Graficar onClick="JavaScript:enviar(this.form)">


</form>
</body>
</html>
