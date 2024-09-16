<?php
	include("../principal/conectar_principal.php"); 
	
	$TipoConsulta = isset($_REQUEST["TipoConsulta"])?$_REQUEST["TipoConsulta"]:"";
	$Recarga      = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:"";
	$Proc         = isset($_REQUEST["Proc"])?$_REQUEST["Proc"]:"";
	$TxtCorr      = isset($_REQUEST["TxtCorr"])?$_REQUEST["TxtCorr"]:"";
	$TxtLote      = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$CmbCodMop      = isset($_REQUEST["CmbCodMop"])?$_REQUEST["CmbCodMop"]:"";
	$TxtConjunto    = isset($_REQUEST["TxtConjunto"])?$_REQUEST["TxtConjunto"]:"";
	$TxtNombre      = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtDescripcion = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";
	$CmbEstadoLote  = isset($_REQUEST["CmbEstadoLote"])?$_REQUEST["CmbEstadoLote"]:"";
	$TxtFechaRecep  = isset($_REQUEST["TxtFechaRecep"])?$_REQUEST["TxtFechaRecep"]:"";	
	$TxtPesoBruto   = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtPesoTara    = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtPesoNeto    = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";
	$TxtPatente     = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TxtGuia        = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$Observacion    = isset($_REQUEST["Observacion"])?$_REQUEST["Observacion"]:"";
	//$HoraMin    = isset($_REQUEST["HoraMin"])?$_REQUEST["HoraMin"]:"";
	$TxtHoraE       = isset($_REQUEST["TxtHoraE"])?$_REQUEST["TxtHoraE"]:"";
	$TxtMinE        = isset($_REQUEST["TxtMinE"])?$_REQUEST["TxtMinE"]:"";

	
	if ($Proc == "M"&&$Recarga!='S')
	{
		$EstadoInput = "readonly";
		$Consulta = "select t1.cod_mop,t1.conjunto,t1.estado,t1.correlativo,t1.patente,t1.fecha,t1.peso_bruto,t1.peso_tara,t1.peso_neto,t1.guia_despacho,t1.hora_entrada, ";
		$Consulta.= " nombre,descripcion ,t1.observacion from sipa_web.otros_pesaje t1 where t1.correlativo = '".$TxtCorr."'";
		$Resp = mysqli_query($link,$Consulta);
		//echo $Consulta;
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$CmbCodMop   = $Fila["cod_mop"];
			$TxtConjunto = $Fila["conjunto"];
			$TxtNombre   = $Fila["nombre"];
			$TxtDescripcion = $Fila["descripcion"];
			$CmbEstadoLote  = $Fila["estado"];
			$TxtCorrelativo = $Fila["correlativo"];
			$TxtFechaRecep = $Fila["fecha"];
			$TxtPesoBruto  = $Fila["peso_bruto"];
			$TxtPesoTara   = $Fila["peso_tara"];
			$TxtPesoNeto   = $Fila["peso_neto"];
			$TxtGuia    = $Fila["guia_despacho"];
			$TxtPatente = $Fila["patente"];
			$HoraMin    = explode(':',$Fila["hora_entrada"]);
			$TxtHoraE   = $HoraMin[0];
			$TxtMinE    = $HoraMin[1];
			$Observacion=$Fila["observacion"];
		}
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaración del array Buffer 
var cadena="" 
function buscar_op(obj,objfoco,InicioBusq,Recargar){ 
   var f = document.FrmRecepcion;
   var letra = String.fromCharCode(event.keyCode) 
   if(puntero >= digitos){ 
       cadena=""; 
       puntero=0; 
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto... 
   if (event.keyCode == 13||event.keyCode == 27)
   { 
       borrar_buffer(); 
       if(event.keyCode != 27&&objfoco!=0) //evita foco a otro objeto si objfoco=0 
		if(Recargar=='S')
			Recarga(objfoco);	   
		else
		   objfoco.focus(); 
    } 
   //sino busco la cadena tipeada dentro del combo... 
   else{ 
       buffer[puntero]=letra; 
       //guardo en la posicion puntero la letra tipeada 
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array 
       puntero++; 

       //barro todas las opciones que contiene el combo y las comparo la cadena... 
       for (var opcombo=0;opcombo < obj.length;opcombo++){ 
          if(obj[opcombo].text.substr(InicioBusq,puntero).toLowerCase()==cadena.toLowerCase()){ 
          obj.selectedIndex=opcombo; 
          } 
       } 
    } 
   event.returnValue = false; //invalida la acción de pulsado de tecla para evitar busqueda del primer caracter 

} 

function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}

