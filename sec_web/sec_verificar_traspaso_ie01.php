<?php 	
	include("../principal/conectar_principal.php");

	$CookieRut = $_COOKIE["CookieRut"];
	$Rut = $CookieRut;
	$Valores = $_REQUEST["Valores"];
	$CmbDias = $_REQUEST["CmbDias"];
	$CmbMes  = $_REQUEST["CmbMes"];
	$CmbAno  = $_REQUEST["CmbAno"];

	$Fecha=date('Y-m-d H:i:s');	
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Hora = date("H").':'.date("i").':'.date("s");
		$FechaHora=$CmbAno."-".$CmbMes."-".$CmbDias." ".$Hora;
		$Datos2=explode('~~',$Valor);
		$IE  = $Datos2[0];
		$Tipo= $Datos2[1];
		switch ($Tipo)
		{
			case "E":
				$Actualizar="UPDATE sec_web.programa_enami set estado3='C',fecha_confirmacion='$Fecha',usuario='$Rut' where corr_enm=".$IE;
				mysqli_query($link, $Actualizar);
				break;
			case "C":
				$Actualizar="UPDATE sec_web.programa_codelco set estado3='C' ,fecha_confirmacion='$Fecha',usuario='$Rut' where corr_codelco=".$IE;
				mysqli_query($link, $Actualizar);
				break;
		}
	}	
	header('location:sec_verificar_traspaso_ie.php');
	/*$Cont=0;
	$Consulta="select cod_bulto,num_bulto,corr_enm from sec_web.embarque_ventana where left(fecha_envio,4)=2004";
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Consulta2="select * from sec_web.lote_catodo where cod_bulto='".$Fila["cod_bulto"]."' and num_bulto=".$Fila["num_bulto"]." and corr_enm=".$Fila["corr_enm"];
		$Respuesta2=mysqli_query($link, $Consulta2);
		if ($Fila2=mysqli_fetch_array($Respuesta2))
		{
			
		}
		else
		{
			$Actualizar="UPDATE sec_web.lote_catodo set corr_enm='".$Fila["corr_enm"]."' where cod_bulto='".$Fila["cod_bulto"]."' and num_bulto=".$Fila["num_bulto"]." and left(fecha_creacion_lote,4)=2004";
			mysqli_query($link, $Actualizar);
			echo $Actualizar."<br>";
			$Cont++;
		}
	}
	echo "TERMINO CANTIDAD:".$Cont;	*/
?>
