<?php
	include("../principal/conectar_sec_web.php");

	$opcion   = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$opcion2  = isset($_REQUEST["opcion2"])?$_REQUEST["opcion2"]:"";
	$txtgrupo = isset($_REQUEST["txtgrupo"])?$_REQUEST["txtgrupo"]:"";	
	$Dia   = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes   = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("n");
	$Ano   = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$mostrar   = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$activar   = isset($_REQUEST["activar"])?$_REQUEST["activar"]:"";
	$mensaje   = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
	
	if(strlen($Dia)==1)
		$Dia= "0".$Dia;
	if(strlen($Mes)==1)
		$Mes= "0".$Mes;

	if ($opcion2 == "B")
	{    
	     $consulta_grupo="select distinct max(fecha) as fecha1,cod_grupo from ref_web.grupo_electrolitico2 where fecha <='".$Ano."-".$Mes."-".$Dia."' and cod_grupo='".$txtgrupo."'  group by cod_grupo order by cod_grupo ";
		 $rs_grupos=mysqli_query($link, $consulta_grupo);	
	     $row_grupos = mysqli_fetch_array($rs_grupos);
		 $fecha1=isset($row_grupos["fecha1"])?$row_grupos["fecha1"]:"0000-00-00";	
	     $consulta_datos="SELECT max(fecha),cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado  ";
         $consulta_datos.="FROM ref_web.grupo_electrolitico2 "; 
         $consulta_datos.="where cod_grupo='".$txtgrupo."' and fecha='".$fecha1."' group by cod_grupo";
		// echo $consulta_datos;
		 $respuesta_datos=mysqli_query($link, $consulta_datos);
	     $row1 = mysqli_fetch_array($respuesta_datos);
		 $mostrar = "S";
		 //exit();
	}
	if ($opcion == "N")
	{
		$consulta2 = "SELECT IFNULL(MAX(cod_grupo)+1,1) AS cod_grupo2 FROM ref_web.grupo_electrolitico2";
		$rs12 = mysqli_query($link, $consulta2);
		$row1 = mysqli_fetch_array($rs12);
		$txtgrupo = $row1["cod_grupo2"];
		//echo $grupo;
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
	//alert("opcion:"+f.opcion.value);
	if (ValidaCampos(f))
	{
		f.action = "sec_ing_grupo_electrolitico_proceso01_ref.php?proceso=G&txtgrupo=" + f.txtgrupo.value + "&opcion=" + f.opcion.value;
		f.submit();
	}
}
function Buscar(f)
{
	f.action = "sec_ing_grupo_electrolitico_proceso_ref.php?opcion2=B&txtgrupo=" + f.cmbfecha.value ;
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
  <table width="441" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="429" align="center" valign="middle">
  
  <table width="423" border="1" cellspacing="0" cellpadding="3">
         <tr> 
            <td>Fecha</td>
            <td> 
              <select name="Dia" style="width:50px;">
                <?php
						for ($i = 1;$i <= 31; $i++)
						{
							if (isset($Dia))
							{
								if ($Dia == $i)
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
              <select name="Mes" style="width:100px">
                <?php
				$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i=1;$i<=12;$i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
              </select>
              <select name="Ano" style="width:100px">
                <?php				
				for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
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

          <tr> 
            <td width="137">N&deg; Grupo</td>
            <td width="268"> 
              <?php
			    $consulta="SELECT distinct cod_grupo FROM ref_web.grupo_electrolitico2 where cod_grupo='".$txtgrupo."' group by cod_grupo ";
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
            <td>N&deg; Circuito</td>
            <td><select name="cmbcircuito" id="cmbcircuito">
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
		  <?php
		  $num_cubas_tot        = isset($row1["num_cubas_tot"])?$row1["num_cubas_tot"]:"";
		  $cubas_descobrizacion = isset($row1["cubas_descobrizacion"])?$row1["cubas_descobrizacion"]:"";
		  $hojas_madres         = isset($row1["hojas_madres"])?$row1["hojas_madres"]:"";
		  $num_catodos_celdas   = isset($row1["num_catodos_celdas"])?$row1["num_catodos_celdas"]:"";
		  $num_anodos_celdas    = isset($row1["num_anodos_celdas"])?$row1["num_anodos_celdas"]:"";
		  $calle_puente_grua    = isset($row1["calle_puente_grua"])?$row1["calle_puente_grua"]:"";
		  $cubas_lavado         = isset($row1["cubas_lavado"])?$row1["cubas_lavado"]:"";
		  $cod_estado           = isset($row1["cod_estado"])?$row1["cod_estado"]:"";
		  ?>
          <tr> 
            <td>N&deg; Total de Cubas</td>
            <td><input name="txttotal" type="text" size="10" value="<?php echo $num_cubas_tot; ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Cubas Descobrizacion</td>
            <td><input name="txtdescobrizacion" type="text" size="10" value="<?php echo $cubas_descobrizacion; ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Cubas Hojas Madres</td>
            <td><input name="txthm" type="text" size="10" value="<?php echo $hojas_madres; ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Catodos Por Celda</td>
            <td><input name="txtcatodos" type="text" size="10" value="<?php echo $num_catodos_celdas; ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Anodos Por Celda</td>
            <td><input name="txtanodos" type="text" size="10" value="<?php echo $num_anodos_celdas; ?>"></td>
          </tr>
          <tr> 
            <td>Calle Puente Grua</td>
            <td><select name="cmbcalle">
				<option value="-1">SELECCIONAR</option>';
			<?php
            echo $row1["calle_puente_grua"];
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = '3005' order by cod_subclase asc";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{	
					if (($mostrar == "S") and ($row["nombre_subclase"] == $calle_puente_grua))
                		echo '<option value="'.$row["nombre_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
					else 
						echo '<option value="'.$row["nombre_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Cubas de Lavado</td>
            <td><input name="txtcubaslavado" type="text" size="10" value="<?php echo $cubas_lavado; ?>"></td>
          </tr>
          <tr> 
            <td>Codigo Estado</td>
            <td><select name="cmbestado" size="1">
                <option value="-1">SELECCIONAR</option>
				  <?php
					if (($mostrar == "S") and ($cod_estado == "A"))
                	{		
						echo '<option value="'.$cod_estado.'" selected>Activo</option>';
					}
					if (($mostrar == "S") and ($cod_estado == "I"))
					{
						echo '<option value="A">Activo</option>';
						echo '<option value="'.$row1["cod_estado"].'" selected>Inactivo</option>';
					}
				    if($cod_estado == '')
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
	if ($activar!="")
	{
		echo '<script language="JavaScript">';		
		if ($mensaje!="")
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.document.frmPrincipal.action = "sec_ing_grupo_electrolitico_ref.php";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


