<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i:s");
$Directorio='excel';
//require_once 'reader.php';
$CookieRut    = $_COOKIE["CookieRut"];

$Opcion       = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:""; 
$ID           = isset($_REQUEST["ID"])?$_REQUEST["ID"]:"Leyes"; 
$Archivo_name = $_FILES["Archivo"]["name"];
$Archivo      = $_FILES["Archivo"]["tmp_name"];

//echo __DIR__;

//require_once __DIR__.'/Classes\PhpSpreadsheet\Spreadsheet.php';

require __DIR__ . "/vendor/autoload.php";
				
//use PhpOffice\PhpSpreadsheet\IOFactory;
//use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\IOFactory;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

switch($Opcion)
{	
	case "P"://PROCESA DATOS EXCEL Y LOS ARROJA A UNA TEMPORAL
			
			if($Archivo_name!='none')
			{
					$Acento=false;
					for ($j = 0;$j <= strlen($Archivo_name); $j++)
					{
						switch(substr($Archivo_name,$j,1))
						{
							case "á":
							case "Á":
							case "é":
							case "É":
							case "í":
							case "Í":
							case "ó":
							case "Ó":
							case "ú":
							case "Ú":
								$Acento=true;
							break;
						}
					}
					if($Acento==false)
					{
							$NombreArchivo="XLS_".$ID."_".$Archivo_name;
							if(is_file($Directorio."/".$NombreArchivo))
							{
								unlink($Directorio."/".$NombreArchivo);
								
							}	
							if (copy($Archivo, $Directorio."/".$NombreArchivo))
							{
								$ProcesaArchivo = "S";
							}
							else
								$ProcesaArchivo = "N";
					}
			}	
			if($ProcesaArchivo=='S')
			{
				//eliminamos la tabla si existe
				//mysqli_query($link, 'drop table if exists cal_web.tmp_leyes_generica');
				//creamos la tabla temporal
				$TablaTMP="CREATE TABLE if not EXISTS cal_web.tmp_leyes_generica (nro_solicitud bigint(10), 
							cod_leyes varchar(10), 
							cod_unidad varchar(5),
							valor  varchar(9),
							run_registro varchar(12),
							existe char(1),
							orden char(2)
							); 
							";
				mysqli_query($link, $TablaTMP);	
				
				$Eliminar="delete from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."'";
				mysqli_query($link, $Eliminar);	
			
				$documento = IOFactory::load($Directorio."/".$NombreArchivo);
				# obtener conteo e iterar
				$totalDeHojas = $documento->getSheetCount();
				//echo "totalDeHojas:".$totalDeHojas."<br>";				
				$indice=2;
				$worksheet  = $documento->getSheet($indice); // hoja actual
				//echo "<br>Hoja Actual:<br>";
				//var_dump($hojaActual);
				//exit();	
				//$worksheet = $spreadsheet->getActiveSheet();
				$Salida=array();
				//for($i=3;$i<=4;$i++)
				for ($row = 3; $row <= 4; ++$row) {
					//for($k=3;$k<=55;$k++)
					for ($col = 3; $col <= 55; ++$col) {					
						//$celda = $worksheet->getCellByColumnAndRow($col, $row);
						$value = $worksheet->getCell([$col,$row])->getValue();
						//echo "[".$col.",".$row."]=".$value."----";
						//if(trim($data->sheets[$Hoja]['cells'][$i][$k])!='')
						if(trim($value)!='')
						{	
							//ObtengoLey(strtoupper(trim($data->sheets[$Hoja]['cells'][$i][$k])),$k,$Salida,$link);
							$Salida = ObtengoLey(strtoupper(trim($value)),$col,$Salida,$link);
						}					
					}
				}
				//var_dump($Salida);				
				$highestRow = $worksheet->getHighestDataRow(); // e.g. 10
				//$highestRow = $worksheet->getHighestRow(); // e.g. 10
				//echo "<br><br>highestRow:".$highestRow."<br>";	
				//exit();
				//for($i=4;$i<=$data->sheets[$Hoja]['numRows'];$i++)
				for($i=4;$i<=$highestRow;$i++)
				{   //$value = $worksheet->getCell([2, $i])->getValue();
					$celda = $worksheet->getCell([2, $i]);
					//$value = $celda->getValue();
					 # Si es una fórmula y necesitamos su valor, llamamos a:
					 $valueRow = $celda->getCalculatedValue();

					//if(trim(is_numeric($data->sheets[$Hoja]['cells'][$i][2]))!='')
					//echo "<br>valueRow:::".$valueRow."<br><br>";
					//exit();
					if(trim(is_numeric($valueRow))!='')
					{
						for($k=3;$k<=107;$k++)
						{
							if($k<='54')
							{
								$Existe='N';
								//$REsp=mysqli_query($link, "select * from cal_web.solicitud_analisis where nro_solicitud='".$data->sheets[$Hoja]['cells'][$i][2]."' and recargo in ('','0')");
								$Consulta = "select * from cal_web.solicitud_analisis where nro_solicitud='".$valueRow."' and recargo in ('','0')";
								//echo "<br>Consulta:".$Consulta."<br>";
								$REsp=mysqli_query($link,$Consulta);
								//var_dump($REsp);
								//exit();
								if($F=mysqli_fetch_assoc($REsp))
									$Existe='S';
								//$valor =trim($data->sheets[$Hoja]['cells'][$i][$k]);
								//$valor = trim($worksheet->getCell([$k, $i])->getValue());	
								$celda     = $worksheet->getCell([$k, $i]);
								//$EsFormula = $worksheet->getCell([$k, $i])->isFormula();
								//echo "<br>EsFormula -->".$EsFormula."<br>";
								//if($EsFormula == true){
									$valor = $celda->getCalculatedValue();
								//}else{
								//  $valor = trim($celda->getValue());
								//}
								/*
								echo "<br>valueRow-->".$valueRow."<br>";
								echo "<br>Salida-->".$Salida[$k]."<br>";
								echo "<br>valor[".$k.",".$i."]-->".$valor."<br><br>";
								echo "<br>CookieRut-->".$CookieRut."<br><br>";
								echo "<br>Existe-->".$Existe."<br><br>";
								echo "<br>K-->".$k."<br><br>";
								*/
								//exit();
								if($valueRow!=0 && $valor!='')
								{
									$Inserta="insert into cal_web.tmp_leyes_generica (nro_solicitud,cod_leyes,valor,run_registro,existe,orden)
									values('".$valueRow."','".$Salida[$k]."','".$valor."','".$CookieRut."','".$Existe."','".$k."')";
									//values('".$data->sheets[$Hoja]['cells'][$i][2]."','".$Salida[$k]."','".$valor."','".$CookieRut."','".$Existe."','".$k."')";
									//echo $Inserta."<br>";
									mysqli_query($link, $Inserta);
									//echo $Inserta."<br>";
								}
									$posAct=3;
							}
							if($k>='56')
							{
							   //echo "K-1:".$k."<br>";
								//echo $data->sheets[$Hoja]['cells'][4][$k]."    ";
								//$unidad=trim($data->sheets[$Hoja]['cells'][$i][$k]);
								$unidad=trim($worksheet->getCell([$k, $i])->getValue());
								//echo "<br>Unidad:".$unidad."<br>";
								if($unidad!='')
								{
									$Actualiza="UPDATE cal_web.tmp_leyes_generica set cod_unidad='".$unidad."' 
									where nro_solicitud='".$valueRow."' and cod_leyes='".$Salida[$posAct]."'";
									//where nro_solicitud='".$data->sheets[$Hoja]['cells'][$i][2]."' and cod_leyes='".$Salida[$posAct]."'";
									//echo $Actualiza."<br>";
									mysqli_query($link, $Actualiza);								
								}
									$posAct++;
							}
						}
					}
				}

			}
			unlink($Directorio."/".$NombreArchivo);
			header("location:cal_traspaso_leyes_excel_generica.php?p=s");
	break;
	case 'GE':
		
				$ID=explode('//',$Datos);
				//LISTADO DE SOLICITUDES
				//while(list($c,$v)=each($ID))
				foreach($ID as $c => $v)
				{
					if($v!='')
					{		
						//$Recargo='0';
						$RUT_FUNC=ObtenerRutFuncionario($v,$link);
							
						/*$Consulta="Select * from cal_web.solicitud_analisis where nro_solicitud='".$v."' and recargo in ('R')";
						$Resp1 = mysqli_query($link, $Consulta);
						if($Row1 = mysqli_fetch_array($Resp1))
						{
							if($Row1["estado_actual"]=='6' || $Row1["estado_actual"]=='32' )
							{
								$Actualizar=" Update cal_web.solicitud_analisis set estado_actual='".$Row1["estado_actual"]."' ";
								$Actualizar.=" where nro_solicitud='".$v."' and recargo in ('R') ";
								mysqli_query($link, $Actualizar);
							}
							else
							{
								$Actualizar=" Update cal_web.solicitud_analisis set estado_actual='5' ";
								$Actualizar.=" where nro_solicitud='".$v."' and recargo in ('R') ";
								mysqli_query($link, $Actualizar);	
							}
						}*/
						
						$Consulta="Select * from cal_web.solicitud_analisis where nro_solicitud='".$v."' and recargo in ('0','')";
						$Resp2 = mysqli_query($link, $Consulta);
						if($Row2 = mysqli_fetch_array($Resp2))
						{
							$RecargoSolicitud=$Row2["recargo"];
							if($Row2["estado_actual"]=='6' || $Row2["estado_actual"]=='32' )
							{
								$Actualizar=" Update cal_web.solicitud_analisis set estado_actual='".$Row2["estado_actual"]."' ";
								$Actualizar.=" where nro_solicitud='".$v."' and recargo = '".$RecargoSolicitud."' ";
								mysqli_query($link, $Actualizar);
							}
							else
							{
								$Actualizar=" Update cal_web.solicitud_analisis set estado_actual='5' ";
								$Actualizar.=" where nro_solicitud='".$v."' and recargo = '".$RecargoSolicitud."' ";
								mysqli_query($link, $Actualizar);	
							}
						}

						$Consulta="Select * from cal_web.estados_por_solicitud  where nro_solicitud='".$Solicitud."' and recargo='".$RecargoSolicitud."' and cod_estado='5'";
						$Resp = mysqli_query($link, $Consulta);
						if($Fila = mysqli_fetch_array($Resp))
						{
							$Actualizar=" Update cal_web.estados_por_solicitud set  rut_proceso='".$RutQuimico."',fecha_hora='".date('Y-m-d H:i:s')."'"; 
							$Actualizar.=" where  nro_solicitud='".$Solicitud."' and recargo='".$RecargoSolicitud."'  and cod_estado='5'"; 
							mysqli_query($link, $Actualizar);
						}
						else
						{
							$Insertar=" insert into cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso)VALUES"; 
							$Insertar.="('".$RutProceso."','".$Solicitud."','".$RecargoSolicitud."','5','".date('Y-m-d H:i:s')."','N','".$RutQuimico."')"; 
							mysqli_query($link, $Insertar);
						}
						
						//INGRESO LAS LEYES DE LAS SOLICITUES O ACTUALIZO
						$Consulta = "select cod_unidad,avg(valor) as valor,cod_leyes,count(*) as cant_reg from cal_web.tmp_leyes_generica where run_registro='".$CookieRut."'  and nro_solicitud='".$v."' group by nro_solicitud,cod_leyes";
						$Respuesta = mysqli_query($link, $Consulta);$Cont2=0;
						while($Row = mysqli_fetch_array($Respuesta))
						{	
							$ValorLey=trim($Row["valor"]);
							if($ValorLey!='')
							{
								if($Row["cant_reg"]>1)
									$ValorLey=round($ValorLey);
								ActualizarLeyesSolicitud($v,$RecargoSolicitud,$Row["cod_leyes"],$ValorLey,$CookieRut,$RUT_FUNC,$Row["cod_unidad"],$link);			
							}
						}
						
						$Consulta="select cod_producto,cod_subproducto from cal_web.solicitud_analisis where nro_solicitud ='".$v."' and recargo in('','0')";
						$Respuesta = mysqli_query($link, $Consulta);
						if($Row5 = mysqli_fetch_array($Respuesta))
						{
							$SubProducto=$Row5["cod_subproducto"];
							$Producto=$Row5["cod_producto"];
						
							if (($Producto == "18" && ($SubProducto == "6" || $SubProducto == "7" || $SubProducto == "8"  || 
							$SubProducto == "17"  || $SubProducto == "16" || $SubProducto == "49" || $SubProducto == "9" || $SubProducto == "10" || 
							$SubProducto == "12" || $SubProducto == "56"  || $SubProducto == "45" || $SubProducto =="48" || $SubProducto =="53"
							|| $Subproducto == "50" || $SubProducto == "51" || $SubProducto == "52" || $SubProducto =="54")) 
							|| ($Producto == "48" && ($SubProducto == "2"))
							|| ($Producto == "17" && ($SubProducto == "1" || $SubProducto == "2" || $SubProducto == "3" || $SubProducto == "4"))
							|| ($Producto == "16" && $SubProducto == "24")||($Producto == "19"))
							{
								IngresaCobre($Row5["cod_producto"],$Row5["cod_subproducto"],$v,date('Y-m-d H:i:s'),$RUT_FUNC,$CookieRut,$link);
							}
						}
						
						CheckeaCierreSA($v,$link);												
					}
				}
	
	header("location:cal_traspaso_leyes_excel_generica.php?g=s");
	break;
}
function ActualizarLeyesSolicitud($Solicitud,$Recargo,$Leyes,$Valor,$RutQuimico,$RutProceso,$Unidad,$link)
{
	//$RetornoUni=ObtengoUnidad($Unidad);
	$RetornoUni=$Unidad;
	$Candado=1;
	if(trim($Valor)=='')
		$Candado=0;
    
	$Actualizar=" Update cal_web.leyes_por_solicitud  set candado='".$Candado."'";
	if(trim($Valor)=='')
		$Actualizar.=",valor=null";
	else
		$Actualizar.=",valor='".$Valor."'";
	$Actualizar.=",rut_quimico='".$RutQuimico."',proceso='6',cod_unidad='".$RetornoUni."'";
	$Actualizar.=" where nro_solicitud='".$Solicitud."' and recargo='".$Recargo."' and cod_leyes='".$Leyes."'";
	//echo $Actualizar;
	mysqli_query($link, $Actualizar);
	
	$Consulta="select * from cal_web.registro_leyes where nro_solicitud='".$Solicitud."' and ";
	$Consulta.=" recargo='".$Recargo."'";
	$Consulta.="  and cod_leyes='".$Leyes."' ";
	$Resp = mysqli_query($link, $Consulta);
	if(!$Fila = mysqli_fetch_array($Resp))
	{
		$InsertarReg=" INSERT INTO cal_web.registro_leyes (select rut_funcionario,'".date('Y-m-d H:i:s')."',nro_solicitud,recargo,cod_leyes,";
		$InsertarReg.=" valor,peso_humedo,peso_seco,cod_unidad,'0',signo,rut_quimico from cal_web.leyes_por_solicitud ";
		$InsertarReg.=" where nro_solicitud='".$Solicitud."' and recargo='".$Recargo."' and cod_leyes='".$Leyes."' order by fecha_hora desc);";
		mysqli_query($link, $InsertarReg);
	 
	}
	$InsertarReg2=" INSERT INTO cal_web.registro_leyes (select rut_funcionario,'".date('Y-m-d H:i:s')."',nro_solicitud,recargo,cod_leyes,";
	$InsertarReg2.=" valor,peso_humedo,peso_seco,cod_unidad,candado,signo,rut_quimico from cal_web.leyes_por_solicitud ";
	$InsertarReg2.=" where nro_solicitud='".$Solicitud."' and recargo='".$Recargo."' and cod_leyes='".$Leyes."' order by fecha_hora desc);";
	mysqli_query($link, $InsertarReg2);
	
}
function CheckeaCierreSA($sa,$link)
{
	$Consulta="select t1.nro_solicitud, t1.recargo, t1.id_muestra, t1.fecha_hora, t1.rut_funcionario ";
	$Consulta.=" ,count(t2.candado) as total_candados, sum(t2.candado) as cerrados,case when count(t2.candado) = sum(t2.candado) then 'S' else 'N' end as error";
	$Consulta.=" from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
	$Consulta.=" on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo";
	$Consulta.=" where t1.estado_actual='5' and t1.nro_solicitud ='".$sa."' group by t1.nro_solicitud, t1.recargo order by error desc";
	$Respuesta = mysqli_query($link, $Consulta);
//		echo $Consulta."<br><br>";
	if($Row4 = mysqli_fetch_array($Respuesta))
	{	
		if($Row4["error"]== "S") 
		{
			if(is_null($Row4["recargo"]) || $Row4["recargo"]=="" || $Row4["recargo"]=="0" )
			{
				$Actualizar = "UPDATE cal_web.solicitud_analisis set estado_actual='6' ";
				$Actualizar.= " where nro_solicitud ='".$Row4["nro_solicitud"]."' ";
				mysqli_query($link, $Actualizar);
				$Consulta = "select count(*) as cantreg from cal_web.estados_por_solicitud where nro_solicitud='".$Row4["nro_solicitud"]."'";
				$Consulta.= " and rut_funcionario='".$Row4["rut_funcionario"]."' and cod_estado='6' ";
				$Resp2=mysqli_query($link, $Consulta);
				if($Row2=mysqli_fetch_array($Resp2))
				{
					if($Row2["cantreg"]== 0) 
					{		
						$Consulta3 =" select * from cal_web.estados_por_solicitud where nro_solicitud='".$Row4["nro_solicitud"]."'";
						$Consulta3.=" and rut_funcionario='".$Row4["rut_funcionario"]."' and cod_estado='5'";
						$Resp3=mysqli_query($link, $Consulta3);
						if($Row3=mysqli_fetch_array($Resp3))
						{	$Insertar = "insert into cal_web.estados_por_solicitud ";
							$Insertar.="(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_estado,ult_atencion,rut_proceso) ";
							$Insertar.=" values ('".$Row4["rut_funcionario"]."','".$Row4["fecha_hora"]."','".$Row4["nro_solicitud"]."','".$Row4["recargo"]."',";
							$Insertar.=" '6','N','".$Row4["rut_proceso"]."') ";
							mysqli_query($link, $Insertar);
						//	echo "Insertar ".$Insertar."<br>";
						}
					}
				}
			}
			else
			{
				$Actualizar = "UPDATE cal_web.solicitud_analisis set estado_actual='6' where nro_solicitud = '".$Row["nro_solicitud"]."' and recargo ='".$Row["recargo"]."' ";
				mysqli_query($link, $Actualizar);
				$Consulta = "select count(*) as cantreg from cal_web.estados_por_solicitud where nro_solicitud='".$Row["nro_solicitud"]."' and recargo  ='".$Row["recargo"]."'";
				$Consulta.= " and rut_funcionario= '".$Row["rut_funcionario"]."' and cod_estado='6'";
				$Resp3=mysqli_query($link, $Consulta);
				if($Row3=mysqli_fetch_array($Resp3))
				{
					if($Row3["cantreg"]== 0) 
					{	$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud='".$Row4["nro_solicitud"]."' and  ='".$Row4["recargo"]."'";
						$Consulta.=" and rut_funcionario='".$Row4["rut_funcionario"]."' and cod_estado='5'";
					//	echo $Consulta."<br>";
						$Resp3=mysqli_query($link, $Consulta);
						if($Row3=mysqli_fetch_array($Resp3))
						{	$Insertar = "insert into cal_web.estados_por_solicitud ";
							$Insertar.="(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_estado,ult_atencion,rut_proceso) ";
							$Insertar.=" values ('".$Row4["rut_funcionario"]."','".$Row4["fecha_hora"]."','".$Row4["nro_solicitud"]."','".$Row4["recargo"]."',";
							$Insertar.=" '6','N','".$Row4["rut_proceso"]."') ";
							mysqli_query($link, $Insertar);
				//			echo "Insertar ".$Insertar."<br>";
						}
					}
				}
			}
		
		}	
	}	
}
function ObtenerRutFuncionario($Solicitud,$link)
{
	$Consulta="Select * from cal_web.solicitud_analisis  t1 where t1.nro_solicitud='".$Solicitud."' ";
	$Resp = mysqli_query($link, $Consulta);
	if($Fila = mysqli_fetch_array($Resp))
	{
		$RUT=$Fila["rut_funcionario"];	
	}
	return ($RUT);
}
function ObtengoLey($Columna,$pos,$CodLEY,$link)
{
	$Consulta="select cod_leyes from proyecto_modernizacion.leyes where upper(abreviatura)='".$Columna."'";
	$Resp = mysqli_query($link, $Consulta);
	if($Fila = mysqli_fetch_array($Resp))
	{
		$CodLEY[$pos]=$Fila["cod_leyes"];
	}else{
		$CodLEY[$pos]=$Columna;
	}
	return $CodLEY;
}
function ObtengoUnidad($Columna,$link)
{
	$Consulta="select cod_unidad from proyecto_modernizacion.unidades where upper(abreviatura)='".$Columna."'";
	$Resp = mysqli_query($link, $Consulta);$CodUni='';
	if($Fila = mysqli_fetch_array($Resp))
	{
		$CodUni=$Fila["cod_unidad"];
	}
	return($CodUni);	
}

