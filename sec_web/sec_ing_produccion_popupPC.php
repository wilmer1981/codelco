<?php	include("../principal/conectar_sec_web.php"); ?>
<?php

		$Existe = 0;
		$IP_USER = $REMOTE_ADDR;
		$consulta ="select * from sec_web.sec_ip_bascula_pc where iden_ip = '".$IP_USER."' and iden_bascula = '".$cmbbascula."'";
		$respuesta=mysqli_query($link, $consulta);
		if ($fila=mysqli_fetch_array($respuesta))
		{
			$Existe = 1;
		}
		/*if ($Existe==0)
		{
				//Bascula incorrecta.
				$mensaje = "Bascula seleccionada no corresponde a PC ";
				
					echo '<script language="JavaScript">';
					echo 'alert("'.$mensaje.'");';
					echo 'window.history.back()';
					echo '</script>';
					return;
		{*/
		if (strlen($mes) == 1)
			$mes = "0".$mes;
		if (strlen($dia) == 1)
			$dia = "0".$dia;
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$TxtFecha = $fecha;
		$codigo ='';
		$consulta="select * from proyecto_modernizacion.sub_clase where cod_clase = 3004 and cod_subclase = '".$mes."'";
		$respuesta=mysqli_query($link, $consulta);
		if($Fila=mysqli_fetch_array($respuesta))
		{
			$TxtCodigo = $Fila["nombre_subclase"];
		}
	if ($cmbbascula!=5 && $cmbbascula!=6)
	{
		$mensaje = "Debe seleccionar bascula..... ";
		echo '<script language="JavaScript">';
		echo 'alert("'.$mensaje.'");';
		echo 'window.history.back()';
		echo '</script>';
		return;
	}
	if ($cmbbascula==5)	
	{
		$consulta="select cod_paquete as codigo,num_paquete as numero,fecha as fecha, bascula6 as peso from sec_web.sec_control_pesada";
		$consulta.=" where cod_paquete ='".$TxtCodigo."' and fecha = '".$TxtFecha."' and (bascula5=0 or bascula5='' or bascula5 is null) and ";
		$consulta.=" bascula6 > 0 ";
	}
	else
	{
		$consulta="select cod_paquete as codigo,num_paquete as numero,fecha as fecha, bascula5 as peso from sec_web.sec_control_pesada";
		$consulta.=" where cod_paquete ='".$TxtCodigo."' and fecha = '".$TxtFecha."' and (bascula6=0 or bascula6='' or bascula6 is null) and ";
		$consulta.=" bascula5 > 0"; 
	}
	$respuesta=mysqli_query($link, $consulta);
	if($fila=mysqli_fetch_array($respuesta))
	{
		$TxtPaquete = $fila["numero"];
		$TxtPesoControl = $fila["peso"];
		$TxtPesada = 0;
		$TxtRango = $TxtPesoControl - $TxtPesada;
	} 
    
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="VBScript">
function LeerArchivo(valor)	

	ubicacion = "c:\PesoMatic.txt"	
	Set fs = CreateObject("Scripting.FileSystemObject")
	Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
	
	//Validar si el peso del archivo ==  0 no leer. 

	Set file2 = fs.getFile(ubicacion) 
	tamano = file2.size	

  	if (tamano <> 0)	then
		valor = file.ReadLine
		LeerArchivo = valor
		else
		LeerArchivo = valor
	end if
	
end function 
</script>

