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
    include("../principal/conectar_sea_web.php");

	    //Proceso=B&ano=2023&mes=11&dia=9&cmbproductos=-1

		if(isset($_REQUEST["Proceso"])) {
			$Proceso = $_REQUEST["Proceso"];
		}else{
			$Proceso = '';
		}
		if(isset($_REQUEST["ano"])) {
			$ano = $_REQUEST["ano"];
		}else{
			$ano = "";
		}
		if(isset($_REQUEST["mes"])) {
			$mes= $_REQUEST["mes"];
		}else{
			$mes = "";
		}
		if(isset($_REQUEST["dia"])) {
			$dia= $_REQUEST["dia"];
		}else{
			$dia = "";
		}
		if(isset($_REQUEST["cmbproductos"])) {
			$cmbproductos= $_REQUEST["cmbproductos"];
		}else{
			$cmbproductos = "";
		}
		if(isset($_REQUEST["Todos"])) {
			$Todos = $_REQUEST["Todos"];
		}else{
			$Todos = "";
		}


?>
<html>
<head>
<title>Recepci&oacute;n de Productos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Datos_Excel()
{
var f = frmPoPup;
var dia,mes,ano;
var valores;
 
 	valores = "&ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&cmbproductos=" + f.cmbproductos.value;    

    window.open("sea_ing_recep_ext04xls.php?Proceso=B"+valores);


}

function buscar_guia()
{
var f = frmPoPup;

    f.action="sea_ing_recep_ext04.php?Proceso=B";
	f.submit();
}

function Imprimir()
{
	window.print();
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="frmPoPup" method="post" action="">
<?php
if($cmbproductos =="-1")
	$Todos = "S";
$Proceso="B";
if($Proceso == "B")
{
	echo'<center><img src="../principal/imagenes/letrasenami.gif" width="120" height="30"></center>';
	echo'<center><font size="7">Fecha: '.$dia.'-'.$mes.'-'.$ano.'</font></center><br>';	
	echo'<div align="center"><table cellpadding="3" cellspacing="0" width="300" border="1" bordercolor="#b26c4a">
      	<tr class="ColorTabla02"> 
        	<td colspan="7"><div align="center"><strong>Recepci&oacute;n de Productos de Terceros</strong></div></td>
      	</tr>
		</table><br>';
}

$fecha2 = date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano));
$FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
$FechaTermino =date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano))." 07:59:59";

