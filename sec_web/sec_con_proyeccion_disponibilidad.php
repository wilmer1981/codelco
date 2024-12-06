<?php
	include("../principal/conectar_principal.php");
	set_time_limit(3000);

	$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	
	if(strlen($mes)==1)
		$mes = "0".$mes;
?>
<html>
<head>
<title>CONSULTA PROYECCION DISPONIBILIDAD CATODOS GRADO A</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "C":
			f.action = "sec_con_proyeccion_disponibilidad.php?Buscar=S";
			f.submit();
			break;
		case "I":
			f.BtnExcel.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnExcel.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "E":
			f.action = "sec_con_proyeccion_disponibilidad_excel.php?Buscar=S";
			f.submit();
			break;
		case "S":
			f.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
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
    <td colspan="2"><strong>PROYECCION DISPONIBILIDAD CATODOS GRADO A</strong></td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF">MES/A&Ntilde;O</td>
    <td width="401">
      <SELECT name="mes" size="1">
        <?php
		for($i=1;$i<13;$i++)
		{
			if (($Buscar == "S") && ($i == $mes))
				echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]." </option>";
			else if (($i == date("n")) && ($Buscar != "S"))
					echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$Meses[$i-1]."</option>\n";			
		}		  
	   ?>
      </SELECT>  
      <SELECT name="ano" size="1">
        <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($Buscar == "S") && ($i == $ano))
				echo "<option SELECTed value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($Buscar != "S"))
				echo "<option SELECTed value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
      </SELECT> <input name="BtnConsultar" type="button" value="Consultar" style="width:70px " onClick="Proceso('C')">   
	  </td>
  </tr>
  <tr align="center">
    <td height="30" colspan="2">
      <input name="BtnExcel" type="button" style="width:70px " onClick="Proceso('E')" value="Excel">	  
      <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td></tr>
</table><br>
<table width="1200" border="1" align="center" cellpadding="2" cellspacing="0" >
  <tr class="ColorTabla02">
    <td rowspan="3" align="center">Dia</td>
    <td colspan="7" align="center">PRODUCCION</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td colspan="7" align="center">PESAJE</td>
	<td colspan="7" align="center">REQUERIMIENTOS</td>
    </tr>
  <tr class="ColorTabla02">
    <td colspan="3" align="center">PROGRAMA</td>
    <td colspan="3" align="center">REAL</td>
	<td rowspan="2" align="center">DIFER</td>
    <td colspan="2" align="center">COMPROMISO</td>
    <td colspan="3" align="center">PROGRAMA</td>
    <td colspan="2" align="center">REAL</td>
	<td rowspan="2" align="center">DIFER<br>DIA</td>
	<td rowspan="2" align="center">DIFER<BR>ACUM</td>
	<td colspan="2" align="center">PROGRAMA PROD</td>
	<td colspan="2" align="center">REQUERIMIENTO</td>
	<td rowspan="2" align="center">GUIA<BR>DESPACHO</td>
	<td rowspan="2" align="center">DIF</td>
	<td rowspan="2" align="center">ACUMULADO</td>
    </tr>
  <tr class="ColorTabla02">
    <td align="center">Refineria</td>
    <td align="center">Catodos</td>
    <td align="center">Acum</td>
	<td align="center">Comercial</td>
    <td align="center">Validada</td>
    <td align="center">Acum.</td>
    <td align="center">Pre-Embarque</td>
    <td align="center">Acum.</td>
    <td align="center">Progr/Pesaje</td>
	<td align="center">Validado %Rech.</td>
	<td align="center">Acum.</td>
    <td align="center">Validada</td>
    <td align="center">Acum.</td>
	<td align="center">Catodo."A".</td>
	<td align="center">Acum.</td>
	<td align="center">ETA</td>
	<td align="center">Acum.</td>
	
    </tr>

<?php

