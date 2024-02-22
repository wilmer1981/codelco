<?php
include("inter_conectar.php");
function CreaArchivo($ClaveArchivo, $NomArchivo, $DirArchivo, $ArrArchivo)	
{
	$ArrConfig=array();
	$Separador="";
	$NumCol=0;
	ConfigArchivo($ClaveArchivo,&$ArrConfig,&$NumCol);	
	$Archivo = fopen($DirArchivo."/".$NomArchivo,"w+");
	if (count($ArrArchivo)>0)
	{
		$Z=1;
		while (list($k,$v)=each($ArrArchivo))
		{
			
			switch ($ClaveArchivo)
			{
				case "HrDatosPersonales":
					$ArrConfig=array();
					$NumCol=0;
					if ($v[1]=="0000")				
						ConfigArchivo("HrMedida",&$ArrConfig,&$NumCol);
					else
						if ($v[1]=="0001")				
							ConfigArchivo("HrAsignacion",&$ArrConfig,&$NumCol);
						else
							if ($v[1]=="0002")				
								ConfigArchivo("HrDatosPersonales",&$ArrConfig,&$NumCol);
					break;
				case "HrEmolBasicos01":
					$ArrConfig=array();
					$NumCol=0;
					if (substr($k,0,4)=="0000")				
						ConfigArchivo("HrEmolBasicos01",&$ArrConfig,&$NumCol);
					else
						if (substr($k,0,4)=="0001")				
							ConfigArchivo("HrEmolBasicos02",&$ArrConfig,&$NumCol);
					break;
				case "HrSistemaSalud":
					$ArrConfig=array();
					$NumCol=0;
					//echo $k." = ".substr($k,0,4)."<br>";
					if (substr($k,0,4)=="0000")				
						ConfigArchivo("HrSistemaSalud",&$ArrConfig,&$NumCol);
					else
						if (substr($k,0,4)=="0001")				
							ConfigArchivo("HrDetSistemaSalud",&$ArrConfig,&$NumCol);
						else
							if (substr($k,0,4)=="0002")				
								ConfigArchivo("HrDetSistemaSalud",&$ArrConfig,&$NumCol);
					break;
				case "HrSistemaPrevision":
					$ArrConfig=array();
					$NumCol=0;
					if (substr($k,0,4)=="0000")				
						ConfigArchivo("HrSistemaPrevision",&$ArrConfig,&$NumCol);
					else
						if (substr($k,0,4)=="0001")				
							ConfigArchivo("HrDetSistemaPrevision",&$ArrConfig,&$NumCol);
					break;
				case "HrCabVacaciones":
					$ArrConfig=array();
					$NumCol=0;
					if (substr($k,0,4)=="0000")				
						ConfigArchivo("HrCabVacaciones",&$ArrConfig,&$NumCol);
					else
						if (substr($k,0,4)=="0001" || substr($k,0,4)=="0002")				
							ConfigArchivo("HrDetVacaciones",&$ArrConfig,&$NumCol);
					break;
			}
			$Linea="";					
			for ($i=1;$i<=$NumCol;$i++)
			{				
				if ($ArrConfig[$i]["valor"]!="")
					$Valor=$ArrConfig[$i]["valor"];
				else
					$Valor=$v[$i];
				if ($ArrConfig[$i]["tipo"]=="d")
				{
					$Valor=str_replace(",",".",$Valor);
					$Valor=number_format($Valor,$ArrConfig[$i]["cant_dec"],".","");					
					if ($ArrConfig[$i]["sig_decimal"]=="")
						$Valor=str_replace(".","",$Valor);
					else
						$Valor=str_replace(".",$ArrConfig[$i]["sig_decimal"],$Valor);					
					switch ($ArrConfig[$i]["align"])
					{
						case "left":
							if ($ArrConfig[$i]["signo"]!="")
								$Valor = "+".str_pad($Valor,($ArrConfig[$i]["largo"]-1),$ArrConfig[$i]["char_relleno"],STR_PAD_LEFT).$Separador;
							else
								$Valor = str_pad($Valor,($ArrConfig[$i]["largo"]),$ArrConfig[$i]["char_relleno"],STR_PAD_LEFT).$Separador;
							$Linea.= $Valor;
							break;
						case "right":
							if ($ArrConfig[$i]["signo"]!="")
								$Valor = "+".str_pad($Valor,($ArrConfig[$i]["largo"]-1),$ArrConfig[$i]["char_relleno"],STR_PAD_RIGHT).$Separador;						
							else
								$Valor = str_pad($Valor,($ArrConfig[$i]["largo"]),$ArrConfig[$i]["char_relleno"],STR_PAD_RIGHT).$Separador;						
							$Linea.= $Valor;
							break;
						case "center":
							if ($ArrConfig[$i]["signo"]!="")
								$Valor = "+".str_pad($Valor,($ArrConfig[$i]["largo"]-1),$ArrConfig[$i]["char_relleno"],STR_PAD_CENTER).$Separador;						
							else
								$Valor = str_pad($Valor,($ArrConfig[$i]["largo"]),$ArrConfig[$i]["char_relleno"],STR_PAD_CENTER).$Separador;						
							$Linea.= $Valor;						
							break;
						default:
							if ($ArrConfig[$i]["signo"]!="")
								$Valor = "+".str_pad($Valor,($ArrConfig[$i]["largo"]-1),$ArrConfig[$i]["char_relleno"]).$Separador;						
							else
								$Valor = str_pad($Valor,($ArrConfig[$i]["largo"]),$ArrConfig[$i]["char_relleno"]).$Separador;						
							$Linea.= $Valor;	
							break;
					}							
				}
				else
				{
					switch ($ArrConfig[$i]["align"])
					{
						case "left":
							$Linea.= str_pad(substr($Valor,0,$ArrConfig[$i]["largo"]),$ArrConfig[$i]["largo"],$ArrConfig[$i]["char_relleno"],STR_PAD_LEFT).$Separador;
							break;
						case "right":
							$Linea.= str_pad(substr($Valor,0,$ArrConfig[$i]["largo"]),$ArrConfig[$i]["largo"],$ArrConfig[$i]["char_relleno"],STR_PAD_RIGHT).$Separador;
							break;
						case "center":
							$Linea.= str_pad(substr($Valor,0,$ArrConfig[$i]["largo"]),$ArrConfig[$i]["largo"],$ArrConfig[$i]["char_relleno"],STR_PAD_CENTER).$Separador;
							break;
						default:
							$Linea.= str_pad(substr($Valor,0,$ArrConfig[$i]["largo"]),$ArrConfig[$i]["largo"],$ArrConfig[$i]["char_relleno"]).$Separador;
							break;
					}		
				}
			} 
			fwrite($Archivo,$Linea."\r\n");
			$Z++;
		}
	}
	else
	{
		$Linea="No hay Datos para Mostrar";
	}	
	//echo "CONTADOR=".$Z;
	fclose($Archivo);
}