if(($Todos == "S" || $cmbproductos == "1") && $Proceso =="B")
{

$cmbproductos = "1";
$total_unidades = 0;
$total_peso = 0;
$fecha = $ano.'-'.$mes.'-'.$dia;


echo'<div align="center"><table cellpadding="0" cellspacing="0" width="520" border="1" bordercolor="#b26c4a" class="TablaPrincipal">
      <tr class="ColorTabla02"> 
        <td colspan="7"><div align="center">&Aacute;nodos HVL</div></td>
      </tr>
      <tr class="ColorTabla01"> 
        <td width="15%"><div align="center">Lote Origen</div></td>
        <td width="20%"><div align="center">Lote Ventana</div></td>
        <td width="15%"><div align="center">Hornada</div></td>
        <td width="15%"><div align="center">Marca</div></td>
        <td width="10%"><div align="center">Cant. Recargo</div></td>
        <td width="12%"><div align="center">Unidades</div></td>
        <td width="13%"><div align="center">Peso</div></td>
      </tr>';

 	include("../principal/conectar_sea_web.php");
    $fecha = $ano.'-'.$mes.'-'.$dia;
					$consulta = "SELECT distinct hornada FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' 
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' Order By hornada";
                    
					$rs = mysqli_query($link, $consulta);
					//echo "una".$consulta."<br>";
					while ($row = mysqli_fetch_array($rs))
					{	
						$consulta = "SELECT * FROM relaciones WHERE hornada_ventana = '".$row["hornada"]."'"; 
						$rs2 = mysqli_query($link, $consulta);
							//echo "dos".$consulta."<br>";

                        if($row2 = mysqli_fetch_array($rs2))
			            {
						echo '<tr><td width="15%"><div align="center">'.$row2["lote_origen"].'</div></td>';
						echo '<td width="20%"><div align="center">'.$row2["lote_ventana"].'</div></td>';

						$Valores = 'Hornada='.substr($row["hornada"],6,6).'&Fecha='.$fecha; 
						echo '<td width="15%"><div align="center"><a href="sea_ing_recep_ext06.php?'.$Valores.'">'.substr($row["hornada"],6,6).'</a></div></td>';
						echo '<td width="15%"><div align="center">'.$row2["marca"].'</div></td>';
						}
						
						$consulta = "SELECT COUNT(numero_recarga) as numero_recarga FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' AND hornada = '".$row["hornada"]."'"; 
						$rs4 = mysqli_query($link, $consulta);
					//echo "tres".$consulta."<br>";

                        if($row4 = mysqli_fetch_array($rs4))
			            {
						echo '<td width="10%"><div align="center">'.$row4["numero_recarga"].'</div></td>';
						}

						$consulta = "SELECT SUM(unidades) as unid FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' AND hornada = '".$row["hornada"]."'"; 
						$rs5 = mysqli_query($link, $consulta);
					//echo "cuatro".$consulta."<br>";

                        if($row5 = mysqli_fetch_array($rs5))
			            {
						    $unidades = $row5["unid"];
						}

						$consulta = "SELECT SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' AND hornada = '".$row["hornada"]."'"; 
						$rs6 = mysqli_query($link, $consulta);
					//echo "cinco".$consulta."<br>";

                        if($row6 = mysqli_fetch_array($rs6))
			            {
						    $peso = $row6["peso"];
						}
						echo '<td width="12%"><div align="center">'.$unidades.'</div></td>';
						echo '<td width="13%"><div align="center">'.number_format($peso,0,'','').'</div></td>';

						$total_unidades = $total_unidades + $unidades;
						$total_peso = $total_peso + $peso;
					
					    echo'</tr>';
					}
                     
		             
    echo'<tr>'; 
      		echo'<td width="75%" colspan="5"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="12%"><div align="center">'.$total_unidades.'</div></td>';
      		echo'<td width="13%"><div align="center">'.number_format($total_peso,0,'','').'</div></td>';
    echo'</tr>
  		</table></div><br>';  

}

if(($Todos == "S" || $cmbproductos == "2") && $Proceso =="B")
{
$cmbproductos = "2";
$total_unidades = 0;
$total_peso = 0;

echo'<div align="center"><table cellpadding="0" cellspacing="0"  width="520" border="1" bordercolor="#b26c4a" class="TablaPrincipal">
      <tr class="ColorTabla02"> 
        <td colspan="7"><div align="center">&Aacute;nodos Teniente</div></td>
      </tr>
      <tr class="ColorTabla01"> 
        <td width="15%"><div align="center">Lote Origen</div></td>
        <td width="20%"><div align="center">Lote Ventana</div></td>
        <td width="15%"><div align="center">Hornada</div></td>
        <td width="15%"><div align="center">Marca</div></td>
        <td width="10%"><div align="center">Cant. Recargo</div></td>
        <td width="12%"><div align="center">Unidades</div></td>
        <td width="13%"><div align="center">Peso</div></td>
      </tr>';
 

 	include("../principal/conectar_sea_web.php");
    $fecha = $ano.'-'.$mes.'-'.$dia;
					$consulta = "SELECT distinct hornada FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' Order By hornada";
 			
					$rs = mysqli_query($link, $consulta);
					//echo $consulta; 
					while ($row = mysqli_fetch_array($rs))
					{	
						$consulta = "SELECT * FROM relaciones WHERE hornada_ventana = '".$row["hornada"]."'"; 
						$rs2 = mysqli_query($link, $consulta);

                        if($row2 = mysqli_fetch_array($rs2))
			            {
						echo '<tr><td width="15%"><div align="center">'.$row2["lote_origen"].'</div></td>';
						echo '<td width="20%"><div align="center">'.$row2["lote_ventana"].'</div></td>';

						$Valores = 'Hornada='.substr($row["hornada"],6,6).'&Fecha='.$fecha; 
						echo '<td width="15%"><div align="center"><a href="sea_ing_recep_ext06.php?'.$Valores.'">'.substr($row["hornada"],6,6).'</a></div></td>';
						echo '<td width="15%"><div align="center">'.$row2["marca"].'</div></td>';
						}

						//$consulta = "SELECT COUNT(RECARGO) as numero_recarga ";
						$consulta = "SELECT max(RECARGO) as numero_recarga ";
						$consulta.= " FROM SIPA_WEB.recepciones ";
						$consulta.= " WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' ";
						//$consulta.= " WHERE COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' ";
						$consulta.= " AND LOTE = '".$row2["lote_ventana"]."' AND peso_neto <> 0"; 
						//echo $consulta."<br>";
						$rs4 = mysqli_query($link, $consulta);

                        if($row4 = mysqli_fetch_array($rs4))
			            {
						echo '<td width="10%"><center>'.$row4["numero_recarga"].'</center></td>';
						}

						$consulta = "SELECT SUM(unidades) as unid FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' AND hornada = '".$row["hornada"]."'"; 
						$rs5 = mysqli_query($link, $consulta);
						//echo $consulta."<br><br>";	
                        if($row5 = mysqli_fetch_array($rs5))
			            {
						    $unidades = $row5["unid"];
						}

						$consulta = "SELECT SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' 
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' AND hornada = '".$row["hornada"]."'"; 
						$rs6 = mysqli_query($link, $consulta);

                        if($row6 = mysqli_fetch_array($rs6))
			            {
						    $peso = $row6["peso"];
						}
						echo '<td width="12%"><div align="center">'.$unidades.'</div></td>';
						echo '<td width="13%"><div align="center">'.number_format($peso,0,'','').'</div></td>';

						$total_unidades = $total_unidades + $unidades;
						$total_peso = $total_peso + $peso;
					
					    echo'</tr>';
					}
                     
		             
    echo'<tr>'; 
      		echo'<td width="75%" colspan="5"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="12%"><div align="center">'.$total_unidades.'</div></td>';
      		echo'<td width="13%"><div align="center">'.number_format($total_peso,0,'','').'</div></td>';
    echo'</tr>
  		</table></div><br>';  

}


