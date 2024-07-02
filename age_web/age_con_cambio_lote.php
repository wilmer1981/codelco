<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=15;
	include("../principal/conectar_principal.php");

	$CmbRecepcion   = isset($_REQUEST["CmbRecepcion"])?$_REQUEST["CmbRecepcion"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtFiltroPrv   = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtFechaIni    = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m-d');
	$TxtFechaFin    = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m-d');
	$OptVer         = isset($_REQUEST["OptVer"])?$_REQUEST["OptVer"]:"P";
	$Busq           = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$LimitIni       = isset($_REQUEST["LimitIni"])?$_REQUEST["LimitIni"]:0;
	$LimitFin       = isset($_REQUEST["LimitFin"])?$_REQUEST["LimitFin"]:999;
	$Orden          = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"T";
	$TxtLote        = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$RadioTipo      = isset($_REQUEST["RadioTipo"])?$_REQUEST["RadioTipo"]:"";
	$Muestra        = isset($_REQUEST["Muestra"])?$_REQUEST["Muestra"]:"";
	$SubProd        = isset($_REQUEST["SubProd"])?$_REQUEST["SubProd"]:"";
	$TxtLoteB       = isset($_REQUEST["TxtLoteB"])?$_REQUEST["TxtLoteB"]:"";
	$TxtFechaB      = isset($_REQUEST["TxtFechaB"])?$_REQUEST["TxtFechaB"]:"";
	$TipoCon        = isset($_REQUEST["TipoCon"])?$_REQUEST["TipoCon"]:"";
	$LCatodo        = isset($_REQUEST["LCatodo"])?$_REQUEST["LCatodo"]:"";
	$TipoBusqueda   = isset($_REQUEST["TipoBusqueda"])?$_REQUEST["TipoBusqueda"]:"";	

?>
<html>
<head>
<title>AGE-Consulta Cambio Subproducto</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">

function Buscar(opt)
{
	var f=document.frmPrincipal;
	var lotes = f.TxtLote.value;

	if (lotes!="")
	{   
		f.action = "age_con_cambio_lote.php?Muestra=S&TxtLote="+lotes;
		f.submit();
	}
	else
	{
		alert ("Lote debe ingresarse");
	}
}
function Grabar()
{
	var f=document.frmPrincipal;
	var Valores ="";
	var SubNew=16;
	if (f.TxtLoteB.value=="")
	{
		alert ("Lote Blister debe ser ingresado")
		f.TxtLoteB.focus();
	}
	if (f.TxtFechaB.value=="")
	{
		alert ("Fecha de Lote Blister debe seleccionarse");
		f.TxtFechaB.focus();
	}
		Valores = f.SubProd.value+"//"+SubNew+"//"+f.TxtLote.value+"//"+f.TxtLoteB.value+"//"+f.TxtFechaB.value;
		//alert(Valores);
		f.action = "age_con_cambio_lote01.php?Proceso=G&Valores="+Valores;
		f.submit();
}
function Salir()
{
		var f=document.frmPrincipal;
		f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=70";
		f.submit();
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
</style></head>
<body onLoad="window.document.frmPrincipal.TxtLote.focus();">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoCon; ?>">
<input type="hidden" name="LCatodo" value="<?php echo $LCatodo; ?>">
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td align="center"><strong>CAMBIO DE PRODUCTOS: CATODOS A BLISTER </strong></td>
            </tr>
		  </table>
		  <br>
		  <table width="750"  border="0" cellpadding="2" cellspacing="0" class="TablaInterior">

            <tr>
         		<td width="80">Lote a Cambiar</td>
			   <td  width="60">
			    	<input  name="TxtLote" type="text" class="InputCen" id="TxtLote" value="<?php echo $TxtLote; ?>" size="10" maxlength="10">
				</td>
				<td width="30">CATODOS</td>
				<td width="30"> 
                <?php 
					if (($RadioTipo == "C") || ($RadioTipo==""))
					{
						echo '<input name="RadioTipo" type="radio" value="C" checked>';
					}
					else
					{
						echo '<input name="RadioTipo" type="radio" value="C">';
					}
				?>
              </td>
            <td width="30">ANODOS</td>
			<td width="30"> 
              <?php 
					if ($RadioTipo == "A")
					{
						echo '<input name="RadioTipo" type="radio" value="A" checked>';
					}
					else
					{
						echo '<input name="RadioTipo" type="radio" value="A">';
					}
				?>
              </td>
            <td width="30">&nbsp;</td>
            <td width="30">&nbsp;</td>
            <td width="30">&nbsp;</td>
            <td width="30">&nbsp;</td>

		    </tr>
	        </table>
			<table width="750" cellpadding="1" cellspacing="0">
	
			<tr align="center">
				<td>
        			<input name="BtnOK" type="button" id="BtnOK" value="Buscar" onClick="Buscar('S')">
              	    <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70px " onClick="Grabar()" value="Grabar">
              		<input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Salir()" value="Salir">
				</td>
            </tr>
			</table>
		  <br>
		  <table width="780" bgcolor="#CCCCCC" border="1" cellpadding="2" cellspacing="0">  
		   <tr><td  align="center">CATODOS&nbsp;/&nbsp;ANODOS</td></tr>
		  </table>
		  <br>

		  <table width="780"  border="1" cellpadding="2" cellspacing="0">
            <tr class="ColorTabla01">
	        <td width="8%">Lote</td>
	    	<td width="4%">Rec.</td>
   		 	<td width="4%">Ult.</td>
 		    <td width="5%">Folio</td>
		    <td width="7%">Corr.</td>
    		<td width="10%">Fecha.</td>
    		<td width="10%">P.Bruto</td>
    		<td width="8%">P.Tara</td>
    		<td width="9%">P.Neto</td>
    		<td width="9%">Guia</td>
    		<td width="10%">Patente</td>
    		<td width="4%">Est.</td>
			<td width="10%">Recepci�n</td>
    		<td width="4%">Aut.</td>
  		</tr>
		
<?php		

	if ($Muestra=="S")	
	{
		if ($RadioTipo=="A")
			$SubProd = 17;
		if ($RadioTipo=="C")
			$SubProd = 18;
		echo '<input type="hidden" name="SubProd" value="' .$SubProd.'">';
		$Consulta = "select t1.lote, t1.fecha_recepcion, t2.recargo, t2.fin_lote, t2.folio,t2.corr, t1.cod_recepcion,";
		$Consulta.= " t2.peso_bruto,t2.peso_tara, t2.peso_neto, t2.guia_despacho, t2.autorizado, t2.patente, t1.estado_lote";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
		$Consulta.= " where t1.lote = '".$TxtLote."' and t1.cod_producto='1' and t1.cod_subproducto = '".$SubProd."'";
		$Consulta.= " and t1.estado_lote<>'6' ";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);	
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Tipo_Recep=isset($Fila["recepcion"])?$Fila["recepcion"]:"";
			$Decimales=0;
			if ($Tipo_Recep=="PMN")
				$Decimales=3;
			echo "<tr >\n";
			echo "<td aling='center'>".$Fila["lote"]."</td>";
			echo "<td aling='center'>".$Fila["recargo"]."</td>";
			echo "<td aling='center'>".$Fila["fin_lote"]."</td>";
			echo "<td aling='center'>".$Fila["folio"]."</td>";
			echo "<td aling='center'>".$Fila["corr"]."</td>";
			echo "<td aling='center'>".$Fila["fecha_recepcion"]."</td>";
			echo "<td align='right'>".number_format($Fila["peso_bruto"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["peso_tara"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["peso_neto"],0,",",".")."</td>\n";
			if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
					echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
			else
					echo "<td>&nbsp;</td>";
			echo "<td aling='center'>".$Fila["patente"]."</td>";
			echo "<td aling='center'>".$Fila["estado_lote"]."</td>";
			echo "<td aling='center'>".$Fila["cod_recepcion"]."</td>";
			echo "<td align='center'>".strtoupper($Fila["autorizado"])."</td>\n";
			echo "</tr>\n";
		}
	}
	echo "</table>";
	
	if ($Muestra=="S" && $TxtLote!="")
	{
		?>
			<br></br>
			<table width="780" bgcolor="#CCCCCC" border="1" cellpadding="2" cellspacing="0">  
		   		<tr><td  align="center">BLISTER</td>
		  	</table>
			<table width="780"  border="1" cellpadding="2" cellspacing="0">
            	<tr class="ColorTabla01">
					<td width="10%">Lote</td>
    				<td width="15%">Fecha.</td>
	    			<td width="4%">Rec.</td>
   		 			<td width="4%">Ult.</td>
 		    		<td width="5%">Folio</td>
		    		<td width="7%">Corr.</td>
    				<td width="8%">P.Bruto</td>
    				<td width="8%">P.Tara</td>
    				<td width="8%">P.Neto</td>
    				<td width="8%">Guia</td>
    				<td width="10%">Patente</td>
    				<td width="4%">Est.</td>
					<td width="10%">Recepci�n</td>
    				<td width="4%">Aut.</td>
				</tr>
			
				<tr>
                 <td width="10%"><input name="TxtLoteB" type="text" class="InputCen" id="TxtLoteB" value="<?php echo $TxtLoteB; ?>" size="9" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtFechaB');"></td>   
		    	<td align="left"><input name="TxtFechaB" type="text" class="InputCen" value="<?php echo $TxtFechaB; ?>" size="15" maxlength="10" >
           		<img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="17" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaB,TxtFechaB,popCal);return false"></td>
		<?php
	        	//echo '<td width="10%"><input name="TxtFechaB" type="text" value="'.$TxtFechaB.'" size="10" maxlength="10" onChange="Buscar2()"></td>';
				
				$recargo = isset($Fila["recargo"])?$Fila["recargo"]:"";
				$fin_lote = isset($Fila["fin_lote"])?$Fila["fin_lote"]:"";
				$folio = isset($Fila["folio"])?$Fila["folio"]:"";
				$corr = isset($Fila["corr"])?$Fila["corr"]:"";
				$peso_bruto = isset($Fila["peso_bruto"])?$Fila["peso_bruto"]:0;
				$peso_tara = isset($Fila["peso_tara"])?$Fila["peso_tara"]:0;
				$peso_neto = isset($Fila["peso_neto"])?$Fila["peso_neto"]:0;
				$guia_despacho = isset($Fila["guia_despacho"])?$Fila["guia_despacho"]:"";
				$patente       = isset($Fila["patente"])?$Fila["patente"]:"";
				$estado_lote   = isset($Fila["estado_lote"])?$Fila["estado_lote"]:"";
				$cod_recepcion = isset($Fila["cod_recepcion"])?$Fila["cod_recepcion"]:"";
				
				echo "<td aling='center'>".$recargo."</td>";
				echo "<td aling='center'>".$fin_lote."</td>";
				echo "<td aling='center'>".$folio."</td>";
				echo "<td aling='center'>".$corr."</td>";
				echo "<td align='right'>".number_format($peso_bruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($peso_tara,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($peso_neto,0,",",".")."</td>\n";
				echo "<td align='center'>".$guia_despacho."</td>\n";
				echo "<td aling='center'>".$patente."</td>";
				echo "<td aling='center'>".$estado_lote."</td>";
				echo "<td aling='center'>".$cod_recepcion."</td>";
				echo "<td align='center'>N</td>\n";
			    echo "</tr>\n";
			echo "</table>";
	}

?>
<br>
</br>
</table>	
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
