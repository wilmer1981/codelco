<?php 	
	include("../principal/conectar_principal.php");
	if (!isset($TxtFechaDisp))
		$TxtFechaDisp=date("Y-m-d");
	if (!isset($TxtFechaProg))
		$TxtFechaProg=date("Y-m-d");
	if (!isset($TxtFechaDevo))
		$TxtFechaDevo=date("Y-m-d");
	if (!isset($CmbProducto))
		$CmbProducto="18";
	
	$Desactiva="";
	switch ($Accion)
	{
		case "N":
			$Titulo = "NUEVA&nbsp;";
			break;
		case "M":
			$Datos = explode("~~",$Valor);
			$IE = $Datos[0];
			$Tipo = $Datos[1];
			$Titulo = "MODIFICA&nbsp;";
			$Consulta = "select * from sec_web.programa_codelco where corr_codelco='".$IE."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$Desactiva="readonly";
				$TxtNumOrden = $Fila["corr_codelco"];
				$TxtNumProgLoteo = $Fila["num_prog_loteo"];
				$CmbAsignacion = $Fila["cod_contrato_maquila"];
				$CmbProducto = $Fila["cod_producto"];
				$CmbSubProducto = $Fila["cod_subproducto"];
				$TxtContrato = $Fila["cod_contrato"];
				$TxtPartida = $Fila["partida"];
				$TxtCuota = $Fila["mes_cuota"];
				$TxtNumSemana = $Fila["numero_semana"];
				$TxtCantidad = $Fila["cantidad_programada"];
				$TxtFechaDisp = $Fila["fecha_disponible"];
				$TxtFechaProg = $Fila["fecha_programacion"];
				$TxtFechaDevo = $Fila["fecha_devolucion_maquila"];
				$CmbNave = $Fila["cod_nave"];
				$CmbCliente = $Fila["cod_cliente"];
				if (substr($Fila["cod_cliente"],0,1)=="0")				
					$ClienteNave="N";
				else
					$ClienteNave="C";
				$CmbPtoEmbarque = $Fila["cod_puerto"];
				$CmbPtoDestino = $Fila["cod_puerto_destino"];
				$TxtDescripcion = $Fila["descripcion"];
			}
			break;
	}
?>
<html>
<head>
<title>Orden de Embarque</title>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmProceso;
	switch (opt)
	{
		case "R":
			f.action = "sec_programa_loteo_orden_emb.php";
			f.submit();
			break;
		case "S":
			window.opener.document.FrmProgLoteo.action="sec_programa_loteo.php?Programa="+f.Prog.value;
			window.opener.document.FrmProgLoteo.submit();
			window.close();
			break;
		case "G":
			if (f.Accion.value=="N")
			{
				if (f.TxtNumOrden.value=="")
				{
					alert("Debe Ingresar Numero \"Orden de Embarque\"");
					f.TxtNumOrden.focus();
					return;
				}
			}
			if (f.CmbProducto.value=="S")
			{
				alert("Debe Seleccionar Producto");
				f.CmbProducto.focus();
				return;
			}
			if (f.CmbSubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			f.action="sec_programa_loteo01.php?Proceso=G";
			f.submit();
			break;
	}
}
</script>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Accion" value="<?php echo $Accion; ?>">
<input type="hidden" name="Prog" value="<?php echo $Prog; ?>">
<input type="hidden" name="EnmCode" value="C">
  <table width="555" height="119" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#0099FF" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="550" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior" >
          <tr align="center" class="ColorTabla01"> 
            <td colspan="4"><em><strong><?php echo $Titulo; ?>&nbsp;ORDEN DE EMBARQUE CODELCO</strong></em></td>
          </tr>
          <tr>
            <td width="146">Num. Orden (I.E.) :</td>
            <td width="149"><input <?php echo $Desactiva; ?> name="TxtNumOrden" type="text" class="InputCen" id="TxtNumOrden" value="<?php echo $TxtNumOrden; ?>" size="12" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtNumProgLoteo');"></td>
            <td width="107" align="right">Prog. Loteo:</td>
            <td width="121"><input name="TxtNumProgLoteo" type="text" class="InputCen" id="TxtNumProgLoteo" value="<?php echo $TxtNumProgLoteo; ?>" size="12" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbAsignacion');"></td>
          </tr>
          <tr>
            <td>Asignacion:</td>
            <td colspan="3"><select name="CmbAsignacion" id="select" onkeydown="TeclaPulsada2('S',false,this.form,'CmbProducto');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='3104' ";
	$Consulta.= " order by cod_subclase ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($CmbAsignacion==$Fila["nombre_subclase"])
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
	}