if(($Todos == "S" || $cmbproductos == "3") && $Proceso =="B")
{
$cmbproductos = "3";
$total_unidades = 0;
$total_peso = 0;

echo'<div align="center"><table cellpadding="0" cellspacing="0" width="520" border="1" bordercolor="#b26c4a" class="TablaPrincipal">
      <tr class="ColorTabla02"> 
        <td colspan="7"><div align="center">&Aacute;nodos Anglo American Sur SA</div></td>
      </tr>
      <tr class="ColorTabla01"> 
        <td width="15%"><div align="center">Lote Origen</div></td>
        <td width="20%"><div align="center">Lote Ventana</div></td>
        <td width="15%"><div align="center">Hornada</div></td>
        <td width="15%"><div align="center">Marca</div></td>
        <td width="10%"><div align="center">Cant. Recargo</div></td>
        <td width="12%"><div align="center">Unidades</div></td>
        <td width="13%"><div align="center">Peso</div></td>
      </tr>';
 

 	include("../principal/conectar_sea_web.php");
    $fecha = $ano.'-'.$mes.'-'.$dia;
					$consulta = "SELECT distinct hornada FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' Order By hornada";
 
					$rs = mysqli_query($link, $consulta);

					while ($row = mysqli_fetch_array($rs))
					{	
						$consulta = "SELECT * FROM relaciones WHERE hornada_ventana = '".$row["hornada"]."'"; 
						$rs2 = mysqli_query($link, $consulta);

                        if($row2 = mysqli_fetch_array($rs2))
			            {
						echo '<tr><td width="15%"><div align="center">'.$row2["lote_origen"].'</div></td>';
						echo '<td width="20%"><div align="center">'.$row2["lote_ventana"].'</div></td>';

						$Valores = 'Hornada='.substr($row["hornada"],6,6).'&Fecha='.$fecha; 
						echo '<td width="15%"><div align="center"><a href="sea_ing_recep_ext06.php?'.$Valores.'">'.substr($row["hornada"],6,6).'</a></div></td>';
						echo '<td width="15%"><div align="center">'.$row2["marca"].'</div></td>';
						}

						$consulta = "SELECT COUNT(RECARGO) as numero_recarga FROM SIPA_WEB.recepciones ";
						$consulta.= " WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' ";
						$consulta.= " AND LOTE = '".$row2["lote_ventana"]."' "; 
						$rs4 = mysqli_query($link, $consulta);

                        if($row4 = mysqli_fetch_array($rs4))
			            {
						echo '<td width="10%"><center>'.$row4["numero_recarga"].'</center></td>';
						}

						$consulta = "SELECT SUM(unidades) as unid FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' 
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' AND hornada = '".$row["hornada"]."' "; 
						$rs5 = mysqli_query($link, $consulta);

                        if($row5 = mysqli_fetch_array($rs5))
			            {
						    $unidades = $row5["unid"];
						}

						$consulta = "SELECT SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' 
					             AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' AND hornada = '".$row["hornada"]."' "; 
						$rs6 = mysqli_query($link, $consulta);

                        if($row6 = mysqli_fetch_array($rs6))
			            {
						    $peso = $row6["peso"];
						}
						echo '<td width="12%"><div align="center">'.$unidades.'</div></td>';
						echo '<td width="13%"><div align="center">'.number_format($peso,0,'','').'</div></td>';

						$total_unidades = $total_unidades + $unidades;
						$total_peso = $total_peso + $peso;
					
					    echo'</tr>';
					}
                     
		             
    echo'<tr>'; 
      		echo'<td width="75%" colspan="5"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="12%"><div align="center">'.$total_unidades.'</div></td>';
      		echo'<td width="13%"><div align="center">'.number_format($total_peso,0,'','').'</div></td>';
    echo'</tr>
  		</table></div><br>';  
}
 $aux_prod = substr($cmbproductos,0,2);

