<html>
<head><title>Menu - Convertidor Teniente</title>
<Script language=JavaScript>
function enviar(f)
{
  open("graficar_t_ct.php?fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value+"&cod_eq="+f.cod_eq.value,"","toolbar=yes,directories=yes,menubar=yes,status=yes,resizable=yes");   
}
</Script>
</head>

<body>
<form name=form1 action="" method="post">
<div>Seleccione el dato a graficar</div>

<input type=radio name=radio1 value=1 checked>Hrs. Desconexion<br>
<br>
<?
  echo "<input type=hidden name=fecha_inicio value=$fecha_inicio>";
  echo "<input type=hidden name=fecha_final  value=$fecha_final>";
  echo "<input type=hidden name=cod_eq value =$cod_eq>";
?>
<input type=button value=Graficar onClick="JavaScript:enviar(this.form)">


</form>
</body>
</html>

