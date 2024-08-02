<?php
	include("../principal/conectar_principal.php");

	$Mensaje= isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');
	$NumBulto= isset($_REQUEST["NumBulto"])?$_REQUEST["NumBulto"]:"";
	$CodBulto= isset($_REQUEST["CodBulto"])?$_REQUEST["CodBulto"]:"";
	$FechaLote= isset($_REQUEST["FechaLote"])?$_REQUEST["FechaLote"]:"";
	$ConsProd= isset($_REQUEST["ConsProd"])?$_REQUEST["ConsProd"]:"";

	//$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
?>
<html>
<head>
<title>Sistema de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":						
			f.action = "sec_asigna_grupo_cuba02.php?Proceso=G";
			f.submit();
			break;
		case "C":
			f.action = "sec_asigna_grupo_cuba01.php?ConsProd=S";
			f.submit();
			break;
		case "S":
			window.opener.frmPrincipal.action = "sec_asigna_grupo_cuba.php";
			window.opener.frmPrincipal.submit();
			window.close();
			break;
	}
}
function Historial(SA)
{
	window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Recarga()
{
	var f = document.frmPopUp;
	f.action = "sec_asigna_grupo_cuba01.php";
	f.submit();
}
function CalculaUnid(ind)
{
	var f = document.frmPopUp;		
	f.UnidTotal.value = 0;		
	for (i=1;i<f.elements.length;i++)	
	{		
		if ((f.elements[i].name.substring(0,4) == "Unid") && (f.elements[i].name != "UnidTotal") && (f.elements[i].name != "UnidLote"))
		{
			if (f.elements[i].value == "")
				f.elements[i].value = 0;
			f.UnidTotal.value = parseInt(f.UnidTotal.value) + parseInt(f.elements[i].value);
		}
	}
}
function CalculaPeso(ind)
{
	var f = document.frmPopUp;		
	f.PesoTotal.value = 0;		
	for (i=1;i<f.elements.length;i++)	
	{		
		if ((f.elements[i].name.substring(0,4) == "Peso") && (f.elements[i].name != "PesoTotal") && (f.elements[i].name != "PesoLote"))
		{
			if (f.elements[i].value == "")
				f.elements[i].value = 0;
			f.PesoTotal.value = parseInt(f.PesoTotal.value) + parseInt(f.elements[i].value);
		}
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="1" topmargin="1" marginwidth="0" marginheight="0">
<form name="frmPopUp" action="" method="post">

  <table width="77%" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
    <tr> 
      <td colspan="4" align="center"><strong>PRODUCCIONES DE CATODOS DESC. NORMAL</strong></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
<?php
	$Consulta = "select t1.cod_bulto, t1.num_bulto, sum(t2.num_unidades) as unidades, sum(t2.peso_paquetes) as peso, t2.cod_subproducto";
	$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.= " where t1.cod_bulto = '".$CodBulto."'";
	$Consulta.= " and t1.num_bulto = '".$NumBulto."'";
	$Consulta.= " group by t1.cod_bulto, t1.num_bulto";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$UnidLote = $Fila["unidades"];
		$PesoLote = $Fila["peso"];
		
		$subproducto = $Fila["cod_subproducto"];
	}
	
	$calidad = array(42=>"Grado A", 43=>"B 115", 44=>"Rechazado");
?>	
    <tr> 
      <td width="109" height="24">LOTE:</td>
      <td width="195"><?php echo strtoupper($CodBulto)."-".str_pad($NumBulto,6,0,STR_PAD_LEFT)?> 
        <input type="hidden" name="Ano" value="<?php echo $Ano; ?>"> <input type="hidden" name="CodBulto" value="<?php echo $CodBulto; ?>"> 
        <input type="hidden" name="NumBulto" value="<?php echo $NumBulto; ?>">
		<input type="hidden" name="FechaLote" value="<?php echo $FechaLote; ?>"> &nbsp;</td>
      <td colspan="2">	  <?php echo "CALIDAD: ".$calidad[$subproducto]; ?></td>
    </tr>

    <tr> 
      <td>UNID. LOTE:</td>
      <td><input name="UnidLote" readonly="" type="text" id="UnidLote5" value="<?php echo $UnidLote; ?>" size="15" maxlength="7"></td>
      <td width="136">PESO LOTE:</td>
      <td width="145"><input name="PesoLote" type="text" readonly="" id="PesoLote" value="<?php echo $PesoLote; ?>" size="15" maxlength="7"></td>
    </tr>
    <tr> 
      <td>F.PRODUCCION</td>
      <td> 
        <select name='MesIni' style='width:100px'>
          <?php
			  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i = 1; $i <= 12; $i++)
				{
					if (isset($MesIni))
					{
						if ($i == $MesIni)
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
              ?>
        </select> <select name='AnoIni' style='width:60px'>
          <?php
				for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
				{
					if (isset($AnoIni))
					{
						if ($i == $AnoIni)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
              ?>
        </select></td>
      <td colspan="2">&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="4" align="center"> <input name="BtnConsultar" type="button" value="Buscar" style="width:70px" onClick="Proceso('C');"> 
        <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70px" onClick="Proceso('G');" value="Grabar"> 
        <input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"> 
      </td>
    </tr>
  </table>
  <br>
<?php	
	$ArrGrupos = explode("///",$Mensaje);
	foreach($ArrGrupos as $i => $v)
	{
		if ($v != "")
			echo "<center>El Grupo <strong>".$v."</strong> no tiene la Pesada correspondiente al Resto Sobrante<center><br>";
	}
?>  
  <br>
  <table width="77%" border="1" align="center" cellpadding="3" cellspacing="1" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="19%" rowspan="2">FECHA</td>
      <td width="10%" rowspan="2">GRUPO</td>
      <td width="15%" rowspan="2">PESO <br>
        PRODUCCION</td>
      <td colspan="3">PESADA VIRTUAL</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center" class="ColorTabla01"> 
      <td width="8%">S/N</td>
      <td width="14%">PESO</td>
      <td width="12%">YA ASIGNADO</td>
      <td width="22%">PARTICIPA</td>
    </tr>
    <?php	
$FechaIni = $AnoIni."-".str_pad($MesIni,2,0,STR_PAD_LEFT)."-01";	  
$FechaFin = $AnoIni."-".str_pad($MesIni,2,0,STR_PAD_LEFT)."-31";	  
if (strtoupper($ConsProd) == "S")
{
	
	$Cubas_A = array(); //Cuabs Grado A.
	$Cubas_B = array(); //Cubas B-115.
	$Cubas_R = array(); //Cubas de Rechazo.
	$Cubas_N = array(); //No Hay Solicitud.
	
	$Consulta = "select cod_grupo, sum(peso_produccion) as peso_produccion, fecha_produccion ";
	$Consulta.= " from sec_web.produccion_catodo ";
	$Consulta.= " where fecha_produccion between '".$FechaIni."' and '".$FechaFin."' ";
	$Consulta.= " and cod_producto = '18'";
	$Consulta.= " and cod_subproducto = '3'";
	$Consulta.= " and cod_grupo <> '99'";
	$Consulta.= " and cod_muestra <> 'S'";
	$Consulta.= " group by fecha_produccion, cod_grupo ";
	//echo $Consulta."<br><br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$i = 1;
	$PesoTotal = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{			
		//-----.
		$consulta = "SELECT * FROM sec_web.produccion_catodo";
		$consulta.= " WHERE fecha_produccion = '".$Fila["fecha_produccion"]."' AND cod_grupo = '".$Fila["cod_grupo"]."'";
		$consulta.= " AND cod_producto = '18' AND cod_subproducto = '3' AND cod_muestra = 'N' ";
		//echo $consulta."<br><br>";
		
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			//SI EL GRUPO-CUBA ES DE LA MISMA CALIDAD DEL LOTE SE MUESTRA.
			$Consulta = " SELECT t2.nro_solicitud,t2.cod_leyes, t2.valor, t2.cod_unidad, t1.estado_actual,";
			$Consulta.= " t2.id_muestra, t1.cod_producto, t1.cod_subproducto";
			$Consulta.= " from cal_web.solicitud_analisis as t1";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2"; 
			$Consulta.= " ON t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " AND t1.fecha_hora = t2.fecha_hora ";
			$Consulta.= " AND t1.rut_funcionario = t2.rut_funcionario ";
			$Consulta.= " AND t1.id_muestra = t2.id_muestra ";
			$Consulta.= " AND t1.recargo = t2.recargo ";
			$Consulta.= " AND left(t2.id_muestra,2) like '%".$row["cod_grupo"]."%'";
			$Consulta.= " WHERE t1.cod_producto = '18' AND t1.cod_subproducto = '3'";
			$Consulta.= "AND left(t1.fecha_muestra,10) = '".$row["fecha_produccion"]."'";
			$Consulta.= " AND left(t1.id_muestra,2) like '%".$row["cod_grupo"]."%' AND right(t1.id_muestra,2) like '%".$row["cod_cuba"]."%'";
			$Consulta.= " AND t2.valor != '' AND t2.cod_leyes != '48'";
			$Consulta.= " AND t1.cod_periodo='1' ";
			$Consulta.= " AND t1.tipo='1' ";
			$Consulta.= " AND t1.cod_analisis='1' ";
			$Consulta.= " AND t1.estado_actual <> '7'";
			//echo $Consulta."<BR><br>";

			$cont = 0;
			$Valor = 0;
			$Grado_A = 0;
			$Astm = 0;
			$Class = "";
			$conta_a = 0;
			$conta_b = 0;
			$conta_r = 0;			
			$rs1 = mysqli_query($link, $Consulta);
			while($row1 = mysqli_fetch_array($rs1))
			{				
				$Consulta = "SELECT * FROM sec_web.clasificacion_catodos WHERE cod_leyes = '".$row1["cod_leyes"]."'";
				//echo $Consulta."<br>";
				$rs2 = mysqli_query($link, $Consulta);
				if($row2 = mysqli_fetch_array($rs2))
				{
					$cont = $cont + 1;
					if ($row1["valor"] <= $row2["grado_a"])
					{
						$conta_a = 1;
					}	
					if (($row1["valor"] > $row2["grado_a"]) && ($row1["valor"] <= $row2["b_115"]))
					{
						$conta_b = 1;
					}	
					if ($row1["valor"] > $row2["b_115"])
					{
						$conta_r = 1;
					}						
					/*$Valor = $Valor + $row1["valor"];			
					$Grado_A = $Grado_A + $row2["grado_a"];  								
					$Astm = $Astm + $row2["b_115"];*/
				}
				
				$nro_solicitud = $row1["nro_solicitud"]; 
				$estado = $row1["estado_actual"];
			}
	
			if($cont != 0)
			{
			
				$Grado_A = $Grado_A;
				$Astm = $Astm;
				$Valor = $Valor;
				
				if($conta_r == 1)
				{
					$Class = "R";
					$clave = $row["fecha_produccion"].'~'.$row["cod_grupo"].'~'.$row["cod_cuba"];					
					$Cubas_R[$clave] =  array(0=> $row["fecha_produccion"], 1=>$row["cod_grupo"], 2=>$row["cod_cuba"], 3=>$row["peso_produccion"]);
					$conta_a = 0;
					$conta_b = 0;
				}
				if($conta_b == 1)
				{
					$Class = "B 115";
					$clave = $row["fecha_produccion"].'~'.$row["cod_grupo"].'~'.$row["cod_cuba"];					
					$Cubas_B[$clave] = array(0=> $row["fecha_produccion"], 1=>$row["cod_grupo"], 2=>$row["cod_cuba"], 3=>$row["peso_produccion"]);
					$conta_a = 0;
				}
				if($conta_a == 1)
				{
					$Class = "A";
					$clave = $row["fecha_produccion"].'~'.$row["cod_grupo"].'~'.$row["cod_cuba"];
					$Cubas_A[$clave] = array(0=>$row["fecha_produccion"], 1=>$row["cod_grupo"], 2=>$row["cod_cuba"], 3=>$row["peso_produccion"]); 				
				}
				
			}
			else
			{
				//No hay solicitud;
				$clave = $row["fecha_produccion"].'~'.$row["cod_grupo"].'~'.$row["cod_cuba"];					
				$Cubas_N[$clave] =  array(0=> $row["fecha_produccion"], 1=>$row["cod_grupo"], 2=>$row["cod_cuba"], 3=>$row["peso_produccion"]);
			}				
			//echo "TIPO: ".$Class."<br><br>";		
		}				
	}	
	
	//Escribe los grupos con las cubas del producto.
	$crear = "CREATE TABLE IF NOT EXISTS sec_web.listado_grupo (fecha date,grupo char(2),cuba char(2), peso bigint)";
	mysqli_query($link, $crear);
	$eliminar = "DELETE FROM sec_web.listado_grupo";
	mysqli_query($link, $eliminar);	
	
	$TipoProducto = array(42=>"A", 43=>"B", 44=>"R");
	$tipo_prod = $TipoProducto[$subproducto];
	
	switch ($subproducto)
	{
		case "42": //Grado A. 
				foreach ($Cubas_A as $c => $v)
				{
					$insertar = "INSERT INTO sec_web.listado_grupo (fecha,grupo,cuba,peso) VALUES ('".$v[0]."', '".$v[1]."', '".$v[2]."', '".$v[3]."')";
					mysqli_query($link, $insertar);
					echo '<input name="TipoProd" type="hidden" value="'.$tipo_prod.'">';
				}
				break;
				
		case "43": //B-115.
				foreach ($Cubas_B as $c => $v)
				{
					$insertar = "INSERT INTO sec_web.listado_grupo (fecha,grupo,cuba,peso) VALUES ('".$v[0]."', '".$v[1]."', '".$v[2]."', '".$v[3]."')";
					mysqli_query($link, $insertar);
					echo '<input name="TipoProd" type="hidden" value="'.$tipo_prod.'">';
				}					
				break;
				
		case "44": //Rechazado.
				foreach ($Cubas_R as $c => $v)
				{
					$insertar = "INSERT INTO sec_web.listado_grupo (fecha,grupo,cuba,peso) VALUES ('".$v[0]."', '".$v[1]."', '".$v[2]."', '".$v[3]."')";
					mysqli_query($link, $insertar);
					echo '<input name="TipoProd" type="hidden" value="'.$tipo_prod.'">';
				}					
				break;			
	}
	
	//proceso.
	$consulta = "SELECT fecha, grupo, SUM(peso) AS peso FROM sec_web.listado_grupo";
	$consulta.= " GROUP BY fecha, grupo";
	$rs4 = mysqli_query($link, $consulta);
	while ($row4 = mysqli_fetch_array($rs4))
	{
		//Consulta si las cubas de este grupo fueron asignadas.
		$consulta = "SELECT * FROM sec_web.listado_grupo";
		$consulta.= " WHERE fecha = '".$row4["fecha"]."' AND grupo = '".$row4["grupo"]."'";		
		$rs5 = mysqli_query($link, $consulta);
		
		$OtroLote = false;
		$cubas_grupo = array();
		while ($row5 = mysqli_fetch_array($rs5))
		{
			$cubas_grupo[] = $row5["cuba"];
			
			//CONSULTA SI YA FUE ASIGNADO A ESTE LOTE.
			$consulta = "SELECT * FROM sec_web.catodos_desc_normal"; 
			$consulta.= " WHERE cod_bulto = '".$CodBulto."'";
			$consulta.= " AND num_bulto = '".$NumBulto."'";
			$consulta.= " AND fecha_creacion_bulto = '".$FechaLote."'";
			$consulta.= " AND grupo = '".$row5["grupo"]."'";
			//$consulta.= " AND cuba = '".$row5[cuba]."'";
			$consulta.= " AND tipo = '".$tipo_prod."'";
			$consulta.= " AND fecha_produccion = '".$row5["fecha"]."'";
			//echo $consulta."<br>";
			
			$rs6 = mysqli_query($link, $consulta);
			if ($row6 = mysqli_fetch_array($rs6))
			{
				$OtroLote = false;
				$Participacion = $row6["participa"];			
			}
			else
			{
				$consulta = "SELECT * FROM sec_web.catodos_desc_normal"; 			
				$consulta.= " WHERE grupo = '".$row5["grupo"]."' AND tipo = '".$tipo_prod."' AND fecha_produccion = '".$row5["fecha"]."'";
				//echo $consulta."<br>";
				
				$rs7 = mysqli_query($link, $consulta);
				if ($row7 = mysqli_fetch_array($rs7))
				{
					$OtroLote = true;
					$Participacion = $row7["participa"];				
				}
				else
					$Participacion = "";
			}
		}
		$cuba = implode(",",$cubas_grupo);
		//echo $cuba."<br>";
		
		if (($Participacion != "T") || ($Participacion == "T" && $OtroLote == false))
		{
			echo "<tr>\n";		
			echo "<td align='center'>".$row4["fecha"]."<input type='hidden' name='Fecha[".$i."]' value='".$row4["fecha"]."'></td>\n";
			echo "<td align='center'>".$row4["grupo"]."<input type='hidden' name='Grupo[".$i."]' value='".$row4["grupo"]."'></td>\n";			
			echo "<td align='center'>".number_format($row4["peso"],0,",",".");
			echo "<input type='hidden' name='PesoProd[".$i."]' value='".$row4["peso"]."'>";
			echo "<input type='hidden' name='Cubas[".$i."]' value='".$cuba."'>";
			$PesoTotal = $PesoTotal + $row4["peso"];
			echo "</td>\n";		
			
			//CONSULTO SI TIENE PESADA VIRTUAL
			$Consulta = "select * from sec_web.produccion_desc_normal ";
			$Consulta.= " where fecha_produccion = '".$row4["fecha"]."'";
			$Consulta.= " and cod_grupo = '99'";
			$Consulta.= " and cod_cuba = '".$row4["grupo"]."'";
			$Consulta.= " and cod_lado = '".$tipo_prod."'";
			//falta condicion para diferenciar si es grado a, b-115, rechazo. (obs: en el lado podria ir A,B,R).
			//echo $Consulta."<br>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				echo "<td align='center'>SI</td>\n";
				echo "<td align='right'>".number_format($Fila2["peso_produccion"],0,",",".")."</td>\n";
				//CONSULTO SI YA FUE ASIGNADO PESO PARCIAL
				$Consulta = "select * from sec_web.catodos_desc_normal ";
				$Consulta.= " where fecha_produccion = '".$row4["fecha"]."'";
				$Consulta.= " and grupo = '".$row4["grupo"]."'";
				$Consulta.= " and tipo = '".$tipo_prod."'";
				//$Consulta.= " and cuba in (".$cuba.")";				
				//echo $Consulta."<br>";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".number_format($Fila2["peso_produccion"],0,",",".")."</td>\n";
				}
				else
				{
					echo "<td align='right'>0</td>\n";
				}
			}
			else
			{
				echo "<td align='center'>NO</td>\n";
				echo "<td align='right'>0</td>\n";
				echo "<td align='right'>0</td>\n";
			}							
			
			echo "<td align='center'><select name='Participa[".$i."]'>";
			switch ($Participacion)
			{
				case "T":
					echo "<option value='0'>0-NO PARTICIPA</option>\n";
					echo "<option selected value='T'>T-TOTAL</option>\n";
					echo "<option value='P'>P-PARCIAL</option>\n";
					break;
				case "P":
					if ($OtroLote == false)
					{
						echo "<option value='0'>0-NO PARTICIPA</option>\n";		
						echo "<option value='T'>T-TOTAL</option>\n";
						echo "<option selected value='P'>P-PARCIAL</option>\n";
					}
					else
					{
						echo "<option value='0'>0-NO PARTICIPA</option>\n";		
						echo "<option value='T'>T-TOTAL</option>\n";
						//echo "<option selected value='P'>P-PARCIAL</option>\n";
					}
					break;
				default:
					echo "<option  value='0'>0-NO PARTICIPA</option>\n";
					echo "<option  value='T'>T-TOTAL</option>\n";
					echo "<option  value='P'>P-PARCIAL</option>\n";
					break;
			}
			echo "</select></td>\n";		
			echo "</tr>\n";
			$i++;			
		}
	}
}	
else
{
	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "</tr>\n";
}
?>
    <tr align="center"> 
      <td><strong>TOTAL</strong></td>
      <td>&nbsp;</td>
      <td><?php echo number_format($PesoTotal,0,",",".");?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
<?php  
	if (count($Cubas_N) != 0)
	{  	
		echo '<br><br><table width="77%" border="1" align="center" cellpadding="3" cellspacing="1" class="TablaDetalle">';
		echo "<tr class='ColorTabla01'>\n";
		echo "<td align='center' colspan='4'>PRODUCCIONES SIN ANALISIS QUIMICOS</td>\n";
		echo "</tr>\n";  
		echo "<tr class='ColorTabla01'>\n";
		echo "<td align='center'>FECHA</td>\n";
		echo "<td align='center'>GRUPO</td>\n";
		echo "<td align='center'>CUBA</td>\n";
		echo "<td align='center'>PESO</td>\n";
		echo "</tr>\n";  
		foreach ($Cubas_N as $c => $v)
		{	
			echo "<tr>\n";
			echo "<td align='center'>".$v[0]."</td>\n";
			echo "<td align='center'>".$v[1]."</td>\n";
			echo "<td align='center'>".$v[2]."</td>\n";
			echo "<td align='center'>".$v[3]."</td>\n";
			echo "</tr>\n";  
		}
		echo '</table>';
	}
?>
  
</form>
</body>
</html>
