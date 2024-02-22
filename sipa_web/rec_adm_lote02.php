<?php
	include("../principal/conectar_principal.php"); 

	if(isset($_REQUEST["Proc"])){
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = '';
	}
	if(isset($_REQUEST["TipoConsulta"])){
		$TipoConsulta = $_REQUEST["TipoConsulta"];
	}else{
		$TipoConsulta = '';
	}
	if(isset($_REQUEST["TxtCorr"])){
		$TxtCorr = $_REQUEST["TxtCorr"];
	}else{
		$TxtCorr = '';
	}
	if(isset($_REQUEST["Recarga"])){
		$Recarga = $_REQUEST["Recarga"];
	}else{
		$Recarga = '';
	}

	if(isset($_REQUEST["DesbPesos"])){
		$DesbPesos = $_REQUEST["DesbPesos"];
	}else{
		$DesbPesos = '';
	}
	if(isset($_REQUEST["ObjFoco"])){
		$ObjFoco = $_REQUEST["ObjFoco"];
	}else{
		$ObjFoco = '';
	}
	if(isset($_REQUEST["BuscarPrv"])){
		$BuscarPrv = $_REQUEST["BuscarPrv"];
	}else{
		$BuscarPrv = '';
	}
		

	/*
	if(isset($_REQUEST["TxtLote"])){
		$TxtLote = $_REQUEST["TxtLote"];
	}else{
		$TxtLote = '';
	}
	if(isset($_REQUEST["TxtConjunto"])){
		$TxtConjunto = $_REQUEST["TxtConjunto"];
	}else{
		$TxtConjunto = '';
	}
	if(isset($_REQUEST["CmbGrupoProd"])){
		$CmbGrupoProd = $_REQUEST["CmbGrupoProd"];
	}else{
		$CmbGrupoProd = '';
	}
	if(isset($_REQUEST["CmbSubProducto"])){
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = '';
	}
	if(isset($_REQUEST["CmbEstadoLote"])){
		$CmbEstadoLote = $_REQUEST["CmbEstadoLote"];
	}else{
		$CmbEstadoLote = '';
	}
	if(isset($_REQUEST["CmbProveedor"])){
		$CmbProveedor = $_REQUEST["CmbProveedor"];
	}else{
		$CmbProveedor = '';
	}
	if(isset($_REQUEST["CmbMinaPlanta"])){
		$CmbMinaPlanta = $_REQUEST["CmbMinaPlanta"];
	}else{
		$CmbMinaPlanta = '';
	}
	if(isset($_REQUEST["CmbClase"])){
		$CmbClase = $_REQUEST["CmbClase"];
	}else{
		$CmbClase = '';
	}
	if(isset($_REQUEST["TxtAsignacion"])){
		$TxtAsignacion = $_REQUEST["TxtAsignacion"];
	}else{
		$TxtAsignacion = '';
	}
	if(isset($_REQUEST["TxtRecargo"])){
		$TxtRecargo = $_REQUEST["TxtRecargo"];
	}else{
		$TxtRecargo = '';
	}
	if(isset($_REQUEST["TxtFechaRecep"])){
		$TxtFechaRecep = $_REQUEST["TxtFechaRecep"];
	}else{
		$TxtFechaRecep = '';
	}
	if(isset($_REQUEST["TxtPatente"])){
		$TxtPatente = $_REQUEST["TxtPatente"];
	}else{
		$TxtPatente = '';
	}
	if(isset($_REQUEST["TxtCorrelativo"])){
		$TxtCorrelativo = $_REQUEST["TxtCorrelativo"];
	}else{
		$TxtCorrelativo = '';
	}
	if(isset($_REQUEST["TxtGuia"])){
		$TxtGuia = $_REQUEST["TxtGuia"];
	}else{
		$TxtGuia = '';
	}
	if(isset($_REQUEST["TxtObs"])){
		$TxtObs = $_REQUEST["TxtObs"];
	}else{
		$TxtObs = '';
	}
	if(isset($_REQUEST["ChkFinLote"])){
		$ChkFinLote = $_REQUEST["ChkFinLote"];
	}else{
		$ChkFinLote = '';
	}
	if(isset($_REQUEST["TxtPesoBruto"])){
		$TxtPesoBruto = $_REQUEST["TxtPesoBruto"];
	}else{
		$TxtPesoBruto = '';
	}
	if(isset($_REQUEST["TxtPesoTara"])){
		$TxtPesoTara = $_REQUEST["TxtPesoTara"];
	}else{
		$TxtPesoTara = '';
	}
	if(isset($_REQUEST["TxtPesoNeto"])){
		$TxtPesoNeto = $_REQUEST["TxtPesoNeto"];
	}else{
		$TxtPesoNeto = '';
	}*/
	




	/******************************************************* */
	if ($Proc == "M" && $Recarga!='S')
	{
		$EstadoInput = "readonly";
		$EstadoInputPesos = "readonly";
		if (isset($DesbPesos) && $DesbPesos=='S')
		{
			$EstadoInputPesos = "";
		}
		$Consulta = "SELECT t1.rut_prv,t1.observacion,t1.lote,t1.recargo,t1.cod_producto,t1.cod_subproducto,t1.cod_mina,t1.rut_prv,t1.cod_clase,t1.conjunto,t1.estado, ";
		$Consulta.= "t1.correlativo,t1.patente,t1.fecha,t1.ult_registro,t1.peso_bruto,t1.peso_tara,t1.peso_neto,t1.guia_despacho,t2.asignacion,t1.cod_grupo ";
		$Consulta.= " from sipa_web.recepciones t1 left join sipa_web.rut_asignacion t2 on t1.rut_prv=t2.rut_prv ";
		$Consulta.= " where t1.correlativo = '".$TxtCorr."' and tipo<>'A'";
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$TxtLote = $Fila["lote"];
			$CmbGrupoProd = $Fila["cod_grupo"];
			$CmbSubProducto = $Fila["cod_producto"]."~".$Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_prv"];
			//echo "Prov".$CmbProveedor."<br>";
			$CmbMinaPlanta=$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["conjunto"];
			//$CmbCodFaena = $Fila["cod_mina"];
			$TxtConjunto = $Fila["conjunto"];
			if(!is_null($Fila["asignacion"]))
				$TxtAsignacion=$Fila["asignacion"];
			else
				$TxtAsignacion="MAQ ENM";
			$CmbClaseProducto = $Fila["cod_clase"];
			$CmbEstadoLote = $Fila["estado"];
			if ($NewRec != "S")
			{
				$TxtRecargo = $Fila["recargo"];
				$TxtCorrelativo = $Fila["correlativo"];
				$TxtFechaRecep = $Fila["fecha"];
				$ChkFinLote = $Fila["ult_registro"];
				$TxtPesoBruto = $Fila["peso_bruto"];
				$TxtPesoTara = $Fila["peso_tara"];
				$TxtPesoNeto = $Fila["peso_neto"];
				$TxtGuia = $Fila["guia_despacho"];
				$TxtPatente = $Fila["patente"];
				$TxtObs=$Fila["observacion"];
			}
		}
	}
	if(isset($CmbGrupoProd))
	{
		$Consulta="SELECT abast_minero from sipa_web.grupos_productos where cod_grupo='$CmbGrupoProd'";
		$RespGrupo=mysqli_query($link, $Consulta);
		$FilaGrupo=mysqli_fetch_array($RespGrupo);
		$AbastMinero=$FilaGrupo["abast_minero"];
		if($AbastMinero=='N')
			$BuscarPrv='S';
	}	
	if(isset($BuscarPrv)&&$BuscarPrv=='S')
		{
			$Consulta = "SELECT * from sipa_web.proveedores where rut_prv='$CmbProveedor'";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
				$TxtNombrePrv=$Fila["nombre_prv"];
			//else
			//	if($CmbSubProducto!='S'&&$CmbProveedor!='')
			//		$ObjFoco='TxtNombrePrv';	
		}	
