<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $AnoCForo."-".str_pad($MesCForo,'2','0',STR_PAD_LEFT)."-".$DiaCForo;
	switch ($Proceso)
	{
		case "G2": //GRABAR
			$Consulta = "select * from pmn_web.carga_fusion_oro ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and correlativo = '".$Correlativo."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$NumElectrolisis=str_replace(".","",$NumElectrolisis);
				$NumElectrolisis=str_replace(",",".",$NumElectrolisis);
				$NumBarra=str_replace(".","",$NumBarra);
				$NumBarra=str_replace(",",".",$NumBarra);
				$PesoBarra=str_replace(".","",$PesoBarra);
				$PesoBarra=str_replace(",",".",$PesoBarra);
				$Actualizar = "UPDATE pmn_web.carga_fusion_oro set ";
				$Actualizar.= " num_electrolisis = '".$NumElectrolisis."', ";
				$Actualizar.= " num_barra = '".$NumBarra."', ";
				$Actualizar.= " peso = '".$PesoBarra."' ";
				$Actualizar.= " where fecha = '".$Fecha."' ";				
				$Actualizar.= " and correlativo = '".$Correlativo."'";
				//echo $Actualizar;
				mysqli_query($link, $Actualizar);
				
				//Movimientos_Pmn('','34','4','2',str_replace(",",".",$PesoBarra),'1','0',$NumElectrolisis,'9',$CookieRut,'M',$Fecha,'0');
			}
			else
			{
				//Insertar
				$NumElectrolisis=str_replace(".","",$NumElectrolisis);
				$NumElectrolisis=str_replace(",",".",$NumElectrolisis);
				$NumBarra=str_replace(".","",$NumBarra);
				$NumBarra=str_replace(",",".",$NumBarra);
				$PesoBarra=str_replace(".","",$PesoBarra);
				$PesoBarra=str_replace(",",".",$PesoBarra);
				$Insertar = "INSERT INTO pmn_web.carga_fusion_oro ";
				$Insertar.= "(rut, fecha, num_electrolisis, num_barra, peso,tipo) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$NumElectrolisis."','".$NumBarra."','".$PesoBarra."','".$CmbTipoF."')";
				mysqli_query($link, $Insertar);
				
				//Movimientos_Pmn('','34','4','2',str_replace(",",".",$PesoBarra),'1','0',$NumElectrolisis,'9',$CookieRut,'I',$Fecha,'0');
			}
			header("location:pmn_principal_reportes.php?MostrarFOro=S&DiaCForo=".$DiaCForo."&MesCForo=".$MesCForo."&AnoCForo=".$AnoCForo."&NumElectrolisis=".$NumElectrolisis."&CmbTipoF=".$CmbTipoF."&Tab7=true");
			break;
		case "M":
			/*echo "electrolisis".$p."<br>";
			echo "barra".$ChkBarra[$i]."<br>";
			echo "peso".$ChkPeso[$i]."<br>";
			echo "muestra".$ChkMuestra[$i]."<br>";
			echo "sobrante".$ChkSobrante[$i]."<br>";
			echo "tipo".$ChkTipo[$i]."<br>";	
			echo "correlativo".$ChkCorrelativo[$i]."<br>";																			*/
					
/*			if (count($ChkElectrolisis1)>0)
			{
*/				
				$Datos=explode('~',$Datos);
				if (($Datos[5]!='4')&& ($Datos[5]!='6'))
				{
					header("location:pmn_principal_reportes.php?MostrarFOro=S&DiaCForo=".$DiaCForo."&MesCForo=".$MesCForo."&AnoCForo=".$AnoCForo."&NumElectrolisis=".$Datos[0]."&NumBarra=".$Datos[1]."&PesoBarra=".$Datos[2]."&Correlativo=".$Datos[6]."&CmbTipoF=".$Datos[5]."&Tab7=true");
				}
				else
				{
					if ($Datos[5]=='4')
					{
						header("location:pmn_principal_reportes.php?MostrarFOro=S&Opcion=S&DiaCForo=".$DiaCForo."&MesCForo=".$MesCForo."&AnoCForo=".$AnoCForo."&NumElectrolisis=".$Datos[0]."&NumBarra=".$Datos[1]."&PesoBarra=".$Datos[2]."&Correlativo=".$Datos[6]."&CmbTipoF=".$Datos[5]."&Tab7=true");					
					}
					else
					{
						header("location:pmn_principal_reportes.php?MostrarFOro=S&Sobrante=S&DiaCForo=".$DiaCForo."&MesCForo=".$MesCForo."&AnoCForo=".$AnoCForo."&NumElectrolisis=".$Datos[0]."&NumBarra=".$Datos[1]."&PesoBarra=".$Datos[2]."&Correlativo=".$Datos[6]."&CmbTipoF=".$Datos[5]."&Tab7=true");									
					}
				}
