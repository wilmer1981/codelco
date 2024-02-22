<?php 
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");

		$CookieRut= $_COOKIE["CookieRut"];


		$CmbProductos = $_REQUEST["CmbProductos"];
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
		$CmbCCosto = $_REQUEST["CmbCCosto"];
		$CmbAreasProceso = $_REQUEST["CmbAreasProceso"];
		$CmbPeriodo = $_REQUEST["CmbPeriodo"];
		$Enabal = $_REQUEST["Enabal"];
		$CmbTipo = $_REQUEST["CmbTipo"];
		$CmbTipoAnalisis = $_REQUEST["CmbTipoAnalisis"];
		$CmbDias = $_REQUEST["CmbDias"];
		$CmbMes = $_REQUEST["CmbMes"];
		$CmbAno = $_REQUEST["CmbAno"];
		$CmbDiasT = $_REQUEST["CmbDiasT"];
		$CmbMesT = $_REQUEST["CmbMesT"];
		$CmbAnoT = $_REQUEST["CmbAnoT"];
		$LimitIni = $_REQUEST["LimitIni"];
		$LimitFin = $_REQUEST["LimitFin"];
		$ChkAgrupacion = $_REQUEST["ChkAgrupacion"];
		$ChkFechaMuestra = $_REQUEST["ChkFechaMuestra"];
		$ChkProducto = $_REQUEST["ChkProducto"];
		$ChkSubProducto = $_REQUEST["ChkSubProducto"];
		$ChkPesoMuestra = $_REQUEST["ChkPesoMuestra"];
		$ChkObservacion = $_REQUEST["ChkObservacion"];
		$Producto = $_REQUEST["Producto"];
		$SubProducto = $_REQUEST["SubProducto"];
		$CCosto = $_REQUEST["CCosto"];
		$Areas = $_REQUEST["Areas"];
	

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
	$Consulta1 ="SELECT nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
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
	if($CmbAno<2008 && $CmbAno>0)
		//$Consulta = $Consulta." from cal_histo.solicitud_analisis_a_".$CmbAno." t1 inner join cal_histo.leyes_por_solicitud_a_".$CmbAno." t3 on ";
		$Consulta = " from cal_histo.solicitud_analisis_a_".$CmbAno." t1 inner join cal_histo.leyes_por_solicitud_a_".$CmbAno." t3 on ";
	else
		//$Consulta = $Consulta." from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t3 on ";
		$Consulta = " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t3 on ";
	$Consulta = $Consulta."  t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
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
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
	}
	else
	{
		if ($Producto!="")
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		if ($SubProducto!="")
			$Consulta=$Consulta." and t1.cod_subproducto ='".$CmbSubProducto."'";
	}
	if ($CCosto!="")
	{
		$Consulta = $Consulta." and t1.cod_ccosto='".$CmbCCosto."'";
	}
	if ($Areas!="")
	{
		$Consulta = $Consulta." and t1.cod_area=".$CmbAreasProceso;
	}
	if($CmbAno<2008 && $CmbAno<>$CmbAnoT)
		$CmbAnoT = $CmbAno;
	$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta = $Consulta." and (t1.fecha_muestra between '".$FechaI."' and '".$FechaT."')";
	if ($Enabal=='S')
	{
		$Consulta = $Consulta." and (t1.enabal='S')";
	}
	$Seleccion1= "SELECT distinct t3.cod_leyes,t4.abreviatura";
	$Seleccion2= "SELECT distinct t1.nro_solicitud,t1.recargo ";
	$Seleccion3= "SELECT count(distinct t1.nro_solicitud,t1.recargo) as total_registros ";
	$Criterio=$Seleccion1.$Consulta." order by t3.cod_leyes";
	$Respuesta1=mysqli_query($link, $Criterio);
	$Arreglo=array();
	$AnchoTabla=0;
	while($Fila1=mysqli_fetch_array($Respuesta1))
	{
		$Arreglo[$Fila1["cod_leyes"]][0]=$Fila1["abreviatura"];
		$Arreglo[$Fila1["cod_leyes"]][1]="";
		//$AnchoTabla=$AnchoTabla	+ 160;
		$AnchoTabla=$AnchoTabla	+ 80;		
	
	}
	$Criterio2=$Seleccion3.$Consulta;
