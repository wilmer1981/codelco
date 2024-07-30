<?php 
include("../principal/conectar_ram_web.php");

if(isset($_REQUEST["Proceso"])){
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso= "";
}
if(isset($_REQUEST["filename"])){
	$filename = $_REQUEST["filename"];
}else{
	$filename = "";
}

if(isset($_REQUEST["fecha_ini"])){
	$fecha_ini = $_REQUEST["fecha_ini"];
}else{
	$fecha_ini= "";
}

if(isset($_REQUEST["fecha_ter"])){
	$fecha_ter = $_REQUEST["fecha_ter"];
}else{
	$fecha_ter= "";
}

if(isset($_REQUEST["num_conjunto"])){
	$num_conjunto = $_REQUEST["num_conjunto"];
}else{
	$num_conjunto= "";
}

if($Proceso == 'B2')
{
	    ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
}
$CodigoDeSistema = 7;
$CodigoDePantalla = 10;

?>
<html>

<head>
    <title>RESUMEN MEZCLA</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript">
    function buscar_conjunto() {
        var f = formulario;

        if (f.num_conjunto.value == '') {
            alert('Debe Ingresar Mezcla');
            f.num_conjunto.focus();
            return;
        }
        f.action = "ram_lst_mov_mezcla_acum.php?Proceso=B";
        f.submit();
    }

    function buscar_conjunto_excel() {
        var f = formulario;

        f.action = "ram_lst_mov_mezcla_acum.php?Proceso=B2";
        f.submit();
    }

    function Imprimir() {
        window.print();
    }

    function salir_menu() {
        var f = formulario;
        f.action = "../principal/sistemas_usuario.php?CodSistema=7";
        f.submit();
    }
    </script>
    <link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
    <style type="text/css">
    <!--
    body {
        margin-left: 3px;
        margin-top: 3px;
        margin-right: 0px;
        margin-bottom: 0px;
    }
    -->
    </style>
</head>

<body>
    <form name="formulario" method="post" action="">
        <?php
	if($Proceso == '')
   		include("../principal/encabezado.php");

	 include("../principal/conectar_principal.php"); 

	 if($Proceso == 'B' || $Proceso == '')
	 {
?>
        <?php 
	if($Proceso == 'B')
	{
?>
        <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">

            <?php
	}
	else
	{
?>
            <table width="770" height="330" valign="top" border="0" cellpadding="5" cellspacing="0"
                class="TablaPrincipal">
                <?php
	}
?>
                <tr>
                    <td align="center" valign="top">

                        <table cellpadding="3" cellspacing="0" width="570" align="center" border="0"
                            bordercolor="#b26c4a" class="TablaPrincipal">
                            <tr class="ColorTabla02">
                                <td colspan="4">
                                    <div align="center">Resumen Mezcla</div>
                                </td>
                            </tr>
                            <tr>
                                <td width="90"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                        height="11">&nbsp;Mezcla</td>
                                <td width="82">
                                    <?php
			if($Proceso == 'B' || $Proceso == 'B2')
				echo '<input name="num_conjunto" type="text" size="15" value="'.$num_conjunto.'">';
            else		
				echo '<input name="num_conjunto" type="text" size="15">';
			?>
                                </td>
                                <td width="220"><input name="buscar" type="button" style="width:70" value="Buscar"
                                        onClick="buscar_conjunto();">
                                    <input name="excel" type="button" style="width:70"
                                        onClick="buscar_conjunto_excel();" value="Excel">
                                </td>
                                <td width="152"> <input name="btnimprimir2" type="button" style="width:70"
                                        value="Imprimir" onClick="Imprimir();">
                                    <input name="btnsalir2" type="button" style="width:70" value="Salir"
                                        onClick="salir_menu();">
                                </td>
                            </tr>
                        </table>
                        <br>
                        <?php
	}	   	  	        
?>
                        <?php
