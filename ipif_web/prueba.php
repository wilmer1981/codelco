 <? 
 include("../principal/conectar_ipif_web.php");
include("funciones/ipif_funciones.php");
/*$ALTER="alter table proyecto_modernizacion.funcionarios  add cod_ceco VARCHAR(50) DEFAULT NULL; ";
$ALTER.="alter table proyecto_modernizacion.funcionarios  add cuenta_red VARCHAR(100) DEFAULT NULL; ";
mysql_query($ALTER);	*/

$Cont=0;
$Consulta="select * from datos_funcionarios ";
$Respuesta=mysqli_query($link, $Consulta);
while ($Fila=mysql_fetch_array($Respuesta))
{
	$Cont=$Cont+1;
	
	$Actualizar="UPDATE proyecto_modernizacion.funcionarios set cod_ceco='".$Fila[cc]."',cuenta_red='".$Fila[cuenta]."'";
	$Actualizar.=" where rut='".$Fila[rut]."' ";	
	echo $Actualizar."<br>";
	mysql_query($Actualizar);

	

}
	
/*	$Actualizar="UPDATE datos_funcionarios set rut='".str_pad($Fila[rut],10,'0',STR_PAD_LEFT)."'";
	$Actualizar.=" where cuenta='".$Fila[cuenta]."' ";	
	echo $Actualizar."<br>";
	mysql_query($Actualizar);*/
	?>