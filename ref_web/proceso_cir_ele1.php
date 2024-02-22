<?php include("../principal/conectar_ref_web.php"); ?>
<HTML>
<HEAD>
      <TITLE>Modificacion Planta Tratamiento Electrolito</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10";
}
/**********/
function Recarga1()
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini.php?recargapag1=S";
	f.submit();
}
/**********/
function Recarga2()
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini02.php?recargapag2=S";
	f.submit();
}
/**********/
function Validaciones()
{
      var f = document.frmPrincipal;

    if (f.txt_turno.value == -1)
	{
		alert("Debe Seleccionar un Turno");
        f.txt_turno.focus();
		return false;
  	}
    if (f.txt_produccion_mfci.value == 0)	
	{
		alert("Debe Ingresar la produccion Correspondiente");
        f.txt_produccion_mfci.focus();
		return false;
	}
    if (f.txt_produccion_mdb.value == 0)
	{
        alert("Debe Ingresar la Produccion Correspondiente");
        f.txt_produccion_mdb.focus();
		return false;
	}
	if (f.txt_produccion_mco.value == 0)
	{
		alert("Debe Ingresar la Produccion Correspondiente");
        f.txt_produccion_mco.focus();
		return false;
	}
    if (f.txt_consumo.value == 0)
	{
        alert("Debe Ingresar el Consumo Correspondiente");
        f.txt_consumo.focus();
		return false;
	}
    if (f.txt_observacion.value == 0)
	{
		alert("Debe Ingresar Observaciones");
        f.txt_observacion.focus();
		return false;
	}

	if (f.txt_stock.value == 0)
	{
		alert("Debe Ingresar un Stock");
        f.txt_stock.focus();
		return false;
	}

   if (f.txt_rechazo_cat_ini.value == 0)
	{
        alert("Debe Ingresar el Total de rechazos");
        f.txt_rechazo_cat_ini.focus();
		return false;
	}
    
   	return true;
}


/***************/
function Guardar()
{
	if(Validaciones())
	{
		var f = document.frmPrincipal;
		f.action = "proceso_cir_ele1.php?proceso=G";
		f.submit();
     }  
}

/**********/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_cir_ele.php?proceso=B";
	f.submit();
}
/**********/

function Modificar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_cir_ele.php?proceso=M";
	f.submit();
}
</script>
</HEAD>
<BODY >
<FORM name="frmPrincipal" action="" method="post">
  <?php
?>
  <table width="300" height="350" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td height="41" colspan="2" align="center">
<p align="left"><font face="Arial, Helvetica, sans-serif"> </font></p>
        <div align="left">
          </font> <font face="Arial, Helvetica, sans-serif">
          </font></div></td>
    </tr>
    <tr> 
    </font></div></td>
    </tr>

        <tr>
            <td>Circuito H2so4</td>
            <td><select name="cmbcircuito" id="cmbcircuito">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sub_clase where cod_clase = 3100";
				$consulta.= " ORDER BY cod_clase";
				$rs = mysqli_query($link, $consulta);

				while ($row = mysqli_fetch_array($rs))
				{
		  			if (($mostrar == "S") and ($row["nombre_subclase"] == $row1["nombre_subclase"]))
						echo '<option value="'.$row["nombre_subclase"].'" selected>Circuito '.$row["nombre_subclase"].'</option>';
					else
						echo '<option value="'.$row["nombre_subclase"].'">Circuito '.$row["nombre_subclase"].'</option>';
				}
			?>
              </select></td>
       </tr>




       <tr>
            <td>Volumen H2so4</td>
            <td><input name="txt_volumen_h2so4" type="text" size="10" value="<?php echo $row1[volumen_h2so4] ?>"></td>
          </tr>

           <tr>
            <td>Circuito H2so4</td>
            <td><select name="cmbcircuito" id="cmbcircuito">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sub_clase where cod_clase = 3100";
				$consulta.= " ORDER BY cod_clase";
				$rs = mysqli_query($link, $consulta);

				while ($row = mysqli_fetch_array($rs))
				{
		  			if (($mostrar == "S") and ($row[cod_clase] == $row1["nombre_subclase"]))
						echo '<option value="'.$row[cod_clase].'" selected>Circuito '.$row["nombre_subclase"].'</option>';
					else
						echo '<option value="'.$row[cod_clase].'">Circuito '.$row["nombre_subclase"].'</option>';
				}
			?>
              </select></td>
       </tr>



       <tr>
            <td>Volumen Desc.Parcial</td>
            <td><input name="txt_volumen_dp" type="text" size="10" value="<?php echo $row1[volumen_dp] ?>"></td>
       </tr>

          <tr>
            <td>Circuito H2so4</td>
            <td><select name="cmbcircuito" id="cmbcircuito">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sub_clase where cod_clase = 3100";
				$consulta.= " ORDER BY cod_clase";
				$rs = mysqli_query($link, $consulta);

				while ($row = mysqli_fetch_array($rs))
				{
		  			if (($mostrar == "S") and ($row[cod_clase] == $row1["nombre_subclase"]))
						echo '<option value="'.$row[cod_clase].'" selected>Circuito '.$row["nombre_subclase"].'</option>';
					else
						echo '<option value="'.$row[cod_clase].'">Circuito '.$row["nombre_subclase"].'</option>';
				}
			?>
              </select></td>
       </tr>

       <tr>
            <td>Volumen Electrolito</td>
            <td><input name="txt_volumen_pte" type="text" size="10" value="<?php echo $row1[volumen_pte] ?>"></td>
          </tr>

   <tr>
      <td align="center"><div align="left"></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          </font></div></td>
    </tr>
    <tr> 
      <td height="23" colspan="2" align="center"> 
        <div align="left"><font face="Arial, Helvetica, sans-serif"></font></div>
        <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
        <div align="left"></div>
        <div align="left"></div></td>
    </tr>
    <tr> 
      <td colspan="2" align="center"> 
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
        <input name ="btnGuardar" type="button" style="width:70" onClick="Guardar()"  value="Guardar">
        <font face="Arial, Helvetica, sans-serif"> 
        <input name ="btnSalir" type="button" onClick="JavaScript:Salir();" style="width:70" value="Salir">
        </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp; 
        </font> </td>
    </tr>
    <tr> 
      <td height="34" colspan="2" align="center" valign="middle"> <br> </td>
    </tr>
  </table>
</FORM>
</BODY>
</HTML>
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	
	}
?>
