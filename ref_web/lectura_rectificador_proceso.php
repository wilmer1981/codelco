<?php
	include("../principal/conectar_sec_web.php");

	if ($opcion == "N")
	{
		 $consulta="select * from ref_web.detalle_produccion where fecha='".$fecha."'";
		 $rs = mysqli_query($link, $consulta);
	     if(!$row = mysqli_fetch_array($rs))
		    {
		      $insertar5="insert into ref_web.detalle_produccion(fecha,stock,lectura_rectificador) ";
		      $insertar5 = $insertar5."values ('".$fecha."','0','".$rectificador."')";
			  mysqli_query($link, $insertar5);
    		  header("Location:Lectura_rectificador.php?fecha=".$fecha);
			 }
		 else {$mensaje = "La lectura del Rectificador ya Existe";
			   header("Location:Lectura_rectificador.php?activar=&fecha=$fecha&mensaje=".$mensaje);} 
			
		 
	}
	if ($opcion=='B')
	   {
	     //$fecha=$ano1.'-'.$mes1.'-'.$dia1;
		 //echo $fecha;
	     $consulta="select * from ref_web.detalle_produccion where fecha='".$fecha."'";
		 $Respuesta = mysqli_query($link, $consulta);
		 $row = mysqli_fetch_array($Respuesta);
	   
	   }
	 if ($opcion=='M')
	    {
		   $actualiza = "UPDATE ref_web.detalle_produccion set lectura_rectificador ='".$rectificador."'";
		   $actualiza.= "where fecha= '".$fecha."' ";
		   mysqli_query($link, $actualiza);
		   $mensaje = "La lectura del Rectificador ha sido modificada con exito";
		   header("Location:Lectura_rectificador.php?activar=&fecha=$fecha&mensaje=".$mensaje);
		
		}  
	


?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.txtrevision.value == "")
	{
		alert("Debe Ingresar Revision");
		return false;
	}
	
	if (f.txtcatodos.value == "")
	{
		alert("Debe Ingresar los Catodos Comerciales");
		return false;
	}
	
	if (f.txtdescobrizacion.value == "")
	{
		alert("Debe Ingresar la Descobrizacion");
		return false;
	}
	
	if (f.txtdespuntes.value == "")
	{
		alert("Debe Ingresar los Despuntes");
		return false;
	}
	
	return true;
}
/*****************/
function Grabar(f,fecha)
{
        f.action = "lectura_rectificador_proceso.php?opcion=N&rectificador="+f.txtrectificador.value+"&fecha="+fecha;
		f.submit();
	
}
function Buscar()
{
	var  f=document.PopupProduccion;

	f.action='lectura_rectificador_proceso.php?opcion=B&mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Modificar(f,fecha)
{

	
	f.action = "lectura_rectificador_proceso.php?opcion=M&rectificador="+f.txtrectificador.value+"&fecha="+fecha;
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
/*****************/
function Salir(f,fecha)
{
	f.action = "Lectura_rectificador.php?&fecha="+fecha;
	f.submit();
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="PopupProduccion" action="" method="post">
  <table width="487" height="157" border="0" cellpadding="5" cellspacing="0" align="center"class="TablaPrincipal">
    <tr>
<td width="421" align="center" valign="middle"><table width="467" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="169">Lectura Rectificador 5:00 AM</td>
            <td width="132"><input name="txtrectificador" type="text" size="10" value="<?php echo $row[lectura_rectificador] ?>"> 
            <td width="148">&nbsp; 
        </table> 
        <br>
		<?php
	  		//Campo oculto.
			//echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
		
        <table width="462" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar(this.form,'<?php echo $fecha?>')">
              <input name="btnmodificar" type="button" style="width:70" value="Modificar" onClick="Modificar(this.form,'<?php echo $fecha?>')"> 
              <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir(this.form,'<?php echo $fecha?>')"></td>
          </tr>
        </table>
    </tr>
</table>	
</form>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($fecha))
			/*echo 'alert("'.$fecha.'");';		*/
			
		//echo 'window.opener.document.frmPrincipal.action = "datos_consumo.php?fecha_ini='.$fecha.'";';
		//echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>


