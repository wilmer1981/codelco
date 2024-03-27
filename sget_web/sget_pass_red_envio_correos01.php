<?
 include("../principal/conectar_sget_web.php");
 
 
 $Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_subclase='1' and cod_clase='30027'";
 $Resp=mysqli_query($link, $Consulta);
 if($Fila=mysql_fetch_assoc($Resp))
 {
 	 $Actualiza="UPDATE proyecto_modernizacion.sub_clase set nombre_subclase='".$TxtCuenta."', valor_subclase1='".$TxtPass."' where cod_subclase='1' and cod_clase='30027'";
	 mysql_query($Actualiza);
 }
 else
 {
 	$Insertar="INSERT INTO proyecto_modernizacion.sub_clase values('30027','1','".$TxtCuenta."','".$TxtPass."','0','0','0','0','0','0')";
	mysql_query($Insertar);
 }
 header('location:sget_pass_red_envio_correos.php?Msj=S')
?>
