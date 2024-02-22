<?php 
	include("../principal/conectar_principal.php");
		//CONSULTA DESCRIPCION PROD. Y SUBPROD
	$ConsultaAux = "select t1.cod_producto, t2.cod_subproducto, t1.descripcion as nom_prod, t2.descripcion as nom_subprod from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2 ";
	$ConsultaAux.= " on t1.cod_producto=t2.cod_producto ";
	$ConsultaAux.= " where t1.cod_producto='".$CmbProductos."' and t2.cod_subproducto='".$CmbSubProducto."'";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$Producto=$Fila["nom_prod"];
		$SubProducto=$Fila["nom_subprod"];
	}
	//--------------------------------------
	//CONSULTA CENTRO COSTO
	$ConsultaAux = "select descripcion from proyecto_modernizacion.centro_costo ";
	$ConsultaAux.= " where centro_costo='".$CmbCCosto."' ";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$CCosto=$Fila["descripcion"];
	}
	//--------------------------------------
	//CONSULTA AREA
	$ConsultaAux = "select nombre_subclase from proyecto_modernizacion.sub_clase ";
	$ConsultaAux.= " where cod_clase = 3 and cod_subclase='".$CmbAreasProceso."' order by cod_subclase";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$Areas=$Fila["nombre_subclase"];
	}
	//--------------------------------------
	$Consulta1 ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	$Fila1=mysqli_fetch_array($Respuesta1);
	$Nivel=$Fila1["nivel"];
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 50;
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 22;
	if ($CmbTipo=='-1')
	{
		$Tipo='';
	}
	else
	{
		$Tipo=" and t1.tipo='".$CmbTipo."'";
	}
	if ($CmbTipoAnalisis=='-1')
	{
		$TipoAnalisis='';
	}
	else
	{
		$TipoAnalisis=" and t1.cod_analisis='".$CmbTipoAnalisis."'";
	}

	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
	$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo  inner join 	proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
	$Consulta = $Consulta." where (t1.cod_periodo='".$CmbPeriodo."')".$Tipo.$TipoAnalisis;
	$Consulta = $Consulta." and (t1.estado_actual <> '7') ";
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5')||($Nivel=='8')||($CmbCCosto=='6150'))
	{
		$Consulta = $Consulta."  ";
	}
	else
	{
		$Consulta = $Consulta." and t1.cod_producto <> 1 ";
	
	}
	if ($CmbSubProducto==-2)
	{
		if ($Producto!="")
		{
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		}
	}
	else
	{
		if ($Producto!="")
		{
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		}
		if ($SubProducto!="")
		{
			$Consulta=$Consulta." and t1.cod_subproducto ='".$CmbSubProducto."'";
		}
	}
	if ($CCosto!="")
	{
		$Consulta = $Consulta." and t1.cod_ccosto='".$CmbCCosto."'";
	}
	if ($Areas!="")
	{
		$Consulta = $Consulta." and t1.cod_area=".$CmbAreasProceso;
	}
	$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta = $Consulta." and (t1.fecha_muestra between '".$FechaI."' and '".$FechaT."')";
	if ($Enabal=='S')
	{
		$Consulta = $Consulta." and (t1.enabal='S')";
	}
	//echo "CON".$Consulta;
	$Seleccion1= "select distinct t3.cod_leyes,t4.abreviatura";
	$Seleccion2= "select distinct t1.nro_solicitud,t1.recargo ";
	$Seleccion3= "select count(distinct t1.nro_solicitud,t1.recargo) as total_registros ";
	$Criterio=$Seleccion1.$Consulta." order by t3.cod_leyes";
	echo $Criterio."</br>";
	$Respuesta1=mysqli_query($link, $Criterio);
	$Arreglo=array();
	while($Fila1=mysqli_fetch_array($Respuesta1))
	{
		$Arreglo[$Fila1["cod_leyes"]][0]=$Fila1["abreviatura"];
		$Arreglo[$Fila1["cod_leyes"]][1]="";
		//$AnchoTabla=$AnchoTabla	+ 160;
		$AnchoTabla=$AnchoTabla	+ 60;		
	
	}
	$Criterio2=$Seleccion3.$Consulta;