function IngresaCobre($Prod,$SubPro,$NumSA,$FechaR,$RutFun,$RutQuim,$link)
{

	$Consulta = "select count(*) as candados_imp_abiertos ";
	$Consulta.= " from cal_web.leyes_por_solicitud ";
	$Consulta.= " where nro_solicitud=".$NumSA;
	$Consulta.= " and candado <> '1'";
	$Consulta.= " and cod_leyes <> '02'";
	$RespProd = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($RespProd);
	if ($Fila["candados_imp_abiertos"] == 0)
	{
		$Consulta = "select * ";
		$Consulta.= " from cal_web.leyes_por_solicitud ";
		$Consulta.= " where nro_solicitud=".$NumSA;
		if (($Prod==16 || $Prod==17 || $Prod==19) || ($Prod==18 && ($SubPro== '16' || $SubPro=='17' || $SubPro=='49')))
			$Consulta.= " and (cod_leyes <> '02')";
		else
			$Consulta.= " and (cod_leyes <> '02' and cod_leyes <> '48')";
		$RespProd = mysqli_query($link, $Consulta);
		$SumaImpurezas = 0;
		$LeyCu = 0;
		while ($FilaProd = mysqli_fetch_array($RespProd))
		{
			$ValorImpureza = 0;
			$ValorImpureza = $FilaProd["valor"];
			if (($FilaProd["signo"] == "<") && ($ValorImpureza == 0.5 && $ValorImpureza > 0.2))
				$ValorImpureza = 0.4;
			if (($FilaProd["signo"] == "<") && ($ValorImpureza == 0.2 && $ValorImpureza > 0.1))
				$ValorImpureza = 0.1;
			$SumaImpurezas = $SumaImpurezas + $ValorImpureza;
		}
		if ($Prod==16 || $Prod==17|| $Prod==19)
		{
			$LeyCu = 100 - (($SumaImpurezas + 100) / 10000);
			$LeyCu = round($LeyCu,2);
		}
		else
			$LeyCu = 100 - (($SumaImpurezas) / 10000);
		
		$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$LeyCu.",cod_unidad='1',proceso = '6',signo='=',rut_quimico='".$RutQuim."' ";
	/*	$Var='';
		$Var=LimiteControl($NumSA,'02','1',$LeyCu);
		if($Var=='S')
			$Actualizar.= " , observacion='".$CookieRut."' ";
		else
			$Actualizar.= " , observacion=NULL ";
	*/	$Actualizar.= " where nro_solicitud=".$NumSA." and rut_funcionario ='".$RutFun."' and cod_leyes ='02'";
		mysqli_query($link, $Actualizar);
		//echo $Actualizar."<br>";
		$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
		$Insertar=$Insertar.$NumSA.",'";
		$Insertar=$Insertar.$FechaR."','";
		$Insertar=$Insertar.$RutFun."','";
		$Insertar=$Insertar."02',";
		$Insertar=$Insertar.$LeyCu.",'";
		$Insertar=$Insertar."1',";
		$Insertar=$Insertar."'0','=','".$RutQuim."')";
		mysqli_query($link, $Insertar);
		//echo $Insertar."<br>";
		$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQuim."' ";		
	/*	$Var='';
		$Var=LimiteControl($NumSA,'02','1',$LeyCu);
		if($Var=='S')
			$Actualizar.= " , observacion='".$CookieRut."' ";
		else
			$Actualizar.= " , observacion=NULL ";
			
*/		$Actualizar.="  where nro_solicitud=".$NumSA." and rut_funcionario ='".$RutFun."' and cod_leyes ='02' ";
		mysqli_query($link, $Actualizar);
		
		
		$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$NumSA." and rut_funcionario ='".$RutFun."' and cod_leyes ='02'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso,signo) values(";
		$Insertar=$Insertar.$NumSA.",'";
		$Insertar=$Insertar.$FechaR."','";
		$Insertar=$Insertar.$RutFun."','";
		$Insertar=$Insertar."02',";
		$Insertar=$Insertar.$Fila["peso_humedo"].",";
		$Insertar=$Insertar.$Fila["peso_seco"].",";
		$Insertar=$Insertar.$LeyCu.",'";
		$Insertar=$Insertar."1',";
		$Insertar=$Insertar."'1','".$RutQuim."','=')";
		mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
		//echo $Insertar;
	}
	return;
}
?>