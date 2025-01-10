<?php
include("../principal/conectar_pmn_web.php");

$Envio      = isset($_REQUEST["Envio"])?$_REQUEST["Envio"]:"";
$ValoresIE  = isset($_REQUEST["ValoresIE"])?$_REQUEST["ValoresIE"]:"";
$FechaEnvio = isset($_REQUEST["FechaEnvio"])?$_REQUEST["FechaEnvio"]:"";
$Ciudad = isset($_REQUEST["Ciudad"])?$_REQUEST["Ciudad"]:"";
$RutC   = isset($_REQUEST["RutC"])?$_REQUEST["RutC"]:"";
$SubCli = isset($_REQUEST["SubCli"])?$_REQUEST["SubCli"]:"";

$FechaEmbarque = isset($_REQUEST["FechaEmbarque"])?$_REQUEST["FechaEmbarque"]:"";
$Direccion     = isset($_REQUEST["Direccion"])?$_REQUEST["Direccion"]:"";

?>
<html>
<head>
<title>Lista de Transportista</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt,NumEnvio)//
{
	var f = document.frmConsulta;
	var Checkeo=false;
	switch (opt)
	{
		case "S":
			window.close();
		break;
		case "C":
			var Valores="";
			var ValoresIEAux="";
			for (i=1;i<f.RutTransporte.length;i++)
			{
				if (f.RutTransporte[i].checked == true)
				{
					Valores=Valores+ f.RutTransporte[i].value + "//";
					Checkeo=true;
				}
			}
			if(Checkeo==true)
			{
				Valores=Valores.substr(0,Valores.length-2);
				f.action="sec_autorizacion_despacho01.php?Envio="+NumEnvio+"&Ciudad="+f.CiudadAux.value+"&Direccion="+f.DireccionAux.value+"&Rut="+f.RutClienteAux.value+"&SubCliente="+f.SubClienteAux.value+"&FechaEmb="+f.FechaEmbarqueAux.value+"&Valores="+Valores+"&ValoresIEAux="+ValoresIEAux+"&Proceso=Transporte";
				f.submit();
			}
			else
			{
				alert("Debe Seleccion un elemento");
			}
			break;
	}
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
<input name="ValoresIEAux" type="hidden" value="<?php echo $ValoresIE  ?>">
<input name="FechaEmbarqueAux" type="hidden" value="<?php echo $FechaEmbarque  ?>">
<input name="CiudadAux" type="hidden" value="<?php echo $Ciudad  ?>">
<input name="DireccionAux" type="hidden" value="<?php echo $Direccion  ?>">
<input name="RutClienteAux" type="hidden" value="<?php echo $RutC  ?>">
<input name="SubClienteAux" type="hidden" value="<?php echo $SubCli  ?>">
  <br>
<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>
      <td width="343"><div align="center"> &nbsp; 
          <input name="btnAceptar" type="button" id="btnAceptar" style="width:70px" onClick="Proceso('C',<?php echo $Envio  ?>);" value="Aceptar">
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="666" border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>
    <?php  
	echo "<tr>\n";
	$Consulta=" SELECT rut_transportista,nombre_transportista from ";
 	$Consulta.=" sec_web.transporte  group by rut_transportista ";
    $Consulta.=" order by nombre_transportista ";
	$Respuesta = mysqli_query($link, $Consulta);

	$cont=1;	
	echo "<input type='hidden' name='RutTransporte'>";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		if($cont==6) 
		{
			echo '</tr>';
			echo '<tr>';
			$cont=1;
		}
		//echo "<input type='radio'  name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E');\">\n";
		//echo "<td><input type='checkbox' name='RutTransporte' value='".$Row["rut_transportista"]."'>\n";
		echo "<td><input type='radio' name='RutTransporte' value='".$Row["rut_transportista"]."'>\n";
		echo $Row["nombre_transportista"]."</td>";
		$cont =$cont+ 1;
	}
?>
  </table>
</form>
</body>
</html>
