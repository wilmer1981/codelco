<?php
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
require_once 'reader.php';
$Directorio='doc';
$Seg=date("s");

if($Archivo_name!='none')
{
	$Extension=explode('.',$Archivo_name);
	if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
	{
		$Acento=false;
		for ($j = 0;$j <= strlen($Archivo_name); $j++)
		{
			switch(substr($Archivo_name,$j,1))
			{
				case "�":
					$Archivo_name=str_replace( "�","a",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","A",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","e",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","E",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","i",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","I",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","o",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","O",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","u",$Archivo_name);
				break;
				case "�":
					$Archivo_name=str_replace( "�","U",$Archivo_name);
				break;
				case "&":
					$Archivo_name=str_replace( "&","",$Archivo_name);
				break;
				case "$":
					$Archivo_name=str_replace( "$","",$Archivo_name);
				break;
				case "#":
					$Archivo_name=str_replace( "#","",$Archivo_name);
				break;
				case "'":
					$Archivo_name=str_replace( "'","",$Archivo_name);
				break;
			}
		}
		if($Acento==false)
		{
				$NombreArchivo=$Ano.$Mes.$Proceso."_".$Archivo_name;
				if (copy($Archivo, $Directorio."/".$NombreArchivo))
				{
					$ProcesaArchivo = "S";
					//echo "entrooo<br>";
				}
				else
					$ProcesaArchivo = "N";
			}
		}
}
if($ProcesaArchivo=="S")
{
	$ValExcel=explode('~',DatosListaExcel($Proceso));
	//echo "SWITH".$ValExcel[7];
	switch($ValExcel[7])
	{	
		case "P"://PRESUMINISTRO
		case "S"://SUMINISTRO
			$CodSumi=$ValExcel[3];
			$IniFilCC=$ValExcel[4];
			$IniColCC=$ValExcel[5];
			$NumHoja=$ValExcel[6];
			$Tipo=$ValExcel[7];
			$SubMes=$ValExcel[8];
			$TipoCarga=$ValExcel[9];//A=ANUAL, M=MENSUAL
			$ValSumi=explode('~',DatosSumistros($CodSumi));
			$UnidSumi=$ValSumi[2];
			ProcesaArchivoSuministro($NombreArchivo,$Directorio,$Ano,$Mes,$Meses,$CodSumi,$NumHoja,$IniColCC,$IniFilCC,$UnidSumi,$Tipo,$SubMes,$TipoCarga);
			$Consulta = "select * from pcip_eec_suministros_detalle where ano='".$Ano."'";
			if($TipoCarga=='M')
				$Consulta.= " and mes='".$Mes."'";
			$Consulta.= " and cod_suministro='".$CodSumi."' and tipo='".$Tipo."'";	
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
				$Mensaje='Archivo Procesado Exitosamente';	
			else
				$Mensaje='Archivo No Procesado';	
		    break;
		case "CDV"://CUADRO DIARIO DE VENTAS
			$TipoCarga=$ValExcel[9];//A=ANUAL, M=MENSUAL
			ProcesaArchivoCDV($NombreArchivo,$Directorio,$Ano,$Mes);
			$Consulta = "select * from pcip_cdv_cuadro_diario_ventas where ano='".$Ano."'";	
			if($TipoCarga=='M')
				$Consulta.= " and mes='".$Mes."'";
				//echo $Consulta."<br>";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
				$Mensaje='Archivo Procesado Exitosamente';
			else
			   	$Mensaje='Archivo No Procesado';	
			break;	
		case "EER"://ESTADO RESULTADO
			$TipoCarga=$ValExcel[9];//A=ANUAL, M=MENSUAL
            ProcesaArchivosEER($NombreArchivo,$Directorio,$Ano,$Mes);
			$Consulta = "select * from pcip_ere_estado_resultado where ano='".$Ano."'";	
			if($TipoCarga=='M')
				$Consulta.= " and mes='".$Mes."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
				$Mensaje='Archivo Procesado Exitosamente';
			else
			   	$Mensaje='Archivo No Procesado';	
			break;			
		case "IP"://INGRESOS PROYECTADOS
			$TipoCarga=$ValExcel[9];//A=ANUAL, M=MENSUAL
			ProcesaArchivosIP($NombreArchivo,$Directorio,$Ano,$Mes);			
			$Consulta = "select * from pcip_inp_tratam where ano='".$Ano."'";
			if($TipoCarga=='M')
				$Consulta.= " and mes='".$Mes."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
				$Mensaje='Archivo Procesado Exitosamente';
			else
			   	$Mensaje='Archivo No Procesado';	
			break;	
						
	}
	header("location:pcip_carga_excel.php?Mensaje=".$Mensaje."&Ano2=".$Ano);
}
else
{
	$Mensaje='Problema al Cargar el Excel, Archivo No Cargado';
	header("location:pcip_carga_excel.php?Mensaje=".$Mensaje);
}
function ProcesaArchivoSuministro($NombreArchivo,$Directorio,$A�o,$Mes,$Meses,$CodSumi,$NumHoja,$PosCC,$IniFilCC,$Unid,$Tipo,$SubMes,$TipoCarga)//nom archivo,directtorio, a�o,mes,arreglo meses,codigo suministro, numero de hoja,columna posicion CC, inicio fila CC,unidad,tipo suministro, subtrae parte mes)
{
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	Procesa($CodSumi,$A�o,$Mes,$NumHoja,$PosCC,$IniFilCC,$data,$Unid,$Meses,$Tipo,$SubMes,$TipoCarga);
}
function Procesa($CodSumi,$A�o,$MesSel,$Hoja,$PosCC,$IniFil,$data,$Unid,$Meses,$Tipo,$SubMes,$TipoCarga)
{
	EliminarSuministro($CodSumi,$A�o,$Tipo);
	//$ColUltMes=RetornaUltColMes($data,$Hoja,$Meses,$IniFilMes,$IniCol);
	reset($Meses);
	while(list($c,$v)=each($Meses))
	{
		//echo $TipoCarga."<br>";
		//echo $MesSel."<br>";
		//echo $c."<br><br>";
		if($TipoCarga=='M'&&$c==$MesSel)
			break;
		for ($i = 0; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
		{
			for ($j = 0; $j <= $data->sheets[$Hoja]['numCols']; $j++)
			{
				if($SubMes=='S')
				{
					$MesHoja=substr(strtoupper(trim($data->sheets[$Hoja]['cells'][$i][$j])),0,3);
					$MesBuscado=substr(strtoupper(trim($v)),0,3);					
				}
				else
				{
					$MesHoja=strtoupper(trim($data->sheets[$Hoja]['cells'][$i][$j]));
					$MesBuscado=strtoupper(trim($v));
				}
				if($MesHoja==$MesBuscado&&$ArrayMeses[$c]=='')
						$ArrayMeses[$c]=$j;	
			}
		}
	}
	if(!isset($ArrayMeses))
	{
		$Mensaje='Problema al Cargar el Excel, Archivo No Cargado';
		header("location:pcip_carga_excel.php?Mensaje=".$Mensaje);
	}
	for ($i = $IniFil; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
	{
		//RESTRICCION DE FILA PARA SUMINISTRO DIESEL
		if($CodSumi=='1'&&(trim($data->sheets[$Hoja]['cells'][$i][$PosCC])=='TOTAL'))
			break;
		if(CCValido(trim($data->sheets[$Hoja]['cells'][$i][$PosCC])))	
		{
			$CC=trim($data->sheets[$Hoja]['cells'][$i][$PosCC]);
			reset($ArrayMeses);
			while(list($c,$v)=each($ArrayMeses))
			{
				$Mes=$c+1;
				$ValorMes=trim($data->sheets[$Hoja]['cells'][$i][$v]);
				InsertarSuministro($CodSumi,$A�o,$Mes,$CC,$ValorMes,$Unid,$Tipo);
			}
		}
	}
}
function CCValido($CC)
{
	$CC=str_replace(' ','',$CC);
	$Consulta="select * from pcip_eec_centro_costos where cod_cc='".$CC."'";
	//echo $Consulta."<br>";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
		return (true);
	else
		return (false);	
}	
function InsertarSuministro($Cod,$A�o,$Mes,$CC,$Valor,$Unid,$Tipo)
{
	$Consulta="select sum(valor) as valor from pcip_eec_suministros_detalle where cod_suministro='".$Cod."' and ano='".$A�o."' and mes='".$Mes."' and cod_cc='".str_replace(' ','',$CC)."' and tipo='".$Tipo."'";
	$Resp=mysql_query($Consulta);
	//echo $Consulta."<br>";
	$Fila=mysql_fetch_array($Resp);
	if(!is_null($Fila[valor]))
	{
		$ValorTot=$Fila[valor]+$Valor;
		$Actualizar="UPDATE pcip_eec_suministros_detalle set valor='".$ValorTot."' where cod_suministro='".$Cod."' and ano='".$A�o."' and mes='".$Mes."' and cod_cc='".str_replace(' ','',$CC)."' and tipo='".$Tipo."' ";
		mysql_query($Actualizar);
		//echo $Actualizar."<br>";
	}
	else
	{
		$Insertar="insert into pcip_eec_suministros_detalle(cod_suministro,ano,mes,cod_cc,valor,cod_unidad,tipo) values ";
		$Insertar.="('".$Cod."','".$A�o."','".$Mes."','".str_replace(' ','',$CC)."','".$Valor."','".$Unid."','".$Tipo."')";
		mysql_query($Insertar);
		//echo $Insertar."<br>";
	}
}
function EliminarSuministro($Cod,$A�o,$Tipo)
{
	$Eliminar="delete from pcip_eec_suministros_detalle where cod_suministro='".$Cod."' and ano='".$A�o."' and tipo='".$Tipo."'";
	mysql_query($Eliminar);
	//echo $Eliminar."<br>";
}

function RetornaPosicionMes($data,$Hoja,$Mes,$Meses,$IniFila)
{
	for ($j = 1; $j <= $data->sheets[$Hoja]['numCols']; $j++)
	{
		$MesHoja=strtoupper(trim($data->sheets[$Hoja]['cells'][$IniFila][$j]));
		$MesSel=strtoupper(trim($Meses[$Mes-1]));
		if(substr($MesHoja,0,3)==substr($MesSel,0,3))
			$ColMes=$j;
	}
	return $ColMes;
}
function RetornaUltColMes($data,$Hoja,$Meses,$IniFila,$IniCol)
{
	//echo $IniCol."<br>";
	//echo $IniFila."<br>";
	$Mes=0;
	for ($j = $IniCol; $j <= $data->sheets[$Hoja]['numCols']; $j++)
	{
		$MesHoja=strtoupper(trim($data->sheets[$Hoja]['cells'][$IniFila][$j]));
		$MesSel=strtoupper(trim($Meses[$Mes]));
		//echo "MES HOJA:".$MesHoja."<br>";
		//echo "MES ARRAY:".$MesSel."<br><br>";
		if(substr($MesHoja,0,3)!=substr($MesSel,0,3))
		{
			$PosUltMes=$j-1;
			break;
		}
		$Mes++;	
	}
	return $PosUltMes;
}
function ProcesaArchivoCDV($NombreArchivo,$Directorio,$A�o,$Mes)//nom archivo,directtorio, a�o,mes
{  
	$Eliminar="delete from pcip_cdv_cuadro_diario_ventas where ano='".$A�o."' and mes='".$Mes."'";
	mysql_query($Eliminar);
	//echo $Eliminar;
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	$Hoja=0;$Det='N';
	//$IniCol=1;
	//$IniCol=2;
	for ($i = 0; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
	{
		for ($j = 0; $j <= $data->sheets[$Hoja]['numCols']; $j++)
		{
			//echo "Fila:".$i."<br>";
			//echo "Colu:".$j."<br>";
			//echo "VALOR CELDA:".$data->sheets[$Hoja]['cells'][$i][$j]."<br>";
			/*if($data->sheets[$Hoja]['cells'][$i][1]!='')
			{
				$IniCol==$data->sheets[$Hoja]['cells'][$i][1];		
			}
			else
			{  
			   $IniCol==$data->sheets[$Hoja]['cells'][$i][2];*/
			   
				if($j==1)//CORRE LOS DATOS DEL EXCEL
				{		
					if($data->sheets[$Hoja]['cells'][$i][1]=='Mercado')	  
					{
						$Mercado=$data->sheets[$Hoja]['cells'][$i][2];
						$CodMercado=CodigoMercado($Mercado);
						//echo $CodMercado."  ".$Mercado."<br>";
					}	
					if($data->sheets[$Hoja]['cells'][$i][1]=='Division')	  
					{
						$Division=$data->sheets[$Hoja]['cells'][$i][2];
						//echo $Division."<br>";
					}	
				
					if($data->sheets[$Hoja]['cells'][$i][1]=='Producto')	  
					{
						$Producto=$data->sheets[$Hoja]['cells'][$i][2];
						if($data->sheets[$Hoja]['cells'][$i][7]=='VENTAS')
							$Ajuste='N';
						else
						    $Ajuste='S';	
						$Consulta="select * from pcip_cdv_productos_ventas where cod_producto='".$Producto."'";
						$Resp=mysql_query($Consulta);
						if(!$Fila=mysql_fetch_array($Resp))
						 {
						  	$NomProducto=$data->sheets[$Hoja]['cells'][$i][3];
							$Insertar=" insert into pcip_cdv_productos_ventas (cod_producto,nom_producto,vigente) values ('".$Producto."','".$NomProducto."','S')";
						 	mysql_query($Insertar);
						 }
						//echo $Producto."<br>";
					}	
					if($Det=='S' && $data->sheets[$Hoja]['cells'][$i][1]!='Total Tipo Venta')
					{
						$NroDoc=$data->sheets[$Hoja]['cells'][$i][1];
						$FecEmision=FormatoFechaAAAAMMDD2($data->sheets[$Hoja]['cells'][$i][2]);
						$NrFolio=$data->sheets[$Hoja]['cells'][$i][3];
						$CodClte=$data->sheets[$Hoja]['cells'][$i][4];
						$Fembar=FormatoFechaAAAAMMDD2($data->sheets[$Hoja]['cells'][$i][5]);
						$Nave=$data->sheets[$Hoja]['cells'][$i][6];
						$Contrato=$data->sheets[$Hoja]['cells'][$i][7];
						/*if($Producto=='8013')//ACIDO SULFURICO
						{
						  $Consulta1=" select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31015'";
						  $Resp1=mysql_query($Consulta1);
						  $Fila1=mysql_fetch_array($Resp1);
						  $Datos=explode(',',$Fila1["nombre_subclase"]);
						  while(list($c,$v)=each($Datos))							  
						  {
								if(trim($data->sheets[$Hoja]['cells'][$i][7])==trim($v))
									$Producto='9999';//COD PRODUCTO ACIDO DEBIL
						  }
						} */
						$Kfinos=$data->sheets[$Hoja]['cells'][$i][8];
						$ValorNeto=$data->sheets[$Hoja]['cells'][$i][9];
						if($Producto=='8013')
						{
							if($Kfinos!=0)				
								$ValorAComparar=($ValorNeto/$Kfinos)*1000;
							else
								$ValorAComparar=0;	
	
							$Consulta1=" select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31060'";
							$Resp1=mysql_query($Consulta1);
							$Fila1=mysql_fetch_array($Resp1);
								$ValorTonelada=$Fila1["valor_subclase1"];
							
							if($ValorAComparar<$ValorTonelada)	
								$Producto='9999';
						}								
						$EstFleDes=$data->sheets[$Hoja]['cells'][$i][10];
						$Iva=$data->sheets[$Hoja]['cells'][$i][11];
						$FobTotal=$data->sheets[$Hoja]['cells'][$i][12];
						//echo $NroDoc."     ".$FecEmision."    ".$NrFolio."    ".$CodCtte."    ".$Fembar."    ".$Nave."    ".$Contrato."    ".$Kfinos."    ".$ValorNeto."    ".$EstFleDes."    ".$Iva."    ".$FobTotal."<br><br>" ; 
						
						$Insertar=" insert into pcip_cdv_cuadro_diario_ventas(cod_division,cod_mercado,tipo_venta,cod_producto,ano,mes,num_documento,fecha_emision,num_folio,cod_cliente,fecha_embarque,nave,cod_contrato,kilos_finos,valor_cif_neto,est_fle_des,seguro_iva,valor_fob_total,ajuste)";
						$Insertar.="values ('".$Division."','".$CodMercado."','".$Tipo."','".$Producto."','".$A�o."','".$Mes."','".$NroDoc."','".$FecEmision."','".$NrFolio."','".$CodClte."','".$Fembar."','".$Nave."','".$Contrato."','".$Kfinos."','".$ValorNeto."','".$EstFleDes."','".$Iva."','".$FobTotal."','".$Ajuste."')";
						mysql_query($Insertar);
						if($Producto=='9999')
							$Producto='8013';					
					}
					
					if($data->sheets[$Hoja]['cells'][$i][1]=='Tipo de Venta')	  
					{
						$Tipo=$data->sheets[$Hoja]['cells'][$i][2];
						$Consulta="select * from pcip_cdv_tipo_ventas_cdv where tipo_venta='".$Tipo."'";
						$Resp=mysql_query($Consulta);
						if(!$Fila=mysql_fetch_array($Resp))
						 {
						  	$NomTipo=$data->sheets[$Hoja]['cells'][$i][3];
							$Insertar=" insert into pcip_cdv_tipo_ventas_cdv (tipo_venta,nom_venta) values ('".$Tipo."','".$NomTipo."')";
						 	mysql_query($Insertar);
						 }
						
						//echo $Tipo."<br>";
						$Det='S';
					}	
					if($data->sheets[$Hoja]['cells'][$i][1]=='Total Tipo Venta')	  
					{
						$TotalTipoVenta=$data->sheets[$Hoja]['cells'][$i][2];
						 
						$Det='N';
					}	
				}		
		}
	}	
}

function ProcesaArchivosEER($NombreArchivo,$Directorio,$A�o,$Mes) //ESTADO RESULTADO
{
  //echo "entro funcion<br>";
	$Eliminar="delete from pcip_ere_estado_resultado where ano='".$A�o."' and mes='".$Mes."'";
	mysql_query($Eliminar);
	//echo $Eliminar;
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	$Hoja=0;$Det='N';
	for ($i = 0; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
	{
		for ($j = 0; $j <= $data->sheets[$Hoja]['numCols']; $j++)
		{
				if($j==5)//CORRE LOS DATOS DEL EXCEL
				{		
					if($data->sheets[$Hoja]['cells'][$i][5]=='****** ESTADOS DE RESULTADOS *****')	  
					{
						$EstadoResultado=$data->sheets[$Hoja]['cells'][$i][5];
						//echo $EstadoResultado."<br>";
						$Det='S';
					}
					
					if($Det=='S' && $data->sheets[$Hoja]['cells'][$i][5]!='TOTAL MARGEN DE LA EXPLOTACION')
					{	
											
						$Division=$data->sheets[$Hoja]['cells'][$i][4];
						if($Division=='FV01')
						{
							$Cuenta=$data->sheets[$Hoja]['cells'][$i][5];
							if($Mes!='1')
							{
							   $Valor=$data->sheets[$Hoja]['cells'][$i][15];
						    }
							else
							{
							   $Valor=$data->sheets[$Hoja]['cells'][$i][11];
							}
							$Producto=$data->sheets[$Hoja]['cells'][$i][8];
/*						    $Producto=str_replace('Ventas','',$Producto);
							$Producto=str_replace('3� Ventas','',$Producto);
							$Producto=str_replace('Costo Vta.','',$Producto);
							$Producto=str_replace('Costo Vta','',$Producto);
							$Producto=str_replace('3� Costo Venta','',$Producto);
							$Producto=str_replace('3� Costo Vta','',$Producto);
							$Producto=str_replace('Costo Venta','',$Producto);
                            $Producto=str_replace('Ventas de','',$Producto);							
							$Consulta="select * from pcip_ere_productos where nom_producto='".$Producto."'";
                            //echo $Consulta."<br>";
							$Resp=mysql_query($Consulta);
							if(!$Fila=mysql_fetch_array($Resp))
							 {
								$Consulta1="select ifnull(max(cod_producto+1),1) as maximo from pcip_ere_productos ";
								$Resp1=mysql_query($Consulta1);
								//echo $Consulta1."<br>";
								if($Fila1=mysql_fetch_array($Resp1))
									$TxtCodigo=$Fila1["maximo"];
								$Insertar1=" insert into pcip_ere_productos (cod_producto,nom_producto,cuenta_ingreso,cuenta_costos,vigente)";
								$Insertar1.=" values ('".$TxtCodigo."','".$Producto."','".$Cuenta."','0','1')";
								mysql_query($Insertar1);
								//echo $Insertar1."<br>";
							 }												
							//echo $Division."     ".$Cuenta."    ".$Valor."<br><br>" ; 
*/							
							$Insertar=" insert into pcip_ere_estado_resultado(cod_division,cod_cuenta,ano,mes,valor)";
							$Insertar.="values ('".$Division."','".$Cuenta."','".$A�o."','".$Mes."','".$Valor."')";
							mysql_query($Insertar);
							//echo $Insertar."<br><br>";					
							}					
					}
					if($data->sheets[$Hoja]['cells'][$i][5]=='TOTAL MARGEN DE LA EXPLOTACION')	  
					{
						$TotalMargenExplotacion=$data->sheets[$Hoja]['cells'][$i][5];
						 
						$Det='N';
					}	
				}		
		}
	}	
}

/*function ProcesaArchivosRHO($NombreArchivo,$Directorio) // RESURSO HUMANO ORGANICA
{
	$Eliminar="delete from pcip_organica";
	mysql_query($Eliminar);
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	$Hoja=2;$Det='N';
	for ($i = 0; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
	{
		for ($j = 0; $j <= $data->sheets[$Hoja]['numCols']; $j++)
		{		
			//echo "Fila:".$i."<br>";
			//echo "Colu:".$j."<br>";
			//echo "VALOR CELDA:".$data->sheets[$Hoja]['cells'][$i][$j]."<br>";		
			if($j==1&&$data->sheets[$Hoja]['cells'][$i][1]!='')//CORRE LOS DATOS DEL EXCEL
			{		
				if (valida_rut(trim($data->sheets[$Hoja]['cells'][$i][1])))
				{
					//echo 'el rut es CORRECTO :-)';
					$Rut=$data->sheets[$Hoja]['cells'][$i][1];
					$Nombre=$data->sheets[$Hoja]['cells'][$i][2];
					$NuSap=$data->sheets[$Hoja]['cells'][$i][3];
					$CodFuncion=$data->sheets[$Hoja]['cells'][$i][4];
					$Rol=$data->sheets[$Hoja]['cells'][$i][5];
					$NomCargo=$data->sheets[$Hoja]['cells'][$i][6];
					$Nivel=$data->sheets[$Hoja]['cells'][$i][7];
					$Turno=$data->sheets[$Hoja]['cells'][$i][8];
					$GrupTurno=$data->sheets[$Hoja]['cells'][$i][9];
					$CentroCosto=$data->sheets[$Hoja]['cells'][$i][10];
					$Fta=$data->sheets[$Hoja]['cells'][$i][12];
					$Fti=$data->sheets[$Hoja]['cells'][$i][13];
					$Vac=$data->sheets[$Hoja]['cells'][$i][14];
					$Sexo=$data->sheets[$Hoja]['cells'][$i][15];
					//echo $Rut."  ".$Nombre."  ".$Rol."  ".$NomCargo."  ".$CentroCosto."  ".$Sexo." ".$Fta."  ".$Fti."  ".$Vac."<br>";

					$Insertar=" insert into pcip_organica(rut,cod_sap,nombres,rol,sexo,nom_cargo,cod_cc,tipo_contrato,fecha_nacimiento,fta,fti,vac)";
					$Insertar.="values ('".$Rut."','".$NuSap."','".$Nombre."','".$Rol."','".$Sexo."','".$NomCargo."','".$CentroCosto."','1','0000-00-00','".$Fta."','".$Fti."','".$Vac."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";					
				}
			}		
		}
	}
}*/
/*function ProcesaArchivoRHS($NombreArchivo,$Directorio,$Ano,$Mes)//nom archivo,directtorio RECURSO HUMANO SOBRETIEMPO
{  
	$Eliminar="delete from pcip_sobretiempo where ano='".$Ano."' and mes='".$Mes."'";
	mysql_query($Eliminar);
	//echo $Eliminar;
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	$Hoja=1;$Det='N';
	//$IniCol=1;
	//$IniCol=2;
	for ($i = 0; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
	{
		for ($j = 0; $j <= $data->sheets[$Hoja]['numCols']; $j++)
		{
			//echo "Fila:".$i."<br>";
			//echo "Colu:".$j."<br>";
			//echo "VALOR CELDA:".$data->sheets[$Hoja]['cells'][$i][$j]."<br>";				
			if($j==1 &&$data->sheets[$Hoja]['cells'][$i][1]!='N� pers.' && $data->sheets[$Hoja]['cells'][$i][1]!='')//CORRE LOS DATOS DEL EXCEL
			{
				$CodCC=$data->sheets[$Hoja]['cells'][$i][1];
				$CodSap=$data->sheets[$Hoja]['cells'][$i][2];
				$NOmbre=$data->sheets[$Hoja]['cells'][$i][3];
				$Tipo=$data->sheets[$Hoja]['cells'][$i][4];
				$Cant=$data->sheets[$Hoja]['cells'][$i][5];
				//echo $CodSap."     ".$CC."    ".$NOmbre."    ".$Tipo."    ".$Cant."<br><br>" ; 
				
				$Consulta="select ifnull(max(correlativo)+1,1) as maximo from pcip_sobretiempo where cod_sap='".$CodSap."' and ano='".$Ano."' and mes='".$Mes."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$Correlativo=$Fila["maximo"];
				}
				$Insertar=" insert into pcip_sobretiempo(correlativo,cod_sap,ano,mes,nom_sobretiempo,cantidad)";
				$Insertar.="values ('".$Correlativo."','".$CodSap."','".$Ano."','".$Mes."','".$Tipo."','".$Cant."')";
				mysql_query($Insertar);
				//echo $Insertar."<br><br>";					

			}												
		}
	}	
}*/
/*function ProcesaArchivoRHA($NombreArchivo,$Directorio,$Ano,$Mes)//nom archivo,directtorio,a�o,mes RECURSO HUMANO AUSENTISMO
{  
	$Eliminar="delete from pcip_ausentismo where ano='".$Ano."' and mes='".$Mes."'";
	mysql_query($Eliminar);
	//echo $Eliminar;
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	$Hoja=0;
	//$IniCol=1;
	//$IniCol=2;	
	for ($i = 0; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
	{
		for ($j = 0; $j <= $data->sheets[$Hoja]['numCols']; $j++)
		{
			//echo "Fila:".$i."<br>";
			//echo "Colu:".$j."<br>";
			//echo "VALOR CELDA:".$data->sheets[$Hoja]['cells'][$i][$j]."<br>";				
			if($j==1 &&$data->sheets[$Hoja]['cells'][$i][1]!='CC' && $data->sheets[$Hoja]['cells'][$i][1]!='')//CORRE LOS DATOS DEL EXCEL
			{
				$PresAb=$data->sheets[$Hoja]['cells'][$i][3];
				$ClaseAbsent=$data->sheets[$Hoja]['cells'][$i][4];
				$CodSap=$data->sheets[$Hoja]['cells'][$i][5];
				$HHPresencia=$data->sheets[$Hoja]['cells'][$i][7];
				$HHPlanificada=$data->sheets[$Hoja]['cells'][$i][8];
				$TipoAbsentPres=$data->sheets[$Hoja]['cells'][$i][9];
				//echo $PresAb."     ".$ClaseAbsent."    ".$CodSap."    ".$HHPresencia."    ".$HHPlanificada."   ".$TipoAbsentPres."<br><br>" ; 
				
				$Insertar=" insert into pcip_ausentismo(cod_sap,pres_absent,clase_absent_pres,ano,mes,hh_presencia,hh_planificada,tipo_absent_pres)";
				$Insertar.="values ('".$CodSap."','".$PresAb."','".$ClaseAbsent."','".$Ano."','".$Mes."','".$HHPresencia."','".$HHPlanificada."','".$TipoAbsentPres."')";
				mysql_query($Insertar);
				//echo $Insertar."<br><br>";					

			}												
		}
	}	
}	*/
function ProcesaArchivosIP($NombreArchivo,$Directorio,$Ano,$Mes) // INGRESO PROYECTADO
{
	$Eliminar="delete from pcip_inp_tratam where ano='".$Ano."' and mes='".$Mes."'";
	mysql_query($Eliminar);
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	$Hoja=2;$Det='N';
	for ($i = 7; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
	{				
			//echo "Fila:".$i."<br>";
			//echo "Colu:".$j."<br>";
			//echo "VALOR CELDA:".$data->sheets[$Hoja]['cells'][$i][$j]."<br>";	
			if($data->sheets[$Hoja]['cells'][$i][1]!='')	  
			{
				$Area=$data->sheets[$Hoja]['cells'][$i][1];
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='31023' and nombre_subclase='".$Area."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$NomArea=$data->sheets[$Hoja]['cells'][$i][1];
					$Cod_area=$Fila["cod_subclase"];
					$NomDivision='';
					//echo "<br>".$NomArea."<br>";	
				}
			}		
		    if($data->sheets[$Hoja]['cells'][$i][1]!='')
			{
				if($data->sheets[$Hoja]['cells'][$i][1]=='')
				   $data->sheets[$Hoja]['cells'][$i][1]='NULL';
				$Division=$data->sheets[$Hoja]['cells'][$i][1];
				$Consulta1="select * from proyecto_modernizacion.sub_clase where cod_clase='31024' and nombre_subclase='".$Division."'";
				$Resp1=mysql_query($Consulta1);
				//echo $Consulta1;
				if($Fila1=mysql_fetch_array($Resp1))
				{
					$NomDivision=$data->sheets[$Hoja]['cells'][$i][1];
					$Cod_division=$Fila1["cod_subclase"];
					//echo "<br>".$NomDivision."<br>";					
				}														
			}	
			//echo $Mes."<br>";
			if($NomDivision!='')
			{			
			switch ($Mes)
			{
               case "1": 
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][4]=='')
						$data->sheets[$Hoja]['cells'][$i][4]='0';																		
					$Real=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][4]);
					$Real=str_replace(',','.',$Real);
					if($data->sheets[$Hoja]['cells'][$i][5]=='')
						$data->sheets[$Hoja]['cells'][$i][5]='0';	
					$Proyectado=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][5]);
					$Proyectado=str_replace(',','.',$Proyectado);
					//echo  $Producto." ".$Unidad." ".$Real." ".$Proyectado."<br><br>";
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real."','".$Proyectado."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";	
					//echo "*************************************"."<br>";				
				break;	
				case "2":	
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}										
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][6]=='')
						$data->sheets[$Hoja]['cells'][$i][6]='0';														
					$Real1=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][6]);
					$Real1=str_replace(',','.',$Real1);
					if($data->sheets[$Hoja]['cells'][$i][7]=='')
						$data->sheets[$Hoja]['cells'][$i][7]='0';														
					$Proyectado1=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][7]);
					$Proyectado1=str_replace(',','.',$Proyectado1);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real1."','".$Proyectado1."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
                break;
				case "3":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}				
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][8]=='')
						$data->sheets[$Hoja]['cells'][$i][8]='0';														
					$Real2=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][8]);
					$Real2=str_replace(',','.',$Real2);
					if($data->sheets[$Hoja]['cells'][$i][9]=='')
						$data->sheets[$Hoja]['cells'][$i][9]='0';														
					$Proyectado2=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][9]);
					$Proyectado2=str_replace(',','.',$Proyectado2);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real2."','".$Proyectado2."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;							
				case "4":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][10]=='')
						$data->sheets[$Hoja]['cells'][$i][10]='0';														
					$Real3=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][10]);
					$Real3=str_replace(',','.',$Real3);
					if($data->sheets[$Hoja]['cells'][$i][11]=='')
						$data->sheets[$Hoja]['cells'][$i][11]='0';														
					$Proyectado3=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][11]);
					$Proyectado3=str_replace(',','.',$Proyectado3);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real3."','".$Proyectado3."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "5":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][12]=='')
						$data->sheets[$Hoja]['cells'][$i][12]='0';														
					$Real4=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][12]);
					$Real4=str_replace(',','.',$Real4);
					if($data->sheets[$Hoja]['cells'][$i][13]=='')
						$data->sheets[$Hoja]['cells'][$i][13]='0';														
					$Proyectado4=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][13]);
					$Proyectado4=str_replace(',','.',$Proyectado4);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real4."','".$Proyectado4."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "6":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][14]=='')
						$data->sheets[$Hoja]['cells'][$i][14]='0';														
					$Real5=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][14]);
					$Real5=str_replace(',','.',$Real5);
					if($data->sheets[$Hoja]['cells'][$i][15]=='')
						$data->sheets[$Hoja]['cells'][$i][15]='0';														
					$Proyectado5=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][15]);
					$Proyectado5=str_replace(',','.',$Proyectado5);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real5."','".$Proyectado5."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "7":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][16]=='')
						$data->sheets[$Hoja]['cells'][$i][16]='0';														
					$Real6=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][16]);
					$Real6=str_replace(',','.',$Real6);
					if($data->sheets[$Hoja]['cells'][$i][17]=='')
						$data->sheets[$Hoja]['cells'][$i][17]='0';														
					$Proyectado6=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][17]);
					$Proyectado6=str_replace(',','.',$Proyectado6);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real6."','".$Proyectado6."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "8":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][18]=='')
						$data->sheets[$Hoja]['cells'][$i][18]='0';														
					$Real7=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][18]);
					$Real7=str_replace(',','.',$Real7);
					if($data->sheets[$Hoja]['cells'][$i][19]=='')
						$data->sheets[$Hoja]['cells'][$i][19]='0';														
					$Proyectado7=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][19]);
					$Proyectado7=str_replace(',','.',$Proyectado7);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real7."','".$Proyectado7."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "9":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][20]=='')
						$data->sheets[$Hoja]['cells'][$i][20]='0';														
					$Real8=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][20]);
					$Real8=str_replace(',','.',$Real8);
					if($data->sheets[$Hoja]['cells'][$i][21]=='')
						$data->sheets[$Hoja]['cells'][$i][21]='0';														
					$Proyectado8=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][21]);
					$Proyectado8=str_replace(',','.',$Proyectado8);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real8."','".$Proyectado8."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "10":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][22]=='')
						$data->sheets[$Hoja]['cells'][$i][22]='0';														
					$Real9=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][22]);
					$Real9=str_replace(',','.',$Real9);
					if($data->sheets[$Hoja]['cells'][$i][23]=='')
						$data->sheets[$Hoja]['cells'][$i][23]='0';														
					$Proyectado9=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][23]);
					$Proyectado9=str_replace(',','.',$Proyectado9);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real9."','".$Proyectado9."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "11":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][24]=='')
						$data->sheets[$Hoja]['cells'][$i][24]='0';														
					$Real10=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][24]);
					$Real10=str_replace(',','.',$Real10);
					if($data->sheets[$Hoja]['cells'][$i][25]=='')
						$data->sheets[$Hoja]['cells'][$i][25]='0';														
					$Proyectado10=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][25]);
					$Proyectado10=str_replace(',','.',$Proyectado10);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real10."','".$Proyectado10."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
				case "12":
			        if($data->sheets[$Hoja]['cells'][$i][2]=='')
					    $data->sheets[$Hoja]['cells'][$i][2]='NULL';				
					if($data->sheets[$Hoja]['cells'][$i][1]!='' && $data->sheets[$Hoja]['cells'][$i][1]!=$NomArea &&$data->sheets[$Hoja]['cells'][$i][1]!=$NomDivision)	
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][1];
					   //echo $Producto."<br>";
					}
					else
					{
					   $Producto=$data->sheets[$Hoja]['cells'][$i][2];
					   //echo $Producto."<br>";
					}								
					$Producto=$data->sheets[$Hoja]['cells'][$i][2];
					$Unidad=$data->sheets[$Hoja]['cells'][$i][3];
					if($data->sheets[$Hoja]['cells'][$i][26]=='')
						$data->sheets[$Hoja]['cells'][$i][26]='0';														
					$Real11=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][26]);
					$Real11=str_replace(',','.',$Real11);
					if($data->sheets[$Hoja]['cells'][$i][27]=='')
						$data->sheets[$Hoja]['cells'][$i][27]='0';														
					$Proyectado11=str_replace('%','',$data->sheets[$Hoja]['cells'][$i][27]);
					$Proyectado11=str_replace(',','.',$Proyectado11);
					$Insertar=" insert into pcip_inp_tratam(ano,mes,nom_area,nom_division,cod_producto,unidad,valor_real,valor_presupuestado)";
					$Insertar.="values ('".$Ano."','".$Mes."','".$Cod_area."','".$Cod_division."','".$Producto."','".$Unidad."','".$Real11."','".$Proyectado11."')";
					mysql_query($Insertar);
					//echo $Insertar."<br><br>";						
				break;			
			 }
		 }			
	 }
}

function CodigoMercado($DescripcionMercado)
{	
	$Valor='';
	$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31008' and nombre_subclase='".$DescripcionMercado."' ";			
	$Resp=mysql_query($Consulta);
	if ($FilaTC=mysql_fetch_array($Resp))
	{		
	  $Valor=$FilaTC["cod_subclase"];
	}
	return($Valor);
}
?>
