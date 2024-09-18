<?php 	
	$CodigoDeSistema=24;
	$CodigoDePantalla = 11;
	include("../principal/conectar_principal.php");
	
	$TxtFechaIni  = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m')."-01";
	$TxtFechaFin  = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m')."-".date('t');
	$TipoBusqueda = isset($_REQUEST["TipoBusqueda"])?$_REQUEST["TipoBusqueda"]:"";
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	$CmbAno = isset($_REQUEST["CbmAno"])?$_REQUEST["CbmAno"]:"";
	$CbmMes = isset($_REQUEST["CbmMes"])?$_REQUEST["CbmMes"]:"";
/********************************************************* */
	if(isset($_REQUEST["OpcConsulta"])){
		$OpcConsulta = $_REQUEST["OpcConsulta"];
	}else{
		$OpcConsulta = "";
	}
	if(isset($_REQUEST["CmbTipoRegistro"])){
		$CmbTipoRegistro = $_REQUEST["CmbTipoRegistro"];
	}else{
		$CmbTipoRegistro = "";
	}
	if(isset($_REQUEST["TxtLoteIni"])){
		$TxtLoteIni = $_REQUEST["TxtLoteIni"];
	}else{
		$TxtLoteIni = "";
	}
	if(isset($_REQUEST["TxtLoteFin"])){
		$TxtLoteFin = $_REQUEST["TxtLoteFin"];
	}else{
		$TxtLoteFin = "";
	}
	if(isset($_REQUEST["TxtConjIni"])){
		$TxtConjIni = $_REQUEST["TxtConjIni"];
	}else{
		$TxtConjIni = "";
	}
	if(isset($_REQUEST["TxtConjFin"])){
		$TxtConjFin = $_REQUEST["TxtConjFin"];
	}else{
		$TxtConjFin = "";
	}
	if(isset($_REQUEST["CmbGrupoProd"])){
		$CmbGrupoProd = $_REQUEST["CmbGrupoProd"];
	}else{
		$CmbGrupoProd = "";
	}
	if(isset($_REQUEST["CmbSubProducto"])){
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = "";
	}
	if(isset($_REQUEST["CmbProveedor"])){
		$CmbProveedor = $_REQUEST["CmbProveedor"];
	}else{
		$CmbProveedor = "";
	}	 
	
	
	/************************************************** */

	switch($OpcConsulta)
	{
		case "F":
			$CheckOpcF='checked';
			$CheckOpcL='';
			$CheckOpcC='';
			$CheckOpcP='';
			break;
		case "L":
			$CheckOpcL='checked';
			$CheckOpcF='';
			$CheckOpcC='';
			$CheckOpcP='';
			break;
		case "C":
			$CheckOpcC='checked';
			$CheckOpcF='';
			$CheckOpcL='';
			$CheckOpcP='';
			break;
		case "P":
			$CheckOpcP='checked';
			$CheckOpcF='';
			$CheckOpcL='';
			$CheckOpcC='';
			break;
		default:
			$CheckOpcF='checked';
			$CheckOpcL='';
			$CheckOpcC='';
			$CheckOpcP='';
			break;
		break;	
	}
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaración del array Buffer 
var cadena="" 
function buscar_op(obj,objfoco,InicioBusq){ 
   var f = document.FrmPrincipal;
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
   event.returnValue = false; //invalida la acción de pulsado de tecla para evitar busqueda del primer caracter 

} 

