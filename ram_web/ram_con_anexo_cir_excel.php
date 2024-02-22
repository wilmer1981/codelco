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

	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
?>
<html>
<head>
<title>Anexo Circulante</title>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
  <br>
  <table border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Flujo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="4" align="center">Leyes</td>
      <td colspan="4" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
	  <td align="center">As</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
	  <td align="center">As</td>
    </tr>
<?php	
	
	$Consulta = "SELECT distinct t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t1.fino_as  ";
	$Consulta.= " FROM ram_web.flujos_mes_cir t1 LEFT join proyecto_modernizacion.flujos t2 ";
	$Consulta.= " on t1.flujo = t2.cod_flujo and t2.sistema = 'CIR'";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " ORDER BY flujo";	
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		/*if ($row["peso"] != 0)
		{*/
			echo '<tr>';
			echo '<td align="center">'.$row["flujo"].'</td>';
			echo '<td align="left">'.strtoupper($row["descripcion"]).'</td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			if ($row["fino_cu"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_ag"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),0,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_au"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),1,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_as"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_as"] / $row["peso"] * 100),2,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_as"],0,',','.').'</td>';										
			echo '</tr>';
		//}
	}		
?>		
	<tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Nodo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="4" align="center">Leyes</td>
      <td colspan="4" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
	  <td align="center">As</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
	  <td align="center">As</td>
    </tr>
<?php	
	
	$Consulta = "SELECT t1.nodo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t1.fino_as ";
	$Consulta.= " FROM ram_web.existencia_nodo_cir t1 LEFT join proyecto_modernizacion.nodos t2 ";
	$Consulta.= " on t1.nodo = t2.cod_nodo and t2.sistema = 'CIR'";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " ORDER BY nodo";			
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		/*if ($row["peso"] != 0)
		{*/
			echo '<tr>';
			echo '<td align="center">'.$row["nodo"].'</td>';
			echo '<td align="left">'.strtoupper($row["descripcion"]).'</td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			if ($row["fino_cu"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_ag"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),0,',','.').'</td>';
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_au"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),1,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			if ($row["fino_as"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_as"] / $row["peso"] * 100),2,',','.').'</td>';	
			else
				echo '<td align="right">&nbsp;</td>';
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';	
			echo '<td align="right">'.number_format($row["fino_as"],0,',','.').'</td>';												
			echo '</tr>';
		//}
	}		
?>
</table>
</form>
</body>
</html>