if($Buscar=='S')
{
	$FechaIniMes=$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-01";
	$UltDiasMes=date("Y-m-d", mktime(1,0,0,intval($mes)+1,1-1,$ano));
	$Dias=intval(substr($UltDiasMes,8));
	$TotProdRef=0;$TotProdCat=0;$TotProdReal=0;$TotProgPesaje=0;$TotProgValidado=0;$TotPesajeReal=0;
	$AcumCat=0;$AcumProdReal=0;$AcumCompPree=0;$AcumProgPesaje=0;$AcumProgPesaje2=0;$AcumProgValidado=0;
	//echo "DIAS:".$Dias;
	for($i=1;$i<=$Dias;$i++)
	{
		$FechaIni=$ano."-".$mes."-".$i;
		$Consulta = "SELECT d_catodo_comercial as peso from sec_web.det_programa_produccion";
		$Consulta.= " where fecha_programa = '".$FechaIni."'";
		$Consulta.= " and cod_revision = '1'";
		$Respuesta = mysqli_query($link, $Consulta);
		$ProdRef =0;
		if ($Fila = mysqli_fetch_array($Respuesta))
			$ProdRef = $Fila["peso"];
		$TotProdRef=$TotProdRef+$ProdRef;	
	}
	$ProgPesaje=$TotProdRef/$Dias;	
	$Consulta="SELECT factor_rechazo,factor_rechazo_prog,dia from sec_web.parametros_mensual_proyeccion where ano='".$ano."' and mes='".$mes."'";

	$Respuesta = mysqli_query($link, $Consulta);
	$FactorRechazo=0;
	$PorcRechazoProg=0; // $PorcRechazo ??
	$DiaCierre=0;
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$FactorRechazo = $Fila["factor_rechazo"];
		$PorcRechazoProg=$Fila["factor_rechazo_prog"];
		$DiaCierre=intval($Fila["dia"]);
	}	
	$Consulta="SELECT tonelaje from sec_web.parametros_mensual_proyeccion where ano='".$ano."' and mes='".$mes."'";

	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
		$AcumProgPesaje2 = $Fila["tonelaje"];
	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = '3004' and cod_subclase='".intval($mes)."'";		
	$rs = mysqli_query($link, $consulta);
	$row = mysqli_fetch_array($rs);
	$LetraMes=$row["nombre_subclase"];
	
	$CantDiasNeg=0;
	$AcumPesajeReal=0;
	$AcumDifGuia=0;
	$AcumEta=0;
	for($i=1;$i<=$Dias;$i++)
	{
		echo "<tr>";
		echo "<td>".$i."</td>";
		$FechaIni=$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".$i;
		$FechaFin=date("Y-m-d", mktime(0,0,0,$mes,$i+1,$ano));
		$FechaIniHora=$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT)." 08:00:00";
		$FechaFinHora=date("Y-m-d", mktime(0,0,0,$mes,$i+1,$ano))." 07:59:59";
		$Consulta = "SELECT d_catodo_comercial as peso from sec_web.det_programa_produccion";
		$Consulta.= " where fecha_programa = '".$FechaIni."'";
		$Consulta.= " and cod_revision = '1'";
		$Respuesta = mysqli_query($link, $Consulta);
		$ProdRef =0;
		if ($Fila = mysqli_fetch_array($Respuesta))
			$ProdRef = $Fila["peso"];
		echo "<td align='center'>".number_format($ProdRef,1,',','.')."</td>";
		echo "<td align='center'>".number_format(round($ProdRef*$FactorRechazo),0,',','.')."</td>";
		$TotProdCat=$TotProdCat+round($ProdRef*$FactorRechazo);	
		echo "<td align='center'>".number_format(round($AcumCat),0,',','.')."</td>";
		$AcumCat2=$AcumCat;
		$AcumCat=$AcumCat+$ProdRef*$FactorRechazo;	
		$Consulta="SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo where ((fecha_produccion = '".$FechaIni."' and hora>='08:00:00') or (fecha_produccion = '".$FechaFin."' and hora<='07:59:59')) and cod_producto='18' and cod_subproducto='1'";
		$Respuesta = mysqli_query($link, $Consulta);
		$ProdReal=0;
		if ($Fila = mysqli_fetch_array($Respuesta))
			$ProdReal = $Fila["peso"]/1000;
		echo "<td align='center'>".number_format($ProdReal,3,',','.')."</td>";
		$TotProdReal=$TotProdReal+$ProdReal;
		ObtienePorcRechazo($FechaIniMes,$FechaIni,$FechaFin,$LetraMes,$PorcRechazoProg,$link);
		echo "<td align='center'>".number_format($ProdReal*$PorcRechazoProg,3,',','.')."</td>";
		echo "<td align='center'>".number_format(round($AcumProdReal),0,',','.')."</td>";
		$AcumProdReal=$AcumProdReal+$ProdReal;
		echo "<td align='center'>".number_format(round(($ProdReal*$PorcRechazoProg)-($ProdRef*$FactorRechazo)),0,',','.')."</td>";
		$Peso=0;//WSO
		ObtieneCompPreembarque($FechaIni,$Peso,$link);
		$CompPree = $Peso;
		echo "<td align='center'>".number_format(round($CompPree),0,',','.')."</td>";
		echo "<td align='center'>".number_format(round($AcumCompPree),0,',','.')."</td>";
		$AcumCompPree=$AcumCompPree+$CompPree;
		echo "<td align='center'>".number_format(round($ProgPesaje),0,',','.')."</td>";
		$TotProgPesaje=$TotProgPesaje+$ProgPesaje;

		if($PorcRechazoProg!=0)
			$ProgValidado=$ProgPesaje*$PorcRechazoProg;
		else
			$ProgValidado=$ProgPesaje;

		echo "<td align='center'>".number_format($ProgValidado,0,',','.')."</td>";
		$TotProgValidado=$TotProgValidado+$ProgValidado;
		$AcumProgValidado=$AcumProgValidado+$ProgValidado;
		echo "<td align='center'>".number_format($AcumProgValidado,0,',','.')."</td>";

		ObtienePesajeReal($FechaIni,$FechaFin,$LetraMes,$Peso,$link);
		$PesajeReal = $Peso;
		echo "<td align='center'>".number_format(round($PesajeReal),0,',','.')."</td>";
		$TotPesajeReal=$TotPesajeReal+$PesajeReal;
		$AcumPesajeReal=$AcumPesajeReal+$PesajeReal;
		echo "<td align='center'>".number_format(round($AcumPesajeReal),0,',','.')."</td>";
		if($i>$DiaCierre)
		{
			if(($PesajeReal/1000)-$ProgValidado<0)
				$CantDiasNeg=$CantDiasNeg+1;
			else
				$CantDiasNeg=0;
			if($CantDiasNeg>=3)
			{
				echo "<td align='center' bgcolor='#FF0000'>".number_format(($PesajeReal/1000)-$ProgValidado,3,',','.')."</td>";
				$CantDiasNeg=0;
			}	
			else
				echo "<td align='center' >".number_format(($PesajeReal/1000)-$ProgValidado,3,',','.')."</td>";
			echo "<td align='center'>".number_format(($AcumPesajeReal/1000)-$AcumProgValidado,3,',','.')."</td>";	
		}
		else
		{
			echo "<td align='center' >0</td>";		
			echo "<td align='center' >0</td>";		
		}	
		echo "<td align='center'>".number_format(round($ProdRef*$FactorRechazo),0,',','.')."</td>";
		echo "<td align='center'>".number_format(round($AcumCat2),0,',','.')."</td>";
		ObtieneEta($FechaIni,$Peso,$link);
		$PesoEta=$Peso;
		echo "<td align='center'>".number_format(round($PesoEta),0,',','.')."</td>";
		$AcumEta=$AcumEta+$PesoEta;
		echo "<td align='center'>".number_format(round($AcumEta),0,',','.')."</td>";
		ObtienePesoGuiasDespacho($FechaIni,$Peso,$link);
		$PesoGuia=$Peso;
		echo "<td align='center'>".number_format(($PesoGuia/1000),1,',','.')."</td>";
		$DifGuia=$PesoEta-($PesoGuia/1000);
		echo "<td align='center'>".number_format($DifGuia,1,',','.')."</td>";
		$AcumDifGuia=$AcumDifGuia+$DifGuia;
		echo "<td align='center'>".number_format($AcumDifGuia,1,',','.')."</td>";
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>".number_format($TotProdRef,1,',','.')."</td>";
	echo "<td align='center'>".number_format($TotProdCat,0,',','.')."</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>".number_format($TotProdReal,3,',','.')."</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>".number_format($TotProgPesaje,0,',','.')."</td>";
	echo "<td align='center'>".number_format($ProgValidado,0,',','.')."</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>".number_format($TotPesajeReal,0,',','.')."</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "<td align='center'>&nbsp;</td>";
	echo "</tr>";
}

