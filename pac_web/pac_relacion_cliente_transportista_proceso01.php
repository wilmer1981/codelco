<?php
	include("../principal/conectar_pac_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Tipo    = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";

	$CmbCliente = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$CmbTransp = isset($_REQUEST["CmbTransp"])?$_REQUEST["CmbTransp"]:"";

	$Entrar=true;
	$Arr=explode('~',$CmbCliente);
	$CmbCliente=$Arr[0];
	$CorrInterno=$Arr[1];
	/*
	echo "Proceso:".$Proceso;
	echo "<br>CmbCliente:".$CmbCliente;
	echo "<br>CmbTransp:".$CmbTransp;
	*/
	
	switch ($Proceso)
	{
		case "N":
			$Consulta="select * from pac_web.relacion_cliente_transp where rut_cliente='$CmbCliente'and corr_interno_cliente='$CorrInterno' and rut_transportista='$CmbTransp'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				header("location:pac_relacion_cliente_transportista_proceso.php?EncontroCoincidencia=true");
				$Entrar=false;
			}
			else
			{
				$Insertar="insert into pac_web.relacion_cliente_transp (rut_cliente,rut_transportista,corr_interno_cliente) values (";
				$Insertar = $Insertar."'$CmbCliente','$CmbTransp','$CorrInterno')";
				//echo $Insertar;
				mysqli_query($link, $Insertar);
			}	
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=explode("//",$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode("~~",$Valor);			
				$Cliente=$Datos2[0];
				$Transp=$Datos2[1];
				$CorrCliente=$Datos2[2];
				$Eliminar ="delete from pac_web.relacion_cliente_transp where rut_cliente='$Cliente' and rut_transportista='$Transp' and corr_interno_cliente='$CorrCliente'";
				mysqli_query($link, $Eliminar);
			}
			break;	
	}
	if ($Entrar==true)
	{
		if ($Proceso=="E")
		{
			header("location:pac_relacion_cliente_transportista.php?EncontroRelacion=".$EncontroRelacion);
		}
		else
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmRelacion.action='pac_relacion_cliente_transportista.php';";
			echo "window.opener.document.FrmRelacion.submit();";
			echo "window.close();";
			echo "</script>";
		}	
	}	
?>