function Proceso(opt,Lote)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			if (f.CmbCodMop.value=="S"){
				alert("Debe Seleccionar Codigo Mop");
				f.CmbCodMop.focus();
				return;}
			if (f.TxtCorrelativo.value==""){
				alert("Debe Ingresar Correlativo");
				f.TxtCorrelativo.focus();
				return;}
			if (f.TxtFechaRecep.value==""){
				alert("Debe Ingresar Fecha de Recepcion");
				f.TxtFechaRecep.focus();
				return;}
			/*if (f.TxtGuia.value==""){
				alert("Debe Ingresar Num. de Guia de Despacho");
				f.TxtGuia.focus();
				return;}*/
			if (f.TxtPesoBruto.value==""){
				alert("Debe Ingresar Peso Bruto");
				f.TxtPesoBruto.focus();
				return;}
			if (f.TxtPesoTara.value==""){
				alert("Debe Ingresar Peso Tara");
				f.TxtPesoTara.focus();
				return;}
			if (f.TxtPesoNeto.value==""){
				alert("Debe Ingresar Peso Neto");
				f.TxtPesoNeto.focus();
				return;}
			if (f.TxtPatente.value==""){
				alert("Debe Ingresar Patente del Camion");
				f.TxtPatente.focus();
				return;}
			else{
				f.TxtPatente.value=f.TxtPatente.value.toUpperCase();
			}
			f.action = "rec_adm_lote01.php?Proceso=" + f.Proc.value+"&TipoRegistro=O";
			f.submit();
			break;
		case "I":
			f.BtnGuardar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnGuardar.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;
		case "S":
			window.opener.document.frmPrincipal.action = "rec_adm_lote.php?TipoCon="+f.TipoConsulta.value;
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
function Recarga(ObjFoco,Tipo)
{
	var f = document.frmProceso;
	
	f.action = "rec_adm_lote04.php?Recarga=S&ObjFoco="+ObjFoco.name;
	f.submit();		
}

