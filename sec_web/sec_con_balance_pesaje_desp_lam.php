<?php
	include("../principal/conectar_principal.php");

	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:"";
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:"";
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"01";
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:"";
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:"";
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"31";

	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$FinoLeyes    = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";

	if ($DiaIni=="")
	{
		//$DiaFin = "31";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		//$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
	}
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;	
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;	
	$Ano = $AnoFin;
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
	//window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
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
      <td height="30" colspan="2"><strong>TIPO DE MOVIMIENTO PESAJE DE PAQUETES</strong></td>
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
      <td>
        <?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
	?>
      </td>
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
    <td width="28">#O.E.</td>
    <td width="150">ASIGNACION</td>
    <!--<td width="53">N&ordm; Cert.</td>-->
    <td width="107">Peso</td>
    <!--<td colspan="2">Leyes</td>-->
  </tr>
  <!--<tr class="ColorTabla01"> 
    <td width="56" align="center">S</td>
    <td width="47" align="center">O</td>
  </tr>-->
  <?php   
	$FechaInicio = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad("01",2, "0", STR_PAD_LEFT);
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad("31",2, "0", STR_PAD_LEFT);
	$FechaAux = $FechaInicio;
	$Ano2 = substr($FechaAux,0,4);
	$Ano2 = $Ano2 + 1;
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $Fila["nombre_subclase"];
	}
	$Color = "";
	$TotalPeso = 0;	
	$Consulta = "SELECT STRAIGHT_JOIN ifnull(t2.cod_bulto,'') as cod_bulto, ifnull(t2.num_bulto,'0') as num_bulto, sum(t1.peso_paquetes) as peso, t2.fecha_creacion_lote, t2.corr_enm";
	$Consulta.= " from sec_web.paquete_catodo t1 left join sec_web.lote_catodo t2";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete where ";
	if ($MesConsulta=="M")
	{	
	
		//$Consulta.= "((year(t1.fecha_creacion_paquete) = year('".$FechaAux."')";
		 $Consulta.= " ((t1.fecha_creacion_paquete >= '".$FechaAux."'";
		$Consulta.= " and t1.cod_paquete = '".$MesConsulta."') or ";
		$Consulta.=" (t2.cod_bulto='M' and t1.cod_paquete='A' and year(t1.fecha_creacion_paquete)= '".$Ano2."' and t1.fecha_creacion_paquete >'".$FechaTermino."'))";
		//$Consulta.= "(year(t1.fecha_creacion_paquete) = '".$Ano2."'))";
		//$Consulta.= " and t1.cod_paquete = '".$MesConsulta."'))";
	}
	else
	{
		
		$Consulta.= " year(t1.fecha_creacion_paquete) = year('".$FechaAux."')";
		$Consulta.= " and t1.cod_paquete = '".$MesConsulta."'";
	}
	$Consulta.= " and t1.cod_producto = '48'";
	$Consulta.= " group by t2.cod_bulto,  t2.num_bulto, t1.cod_subproducto";
	//echo $Consulta;
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
		$Consulta = "SELECT STRAIGHT_JOIN distinct t1.cod_producto, t1.cod_subproducto, t2.descripcion";
		$Consulta.= " from sec_web.lote_catodo t3 inner join sec_web.paquete_catodo t1 ";
		$Consulta.= " on t3.cod_paquete = t1.cod_paquete and t3.num_paquete = t1.num_paquete ";
		$Consulta.= " and t3.fecha_creacion_paquete = t1.fecha_creacion_paquete ";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";			
		$Consulta.= " where t3.cod_bulto = '".$Fila["cod_bulto"]."'";
		$Consulta.= " and t3.num_bulto = '".$Fila["num_bulto"]."'";
		//echo $Consulta;
		$Resp2 = mysqli_query($link, $Consulta);
		$ContProd = 0;
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$ContProd++;
			$Descripcion = $Fila2["descripcion"];
		}
		if ($ContProd == 0)
		{
			echo "<td>Sin Sub-Producto</td>\n";
		}
		else
		{
			if ($ContProd == 1)
			{
				echo "<td>".$Descripcion."</td>\n";
			}
			else
			{
				echo "<td>DESPUNTE Y LAMINAS</td>\n";
			}
		}
		if ($Fila["cod_bulto"] == "")
			echo "<td>Sin Lote</td>\n";
		else
			echo "<td align='center'><a href=\"JavaScript:Detalle('".$Producto."','".$SubProducto."','".substr($Fila["fecha_creacion_lote"],0,4)."','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."');\">";
			echo strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</a></td>\n";						
		$Consulta = "SELECT num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//ORDEN DE EMBARQUE
		echo "<td align=\"center\">".$Fila["corr_enm"]."</td>\n";
		// ASIGNACION
		$Consulta = "SELECT * from sec_web.programa_codelco where corr_codelco='".$Fila["corr_enm"]."'";
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
