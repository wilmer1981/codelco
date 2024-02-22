<?php 	
	include("../principal/conectar_comet_web.php");
	switch($Proceso)
	{
		case "N":
			$EstadoNumPadron='';
			$EstadoCanjeSI='';
			$EstadoCanjeNO='checked';
			break;
		case "M":
			$EstadoNumPadron='readonly';
			$Datos=explode('//',$Valores);
			$TxtCodigo=$Datos[0];
			$Consulta = "select * from age_web.padron_minero where num_padron='".$TxtCodigo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtNumPadron=$Fila["num_padron"];
			$CmbProveedor=$Fila["rut_prv"];
			$CmbMina=$Fila["cod_faena"];
			$CmbTipoRecepcion=$Fila["tipo_recepcion"];
			$TxtFechaOtorg=$Fila["fecha_otorg"];
			$TxtFechaVenc=$Fila["fecha_venc"];
			if($Fila["canje"]=='S')
				$EstadoCanjeSI='checked';
			else
				$EstadoCanjeNO='checked';
			break;	
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
		if (Frm.TxtNumPadron.value == "")
		{
			alert("Debe Ingresar Numero de Padron Minero")
			Frm.TxtNumPadron.focus();
			return;
		}
	}
	if (Frm.CmbProveedor.value == "-1")
	{
		alert("Debe Seleccionar Proveedor");
		Frm.CmbProveedor.focus();
		return;
	}
	if (Frm.CmbMina.value == "-1")
	{
		alert("Debe Seleccionar Mina");
		Frm.CmbMina.focus();
		return;
	}
	if (Frm.CmbTipoRecepcion.value == "-1")
	{
		alert("Debe Seleccionar Tipo Recepcion");
		Frm.CmbTipoRecepcion.focus();
		return;
	}
	Frm.action="age_padrones_mineros_proceso01.php?Proceso="+Proceso+"&TxtNumPadron="+Frm.TxtNumPadron.value+"&Valores="+Valores;
	Frm.submit();
}
function Recarga(Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_funcionarios_proceso.php?Proceso="+Proceso;
	Frm.submit();
	
}

function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.TxtNumPadron.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr> 
            <td class="Colum01">N&deg; Padron</td>
            <td><input name="TxtNumPadron" type="text" class="InputDer" value="<?php echo $TxtNumPadron;?>" size="12" maxlength="8" <?php echo $EstadoNumPadron;?> onKeyDown="TeclaPulsada2('N',false,this.form,'CmbProveedor')" ></td>
          </tr>
          <tr> 
            <td width="91" class="Colum01">Fechas Otorg.</td>
            <td width="415"> 
              <input name="TxtFechaOtorg" type="text" class="InputCen" value="<?php echo $TxtFechaOtorg; ?>" size="15" maxlength="10" readOnly>
              <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaOtorg,TxtFechaOtorg,popCal);return false"> 
            </td>
          </tr>
          <tr>
            <td class="Colum01">Fechas Venc.</td>
            <td><input name="TxtFechaVenc" type="text" class="InputCen" id="TxtFechaVenc4" value="<?php echo $TxtFechaVenc; ?>" size="15" maxlength="10" readonly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaVenc,TxtFechaVenc,popCal);return false"></td>
          </tr>
          <tr> 
            <td width="91" class="Colum01"> Proveedor</td>
            <td width="415"><select name="CmbProveedor" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbMina')">
                <option class='NoSelec' value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from rec_web.proved order by NOMPRV_A";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["RUTPRV_A"])
						echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
				}
			?>
              </select> </td>
          </tr>
          <tr> 
            <td class="Colum01">Mina/Planta</td>
            <td><select name="CmbMina" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbTipoRecepcion')">
                <option class='NoSelec' value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from age_web.mina order by descripcion";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbMina == $Fila["cod_faena"])
						echo "<option selected value='".$Fila["cod_faena"]."'>".str_pad($Fila["cod_faena"],10,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
					else
						echo "<option value='".$Fila["cod_faena"]."'>".str_pad($Fila["cod_faena"],10,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
				}
			?>
              </select> </td>
          </tr>
          <tr> 
            <td class="Colum01">T.Recepcion</td>
            <td><select name="CmbTipoRecepcion" style="width:150" onKeyDown="TeclaPulsada2('N',false,this.form,'BtnGrabar')">
              <option class='NoSelec' value="-1">SELECCIONAR</option>
              <?php
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15002'";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbTipoRecepcion== $Fila["cod_subclase"])
						echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["valor_subclase1"]."</option>";
					else
						echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["valor_subclase1"]."</option>";
				}
			?>
            </select></td>
          </tr>
          <tr>
            <td class="Colum01">Canje</td>
            <td>Si
            <input name="OptCanje" type="radio" value="S" <?php echo $EstadoCanjeSI;?>>
            &nbsp;&nbsp;&nbsp;&nbsp;No
            <input name="OptCanje" type="radio" value="N" <?php echo $EstadoCanjeNO;?>></td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
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
