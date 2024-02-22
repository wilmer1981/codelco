<?php include("../principal/conectar_pmn_web.php");

if(!isset($MesIniCon))
	$MesIniCon=date('m');
if(!isset($AnoIniCon))
	$AnoIniCon=date('Y');
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt,H)//Opcion y la ornada
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
			break;
		case "B":
			f.action="pmn_ing_circulantes_oxidos2.php";
			f.submit();
		break;
		
	}
}

function CargaDatos(Fecha)
{
	var f = document.frmConsulta;
	window.opener.document.frmPrincipalRpt.action="pmn_principal_reportes.php?Tab13=true&DatoModifi="+Fecha+"&Mod=S";
	window.opener.document.frmPrincipalRpt.submit();
	window.close();
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<table width="60%" height="20" border="0">
  <tr>
      <td class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">Detalle oxidos plata cobre </strong></td>
  </tr>
</table>
<table width="60%" border="0" >
  <tr>
    <td width="105" class="titulo_azul">Fecha Incio</td>
    <td width="672"><select name="MesIniCon" style="width:90px;">
          <?php
	 for ($i=1;$i<=12;$i++)
	{
		if (isset($MesIniCon))
		{
			if ($i == $MesIniCon)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if ($i == $MesActual)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
	  ?>
        </select>
        <select name="AnoIniCon" style="width:60px;">
          <?php
	 for ($i=2002;$i<=date("Y");$i++)
	{
		if (isset($AnoIniCon))
		{
			if ($i == $AnoIniCon)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i == $AnoActual)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
	?>
      </select></td>
    </tr>
</table>
<br>
<table width="60%" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>  <td width="343"><div align="center"> 
        <input type="button" name="btnCerrar2" value="Consultar" onClick="Proceso('B');" style="width:70px">
        &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="60%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="TituloCabeceraAzul"> 
      <td width="34">&nbsp;</td>
      <td width="36">D&iacute;a</td>
      <td width="74"><strong>Hora</strong></td>
      <td width="154">Producto</td>
      <td width="205">Subproducto</td>
      <td width="86">Valor</td>
      <td width="182"><strong>Funcionario</strong></td>
    </tr>
    <?php  
		  for($K=1;$K<=31;$K++)
		  {
		  	//echo $K."<br>";		
		  
				$ConsultaP = "select * from pmn_web.produccion_circulantes_oxidos ";
				$ConsultaP.= " where year(fecha)='".$AnoIniCon."' and month(fecha)='".$MesIniCon."' and day(fecha)='".$K."'";
				//echo $ConsultaP."<br>";
				//echo $ConsultaP."<br>";
				$RespuestaP = mysqli_query($link, $ConsultaP);
				while ($Filas = mysqli_fetch_array($RespuestaP))
				{
					$Dia=substr($Filas["fecha"],0,10);
					$Dia=explode('-',$Dia);
					$Hora=substr($Filas["fecha"],11,20);		
					?>	
				  <tr>
					<td align="center" bgcolor="#CCCCCC"><input type='radio' class='SinBorde' name='Check' value='<?php echo $Filas["fecha"]?>' onClick="CargaDatos('<?php echo $Filas["fecha"]?>')"></td>
					<td align="center" bgcolor="#CCCCCC"><?php echo $Dia[2];?></td>
					<td align="center" bgcolor="#CCCCCC"><?php echo $Hora;?></td>
					<?php
					$Consulta3 = "select * from proyecto_modernizacion.productos where cod_producto ='".$Filas["cod_producto"]."'";
					//echo "producto:     ".$Consulta3."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Producto=$Row3["descripcion"]
					?>
					<td align="left" bgcolor="#CCCCCC"><?php echo ucwords(strtolower($Producto));?>&nbsp;</td>
					<?php
					$Consulta3 = "select * from proyecto_modernizacion.subproducto where cod_producto ='".$Filas["cod_producto"]."' and cod_subproducto='".$Filas["cod_subproducto"]."'";
					//echo "Subproducto:     ".$Consulta3."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Subproducto=$Row3["descripcion"]
					?>
					<td align="left" bgcolor="#CCCCCC"><?php echo ucwords(strtolower($Subproducto));?>&nbsp;</td>
					<td align="right" bgcolor="#CCCCCC"><?php echo number_format($Filas["valor"],2,',','.');?>&nbsp;</td>
					<?php
					$Consulta3 = "select * from proyecto_modernizacion.funcionarios where rut ='".$Filas[rut]."'";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Funcionario=$Row3["apellido_paterno"]." ".$Row3["apellido_materno"]." ".$Row3["nombres"]
					?>
					<td align="left" bgcolor="#CCCCCC"><?php echo ucwords(strtolower($Funcionario));?>&nbsp;</td>
				  </tr>
					<?php
				}
		  }		
?>
  </table>
</form>
</body>
</html>
