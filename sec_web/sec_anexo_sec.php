<?php
	include("../principal/conectar_principal.php");
	
	include("sec_anexo_sec_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
	$CodigoDeSistema = 16;
	$CodigoDePantalla = 2;
	set_time_limit(1000);
	/*$Consulta="select * from sea_web.movimientos_c";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		$FecMov=explode('-',$Fila["fecha_movimiento"]);
		$FecMov=$FecMov[2]."-".$FecMov[1]."-".$FecMov[0];
		$FecBen=explode('-',$Fila[fecha_benef]);
		$FecBen=$FecBen[2]."-".$FecBen[1]."-".$FecBen[0];
		$FechaAux=explode(' ',$Fila[hora]);
		$Fecha=explode('-',$FechaAux[0]);
		$Hora=$FechaAux[1];
		$FechaHora=$Fecha[2]."-".$Fecha[1]."-".$Fecha[0]." ".$Hora;
		$Insertar="INSERT INTO sea_web.movimientos (`tipo_movimiento`,`cod_producto`,`cod_subproducto`,`hornada`,`numero_recarga`,`fecha_movimiento`,`campo1`,`campo2`,`unidades`,`flujo`,`fecha_benef`,`peso`,`estado`,`lote_ventana`,`peso_origen`,`zuncho`,`hora`) VALUES ";
		$Insertar.="('".$Fila[tipo_movimiento]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila[hornada]."','".$Fila[numero_recarga]."','".$FecMov."','".$Fila[campo1]."','".$Fila[campo2]."','".$Fila["unidades"]."','".$Fila["flujo"]."','".$FecBen."',";
		$Insertar.="'".$Fila["peso"]."','".$Fila["estado"]."','".$Fila[lote_ventana]."','".$Fila[peso_origen]."','".$Fila[zuncho]."','".$FechaHora."')";
		echo $Insertar."<br>";
		mysqli_query($link, $Insertar);
	}*/
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
	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}

	if(isset($_REQUEST["CodSistema"])){
		$CodSistema = $_REQUEST["CodSistema"];
	}else{
		$CodSistema = "";
	}
/*
	if(isset($_REQUEST["PesoMes"])){
		$PesoMes = $_REQUEST["PesoMes"];
	}else{
		$PesoMes = "";
	}*/
	if(isset($_REQUEST["FinoAg"])){
		$FinoAg = $_REQUEST["FinoAg"];
	}else{
		$FinoAg = "";
	}
	if(isset($_REQUEST["FinoAu"])){
		$FinoAu = $_REQUEST["FinoAu"];
	}else{
		$FinoAu = "";
	}
	if(isset($_REQUEST["FinoCu"])){
		$FinoCu = $_REQUEST["FinoCu"];
	}else{
		$FinoCu = "";
	}


?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>

#postit{
position:absolute;
width:330;
padding:5px;
background-color:#339999;
border:1px solid black;
visibility:hidden;
z-index:500;
cursor:hand;
}

</style>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=SEC&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("�Esta seguro que desea guardar esta version del Anexo.SEC?");
			if (msg)
			{
				f.action = "sec_anexo_sec01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=16&Nivel=0";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "E":
			f.action = "sec_anexo_sec_excel.php?Mostrar=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "sec_anexo_sec.php?Mostrar=S";
			f.submit(); 
			break;
	}	
}

