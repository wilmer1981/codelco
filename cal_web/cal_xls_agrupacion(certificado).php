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

$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;

if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar =  "";
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes = date("m");
}
if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}

if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT =  date("Y");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT = date("m");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT =  date("d");
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
if(isset($_REQUEST["CmbAgrupacion"])) {
	$CmbAgrupacion = $_REQUEST["CmbAgrupacion"];
}else{
	$CmbAgrupacion = "";
}
if(isset($_REQUEST["CmbPeriodo"])) {
	$CmbPeriodo = $_REQUEST["CmbPeriodo"];
}else{
	$CmbPeriodo = "";
}
if(isset($_REQUEST["nro_solicitud"])) {
	$nro_solicitud = $_REQUEST["nro_solicitud"];
}else{
	$nro_solicitud = "";
}
if(isset($_REQUEST["id_muestra"])) {
	$id_muestra = $_REQUEST["id_muestra"];
}else{
	$id_muestra = "";
}


?>
<html>
<head>
<title></title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
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
    <table width="355" border="0" cellpadding="3" cellspacing="0" >
      <tr> 
        <td width="89"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            Usuario:</font></font></div></td>
        <td width="251"><strong> 
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
        <td><?php echo $CmbDias."/".$CmbMes."/".$CmbAno; ?></td>
          
      </tr>
      <tr> 
        <td height="31">Fecha Termino:</td>
        <td><?php echo $CmbDiasT."/".$CmbMesT."/".$CmbAnoT; ?> </td>
      </tr>
      <tr> 
        <td height="31">Agrupacion</td>
        <td> <div align="left"> 
           <?php 
	  		$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = '1004' and cod_subclase = '".$CmbAgrupacion."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo $Fila["nombre_subclase"];
			}
	   		?>  
          </div></td>
      </tr>
    </table>
    <br>
    <table width="873" border="1" cellpadding="0" cellspacing="0" >
      <tr> 
        <td width="69" height="20"> <div align="center"></div>
          <div align="center">S.A</div></td>
        <td width="61" height="20">Agrupacion</td>
		<td width="162" height="20">Id Muestra</td>
        <td width="161" height="20"><div align="center">F Muestra</div></td>
        <td width="91"><div align="left"> 
            <div align="center"></div>
            <div align="center">F.Creacion</div>
          </div></td>
        <td width="122"><div align="center">Producto</div></td>
        <td width="191"><div align="center">SubProducto</div></td>
      </tr>
      <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		$Consulta = "select distinct(t1.nro_solicitud), t1.nro_sa_lims,t1.fecha_hora,t1.cod_producto,t1.cod_subproducto,t1.rut_funcionario,t1.id_muestra,t1.fecha_hora as FechaCreacion,t1.tipo_solicitud,t1.estado_actual,t1.fecha_muestra,t1.agrupacion from cal_web.solicitud_analisis t1  ";		
		$Consulta = $Consulta." where (t1.fecha_muestra between  '".$FechaI."' and '".$FechaT."') and (not isnull(t1.nro_solicitud) or t1.nro_solicitud = '')";
		if ($CmbPeriodo == "-1")//todos los periodos
		{
			$Consulta = $Consulta." and (t1.agrupacion = '".$CmbAgrupacion."') ";
		}
		else
		{
			$Consulta = $Consulta." and (t1.agrupacion = '".$CmbAgrupacion."') and (t1.cod_periodo = '".$CmbPeriodo."')";
		}
		//echo $Consulta."<br>";
		$Respuesta= mysqli_query($link, $Consulta);
		$Coincidencias=0;
		while ($Fila=mysqli_fetch_array($Respuesta))
	  	{
				
			echo "<tr>";
			if (($Fila["tipo_solicitud"]=='R') && (($Fila["estado_actual"] =='6') || ($Fila["estado_actual"] =='32'))) 				
			{

				if ($Fila["nro_sa_lims"]=='') {
  					$VarSA=$Fila["nro_solicitud"];
  				}else{
  					$VarSA=$Fila["nro_sa_lims"];
  				}


				echo "<td width='95'>".$TxtSA = $VarSA."<input name = TxtSAO type = 'hidden' value ='".$VarSA."'><input name = TxtRecargoO type = 'hidden' value ='N'></div></td>";	



				$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Fila["agrupacion"]."'";
				$Resp1=mysqli_query($link, $Consulta);
				$Fil1=mysqli_fetch_array($Resp1);
				echo "<td width ='150'><div align ='left'>".$Fil1["nombre_subclase"]."&nbsp;</div></td>";	
				echo "<td width='110'><div align='rigth'>".$TxtIdMuestra = $Fila["id_muestra"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
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
					echo "<tr>";

					if ($Fila["nro_sa_lims"]=='') {
	  					$VarSA=$Fila["nro_solicitud"];
	  				}else{
	  					$VarSA=$Fila["nro_sa_lims"];
	  				}


					echo "<td width='95'><div align='center'>".$TxtSA = $VarSA."<input name = TxtSAO type = 'hidden' value ='".$VarSA."'><input name = TxtRecargoO type = 'hidden' value ='N'></div></td>";									
					$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Fila["agrupacion"]."'";
					$Resp1=mysqli_query($link, $Consulta);
					$Fil1=mysqli_fetch_array($Resp1);
					echo "<td width ='150'><div align ='left'>".$Fil1["nombre_subclase"]."&nbsp;</div></td>";	
					echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
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
