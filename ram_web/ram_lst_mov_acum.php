<?php 
  	include("../principal/conectar_ram_web.php");
	//$fecha_ter = date("Y-m-d",mktime(7,59,59,$mes2,($dia2 + 1),$ano2))." 07:59:59";
	//$linea = "generador=1&ano=".$ano."&mes=".$mes."&dia=".$dia."&ano2=".$ano2."&mes2=".$mes2."&dia2=".$dia2;
	$generador   = isset($_REQUEST["generador"])?$_REQUEST["generador"]:"";
	$ano         = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$dia         = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$mes         = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano2        = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:date("Y");
	$dia2        = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:date("d");
	$mes2        = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:date("m");

	$Total_ini_prod    = isset($_REQUEST["Total_ini_prod"])?$_REQUEST["Total_ini_prod"]:0;
	$Total_recep_prod  = isset($_REQUEST["Total_recep_prod"])?$_REQUEST["Total_recep_prod"]:0;
	$Total_trasp_prod  = isset($_REQUEST["Total_trasp_prod"])?$_REQUEST["Total_trasp_prod"]:0;
	$Total_val_prod    = isset($_REQUEST["Total_val_prod"])?$_REQUEST["Total_val_prod"]:0;
	$Total_emb_prod    = isset($_REQUEST["Total_emb_prod"])?$_REQUEST["Total_emb_prod"]:0;
	$Total_exist_prod  = isset($_REQUEST["Total_exist_prod"])?$_REQUEST["Total_exist_prod"]:0;
	$Total_benef_prod  = isset($_REQUEST["Total_benef_prod"])?$_REQUEST["Total_benef_prod"]:0;
	$Total_ini_cir     = isset($_REQUEST["Total_ini_cir"])?$_REQUEST["Total_ini_cir"]:0;
	$Total_recep_cir   = isset($_REQUEST["Total_recep_cir"])?$_REQUEST["Total_recep_cir"]:0;
	$Total_trasp_d_cir = isset($_REQUEST["Total_trasp_d_cir"])?$_REQUEST["Total_trasp_d_cir"]:0;
	$Total_trasp_cir   = isset($_REQUEST["Total_trasp_cir"])?$_REQUEST["Total_trasp_cir"]:0;
	$Total_benef_cir   = isset($_REQUEST["Total_benef_cir"])?$_REQUEST["Total_benef_cir"]:0;
	$Total_emb_cir     = isset($_REQUEST["Total_emb_cir"])?$_REQUEST["Total_emb_cir"]:0;
	$Total_trasp_a_cir = isset($_REQUEST["Total_trasp_a_cir"])?$_REQUEST["Total_trasp_a_cir"]:0;
	$Total_exist_cir   = isset($_REQUEST["Total_exist_cir"])?$_REQUEST["Total_exist_cir"]:0;

 //mysql_select_db("ram_web",$link);
	
	if(strlen($dia) == 1)
		$dia = '0'.$dia;
	
	if(strlen($mes) == 1)
		$mes = '0'.$mes;

	if(strlen($dia2) == 1)
		$dia2 = '0'.$dia2;
	
	if(strlen($mes2) == 1)
		$mes2 = '0'.$mes2;
	
?>

<html>

<head>
    <title>Movimientos Acumulados</title>
    <link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
    <script language="JavaScript">
    function Detalle(dir) {
        window.open(dir, "", "menubar=no resizable=no Top=50 Left=200 width=550 height=300 scrollbars=yes");
    }

    function Imprimir() {
        var f = document.frm1;

        f.BtnImprimir.style.visibility = 'hidden';
        f.BtnSalir.style.visibility = 'hidden';
        window.print();
        f.BtnImprimir.style.visibility = '';
        f.BtnSalir.style.visibility = '';
    }

    /**************/
    function Salir() {
        window.history.back();
    }
    </script>
</head>

<body class="TablaPrincipal">
    <form name="frm1" action="" method="post">

        <table width="500" border="0" align="center">
            <tr class="ColorTabla01">
                <td align="center" colspan="9">INFORME MOVIMIENTOS PRODUCTOS MINEROS, CIRCULANTES Y FUNDENTES</td>
            </tr>
            <tr class="ColorTabla02">
                <td align="center" colspan="9">PERIODO: <?php echo $dia.'/'.$mes.'/'.$ano ?> A
                    <?php echo $dia2.'/'.$mes2.'/'.$ano2 ?></td>
            </tr>
        </table><br>
        <table width="300" border="0" align="center">
            <tr class="ColorTabla02">
                <td align="center" colspan="9">01 - PRODUCTOS MINEROS</td>
            </tr>
        </table>

        <?php


