<?php
	include("../principal/conectar_principal.php"); 

	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');
	$NumInstruccion = isset($_REQUEST["NumInstruccion"])?$_REQUEST["NumInstruccion"]:"";
	$EnmCode        = isset($_REQUEST["EnmCode"])?$_REQUEST["EnmCode"]:"";


 	$FechaInicio= date("Y");
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
    //$Consulta.= " and substring(fecha_creacion_lote,1,4) ='".$FechaAux."'";
    $Consulta.= " and (year(fecha_creacion_lote) ='".$FechaAux."'";
    $Consulta.= " or year(fecha_creacion_lote) ='".$FechaAux1."')";
	
	$Respuesta = mysqli_query($link, $Consulta);

	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodLote = $Fila["cod_bulto"];
		$NumLote = $Fila["num_bulto"];
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
		$Consulta.= " inner join sec_web.marca_catodos t4 on t1.cod_marca = t4.cod_marca ";
		$Consulta.= " and t2.fecha_creacion_paquete  = t1.fecha_creacion_paquete";
		$Consulta.= " where t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' and t1.corr_enm = '".$Corr_enm."' ";
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
				else
				{
					$Consulta = "SELECT * from sec_web.programa_codelco ";
					$Consulta.= " where corr_codelco = '".$Fila["corr_enm"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						
						if ($Fila2["cod_contrato_maquila"]=="MAQ ENM")
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
<title>Sistema Estadistico de Catodos V.20220831</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action = "sec_con_packing_list_file.php";
			f.submit();
			break;
		case "S":
			f.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=0";
			f.submit();
			break;
		case "E":
			f.action= "sec_con_packing_list_excel.php";
			f.submit();
			break;
		case "I":
			<?php
				if (isset($NumInstruccion))
				{
					echo "f.action = 'sec_con_packing_list_file02.php?Archivo=packing_".$NumInstruccion.".lst';";
					echo "f.submit();";
				}
				else
				{
					echo "alert('NO SE HA GENERADO ARCHIVO PARA IMPRIMIR');";
				}
			?>
			break;
	}
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="770" border="0" cellpadding="2" cellspacing="1">
    <tr> 
      <td colspan="4"><font size="1">EMPRESA NACIONAL DE MINERIA (ENM) PRODUCTOR<br>
        NATIONAL MINING COMPANY</font></td>
      <td width="283" align="center"><strong>PACKING LIST<br>
        CODIGO DE LOTE: <?php echo strtoupper($CodLote)."-".$NumLote; ?></strong></td>
      <td width="163" align="center">FECHA: <?php echo date("d/m/Y"); ?></td>
    </tr>
  </table>
  <br>
  <table width="770" border="0" cellpadding="2" cellspacing="1">
    <tr> 
      <td colspan="2" align="center">
	  <?php
	  	if ($EnmCode == "E")
		{
			echo "<input name='EnmCode' type='radio' value='E' checked>ENAMI&nbsp;&nbsp;";
        	echo "<input type='radio' name='EnmCode' value='C'>CODELCO";
		}
		else
		{
			if ($EnmCode == "C")
			{
				echo "<input name='EnmCode' type='radio' value='E'>ENAMI&nbsp;&nbsp;";
        		echo "<input type='radio' name='EnmCode' value='C' checked>CODELCO";
			}
			else
			{
				echo "<input name='EnmCode' type='radio' value='E' checked>ENAMI&nbsp;&nbsp;";
        		echo "<input type='radio' name='EnmCode' value='C'>CODELCO";
			}
		}
		?></td>
    </tr>
    <tr> 
    	<td width="174">N&ordm; INSTRUCCION: </td>
    	<td width="585"><input name="NumInstruccion" type="text" id="NumInstruccion" value="<?php echo $NumInstruccion; ?>" size="15">        
    	<input name="button" type="submit" id="button" value="Generar" onClick="Proceso('R');" style="width:125px"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
        <input name="btnExcel" type="button" id="btnExcel" style="width:70;" onClick="JavaScript:Proceso('E')" value="Excel"> 
    	<input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"></td>
    </tr>
    <tr> 
      <td>PRODUCTO - SUBPRODUCTO:</td>
      <td><strong><?php echo $Producto." / ".$SubProducto; ?></strong></td>
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
      <td><strong><?php echo $LoteSipa; ?></strong></td>
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
$TotalPaquetes=0;
$TotalPesoNeto=0;
$TotalPesoBruto=0;
$TotalUnidades=0;
if ($NumInstruccion!="")
{
	$NomArchivo = "packing_list\\packing_".$NumInstruccion.".lst";
	$Archivo = fopen($NomArchivo,"w+");
	//echo "archivo : ".$NumInstruccion;	
	Cabecera($Archivo,$CodLote,$NumLote,$DescProducto,$NumInstruccion,$Cliente,'1',date("d/m/Y"),$LoteSipa);
	$Consulta = "SELECT * from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' and t1.corr_enm = '".$Corr_enm."' ";
	$Consulta.= " order by t1.cod_paquete,t1. num_paquete ";
	//echo "con".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPaquetes = 0;
	$TotalPesoBruto = 0;
	$TotalPesoNeto = 0;
	$TotalUnidades = 0;
	$ContLineas = 1;
	$ContPaginas = 1;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".strtoupper($CodMarca)."</td>\n";
		echo "<td align='center'>".strtoupper($Marca)."</td>\n";		
		echo "<td align='center'>".number_format($Fila["peso_paquetes"],0,",",".")."</td>\n";
		
		//echo "<td align='center'>".number_format(($Fila["peso_paquetes"] + 1),0,",",".")."</td>\n";
	if ($Producto=='57' or $Producto=='19')
	{
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
				$PesoBrutoAux = $Filaj["peso_bruto"];
			}
	 		else
			{
				echo "<td align='center'>".number_format(($Fila["peso_paquetes"] + 1),0,",",".")."</td>\n";
				$TotalPesoBruto = $TotalPesoBruto + ($Fila["peso_paquetes"] + 1);
				$PesoBrutoAux = $Fila["peso_paquetes"] + 1;
			}
	}
	else
	{
		echo "<td align='center'>".number_format(($Fila["peso_paquetes"] + 1),0,",",".")."</td>\n";
		$TotalPesoBruto = $TotalPesoBruto + ($Fila["peso_paquetes"] + 1);
		$PesoBrutoAux = $Fila["peso_paquetes"] + 1;
	}		
	  	echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		echo "<td align='center'>".number_format($Fila["num_unidades"],0,",",".")."</td>\n";
		$Consulta = "SELECT * from ram_web.atributo_existencia ";
		$Consulta.= " where cod_existencia = '".$Fila["cod_lugar"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{	
			$Abrev = strtoupper($Fila2["abrev_existencia"]);	
			echo "<td align='left'>".strtoupper($Fila2["abrev_existencia"])."</td>\n";
		}
		else
		{
			$Abrev = "";
			echo "<td align='left'>&nbsp;</td>\n";
		}
		echo "<td align='center'>".strtoupper($Fila["cod_paquete"])."-".$Fila["num_paquete"]."</td>\n";
		$TotalPaquetes = $TotalPaquetes + 1;
		$TotalPesoNeto = $TotalPesoNeto + $Fila["peso_paquetes"];
		$TotalUnidades = $TotalUnidades + $Fila["num_unidades"];

		if ($ContLineas == 46)
		{
			for ($j = 1;$j<=8;$j++)
			{
				fwrite($Archivo,"\r\n");
			}
			$ContLineas = 1;
			$ContPaginas++;
			Cabecera($Archivo,$CodLote,$NumLote,$DescProducto,$NumInstruccion,$Cliente,$ContPaginas,date("d/m/Y"),$LoteSipa);
		}
		$Linea = FormatTexto(strtoupper($CodMarca),8,"A");
		$Linea.= FormatTexto(strtoupper($Marca),24,"A");
		$Linea.= FormatTexto(number_format($Fila["peso_paquetes"],0,".",","),9,"C");
		$Linea.= FormatTexto(" ",6,"D");
		$Linea.= FormatTexto(number_format($PesoBrutoAux,0,".",","),10,"C");
		$Linea.= FormatTexto(" ",5,"D");
		$Linea.= FormatTexto($Fila["cod_grupo"],5,"C");
		$Linea.= FormatTexto(" ",5,"D");
		$Linea.= FormatTexto(number_format($Fila["num_unidades"],0,".",","),8,"C");
		$Linea.= FormatTexto(" ",7,"D");
		$Linea.= FormatTexto($Abrev,9,"C");
		$Linea.= FormatTexto(" ",7,"D");
		$Linea.= FormatTexto(strtoupper($Fila["cod_paquete"])."-".$Fila["num_paquete"],8,"C");
 		fwrite($Archivo,$Linea."\r\n");
		$ContLineas++;
	}
	PiePagina($Archivo,$TotalPaquetes,$TotalUnidades,$TotalPesoNeto,$TotalPesoBruto);
	fclose($Archivo);
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
<br>
<br>
</form>
</body>
</html>
<?php
function Cabecera($Arch,$Cod,$Num,$Desc,$Inst,$Cli,$Pag,$Fech,$Sipa)
{
	fwrite($Arch,"\r\n");
	//CHR(10)
	fwrite($Arch,"EMPRESA NACIONAL DE MINERIA (ENM) PRODUCTOR          PACKING LIST                             PAG.  :   ".$Pag."\r\n");
	fwrite($Arch,"NATIONAL MINING COMPANY                       CODIGO DE LOTE   : ".$Cod."-".$Num."                      FECHA :".$Fech."\r\n");
	fwrite($Arch,"                                              -----------------------------\r\n");
	fwrite($Arch,"FLUJO        : \r\n");
	fwrite($Arch,"DESCRIPCION  : ".$Desc."\r\n");
	fwrite($Arch,"N� INSTR. DE EMBARQUE : ".$Inst."\r\n");
	fwrite($Arch,"CLIENTE      : ".$Cli."\r\n");
	fwrite($Arch,"Lote Sipa    : ".$Sipa."\r\n");
	fwrite($Arch,"\r\n");
	fwrite($Arch,"----------------------------------------------------------------------------------------------------------------------------- \r\n");
	fwrite($Arch,"MARCA       DESCRIPCION         PESO NETO      PESO BRUTO     GRUPO     UNIDADES       UBICACION         SERIE                \r\n"); 
	fwrite($Arch,"-----------------------------------------------------------------------------------------------------------------------------\r\n\r\n");
	//fwrite($Arch,"\r\n");
}

function PiePagina($Arch,$TotPaq,$TotUnid,$PNeto,$PBruto)
{
	fwrite($Arch,"\r\n");
	fwrite($Arch,"\r\n");
	fwrite($Arch,"------------------------------------------------------------------------------------------------------------------------\r\n");
	fwrite($Arch,"T.SUB-LOTES              TOT.PAQUETES =".$TotPaq."      TOT.UNID. = ".$TotUnid."   T/P NETO (kg) = ".number_format($PNeto,0,".",",")."      T/P BRUTO (kg) = ".number_format($PBruto,0,".",",")."\r\n");
	fwrite($Arch,"------------------------------------------------------------------------------------------------------------------------\r\n");	

}

function FormatTexto($Texto,$MaxLen,$Pos)
{
	if (strlen($Texto) < $MaxLen)
	{
		for ($i = strlen($Texto); $i < $MaxLen; $i++)
		{
			if ($Pos == "A")
			{
				$Texto = $Texto." ";
			}
			else
			{
				if ($Pos == "D")
				{
					$Texto = " ".$Texto;
				}
				else
				{
					if ($Pos == "C")
					{
						if ($SW == 2)
						{
							$Texto = $Texto." ";
							$SW = 1;
						}
						else
						{
							$Texto = " ".$Texto;
							$SW = 2;
						}
					}
				}
			}
		}
	}
	else
	{
		$Texto = substr($Texto,0,$MaxLen);
	}
	return $Texto;
}
?>
