<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>
<?
include ("conectar.php");
?>
<body>
<?
$i=1;
$sql="SELECT * FROM ENABAL_AUX WHERE FECHA BETWEEN '2000-02-01' AND '2005-01-01' ";
$resultado=mysql_query($sql);
while($linea=mysql_fetch_array($resultado))
{
	$uno=substr($linea[FECHA], 0, 2);
	$dos=substr($linea[FECHA], 3, 2);
	$tres=substr($LINEA[FECHA], 6, 3);
	$cad2 = ($tres."-".$dos."-".$uno);
	$sql2="INSERT INTO enabal (fecha,t_mov,n_flujo,nom_producto,p_seco,f_cobre,f_plata,f_oro) VALUES('$linea[FECHA]','$linea[T_MOV]','$linea[N_FLUJO]','$linea[NOM_PRODUCTO]','$linea[P_SECO]','$linea[F_COBRE]','$linea[F_PLATA]','$linea[F_ORO]')";
	echo "CONSULTA"."\t".$sql2."<br>";
	mysql_query($sql2);
}
?>
</body>
</html>