?>
<html>
<head>
<script language="JavaScript">
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Imprimir()
{
	var f=document.FrmConsultaGeneral;
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnImprimir2.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	f.BtnSalir2.style.visibility = "hidden";
	window.print();
	f.BtnImprimir.style.visibility = "visible";
	f.BtnImprimir2.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
	f.BtnSalir2.style.visibility = "visible";

}
function Salir()
{
	var frm=document.FrmConsultaGeneral;
	frm.action="cal_consulta_general.php";
	frm.submit();
}
function Recarga(LimitIni,Producto,SubProducto,CCosto,Areas,CmbProductos,CmbSubProducto,CmbCCosto,CmbAreasProceso,CmbPeriodo,CmbAno,CmbMes,CmbDias,CmbAnoT,CmbMesT,CmbDiasT,E,CmbTipoAnalisis,CmbTipo)
{
	var frm=document.FrmConsultaGeneral;
	frm.action="cal_consulta_general_respuesta.php?LimitIni="+LimitIni+"&Producto="+Producto+"&SubProducto="+SubProducto+"&CCosto="+CCosto+"&CmbCCosto="+CmbCCosto + "&CmbProductos="+CmbProductos+"&CmbSubProducto="+CmbSubProducto+"&Areas="+Areas+"&CmbPeriodo="+CmbPeriodo+"&CmbAreasProceso="+CmbAreasProceso + "&CmbAno="+CmbAno+"&CmbMes="+CmbMes+"&CmbDias="+CmbDias+"&CmbAnoT="+CmbAnoT+"&CmbMesT="+CmbMesT+"&CmbDiasT="+CmbDiasT+"&Enabal="+E+"&CmbTipoAnalisis="+CmbTipoAnalisis+"&CmbTipo="+CmbTipo;
	frm.submit(); 
}

</script>
<title>Consulta General</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaGeneral" method="post" action="">
<input type="hidden" name="LimitFin" value="<?php echo $LimitFin; ?>">
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999" class="TablaInterior">
  <?php if ($CCosto!=""){?>
    <tr bgcolor="#FFFFFF">
      <td>C.Costo:</td>
      <td width="496" align="left" bgcolor="#EFEFEF"><?php echo $CCosto; ?></td>
    </tr>
	<?php }
	if ($Areas!="") { ?>
    <tr bgcolor="#FFFFFF">
      <td>Area:</td>
      <td align="left" bgcolor="#EFEFEF"><?php echo $Areas; ?></td>
    </tr>
	<?php } ?>
    <tr bgcolor="#FFFFFF">
      <td>Tipo Analisis:</td>
      <td align="left" bgcolor="#EFEFEF">
        <?php
			  if ($CmbTipoAnalisis=='-1')
			  {
				 echo "Todos";
			  }
			  else
			  {	
				if ($CmbTipoAnalisis=='1')
				 {
					echo "Quimico";  
				 }
				 else
				 {
					echo "Fisico";  
				 }
			  } 	
			?>
      </td>
    </tr>
	<?php if ($Producto!="") { ?>
    <tr bgcolor="#FFFFFF">
      <td width="90">Producto:</td>
      <td align="left" bgcolor="#EFEFEF"><?php echo $Producto; ?></td>
    </tr>
	<?php } 
	if ($SubProducto!="") {?>
    <tr bgcolor="#FFFFFF">
      <td>SubProducto:</td>
      <td bgcolor="#EFEFEF"><?php echo $SubProducto; ?></td>
    </tr>
	<?php } ?>
    <tr bgcolor="#FFFFFF">
      <td>Tipo Muestra:</td>
      <td bgcolor="#EFEFEF">
        <?php 
				$Con="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase=1005";
				$Con=$Con." and cod_subclase = '".$CmbTipo."'";
				$Respuesta= mysqli_query($link, $Con);
				$Fila= mysqli_fetch_array($Respuesta); 
				$Tipo= $Fila["nombre_subclase"];
				if ($CmbTipo=='-1')
				{	
					echo "Todos";
				}
				else
				{	
					echo $Tipo ;
				}
			?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>Periodo:</td>
      <td bgcolor="#EFEFEF">
        <?php 
		        //$AnchoTabla = $AnchoTabla + 490;
				$ConsultaN = "select * from proyecto_modernizacion.sub_clase where cod_clase = 2 and cod_subclase = '".$CmbPeriodo."' order by cod_subclase";
				$RespuestaN= mysqli_query($link, $ConsultaN);
				while ($FilaN = mysqli_fetch_array($RespuestaN))
				{
					$Periodo=$FilaN["nombre_subclase"];
				}
				echo $Periodo."&nbsp;&nbsp;&nbsp;&nbsp;";
				switch ($CmbPeriodo)
				{
					case "1":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
					case "2":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;		
					case "3":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
					case "4":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
					case "5":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
				}
			?>
      </td>
    </tr>
    <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70" onClick="Imprimir();" value="Imprimir">