if(($Todos == "S" || $aux_prod == "16") && $Proceso =="B")
{
//BLISTER
//$cmbsubproductos = "2";
$total_unidades = 0;
$total_peso = 0;
$cmbproductos =substr($cmbproductos,2,1);
$descripcion="";
$aux="";
if ($Todos !="S")
{
    $aux ="and cod_subproducto = '".$cmbproductos."'";
    
       		$consulta = "SELECT nombre_subclase FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 16";
             $consulta = $consulta." and  cod_subclase = '".$cmbproductos."'" ;
			$rs = mysqli_query($link, $consulta);
             if($row = mysqli_fetch_array($rs))
			            {
                           $descripcion = $row["nombre_subclase"];
						}
            echo $descripcion;

}
		  
echo'<div align="center"><table cellpadding="0" cellspacing="0" width="520" border="1" bordercolor="#b26c4a" class="TablaPrincipal">

      <tr class="ColorTabla02"> 
        <td colspan="7"><div align="center">Blister</div></td>
      </tr>
      <tr class="ColorTabla01"> 
        <td width="20%"><div align="center">Lote/Hornada</div></td>
        <td width="20%"><div align="center">Lote Ventana</div></td>
        <td width="10%"><div align="center">Recargo</div></td>
        <td width="12%"><div align="center">Unidades</div></td>
        <td width="13%"><div align="center">Peso</div></td>
      </tr>';
 
 	include("../principal/conectar_sea_web.php");
    $fecha = $ano.'-'.$mes.'-'.$dia;
					$consulta = "SELECT distinct lote_ventana FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'  ";
                    $consulta = $consulta .$aux ."  AND cod_producto = 16  Order By hornada";

					$rs = mysqli_query($link, $consulta);

					while ($row = mysqli_fetch_array($rs))
					{	
						$consulta = "SELECT * FROM relaciones WHERE lote_ventana = '".$row["lote_ventana"]."'"; 
						$rs2 = mysqli_query($link, $consulta);

                        if($row2 = mysqli_fetch_array($rs2))
			            {
						echo '<tr>';
						echo '<td width="20%"><div align="center">'.substr($row2["hornada_ventana"],3,6).'</div></td>';
						}

						$Valores = 'Hornada='.$row["lote_ventana"].'&Fecha='.$fecha; 
						echo '<td width="20%"><div align="center"><a href="sea_ing_recep_ext06.php?'.$Valores.'">'.$row["lote_ventana"].'</a></div></td>';

						$consulta = "SELECT COUNT(numero_recarga) as numero_recarga FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 16  AND lote_ventana = '".$row["lote_ventana"]."' ";
						$rs4 = mysqli_query($link, $consulta);

                        if($row4 = mysqli_fetch_array($rs4))
			            {
						echo '<td width="10%"><div align="center">'.$row4["numero_recarga"].'</div></td>';
						}

						$consulta = "SELECT SUM(unidades) as unid FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 16  AND lote_ventana = '".$row["lote_ventana"]."' ";
						$rs5 = mysqli_query($link, $consulta);

                        if($row5 = mysqli_fetch_array($rs5))
			            {
						    $unidades = $row5["unid"];
						}

						$consulta = "SELECT SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'
					             AND cod_producto = 16  AND lote_ventana = '".$row["lote_ventana"]."' ";
						$rs6 = mysqli_query($link, $consulta);

                        if($row6 = mysqli_fetch_array($rs6))
			            {
						    $peso = $row6["peso"];
						}
						echo '<td width="12%"><div align="center">'.$unidades.'</div></td>';
						echo '<td width="13%"><div align="center">'.number_format($peso,0,'','').'</div></td>';

						$total_unidades = $total_unidades + $unidades;
						$total_peso = $total_peso + $peso;
					}
                     
        echo'<tr>'; 
      		echo'<td width="75%" colspan="3"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="12%"><div align="center">'.$total_unidades.'</div></td>';
      		echo'<td width="13%"><div align="center">'.number_format($total_peso,0,'','').'</div></td>';
    echo'</tr>
  		</table></div><br>';
}


