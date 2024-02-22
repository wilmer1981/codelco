<?php
	include("../principal/conectar_pac_web.php");
	$Entrar=true;
	$FechaRevTec=$CmbAnoRT."-".$CmbMesRT."-".$CmbDiaRT;
	$FechaCertEK=$CmbAnoCE."-".$CmbMesCE."-".$CmbDiaCE;
	switch ($Proceso)
	{
		case "N":
			$Consulta="select * from pac_web.camiones_por_transportista where nro_patente='".strtoupper($TxtPatente)."' and rut_transportista='".$CmbTransp."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				header("location:pac_ingreso_camiones_proceso.php?EncontroCoincidencia=true");
				$Entrar=false;
			}
			else
			{
				switch ($RadioTransp)
				{
					case "C":
						$Insertar="insert into pac_web.camiones_por_transportista (rut_transportista,nro_patente,marca,modelo,a�o,carga,tara,fecha_rev_tecnica,tipo,tipo2,rut_funcionario) values (";
						$Insertar = $Insertar."'$CmbTransp','".strtoupper($TxtPatente)."','$TxtMarca','$TxtModelo','$TxtA�o','$TxtCarga','$TxtTara','$FechaRevTec','$RadioTransp','$Tipo','$CookieRut')";
						break;
					case "R":
						$Insertar="insert into pac_web.camiones_por_transportista (rut_transportista,nro_patente,marca,modelo,a�o,carga,tara,fecha_rev_tecnica,fecha_cert_estanque,tipo,tipo2,rut_funcionario) values (";
						$Insertar = $Insertar."'$CmbTransp','".strtoupper($TxtPatente)."','$TxtMarca','$TxtModelo','$TxtA�o','$TxtCarga','$TxtTara','$FechaRevTec','$FechaCertEK','$RadioTransp','$Tipo','$CookieRut')";
						break;
					case "B":	
						$Insertar="insert into pac_web.camiones_por_transportista (rut_transportista,nro_patente,tipo) values (";
						$Insertar = $Insertar."'$CmbTransp','S/N','$RadioTransp')";
						break;
				}
				mysqli_query($link, $Insertar);
			}	
			break;
		case "M":
			$Consulta="select tipo from pac_web.camiones_por_transportista where nro_patente='".strtoupper($TxtPatente)."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			switch ($Fila[tipo])
			{
				case "C":
					$Modificar="UPDATE pac_web.camiones_por_transportista set marca='$TxtMarca',modelo='$TxtModelo',a�o='$TxtA�o',carga='$TxtCarga',tara='$TxtTara',fecha_rev_tecnica='$FechaRevTec',tipo2='$Tipo',rut_funcionario='$CookieRut' where nro_patente='".strtoupper($TxtPatente)."'";
					break;
				case "R":
					$Modificar="UPDATE pac_web.camiones_por_transportista set marca='$TxtMarca',modelo='$TxtModelo',a�o='$TxtA�o',carga='$TxtCarga',tara='$TxtTara',fecha_rev_tecnica='$FechaRevTec',fecha_cert_estanque='$FechaCertEK',tipo2='$Tipo',rut_funcionario='$CookieRut' where nro_patente='".strtoupper($TxtPatente)."'";
					break;
			}
			mysqli_query($link, $Modificar);	
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$Patente=substr($Datos,0,$i);
					$Eliminar ="delete from pac_web.camiones_por_transportista where nro_patente='".strtoupper($Patente)."'";
					mysqli_query($link, $Eliminar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Entrar==true)
	{
		if ($Proceso=="E")
		{
			header("location:pac_ingreso_camiones.php?CmbTransporte=-1&EncontroRelacion=".$EncontroRelacion);
		}
		else
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmIngCamiones.action='pac_ingreso_Camiones.php';";
			echo "window.opener.document.FrmIngCamiones.submit();";
			echo "window.close();";
			echo "</script>";
		}	
	}	
?>