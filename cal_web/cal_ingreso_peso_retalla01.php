<?php
	include("../principal/conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];
	$RutQ=$CookieRut;

	$Valores = $_REQUEST["Valores"];
	$ValoresSA = $_REQUEST["ValoresSA"];


	for ($f=0;$f<=strlen($Valores);$f++)
	{
		if (substr($Valores,$f,2)=="//")
		{
			$SAValor=substr($Valores,0,$f);
			$SA=substr($SAValor,0,10);
			$Valor=substr($SAValor,12);
			$Valor=str_replace(",",".",$Valor);
			$Actualizar="UPDATE cal_web.solicitud_analisis set peso_retalla=".$Valor." where nro_solicitud=".$SA." and recargo='R'";
			mysqli_query($link, $Actualizar);
			$Valores=substr($Valores,$f+2);
			$f=0;
			$Consulta="select * from cal_web.solicitud_analisis where nro_solicitud=".$SA." and recargo='R'";
			$RespRetalla=mysqli_query($link, $Consulta);
			$FilaRetalla=mysqli_fetch_array($RespRetalla);
			$FechaReg = date('Y-m-d H:i:s');
			$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
			$Insertar=$Insertar.$SA.",'".$FechaReg."','".$FilaRetalla["rut_funcionario"]."','".$FilaRetalla["recargo"]."','PES.MAT','".$Valor."','','','','".$RutQ."')";
			mysqli_query($link, $Insertar);
		}
	}
	echo "<script languaje='JavaScript'>";		
	echo " window.opener.document.FrmIngresoValorRetalla.action='cal_ingreso_valor_retalla.php?ValoresSA=".$ValoresSA."';";
	echo " window.opener.document.FrmIngresoValorRetalla.submit();";		
	echo " window.close();</script>";		
?>