?>
<html>
<head>
<title>Consulta General</title>
</head>
<body >
<form name="FrmConsultaGeneral" method="post" action="">
<input type="hidden" name="LimitFin" value="<?php echo $LimitFin; ?>">
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999" class="TablaInterior">
  <?php if ($CCosto!=""){?>
    <tr bgcolor="#FFFFFF">
      <td colspan="2">C.Costo:</td>
      <td colspan="8" width="496" align="left" bgcolor="#EFEFEF"><?php echo $CCosto; ?></td>
    </tr>
	<?php }
	if ($Areas!="") { ?>
    <tr bgcolor="#FFFFFF">
      <td colspan="2">Area:</td>
      <td colspan="8" align="left" bgcolor="#EFEFEF"><?php echo $Areas; ?></td>
    </tr>
	<?php } ?>
    <tr bgcolor="#FFFFFF">
      <td colspan="2">Tipo Analisis:</td>
      <td colspan="8" align="left" bgcolor="#EFEFEF">
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
      <td colspan="2" width="90">Producto:</td>
      <td colspan="8" align="left" bgcolor="#EFEFEF"><?php echo $Producto; ?></td>
    </tr>
	<?php } 
	if ($SubProducto!="") {?>
    <tr bgcolor="#FFFFFF">
      <td colspan="2">SubProducto:</td>
      <td colspan="8" bgcolor="#EFEFEF"><?php echo $SubProducto; ?></td>
    </tr>
	<?php } ?>
    <tr bgcolor="#FFFFFF">
      <td colspan="2">Tipo Muestra:</td>
      <td colspan="8" bgcolor="#EFEFEF">
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
      <td colspan="2">Periodo:</td>
      <td colspan="8" bgcolor="#EFEFEF">
        <?php 
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
  </table>
  <br>
		<?php
			$AnchoTabla=$AnchoTabla+120;
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
        <table width="<?php echo $AnchoTabla; ?>" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
  
				<tr class="ColorTabla01">
				<?php if (count($Arreglo)>0)
				{ ?>
					<td width="60" align="center">S.A</td>
					<td width="60" align="center">Id.Muestra</td>
					<?php
					//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
					reset($Arreglo);
					//while(list($Clave,$Valor)=each($Arreglo))
					foreach ($Arreglo as $Clave => $Valor) 
					{
						echo "<td align=\"center\" width=\"20\">Sig.</td>";
						echo "<td align=\"center\" width=\"80\">".$Valor[0]."</td>";
						echo "<td align=\"center\" width=\"20\">Unid.</td>";
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
					$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud ";// LIMIT ".$LimitIni.", ".$LimitFin;
					$Respuesta2=mysqli_query($link, $Criterio);
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						echo "<tr bgcolor=\"#FFFFFF\">";
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==""))
						{
							$Recargo='N';
							echo "<td align=\"center\">".intval(substr($Fila["nro_solicitud"],4))."</td>";
							$Consulta ="select STRAIGHT_JOIN t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion ";
							if($CmbAno<2008 && $CmbAno>0)
								$Consulta.=" from cal_histo.solicitud_analisis_a_".$CmbAno." t1 ";
								else
								$Consulta.=" from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto "; 
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"];
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td align=\"left\">".$FilaDatos["id_muestra"]."</td>";							
						}
						else
						{
							echo "<td align=\"center\">".intval(substr($Fila["nro_solicitud"],4))."-".$Fila["recargo"]."</td>";								
							$Consulta ="select STRAIGHT_JOIN t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion ";
							if($CmbAno<2008 && $CmbAno>0)							
								$Consulta.=" from cal_histo.solicitud_analisis_a_".$CmbAno." t1 ";
								else
								$Consulta.=" from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td align=\"left\">".$FilaDatos["id_muestra"]."</td>";									
						}	
						//SE LIMPIA EL ARREGLO
						reset($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach ($Arreglo as $Clave => $Valor) 
						{
							$Arreglo[$Clave][1]="&nbsp;";				
						}
						//SE ASIGNAN LOS VALORES AL ARREGLO
						$Consulta ="select STRAIGHT_JOIN t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura ";
						if($CmbAno<2008 && $CmbAno>0)
							$Consulta.=" from cal_histo.leyes_por_solicitud_a_".$CmbAno." t1 ";
							else
							$Consulta.=" from cal_web.leyes_por_solicitud t1 ";
						$Consulta.=" inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
						//echo $Consulta."</br>";
						$Respuesta3=mysqli_query($link, $Consulta);
						while($Fila3=mysqli_fetch_array($Respuesta3))
						{
							if ($Fila3["signo"]=="N")
							{
								$Arreglo[$Fila3["cod_leyes"]][1]="ND";
								$Arreglo[$Fila3["cod_leyes"]][2]="";
								if ($Fila3["signo"]=="=")
									$Arreglo[$Fila3["cod_leyes"]][3]="";
								else
									$Arreglo[$Fila3["cod_leyes"]][3]=$Fila3["signo"];
							}
							else
							{
								if ($Fila3["signo"]=="=")
								{
									$Valor=number_format($Fila3["valor"],3,",",".");
									$Arreglo[$Fila3["cod_leyes"]][1]=$Valor;
									$Arreglo[$Fila3["cod_leyes"]][2]=$Fila3["abreviatura"];
									$Arreglo[$Fila3["cod_leyes"]][3]="";
								}
								else
								{
									$Valor=number_format($Fila3["valor"],3,",",".");
									$Arreglo[$Fila3["cod_leyes"]][1]=$Valor;
									$Arreglo[$Fila3["cod_leyes"]][2]=$Fila3["abreviatura"];
									$Arreglo[$Fila3["cod_leyes"]][3]=$Fila3["signo"];
								}
							}		
						}
						//SE LLENA LA LISTA CON VALORES DEL ARREGLO
						reset($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach ($Arreglo as $Clave => $Valor) 
						{
							echo "<td align=\"right\" >".$Valor[3]."</td>";
							echo "<td align=\"right\" >".$Valor[1]."</td>";
							echo "<td align=\"center\" bgcolor=\"#efefef\" >".$Valor[2]."</td>";
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
        <br>
        </td>
        </tr>
        </table>
</form>
</body>
</html>
