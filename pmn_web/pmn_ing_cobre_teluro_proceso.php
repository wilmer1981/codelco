<?php 
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 3;
	if (!isset($AnoTe))
	{
		$AnoTe=date("Y");
		$MesTe=date("m");
		$DiaTe=date("d");
	}
	include("../principal/conectar_pmn_web.php");

?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(opt,Corr)
{
	var f = document.frmPrincipalTeluro;
	switch (opt)
	{
		case "M":
			window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ConsultaP=S&Corr=" + Corr + "&Tab14=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_ing_cobre_teluro_proceso.php?Opc=P&Tipo="+f.Tipo.value;
			f.submit();
		break;
	}
	
}
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="3" topmargin="2">
<form name="frmPrincipalTeluro" action="" method="post">
<input type="hidden" name="Marcados" value="">
<input type="hidden" name="Tipo" value="<?php echo $Tipo;?>">
  <?php //include("../principal/encabezado.php");?>
  <table width="98%" border="0" cellpadding="5" cellspacing="0" class="TituloCabeceraOz">
    <tr> 
      <td colspan="2" valign="top" > 
	  <?php
	  if($Opc=='P')
	  {
	  ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr> 
            <td class="TituloCabeceraAzul">Producci&oacute;n</td>
		  </tr>	
          <tr> 
            <td class="titulo_azul">
			<table width="100%" border="0" >
              <tr>
                <td width="163" class="titulo_azul">Fecha Incio</td>
                <td width="445"><select name="DiaIniCon" style="width:50px;">
                    <?php
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaIniCon))
						{
							if ($i == $DiaIniCon)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					?>
                  </select>
                    <select name="MesIniCon" style="width:90px;">
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
                <td width="144" class="titulo_azul">Fecha Termino</td>
                <td width="512"><select name="DiaFinCon" style="width:50px;">
                    <?php
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaFinCon))
						{
							if ($i == $DiaFinCon)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					?>
                  </select>
                    <select name="MesFinCon" style="width:90px;">
                      <?php
	  	for ($i=1;$i<=12;$i++)
		{
			if (isset($MesFinCon))
			{
				if ($i == $MesFinCon)
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
                    <select name="AnoFinCon" style="width:60px;">
                      <?php
	  	for ($i=2002;$i<=date("Y");$i++)
		{
			if (isset($AnoFinCon))
			{
				if ($i == $AnoFinCon)
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
				<table width="620" border="0">
				<tr>
				<td align="center">
				<input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
				&nbsp; 
				<input name="btneliminar" type="button" id="btneliminar3" value="Eliminar"style="width:70"  onClick="Eliminar(this.form)"> 
				&nbsp; 
				<input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
				</td>
				</tr>
				</table>
			<br>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="TablaDetalle">
			<tr align="center"  class="TituloCabeceraAzul"> 
			<td width="172">Consultar</td>
			<td width="313"><strong>Fecha Hora</strong></td>
			<td width="151"><strong>Lixiviaci&oacute;n</strong></td>
			<td width="179"><strong>Turno</strong></td>
			<td width="464"><strong>Peso</strong></td>
			</tr>
			<?php  
			$Consulta = "select * from pmn_web.cobre_teluro ";
			$Consulta.= " where fechaHora between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon." 00:00:00' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon." 23:59:59' and tipo='".$Tipo."'";
			$Consulta.= " order by fechahora,n_lixiviacion";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Row = mysqli_fetch_array($Respuesta))
			{
				$Consulta= "select * from proyecto_modernizacion.sub_clase where cod_clase ='1' and cod_subclase = '".$Row[turno]."'";
				$Resp=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Resp);  
				$NomTurno=$Fila["nombre_subclase"];			
			?>
				<tr>
				<td align='center'>
				<input type='radio' class='SinBorde' name='fechahora' value='<?php echo $Row[fechaHora];?>' onClick="JavaScript:Proceso('M','<?php echo $Row[correlativo];?>')">
				</td>
				<td align='center'><?php echo $Row[fechaHora];?>&nbsp;</td>
				<td align='right'><?php echo $Row[n_lixiviacion];?>&nbsp;</td>
				<td align='center'><?php echo $NomTurno;?>&nbsp;</td>
				<td align="right"><?php echo $Row["peso"];?>&nbsp;</td>
				</tr>
			<?php
			}
			?>
			</table>
			</td>
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
          </tr>
        </table>
        <?php
	}
	?>
      </td>
    </tr>
  </table>
  <?php //include("../principal/pie_pagina.php");?>  
</form>
</body>
</html>
<?php
echo "<script lenguaje='javascript'>";
	if($MsjTe=='1')
		echo "alert('Registro Guardado con Exito')";
	if($MsjTe=='2')
		echo "alert('Registro Modificado con Exito')";
echo "</script>";
?>