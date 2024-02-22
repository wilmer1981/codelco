<?php
	include("../principal/conectar_principal.php");
	/*if (!isset($DiaIni))
	{
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;
		$DiaFin = "31";
	}
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	

	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));

	$FechaInicio = $FechaAux;
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaTermino,5,2),intval(substr($FechaTermino,8,2)) - 1,substr($FechaTermino,0,4)));	
	*/
	
	if (!isset($DiaIni))
	{
		$DiaFin = "31";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
	}
	$AnoAnt = $AnoFin - 1;
	$Ano = $AnoFin;
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	

	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaInicio = $FechaAux;
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaTermino,5,2),intval(substr($FechaTermino,8,2)) - 1,substr($FechaTermino,0,4)));	

	
	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<script language="JavaScript">
function Proceso(opt)
{
	var f = frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			f.action = "sec_con_balance.php";
			f.submit();
			break;
	}
}

function Historial(SA)
{
	window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Detalle(prod,subprod,ano,cod_lote,num_lote)
{
	window.open("sec_con_balance_detalle_paquete.php?Producto=" + prod + "&SubProducto=" + subprod + "&Ano=" + ano + "&Codigo=" + cod_lote + "&Numero=" + num_lote,"","top=40,left=10,width=680,height=350,scrollbars=yes,resizable = yes");
}
</script>
<body background="../Principal/imagenes/fondo3.gif">
<form action="" method="post" name="frmPrincipal">
  <table width="622" border="1" cellspacing="0" cellpadding="2">
    <tr align="center"> 
      <td height="30" colspan="2"><strong>TIPO DE MOVIMIENTO STOCK FINAL</strong></td>
    </tr>
    <tr> 
      <td width="141"><strong>PRODUCTO</strong></td>
      <td width="363">DESPUNTE Y LAMINAS</td>
    </tr>
    <tr>
      <td><strong>SUBPRODUCTO</strong></td>
      <td>TODOS</td>
    </tr>
    <tr> 
      <td><strong>PERIODO</strong></td>
      <td><?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
	?></td>
    </tr>
    <tr align="center"> 
      <td height="52" colspan="2"> <input name="BtnImprimir" type="button" id="BtnImprimir2" value="Imprimir" style="width:70px;" onClick="Proceso('I')"> 
        <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')"> 
      </td>
    </tr>
  </table>
<br>
<br>
  <table width="700" border="1" cellspacing="0" cellpadding="2">
    <tr align="center" class="ColorTabla01"> 
    <td width="150">SubProducto</td>
    <td width="100">Lote</td>
    <td width="56">N&ordm; Envio</td>
    <td width="28">#O.E./I.E.</td>
    <td width="150">Asignacion</td>
    <!--<td width="53">N&ordm; Cert.</td>-->
    <td width="107">Peso</td>
    <!--<td colspan="2">Leyes</td>-->
  </tr>
  <!--<tr class="ColorTabla01"> 
    <td width="56" align="center">S</td>
    <td width="47" align="center">O</td>
  </tr>-->
  <?php   	
	
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	//echo $Consulta;
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $Fila["nombre_subclase"];
	}
	if ($MesConsulta =="A")
		$AnoFin = $AnoFin +1;
	
	$Eliminar = "DROP TABLE `sec_web`.`tmp_stock_ini2`";
	mysqli_query($link, $Eliminar);
	$Consulta = " create table sec_web.tmp_stock_ini2 as ";
	$Consulta.= " SELECT t2.cod_bulto, t2.num_bulto, year(t2.fecha_creacion_lote) as ano_creacion, sum(t1.peso_paquetes) as peso ";
	$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.= " where ";
	$Consulta.= " t1.cod_producto = '48'";
	$Consulta.= " and t1.cod_estado = 'a' and ";
	if($MesConsulta=='M')
		$Consulta.=" ((t1.cod_paquete <= '".$MesConsulta."' and year(t1.fecha_creacion_paquete) <= '".$AnoFin."') "; 
		else
		$Consulta.=" ((t1.cod_paquete < '".$MesConsulta."' and year(t1.fecha_creacion_paquete) = '".$AnoFin."') "; 
	$Consulta.= " or (year(t1.fecha_creacion_paquete) < '".$AnoFin."' and t1.cod_paquete >'".$MesConsulta."')";
	$Consulta.= " or (year(t1.fecha_creacion_paquete) < ".$AnoFin.") or  ";
	$Consulta.= " (t1.cod_paquete = 'M' and year(t1.fecha_creacion_paquete) = '".$AnoFin."' and ";
	$Consulta.= " month(t1.fecha_creacion_paquete) = '01'))";
	$Consulta.= " group by t2.cod_bulto, t2.num_bulto ";
	$Consulta.= " order by ano_creacion, t2.cod_bulto, t2.num_bulto";
	//echo $Consulta."<br>";
	mysqli_query($link, $Consulta);	
			
	$Consulta = " SELECT sum(t1.peso_paquetes) as peso,t2.cod_bulto,t2.num_bulto ";
	$Consulta.= " from sec_web.paquete_catodo t1  ";
	$Consulta.= " inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia ";
	$Consulta.= " where t2.fecha_guia between '".$FechaInicio."' and curdate() ";//'".$FechaTermino."' ";
	$Consulta.= " and t1.cod_producto = '48' and";
	$Consulta.= " (( t1.cod_paquete < '".$MesConsulta."' and year(t1.fecha_creacion_paquete) = '".$AnoFin."')";
	$Consulta.= " or (t1.cod_paquete >= '".$MesConsulta."' and year(t1.fecha_creacion_paquete) < '".$AnoFin."')";  
	$Consulta.= " or (t1.cod_paquete = 'M' and year(t1.fecha_creacion_paquete) = '".$AnoFin."' and ";
	$Consulta.=" month(t1.fecha_creacion_paquete) = '01')";  
	$Consulta.= " or (year(t1.fecha_creacion_paquete) < ".$AnoFin.")) ";
	$Consulta.= " group by t2.cod_bulto,t2.num_bulto ";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		//$Consulta = " SELECT sum(t1.peso) as peso,t1.cod_bulto,t1.num_bulto ";
		//$Consulta.= " from sec_web.traspaso t1 ";
		//$Consulta.= " where t1.fecha_traspaso between '".$FechaInicio."' and curdate() ";
		//$Consulta.= " and t1.cod_producto = '48'";
		//$Consulta.= " and t1.cod_bulto <= '".$Fila["cod_bulto"]."' and year(t1.fecha_creacion_lote) <= '".$AnoFin."'";
		//$Consulta.= " group by t1.cod_bulto,t1.num_bulto ";
		//$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta;
		//if ($Fila2 = mysqli_fetch_array($Resp2))
		//{
			//ESTA TRASPASADO
		//}
		//else
		//{
			$Insertar = "insert into sec_web.tmp_stock_ini2 (cod_bulto, num_bulto, ano_creacion, peso) ";
			$Insertar.= "values('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','','".$Fila["peso"]."')";
			mysqli_query($link, $Insertar);
		//}
	}
	// aca
	$Consulta3 = " SELECT t1.cod_bulto,t1.num_bulto,t1.fecha_creacion_lote ";
	$Consulta3.= " from sec_web.traspaso t1 ";
	$Consulta3.= " where t1.fecha_traspaso between '".$FechaInicio."' and curdate() ";
	$Consulta3.= " and t1.cod_producto = '48'";
	$Consulta3.= " and ((t1.cod_bulto < '".$MesConsulta."' and year(t1.fecha_creacion_lote) = '".$AnoFin."') or ";
	$Consulta3.= " (t1.cod_bulto >= '".$MesConsulta."' and year(t1.fecha_creacion_lote) < '".$AnoFin."')) ";
	$Resp3 = mysqli_query($link, $Consulta3);
	//echo $Consulta3."<br>";
	while($Fila3 = mysqli_fetch_array($Resp3))
	{
		$peso = 0;
		$Consulta4 ="SELECT t2.cod_bulto,t2.num_bulto, sum(t1.peso_paquetes) as peso ";
		$Consulta4.=" from sec_web.paquete_catodo t1, sec_web.lote_catodo t2 ";
		$Consulta4.=" where t2.cod_bulto = '".$Fila3["cod_bulto"]."' and t2.num_bulto = '".$Fila3["num_bulto"]."' and ";
		$Consulta4.=" t2.fecha_creacion_lote =  '".$Fila3["fecha_creacion_lote"]."' and t2.cod_paquete = t1.cod_paquete and ";
		$Consulta4.=" t2.num_paquete = t1.num_paquete and t2.fecha_creacion_paquete = t1.fecha_creacion_paquete and ";
		$Consulta4.=" ((t1.cod_paquete < '".$MesConsulta."' and year(t1.fecha_creacion_paquete) <= '".$AnoFin."') or ";
		$Consulta4.=" (t1.cod_paquete >= '".$MesConsulta."' and year(t1.fecha_creacion_paquete) < '".$AnoFin."'))";
		$Consulta4.=" group by t2.cod_bulto,t2.num_bulto ";
		$Resp4 = mysqli_query($link, $Consulta4);
		//echo $Consulta4."<br>";
		if($Fila4 = mysqli_fetch_array($Resp4))
		{	
			//ESTA TRASPASADO
			$Insertar = "insert into sec_web.tmp_stock_ini2 (cod_bulto, num_bulto, ano_creacion, peso) ";
			$Insertar.= "values('".$Fila3["cod_bulto"]."','".$Fila3["num_bulto"]."','','".$Fila4["peso"]."')";
			mysqli_query($link, $Insertar); 
		}
	}
	// hasta aca
	
	$Consulta = "SELECT * from sec_web.tmp_stock_ini2 order by cod_bulto, num_bulto";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Color == "")
			$Color = "WHITE";
		else
			$Color = "";
		echo "<tr bgcolor = '".$Color."'>\n";
		//CONSULTA SI TODOS LOS PAQUETES SON DE UN MISMO PRODUCTO-SUBPRODUCTO
		$Consulta = "SELECT distinct t1.cod_producto, t1.cod_subproducto, t2.descripcion, t3.fecha_creacion_lote ";
		$Consulta.= " from sec_web.lote_catodo t3 inner join sec_web.paquete_catodo t1 ";
		$Consulta.= " on t3.cod_paquete = t1.cod_paquete and t3.num_paquete = t1.num_paquete and t3.fecha_creacion_paquete = t1.fecha_creacion_paquete ";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";			
		$Consulta.= " where t3.cod_bulto = '".$Fila["cod_bulto"]."'";
		$Consulta.= " and t3.num_bulto = '".$Fila["num_bulto"]."'";
		$Consulta.= " and t1.cod_estado = 'a'";
		//echo "PP".$Consulta;
		$Resp2 = mysqli_query($link, $Consulta);
		$ContProd = 0;
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$ContProd++;
			$AnoCreacionLote = substr($Fila2["fecha_creacion_lote"],0,4);
			$Descripcion = $Fila2["descripcion"];
		}
		if ($ContProd == 0)
		{
			echo "<td>Sin Sub-Producto</td>\n";
		}
		else
		{
			echo "<td>".$Descripcion."</td>\n";
		
			/*if ($ContProd == 1)
			{
				echo "<td>".$Descripcion."</td>\n";
			}
			else
			{
				echo "<td>DESPUNTE Y LAMINAS</td>\n";
			}*/
		}
		if ($Fila["cod_bulto"] == "")
			echo "<td>Sin Lote</td>\n";
		else
			echo "<td align='center'><a href=\"JavaScript:Detalle('".$Producto."','".$SubProducto."','".$AnoCreacionLote."','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."');\">".strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</a></td>\n";						
		$Consulta = "SELECT num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."' and year(fecha_embarque) = '".$AnoFin."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//--------------------------NUM. ORDEN DE EMBARQUE--------------------------------------------
		$Consulta = "SELECT * from sec_web.embarque_ventana ";
		$Consulta.= " where num_envio='".$Fila2["num_envio"]."' ";
		$Consulta.= " and cod_bulto='".$Fila["cod_bulto"]."' ";
		$Consulta.= " and num_bulto='".$Fila["num_bulto"]."' ";
		$Consulta.= " and year(fecha_embarque) ='".$AnoFin."' ";
		$RespAux=mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
			echo "<td align=\"center\">".$FilaAux["corr_enm"]."</td>\n";
		else
			echo "<td>".$Fila["ie"]."</td>\n";

			//echo "<td>&nbsp;</td>\n";
		//-------------------------------------------------------------------------------------------
		// ASIGNACION
		$Consulta = "SELECT * from sec_web.programa_codelco where corr_codelco='".$FilaAux["corr_enm"]."'";
		$RespAux=mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
			echo "<td align=\"center\">".$FilaAux["cod_contrato_maquila"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		//-----------------------
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
									
		$TotalPeso = $TotalPeso + $Fila["peso"];			
		//------------------------------------------------------------------------------------------------			
	}		
?>
  <tr> 
    <td colspan="5"><strong>TOTAL</strong></td>
    <td align="right" bgcolor="#FFFF66"><?php echo number_format($TotalPeso,0,",","."); ?></td>
    <!--<td align="right" bgcolor="#FFFF66">&nbsp;</td>
    <td align="right" bgcolor="#FFFF66">&nbsp;</td>-->
  </tr>
</table>
</form>
</body>
</html>