/*			}
			else
			{
				header("location:pmn_principal_reportes.php?MostrarFOro=S&DiaCForo=".$DiaCForo."&MesCForo=".$MesCForo."&AnoCForo=".$AnoCForo."&Tab7=true");
			}
*/			break;
		case "E":
			// ELIMINA CABECERA
			$Eliminar = "delete from pmn_web.carga_fusion_oro ";
			$Eliminar.= " where fecha = '".$AnoCForo."-".$MesCForo."-".$DiaCForo."'";
			mysqli_query($link, $Eliminar);
			// ELIMINA DETALLE
			$Eliminar = "delete from pmn_web.carga_fusion_oro ";
			$Eliminar.= " where fecha = '".$AnoCForo."-".$MesCForo."-".$DiaCForo."'";
			mysqli_query($link, $Eliminar);
						
			header("location:pmn_principal_reportes.php?DiaCForo=".$DiaCForo."&MesCForo=".$MesCForo."&AnoCForo=".$AnoCForo."&Tab7=true");
			break;
		case "E2":
			//if (count($ChkElectrolisis1)>0)
			//{
				$Datos=explode('//',$Datos);				
				while (list($i,$p) = each($Datos))
				{
					$Dato=explode('~',$p);
					$Eliminar = "delete from pmn_web.carga_fusion_oro ";
					$Eliminar.= " where fecha = '".$AnoCForo."-".$MesCForo."-".$DiaCForo."'";
					//$Eliminar.= " and num_electrolisis = '".$p."'";
					$Eliminar.= " and correlativo = '".$Dato[6]."'";
					mysqli_query($link, $Eliminar);
					
					//Movimientos_Pmn('','34','4','2','0','1','0',$NumElectrolisis,'9',$CookieRut,'E',$AnoCForo."-".str_pad($MesCForo,'2','0',STR_PAD_LEFT)."-".$DiaCForo,'0');
					
				}
			//}
			header("location:pmn_principal_reportes.php?MostrarFOro=S&DiaCForo=".$DiaCForo."&MesCForo=".$MesCForo."&AnoCForo=".$AnoCForo."&NumElectrolisis=".$NumElectrolisis."&Tab7=true");
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?&Tab7=true");
			break;
		case "Muestra":
			/*echo "Resto Humedo".$PesoRestoH."<br>";
			echo "Resto Caliente".$PesoRestoC."<br>";
			echo "Resto Frio".$PesoRestoF."<br>";*/
			$Mtra=str_replace(".","",$Mtra);
			$Mtra=str_replace(",",".",$Mtra);
			$Actualizar="UPDATE pmn_web.carga_fusion_oro set mtra='".$Mtra."', muestra='S'"; 	
			$Actualizar.=" where fecha ='".$Fe."' and num_electrolisis = '".$Elect."' and correlativo ='".$Corr."' ";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			
			//echo $Fe."<br>";
			$AMD=explode('-',$Fe);
			$A=$AMD[0];
			$Mes=$AMD[1];
			$Dia=$AMD[2];
			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?FFOro=".$Fe."&AnitoCForo=".$A."&MCForo=".$Mes."&DCForo=".$Dia."&MostrarFOro=S"."&Op=S&Tab7=true';";
			echo "window.opener.document.frmPrincipalRpt.submit();";
			echo "window.close();</script>";
			
			break;
		case "Muestra2":
			$Mtra=str_replace(".","",$Mtra);
			$Mtra=str_replace(",",".",$Mtra);
			$Actualizar="UPDATE pmn_web.carga_fusion_oro set mtra='".$Mtra."',muestra='S' ";//,ca=".$Ca.","; 	
			//$Actualizar.=" peso_caliente=".$PesoC.",peso_frio=".$PesoF.",muestra='S',";						
			//$Actualizar.=" resto_peso_caliente = '".$PesoRestoC."',resto_peso_frio='".$PesoRestoF."' ";
			$Actualizar.=" where fecha ='".$Fe."' and num_barra = '".$Barra."' and correlativo ='".$Corr."' ";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);

			$AMD=explode('-',$Fe);
			$A=$AMD[0];
			$Mes=$AMD[1];
			$Dia=$AMD[2];
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?FFOro=".$Fe."&AnitoCForo=".$A."&MCForo=".$Mes."&DCForo=".$Dia."&MostrarFOro=S"."&Sobrante=S&Tab7=true';";
			echo "window.opener.document.frmPrincipalRpt.submit();";
			echo "window.close();</script>";
			break;
		
		case "Sobrante":
			$PesoS=str_replace(".","",$PesoS);
			$PesoS=str_replace(",",".",$PesoS);
			$Actualizar="UPDATE pmn_web.carga_fusion_oro set peso_sobrante=".$PesoS.",sobrante='S' "; 	
			$Actualizar.="where fecha ='".$Fe."' and num_electrolisis = '".$Elect."' and correlativo ='".$Corr."' ";
			mysqli_query($link, $Actualizar);
			$AMD=explode('-',$Fe);
			$A=$AMD[0];
			$Mes=$AMD[1];
			$Dia=$AMD[2];
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?FFOro=".$Fe."&AnitoCForo=".$A."&MCForo=".$Mes."&DCForo=".$Dia."&MostrarFOro=S"."&OpFOro=S&Tab7=true';";
			echo "window.opener.document.frmPrincipalRpt.submit();";
			echo "window.close();</script>";
		break;	
		/*case "Embalaje":
			for($j= 0;$j <= strlen($ElectBarras); $j++)
			{
				if (substr($ElectBarras,$j,2) == "//")
				{
					$ElecBarra =substr($ElectBarras,0,$j);	
					for ($x=0;$x<= strlen($ElecBarra);$x++)
					{
						if (substr($ElecBarra,$x,2) == "~~")
						{
							$Electrolisis = substr($ElecBarra,0,$x);
							$Barra = substr($ElecBarra,$x+2,strlen($ElecBarra));
							$Actualizar="UPDATE pmn_web.carga_fusion_oro set peso_bruto=".$PesoBruto.",nro_sello='".$Sello."' "; 	
							$Actualizar.="where fecha ='".$Fe."' and num_electrolisis = '".$Electrolisis."' and num_barra ='".$Barra."' ";
							mysqli_query($link, $Actualizar);
						}	
					}	
					$ElectBarras = substr($ElectBarras,$j + 2);
					$j = 0;
				}
			}
			$A=substr($Fe,0,4);
			$Mes=substr($Fe,5,2);
			$Dia=substr($Fe,8,2);			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='pmn_carga_fusion_oro.php?F=".$Fe."&Anito=".$A."&M=".$Mes."&D=".$Dia."&Mostrar=S"."&Op=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
		/*case "Acta":	
			for($j= 0;$j <= strlen($ElectBarras); $j++)
			{
				if (substr($ElectBarras,$j,2) == "//")
				{
					$ElecBarra =substr($ElectBarras,0,$j);	
					for ($x=0;$x<= strlen($ElecBarra);$x++)
					{
						if (substr($ElecBarra,$x,2) == "~~")
						{
							$Electrolisis = substr($ElecBarra,0,$x);
							$Barra = substr($ElecBarra,$x+2,strlen($ElecBarra));
							$Actualizar="UPDATE pmn_web.carga_fusion_oro set num_acta=".$TxtActa.",fecha_acta='".$FechaActa."' "; 	
							$Actualizar.="where fecha ='".$Fe."' and num_electrolisis = '".$Electrolisis."' and num_barra ='".$Barra."' ";
							//echo $Actualizar."<br>";
							mysqli_query($link, $Actualizar);
						}	
					}	
					$ElectBarras = substr($ElectBarras,$j + 2);
					$j = 0;
				}
			}
			$A=substr($Fe,0,4);
			$Mes=substr($Fe,5,2);
			$Dia=substr($Fe,8,2);			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='pmn_carga_fusion_oro.php?F=".$Fe."&Anito=".$A."&M=".$Mes."&D=".$Dia."&Mostrar=S"."&Op=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";*/
		break;
	}
?>