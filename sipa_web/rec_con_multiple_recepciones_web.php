<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");	

	if(isset($_REQUEST["OpcConsulta"])){
		$OpcConsulta = $_REQUEST["OpcConsulta"];
	}else{
		$OpcConsulta = "";
	}
	if(isset($_REQUEST["CmbMes"])){
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes = date("m");
	}
	if(isset($_REQUEST["CmbAno"])){
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno = date("Y");
	}
	if(isset($_REQUEST["CmbTipoRegistro"])){
		$CmbTipoRegistro = $_REQUEST["CmbTipoRegistro"];
	}else{
		$CmbTipoRegistro = "";
	}
	if(isset($_REQUEST["OpcTR"])){
		$OpcTR = $_REQUEST["OpcTR"];
	}else{
		$OpcTR = "";
	}
	if(isset($_REQUEST["CmbGrupoProd"])){
		$CmbGrupoProd = $_REQUEST["CmbGrupoProd"];
	}else{
		$CmbGrupoProd = "";
	}
	if(isset($_REQUEST["CmbSubProducto"])){
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = "";
	}
	if(isset($_REQUEST["TxtFechaIni"])){
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni = "";
	}
	if(isset($_REQUEST["TxtFechaFin"])){
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin = "";
	}
	if(isset($_REQUEST["CmbProveedor"])){
		$CmbProveedor = $_REQUEST["CmbProveedor"];
	}else{
		$CmbProveedor = "";
	}

	if(isset($_REQUEST["TxtLoteIni"])){
		$TxtLoteIni = $_REQUEST["TxtLoteIni"];
	}else{
		$TxtLoteIni = "";
	}
	if(isset($_REQUEST["TxtLoteFin"])){
		$TxtLoteFin = $_REQUEST["TxtLoteFin"];
	}else{
		$TxtLoteFin = "";
	}
	if(isset($_REQUEST["TxtConjIni"])){
		$TxtConjIni = $_REQUEST["TxtConjIni"];
	}else{
		$TxtConjIni = "";
	}
	if(isset($_REQUEST["TxtConjFin"])){
		$TxtConjFin = $_REQUEST["TxtConjFin"];
	}else{
		$TxtConjFin = "";
	}
	if(isset($_REQUEST["OpcHLF"])){
		$OpcHLF = $_REQUEST["OpcHLF"];
	}else{
		$OpcHLF = "";
	}

	if ($OpcConsulta == "P" || $OpcConsulta == "C")
	{
		$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
		$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	}
?>
<html>
<head>
<title>Consulta Multiple Recepciones Y Despachos</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "S":
			f.action = "rec_con_multiple_recepciones.php";
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
    <td colspan="2"><strong>CONSULTA  DE  <?php echo $NombreCons;?></strong></td>
  </tr>
<?php
	if ($OpcConsulta=="F")
	{
?>		  
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Fecha</span></td>
    <td width="401"><?php echo $TxtFechaIni; ?> Al <?php echo $TxtFechaFin; ?></td>
  </tr>
<?php
	}
	if ($OpcConsulta=="L")
	{
?>	
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Rango de Lote:</span></td>
    <td><?php echo $TxtLoteIni; ?> Al <?php echo $TxtLoteFin; ?></td>
  </tr>
<?php	
	}
?>  
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Grupo Producto:</span></td>
    <td>
	<?php
	if ($CmbGrupoProd == "S")
	{
		echo "Todos";
	}
	else
	{
		$Consulta = "SELECT * from sipa_web.grupos_productos where cod_grupo='".$CmbGrupoProd."'";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			echo  $Fila["descripcion_grupo"]."\n";	
		}
	}
	?>	
    </td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">SubProducto:</span></td>
    <td><?php
	if ($CmbSubProducto == "S")
	{
		echo "Todos";
	}
	else
	{
		$SubProd=explode('~',$CmbSubProducto);
		$Consulta = "SELECT cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
		$Consulta.= " from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto='".$SubProd[0]."' and cod_subproducto='".$SubProd[1]."' order by orden";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{		
			echo  $Fila["orden"]." - ".$Fila["abreviatura"]."\n";
		}
	}
?>
	</td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Proveedor:</span></td>
    <td>
      <?php
	if ($CmbProveedor == "S")
		echo "Todos";
	else
	{	  
		$RutAux = $CmbProveedor;
		$Consulta = "SELECT * ";
		$Consulta.= " from rec_web.proved ";
		$Consulta.= " where RUTPRV_A='".$RutAux."'";
		$Consulta.= " order by TRIM(nomprv_a) ";
		$Resp = mysqli_query($link, $Consulta);	
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$Datos = explode("-",$Fila["RUTPRV_A"]);
			$RutAux = ($Datos[0]*1)."-".$Datos[1];
			echo  $Fila["RUTPRV_A"]." - ".$Fila["NOMPRV_A"]."\n";
		}
	}
