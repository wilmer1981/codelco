<?php
	        ob_end_clean();
if(isset($_REQUEST["filename"])){
	$filename = $_REQUEST["filename"];
}else{
	$filename = "";
}
$generador  = isset($_REQUEST["generador"])?$_REQUEST["generador"]:"";

if(isset($_REQUEST["ano"])){
	$ano = $_REQUEST["ano"];
}else{
	$ano = date("Y");
}
if(isset($_REQUEST["dia"])){
	$dia = $_REQUEST["dia"];
}else{
	$dia = "";
}
if(isset($_REQUEST["mes"])){
	$mes = $_REQUEST["mes"];
}else{
	$mes = date("m");
}
			
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
    include("../principal/conectar_ram_web.php");
	if(strlen($dia) == 1)
		$dia = '0'.$dia;
	if(strlen($mes) == 1)
		$mes = '0'.$mes;
	$IpUsuario=	str_replace('.','',$REMOTE_ADDR);
	$NombreTabla1="tmp_table".$IpUsuario;
		
?>
<html>

<head>
    <title>Informe Diario</title>
</head>

<body>
    <form name="frm1" action="" method="post">

        <table width="400" border="0" align="center">
            <tr class="ColorTabla01">
                <td align="center" colspan="8">INFORME DIARIO RECEPCION Y MEZCLA</td>
            </tr>
            <tr class="ColorTabla02">
                <td align="center" colspan="8">FECHA: <?php echo $dia.'/'.$mes.'/'.$ano ?></td>
            </tr>
        </table><br>
        <?php	
$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';
$fecha_ter = $ano.'-'.$mes.'-'.$dia.' 23:59:59';

$fecha_i = $ano.'-'.$mes.'-'.$dia.' 08:00:00';
$fecha_t = date("Y-m-d",mktime(7,59,59,$mes,($dia + 1),$ano))." 07:59:59";

$fecha = $ano.'-'.$mes.'-'.$dia;
$arreglo = array();
$arreglo2 = array();
?>

        <?php

