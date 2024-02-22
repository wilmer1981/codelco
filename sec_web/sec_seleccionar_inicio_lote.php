<?php 	
	include("../principal/conectar_sec_web.php");
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Valores2 = isset($_REQUEST["Valores2"])?$_REQUEST["Valores2"]:"";

	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$TxtIE=$Datos2[0];
		$PesoPreparado=$Datos2[7];
		$CodBulto=$Datos2[8];
		$NumBulto=$Datos2[9];
		$CodMarca=$Datos2[10];
	}
	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Valores,Valores2)
{
	var Frm=document.FrmSelecLoteIni;
	
	if (Frm.CmbLoteInicial.value=='-1')
	{
		alert('Debe Seleccionar Lote Inicio');
		Frm.CmbLoteInicial.focus();
		return;
	}	
	if (confirm('Esta Seguro de Grabar los Datos'))
	{
		Frm.action="sec_asignar_ie_virtual01.php?Valores="+Valores+"&Valores2="+Valores2;
		Frm.submit();
	}	
}

function Salir()
{
	window.close();
	
}
</script>
<title>Seleccionar Lote Inicio</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmSelecLoteIni" method="post" action="">
  <table width="375" height="185" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	<td align="center"><br>
		<table width="322" border="0" cellpadding="3" cellspacing="0" class="tablainterior">
          <tr>
		    <td align="center">Selecione Lote Inicial</td>
		  </tr>
		  <td align="center">
              <SELECT name="CmbLoteInicial" style="width:250">
		  	  <option value="-1" SELECTed>Seleccionar</option>
			  <?php
				if ($PesoPreparado!='')
				{
					
					$Consulta="SELECT descripcion from sec_web.marca_catodos where cod_marca='".$CodMarca."'";
					$Respuesta=mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Respuesta))
					{
						$Marca=$Fila["descripcion"];
					}
					echo "<option value='".$CodBulto."~~".$NumBulto."~~".$CodMarca."'>".$CodBulto."-".$NumBulto."&nbsp;&nbsp;Marca:&nbsp;".$Marca."</option>";										
				}
				$Datos=explode('//',$Valores2);
				foreach($Datos as $Clave => $Valor)
				{
					$Datos2=explode('~~',$Valor);
					$IEVirtual=$Datos2[0];
					$Consulta="SELECT cod_bulto,num_bulto,cod_marca";
					$Consulta=$Consulta." from sec_web.lote_catodo where corr_enm=".$IEVirtual." and cod_estado='a' ";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Consulta="SELECT descripcion from sec_web.marca_catodos where cod_marca='".$Fila["cod_marca"]."'";
					$Respuesta=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta))
					{
						$Marca=$Fila2["descripcion"];
					}
					echo "<option value='".$Fila["cod_bulto"]."~~".$Fila["num_bulto"]."~~".$Fila["cod_marca"]."'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."&nbsp;&nbsp;Marca:&nbsp;".$Marca."</option>";
				}			  
			  ?>
		  	  </SELECT></td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
		</table>
        <br><br>
		<table width="322" border="0" class="tablainterior">
          <tr>
			<td width="491" align="center">
			<input type="button" name="BtnOK" value="OK" style="width:70" onClick="Grabar('<?php echo $Valores;?>','<?php echo $Valores2;?>');">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
			</td>
		  </tr>
		</table>
	</td>
  </tr>
  </table>
</form>
</body>
</html>
