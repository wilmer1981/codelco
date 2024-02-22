<?php	
	ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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
	include("../principal/conectar_pmn_web.php");
	include("pmn_con_balance_calcula_flujo.php");	
?>
<html>
<head>
<title>Sistema de PLAMEN</title>
</head>

<body>

  <table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Flujo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="2" align="center">Leyes</td>
      <td colspan="2" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
    <?php
if ($Proceso == "S")  
{	
	//Consulto si las existencias del mes se pueden borrar.
	$Copiar = "N";
    $Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM pmn_web.existencia_nodo ";
    $Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' and bloqueado = '1'";    
   	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{	
		$Eliminar = "DELETE FROM pmn_web.flujos_mes";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Copiar = "S";
		
		//CALCULA FLUJOS.
		CalculaFlujos($Ano,$Mes);
	}	
	
	$consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au";
	$consulta.= " FROM pmn_web.flujos_mes AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.flujos t2";
	$consulta.= " ON t1.flujo = t2.cod_flujo AND t2.sistema = 'PMN'";
	$consulta.= " WHERE t1.ano = '".$Ano."' AND t1.mes = '".$Mes."'";
	$consulta.= " AND peso != 0";
	$consulta.= " GROUP BY t1.flujo";
	$consulta.= " ORDER BY CEILING(t2.cod_flujo)";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{	
		echo '<tr>';
		echo '<td align="center">'.$row["flujo"].'</td>';
		echo '<td align="left">'.$row["descripcion"].'</td>';
		echo '<td align="right">'.number_format($row["peso"],3,",",".").'</td>';
		if ($row["peso"] != 0)
		{
			echo '<td align="right">'.number_format(($row[fino_ag] / $row["peso"] * 1000),2,",","").'</td>';
			echo '<td align="right">'.number_format(($row[fino_au] / $row["peso"] * 1000),2,",","").'</td>';
		}
		else
		{
			echo '<td align="center">&nbsp;</td>';
			echo '<td align="center">&nbsp;</td>';		
		}
		
		echo '<td align="right">'.number_format($row[fino_ag],3,",",".").'</td>';								
		echo '<td align="right">'.number_format($row[fino_au],3,",",".").'</td>';								
		echo '</tr>';
	}
}

?>
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Nodo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="2" align="center">Leyes</td>
      <td colspan="2" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
    <?php
	//RESCATO ANEXO 
	$consulta = "SELECT t1.nodo, SUM(t1.peso) AS peso, SUM(t1.fino_ag) AS fino_ag, SUM(t1.fino_au) AS fino_au, t2.descripcion ";
	$consulta.= " FROM pmn_web.existencia_nodo AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.nodos AS t2 ";
	$consulta.= " ON t1.nodo = t2.cod_nodo AND t2.sistema = 'PMN'";
	$consulta.= " WHERE t1.ano = '".$Ano."' AND t1.mes = '".$Mes."'";
	$consulta.= " GROUP BY t1.nodo";
	$consulta.= " ORDER BY t1.nodo";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))	
	{
		echo '<tr>';
		echo '<td align="center">'.$row["nodo"].'</td>';
		echo '<td align="left">'.$row["descripcion"].'</td>';
		echo '<td align="right">'.number_format($row["peso"],3,",",".").'</td>';
		if ($row["peso"] != 0)
		{
			echo '<td align="right">'.number_format(($row[fino_ag] / $row["peso"] * 1000),2,",","").'</td>';
			echo '<td align="right">'.number_format(($row[fino_au] / $row["peso"] * 1000),2,",","").'</td>';
		}
		else
		{
			echo '<td align="center">&nbsp;</td>';
			echo '<td align="center">&nbsp;</td>';		
		}
		
		echo '<td align="right">'.number_format($row[fino_ag],3,",",".").'</td>';								
		echo '<td align="right">'.number_format($row[fino_au],3,",",".").'</td>';								
		echo '</tr>';	
	}
?>
  </table>
  <br>
  <br>
  <table width="566" border="1" align="center" cellpadding="2" cellspacing="0">
<tr align="center" class="ColorTabla01"> 
      <td colspan="5">NODOS CON DIFERENCIAS METALURGICAS</td>
    </tr>
    <tr align="center" class="ColorTabla01"> 
      <td width="39" rowspan="2">Nodo</td>
      <td width="266" rowspan="2">Descripcion</td>
      <td width="92" rowspan="2">Peso</td>
      <td colspan="2">Fino</td>
    </tr>
    <tr align="center" class="ColorTabla01"> 
      <td width="72">Ag</td>
      <td width="65">Au</td>
    </tr>
    <?php
	$consulta = "SELECT t1.nodo, t2.descripcion ";
	$consulta.= " FROM pmn_web.existencia_nodo AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.nodos AS t2 ";
	$consulta.= " ON t1.nodo = t2.cod_nodo AND t2.sistema = 'PMN'";
	$consulta.= " WHERE t1.ano = '".$Ano."' AND t1.mes = '".$Mes."'";
	$consulta.= " GROUP BY t1.nodo";
	$consulta.= " ORDER BY t1.nodo";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		$vector = explode('~', CalculaDifMetalurgicas($row["nodo"], $Mes, $Ano)); 
		if ($vector[0] == 'S')
		{
			echo '<tr>';
			echo '<td align="center">'.$row["nodo"].'</td>';
			echo '<td align="left">'.$row["descripcion"].'</td>';
			echo '<td align="right">'.number_format($vector[1],3,",",".").'</td>';
			echo '<td align="right">'.number_format($vector[2],3,",",".").'</td>';
			echo '<td align="right">'.number_format($vector[3],3,",",".").'</td>';
			echo '</tr>';
		}
	}
?>
  </table>
</body>
</html>