function Detalle(flu,pag)
{
	var f = frmPrincipal;
	switch (flu)
	{
		case "161":
			pagAux = "sec_con_detalle_ley_comercial.php?Flujo=161&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		case "160":
			pagAux = "sec_con_detalle_ley_desc_parcial.php?Flujo=160&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		case "314":
			pagAux = "sec_con_detalle_ley_ew.php?Flujo=314&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		case "211":
			pagAux = "sec_con_detalle_ley_externos.php?Flujo=211&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		default:
			pagAux = pag;
			break;
	}	
	window.open(pagAux,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">

  <table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center">
      <td height="23" colspan="4" class="ColorTabla02"><strong>ANEXO DEL SISTEMA CATODOS</strong></td>
    </tr>
    <tr>
      <td width="92" height="23">Mes Anexo</td>
      <td width="166">
        <select name="Mes">
          <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
        </select>
        <select name="Ano" size="1">
          <?php
			for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
        </select>
      </td>
      <td  align="right">Cierre Parcial:
      </td>
      <td width="183"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='3' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='3' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
	$Resp = mysqli_query($link, $Consulta);	
	$CierreBalance = false;
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
		{
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
		}
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
?></td>
    </tr>
    <tr>
      <td height="23">&nbsp;</td>
      <td height="23">&nbsp;</td>
      <td height="23" align="right">Cierre General:</td>
      <td height="23"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='3' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='3' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2')";
	$Resp = mysqli_query($link, $Consulta);	
	$CierreBalance = false;
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
		{
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
		}
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
?></td>
    </tr>
    <tr align="center">
      <td height="23" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
          <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
          <?php			  
	if ($Mostrar == "S")
	{		
        echo "<input name='BtnExcel' type='button' style='width:70px;' onClick=\"Proceso('E')\" value='Excel'>\n";
	}
	//Consulto si las existencias del mes estab bloqueadas
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM sec_web.existencia_nodo ";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{		
        echo "<input name='BrnCerrar' type='button' value='Cerrar Mes' style='width:70px;' onClick=\"Proceso('CM')\">";
	}
	else
	{
		if ($CierreBalance == false)
			echo "<input name='BrnAbrir' type='button' value='Abrir Mes' style='width:70px;' onClick=\"Proceso('AM')\">";
	}
?>
          <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
    </tr>
  </table>
  <br>
<br>
  <table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Flujo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
    <?php
	//$Mostrar='N';	
if ($Mostrar == "S")  
{	
	//Consulto si las existencias del mes se pueden borrar.
	$Copiar = "N";
    $Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM sec_web.existencia_nodo ";
    $Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' and bloqueado = '1'";    
   	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);$Copiar="N";
	if ($Fila["valor"] == "0")
	{
		//Elimino las existencia de los Nodos y Flujos
		$Eliminar = "DELETE FROM sec_web.existencia_nodo";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DELETE FROM sec_web.flujos_mes";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Copiar = "S";
	}
	//$Copiar = "S";
	if ($Copiar == "S")
	{
		//RESCATA LEYES
		RescataLeyes($Ano, $Mes, $link);
		//-------------
		$FechaInicio = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
		$FechaTermino = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-31";
		$Consulta = "select distinct cod_flujo, ceiling(cod_flujo) as flujo_orden,descripcion from proyecto_modernizacion.flujos ";
		$Consulta.= " where sistema = 'SEC' and esflujo<>'N' ";
		//$Consulta.= " and cod_flujo in ('','417')";
		$Consulta.= "  order by flujo_orden";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "select * from sec_web.relacion_flujo ";
			$Consulta.= " where flujo = '".$Fila["cod_flujo"]."'";
			//echo $Consulta."<br><br>";
			$Resp2 = mysqli_query($link, $Consulta);
			$Peso = 0;
			$Fino_Cu = 0;
			$Fino_Ag = 0;
			$Fino_Au = 0;
			$Finos = "";
			$PesoAux=0; //WSO
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$TipoMovimiento = $Fila2["tipo_mov"];
				RescataPeso($Fila2["tipo_mov"],$Fila2["cod_producto"],$Fila2["cod_subproducto"],$Fila["cod_flujo"],$FechaInicio,$FechaTermino,$PesoAux,$Fino_Cu,$Fino_Ag,$Fino_Au,$link);
				$Peso = $Peso + $PesoAux;
			}	
			echo "<tr> \n";
			echo "<td align='center'>".$Fila["cod_flujo"]."</td>\n";
			echo "<td><a href=\"JavaScript:Detalle('".$Fila["cod_flujo"]."','sec_con_detalle_flujo.php?TipoMov=".$TipoMovimiento."&Flujo=".$Fila["cod_flujo"]."&Ano=".$Ano."&Mes=".$Mes."')\">";
			echo strtoupper($Fila["descripcion"])."</a></td>\n";		
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
			if($Fila["cod_flujo"]=='238'||$Fila["cod_flujo"]=='239')
			{
				$Fino_Cu=(99.99*$Peso);
				$Fino_Ag=0;
				$Fino_Au=0;
			}
			if ($Fino_Cu > 0 && $Peso > 0)
			{					
				echo "<td align='right'>".substr(number_format(($Fino_Cu/$Peso),4,",","."),0,5)."</td>\n";
				$Fino_Cu = $Fino_Cu / 100;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Cu = 0;
			}
			if ($Fino_Ag > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format(($Fino_Ag/$Peso),2,",",".")."</td>\n";
				$Fino_Ag = $Fino_Ag / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Ag = 0;
			}
			if ($Fino_Au > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format(($Fino_Au/$Peso),2,",",".")."</td>\n";
				$Fino_Au = $Fino_Au / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Au = 0;
			}
			echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
			echo "</tr>\n";
			//INSERTO EN TABLA FLUJO MES
			$Insertar = "INSERT INTO sec_web.flujos_mes ";
			$Insertar.= " (ano, mes, flujo, peso, fino_cu, fino_ag, fino_au) ";
			$Insertar.= " VALUES ('".$Ano."', '".$Mes."', '".$Fila["cod_flujo"]."', ";
			$Insertar.= "'".$Peso."', '".$Fino_Cu."', '".$Fino_Ag."', '".$Fino_Au."')";			
			mysqli_query($link, $Insertar);
		}
	}
	else
	{
		//RESCATO LO YA GENERADO EN EL ANEXO
		$Consulta = "select distinct t1.flujo, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t2.descripcion ";
		$Consulta.= " from sec_web.flujos_mes t1 inner join proyecto_modernizacion.flujos t2 ";
		$Consulta.= " on t1.flujo = t2.cod_flujo ";
		$Consulta.= " where t1.ano = '".$Ano."'";
		$Consulta.= " and t1.mes = '".$Mes."'";
		$Consulta.= " and t2.sistema = 'SEC'";
		$Consulta.= " and t2.esflujo <> 'N'";
		$Consulta.= " order by t1.flujo";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "select * from sec_web.relacion_flujo ";
			$Consulta.= " where flujo = '".$Fila["flujo"]."'";
			$Resp2 = mysqli_query($link, $Consulta);			
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$TipoMovimiento = $Fila2["tipo_mov"];
			}
			$Peso = $Fila["peso"];
			$Fino_Cu = $Fila["fino_cu"];
			$Fino_Ag = $Fila["fino_ag"];
			$Fino_Au = $Fila["fino_au"];
			echo "<tr> \n";
			echo "<td align='center'>".$Fila["flujo"]."</td>\n";
			echo "<td><a href=\"JavaScript:Detalle('".$Fila["flujo"]."','sec_con_detalle_flujo.php?TipoMov=".$TipoMovimiento."&Flujo=".$Fila["flujo"]."&Ano=".$Ano."&Mes=".$Mes."')\">";
			echo strtoupper($Fila["descripcion"])."</a></td>\n";	
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
			if ($Fino_Cu > 0 && $Peso > 0)
			{					
				echo "<td align='right'>".substr(number_format((($Fino_Cu/$Peso)*100),4,",","."),0,5)."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Cu = 0;
			}
			if ($Fino_Ag > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Ag/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Ag = 0;
			}
			if ($Fino_Au > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Au/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Au = 0;
			}
			echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
			echo "</tr>\n";
		}
	}
}
?>
	<tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Nodo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
    <?php
