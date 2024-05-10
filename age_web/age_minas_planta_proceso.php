<?php 	
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");
	$Recarga = isset($_REQUEST['Recarga']) ? $_REQUEST['Recarga'] : '';
	$BuscarRut = isset($_REQUEST['BuscarRut']) ? $_REQUEST['BuscarRut'] : '';

	$Proceso = isset($_REQUEST['Proceso']) ? $_REQUEST['Proceso'] : '';
	$ChkOrden = isset($_REQUEST['ChkOrden']) ? $_REQUEST['ChkOrden'] : 'R';
	$EstadoCodMina = isset($_REQUEST['EstadoCodMina']) ? $_REQUEST['EstadoCodMina'] : '';
	$EstadoCmbPrv  = isset($_REQUEST['EstadoCmbPrv']) ? $_REQUEST['EstadoCmbPrv'] : '';
	$TipoBusq = isset($_REQUEST['TipoBusq']) ? $_REQUEST['TipoBusq'] : '';
	$TxtFiltroPrv = isset($_REQUEST['TxtFiltroPrv']) ? $_REQUEST['TxtFiltroPrv'] : ''; 
	$CmbProveedor = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';
	$TxtCodMina   = isset($_REQUEST['TxtCodMina']) ? $_REQUEST['TxtCodMina'] : '';
	$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : '';
	$CmbTipoFaena   = isset($_REQUEST['CmbTipoFaena']) ? $_REQUEST['CmbTipoFaena'] : '';
	$TxtSierra      = isset($_REQUEST['TxtSierra']) ? $_REQUEST['TxtSierra'] : '';
	$TxtComuna      = isset($_REQUEST['TxtComuna']) ? $_REQUEST['TxtComuna'] : '';
	$TxtFecha       = isset($_REQUEST['TxtFecha']) ? $_REQUEST['TxtFecha'] : '';
	$TxtFechaPadron       = isset($_REQUEST['TxtFechaPadron']) ? $_REQUEST['TxtFechaPadron'] : '';
	$TxtCodFaena    = isset($_REQUEST['TxtCodFaena']) ? $_REQUEST['TxtCodFaena'] : '';

	$TxtProvincia       = isset($_REQUEST['TxtProvincia']) ? $_REQUEST['TxtProvincia'] : '';
	$TxtRutPropiet      = isset($_REQUEST['TxtRutPropiet']) ? $_REQUEST['TxtRutPropiet'] : '';
	$Valores = isset($_REQUEST['Valores']) ? $_REQUEST['Valores'] : '';

	$EncontroCoincidencia = isset($_REQUEST['EncontroCoincidencia']) ? $_REQUEST['EncontroCoincidencia'] : '';
	
	$NomBtnGrabar='Grabar';
	switch($Proceso)
	{
		case "M";
			$NomBtnGrabar='Modificar';
			$EstadoCodMina='readonly';
			$EstadoCmbPrv='disabled';
			$Datos=explode('~',$Valores);
			$CmbProveedor=isset($Datos[0])?$Datos[0]:"";
			$TxtCodMina= isset($Datos[1])?$Datos[1]:"";
			$Consulta ="select * from sipa_web.minaprv where cod_mina='".$TxtCodMina."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodMina=isset($Fila["cod_mina"])?$Fila["cod_mina"]:"";
			$TxtDescripcion=isset($Fila["nombre_mina"])?$Fila["nombre_mina"]:"";
			$TxtSierra=isset($Fila["sierra"])?$Fila["sierra"]:"";
			$TxtComuna=isset($Fila["comuna"])?$Fila["comuna"]:"";
			$CmbTipoFaena=isset($Fila["ind_faena"])?$Fila["ind_faena"]:"";
			$TxtFechaPadron=isset($Fila["fecha_padron"])?$Fila["fecha_padron"]:"";
			break;		
		case "N":
			$EstadoCodFaena='';
			$TxtDescripcion='';$TxtCodMina='';$TxtSierra='';$TxtComuna='';$TxtFechaPadron='';$CmbTipoFaena='-1';
			break;
	}
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Grabar(Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.Proceso.value=='N')
	{
		if (Frm.TxtCodMina.value == "")
		{
			alert("Debe Ingresar Codigo Mina")
			Frm.TxtCodMina.focus();
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
	Frm.action="age_padrones_mineros_proceso01.php?Proceso="+Frm.Proceso.value+"&CmbProveedor="+Frm.CmbProveedor.value;
	Frm.submit();
}
function Eliminar()
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtCodFaena.value!='')
	{
		Frm.action="age_minas_planta_proceso01.php?Proceso=E";
		Frm.submit();
	}	
}

