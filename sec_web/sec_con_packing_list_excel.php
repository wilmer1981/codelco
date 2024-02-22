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
    $FechaInicio= date("Y");

	$DiaIni = $_REQUEST["DiaIni"];
	$MesIni = $_REQUEST["MesIni"];
	$AnoIni = $_REQUEST["AnoIni"];
	$DiaFin = $_REQUEST["DiaFin"];
	$MesFin = $_REQUEST["MesFin"];
	$AnoFin = $_REQUEST["AnoFin"];
	$NumInstruccion = $_REQUEST["NumInstruccion"];
	$EnmCode        = $_REQUEST["EnmCode"];


 	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
	//$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaAux = $FechaInicio;
    $FechaAux1 = $FechaAux - 1;
	$CodLote = 0;
	$NumLote = 0;
	$Corr_enm = ""; //WSO

	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	$Consulta = "SELECT * from sec_web.lote_catodo where corr_enm = '".$NumInstruccion."'";
    $Consulta.= " and (year(fecha_creacion_lote) ='".$FechaAux."'";
    $Consulta.= " or year(fecha_creacion_lote) ='".$FechaAux1."')";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodLote = $Fila["cod_bulto"];
		$NumLote = $Fila["num_bulto"];
		/*poly*/
		$Corr_enm = $Fila["corr_enm"];
	}
	$Instruccion=""; //WSO
	$Producto=""; //WSO
	$SubProducto = ""; //WSO
	$DescProducto=""; //WSO
	$Cliente = ""; //WSO
	if ($CodLote != "0" && $NumLote != "0")
	{
		$Consulta = "SELECT t1.cod_bulto, t1.num_bulto, t1.corr_enm, t2.cod_producto, t2.cod_subproducto,";
		$Consulta.= " t1.cod_marca, t4.descripcion as marca, t1.corr_enm, t3.descripcion ";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t3 ";
		$Consulta.= " on t2.cod_producto = t3.cod_producto and t2.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " left join sec_web.marca_catodos t4 on t1.cod_marca = t4.cod_marca ";
		$Consulta.= " where  t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."'  and t1.corr_enm = '".$Corr_enm."'";
		$Consulta.= " group by t1.cod_bulto, t1.num_bulto ";     
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta;
		/*
		$Instruccion=""; //WSO
		$Producto=""; //WSO
		$SubProducto = ""; //WSO
		$DescProducto=""; //WSO
		$Cliente = ""; //WSO
		*/
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Producto = $Fila["cod_producto"];
			$SubProducto = $Fila["cod_subproducto"];
			$DescProducto = $Fila["descripcion"];
			$Instruccion = $Fila["corr_enm"];
			$CodMarca = $Fila["cod_marca"];
			$Marca = $Fila["marca"];
			if ($EnmCode == "E")
			{
				$Consulta = "SELECT * from sec_web.programa_enami ";
				$Consulta.= " where corr_enm = '".$Fila["corr_enm"]."'";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$Consulta = "SELECT * from sec_web.cliente_venta where cod_cliente = '".$Fila2["cod_cliente"]."'";
					$Respuesta3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$Cliente = strtoupper($Fila3["nombre_cliente"]);
					}
					else
					{
						$Consulta = "SELECT * from sec_web.nave where cod_nave = '".$Fila2["cod_cliente"]."'";
						$Respuesta3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Cliente = strtoupper($Fila3["nombre_nave"]);
						}
					}
				}
			}
			else
			{
				$Cliente = "CODELCO";
			}						
		}
	}
	
		
	$Consulta= "SELECT distinct t3.cod_bulto,t3.num_bulto,t1.lote_origen, t1.recargo, t1.cod_paquete, t1.num_paquete, t2.num_unidades,t2.peso_paquetes,t2.cod_estado,t2.hora";
 	$Consulta.= " FROM sec_web.paquete_catodo_externo AS t1 INNER JOIN sec_web.paquete_catodo AS t2";
	$Consulta.= " inner join sec_web.lote_catodo as t3 ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete ";
	$Consulta.= " and t2.cod_paquete = t3.cod_paquete and t2.num_paquete = t3.num_paquete";
	$Consulta.= " AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.= " and t1.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
	$Consulta.= " AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";	
	$Consulta.= " and t2.fecha_creacion_paquete  = t1.fecha_creacion_paquete";  
	$Consulta.= " where t3.cod_bulto = '".$CodLote."' and t3.num_bulto = '".$NumLote."'  and t3.corr_enm = '".$Corr_enm."' ";
	$Respuestasipa = mysqli_query($link, $Consulta);
	$LoteSipa=""; //WSO
	if ($Filasipa = mysqli_fetch_array($Respuestasipa))
	{
		$LoteSipa = $Filasipa["lote_origen"];
	}
		
	
