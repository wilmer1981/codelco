<?
	$Datos=explode('~',$Valores);
// echo $Datos[0]."<br>";
// echo $Datos[1]."<br>";
// echo $Datos[2];
// echo $Datos[3];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Modificar - Eliminar Flujo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
</head>
<script language="javascript">
function Actualizar(datos)
{	
	var f=document.form1;

	if(f.Textarea.value=='')
	{
		alert ("Debe Ingresar Numero de Flujo");
		f.Textarea.focus();
		return false;
	}
	if(isNaN(parseInt(f.Textarea.value)))
	{
		alert ("Flujo Asociado s�lo acepta el ingreso de n�meros");
		f.Textarea.focus();
		return false;
	}	
			
	var f=document.form1;
	var datoscero='';
	datoscero=datos;
	f.action="ModEliminar.php?modificarOPT=S&Valores="+datoscero;
	f.submit();			
}

function Eliminar(datos)
{
	var f=document.form1;

	if(f.Textarea.value=='')
	{
		alert ("Debe Ingresar Numero de Flujo");
		f.Textarea.focus();
		return false;
	}
	if(isNaN(parseInt(f.Textarea.value)))
	{
		alert ("Flujo Asociado s�lo acepta el ingreso de n�meros");
		f.Textarea.focus();
		return false;
	}
		
	var f=document.form1;
	var datoscero='';
	datoscero=datos;		
	f.action="ModEliminar.php?eliminarOPT=S&Valores="+datoscero;
	f.submit();			

}

</script>

<body>
	<form name="form1" method="post" action="">
<?php
	//include("../principal/encabezado.php");
	include("conectar.php");
?>

<?php 	

//instrucciones artesanales

	// obtengo el flujo	
	echo "<input name='AuxiliarUno' type='hidden' value='".$Datos[1]."' size='12' </td>";
	// obtengo el cod_item
	echo "<input name='AuxiliarDos' type='hidden' value='".$Datos[2]."' size='12' </td>";

//fin instrucciones artesanales

 	echo "<table width='570' border='0' class='TablaPrincipal'>";
     	echo "<tr>";	 
     		echo "<td align='center' valign='top'>
			<table width='550' border='1'>";
	 			echo "<tr class='Detalle03'>";
     				echo "<td colspan='4'><div align='center'><strong>MODIFICAR - ELIMINAR FLUJO BALANCE ".$Datos[3]."</strong></strong></div></td>";
     			echo "</tr>";
		
     			echo " <tr>";	 
	 				echo "<td colspan='4'><br></td>";
     			echo "</tr>";
	 
				echo  "<tr>";
					echo  "<td rowspan='3'>&nbsp;</td>";
					echo  "<td width='200' class='ColorTabla01' align='center'>NOMBRE ITEM</td>";
					echo  "<td width='150' class='ColorTabla01' align='center'>FLUJO ASOCIADO </td>";
					echo "<td rowspan='3'>&nbsp;</td>";
				echo "</tr>";
				 
				echo "<tr>";
					echo "<td class='Detalle03' align='center'>".$Datos[0]."</td>";
					echo "<td align='left'><input name='Textarea' type='text' value='".$Datos[1]."' size='12' ></td>";
				echo "</tr>";	 
				echo "<tr>";   
				$Datos=$Datos[0]."~".$Textarea."~".$Datos[2]."~".$Datos[3];                                                                             // onclick=\"popUp('','$datos')\"
					echo "<td colspan='2' align='center'><input type='button' name='BtnActualizar' value='Actualizar Flujo' onClick=\"Actualizar('$Datos')\">
					<input type='button' name='BtnEliminar' value='Eliminar Flujo' onClick=\"Eliminar('$Datos')\"><input type='button' name='BtnCerrar' value='Cerrar' onClick='self.close()'></td>"; 				
				
				//	echo "<td colspan='2' align='center'><input type='button' name='BtnActualizar' value='Actualizar' onClick='Actualizar()'>
				//	<input type='button' name='BtnCerrar' value='Cerrar' onClick='Cerrar()'></td>";     	\"popUp('','$datos')\"
				echo "</tr>";				
       echo "</table>";
	echo "</td>";
    echo "</tr>";
 echo " </table>"; 
 

  
?>

<?php 
 if($modificarOPT=='S')
 {
 	$flag=0;
 	$consulta1="Select * from flujoitem where cod_item='$AuxiliarDos' and flujo='$Textarea'";
 	$validacion=mysql_query($consulta1);
	while($fila=mysql_fetch_array($validacion))
	{
		$flag=1; echo $fila[cod_item]." ".$fila["flujo"];
 	}
	
	if($flag==1)
	{ 
		echo "valor existe !";
	}else{
		$consulta2="Update flujoitem set flujo='$Textarea' where cod_item='$AuxiliarDos' and flujo='$AuxiliarUno'"; 
		//	echo $consulta;	
		$res=mysql_query($consulta2);
 	}

		echo "<table width='400' align='center' border='1' class='TablaPrincipal'>";
		echo "<tr class='Detalle03'>";
		echo "<td align='center' ><strong>Flujo Actualizado Correctamente</strong></td>";
	    echo "</tr>";
		echo "</table>";	
	
	
	$Valores=$Datos;

 }
 
 if($eliminarOPT=='S')
 { 
 	$i=0;
	$consulta1="Select * from flujoitem where cod_item='$AuxiliarDos' ";
// 	$consulta1="Select * from flujoitem where cod_item='$AuxiliarDos' and flujo='$Textarea'";
	//echo $consulta1;
	$verificacion=mysql_query($consulta1);
	while($fila=mysql_fetch_array($verificacion))
	{
		$i++;//echo "valor de i: ".$i;
		//echo "consulta uno: ".$fila[flujoitem].$fila[cod_item];
 	}
	
	if(!($i>1))
	{
		$consulta2="Delete from item where cod_item='$AuxiliarDos' ";
		$ejecutar=mysql_query($consulta2);
		//echo $consulta2;
	}
		$consulta3="Delete from flujoitem where cod_item='$AuxiliarDos' and flujo='$Textarea'";
		//echo $consulta3;
		$ejecutar=mysql_query($consulta3);	
		
		echo "<table width='400' align='center' border='1' class='TablaPrincipal'>";
		echo "<tr class='Detalle03'>";
		echo "<td align='center' ><strong>Flujo Eliminado Correctamente</strong></td>";
	    echo "</tr>";
		echo "</table>";		
 }

?>

<?php
	include("cerrarconexion.php");
	//include("../principal/pie_pagina.php");
?>
</form>
</body>
</html>