?>			  
            </select></td>
          </tr>
          <tr>
            <td>Producto:</td>
            <td colspan="3"><select name="CmbProducto" onChange="Proceso('R')"  onkeydown="TeclaPulsada2('S',false,this.form,'CmbSubProducto');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
              <?php
			
	$Consulta = "select * from proyecto_modernizacion.productos where cod_producto<>'1' order by descripcion";
	$Resp = mysqli_query($link, $Consulta);  	
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($Fila["cod_producto"]==$CmbProducto)
			echo "<option value=\"".$Fila["cod_producto"]."\" selected>".strtoupper($Fila["descripcion"])."</option>\n";
		else 
			echo "<option value=\"".$Fila["cod_producto"]."\">".strtoupper($Fila["descripcion"])."</option>\n";
	}
			?>
            </select></td>
          </tr>
          <tr>
            <td>SubProducto:</td>
            <td colspan="3"><select name="CmbSubProducto"  onkeydown="TeclaPulsada2('S',false,this.form,'TxtContrato');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
              <?php	
			$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto ";
			$Consulta.= " WHERE cod_producto = '".$CmbProducto."'";
			$Consulta.= " order by descripcion";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{				
				if ($CmbSubProducto==$Fila["cod_subproducto"])
					echo "<option value=\"".$Fila["cod_subproducto"]."\" selected>".strtoupper($Fila["descripcion"])."</option>\n";
				else
					echo "<option value=\"".$Fila["cod_subproducto"]."\">".strtoupper($Fila["descripcion"])."</option>\n";
			}						
		?>
            </select></td>
          </tr>
          <tr>
            <td>Contrato:</td>
            <td><input name="TxtContrato" type="text" class="InputCen" id="TxtContrato" value="<?php echo $TxtContrato; ?>" size="20" maxlength="15" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCuota');"></td>
            <td align="right"> Mes Cuota: </td>
            <td>            <input name="TxtCuota" type="text" class="InputCen" id="TxtCuota" value="<?php echo $TxtCuota; ?>" size="7" maxlength="2" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPartida');"></td>
          </tr>
          <tr>
            <td>Partida:</td>
            <td><input name="TxtPartida" type="text" class="InputCen" id="TxtCorrMes2" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtNumSemana');" value="<?php echo $TxtPartida; ?>" size="7" maxlength="2"></td>
            <td align="right">Num. Semana: </td>
            <td><input name="TxtNumSemana" type="text" class="InputCen" id="TxtNumSemana" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtCantidad');" value="<?php echo $TxtNumSemana; ?>" size="7" maxlength="2"></td>
          </tr>
          <tr>
            <td>Cantidad:</td>
            <td><input name="TxtCantidad" type="text" class="InputDer" id="TxtCantidad" value="<?php echo $TxtCantidad; ?>" size="12" maxlength="8" onKeyDown="TeclaPulsada2('S',true,this.form,'CmbCliente');">
            (TM)</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>F. Programacion:</td>
            <td><input name="TxtFechaProg" type="text" class="InputCen" value="<?php echo $TxtFechaProg; ?>" size="13" maxlength="10" readonly >
                <img name='Calendario2' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaProg,TxtFechaProg,popCal);return false"></td>
            <td align="right">F. ETA: </td>
            <td><input name="TxtFechaDevo" type="text" class="InputCen" id="TxtFechaDevo" value="<?php echo $TxtFechaDevo; ?>" size="13" maxlength="10" readonly >
                <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaDevo,TxtFechaDevo,popCal);return false"></td>
          </tr>
          <tr>
            <td>F. Disponibilidad:</td>
            <td><input name="TxtFechaDisp" type="text" class="InputCen" value="<?php echo $TxtFechaDisp; ?>" size="13" maxlength="10" readonly >
                <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaDisp,TxtFechaDisp,popCal);return false"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Cliente:</td>
            <td colspan="3"><select name="CmbCliente" id="select2" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbPtoEmbarque');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
			  <option value="S" class="NoSelec">-------CLIENTE-------</option>
              <?php
					$Consulta = "select * from sec_web.cliente_venta order by trim(sigla_cliente) ";
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_cliente"]==$CmbCliente)
							echo "<option selected value='".$Fila["cod_cliente"]."'>".$Fila["cod_cliente"]." - ".strtoupper($Fila["sigla_cliente"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_cliente"]."'>".$Fila["cod_cliente"]." - ".strtoupper($Fila["sigla_cliente"])."</option>\n";
					}
					echo "<option value='S' class='NoSelec'>-------NAVE-------</option>\n";
					$Consulta = "select * from sec_web.nave order by trim(nombre_nave) ";
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_nave"]==$CmbCliente)
							echo "<option selected value='".$Fila["cod_nave"]."'>".$Fila["cod_nave"]." - ".strtoupper($Fila["nombre_nave"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_nave"]."'>".$Fila["cod_nave"]." - ".strtoupper($Fila["nombre_nave"])."</option>\n";
					}
				
			?>
            </select> 
              </td>
          </tr>
          <tr>
            <td>Pto. Embarque:</td>
            <td colspan="3"><select name="CmbPtoEmbarque" id="CmbPtoEmbarque" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbPtoDestino');">
			<option value="S" class="NoSelec">SELECCIONAR</option>
			<?php
				$Consulta = "select * from sec_web.puertos order by trim(nom_aero_puerto) ";
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					if ($Fila["cod_puerto"]==$CmbPtoEmbarque)
						echo "<option selected value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]." - ".strtoupper($Fila["nom_aero_puerto"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]." - ".strtoupper($Fila["nom_aero_puerto"])."</option>\n";
				}
			?>           
            </select></td>
          </tr>
          <tr>
            <td>Pto. Destino: </td>
            <td colspan="3"><select name="CmbPtoDestino" id="select3" onkeydown="TeclaPulsada2('S',false,this.form,'TxtDescripcion');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
              <?php
				$Consulta = "select * from sec_web.puertos order by trim(nom_aero_puerto) ";
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					if ($Fila["cod_puerto"]==$CmbPtoDestino)
						echo "<option selected value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]." - ".strtoupper($Fila["nom_aero_puerto"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]." - ".strtoupper($Fila["nom_aero_puerto"])."</option>\n";
				}
			?>
            </select></td>
          </tr>
          <tr>
            <td>Descripcion:</td>
            <td colspan="3"><textarea name="TxtDescripcion" cols="50" rows="3" wrap="VIRTUAL" id="TxtDescripcion"><?php echo $TxtDescripcion; ?></textarea></td>
          </tr>
          <tr align="center" class="Detalle02">
            <td height="40" colspan="4"><input type="button" name="BtnGrabar" value="Grabar" style="width:70" onClick="Proceso('G');">
            <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
</table>
</form>
</body>
</html>