<?php
 	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPopUp;
	
	f.action = "pmn_ing_corte_lixiviacion_recepcion_popup.php?recargapag1=S";
	f.submit();
}
/*****************/
function Chequear(r)
{		
	var f = document.frmPopUp;

	var linea = 'ano1='+ f.ano.value + '&mes1=' + f.mes.value + '&num=' + r.value; 

	window.opener.document.frmPrincipal.action = "pmn_ing_corte_lixiviacion_recepcion.php?opc=B&" + linea;
	window.opener.document.frmPrincipal.submit();
	window.close();
}
/*****************/
function Salir()
{
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
  <br>
  <table width="500" height="25" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td align="center">Datos De Corte De N&ordm; Lixiaciones Para Listado De 
        Recepcion</td>
    </tr>
  </table>

  <br>
  <table width="500" height="25" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="195">Fecha</td>
      <td width="290"> 
        <?php
  		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  ?>
        <select name="mes" size="1">
          <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
        </select> <select name="ano" size="1">
          <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
        </select> &nbsp; <input name="btnbuscar" type="button" id="btnbuscar" value="Buscar" onClick="Recarga1()"></td>
    </tr>
  </table>
  <br>
  <table width="500" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr class="ColorTabla01">
      <td width="252" align="center">Fecha</td>
      <td width="342" align="center">N&ordm; Lixiviacion</td>
    </tr>
<?php
	$consulta = "SELECT * FROM pmn_web.corte_lixiviacion";	
	$consulta.= " WHERE fecha = '".$ano.'-'.$mes."-01'";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
    	echo '<tr>';
      	echo '<td><input type="radio" name="radiobutton" value="'.$row[num_lixiviacion].'" onClick="Chequear(this)">'.$row["fecha"].'</td>';
      	echo '<td align="center">'.$row[num_lixiviacion].'</td>';
    	echo '</tr>';
	}
?>	

</table>
    
  <br>
  <table width="500" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr>
    <td align="center"><input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>  
</form>
</body>
</html>