function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}
function Recarga2()
{
	var Frm=document.FrmPrincipal;
	
	Frm.action='rec_con_multiple_recepciones.php';
	Frm.submit();
}
function Recarga(TipoBusq)
{
	var Frm=document.FrmPrincipal;
	switch(TipoBusq)
	{
		case "1"://POR FECHA		
			Frm.TxtLoteIni.value = "";
			Frm.TxtLoteFin.value = "";
			Frm.TxtConjIni.value = "";
			Frm.TxtConjFin.value = "";
			Frm.TxtFechaIni.focus();
			break;
		case "2"://POR LOTE
			Frm.TxtConjIni.value = "";
			Frm.TxtConjFin.value = "";
			Frm.TxtLoteIni.focus();
			break;
		case "3"://POR CONJUNTO
			Frm.TxtLoteIni.value = "";
			Frm.TxtLoteFin.value = "";
			Frm.TxtConjIni.focus();
			break;
		case "4"://POR CONJUNTO
			Frm.TxtLoteIni.value = "";
			Frm.TxtLoteFin.value = "";
			Frm.TxtConjIni.value = "";
			Frm.TxtConjFin.value = "";
			Frm.CmbMes.focus();
			break;
	}
	Frm.TipoBusqueda.value=TipoBusq;
}
function Consulta(opt)
{
	var f=document.FrmPrincipal;
	switch (f.TipoBusqueda.value)
	{
		case "2":
			if(f.CmbTipoRegistro.value=='R'||f.CmbTipoRegistro.value=='D')
			{
				if (f.TxtLoteIni.value=="")
				{
					alert("Debe Ingresar Rango de Lotes");
					f.TxtLoteIni.focus();
					return;
				}
				if (f.TxtLoteIni.value!="" && f.TxtLoteFin.value=="")
					f.TxtLoteFin.value = f.TxtLoteIni.value;
			}		
			else
			{
				alert("Otros Pesajes no Registra Lotes");
				return;
			}			
			break;
		case "3":
			if(f.CmbTipoRegistro.value=='R')
			{
				if (f.TxtConjIni.value=="")
				{
					alert("Debe Ingresar Rango de Conjuntos");
					f.TxtConjIni.focus();
					return;
				}
				if (f.TxtConjIni.value!="" && f.TxtConjFin.value=="")
					f.TxtConjFin.value = f.TxtConjIni.value;
			}
			else
			{
				alert("Conjuntos solo para Recepciones");
				return;
			}
			break;
		case "4":
			if(f.CmbTipoRegistro.value=='O')
			{
				alert("Otros Pesajes no Registra Proveedores");
				return;
			}
			break;
	}
	switch (opt)
	{
		case "W":
			f.action = "rec_con_multiple_recepciones_web.php";
			break;
		case "E":
			f.action = "rec_con_multiple_recepciones_excel.php";
			break;
	}	
	f.submit();
	
}
function Salir()
{
	var Frm=document.FrmPrincipal;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=24";
	Frm.submit();
}
</script>
<title>Consulta Multiple Recepciones Y Despachos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style type="text/css">
.Estilo1 {color: #0000ff}
</style>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="TipoBusqueda" value="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top">
	    <table width="750" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
   		  <tr>
            <td colspan="10" align="center" class="Detalle02">Consultar Por:&nbsp;
              <SELECT name="CmbTipoRegistro">
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
						//echo "<option value='O'>Otros Pesaje</option>";
						break;
					case "O"://OTROS PESAJE
						echo "<option value='R'>Recepcion</option>";
						echo "<option value='D'>Despachos</option>";
						//echo "<option value='O' SELECTed>Otros Pesaje</option>";
						break;
					default:
						echo "<option value='R' SELECTed>Recepcion</option>";
						echo "<option value='D'>Despachos</option>";
						//echo "<option value='O'>Otros Pesaje</option>";
						break;						
				}
			  ?>
              </SELECT>
            </td>
		  </tr>
   		  <tr>
            <td colspan="10" bgcolor="#FFFFFF">&nbsp;</td>
		  </tr>
		  <tr>
            <td width="26" class="Detalle02">
              <input name="OpcConsulta" type="radio" onClick="Recarga('1')" value="F" <?php echo $CheckOpcF;?>></td>
            <td width="246" align="left" class="Detalle02"><div align="left">Fecha</div></td>
            <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td colspan="6" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">Del&nbsp;
                <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="13" maxlength="10" readonly >
                <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al 
                <input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
                <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
            <td width="84" align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td colspan="6" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01">Periodo:</td>
            <td>&nbsp;</td>
          <td colspan="5"><SELECT name="CmbMes"  onKeyDown="TeclaPulsada2('N',false,this.form,'CmbAno');">
            <?php
	for ($i=1;$i<=12;$i++)
	{
		if ($Mes=="")
		{
			if ($i == date("n"))
				echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}	
		else
		{
			if ($i == $Mes)
				echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
?>
          </SELECT>
            <SELECT name="CmbAno"  onKeyDown="TeclaPulsada2('N',false,this.form,'CmbSubProducto');">
              <?php
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
	{
		if ($Ano=="")
		{
			if ($i == date("Y"))
				echo "<option SELECTed value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}	
		else
		{
			if ($i == $Ano)
				echo "<option SELECTed value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
?>
            </SELECT>
            (Solo Conjunto y Proveedor)</td>
          </tr>
          <tr>
            <td class="Detalle02">
              <input name="OpcConsulta" type="radio" value="L" onClick="Recarga('2')" <?php echo $CheckOpcL;?>>
            </td>
            <td class="Detalle02"><div align="left">Lotes</div></td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01">Grupo Prod.:</td>
            <td width="33">&nbsp;</td>
            <td colspan="5"><span class="ColorTabla02">
              <SELECT name="CmbGrupoProd" style="width:250" onChange="Recarga2()">
                <option value="S" SELECTed class="NoSelec">Seleccionar</option>
                <?php
				$Consulta = "SELECT * from sipa_web.grupos_productos order by descripcion_grupo ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbGrupoProd == $Fila["cod_grupo"])
						echo "<option SELECTed value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
					else
						echo "<option value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
				}
			  ?>
              </SELECT>
            </span></td>
          </tr>
          <tr>
            <td colspan="2">N&deg; Inicio
                <input name="TxtLoteIni" type="text" class="InputCen" value="<?php echo $TxtLoteIni;?>" size="12" maxlength="8"  onKeyDown="TeclaPulsada2('S',false,this.form,'TxtLoteFin');">
&nbsp; N&deg; Final
      <input name="TxtLoteFin" type="text"  class="InputCen" value="<?php echo $TxtLoteFin;?>" size="12" maxlength="8" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbMes');">
            </td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01">SubProducto:</td>
            <td>&nbsp;</td>
            <td colspan="5"><span class="ColorTabla02">
              <SELECT name="CmbSubProducto" style="width:250" onChange="Recarga2()" >
                <option value="S" SELECTed class="NoSelec">Seleccionar</option>
                <?php
				$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod, ";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.="where t1.cod_grupo='".$CmbGrupoProd."' order by nom_subprod";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_producto"]."~".$Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
					else
						echo "<option value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
				}
			  ?>
              </SELECT>
            </span></td>
          </tr>
          <tr>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
            <td align="right" bgcolor="#FFFFFF"><span class="Detalle01">Proveedor:</span></td>
            <td align="right">&nbsp; </td>
            <td colspan="5"><span class="ColorTabla02">
              <SELECT name="CmbProveedor" style="width:300" onkeypress=buscar_op(this,OpcTR,0,'S') onBlur="borrar_buffer()" onclick="borrar_buffer()">
                <option value="S" class="NoSelec" SELECTed>Seleccionar</option>
                <?php
					$SubProd=explode('~',$CmbSubProducto);
					$Consulta = "SELECT distinct rut_prv,nombre_prv from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
					if($CmbSubProducto!="" && $CmbSubProducto!='S')
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
			   ?>
              </SELECT><?php //echo $Consulta;?>
            </span></td>
          </tr>
          <tr>
            <td class="Detalle02"><input name="OpcConsulta" type="radio" value="C" onClick="Recarga('3')" <?php echo $CheckOpcC;?>></td>
            <td class="Detalle02">Conjuntos</td>
            <td align="right" bgcolor="#FFFFFF"><span class="Estilo1">Ver Datos por:</span></td>
            <td align="right">Lote:</td>
          <td width="22"><input name="OpcTR" type="radio" value="T" checked></td>
            <td width="60" align="right">Recargos:</td>
            <td width="24"><input name="OpcTR" type="radio" value="R"></td>
          <td width="37" align="right">&nbsp;</td>
          <td width="143">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">N&deg; Inicio
                <input name="TxtConjIni" type="text"  class="InputCen" value="<?php echo $TxtConjIni;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtConjFin');">
&nbsp; N&deg; Final
      <input name="TxtConjFin" type="text" class="InputCen" value="<?php echo $TxtConjFin;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbMes');">
            </td>
            <td align="right" bgcolor="#FFFFFF">&nbsp;              <input name="OpcHLF" type="hidden" value="P" checked></td>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td class="Detalle02"><input name="OpcConsulta" type="radio" value="P" onClick="Recarga('4')" <?php echo $CheckOpcP;?>></td>
            <td class="Detalle02">Proveedor</td>
            <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td colspan="6">&nbsp;</td>
          </tr>
        </table>
	    <br>
	  <table width="750" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
        <tr>
          <td align="center"><input name="BtnConsulta" type="button" value="Consultar" onClick="Consulta('W')">
            <input name="BtnExcel" type="button" value="Excel"style="width:70" onClick="Consulta('E')">
            <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();"></td>
        </tr>
      </table>	  <br>  </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>