if($Todos == "S" && $Proceso =="B")
{
//acumuladores
$fecha_ini = $ano.'-'.$mes.'-01';
$fecha_ter = $ano.'-'.$mes.'-'.$dia;
$fecha_ter2 = date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano));
$fecha_hora_ini = $ano.'-'.$mes.'-01 07:59:59';
$fecha_hora_ter = date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano))." 07:59:59";


	$consulta = "SELECT WEEKDAY('".$fecha_ter."') AS dia";
 	$rs = mysqli_query($link, $consulta);
	if($row_d = mysqli_fetch_array($rs))
	{
		$dia_1 = $dia - $row_d["dia"];
		$fecha_sem = $ano.'-'.$mes.'-'.$dia_1;
	}
	
echo'<table cellpadding="0" cellspacing="0"  width="520" border="1" bordercolor="#b26c4a" class="TablaPrincipal">
  <tr class="ColorTabla02"> 
    <td colspan="5"><center>Resumen</center></td>
  </tr>
  <tr class="ColorTabla01"> 
    <td width="40%"><center>Producto Terceros</center></td>
    <td colspan="2"><center>Acumulado Semanal</center></td>
    <td colspan="2"><center>Acumulado Mensual</center></td>
  </tr>
  <tr>'; 

    echo'<td width="40%">&Aacute;nodos HVL</td>';
    //semanal HVL	
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 17 AND cod_subproducto = 1 AND fecha_movimiento BETWEEN '".$fecha_sem."' AND '".$fecha_ter."' ";
	$rs = mysqli_query($link, $consulta);
    if($row = mysqli_fetch_array($rs))
	{
		$unidades_HVL = $row["unidades"];
		$peso_HVL = $row["peso"];
	}
    echo'<td width="15%"><center>'.$unidades_HVL.'</center></td>';
    echo'<td width="15%"><center>'.$peso_HVL.'</center></td>';

    //mensual HVL	
	//$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
	//			 AND cod_producto = 17 AND cod_subproducto = 1 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 17 AND cod_subproducto = 1 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter2."' and hora BETWEEN '".$fecha_hora_ini."' AND '".$fecha_hora_ter."'";			 
	$rs = mysqli_query($link, $consulta);
    if($row = mysqli_fetch_array($rs))
	{
		$unidades_HVL = $row["unidades"];
		$peso_HVL = $row["peso"];
	}
    echo'<td width="15%"><center>'.$unidades_HVL.'</center></td>';
    echo'<td width="15%"><center>'.$peso_HVL.'</center></td>';
  
  echo'</tr>';
  echo'<tr> 
    <td>&Aacute;nodos Teniente</td>';

    //semanal TTE	
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 17 AND cod_subproducto = 2 AND fecha_movimiento BETWEEN '".$fecha_sem."' AND '".$fecha_ter."'";
	$rs2 = mysqli_query($link, $consulta);
    if($row2 = mysqli_fetch_array($rs2))
	{
		$unidades_TTE = $row2["unidades"];
		$peso_TTE = $row2["peso"];
	}
    echo'<td><center>'.$unidades_TTE.'</center></td>';
    echo'<td><center>'.$peso_TTE.'</center></td>';

    //mensual TTE	
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 17 AND cod_subproducto = 2 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter2."' and hora BETWEEN '".$fecha_hora_ini."' AND '".$fecha_hora_ter."'";
	$rs2 = mysqli_query($link, $consulta);
	//echo $consulta;
    if($row2 = mysqli_fetch_array($rs2))
	{
		$unidades_TTE = $row2["unidades"];
		$peso_TTE = $row2["peso"];
	}
    echo'<td><center>'.$unidades_TTE.'</center></td>';
    echo'<td><center>'.$peso_TTE.'</center></td>';
  
  echo'</tr>';
  echo'<tr>'; 
    echo'<td>&Aacute;nodos Anglo American Sur SA</td>';
    //semanal DISP	
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 17 AND cod_subproducto = 3 AND fecha_movimiento BETWEEN '".$fecha_sem."' AND '".$fecha_ter."'";
	$rs3 = mysqli_query($link, $consulta);
    if($row3 = mysqli_fetch_array($rs3))
	{
		$unidades_DISP = $row3["unidades"];
		$peso_DISP = $row3["peso"];
	}

    echo'<td><center>'.$unidades_DISP.'</center></td>';
    echo'<td><center>'.$peso_DISP.'</center></td>';

    //mensual DISP	
	//$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
	//			 AND cod_producto = 17 AND cod_subproducto = 3 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 17 AND cod_subproducto = 3 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter2."' and hora BETWEEN '".$fecha_hora_ini."' AND '".$fecha_hora_ter."'";

	$rs3 = mysqli_query($link, $consulta);
    if($row3 = mysqli_fetch_array($rs3))
	{
		$unidades_DISP = $row3["unidades"];
		$peso_DISP     = $row3["peso"];
	}

    echo'<td><center>'.$unidades_DISP.'</center></td>';
    echo'<td><center>'.$peso_DISP.'</center></td>';