$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 08:00:00';
//$fecha_ter = date("Y-m-d",mktime(7,59,59,$mes2,($dia2 + 1),$ano2))." 07:59:59";
//$fecha_ter = $ano.'-'.$mes.'-'.$dia.' 07:59:59';
$fecha_ter = $ano2.'-'.$mes2.'-'.$dia2.' 07:59:59';

$fecha_t = $ano2.'-'.$mes2.'-'.$dia2;
$fecha_i = $ano.'-'.$mes.'-'.$dia;



?>

        <?php

/******************************************* cod_conjunto = 1 *********************************************/

echo '<table width="665" border="0" cellspacing="0" cellpadding="0" align="center">';
  echo '<tr class="ColorTabla01">'; 
	echo '<td width="20%" align="center">Conjunto</td>';
	echo '<td width="10%" align="center">Exist Ini.</td>';
	echo '<td width="10%" align="center">Recep.</td>';
	echo '<td width="10%" align="center">Trasp.<br>d. Cjto</td>';
	echo '<td width="10%" align="center">Trasp.</td>';
	echo '<td width="10%" align="center">Benef. Dir.</td>';			
	echo '<td width="10%" align="center">Embarque</td>';
	echo '<td width="10%" align="center">Trasp<br>a Cjto</td>';
	echo '<td width="10%" align="center">Exist Final</td></table><br>';			
	
	    $Consulta = "CREATE TEMPORARY TABLE `tmp_table` (";
	    //$Consulta = "CREATE TABLE bd_temp.tmp_table (key ind01(num_conjunto,conjunto_destino)) as";
		$Consulta.= " id INT NOT NULL AUTO_INCREMENT, ";
	    $Consulta.= " cod_existencia char(2) NOT NULL DEFAULT '0' , ";
		$Consulta.= " num_conjunto varchar(6) NOT NULL DEFAULT '0' , ";
		$Consulta.= " conjunto_destino varchar(6) NOT NULL DEFAULT '0' , ";
		//$Consulta.= " fecha_movimiento datetime NOT NULL DEFAULT '0000-00-00 00:00:00' , ";
		$Consulta.= " fecha_movimiento datetime NOT NULL DEFAULT CURRENT_TIMESTAMP , ";
		$Consulta.= " peso_humedo double NOT NULL DEFAULT '0' , ";
		//$Consulta.= " estado_validacion double NULL DEFAULT '0' , ";
		$Consulta.= " estado_validacion varchar(15) NULL DEFAULT '0', ";
		$Consulta.= " PRIMARY KEY (id,cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Consulta.= " UNIQUE KEY Ind02 (id,cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Consulta.= " KEY Ind01 (num_conjunto,conjunto_destino)) AS";
	$Consulta.= " SELECT cod_existencia, cod_conjunto, num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo, cod_validacion as estado_validacion";
    $Consulta = $Consulta." FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 1 AND peso_humedo > 0";
    $Consulta = $Consulta." AND fecha_movimiento" ;
    $Consulta = $Consulta." BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
	$Consulta = $Consulta." AND cod_existencia != 15 AND cod_existencia != 5";		
	$rs = mysqli_query($link, $Consulta);
	//echo "1:".$Consulta."<br>";
	$Consulta = "SELECT cod_existencia, cod_conjunto, num_conjunto, conjunto_destino,fecha_movimiento, peso_humedo_movido, estado_validacion FROM ram_web.movimiento_conjunto ";
	$Consulta = $Consulta." WHERE cod_conjunto = 1 AND peso_humedo_movido > 0  ";
	$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";		
	//echo "2:".$Consulta."<br><br>";
	$rs = mysqli_query($link, $Consulta);
	while ($row = mysqli_fetch_array($rs))
	{		 		
		$Insertar = "INSERT INTO tmp_table (cod_existencia, cod_conjunto,num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo,estado_validacion)";
		$Insertar = "$Insertar VALUES ('".$row["cod_existencia"]."','".$row["cod_conjunto"]."','".$row["num_conjunto"]."','".$row["conjunto_destino"]."','".$row["fecha_movimiento"]."','".$row["peso_humedo_movido"]."','".$row["estado_validacion"]."')";
		mysqli_query($link, $Insertar);
	}

	//Consulta los Productos que participan en los Mov.		
	$Consulta  = "SELECT distinct t2.cod_subproducto as cod_producto";
	$Consulta.= " FROM ram_web.movimiento_proveedor as t1";
	$Consulta.= " INNER JOIN ram_web.conjunto_ram as t2";
	$Consulta.= " on t1.cod_conjunto = t2.cod_conjunto AND t1.num_conjunto = t2.num_conjunto";
	$Consulta.= " WHERE t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'"; 
	$Consulta.= " AND t1.cod_conjunto = 1";  
	$Consulta.= " AND (t2.estado != 'f' AND t2.estado != 'c') order by t2.cod_subproducto asc, t1.num_conjunto asc";
    //echo "3:".$Consulta."<br><br>";
	$rs0 = mysqli_query($link, $Consulta);
	while($row0 = mysqli_fetch_array($rs0))
	{    
			//echo "ingresooo 3";
		  $Total_ini = 0;
		  $Total_recep = 0;
		  $Total_val = 0;
		  $Total_trasp = 0;
		  $Total_benef = 0;
		  $Total_emb = 0;
		  $Total_exist = 0;   

		  $Consulta = "SELECT cod_subproducto,descripcion FROM proyecto_modernizacion.subproducto WHERE prod_ram = 1 AND cod_subproducto = '".$row0["cod_producto"]."' ";
		  //echo "3-1:".$Consulta."<br>";
		  $rs_p = mysqli_query($link, $Consulta);

	        if($row_p = mysqli_fetch_array($rs_p))
		  {	


        	    if($row_p["cod_subproducto"] == "91") 
			{
			  echo '<table width="665" border="0" cellspacing="0" cellpadding="0" align="center">';
			  echo '<tr class="Detalle02">';
          		  echo '<td width="20%">TOTAL</td>';
         		  echo '<td width="10%" align="right">'.number_format($Total_ini_prod/1000,3,",","").'</td>';
        		  echo '<td width="10%" align="right">'.number_format($Total_recep_prod/1000,3,",","").'</td>';
            		  echo '<td width="10%"align="right">&nbsp;</td>';            
        		  echo '<td width="10%" align="right">'.number_format($Total_trasp_prod/1000,3,",","").'</td>';            
       			  echo '<td width="10%" align="right">'.number_format($Total_benef_prod/1000,3,",","").'</td>';
        		  echo '<td width="10%" align="right">'.number_format($Total_emb_prod/1000,3,",","").'</td>';
       			  echo '<td width="10%" align="right">'.number_format($Total_val_prod/1000,3,",","").'</td>';
          		  echo '<td width="10%" align="right">'.number_format($Total_exist_prod/1000,3,",","").'</td>';            
      			  echo '</tr></table><br>';
			}
			  echo '<table width="300" border="0" align="center">';
			  echo '<tr class="ColorTabla01">'; 
	    	  	  echo '<td>'.$row_p["cod_subproducto"].' - '.$row_p["descripcion"].'</td>';
		  	  echo '</tr></table>'; 
		  }	
		  	
		  //Consulta los Conjuntos que participan en los Mov.
		  $Consulta  = "SELECT distinct t1.num_conjunto as num_conjunto, t2.cod_subproducto as cod_producto";
		  $Consulta.= " FROM ram_web.movimiento_proveedor as t1";
		  $Consulta.= " INNER JOIN ram_web.conjunto_ram as t2";
		  $Consulta.= " on t1.cod_conjunto = t2.cod_conjunto AND t1.num_conjunto = t2.num_conjunto";
		  $Consulta.= " WHERE t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'"; 
		  $Consulta.= " AND t1.cod_conjunto = 1 AND t2.cod_subproducto = ".$row0["cod_producto"];  
		  $Consulta.= " AND (t2.estado != 'f' AND t2.estado != 'c') order by t2.cod_subproducto asc, t1.num_conjunto asc";
		  $rs = mysqli_query($link, $Consulta);

	      echo '<table width="665" border="0" cellspacing="0" cellpadding="0" align="center">';
		  
		  while($row = mysqli_fetch_array($rs))
		  {          
		  	echo '<tr>';

			//Descripcion
			$Consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 1 AND num_conjunto = '".$row["num_conjunto"]."' AND (estado != 'f' AND estado != 'c')"; 
			$rs1 = mysqli_query($link, $Consulta);
			if($row1 = mysqli_fetch_array($rs1))
			{
            	echo '<td width="20%">'.$row["num_conjunto"].' '.substr($row1["descripcion"],0,22).'</td>';
				
				//Existencia Ini		
				$Consulta ="SELECT sum(peso_humedo) AS peso_ini from tmp_table WHERE num_conjunto = '".$row["num_conjunto"]."' AND cod_existencia = 13 AND left(FECHA_MOVIMIENTO,10) = '".$fecha_i."'";
				$rs2 = mysqli_query($link, $Consulta);
				if($row2 = mysqli_fetch_array($rs2))
				{
                    $peso_ini = $row2["peso_ini"];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="right" width="10%">'.number_format($peso_ini/1000,3,",","").'</td>';
				}

				//Recepcion
				$Consulta ="SELECT sum(peso_humedo) AS peso_recep from tmp_table WHERE num_conjunto = '".$row["num_conjunto"]."' AND cod_existencia = 2 AND left(FECHA_MOVIMIENTO,10) BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
				$rs3 = mysqli_query($link, $Consulta);
				if($row3 = mysqli_fetch_array($rs3))
				{		
					$peso_recep = $row3["peso_recep"];
					$Total_recep = $Total_recep + $peso_recep;		

					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=02&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_recep != 0)				
						echo "<td align='right' width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_recep/1000,3,",","")."</a></td>";
					else
					  echo '<td align="right" width="10%">0,000</td>';
				}


				//Traspaso desde Conj.
					echo '<td align="right" width="10%">0,000</td>';


                //Traspaso 
				$Consulta ="SELECT sum(peso_humedo + estado_validacion) AS peso_trasp FROM tmp_table WHERE cod_existencia = 6 AND num_conjunto = '".$row["num_conjunto"]."' AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs5 = mysqli_query($link, $Consulta);
				if($row5 = mysqli_fetch_array($rs5))
				{
            	    $peso_trasp = $row5["peso_trasp"];	
					$Total_trasp = $Total_trasp + $peso_trasp;		

					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=06&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_ini."&Fecha_ter=".$fecha_ter);
					if($peso_trasp != 0)				
						echo "<td align='right'  width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_trasp/1000,3,",","")."</a></td>";
					else
					  echo '<td align="right" width="10%">0,000</td>';
				}

                //Beneficio Dir. 
					echo '<td align="right" width="10%">0,000</td>';

                //Embarque 
				$Consulta ="SELECT sum(peso_humedo) AS peso_emb from tmp_table where num_conjunto = '".$row["num_conjunto"]."' AND cod_existencia = 5 AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs3 = mysqli_query($link, $Consulta);
				if($row3 = mysqli_fetch_array($rs3))
				{		
					$peso_emb = $row3["peso_emb"];
					$Total_emb = $Total_emb + $peso_emb;		
					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=05&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_ini."&Fecha_ter=".$fecha_ter);
					if($peso_emb != 0)				
						echo "<td align='right'  width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_emb/1000,3,",","")."</a></td>";
					else
					  echo '<td align="right" width="10%">0,000</td>';
				}

                //Traspaso a Cjto
					echo '<td align="right" width="10%">0,000</td>';

				//Existencia Final
				$Consulta ="SELECT sum(peso_humedo) AS peso_final FROM tmp_table WHERE num_conjunto = '".$row["num_conjunto"]."'  AND cod_existencia = 1 AND left(FECHA_MOVIMIENTO,10) = '".$fecha_t."'";
				$rs6 = mysqli_query($link, $Consulta);

				if($row6 = mysqli_fetch_array($rs6))
				{
					$peso_final = $row6["peso_final"];
					$Total_exist = $Total_exist + $peso_final;
		            echo '<td align="right" width="10%">'.number_format($peso_final/1000,3,",","").'</td>';            
				}

			}   			

          echo '</tr>';
         } 
	    echo '<tr class="ColorTabla02">';
            echo '<td width="20%">SubTotales</td>';
            echo '<td align="right" width="10%">'.number_format($Total_ini/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_recep/1000,3,",","").'</td>';            
            echo '<td align="right" width="10%">&nbsp;</td>';
            echo '<td align="right" width="10%">'.number_format($Total_trasp/1000,3,",","").'</td>';            
            echo '<td align="right" width="10%">'.number_format($Total_benef/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_emb/1000,3,",","").'</td>';
            echo '<td width="10%" align="right">'.number_format($Total_val/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_exist/1000,3,",","").'</td>';            
            echo '</tr>';
            echo '</table><br>';	

		$Total_ini_prod = $Total_ini_prod + $Total_ini; 
		$Total_recep_prod = $Total_recep_prod + $Total_recep; 
		$Total_trasp_prod = $Total_trasp_prod + $Total_trasp; 
		$Total_val_prod = $Total_val_prod + $Total_val; 
		$Total_emb_prod = $Total_emb_prod + $Total_emb; 
		$Total_exist_prod = $Total_exist_prod + $Total_exist; 



	}
	echo '<table width="665" border="0" cellspacing="0" cellpadding="0" align="center">';
		  echo '<tr class="Detalle02">';
            echo '<td width="20%">TOTAL</td>';
            echo '<td width="10%" align="right">'.number_format($Total_ini_prod/1000,3,",","").'</td>';
            echo '<td width="10%" align="right">'.number_format($Total_recep_prod/1000,3,",","").'</td>';            
            echo '<td width="10%" align="right">&nbsp;</td>';
            echo '<td width="10%" align="right">'.number_format($Total_trasp_prod/1000,3,",","").'</td>';            
            echo '<td width="10%" align="right">'.number_format($Total_benef_prod/1000,3,",","").'</td>';
            echo '<td width="10%" align="right">'.number_format($Total_emb_prod/1000,3,",","").'</td>';
            echo '<td width="10%" align="right">'.number_format($Total_val_prod/1000,3,",","").'</td>';
            echo '<td width="10%" align="right">'.number_format($Total_exist_prod/1000,3,",","").'</td>';            
          echo '</tr>';
        echo '</table><br>';	

