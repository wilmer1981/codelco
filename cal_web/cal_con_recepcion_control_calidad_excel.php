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

$Fecha_Hora=date("d-m-Y h:i");
$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut=$CookieRut;
$CodigoDeSistema=1;
$CodigoDePantalla=5;

$Consulta = "SELECT * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
$Respuesta =mysqli_query($link, $Consulta);
if($Fila =mysqli_fetch_array($Respuesta))
{
	$Nivel = $Fila["nivel"];
}

    $Mostrar = $_REQUEST["Mostrar"];
	$CmbDias = $_REQUEST["CmbDias"];

	$CmbMes = $_REQUEST["CmbMes"];
	$CmbAno = $_REQUEST["CmbAno"];
	$CmbDiasT = $_REQUEST["CmbDiasT"];
	$CmbMesT = $_REQUEST["CmbMesT"];
	$CmbAnoT = $_REQUEST["CmbAnoT"];
	$CmbEstado = $_REQUEST["CmbEstado"];

?>
<html>
<head>
<title></title>
</head>
<body>
    
<table width="761" border="0" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="120" height="31">Fecha Inicio<font size="2">:&nbsp; </font></td>
    <td colspan="4"><?php echo $CmbDias."-".$CmbMes."-".$CmbAno; ?></td>
  </tr>
  <tr> 
    <td height="31">Fecha Termino:</td>
    <td colspan="4"><?php echo $CmbDiasT."-".$CmbMesT."-".$CmbAnoT; ?> &nbsp; &nbsp; </td>
  </tr>
  <tr> 
    <td height="31">Estado: </td>
    <td colspan="4"><?php 
	$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where (cod_clase = '1002' and cod_subclase = '".$CmbEstado."')";
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resp);
	echo $Fila["nombre_subclase"];
	?></td>
  </tr>
