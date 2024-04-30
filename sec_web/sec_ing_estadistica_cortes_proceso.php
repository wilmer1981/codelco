<?php 
	include("../principal/conectar_sec_web.php");
	
	if ($opcion == "M")
	{
		$consulta = "SELECT * FROM sec_web.cortes_refineria WHERE cod_grupo = '".$grupo."' AND fecha_desconexion = '".$fecha_desconexion."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mostrar = "S";
			$ano1 = substr($row["fecha_desconexion"],0,4);
			$mes1 = substr($row["fecha_desconexion"],5,2);
			$dia1 = substr($row["fecha_desconexion"],8,2);
			$hr1 = substr($row["fecha_desconexion"],11,2);
			$mm1 = substr($row[fecha_desconexion],14,2);

			$ano2 = substr($row["fecha_conexion"],0,4);
			$mes2 = substr($row["fecha_conexion"],5,2);
			$dia2 = substr($row["fecha_conexion"],8,2);
			$hr2 = substr($row["fecha_conexion"],11,2);
			$mm2 = substr($row["fecha_conexion"],14,2);			
		}
	}
	
?>

<html>
<head>
<title>Ingreso Estadistica de Cortes Refineria</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.cmbtipo.value == -1)
	{
		alert("Debe Seleccionar el Tipo de Desconexion");
		return false;
	}
	
	if (f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar el Grupo");
		return false;
	}
	
	if (f.txtkah1.value == "")
	{
		alert("Debe Ingresar los Kahdird");
		return false;
	}
	
	//if (f.txtkah2.value == "")
	//{
		//alert("Debe Ingresar los Kahdirc");
		//return false;
	//}
	
	return true;
}
/******************/
function Grabar(f)
{
	var dias1=0;
	var dias2 = 0;
	var minutos1 = 0;
	var minutos2 = 0;
	dias1 = (f.ano1.value * 360) + (f.mes1.value * 30) + (f.dia1.value * 1); 
	dias2 = (f.ano2.value * 360) + (f.mes2.value * 30) + (f.dia2.value * 1); 
	minutos1 = (f.hr1.value * 60) + (f.mm1.value * 1);
	minutos2 = (f.hr2.value * 60) + (f.mm2.value * 1); 
	if (ValidaCampos(f))   
	{
	//alert (dias2 + " --" + dias1);
	
		if (dias2 < dias1)
		{
			alert ("Fecha  de Conexión no puede ser Menor que Fecha de Desconexión");
			return;
		}		
		
			if (minutos2 < minutos1)
		{
			alert ("Fecha Hora de Conexión no puede ser Menor que Fecha Hora de Desconexión");
			return;
		}		

 		if (f.txtkah2.value < f.txtkah1.value)
		{
			alert ("Lectura de Conexión no puede ser Menor que Lectura de Desconexión");
			return;
		}
	
		linea = "dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value + "&hr1=" + f.hr1.value + "&mm1=" + f.mm1.value;
		linea = linea + "&proceso=G" + "&cmbgrupo=" + f.cmbgrupo.value; 
		
		f.action = "sec_ing_estadistica_cortes_proceso01.php?" + linea ;
		f.submit();
	}
}
/******************/
function Salir()
{
	window.close();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="433" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
<td width="762" align="center" valign="middle">

<table width="500" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td width="160" height="30">Tipo Desconexion</td>
          <td width="282"><SELECT name="cmbtipo" id="cmbtipo">
              <option value="-1">SELECCIONAR</option>
			  	<?php
			  		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3000";
					$rs1 = mysqli_query($link, $consulta);
					while ($row1 = mysqli_fetch_array($rs1))
					{	
						if ($row1["valor_subclase1"] == $row[tipo_desconexion])
							echo '<option value="'.$row1["valor_subclase1"].'" SELECTed>'.$row1["nombre_subclase"].'</option>';
						else 
							echo '<option value="'.$row1["valor_subclase1"].'">'.$row1["nombre_subclase"].'</option>';
					}
			  	?>
            </SELECT></td>
        </tr>
        <tr> 
          <td height="30">Grupo</td>
          <td>
		  		<?php
					if ($opcion == "M")
						echo '<SELECT name="cmbgrupo" id="cmbgrupo" disabled>';
					else 
						echo '<SELECT name="cmbgrupo" id="cmbgrupo">';
				
					echo '<option value="-1">SELECCIONAR</option>';
			  	
			  		$consulta = "SELECT distinct(cod_grupo) FROM ref_web.grupo_electrolitico2 ORDER BY cod_grupo";
					$rs2 = mysqli_query($link, $consulta);
					while ($row2 = mysqli_fetch_array($rs2))
					{		
						if ($row2["cod_grupo"] == $row["cod_grupo"])
							echo '<option value="'.$row2["cod_grupo"].'" SELECTed>N° '.$row2["cod_grupo"].'</option>';
						else 
							echo '<option value="'.$row2["cod_grupo"].'">N° '.$row2["cod_grupo"].'</option>';
					}
			  	?>
            </SELECT></td>
        </tr>
        <tr> 
          <td height="30">Fecha y Hora Desconexion</td>
            <td> 
              <?php
			if ($opcion == "M")
				echo '<SELECT name="dia1" id="dia1" disabled>';
			else
		  		echo '<SELECT name="dia1" id="dia1">';
            
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia1))			
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else					
					echo '<option value="'.$i.'">'.$i.'</option>';												
			}		
		?></SELECT>
              <?php
			if ($opcion == "M")
				echo '<SELECT name="mes1" id="SELECT" disabled>';
			else
				echo '<SELECT name="mes1" id="SELECT">';
            
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes1))
					echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
				else if (($i == date("n")) && ($mostrar != "S"))
						echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
				else
					echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
			}		  
		?></SELECT>
              <?php			
			if ($opcion == "M")
				echo '<SELECT name="ano1" id="ano1" disabled>';
			else 
				echo '<SELECT name="ano1" id="ano1">';
            
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano1))
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?></SELECT>
              &nbsp; &nbsp; &nbsp; 
              <?php
			if ($opcion == "M")
				echo '<SELECT name="hr1" id="SELECT5" disabled>';
			else 
            	echo '<SELECT name="hr1" id="SELECT5">';
             
		 	for($i=0; $i<=23; $i++)
			{
				if (($mostrar == "S") && ($i == $hr1))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($mostrar != "S"))
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?></SELECT>
              : 
              <?php
			if ($opcion == "M")
				echo '<SELECT name="mm1" id="SELECT6" disabled>';
			else 
           	 	echo '<SELECT name="mm1" id="SELECT6">';

		 	for($i=0; $i<=59; $i++)
			{
				if (($mostrar == "S") && ($i == $mm1))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($mostrar != "S"))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?></SELECT>
              </td>
        </tr>
        <tr> 
          <td height="30">Kahdird</td>
          <td><input name="txtkah1" type="text" size="10" value="<?php echo $row[kahdird]?>"></td>
        </tr>
        <tr> 
            <td height="30">Fecha y Hora Conexion</td>
            <td><SELECT name="dia2" size="1" id="SELECT2">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia2))			
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else					
					echo '<option value="'.$i.'">'.$i.'</option>';												
			}		
		?>
              </SELECT> 
              <SELECT name="mes2" size="1" id="mes2">
              <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes2))
					echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
				else if (($i == date("n")) && ($mostrar != "S"))
						echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
				else
					echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
			}		  
		?>
            </SELECT> <SELECT name="ano2" size="1" id="SELECT4">
              <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano2))
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
            </SELECT> &nbsp; &nbsp; &nbsp; <SELECT name="hr2" id="SELECT7">
              <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($mostrar == "S") && ($i == $hr2))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($mostrar != "S"))
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
            </SELECT>
            : 
            <SELECT name="mm2" id="SELECT8">
              <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($mostrar == "S") && ($i == $mm2))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($mostrar != "S"))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
            </SELECT></td>
        </tr>
        <tr>
          <td height="30">Kahdirc</td>
          <td><input name="txtkah2" type="text" size="10" value="<?php echo $row[kahdirc]?>"></td>
        </tr>
      </table>
	
		<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>	  

      <br>
      <table width="500" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar(this.form)">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
          </td>
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
			
		echo 'window.opener.document.frmPrincipal.action = "sec_ing_estadistica_cortes.php";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>