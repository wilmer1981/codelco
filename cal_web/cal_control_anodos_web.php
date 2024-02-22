<?php
	include("../principal/conectar_principal.php");
	if(isset($_REQUEST["TipoProducto"])) {
		$TipoProducto = $_REQUEST["TipoProducto"];
	}else{
		$TipoProducto ="";
	}
	if(isset($_REQUEST["Valores"])) {
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores ="";
	}
	if(isset($_REQUEST["TxtFechaIni"])) {
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni=date("Y-m")."-01";
	}
	if(isset($_REQUEST["TxtFechaFin"])) {
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin=date("Y-m-d");
	}

	$Datos = explode("-",$TipoProducto);
	$Producto = $Datos[0];
	$SubProducto = $Datos[1];
	//PRODUCTO
	$Consulta = "select * from proyecto_modernizacion.productos where cod_producto='".$Producto."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$NomProducto = $Fila["descripcion"];
	}
	//SUB-PRODUCTO
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$NomSubProducto = $Fila["descripcion"];
	}	
	//PERIODO
	$FechaIni = $TxtFechaIni;
	$FechaFin = $TxtFechaFin;
	$Periodo = substr($FechaIni,8,2)."-".substr($FechaIni,5,2)."-".substr($FechaIni,0,4);
	$Periodo.= " AL ".substr($FechaFin,8,2)."-".substr($FechaFin,5,2)."-".substr($FechaFin,0,4);
	
	//LEYES
	$ArrLeyes = array();
	$ArrLimites = array();
	$Datos = explode("//",$Valores);
	$i=1;
	$LimitesCons = "";
	//foreach($Datos as $k => $v)
	foreach($Datos as $k => $v )
	{
		$Datos2 = explode("~~",$v);
		if ($Datos2[0]=="AS/SB")
		{
			$Abrev = "As/Sb";
		}
		else
		{
			$Consulta = "select * from proyecto_modernizacion.leyes where cod_leyes = '".$Datos2[0]."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Abrev = $Fila["abreviatura"];
			}		
		}
		//ARREGLO LEYES
		$ArrLeyes[$Datos2[0]][0] = $Datos2[0]; //COD_LEYES
		if ($Datos2[2] > 0)
			$ArrLeyes[$Datos2[0]][1] = $Datos2[1]; //SIGNO
		else
			$ArrLeyes[$Datos2[0]][1] = ""; //SIGNO
		$ArrLeyes[$Datos2[0]][2] = str_replace(",",".",$Datos2[2]); //VALOR
		$ArrLeyes[$Datos2[0]][3] = $Abrev;     //ABREVIATURA 
		//ARREGLO LIMITES
		if ($Datos2[2] > 0)
		{
			$ArrLimites[$Datos2[0]][0] = $Datos2[0]; //COD_LEYES
			$ArrLimites[$Datos2[0]][1] = $Datos2[1]; //SIGNO
			$ArrLimites[$Datos2[0]][2] = str_replace(",",".",$Datos2[2]); //VALOR
			$ArrLimites[$Datos2[0]][3] = $Abrev;     //ABREVIATURA 
			$LimitesCons.= $Abrev.$Datos2[1].$Datos2[2]."; ";
		}		
		$i++;
	}
	$LimitesCons = substr($LimitesCons,0,strlen($LimitesCons)-2);
	$LargoTabla = 390 + ($i*40);
?>
<html>
<head>
<title>CAL-Control de Anodos</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Proceso(o)
{	
	var f = document.frmPrincipal;
	switch (o)
	{
		case "I":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			window.print();
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			break;
		case "S":
			f.action = "cal_control_anodos.php";
			f.submit();
			break;
		case "INF":
			var Informacion="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkValores" && f.elements[i].checked==true)
					Informacion=Informacion + f.elements[i].value;
			}
			if (Informacion=="")
			{
				alert("No hay nada seleccionado para Generar el Informe");
				return;
			}			
			else
			{
				window.open("cal_control_anodos_informe.php?Informacion="+Informacion,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
			}
			break;
	}
}
</script>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="500" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#000000">
  <tr align="center" class="ColorTabla01">
    <td colspan="2">CONTROL DE ANODOS </td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td width="124" bgcolor="#FFFFFF">Tipo de Producto:</td>
    <td width="458"><?php echo $NomSubProducto; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Periodo:</td>
    <td><?php echo $Periodo; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Limites Consultados:</td>
    <td><?php echo $LimitesCons; ?></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td colspan="2"><input name="BtnGenera" type="button" id="BtnGenera" style="width:110px" onClick="Proceso('INF')" value="Generar Informe">      <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px" onClick="Proceso('I')">
    <input name="BtnSalir" type="button" id="BtnSalir" style="width:70px" onClick="Proceso('S')" value="Salir"></td>
  </tr>
</table>
<BR><BR>
<table width="<?php echo $LargoTabla; ?>" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr align="center" class="ColorTabla01">  	
  	<td width="100">Fecha</td>
	<td width="80">Solicitud</td>
    <td width="29">Id.Muestra</td>
    <td width="30">Estado</td>
    <?php	
	//while (list($k,$v)=each($ArrLeyes))
	foreach($ArrLeyes as $k => $v)
	{
		if ($v[1]!="")
			echo "<td width='35'>".$v[3]."<br>".$v[1]."".$v[2]."</td>\n";
		else
			echo "<td width='35'>".$v[3]."</td>\n";
	}
?>	
	<td width="14">&nbsp;</td>
    <td width="150">Obs.</td>
  </tr>
