<?php 
include("../principal/conectar_sea_web.php");

//"sea_con_lotes.php?mesl=" + f.mes.value + "&anol=" + f.ano.value +"&cmbanodos=" + f.cmbanodos.value
//////// Agregado por WSO ///////////
if(isset($_REQUEST["mesl"])) {
	$mesl = $_REQUEST["mesl"];
}else{
	$mesl = '';
}
if(isset($_REQUEST["anol"])) {
	$anol = $_REQUEST["anol"];
}else{
	$anol = '';
}

if(isset($_REQUEST["cmbanodos"])) {
	$cmbanodos = $_REQUEST["cmbanodos"];
}else{
	$cmbanodos = '';
}

if(isset($_REQUEST["txtlote"])) {
	$txtlote = $_REQUEST["txtlote"];
}else{
	$txtlote = '';
}

/////////////////////////////////////

?>


<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			Valores =  f.elements[i].value;
		}
	}
	return Valores;
}
//*********************//
function Enviar(f)
{
	var valor = ValidaSeleccion(f,'radio');
	window.opener.document.frmPrincipal.txtlote.disabled = false;
	window.opener.document.frmPrincipal.txtlote.value = valor;	
	window.opener.document.frmPrincipal.action = "sea_ing_lotes01.php?proceso=B";
	window.opener.document.frmPrincipal.submit();
	window.close();
}
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal"> 
<form name="form1" method="post" action="">
<?php 
	if (strlen($mesl) == 1)
			$mesl = "0".$mesl;
	
	$anob = substr($anol,2,2);
	$anob = "$anob$mesl%";
	//echo $anob;
?>
  <div style="position:absolute; left: 50px; top: 10px;" id="div1">
  <table width="500" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">
    <tr>
      <td height="25"><div align="center">Lotes Ingresados</div></td>
    </tr>
  </table>
  </div>
  <br>
  <div style="position:absolute; left: 50px; top: 50px;" id="div2">
  <table width="500" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">
    <tr>
      <td width="125" height="25"><div align="center">Lote Ventanas</div></td>
      <td width="125"><div align="center">Hornda Ventanas</div></td>
      <td width="125"><div align="center">Lote Origen</div></td>
      <td width="125"><div align="center">Marca</div></td>
    </tr>
  </table>
  </div>
  <br>
  <div style="position:absolute; left: 50px; top: 75px; width:518px; height:200px; OVERFLOW: auto;" id="div3">
  <table width="500" border="1" cellspacing="0" cellpadding="0" class="ColorTabla02">
  	<?php
		//$consulta = "SELECT * FROM relaciones WHERE cod_origen = '".$cmbanodos."' and lote_ventana like '".$anob."' ORDER BY lote_ventana ASC";
		$consulta = "SELECT * FROM relaciones WHERE cod_origen = '".$cmbanodos."' and lote_ventana like '".$txtlote."' ORDER BY lote_ventana ASC";
		//echo "Consulta:".$consulta;
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			echo '<tr>';
			echo '<td width="125" height="20"><input type="radio" name="radio" value="'.$row["lote_ventana"].'" onClick="JavaScript:Enviar(this.form)">'.$row["lote_ventana"].'</td>';
    		echo '<td width="125" align="center">'.substr($row["hornada_ventana"],6,6).'</td>';
      		echo '<td width="125" align="center">'.$row["lote_origen"].'</td>';
      		echo '<td width="125" align="center">'.$row["marca"].'</td></tr>';
		}
	?>
  </table>
  </div>
  <br>
  <div style="position:absolute; top: 280px; left: 50px;" id="div4">
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><div align="center">
            <input name="btnsalir" type="button" value="Salir" style="width:70" onClick="self.close()">
          </div></td>
    </tr>
  </table>
</div>


</form>

</body>
</html>
<?php include("../principal/cerrar_sea_web.php"); ?>