?>
<html>
<head>
<title>Sistema Pesaje</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaraci�n del array Buffer 
var cadena="" 
function Proceso(opt,Lote)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			if(Lote!='')
			{
				if (f.TxtLote.value==""){
					alert("Debe Ingresar Num. Lote");
					f.TxtLote.focus();
					return;}
				if (f.CmbSubProducto.value=="S"){
					alert("Debe Seleccionar SubProducto");
					f.CmbSubProducto.focus();
					return;}
				/*if (f.CmbEstadoLote.value=="S"){
					alert("Debe Seleccinar Estado del Lote");
					f.CmbEstadoLote.focus();
					return;}*/
				if (f.CmbProveedor.value=="S"){
					alert("Debe Seleccionar Proveedor");
					f.CmbProveedor.focus();
					return;}
				if(f.AbastMin.value=='S')
				{	
					if (f.CmbMinaPlanta.value=="S"){
						alert("Debe Seleccionar Mina/Planta");
						f.CmbMinaPlanta.focus();
						return;}
					if (f.CmbClase.value=="S"){
						alert("Debe Seleccionar Clase de Producto");
						f.CmbClase.focus();
						return;}
				}		
				if (f.TxtRecargo.value=="" || f.TxtRecargo.value=="0"){
					alert("Debe Ingresar Num. de Recargo");
					f.TxtRecargo.focus();
					return;}
			}		
			if (f.TxtCorrelativo.value==""){
				alert("Debe Ingresar Correlativo");
				f.TxtCorrelativo.focus();
				return;}
			if (f.TxtFechaRecep.value==""){
				alert("Debe Ingresar Fecha de Recepcion");
				f.TxtFechaRecep.focus();
				return;}
			if (f.TxtGuia.value==""){
				alert("Debe Ingresar Num. de Guia de Despacho");
				f.TxtGuia.focus();
				return;}
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
			f.action = "rec_adm_lote01.php?Proceso=" + f.Proc.value+"&TipoRegistro=R";
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
			f.action = "rec_adm_lote02.php";
			f.submit();
			break;
		case "R": //RECARGA		
			if (f.CmbRecargo.value!="S")
			{
				f.TxtRecargo.value = f.CmbRecargo.value;
				f.action = "rec_adm_lote02.php";
				f.submit();
			}
			break
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
	
	f.action = "rec_adm_lote02.php?Recarga=S&ObjFoco="+ObjFoco.name;
	f.submit();		
}
function ObtenerFecPadronConj()
{
	var f = document.frmProceso;
	if(f.CmbMinaPlanta.value!='S')
	{
		var Datos=f.CmbMinaPlanta.value.split('~');
		//f.TxtVencPadron.value=Datos[2];
		f.TxtConjunto.value=Datos[2];
	}	
}
function BuscarProveedor()
{
	var f = document.frmProceso;
	
	if(f.CmbProveedor.value!='S'&&f.CmbProveedor.value!='')
	{
		f.action = "rec_adm_lote02.php?BuscarPrv=S";
		f.submit();		
	}	
}
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
          obj.SELECTedIndex=opcombo; 
          } 
       } 
    } 
   event.returnValue = false; //invalida la acci�n de pulsado de tecla para evitar busqueda del primer caracter 

}
function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}
 
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<input type="hidden" name="TxtCorr" value="<?php echo $TxtCorr; ?>">
<table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="4"><strong>OPERACION:
	<?php
	switch ($Proc)
	{
		case "M":
			echo "Modificando Lote-Recargo --- Recepcion";
			break;
		case "N":
			echo "Insertando Nuevo Lote-Recargo";
			break;
		default:
			echo "Operacion. No Identificada";
		}
	?></strong></td>
  </tr>
  <?php if($TxtLote!='')
  {
  ?>
  <tr class="ColorTabla02">
    <td colspan="4"><strong>DATOS DEL LOTE </strong></td>
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
    <td width="92" class="Colum01">Lote:</td>
    <td width="180" class="Colum01"><input name="TxtLote" type="text" class="InputCen" id="TxtLote" value="<?php echo $TxtLote; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'TxtConjunto');"></td>
    <td width="103" align="right" class="Colum01">Num.Conjunto:</td>
    <td width="98" class="Colum01"><input name="TxtConjunto" type="text" class="InputDer" id="TxtConjunto2" value="<?php echo $TxtConjunto; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbSubProducto');"></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Grupo Prod :</td>
    <td class="Colum01"><span class="ColorTabla02">
      <SELECT name="CmbGrupoProd" style="width:200" onChange="Recarga('R')" <?php echo $HabilitarCmb;?>>
        <option value="S" SELECTed class="NoSelec">Seleccionar</option>
        <?php
				$Consulta = "SELECT * from sipa_web.grupos_productos order by descripcion_grupo ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbGrupoProd == $Fila["cod_grupo"])
					{	
						echo "<option SELECTed value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
						$AbastMinero=$Fila["abast_minero"];
					}	
					else
						echo "<option value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
				}
		?>
      </SELECT><input type="hidden" name="AbastMin" value="<?php echo $AbastMinero;?>">
    </span></td>
    <td align="right" class="Colum01">Estado del Lote:</td>
    <td class="Colum01"><SELECT name="CmbEstadoLote" class="Select01" id="CmbEstadoLote"  onkeydown="TeclaPulsada2('N',true,this.form,'CmbProveedor');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24001' order by cod_subclase";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["valor_subclase1"]==$CmbEstadoLote)
				echo "<option SELECTed value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>\n";
			else
				echo "<option value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>\n";
		}
	 ?>
    </SELECT></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">SubProducto:</td>
    <td colspan="3" class="Colum01"><span class="ColorTabla02">
      <SELECT name="CmbSubProducto" style="width:400" onChange="Recarga('R')" <?php echo $HabilitarCmb;?>>
        <option value="S" SELECTed class="NoSelec">Seleccionar</option>
        <?php
				$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod, ";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.="where t1.cod_grupo='".$CmbGrupoProd."' order by t2.descripcion";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_producto"]."~".$Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
					else
						echo "<option value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
				}
			  ?>
      </SELECT><?php //echo $Consulta;?>
    </span></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor:</td>
	<?php
		if($AbastMinero=='S')
		{
	?>	
    <td colspan="3" class="Colum01"><span class="ColorTabla02">
      <SELECT name="CmbProveedor" style="width:400" onkeypress=buscar_op(this,CmbMinaPlanta,0,'S') onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb;?> onChange="Recarga('R')">
        <option value="S" SELECTed>Seleccionar</option>
        <?php
				if(isset($CmbProveedor))
				{
					$SubProd=explode('~',$CmbSubProducto);
					$Consulta = "SELECT distinct rut_prv,nombre_prv from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
					$Consulta.= " where t2.cod_producto='".$SubProd[0]."' and t2.cod_subproducto='".$SubProd[1]."'";
					$Consulta.= " order by t1.nombre_prv";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($CmbProveedor == $Fila["rut_prv"])
							echo "<option SELECTed value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
						else
							echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
					}
				}	
			?>
      </SELECT><?php //echo $Consulta;?>
    </span></td>
	  <?php }
	  else
	  {
	     echo "<td colspan='3' class='Colum01'>";
		 if($CmbProveedor=='S')
			$CmbProveedor='';
		 echo "<input name='CmbProveedor' type='textbox' class='InputIzq' value='$CmbProveedor' size='14' maxlength='10' onKeyDown=\"TeclaPulsada2('N',true,this.form,'TxtNombrePrv');\" onblur='BuscarProveedor()'>&nbsp;&nbsp;Nombre:&nbsp;"; 
		 echo "<input name='TxtNombrePrv' type='textbox' class='InputIzq' value='$TxtNombrePrv' size='50' maxlength='25' onKeyDown=\"TeclaPulsada2('N',true,this.form,'CmbLotes');\">";
	  	echo "</td>";
	  }
	   ?>
  </tr>
  	<?php
		if($AbastMinero=='S')
		{
	?>	
  <tr class="Colum01">
    <td class="Colum01">Cod Mina/Planta: </td>
    <td colspan="3" class="Colum01"><span class="ColorTabla02">
      <SELECT name="CmbMinaPlanta" style="width:400" onChange="ObtenerFecPadronConj()" onKeyDown="TeclaPulsada2('N',false,this.form,'BtnPBruto');" <?php echo $HabilitarCmb;?>>
        <option value="S" SELECTed class="NoSelec">Seleccionar</option>
        <?php
	  		if(isset($CmbMinaPlanta))
			{
				$SubProd=explode('~',$CmbSubProducto);
				$Datos=explode('~',$CmbMinaPlanta);
				$Consulta = "SELECT  t1.rut_prv,t1.cod_mina,t1.nombre_mina,t1.sierra,t1.comuna,t1.fecha_padron,t3.conjunto from sipa_web.minaprv t1 ";
				$Consulta.= "left join sipa_web.grupos_prod_prv t2 on t2.cod_producto='1' and t2.cod_subproducto='".$SubProd[1]."' ";
				$Consulta.= "and t2.rut_prv='".$CmbProveedor."' and t2.cod_mina=t1.cod_mina ";
				$Consulta.= "left join sipa_web.grupos_conjunto t3 on t3.cod_grupo=t2.cod_grupo ";
				$Consulta.= "where t1.rut_prv='".$CmbProveedor."' ";
				$Consulta.= "order by t1.rut_prv,t1.cod_mina,t1.nombre_mina";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Datos[0] == $Fila["rut_prv"]&&$Datos[1] == $Fila["cod_mina"]&&$Datos[2] == $Fila["conjunto"])
						echo "<option SELECTed value='".$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["conjunto"]."'>".$Fila["cod_mina"]." | ".$Fila["nombre_mina"]." | ".$Fila["sierra"]." | ".$Fila["comuna"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["conjunto"]."'>".$Fila["cod_mina"]." | ".$Fila["nombre_mina"]." | ".$Fila["sierra"]." | ".$Fila["comuna"]."</option>\n";
				}			
			}
	  ?>
      </SELECT>
    </span></td>
    </tr>
	<?php
		}
	?>
  <tr class="Colum01">
    <td class="Colum01">Clase Producto:</td>
    <td class="Colum01"><span class="ColorTabla02">
      <SELECT name="CmbClase" style="width:100" onkeypress=buscar_op(this,CmbLotes,0,'N') onBlur="borrar_buffer()" onclick="borrar_buffer()" >
        <!--<option SELECTed value="G">GRANZA</option>-->
        <?php
			$CodProdSub=explode('~',$CmbSubProducto);
			if($CodProdSub[0]=='1')
			{	
				switch($CodProdSub[1])
				{
					case "1":
					case "2":
					case "4":
					case "5":
					case "6":
					case "9":
					case "13":
						$CmbClase='G';
						break;
					case "17":
					case "18":
					case "16":
						$CmbClase='M';
						break;
					default:
						$CmbClase='O';
						break;
				}
			}	
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15001' ";
			if($CmbClase=='O')
				$Consulta.="and nombre_subclase='O' ";//OTRA
			$Consulta.="order by nombre_subclase";
			$RespAsig=mysqli_query($link, $Consulta);
			while($FilaAsig=mysqli_fetch_array($RespAsig))
			{
				if($FilaAsig["nombre_subclase"]==$CmbClase)
					echo "<option value='".$FilaAsig["nombre_subclase"]."'SELECTed>".$FilaAsig["valor_subclase1"]."</option>";
				else
					echo "<option value='".$FilaAsig["nombre_subclase"]."'>".$FilaAsig["valor_subclase1"]."</option>";
			}
		?>
      </SELECT>
    </span></td>
    <td align="right" class="Colum01">Cod.Recep:</td>
    <td class="Colum01"><span class="ColorTabla02">
      <input name="TxtAsignacion" type="text" class="InputCen" value="<?php echo $TxtAsignacion; ?>" size="12" readonly="true" >
    </span></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">&nbsp;</td>
    <td class="Colum01">&nbsp;</td>
    <td align="right" class="Colum01">&nbsp;</td>
    <td class="Colum01">&nbsp;</td>
  </tr>
