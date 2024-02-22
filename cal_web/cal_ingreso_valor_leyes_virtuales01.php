<?php 
include("../principal/conectar_principal.php");
$RutQ=$CookieRut;
$Fecha = date('Y-m-d H:i');
$FechaReg = date('Y-m-d H:i:s');
$Fecha2=date("Y-m-d H:i:s");
$Valores = substr($Valores,0,strlen($Valores)-2);
switch ($Opcion)
{
	case "S":
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngLeyes.action='cal_adm_ingreso_leyes.php?Mostrar=S&Valores_Check=".$Valores."';";
		echo "window.opener.document.FrmIngLeyes.submit();";		
		echo "window.close();</script>";
		$Entrar=false;
		break;
	case "G":
		$Datos=explode('//',$Valores);
		while(list($c,$v)=each($Datos))
		{
			$Datos2=explode('~~',$v);
			$SA=$Datos2[0];
			$Recargo=$Datos2[1];
			$Rut=$Datos2[2];
			$CodLey=$Datos2[3];
			$Valor=str_replace(",",".",$Datos2[4]);
			$CodUnidad=$Datos2[5];
			if ($Recargo =='N')//SIN RECARGO
			{
				$Actualizar="UPDATE cal_web.leyes_por_solicitud set valor2=".$Valor.",cod_unidad='".$CodUnidad."',proceso = '6',rut_quimico='".$RutQ."'";
				$Actualizar.="where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$CodLey."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
				$Insertar=$Insertar.$SA.",'";
				$Insertar=$Insertar.$FechaReg."','";
				$Insertar=$Insertar.$Rut."','";
				$Insertar=$Insertar.$CodLey."',";
				$Insertar=$Insertar.$Valor.",'";
				$Insertar=$Insertar.$CodUnidad."',";
				$Insertar=$Insertar."'1','=','$RutQ')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			else
			{
				$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$CodUnidad."',proceso = '6',rut_quimico='".$RutQ."'";
				$Actualizar.="where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$CodLey."' and recargo='".$Recargo."'";
				mysqli_query($link, $Actualizar);
				$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
				$Insertar=$Insertar.$SA.",'";
				$Insertar=$Insertar.$FechaReg."','";
				$Insertar=$Insertar.$Rut."','";
				$Insertar=$Insertar.$Recargo."','";
				$Insertar=$Insertar.$CodLey."',";
				$Insertar=$Insertar.$Valor.",'";
				$Insertar=$Insertar.$CodUnidad."',";
				$Insertar=$Insertar."'1','=','$RutQ')";
				mysqli_query($link, $Insertar);
			}
		}
		break;
}	
header ("location:cal_ingreso_valor_leyes_virtuales.php?ValoresSA=".$ValoresSA."//");
?>