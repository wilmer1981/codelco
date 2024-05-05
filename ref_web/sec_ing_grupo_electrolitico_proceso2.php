<?php
	include("../principal/conectar_sec_web.php");
	
	
	if ($opcion2 == "B")
	{
	     $consulta_datos="SELECT max(fecha),cod_grupo,cod_circuito,cod_electrolito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado  ";
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
	if (f.cmbelectrolito.value == -1)
	{
		alert("Debe Seleccionar el Circuito Electrolito");
		return false;
	}
	
	if (f.cmbcircuito.value == -1)
	{
		alert("Debe Seleccionar el Circuito Electrico");
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
		f.action = "sec_ing_grupo_electrolitico_proceso02.php?proceso=G&txtgrupo=" + f.txtgrupo.value + "&opcion=" + f.opcion.value;
		f.submit();
	}
}
function Buscar(f)
{
	f.action = "sec_ing_grupo_electrolitico_proceso2.php?opcion2=B&txtgrupo=" + f.cmbfecha.value ;
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
              <?php
			  	/*$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); */
			  /*	if($opcion == "M")
				{
					echo $Meses[$Mes-1]." del ".$Ano;
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
  				}*/ 
				if($opcion == "N") 
		      	{ 
					echo $Meses[$Mes-1]." del ".$Ano;
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
				} 
			
			   if($opcion == "M")
				{?> 
              		<select name="dia1" size="1" id="select2">
                    <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
						{	
							if (isset($Dia))
							{
								if ($dia1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("j"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}																				
						}		
		            ?>
                   </select>
                   <select name="mes1" size="1" id="mes1">
                   <?php
		 				for($i=1;$i<13;$i++)
		  					{
								if (isset($Mes))
								{
									if ($i == $Mes)
										echo "<option value='".$i."' selected>".$meses[$i-1]."</option>\n";
									else
										echo "<option value='".$i."'>".$meses[$i-1]."</option>\n";
								}
								else
								{
									if ($i == date("n"))
										echo "<option value='".$i."' selected>".$meses[$i-1]."</option>\n";
									else
										echo "<option value='".$i."'>".$meses[$i-1]."</option>\n";
								}			
							}		  
					?>
              		</select>
              		<select name="ano1" size="1" id="select4">
                		<?php
							for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
								{
									if (isset($Ano))
								{
									if ($i == $Ano)
										echo "<option value='".$i."' selected>".$i."</option>\n";
									else
										echo "<option value='".$i."'>".$i."</option>\n";
								}
								else
								{
									if ($i == date("Y"))
										echo "<option value='".$i."' selected>".$i."</option>\n";
									else
										echo "<option value='".$i."'>".$i."</option>\n";
								}
								}
						?>
              		</select> </td>
          </tr>
		  <?php } ?>
		  
		  
		  
		  
          <tr> 
            <td width="141">N&deg; Grupo</td>
            <td width="246"> 
              <?php
			    $consulta="SELECT distinct cod_grupo FROM sec_web.grupo_electrolitico2 where cod_grupo='".$txtgrupo."' group by cod_grupo ";
				$rs = mysqli_query($link, $consulta);
				$rows = mysqli_fetch_array($rs);
            	if ($mostrar == "S")
				{
					if ($opcion == "M")
				  		echo '<input name="txtgrupo" type="hidden" size="10" value="'.$txtgrupo.'" >'.$txtgrupo;
					else
						echo '<input name="txtgrupo" type="text" size="10" value="'.$txtgrupo.'">';						
				}
				else
				{
				  	echo '<input name="txtgrupo" type="text" size="10" value="'.$txtgrupo.'">';					
				}
			?>
            </td>
          </tr>
          <tr> 
            <td>N&deg; Circuito Electrico</td>
            <td><select name="cmbelectrolito" id="select">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sec_web.circuitos ";
				$consulta.= " ORDER BY cod_circuito";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if (($mostrar == "S") and ($row["cod_circuito"] == $row1["cod_circuito"]))
						echo '<option value="'.$row["cod_circuito"].'" selected>Circuito '.$row["cod_circuito"].'</option>';
					else 
						echo '<option value="'.$row["cod_circuito"].'">Circuito '.$row["cod_circuito"].'</option>';
				}			
			?>
              </select></td>
          </tr>
          <tr> 
            <td>N&deg; Circuito Electrolito</td>
            <td><select name="cmbcircuito" id="cmbcircuito">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sec_web.circuitos ";
				$consulta.= " ORDER BY cod_circuito";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if (($mostrar == "S") and ($row[cod_electrolito] == $row1[cod_electrolito]))
						echo '<option value="'.$row[cod_electrolito].'" selected>Circuito '.$row[cod_electrolito].'</option>';
					else 
						echo '<option value="'.$row[cod_electrolito].'">Circuito '.$row[cod_electrolito].'</option>';
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
            <td><input name="txthm" type="text" size="10" value="<?php echo $row1["hojas_madres"] ?>"></td>
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
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = '3005' order by cod_subclase asc";
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