</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<input type="hidden" name="TxtCorr" value="<?php echo $TxtCorr; ?>">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="4"><strong>OPERACION:
	<?php
	switch ($Proc)
	{
		case "M":
			echo "Modificando Lote-Recargo --- Despacho";
			break;
		case "N":
			echo "Insertando Nuevo Lote-Recargo";
			break;
		default:
			echo "Operacion. No Identificada";
	}	
	?></strong>
  </tr>
  <tr>
    <td width="94" class="Colum01">Correlativo: </td>
    <td width="174" class="Colum01"><input name="TxtCorrelativo" type="text" class="InputDer" id="TxtCorrelativo2" value="<?php echo str_pad($TxtCorrelativo,5,0,STR_PAD_LEFT); ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtConjunto');"></td>
    <td width="92" align="right" class="Colum01">Fecha Recep:</td>
    <td width="113" class="Colum01"><input name="TxtFechaRecep" type="text" class="InputCen" id="TxtFechaRecep" value="<?php echo $TxtFechaRecep; ?>" size="15" maxlength="10" readonly onKeyDown="TeclaPulsada2('S',false,this.form,'TxtFolio');">
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaRecep,TxtFechaRecep,popCal);return false"></td>
  </tr>
  <tr>
    <td width="94" class="Colum01">Conjunto</td>
    <td class="Colum01"><input name="TxtConjunto" type="text" class="InputIzq" value="<?php echo $TxtConjunto; ?>" size="25" maxlength="10" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtNombre');"></td>
    <td align="right" class="Colum01">&nbsp;</td>
    <td width="113" class="Colum01">&nbsp;</td>
  </tr>
  <tr>
    <td class="Colum01">Nombre:</td>
    <td colspan="3" class="Colum01"><input name="TxtNombre" type="text" class="InputIzq" value="<?php echo $TxtNombre; ?>" size="70" maxlength="30" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtDescripcion');"></td>
    </tr>

  <tr>
    <td class="Colum01">Descripcion:</td>
    <td colspan="3" class="Colum01">      <input name="TxtDescripcion" type="text" class="InputIzq" id="TxtDescripcion" value="<?php echo $TxtDescripcion; ?>" size="70" maxlength="30"></td>
    </tr>
  <tr>
    <td class="Colum01">Guia Despacho:</td>
    <td class="Colum01"><input name="TxtGuia" type="text" class="InputCen" id="TxtGuia" value="<?php echo $TxtGuia; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPesoBruto');"></td>
    <td align="right" class="Colum01">Peso Bruto:</td>
    <td class="Colum01"><input name="TxtPesoBruto" type="text" id="TxtPesoBruto2" value="<?php echo $TxtPesoBruto;?>" size="10" maxlength="10" class="InputDer" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPatente');"></td>
  </tr>
  <tr>
    <td class="Colum01">Patente:</td>
    <td class="Colum01"><span class="ColorTabla02">
      <input name="TxtPatente" type="text" class="InputCen" id="TxtPatente5" value="<?php echo $TxtPatente; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtPesoTara');">
    </span> </td>
    <td align="right" class="Colum01">Peso Tara:</td>
    <td class="Colum01"><input name="TxtPesoTara" type="text" class="InputDer" id="TxtPesoTara" value="<?php echo $TxtPesoTara; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbCodMop');">	</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod.Mop:</td>
    <td class="Colum01"><span class="ColorTabla02">
      <select name="CmbCodMop" style="width:85" onkeypress=buscar_op(this,TxtPesoNeto,0)>
        <option value='S' selected>Seleccionar</option>
        <?php
			$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='8004' order by nombre_subclase";
			$RespMOP=mysqli_query($link,$Consulta);
			while($FilaMop=mysqli_fetch_array($RespMOP))
			{
				if(intval($FilaMop["valor_subclase1"])==intval($CmbCodMop))
					echo "<option value='".$FilaMop["valor_subclase1"]."' selected>".$FilaMop["nombre_subclase"]."</option>";
				else
					echo "<option value='".$FilaMop["valor_subclase1"]."'>".$FilaMop["nombre_subclase"]."</option>";
			}
		?>
      </select>
</span></td>
    <td align="right" class="Colum01">Peso Neto:</td>
    <td class="Colum01"><input name="TxtPesoNeto" type="text" class="InputDer" id="TxtPesoNeto" value="<?php echo $TxtPesoNeto;?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtHoraE');"></td>
  </tr>
  <tr align="center" valign="middle">
    <td height="30" align="left" class="Colum01">Hora Entrada: </td>
    <td height="30" class="Colum01"><div align="left">
  <input name="TxtHoraE" type="text" class="InputCen"  value="<?php echo $TxtHoraE;?>" size="2" maxlength="2" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtMinE');">
&nbsp;:&nbsp;
  <input name="TxtMinE" type="text" class="InputCen"  value="<?php echo $TxtMinE;?>" size="2" maxlength="2" onKeyDown="TeclaPulsada2('S',false,this.form,'BtnGuardar');">
    </div></td>
    <td height="30" class="Colum01">&nbsp;</td>
    <td height="30" class="Colum01">&nbsp;</td>
  </tr>
  <tr align="center" valign="middle">
    <td height="30" align="left" class="Colum01">Observacion: </td>
    <td colspan="3" height="30" class="Colum01"><textarea name="Obs" rows="4" cols="80"><?php echo $Observacion;?></textarea></td>
  </tr>

  <tr align="center" valign="middle">
    <td height="30" colspan="4" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar" value="Guardar" style="width:70px " onClick="Proceso('G','<?php echo $TxtLote;?>')">
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
