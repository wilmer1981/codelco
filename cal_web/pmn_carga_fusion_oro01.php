<?php
	include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G2": //GRABAR
			$Consulta = "select * from pmn_web.carga_fusion_oro ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			$Consulta.= " and num_barra = '".$NumBarra."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.carga_fusion_oro set ";
				$Actualizar.= " peso = '".str_replace(",",".",$PesoBarra)."' ";
				$Actualizar.= " where fecha = '".$Fecha."' ";				
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				$Actualizar.= " and num_barra = '".$NumBarra."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "insert into pmn_web.carga_fusion_oro ";
				$Insertar.= "(rut, fecha, num_electrolisis, num_barra, peso) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$NumElectrolisis."','".$NumBarra."','".str_replace(",",".",$PesoBarra)."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_carga_fusion_oro.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis);
			break;
		case "M":
			if (count($ChkElectrolisis1)>0)
			{
				while (list($i,$p) = each($ChkElectrolisis1))
				{
					header("location:pmn_carga_fusion_oro.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$p."&NumBarra=".$ChkBarra[$i]."&PesoBarra=".$ChkPeso[$i]."&Obs2=".$ChkObs2[$i]);
				}
			}
			else
			{
				header("location:pmn_carga_fusion_oro.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "E":
			// ELIMINA CABECERA
			$Eliminar = "delete from pmn_web.carga_fusion_oro ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			mysqli_query($link, $Eliminar);
			// ELIMINA DETALLE
			$Eliminar = "delete from pmn_web.carga_fusion_oro ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			mysqli_query($link, $Eliminar);
			header("location:pmn_carga_fusion_oro.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "E2":
			if (count($ChkElectrolisis1)>0)
			{
				while (list($i,$p) = each($ChkElectrolisis1))
				{
					$Eliminar = "delete from pmn_web.carga_fusion_oro ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and num_electrolisis = '".$p."'";
					$Eliminar.= " and num_barra = '".$ChkBarra[$i]."'";					
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_carga_fusion_oro.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis);
			break;
		case "C": //CANCELAR
			header("location:pmn_carga_fusion_oro.php");
			break;
		case "Muestra":
			/*echo "Resto Humedo".$PesoRestoH."<br>";
			echo "Resto Caliente".$PesoRestoC."<br>";
			echo "Resto Frio".$PesoRestoF."<br>";*/
			$Actualizar="UPDATE pmn_web.carga_fusion_oro set mtra=".$Mtra.",ca=".$Ca.","; 	
			$Actualizar.=" peso_humedo=".$PesoH.",peso_caliente=".$PesoC.",peso_frio=".$PesoF.",muestra='S',";						
			$Actualizar.=" resto_peso_humedo='".$PesoRestoH."',resto_peso_caliente = '".$PesoRestoC."',resto_peso_frio='".$PesoRestoF."' ";
			$Actualizar.="where fecha ='".$Fe."' and num_electrolisis = '".$Elect."' and num_barra ='".$Barra."' ";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			$A=substr($Fe,0,4);
			$Mes=substr($Fe,5,2);
			$Dia=substr($Fe,8,2);			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='pmn_carga_fusion_oro.php?F=".$Fe."&Anito=".$A."&M=".$Mes."&D=".$Dia."&Mostrar=S"."&Op=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
			break;
		case "Sobrante":
			$Actualizar="UPDATE pmn_web.carga_fusion_oro set peso_sobrante=".$PesoS.",sobrante='S' "; 	
			$Actualizar.="where fecha ='".$Fe."' and num_electrolisis = '".$Elect."' and num_barra ='".$Barra."' ";
			mysqli_query($link, $Actualizar);
			$A=substr($Fe,0,4);
			$Mes=substr($Fe,5,2);
			$Dia=substr($Fe,8,2);			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='pmn_carga_fusion_oro.php?F=".$Fe."&Anito=".$A."&M=".$Mes."&D=".$Dia."&Mostrar=S"."&Op=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;	
		case "Embalaje":
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
		case "Acta":	
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
			echo "window.close();</script>";
		break;
	}
?>