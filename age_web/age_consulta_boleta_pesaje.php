<?php 		
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 14;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
	if(!isset($TipoBusq))
		$TipoBusq='0';
?>
<html>
<head>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga(TipoBusq)
{
	var Frm=document.FrmConsultaBolPesaje;
	switch(TipoBusq)
	{
		case "1"://POR RANGOS
			Frm.CmbProveedor.value='-1';
			Frm.CmbSubProducto.value='-1';
			if (Frm.TxtBolIni.value!="" && Frm.TxtBolFin.value=="")
				Frm.TxtBolFin.value=Frm.TxtBolIni.value;
			Frm.action="age_consulta_boleta_pesaje.php?Recarga=S&Mostrar=S&TipoBusq=1";
			break;
		case "2"://POR PROVEEDOR
			Frm.TxtBolIni.value='';
			Frm.TxtBolFin.value='';	
			Frm.CmbSubProducto.value='-1';
			Frm.action="age_consulta_boleta_pesaje.php?Recarga=S&Mostrar=S&TipoBusq=2";
			break;
		case "3"://POR SUBPRODUCTO
			Frm.TxtBolIni.value='';
			Frm.TxtBolFin.value='';	
			Frm.CmbProveedor.value='-1';
			Frm.action="age_consulta_boleta_pesaje.php?Recarga=S&Mostrar=S&TipoBusq=3";
			break;
		case "4"://CONSULTA A EXCEL
			Frm.action="age_consulta_boleta_pesaje_excel.php?Recarga=S&Mostrar=S&TipoBusq=<?php echo $TipoBusq; ?>";
			break;
		default:
			Frm.action="age_consulta_boleta_pesaje.php?Recarga=S&TipoBusq=0";		
			break;
	}
	Frm.submit();
}
function Recarga3()
{
	var Frm=document.FrmConsultaBolPesaje;
	Frm.action="age_consulta_boleta_pesaje.php?TipoBusq=3";
	Frm.submit();	
}
function Detalle(Valores)
{
	window.open("age_consulta_boleta_pesaje_detalle.php?Valores="+Valores,"","top=5,left=5,width=800,height=430,scrollbars=yes,resizable = no");		
}
function Salir()
{
	var Frm=document.FrmConsultaBolPesaje;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=10&Nivel=1";
	Frm.submit();
}
</script>
<title>AGE-Consulta Boleta Pesaje</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">

