<?php
include("../principal/conectar_principal.php");
$FechaHora = date("Y-m-d h:i");
$Rut =$CookieRut;

switch ($Opcion)
{
	case "G":
		for($j=0;$j <= strlen($Correlativo); $j++)
		{
			if (substr($Correlativo,$j,2) == "//")
			{
				$CorSol =substr($Correlativo,0,$j);	
				for ($x=0;$x<= strlen($CorSol);$x++)
				{
					if (substr($CorSol,$x,2) == "~~")
					{
					$Numero = substr($CorSol,0,$x);
					$SA = substr($CorSol,$x+2,strlen($CorSol));
					//actualiza tabla certficados el campo estado con activo
					$Actualizar= "UPDATE cal_web.certificados set estado ='A' where nro_certificado = ".$Numero;
					mysqli_query($link, $Actualizar);
					//actualiza la tabla solictud de analisis colocandole estdao 15 a la sol de analisis  
					//$Actualizar= "UPDATE cal_web.solicitud_analisis set estado_actual ='15' where nro_solicitud = '".$SA."'";
					//mysqli_query($link, $Actualizar);
					//consulta que rescata los nro de solictud de analisis que tienen estado 6
					/*$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$SA."' and cod_estado = '6' ";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
					$RutFunc = $Fila["rut_funcionario"];
					$Recargo = $Fila["recargo"];
					//inserta registro en estados_por_solicitud con el nuevo registro y estado6  
					$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora)";
					$insertar.="values ('".$RutFunc."','".$SA."','".$Recargo."','15','".$FechaHora."')";
					mysqli_query($link, $insertar);
					}*/
					$Correlativo = substr($Correlativo,$j + 2);
					$j = 0;
					}
				}	
			}	
		}
		break;
}
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmGeneracion.action='cal_generacion_certificados.php?SA=".$SA02."&Mostrar=I';";
		echo "window.opener.document.FrmGeneracion.submit();";
		echo "window.close();</script>";
		//header("location:../cal_web/cal_generacion_certificados.php");*/
?>
