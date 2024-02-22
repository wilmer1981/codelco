<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $AnoBarraOro."-".str_pad($MesBarraOro,'2','0',STR_PAD_LEFT)."-".$DiaBarraOro;
	
	$PesoBarra=str_replace(".","",$PesoBarra);
	$PesoBarra=str_replace(",",".",$PesoBarra);
	$NumActa=str_replace(".","",$NumActa);
	$NumActa=str_replace(",",".",$NumActa);
	switch ($Proceso)
	{
		case "G2": //GRABAR
			$Consulta = "select * from pmn_web.embarque_oro ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and num_barra = '".$NumBarra."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.embarque_oro set ";
				$Actualizar.= " peso_neto_barra = '".$PesoBarra."', ";
				$Actualizar.= " num_acta = '".$NumActa."' ";
				$Actualizar.= " where fecha = '".$Fecha."' ";				
				$Actualizar.= " and num_barra = '".$NumBarra."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				
				//Movimientos_Pmn('','34','4','4',str_replace(",",".",$PesoBarra),'1','0',$NumBarra,'12-2',$CookieRut,'M',$Fecha,'0');
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.embarque_oro ";
				$Insertar.= "(rut, fecha,num_barra,peso_neto_barra,num_acta) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$NumBarra."','".$PesoBarra."','".$NumActa."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
				
				//Movimientos_Pmn('','34','4','4',str_replace(",",".",$PesoBarra),'1','0',$NumBarra,'12-2',$CookieRut,'I',$Fecha,'0');
			}
			header("location:pmn_principal_reportes.php?MostrarBarraOro=S&DiaBarraOro=".$DiaBarraOro."&MesBarraOro=".$MesBarraOro."&AnoBarraOro=".$AnoBarraOro."&Tab9=true&TabEmba1=true");
			break;
		case "M":
			
/*			if (count($ChkBarra1)>0)
			{
				while (list($i,$p) = each($ChkBarra1))
				{
*/					$Datos=explode('~',$Datos);
					header("location:pmn_principal_reportes.php?MostrarBarraOro=S&DiaBarraOro=".$DiaBarraOro."&MesBarraOro=".$MesBarraOro."&AnoBarraOro=".$AnoBarraOro."&NumBarra=".$Datos[0]."&PesoBarra=".$Datos[1]."&Tab9=true&TabEmba1=true");//."&PesoBarra=".$ChkPeso[$i]."&Obs2=".$ChkObs2[$i]);
/*				}
			}
			else
			{
				header("location:pmn_principal_reportes.php?MostrarBarraOro=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Tab9=true&TabEmba1=true");
			}
*/		break;
		case "E2":
/*			if (count($ChkBarra1)>0)
			{
				while (list($i,$p) = each($ChkBarra1))
				{				
*/				
					//echo $Datos;
					$Datos=explode('//',$Datos);
					while (list($i,$p) = each($Datos))
					{
						$Datos2=explode('~',$p);
						$Eliminar = "delete from pmn_web.embarque_oro ";
						$Eliminar.= " where fecha = '".$AnoBarraOro."-".$MesBarraOro."-".$DiaBarraOro."'";
						$Eliminar.= " and num_barra = '".$Datos2[0]."'";
						//echo $Eliminar."<br>";
						mysqli_query($link, $Eliminar);
						
						//Movimientos_Pmn('','34','4','4','0','1','0',$Datos2[0],'12-2',$CookieRut,'E',$AnoBarraOro."-".str_pad($MesBarraOro,'2','0',STR_PAD_LEFT)."-".$DiaBarraOro,'0');
					}
				//}
			//}
			header("location:pmn_principal_reportes.php?MostrarBarraOro=S&DiaBarraOro=".$DiaBarraOro."&MesBarraOro=".$MesBarraOro."&AnoBarraOro=".$AnoBarraOro."&Tab9=true&TabEmba1=true");
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?&Tab9=true&TabEmba1=true");
			break;
		case "Valores":
			$PesoBruto=str_replace('.','',$PesoBruto);
			$PesoBruto=str_replace(',','.',$PesoBruto);
			$Valor=str_replace('.','',$Valor);
			$Valor=str_replace(',','.',$Valor);
			$PesoNeto=str_replace('.','',$PesoNeto);
			$PesoNeto=str_replace(',','.',$PesoNeto);
			$Sello=str_replace('.','',$Sello);
			$Sello=str_replace(',','.',$Sello);
			for($j= 0;$j <= strlen($Barras); $j++)
			{
				if (substr($Barras,$j,2) == "//")
				{
					$Barra =substr($Barras,0,$j);	
					$Actualizar="UPDATE pmn_web.embarque_oro set peso_neto_caja='".$PesoNeto."',";
					$Actualizar.="peso_bruto_caja='".$PesoBruto."', ";
					$Actualizar.="valor_declarado='".$Valor."', ";
					$Actualizar.="num_sello='".$Sello."' ";
					$Actualizar.=" where num_barra='".$Barra."'			";
					$Actualizar.=" and fecha = '".$Ano."-".$Mes."-".$Dia."'";
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
					$Barras = substr($Barras,$j + 2);
					$j = 0;
				}
			}
			//echo "fecha:      ".$Fecha;
			//$Fecha=explode('-',$Fecha);
			//$Ano=$Fecha[0];
			//$Mes=$Fecha[1];
			//$Dia=$Fecha[2];			
			/*echo $A."<br>";
			echo $Mes."<br>";
			echo $Dia."<br>";*/
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?FBarraOro=".$Fe."&AnoBarraOro=".$Ano."&MesBarraOro=".$Mes."&DiaBarraOro=".$Dia."&MostrarBarraOro=S&Op=S&Tab9=true&TabEmba1=true';";
			echo "window.opener.document.frmPrincipalRpt.submit();";
			echo "window.close();</script>";
		break;
		case "Acta":
			$Actualizar="UPDATE pmn_web.embarque_oro set num_acta='".$NumActa."' where ";
			$Actualizar.=" fecha = '".$Ano."-".$Mes."-".$Dia."' ";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?FBarraOro=".$Fe."&AnoBarraOro=".$Ano."&MesBarraOro=".$Mes."&DiaBarraOro=".$Dia."&MostrarBarraOro=S&Op=S&Tab9=true&TabEmba1=true';";
			echo "window.opener.document.frmPrincipalRpt.submit();";
			echo "window.close();</script>";	
			break;
	}
?>