<form name="FrmConsultaBolPesaje" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top">
	  <table width="800" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
            <td width="144" class="Detalle02">Mes:</td>
            <td width="429" align="left">
            <?php
			echo "<select name='CmbMes' size='1' style='width:90px;' onChange='Recarga()'>";
			for($i=1;$i<13;$i++)
			{
				if ($i==$CmbMes&&$Recarga=='S')
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else if ($i==date("n")&&$Recarga!='S')	
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else	
					echo "<option value='".$i."'>".$meses[$i-1]."</option>";
			}
			echo "</select>";
			echo "<select name='CmbAno' size='1' style='width:70px;' onChange='Recarga()'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if ($i==$CmbAno&&$Recarga=='S')
					echo "<option selected value ='$i'>$i</option>";
				else if ($i==date('Y')&&$Recarga!='S')
					echo "<option selected value ='$i'>$i</option>";
				else		
					echo "<option value='".$i."'>".$i."</option>";
			}
			echo "</select>";
			?>
            </td>
            <td colspan="2" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="Detalle02">Buscar Por Rangos Lotes:</td>
            <td>N&deg; Inicio 
              <input name="TxtBolIni" type="text" id="TxtBolIni3" size="10" maxlength="8" value="<?php echo $TxtBolIni;?>">
              &nbsp; N&deg; Final 
              <input name="TxtBolFin" type="text" id="TxtBolFin3" size="10" maxlength="8" value="<?php echo $TxtBolFin;?>">
              &nbsp;&nbsp;&nbsp; </td>
            <td width="32"><input name="BtnOk" type="button" value="Ok" onClick="Recarga('1')"></td>
          <td width="110" rowspan="3" align="center"><input name="BtnExcel" type="button" id="BtnExcel" style="width:70" onClick="Recarga('4');" value="Excel">
            <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();"></td>
          </tr>
          <tr>
            <td class="Detalle02">Buscar Por SubProducto:</td>
            <td><select name="CmbSubProducto" style="width:300" onChange='Recarga()'>
              <option class="NoSelec"  value="S">SELECCIONAR</option>
              <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
            </select></td>
            <td>            <input name="BtnOk3" type="button" value="Ok" onClick="Recarga('3')"></td>
          </tr>
          <tr>
            <td class="Detalle02">Buscar Por Proveedor:</td>
            <td><select name="CmbProveedor" onChange='Recarga()' style="width:300">
              <option class="NoSelec" value="S">SELECCIONAR</option>
              <?php
				if (isset($CmbSubProducto) && $CmbSubProducto != "S")
				{
					$Consulta = "select t1.rut_prv as RUTPRV_A, t1.nombre_prv as NOMPRV_A ";
					$Consulta.= " from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv = t2.rut_proveedor  ";
					$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$CmbSubProducto."'";		
					if($TipoBusq=='3'&&$TxtFiltroPrv!='')
					   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%'"; 						
					$Consulta.= " order by trim(t1.nombre_prv)";
				}
				else
				{
					$Consulta = "select t1.rut_prv as RUTPRV_A, t1.nombre_prv as NOMPRV_A  ";
					$Consulta.= " from sipa_web.proveedores t1  ";
					if($TipoBusq=='3'&&$TxtFiltroPrv!='')
					   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%'"; 						
					$Consulta.= " order by trim(t1.nombre_prv)";
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor==$Fila["RUTPRV_A"])
						echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
				}
			?>
            </select>
              Filtro 
              <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
            <td><input name="BtnOk2" type="button" value="Ok" onClick="Recarga('2')"></td>
          </tr>
        </table>
	  <br> 
        <table width="800" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr class="ColorTabla01">
		  <!--<td align="center" width="10">&nbsp;</td>-->
		  <td width="24" align="center">Lote</td>
		  <td align="center" width="35">Recep</td>
		  <td align="center" width="77">Rut Prv</td>
          <td align="center" width="144">Nombre Proveedor</td>
          <td align="center" width="102">SubProducto</td>
		  <td align="center" width="136">Mina</td>
		  <td align="center" width="31">Clase</td>
		  <td align="center" width="36">Conjto</td>
		  <td align="right"  width="90">Peso.Hum(Kg)</td>
		  </tr>          
		  <?php
			if ($Mostrar=='S')	
			{
				if (strlen($CmbMes)=='1')
				{
					$FechaIni=$CmbAno."-0".$CmbMes."-01";
					$FechaFin=$CmbAno."-0".$CmbMes."-31";
				}	
				else
				{
					$FechaIni=$CmbAno."-".$CmbMes."-01";
					$FechaFin=$CmbAno."-".$CmbMes."-31";
				}	
				$Consulta ="select sum(t5.peso_neto) as tot_peso_neto,t1.lote,t1.fecha_recepcion,";
				$Consulta.= " t1.rut_proveedor,t1.cod_producto, t1.cod_subproducto,t3.nomprv_a as nombre,";
				$Consulta.= " t2.abreviatura as subproducto,t4.NOMMIN_A, t1.clase_producto, t1.num_conjunto ";
				$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.= " inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a left join rec_web.minaprv t4 on t1.rut_proveedor=t4.RUTPRV_A and t1.cod_faena=t4.CODMIN_A ";
				$Consulta.= " inner join age_web.detalle_lotes t5 on t1.lote=t5.lote ";
				switch($TipoBusq)
				{
					case "1"://POR RANGO BOLETAS
						$Consulta.= " where t1.lote between '$TxtBolIni' and '$TxtBolFin'";	
						break;
					case "2"://POR PROVEEDOR
						$Consulta.= " where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' and t1.rut_proveedor='".$CmbProveedor."'";
						break;
					case "3"://POR SUBPRODUCTO
						$Consulta.= " where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' and t1.cod_subproducto='".$CmbSubProducto."'";
						break;
					default:
						$Consulta.= " where t1.lote='-1'";
						break;	
				}
				$Consulta.= " and t1.estado_lote<>'6' ";
				$Consulta.= " group by t1.lote order by lpad(t1.cod_producto,3,'0'), lpad(t1.cod_subproducto,3,'0'), t1.rut_proveedor,t1.lote";
				//echo $Consulta;
				$Resp = mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='CheckCod'>";
				$TotalPeso = 0;
				$SubTotalPeso = 0;
				$CantReg = 0;
				$SubCantReg = 0;;	
				$ProdAnt = "";
				$SubProdAnt = "";
				$RutAnt = "";
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if (($ProdAnt!="" && $SubProdAnt!="") && ($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"]))
					{
						EscribeSubTotal($DescrAnt, &$SubTotalPeso, &$SubCantReg);
					}
					else
					{
						if (($ProdAnt!="" && $SubProdAnt!="" && $RutAnt!="") && 
						($ProdAnt==$Fila["cod_producto"] && $SubProdAnt==$Fila["cod_subproducto"] && $RutAnt!=$Fila["rut_proveedor"]))
						{
							EscribeSubTotal($DescrAnt, &$SubTotalPeso, &$SubCantReg);
						}
					}
					echo "<tr>\n";
					echo "<td align='center'><a href=JavaScript:Detalle('".$Fila[lote]."')>".$Fila["lote"]."</a></td>\n";
					echo "<td align='center'>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Meses[intval(substr($Fila["fecha_recepcion"],5,2))-1],0,3)."</td>\n";
					echo "<td align='right'>".$Fila["rut_proveedor"]."</td>\n";
					echo "<td align='left'>".strtoupper(substr($Fila["nombre"],0,18))."</td>\n";
					echo "<td align='left'>".$Fila["subproducto"]."</td>\n";
					echo "<td align='left'>".strtoupper(substr($Fila["NOMMIN_A"],0,18))."</td>\n";
					echo "<td align='center'>".$Fila["clase_producto"]."</td>\n";
					echo "<td align='center'>".$Fila["num_conjunto"]."</td>\n";
					echo "<td align='right'>".number_format($Fila["tot_peso_neto"],0,',','.')."</td>\n";
					echo "</tr>\n";
					$TotalPeso = $TotalPeso + $Fila["tot_peso_neto"];
					$SubTotalPeso = $SubTotalPeso + $Fila["tot_peso_neto"];
					$CantReg++;
					$SubCantReg++;					
					$ProdAnt = $Fila["cod_producto"];
					$SubProdAnt = $Fila["cod_subproducto"];
					$RutAnt = $Fila["rut_proveedor"];
					$DescrAnt = $Fila["subproducto"]."&nbsp;".strtoupper(substr($Fila["nombre"],0,18));					
				}
			}
			EscribeSubTotal($DescrAnt, &$SubTotalPeso, &$SubCantReg);
			
			
function EscribeSubTotal($Descr, $PesoSubTotal, $SubTotalReg)
{
	echo '<tr class="Detalle01">';
	echo '<td colspan="8" align="right"><strong>TOTAL '.$Descr.' '.number_format( $SubTotalReg,0,",",".").' LOTES CON UN PESO DE: </strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoSubTotal,0,",",".").'</strong></td>';
	echo '</tr>';
	$Descr = "";
	$PesoSubTotal = 0;
	$SubTotalReg = 0;
}			
		  ?>
		  <tr class="Detalle01">
            <td colspan="8" align="right"><strong>TOTAL <?php echo number_format($CantReg,0,",","."); ?> LOTES CON UN PESO DE: </strong></td>
            <td align="right"><strong><?php echo number_format($TotalPeso,0,",","."); ?></strong></td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>