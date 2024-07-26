<?php
	include("../principal/conectar_principal.php"); 
	$CodigoDeSistema=2;

	if(isset($_REQUEST["DiaIni"])) {
		$DiaIni = $_REQUEST["DiaIni"];
	}else{
		$DiaIni =  date("d");
	}
	if(isset($_REQUEST["MesIni"])) {
		$MesIni = $_REQUEST["MesIni"];
	}else{
		$MesIni =  date("m");
	}
	if(isset($_REQUEST["AnoIni"])) {
		$AnoIni = $_REQUEST["AnoIni"];
	}else{
		$AnoIni =  date("Y");
	}

	if(isset($_REQUEST["DiaFin"])) {
		$DiaFin = $_REQUEST["DiaFin"];
	}else{
		$DiaFin =  date("d");
	}
	if(isset($_REQUEST["MesFin"])) {
		$MesFin = $_REQUEST["MesFin"];
	}else{
		$MesFin =  date("m");
	}
	if(isset($_REQUEST["AnoFin"])) {
		$AnoFin = $_REQUEST["AnoFin"];
	}else{
		$AnoFin =  date("Y");
	}

	if(isset($_REQUEST["Act"])) {
		$Act = $_REQUEST["Act"];
	}else{
		$Act =  "";
	}
	


	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;	
?>
<?php
function ActualizaPeso($Fecha, $Prod, $SubProd, $Hornada, $PesoSea, $PesoSipa, $PesoZuncho, $Unidades, $Guia, $Patente, $link)
{

	//ACTUALIZA RECEPCION 
	$Actualizar = "UPDATE sea_web.movimientos set ";
	$Actualizar.= " peso = '".($PesoSipa - $PesoZuncho)."'";
	$Actualizar.= " where cod_producto = '".$Prod."'";
	$Actualizar.= " and cod_subproducto = '".$SubProd."'";
	$Actualizar.= " and fecha_movimiento = '".$Fecha."'";
	$Actualizar.= " and hornada = '".$Hornada."'";
	$Actualizar.= " and tipo_movimiento = '1'";
	$Actualizar.= " and estado = '1'";	
	$Actualizar.= " and campo1 = '".$Guia."'";
	$Actualizar.= " and campo2 = '".$Patente."'";
	mysqli_query($link, $Actualizar);
	//echo $Actualizar."<br>";
	//ACTUALIZA TABLA HORANADA
	$Actualizar = "UPDATE sea_web.hornadas set ";
	$Actualizar.= " peso_unidades = ((peso_unidades - ".$PesoSea.") + ".($PesoSipa - $PesoZuncho).")";
	$Actualizar.= " where cod_producto = '".$Prod."'";
	$Actualizar.= " and cod_subproducto = '".$SubProd."'";
	$Actualizar.= " and hornada_ventana = '".$Hornada."'";
	mysqli_query($link, $Actualizar);
	//echo $Actualizar."<br>";
	$PesoProm = ($PesoSipa - $PesoZuncho) / $Unidades;
	//ACTUALIZO MOVIMIENTOS REALIZADOS DESPUES DE LA RECEPCION
	$Actualizar = "UPDATE sea_web.movimientos set ";
	$Actualizar.= " peso = unidades * ".$PesoProm;
	$Actualizar.= " where cod_producto = '".$Prod."'";
	$Actualizar.= " and cod_subproducto = '".$SubProd."'";
	$Actualizar.= " and hornada = '".$Hornada."'";
	$Actualizar.= " and fecha_movimiento >= '".$Fecha."'";
	$Actualizar.= " and tipo_movimiento <> '1'";
	mysqli_query($link, $Actualizar);
	//echo $Actualizar."<br>";
}
?>
<html>
<head>
<title>Actualizacion de Recepciones de Blister</title>
<link rel="stylesheet" href="../Principal/estilos/css_principal.css" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sea_actualiza_recepcion.php?Act=N";
			f.submit();
			break;
		case "A":
			f.action ="sea_actualiza_recepcion.php?Act=S";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=2&Nivel=0";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