?>
<html>
<head>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
</head>
  <table width="770" border="0" cellpadding="2" cellspacing="1">
    <tr> 
      <td colspan="4"><font size="1"><strong>CODELCO CHILE - DIVISION VENTANAS</strong><br>
      </font></td>
      <td width="283" align="center"><strong>PACKING LIST<br>
        CODIGO DE LOTE: <?php echo strtoupper($CodLote)."-".$NumLote; ?></strong></td>
      <td width="163" align="center">FECHA: <?php echo date("d/m/Y"); ?></td>
    </tr>
  </table>
  <br>
  <table width="770" border="0" cellpadding="2" cellspacing="1">
    <tr> 
      <td colspan="2" align="center">
	</td>
    </tr>
    <tr> 
      <td width="174">N&ordm; INSTRUCCION: </td>
	  <td><strong><?php echo $NumInstruccion; ?></strong></td>
	</tr>
    <tr> 
      <td>PRODUCTO - SUBPRODUCTO:</td>
      <td><strong><?php echo $Producto." ".$SubProducto; ?></strong></td>
    </tr>
    <tr> 
      <td>DESCRIPCION:</td>
      <td><strong>
	  <?php 
			if ($Producto == '57')
			{
				$Consulta = "SELECT t2.descripcion from sec_web.pesaje_lodos as t1";
				$Consulta.= " inner join proyecto_modernizacion.subproducto as t2";
				$Consulta.= " on t2.cod_producto = t1.cod_producto AND t2.cod_subproducto = t1.cod_subproducto";
				$Consulta.= " where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '12'";
				$Consulta.= " and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' and t1.corr_ie = '".$Corr_enm."'";
				$Consulta.= " and t1.num_pesada = '2'";
				$rs = mysqli_query($link, $Consulta);
				if ($row = mysqli_fetch_array($rs))
				{
					$DescProducto = $row["descripcion"];
				}
			}

	  		echo $DescProducto;
			
			
	  ?>
	  </strong></td>
    </tr>
    <tr> 
      <td>N&ordm; INSTR. DE EMBARQUE</td>
      <td><strong><?php echo $Instruccion; ?></strong></td>
    </tr>
    <tr> 
      <td>CLIENTE</td>
      <td><strong><?php echo $Cliente; ?></strong></td>
    </tr>
	
		<?php
	if ($Instruccion >'900000')
	{
	?>
	    <tr> 
      <td>LOTE SIPA</td>
      <td><strong><?php echo $LoteSipa ?></strong></td>
    </tr>
<?php }?>
	
  </table>  