&nbsp;
      <input name="BtnSalir" type="button" id="BtnSalir" style="width:70" onClick="Salir();" value="Salir"></td>
    </tr>
  </table>
  <br>
		<?php
			$AnchoTabla=$AnchoTabla+90;
			if ($ChkAgrupacion=="S") 
				$AnchoTabla=$AnchoTabla+60;
			if ($ChkFechaMuestra=="S")
				$AnchoTabla=$AnchoTabla+130;
			if ($ChkProducto=="S")
				$AnchoTabla=$AnchoTabla+100;
			if ($ChkSubProducto=="S")
				$AnchoTabla=$AnchoTabla+100;
			if ($ChkPesoMuestra=="S")
				$AnchoTabla=$AnchoTabla+60;
			if (($CmbProductos=='42')&&($CmbSubProducto=='33'))
				$AnchoTabla=$AnchoTabla+130;
			if ($ChkObservacion=="S")
				$AnchoTabla=$AnchoTabla+350; 
		?>
        <table width="<?php echo $AnchoTabla; ?>" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999" style="font-size:9px ">
  
				<tr class="ColorTabla01">
				<?php if (count($Arreglo)>0)
				{ ?>
					<td width="50" align="center">S.A</td>
					<td width="50" align="center">Id.Muestra</td>
					<?php
					//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
					reset($Arreglo);
					while(list($Clave,$Valor)=each($Arreglo))
					{
						echo "<td  align=\"center\" colspan=\"2\">".$Valor[0]."</td>";
					}
					?>
					<?php if ($ChkAgrupacion=="S") {?>
					<td width="60" align="center">Agrup.</td>
					<?php }if ($ChkFechaMuestra=="S") {?>
					<td width="130" align="center">Fecha Muestra</td>
					<?php }if ($ChkProducto=="S") {?>
					<td width="100" align="center">Producto</td>
					<?php }if ($ChkSubProducto=="S") {?>
					<td width="100" align="center">SubProducto</td>
					<?php } if ($ChkPesoMuestra=="S") {?>
					<td width="60" align="center">Peso Muestra</td>
					<?php }
					if (($CmbProductos=='42')&&($CmbSubProducto=='33'))
					{ ?>
					     <td width="130" align="center">Fecha Entrada</td>
					<?php }if ($ChkObservacion=="S") {?>
					<td width="350" align="center">Observacion</td>
					<?php } ?>
		  </tr>
					<?php
					$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud LIMIT ".$LimitIni.", ".$LimitFin;
					$Respuesta2=mysqli_query($link, $Criterio);
					//echo $Criterio."</br>";
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						echo "<tr bgcolor=\"#FFFFFF\">";
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==""))
						{
							$Recargo='N';
							echo "<td align=\"center\"><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">".intval(substr($Fila["nro_solicitud"],4))."</a></td>";
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto "; 
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"];
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td align=\"left\">".$FilaDatos["id_muestra"]."</td>";							
						}
						else
						{
							echo "<td align=\"center\"><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."')\">".intval(substr($Fila["nro_solicitud"],4))."-".$Fila["recargo"]."</a></td>";								
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td align=\"left\">".$FilaDatos["id_muestra"]."</td>";									
						}	
						//SE LIMPIA EL ARREGLO
						reset($Arreglo);
						while(list($Clave,$Valor)=each($Arreglo))
						{
							$Arreglo[$Clave][1]="&nbsp;";				
						}
						//SE ASIGNAN LOS VALORES AL ARREGLO
						$Consulta ="select t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
						//echo $Consulta."</br>";
						$Respuesta3=mysqli_query($link, $Consulta);
						while($Fila3=mysqli_fetch_array($Respuesta3))
						{
							if ($Fila3["signo"]=="N")
							{
								$Arreglo[$Fila3["cod_leyes"]][1]="ND";
								$Arreglo[$Fila3["cod_leyes"]][2]="";
							}
							else
							{
								if ($Fila3["signo"]=="=")
								{
									$Valor=number_format($Fila3["valor"],3,",",".");
									$Arreglo[$Fila3["cod_leyes"]][1]=$Valor;
									$Arreglo[$Fila3["cod_leyes"]][2]=$Fila3["abreviatura"];
								}
								else
								{
									$Valor=number_format($Fila3["valor"],3,",",".");
									$Arreglo[$Fila3["cod_leyes"]][1]=$Fila3["signo"]."".$Valor;
									$Arreglo[$Fila3["cod_leyes"]][2]=$Fila3["abreviatura"];
								}
							}		
						}
						//SE LLENA LA LISTA CON VALORES DEL ARREGLO
						reset($Arreglo);
						while(list($Clave,$Valor)=each($Arreglo))
						{
							//echo "valor".$Valor[1]."--".$Valor[2]."</br>";
							echo "<td align=\"right\" ><span style=\"font-size:9px \">".$Valor[1]."</span></td>";
							echo "<td align=\"center\" bgcolor=\"#efefef\" ><span style=\"font-size:9px \">".$Valor[2]."</span></td>";
						}
						if ($ChkAgrupacion=="S")
							echo "<td align=\"left\">".$FilaDatos["nombre_subclase"]."</td>";							
						if ($ChkFechaMuestra=="S")
							echo "<td align=\"center\">".substr($FilaDatos["fecha_muestra"],8,2)."/".substr($FilaDatos["fecha_muestra"],5,2)."/".substr($FilaDatos["fecha_muestra"],2,2)." ".substr($FilaDatos["fecha_muestra"],11,5)."</td>";
						if ($ChkProducto=="S")
							echo "<td align=\"left\">".$FilaDatos["producto"]."</td>";
						if ($ChkSubProducto=="S")
							echo "<td align=\"left\">".$FilaDatos["subproducto"]."</td>";		
						if (($FilaDatos["cod_producto"]=='42')&&(($FilaDatos["cod_subproducto"]=='33')||($FilaDatos["cod_subproducto"]=='35')||($FilaDatos["cod_subproducto"]=='53')))
						{
							$pos = strpos(strtoupper($FilaDatos["id_muestra"]),"R-");
							if ($pos === false)
							{
								if ($ChkPesoMuestra=="S")
									echo "<td align=\"center\">&nbsp;</td>";
								if ($ChkFechaEntrada=="S")
									echo "<td align=\"center\">&nbsp;</td>";
								if ($ChkObservacion=="S")
									echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
							}
							else
							{
					            $Consulta="select pesont_a from rec_web.despachos where lote_a='".substr($FilaDatos["id_muestra"],0,6)."' and recarg_a='".trim(substr($FilaDatos["id_muestra"],$pos+2))."'";
								$Resp=mysqli_query($link, $Consulta);
								if ($FilaPeso=mysqli_fetch_array($Resp))
								{								     
									if ($ChkPesoMuestra=="S")
										echo "<td align=\"right\">".$FilaPeso["pesont_a"]."</td>";
								    $Consultan="select fecha_a,hora_a from rec_web.despachos where lote_a='".substr($FilaDatos["id_muestra"],0,6)."' and recarg_a='".trim(substr($FilaDatos["id_muestra"],$pos+2))."'";
								    $Respn=mysqli_query($link, $Consultan);
								    if ($FilaFechan=mysqli_fetch_array($Respn))
									{
									   if ($ChkFechaEntrada=="S")
											echo "<td align=\"center\">".substr($FilaFechan["fecha_a"],8,2)."/".substr($FilaFechan["fecha_a"],5,2)."/".substr($FilaFechan["fecha_a"],2,2)." ".substr($FilaFechan["hora_a"],0,5)."</td>";
									}
									else
									{
										if ($ChkFechaEntrada=="S")
											echo "<td align=\"center\">&nbsp;</td>";
									}
									if ($ChkObservacion=="S")
										echo "<td >".$FilaDatos["observacion"]."&nbsp;</td>";
								}
								else
								{
									if ($ChkPesoMuestra=="S")
										echo "<td align=\"right\">&nbsp;</td>";
									if ($ChkFechaEntrada=="S")
										echo "<td align=\"center\">&nbsp;</td>";
									if ($ChkObservacion=="S")
										echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
								}
							}
						}
						else
						{
							if ($ChkPesoMuestra=="S")
								echo "<td>&nbsp;</td>";
							if ($ChkObservacion=="S")
								echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
						}	
						echo "</tr>";
					}
				}
				else
				{
					if ($ChkPesoMuestra=="S")
						echo "<td>&nbsp;</td>";
					if ($ChkObservacion=="S")
						echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
					echo "</tr>";
				}
			?>
  </table>
        <br>
        <table width="755" border="0" align="center" cellpadding="3" cellspacing="1"><!-- class="TablaInterior">-->
          <tr>
            <td align="center">
			<?php
				$Respuesta = mysqli_query($link, $Criterio2);
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
						$LimiteInicial=$i * $LimitFin;
						$Param="$LimiteInicial,'$Producto','$SubProducto','$CCosto','$Areas','$CmbProductos','$CmbSubProducto','$CmbCCosto','$CmbAreasProceso','$CmbPeriodo','$CmbAno','$CmbMes','$CmbDias','$CmbAnoT','$CmbMesT','$CmbDiasT','$Enabal','$CmbTipoAnalisis','$CmbTipo'";
						$Param=str_replace(" ","%20",$Param);
						//$StrPaginas.=  "<a href=JavaScript:Recarga('$LimiteInicial','$Producto','$SubProducto','$CCosto','$Areas','$CmbProductos','$CmbSubProducto','$CmbCCosto','$CmbAreasProceso','$CmbPeriodo','$CmbAno','$CmbMes','$CmbDias','$CmbAnoT','$CmbMesT','$CmbDiasT');>";
						$StrPaginas.=  "<a href=JavaScript:Recarga($Param);>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
				}
				echo substr($StrPaginas,0,-15);
				//echo $StrPaginas;
			?>	
		   </td>
		  </tr>
          <tr>
            <td align="center"><input name="BtnImprimir2" type="button" id="BtnImprimir2" style="width:70" onClick="Imprimir();" value="Imprimir">
&nbsp;
<input name="BtnSalir2" type="button" id="BtnSalir2" style="width:70" onClick="Salir();" value="Salir"></td>
          </tr>
  </table>
        <br>
        </td>
        </tr>
        </table>
</form>
</body>
</html>