//*********************************************************** cod_conjunto = 1 - rango 1
$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;

   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';
  
	  $Consulta = "CREATE TEMPORARY TABLE IF NOT EXISTS  `".$NombreTabla1."` (";
	  $Consulta.= " cod_existencia char(2) NOT NULL DEFAULT '0' , ";
		$Consulta.= " num_conjunto varchar(6) NOT NULL DEFAULT '0' , ";
		$Consulta.= " conjunto_destino varchar(6) NOT NULL DEFAULT '0' , ";
		//$Consulta.= " fecha_movimiento datetime NOT NULL DEFAULT '0000-00-00 00:00:00' , ";
		$Consulta.= " fecha_movimiento datetime NOT NULL DEFAULT CURRENT_TIMESTAMP , ";
		$Consulta.= " peso_humedo double NOT NULL DEFAULT '0' , ";
		$Consulta.= " estado_validacion double NOT NULL DEFAULT '0' , ";
		$Consulta.= " PRIMARY KEY (cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Consulta.= " UNIQUE KEY Ind02 (cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Consulta.= " KEY Ind01 (num_conjunto,conjunto_destino)) AS";
	 
	  $Consulta.= " SELECT cod_existencia, num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo, cod_validacion as estado_validacion";
	  $Consulta = $Consulta." FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 1 AND peso_humedo > 0";
      $Consulta = $Consulta." AND fecha_movimiento" ;
      $Consulta = $Consulta." BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'  AND  num_conjunto ";
      $Consulta = $Consulta." BETWEEN '1000' AND '8999'";		
	  $rs = mysqli_query($link, $Consulta);

	  $Consulta = "SELECT cod_existencia, num_conjunto, conjunto_destino,fecha_movimiento, peso_humedo_movido, estado_validacion FROM ram_web.movimiento_conjunto ";
      $Consulta = $Consulta." WHERE cod_conjunto = 1 AND peso_humedo_movido > 0  ";
      $Consulta = $Consulta." AND cod_existencia != 15";		
	  $Consulta = $Consulta." AND num_conjunto BETWEEN '1000' AND '8999' AND fecha_movimiento ";
      $Consulta = $Consulta." BETWEEN '".$fecha_i."' AND '".$fecha_t."'";		
	  	
      $rs = mysqli_query($link, $Consulta);
	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Insertar = "INSERT INTO ".$NombreTabla1." (cod_existencia,num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo,estado_validacion)";
			$Insertar = "$Insertar VALUES ($row[cod_existencia],$row[num_conjunto],$row[conjunto_destino],'$row[fecha_movimiento]',$row[peso_humedo_movido],$row[estado_validacion])";
			mysqli_query($link, $Insertar);
	  }

	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM ".$NombreTabla1." ORDER by num_conjunto,conjunto_destino DESC";
	  $rs = mysqli_query($link, $Consulta);

	  $fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';
	  $fecha_ini_mov = $ano.'-'.$mes.'-'.$dia.' 08:00:00';		
	  $fecha_ter_mov = date("Y-m-d",mktime(7,59,59,$mes,($dia + 1),$ano))." 07:59:59";
		
	  while ($row = mysqli_fetch_array($rs))	  
      {
		$Encontrado = "";
			
		if($row["num_conjunto"] == $row["conjunto_destino"])
		{
			$Consulta="SELECT * FROM ".$NombreTabla1." WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino <> $row[num_conjunto]";
			$Consulta.=" AND ((fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and ( cod_existencia =02 or cod_existencia =13))";
			$Consulta.=" or (fecha_movimiento BETWEEN '".$fecha_ini_mov."' AND '".$fecha_ter_mov."' and ( cod_existencia=05 or cod_existencia =12 or cod_existencia =15)))";
			
			$rs0 = mysqli_query($link, $Consulta);
			if($row0 = mysqli_fetch_array($rs0))
			{
				$Encontrado = "S";
			}
			else 
			{
				$Encontrado = "N";
			}
		}
		else	
		{
				$Encontrado = "N";
		}

        if($Encontrado == "N")
		{
				//Descripcion				
				$Consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = 1 AND num_conjunto = $row[num_conjunto] and estado <> 'f' ";
				$rs1 = mysqli_query($link, $Consulta);
				if($row1 = mysqli_fetch_array($rs1))
				{
 				echo '<tr>';
					echo '<td>'.$row1["cod_conjunto"].'-'.$row["num_conjunto"].' '.$row1["descripcion"].'</td>';
					$peso_ini = 0;
					$peso_recep = 0;
					$peso_final = 0;
					$peso_trasp = 0;
					$peso_benef = 0;
					$peso_val = 0;
					//CONJUNTO DESTINO
					$Consulta = "SELECT MAX(conjunto_destino) as conj_destino ";
					$Consulta.= " FROM ram_web.movimiento_proveedor ";
					$Consulta.= " WHERE  num_conjunto = ".$row["num_conjunto"]." ";
					$Consulta.= " AND conjunto_destino != ".$row["num_conjunto"]." ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";							
					$rs_c = mysqli_query($link, $Consulta);							
					if($row_c = mysqli_fetch_array($rs_c))
					{
						$conj_destino = $row_c["conj_destino"];	
					}
					//---------------------------------------------------------------------------------
					//Existencia Ini, Recepcion, Existencia Final
					$Consulta = " SELECT cod_existencia, ";
					$Consulta.= " case when (cod_existencia = 13 AND num_conjunto = ".$row["num_conjunto"]."  ";
					$Consulta.= "    AND (conjunto_destino = ".$row["num_conjunto"]." OR conjunto_destino = ".$row["conjunto_destino"].")) then sum(peso_humedo) else 0 end AS peso_ini, ";
					$Consulta.= " case when (cod_existencia = 2  AND num_conjunto = ".$row["num_conjunto"]." ";
					$Consulta.= "    AND conjunto_destino = ".$row["num_conjunto"]." )                          then sum(peso_humedo) else 0 end AS peso_recep, ";
					$Consulta.= " case when (cod_existencia = 1  AND num_conjunto = ".$row["num_conjunto"].")   then sum(peso_humedo) else 0 end AS peso_final ";
					$Consulta.= " FROM ".$NombreTabla1."";
					$Consulta.= " WHERE (cod_existencia = 1 or cod_existencia = 2 or cod_existencia = 13) ";
					$Consulta.= " AND num_conjunto = ".$row["num_conjunto"]." ";
					$Consulta.= " AND (conjunto_destino = ".$row["num_conjunto"]." OR conjunto_destino = ".$row["conjunto_destino"].") ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
					$Consulta.= " group by cod_existencia, num_conjunto  ";
					$rs2 = mysqli_query($link, $Consulta);
					//Traspaso, Benef Dir., Validacion
					$Consulta = "SELECT cod_existencia, case when (cod_existencia = 6 or cod_existencia = 15 or cod_existencia = 16) then sum(peso_humedo) end AS peso_trasp, ";
					$Consulta.= " case when (cod_existencia = 5)  then sum(peso_humedo) end AS peso_benef, ";
					$Consulta.= " case when (cod_existencia = 6 OR cod_existencia = 16 OR cod_existencia = 5)  then sum(estado_validacion) end AS peso_val ";
					$Consulta.= " FROM ".$NombreTabla1."";
					$Consulta.= " WHERE num_conjunto = ".$row["num_conjunto"]." AND conjunto_destino = ".$row["conjunto_destino"]." ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' ";
					$Consulta.= " AND (cod_existencia = 5 OR cod_existencia = 6 OR cod_existencia = 15 OR cod_existencia = 16) ";
					$Consulta.= " group by cod_existencia";					
					$rs5 = mysqli_query($link, $Consulta);
					if ($row5 = mysqli_fetch_array($rs5))
					{						
						$peso_trasp = $row5["peso_trasp"];
						$peso_benef = $row5["peso_benef"];
						$peso_val = $row5["peso_val"];
					}			
					while ($row2 = mysqli_fetch_array($rs2))
					{
						if (intval($row2["cod_existencia"]) == 13) 
							$peso_ini = $row2["peso_ini"];
						if (intval($row2["cod_existencia"]) == 2) 
							$peso_recep = $row2["peso_recep"];
						if (intval($row2["cod_existencia"]) == 1) 
							$peso_final = $row2["peso_final"];
					}					
					//----------------------------------------------------------------------------------
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_ini = $row2[peso_ini];
						$Total_ini = $Total_ini + $peso_ini;		
						echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
					}
					elseif($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"])
					{
						echo '<td align="right">0,000</td>';
					}
					if($row["num_conjunto"] == $row["conjunto_destino"])
					{
						//$peso_ini = $row2[peso_ini];
						$Total_ini = $Total_ini + $peso_ini;		
						echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
					}
					//Recepcion
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_recep = $row3[peso_recep];
						$Total_recep = $Total_recep + $peso_recep;		                         
						
						$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=02&Conjunto=".$row["num_conjunto"]."&Fecha=".$ano."-".$mes."-".$dia);
						if($peso_recep != 0)
						  echo "<td align='right'>".number_format($peso_recep/1000,3,",","")."</td>";
						else
						  echo '<td align="right">0,000</td>';
					}
					elseif($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"])
					{
						echo '<td align="right">0,000</td>';							
					}
					if($row["num_conjunto"] == $row["conjunto_destino"])
					{							
						//$peso_recep = $row3[peso_recep];
						$Total_recep = $Total_recep + $peso_recep;		                         

						$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=02&Conjunto=".$row["num_conjunto"]."&Fecha=".$ano."-".$mes."-".$dia);
						if($peso_recep != 0)
						  echo "<td align='right'>".number_format($peso_recep/1000,3,",","")."</td>";
						else
						  echo '<td align="right">0,000</td>';
					}
					//Mezcla
					$Consulta ="SELECT conjunto_destino FROM ".$NombreTabla1." WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 12";
					$rs4 = mysqli_query($link, $Consulta);
					
					if($row4 = mysqli_fetch_array($rs4))
					{
						$conjunto_destino = $row4["conjunto_destino"];		
						echo '<td align="right">'.$conjunto_destino.'</td>';
					}
					else
					{
						$conjunto_destino = $row["conjunto_destino"];		
						echo '<td align="right">'.$conjunto_destino.'</td>';				
					}
			   							
					//$peso_trasp = $row5[peso_trasp];	
					$Total_trasp = $Total_trasp + $peso_trasp;		
					
					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=06&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_trasp != 0)				
						echo "<td align='right'>".number_format($peso_trasp/1000,3,",","")."</td>";
					else
						echo '<td align="right">0,000</td>';
						
					//Benef. Dir.
					//$peso_benef = $row5[peso_benef];	
					$Total_benef = $Total_benef + $peso_benef;		
					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=05&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_benef != 0)				
						echo "<td align='right'>".number_format($peso_benef/1000,3,",","")."</td>";
					else
						echo '<td align="right">0,000</td>';
		
					//Validaci�n 										
					//$peso_val = $row5[peso_val];
					$Total_val = $Total_val + $peso_val;		                         
					
					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=21&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_val != 0)
						echo "<td align='right'>".number_format($peso_val/1000,3,",","")."</td>";
					else
					  echo '<td align="right">0,000</td>';
			
					//Existencia Final
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_final = $row6[peso_final];
						$Total_exist = $Total_exist + $peso_final;
						echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
					}
					elseif($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"])
					{
						echo '<td align="right">0,000</td>';							
					}
					if($row["num_conjunto"] == $row["conjunto_destino"])
					{
						//$peso_final = $row6[peso_final];
						$Total_exist = $Total_exist + $peso_final;
						echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
					}				
				echo '</tr>';
				}   			
		
		  } 
	 }	
	  echo '<tr class="ColorTabla02">';
		echo '<td>SubTotales</td>';
		echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
		echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
	  echo '</tr>';	
	echo '</table><br>';

