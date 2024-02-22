<?php 
include("../principal/conectar_pmn_web.php"); 

//Lote="+Lote+"&Recargo="+Recargo;
if(isset($_REQUEST["Lote"])){
	$Lote = $_REQUEST["Lote"];
}else{
	$Lote = "";
}
if(isset($_REQUEST["Recargo"])){
	$Recargo = $_REQUEST["Recargo"];
}else{
	$Recargo = "";
}

$PesoTara='9,5';
$Consulta = "select year(fecha_hora) as ano, month(fecha_hora) as mes, day(fecha_hora) as dia,fecha_hora,sum(pneto) as PNeto,peso_total from pmn_web.pmn_pesa_bad_detalle ";
$Consulta.= " where lote='".$Lote."' and recargo='".$Recargo."' group by recargo";
//echo $Consulta;
$Respuesta = mysqli_query($link, $Consulta);
$Row = mysqli_fetch_array($Respuesta);
$Ano=$Row["ano"];
$Mes=$Row["mes"];
$Dia=$Row["dia"];
$FechaHora=$Row["fecha_hora"];
$PActual=$Row["PNeto"];
$PTotalTambor = $Row["peso_total"];
$Diferencia = $PTotalTambor - $PActual;
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<script language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmConsulta02;
	var ValFecha='';
	
	switch (opt)
	{		
		case "G":
			if(f.Lixiviacion.value=='S')
			{
				alert('Debe seleccionar lixiviaci�n')
				f.Lixiviacion.focus();
				return;
			}
			var PesoStockBad=parseFloat(f.pesoStockBad.value.replace(',','.'));
			var Neto=parseFloat(f.PesoNeto.value.replace(',','.'));
			if(Neto > PesoStockBad)
			{
				alert('Valor neto de tambor, no puede ser mayor a stock BAD de la lixiviaci�n.')
				f.PesoNeto.focus();
				return;
			}		
			var Diferencia=parseFloat(f.Diferencia.value.replace(',','.'));
			var Neto=parseFloat(f.PesoNeto.value.replace(',','.'));
			if(Neto > Diferencia)
			{
				alert('Valor neto de tambor, no puede ser mayor a la diferencia por completar.')
				f.PesoNeto.focus();
				return;
			}		
			f.action= "pmn_ing_pesaje01.php?Proceso=G2&PesoNeto="+f.PesoNeto.value;
	 		f.submit();
			break
		case "E":
			var LargoForm = f.elements.length;
			var ValLixiv = "";
			var ValTurno = "";
			for (i = 0; i < LargoForm; i++)
			{
				if ((f.elements[i].name == "ChkLixiv") && (f.elements[i].checked == true))
				{
					ValLixiv = f.elements[i].value;
					ValTurno = f.elements[i+2].value;
					ValFecha = f.elements[i+3].value;
					break;
				}
			}
			if (ValLixiv == "")
			{
				alert("Debe seleccionar un registro para Eliminar");
				return;
			}
			else
			{
				f.action = "pmn_ing_lixiviacion01.php?Proceso=E&Lixiv=" + ValLixiv + "&Turnito=" + ValTurno + "&Dia="+f.Dia.value + "&Mes="+f.Mes.value + "&Ano="+f.Ano.value + "&DiaF="+f.DiaF.value + "&MesF="+f.MesF.value + "&AnoF="+f.AnoF.value + "&FechaCarga="+ValFecha;
				f.submit();
			}
			break
		case "S":
				window.opener.document.frmPrincipalRpt.action = "pmn_pesaje.php?LR="+f.Lote.value+"&Mostrar=S";
				window.opener.document.frmPrincipalRpt.submit();
				window.close();
			break
		case "R": //CANCELAR
			f.action= "pmn_ing_pesaje02.php?Lote="+f.Lote.value+"&Recargo="+f.Recargo.value;
	 		f.submit();
		break;			
	}
}
function CalculaBT()
{
	var f = document.frmConsulta02;
	var Valor=parseFloat(f.PesoBruto.value.replace(',','.'))-parseFloat(f.PesoTara.value.replace(',','.'));
	f.PesoNeto.value=decimales(Valor,2);
	document.getElementById('ValorNeto').innerHTML=decimales(Valor,2);
}
//-->
</script>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body class="TituloCabeceraOz">
<form name="frmConsulta02" action="" method="post">
<input type="hidden" name="FechaHora" value="<?php echo $FechaHora;?>">
<br>
    <table width="200" height="56" border="0" cellpadding="3" cellspacing="0" class="TituloCabeceraOz">
      <tr> 
        <td height="28" colspan="4" class="TituloCabeceraOz">Completar Peso de Tambor N� <?php echo $Recargo;?></td>
	  <td width="0"></td>
      <tr> 
        <td height="28" colspan="4" class="titulo_azul">
		<table width="570" border="0" cellpadding="3" cellspacing="0" align="center" class="TablaInterior">
          <tr>
            <td width="124" height="30" class="titulo_azul">Fecha:</td>
            <td colspan="4">
			<?php 
			echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
			echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
			echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
			printf("%'02d",$Dia);
			echo "-";
			printf("%'02d",$Mes);
			echo "-";
			printf("%'04d",$Ano);
			?>            
			</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td class="titulo_azul">Lote</td>
            <td colspan="7"><?php echo $Lote;?>&nbsp;<input type="hidden" name="Lote" id="Lote" value="<?php echo $Lote;?>"></td>
          </tr>
          <tr>
            <td class="titulo_azul">Peso Actual Tambor</td>
            <td class="TituloCabeceraLetra"><?php echo number_format($PActual,2,',','');?></td>
            <td colspan="3" class="TituloCabeceraLetra">Peso Total de Tambor(neto):&nbsp;&nbsp;<?php echo number_format($PTotalTambor,2,',','');?></td>
            <td class="TituloCabeceraLetra">Diferencia:&nbsp;&nbsp;<?php echo number_format($Diferencia,2,',','');?><input type="hidden" name="Diferencia" id="Diferencia" value="<?php echo $Diferencia;?>"></td>
          </tr>
          <tr>
            <td class="titulo_azul">Num. lixiviaci�n</td>
            <td colspan="7"><select name="Lixiviacion" style="width:100px" onChange="Proceso('R')">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta = "SELECT * FROM pmn_web.lixiviacion_barro_anodico";
				$Consulta.= " WHERE stock_bad > 0 and bad>0 and year(fecha)>=2011";
				//$Consulta.= " AND ((YEAR(fecha) = '2004' AND num_lixiviacion >= '800') OR (YEAR(fecha) >= 2005))";
				$Consulta.= " ORDER BY num_lixiviacion asc";
				$Respuesta = mysqli_query($link, $Consulta);$PesoTotal='';
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Lixiviacion==$Row["num_lixiviacion"])
					{
						$PesoTotal=number_format($Row["stock_bad"],2,',','');
							echo "<option selected value = '".$Row["num_lixiviacion"]."'>".str_pad($Row["num_lixiviacion"],6,0,STR_PAD_LEFT)." -- ".number_format($Row["stock_bad"],2,',','')."</option>\n";
					}
					else
						echo "<option  value = '".$Row["num_lixiviacion"]."'>".str_pad($Row["num_lixiviacion"],6,0,STR_PAD_LEFT)." -- ".number_format($Row["stock_bad"],2,',','')."</option>\n";
				}
				?>
              </select>
              &nbsp;&nbsp;<?php echo 'Stock BAD lixiviaci�n: '.$PesoTotal;//."   ".$TotalTambores;?>
              <input type="hidden" name="pesoStockBad" id="pesoStockBad" value="<?php echo $PesoTotal;?>">            </td>
          </tr>
          <tr>
            <td class="titulo_azul">Tambor</td>
            <td width="56"><?php echo $Recargo;?>
            <input name="Recargo" type="hidden" value="<?php echo $Recargo;?>" size="3" maxlength="2"></td>
            <td width="113" class="titulo_azul">Peso Tara</td>
            <td width="54"><?php echo $PesoTara;?>
            <input name="PesoTara" type="hidden" id="PesoTara" value="<?php echo $PesoTara;?>" size="6" onKeyDown="SoloNumeros(true,this)" onBlur="CalculaBT()" maxlength="7"></td>
            <td width="63" class="titulo_azul">Peso Neto</td>
            <td width="121"><label id="ValorNeto"></label>
            <input name="PesoNeto" type="text" id="PesoNeto" onKeyDown="SoloNumeros(true,this)" value="<?php echo $PesoNeto;?>" size="6" maxlength="7"></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td width="304" height="28">
		<input type="button" name="btnModificar" value="Ingresar" onClick="Proceso('G')" style="width:70px">
        <input type="button" name="btnSalir" value="Salir" onClick="Proceso('S')" style="width:70px">		
		</td>
      </tr>
    </table>
  <br>
</form>
</body>
</html>
