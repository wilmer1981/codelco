<?php
	include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	$FechaSalida = $AnoSalida."-".$MesSalida."-".$DiaSalida;
	$FechaMovimiento=date("Y-m-d h:i");
	$Rut=$CookieRut;
	switch ($Proceso)
	{

		case "GD":
			if ($Prod == '39')
			{
				$Consulta ="select * from pmn_web.observaciones ";
				$Consulta.=" where fecha = '".$Ano."-".$Mes."-".$Dia."'";	
				$Consulta.=" and num_horno = '".$NumHorno."'";
				$Consulta.=" and num_funda='".$NumFunda."'";
				$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
				$Consulta.=" and hornada_parcial='".$HornadaParcial."'";
				$Consulta.=" and turno = '".$Turno."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					$Actualizar="UPDATE pmn_web.observaciones set num_horno = '".$NumHorno1."'";
					$Actualizar.=" ,num_funda = '".$NumFunda1."',hornada_total = '".$HornadaTotal1."',hornada_parcial ='".$HornadaParcial1."'";
					$Actualizar.=" where num_horno = '".$Row[num_horno]."'";
					$Actualizar.=" and num_funda= '".$Row[num_funda]."'";
					$Actualizar.=" and hornada_total = '".$Row[hornada_total]."'";
					$Actualizar.=" and hornada_parcial='".$Row[hornada_parcial]."'";
					$Actualizar.=" and fecha = '".$Ano."-".$Mes."-".$Dia."'";	
					$Actualizar.=" and turno = '".$Turno."'";
					//echo $Actualizar;
					mysqli_query($link, $Actualizar);
					$Prod01 = $Row["cod_producto"];
					$Subp01 = $Row["cod_subproducto"];
				}	
			}
			else
			{
				
				
				$Consulta = "Select * from pmn_web.deselenizacion ";
				$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
				$Consulta.= " and num_horno = '".$NumHorno."'";
				$Consulta.=" and num_funda='".$NumFunda."'";
				$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
				$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
				$Consulta.= " and turno = '".$Turno."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					
					$Actualizar = "UPDATE pmn_web.deselenizacion set num_horno = '".$NumHorno1."'";
					$Actualizar.=" ,num_funda = '".$NumFunda1."',hornada_total = '".$HornadaTotal1."',hornada_parcial ='".$HornadaParcial1."'";
					$Actualizar.=" ,hornada =  '".$NumHorno1."-".$NumFunda1."-".$HornadaTotal1."-".$HornadaParcial1."'";
					$Actualizar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Actualizar.= " and num_horno = '".$NumHorno."'";
					$Actualizar.= " and num_funda = '".$NumFunda."'";
					$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
					$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
					$Actualizar.= " and turno = '".$Turno."'";
					//echo "29: ".$Actualizar."<br>";
					mysqli_query($link, $Actualizar);
				}	
				$consulta = " SELECT * FROM pmn_web.detalle_deselenizacion";
				$consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
				$consulta.= " and num_horno = '".$NumHorno."'";
				$consulta.= " and num_funda = '".$NumFunda."'";
				$consulta.= " and hornada_total = '".$HornadaTotal."'";
				$consulta.= " and hornada_parcial = '".$HornadaParcial."'";
				$consulta.= " and turno = '".$Turno."'";
				$rs10 = mysqli_query($link, $consulta);
				while  ($row10 = mysqli_fetch_array($rs10))
				{
					$Actualizar = "UPDATE pmn_web.detalle_deselenizacion set num_horno = '".$NumHorno1."'";
					$Actualizar.=" ,num_funda = '".$NumFunda1."',hornada_total = '".$HornadaTotal1."',hornada_parcial ='".$HornadaParcial1."'";
					$Actualizar.=" ,hornada =  '".$NumHorno1."-".$NumFunda1."-".$HornadaTotal1."-".$HornadaParcial1."'";
					$Actualizar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Actualizar.= " and num_horno = '".$NumHorno."'";
					$Actualizar.= " and num_funda = '".$NumFunda."'";
					$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
					$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
					$Actualizar.= " and turno = '".$Turno."'";
					mysqli_query($link, $Actualizar);
					$consulta = "select * from movimientos";
					$consulta.= " where hornada = '".$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial."' and";
					$consulta.= " rut = '".$Row[rut]."'";
		
					
					$Respuesta = mysqli_query($link, $consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						$Actualizar= "UPDATE pmn_web.movimientos set hornada =  '".$NumHorno1.$NumFunda1.$HornadaTotal1.$HornadaParcial1."'";
						$Actualizar.= " where hornada = '".$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial."' and"; 
						$Actualizar.= " rut = '".$Row[rut]."'";
						//echo $Actualizar;
						mysqli_query($link, $Actualizar);
					}	
				}
			}	
			$Variables="ModifDese=S&Prod01=".$Prod01."&Subp01=".$Subp01."&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumHorno01=".$NumHorno1."&NumFunda01=".$NumFunda1."&HornadaTotal01=".$HornadaTotal1."&HornadaParcial01=".$HornadaParcial1."&Turno=".$Turno."&Tab8=true";
																									
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?".$Variables."';";
			echo "window.opener.document.frmPrincipalRpt.submit();";
			echo "window.close();</script>";
			break;
	}
?>