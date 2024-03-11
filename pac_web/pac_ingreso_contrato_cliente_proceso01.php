<?php
	include("../principal/conectar_pac_web.php");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$ProcesoAux  = isset($_REQUEST["ProcesoAux"])?$_REQUEST["ProcesoAux"]:"";
	$FechaHora   = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";
	
	$CmbCliente  = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$TxtContrato  = isset($_REQUEST["TxtContrato"])?$_REQUEST["TxtContrato"]:"";
	$TxtNroControl  = isset($_REQUEST["TxtNroControl"])?$_REQUEST["TxtNroControl"]:"";
	$CmbNumCuotas  = isset($_REQUEST["CmbNumCuotas"])?$_REQUEST["CmbNumCuotas"]:"";	
	$TxtTotalToneladas  = isset($_REQUEST["TxtTotalToneladas"])?$_REQUEST["TxtTotalToneladas"]:"";
	$CmbMesInicio  = isset($_REQUEST["CmbMesInicio"])?$_REQUEST["CmbMesInicio"]:"";
	$CmbAnoInicio  = isset($_REQUEST["CmbAnoInicio"])?$_REQUEST["CmbAnoInicio"]:"";
	$CmbMesFinal  = isset($_REQUEST["CmbMesFinal"])?$_REQUEST["CmbMesFinal"]:"";
	$CmbAnoFinal  = isset($_REQUEST["CmbAnoFinal"])?$_REQUEST["CmbAnoFinal"]:"";
	$CmbDia  = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:"";
	$CmbMes  = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno  = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";

	$TxtToneladas  = isset($_REQUEST["TxtToneladas"])?$_REQUEST["TxtToneladas"]:"";

	$Fecha=$CmbAno."-".$CmbMes."-".$CmbDia;

	echo $Proceso."<br>";
	switch ($Proceso)
	{
		case "N": //GRABAR CONTRATO
			$Consulta="select * from pac_web.contrato_cliente ";
			$Consulta.=" where nro_contrato = '".$TxtContrato."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Mostrar='S';
				//echo "existe";
			}
			else
			{
				$Insertar = "insert into pac_web.contrato_cliente ";
				$Insertar.= "(rut_cliente,nro_contrato,correlativo,nro_cuotas,toneladas,mes_inicio,mes_final,ano_inicio,ano_final) ";
				$Insertar.= "values('".$CmbCliente."','".$TxtContrato."','".$TxtNroControl."','".$CmbNumCuotas."','".str_replace(",",".",$TxtTotalToneladas)."','".$CmbMesInicio."','".$CmbMesFinal."','".$CmbAnoInicio."','".$CmbAnoFinal."')";
				mysqli_query($link, $Insertar);
				$CmbCliente="";
				//echo $Insertar;
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmIngContrato.action='pac_ingreso_contrato_cliente.php';";
			echo "window.opener.document.FrmIngContrato.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "A"://AGREGAR DETALLE(SI NO HAY CONTRATO Y QUIERE AGREGAR DETALLE INSERTA EL CONTRATO)
			$Consulta="select * from pac_web.contrato_cliente ";
			$Consulta.=" where nro_contrato = '".$TxtContrato."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if (!$Fila=mysqli_fetch_array($Respuesta))
			{
				$Insertar = "insert into pac_web.contrato_cliente ";
				$Insertar.= "(rut_cliente,nro_contrato,correlativo,nro_cuotas,toneladas,mes_inicio,mes_final,ano_inicio,ano_final) ";
				$Insertar.= "values('".$CmbCliente."','".$TxtContrato."','".$TxtNroControl."','".$CmbNumCuotas."','".str_replace(",",".",$TxtTotalToneladas)."','".$CmbMesInicio."','".$CmbMesFinal."','".$CmbAnoInicio."','".$CmbAnoFinal."')";
				mysqli_query($link, $Insertar);
				$Valores=$CmbCliente."~~".$TxtContrato."//";
				$ProcesoAux='M';
			}
			$Consulta="select toneladas from pac_web.contrato_cliente where nro_contrato='".$TxtContrato."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$FilaTon=mysqli_fetch_array($Respuesta);
			$TotToneladasContrato=$FilaTon["toneladas"];
			$Consulta="select sum(toneladas) as TotalToneladas from pac_web.detalle_contrato ";
			$Consulta.=" where nro_contrato = '".$TxtContrato."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$FilaTon=mysqli_fetch_array($Respuesta);
			$Consulta="select * from pac_web.detalle_contrato ";
			$Consulta.=" where nro_contrato = '".$TxtContrato."' and fecha='".$Fecha."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$TotToneladasDetalle=$FilaTon["TotalToneladas"] + (str_replace(",",".",$TxtToneladas)-$Fila["toneladas"]);
				if ($TotToneladasContrato>=$TotToneladasDetalle)
				{
					$Actualizar="UPDATE pac_web.detalle_contrato set toneladas='".str_replace(",",".",$TxtToneladas)."' where nro_contrato='".$TxtContrato."' and fecha ='".$Fecha."'";
					mysqli_query($link, $Actualizar);
				}	
				else
				{
					$Mostrar2="S";
				}	
			}
			else
			{
				$TotToneladasDetalle=$FilaTon["TotalToneladas"] + str_replace(",",".",$TxtToneladas);
				if ($TotToneladasContrato>=$TotToneladasDetalle)
				{
					$Insertar="insert into pac_web.detalle_contrato (nro_contrato,fecha,toneladas) values (";
					$Insertar=$Insertar."'$TxtContrato','$Fecha','".str_replace(",",".",$TxtToneladas)."')";
					mysqli_query($link, $Insertar);
				}	
				else
				{
					$Mostrar2="S";
				}	
			}
			header("location:pac_ingreso_contrato_cliente_proceso.php?Mostrar2=".$Mostrar2."&Proceso=".$ProcesoAux."&Valores=".$Valores);		
			break;
				
		case "M": //MODIFICA LOS DATOS DEL CONTRATO
			$Actualizar="UPDATE pac_web.contrato_cliente set nro_cuotas='".$CmbNumCuotas."',toneladas='".str_replace(",",".",$TxtTotalToneladas)."',";
			$Actualizar=$Actualizar."mes_inicio='".$CmbMesInicio."',ano_inicio='".$CmbAnoInicio."',mes_final='".$CmbMesFinal."',";
			$Actualizar=$Actualizar."ano_final='".$CmbAnoFinal."' where rut_cliente='".$TxtRutCliente."' and nro_contrato='".$TxtContrato."'";
			mysqli_query($link, $Actualizar);
			header("location:pac_ingreso_contrato_cliente_proceso.php?Proceso=".$Proceso."&Valores=".$Valores);		
			break;
		case "E"://ELIMINA EL CONTRATO Y TODO SU DETALLE
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$RutContrato=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($RutContrato);$j++)
					{
						if (substr($RutContrato,$j,2)=="~~")
						{
							$RutCliente=substr($RutContrato,0,$j);
							$Contrato=substr($RutContrato,$j+2);
							$Eliminar = "delete from  pac_web.contrato_cliente ";
							$Eliminar.= " where nro_contrato='".$Contrato."'"; 
							$Eliminar.= " and rut_cliente='".$RutCliente."'";
							mysqli_query($link, $Eliminar);
							$Eliminar = "delete from  pac_web.detalle_contrato";
							$Eliminar.= " where nro_contrato='".$Contrato."'"; 
							mysqli_query($link, $Eliminar);
						}
					}						
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			header("location:pac_ingreso_contrato_cliente.php");
			break;
		case "B"://BUSCAR UN DETALLE
			$Consulta="select * from pac_web.detalle_contrato where nro_contrato='".$TxtContrato."' and fecha ='".$Fecha."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				header("location:pac_ingreso_contrato_cliente_proceso.php?Proceso=".$ProcesoAux."&Valores=".$Valores."&TxtToneladas=".str_replace(".",",",$Fila["toneladas"])."&CmbDia=".$CmbDia."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno);		
			}
			else
			{
				header("location:pac_ingreso_contrato_cliente_proceso.php?Proceso=".$ProcesoAux."&Valores=".$Valores);		
			}
			break;
		case "ED"://ELIMINAR DETALLE
			$Consulta="select * from pac_web.detalle_contrato where nro_contrato='".$TxtContrato."' and fecha ='".$Fecha."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Eliminar="delete from pac_web.detalle_contrato where nro_contrato='".$TxtContrato."' and fecha ='".$Fecha."'";
				mysqli_query($link, $Eliminar);
			}
			header("location:pac_ingreso_contrato_cliente_proceso.php?Proceso=".$ProcesoAux."&Valores=".$Valores);		
			break;

	}
?>