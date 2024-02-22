<?php
	include("../principal/conectar_pac_web.php");
	$Entrar=true;
	$Rut=str_replace('.','',$TxtRut)."-".$TxtDv;
	
	switch ($Proceso)
	{
		case "N":
			$Consulta="select * from pac_web.choferes where rut_chofer='".$Rut."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				header("location:pac_ingreso_choferes_proceso.php?EncontroCoincidencia=true");
				$Entrar=false;
			}
			else
			{
				$Insertar="insert into pac_web.choferes (rut_transportista,rut_chofer,nombre,direccion,registro,tipo) values (";
				$Insertar = $Insertar."'$CmbTransp','".$Rut."','$TxtNombre','$TxtDireccion','$TxtRegistro','$Tipo')";
				mysqli_query($link, $Insertar);
				
			}	
			break;
		case "M":
			$Modificar="UPDATE pac_web.choferes set nombre='$TxtNombre',direccion='$TxtDireccion',registro='$TxtRegistro',tipo='$Tipo' where rut_chofer='".$Rut."'";
			mysqli_query($link, $Modificar);
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$RutChofer=substr($Datos,0,$i);
					$Eliminar ="delete from pac_web.choferes where rut_chofer='".$RutChofer."'";
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
			header("location:pac_ingreso_choferes.php?EncontroRelacion=".$EncontroRelacion);
		}
		else
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmIngChoferes.action='pac_ingreso_choferes.php';";
			echo "window.opener.document.FrmIngChoferes.submit();";
			echo "window.close();";
			echo "</script>";
		}	
	}	
?>