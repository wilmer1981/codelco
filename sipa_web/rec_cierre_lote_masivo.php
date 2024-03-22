<?php
	$CodigoDeSistema=24;
	$CodigoDePantalla=10;
	include("../principal/conectar_principal.php");
	include("funciones.php");
	/*
	if(isset($_REQUEST["CmbTipoRegistro"])){
		$Proceso = $_REQUEST["CmbTipoRegistro"];
	}else{
		$CmbTipoRegistro = "";
	}
	if(!isset($CmbTipoRegistro))
		$CmbTipoRegistro='R';
	*/
	$CmbTipoRegistro = isset($_REQUEST["CmbTipoRegistro"])?$_REQUEST["CmbTipoRegistro"]:'R';
	$TipoCon        = isset($_REQUEST["TipoCon"])?$_REQUEST["TipoCon"]:"";
	$ObjFoco        = isset($_REQUEST["ObjFoco"])?$_REQUEST["ObjFoco"]:"BtnConsultar";
	$CmbGrupoProd   = isset($_REQUEST["CmbGrupoProd"])?$_REQUEST["CmbGrupoProd"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$OpcLote        = isset($_REQUEST["OpcLote"])?$_REQUEST["OpcLote"]:"";
	$Orden          = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$LimitIni       = isset($_REQUEST["LimitIni"])?$_REQUEST["LimitIni"]:"";
	$TxtNumRomana	= isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";

    $HabilitarCmb='';

	$ArrLeyes = array();
	$Consulta = "SELECT * from proyecto_modernizacion.leyes ";
	$RespLeyes = mysqli_query($link, $Consulta);	
	while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{
		$ArrLeyes[$FilaLeyes["cod_leyes"]][0] = $FilaLeyes["cod_leyes"];
		$ArrLeyes[$FilaLeyes["cod_leyes"]][1] = $FilaLeyes["abreviatura"];
	}
//	if(!isset($ObjFoco))
//		$ObjFoco="BtnConsultar";

	//if(!isset($OpcLote)||$OpcLote=='N')
	if($OpcLote=="" || $OpcLote=='N')
	{
		$EstOpc1='checked';
		$EstOpc2='';
		$NomBtnGrabar='Cerrar Lote';
	}else{
		$EstOpc1='';
		$EstOpc2='checked';
		$NomBtnGrabar='Abrir Lote';
	}	
		
?>
<html>
<head>
<title>SIPA-Cierre y Apertura de Lotes</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>

<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaraci�n del array Buffer 
var cadena="" 
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			//eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function Proceso(opt,valor)
{
	var f=document.frmPrincipal;
	var Operacion='';
	switch (opt)
	{
		case "G":
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote" &&f.elements[i].checked==true)
				{
					TxtLotes = TxtLotes + f.elements[i].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
			if(f.OpcLote[0].checked==true)
				operacion='N';
			else
				operacion='S';
			window.open("rec_cierre_lote_masivo_proceso.php?Proc=OM&TxtValores="+TxtLotes+"&TipoRegistro="+f.CmbTipoRegistro.value+"&Operacion="+operacion,"","top=100,left=50,width=550,height=300,scrollbars=yes,resizable=yes");
			break;
		case "CF":
			f.action = "rec_cierre_lote_masivo.php?TipoCon=CF";
			f.submit();
			break;
		case "BOL":
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote" &&f.elements[i].checked==true)
				{
					TxtLotes = TxtLotes + f.elements[i].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
			TxtLotes=TxtLotes.replace(/~/gi,'-');
			window.open("rec_adm_lote_boleta.php?Valores="+TxtLotes+"&TipoReg="+f.CmbTipoRegistro.value+"&TxtNumRomana="+f.TxtNumRomana.value,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			break;
		case "XLS":
			f.action = "rec_adm_lote_excel.php?TipoCon=<?php echo $TipoCon; ?>&Orden=<?php echo $Orden; ?>";
			f.submit();
			break;
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=24";
			f.submit();
			break;
		case "O": //ORDENA
			f.action = "rec_cierre_lote_masivo.php?LimitIni=<?php echo $LimitIni; ?>&TipoCon=<?php echo $TipoCon; ?>&Orden=" + valor;
			f.submit();
			break;
		case "R": //RECARGA
			f.action = "rec_cierre_lote_masivo.php?LimitIni=<?php echo $LimitIni; ?>&TipoCon=<?php echo $TipoCon; ?>&Orden=<?php echo $Orden; ?>&"+valor;
			f.submit();
			break;
		case "MT": //MARCA TODO
			var ValorChk = false;
			if (f.ChkMarcaTodo.checked)
				ValorChk = true;
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote"&&f.elements[i].disabled==false)
				{
					f.elements[i].checked=ValorChk;
					CCA(f.elements[i],'CL03');
				}
			}
			break;
		case "I":
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote" &&f.elements[i].checked==true)
				{
					TxtLotes = TxtLotes + f.elements[i].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
			f.action = "rec_cierre_lote_masivo_proceso01.php?TipoRegistro="+f.CmbTipoRegistro.value+"&Proceso="+opt+"&TxtValores="+TxtLotes;
			f.submit();
			break;
	}
}
function Recarga(ObjFoco,Tipo)
{
	var f = document.frmPrincipal;
	
	f.action = "rec_cierre_lote_masivo.php?ObjFoco="+ObjFoco.name;
	f.submit();		
}
function buscar_op(obj,objfoco,InicioBusq,Recargar){ 
   var f = document.frmPrincipal;
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
<script language="VBScript">
	/*
	function LeerRomana(valor)	
		ubicacion = "c:\PesaMatic\bascula.txt"	
		Set fs = CreateObject("Scripting.FileSystemObject")
		Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
		
		//Validar si el peso del archivo ==  0 no leer. 
		
		Set file2 = fs.getFile(ubicacion) 
		tamano = file2.size	

		if (tamano <> 0)	then
			valor = file.ReadLine
			valor = file.ReadLine
			valor = file.ReadLine
			valor = file.ReadLine
			LeerRomana = valor
		else
			LeerRomana = valor
		end if
			
	end function 
	*/
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
</style></head>

<body <?php echo 'onload=window.document.frmPrincipal.'.$ObjFoco.'.focus()'?>><DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoCon; ?>">
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr>
				<td>Administrar por:</td>
              <td colspan="3">
			  <SELECT name="CmbTipoRegistro" onChange="Proceso('R')">
			  <option value="S" SELECTed>Seleccionar</option>
			  <?php
			  	switch($CmbTipoRegistro)
				{
					case "R"://RECEPCION
						echo "<option value='R' SELECTed>Recepcion</option>";
						echo "<option value='D'>Despachos</option>";
						//echo "<option value='O'>Otros Pesaje</option>";
						break;
					case "D"://DESPACHOS
						echo "<option value='R'>Recepcion</option>";
						echo "<option value='D' SELECTed>Despachos</option>";
					//	echo "<option value='O'>Otros Pesaje</option>";
						break;
					//case "O"://OTROS PESAJE
					//	echo "<option value='R'>Recepcion</option>";
					//	echo "<option value='D'>Despachos</option>";
					//	echo "<option value='O' SELECTed>Otros Pesaje</option>";
					//	break;
					default:
						echo "<option value='R' SELECTed>Recepcion</option>";
						echo "<option value='D'>Despachos</option>";
						//echo "<option value='O'>Otros Pesaje</option>";
						break;						
				}
			  ?>
			  </SELECT><input type="hidden" name="TxtNumRomana" value="<?php echo $TxtNumRomana;?>">
              </td>
            </tr>
            <tr>
              <td width="13%">Grupo Producto:</td>
              <td width="48%">
              <SELECT name="CmbGrupoProd" style="width:300" onChange="Recarga(CmbSubProducto)" onkeypress="buscar_op(this,CmbSubProducto,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb;?>>
                <option value="S" SELECTed class="NoSelec">VER TODOS LOS GRUPOS</option>
                <?php
				$Consulta = "SELECT * from sipa_web.grupos_productos order by descripcion_grupo ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbGrupoProd == $Fila["cod_grupo"])
					{	
						echo "<option SELECTed value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
					}	
					else
						echo "<option value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
				}
			  ?>
              </SELECT>
</td>
              <td width="7%">&nbsp;</td>
              <td width="32%"><span class="ColorTabla02">
</span> </td>
            </tr>
            <tr>
              <td>SubProducto:</td>
              <td>
                <SELECT name="CmbSubProducto" style="width:300" onChange="Recarga(BtnConsultar)" onkeypress="buscar_op(this,BtnConsultar,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb;?>>
                  <option value="S" SELECTed class="NoSelec">VER TODOS LOS SUBPRODUCTO</option>
                  <?php
				$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod,";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.="where t1.cod_grupo='$CmbGrupoProd' order by orden";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_producto"]."~".$Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
					else
						echo "<option value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
				}
			  ?>
                </SELECT>              </td>
              <td>&nbsp;</td>
              <td>&nbsp;                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Lotes Abierto
			  	
                <input name="OpcLote" type="radio" value="N" <?php echo $EstOpc1;?> onClick="Proceso('CF')">
              Lotes Cerrados
              <input name="OpcLote" type="radio" value="S" <?php echo $EstOpc2;?> onClick="Proceso('CF')"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr align="center" class="ColorTabla02">
              <td colspan="4">
			  <input name="BtnConsultar" type="button" id="BtnConsultar4" style="width:70px " onClick="Proceso('CF')" value="Buscar">
			  <input name="BtnGrabar" type="button" id="BtnGrabar3" style="width:70px " onClick="Proceso('G')" value="<?php echo $NomBtnGrabar?>">
              <input name="BtnImprimir2" type="button" id="BtnImprimir3" style="width:100px " onClick="Proceso('BOL')" value="Boleta PDF">
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:100px " onClick="Proceso('I')" value="Imprimir Boleta">
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
            </tr>
        </table>
		  <br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
              <td width="4%"><input type="checkbox" name="ChkMarcaTodo" value="" onClick="Proceso('MT')"></td>
              <td width="5%"><a href="JavaScript:Proceso('O','F');">Fecha</a></td>
              <td width="5%"><a href="JavaScript:Proceso('O','O');">Correl.</a></td>
              <td width="4%"><a href="JavaScript:Proceso('O','L');">Lote</a></td>
              <td width="4%">Rec</td>
              <td width="2%">U</td>
			  <td width="6%"><a href="JavaScript:Proceso('O','E');">Patente</a></td>
              <td width="6%">P.Bruto</td>
              <td width="6%">P.Tara</td>
              <td width="6%">P.Neto</td>
              <td width="6%"><a href="JavaScript:Proceso('O','G');">Guia</a></td>
              <td width="11%"><a href="JavaScript:Proceso('O','T');">Producto</a></td>
              <td width="21%"><a href="JavaScript:Proceso('O','P');">Proveedor</a></td>
              <td width="4%">S.A</td>
			  <td width="4%">Est</td>
            </tr>
<?php	
if (isset($TipoCon) && $TipoCon!="")	
{
	//$TxtFechaIni=date('Y-m-d');
	//$TxtFechaFin=date('Y-m-d');
	$TxtFechaIni='2006-03-01';
	$TxtFechaFin='2006-03-31';
	switch($CmbTipoRegistro)
	{
		case "R"://RECEPCION
			$NombreTabla='sipa_web.recepciones';
			$Select="lote,recargo ";
			$order=",lote";$order1="lote,";
			break;
		case "D"://DESPACHOS
			$NombreTabla='sipa_web.despachos';
				$Select="lote,recargo ";
					$order=",lote";$order1="lote,";
			break;
		case "O"://OTROS PESAJE
			$NombreTabla='sipa_web.otros_pesaje';
				$Select=" ";
					$order="";
						$order1="";
			break;
		default:
			$NombreTabla='sipa_web.recepciones';
				$Select="lote,recargo ";
					$order=",lote";
					$order1="lote,";
			break;	
	}
	$Consulta = "SELECT ".$Select.",fecha,correlativo,ult_registro,t5.nombre_prv as nom_proveedor,t1.cod_producto, ";
	$Consulta.= " t1.cod_subproducto,peso_bruto,peso_tara,peso_neto,guia_despacho, ";
	$Consulta.= " patente,t1.rut_prv, LPAD(recargo,2,'0') as orden, leyes, impurezas ";
	$Consulta.= " ,conjunto, t4.abreviatura, max(recargo) as cant_rec,";
	switch($CmbTipoRegistro)
	{
		case "R"://RECEPCION
			$Consulta.= " cod_clase,";
			break;
		case "D"://DESPACHOS
			break;
	}
	$Consulta.= " hora_entrada,hora_salida from ".$NombreTabla." t1 ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t4 on ";
	$Consulta.= "t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
	$Consulta.= " left join sipa_web.proveedores t5 on t1.rut_prv=t5.rut_prv  ";
	$Consulta.= " where fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' and ";
	$Consulta.= " lpad(recargo,2,'0')=(SELECT max(lpad(recargo,2,'0')) from ".$NombreTabla." where  lote=t1.lote) and ult_registro='$OpcLote' "; 
	$DatosProd=explode('~',$CmbSubProducto)	;
	switch ($TipoCon)
	{
		case "CF":
			if ($CmbSubProducto!= "S")
				$Consulta.= " and t1.cod_producto='".$DatosProd[0]."' and t1.cod_subproducto='".$DatosProd[1]."'";		
			break;
	}
		$Consulta.= " group by lote ";
	switch ($Orden)
	{
		case "F"://FECHA RECEPCION
			$Consulta.= " order by fecha ".$order.",orden ";
			break;
		case "O"://CORRELATIVO
			$Consulta.= " order by correlativo ".$order.", orden ";
			break;
		case "L"://LOTE
			$Consulta.= " order by ".$order1." orden ";
			break;
		case "E"://PATENTE
			$Consulta.= " order by t1.patente, orden ";
			break;
		case "G"://GUIA DESPACHO
			$Consulta.= " order by guia_despacho ".$order.",orden ";
			break;
		case "T"://PRODUCTO
			$Consulta.= " order by lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), rut_prv ".$order.", orden ";
			break;
		case "P"://PROVEEDOR
			$Consulta.= " order by rut_prv, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0')".$order.", orden ";
			break;
		case "C"://CONJUNTO
			$Consulta.= " order by conjunto  ".$order.", orden ";
			break;
		default://POR PROVEEDOR
			$Consulta.= " order by rut_prv, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0')".$order.",orden ";
			break;
	}	
	$ConsultaAux = $Consulta;	
	$Resp = mysqli_query($link, $Consulta);
	//PARA SABER EL TOTAL DE REGISTROS
	$Respuesta = mysqli_query($link, $ConsultaAux);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		//RESCATA PASTAS E IMPUREZAS
		$Pastas = explode('~',$Fila["leyes"]);;
		$Impurezas = explode('~',$Fila["impurezas"]);
		$ArrPastas=array();
		$ArrImpurezas=array();
		//if (strlen($Pastas)>1)
		if (count($Pastas)>1)
		{
			foreach($Pastas as $c => $v)
			{
				$ArrPastas[$v][0]=$v;
				$ArrPastas[$v][1]="S";
			}
		}
		//if (strlen($Impurezas)>1)
		if (count($Impurezas)>1)
		{
			foreach($Impurezas as $c => $v)
			{
				$ArrImpurezas[$v][0]=$v;
				$ArrImpurezas[$v][1]="S";
			}
		}			
		//NOMBRE_PROV			
		if ($Fila["nom_proveedor"]=="")
			$NomProv = $Fila["nom_proveedor"];
		else
			$NomProv = isset($Fila["rut_proveedor"])?$Fila["rut_proveedor"]:"";
		//SOLICITUD DEL LOTE
		$Consulta = "SELECT distinct t2.nro_solicitud ,t2.recargo , t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from ".$NombreTabla." t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$Fila["lote"]."' and t2.estado_actual not in ('7','16')";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='') ";	
		//echo $Consulta;
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA=substr($FilaAux["nro_solicitud"],4);
			$EstadoSA=substr($FilaAux["nombre_subclase"],0,8);
			$CodEstado=$FilaAux["estado_actual"];
		}
		else
		{	$SA="&nbsp;";$EstadoSA="&nbsp;";$CodEstado='';}
		if(($OpcLote=='S')&&($CodEstado=='3'||$CodEstado=='4'||$CodEstado=='5'||$CodEstado=='6'||$CodEstado=='7'||$CodEstado=='8'||$CodEstado=='9'))
			$EstCheck='disabled';
		else
			$EstCheck='';
		$Datos=	$Fila["lote"]."~".$Fila["recargo"]."~".$Fila["correlativo"];
		echo "<tr >\n";
		echo "<td align='center'><input type='checkbox' name='ChkLote' value='".$Datos."' onClick=\"CCA(this,'CL03')\" $EstCheck></td>";
		echo "<td align='center'>".substr($Fila["fecha"],8,2)."/".substr($Fila["fecha"],5,2)."</td>\n";
		echo "<td align='center'>".str_pad($Fila["correlativo"],5,0,STR_PAD_LEFT)."</td>\n";
		echo "<td align='center'>".	substr($Fila["lote"],2)."</td>";
		echo "<td align='center'>".str_pad($Fila["recargo"],2,0,STR_PAD_LEFT)."</td>\n";
		if ($Fila["ult_registro"]!="" && !is_null($Fila["ult_registro"]))
			echo "<td align='center'>".$Fila["ult_registro"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td onMouseOver=\"JavaScript:muestra('".$Fila["lote"].$Fila["recargo"]."');\" onMouseOut=\"JavaScript:oculta('".$Fila["lote"].$Fila["recargo"]."');\" class='Detalle02'>";
		echo "<div id='Txt".$Fila["lote"].$Fila["recargo"]."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:400px'>\n";
		echo "<table width='400' border='1' cellpadding='2' cellspacing='1'>";
		switch($CmbTipoRegistro)
		{
			case "R"://RECEPCION
				echo "<tr><td width='100'>CLASE:</td><td>".$Fila["cod_clase"]."</td></tr>";
				break;
			case "D"://DESPACHOS
				break;
		}
		echo "<tr><td>HORA ENTRADA:</td><td>".$Fila["hora_entrada"]."</td></tr>";
		echo "<tr><td>HORA SALIDA:</td><td>".$Fila["hora_salida"]."</td></tr>";
		//PASTAS
		echo "<tr><td>PASTAS:</td><td>";
		reset($ArrPastas);
		$StrLeyes = "";		
		foreach($ArrPastas as $k => $v)
		{
			$StrLeyes = $StrLeyes.$ArrLeyes[$v[0]][1].", ";
		}
		if ($StrLeyes!="")
		{
			$StrLeyes=substr($StrLeyes,0,strlen($StrLeyes)-2);
			echo $StrLeyes."</td></tr>";
		}
		else
		{
			echo "&nbsp;</td></tr>";
		}
		//IMPUREZAS
		echo "<tr><td>IMPUREZAS:</td><td>";
		reset($ArrImpurezas);
		$StrLeyes = "";
		foreach($ArrImpurezas as $k => $v)
		{
			$StrLeyes = $StrLeyes.$ArrLeyes[$v[0]][1].", ";
		}
		if ($StrLeyes!="")
		{
			$StrLeyes=substr($StrLeyes,0,strlen($StrLeyes)-2);
			echo $StrLeyes."</td></tr>";
		}
		else
		{
			echo "&nbsp;</td></tr>";
		}
		$Decimales=0;
		echo "</table></div>".$Fila["patente"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_bruto"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],$Decimales,",",".")."</td>\n";
		if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
			echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($Fila["abreviatura"]!="" && !is_null($Fila["abreviatura"]))
			echo "<td>".$Fila["abreviatura"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($NomProv!="")
			echo "<td>".substr($NomProv,0,18)."</td>\n";
		else
			echo "<td>".$Fila["rut_prv"]."</td>\n";
		echo "<td>".$SA."</td>\n";	
		echo "<td>".$EstadoSA."</td>\n";	
		echo "</tr>\n";
	}
}	
?>			
		</table>          
	  </td>
	</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
<?php
echo "<script language='JavaScript'>";
echo "var f = document.frmPrincipal;";
//echo "f.TxtNumRomana.value = LeerRomana(f.TxtNumRomana.value);";
$ubicacion = 'PesaMatic';
$archivo   = 'bascula.txt';
$Romana    = LeerArchivo($ubicacion,$archivo);
//echo "Romana:".$Romana;
if($Romana==""){
	echo "f.TxtNumRomana.value='".$Romana."';";
}else{
	echo "f.TxtNumRomana.value=".$Romana.";";
}
//echo "alert(f.TxtNumRomana.value);";
echo "</script>";
?>