<?php  	
	$Consulta = "select distinct t1.fecha_muestra, t1.id_muestra as hornada, t1.nro_solicitud, t1.recargo, t1.estado_actual, t3.nombre_subclase as nom_estado ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud=t2.nro_solicitud ";
	$Consulta.= " and t1.recargo=t2.recargo inner join proyecto_modernizacion.sub_clase t3 on t1.estado_actual=t3.cod_subclase and cod_clase='1002' ";
	$Consulta.= " where t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."'";
	$Consulta.= " and t1.fecha_muestra between '".$FechaIni." 00:00:01' and '".$FechaFin." 23:59:59'";	
	$Consulta.= " and t1.estado_actual not in(7,16) and tipo<>'6'";
	$i=1;
	//while (list($k,$v)=each($ArrLimites))
	foreach($ArrLimites as $k => $v)
	{
		if ($v[0]!="AS/SB")
		{
			if ($i==1)
				$Consulta.= " and (";
			$Consulta.= "(t2.cod_leyes = '".$v[0]."') or "; //and t2.valor ".$v[1]." '".$v[2]."') or ";
			$i++;
		}
	}
	//------QUERY SENTENCIA MODIFICADA, YA QUE AL NO ENTRAR AL CICLO ANTERIOR, ELIMINABA 4 ESPACIOS HACIA ATRAS Y LA CONSULTA
	//------QUEDABA DE LA SIGUIENTE MANERA "and tipo<", por lo cual, se agrego un if($i!=1) en linea siguiente asi solo elimina esos cuatros espacio
	//------al contener datos del ciclo anterior
	//------DVS / LRC 13-06-2014
	if($i>1)
		$Consulta = substr($Consulta,0,strlen($Consulta)-4);
	if ($i>1)
		$Consulta.= ")";
	if ($Producto != 0)
	{
		$Consulta.= " and t1.cod_producto = '".$Producto."'";
		if ($SubProducto != 0)
			$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
	}
	$Consulta.= " order by t1.fecha_muestra, t1.id_muestra ";
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Errores=false;		
		echo "<tr bgcolor=\"white\">\n";
		echo "<td align='center'>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],5,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>\n";		
		echo "<td align='center'><a href=\"JavaScript:Historial('".$Fila["nro_solicitud"]."','".$Fila["recargo"]."')\" class=\"LinksAzul\">".intval(substr($Fila["nro_solicitud"],4))."</a></td>\n";
		echo "<td align='center'>".$Fila["hornada"]."</td>\n";
		echo "<td align='center'>".$Fila["nom_estado"]."</td>\n";
		$Consulta = "select * from cal_web.leyes_por_solicitud ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Consulta.= " and id_muestra = '".$Fila["hornada"]."'";
		$Consulta.= " and nro_solicitud = '".$Fila["nro_solicitud"]."'";
		$Consulta.= " and recargo = '".$Fila["recargo"]."'";
		$Consulta.= " order by cod_leyes";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{			
			if( $ArrLeyes[$Fila2["cod_leyes"]][0]!="")
			{
				$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]][5] = $Fila2["cod_unidad"];
				$ArrLeyes[$Fila2["cod_leyes"]][6] = $Fila2["signo"];
			}
		}
		if ($ArrLeyes["08"][4]>0 && $ArrLeyes["09"][4]>0)
			$ArrLeyes["AS/SB"][4] = $ArrLeyes["08"][4]/$ArrLeyes["09"][4];
		else
			$ArrLeyes["AS/SB"][4] = 0;
		reset($ArrLeyes);
		$ClaveChk="";
		$SinDefinir=false;
		//while (list($k,$v)=each($ArrLeyes))
		foreach($ArrLeyes as $k => $v )
		{
			$Color = "";
				if ($v[1] != "")
				{
					switch ($v[1])
					{
						case ">":
							if ($v[4]>$v[2])
							{
								$Color="YELLOW";
								$Errores=true;
								$ClaveChk.= $Producto."~~".$SubProducto."~~".$Fila["hornada"]."~~".$v[0]."~~>~~".$v[2]."~~".$v[4]."~~".$v[5]."//";
							}
							break;
						case "<":
							if ($v[4]<$v[2])
							{
								$Color="YELLOW";
								$Errores=true;
								$ClaveChk.= $Producto."~~".$SubProducto."~~".$Fila["hornada"]."~~".$v[0]."~~<~~".$v[2]."~~".$v[4]."~~".$v[5]."//";
							}
							break;
						case "=":
							if ($v[4]==$v[2])
							{
								$Color="YELLOW";
								$Errores=true;
								$ClaveChk.= $Producto."~~".$SubProducto."~~".$Fila["hornada"]."~~".$v[0]."~~=~~".$v[2]."~~".$v[4]."~~".$v[5]."//";
							}
							break;
					}
				}
				
				if ($v[6]==">")
				{					
					echo "<td align='right' bgcolor='#FF9900'>";
					echo $v[6]." ";
					$SinDefinir=true;
				}
				else
				{
					echo "<td align='right' bgcolor='".$Color."'>";
				}
				echo number_format($v[4],2,",",".")."</td>\n";	
		}
		echo "<td align='center'>";		
		if ($SinDefinir==true)
		{
			echo "&nbsp;";
			$Mensaje="Analisis Por Realizar";
		}
		else
		{
			if ($Errores)
			{
				echo "<input type=\"checkbox\" name=\"ChkValores\" value=\"".$ClaveChk."\">";
				$Mensaje="Analisis Fuera de Rango";				
			}
			else
			{
				echo "&nbsp;";
				$Mensaje="Analisis OK";
			}
		}
		echo "</td>\n";
		echo "<td>".$Mensaje."</td>\n";		
		echo "</tr>\n";
		reset($ArrLeyes);
		do {			 
			$key = key ($ArrLeyes);
			$ArrLeyes[$key][4] = "";
		} while (next($ArrLeyes));	
	}
?>   
</table>
</form>
</body>
</html>
