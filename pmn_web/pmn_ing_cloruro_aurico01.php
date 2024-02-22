<?php
include("../principal/conectar_pmn_web.php");

switch($Opcion)
{
	case "E":
			$FechaDiaMas=date('Y-m-d',mktime(0,0,0,$MesCA,$DiaCA+1,$AnoCA));
			$Consulta="select * from cloruro_aurico where fecha='".$FechaDiaMas."'";
			$Resps=mysqli_query($link, $Consulta);
			if($Filas=mysqli_fetch_assoc($Resps))
			{
				header('location:pmn_principal_reportes.php?Tab15=true&Msj=NE');	
			}		    
			else
			{
				$Elimina="delete from cloruro_aurico where fecha='".$AnoCA."-".$MesCA."-".$DiaCA."'";
				mysqli_query($link, $Elimina);
				header('location:pmn_principal_reportes.php?Tab15=true&Msj=E&AnoCA='.$AnoCA.'&MesCA='.$MesCA.'&DiaCA='.$DiaCA);	
			}
	break;
	case "MFinal":
			$StockFinal=str_replace('.','',$StockFinal);
			$StockFinal=str_replace(',','.',$StockFinal);
			$Actualiza1="UPDATE cloruro_aurico set stockFin_V='".$StockFinal."'";
			$Actualiza1.=" where fecha='".$AnoCA."-".$MesCA."-".$DiaCA."'";
			//echo "ACTUALIZO EL REGISTRO:         ".$Actualiza1."<br>";
			mysqli_query($link, $Actualiza1);
			/*for($i=$DiaCA+1;$i<=31;$i++)
			{
				$Consulta="select * from cloruro_aurico where fecha='".$AnoCA."-".$MesCA."-".$i."'";
				$Resps=mysqli_query($link, $Consulta);
				if($Filas=mysqli_fetch_assoc($Resps))
				{
					$FechaAnterior=date('Y-m-d',mktime(0,0,0,$MesCA,$i-1,$AnoCA));
					$Consulta="select * from cloruro_aurico where fecha='".$FechaAnterior."'";
					$Resp2=mysqli_query($link, $Consulta);
					if($Filas2=mysqli_fetch_assoc($Resp2))
					{
						if($Filas2[stockFin_V]==0 && $Filas2[stockFin_V]=='')
							$StockIni=$Filas2[stockIni_V]+$Filas2[prod_ca_V]-$Filas2[ca_a_prod_V];
						else
							$StockIni=$Filas2[stockFin_V];
					}	
					else
						$StockIni='0';
					
					$ValorDatoMod=$StockIni+$Filas[prod_ca_V];
					$ValorDato=$ValorDatoMod;			
					$StockFinal2=$StockIni+$Filas[prod_ca_V]-$ValorDato;
					$Actualiza="UPDATE cloruro_aurico set prod_ca_V='".$Filas[prod_ca_V]."',ca_a_prod_V='".$ValorDato."'";
					$Actualiza.=",mue_a_proc_V='".$Filas[mue_a_proc_V]."',cat_a_proc_V='".$Filas[cat_a_proc_V]."',stockIni_V='".$StockIni."',stockFin_V='".$StockFinal2."'";
					$Actualiza.=" where fecha='".$AnoCA."-".$MesCA."-".$i."'";
					//echo "actualiza registros existentes:     ".$Actualiza."<br>";
					mysqli_query($link, $Actualiza);
				}										
			}*/	
			header('location:pmn_principal_reportes.php?Tab15=true&Msj=M');	
	break;
	case "G":
			$ExplodDatos=explode('//',$DatosEnvio);
			while(list($c,$v)=each($ExplodDatos))
			{
				$Datos2=explode('~',$v);
				
				$StockIni=$Datos2[1];$Valor1=$Datos2[2];$Valor2=$Datos2[3];$Valor3=$Datos2[4];$Valor4=$Datos2[5];
				$Valor1=str_replace('.','',$Valor1);
				$Valor1=str_replace(',','.',$Valor1);
				$Valor2=str_replace('.','',$Valor2);
				$Valor2=str_replace(',','.',$Valor2);
				$Valor3=str_replace('.','',$Valor3);
				$Valor3=str_replace(',','.',$Valor3);
				$Valor4=str_replace('.','',$Valor4);
				$Valor4=str_replace(',','.',$Valor4);
				$StockIni=str_replace('.','',$StockIni);
				$StockIni=str_replace(',','.',$StockIni);
				$StockFinal=str_replace('.','',$StockFinal);
				$StockFinal=str_replace(',','.',$StockFinal);
				$ValorDato=$StockIni+$Valor1;
				if($Valor2!=$ValorDato)
					$ValorDato=$Valor2;
				$StockFinalDato=$StockIni+$Valor1-$ValorDato;
				$Consulta="select * from cloruro_aurico where fecha='".$AnoCA."-".$MesCA."-".$Datos2[0]."'";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysqli_fetch_assoc($Resp))
				{
					//if($StockFinal!=$StockFinalDato && $StockFinal!='0.0000')
						//$StockFinalDato=$StockFinal;
					$Actualiza1="UPDATE cloruro_aurico set prod_ca_V='".$Valor1."',ca_a_prod_V='".$ValorDato."'";
					$Actualiza1.=",mue_a_proc_V='".$Valor3."',cat_a_proc_V='".$Valor4."'";
					$Actualiza1.=" where fecha='".$AnoCA."-".$MesCA."-".$Datos2[0]."'";
					//echo "ACTUALIZO EL REGISTRO:         ".$Actualiza1."<br>";
					mysqli_query($link, $Actualiza1);
					
				}
				else
				{
					$Insertar="INSERT INTO cloruro_aurico values('".$AnoCA."-".$MesCA."-".$Datos2[0]."','".$StockIni."','".$Valor1."','".$ValorDato."','".$Valor3."','".$Valor4."','".$StockFinalDato."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
				}	
			}
			header('location:pmn_principal_reportes.php?Tab15=true&Msj=M&AnoCA='.$AnoCA.'&MesCA='.$MesCA.'&DiaCA='.$DiaCA);
	break;
	case "R":
			$Consulta="select * from cloruro_aurico where fecha='".$AnoCA."-".$MesCA."-".$DiaCA."'";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysqli_fetch_assoc($Resp))
			{
				$FechaAnterior=date('Y-m-d',mktime(0,0,0,$MesCA,$DiaCA-1,$AnoCA));
				$Consulta="select * from cloruro_aurico where fecha='".$FechaAnterior."'";
				$Resp2=mysqli_query($link, $Consulta);
				if($Filas2=mysqli_fetch_assoc($Resp2))
				{
					if($Filas2[stockFin_V]==0 && $Filas2[stockFin_V]=='')
						$StockIni=$Filas2[stockIni_V]+$Filas2[prod_ca_V]-$Filas2[ca_a_prod_V];
					else
						$StockIni=$Filas2[stockFin_V];
				}
				else
					$StockIni='0';

				$Insert="INSERT INTO cloruro_aurico (fecha,stockIni_V)";
				$Insert.=" values('".$AnoCA."-".$MesCA."-".$DiaCA."','".$StockIni."')";
				mysqli_query($link, $Insert);
			}	
			header('location:pmn_principal_reportes.php?Tab15=true&AnoCA='.$AnoCA.'&MesCA='.$MesCA.'&DiaCA='.$DiaCA);
	break;
}	
?>