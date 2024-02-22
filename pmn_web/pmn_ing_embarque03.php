<?php 
	include("../principal/conectar_pmn_web.php"); 
	include("pmn_funciones.php");	

	if(isset($_REQUEST["Tipo"])){
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = "";
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
			if(SoloUnElemento(f.name,'SelectedEmb','E'))
			{
				Datos=Recuperar(f.name,'SelectedEmb');
				if(confirm('¿Esta seguro de eliminar relación con el correlativo SIPA?'))
				{
					var Tipo='SIPA';
					if(f.Tipo.value=='ESPE')
						Tipo='ESPE';
					f.action = "pmn_ing_embarque01.php?Proceso=ECorr&Valores="+Datos+"&Tipo="+Tipo;
					f.submit();
				}
			}
			break
		case "I":
			window.print();
			break
		case "V":
			var Tipo='SIPA';
			if(f.Tipo.value=='ESPE')
				Tipo='ESPE';
			f.action = "pmn_ing_embarque03.php?Tipo="+Tipo;
			f.submit();
			break
		case "S":
			var Tipo='SIPA';
			var Datos="&Rec=S&RecT=S&Tipo=SIPA";
			if(f.Tipo.value=='ESPE')
			{
				Datos="&Rec=S&RecT=S&Tipo=ESPE";
				Tipo='ESPE';
			}	
			
			window.opener.document.frmPrincipalRpt.action = "pmn_embarque.php?Corr="+f.Corr.value+Datos;
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
<input type="hidden" name="Tipo" value="<?php echo $Tipo;?>">
<br>
<table width="100%">
<tr><td>
  <table width="700"  border="0" align="left" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
      <tr class="ColorTabla01">
        <td colspan="4">Lotes asignados por correlativo</td>
      </tr>
      <br>
      <tr>
        <td width="121" align="right" class="ColorTabla02">Fecha Inicio Embarque</td>
        <td width="198" class="ColorTabla02" ><select name="Dia">
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
        <td width="146" class="ColorTabla02" >Fecha Termino Embarque </td>
        <td width="211" align="left" class="ColorTabla02" ><select name="DiaF" id="DiaF">
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
        <td width="121" align="right" class="ColorTabla02">&nbsp;</td>
        <td colspan="3" class="ColorTabla02" ><input type="button" name="btnVerDia" value="Consultar" onClick="Proceso('V');" style="width:70px">
		  <input type="button" name="Cancelar" value="Eliminar Relacion con SIPA" style="width:140px;" onClick="Proceso('E')">
          <input type="button" name="Cancelar" value="Salir" onClick="Proceso('S')"></td>
      </tr>
    </table>
</td></tr>
<tr><td>	
  <br>
  
  <table width="800" border="0" align="left" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
              <tr align="center" class="ColorTabla01">
                <?php
   				   // if($ExisteCorrelativo=='S')
					//{
					?>
                <?php
					//}
					?>
                <td width="41" height="15" class="ColorTabla01">Lote</td>
                <td width="70">SA</td>
                <td width="95">Producto SA</td>
                <td width="130">Subproducto SA</td>
                <td width="120">Leyes</td>
				  <td width="50">&nbsp;</td>
                <td width="65">Corr SIPA</td>
                <td width="75">Peso Palet</td>
                <td width="65">Peso Lote</td>
                <td width="50">Tamb.</td>
              </tr>
              <?php	
				$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra and t2.recargo in('0','') and t2.nro_solicitud is not null";
				$Consulta.= " inner join pmn_web.pmn_pesa_bad_detalle t3 on t1.lote=t3.lote";
				$Consulta.= " where t3.fecha_embarque between '".$Ano."-".$Mes."-".$Dia." 00:00:00' and '".$AnoF."-".$MesF."-".$DiaF." 23:59:59' and t3.correlativo_sipa is not null";
				$Consulta.= " group by t1.lote order by t1.lote asc";
				//echo $Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				$HayD='N';
				$Total = 0;
				echo "<input type='hidden' name='SelectedEmb' />";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$HayD='S';
					$NomProductoSA=NomProducto($Row["cod_producto"]);
					$NomSubProductoSA=NomSubProducto($Row["cod_producto"],$Row["cod_subproducto"]);
					$Leyes=ObtenerLeyes($Row["nro_solicitud"]);
					$TotTambores=ObtenerTambores($Row["lote"]);
										
					$OK='';
					if($Row["CabeceraSA"]!='')
						$OK='OK';
					$TotNeto=TotalNetoLote($Row["lote"]);	
					echo "<tr valign='top'>\n";
				    //if($ExisteCorrelativo=='S')
					echo "</td>\n";
					echo "<td align='left'>".$Row["lote"]."</td>\n";
					echo "<td align='left'>".$Row["nro_solicitud"]."<input type='hidden' name='SA[".$Row["lote"]."]' value='".$Row["nro_solicitud"]."'></td>\n";
					echo "<td align='left'>".$NomProductoSA."</td>\n";
					echo "<td align='left'>".$NomSubProductoSA."</td>\n";
					echo "<td align='left'>".$Leyes."</td>\n";
					$PaletA=ObtengoDatosPaletAB($Row["lote"],'A','N');
					$PaletA=explode('-:-',$PaletA);
					$ValorA=$PaletA[0];
					$TmbA=$PaletA[1];
					$SIPA_a=$PaletA[2];
					$PaletB=ObtengoDatosPaletAB($Row["lote"],'B','N');
					$PaletB=explode('-:-',$PaletB);
					$ValorB=$PaletB[0];
					$TmbB=$PaletB[1];
					$SIPA_b=$PaletB[2];
					echo "<td colspan='5'>";
						echo "<table width='100%' border='1' cellpadding='0' cellspacing='0'>";
						if($ValorA!='0'){
							echo "<tr valign='bottom'>\n
								<td align='right' width='11.7%'>A: <input type='checkbox' style='border:none;' name='SelectedEmb' value='".$Row["lote"]."-/-A-/-".$SIPA_a."'></td>\n
								<td align='right' width='15%'>".$SIPA_a."</td>\n
								<td align='right' width='18%'>".number_format($Row["peso_palet_a"],2,',','')."</td>\n
								<td align='right' width='15%'>".number_format($ValorA,2,',','')."</td>\n
								<td align='center' width='11%'>".$TmbA."</td>\n
							</tr>\n"; 
						}
						if($ValorB!='0'){
							echo "<tr valign='bottom'>\n
								<td align='right' width='11.7%'>B: <input type='checkbox' style='border:none;' name='SelectedEmb' value='".$Row["lote"]."-/-B-/-".$SIPA_b."'></td>\n
								<td align='right' width='15%'>".$SIPA_b."</td>\n
								<td align='right' width='18%'>".number_format($Row["peso_palet_b"],2,',','')."</td>\n
								<td align='right' width='15%'>".number_format($ValorB,2,',','')."</td>\n
								<td align='center' width='11%'>".$TmbB."</td>\n
							</tr>\n";
						}
						echo "</table>";
					echo "</td>";					
					echo "</tr>\n";
					$Total = $Total + $ValorB + $ValorA;
				}
				?>
              <tr class="ColorTabla01">
                <td class="ColorTabla01" align="right" colspan="8">Totales</td>
                <td align="right"><?php echo number_format($Total,2,',','');?></td>
                <td>&nbsp;</td>
              </tr>
				<?php
				if($HayD=='N')
				{
					?>
              <tr>
                <td colspan="9" align="center" class="TituloTablaNaranja">No hay lotes Embarcados</td>
              </tr>
              <?php
				}
				?>
            </table></td>
          </tr>
  </table>
</td></tr>
</table>
</form>
</body>
</html>
