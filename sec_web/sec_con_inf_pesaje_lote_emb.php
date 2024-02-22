<?php
	include("../principal/conectar_principal.php"); 

	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');

	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$CodLote = isset($_REQUEST["CodLote"])?$_REQUEST["CodLote"]:"";
	$NumLote = isset($_REQUEST["NumLote"])?$_REQUEST["NumLote"]:"";

	$Producto = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$DescProducto = isset($_REQUEST["DescProducto"])?$_REQUEST["DescProducto"]:"";
	$CorrEnm = isset($_REQUEST["CorrEnm"])?$_REQUEST["CorrEnm"]:"";
	$Cliente = isset($_REQUEST["Cliente"])?$_REQUEST["Cliente"]:"";
	
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');

 	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaAux = $FechaInicio;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	
	$Fecha = date('Y-m-d');
	$anito=substr($Fecha,0,4);

	if (isset($CodLote) && isset($NumLote))
	{
		$Consulta = "SELECT t1.corr_enm, t1.cod_bulto, t1.num_bulto, t1.corr_enm, t2.cod_producto, t2.cod_subproducto, t3.descripcion,";
		$Consulta.= " t1.cod_marca, t4.descripcion as marca, count(*) as bulto_paquetes, sum(t2.peso_paquetes) as bulto_peso";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t3";
		$Consulta.= " on t2.cod_producto = t3.cod_producto and t2.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " inner join sec_web.marca_catodos t4 on t1.cod_marca = t4.cod_marca";
		$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."'";
		$Consulta.= " and year(t1.fecha_creacion_lote) = '".$CmbAno."'";
		$Consulta.= " group by t1.cod_bulto, t1.num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
	
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
		
		
			$Producto 		= $Fila["cod_producto"];
			$SubProducto 	= $Fila["cod_subproducto"];
			$DescProducto 	= $Fila["descripcion"];
			$CorrEnm  		= $Fila["corr_enm"];
			$Fechita     	= $Fila["fecha_creacion_lote"];
		
			$Consulta = "SELECT count(*) as existe from sec_web.programa_enami ";
			$Consulta.= " where corr_enm = '".$Fila["corr_enm"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if ($Fila2["existe"] > 0)
				{
					$Cliente = "ENAMI";
				}
				else
				{
					$Consulta = "SELECT count(*) as existe from sec_web.programa_codelco ";
					$Consulta.= " where corr_codelco = '".$Fila["corr_enm"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))		
					{
						if ($Fila2["existe"] > 0)
						{
							$Cliente = "CODELCO";
						}
						else
						{
							$Cliente = "&nbsp;";
						}
					}
				}
			}
			$CodMarca = $Fila["cod_marca"];
			$Marca = $Fila["marca"];
			$TotPaquetes = $Fila["bulto_paquetes"];
			$TotPeso = $Fila["bulto_peso"];

			$Consulta = "SELECT sum(num_unidades) as unidades";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."'";
			$Consulta.= " and year(t1.fecha_creacion_lote) = '".$CmbAno."'";
			$Consulta.= " group by t1.cod_bulto, t1.num_bulto ";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
				$TotUnidades = $Fila2["unidades"];
			else
				$TotUnidades = 0;
		}
	}
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action = "sec_con_inf_pesaje_lote_emb.php";
			f.submit();
			break;
		case "E":
			CodLote=f.CodLote.value;
			NumLote=f.NumLote.value;
			f.action = "sec_con_inf_pesaje_lote_emb_excel.php?CodLote="+ CodLote+"&NumLote="+NumLote;
			f.submit();
			break;
		case "S":
			f.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Recarga(URL,LimiteIni)
{
	var frm=document.frmPrincipal;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni;
	frm.submit(); 
}

function Recarga1()
{
//alert ("Entro");
	var Frm=document.frmPrincipal;
	var CodLote="";
	//alert(Frm.CmbSerie.value);
	CodLote=(Frm.CodLote.value.substr(0,1));
	NumLote=(Frm.NumLote.value.substr(2,Frm.NumLote.value.length));
	Frm.action="sec_con_inf_pesaje_lote_emb.php?Mostrar=S&CodLote="+CodLote+"&NumLote="+NumLote;
	Frm.submit();
}


