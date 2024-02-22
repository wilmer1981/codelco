<?php
	include("../principal/conectar_sec_web.php");
	
	
	if ($opcion2 == "B")
	{
	     $consulta_datos="SELECT max(fecha),cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado  ";
         $consulta_datos.="FROM sec_web.grupo_electrolitico2 "; 
         $consulta_datos.="where cod_grupo='".$txtgrupo."' and fecha='".$Ano."-".$Mes."-01' group by cod_grupo";
		 $respuesta_datos=mysqli_query($link, $consulta_datos);
	     $row1 = mysqli_fetch_array($respuesta_datos);
		 $mostrar = "S";
	}
	if ($opcion == "N")
	{
		$consulta2 = "SELECT IFNULL(MAX(cod_grupo)+1,1) AS cod_grupo2 FROM sec_web.grupo_electrolitico2";
		$rs12 = mysqli_query($link, $consulta2);
		$row1 = mysqli_fetch_array($rs12);
		$txtgrupo = $row1[cod_grupo2];
		echo $grupo;
	}
	
?>

<html>
<head>
<title>Modificacion H2so4</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.txtgrupo.value == "")
	{
		alert("Debe Ingresar el N del Grupo");
		return false;
	}
	
	if (f.cmbcircuito.value == -1)
	{
		alert("Debe Seleccionar el Circuito");
		return false;
	}
	
	if (f.cmbestado.value == -1)
	{
		alert("Debe Seleccionar el Estado");
		return false;
	}
	
	return true;
}
/*****************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		f.action = "ingreso_cir_ele.php?proceso=G&txtgrupo=" + f.txtgrupo.value + "&opcion=" + f.opcion.value;
		f.submit();
	}
}
function Buscar(f)
{
	f.action = "proceso_cir_ele.php?opcion2=B&txtgrupo=" + f.cmbfecha.value ;
	f.submit();
}


/****************/
function Salir()
{
	window.close();
}
</script>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPopup" action="" method="post">
  <table width="433" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="421" align="center" valign="middle">
  
  <table width="405" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="141">N&deg; Circuito</td>
            <td width="246"><select name="cmbcircuito" id="select3">
                <option value="-1">SELECCIONAR</option>
               <?php
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3100 ORDER BY cod_clase";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if (($mostrar == "S") && ($row["cod_subclase"] == $row["nombre_subclase"]))
						echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
					else 
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}			
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Volumen </td>
            <td><input name="txt_volumen_h2so4" type="text" size="10" value="<?php echo $row1[volumen_h2so4] ?>"></td>
          </tr>
        </table> 
	  	<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
	  
        <br>
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="JavaScrip:Grabar(this.form)">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Salir()"></td>
        </tr>
      </table></td>
	  
</tr>
</table>	  
</form>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.document.frmPrincipal.action = "sec_ing_grupo_electrolitico.php";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