</table>
<br>
<?php }?>
<table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="4"><strong>
<?php
	if ($NewRec == "S")
		echo "<font style='color=#FF0000'>INGRESAR DATOS DEL NUEVO RECARGO</font>";
	else
		echo "DATOS DEL RECARGO";
?>	 </strong></td>
  </tr>
  <tr>
    <td width="97" class="Colum01">Num.Recargo:</td>
    <td class="Colum01"><input name="TxtRecargo" type="text" class="InputDer" id="TxtRecargo" value="<?php echo $TxtRecargo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtFechaRecep');"></td>
    <td width="103" align="right" class="Colum01">Fin Lote:</td>
    <td width="113" class="Colum01">
      <?php
	switch ($ChkFinLote)
	{
		case "S":
			echo "<input checked name='ChkFinLote' type='radio' value='S'>Si&nbsp;\n";
			echo "<input name='ChkFinLote' type='radio' value='N'>No</td>\n";
			break;
		default:
			echo "<input name='ChkFinLote' type='radio' value='S'>Si&nbsp;\n";
			echo "<input checked name='ChkFinLote' type='radio' value='N'>No</td>\n";
			break;
	}
?>  
  </tr>
  <tr>
    <td class="Colum01">Fecha Recep:</td>
    <td class="Colum01">      <input name="TxtFechaRecep" type="text" class="InputCen" id="TxtFechaRecep2" value="<?php echo $TxtFechaRecep; ?>" size="15" maxlength="10" readonly onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPatente');">
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaRecep,TxtFechaRecep,popCal);return false"></td>
    <td align="right" class="Colum01">Peso Bruto:</td>
    <td class="Colum01"><input name="TxtPesoBruto" type="text" id="TxtPesoBruto" value="<?php echo $TxtPesoBruto;?>" size="10" maxlength="10" class="InputDer" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPesoTara');" <?php echo $EstadoInputPesos;?>></td>
  </tr>
  <tr>
    <td class="Colum01">Patente:</td>
    <td class="Colum01"><input name="TxtPatente" type="text" class="InputCen" id="TxtPatente2" value="<?php echo $TxtPatente; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('N',false,this.form,'TxtCorrelativo');"></td>
    <td align="right" class="Colum01">Peso Tara:</td>
    <td class="Colum01"><input name="TxtPesoTara" type="text" class="InputDer" id="TxtPesoTara" value="<?php echo $TxtPesoTara; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPesoNeto');" <?php echo $EstadoInputPesos;?>></td>
  </tr>
  <tr>
    <td class="Colum01">Correlativo: </td>
    <td class="Colum01"><input name="TxtCorrelativo" type="text" class="InputDer" id="TxtCorrelativo2" value="<?php echo str_pad($TxtCorrelativo,5,0,STR_PAD_LEFT); ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtGuia');" readonly="true"></td>
    <td align="right" class="Colum01">Peso Neto:</td>
    <td class="Colum01"><input name="TxtPesoNeto" type="text" class="InputDer" id="TxtPesoNeto" value="<?php echo $TxtPesoNeto;?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtObs');" <?php echo $EstadoInputPesos;?>></td>
  </tr>
  <tr>
    <td class="Colum01">Guia Despacho:</td>
    <td class="Colum01">      <input name="TxtGuia" type="text" class="InputCen" id="TxtGuia2" value="<?php echo $TxtGuia; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPesoBruto');"></td>
    <td align="right" class="Colum01">&nbsp;</td>
    <td class="Colum01">&nbsp;
	<!--<a href="JavaScript:Modifica_Peso()"><img src='../principal/imagenes/cand_cerrado.gif' border="0">	</a>-->
	</td>
  </tr>
  <tr>
    <td class="Colum01">Observacion:</td>
    <td class="Colum01" colspan="3"><input name="TxtObs" type="text" class="InputIzq" value="<?php echo $TxtObs; ?>" size="60" maxlength="100" onKeyDown="TeclaPulsada2('N',false,this.form,'BtnGuardar');"></td>
  </tr>
  <tr align="center" valign="middle">
    <td height="30" colspan="4" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar" value="Guardar" style="width:70px " onClick="Proceso('G','<?php echo $TxtLote;?>')">
<?php 
	if ($Proc == "M")
	{
?>	
      <input name="BtnNuevoRec" type="hidden" id="BtnNuevoRec" value="Nuevo Recargo" style="width:100px " onClick="Proceso('NR')">
<?php
	}
?>	 
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