</table>
    <br>
    <table width="760" border="1" cellpadding="0" cellspacing="0" >
      <tr class="ColorTabla01"> 
        <td width="82" height="20"><div align="center">S.A</div></td>
        <td width="84" height="20">Id Muestra</td>
        
    <td width="90" height="20">F Muestra</td>
		<td width="107"><div align="left"> 
            <div align="center"></div>

            <div align="center">Producto</div>
          </div></td>
        <td width="107"><div align="center">Originador</div></td>
        <td width="122"><div align="center">Obs</div></td>
        <td width="94"><div align="center">F.Creacion</div></td>
        <td width="106"> <div align="center">F.Estado</div>
          <div align="center"></div></td>
      </tr>
      <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		//$CmbEstado=$CmbEstadoAux;
		if (($CmbEstado !='1') && ($CmbEstado !='2')&& ($CmbEstado !='3')&& ($CmbEstado !='13')&& ($CmbEstado !='7')&& ($CmbEstado !='8')&& ($CmbEstado !='16')&&($CmbEstado !='31') &&($CmbEstado != '32'))
		{
			//if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="6"))
			if (($Nivel >= '1')&& ($Nivel <='20')) 
			{
				$Letra=substr($CmbEstado,strlen($CmbEstado)-1,1);
				if ($CmbEstado!="-1")
				{
					$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
				}
			}	
			switch ($Nivel) 
			{
				//si es el jefe laboratorio
				case "30":
					if ($Letra=='F')
					{
						$TipoAnalisis = " and (t1.cod_analisis = '2')  ";
						
					}
					if ($Letra=='Q')
					{
						$TipoAnalisis = " and (t1.cod_analisis = '1' )   ";
					}
					break;
				default: 
					if ($Letra=='F')
					{
						$TipoAnalisis = " and (t1.cod_analisis = '2')  ";
						
					}
					if ($Letra=='Q')
					{
						$TipoAnalisis = " and (t1.cod_analisis = '1' )   ";
					}
					break;
			}
		}	
		switch ($CmbEstado) 
		{
			//Todos
			case "-1":
				//$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '3') or (t1.estado_actual = '4') or (t1.estado_actual = '12') ";		 		
				break;
			case "1":
				//estado creadas
				//if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				//{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '1')"; 
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '1') and t1.cod_producto <> 1 "; 
				}*/
				break;		 
			case "2":
				//Estado Recepcionada
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '2')";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '2') and t1.cod_producto <> 1 ";
				}*/	
				break;
			case "3":
				//enviado a laboratorio por el jefe
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '3')".$TipoAnalisis ;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '3') and t1.cod_producto <> 1 ".$TipoAnalisis ;
				}*/
				break;		 
		 	case "4": 
		 		//Recepcionado en control de calidad
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '4')".$TipoAnalisis ;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '4') and t1.cod_producto <> 1 ".$TipoAnalisis ;
				}*/
				break;
			//Atendido por quimico
			case "5":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '5')".$TipoAnalisis;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '5') and t1.cod_producto <> 1 ".$TipoAnalisis;
				}*/
				break;
			//Estado finalizado 
			case "6":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '6')".$TipoAnalisis;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '6') and t1.cod_producto <> 1 ".$TipoAnalisis;
				}*/
				break;	
			//directos de control de calidad
			case "12":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '12') ".$TipoAnalisis ;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '12') and t1.cod_producto <> 1 ".$TipoAnalisis ;
				}*/
				break;
			//eliminado
			case "7":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '7') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '7') and t1.cod_producto <> 1 ";
				}*/
				break;
			//Pendien
			case "8":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '8') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '8') and t1.cod_producto <> 1 ";
				}*/
				break;
			//atendido en muestrera
			case "13":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '13') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '13') and t1.cod_producto <> 1 ";
				}*/
				break;
			//Anuladas
			case "16":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '16') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '16') and t1.cod_producto <> 1 ";
				}*/
				break;
			//atendido por quimico FRX
			case "31":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '31') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '31') and t1.cod_producto <> 1 ";
				}*/
				break;
			//atendido por quimico FRX
			case "32":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '32') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '32') and t1.cod_producto <> 1 ";
				}*/
				break;	
			default:
				//Todos
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and ((t1.estado_actual = '3')or (t1.estado_actual = '4')or(t1.estado_actual = '12'))  and ((t1.cod_analisis = '1') or (t1.cod_analisis = '2'))";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and ((t1.estado_actual = '3')or (t1.estado_actual = '4')or(t1.estado_actual = '12'))  and ((t1.cod_analisis = '1') or (t1.cod_analisis = '2')) and t1.cod_producto <> 1 ";
				}*/
				break;
		}
		$Consulta = "select t1.cod_tipo_muestra,t2.descripcion as nomproducto,t3.descripcion as nomsubproducto,";
		$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.fecha_hora,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
		$Consulta = $Consulta."concat(t4.nombres,' ',t4.apellido_paterno,' ',t4.apellido_materno) as nombreapellido, ";
		$Consulta = $Consulta."t4.apellido_paterno as ap_paterno,t1.observacion,t1.fecha_muestra, ";
		$Consulta =	$Consulta."t1.nro_solicitud,t1.nro_sa_lims,t1.id_muestra,t1.cod_analisis,t1.tipo_solicitud,t1.fecha_hora as Fecha_Creacion ,t7.nombre_subclase,t6.fecha_hora as FechaAtencion,t6.cod_estado,t7.cod_subclase ";
		$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
		$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
		$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual =t6.cod_estado )";
		$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
		$Consulta = $Consulta.$Estado."order by nro_solicitud,recargo_ordenado";
		
		$Respuesta= mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
	  	{
	  	  	if ($CmbEstado=='1')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '1')";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$TxtFechaEstado = $Fila2["fecha_hora"];
					
				}	
			}
			if ($CmbEstado=='2')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '1')";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$TxtFechaEstado = $Fila2["fecha_hora"];
					
				}	
			}
			if ($CmbEstado=='3')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '3')";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$TxtFechaEstado = $Fila2["fecha_hora"];
					
				}	
			}
			if ($CmbEstado=='4')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '4') ";
				$Respuesta3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Respuesta3))
				{
					$TxtFechaEstado = $Fila3["fecha_hora"];
					
				}	
			}			
			if ($CmbEstado=='5')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '5') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='6')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '6') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='7')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '7') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='8')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '8') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='12')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '12') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='13')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '13') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='16')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '16') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='31')//atendido por Finalizado FRX
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '31') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='32')//Finalizado por Finalizado FRX
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '32') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			echo "<tr>";
				if ($Fila["tipo_solicitud"] == 'R') 
				{	
					if ($Fila["nro_sa_lims"]=='') {
              			echo "<td width='95'>".$TxtSA = $Fila["nro_solicitud"]."</td>";	
      				}else{
      					echo "<td width='95'>".$TxtSA = $Fila["nro_sa_lims"]."</td>";	
      				}				
								
				}
				if ($Fila["tipo_solicitud"] == 'A') 

				{
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{

						if ($Fila["nro_sa_lims"]=='') {
              			echo "<td width='95'>".$TxtSA = $Fila["nro_solicitud"]."</td>";	
	      				}else{
	      					echo "<td width='95'>".$TxtSA = $Fila["nro_sa_lims"]."</td>";	
	      				}	

						 			
					}
					else
					{
						if ($Fila["nro_sa_lims"]=='') {
              				echo "<td width='95'>".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."</td>";	
	      				}else{
	      					echo "<td width='95'>".$TxtSA = $Fila["nro_sa_lims"].'-'.$Fila["recargo"]."</td>";	
	      				}



									
					} 
				}				
				echo "<td width='68'>".$TxtIdMuestra = $Fila["id_muestra"]."</td>";				
				echo "<td width ='90'>".$Fila["fecha_muestra"]."</td>";		
				echo "<td width ='170'>".$TxtProducto= ucwords(strtolower($Fila["nomsubproducto"]))."</td>";
				echo "<td width ='110'>".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1).".".ucwords(strtolower($Fila["ap_paterno"]))."</td>";
				if ((is_null($Fila["observacion"])) || ($Fila["observacion"]==''))	
				{
					echo "<td width ='85'>".$Fila["observacion"]."</td>";
				}
				else
				{			
					echo "<td width ='85'>".$Fila["observacion"]."</td>";
				}
				echo "<td width ='70'>".$TxtFechaCreacion=$Fila["Fecha_Creacion"]."</td>";		
				echo "<td width ='70'>".$TxtFechaEstado."</td>";
				echo "</tr>";
	   }
	   ?>
    </table>
</body>
</html>