function ObtienePesajeReal($FechaIni,$FechaFin,$LetraMes,$Peso,$link)
{

	$Peso=0;
	$CrearTmp ="create table if not exists sec_web.tmpConsultaEmb2 "; 
	$CrearTmp =$CrearTmp."(subproducto varchar (30),corr_ie bigint(8),cliente_nave varchar(30),";
	$CrearTmp =$CrearTmp."toneladas bigint(8),marca varchar(10),cod_lote varchar(1),num_lote_inicio varchar(12),";
	$CrearTmp =$CrearTmp."num_lote_final varchar(12),paquetes bigint(8),catodos bigint(8),peso_neto bigint(8))";
	mysqli_query($link, $CrearTmp);
	$Eliminar="delete from sec_web.tmpConsultaEmb2";
	mysqli_query($link, $Eliminar);

	$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,";
	$Consulta.="t4.cantidad_programada as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,";
	$Consulta.="t1.cod_marca,sum(peso_paquetes) as peso_neto,";
	$Consulta.="(case when not isnull(t5.nombre_cliente) then t5.nombre_cliente else t6.nombre_nave end) as nombre_cliente ";
	$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
	$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
	$Consulta.="inner join sec_web.programa_codelco t4 on t1.corr_enm=t4.corr_codelco ";
	$Consulta.="left join sec_web.cliente_venta t5 on t4.cod_cliente=t5.cod_cliente ";
	$Consulta.="left join sec_web.nave t6 on ceiling(t4.cod_cliente)=t6.cod_nave ";
	$Consulta.="where t2.cod_paquete='".$LetraMes."' and ((t2.fecha_creacion_paquete = '".$FechaIni."' and t2.hora>='08:00:00')";
	$Consulta.=" or (t2.fecha_creacion_paquete = '".$FechaFin."' and t2.hora<='07:59:59')) and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
	$Consulta.=" and t2.cod_producto='18' and t2.cod_subproducto='40' group by t1.corr_enm,t1.cod_paquete";
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Insertar="INSERT INTO sec_web.tmpConsultaEmb2(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
		$Insertar.="'".$Fila["subproducto"]."','".$Fila["corr_enm"]."','".$Fila["nombre_cliente"]."','".$Fila["toneladas"]."','".$Fila["cod_marca"]."','".$Fila["cod_paquete"]."','".$Fila["lote_inicio"]."','".$Fila["lote_final"]."','".$Fila["paquetes"]."','".$Fila["catodos"]."','".$Fila["peso_neto"]."')";
		mysqli_query($link, $Insertar);
	}
	$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,";
	$Consulta.="t4.peso_programado as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,";
	$Consulta.="t1.cod_marca,sum(peso_paquetes) as peso_neto ";
	$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
	$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
	$Consulta.="inner join sec_web.instruccion_virtual t4 on t1.corr_enm=t4.corr_virtual ";
	$Consulta.="where t2.cod_paquete='".$LetraMes."' and ((t2.fecha_creacion_paquete = '".$FechaIni."' and t2.hora>='08:00:00')";
	$Consulta.=" or (t2.fecha_creacion_paquete = '".$FechaFin."' and t2.hora<='07:59:59')) and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.=" and t2.cod_producto='18' and t2.cod_subproducto='40' group by t1.corr_enm";
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Insertar="INSERT INTO sec_web.tmpConsultaEmb2(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
		$Insertar.="'".$Fila["subproducto"]."','".$Fila["corr_enm"]."','','".$Fila["toneladas"]."','".$Fila["cod_marca"]."','".$Fila["cod_paquete"]."','".$Fila["lote_inicio"]."','".$Fila["lote_final"]."','".$Fila["paquetes"]."','".$Fila["catodos"]."','".$Fila["peso_neto"]."')";
		mysqli_query($link, $Insertar);
	}
	$Consulta="SELECT * from sec_web.tmpConsultaEmb2";
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Peso=$Peso+$Fila["peso_neto"];				
	}

}

