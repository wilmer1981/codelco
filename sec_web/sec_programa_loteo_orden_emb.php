<?php 	
	include("../principal/conectar_principal.php");

	$Accion = isset($_REQUEST["Accion"])?$_REQUEST["Accion"]:"";
	$Valor  = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";
	$Prog   = isset($_REQUEST["Prog"])?$_REQUEST["Prog"]:"";
	$jcf    = isset($_REQUEST["jcf"])?$_REQUEST["jcf"]:0;
	$TipoOrden = isset($_REQUEST["TipoOrden"])?$_REQUEST["TipoOrden"]:"";
	$TxtNumProgLoteo = isset($_REQUEST["TxtNumProgLoteo"])?$_REQUEST["TxtNumProgLoteo"]:"";
	$TxtContrato = isset($_REQUEST["TxtContrato"])?$_REQUEST["TxtContrato"]:"";
	$TxtPartida = isset($_REQUEST["TxtPartida"])?$_REQUEST["TxtPartida"]:"";
    $TxtCantidad = isset($_REQUEST["TxtCantidad"])?$_REQUEST["TxtCantidad"]:"";
    $TxtCuota = isset($_REQUEST["TxtCuota"])?$_REQUEST["TxtCuota"]:"";
	/*
	if(isset($_REQUEST["Titulo"])){
		$Titulo = $_REQUEST["Titulo"];
	}else{
		$Titulo = "";
	}*/
	$TxtNumSemana = isset($_REQUEST["TxtNumSemana"])?$_REQUEST["TxtNumSemana"]:"";
    $TxtDescripcion = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";
	$TxtNumOrden = isset($_REQUEST["TxtNumOrden"])?$_REQUEST["TxtNumOrden"]:"";
    $TxtFechaDisp = isset($_REQUEST["TxtFechaDis"])?$_REQUEST["TxtFechaDisp"]:date("Y-m-d");
	$TxtFechaProg = isset($_REQUEST["TxtFechaProg"])?$_REQUEST["TxtFechaProg"]:date("Y-m-d");
	$TxtFechaDevo = isset($_REQUEST["TxtFechaDevo"])?$_REQUEST["TxtFechaDevo"]:date("Y-m-d");
	$CmbPtoEmbarque = isset($_REQUEST["CmbPtoEmbarque"])?$_REQUEST["CmbPtoEmbarque"]:"LX8";
	$CmbPtoDestino = isset($_REQUEST["CmbPtoDestino"])?$_REQUEST["CmbPtoDestino"]:"LXF";
	$CmbProducto = isset($_REQUEST["CmbProducto"])?$_REQUEST["CmbProducto"]:"";
	$CmbNave = isset($_REQUEST["CmbNave"])?$_REQUEST["CmbNave"]:"";
	$CmbAsignacion = isset($_REQUEST["CmbAsignacion"])?$_REQUEST["CmbAsignacion"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbCliente     = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	if ($CmbProducto=="")
	{
		$CmbProducto="18";
		$CmbSubProducto="40";
	}
		
	$Desactiva="";
	$Titulo =""; //WSO
	switch ($Accion)
	{
		case "N":
			$Titulo = "NUEVA&nbsp;";			
			switch ($TipoOrden)
			{
				case "ENM":
					$Consulta = "SELECT MAX(corr_codelco) as mayor ";
					$Consulta.= " from sec_web.programa_codelco where corr_codelco < '50000'";
					
					break;
				case "CODE":
					$Consulta = "SELECT IFNULL(MAX(corr_codelco),50000) as mayor "; //intellego 30-04-2015  Luis Castillo se aumenta salto para los codelco a 50000 
					$Consulta.= " from sec_web.programa_codelco where corr_codelco > '50000'"; //miel
					break;
				default:
						$Consulta = "SELECT IFNULL(MAX(corr_codelco),50000) as mayor "; //intellego 30-04-2015  Luis Castillo se aumenta salto para los codelco a 50000 
					$Consulta.= " from sec_web.programa_codelco where corr_codelco > '50000'"; //miel
				break;
			}
			  
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$TxtNumOrden=$Fila["mayor"]+1;
			}	
			break;
		case "M":
		   if ($jcf==0)
		   {
			//echo "Ingresooooo...".$Valor;
			$Datos = explode("~~",$Valor);
			$IE   = $Datos[0];
			$Tipo = isset($Datos[1])?$Datos[1]:"";
			$Titulo = "MODIFICA&nbsp;";
			$Consulta = "SELECT * from sec_web.programa_codelco where corr_codelco='".$IE."'";
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
				$TxtCantidad = '".$Fila["cantidad_programada"]."';
				$TxtCantAnt= '".$Fila["cantidad_programada"]."';
				$TxtFechaDisp = $Fila["fecha_disponible"];
				$TxtFechaProg = $Fila["fecha_programacion"];
				$TxtFechaDevo = $Fila["fecha_devolucion_maquila"];				
				if (substr($Fila["cod_cliente"],0,1)=="0")				
					$ClienteNave="N";
				else
					$ClienteNave="C";
				//if ($ClienteNave=="N")
					$CmbNave = $Fila["cod_cliente"];
				//else				
					$CmbCliente = $Fila["cod_cliente"];
				$CmbPtoEmbarque = $Fila["cod_puerto"];
				$CmbPtoDestino = $Fila["cod_puerto_destino"];
				$TxtDescripcion = $Fila["descripcion"];
			 }
			 $jcf=0;	
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
		case "NN":
			window.open("sec_programa_loteo_nave.php","","top=100,left=100,width=550,height=400,statusbar=yes,scrollbars=yes,resizable = yes");
			break;
		case "NC":
			window.open("sec_programa_loteo_cliente.php","","top=100,left=100,width=550,height=550,statusbar=yes,scrollbars=yes,resizable = yes");
			break;
		case "NPD"://NUEVO PUERTO DESTINO
			window.open("sec_programa_loteo_puerto.php","","top=100,left=100,width=550,height=400,statusbar=yes,scrollbars=yes,resizable = yes");
			break;
		case "R":
		    f.jcf.value = 1;
			f.action = "sec_programa_loteo_orden_emb.php?jcf="+f.jcf.value;
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
			if (f.CmbCliente.value=="S" && f.CmbNave.value=="S")
			{
				alert("Debe seleccionar Cliente o Nave");
				f.CmbCliente.focus();
				return;
			}
			if (f.CmbCliente.value!="S" && f.CmbNave.value!="S")
			{
				alert("Solo debe seleccionar una opcion... Cliente o Nave");
				f.CmbCliente.focus();
				return;
			}
			if (f.TxtCantAnt.value>=0)
			{
				if (f.TxtCantAnt.value!=f.TxtCantidad.value)
				{	
					
					if ((f.TxtCantidad.value*1000)<(f.TxtAcumulado.value))
					{
						alert("La cantidad no puede ser menor a lo que se encuentra pesado "+f.TxtAcumulado.value+" Kgrs");
						f.TxtCantidad.focus();
						return;
					}
					else
					{
						if(((f.TxtCantidad.value*1000)-f.TxtPesoRango.value) <= (f.TxtAcumulado.value))
						{
							if(confirm("La Instruccion quedara en estado Terminado de Pesar\nDebido que se Completara el Peso \n Desea Continuar?"))
							{
								
							}
							else
							{
								return;
							}
						}
					}
				}
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
<input type="hidden" name="jcf" value="<?php echo $jcf; ?>">
<table width="555" height="119" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#0099FF" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="550" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior" >
          <tr align="center" class="ColorTabla01"> 
            <td colspan="4"><em><strong><?php echo $Titulo; ?>&nbsp;ORDEN DE EMBARQUE CODELCO(Versi&oacute;n 1) </strong></em></td>
          </tr>
          <tr align="center">
            <td colspan="4">
<?php	
	//ORDEN ENAMI
	$Consulta = "SELECT MAX(corr_codelco) as mayor ";
	$Consulta.= " from sec_web.programa_codelco where corr_codelco < '50000'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NumOrdenENM=$Fila["mayor"]+1;
	//ORDEN CODELCO
	$Consulta = "SELECT IFNULL(MAX(corr_codelco),50000) as mayor "; //intellego 30-04-2015  Luis Castillo se aumenta salto para los codelco a 50000 
	$Consulta.= " from sec_web.programa_codelco where corr_codelco > '50000'"; //miel
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NumOrdenCODE=$Fila["mayor"]+1;
			
	switch ($TipoOrden)
	{
		case "ENM":
			echo "<input onClick=\"Proceso('R')\" name=\"TipoOrden\" type=\"radio\" value=\"CODE\">CODELCO:&nbsp;<b>".$NumOrdenCODE."</b>&nbsp;&nbsp;";
			echo "<input onClick=\"Proceso('R')\" checked name=\"TipoOrden\" type=\"radio\" value=\"ENM\">ENAMI:&nbsp;<b>".$NumOrdenENM."</b></td>";
			break;
		case "CODE":
			echo "<input onClick=\"Proceso('R')\" checked name=\"TipoOrden\" type=\"radio\" value=\"CODE\">CODELCO:&nbsp;<b>".$NumOrdenCODE."</b>&nbsp;&nbsp;";
			echo "<input onClick=\"Proceso('R')\" name=\"TipoOrden\" type=\"radio\" value=\"ENM\">ENAMI:&nbsp;<b>".$NumOrdenENM."</b></td>";		
			break;
		default:
			echo "<input onClick=\"Proceso('R')\" checked name=\"TipoOrden\" type=\"radio\" value=\"CODE\">CODELCO:&nbsp;<b>".$NumOrdenCODE."</b>&nbsp;&nbsp;";
			echo "<input onClick=\"Proceso('R')\" name=\"TipoOrden\" type=\"radio\" value=\"ENM\">ENAMI:&nbsp;<b>".$NumOrdenENM."</b></td>";		
			break;
	}

?>
          </tr>
          <tr>
            <td width="146">Num. Orden (I.E.) :</td>
            <td width="149"><input <?php echo $Desactiva; ?> name="TxtNumOrden" type="text" class="InputCen" id="TxtNumOrden" value="<?php echo $TxtNumOrden; ?>" size="12" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtNumProgLoteo');"></td>
            <td width="107" align="right">Prog. Loteo:</td>
            <td width="121"><input name="TxtNumProgLoteo" type="text" class="InputCen" id="TxtNumProgLoteo" value="<?php echo $TxtNumProgLoteo; ?>" size="12" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbAsignacion');"></td>
          </tr>
          <tr>
            <td>Asignacion:</td>
            <td colspan="3"><select name="CmbAsignacion" id="select2" onkeydown="TeclaPulsada2('S',false,this.form,'CmbProducto');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
              <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='3104' ";
	$Consulta.= " order by nombre_subclase,valor_subclase1 ";
	$var1=$Consulta;
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
			
	$Consulta = "select * from proyecto_modernizacion.productos ";
	$Consulta.= " where cod_producto in('18','48','19','64') order by descripcion";
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
			  if ($CmbProducto == '19' || $CmbProducto == '64') 
			  {
			  		if ($CmbProducto == '19')
					{
			  			$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto ";
					
						$Consulta.= " WHERE cod_producto = '".$CmbProducto."' and";
						$Consulta.= " cod_subproducto in('21','22','23','25','26') order by descripcion";
					
						$Resp = mysqli_query($link, $Consulta);
					}
					
					else
					{
			  		
			  		$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto ";
					
					$Consulta.= " WHERE cod_producto = '".$CmbProducto."' and";
					$Consulta.= " cod_subproducto in('6') order by descripcion";
					
					$Resp = mysqli_query($link, $Consulta);

			 	 	}
			  }	
			  else
			  {
				$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto ";
				$Consulta.= " WHERE cod_producto = '".$CmbProducto."'";
				$Consulta.= " order by descripcion";
				$Resp = mysqli_query($link, $Consulta);
			}
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
            <td>
<?php 
$Consulta="Select peso_rango from  sec_web.sec_parametro_peso";
	$rs = mysqli_query($link, $Consulta);
	if ($row = mysqli_fetch_array($rs))
	{
		$TxtPesoRango=$row["peso_rango"];
	}
?>
<input name="TxtPesoRango" type="hidden"  id="TxtPesoRango" value="<?php echo $TxtPesoRango; ?>"> 
<input name="TxtCantAnt" type="hidden"  id="TxtCantAnt" value="<?php echo $TxtCantAnt; ?>"> 
<input name="TxtCantidad" type="text" class="InputDer" id="TxtCantidad" value="<?php echo $TxtCantidad; ?>" size="12" maxlength="8" onKeyDown="TeclaPulsada2('S',true,this.form,'CmbCliente');">
<?php
			$AnoMenosConsulta=date('Y')-1;
			$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
			$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete  AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
			//$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
			$consulta.= " WHERE t1.corr_enm = '".$TxtNumOrden."' and year(fecha_creacion_lote) between '".$AnoMenosConsulta."' and '".date('Y')."'";//agregado 22-05-2012";
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			$TxtAcumulado = $row["peso"];
			//echo $consulta;
?>
<input name="TxtAcumulado" type="hidden"  id="TxtAcumulado" value="<?php echo $TxtAcumulado; ?>"> (TM)</td>
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
            <td rowspan="2">Cliente &oacute; Nave:</td>
            <td colspan="3"><select name="CmbCliente" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbPtoEmbarque');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
              <?php
					$Consulta = "select * from sec_web.cliente_venta where cod_cliente<>'' order by trim(sigla_cliente) ";
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_cliente"]==$CmbCliente)
							echo "<option selected value='".$Fila["cod_cliente"]."'>".$Fila["cod_cliente"]." - ".strtoupper($Fila["sigla_cliente"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_cliente"]."'>".$Fila["cod_cliente"]." - ".strtoupper($Fila["sigla_cliente"])."</option>\n";
					}								
			?>
            </select> 
            Cliente 
            </td>
          </tr>
		  <tr>
            <td colspan="3"><select name="CmbNave" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbPtoEmbarque');">
              <option value="S" class="NoSelec">SELECCIONAR</option>
              <?php
					$Consulta = "select * from sec_web.nave where cod_nave<>'' order by trim(nombre_nave) ";
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_nave"]==$CmbNave)
							echo "<option selected value='".$Fila["cod_nave"]."'>".$Fila["cod_nave"]." - ".strtoupper($Fila["nombre_nave"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_nave"]."'>".$Fila["cod_nave"]." - ".strtoupper($Fila["nombre_nave"])."</option>\n";
					}
				
			?>
            </select>
              Nave 
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
			<?php
			//echo "VV".$var1;
			?>
          </tr>
          <tr>
            <td>Descripcion:</td>
            <td colspan="3"><textarea name="TxtDescripcion" cols="50" rows="3" wrap="VIRTUAL" id="TxtDescripcion"><?php echo $TxtDescripcion; ?></textarea></td>
          </tr>
          <tr align="center" class="Detalle02">
            <td height="40" colspan="4"><input type="button" name="BtnGrabar" value="Grabar" style="width:70" onClick="Proceso('G');">
            <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
            <input name="BtnNueva" type="button" id="BtnNueva" style="width:90" onClick="Proceso('NN');" value="Nueva Nave">
            <input name="BtnNueva2" type="button" id="BtnNueva2" style="width:90" onClick="Proceso('NC');" value="Nuevo Cliente">
            <input name="BtnNueva22" type="button" id="BtnNueva22" style="width:120" onClick="Proceso('NPD');" value="Nuevo Pto. Destino"></td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
</table>
</form>
</body>
</html>