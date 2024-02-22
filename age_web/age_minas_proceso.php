<?php 	
	include("../principal/conectar_comet_web.php");
	if (!isset($ChkOrden))
		$ChkOrden="R";
	$NomBtnGrabar='Grabar';
	if ($Recarga=='S')
	{
		$Proceso='M';
		$NomBtnGrabar='Modificar';
		$EstadoCodFaena='readonly';
		$TxtFaena=$CmbMina;
		$Consulta ="select * from age_web.mina left join age_web.productores_mineros on rut_propietario=rut ";
		$Consulta.="where cod_faena='".$TxtFaena."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		if ($BuscarRut=='S')
		{
			$Consulta ="select * from age_web.productores_mineros where rut='".$TxtRutPropiet."'";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$TxtRutPropiet=$Fila2["rut"];
			$NombrePropiet=$Fila2["nombre"];
		}	
		else
		{
			$TxtCodFaena=$Fila["cod_faena"];
			$TxtDescripcion=$Fila["descripcion"];
			$TxtCodMina=$Fila["cod_mina"];
			$TxtSierra=$Fila["sierra"];
			$TxtComuna=$Fila["comuna"];
			$TxtProvincia=$Fila["provincia"];
			$TxtRutPropiet=$Fila["rut"];
			$NombrePropiet=$Fila["nombre"];
			$CmbTipoFaena=$Fila["tipo_faena"];
		}		
		
	}
	else
	{
		$Proceso='N';
		$EstadoCodFaena='';
		$CmbMina='-1';$TxtCodFaena='';$TxtDescripcion='';$TxtCodMina='';$TxtSierra='';$TxtComuna='';$TxtProvincia='';$TxtRutPropiet='';$CmbTipoFaena='-1';
	}
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Proceso=='N')
	{
		if (Frm.TxtCodFaena.value == "")
		{
			alert("Debe Ingresar Numero de Faena")
			Frm.TxtCodFaena.focus();
			return;
		}
	}
	if (Frm.TxtDescripcion.value == "1")
	{
		alert("Debe Ingresar Descripcion");
		Frm.TxtDescripcion.focus();
		return;
	}
	if (Frm.CmbTipoFaena.value == "-1")
	{
		alert("Debe Seleccionar Tipo Faena");
		Frm.CmbTipoFaena.focus();
		return;
	}
	Frm.action="age_minas_proceso01.php?Proceso="+Proceso;
	Frm.submit();
}
function Eliminar()
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtCodFaena.value!='')
	{
		Frm.action="age_minas_proceso01.php?Proceso=E";
		Frm.submit();
	}	
}

function Recarga(Tipo)
{
	var Frm=document.FrmProceso;
	
	switch(Tipo)
	{
		case '1':
			Frm.action="age_minas_proceso.php?Recarga=S";	
			break;
		case '2':
			Frm.action="age_minas_proceso.php";	
			break;
		case '3':
			Frm.action="age_minas_proceso.php?Recarga=S&BuscarRut=S";	
			break;
	}
	
	Frm.submit();
	
}

function Salir()
{
	window.close();
	
}
function Recarga2()
{
	var Frm=document.FrmProceso;
	Frm.action="age_minas_proceso.php";
	Frm.submit();	
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
-->
</style>
<title>Ingreso de Minas</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.CmbMina.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr>
            <td class="Colum01">Ordenar Por </td>
            <td><?php
switch ($ChkOrden)
{
	case "R":
		echo '<input checked name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Codigo&nbsp;&nbsp;';
		echo '<input name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
		break;
	case "N":
		echo '<input name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Codigo&nbsp;&nbsp;';
		echo '<input checked name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
		break;

}

?></td>
          </tr>
          <tr> 
            <td class="Colum01">Mina</td>
            <td><select name="CmbMina" style="width:300" onChange="Recarga('1');" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCodFaena')">
                <option class="NoSelec" value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from age_web.mina ";
				switch ($ChkOrden)
				{
					case "R":
						$Consulta.= "order by trim(cod_faena)";
						break;
					case "N":
						$Consulta.= "order by trim(descripcion)";
						break;
				
				};
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbMina == $Fila["cod_faena"])
						echo "<option selected value='".$Fila["cod_faena"]."'>".str_pad($Fila["cod_faena"],10,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
					else
						echo "<option value='".$Fila["cod_faena"]."'>".str_pad($Fila["cod_faena"],10,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td class="Colum01">Cod. Faena</td>
            <td><input name="TxtCodFaena" type="text" value="<?php echo $TxtCodFaena;?>" <?php echo $EstadoCodFaena?> class="InputDer" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtDescripcion')"></td>
          </tr>
          <tr> 
            <td width="91" class="Colum01">Descripcion</td>
            <td width="415"><input name="TxtDescripcion" type="text" size="85" maxlength="80" value="<?php echo $TxtDescripcion;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCodMina')"> 
            </td>
          </tr>
          <tr> 
            <td class="Colum01">Cod.Mina</td>
            <td><input name="TxtCodMina" type="text" size="25" maxlength="20" value="<?php echo $TxtCodMina;?>" class="InputDer" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtSierra')"> 
            </td>
          </tr>
          <tr> 
            <td width="91" class="Colum01">Sierra </td>
            <td width="415"><input name="TxtSierra" type="text" size="70" maxlength="50" value="<?php echo $TxtSierra;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtComuna')"> 
            </td>
          </tr>
          <tr> 
            <td class="Colum01">Comuna</td>
            <td><input name="TxtComuna" type="text" size="70" maxlength="50" value="<?php echo $TxtComuna;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtProvincia')"> 
            </td>
          </tr>
          <tr> 
            <td class="Colum01">Provincia</td>
            <td><input name="TxtProvincia" type="text" size="70" maxlength="50" value="<?php echo $TxtProvincia;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtRutPropiet')"></td>
          </tr>
          <tr> 
            <td class="Colum01">Rut Propiet</td>
            <td><input name="TxtRutPropiet" type="text" value="<?php echo $TxtRutPropiet;?>" size="15" class="InputDer" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtOk')">
              &nbsp;
              <input name="TxtOk" type="button" value="Ok" onClick="Recarga('3')" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbTipoFaena')">
              &nbsp;<?php echo $NombrePropiet;?></td>
          </tr>
          <tr> 
            <td class="Colum01">Tipo Faena</td>
            <td><select name="CmbTipoFaena" style="width:160" onKeyDown="TeclaPulsada2('N',false,this.form,'BtnGrabar')">
                <option class="NoSelec" value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15000' order by cod_subclase";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbTipoFaena == $Fila["cod_subclase"])
						echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
					else
						echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}
			?>
              </select></td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509">
			  <input type="button" name="BtnGrabar" value="<?php echo $NomBtnGrabar;?>" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
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