?>

        <table width="300" border="0" align="center">
            <tr class="ColorTabla02">
                <td align="center" colspan="9">03 - PRODUCTOS CIRCULANTES</td>
            </tr>
        </table>

        <?php
/******************************************* cod_conjunto = 3 *********************************************/

echo '<table width="665" border="0" cellspacing="0" cellpadding="0" align="center">';
  echo '<tr class="ColorTabla01">'; 
	echo '<td width="20%" align="center">Conjunto</td>';
	echo '<td width="10%" align="center">Exist Ini.</td>';
	echo '<td width="10%" align="center">Recep</td>';
	echo '<td width="10%" align="center">Trasp<br>d. Cjto</td>';
	echo '<td width="10%" align="center">Trasp.</td>';			
	echo '<td width="10%" align="center">Benef. Dir.</td>';			
	echo '<td width="10%" align="center">Embarque</td>';			
	echo '<td width="10%" align="center">Trasp<br>a Cjto</td>';			
	echo '<td width="10%" align="center">Exist Final</td></table><br>';			
	
	$Consulta = "CREATE  TEMPORARY  TABLE  `tmp_table2` (";
	$Consulta.= " id INT NOT NULL AUTO_INCREMENT, ";
	$Consulta.= " cod_existencia char(2) NOT NULL DEFAULT '0' , ";
		$Consulta.= " num_conjunto varchar(6) NOT NULL DEFAULT '0' , ";
		$Consulta.= " conjunto_destino varchar(6) NOT NULL DEFAULT '0' , ";
		//$Consulta.= " fecha_movimiento datetime NOT NULL DEFAULT '0000-00-00 00:00:00' , ";
		$Consulta.= " fecha_movimiento datetime NOT NULL DEFAULT CURRENT_TIMESTAMP , ";
		$Consulta.= " peso_humedo double NOT NULL DEFAULT '0' , ";
		//$Consulta.= " estado_validacion double NULL DEFAULT '0' , ";
		$Consulta.= " estado_validacion varchar(15) NULL DEFAULT '0', ";
		$Consulta.= " PRIMARY KEY (id,cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Consulta.= " UNIQUE KEY Ind02 (id,cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Consulta.= " KEY Ind01 (num_conjunto,conjunto_destino)) AS";
	
	$Consulta.= " SELECT cod_existencia, cod_conjunto, num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo, cod_validacion as estado_validacion";
    $Consulta = $Consulta." FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 3 AND peso_humedo > 0";
    $Consulta = $Consulta." AND fecha_movimiento" ;
    $Consulta = $Consulta." BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
	$Consulta = $Consulta." AND cod_existencia != 15 AND cod_existencia != 5";		
	$rs = mysqli_query($link, $Consulta);

	$Consulta = "SELECT cod_existencia, cod_conjunto, num_conjunto, conjunto_destino,fecha_movimiento, peso_humedo_movido, estado_validacion FROM ram_web.movimiento_conjunto ";
	$Consulta = $Consulta." WHERE cod_conjunto = 3 AND peso_humedo_movido > 0  ";
	$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";		
	$rs = mysqli_query($link, $Consulta);
	while ($row = mysqli_fetch_array($rs))
	{		 		
		$Insertar = "INSERT INTO tmp_table2 (cod_existencia, cod_conjunto,num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo,estado_validacion)";
		$Insertar = "$Insertar VALUES ('".$row["cod_existencia"]."','".$row["cod_conjunto"]."','".$row["num_conjunto"]."','".$row["conjunto_destino"]."','".$row["fecha_movimiento"]."','".$row["peso_humedo_movido"]."','".$row["estado_validacion"]."')";
		mysqli_query($link, $Insertar);
	}

	//Consulta los Productos que participan en los Mov.		
	$Consulta  = "SELECT distinct t2.cod_subproducto as cod_producto";
	$Consulta.= " FROM ram_web.movimiento_proveedor as t1";
	$Consulta.= " INNER JOIN ram_web.conjunto_ram as t2";
	$Consulta.= " on t1.cod_conjunto = t2.cod_conjunto AND t1.num_conjunto = t2.num_conjunto";
	$Consulta.= " WHERE t2.estado != 'f' AND t2.estado != 'c' AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'"; 
	$Consulta.= " AND t1.cod_conjunto = 3";  	
	$Consulta.= " order by t2.cod_subproducto asc, t1.num_conjunto asc";
	//echo $Consulta."<br>";
	$rs0 = mysqli_query($link, $Consulta);
	while($row0 = mysqli_fetch_array($rs0))
	{          			
		  $Total_ini = 0;
		  $Total_recep = 0;
		  $Total_val = 0;
		  $Total_trasp_d = 0;
		  $Total_trasp = 0;
		  $Total_benef = 0;
		  $Total_emb = 0;
		  $Total_trasp_a = 0;
		  $Total_exist = 0;

		  $Consulta = "SELECT ap_subproducto,descripcion FROM proyecto_modernizacion.subproducto WHERE cod_producto = 42 AND cod_subproducto = '".$row0["cod_producto"]."' ";
		  $rs_p = mysqli_query($link, $Consulta); 

		  if($row_p = mysqli_fetch_array($rs_p))
		  {	
			  echo '<table width="300" border="0" align="center">';
			  	echo '<tr class="ColorTabla01">'; 
	    	  	echo '<td>'.$row_p["ap_subproducto"].' - '.$row_p["descripcion"].'</td>';
		  	  echo '</tr></table>'; 
		  }
		  	
		  //Consulta los Conjuntos que participan en los Mov.
		  $Consulta  = "SELECT distinct t1.num_conjunto as num_conjunto, t2.cod_subproducto as cod_producto";
		  $Consulta.= " FROM ram_web.movimiento_proveedor as t1";
		  $Consulta.= " INNER JOIN ram_web.conjunto_ram as t2";
		  $Consulta.= " on t1.cod_conjunto = t2.cod_conjunto AND t1.num_conjunto = t2.num_conjunto";
		  $Consulta.= " WHERE t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'"; 
		  $Consulta.= " AND t1.cod_conjunto = 3 AND (t2.estado != 'f' AND t2.estado != 'c') AND t2.cod_subproducto = '".$row0["cod_producto"]."' ";  
		  $Consulta.= " order by t2.cod_subproducto asc, t1.num_conjunto asc";
		  //echo $Consulta."<br>";
		  $rs = mysqli_query($link, $Consulta);
	      echo '<table width="665" border="0" cellspacing="0" cellpadding="0" align="center">';
		  
		  while($row = mysqli_fetch_array($rs))
		  {          
		  	echo '<tr>';

			//Descripcion
			$Consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 3 AND num_conjunto = '".$row["num_conjunto"]."' AND (estado != 'f' AND estado != 'c')"; 
			$rs1 = mysqli_query($link, $Consulta);
			if($row1 = mysqli_fetch_array($rs1))
			{
            	echo '<td width="20%">'.$row["num_conjunto"].' '.substr($row1["descripcion"],0,22).'</td>';
				

				//Existencia Ini		
				$Consulta ="SELECT sum(peso_humedo) AS peso_ini from tmp_table2 WHERE num_conjunto = '".$row["num_conjunto"]."' AND cod_existencia = 13 AND FECHA_MOVIMIENTO = '".$fecha_i."' ";
				//echo $Consulta."<br>";
				$rs2 = mysqli_query($link, $Consulta);
				if($row2 = mysqli_fetch_array($rs2))
				{
                    $peso_ini = $row2["peso_ini"];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="right" width="10%">'.number_format($peso_ini/1000,3,",","").'</td>';
				}

				//Recepcion
				$Consulta ="SELECT sum(peso_humedo + estado_validacion) AS peso_recep from tmp_table2 WHERE num_conjunto = '".$row["num_conjunto"]."' AND cod_existencia = 2 AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs3 = mysqli_query($link, $Consulta);
				if($row3 = mysqli_fetch_array($rs3))
				{		
					$peso_recep = $row3["peso_recep"];
					$Total_recep = $Total_recep + $peso_recep;
					
					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=22&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_ini."&Fecha_ter=".$fecha_ter);
					if($peso_recep != 0)				
						echo "<td align='right' width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_recep/1000,3,",","")."</a></td>";
					else
					  echo '<td align="right" width="10%">0,000</td>';
				}


                //Traspaso desde Cjto
				$Consulta ="SELECT sum(peso_humedo + estado_validacion) AS peso_trasp_d FROM tmp_table2 WHERE cod_existencia = 15 AND conjunto_destino = '".$row["num_conjunto"]."' AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs5 = mysqli_query($link, $Consulta);
				//echo $Consulta;				
				if($row5 = mysqli_fetch_array($rs5))
				{
            	    $peso_trasp_d = $row5["peso_trasp_d"];	
					$Total_trasp_d = $Total_trasp_d + $peso_trasp_d;		

					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=17&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_ini."&Fecha_ter=".$fecha_ter);
					if($peso_trasp_d != 0)				
						echo "<td  align='right' width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_trasp_d/1000,3,",","")."</a></td>";
					else
					  echo '<td align="right" width="10%">0,000</td>';
				}

                //Traspaso 
				$Consulta ="SELECT sum(peso_humedo + estado_validacion) AS peso_trasp FROM tmp_table2 WHERE cod_existencia = 6 AND num_conjunto = '".$row["num_conjunto"]."' AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs5 = mysqli_query($link, $Consulta);
				if($row5 = mysqli_fetch_array($rs5))
				{
            	    $peso_trasp = $row5["peso_trasp"];	
					$Total_trasp = $Total_trasp + $peso_trasp;		
					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=06&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_ini."&Fecha_ter=".$fecha_ter);
					if($peso_trasp != 0)				
						echo "<td  align='right' width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_trasp/1000,3,",","")."</a></td>";
					else
					  echo '<td width="10%" align="right">0,000</td>';
				}

                //Beneficio Dir. 
					echo '<td align="right" width="10%">0,000</td>';

                //Embarque 
				$Consulta ="SELECT sum(peso_humedo + estado_validacion) AS peso_emb from tmp_table2 where num_conjunto = '".$row["num_conjunto"]."' AND cod_existencia = 5 AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs3 = mysqli_query($link, $Consulta);
				if($row3 = mysqli_fetch_array($rs3))
				{		
					$peso_emb = $row3["peso_emb"];
					$Total_emb = $Total_emb + $peso_emb;		
					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=05&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_ini."&Fecha_ter=".$fecha_ter);
					if($peso_emb != 0)				
						echo "<td align='right' width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_emb/1000,3,",","")."</a></td>";
					else
					  echo '<td align="right" width="10%">0,000</td>';
				}

                //Traspaso a Cjto
				$Consulta ="SELECT sum(peso_humedo + estado_validacion) AS peso_trasp_a FROM tmp_table2 WHERE cod_existencia = 15 AND num_conjunto = '".$row["num_conjunto"]."' AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs5 = mysqli_query($link, $Consulta);
				if($row5 = mysqli_fetch_array($rs5))
				{
            	    $peso_trasp_a = $row5["peso_trasp_a"];	
					$Total_trasp_a = $Total_trasp_a + $peso_trasp_a;		
					$Valores = str_replace(' ','%20',"ram_con_recep_acum.php?cod_exist=15&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_ini."&Fecha_ter=".$fecha_ter);
					if($peso_trasp_a != 0)				
						echo "<td align='right' width='10%'><a href=JavaScript:Detalle('$Valores');>".number_format($peso_trasp_a/1000,3,",","")."</a></td>";
					else
					  echo '<td align="right" width="10%">0,000</td>';
				}


			/*	$Consulta = "SELECT MAX(fecha_movimiento) as fecha_ter FROM ram_web.movimiento_proveedor
				 WHERE num_conjunto = $row["num_conjunto"] AND cod_existencia = 1 AND FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs7 = mysqli_query($link, $Consulta); 
				
				if($row7 = mysqli_fetch_array($rs7))
				{
					$fecha_t = substr($row7["fecha_ter"],0,10);				
				}*/

				//Existencia Final
				$Consulta ="SELECT sum(peso_humedo) AS peso_final FROM tmp_table2 WHERE num_conjunto = '".$row["num_conjunto"]."'  AND cod_existencia = 1 AND left(FECHA_MOVIMIENTO,10) = '".$fecha_t."'";
				$rs6 = mysqli_query($link, $Consulta);
				//echo $Consulta;
				if($row6 = mysqli_fetch_array($rs6))
				{
					$peso_final = $row6["peso_final"];
					$Total_exist = $Total_exist + $peso_final;
		            echo '<td align="right" width="10%">'.number_format($peso_final/1000,3,",","").'</td>';            
				}

			}   			

          echo '</tr>';
         } 
		  echo '<tr class="ColorTabla02">';
            echo '<td width="20%">SubTotales</td>';
            echo '<td align="right" width="10%">'.number_format($Total_ini/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_recep/1000,3,",","").'</td>';            
            echo '<td align="right" width="10%">'.number_format($Total_trasp_d/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_trasp/1000,3,",","").'</td>';            
            echo '<td align="right" width="10%">'.number_format($Total_benef/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_emb/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_trasp_a/1000,3,",","").'</td>';
            echo '<td align="right" width="10%">'.number_format($Total_exist/1000,3,",","").'</td>';            
          echo '</tr>';
        echo '</table><br>';	
		
		$Total_ini_cir = $Total_ini_cir + $Total_ini; 
		$Total_recep_cir = $Total_recep_cir + $Total_recep; 
		$Total_trasp_d_cir = $Total_trasp_d_cir + $Total_trasp_d; 
		$Total_trasp_cir = $Total_trasp_cir + $Total_trasp; 
		$Total_emb_cir = $Total_emb_cir + $Total_emb; 
		$Total_trasp_a_cir = $Total_trasp_a_cir + $Total_trasp_a; 
		$Total_exist_cir = $Total_exist_cir + $Total_exist; 

	}
	echo '<table width="665" border="0" cellspacing="0" cellpadding="0" align="center">';
		  echo '<tr class="Detalle02">';
			echo '<td width="20%">TOTAL</td>';
			echo '<td width="10%" align="right">'.number_format($Total_ini_cir/1000,3,",","").'</td>';
			echo '<td width="10%" align="right">'.number_format($Total_recep_cir/1000,3,",","").'</td>';   
			echo '<td width="10%" align="right">'.number_format($Total_trasp_d_cir/1000,3,",","").'</td>';			
			echo '<td width="10%" align="right">'.number_format($Total_trasp_cir/1000,3,",","").'</td>';			
			echo '<td width="10%" align="right">'.number_format($Total_benef_cir/1000,3,",","").'</td>';			
			echo '<td width="10%" align="right">'.number_format($Total_emb_cir/1000,3,",","").'</td>';			
			echo '<td width="10%" align="right">'.number_format($Total_trasp_a_cir/1000,3,",","").'</td>';			
			echo '<td width="10%" align="right">'.number_format($Total_exist_cir/1000,3,",","").'</td>';		
          echo '</tr>';
        echo '</table><br>';	


	$Eliminar = "DROP TABLE tmp_table ";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE tmp_table2 ";
	mysqli_query($link, $Eliminar);

?>

        <table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td align="center">
                    <input name="BtnImprimir" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()">
                    <input name="BtnSalir" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()">
                </td>
            </tr>
        </table>
    </form>
</body>

</html>
<?php include("../principal/cerrar_sea_web.php") ?>