//Blister Scrap Codelco
echo'<tr>'; 
    echo'<td>Blister '.$descripcion.' </td>';
    //semanal DISP	
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 16  AND fecha_movimiento BETWEEN '".$fecha_sem."' AND '".$fecha_ter."'";
	$rs3 = mysqli_query($link, $consulta);
    if($row3 = mysqli_fetch_array($rs3))
	{
		$unidades_scrap = $row3["unidades"];
		$peso_scrap     = $row3["peso"];
	}

    echo'<td><center>'.$unidades_scrap.'</center></td>';
    echo'<td><center>'.$peso_scrap.'</center></td>';

    //mensual DISP	
	//$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
	//			 AND cod_producto = 16  AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
	$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso FROM movimientos WHERE tipo_movimiento = 1 
				 AND cod_producto = 16  AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter2."' and hora BETWEEN '".$fecha_hora_ini."' AND '".$fecha_hora_ter."'";			 
	$rs3 = mysqli_query($link, $consulta);
    if($row3 = mysqli_fetch_array($rs3))
	{
		$unidades_scrap = $row3["unidades"];
		$peso_scrap = $row3["peso"];
	}

    echo'<td><center>'.$unidades_scrap.'</center></td>';
    echo'<td><center>'.$peso_scrap.'</center></td>';

echo'</tr>
</table>';
}
?>
		<br><table cellpadding="3" cellspacing="0" width="520" border="0" align="center">
		  <tr>
			<td> <div align="center">
				<input name="btnvolver" type="button" style="width:110;" value=" <<   Volver Atras" onClick="JavaScript:window.history.back()"> 
				<input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
				<input name="btnsalir" type="button" style="width:100" value="Cerra Ventana" onClick="self.close()">
			  </div></td>
		  </tr>
		</table>
	
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>