if($Proceso == 'B' || $Proceso == 'B2')
{
	$consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE conjunto_destino = $num_conjunto group by num_conjunto order by conjunto_destino ASC ";
	$rs = mysqli_query($link, $consulta);

	if($row = mysqli_fetch_array($rs))
	{
		echo '<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla02">';

		$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE num_conjunto = $num_conjunto";
		$rs2 = mysqli_query($link, $consulta);
		
		if($row2 = mysqli_fetch_array($rs2))
		{
			echo '<td width="40%" align="center" colspan="5"><strong>MEZCLA : '.$row2["num_conjunto"].' - '.$row2["descripcion"].'</strong></td>';
		}
		echo '</tr></table><br>';
        
		//Inicio y Termino de Movimiento
		echo '<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla02">';
		$consulta = "SELECT MIN(fecha_movimiento) as fecha_ini, MAX(fecha_movimiento) as fecha_ter FROM ram_web.movimiento_conjunto
		 WHERE conjunto_destino = $num_conjunto AND cod_conjunto_destino = 2";
		$rs4 = mysqli_query($link, $consulta);
		
		if($row4 = mysqli_fetch_array($rs4))
		{
			$fecha_ini = $row4["fecha_ini"];
			$fecha_ter = $row4["fecha_ter"];
			echo '<td width="40%" align="center" colspan="5"><strong>Inicio Mov : '.substr($row4["fecha_ini"],0,10).' &nbsp;&nbsp;&nbsp;Termino Mov : '.substr($row4["fecha_ter"],0,10).'</strong></td>';
		}
		echo '</tr></table>';

		//PRODUCTOS MINEROS		
		echo '<table width="570"  border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla01">';
		echo '<td width="15%" align="center">COD.</td>';
		echo '<td width="27%" align="center">CONJ. ORIGEN</td>';
		//echo '<td width="24%" align="center">FECHA</td>';
		echo '<td width="8%" align="right">P. HUM.</td>';
		echo '<td width="12%" align="right">VALID</td>';
		echo '<td width="17%" align="right">P. TOTAL</td>';
		echo '</tr>';				
				
		$consulta = "SELECT distinct COD_CONJUNTO,NUM_CONJUNTO,FECHA_MOVIMIENTO FROM ram_web.movimiento_conjunto
		 WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND conjunto_destino = $num_conjunto AND cod_conjunto_destino = 2 AND cod_conjunto = 1 group by num_conjunto";
		$rs3 = mysqli_query($link, $consulta);

		while ($row3 = mysqli_fetch_array($rs3))
		{												  

		    	echo '<tr><td width="8%">'.$row3["COD_CONJUNTO"].' * '.$row3["NUM_CONJUNTO"].'</td>';

				$consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = $row3[COD_CONJUNTO] AND num_conjunto = ".$row3["NUM_CONJUNTO"]; 
				$rs5 = mysqli_query($link, $consulta);
	
				if($row5 = mysqli_fetch_array($rs5))
				{
	 			    	echo '<td width="22%">'.$row5["descripcion"].'</td>';
				}

		    	//echo '<td width="22%">'.$row3[FECHA_MOVIMIENTO].'</td>';

				$consulta = "SELECT SUM(peso_humedo_movido) as peso_humedo, SUM(estado_validacion) as validacion FROM ram_web.movimiento_conjunto
				 WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND num_conjunto = $row3[NUM_CONJUNTO] AND cod_conjunto = 1 AND conjunto_destino = $num_conjunto group by num_conjunto";
				$rs6 = mysqli_query($link, $consulta);

				if($row6 = mysqli_fetch_array($rs6))
				{
					$peso_humedo = $row6["peso_humedo"];
					$validacion = $row6["validacion"];						
					echo '<td width="10%" align="right">'.number_format($peso_humedo/1000,3,",","").'</td>';
					echo '<td width="10%" align="right">'.number_format($validacion/1000,3,",","").'</td>';
                    $Total = $peso_humedo + $validacion;
				}

				echo '<td width="10%" align="right">'.number_format($Total/1000,3,",","").'</td>';
				
		}
     	echo '</tr>';
		
		$consulta = "SELECT SUM(PESO_HUMEDO_MOVIDO) AS Total_Humedo FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND CONJUNTO_DESTINO = $num_conjunto AND cod_conjunto = 1";
		$rs7 = mysqli_query($link, $consulta);

		if($row7 = mysqli_fetch_array($rs7))
		{
			$Total_Humedo = $row7["Total_Humedo"];
		}

		$consulta = "SELECT SUM(ESTADO_VALIDACION) AS Validacion FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND CONJUNTO_DESTINO = $num_conjunto AND cod_conjunto = 1";
		$rs8 = mysqli_query($link, $consulta);

		if($row8 = mysqli_fetch_array($rs8))
		{
				$Total_val = $row8["Validacion"];
				$Total_Final = $row7["Total_Humedo"] + $Total_val = $row8["Validacion"];
		}

			echo '<tr class="ColorTabla02">';
				echo '<td width="70%" colspan="2"><strong>Totales</strong></td>';			        
				echo '<td width="10%" align="right">'.number_format($Total_Humedo/1000,3,",","").'</td>';			        
				echo '<td width="10%" align="right">'.number_format($Total_val/1000,3,",","").'</td>';			        
				echo '<td width="10%" align="right">'.number_format($Total_Final/1000,3,",","").'</td>';
			echo '</tr>';
		echo '</table><br>'; 								        


		//PRODUCTOS CIRCULANTE		
		echo '<table width="570"  border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla01">';
		echo '<td width="15%" align="center">COD.</td>';
		echo '<td width="27%" align="center">CONJ. ORIGEN</td>';
		//echo '<td width="24%" align="center">FECHA</td>';
		echo '<td width="8%" align="right">P. HUM.</td>';
		echo '<td width="12%" align="right">VALID</td>';
		echo '<td width="17%" align="right">P. TOTAL</td>';
		echo '</tr>';				
		$consulta = "SELECT distinct COD_CONJUNTO,NUM_CONJUNTO,FECHA_MOVIMIENTO FROM ram_web.movimiento_conjunto
		 WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND conjunto_destino = $num_conjunto AND cod_conjunto_destino = 2 AND cod_conjunto = 3 group by num_conjunto";
		$rs3 = mysqli_query($link, $consulta);

		while ($row3 = mysqli_fetch_array($rs3))
		{												  

		    	echo '<tr><td width="8%">'.$row3["COD_CONJUNTO"].' * '.$row3["NUM_CONJUNTO"].'</td>';

				$consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = $row3[COD_CONJUNTO] AND num_conjunto = ".$row3["NUM_CONJUNTO"]; 
				$rs5 = mysqli_query($link, $consulta);
	
				if($row5 = mysqli_fetch_array($rs5))
				{
	 			    	echo '<td width="22%">'.$row5["descripcion"].'</td>';
				}

		    	//echo '<td width="22%">'.$row3[FECHA_MOVIMIENTO].'</td>';

				$consulta = "SELECT SUM(peso_humedo_movido) as peso_humedo, SUM(estado_validacion) as validacion FROM ram_web.movimiento_conjunto
				 WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND num_conjunto = $row3[NUM_CONJUNTO] AND cod_conjunto = 3 AND conjunto_destino = $num_conjunto group by num_conjunto";
				$rs6 = mysqli_query($link, $consulta);

				if($row6 = mysqli_fetch_array($rs6))
				{
					$peso_humedo = $row6["peso_humedo"];
					$validacion = $row6["validacion"];						
					echo '<td width="10%" align="right">'.number_format($peso_humedo/1000,3,",","").'</td>';
					echo '<td width="10%" align="right">'.number_format($validacion2/1000,3,",","").'</td>';

                    $Total = $peso_humedo +  $validacion;
				}


				echo '<td width="10%" align="right">'.number_format($Total/1000,3,",","").'</td>';
				
		}
     	echo '</tr>';
		
		$consulta = "SELECT SUM(PESO_HUMEDO_MOVIDO) AS Total_Humedo FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND CONJUNTO_DESTINO = $num_conjunto AND cod_conjunto = 3";
		$rs7 = mysqli_query($link, $consulta);

		if($row7 = mysqli_fetch_array($rs7))
		{
			$Total_Humedo = $row7["Total_Humedo"];
		}

		$consulta = "SELECT SUM(ESTADO_VALIDACION) AS Validacion FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND CONJUNTO_DESTINO = $num_conjunto AND cod_conjunto = 3";
		$rs8 = mysqli_query($link, $consulta);

		if($row8 = mysqli_fetch_array($rs8))
		{
				$Total_val = $row8["Validacion"];
				$Total_Final = $Total_Humedo + $row8["Validacion"];
		}

				echo '<tr class="ColorTabla02">';
					echo '<td width="70%" colspan="2"><strong>Totales</strong></td>';			        
					echo '<td width="10%" align="right">'.number_format($Total_Humedo/1000,3,",","").'</td>';			        
					echo '<td width="10%" align="right">'.number_format($Total_val/1000,3,",","").'</td>';			        
					echo '<td width="10%" align="right">'.number_format($Total_Final/1000,3,",","").'</td>';
				echo '</tr>';

	} 	

		$consulta = "SELECT SUM(PESO_HUMEDO_MOVIDO) AS Total_Humedo FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND CONJUNTO_DESTINO = $num_conjunto";
		$rs7 = mysqli_query($link, $consulta);

		if($row7 = mysqli_fetch_array($rs7))
		{
			$Total_Humedo = $row7["Total_Humedo"];
		}

		$consulta = "SELECT SUM(ESTADO_VALIDACION) AS Validacion FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND CONJUNTO_DESTINO = $num_conjunto";
		$rs8 = mysqli_query($link, $consulta);

		if($row8 = mysqli_fetch_array($rs8))
		{
				$Total_val = $row8["Validacion"];
				$Total_Final = $row7["Total_Humedo"] + $row8["Validacion"];
		}

			echo '<tr class="Detalle02">';
				echo '<td colspan="2"><strong>TOTAL MEZCLA</strong></td>';			        
				echo '<td align="right">'.number_format($Total_Humedo/1000,3,",","").'</td>';			        
				echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';			        
				echo '<td align="right">'.number_format($Total_Final/1000,3,",","").'</td>';
			echo '</tr>';
		echo '</table><br>'; 								        

}	


?>
            </table>
            <td align="center" valign="top">
                </tr>
        </table>
        <?php 
	if($Proceso == '')
 	include("../principal/pie_pagina.php");
 ?>
    </form>
</body>

</html>
<?php include("../principal/cerrar_ram_web.php") ?>