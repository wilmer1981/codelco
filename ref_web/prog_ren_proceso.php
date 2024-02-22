<?php
	include("../principal/conectar_sec_web.php");
	
	if ($opcion=="H")
	{echo Hola;}
	if ($opcion2 == "B")
	{
	     $consulta_datos="SELECT max(fecha),cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado  ";
         $consulta_datos.="FROM sec_web.grupo_electrolitico2 "; 
         $consulta_datos.="where cod_grupo='".$txtgrupo."' and fecha='".$cmbfecha."' group by cod_grupo";
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
<title>Documento sin t&iacute;tulo</title>
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
		f.action = "sec_ing_grupo_electrolitico_proceso01.php?proceso=G&txtgrupo=" + f.txtgrupo.value + "&opcion=" + f.opcion.value;
		f.submit();
	}
}
function Buscar(f)
{
	f.action = "sec_ing_grupo_electrolitico_proceso.php?opcion2=B&txtgrupo=" + f.cmbfecha.value ;
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
            <td>Fecha</td>
            <td>
			<?php if($opcion == "M")
				{				
			?>
			    <select name="cmbfecha" id="cmbfecha">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT fecha FROM sec_web.grupo_electrolitico2 where cod_grupo='".$txtgrupo."' ORDER BY fecha";
				echo $consulta;
				$rs = mysqli_query($link, $consulta);
				while ($rowe = mysqli_fetch_array($rs))
				{
		  			if ($mostrar == "S" and $cmbfecha == $rowe["fecha"])
						echo '<option value="'.$rowe["fecha"].'" selected> '.$rowe["fecha"].'</option>';
					else 
                        echo '<option value="'.$rowe["fecha"].'">'.$rowe["fecha"].'</option>';
				}			
			?>
              </select>
              <input name="btnbuscar" type="button" style="width:70" value="buscar" onClick="Buscar(this.form)">
		  <?php  } ?>

          <?php  if($opcion == "N") 
		      {    ?>
				<select name="dia1" size="1" >
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{
						if (($mostrar == "S") && ($i == $dia1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select>
              <select name="mes1" size="1" id="mes1">
                <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
              </select>
              <select name="ano1" size="1" id="select4">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select>
			 <?php } ?>		  
		  
		  </td>		  	
          </tr>

          <tr> 
            <td width="141">N&deg; Grupo</td>
            <td width="246"> 
              <?php
			    $consulta="SELECT distinct cod_grupo FROM sec_web.grupo_electrolitico2 where cod_grupo='".$txtgrupo."' group by cod_grupo ";
				$rs = mysqli_query($link, $consulta);
				$rows = mysqli_fetch_array($rs);
            	if ($mostrar == "S")
				  echo '<input name="txtgrupo" type="text" size="10" value="'.$txtgrupo.'" >';
				else
				  echo '<input name="txtgrupo" type="text" size="10" value="'.$txtgrupo.'">';					
			?>
            </td>
          </tr>
          <tr> 
            <td>N&deg; Circuito</td>
            <td><select name="cmbcircuito" id="cmbcircuito">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sec_web.circuitos ORDER BY cod_circuito";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if (($mostrar == "S") and ($row[cod_circuito] == $row1[cod_circuito]))
						echo '<option value="'.$row[cod_circuito].'" selected>Circuito '.$row[cod_circuito].'</option>';
					else 
						echo '<option value="'.$row[cod_circuito].'">Circuito '.$row[cod_circuito].'</option>';
				}			
			?>
              </select></td>
          </tr>
          <tr> 
            <td>N&deg; Total de Cubas</td>
            <td><input name="txttotal" type="text" size="10" value="<?php echo $row1[num_cubas_tot] ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Cubas Descobrizacion</td>
            <td><input name="txtdescobrizacion" type="text" size="10" value="<?php echo $row1[cubas_descobrizacion] ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Cubas Hojas Madres</td>
            <td><input name="txthm" type="text" size="10" value="<?php echo $row1[hojas_madres] ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Catodos Por Celda</td>
            <td><input name="txtcatodos" type="text" size="10" value="<?php echo $row1[num_catodos_celdas] ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Anodos Por Celda</td>
            <td><input name="txtanodos" type="text" size="10" value="<?php echo $row1[num_anodos_celdas] ?>"></td>
          </tr>
          <tr> 
            <td>Calle Puente Grua</td>
            <td><select name="cmbcalle">
				<option value="-1">SELECCIONAR</option>';
			<?php
            echo $row1[calle_puente_grua];
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = '3005'";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{	
					if (($mostrar == "S") and ($row["nombre_subclase"] == $row1[calle_puente_grua]))
                		echo '<option value="'.$row["nombre_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
					else 
						echo '<option value="'.$row["nombre_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Cubas de Lavado</td>
            <td><input name="txtcubaslavado" type="text" size="10" value="<?php echo $row1[cubas_lavado] ?>"></td>
          </tr>
          <tr> 
            <td>Codigo Estado</td>
            <td><select name="cmbestado" size="1">
                <option value="-1">SELECCIONAR</option>
				  <?php
					if (($mostrar == "S") and ($row1["cod_estado"] == "A"))
                	{		
						echo '<option value="'.$row1["cod_estado"].'" selected>Activo</option>';
					}
					if (($mostrar == "S") and ($row1["cod_estado"] == "I"))
					{
						echo '<option value="A">Activo</option>';
						echo '<option value="'.$row1["cod_estado"].'" selected>Inactivo</option>';
					}
				    if($row1["cod_estado"] == '')
					{
						echo '<option value="A">Activo</option>';
						echo '<option value="I">Inactivo</option>';
					}
				?>
               
				
              </select></td>
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


