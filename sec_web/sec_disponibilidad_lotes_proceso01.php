<?php 	
	include("../principal/conectar_principal.php");

	$Valores       = $_REQUEST["Valores"];
	$CmbDispLotes  = $_REQUEST["CmbDispLotes"];
	$CmbDias = $_REQUEST["CmbDias"];
	$CmbMes  = $_REQUEST["CmbMes"];
	$CmbAno  = $_REQUEST["CmbAno"];
	
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$FechaHora=$CmbAno."-".$CmbMes."-".$CmbDias;
		$Datos2=explode('~~',$Valor);
		$Cod_Bulto = $Datos2[0];	
		$Num_Bulto = $Datos2[1];	
		$IE        = $Datos2[2];
		/*$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='".$CmbDispLotes."' where cod_bulto='".$Cod_Bulto."' and num_bulto=".$Num_Bulto." and corr_enm=".$IE." and cod_estado='a'";
		mysqli_query($link, $Actualizar);*/
		$Insertar="INSERT INTO sec_web.movimientos_disponibilidad (cod_bulto,num_bulto,corr_ie,disponibilidad,fecha_hora) values(";
		$Insertar=$Insertar."'$Cod_Bulto',$Num_Bulto,$IE,'$CmbDispLotes','$FechaHora')";
		mysqli_query($link, $Insertar);
	}	
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmDispLotes.action='sec_disponibilidad_lotes.php';";
	echo "window.opener.document.FrmDispLotes.submit();";
	echo "window.close();";
	echo "</script>";
	/*switch ($Proceso)
	{
		case "Lote":
		$Consulta=" SELECT * from sec_web.paquete_catodo ";
		$Consulta.=" where cod_paquete='B' and num_paquete ";
		$Consulta.=" between '71' and '199' and cod_estado='a' and fecha_creacion_paquete='2004-02-25' ";  
		$Respuesta=mysqli_query($link, $Consulta);
		$cant=0;
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$Peso=$Fila["peso_paquetes"]/1000;
			$Actualizar="UPDATE sec_web.paquete_catodo set peso_paquetes='".$Peso."' ";
			$Actualizar.=" where cod_paquete='B' and num_paquete between '71' and '199' ";
			$Actualizar.=" and fecha_creacion_paquete='2004-02-25' ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar."<br>";
			$insertar="insert into sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete, ";
			$insertar.="fecha_creacion_lote,cod_marca,corr_enm,cod_estado,disponibilidad)values";
			$insertar.="('B','71','".$Fila["cod_paquete"]."','".$Fila["num_paquete"]."','2004-03-17','01AM','900349','a',";
			$insertar.="'P')			";
			mysqli_query($link, $insertar);
			//echo $insertar."<br>";
			$cant++;
		}
		echo $cant;
	
		
		break;
	}*/
?>