function Recarga(Tipo)
{
	var Frm=document.FrmProceso;
	
	switch(Tipo)
	{
		case '1':
			Frm.action="age_minas_planta_proceso.php?Recarga=S";	
			break;
		case '2':
			Frm.action="age_minas_planta_proceso.php";	
			break;
		case '3':
			Frm.action="age_minas_planta_proceso.php?Recarga=S&BuscarRut=S";	
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
	Frm.action="age_minas_planta_proceso.php";
	Frm.submit();	
}
function Recarga3()
{
	var Frm=document.FrmProceso;
	Frm.action="age_minas_planta_proceso.php?TipoBusq=3";
	Frm.submit();	
}
</script>
<style type="text/css">
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

</style>
<title>Ingreso de Minas</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<?php
	if($Proceso=='N')
		echo "<body onload='document.FrmProceso.CmbProveedor.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	else
		echo "<body onload='document.FrmProceso.TxtDescripcion.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";		
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
<input type="hidden" name='Proceso' value="<?php echo $Proceso;?>">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
		  	<?php
			if($Proceso=='N')
			{
			?>
            <tr>
			<td class="Colum01">Ordenar Por </td>
            <td>
			<?php
				switch ($ChkOrden)
				{
					case "R":
						echo '<input checked name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
						echo '<input name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
						break;
					case "N":
						echo '<input name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
						echo '<input checked name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
						break;
				}
			?>
---> Filtro Prv&nbsp;
<input type="text" name="TxtFiltroPrv" size="10">
<input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
</td>
          </tr>
		  <tr> 
		  <?php
		   }
		   ?>
          
            <td class="Colum01">Proveedores</td>
            <td><select name="CmbProveedor" style="width:400" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCodMina')" <?php echo $EstadoCmbPrv;?> >
              <option value="-1">SELECCIONAR</option>
              <?php
				$Consulta = "select * from sipa_web.proveedores ";
				if($TipoBusq=='3'&&$TxtFiltroPrv!='')
				   $Consulta.= " where nombre_prv like '%".$TxtFiltroPrv."%'";  				
				switch ($ChkOrden)
				{
					case "R":
						$Consulta.= "order by lpad(rut_prv,10,'0')";
						break;
					case "N":
						$Consulta.= "order by trim(nombre_prv)";
						break;
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." ".$Fila["nombre_prv"]."</option>";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." ".$Fila["nombre_prv"]."</option>";
				}
			    ?>
            </select></td>
          </tr>
          <tr> 
            <td width="111" class="Colum01">Cod.Mina</td>
            <td width="409"><input name="TxtCodMina" type="text" size="16" maxlength="20" value="<?php echo $TxtCodMina;?>" class="InputDer" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtSierra')" <?php echo $EstadoCodMina;?>></td>
          </tr>
          <tr> 
            <td class="Colum01"> Nombre Mina/Planta</td>
            <td><input name="TxtDescripcion" type="text" size="70" maxlength="80" value="<?php echo $TxtDescripcion;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCodMina')"></td>
          </tr>
          <tr> 
            <td width="111" class="Colum01">Sierra </td>
            <td width="409"><input name="TxtSierra" type="text" size="70" maxlength="50" value="<?php echo $TxtSierra;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtComuna')"> 
            </td>
          </tr>
          <tr> 
            <td class="Colum01">Comuna</td>
            <td><input name="TxtComuna" type="text" size="70" maxlength="50" value="<?php echo $TxtComuna;?>" class="InputIzq" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtProvincia')"> 
            </td>
          </tr>
          <tr> 
            <td class="Colum01">Fecha Venc. Padron </td>
            <td><input name="TxtFechaPadron" type="text" class="InputCen" id="TxtFechaPadron" value="<?php echo $TxtFechaPadron; ?>" size="13" maxlength="10" readonly >
              <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaPadron,TxtFechaPadron,popCal);return false"></td>
          </tr>
          <tr> 
            <td class="Colum01">Tipo</td>
            <td><select name="CmbTipoFaena" style="width:160" onKeyDown="TeclaPulsada2('N',false,this.form,'BtnGrabar')">
                <option class="NoSelec" value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15000' order by cod_subclase";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbTipoFaena == $Fila["valor_subclase1"])
						echo "<option selected value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>";
					else
						echo "<option value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>";
				}
			?>
              </select></td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509">
			  <input type="button" name="BtnGrabar" value="<?php echo $NomBtnGrabar;?>" style="width:60" onClick="Grabar('<?php echo $Valores;?>')">
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
	if ($EncontroCoincidencia!="")
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			//echo "alert('Codigo ya fue Ingresado');";
			//echo "Frm.TxtCodigo.focus();";
			echo "</script>";
		}
	}
?>
