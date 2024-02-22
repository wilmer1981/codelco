<?php 	
	include("../principal/conectar_comet_web.php");
	$NomBtnGrabar='Grabar';
	if ($Recarga=='S')
	{
		$Proceso='M';
		$NomBtnGrabar='Modificar';
		$EstadoRut='readonly';
		$TxtRut=$CmbProductor;
		$Consulta ="select * from age_web.productores_mineros where rut='".$TxtRut."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$TxtNombre=$Fila["nombre"];
		$TxtDireccion=$Fila["direccion_p"];
		$TxtCiudad=$Fila["ciudad_comuna_p"];
		$CmbRegion=$Fila["region_p"];
		$TxtTelefono=$Fila["telefono_p"];
		$TxtRutD=$Fila["rut_r"];
		$TxtNombreD=$Fila["nombre_r"];
		$TxtDireccionD=$Fila["direccion_r"];
		$TxtCiudadD=$Fila["ciudad_comuna_r"];
		$CmbRegionD=$Fila["region_r"];
		$TxtTelefonoD=$Fila["telefono_r"];
	}
	else
	{
		$Proceso='N';
		$EstadoRut='';
		$CmbProductor='-1';$TxtRut='';$TxtNombre='';$TxtDireccion='';$TxtCiudad='';$TxtComuna='';$CmbRegion='-1';$TxtTelefono='';
		$TxtRutD='';$TxtNombreD='';$TxtDireccionD='';$TxtCiudadD='';$TxtComunaD='';$CmbRegionD='-1';$TxtTelefonoD='';
	}
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Grabar(Proceso)
{
	var Frm=document.FrmProceso;
	
	if (Proceso=='N')
	{
		if (Frm.TxtRut.value == "")
		{
			alert("Debe Ingresar Rut Productor")
			Frm.TxtRut.focus();
			return;
		}
	}
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre");
		Frm.TxtNombre.focus();
		return;
	}
	if (Frm.CmbRegion.value == "-1")
	{
		alert("Debe Seleccionar Region");
		Frm.CmbRegion.focus();
		return;
	}
	if (Frm.CmbRegionD.value == "-1")
	{
		alert("Debe Seleccionar Region");
		Frm.CmbRegionD.focus();
		return;
	}
	Frm.action="age_productores_mineros_proceso01.php?Proceso="+Proceso;
	Frm.submit();
}
function Eliminar()
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtRut.value!='')
	{
		Frm.action="age_productores_mineros_proceso01.php?Proceso=E";
		Frm.submit();
	}	
}

function Recarga(Tipo)
{
	var Frm=document.FrmProceso;
	
	switch(Tipo)
	{
		case '1':
			Frm.action="age_productores_mineros_proceso.php?Recarga=S";	
			break;
		case '2':
			Frm.action="age_productores_mineros_proceso.php";	
			break;
	}
	
	Frm.submit();
	
}

function Salir()
{
	window.close();
	
}
</script>
<title>Productores Mineros</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.CmbProductor.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554">
	<table width="535" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr class="Detalle02">
            <td colspan="2"><div align="center">DATOS PRODUCTOR MINERO </div></td>
          </tr>
          <tr> 
            <td>Productor</td>
            <td><select name="CmbProductor" style="width:300" onChange="Recarga('1');" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtRut')">
                <option  class="NoSelec" value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from age_web.productores_mineros order by nombre";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProductor == $Fila["rut"])
						echo "<option selected value='".$Fila["rut"]."'>".str_pad($Fila["rut"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre"]."</option>";
					else
						echo "<option value='".$Fila["rut"]."'>".str_pad($Fila["rut"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre"]."</option>";
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Rut</td>
            <td><input name="TxtRut" type="text" value="<?php echo $TxtRut;?>" <?php echo $EstadoRut?> class="InputDer" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtNombre')"></td>
          </tr>
          <tr> 
            <td width="91">Nombre</td>
            <td width="415"><input name="TxtNombre" type="text" size="85" maxlength="80" value="<?php echo $TxtNombre;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtDireccion')"> 
            </td>
          </tr>
          <tr> 
            <td>Direccion</td>
            <td><input name="TxtDireccion" type="text" class="InputIzq" value="<?php echo $TxtDireccion;?>" size="85" maxlength="20" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCiudad')"> 
            </td>
          </tr>
          <tr> 
            <td width="91">Ciudad</td>
            <td width="415"><input name="TxtCiudad" type="text" class="InputIzq" id="TxtCiudad" value="<?php echo $TxtCiudad;?>" size="85" maxlength="50" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbRegion')"> 
            </td>
          </tr>
          <tr> 
            <td>Region</td>
            <td><select name="CmbRegion" id="CmbRegion" style="width:180" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtTelefono')">
                <option class="NoSelec" value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='99000' order by cod_subclase";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbRegion == $Fila["cod_subclase"])
						echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
					else
						echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}
			?>
              </select> </td>
          </tr>
          <tr> 
            <td>Telefono</td>
            <td><input name="TxtTelefono" type="text" class="InputDer" id="TxtTelefono" value="<?php echo $TxtTelefono;?>" size="15" maxlength="50" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtRutD')"></td>
          </tr>
          <tr>
            <td height="21" colspan="2" class="Detalle02"><div align="center">DATOS REPRESENTANTE LEGAL </div></td>
          </tr>
          <tr> 
            <td height="30">Rut</td>
            <td><input name="TxtRutD" type="text" class="InputDer" id="TxtRutD" value="<?php echo $TxtRutD;?>" size="15" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtNombreD')">
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input name="TxtNombreD" type="text" class="InputIzq" id="TxtNombreD" value="<?php echo $TxtNombreD;?>" size="85" maxlength="80" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtDireccionD')"></td>
          </tr>
          <tr> 
            <td>Direccion</td>
            <td><input name="TxtDireccionD" type="text" class="InputIzq" id="TxtDireccion2" value="<?php echo $TxtDireccionD;?>" size="85" maxlength="20" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCiudadD')"></td>
          </tr>
          <tr> 
            <td>Ciudad</td>
            <td><input name="TxtCiudadD" type="text" class="InputIzq" id="TxtCiudad2" value="<?php echo $TxtCiudadD;?>" size="85" maxlength="50" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbRegionD')"></td>
          </tr>
          <tr> 
            <td>Region</td>
            <td><select name="CmbRegionD" id="select" style="width:180" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtTelefonoD')">
                <option class="NoSelec" value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='99000' order by cod_subclase";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbRegionD == $Fila["cod_subclase"])
						echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
					else
						echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}
			?>
              </select></td>
          </tr>
          <tr>
            <td>Telefono</td>
            <td><input name="TxtTelefonoD" type="text" class="InputDer" id="TxtTelefonoD" value="<?php echo $TxtTelefonoD;?>" size="15" maxlength="50" onKeyDown="TeclaPulsada2('N',false,this.form,'BtnGrabar')"></td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509">
			  <input type="button" name="BtnGrabar" value="<?php echo $NomBtnGrabar;?>" style="width:60" onClick="Grabar('<?php echo $Proceso;?>')">
              <input type="button" name="BtnCancelar" value="Cancelar" style="width:60" onClick="Recarga('2');">
			  <input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="Eliminar();">
			  <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
            </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
<?php
	if (isset($EncontroCoincidencia))
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('Codigo ya fue Ingresado');";
			echo "Frm.TxtCodigo.focus();";
			echo "</script>";
		}
	}
?>
