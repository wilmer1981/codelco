<?php
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Proceso Nuevo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			f.action = "sec_modificacion_parametros_proyeccion_proceso01.php?Proceso=N";
			f.submit();
			break;
		case "S":
		    window.opener.document.frmPrincipal.action = 'sec_modificacion_parametros_proyeccion.php?Buscar=S';
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
</script>

<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<form name="frmProceso" method="post" action="">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><strong>MODIFICACION PAR&Aacute;METROS DE PROYECCI&Oacute;N</strong></td>
  </tr>
  
  <tr class="ColorTabla02">
    <td colspan="2" class="Colum01"><strong>INSERCIÓN PARAMETROS NUEVOS</strong></td>
    </tr>
	<tr class="Colum01">
    <td class="Colum01">Fecha</td>
    <td class="Colum01">
	  <select name="mes" size="1" id="select2">
        <?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrar == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
			else if (($i == date("n")) && ($mostrar != "S"))
					echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$Meses[$i-1]."</option>\n";			
		}		  
	   ?>
      </select>
	  <select name="ano" size="1">
      <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrar == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($mostrar != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	 ?>
   
	</select></td>
  <!--</tr>
  <tr class="Colum01">
    <td class="Colum01">Tonelaje Mes Anterior </td>
    <td class="Colum01"><input type="text" onkeydown="TeclaPulsada2('S',true,this.form,'');" name="tonelaje" size="12"></td>
  </tr>-->
  
<tr class="Colum01">
    <td class="Colum01">Factor Rechazo </td>
    <td class="Colum01"><input type="text" onkeydown="TeclaPulsada2('S',true,this.form,'');" name="factor" size="12"></td>
  </tr>
  
  <tr class="Colum01">
    <td class="Colum01">Factor Rechazo Prog </td>
    <td class="Colum01"><input type="text" onkeydown="TeclaPulsada2('S',true,this.form,'');" name="factor2" size="12"></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Dia Cierre</td>
     <td class="Colum01"><input type="text" onkeydown="TeclaPulsada2('S',true,this.form,'');" name="Dia" size="6" value="<?php echo $Fila[dia] ?>">
     (Afecta columna DIFER DIA -- PESAJE)</td>
  </tr>
  
  <tr align="center" class="Colum01">
    <td height="30" colspan="2" class="Colum01">
	  <input name="BtnGuardar" type="button" id="BtnGuardar3" value="Guardar" style="width:70px " onClick="Proceso('G')">      
      <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