//**************************************************** cod_conjunto = 1  - rango 2
$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;
   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';			
		
	  $Crear_Tabla = "CREATE TEMPORARY TABLE `tmp_table2` (";
	//$Crear_Tabla = "CREATE TEMPORARY TABLE `tmp_table2` (key ind01(num_conjunto,conjunto_destino)) as ";
$Crear_Tabla.= " cod_existencia char(2) NOT NULL DEFAULT '0' , ";
		$Crear_Tabla.= " num_conjunto varchar(6) NOT NULL DEFAULT '0' , ";
		$Crear_Tabla.= " conjunto_destino varchar(6) NOT NULL DEFAULT '0' , ";
		//$Crear_Tabla.= " fecha_movimiento datetime NOT NULL DEFAULT '0000-00-00 00:00:00' , ";
		$Crear_Tabla.= " fecha_movimiento datetime NOT NULL DEFAULT CURRENT_TIMESTAMP , ";
		$Crear_Tabla.= " peso_humedo double NOT NULL DEFAULT '0' , ";
		$Crear_Tabla.= " estado_validacion double NOT NULL DEFAULT '0' , ";
		$Crear_Tabla.= " PRIMARY KEY (cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Crear_Tabla.= " UNIQUE KEY Ind02 (cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
		$Crear_Tabla.= " KEY Ind01 (num_conjunto,conjunto_destino)) AS";
	 
	  $Crear_Tabla.= " SELECT cod_existencia, num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo, cod_validacion as estado_validacion";
	  $Crear_Tabla.= " FROM ram_web.movimiento_proveedor ";
	  $Crear_Tabla.= " WHERE cod_conjunto = 1";
	  $Crear_Tabla.= " AND peso_humedo > 0  ";
	  $Crear_Tabla.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
	  $Crear_Tabla.= " AND num_conjunto BETWEEN '9000' AND '9999' ";
	  $Crear_Tabla.= " ORDER BY num_conjunto,fecha_movimiento ASC";
	  mysqli_query($link, $Crear_Tabla);
	  
	  $Consulta = "SELECT cod_existencia, num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo_movido, estado_validacion FROM ram_web.movimiento_conjunto WHERE cod_conjunto = 1 AND peso_humedo_movido > 0
	  AND num_conjunto BETWEEN '9000' AND '9999' AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
      $Consulta = $Consulta." AND cod_existencia != 15";		
	  $rs = mysqli_query($link, $Consulta);
	  
	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Insertar = "INSERT INTO tmp_table2 (cod_existencia,num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo, estado_validacion)";
			$Insertar = "$Insertar VALUES ($row[cod_existencia],$row[num_conjunto],$row[conjunto_destino],'$row[fecha_movimiento]',$row[peso_humedo_movido],$row[estado_validacion])";
			mysqli_query($link, $Insertar);
	  }

	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM tmp_table2 ORDER by num_conjunto,conjunto_destino DESC";
	  $rs = mysqli_query($link, $Consulta);	  

	  $fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';		
	  while ($row = mysqli_fetch_array($rs))	  
      {

		$Encontrado = "";			

		if($row["num_conjunto"] == $row["conjunto_destino"])
		{
			$Consulta = "SELECT * FROM tmp_table2 WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino <> $row[num_conjunto]
			AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs0 = mysqli_query($link, $Consulta);
			if($row0 = mysqli_fetch_array($rs0))
			{
				$Encontrado = "S";
			}
			else 
			{
				$Encontrado = "N";
			}
		}
		else	
		{
				$Encontrado = "N";
		}

		if($Encontrado == "N")
		{
				//Descripcion
                 $Consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = 1 AND num_conjunto = $row[num_conjunto] and estado <> 'f'";
				$rs1 = mysqli_query($link, $Consulta);
		
				if($row1 = mysqli_fetch_array($rs1))
				{
					echo '<tr>';
					echo '<td>'.$row1["cod_conjunto"].'-'.$row["num_conjunto"].' '.$row1["descripcion"].'</td>';
					$peso_ini = 0;
					$peso_recep = 0;
					$peso_final = 0;
					$peso_trasp = 0;
					$peso_benef = 0;
					$peso_val = 0;
					//CONJUNTO DESTINO
					$Consulta = "SELECT MAX(conjunto_destino) as conj_destino ";
					$Consulta.= " FROM tmp_table2 ";
					$Consulta.= " WHERE  num_conjunto = ".$row["num_conjunto"]." ";
					$Consulta.= " AND conjunto_destino != ".$row["num_conjunto"]." ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";							
					$rs_c = mysqli_query($link, $Consulta);							
					if($row_c = mysqli_fetch_array($rs_c))
					{
						$conj_destino = $row_c["conj_destino"];	
					}
					//---------------------------------------------------------------------------------
					//Existencia Ini, Recepcion, Existencia Final
					$Consulta = " SELECT cod_existencia, ";
					$Consulta.= " case when (cod_existencia = 13 AND num_conjunto = ".$row["num_conjunto"]."  ";
					$Consulta.= "    AND (conjunto_destino = ".$row["num_conjunto"]." OR conjunto_destino = ".$row["conjunto_destino"].")) then sum(peso_humedo) else 0 end AS peso_ini, ";
					$Consulta.= " case when (cod_existencia = 2  AND num_conjunto = ".$row["num_conjunto"]." ";
					$Consulta.= "    AND conjunto_destino = ".$row["num_conjunto"]." )                          then sum(peso_humedo) else 0 end AS peso_recep, ";
					$Consulta.= " case when (cod_existencia = 1  AND num_conjunto = ".$row["num_conjunto"].")   then sum(peso_humedo) else 0 end AS peso_final ";
					$Consulta.= " FROM tmp_table2 ";
					$Consulta.= " WHERE (cod_existencia = 1 or cod_existencia = 2 or cod_existencia = 13) ";
					$Consulta.= " AND num_conjunto = ".$row["num_conjunto"]." ";
					$Consulta.= " AND (conjunto_destino = ".$row["num_conjunto"]." OR conjunto_destino = ".$row["conjunto_destino"].") ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
					$Consulta.= " group by cod_existencia, num_conjunto  ";
					$rs2 = mysqli_query($link, $Consulta);
					while ($row2 = mysqli_fetch_array($rs2))
					{
						if (intval($row2["cod_existencia"]) == 13) 
							$peso_ini = $row2["peso_ini"];
						if (intval($row2["cod_existencia"]) == 2) 
							$peso_recep = $row2["peso_recep"];
						if (intval($row2["cod_existencia"]) == 1) 
							$peso_final = $row2["peso_final"];
					}					
					//----------------------------------------------------------------------------------
					//Existencia Inicial							
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_ini = $row2[peso_ini];
						$Total_ini = $Total_ini + $peso_ini;		
						echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
					}
					elseif($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"])
					{
						echo '<td align="right">0,000</td>';
					}
					if($row["num_conjunto"] == $row["conjunto_destino"])
					{
						//$peso_ini = $row2[peso_ini];
						$Total_ini = $Total_ini + $peso_ini;		
						echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
					}
					
					//Recepcion
					
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_recep = $row3[peso_recep];
						$Total_recep = $Total_recep + $peso_recep;		                         
						
						$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=02&Conjunto=".$row["num_conjunto"]."&Fecha=".$ano."-".$mes."-".$dia);
						if($peso_recep != 0)
						  echo "<td align='right'>".number_format($peso_recep/1000,3,",","")."</td>";
						else
						  echo '<td align="right">0,000</td>';
					}
					elseif($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"])
					{
						echo '<td align="right">0,000</td>';							
					}
					if($row["num_conjunto"] == $row["conjunto_destino"])
					{
						//$peso_recep = $row3[peso_recep];
						$Total_recep = $Total_recep + $peso_recep;		                         

						$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=02&Conjunto=".$row["num_conjunto"]."&Fecha=".$ano."-".$mes."-".$dia);
						if($peso_recep != 0)
						  echo "<td align='right'>".number_format($peso_recep/1000,3,",","")."</td>";
						else
						  echo '<td align="right">0,000</td>';
					}
					
					//Mezcla
					$Consulta ="SELECT conjunto_destino FROM tmp_table2 WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 12";
					$rs4 = mysqli_query($link, $Consulta);
					if($row4 = mysqli_fetch_array($rs4))
					{
						$conjunto_destino = $row4["conjunto_destino"];		
						echo '<td align="right">'.$conjunto_destino.'</td>';
					}
					else
					{
						$conjunto_destino = $row["conjunto_destino"];		
						echo '<td align="right">'.$conjunto_destino.'</td>';				
					}
			   
					//Traspaso, Benef Dir., Validacion
					$Consulta = "SELECT cod_existencia, case when (cod_existencia = 6 or cod_existencia = 15 or cod_existencia = 16) then sum(peso_humedo) end AS peso_trasp, ";
					$Consulta.= " case when (cod_existencia = 5)  then sum(peso_humedo) end AS peso_benef, ";
					$Consulta.= " case when (cod_existencia = 6 OR cod_existencia = 16 OR cod_existencia = 5)  then sum(estado_validacion) end AS peso_val ";
					$Consulta.= " FROM tmp_table2   ";
					$Consulta.= " WHERE num_conjunto = ".$row["num_conjunto"]." AND conjunto_destino = ".$row["conjunto_destino"]." ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' ";
					$Consulta.= " AND (cod_existencia = 5 OR cod_existencia = 6 OR cod_existencia = 15 OR cod_existencia = 16) ";
					$Consulta.= " group by cod_existencia";					
					$rs5 = mysqli_query($link, $Consulta);
					if ($row5 = mysqli_fetch_array($rs5))
					{						
						$peso_trasp = $row5["peso_trasp"];
						$peso_benef = $row5["peso_benef"];
						$peso_val = $row5["peso_val"];
					}
					//$peso_trasp = $row5[peso_trasp];	
					$Total_trasp = $Total_trasp + $peso_trasp;		
	
					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=06&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_trasp != 0)				
						echo "<td align='right'>".number_format($peso_trasp/1000,3,",","")."</td>";
					else
						echo '<td align="right">0,000</td>';
		
					//Benef. Dir.				
					//$peso_benef = $row6[peso_benef];	
					$Total_benef = $Total_benef + $peso_benef;		
					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=05&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_benef != 0)				
						echo "<td align='right'>".number_format($peso_benef/1000,3,",","")."</td>";
					else
						echo '<td align="right">0,000</td>';
		
					//Validaci�n 
					//$peso_val = $row6[peso_val];
					$Total_val = $Total_val + $peso_val;		                         
					
					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=21&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_val != 0)
						echo "<td align='right'>".number_format($peso_val/1000,3,",","")."</td>";
					else
					  echo '<td align="right">0,000</td>';
					
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_final = $row6[peso_final];
						$Total_exist = $Total_exist + $peso_final;
						echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
					}
					elseif($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"])
					{
						echo '<td align="right">0,000</td>';							
					}
					if($row["num_conjunto"] == $row["conjunto_destino"])
					{
						//$peso_final = $row6[peso_final];
						$Total_exist = $Total_exist + $peso_final;
						echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
					}
	
				echo '</tr>';
				
				}   			
		
		  } 
	 }	
	  echo '<tr class="ColorTabla02">';
		echo '<td>SubTotales</td>';
		echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
		echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
	  echo '</tr>';
	echo '</table><br>';

