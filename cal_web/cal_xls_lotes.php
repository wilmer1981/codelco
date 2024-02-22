<?php         ob_end_clean();
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
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;

if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes =  date("m");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT =  date("d");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT =  date("m");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT =  date("Y");
}
if(isset($_REQUEST["IdInicial"])) {
	$IdInicial = $_REQUEST["IdInicial"];
}else{
	$IdInicial =  "";
}
if(isset($_REQUEST["IdFinal"])) {
	$IdFinal = $_REQUEST["IdFinal"];
}else{
	$IdFinal =  "";
}
if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar =  "";
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni =  0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin =  10;
}


?>
<html>
<head>
<title></title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsultaRecepcion" method="post" action="">
<?php
	/*if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <tr> <td width="756"></tr>
  <tr>
    <table width="345" border="0" cellpadding="3" cellspacing="0" >
      <tr> 
        <td width="89"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            Usuario:</font></font></div></td>
        <td width="241"><strong> 
          <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
		
			}
		  ?>
          </strong></td>
      </tr>
      <tr> 
        <td height="31">Fecha Inicio<font size="2">:&nbsp; </font></td>
        <td><font size="2"> 
          <?php echo $CmbDias."/".$CmbMes."/".$CmbAno; ?>
          </font> </td>
      </tr>
      <tr> 
        <td height="31">Fecha Termino:</td>
        <td>
          <?php echo $CmbDiasT."/".$CmbMesT."/".$CmbAnoT; ?>
        </td>
      </tr>
      <tr> 
        <td height="31">&nbsp;</td>
        <td> <div align="left"> </div></td>
      </tr>
    </table>
    <br>
    <table width="873" border="1" cellpadding="0" cellspacing="0" >
      <tr> 
        <td height="20"> <div align="center"></div>
          S.A</td>
        <td width="144" height="20">Agrupacion</td>
		<td width="144" height="20">Id Muestra</td>
        <td width="171" height="20"><div align="center">F Muestra</div></td>
        <td width="94"><div align="left"> 
            <div align="center"></div>
            <div align="center">F.Creacion</div>
          </div></td>
        <td width="128"><div align="center">Producto</div></td>
        <td width="198"><div align="center">SubProducto</div></td>
      </tr>
     <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		$Consulta=" select t1.lote_origen,t1.cod_origen from sea_web.relaciones t1";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote_origen = t2.id_muestra";
		$Consulta.=" where (t1.lote_ventana between '".$IdInicial."' and '".$IdFinal."') ";
		//echo $Consulta."<br>";
		$Respuesta=mysqli_query($link, $Consulta);
		$i=0;
		$Encontro=false;
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			if ($Fila["cod_origen"]=='1')
			{
					if ($i==0)
					{
						$LoteOrigen=$Fila["lote_origen"];
					}
					$LoteFinal=$Fila["lote_origen"];
					$Encontro=true;
					$i++;
			}
		}
		if ($Encontro==true)
		{
			$Pregunta.=" (t1.id_muestra between '".$LoteOrigen."' and '".$LoteFinal."') or (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."') and (t1.fecha_muestra between  '".$FechaI."' and '".$FechaT."') and ((t1.agrupacion = 1)or(t2.lotes='S')) ";
		}
		else
		{
			$Pregunta = "   (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."') and (t1.fecha_muestra between  '".$FechaI."' and '".$FechaT."') and ((t1.agrupacion = 1)or(t2.lotes='S')) ";
		}
		$Consulta = "SELECT distinct(t1.nro_solicitud), t1.nro_sa_lims,t1.fecha_hora,t1.fecha_muestra,t1.cod_producto,t1.cod_subproducto,t1.rut_funcionario,t1.id_muestra,t1.fecha_hora as FechaCreacion,t1.tipo_solicitud,t1.agrupacion,t1.estado_actual from cal_web.solicitud_analisis t1 ";		
		$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta = $Consulta." where (not isnull(t1.nro_solicitud) or t1.nro_solicitud = '') and ";
		$Consulta = $Consulta.$Pregunta; 
		$Respuesta= mysqli_query($link, $Consulta);
		$Coincidencias=0;
		while ($Fila=mysqli_fetch_array($Respuesta))
	  	{
			echo "<tr>";
			if (($Fila["tipo_solicitud"]=='R') && ($Fila["estado_actual"] =='6')) 				
			{
				if ($Fila["nro_sa_lims"]=='') {
  					$VarSA=$Fila["nro_solicitud"];
  				}else{
  					$VarSA=$Fila["nro_sa_lims"];
  				}


				echo "<td width='95'>".$TxtSA = $VarSA."
				<input name = TxtSAO type = 'hidden' value ='".$VarSA."'>
				<input name = TxtRecargoO type = 'hidden' value ='N'></div></td>";	




				$Consulta ="select t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
				$Consulta.= " inner join cal_web.solicitud_analisis t1 on  t1.agrupacion = t2.cod_subclase and t2.cod_clase = 1004  "; 
				$Consulta.= " where t1.nro_solicitud = ".$Fila["nro_solicitud"]." ";
				$Resp1=mysqli_query($link, $Consulta);
				$Fil1=mysqli_fetch_array($Resp1);
				echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
				echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
				echo "<td width ='150'><div align ='left'>".$Fila["fecha_muestra"]."&nbsp;</div></td>";		
				echo "<td width ='150'><div align ='left'>".$Fila["FechaCreacion"]."&nbsp;</div></td>";		
				//----------------------Producto y  Subproducto --------------------------------------
				$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
				$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
				$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
				$Consulta.= " where t1.nro_solicitud = '".$Fila["nro_solicitud"]."' ";
				echo "<input type='hidden' name='checkSA'><input name ='TxtSAO' type='hidden'><input name ='TxtRecargoO' type='hidden'>";
				$Resp=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Resp);  
				echo "<td align ='center'>".$Fila1["AbrevProducto"]."</td>";
				echo "<td align = 'center'>".$Fila1["AbrevSubProducto"]."</td>";
				echo "</tr>";
			}
			if ($Fila["tipo_solicitud"]=='A')
			{
				$Consulta = " select count(*) as NroSol from cal_web.solicitud_analisis where nro_solicitud = '".$Fila["nro_solicitud"]."'"; 
				$Respuesta2 = mysqli_query($link, $Consulta);
				$Fila2 = mysqli_fetch_array($Respuesta2);
				$N1 = $Fila2["NroSol"];
				$Consulta = " select count(*) as NroSolF from cal_web.solicitud_analisis where nro_solicitud = '".$Fila["nro_solicitud"]."' and estado_actual = '6'"; 
				$Respuesta3 = mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3);
				$N2=$Fila3["NroSolF"];
				
				if ($Fila2["NroSol"] == $Fila3["NroSolF"])
				{	

					if ($Fila["nro_sa_lims"]=='') {
	  					$VarSA=$Fila["nro_solicitud"];
	  				}else{
	  					$VarSA=$Fila["nro_sa_lims"];
	  				}

					echo "<tr>";
					echo "<td width='95'><div align='center'>".$TxtSA = $Fila["nro_solicitud"]."<input name = TxtSAO type = 'hidden' value ='".$VarSA."'><input name = TxtRecargoO type = 'hidden' value ='N'></div></td>";									
					$Consulta ="select t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta.= " inner join cal_web.solicitud_analisis t1 on  t1.agrupacion = t2.cod_subclase and t2.cod_clase = 1004  "; 
					$Consulta.= " where t1.nro_solicitud = ".$Fila["nro_solicitud"]." ";
					$Resp1=mysqli_query($link, $Consulta);
					$Fil1=mysqli_fetch_array($Resp1);
					echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
					$Consulta=" select t1.lote_ventana from sea_web.relaciones t1";
					$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote_origen = t2.id_muestra";
					$Consulta.=" where (t2.id_muestra='".$Fila["id_muestra"]."') ";
					$Resp20=mysqli_query($link, $Consulta);
					if ($Fil20=mysqli_fetch_array($Resp20))
					{
						echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fil20["lote_ventana"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
					}
					else
					{
						echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
					}
					echo "<td width ='150'><div align ='left'>".$Fila["fecha_muestra"]."&nbsp;</div></td>";		
					echo "<td width ='150'><div align ='left'>".$Fila["FechaCreacion"]."&nbsp;</div></td>";		
					//----------------------Producto y  Subproducto --------------------------------------
					$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
					$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
					$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
					$Consulta.= " where t1.nro_solicitud = '".$Fila["nro_solicitud"]."' ";
					$Resp=mysqli_query($link, $Consulta);
					$Fila1=mysqli_fetch_array($Resp);  
					echo "<td align ='center'>".$Fila1["AbrevProducto"]."</td>";
					echo "<td align = 'center'>".$Fila1["AbrevSubProducto"]."</td>";
					echo "</tr>";
				}	
			}
		}
	   ?>
    </table>
    <br></td>
    </tr>
</form>
</body>
</html>
