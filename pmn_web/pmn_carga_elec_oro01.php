<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $AnoElectOro."-".$MesElectOro."-".$DiaElectOro;
	
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.carga_electrolisis_oro ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and turno = '".$Turno."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			$Consulta.= " and correlativo = '".$Correlativo."'";
			$Consulta.= " and colada = '".$Colada."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualiza
				$Actualizar = "UPDATE pmn_web.carga_electrolisis_oro set";
				$Actualizar.= " cant_anodos = '".$CantAnodos."', ";
			    $Actualizar.= " peso_anodos = '".str_replace(",",".",$PesoAnodos)."', ";
				$Actualizar.= " operador = '".$Operador."', ";
				$Actualizar.= " observacion = '".$Obs."' , ";
				$Actualizar.= " jefe_turno = '".$JefeTurno."', ";
				$Actualizar.= " color = '".$cmbcolor."',";
				$Actualizar.= " cloruro_aurico = '".str_replace(",",".",$CloruroAurico)."',";
				$Actualizar.= " catodos_seco = '".str_replace(",",".",$CatodoSeco)."',";
				$Actualizar.= " peso_resto = '".str_replace(",",".",$PesoRestos)."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and turno = '".$Turno."'";
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				$Actualizar.= " and correlativo = '".$Correlativo."'";
				$Actualizar.= " and colada = '".$Colada."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				
				//Movimientos_Pmn('','1','58','2',str_replace(",",".",$PesoAnodos),$CantAnodos,'0',$NumElectrolisis,'6',$CookieRut,'M',$Correlativo,$Turno);
			}
			else
			{
				//Inserta
				if($CloruroAurico=='')
					$CloruroAurico='0';
				else	
					$CloruroAurico=str_replace(",",".",$CloruroAurico);
				if($CatodoSeco=='')	
					$CatodoSeco='0';
				else	
					$CatodoSeco=str_replace(",",".",$CatodoSeco);
				if($PesoRestos=='')	
					$PesoRestos='0';
				else	
					$PesoRestos=str_replace(",",".",$PesoRestos);
				$Insertar = "INSERT INTO pmn_web.carga_electrolisis_oro ";
				$Insertar.= "(rut, fecha, turno, num_electrolisis, correlativo, colada, cant_anodos, ";
				$Insertar.= "peso_anodos, operador, observacion,jefe_turno,color,cloruro_aurico,catodos_seco,peso_resto) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".$NumElectrolisis."',";
				$Insertar.= "'".$Correlativo."','".$Colada."','".$CantAnodos."','".str_replace(",",".",$PesoAnodos)."','".$Operador."','".$Obs."','".$JefeTurno."', '".$cmbcolor."', '".str_replace(",",".",$CloruroAurico)."', '".str_replace(",",".",$CatodoSeco)."', '".str_replace(",",".",$PesoRestos)."')";
				//echo $Insertar;
				mysqli_query($link, $Insertar);
				
				//Movimientos_Pmn('','1','58','2',str_replace(",",".",$PesoAnodos),$CantAnodos,'0',$NumElectrolisis,'6',$CookieRut,'I',$Correlativo,$Turno);
			}
			header("location:pmn_principal_reportes.php?DiaElectOro=".$DiaElectOro."&MesElectOro=".$MesElectOro."&AnoElectOro=".$AnoElectOro."&Turno=".$Turno."&NumElectrolisis=".$NumElectrolisis."&Correlativo=".$Correlativo."&Operador=".$Operador."&JefeTurno=".$JefeTurno."&Tab4=true");
			break;
		case "M":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					header("location:pmn_principal_reportes.php?MostrarElOro=S&DiaElectOro=".$DiaElectOro."&MesElectOro=".$MesElectOro."&AnoElectOro=".$AnoElectOro."&Turno=".$p."&NumElectrolisis=".$ChkNumElec[$i]."&Correlativo=".$ChkCorrelativo[$i]."&Colada=".$ChkColada[$i]."&Tab4=true");
				}
			}
			else
			{
				header("location:pmn_principal_reportes.php?DiaElectOro=".$DiaElectOro."&MesElectOro=".$MesElectOro."&AnoElectOro=".$AnoElectOro."&Tab4=true");
			}
			break;
		case "E":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					$Eliminar = "delete from pmn_web.carga_electrolisis_oro ";
					$Eliminar.= " where fecha = '".$AnoElectOro."-".$MesElectOro."-".$DiaElectOro."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and num_electrolisis = '".$ChkNumElec[$i]."'";
					$Eliminar.= " and correlativo = '".$ChkCorrelativo[$i]."'";
					$Eliminar.= " and colada = '".$ChkColada[$i]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					
					//Movimientos_Pmn('','1','58','2','0','0','0',$ChkNumElec[$i],'6',$CookieRut,'E',$ChkCorrelativo[$i],$p);
				}
			}
			if ($volver == "S")
			{
				header("location:pmn_principal_reportes.php?DiaElectOro=".$DiaElectOro."&MesElectOro=".$MesElectOro."&AnoElectOro=".$AnoElectOro."&Tab4=true");
				break;
			}
		case "S":
			
			if (count($checkbox)>0)
			{
				$valores = explode("~",$parametros);
		        while(list($c,$v) = each($valores))
		            {
					
				    $Eliminar = "delete from pmn_web.carga_electrolisis_oro ";
					$Eliminar.= " where fecha = '".$v."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}
		
			header("location:pmn_carga_elect_oro03.php?DiaElectOro=".$DiaElectOro."&MesElectOro=".$MesElectOro."&AnoElectOro=".$AnoElectOro);
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?&Tab4=true");
			break;
	}
?>