</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php
	$LimitFin=55;
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 55;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">

  <table width="500" border="0" align="center" cellpadding="2" cellspacing="1">
    <tr> 
      <td colspan="2" align="center"><strong>LISTADO DE PESAJE DE LOTE DE EMBARQUE</strong></td>
    </tr>
  </table>
  <br>
  <table width="650" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="116"><strong>CODIGO LOTE: </strong></td>
      <td width="520"><SELECT name="CodLote" id="CodLote">
      		<?php
			$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3004' order by nombre_subclase";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				if ($Fila["nombre_subclase"] == $CodLote)
					echo "<option SELECTed value = '".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
				else
					echo "<option value = '".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
			}
			?>
        	</SELECT>
        <input name="NumLote" type="text" id="NumLote2" value="<?php echo $NumLote?>" size="15"> 
        <font size="1"><font size="2"><font size="1"><font size="2"><font size="1"><font size="2"> 
        </font><font size="1"><font size="2"><font size="1"><font size="2"><font size="1"><font size="2"> 
        <SELECT name="CmbAno" size="1" id="SELECT9" style="width:70px;" onChange="Recarga1();">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option SELECTed value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
				{
					if ($i==date("Y"))
						{
							echo "<option SELECTed value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			?>
        </SELECT>
        </font></font></font></font></font></font><font size="2"> </font></font></font></font></font></font> 
        <strong>Lineas por p&aacute;gina : </strong> 
        <input name="LimitFin" type="text" id="LimitFin" value="<?php echo $LimitFin;?>" size="12" maxlength="12">		</td>
    </tr>
    <tr> 
      <td><strong>PRODUCTO:</strong></td>
      <td><strong><?php echo $Producto; ?></strong></td>
    </tr>
    <tr> 
      <td><strong>DESCRIPCION:</strong></td>
      <td><strong><?php echo $DescProducto ?></strong></td>
    </tr>
	<tr>
		<td><strong>INST.EMBARQUE:</strong></td>
		<td><strong><?php echo $CorrEnm ?></strong></td>
	</tr>
    <tr> 
      <td><strong>CLIENTE:</strong></td>
      <td><strong><?php echo $Cliente ?></strong></td>
    </tr>
    <tr> 
      <td><strong>MARCA:</strong></td>
      <td><strong><?php 
		if (isset($CodMarca))
	  		echo $CodMarca." / ".$Marca;
	  	else
			echo "&nbsp;";
		?></strong></td>
    </tr>
    <tr> 
      <td><strong>TOTAL PAQUETES:</strong></td>
      <td><strong><?php 
		if (isset($TotPaquetes))
			echo number_format($TotPaquetes,0,",",".");
		else
			echo "&nbsp;";
		?></strong></td>
    </tr>
    <tr> 
      <td><strong>TOTAL PESO:</strong></td>
      <td><strong><?php 
		if (isset($TotPeso))
			echo number_format($TotPeso,0,",",".");
		else
			echo "&nbsp;";	
		 ?></strong></td>
    </tr>
    <tr>
      <td><strong>TOTAL UNIDADES:</strong></td>
      <td><strong><?php 
		if (isset($TotUnidades))
			echo number_format($TotUnidades,0,",",".");
		else
			echo "&nbsp;";
		?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="button2" type="submit" id="button4" value="Consultar" onClick="Proceso('R');" style="width:70px">
      <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
      <input name="btnExcel2" type="button" id="btnExcel2" style="width:70" onClick="JavaScript:Proceso('E')" value="Excel">
      <input name="btnsalir22" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"></td>
    </tr>
  </table>
<br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="90">SERIE</td>
      <td width="105">PESO NETO</td>
      <td width="73">GRUPO</td>
      <td width="95">UNIDADES</td>
      <td width="190">UBICACION</td>
    </tr>
    <?php
	$Consulta = "SELECT * from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' ";
	$Consulta.= " and year(t1.fecha_creacion_lote) = '".$CmbAno."'";
	$Consulta.= " order by t1.cod_paquete,t1. num_paquete asc ";
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
    //echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalCortes = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_paquete"]."-".$Fila["num_paquete"]."</td>\n";
		echo "<td align='center'>".$Fila["peso_paquetes"]."</td>\n";
		echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		echo "<td align='center'>".$Fila["num_unidades"]."</td>\n";
		$Consulta = "SELECT * from ram_web.atributo_existencia ";
		$Consulta.= " where cod_existencia = '".$Fila["cod_lugar"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
			echo "<td align='left'>".$Fila2["abrev_existencia"]." - ".$Fila2["nombre_existencia"]."</td>\n";
		else
			echo "<td align='left'>&nbsp;</td>\n";
		echo "</tr>\n";
		$TotalCortes++;
	}
	?>
  </table>
 	<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
    	<tr>
        	<td height="25" align="center" valign="middle">Paginas &gt;&gt; 
		<?php	
			$Consulta = "SELECT count(*) as total_registros ";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' ";
			$Consulta.= " and year(t1.fecha_creacion_lote) = '".$CmbAno."'";
			$Respuesta = mysqli_query($link, $Consulta);
			$Row = mysqli_fetch_array($Respuesta);
			$Coincidencias = $Row["total_registros"];
			$NumPaginas = ($Coincidencias / $LimitFin);
			$LimitFinAnt = $LimitIni;
			$StrPaginas = "";
			for ($i = 0; $i <= $NumPaginas; $i++)
			{
				$LimitIni = ($i * $LimitFin);
				if ($LimitIni == $LimitFinAnt)
				{
					$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
				}
				else
				{
					$StrPaginas.=  "<a href=JavaScript:Recarga('sec_con_inf_pesaje_lote_emb.php','".($i * $LimitFin)."');>";
					$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
				}
			}
			echo substr($StrPaginas,0,-15);
		?>
	</td>
	</tr>
  </table>

<br>
<br>
</form>
</body>
</html>