$MesCons = $Mes;
$AnoCons = $Ano;
//$Mostrar='S';	
if ($Mostrar == "S")  
{	
	 //$Copiar='S';
	 if ($Copiar == "S")
	{
		$Unidades = array(2=>100,4=>1000,5=>1000);
		$Consulta = "SELECT DISTINCT t1.nodo, t2.descripcion as nom_nodo ";
		$Consulta.= " FROM proyecto_modernizacion.flujos t1 inner join ";
		$Consulta.= " proyecto_modernizacion.nodos t2 on t1.nodo = t2.cod_nodo";
		$Consulta.= " WHERE t1.sistema = 'SEC' and t2.virtual<>'S' ";
		//$Consulta.= " and t1.nodo='81'";
		$Consulta.= " ORDER BY t1.nodo";
		//echo $Consulta."<br>";
		$RespAux5 = mysqli_query($link, $Consulta);            
		while ($FilaAux5 = mysqli_fetch_array($RespAux5))
		{
			$Nodo=$FilaAux5["nodo"];
			$PesoTotal=0;$AcumFinoCu=0;$AcumFinoAg=0;$AcumFinoAu=0;
			ObtieneExistencias($AnoCons,$MesCons,$Nodo,$PesoTotal,$AcumFinoCu,$AcumFinoAg,$AcumFinoAu,$link);
			if($Nodo=='83')
			{
				$AcumFinoCu=$PesoTotal;
				$AcumFinoAg=0;$AcumFinoAu=0;
			}
			
			echo "<tr> \n";
			echo "<td align='center'>".$Nodo."</td>\n";
			echo "<td><a href=\"JavaScript:Detalle('".$Nodo."','sec_con_detalle_nodo.php?Nodo=".$Nodo."&Ano=".$AnoCons."&Mes=".$MesCons."')\">";
			echo strtoupper($FilaAux5["nom_nodo"])."</td>\n";
			echo "<td align='right'>".number_format($PesoTotal,0,",",".")."</td>\n";
			echo "<td align='right'>";
			if ($AcumFinoCu>0 && $PesoTotal>0)
			echo number_format(($AcumFinoCu/$PesoTotal)*100,2,",",".");
			else
			 echo "0";
			echo "</td>\n";
			echo "<td align='right'>";
			if ($AcumFinoCu>0 && $PesoTotal>0)
			echo number_format(($AcumFinoAg/$PesoTotal)*1000,2,",",".");
			else
			echo "0";
			echo "</td>\n";
			echo "<td align='right'>";
			if ($AcumFinoCu>0 && $PesoTotal>0)
			echo number_format(($AcumFinoAu/$PesoTotal)*1000,2,",",".");
			else
			echo "0";
			echo "</td>\n";
			echo "<td align='right'>".number_format($AcumFinoCu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($AcumFinoAg,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($AcumFinoAu,0,",",".")."</td>\n";
			echo "</tr>\n";	
			$Eliminar = "DROP TABLE IF EXISTS sec_web.tmp_existencias";
			mysqli_query($link, $Eliminar);
			//INSERTO VALORES EN LA TABLA EXISTENCIA NODO	   
			$Insertar = "INSERT INTO sec_web.existencia_nodo ";
			$Insertar.= " (ano,mes,nodo,peso,fino_cu,fino_ag,fino_au)";
			$Insertar.= " VALUES ('".$AnoCons."',";
			$Insertar.= "'".$MesCons."',";
			$Insertar.= "'".$Nodo."',";
			$Insertar.= "'".$PesoTotal."',";
			$Insertar.= "'".$AcumFinoCu."',";
			$Insertar.= "'".$AcumFinoAg."',";
			$Insertar.= "'".$AcumFinoAu."')";
			//echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
			
		}
	}
	else
	{
		//RESCATO ANEXO CREADO BLOQUEADO = 1
		$Consulta = "SELECT t1.nodo, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t2.descripcion ";
		$Consulta.= " from sec_web.existencia_nodo t1 inner join proyecto_modernizacion.nodos t2 ";
		$Consulta.= " on t1.nodo = t2.cod_nodo ";
		$Consulta.= " where t1.ano = '".$Ano."'";
		$Consulta.= " and t1.mes = '".$Mes."'";
		$Consulta.= " and t2.sistema = 'SEC' and t2.virtual<>'S' ";
		$Consulta.= " order by t1.nodo";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Peso = $Fila["peso"];
			$Fino_Cu = $Fila["fino_cu"];
			if ($Fila["nodo"]==98 || $Fila["nodo"]==83)
			{
				$Fino_Ag = 0;
				$Fino_Au = 0;
			}
			else
			{
				$Fino_Ag = $Fila["fino_ag"];
				$Fino_Au = $Fila["fino_au"];
			}			
			echo "<tr> \n";
			echo "<td align='center'>".$Fila["nodo"]."</td>\n";
			echo "<td><a href=\"JavaScript:Detalle('".$Fila["nodo"]."','sec_con_detalle_nodo.php?Nodo=".$Fila["nodo"]."&Ano=".$AnoCons."&Mes=".$MesCons."')\">";
			echo strtoupper($Fila["descripcion"])."</td>\n";		
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
			if ($Fino_Cu > 0 && $Peso > 0)
			{					
				echo "<td align='right'>".substr(number_format((($Fino_Cu/$Peso)*100),4,",","."),0,5)."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Cu = 0;
			}
			if ($Fino_Ag > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Ag/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Ag = 0;
			}
			if ($Fino_Au > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Au/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Au = 0;
			}
			echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
			echo "</tr>\n";
		}
	}
}
?>
  </table> </td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form> 
</body>
</html>
<?php
function ObtieneExistencias($AnoFin,$MesFin,$Nodo,$PesoTotal,$AcumFinoCu,$AcumFinoAg,$AcumFinoAu,$link)
{
	$MesCons = $MesFin;
	$AnoCons = $AnoFin;
	$Unidades = array(2=>100,4=>1000,5=>1000); 
	//$Crear = "CREATE TEMPORARY TABLE sec_web.tmp_existencias (";
	$Crear = "CREATE TEMPORARY TABLE IF NOT EXISTS sec_web.tmp_existencias (";
	$Crear.= " `id` char(2) NOT NULL default '',";
	$Crear.= " `cod_bulto` char(2) NOT NULL default '',";
	$Crear.= " `num_bulto` int(11) NOT NULL default '0',";
	$Crear.= " `ano_creacion` int(4) NOT NULL default '0',";
	$Crear.= " `peso` double(17,0) default NULL,";
	$Crear.= " `cod_producto` varchar(10) NOT NULL,";
	$Crear.= " `cod_subproducto` varchar(10) NOT NULL,";
	$Crear.= " PRIMARY KEY  (`id`,`cod_bulto`,`num_bulto`,`ano_creacion`),";
	$Crear.= " UNIQUE KEY `Ind01` (`id`,`cod_bulto`,`num_bulto`,`ano_creacion`),";
	$Crear.= " KEY `Ind02` (`cod_bulto`,`num_bulto`),";
	$Crear.= " KEY `Ind03` (`cod_bulto`,`ano_creacion`),";
	$Crear.= " KEY `Ind04` (`cod_producto`,`cod_subproducto`)";
	$Crear.= " )";
	mysqli_query($link, $Crear);
	
	$Consulta = "SELECT distinct t3.descripcion, t2.cod_producto, t2.cod_subproducto ";
	$Consulta.= " from sec_web.relacion_flujo t2 ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t3 ";
	$Consulta.= " on t2.cod_producto = t3.cod_producto and t2.cod_subproducto = t3.cod_subproducto";
	$Consulta.= " where t2.flujo = '".$Nodo."'";
	$Consulta.= " and t2.tipo_mov = '4'";
	
	//$Consulta.= " and t2.cod_subproducto = '7'";
	//echo $Consulta."<br>";
	$RespAux = mysqli_query($link, $Consulta);
	$PesoTotal=0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{				
		$Producto = $FilaAux["cod_producto"];
		$SubProducto = $FilaAux["cod_subproducto"];
		//echo $Producto."-".$SubProducto." - ".$FilaAux["descripcion"]."<br><br>";
		$DiaFin = "31";
		$MesFin = str_pad($MesCons,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoCons;
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
		$FechaOri = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);
		$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	
		$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
		$FechaInicio = $FechaAux;
		$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
		$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaTermino,5,2),intval(substr($FechaTermino,8,2)) - 1,substr($FechaTermino,0,4)));	 
		$ArrTotal = array();
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaOri,5,2))."'"	;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$MesConsulta = $Fila["nombre_subclase"];
		}
		$MesAct=intval(substr($FechaOri,5,2));
		if($MesAct==12)
			$MesSig=1;
		else
			$MesSig=$MesAct+1;	
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3004' and cod_subclase = '".$MesSig."'"	;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$MesSig = $Fila["nombre_subclase"];
		}
			
		$Color = "";$TotalPeso = 0;	
		$Consulta= " SELECT t2.cod_bulto, t2.num_bulto, year(t2.fecha_creacion_lote) as ano_creacion, sum(t1.peso_paquetes) as peso ";
		$Consulta.= " ,t1.cod_producto, t1.cod_subproducto,t2.fecha_creacion_lote ";
		$Consulta.= " FROM sec_web.paquete_catodo t1 INNER JOIN sec_web.lote_catodo t2 ";	
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
		$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
		$Consulta.= " where ";
		switch($Producto)
		{
			case "64":
				if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
					$Consulta.= " t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5')";
				else
					$Consulta.= " t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'  ";		
			break;
			case "48":
				$Consulta.= " t1.cod_producto = '48'";
			break;
			default:
				$Consulta.= " t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'  ";				
		}
		//$Consulta.= " and year(t1.fecha_creacion_paquete) <= '".$AnoFin."' and ((t1.cod_estado = 'a' and t1.fecha_embarque = '00-00-0000' and t1.fecha_creacion_paquete < '".$FechaAux."') or ";
		if($MesSig=='A')
			$Consulta.= " and year(t1.fecha_creacion_paquete) <= '".($AnoFin+1)."' and ";
		else
			$Consulta.= " and year(t1.fecha_creacion_paquete) <= '".$AnoFin."' and ";
		$Consulta.= "(";
		$Consulta.= "(t1.cod_estado = 'a' and t1.fecha_embarque = '0000-00-00' and t1.cod_paquete <>'".$MesSig."'";
		//$Consulta.= " and ((year(t1.fecha_creacion_paquete) = '".$AnoFin."' and t1.cod_paquete <='".$MesConsulta."')or(year(t1.fecha_creacion_paquete) < '".$AnoFin."')) ";
		$Consulta.= ")or ";
		if($MesSig=='A')
			$Consulta.= "(t1.cod_estado = 'a'  and year(t1.fecha_creacion_paquete) <= '".$AnoFin."' and t1.cod_paquete ='".$MesSig."'";
		else
			$Consulta.= "(t1.cod_estado = 'a'  and year(t1.fecha_creacion_paquete) < '".$AnoFin."' and t1.cod_paquete ='".$MesSig."'";
		$Consulta.= ")or ";
		$Consulta.= "(t1.cod_estado = 'c' and t1.fecha_embarque >= '".$FechaAux."' and t1.cod_paquete <>'".$MesSig."')";
		$Consulta.= ")";

		$Consulta.= " group by t2.cod_bulto, t2.num_bulto ";
		$Consulta.= " order by ano_creacion, t2.cod_bulto, t2.num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta."<br><br>";
		$PesoM=0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if($Fila["cod_bulto"]>$MesConsulta && $Fila["fecha_creacion_lote"]>=$FechaAux)
			{
				$Nada='';
			}
			else
			{
				$Insertar = "INSERT INTO sec_web.tmp_existencias  (id, cod_bulto, num_bulto, ano_creacion, peso, cod_producto, cod_subproducto) ";
				$Insertar.= "values('1','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["ano_creacion"]."','".$Fila["peso"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."')";
				mysqli_query($link, $Insertar);
			}
			$PesoM=$PesoM+$Fila["peso"];
		}
		//echo "PESO: ".$PesoM."<BR>";
		//CONSULTA LO QUE SE TRASPASO
		$FechaIniAux = date("Y-m-d", mktime(0,0,0,substr($FechaInicio,5,2)-1,1,substr($FechaInicio,0,4)));
		$FechaFinAux = substr($FechaIniAux,0,4)."-".substr($FechaIniAux,5,2)."-31";
		$Consulta = "select sum(t1.peso_paquetes) as peso,t3.cod_bulto,t3.num_bulto,";
		$Consulta.= " year(t3.fecha_creacion_lote) as ano_creacion, t5.hornada, t4.fecha_traspaso, t5.fecha_movimiento,t1.cod_subproducto, t1.cod_subproducto ";
		$Consulta.= " from sec_web.paquete_catodo t1 ";
		$Consulta.= " inner join sec_web.lote_catodo t3 on t1.cod_paquete = t3.cod_paquete";
		$Consulta.= " and t1.num_paquete = t3.num_paquete and t1.fecha_creacion_paquete = t3.fecha_creacion_paquete";
		$Consulta.= " INNER join sec_web.traspaso t4 on t3.cod_bulto = t4.cod_bulto AND t3.num_bulto = t4.num_bulto and t3.fecha_creacion_lote=t4.fecha_creacion_lote";
		$Consulta.= " left join sea_web.movimientos t5 on t5.tipo_movimiento = 4 and t5.hornada = t4.hornada";
		$Consulta.= " left join sea_web.stock_piso_raf t6 on t5.hornada = t6.hornada";
		$Consulta.= " where t4.fecha_traspaso between '".$FechaIniAux."' and CURDATE() ";
		if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
		{
			$Consulta.= " and t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5') ";
		}
		else
		{
			$Consulta.= " and t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."' ";
		}
		$Consulta.= " and (year(t1.fecha_creacion_paquete) = ".$AnoFin."  ";
		if (strtoupper($MesConsulta)=="A")
			$Consulta.= " and t1.cod_paquete <= 'M' ";
		else
			$Consulta.= " and t1.cod_paquete < '".$MesConsulta."' ";
		$Consulta.= " or year(t1.fecha_creacion_paquete) < ".$AnoFin.")  ";
		$Consulta.= " group by t3.cod_bulto,t3.num_bulto";
		//echo "traspaso".$Consulta."</br>";;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["fecha_traspaso"]>$FechaFinAux)
			{
				$Insertar = "insert into sec_web.tmp_existencias  (id, cod_bulto, num_bulto, ano_creacion, peso, cod_producto, cod_subproducto) ";
				$Insertar.= "values('1','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["ano_creacion"]."','".$Fila["peso"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."')";
				mysqli_query($link, $Insertar);
			}
		}
		//FIN TRASPASO		
		
	}
		
	$AcumFinoCu = 0;$AcumFinoAg = 0;$AcumFinoAu = 0;
	if ($Nodo != 77)
	{
		//CONSULTA TABLA CREADA CON LEYES
		$Consulta = "select  cod_bulto, num_bulto, ano_creacion, peso, cod_producto, cod_subproducto ";
		$Consulta.= " from sec_web.tmp_existencias  ";
		//$Consulta.= " WHERE cod_bulto='M' and num_bulto='4185'";
		$Consulta.= " order by cod_bulto, num_bulto";//group by cod_bulto order by cod_bulto, num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Producto=$Fila["cod_producto"];
			$SubProducto=$Fila["cod_subproducto"];
			$Peso = $Fila["peso"];
			$Fino_Cu = 0;$Fino_Ag = 0;$Fino_Au = 0;														
			//LEYES
			$Ano = $Fila["ano_creacion"];
			$Consulta = "select * from proyecto_modernizacion.sub_clase ";
			$Consulta.= " where cod_clase=3004 and nombre_subclase = '".$Fila["cod_bulto"]."'";
			$RespAux2 = mysqli_query($link, $Consulta);
			if ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				$Mes = $FilaAux2["cod_subclase"];
			}		
			if (intval($Ano)==intval($AnoCons) && intval($Mes)==intval($MesCons))
			{
				$Consulta = "SELECT t2.flujo from proyecto_modernizacion.flujos t1 ";
				$Consulta.= " inner join sec_web.relacion_flujo t2 ";
				$Consulta.= " on t1.cod_flujo = t2.flujo ";
				$Consulta.= " where t1.nodo='".$Nodo."' ";
				$Consulta.= " and t2.tipo_mov = 1 ";
				$Consulta.= " and t1.esflujo <> 'N' ";
				$RespAux2 = mysqli_query($link, $Consulta);
				$Flujo = "";
				if ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Flujo = $FilaAux2["flujo"];
				}
				//CONSULTO LEYES DEL MES PEDIDO
				$Consulta = "select * from sec_web.flujos_mes ";
				$Consulta.= " where ano = '".$AnoCons."'";
				$Consulta.= " and mes = '".$MesCons."'";
				$Consulta.= " and flujo = '".$Flujo."'";
				$RespAux2 = mysqli_query($link, $Consulta);
				//echo "1 ".$Consulta."<br>";
				$Encontro=false;
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Encontro=true;
					if ($FilaAux2["fino_cu"]>0 && $FilaAux2["peso"]>0)
						$Fino_Cu = ($FilaAux2["fino_cu"] / $FilaAux2["peso"])*100;
					else
						$Fino_Cu = 0;
					if ($FilaAux2["fino_ag"]>0 && $FilaAux2["peso"]>0)
						$Fino_Ag = ($FilaAux2["fino_ag"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Ag = 0;
					if ($FilaAux2["fino_au"]>0 && $FilaAux2["peso"]>0)
						$Fino_Au = ($FilaAux2["fino_au"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Au = 0;
					//echo $Fino_Ag."<br>"; 	
				}			
			}
			else
			{
				$Consulta = "select * from sec_web.relacion_flujo ";
				$Consulta.= " where cod_producto='".$Producto."'";
				$Consulta.= " and cod_subproducto='".$SubProducto."' ";
				$Consulta.= " and tipo_mov='1' ";
				$RespAux2 = mysqli_query($link, $Consulta);
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{					
					$FlujoProd = $FilaAux2["flujo"];
				}
				//echo $Consulta."<br>";
				$Consulta = "select * from sec_web.flujos_mes ";
				$Consulta.= " where ano = '".$Ano."'";
				$Consulta.= " and mes = '".$Mes."'";
				$Consulta.= " and flujo = '".$FlujoProd."'";
				//echo "2 ".$Consulta."<br>";
				$RespAux2 = mysqli_query($link, $Consulta);
				$Encontro=false;
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Encontro=true;
					if ($FilaAux2["fino_cu"]>0 && $FilaAux2["peso"]>0)
						$Fino_Cu = ($FilaAux2["fino_cu"] / $FilaAux2["peso"])*100;
					else
						$Fino_Cu = 0;
					if ($FilaAux2["fino_ag"]>0 && $FilaAux2["peso"]>0)
						$Fino_Ag = ($FilaAux2["fino_ag"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Ag = 0;
					if ($FilaAux2["fino_au"]>0 && $FilaAux2["peso"]>0)
						$Fino_Au = ($FilaAux2["fino_au"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Au = 0;
				}
			}
			if (!$Encontro)
			{
				$Consulta = "select * from sec_web.relacion_flujo ";
				$Consulta.= " where cod_producto='".$Producto."'";
				$Consulta.= " and cod_subproducto='".$SubProducto."' ";
				$Consulta.= " and tipo_mov='1' ";
				$RespAux2 = mysqli_query($link, $Consulta);
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{					
					$FlujoProd = $FilaAux2["flujo"];
				}
				$FechaAux = date("Y-m-d", mktime(0,0,0,$MesCons-1,1,$AnoCons));
				$AnoAnt = substr($FechaAux,0,4);
				$MesAnt = intval(substr($FechaAux,5,3));
				$Consulta = "select * from sec_web.flujos_mes ";
				$Consulta.= " where ano = '".$AnoAnt."'";
				$Consulta.= " and mes = '".$MesAnt."'";
				$Consulta.= " and flujo = '".$FlujoProd."'";
				//echo "3 ".$Consulta."<br>";
				$RespAux2 = mysqli_query($link, $Consulta);
				$Encontro = false;
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Encontro = true;
					if ($FilaAux2["fino_cu"]>0 && $FilaAux2["peso"]>0)
						$Fino_Cu = ($FilaAux2["fino_cu"] / $FilaAux2["peso"])*100;
					else
						$Fino_Cu = 0;
					if ($FilaAux2["fino_ag"]>0 && $FilaAux2["peso"]>0)
						$Fino_Ag = ($FilaAux2["fino_ag"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Ag = 0;
					if ($FilaAux2["fino_au"]>0 && $FilaAux2["peso"]>0)
						$Fino_Au = ($FilaAux2["fino_au"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Au = 0;
				}
				//echo $Fino_Ag."<br>";
			}
			//FINOS			
			if ($Fino_Cu > 0 && $Peso > 0)				
				$AcumFinoCu = $AcumFinoCu + (($Fino_Cu*$Peso)/100);					
			if ($Fino_Ag > 0 && $Peso > 0)									
				$AcumFinoAg = $AcumFinoAg + (($Fino_Ag*$Peso)/1000);				
			if ($Fino_Au > 0 && $Peso > 0)									
				$AcumFinoAu = $AcumFinoAu + (($Fino_Au*$Peso)/1000);				
			$PesoTotal = $PesoTotal + $Fila["peso"];			
		}		
	}			
	$Eliminar = "DROP TABLE IF EXISTS sec_web.tmp_existencias";
	mysqli_query($link, $Eliminar);
}
?>

