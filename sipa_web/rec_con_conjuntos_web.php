<?php
	//echo date('h:i:s')."<BR>";
	//echo date('G:i:s')."<BR>";
	include("../principal/conectar_principal.php");
	include("funciones.php");

	/************************************************ */
	if(isset($_REQUEST["Buscar"])){
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}
	if(isset($_REQUEST["TxtFechaIni"])){
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni=date('Y-m-d');
	}
	if(isset($_REQUEST["CmbTipoRegistro"])){
		$CmbTipoRegistro = $_REQUEST["CmbTipoRegistro"];
	}else{
		$CmbTipoRegistro = "";
	}
	
	/************************************************ */
	/*
	if(!isset($TxtFechaIni))
		$TxtFechaIni=date('Y-m-d');
	*/
	$TxtFechaIniMes=substr(date('Y-m-d'),0,7)."-01";	
	//$TxtFechaFin=date('Y-m-d');
		
	/*if ($OpcConsulta == "P" || $OpcConsulta == "C")
	{
		$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
		$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	}*/
?>
<html>
<head>
<title>Informe Recepciones por Producto</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "C":
			f.action = "rec_con_conjuntos_web.php?Buscar=S";
			f.submit();
			break;
		case "I":
			f.BtnConsultar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnConsultar.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=24";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
  	<?php
		switch($CmbTipoRegistro)
		{
			case "R"://RECEPCION
				$NombreCons='RECEPCIONES';
				break;
			case "D"://DESPACHOS
				$NombreCons='DESPACHOS';
				break;
		}	
	?>
    <td colspan="2"><strong>INFORME DE RECEPCIONES POR CONJUNTO MINEROS </strong></td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Fecha</span></td>
    <td width="401">
      <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="13" maxlength="10" readonly >
      <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false">
      <!--<input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
      <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false">-->
	  </td>
  </tr>
  <tr align="center">
    <td height="30" colspan="2">
	<input name="BtnConsultar" type="button" value="Consultar" style="width:70px " onClick="Proceso('C')">
	<input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td></tr>
</table><br>
<table width="600" border="1" align="center" cellpadding="2" cellspacing="0" >
  <tr class="ColorTabla02">
    <td width="60" align="center">LOTE</td>
    <td width="19" align="center">RE</td>
    <td width="15" align="center">UR</td>
    <td width="304" align="center">PROVEEDOR</td>
    <td width="51" align="center">CONJ.</td>
    <td width="66" align="center">P.NETO</td>
  </tr>
<?php
if($Buscar=='S')
{
	$TotalRecep=0;
	$Consulta="SELECT distinct t1.conjunto,t2.descripcion as nombre_subprod from sipa_web.recepciones t1 left join proyecto_modernizacion.subproducto t2 on ";
	$Consulta.="t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.="where t1.cod_producto='1' and fecha='".$TxtFechaIni."' and t1.conjunto not in('','0') ";
	//echo $Consulta;
	$RespConj=mysqli_query($link, $Consulta);
	while($FilaConj=mysqli_fetch_array($RespConj))
	{
		$TotNeto=0;
		echo "<tr class='Detalle01' align='left'>";
		echo "<td colspan='6'>CONJUNTO:&nbsp;".$FilaConj["conjunto"]." ---> ".$FilaConj[nombre_subprod]."</td>";
		echo "</tr>";
		$Consulta="SELECT t1.lote,t2.nombre_prv,t1.conjunto,sum(t1.peso_neto) as peso_neto ";
		$Consulta.="from sipa_web.recepciones t1 left join sipa_web.proveedores t2 on t1.rut_prv=t2.rut_prv ";
		$Consulta.="where t1.fecha='".$TxtFechaIni."' and t1.cod_producto='1' and t1.conjunto='".$FilaConj["conjunto"]."' and peso_neto<>'' ";
		$Consulta.="group by lote order by t1.lote";
		//echo $Consulta;
		$RespRecep=mysqli_query($link, $Consulta);
		while($FilaR=mysqli_fetch_array($RespRecep))
		{
			echo "<tr>";
			echo "<td align='center'>".$FilaR["lote"]."</td>";
			$Consulta="SELECT count(*) as cant_rec from sipa_web.recepciones where lote='".$FilaR["lote"]."' and fecha between '".$TxtFechaIniMes."' and '".$TxtFechaIni."' group by lote";
			$RespRec=mysqli_query($link, $Consulta);
			$FilaRec=mysqli_fetch_array($RespRec);
			//echo $Consulta."<br>";
			echo "<td align='right'>".$FilaRec[cant_rec]."</td>";
			$Consulta="SELECT ult_registro from sipa_web.recepciones where lote='".$FilaR["lote"]."' and recargo='".$FilaRec[cant_rec]."'";
			$RespUR=mysqli_query($link, $Consulta);
			$FilaUR=mysqli_fetch_array($RespUR);
			echo "<td align='center'>".$FilaUR["ult_registro"]."</td>";
			echo "<td>".$FilaR["nombre_prv"]."</td>";
			echo "<td align='center'>".$FilaR["conjunto"]."</td>";
			echo "<td align='right'>".number_format($FilaR["peso_neto"],0,'','.')."</td>";
			echo "</tr>";			
			$TotNeto=$TotNeto+$FilaR["peso_neto"];
		}
		echo "<tr class='Detalle01'>";
		echo "<td colspan='5' align='right'>SUBTOTAL</td>";
		echo "<td align='right'>".number_format($TotNeto,0,'','.')."</td>";
		echo "</tr>";
		$TotalRecep=$TotalRecep+$TotNeto;
	}
	echo "<tr class='Detalle01'>";
	echo "<td colspan='5' align='right'>TOTAL</td>";
	echo "<td align='right'>".number_format($TotalRecep,0,'','.')."</td>";
	echo "</tr>";
}
?>
</table>
</form>
</body>
</html>