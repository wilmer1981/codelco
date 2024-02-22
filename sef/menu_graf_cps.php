<html>
<head><title>Menu - Horno Electrico</title>
<Script language=JavaScript>
function enviar(f)
{

  if (document.forms[0].radio1[0].checked)  //movimiento
    r = document.forms[0].radio1[0].value;  
  else if (document.forms[0].radio1[1].checked)  //peso
         r = document.forms[0].radio1[1].value;
  	          		    		     
  parametros = "fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value+"&radio1="+r+"&cod_eq="+f.cod_eq.value + "&cod_pro="+ f.cod_pro.value +"&opc="+f.opc.value+"&origen="+f.origen.value+"&num_cps="+f.num_cps.value;

  open("graficar_cps.php?"+parametros,"","toolbar=yes,directories=yes,menubar=yes,status=yes,resizable=yes");   
}
</Script>
</head>

<body>
<form name=form1 action="" method="post">
<div>Seleccione el dato a graficar</div>
<?
 
  echo "<input type=radio name=radio1 value=1 checked>Cantidad de Movimientos<br>";
  echo "<input type=radio name=radio1 value=2>Peso Movimiento<br>";
 
  echo "<br>";
?>

<?
  echo "<input type=hidden name=fecha_inicio value=$fecha_inicio>";
  echo "<input type=hidden name=fecha_final  value=$fecha_final>";
  echo "<input type=hidden name=opc value=$opc>";
  echo "<input type=hidden name=cod_eq value=$cod_eq>";
  echo "<input type=hidden name=cod_pro value=$cod_pro>";
  echo "<input type=hidden name=origen value=$origen>";
  echo "<input type=hidden name=num_cps value=$num_cps>";

?>
<input type=button value=Graficar onClick="JavaScript:enviar(this.form)">


</form>
</body>
</html>