function ConfigArchivo($CodArchivo, $ArrConfig, $NumCol)
{
	$FunCons="select * from interfaces_sap.intersap_param_archivos where cod_archivo='".$CodArchivo."' order by orden";
	$FunResp=mysqli_query($link, $FunCons);
	//echo $FunCons."<br>";
	$NumCol=0;
	while ($FunFila=mysqli_fetch_array($FunResp))
	{
		//echo $FunFila["orden"]." / ".$FunFila["nom_campo"]."<br>";
		$ArrConfig[$FunFila["orden"]]["nom_campo"]=$FunFila["nom_campo"];
		$ArrConfig[$FunFila["orden"]]["tipo"]=$FunFila["tipo"];
		$ArrConfig[$FunFila["orden"]]["valor"]=$FunFila["valor"];
		$ArrConfig[$FunFila["orden"]]["largo"]=$FunFila["largo"];
		$ArrConfig[$FunFila["orden"]]["align"]=$FunFila["align"];
		if ($FunFila["char_relleno"]=="bl")
			$ArrConfig[$FunFila["orden"]]["char_relleno"]=" ";			
		else
			$ArrConfig[$FunFila["orden"]]["char_relleno"]=$FunFila["char_relleno"];			
		$ArrConfig[$FunFila["orden"]]["cant_ent"]=$FunFila["cant_ent"];
		$ArrConfig[$FunFila["orden"]]["cant_dec"]=$FunFila["cant_dec"];
		$ArrConfig[$FunFila["orden"]]["sig_decimal"]=$FunFila["sig_decimal"];
		$NumCol++;
	}
}