</script></head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
  <table width="770" height="330" border="0" class="TablaPrincipal">
    <tr>
      <td valign="top"> <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <?php // <td align="center"><strong>ACTUALIZA RECEPCIONES DIARIAS</strong></td> ?>
			  <td align="center"><strong>CONSULTA RECEPCIONES DIARIAS</strong></td>
          </tr>
        </table>
        <br>
        <table width="750" border="0" align="center" cellpadding="3" cellspacing="2" class="TablaInterior">
          <tr> 
            <td width="98" height="22">Fecha Inicio:</td>
            <td width="247"><select name="DiaIni" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
              </select> <select name="MesIni" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </select> <select name="AnoIni" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
              </select></td>
            <td width="106">Fecha Termino: </td>
            <td width="262"><select name="DiaFin" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
              </select> <select name="MesFin" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </select> <select name="AnoFin" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
              </select></td>
          </tr>
          <tr align="center"> 
            <td height="22" colspan="4"><input name="BtnConsultar" type="button" onClick="JavaScript:Proceso('C')" value="Consultar"> 
             <?php // <input name="BtnActualizar" type="button" value="Actualizar" onClick="JavaScript:Proceso('A')"> ?>              
              <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
              <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
            </td>
          </tr>
        </table>
        <br> 
        <table width="750" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="66">FECHA</td>
            <td width="58">TIPO MOV.</td>
            <td width="87">PROD.</td>
            <td width="101">SUB.PROD.</td>
            <td width="62">HORNADA</td>
            <td width="62">PESO RECEP.</td>
            <td width="60">PESO SIPA</td>
            <td width="65">ZUNCHO</td>
            <td width="123">DIFERENCIA</td>
            <td width="43">ACT.</td>
          </tr>
          <?php
	$Consulta = " select t1.fecha_movimiento, t1.tipo_movimiento,  t3.descripcion as nom_producto, ";
	$Consulta.= " t2.descripcion as nom_subproducto, t1.hornada, t1.peso, t1.peso_origen, t1.cod_producto, t1.cod_subproducto, ";
	$Consulta.= " t4.nombre_subclase as movimiento, t1.campo1, t1.campo2, t1.unidades ";
	$Consulta.= " from sea_web.movimientos t1 inner join proyecto_modernizacion.subproducto t2 ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto in ('1','2','3','5','6','7','9','10','12') and t1.cod_subproducto = t2.cod_subproducto ";
	$Consulta.= " inner join proyecto_modernizacion.productos t3 on t1.cod_producto = t3.cod_producto ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase = '2001' and t4.cod_subclase = t1.tipo_movimiento ";
	$Consulta.= " where t1.tipo_movimiento = '1'"; //RECEPCION
	$Consulta.= " and t1.estado = '0'";
	$Consulta.= " and t1.fecha_movimiento between '".$FechaInicio."' and '".$FechaTermino."'";
	$Consulta.= " order by t1.fecha_movimiento,t1.cod_producto, t1.cod_subproducto, t1.hornada ";
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalPesoOrigen = 0;
	$TotalZuncho = 0;
	$TotalDiferencia = 0;	
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td  align='center'>".substr($Fila["fecha_movimiento"],8,2)."/".substr($Fila["fecha_movimiento"],5,2)."/".substr($Fila["fecha_movimiento"],0,4)."</td>\n";		
		echo "<td align='center'>".$Fila["movimiento"]."</td>\n";
		echo "<td align='center'>".$Fila["nom_producto"]."</td>\n";									
		echo "<td align='center'>".$Fila["nom_subproducto"]."</td>\n";			
		echo "<td align='right'>";
		if ($Fila["cod_producto"] == 16)
			echo substr($Fila["hornada"],3);
		else
			echo substr($Fila["hornada"],6); 
		echo "</td>\n";		
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		$Consulta = "SELECT sum(peso_neto) as peso_sipa FROM sipa_web.recepciones ";
		$LoteVentana="";
		if ($Fila["cod_subproducto"] == 1)
		{
			$Consulta.= " where guia_despacho = '".$Fila["campo1"]."' AND patente = '".$Fila["campo2"]."' AND fecha = '".$Fila["fecha_movimiento"]."'";
		}
		else
		{   
			//RESCATO LOTE_VENTANA
			$Consulta2 = "select * from sea_web.relaciones where hornada_ventana = '".$Fila["hornada"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta2);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$LoteVentana = $Fila2["lote_ventana"];
			}
			//--------------------
			//$Consulta.= " where LOTE_A = '".$LoteVentana."' AND FECHA_A = '".$Fila["fecha_movimiento"]."'";
			$Consulta.= " where lote = '".$LoteVentana."' AND fecha = '".$Fila["fecha_movimiento"]."'";
		}
		//echo $Consulta;
		$Respuesta2 = mysqli_query($link, $Consulta);
		$PesoSipa = 0;
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$PesoSipa = $Fila2["peso_sipa"];
		}
		echo "<td align='right'>".number_format($PesoSipa,0,",",".")."</td>\n";		
		$PesoZuncho = 0;
		//PESO ZUNCHO
		$PesoZuncho = 0;		
		$Consulta = "select * from sea_web.relacion_zuncho ";
		$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."' ";		
		$Consulta.= " and cod_subproducto='".$Fila["cod_subproducto"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$PesoZuncho = $Fila2["zuncho"];			
		}
		else
		{
			$PesoZuncho = 0;
		}
		$PesoZuncho = $PesoZuncho * $Fila["unidades"];
		//-------------------------------------
		$Dif = abs(($PesoSipa - $Fila["peso"]) - $PesoZuncho);
		echo "<td align='right'>".number_format($PesoZuncho,0,",",".")."</td>\n";
		if ($Dif <> 0) 
		{
			echo "<td align='right'><font color='red'>".number_format($Dif,0,",",".")."</font></td>\n";
			if ($Act == "S")
				ActualizaPeso($Fila["fecha_movimiento"], $Fila["cod_producto"], $Fila["cod_subproducto"], $Fila["hornada"], $Fila["peso"], $PesoSipa, $PesoZuncho, $Fila["unidades"], $Fila["campo1"], $Fila["campo2"], $link);
		}
		else
		{
			echo "<td align='right'>".number_format($Dif,0,",",".")."</td>\n";
		}
		echo "<td align='center'>";
		if ($Act == "S")
			echo "<img src='../Principal/imagenes/ico_ok.gif' width='13' height='13'>";
		else
			echo "&nbsp;";
		echo "</td>\n";
		echo "</tr>\n";
		$TotalPeso = $TotalPeso + $Fila["peso"];
		$TotalPesoOrigen = $TotalPesoOrigen + $PesoSipa;
		$TotalDiferencia = $TotalDiferencia + $Dif;
		$TotalZuncho = $TotalZuncho + $PesoZuncho;
	}
?>
          <tr> 
            <td colspan="5"><strong>TOTALES</strong></td>
            <td align="right"><?php echo number_format($TotalPeso,0,",","."); ?></td>
            <td align="right"><?php echo number_format($TotalPesoOrigen,0,",","."); ?></td>
            <td align="right"><?php echo number_format($TotalZuncho,0,",","."); ?></td>
            <td align="right"><?php echo number_format($TotalDiferencia,0,",","."); ?></td>
            <td align="right">&nbsp;</td>
          </tr>
        </table>
        <br> <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td align="center"> <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
              <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
