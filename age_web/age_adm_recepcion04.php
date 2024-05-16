<?php
	include("../principal/conectar_principal.php");
	require_once 'reader.php';
	if(!isset($TxtConjunto))
		$TxtConjunto=0;
	if($Opcion=='N')
	{
		$CmbSubProducto='S';
		$TxtConjunto='0';
		$CmbSubProducto='S';
		$CmbEstadoLote='S';		
		$CmbProveedor='S';
		$CmbCodFaena='S';
		$CmbClaseProducto='S';
		$CmbCodRecepcion='S';
		$CmbCodRecepcionENM='-1';
		$TxtCancha='';
	}	
	if($Opcion=='MO')
	{
		$LotesConsulta=explode("~",$Lotes);
		if(list($c,$v)=each($LotesConsulta))
		{
			//DATOS PARA LA CABEZERA
			$Consulta="select * from age_web.lotes where lote='".$v."'";
			$Resp = mysqli_query($link, $Consulta);
			if($Fila = mysqli_fetch_array($Resp))
			{
				$TxtSubProducto=$Fila["cod_subproducto"];	
				$TxtConjunto=$Fila["num_conjunto"];
				$CmbEstadoLote=$Fila["estado_lote"];
				$CmbProveedor=$Fila["rut_proveedor"];
				$CmbCodFaena=$Fila[cod_faena];
				$CmbClaseProducto=$Fila[clase_producto];
				$CmbCodRecepcion=$Fila["cod_recepcion"];
				$CmbCodRecepcionENM=$Fila[cod_recepcion_enm];
				$TxtCancha=$Fila[cancha];
			}		
		}
	}
	if ($Proc == "M")
	{
		$EstadoInput = "readonly";
		$Consulta = "select * ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
		$Consulta.= " on t1.lote = t2.lote";
		$Consulta.= " where t1.lote = '".$TxtLote."'";
		$Consulta.= " and t2.recargo = '".$TxtRecargo."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$TxtLote = $Fila["lote"];
			$CmbSubProducto = $Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_proveedor"];
			$CmbCodFaena = $Fila["cod_faena"];
			$CmbCodRecepcion = $Fila["cod_recepcion"];
			$CmbCodRecepcionENM = $Fila["cod_recepcion_enm"];
			$CmbClaseProducto = $Fila["clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$TxtMuestraParalela = $Fila["muestra_paralela"];
			$TxtLoteRemuestreo = $Fila["num_lote_remuestreo"];
			$CmbEstadoLote = $Fila["estado_lote"];
			$TxtCancha = $Fila["cancha"];
			$CmbEstadoRecargo = $Fila["estado_recargo"];
			//DATOS DEL DETALLE
			if ($NewRec != "S")
			{
				$TxtRecargo = $Fila["recargo"];
				$TxtFolio = $Fila["folio"];
				$TxtCorrelativo = $Fila["corr"];
				$TxtFechaRecep = $Fila["fecha_recepcion"];
				$ChkFinLote = $Fila["fin_lote"];
				$TxtPesoBruto = $Fila["peso_bruto"];
				$TxtPesoTara = $Fila["peso_tara"];
				$TxtPesoNeto = $Fila["peso_neto"];
				$TxtGuia = $Fila["guia_despacho"];
				$TxtPatente = $Fila["patente"];
				$CmbAutorizado = $Fila["autorizado"];
			}
			else
			{
				$Consulta = "select ifnull(max(recargo*1),0) as ult_recargo from age_web.detalle_lotes ";
				$Consulta.= " where lote='".$TxtLote."'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
					$TxtRecargo = $Fila2["ult_recargo"] + 1;
				else
					$TxtRecargo = 1;
				$TxtFolio = "";
				$TxtCorrelativo = "";
				$TxtFechaRecep = date("Y-m-d");
				$ChkFinLote = "N";
				$TxtPesoBruto = 0;
				$TxtPesoTara = 0;
				$TxtPesoNeto = 0;
				$TxtGuia = "";
				$TxtPatente = "";
				$CmbAutorizado = "N";
			}//FIN SI ES NEWREC!= "S"
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
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "PE":
			if (f.TxtConjunto.value==""){
				alert("Debe Ingresar Num. Conjunto");
				f.TxtConjunto.focus();
				return;}
			if (f.CmbSubProducto.value=="S"){
				alert("Debe Seleccinar SubProducto");
				f.CmbSubProducto.focus();
				return;}
			if (f.CmbEstadoLote.value=="S"){
				alert("Debe Seleccinar Estado del Lote");
				f.CmbEstadoLote.focus();
				return;}
			if (f.CmbProveedor.value=="S"){
				alert("Debe Seleccionar Proveedor");
				f.CmbProveedor.focus();
				return;}
			if (f.CmbCodFaena.value=="S"){
				alert("Debe Seleccionar Faena");
				f.CmbCodFaena.focus();
				return;}
			if (f.CmbClaseProducto.value=="S"){
				alert("Debe Seleccionar Clase de Producto");
				f.CmbClaseProducto.focus();
				return;}
			if (f.CmbCodRecepcion.value=="S"){
				alert("Debe Tipo de Recepcion");
				f.CmbCodRecepcion.focus();
				return;}
			if (f.CmbCodRecepcionENM.value=="-1"){
				alert("Debe Tipo de Recepcion ENM");
				f.CmbCodRecepcionENM.focus();
				return;}
			if (f.Archivo.value==""){
				alert("Debe Adjuntar Excel");
				return;}
			f.action = "age_adm_recepcion01.php?Proceso=NLE";
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
		case "NR": //NUEVO RECARGO
			f.NewRec.value = "S";
			f.action = "age_adm_recepcion02.php";
			f.submit();
			break;
		case "R": //RECARGA		
			if (f.CmbRecargo.value!="S")
			{
				f.TxtRecargo.value = f.CmbRecargo.value;
				f.action = "age_adm_recepcion02.php";
				f.submit();
			}
			break
		case "S":
			window.opener.document.frmProceso.action = "age_adm_recepcion02.php?TipoCon=CF&Proc=N";
			window.opener.document.frmProceso.submit();
			window.close();
			break;
		case "NI":
			f.action = "age_adm_recepcion04.php?Opcion=N";
			f.submit();
			break;
	}
}
function Recarga3()
{
	var Frm=document.frmProceso;
	Frm.action="age_adm_recepcion04.php?TipoBusq=3";
	Frm.submit();	
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
<form name="frmProceso" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="4"><strong>OPERACION: CARGA AUTOMATICA DE LOTES DESDE EXCEL</strong>
	<a href="JavaScript:Proceso('NI')"><img src="../principal/imagenes/nuevo.png"  alt="Nuevo Proceso" width="18" height="19"  border="0" align="absmiddle" /></a></td>
  </tr>
  <tr class="ColorTabla02">
    <td colspan="4"><strong>DATOS DEL PROCESO </strong></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td width="92" class="Colum01">SubProducto:</td>
	<td width="180" class="Colum01">
	<?php
	if($Opcion!='MO')
	{
		?>
		<select name="CmbSubProducto" class="Select01" id="CmbSubProducto" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbEstadoLote');">
		<option value="S" class="NoSelec">SELECCIONAR</option>
		<?php
			$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
			$Consulta.= " from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto='1' order by orden";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($CmbSubProducto == $Fila["cod_subproducto"])
					echo  "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["orden"]." - ".$Fila["abreviatura"]."</option>\n";
				else
					echo  "<option value='".$Fila["cod_subproducto"]."'>".$Fila["orden"]." - ".$Fila["abreviatura"]."</option>\n";
			}
		?>	
		</select>
	<?php
	 }
	 else
	 {
			$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
			$Consulta.= " from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto='1' and cod_subproducto='".$TxtSubProducto."' order by orden";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				echo "<input type='hidden' name='CmbSubProducto' value='".$Fila["cod_subproducto"]."'>"; 
				echo $Fila["orden"]." - ".$Fila["abreviatura"];	
			}	 
	 }	 		
	?>		</td>	
    <td width="103" align="right" class="Colum01">Estado del Lote:</td>
    <td width="98" class="Colum01">
	<?php
	if($Opcion!='MO')
	{
	?>	
	<select name="CmbEstadoLote" class="Select01" id="CmbEstadoLote"  onkeydown="TeclaPulsada2('N',true,this.form,'CmbProveedor');">
     <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15003' order by cod_subclase";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["cod_subclase"]==$CmbEstadoLote)
				echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		}
	  ?>
    </select>
	<?php
	}
	else
	{
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15003' and cod_subclase='".$CmbEstadoLote."' order by cod_subclase";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbEstadoLote' value='".$Fila["cod_subproducto"]."'>"; 
			echo $Fila["nombre_subclase"];	
		}	
	}	
	?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor: </td>
    <td colspan="3" class="Colum01">
	<?php
	if($Opcion!='MO')
	{
	?>	
		<select name="CmbProveedor" class="Select01" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbCodFaena');" style="width:270">
		<option value="S" class="NoSelec">SELECCIONAR</option>
		<?php
			$Consulta = "select * ";
			$Consulta.= " from sipa_web.proveedores ";
			if($TipoBusq=='3'&&$TxtFiltroPrv!='')
			   $Consulta.= " where nombre_prv like '%".$TxtFiltroPrv."%'";    	
			$Consulta.= " order by TRIM(nombre_prv) ";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$Datos = explode("-",$Fila["rut_prv"]);
				$RutAux = ($Datos[0]*1)."-".$Datos[1];
				if ($CmbProveedor == $RutAux)
					echo  "<option selected value='".$RutAux."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"]."</option>\n";
				else
					echo  "<option value='".$RutAux."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"]."</option>\n";
			}
		?>	
		</select>
      Filtro 
      <input type="text" name="TxtFiltroPrv" size="10">
      <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
	<?php
	 }
	 else
	 {
			$Consulta = "select * ";
			$Consulta.= " from sipa_web.proveedores where rut_prv='".$CmbProveedor."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				echo "<input type='hidden' name='CmbProveedor' value='".$Fila["rut_prv"]."'>"; 
				echo str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"];
			}
	 }
	?>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod Faena: </td>
    <td colspan="3" class="Colum01">
	<?php
	if($Opcion!='MO')
	{
	?>	
		<select name="CmbCodFaena" class="Select01" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbClaseProducto');">
		<option value="S" class="NoSelec">SELECCIONAR</option>
		<?php
			$Consulta = "select distinct cod_mina,nombre_mina from sipa_web.minaprv order by nombre_mina ";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($CmbCodFaena == $Fila["cod_mina"])
					echo "<option selected value='".$Fila["cod_mina"]."'>".$Fila["cod_mina"]." - ".$Fila["nombre_mina"]."</option>\n";
				else
					echo "<option value='".$Fila["cod_mina"]."'>".$Fila["cod_mina"]." - ".$Fila["nombre_mina"]."</option>\n";
			}
		?>	
    </select>
	<?php
	 }
	 else
	 {
			$Consulta = "select distinct cod_mina,nombre_mina from sipa_web.minaprv where cod_mina='".$CmbCodFaena."' order by nombre_mina ";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				echo "<input type='hidden' name='CmbCodFaena' value='".$Fila["cod_mina"]."'>"; 
				echo $Fila["cod_mina"]." - ".$Fila["nombre_mina"];
			}	 	
	 }
	?>	</td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Clase Producto:</td>
    <td class="Colum01">
	<?php
	if($Opcion!='MO')
	{
	?>	
		<select name="CmbClaseProducto" class="Select01" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbCodRecepcion');">
		<option value="S" class="NoSelec">SELECCIONAR</option>
		  <?php
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15001' order by nombre_subclase";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Fila["nombre_subclase"]==$CmbClaseProducto)
					echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
				else
					echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
			}
		  ?>
		</select>
	<?php
	 }
	 else
	 {
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15001' and nombre_subclase='".$CmbClaseProducto."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				echo "<input type='hidden' name='CmbClaseProducto' value='".$Fila["nombre_subclase"]."'>"; 
				echo $Fila["valor_subclase1"];
			}	 
	 }
	?>	</td>					
    <td align="right" class="Colum01">Cod.Recep:</td>
    <td class="Colum01">	
	<?php
	if($Opcion!='MO')
	{
	?>	
	  <select name="CmbCodRecepcion" class="Select01" onkeydown="TeclaPulsada2('N',true,this.form,'TxtMuestraParalela');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
		$Consulta = "select * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase='3104' ";
		$Consulta.= " order by cod_subclase ";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($CmbCodRecepcion==$Fila["nombre_subclase"])
				echo "<option selected value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
		}
	  ?>
    </select>
	<?php
	}
	else
	{
		$Consulta = "select * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase='3104' and nombre_subclase='".$CmbCodRecepcion."'order by cod_subclase ";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbCodRecepcion' value='".$Fila["nombre_subclase"]."'>"; 
			echo $Fila["nombre_subclase"];
		}	
	}
	?>	</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod.Recep.ENM :</td>
    <td class="Colum01">
	<?php
	if($Opcion!='MO')
	{
	?>	
	  <select name="CmbCodRecepcionENM" class="Select01" id="CmbCodRecepcionENM" onkeydown="TeclaPulsada2('N',true,this.form,'TxtMuestraParalela');">
      <option value="-1" class="NoSelec">SELECCIONAR</option>
      <?php
		$Consulta = "select COD_C, DESC_A from rec_web.tipos  where indica='R' order by DESC_A ";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["COD_C"]==$CmbCodRecepcionENM)
				echo "<option selected value='".$Fila["COD_C"]."'>".$Fila["DESC_A"]."</option>\n";
			else
				echo "<option value='".$Fila["COD_C"]."'>".$Fila["DESC_A"]."</option>\n";
		}
	  ?>
    </select>
	<?php
	 }
	 else
	 {
		$Consulta = "select COD_C, DESC_A from rec_web.tipos  where indica='R' and COD_C='".$CmbCodRecepcionENM."' order by DESC_A ";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbCodRecepcionENM' value='".$Fila["COD_C"]."'>"; 
			echo $Fila["DESC_A"];
		}	 
	 }
	?>	</td>
    <td align="right" class="Colum01">Cancha:</td>
    <td class="Colum01">
	<?php
	if($Opcion!='MO')
	{
	?>	
		<input name="TxtCancha" type="text" class="InputDer" value="<?php echo $TxtCancha; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtRecargo');"></td>
	<?php
	}
	else
	{
	 	echo "<input type='hidden' name='TxtCancha' value='".$TxtCancha."'>"; 
	 	echo $TxtCancha;
	}	
	?>
  </tr>
  <tr class="Colum01">
    <td align="center" class="Colum01">Adjuntar Excel:</td>
    <td align="left" class="Colum01"><?php
	 if($Opcion!='MO')
	 {
	?>
      <input type="file" name="Archivo" id="Archivo">
	 <?php }?> &nbsp;</td>
    <td align="center" class="Colum01">Num.Conjunto:</td>
    <td align="left" class="Colum01"><?php
	 if($Opcion!='MO')
	 {
	?>
      <input name="TxtConjunto" type="text" class="InputDer" id="TxtConjunto2" value="<?php echo $TxtConjunto; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbSubProducto');"></td>
	<?php }
	else
		echo $TxtConjunto;
	?> &nbsp;
  
  </tr>
  <tr class="Colum01">
    <td colspan="4" align="center" class="Colum01"><?php
	if($Opcion!='MO')
	{
	?>
      <input name="BtnProcesarExcel" type="button" value="Procesar Excel" style="width:100px " onClick="Proceso('PE')">
      <?php
	} 
	?>
      <?php
	  if($ProcesaExcelOk=='S')
	  {
	  ?>
      <input name="BtnGuardar" type="button" id="BtnGuardar" value="Guardar" style="width:70px " onClick="Proceso('G')">
      <?php
	  }
	  ?>
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <?php
  //echo "Opcion:  ".$Opcion;
	if($Opcion=='MO')
	{		
		reset($LotesConsulta);$TotBruto=0;$TotTara=0;$TotNeto=0;
		while(list($c,$v)=each($LotesConsulta))
		{
			$Consulta="select * from age_web.lotes where lote='".$v."'";
			//echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			if($Fila = mysqli_fetch_array($Resp))
			{
			  echo "<tr class='ColorTabla02'>";
  				echo "<td width='97' colspan='2' align='center'>LOTE VENTANAS:</td>";
			  	echo "<td align='right'>".$Fila["lote"]."</td>";
				echo "<td width='97' colspan='2' align='center'>FECHA EMISION</td>";
				echo "<td width='97' align='center'>".$Fila[fecha_recepcion]."</td>";
			  echo  "</tr>";
				$ConsultaLote="select * from age_web.detalle_lotes where lote='".$Fila["lote"]."' and observacion<>''";
				//echo $ConsultaLote."<br>";
				$RespLote = mysqli_query($link, $ConsultaLote);
				if($FilaLote = mysqli_fetch_array($RespLote))
				{
					  $LoteOrigen=explode('-',$FilaLote["observacion"]);
					  echo "<tr class='ColorTabla02'>";
						echo "<td colspan='2' align='left'>LOTE ORIGEN:</td>";
						echo "<td  align='right'><span class='ErrorNo'>".$LoteOrigen[0]."</span></td>";
						echo "<td colspan='3' align='left'>&nbsp;</td>";
					  echo  "</tr>";
				}
				   echo "<tr class='SinBorde'>";
					echo "<td width='97' align='center'><strong>REC</strong></td>";
					echo "<td width='74' align='center'><strong>PATENTE</strong></td>";
					echo"<td width='80' align='center'><strong>GUIA</strong></td>";
					echo "<td width='103' align='center'><strong>PESO BRUTO</strong></td>";
					echo "<td width='113' align='center'><strong>PESO TARA </strong></td>";
					echo "<td width='113' align='center'><strong>PESO NETO</strong></td>";	
				   echo  "</tr>";$SubTotBruto=0;$SubTotTara=0;$SubTotNeto=0;			
				$Consulta="select *,ceiling(recargo) as RecOrden from age_web.detalle_lotes where lote='".$Fila["lote"]."' order by RecOrden asc";
				//echo $Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);
				while($Fila2 = mysqli_fetch_array($Resp2))
				{
					echo "<tr>";
					echo "<td width='97' align='center'>".$Fila2["recargo"]."</td>";
					echo "<td width='97' align='center'>".$Fila2["patente"]."</td>";
					echo "<td width='97' align='center'>".$Fila2["guia_despacho"]."</td>";
					echo "<td width='97' align='right'>".number_format($Fila2[peso_bruto],0,'','.')."</td>";
					echo "<td width='97' align='right'>".number_format($Fila2["peso_tara"],0,'','.')."</td>";
					echo "<td width='97' align='right'>".number_format($Fila2[peso_neto],0,'','.')."</td>";	
					echo "</tr>";
					$SubTotBruto=$SubTotBruto+$Fila2[peso_bruto];	
					$SubTotTara=$SubTotTara+$Fila2["peso_tara"];
					$SubTotNeto=$SubTotNeto+$Fila2[peso_neto];			
					$TotBruto=$TotBruto+$Fila2[peso_bruto];	
					$TotTara=$TotTara+$Fila2["peso_tara"];
					$TotNeto=$TotNeto+$Fila2[peso_neto];			

				}
				echo "<tr class='SinBorde'>";
				echo "<td align='right' colspan='3'>SUB-TOTAL</td>";
				echo "<td width='97' align='right'>".number_format($SubTotBruto,0,'','.')."</td>";
				echo "<td width='97' align='right'>".number_format($SubTotTara,0,'','.')."</td>";
				echo "<td width='97' align='right'>".number_format($SubTotNeto,0,'','.')."</td>";	
				echo "</tr>";					
			}

  	   }
		echo "<tr class='SinBorde'>";
		echo "<td align='right' colspan='3'>TOTAL</td>";
		echo "<td width='97' align='right'>".number_format($TotBruto,0,'','.')."</td>";
		echo "<td width='97' align='right'>".number_format($TotTara,0,'','.')."</td>";
		echo "<td width='97' align='right'>".number_format($TotNeto,0,'','.')."</td>";	
		echo "</tr>";					

  }
  ?> 
  </tr>
  <tr align="center" valign="middle">
    <td height="30" colspan="6" class="Colum01">&nbsp;</td>
    </tr>
</table>

</form>
</body>
</html>