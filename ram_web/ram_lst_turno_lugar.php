<?php 

$ano        = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
$mes        = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
$dia        = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");

$cmbturno   = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";
$Turno_Ini   = isset($_REQUEST["Turno_Ini"])?$_REQUEST["Turno_Ini"]:"";
$Turno_Ter   = isset($_REQUEST["Turno_Ter"])?$_REQUEST["Turno_Ter"]:"";

if($cmbturno == "A")
{
	$Turno_Ini = "08:00:00";
	$Turno_Ter = "15:59:59";
}	

if($cmbturno == "B")
{
	$Turno_Ini = "16:00:00";
	$Turno_Ter = "23:59:59";
}	

if($cmbturno == "C")
{
	$Turno_Ini = "00:00:00";
	$Turno_Ter = "07:59:59";
}	

if(strlen($dia) == 1)
$dia = '0'.$dia;

if(strlen($mes) == 1)
$mes = '0'.$mes;

$Fecha_Ini = $ano.'-'.$mes.'-'.$dia.' '.$Turno_Ini;
$Fecha_Ter = $ano.'-'.$mes.'-'.$dia.' '.$Turno_Ter;

//$Fecha_Ini = $dia.'-'.$mes.'-'.$ano.' '.$Turno_Ini;
//$Fecha_Ter = $dia.'-'.$mes.'-'.$ano.' '.$Turno_Ter;
 
 include("../principal/conectar_ram_web.php"); 
?>
<html>

<head>
    <title>Documento sin t&iacute;tulo</title>
    <script language="JavaScript">
    function Salir() {
        window.history.back();
    }
    /***********/
    function Imprimir() {
        window.print();
    }
    </script>
    <link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<body class="TablaPrincipal">
    <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr class="ColorTabla01">
            <td align="center" colspan="10">INFORME MOVIMIENTO TOTALES POR LUGAR</td>
        </tr>
        <tr class="ColorTabla02">
            <td align="center" colspan="10">FECHA:&nbsp; <?php echo $dia.'/'.$mes.'/'.$ano ?></td>
        </tr>
    </table>
    <br>

    <?php
		echo '<table width="100"  border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla01">';
			echo '<td width="60%" align="center"><strong>TURNO &nbsp;: </strong></td>';
			echo '<td width="40%">'.$cmbturno.'</td>';
		echo '</tr></table>';


	$consulta = "SELECT distinct COD_LUGAR_DESTINO FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' AND COD_LUGAR_DESTINO != '' order by COD_LUGAR_DESTINO ASC ";
	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<table width="350"  border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla02">';
		echo '<td width="40%" align="center"><strong>LUGAR DESTINO :</strong></td>';

		$consulta = "SELECT * FROM tipo_lugar WHERE cod_tipo_lugar = '".$row["COD_LUGAR_DESTINO"]."'";
		$rs2 = mysqli_query($link, $consulta);
		
		if($row2 = mysqli_fetch_array($rs2))
		{
			echo '<td width="60%">'.$row2["cod_tipo_lugar"].' - '.$row2["descripcion_lugar"].'</td>';
		}
		echo '</tr></table>';

		echo '<table width="650"  border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla01">';
		echo '<td width="10%" align="center">COD.</td>';
		echo '<td width="27%" align="center">CONJUNTO</td>';
		echo '<td width="3%" align="center">DEST.</td>';
		echo '<td width="11%" align="center">TIPO MOV.</td>';
		echo '<td width="20%" align="center">FECHA MOVIMIENTO</td>';
		echo '<td width="9%"align="right">P. HUM.</td>';
		echo '<td width="9%"align="center">VALID.</td>';
		echo '<td width="9%" align="right">TOTAL</td>';
		echo '</tr>';

		$consulta = "SELECT COD_EXISTENCIA,COD_CONJUNTO,NUM_CONJUNTO,CONJUNTO_DESTINO,FECHA_MOVIMIENTO,PESO_HUMEDO_MOVIDO,ESTADO_VALIDACION
		 FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' AND COD_LUGAR_DESTINO = '".$row["COD_LUGAR_DESTINO"]."' ORDER BY FECHA_MOVIMIENTO";
		$rs3 = mysqli_query($link, $consulta);		
            
		while ($row3 = mysqli_fetch_array($rs3))
		{												  

				$consulta = "SELECT * FROM conjunto_ram where cod_conjunto = '".$row3["COD_CONJUNTO"]."' AND num_conjunto = '".$row3["NUM_CONJUNTO"]."' AND estado != 'f'"; 
				$rs5 = mysqli_query($link, $consulta);
	
				if($row5 = mysqli_fetch_array($rs5))
				{
			    	echo '<tr><td width="8%" align="left">'.$row3["COD_CONJUNTO"].' - '.$row3["NUM_CONJUNTO"].'</td>';
	 			    	echo '<td width="22%">'.$row5["descripcion"].'</td>';

						echo '<td width="10%" align="center">'.$row3["CONJUNTO_DESTINO"].'</td>';
		
						$consulta = "SELECT nombre_existencia FROM atributo_existencia where cod_existencia = '".$row3["COD_EXISTENCIA"]."'"; 
						$rs6 = mysqli_query($link, $consulta);
			
						if($row6 = mysqli_fetch_array($rs6))
						{
								echo '<td width="10%" align="center">'.$row6["nombre_existencia"].'</td>';
						}
		
						echo '<td width="20%" align="center">'.$row3["FECHA_MOVIMIENTO"].'</td>';
						echo '<td width="10%" align="right">'.number_format($row3["PESO_HUMEDO_MOVIDO"]/1000,3,",","").'</td>';					
						$validacion = $row3["ESTADO_VALIDACION"];
						echo '<td width="10%" align="center">'.number_format($validacion/1000,3,",","").'</td>';
		
						$Total = $row3["PESO_HUMEDO_MOVIDO"] + $validacion;
		
						echo '<td width="10%" align="right">'.number_format($Total/1000,3,",","").'</td>';
			     	echo '</tr>';
				}				

		}
		
		$consulta = "SELECT SUM(PESO_HUMEDO_MOVIDO) AS Total_Humedo FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' AND COD_LUGAR_DESTINO = '".$row["COD_LUGAR_DESTINO"]."'";
		$rs7 = mysqli_query($link, $consulta);

		if($row7 = mysqli_fetch_array($rs7))
		{
			$Total_Humedo = $row7["Total_Humedo"];
		}

		$consulta = "SELECT SUM(ESTADO_VALIDACION) AS Validacion FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' AND COD_LUGAR_DESTINO = '".$row["COD_LUGAR_DESTINO"]."'";
		$rs8 = mysqli_query($link, $consulta);

		if($row8 = mysqli_fetch_array($rs8))
		{
				$Total_val = $row8["Validacion"];
		}

				echo '<tr class="ColorTabla02">';
					echo '<td width="70%" colspan="5"><strong>Totales</strong></td>';			        
					echo '<td width="10%" align="right">'.number_format($Total_Humedo/1000,3,",","").'</td>';			        
					echo '<td width="10%" align="center">'.number_format($Total_val/1000,3,",","").'</td>';			        
					$Total_Final = $Total_Humedo + $Total_val;
					echo '<td width="10%" align="right">'.number_format($Total_Final/1000,3,",","").'</td>';
				echo '</tr>';
			echo '</table><br>'; 								        

	} 	



?>
    <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <input name="btnimprimir" type="button" value="Imprimir" style="width:70;"
                    onClick="JavaScript:Imprimir()">
                <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir">
            </td>
        </tr>
    </table>

</body>

</html>
<?php include("../principal/cerrar_ram_web.php") ?>