function ObtieneCompPreembarque($FechaInicio,$Peso,$link)
{

	//CONSULTA TABLA PROGRAMA ENAMI
	$Peso=0;
	$Consulta="SELECT cantidad_programada as peso_neto from sec_web.programa_codelco ";
	$Consulta=$Consulta." where cod_producto='18' and cod_subproducto='40' and fecha_disponible = '".$FechaInicio."'";
	$Resultado=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		$Peso=$Peso+$Fila["peso_neto"];		
	}
}
function ObtieneEta($FechaInicio,$Peso,$link)
{

	//CONSULTA TABLA PROGRAMA ENAMI
	$Peso=0;
	$Consulta="SELECT cantidad_programada as peso_neto from sec_web.programa_codelco ";
	$Consulta=$Consulta." where cod_producto='18' and cod_subproducto='40' and fecha_devolucion_maquila = '".$FechaInicio."'";
	$Resultado=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		$Peso=$Peso+$Fila["peso_neto"];		
	}
}
 //$PorcRechazoProg era.... $PorcRechazo
function ObtienePorcRechazo($FechaIniMes,$FechaInicio,$FechaTermino,$LetraMes,$PorcRechazoProg,$link)
{

	$Consulta = "SELECT * from sec_web.informe_diario ";
	$Consulta.= " where fecha = '".$FechaInicio."'";
	$Resp = mysqli_query($link, $Consulta);
	$PaqStandard=0;
	$PaqStandardGranel=0;
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$PaqStandard = $Fila["peso_paquete_standard"];
		$PaqStandardGranel = $Fila["peso_standard_granel"];
	}
	//ACUMULADO COMERCIAL
	$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
	$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$FechaIniMes." 08:00:00' AND '".$FechaTermino." 07:59:59'";
	$Consulta.= " and cod_producto = '18'";
	$Consulta.= " and cod_subproducto = '1'";
	$Respuesta = mysqli_query($link, $Consulta);
	$ComercialAcumulado=0;
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$ComercialAcumulado = $Fila["peso"];
	}

	//PESADO A EMBARQUE STANDARD
	$Consulta = " SELECT sum(peso_paquetes) as peso";
	$Consulta.= " FROM sec_web.paquete_catodo ";
	$Consulta.= " where CONCAT(fecha_creacion_paquete,' ',hora) BETWEEN '".$FechaIniMes." 08:00:00' AND '".$FechaTermino." 07:59:59'";
	$Consulta.= " and cod_producto = '18'";
	$Consulta.= " and cod_paquete = '".$LetraMes."'";
	$Consulta.= " and cod_subproducto = '46'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesadoEmbarque = $Fila["peso"];
	}
	$PqtesSinPesarGranel = ($PaqStandard + $PaqStandardGranel) * 1000;
	$StandardAcumulado = $PesadoEmbarque + $PqtesSinPesarGranel;
	//PORCENTAJE DE STANDARD
	if($ComercialAcumulado<>0)
		$PorcRechazoProg =round((100-(100 * ($StandardAcumulado/$ComercialAcumulado)))/100,4);

}
function ObtienePesoGuiasDespacho($FechaInicio,$Peso,$link)
{

	//CONSULTA TABLA  GUIAS DE DESPACHO
	$Peso=0;
	$Consulta = "SELECT sum(t2.peso_paquetes) as peso  ";
	$Consulta.= "from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
	$Consulta.= "on t1.num_guia=t2.num_guia inner join proyecto_modernizacion.subproducto t4  ";
	$Consulta.= "on t2.cod_producto = t4.cod_producto and t2.cod_subproducto = t4.cod_subproducto  ";
	$Consulta.= "where t1.cod_estado <>'A'  and t1.fecha_guia = '".$FechaInicio."'";
	$Consulta.= " and t2.cod_estado = 'c' and t2.cod_producto='18' and t2.cod_subproducto='40'";
	$Consulta.= "group by t2.cod_producto, t2.cod_subproducto ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Peso=$Fila["peso"];
	}
}
?>
</table>
</form>
</body>
</html>