<script language="JavaScript">
function PesoAutomatico()
{
	setTimeout("CapturaPeso()",500);	
}	
/*****************/
function CapturaPeso()
{
	var f = document.frm1;
	f.TxtPesada.value = LeerArchivo(f.TxtPesada.value);
	//f.TxtPesada.value = 2350;
	VeRango();
	setTimeout("CapturaPeso()",200);	

}
function VeRango()
{	
	var f = document.frm1;	
	var desvio = 0;
	var peso1 = f.TxtPesoControl.value;
	var peso2 = f.TxtPesada.value;	
	desvio = (peso1 - peso2);
	f.TxtRango.value = parseInt(desvio);
}
function Grabar()
{	
	var f = document.frm1;
	
	if (f.TxtRango.value > 2 || f.TxtRango.value < -2)
	{
	 	alert ("Diferencia de peso entre Basculas fuera de rango, Debe calibrar Basculas");
	}	
	linea = "&recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value;
	linea = linea + "&cmbsubproducto=" + f.cmbsubproducto.value + "&TxtCodigo=" + f.TxtCodigo.value +"&TxtPaquete=" + f.TxtPaquete.value;
	linea = linea + "&TxtFecha=" + f.TxtFecha.value +"&TxtPesada=" + f.TxtPesada.value + "&cmbbascula=" + f.cmbbascula.value;
	f.action = "sec_ing_produccion01_0809.php?proceso=GC2" + linea;
	f.submit();
}
function Salir()
{	
	window.close();
}
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frm1" action="" method="post">
<?php 	
	echo '<input name="TxtFecha" type="hidden" value="'.$TxtFecha.'">'; 
    echo '<input name="cmbbascula" type="hidden" value="'.$cmbbascula.'">'; 
    echo '<input name="cmbmovimiento" type="hidden" value="'.$cmbmovimiento.'">'; 
    echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">'; 
 
 ?>

<table align="center" width="450" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr><td>&nbsp;&nbsp;</td></tr>
  <tr><td align="center">CONTROL DE PESOS (BASCULAS)</td></tr>
  <tr><td>&nbsp;&nbsp;</td></tr>

</table>

<table align="center" width="250" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">
	<tr><td>&nbsp;&nbsp;</td></tr>
	<tr><td width="50" align="center">Fecha</td>
	<td width="100" align="right"><?php echo $fecha; ?> </td></tr>
	<tr><td>&nbsp;&nbsp;</td></tr>
</table>
<table align="center" width="250" bgcolor="#CCCCCC" height="25" border="0" cellspacing="0" cellpadding="0">

	<tr><td width="30" align="left">Cod.Paquete</td>
	<td width="30"><strong><input  name="TxtCodigo"  type="text" style="2" size="8" align="center" value="<?php echo $TxtCodigo; ?>" readonly=""  ></strong></td> </tr>
	<tr><td width="70" align="left">Num. Paquete</td>
	<td width="70"><strong><input name="TxtPaquete" type="text" size="8"  align="right" value="<?php echo $TxtPaquete; ?>" readonly=""></strong></td></tr>
	<tr><td width="70" align="left">Primer Peso</td>
	<td width="70"><strong><input name="TxtPesoControl" type="text" size="8"  align="right" value="<?php echo $TxtPesoControl; ?>" readonly="" ></strong></td></tr>
	<tr><td width="70" align="left">Peso Control</td>
	<td width="70" ><input name="TxtPesada" type="text" size="8" align="right" value="<?php echo $TxtPesada; ?>" readonly="" ></td></tr>
	<tr><td width="70" align="left">Diferecia </td>
	<td width="70" ><strong><input name="TxtRango" type="text" size="8" align="right" value="<?php echo $TxtRango; ?>" readonly="" ></strong></td></tr>
	</table>
<table align="center" width="250" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
	<tr><td>&nbsp;&nbsp;</td></tr>
  	<tr>
  		  <td>&nbsp;&nbsp;</td>
          <td><input name="btnGrabar" type="button" style="width:70" value="Grabar" onClick="Grabar()"></td> 
  		  <td>&nbsp;&nbsp;</td>
          <td><input name="btnSalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  		  <td>&nbsp;&nbsp;</td>
  	<?php
		//Activa la Funcion JavaScript para poner el Peso Automaticamente.
		echo '<script language="JavaScript"> PesoAutomatico(); </script>';
	?>	   
 </tr>
</table>

</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>