?>
      </td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Ver Datos: </span></td>
    <td height="18">
<?php
	if ($OpcTR=="T")
		echo "Acumulado por Lote";
	else
	{
		if ($OpcTR=="R")
			echo "Detalle por Recargo";
	}
?>	
	</td>
  </tr>
  <tr align="center">
    <td height="30" colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
          <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td></tr>
</table>
<br>
<?php

$ColSpan =13; 
if ($OpcTR=="R")			
	if($OpcConsulta=='C'||$CmbTipoRegistro=='D')
		$ColSpanSubTotal = 11;
	else
		$ColSpanSubTotal = 12;	
else
	if($OpcConsulta=='C'||$CmbTipoRegistro=='D')
		$ColSpanSubTotal = 2;
	else
		$ColSpanSubTotal = 3;
echo "<table width='600'  border='1' align='center' cellpadding='3' cellspacing='0'>\n";
switch($CmbTipoRegistro)
{
	case "R"://RECEPCION
		$NombreTabla='sipa_web.recepciones';
		break;
	case "D"://DESPACHOS
		$NombreTabla='sipa_web.despachos';
		break;
	case "O"://OTROS PESAJE
		$NombreTabla='sipa_web.otros_pesaje';
		break;
	default:
		$NombreTabla='sipa_web.recepciones';
		break;	
}
switch ($OpcConsulta)
{
	case "F":			
		$Consulta = "SELECT distinct fecha,guia_despacho,correlativo,rut_prv from ".$NombreTabla." where estado<>'6' ";		
		$Consulta.= " and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		if ($CmbSubProducto != "S")
		{
			$SubProd=explode('~',$CmbSubProducto);
			$Consulta.= " and cod_producto = '".$SubProd[0]."' ";
			$Consulta.= " and cod_subproducto = '".$SubProd[1]."' ";
		}
		if ($CmbProveedor != "S")
			$Consulta.= " and rut_prv = '".$CmbProveedor."' ";
		$Consulta.= " and cod_producto <> '' group by fecha order by fecha ";
		break;
	case "L";
		$Consulta = "SELECT distinct cod_producto, cod_subproducto, lpad(cod_subproducto,4,'0') as orden  ";
		$Consulta.= " from ".$NombreTabla." where lote between '".$TxtLoteIni."' and '".$TxtLoteFin."' and estado<>'6' ";
		if ($CmbSubProducto != "S")
		{
			$SubProd=explode('~',$CmbSubProducto);
			$Consulta.= " and cod_producto = '".$SubProd[0]."' ";
			$Consulta.= " and cod_subproducto = '".$SubProd[1]."' ";
		}
		if ($CmbProveedor != "S")
			$Consulta.= " and rut_prv = '".$CmbProveedor."' ";
		$Consulta.= " and cod_producto <> '' order by orden ";
		break;
	case "C":
		$Consulta = "SELECT distinct cod_producto, cod_subproducto, conjunto, lpad(conjunto,4,'0') as orden  ";
		$Consulta.= " from ".$NombreTabla." where conjunto between '".$TxtConjIni."' and '".$TxtConjFin."'  and estado<>'6' ";	
		$Consulta.= " and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
		if ($CmbSubProducto != "S")
		{
			$SubProd=explode('~',$CmbSubProducto);
			$Consulta.= " and cod_producto = '".$SubProd[0]."' ";
			$Consulta.= " and cod_subproducto = '".$SubProd[1]."' ";
		}
		if ($CmbProveedor != "S")
			$Consulta.= " and rut_prv = '".$CmbProveedor."' ";
		$Consulta.= " and cod_producto <> '' order by orden ";
		break;
	case "P":		
		$Consulta = "SELECT distinct rut_prv,guia_despacho,correlativo from ".$NombreTabla." where estado<>'6' ";		
		$Consulta.= " and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		if ($CmbSubProducto != "S")
		{
			$SubProd=explode('~',$CmbSubProducto);
			$Consulta.= " and cod_producto = '".$SubProd[0]."' ";
			$Consulta.= " and cod_subproducto = '".$SubProd[1]."' ";
		}
		if ($CmbProveedor != "S")
			$Consulta.= " and rut_prv = '".$CmbProveedor."' ";
		$Consulta.= " and cod_producto <> '' and rut_prv<>'S' group by rut_prv order by rut_prv ";
		break;
}
//echo $Consulta."<br><br>";
$Resp01 = mysqli_query($link, $Consulta);	
while ($Fila01 = mysqli_fetch_array($Resp01))	
{	
	switch ($OpcConsulta)
	{
		case "F":
			echo "<tr class='ColorTabla01'>\n";		
			echo "<td align='center' colspan='".$ColSpan."'><strong>".substr($Fila01["fecha"],8,2)."-".substr($Fila01["fecha"],5,2)."-".substr($Fila01["fecha"],0,4)."</strong></td>\n";			
			echo "</tr>\n";
			break;
		case "P":
			echo "<tr class='ColorTabla01'>\n";
			switch($CmbTipoRegistro)	
			{
				case "R":
					$NomProveedor="";
					$RutAux = $Fila01["rut_prv"];
					$Consulta = "SELECT * ";
					$Consulta.= " from sipa_web.proveedores ";
					$Consulta.= " where rut_prv='".$RutAux."'";
					$Consulta.= " order by TRIM(nombre_prv) ";
					$RespProv = mysqli_query($link, $Consulta);	
					while ($FilaProv = mysqli_fetch_array($RespProv))
					{
						$NomProveedor = $FilaProv["nombre_prv"];
					}
					break;
				case "D":
					//echo $Fila01["rut_prv"]." - ".$Fila01["correlativo"]." - ".$Fila01["guia_despacho"]."<br>";
					ObtenerProveedorDespacho('D',$Fila01["rut_prv"],$Fila01["correlativo"],$Fila01["guia_despacho"],$RutProved,$NombreProved,$link);
					$NomProveedor = $NombreProved;
					break;
			}
			echo "<td align='center' colspan='".$ColSpan."'>".$Fila01["rut_prv"]." - ".$NomProveedor."</td>";
			echo "</tr>\n";
			break;
	}
	switch ($OpcConsulta)
	{		
		case "F":
			$Consulta = "SELECT distinct cod_producto, cod_subproducto, lpad(cod_subproducto,3,'0') as orden ";
			$Consulta.= " from ".$NombreTabla." where estado<>'6' ";
			if ($CmbSubProducto != "S")
			{
				$SubProd=explode('~',$CmbSubProducto);
				$Consulta.= " and cod_producto = '".$SubProd[0]."' ";
				$Consulta.= " and cod_subproducto = '".$SubProd[1]."' ";
			}
			if ($CmbProveedor != "S")
				$Consulta.= " and rut_prv = '".$CmbProveedor."' ";
			$Consulta.= " and fecha between '".$Fila01["fecha"]."' and '".$Fila01["fecha"]."'";	
			$Consulta.= " and cod_producto <> '' group by cod_producto,cod_subproducto order by orden ";
			break;
		case "L":
			$Consulta = $Consulta;
			break;
		case "C":
			$Consulta = $Consulta;
			break;
		case "P":		
			$Consulta = "SELECT distinct rut_prv, cod_producto, cod_subproducto, lpad(cod_subproducto,3,'0') as orden ";
			$Consulta.= " from ".$NombreTabla."  where estado<>'6' and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";		
			if ($CmbSubProducto != "S")
			{
				$SubProd=explode('~',$CmbSubProducto);
				$Consulta.= " and cod_producto = '".$SubProd[0]."' ";
				$Consulta.= " and cod_subproducto = '".$SubProd[1]."' ";
			}
			$Consulta.= " and rut_prv = '".$Fila01["rut_prv"]."' ";
			$Consulta.= " and cod_producto <> '' group by rut_prv order by orden ";
			break;
	}
	//echo $Consulta."<br>";
	$RespAux = mysqli_query($link, $Consulta);
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{
		//TITULO		
		$Consulta = "SELECT * from proyecto_modernizacion.productos where cod_producto = '".$FilaAux["cod_producto"]."'";
		$RespJ = mysqli_query($link, $Consulta);
		if ($FilaJ = mysqli_fetch_array($RespJ))
		{
			//$PProd = $FilaJ["producto"];
			if(isset($FilaJ["producto"])){
				$PProd = $FilaJ["producto"];
			}else{
				$PProd = "";
			}
			$DProd = $FilaJ["abreviatura"];
		}
		$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
		$Consulta.= "where cod_producto = '".$FilaAux["cod_producto"]."' and cod_subproducto='".$FilaAux["cod_subproducto"]."'";
		$RespAux2 = mysqli_query($link, $Consulta);
		if ($FilaAux2 = mysqli_fetch_array($RespAux2))
			$NomSubProd = $FilaAux2["descripcion"];
		else
			$NomSubProd = "SIN IDENTIFICACION";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td align='left' colspan='".$ColSpan."'>".$DProd." - ".str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>\n";
		echo "</tr>\n";
		echo "<tr class='ColorTabla02'>\n";
		if ($OpcConsulta!="C")
			echo "<td align='center'>Fecha</td>\n";
		else
			echo "<td align='center'>Conjto</td>\n";
		echo "<td align='center'>Lote</td>\n";
		if ($OpcTR=="R")
		{	
			echo "<td align='center'>Rec.</td>\n";
			echo "<td align='center'>U</td>\n";
			echo "<td align='center'>Correl.</td>\n";
			echo "<td align='center'>Patente</td>\n";
			echo "<td align='center'>Guia</td>\n";
			echo "<td align='center'>Hora.E</td>\n";
			echo "<td align='center'>Hora.S</td>\n";
			if($CmbTipoRegistro=='R'&&$OpcConsulta!="C")	
				echo "<td align='center'>Conj.</td>\n";
			echo "<td align='center'>P.Bruto<br>Kg.</td>\n";
			echo "<td align='center'>P.Tara<br>Kg.</td>\n";
		}
		else
		{
			if ($CmbTipoRegistro=='R'&&$OpcConsulta!="C")
				echo "<td align='center'>Conj.</td>\n";
		}
		echo "<td align='center'>P.Neto<br>Kg.</td>\n";
		echo "</tr>\n";
		$Consulta = "SELECT distinct lote, recargo, rut_prv, sum(peso_neto) as peso_hum,  ";
		$Consulta.= " lpad(recargo,2,'0') as orden, fecha,patente,guia_despacho,correlativo,ult_registro,peso_tara,peso_bruto,hora_entrada,hora_salida ";
		if ($OpcConsulta=="C"||$CmbTipoRegistro=='R')
			$Consulta.= " , conjunto ";
		$Consulta.= " from ".$NombreTabla." where estado<>'A' and lote<>''";
		$Consulta.= " and cod_producto = '".$FilaAux["cod_producto"]."' ";
		$Consulta.= " and cod_subproducto = '".$FilaAux["cod_subproducto"]."' ";
		switch ($OpcConsulta)
		{
			case "F":
				$Consulta.= " and fecha between '".$Fila01["fecha"]."' and '".$Fila01["fecha"]."'";
				break;
			case "L":
				$Consulta.= " and lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
				break;
			case "C":
				$Consulta.= " and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and conjunto = '".$FilaAux["conjunto"]."'";
				break;
			case "P":
				$Consulta.= " and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and rut_prv = '".$FilaAux["rut_prv"]."' ";
				break;
		}
		if ($CmbProveedor != "S" && $OpcConsulta!="P")
			$Consulta.= " and rut_prv = '".$CmbProveedor."' ";
		if ($OpcConsulta!="C")
			$Consulta.= " group by lote, recargo order by lote, orden";
		else
			$Consulta.= " group by conjunto, lote, recargo order by conjunto, lote, orden";
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		for ($i = 0; $i <=mysqli_num_rows($Resp) - 1; $i++)
		{
			if (mysqli_data_seek($Resp, $i)) 
			{
				$TotalLotePesoHum=0; // WSO
				if ($Fila = mysqli_fetch_row($Resp))  
				{        				
					$Lote = $Fila[0];
					$Recargo = $Fila[1];
					$PesoHum = $Fila[3];
					$F_Recep = $Fila[5];
					$Patente = $Fila[6];
					$Guia = $Fila[7];
					$Corr = $Fila[8];
					$Ult_Reg = $Fila[9];
					$PTara = $Fila[10];
					$PBruto = $Fila[11];
					$HoraE = $Fila[12];
					$HoraS = $Fila[13];
					//if ($OpcConsulta == "C")
						$N_Conjto = $Fila[14];	
					if ($OpcTR=="R")
					{
						echo "<tr>\n";
						if ($OpcConsulta != "C")
							echo "<td align='center'>".substr($F_Recep,8,2)."/".substr($F_Recep,5,2)."</td>\n";
						else
							echo "<td align='center'>".$N_Conjto."</td>\n";
						echo "<td align='center'>".$Lote."</td>\n";
						echo "<td align='center'>".$Recargo."</td>\n";
						echo "<td align='center'>".$Ult_Reg."</td>\n";
						echo "<td align='center'>".$Corr."</td>\n";
						echo "<td align='center'>".$Patente."</td>\n";
						echo "<td align='center'>".$Guia."</td>\n";
						echo "<td align='center'>".$HoraE."</td>\n";
						echo "<td align='center'>".$HoraS."</td>\n";
						if ($OpcConsulta!="C" && $CmbTipoRegistro=='R')
							echo "<td align='center'>".$N_Conjto."</td>\n";
						echo "<td align='center'>".$PBruto."</td>\n";
						echo "<td align='center'>".$PTara."</td>\n";
						echo "<td align='center'>".number_format($PesoHum,0,",",".")."</td>\n";
					}
					//TOTAL LOTE
					$TotalLotePesoHum = $TotalLotePesoHum + $PesoHum;
					//CONSULTO POR EL LOTE O CONJUNTO QUE SIGUE
					$Totalizar=true;	
					$i++;
					if ($i<=mysqli_num_rows($Resp)-1)
					{
						if (mysqli_data_seek($Resp, $i))
						{
							if ($Fila = mysqli_fetch_row($Resp))	
							{	 
								$Sgte = $Fila[0]; //LOTE									
								if ($Lote==$Sgte)
									$Totalizar=false;																				
							}								
						}								
						$i--;
					}					
					if ($Totalizar)
					{
						if ($OpcTR=="R")	
							echo "<tr class='ColorTabla02'>\n";
						else
							echo "<tr>\n";
						$Negrita01 = "<strong>";
						$Negrita02 = "</strong>";
						if ($OpcTR=="R")			
							echo "<td colspan='".$ColSpanSubTotal."' align='left'>".$Negrita01."Total Lote:&nbsp;".$Lote."".$Negrita02."</td>\n";
						else
						{
							$Negrita01 = "";
							$Negrita02 = "";
							if ($OpcConsulta != "C")
								echo "<td align='center'>".substr($F_Recep,8,2)."/".substr($F_Recep,5,2)."</td>\n";
							else
								echo "<td align='center'>".$N_Conjto."</td>\n";
							//echo "<td colspan='".($ColSpanSubTotal-1)."' align='center'>".$Negrita01."".$Lote."".$Negrita02."</td>\n";
							echo "<td align='center'>".$Negrita01."".$Lote."".$Negrita02."</td>\n";
							if ($OpcConsulta!="C"&&$CmbTipoRegistro=='R')
								echo "<td align='center'>".$N_Conjto."</td>\n";							
						}
						echo "<td align='center'>".$Negrita01."".number_format($TotalLotePesoHum,$Decimales,",",".")."".$Negrita02."</td>\n";
						echo "</tr>\n";
						$SubTotalPesoHum = $SubTotalPesoHum + $TotalLotePesoHum;
						$TotalLotePesoHum = 0;
					}//FIN TOTAL LOTE
					echo "</tr>\n";
				}
			}
		}
		//SUB-TOTAL 
		echo "<tr class='ColorTabla03' bgcolor='#FFFFFF'>\n";
		echo "<td colspan='".$ColSpanSubTotal."' align='left'><font color='blue'><strong>";
		switch ($OpcConsulta)
		{			
			case "F":		
				echo "Total Prod.&nbsp;".str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT);
				break;
			case "L":
				echo "Total Prod.&nbsp;".str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT);
				break;
			case "C":
				echo "Total Conjto:&nbsp;".$N_Conjto;				
				break;
			case "P":
				echo "Total Prod.&nbsp;";
				echo str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT);
				break;
		}				
		echo "</strong></font></td>\n";
		echo "<td align='center'><font color='blue'><strong>".number_format($SubTotalPesoHum,$Decimales,",",".")."</strong></font></td>\n";
		echo "</tr>\n";
		$TotalPesoHum = $TotalPesoHum + $SubTotalPesoHum;
		$SubTotalPesoHum = 0;
	}
	//TOTAL
	switch ($OpcConsulta)
	{
		case "F":
			echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan='".$ColSpanSubTotal."' align='left'><strong>Total Dia&nbsp;".substr($Fila01["fecha"],8,2)."/".substr($Fila01["fecha"],5,2)."</strong></td>\n";
			break;
		case "P":
			echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan='".$ColSpanSubTotal."' align='left'><strong>Total Proveedor</strong></td>\n";
			break;
		default:
			echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan='".$ColSpanSubTotal."' align='left'><strong>Total Consulta</strong></td>\n";
			break;
	}
	echo "<td align='center'><strong>".number_format($TotalPesoHum,$Decimales,",",".")."</strong></td>\n";
	echo "</tr>\n";
	if ($OpcConsulta!="F" && $OpcConsulta!="P")
		break;
	else
		$TotalPesoHum = 0;
}	
echo "</table>\n";
?>  
</form>
</body>
</html>