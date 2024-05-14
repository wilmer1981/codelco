<?php 
	include("../principal/conectar_pmn_web.php"); 

	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	if(isset($_REQUEST["Dia"])){
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia = "";
	}
	if(isset($_REQUEST["AnoF"])){
		$AnoF = $_REQUEST["AnoF"];
	}else{
		$AnoF = "";
	}
	if(isset($_REQUEST["MesF"])){
		$MesF = $_REQUEST["MesF"];
	}else{
		$MesF = "";
	}
	if(isset($_REQUEST["DiaF"])){
		$DiaF = $_REQUEST["DiaF"];
	}else{
		$DiaF = "";
	}
	
	if(isset($_REQUEST["Corr"])){
		$Corr = $_REQUEST["Corr"];
	}else{
		$Corr = "";
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmConsulta;
	var ValFecha='';
	
	switch (opt)
	{		
		case "M":
			var LargoForm = f.elements.length;
			var ValLixiv = "";
			var ValTurno = "";
			for (i = 0; i < LargoForm; i++)
			{
				if ((f.elements[i].name == "ChkLixiv") && (f.elements[i].checked == true))
				{
					ValLixiv = f.elements[i].value;
					ValTurno = f.elements[i+2].value;
					ValFecha= f.elements[i+3].value;
					break;
				}
			}
			if (ValLixiv == "")
			{
				alert("Debe seleccionar un registro para Modificar");
				return;
			}
			else
			{
				var ValFechaAux=ValFecha.split('-');
				window.opener.document.frmPrincipalRpt.action = "pmn_lixiviacion.php?ModifLixi=S&DiaModif=" + ValFechaAux[2] + "&MesModif=" + ValFechaAux[1] + "&AnoModif=" + ValFechaAux[0] + "&TurnoModif=" + ValTurno + "&NumLixModif="+ValLixiv + "&FechaModif="+ValFecha+"&Tab6=true" ;
				window.opener.document.frmPrincipalRpt.submit();
				window.close();
			}
			break
		case "E":
			if(SoloUnElemento(f.name,'selec','E'))
			{
				Datos=Recuperar(f.name,'selec');
				if(confirm('¿Esta seguro de eliminar lote(s) selecionado(s)?'))
				{
					f.action = "pmn_ing_embarque01.php?Proceso=ELote&Valores="+Datos;
					f.submit();
				}
			}
			break
		case "I":
			window.print();
			break
		case "V":
			f.action = "pmn_ing_embarque02.php";
			f.submit();
			break
		case "S":
			window.opener.document.frmPrincipalRpt.action = "pmn_embarque.php?Corr="+f.Corr.value;
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
		break
	}
}
//-->
</script>
</head>
<style type="text/css">
	.Estilo2 {color: #FF0000}
</style>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<input type="hidden" name="Corr" value="<?php echo $Corr;?>">
<br>
<table width="100%">
<tr><td>
  <table width="700"  border="0" align="left" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
      <tr class="ColorTabla01">
        <td colspan="4">Lotes asignados por correlativo</td>
      </tr>
      <br>
      <tr>
        <td width="91" align="right" class="ColorTabla02">Fecha Inicio</td>
        <td width="195" class="ColorTabla02" ><select name="Dia">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($Dia))
			{
				if ($Dia == $i)
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
          <select name="Mes">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($Mes))
			{
				if ($Mes == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
          </select>
          <select name="Ano">
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($Ano))
			{
				if ($Ano == $i)
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
        <td width="98" class="ColorTabla02" >Fecha Termino</td>
        <td width="292" align="left" class="ColorTabla02" ><select name="DiaF" id="DiaF">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaF))
			{
				if ($DiaF == $i)
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
          <select name="MesF" id="MesF">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesF))
			{
				if ($MesF == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
          </select>
          <select name="AnoF" id="AnoF">
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoF))
			{
				if ($AnoF == $i)
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
      <tr>
        <td width="91" align="right" class="ColorTabla02">&nbsp;</td>
        <td colspan="3" class="ColorTabla02" ><input type="button" name="btnVerDia" value="Consultar" onClick="Proceso('V');" style="width:70px">
		<input type="button" name="btnVerDia" value="Eliminar" onClick="Proceso('E');" style="width:70px">
		<input type="button" name="Cancelar" value="Salir" onClick="Proceso('S')"></td>
      </tr>
    </table>
</td></tr>
<tr><td>	
  <br>
  <table width="700" border="0" align="left" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td valign="top"> 
              <table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
                <?php	
				$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
				$Consulta.= " where fecha_hora between '".$Ano."-".$Mes."-".$Dia." 00:00:00' and '".$AnoF."-".$MesF."-".$DiaF." 23:59:59'";
				$Consulta.= " group by t2.correlativo_sipa";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					echo "<tr class='ColorTabla01'>\n";
					echo "<td align='left' colspan='2'>Correlativo Sipa</td>\n";
					echo "<td align='left' colspan='6'>".$Row[correlativo_sipa]."</td>\n";
					echo "</tr>\n";
					?>
					<tr align="center" class="ColorTabla01"> 
					  <td width="41" height="15" class="ColorTabla01">&nbsp;</td>
					  <td width="41" height="15" class="ColorTabla01">Lote</td>
					  <td width="95">Recargo</td>
					  <td width="149">Peso Bruto</td>
					  <td width="149">Peso Tara</td>
					  <td width="149">Peso Neto</td>
					  <td width="149">Sello interno</td>
					  <td width="149">Sello externo</td>
					</tr>
					<?php
					$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
					$Consulta.= " where t2.correlativo_sipa='".$Row[correlativo_sipa]."'";
					$Consulta.= " order by t2.lote,t2.recargo";
					echo "<input type='hidden' name='selec'>";
					$Respuesta2 = mysqli_query($link, $Consulta);$Total02='0';$Total03='0';$Total04='0';$i=1;
					while ($Row2 = mysqli_fetch_array($Respuesta2))
					{
						echo "<tr>\n";
						if($Row2["recargo"]==1)
							echo "<td align='center'><input type='checkbox' style='background:#ccc;' class='SinBorde' name='selec' value='".$Row2["lote"]."' /></td>\n";
						else
							echo "<td align='center'>&nbsp;</td>\n";	
						echo "<td align='center'>".$Row2["lote"]."</td>\n";
						echo "<td align='center'>".$Row2["recargo"]."</td>\n";
						echo "<td align='right'>".number_format($Row2[pbruto],2,',','.')."</td>\n";
						echo "<td align='right'>".number_format($Row2[ptara],2,',','.')."</td>\n";
						echo "<td align='right'>".number_format($Row2[pneto],2,',','.')."</td>\n";
						echo "<td align='right'>".$Row2[sint]."</td>\n";
						echo "<td align='right'>".$Row2[sext]."</td>\n";
						echo "</tr>\n";
						$i++;
						$Total02 = $Total02 + $Row2[pbruto];
						$Total03 = $Total03 + $Row2[ptara];
						$Total04 = $Total04 + $Row2[pneto];
					}					
					?>
					<tr align="center"> 
					  <td height="15" colspan="2" align="right"><strong>TOTAL</strong></td>
					  <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
					  <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
					  <td align="right"><?php echo number_format($Total04,2,',','.'); ?></td>
					  <td align="right">&nbsp;</td>
					  <td align="right">&nbsp;</td>
					</tr>
					<?php
				}
				?>
		  </table>            
		  </td>
          </tr>
  </table>
</td></tr>
</table>
</form>
</body>
</html>
