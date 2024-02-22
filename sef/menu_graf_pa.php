<html>
<head><title>Menu - Planta de Acido</title>
<Script language=JavaScript>
function enviar(f)
{
  if (document.forms[0].radio1[0].checked)
    r = document.forms[0].radio1[0].value;  
  else if (document.forms[0].radio1[1].checked)  
         r = document.forms[0].radio1[1].value;
       else if (document.forms[0].radio1[2].checked)  
              r =document.forms[0].radio1[2].value;
	    else if (document.forms[0].radio1[3].checked)  
                   r = document.forms[0].radio1[3].value;
  
  open("graficar_pa.php?fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value+"&radio1="+r,"","toolbar=yes,directories=yes,menubar=yes,status=yes,resizable=yes");   
}
</Script>
</head>

<body>
<form name=form1 action="" method="post">
<div>Seleccione el dato a graficar</div>

<input type=radio name=radio1 value=1 checked>Caudal<br>
<input type=radio name=radio1 value=2>Horas Op.<br>
<input type=radio name=radio1 value=3>Azufre<br>
<input type=radio name=radio1 value=4>Producción<br>
<br>
<?
  echo "<input type=hidden name=fecha_inicio value=$fecha_inicio>";
  echo "<input type=hidden name=fecha_final  value=$fecha_final>";
?>
<input type=button value=Graficar onClick="JavaScript:enviar(this.form)">


</form>
</body>
</html>
