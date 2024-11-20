<?php 
	include("../principal/conectar_ref_web.php");

	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename = "";
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

	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
    $mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
?>

<html>
<head>
<title>Programa de Renovacion</title>
</head>
<form name="frmPrincipal" action="" method="post">
  <table width="770" height="500" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <p> Programa de Cambio de Anodos Hojas Madres</p>
    <tr>
      <td width="762" align="center" valign="middle"> 
          <table width="730" border="2" cellspacing="0" cellpadding="0" bordercolor="white" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="116" align="center">Fecha</td>
              <td width="121" align="center">Grupo</td>
              <td width="191" align="center">Cubas N&deg;</td>
              <td width="122" align="center">Anodos a Renovar</td>
              <td width="116" align="center">Inicio Renovacion</td>
            </tr>
          </table>
          <table width="730" border="2" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php	
	if ($opcion=="H")
	{
	    if (strlen($mes1)==1)
		   {$mes1='0'.$mes1;}  
	    $fecha=$ano1.'-'.$mes1;
		if($mes1=='01' || $mes1=='03' || $mes1=='05' || $mes1=='07' || $mes1=='08' || $mes1=='10' || $mes1=='12'){
		 $dias=31;
		}
		if($mes1=='04' || $mes1=='06' || $mes1=='09' || $mes1=='11'){
		 $dias=30;
		}
		if($mes1=='02'){
		 $dias=29;
		}
		$i=1;
		while ($i <= 31)
		{
			echo '<tr>';
			if (strlen($i)==1)
			{$i='0'.$i;}
		
			$consultat="select count(cod_grupo) total_filas from ref_web.renovacion_hm where fecha ='".$fecha."-".$i."'";
			$rsst = mysqli_query($link, $consultat);
			$rowst = mysqli_fetch_array($rsst);
			$consulta="select * from ref_web.renovacion_hm where fecha ='".$fecha."-".$i."' order by cod_grupo asc ";
			$rss = mysqli_query($link, $consulta);
			if ($rows = mysqli_fetch_array($rss))
			{
				if ($rows["fecha"]<>'')
				{
				   $dia=substr($rows["fecha"],8,2);
				   echo '<td width="137" align="center" rowspan="'.$rowst["total_filas"].'">'.$rows["fecha"].'</td>';
				}
				else {
					  echo '<td width="137" align="center" rowspan="'.$rowst["total_filas"].'">'.$fecha.'-'.$i.'</td>';
				} 
				$rss = mysqli_query($link, $consulta);
				while ($rows = mysqli_fetch_array($rss))
				{
					   echo '<td width="146" align="center">'.$rows["cod_grupo"].'</td>';  
						if ($rows["cubas_renovacion"]=='SIN RENOVACION')
						  {echo '<td width="234" align="center" class="detalle01"><font color="#FF0000"><strong>'.$rows["cubas_renovacion"].'&nbsp;</strong></font></td>';}
						else {echo '<td width="234" align="center">'.$rows["cubas_renovacion"].'</td>';}
					   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo= '".$rows["cod_grupo"]."'";
					   $rss_fecha = mysqli_query($link, $consulta_fecha);
					   $rows_fecha = mysqli_fetch_array($rss_fecha);
					   $rowsfecha  = isset($rows_fecha["fecha"])?$rows_fecha["fecha"]:"0000-00-00";
					   $consulta="select num_cubas_tot,hojas_madres, num_anodos_celdas from ref_web.grupo_electrolitico2 where cod_grupo='".$rows["cod_grupo"]."' and fecha='".$rowsfecha."'";
					   $rs = mysqli_query($link, $consulta);
					   $row = mysqli_fetch_array($rs);
						if ($rows["cubas_renovacion"]<>'Renovacion Grupo 8 Comercial')
						{
						   $arreglo = explode("-",$rows["cubas_renovacion"]);
						   $nacelda=isset($rows["num_anodos_celdas"])?$rows["num_anodos_celdas"]:0;
						   $anodos_a_renovar= count($arreglo)*$nacelda;
						   //$anodos_a_renovar= count($arreglo)*$row["num_anodos_celdas"];
						} 
						else { //echo '('.$row["num_cubas_tot"].'-'.$row["hojas_madres"].')*'.$row["num_anodos_celdas"].')';
							  $anodos_a_renovar=(($row["num_cubas_tot"]-$row["hojas_madres"])*$row["num_anodos_celdas"]);
						} 
					   echo '<td width="146" align="center">'.$anodos_a_renovar.'</td>';
					   echo '<td width="146" align="center">'.$rows["inicio_renovacion"].'</td>';
					  // $i=$i+1;
					  echo '<tr>';
				}
			}
			else {
				$fecha     = isset($rows["fecha"])?$rows["fecha"]:"";
				$cod_grupo = isset($rows["cod_grupo"])?$rows["cod_grupo"]:"";
				$cubas_renovacion = isset($rows["cubas_renovacion"])?$rows["cubas_renovacion"]:"";
				$anodos_a_renovar = isset($rows["anodos_a_renovar"])?$rows["anodos_a_renovar"]:"";
				if ($fecha<>'')
				{
					$dia=substr($rows["fecha"],8,2);
					echo '<td width="137" align="center" >'.$fecha.'</td>';
				}
				else {
					echo '<td width="137" align="center" >'.$fecha.'-'.$i.'</td>';
				}   
				echo '<td width="146" align="center">'.$cod_grupo.'</td>';  	
				if ($cubas_renovacion=='SIN RENOVACION')
				{echo '<td width="234" align="center" class="detalle01"><font color="#FF0000"><strong>'.$cubas_renovacion.'&nbsp;</strong></font></td>';}
				else {echo '<td width="234" align="center">'.$cubas_renovacion.'</td>';}
				echo '<td width="146" align="center">'.$anodos_a_renovar.'</td>';
				echo '<td width="146" align="center"></td>';
					   
			} 
			$i=$i+1;  
	    }
	}
    
?>
</table> 

<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  <tr>
              <td align="center"></td>
  </tr>
</table>
</td>
</tr>
</table>
</form>
</html>
<?php //include("../principal/cerrar_ref_web.php"); ?>