//*********************************** cod_conjunto = 3 *** CIRCULANTES ***

$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;

   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';			
		
	  $Crear_Tabla = " CREATE TEMPORARY TABLE IF NOT EXISTS ram_web.tmp_table3 ( ";
	  $Crear_Tabla.= " cod_existencia char(2) NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " num_conjunto varchar(6) NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " conjunto_destino varchar(6) NOT NULL DEFAULT '0' , ";
	  //$Crear_Tabla.= " fecha_movimiento datetime NOT NULL DEFAULT '0000-00-00 00:00:00' , ";
		$Crear_Tabla.= " fecha_movimiento datetime NOT NULL DEFAULT CURRENT_TIMESTAMP , ";
	  $Crear_Tabla.= " peso_humedo double NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " estado_validacion char(2) NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " PRIMARY KEY (cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
	  $Crear_Tabla.= " UNIQUE KEY Ind02 (cod_existencia,conjunto_destino,num_conjunto,fecha_movimiento), ";
	  $Crear_Tabla.= "  KEY Ind01 (num_conjunto,conjunto_destino))  ";
	  $Crear_Tabla.= " AS SELECT cod_existencia,num_conjunto,conjunto_destino,fecha_movimiento,";
	  $Crear_Tabla.= " peso_humedo,cod_existencia as estado_validacion ";
	  $Crear_Tabla.= " FROM ram_web.movimiento_proveedor ";
	  $Crear_Tabla.= " WHERE cod_conjunto = '03' AND peso_humedo > 0 ";
	  $Crear_Tabla.= " AND cod_existencia != '15'"; 	
	  $Crear_Tabla.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
	  $Crear_Tabla.= " order by num_conjunto,fecha_movimiento ASC ";	  
	  $rs = mysqli_query($link, $Crear_Tabla);

	  $Consulta = "SELECT cod_existencia,num_conjunto,conjunto_destino,fecha_movimiento,";
	  $Consulta.= " peso_humedo_movido,estado_validacion FROM ram_web.movimiento_conjunto ";
	  $Consulta.= " WHERE cod_conjunto = '03' AND peso_humedo_movido > 0";
	  $Consulta.= " AND cod_existencia != '03' AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."'";	  
	  $rs = mysqli_query($link, $Consulta);
	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Insertar = "INSERT INTO ram_web.tmp_table3 (cod_existencia,num_conjunto, conjunto_destino, fecha_movimiento, peso_humedo, estado_validacion)";
			$Insertar.= " VALUES ('".$row["cod_existencia"]."', '".$row["num_conjunto"]."', '".$row["conjunto_destino"]."', ";
			$Insertar.= " '".$row["fecha_movimiento"]."', '".$row["peso_humedo_movido"]."', '".$row["estado_validacion"]."')";
			mysqli_query($link, $Insertar);
	  }

	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino ";
	  $Consulta.= " FROM ram_web.tmp_table3 ORDER by num_conjunto,conjunto_destino DESC";
	  $rs = mysqli_query($link, $Consulta);	  
  	  $fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';     
	  while ($row = mysqli_fetch_array($rs))	  
      {
		$Encontrado = "";			
		$cod_existencia = "";
		$Entro = "";
		if($row["num_conjunto"] == $row["conjunto_destino"])
		{
			$Consulta = "SELECT * FROM ram_web.tmp_table3 ";
			$Consulta.= " WHERE cod_existencia = '06' AND num_conjunto = '".$row["num_conjunto"]."'";
			$Consulta.= " AND conjunto_destino = '".$row["num_conjunto"]."' ";
			$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs10 = mysqli_query($link, $Consulta);
			if($row10 = mysqli_fetch_array($rs10))
			{
				$Encontrado = "N";			
				$Consulta = "SELECT * FROM ram_web.tmp_table3 ";
				$Consulta.= " WHERE num_conjunto = '".$row["num_conjunto"]."' AND conjunto_destino<>'".$row["num_conjunto"]."' ";
				$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs11 = mysqli_query($link, $Consulta);
				if($row11 = mysqli_fetch_array($rs11))
					$cod_existencia = "06";		
				else
					$cod_existencia = "";		
			}
			else
			{
				$Consulta = "SELECT * FROM ram_web.tmp_table3 ";
				$Consulta.= " WHERE num_conjunto = '".$row["num_conjunto"]."' AND conjunto_destino<>'".$row["num_conjunto"]."'";
				$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$rs0 = mysqli_query($link, $Consulta);
				if($row0 = mysqli_fetch_array($rs0))
					$Encontrado = "S";				
				else 
					$Encontrado = "N";
			}
		}
		else	
		{
			$Encontrado = "N";
		}

		if($Encontrado == "N")
		{
				//Descripcion
				$Consulta = "SELECT * FROM ram_web.conjunto_ram ";
				$Consulta.= " where cod_conjunto = '03' AND num_conjunto = '".$row["num_conjunto"]."'  AND estado != 'f'"; 
				$rs1 = mysqli_query($link, $Consulta);
				if($row1 = mysqli_fetch_array($rs1))
				{
					echo '<tr>';
					echo '<td>'.$row1["cod_conjunto"].'-'.$row["num_conjunto"].' '.$row1["descripcion"].'</td>';
					$peso_ini = 0;
					$peso_recep = 0;
					$peso_final = 0;
					$peso_trasp = 0;
					$peso_benef = 0;
					$peso_val = 0;
					//CONJUNTO DESTINO
					$Consulta = "SELECT MAX(conjunto_destino) as conj_destino ";
					$Consulta.= " FROM ram_web.tmp_table3 ";
					$Consulta.= " WHERE  num_conjunto = '".$row["num_conjunto"]."' ";
					$Consulta.= " AND conjunto_destino != '".$row["num_conjunto"]."' ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";							
					$rs_c = mysqli_query($link, $Consulta);							
					if($row_c = mysqli_fetch_array($rs_c))
						$conj_destino = $row_c["conj_destino"];	
					//---------------------------------------------------------------------------------					
					//Existencia Ini, Recepcion, Existencia Final
					$Consulta = " SELECT cod_existencia, ";
					$Consulta.= " case when (cod_existencia = '13' AND num_conjunto = '".$row["num_conjunto"]."'  ";
					$Consulta.= "    AND (conjunto_destino = '".$row["num_conjunto"]."' OR conjunto_destino = '".$row["conjunto_destino"]."')) then peso_humedo else 0 end AS peso_ini, ";					
					$Consulta.= " case when (cod_existencia = '01'  AND num_conjunto = '".$row["num_conjunto"]."' ";
					$Consulta.= "    AND conjunto_destino = '".$row["num_conjunto"]."') then peso_humedo else 0 end AS peso_final ";
					$Consulta.= " FROM ram_web.tmp_table3 ";
					$Consulta.= " WHERE (cod_existencia = '01' or cod_existencia = '13') ";
					$Consulta.= " AND num_conjunto = '".$row["num_conjunto"]."' ";
					$Consulta.= " AND (conjunto_destino = '".$row["num_conjunto"]."' OR conjunto_destino = '".$row["conjunto_destino"]."') ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
					//$Consulta.= " group by cod_existencia, num_conjunto  ";
					$rs2 = mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";
					$peso_ini = 0;
					$peso_final = 0;
					while ($row2 = mysqli_fetch_array($rs2))
					{
						if (intval($row2["cod_existencia"]) == "13") 
							$peso_ini = $peso_ini + $row2["peso_ini"];
						if (intval($row2["cod_existencia"]) == "01") 
							$peso_final = $peso_final + $row2["peso_final"];
					}
					//Existencia Ini					
						
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_ini = $row2[peso_ini];
						$Total_ini = $Total_ini + $peso_ini;		
						echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
					}
					elseif(($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"]) || $cod_existencia == "06")
					{
						echo '<td align="right">0,000</td>';
 					    $Entro = "S";							
					}
					if($row["num_conjunto"] == $row["conjunto_destino"] && $Entro != "S")
					{
						//$peso_ini = $row2[peso_ini];
						$Total_ini = $Total_ini + $peso_ini;		
						echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
					}
					
					//Recepcion
					$Consulta = "SELECT sum(peso_humedo + estado_validacion) AS peso_recep ";
					$Consulta.= " from ram_web.tmp_table3 ";
					$Consulta.= " where ((num_conjunto = '".$row["num_conjunto"]."' ";
					$Consulta.= " AND conjunto_destino = '".$row["num_conjunto"]."' ";
					$Consulta.= " AND cod_existencia = '02' ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."')";
					$Consulta.= " OR (conjunto_destino = '".$row["num_conjunto"]."'   AND cod_existencia = '15' ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."'))";
					$rs3 = mysqli_query($link, $Consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{		
						if($conj_destino == $row["conjunto_destino"])
						{
							$peso_recep = $row3["peso_recep"];
							$Total_recep = $Total_recep + $peso_recep;		                         
							
						    $Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=17&Conjunto=".$row["num_conjunto"]."&ano=".$ano."&mes=".$mes."&dia=".$dia);
							if($peso_recep != 0)
							  echo "<td align='right'>".number_format($peso_recep/1000,3,",","")."</td>";
							else
								echo '<td align="right">0,000</td>';
						}
						elseif(($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"]) || $cod_existencia == "06")
						{
							echo '<td align="right">0,000</td>';
						}
						if($row["num_conjunto"] == $row["conjunto_destino"] && $Entro != "S")
						{
							$peso_recep = $row3["peso_recep"];
							$Total_recep = $Total_recep + $peso_recep;		                         

						    $Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=17&Conjunto=".$row["num_conjunto"]."&ano=".$ano."&mes=".$mes."&dia=".$dia);
							if($peso_recep != 0)
							  echo "<td align='right'>".number_format($peso_recep/1000,3,",","")."</td>";
							else
								echo '<td align="right">0,000</td>';
						}

					}
					
					//Mezcla
					$Consulta = "SELECT conjunto_destino FROM ram_web.tmp_table3 ";
					$Consulta.= " WHERE num_conjunto = '".$row["num_conjunto"]."' AND conjunto_destino = '".$row["conjunto_destino"]."'";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = '12'";
					$rs4 = mysqli_query($link, $Consulta);
					if($row4 = mysqli_fetch_array($rs4))
					{
						$conjunto_destino = $row4["conjunto_destino"];		
						echo '<td align="right">'.$conjunto_destino.'</td>';
					}
					else
					{
						$conjunto_destino = $row["conjunto_destino"];		
						echo '<td align="right">'.$conjunto_destino.'</td>';				
					}			   
					//Traspaso 
					$Consulta = "SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto ";
					$Consulta.= " WHERE num_conjunto = '".$row["num_conjunto"]."' AND conjunto_destino = '".$row["conjunto_destino"]."' ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' ";
					$Consulta.= " AND (cod_existencia = '06' OR cod_existencia = '15')AND (cod_lugar_destino <= '12' OR cod_lugar_destino >= '26')";
					$rs5 = mysqli_query($link, $Consulta);
					if($row5 = mysqli_fetch_array($rs5))
					{
						$peso_trasp = $row5["peso_trasp"];	
						$Total_trasp = $Total_trasp + $peso_trasp;		

						$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=15&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
						if($peso_trasp != 0)				
							echo "<td align='right'>".number_format($peso_trasp/1000,3,",","")."</td>";
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Benef. Dir.	
					/*$Consulta ="SELECT cod_existencia, peso_humedo AS peso_benef ";
					$Consulta.= " FROM ram_web.tmp_table3";
					$Consulta.= " WHERE num_conjunto = '".$row["num_conjunto"]."' ";
					$Consulta.= " AND conjunto_destino = '".$row["conjunto_destino"]."' ";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' ";
					$Consulta.= " AND (cod_existencia='05' OR cod_existencia='16' OR cod_existencia='06')";
					//$Consulta.= " group by cod_existencia ";*/
					$Consulta ="SELECT cod_existencia, peso_humedo_movido AS peso_benef ";
					$Consulta.= " FROM ram_web.movimiento_conjunto ";
					$Consulta.= " WHERE num_conjunto = '".$row["num_conjunto"]."' ";
					$Consulta.= " AND conjunto_destino = '".$row["conjunto_destino"]."' ";
					$Consulta.= "  AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
					$Consulta.= "  AND (cod_existencia = '05' OR cod_existencia = '16' OR cod_existencia = '06')";					
					$rs6 = mysqli_query($link, $Consulta);
					$peso_benef=0;
					while ($row6 = mysqli_fetch_array($rs6))
					{
						$peso_benef = $peso_benef + $row6["peso_benef"];															
					}
					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=05&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					$Total_benef = $Total_benef + $peso_benef;
					if($peso_benef != 0)				
						echo "<td align='right'>".number_format($peso_benef/1000,3,",","")."</td>";
					else
						echo '<td align="right">0,000</td>';
					//Validaci�n 
					$Consulta ="SELECT sum(estado_validacion) AS peso_val ";
					$Consulta.= " FROM ram_web.movimiento_conjunto ";
					$Consulta.= " WHERE num_conjunto = '".$row["num_conjunto"]."' ";
					$Consulta.= " AND conjunto_destino = '".$row["conjunto_destino"]."' ";
					$Consulta.= "  AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
					$Consulta.= "  AND (cod_existencia = '05' OR cod_existencia = '06' OR cod_existencia = '15')";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{
						$peso_val = $row6["peso_val"];
						$Total_val = $Total_val + $peso_val;		
						$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=22&Conjunto=".$row["num_conjunto"]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
						if($peso_val != 0)
							echo "<td align='right'>".number_format($peso_val/1000,3,",","")."</td>";
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Existencia Final					
					if($conj_destino == $row["conjunto_destino"])
					{
						//$peso_final = $row6[peso_final];
						$Total_exist = $Total_exist + $peso_final;
						echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
					}
					elseif(($conj_destino != $row["conjunto_destino"] AND $row["num_conjunto"] != $row["conjunto_destino"]) || $cod_existencia == "06")
					{
						echo '<td align="right">0,000</td>';
					}
					if($row["num_conjunto"] == $row["conjunto_destino"] && $Entro != "S")
					{
						//$peso_final = $row6[peso_final];
						$Total_exist = $Total_exist + $peso_final;
						echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
					}
				echo '</tr>';
				//echo "vuelta tabla 2 = ".date("H:i:s")."<br>";
				}   
		    }

	 } 
	  echo '<tr class="ColorTabla02">';
		echo '<td>SubTotales</td>';
		echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
		echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
	  echo '</tr>';
	echo '</table><br>';


//**************************************************************** cod_conjunto = 2
if(strlen($dia) == 1)
	$dia = '0'.$dia;

if(strlen($mes) == 1)
	$mes = '0'.$mes;
	
$fecha_ini = $ano.'-'.$mes.'-'.($dia - 1).' 00:00:00';
$fecha_ter = $ano.'-'.$mes.'-'.$dia.' 23:59:59';

$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;

   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';			

	  $Consulta = "SELECT distinct conjunto_destino FROM ram_web.movimiento_conjunto WHERE cod_conjunto_destino = 2 AND peso_humedo_movido <> 0
				  AND left(fecha_movimiento,10) <= '".$fecha."' ORDER BY conjunto_destino";
	  $rs = mysqli_query($link, $Consulta);
		  
	  while ($row = mysqli_fetch_array($rs))
	  {
		 	$arreglo4[] = array($row["conjunto_destino"]);
	  }
	 // while (list($clave, $valor) = each($arreglo4))
	  foreach ($arreglo4 as $clave=>$valor)	  
      {
			//Descripcion
			$Consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 2 AND num_conjunto = $valor[0]
						 AND estado = 'p'"; 
			$rs1 = mysqli_query($link, $Consulta);
			if($row1 = mysqli_fetch_array($rs1))
			{
				$ano_c = substr($row1["fecha_creacion"],0,4);
				$mes_c = substr($row1["fecha_creacion"],5,2);
				$dia_c = substr($row1["fecha_creacion"],8,2);
				$fecha_creacion = $ano_c.'-'.$mes_c.'-'.$dia_c;

				echo '<tr>';				
				echo '<td>'.$row1["cod_conjunto"].'-'.$valor[0].' '.$row1["descripcion"].'</td>';
					
				$fecha_ini = $ano.'-'.$mes.'-'.$dia;						
				$Consulta ="SELECT sum(peso_humedo_movido + estado_validacion) AS peso_ini FROM ram_web.movimiento_conjunto 
				 WHERE conjunto_destino = $valor[0]  AND cod_existencia <> 15 AND cod_lugar_destino >= 14 
				 AND cod_lugar_destino <= 25 AND FECHA_MOVIMIENTO >='$fecha_creacion'
				 AND FECHA_MOVIMIENTO <'$fecha_ter'";

				$rs2 = mysqli_query($link, $Consulta);
				if($row2 = mysqli_fetch_array($rs2))
				{
					$peso_ini = $row2["peso_ini"];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
				}
				
				//Recepcion
					echo '<td align="right">0,000</td>';
				
				//Mezcla 	
					echo '<td align="right">'.$valor[0].'</td>';				
		   
	
				//Traspaso 
				$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';
				$Consulta ="SELECT sum(peso_humedo_movido + estado_validacion) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE conjunto_destino = $valor[0] and fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 6 || cod_existencia = 5)";
				$rs5 = mysqli_query($link, $Consulta);
	
				if($row5 = mysqli_fetch_array($rs5))
				{
					$peso_trasp = $row5["peso_trasp"];	
					$Total_trasp = $Total_trasp + $peso_trasp;		

					$Valores = str_replace(' ','%20',"ram_con_recep.php?cod_exist=11&Conjunto=".$valor[0]."&Fecha_ini=".$fecha_i."&Fecha_ter=".$fecha_t);
					if($peso_trasp != 0)
					  echo "<td align='right'>".number_format($peso_trasp/1000,3,",","")."</td>";

					else
						echo '<td align="right">0,000</td>';

				}
	
				//Benef Dir	
					echo '<td align="right">0,000</td>';
	
				//Validaci�n 
					echo '<td align="right">0,0000</td>';
				
				//Exist Final
				$peso_final = $peso_ini + $peso_trasp;
				$Total_exist = $Total_exist + $peso_final;				
					echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
	
			echo '</tr>';

		}				   			

    } 
		  echo '<tr class="ColorTabla02">';
            echo '<td>SubTotales</td>';
            echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
            echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
            echo '<td align="right">&nbsp;</td>';
            echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
            echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
            echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
            echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
          echo '</tr>';
        echo '</table><br>';

		echo '<input type="hidden" name="ano" size="4" value="'.$ano.'">';
		echo '<input type="hidden" name="mes" size="4" value="'.$mes.'">';
		echo '<input type="hidden" name="dia" size="4" value="'.$dia.'">';

		echo '<input type="hidden" name="generador" size="4" value="'.$generador.'">';
		
?>

    </form>
</body>

</html>
<?php 
	$Eliminar = "DROP TABLE ".$NombreTabla1." ";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE tmp_table2 ";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE tmp_table3 ";
	mysqli_query($link, $Eliminar);
	include("../principal/cerrar_sea_web.php") 
?>