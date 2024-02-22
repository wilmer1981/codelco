<?php include("../principal/conectar_ref_web.php"); ?>
<HTML>
<HEAD>
      <TITLE>===========Sistema Refineria===========Ingreso de Hojas Madres===========</TITLE>
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
	f.action = "ingreso_hojas_madres02.php?recargapag2=S";
	f.submit();
}
/**********/
function Validaciones()
{
      var f = document.frmPrincipal;

    if (f.txt_gru.value == -1)
	{
		alert("Debe Seleccionar un Turno");
        f.txt_gru.focus();
		return false;
  	}
    if (f.txt_rech_del.value == 0)	
	{
		alert("Debe Ingresar la produccion Correspondiente");
        f.txt_rech_del.focus();
		return false;
	}
    if (f.txt_rech_gra.value == 0)
	{
        alert("Debe Ingresar la Produccion Correspondiente");
        f.txt_rech_gra.focus();
		return false;
	}
	if (f.txt_rech_gru.value == 0)
	{
		alert("Debe Ingresar la Produccion Correspondiente");
        f.txt_rech_gru.focus();
		return false;
	}
    if (f.txt_total_recu.value == 0)
	{
        alert("Debe Ingresar el Consumo Correspondiente");
        f.txt_total_recu.focus();
		return false;
	}
    if (f.txt_stock.value == 0)
	{
		alert("Debe Ingresar Observaciones");
        f.txt_stock.focus();
		return false;
	}

	if (f.txt_peso_promedio.value == 0)
	{
		alert("Debe Ingresar un Stock");
        f.txt_peso_promedio.focus();
		return false;
	}
  	return true;
}


/***************/
function Proceso(f,opc)
{
	linea = "opcion=" + opc;

	if (opc == '1')
	    window.open("popup_hoja_madre.php?"+linea,"","top=180,left=100,width=595,height=440,scrollbars=no,resizable = no");
}
function Guardar()
{
	if (Validaciones())
	{
		var f = document.frmPrincipal;
		f.action = "ingreso_hojas_madres01.php?proceso=G";
		f.submit();
	}
}

/**********/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_hojas_madres01.php?proceso=B";
	f.submit();
}
/**********/
function Modificar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_hojas_madres01.php?proceso=M";
	f.submit();
}
</script>
</HEAD>
<BODY >
<FORM name="frmPrincipal" action="" method="post">
  <?php include("../principal/encabezado.php"); ?>
  <?php
?>
  <table width="770" height="390" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center"><p align="left"><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp; 
          </font></p></td>
      <td align="center"><div align="left"> </div></td>
    </tr>
    <tr> 
      <td width="175" height="22" align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
      <td width="573" align="center"><div align="left"> <font face="Arial, Helvetica, sans-serif"> 
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
          <select name="mes1" size="1" id="select12">
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
          <select name="ano1" size="1" id="select13">
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
          </font> </div></td>
    </tr>
    <tr> 
      <td height="30" align="center"> <div align="left"><font face="Times New Roman, Times, serif">Grupo 
          &nbsp;&nbsp;&nbsp;&nbsp;</font><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif"> 
          </font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <select name="txt_gru" size="1">
            <option value='-1'>Seleccionar</option>
            <?php
					$Consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' order by valor_subclase1"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($txt_gru==$Fila["valor_subclase1"])
							echo "<option value='".$Fila["valor_subclase1"]."' selected>".$Fila["valor_subclase1"]."</option>";
						else
							echo "<option value='".$Fila["valor_subclase1"]."'>".$Fila["valor_subclase1"]."</option>";
		     		}
				?>
          </select>
          </font><font face="Arial, Helvetica, sans-serif"> 
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"> <div align="left"><font face="Times New Roman, Times, serif">Rechazo 
          Delgadas</font><font face="Arial, Helvetica, sans-serif">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
          &nbsp; </font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_rech_del" type="text" id="txt_rech_del" size="15" maxlength="15" title="Ingresar Hojas Madres Rechazadas por ser Delgadas" value= "<?php echo $txt_rech_del ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Times New Roman, Times, serif">Rechazo 
          Granuladas </font><font face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp;&nbsp; 
          &nbsp; </font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_rech_gra" type="text" id="txt_rech_gra" size="15" maxlength="15" value= "<?php echo $txt_rech_gra ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Times New Roman, Times, serif">Rechazo 
          Gruesas &nbsp;</font><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;</font><font face="Arial, Helvetica, sans-serif"> 
          &nbsp;&nbsp;&nbsp;&nbsp; </font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_rech_gru" type="text" id="txt_rech_gru" size="15" maxlength="15" value= "<?php echo $txt_rech_gru ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td height="32" align="center"> <div align="left">Recuperados<font face="Arial, Helvetica, sans-serif"> 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          </font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_total_recu" type="text" id="txt_total_recu" size="15" maxlength="15" value= "<?php echo $txt_total_recu ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left">Stock<font face="Arial, Helvetica, sans-serif"> 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          </font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_stock" type="text" id="txt_stock" size="15" maxlength="15" value= "<?php echo $txt_stock ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Peso 
          Promedio<font face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          </font></font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_peso_promedio" type="text" id="txt_peso_promedio" size="15" maxlength="15" value= "<?php echo $txt_peso_promedio ?>">
          </font></font></div></td>
    </tr>
    <tr> 
      <td height="33" align="center"> <div align="left"></div>
        <div align="left"><font face="Arial, Helvetica, sans-serif">Observaciones<font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          </font> </font></div></td>
      <td height="33" align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"> 
          <textarea name="txt_observacion" type="text" id="txt_observacion" cols="50" value= "<?php echo $txt_observacion ?>"><?php echo $txt_observacion ?></textarea>
          </font></font></div></td>
    </tr>
    <tr> 
      <td height="22" colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td height="42" colspan="2" align="center"> 
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
        <input name ="btnGuardar" type="button" style="width:70" onClick="Guardar()"  value="Guardar"> 
        <font face="Arial, Helvetica, sans-serif"> 
        <input name="btnbuscar" type="button" value="Buscar" style="width:70" title="Busca datos segun fecha" onClick="Proceso(this.form,'1')">
        </font> <input name ="btnSalir" type="button" onClick="JavaScript:Salir();" style="width:70" value="Salir"> 
        <br> </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php"); ?>
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