<br>
  <table width="770" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="64">MARCA</td>
      <td width="161">DESCRIPCION</td>
      <td width="97">PESO NETO</td>
      <td width="101">PESO BRUTO</td>
      <td width="60">GRUPO</td>
      <td width="86">UNIDADES</td>
      <td width="83">UBICACION</td>
      <td width="99">SERIE</td>
    </tr>    
    <?php
	   $Consulta = "SELECT * from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	   $Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	   $Consulta.= " where t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.corr_enm = '".$Corr_enm."'";
	   $Consulta.= " order by t1.cod_paquete,t1. num_paquete ";
	
	   $Respuesta = mysqli_query($link, $Consulta);
	   $TotalPaquetes = 0;
	   $TotalPesoBruto = 0;
	   $TotalPesoNeto = 0;
	   $TotalUnidades = 0;
	   while ($Fila = mysqli_fetch_array($Respuesta))
	   {
		  echo "<tr>\n";
		  echo "<td align='center'>".strtoupper($CodMarca)."</td>\n";
		  echo "<td align='center'>".strtoupper($Marca)."</td>\n";
		  //polyecho "<td align='center'>".number_format($Fila["peso_paquetes"],0,",",".")."</td>\n";
		  echo "<td align='center'>".$Fila["peso_paquetes"]."</td>\n";

          if ($Producto=='57')
          {
                $consuj = "SELECT t3.peso_bruto as peso_bruto from sec_web.pesaje_lodos t3 where";
                $consuj.= " t3.cod_producto = '".$Producto."' and t3.cod_subproducto = '12'";
                $consuj.= " and t3.cod_bulto = '".$CodLote."' and t3.num_bulto = '".$NumLote."' and t3.corr_ie = '".$Corr_enm."'";
                $consuj.= " and t3.cod_paquete = '".$Fila["cod_paquete"]."' and t3.num_paquete = '".$Fila["num_paquete"]."'";
				$consuj.= " and t3.num_pesada = '2'";
				//echo $consuj."<br>";				
                $respuej = mysqli_query($link, $consuj);
                if (!$Filaj = mysqli_fetch_array($respuej))
				{
					$consuj = "SELECT t3.peso_bruto as peso_bruto from sec_web.pesaje_lodos t3 where";
					$consuj.= " t3.cod_producto = '".$Producto."' and t3.cod_subproducto = '11'";
					$consuj.= " and t3.cod_bulto = '".$CodLote."' and t3.num_bulto = '".$NumLote."' and t3.corr_ie = '".$Corr_enm."'";
					$consuj.= " and t3.cod_paquete = '".$Fila["cod_paquete"]."' and t3.num_paquete = '".$Fila["num_paquete"]."'";
					$consuj.= " and t3.num_pesada = '1'";
					$respuej = mysqli_query($link, $consuj);
					$Filaj = mysqli_fetch_array($respuej);
				}				
				
                echo "<td align='center'>".number_format($Filaj["peso_bruto"],0,",",".")."</td>\n";
                $TotalPesoBruto = $TotalPesoBruto + $Filaj["peso_bruto"];
          }
          else
          {
			  if ($Producto=='64')
			  {
				echo "<td align='center'>&nbsp;</td>\n";
			  }	
			  else
			  {
			  	echo "<td align='center'>".number_format(($Fila["peso_paquetes"] + 1),0,",",".")."</td>\n";
   		        $TotalPesoBruto = $TotalPesoBruto + ($Fila["peso_paquetes"] + 1);
			  }	
          }
		  echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		  echo "<td align='center'>".number_format($Fila["num_unidades"],0,",",".")."</td>\n";
		  $Consulta = "SELECT * from ram_web.atributo_existencia ";
		  $Consulta.= " where cod_existencia = '".$Fila["cod_lugar"]."'";
		  $Respuesta2 = mysqli_query($link, $Consulta);
		  if ($Fila2 = mysqli_fetch_array($Respuesta2))
			 echo "<td align='left'>".strtoupper($Fila2["abrev_existencia"])."</td>\n";
          else
			echo "<td align='left'>&nbsp;</td>\n";
          echo "<td align='center'>".strtoupper($Fila["cod_paquete"])."-".$Fila["num_paquete"]."</td>\n";
          $TotalPaquetes = $TotalPaquetes + 1;
//		  $TotalPesoBruto = $TotalPesoBruto + ($Fila["peso_paquetes"] + 1);
		  $TotalPesoNeto = $TotalPesoNeto + $Fila["peso_paquetes"];
		  $TotalUnidades = $TotalUnidades + $Fila["num_unidades"];
	    }
   

	?>
	<tr align="center">
      <td colspan="2"><strong><?php echo number_format($TotalPaquetes,0,",","."); ?> Paquetes</strong></td>
      <td><strong><?php echo number_format($TotalPesoNeto,0,",","."); ?></strong></td>
      <td><strong><?php echo number_format($TotalPesoBruto,0,",","."); ?></strong></td>
      <td>&nbsp;</td>
      <td><strong><?php echo number_format($TotalUnidades,0,",","."); ?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</html>