function HomologaRol($Codigo)
{
	switch ($Codigo)
	{
		case "1":
			$Codigo="F1";
			break;
		case "2":
			$Codigo="F1";
			break;
		default:
			$Codigo="F2";
			break;
	}
}

function HomologaEstCivil($Codigo)
{
	switch ($Codigo)
	{
		case "1": //CASADO
			$Codigo="1";
			break;
		case "2": //SOLTERO
			$Codigo="0";
			break;
		case "3"://VIUDO
			$Codigo="2";
			break;
	}
}

function HomologaEstCivilEmp($Codigo)
{
	switch ($Codigo)
	{
		case "1"://CASADO
			$Codigo="04";
			break;
		case "2"://SOLTERO
			$Codigo="01";
			break;
		case "3"://VIUDO
			$Codigo="06";
			break;
	}
}

function HomologaSexo($Codigo)
{
	switch ($Codigo)
	{
		case "1":
			$Sexo="M";
			break;
		case "0":
			$Sexo="F";
			break;
	}
}

function HomologaNivel($Rol, $Nivel)
{
	switch ($Rol)
	{
		case "1":
		case "2":
			$Nivel=78+intval($Nivel);
			break;
		default:
			$Nivel=$Nivel;
			break;
	}
}

function datediff($interval, $date1, $date2) 
{
	// Function roughly equivalent to the ASP "DateDiff" function
	
	/* Get the seconds first */
	$seconds = strtotime($date2) - strtotime($date1);
	
	/*$date1=date("Y-m-d", strtotime($date1));
	$date2=date("Y-m-d",strtotime($date2));*/
	
	switch($interval) 
	{
		case "y":
			list($year1, $month1, $day1) = split('-', $date1);
			list($year2, $month2, $day2) = split('-', $date2);
			$time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
			$time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
			$diff = $year2 - $year1;
			if($month1 > $month2) 
			{
				$diff -= 1;
			} 
			elseif($month1 == $month2) 
			{
				if($day1 > $day2) 
				{
					$diff -= 1;
				} 
				elseif($day1 == $day2) 
				{
					if($time1 > $time2) 
					{
						$diff -= 1;
					}
				}
			}
			break;
		case "m":
			/* parses the year, month and days. split() was replaced with explode(), PHP Manual says it's faster */
			list($year1, $month1, $day1) = explode('-', $date1);
			list($year2, $month2, $day2) = explode('-',$date2);
			
			$time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
			$time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
			
			$diff = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
			
			if($day1 > $day2) 
			{
				$diff -= 1;
			} 
			elseif($day1 == $day2) 
			{
				if($time1 > $time2) 
				{
					$diff -= 1;
				}
			}
			break;
		case "w":
			// Only simple seconds calculation needed from here on
			$diff = floor($seconds / 604800);
			break;
		case "d":
			$diff = floor($seconds / 86400);
			break;
		case "h":
			$diff = floor($seconds / 3600);
			break; 
		case "i":
			$diff = floor($seconds / 60);
			break; 
		case "s":
			$diff = $seconds;
			break; 
	}
//return the +ve integer only
	if ($diff<0)
	{
		$diff=0-$diff;
	}
	return $diff;
}
?>
