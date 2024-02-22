<?php include("../principal/conectar_ref_web.php"); ?>
<HTML>
<HEAD>
      <TITLE>===========Sistema Refineria===========Ingreso de Catodos Iniciales===========</TITLE>
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
function Proceso(f,opc)
{
	linea = "opcion=" + opc;

	if (opc == '1')
	    window.open("popup_catodos_iniciales.php?"+linea,"","top=180,left=100,width=590,height=405,scrollbars=no,resizable = no");
}
function Guardar()
{
	if(Validaciones())
	{
		var f = document.frmPrincipal;
		f.action = "ingreso_cat_ini01.php?proceso=G";
		f.submit();
     }  
}

/**********/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini01.php?proceso=B";
	f.submit();
}
/**********/

function Modificar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini01.php?proceso=M";
	f.submit();
}
</script>
</HEAD>
<BODY >
<FORM name="frmPrincipal" action="" method="post">
  <?php include("../principal/encabezado.php"); ?>
  <?php
?>
  <table width="769" height="397" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td height="41" colspan="2" align="center">
<p align="left"><font face="Arial, Helvetica, sans-serif"> </font></p>
        <div align="left">
<table width="766" border="0" cellspacing="0" cellpadding="3" class="ColorTabla01">
            <tr> 
              <td height="20" align="center"><ur> <div align="left"></div>
                <div align="center">Ingreso Catodos Iniciales</div></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr> 
      <td width="172" height="22" align="center"> <div align="left"><font face="Arial, Helvetica, sans-serif">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
      <td width="575" align="center"><div align="left"> <font face="Arial, Helvetica, sans-serif"> 
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
          </font> <font face="Arial, Helvetica, sans-serif"> 
          <input name="btnbuscar" type="button" value="Buscar Datos" style="width:80" onClick="Proceso(this.form,'1')">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Turno 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <select name="txt_turno">
            <option value='-1'>Seleccionar</option>
            <?php
					$Consulta="select distinct turno from ref_web.iniciales order by turno"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($txt_turno==$Fila[turno])
							echo "<option value='".$Fila[turno]."' selected>'".$Fila[turno]."'</option>";
						else
							echo "<option value='".$Fila[turno]."'>'".$Fila[turno]."'</option>";
		     		}
				?>
          </select>
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"> <div align="left"></div>
        <div align="left"><font face="Arial, Helvetica, sans-serif">Produccion 
          MFCI &nbsp;&nbsp;&nbsp;</font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_produccion_mfci" type="text" id="txt_produccion_mfci" size="15" maxlength="15" value= "<?php echo $txt_produccion_mfci ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Produccion 
          MDB &nbsp;</font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_produccion_mdb" type="text" id="txt_produccion_mdb" size="15" maxlength="15" value= "<?php echo $txt_produccion_mdb ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Produccion</font> 
          MCO<font face="Arial, Helvetica, sans-serif"> </font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <input name="txt_produccion_mco" type="text" id="txt_produccion_mco" size="15" maxlength="15" value= "<?php echo $txt_produccion_mco ?>">
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;</font><font face="Geneva, Arial, Helvetica, sans-serif">Observaciones&nbsp;&nbsp;&nbsp;</font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <textarea name="txt_observacion" type="text" id="textarea2" cols="50" value= "<?php echo $txt_observacion ?>"><?php echo $txt_observacion ?></textarea>
          </font></div></td>
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