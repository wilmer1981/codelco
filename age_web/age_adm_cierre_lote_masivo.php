<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=56;

	$Proceso          = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$CmbSubProducto   = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor     = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtNomProveedor  = isset($_REQUEST["TxtNomProveedor"])?$_REQUEST["TxtNomProveedor"]:"";
	$CmbMes        = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno        = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$Chequeado1    = isset($_REQUEST["Chequeado1"])?$_REQUEST["Chequeado1"]:"";
	$Chequeado2    = isset($_REQUEST["Chequeado2"])?$_REQUEST["Chequeado2"]:"";
	$BuscarCanje   = isset($_REQUEST["BuscarCanje"])?$_REQUEST["BuscarCanje"]:"";
	$TipoBusqueda  = isset($_REQUEST["TipoBusqueda"])?$_REQUEST["TipoBusqueda"]:"";
	$Buscar        = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtLoteIni    = isset($_REQUEST["TxtLoteIni"])?$_REQUEST["TxtLoteIni"]:"";
	$TxtLoteFin    = isset($_REQUEST["TxtLoteFin"])?$_REQUEST["TxtLoteFin"]:"";
	$EstadoInput   = isset($_REQUEST["EstadoInput"])?$_REQUEST["EstadoInput"]:"";
	$CheckCanjeSi  = isset($_REQUEST["CheckCanjeSi"])?$_REQUEST["CheckCanjeSi"]:""; 
	$CheckCanjeNo  = isset($_REQUEST["CheckCanjeNo"])?$_REQUEST["CheckCanjeNo"]:""; 
	$ChequeadoCanje1  = isset($_REQUEST["ChequeadoCanje1"])?$_REQUEST["ChequeadoCanje1"]:"";
	$ChequeadoCanje2  = isset($_REQUEST["ChequeadoCanje2"])?$_REQUEST["ChequeadoCanje2"]:""; 
	$GrabarHabilitado = isset($_REQUEST["GrabarHabilitado"])?$_REQUEST["GrabarHabilitado"]:""; 
	$Petalo        = isset($_REQUEST["Petalo"])?$_REQUEST["Petalo"]:""; 
	$Busq          = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:""; 
	$Recarga       = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:""; 
	$Orden         = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$Opt           = isset($_REQUEST["Opt"])?$_REQUEST["Opt"]:"";

	if($CmbMes=="")
	{
		$LoteIni=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."0001";
		$LoteFin=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."9999";
	}
	else
	{
		if ($CmbAno<2006)
		{
			$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
			$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
		}
		else
		{
			$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
			$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
		}
	}	
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Consulta="SELECT count(*) as cant from age_web.lotes where lote between '".$LoteIni."' and '".$LoteFin."' and estado_lote not in ('2','4','6') and cod_subproducto<'90' ";
	$Respuesta=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
	{
		$CantLotesAbiertos=$Fila["cant"];
	}
	if($Chequeado1=="")
		$Chequeado1='checked';
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
	if($BuscarCanje!="")
		switch($BuscarCanje)
		{
			case "S":
				$ChequeadoCanje1='';
				$ChequeadoCanje2='checked';
				break;
			case "N":
				$ChequeadoCanje1='checked';
				$ChequeadoCanje2='';
				break;
			default:
				$ChequeadoCanje1='';
				$ChequeadoCanje2='';
				break;
		}
?>
<html>
<head>
<title>AGE-Adm.Cierre Lote Masivo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function DesabilitarCheck(opt)
{
	var f = document.frmPrincipal;

	switch(opt)
	{
		case "1"://CLICK SIN CANJE
			f.Check_CCanje.checked='';
			break;
		case "2"://CLICK CON CANJE
			f.Check_SCanje.checked='';
			break;
	}
}
function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	var Valores='';
	var BuscarCanje='';
	
	switch (opt)
	{
		case "B"://BUSCAR
			if(f.Opt[0].checked==true)
			{
				$Chequeado1='checked';
				$Chequeado2='';
			}	
			else
			{	
				$Chequeado1='';
				$Chequeado2='checked';
			}
			if(f.Check_SCanje.checked)
				BuscarCanje='N'
			if(f.Check_CCanje.checked==true)
				BuscarCanje='S'
			if(f.TxtLoteIni.value=='')
			{
				//BUSQUEDA POR MES(BM)
				f.action = "age_adm_cierre_lote_masivo.php?Orden=<?php echo $Orden; ?>&Recarga=S&TipoBusqueda=BM&Buscar=S&Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2+"&BuscarCanje="+BuscarCanje;
			}
			else
			{
				//BUSQUEDA POR LOTE(BL)
				if(f.TxtLoteFin.value=='')
					f.TxtLoteFin.value=f.TxtLoteIni.value;
				f.action = "age_adm_cierre_lote_masivo.php?Orden=<?php echo $Orden; ?>&Recarga=S&TipoBusqueda=BL&Buscar=S&Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2+"&BuscarCanje="+BuscarCanje;
			}
			f.submit();		
			break;		
		case "G"://CERRAR LOTES
			Valores=RecuperarValoresCheckeado();
			if(Valores!='')
			{
				if(confirm('Esta Seguro de Cerrar Los Lotes'))
				{
					f.action = "age_adm_cierre_lote01.php?Proceso=M&Valores="+Valores;
					f.submit();	
				}
			}
			else
				alert('Debe Seleccionar Lote(s)');
			break;
		case "MC"://SOLO GRABAR CANJE(CON O SIN CANJE)
			Valores=RecuperarValoresCheckeado();
			if(confirm('Esta Seguro de Grabar C/S Canje'))
			{
				f.action = "age_adm_cierre_lote01.php?Proceso=MC&Valores="+Valores;
				f.submit();	
			}
			break;
			
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "E"://EXCEL	
			if(f.Opt[0].checked==true)
			{
				$Chequeado1='checked';
				$Chequeado2='';
			}	
			else
			{	
				$Chequeado1='';
				$Chequeado2='checked';
			}
			if(f.Check_SCanje.checked)
				BuscarCanje='N'
			if(f.Check_CCanje.checked==true)
				BuscarCanje='S'
			if(f.TxtLoteIni.value=='')
			{
				//BUSQUEDA POR MES(BM)
				//f.action = "age_adm_cierre_lote_masivo.php?Recarga=S&TipoBusqueda=BM&Buscar=S&$Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2;
				f.action = "age_adm_cierre_lote_masivo_excel.php?Recarga=S&TipoBusqueda=BM&Buscar=S&$Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2+"&BuscarCanje="+BuscarCanje;
			}
			else
			{
				//BUSQUEDA POR LOTE(BL)
				if(f.TxtLoteFin.value=='')
					f.TxtLoteFin.value=f.TxtLoteIni.value;
				f.action = "age_adm_cierre_lote_masivo_excel.php?Recarga=S&TipoBusqueda=BL&Buscar=S&$Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2+"&BuscarCanje="+BuscarCanje;
				//f.action = "age_adm_cierre_lote_masivo_excel.php?Buscar=S&$Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2;				
			}
			f.submit();
			break;
		case "O"://ORDENAMIENTO
			if(f.Opt[0].checked==true)
			{
				$Chequeado1='checked';
				$Chequeado2='';
			}	
			else
			{	
				$Chequeado1='';
				$Chequeado2='checked';
			}
			if(f.Check_SCanje.checked)
				BuscarCanje='N'
			if(f.Check_CCanje.checked==true)
				BuscarCanje='S'
			if(f.TxtLoteIni.value=='')
			{
				//BUSQUEDA POR MES(BM)
				f.action = "age_adm_cierre_lote_masivo.php?Recarga=S&TipoBusqueda=BM&Buscar=S&$Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2+"&Orden="+opt2+"&BuscarCanje="+BuscarCanje;
			}
			else
			{
				//BUSQUEDA POR LOTE(BL)
				if(f.TxtLoteFin.value=='')
					f.TxtLoteFin.value=f.TxtLoteIni.value;
				f.action = "age_adm_cierre_lote_masivo.php?Recarga=S&TipoBusqueda=BL&Buscar=S&$Chequeado1="+$Chequeado1+"&Chequeado2="+$Chequeado2+"&Orden="+opt2+"&BuscarCanje="+BuscarCanje;
			}
		
			//f.action = "age_adm_cierre_lote_masivo.php?Orden="+opt2;
			f.submit();
			break;		
		case "R":
			f.action = "age_adm_cierre_lote_masivo.php?Recarga=S";
			frmPrincipal.submit();
			break;
		case "ELI":
			if(confirm('Esta Seguro de Eliminar el o los Lote(s)'))
			{
				f.action = "age_adm_cierre_lote01.php?Proceso=ELI&Lote="+opt2;
				frmPrincipal.submit();
			}
			break;
		case "S"://SALIR
			frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=50";
			frmPrincipal.submit();
			break;			
	}
}
function DetalleLote(Lote)
{
	window.open("../age_web/age_adm_cierre_lote.php?Orden=<?php echo $Orden; ?>&EsPopup=S&TxtLote="+Lote,"","top=0,left=0,width=800,height=600,scrollbars=yes,resizable = yes");					
}
function CheckearTodo()
{
	var Frm = frmPrincipal;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckCod[i].checked=true;
			}
			else
			{
				Frm.CheckCod[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function RecuperarValoresCheckeado()
{
	var Frm = frmPrincipal;
	var Valores="";
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
			{
				Valores=Valores + Frm.CheckCod[i].value+"//";
			}
		}
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);
	}
	catch (e)
	{
	}
}
function DetalleLeyes(Lote,Estado,Tipo,Canjeable)
{
	if(Tipo=='CDV')
	{
		//if(Estado=='4')
		//{
			if(confirm("Desea Generar Certificado Definitivo\n(Si Presiona Cancelar Solo Emitira un Borrador)"))
				window.open("../age_web/age_certificado_leyes.php?Orden=<?php echo $Orden; ?>&Tipo=CDV&GrabarCert=S&Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			else
				window.open("../age_web/age_certificado_leyes.php?Orden=<?php echo $Orden; ?>&Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
		//}
		//else
			//window.open("../age_web/age_certificado_leyes.php?Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");			
	}
	else
	{
		//if(Estado=='4')
		//{
			if(confirm("Desea Generar Certificado Definitivo\n(Si Presiona Cancelar Solo Emitira un Borrador)"))
				window.open("../age_web/age_certificado_leyes_enm.php?Orden=<?php echo $Orden; ?>&Tipo=ENM&GrabarCert=S&Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			else
				window.open("../age_web/age_certificado_leyes_enm.php?Orden=<?php echo $Orden; ?>&Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
		//}
		//else
			//window.open("../age_web/age_certificado_leyes_enm.php?Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");			
	}
			
}
function DescargaArchivos(Lote)
{
	window.open("age_descarga_cert.php?Lote="+Lote,"","top=35,left=10,width=600,height=400,scrollbars=yes,resizable=YES,toolbar=YES,menubar=YES");
}
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleAnalisis(SA,Rec)
{
	window.open("age_con_detalle_leyes.php?SA="+ SA+"&Recargo="+Rec,"","top=70,left=50,width=400,height=430,scrollbars=yes,resizable = yes");					
}
function Recarga3()
{
	var Frm = frmPrincipal;
	Frm.action="age_adm_cierre_lote_masivo.php?Busq=S";
	Frm.submit();	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>
<body onLoad="window.document.frmPrincipal.TxtLoteIni.focus();">
<form name="frmPrincipal" action="JavaScript:Proceso('B')" method="post">
<?php include("../principal/encabezado.php") ?>
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
<table width="750"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02" align="center">
    <td colspan="4"><strong>VALIDACION LOTES MASIVO </strong></td>
  </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Mes:</td>
    <td class="Colum01"><?php
			echo "<select name='CmbMes' size='1' style='width:90px;'>";
			for($i=1;$i<13;$i++)
			{
				if ($i==$CmbMes&&$Recarga=='S')
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else if ($i==date("n")&&$Recarga!='S')	
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else	
					echo "<option value='".$i."'>".$meses[$i-1]."</option>";
			}
			echo "</select>";
			echo "<select name='CmbAno' size='1' style='width:70px;'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if ($i==$CmbAno&&$Recarga=='S')
					echo "<option selected value ='$i'>$i</option>";
				else if ($i==date('Y')&&$Recarga!='S')
					echo "<option selected value ='$i'>$i</option>";
				else		
					echo "<option value='".$i."'>".$i."</option>";
			}
			echo "</select>";
			?>&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#FF0000">Lotes No Validados en el Mes:</font></strong>&nbsp;&nbsp;
      <input name="textfield" type="text" class='InputColor' value='<?php echo $CantLotesAbiertos;?>' size="8" readonly></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">SubProducto:</td>
    <td class="Colum01">
		<select name="CmbSubProducto" style="width:300" onChange="Proceso('R');">
        <option class="NoSelec" value="S">TODOS</option>
      <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
    </select>  </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor:</td>
    <td class="Colum01"><select name="CmbProveedor" style="width:300">
      <option class="NoSelec" value="S">TODOS</option>
      <?php
				$Consulta = "select t1.rut_proveedor, t2.nombre_prv as nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join sipa_web.proveedores t2 on t1.rut_proveedor = t2.rut_prv ";
				$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' ";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t2.nombre_prv like '%".$TxtFiltroPrv."%' ";  				
				$Consulta.= "order by t2.nombre_prv ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
				}
			?>
    </select>
      ---> Filtro Prv&nbsp;
      <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
      <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">            
    </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Lote Inicio:</td>
    <td width="664" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtLoteIni" type="text" class="InputCen" value="<?php echo $TxtLoteIni; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
      &nbsp;&nbsp;&nbsp;
      Lote Final: 
        <input <?php echo $EstadoInput; ?> name="TxtLoteFin" type="text" class="InputCen" id="TxtLote2" value="<?php echo $TxtLoteFin; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
        &nbsp;&nbsp;&nbsp;
        Lotes Validados 
        <input name="Opt" type="radio" value="C" <?php echo $Chequeado1;?> onClick="Proceso('B')">
        &nbsp;&nbsp;&nbsp;
        Lotes No Validados
        <input name="Opt" type="radio" value="A" <?php echo $Chequeado2;?> onClick="Proceso('B')">&nbsp;&nbsp;&nbsp;
        S/Canje&nbsp;<input type="checkbox" name="Check_SCanje" value="S" onClick="DesabilitarCheck('1')" <?php echo $ChequeadoCanje1;?>>&nbsp;&nbsp;C/Canje&nbsp;
        <input type="checkbox" name="Check_CCanje" value="N" onClick="DesabilitarCheck('2')" <?php echo $ChequeadoCanje2;?>>
  </tr>
  <tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">
		<input name="BtnOK" type="button" value="Buscar" style="width:80px " onClick="Proceso('B')">
		<input name="BtnGrabar" type="button" value="Cerrar Lotes" style="width:80px " onClick="Proceso('G')">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I','<?php echo $Petalo?>')">
		<input name="BtnExcel" type="button" value="Excel" style="width:80px " onClick="Proceso('E','<?php echo $Petalo?>')">
		<input name="BtnSalir" type="button" value="Salir" style="width:80px " onClick="Proceso('S')">
		<input name="BtnGrabarCanje" type="button" value="Grabar Canje" style="width:100px " onClick="Proceso('MC')" <?php echo $GrabarHabilitado;?>>
		Canje:&nbsp;&nbsp;&nbsp;Si
		<input name="OptCanje" type="radio" value="S" <?php echo $CheckCanjeSi;?>>
No
<input name="OptCanje" type="radio" value="N" <?php echo $CheckCanjeNo;?>>
	  </td>
	</tr>
	</table>
	<br>
	<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0' class='TablaInterior'>
	<tr align="center" class="ColorTabla01">
	<td><input type="checkbox" name="CheckTodos" onClick="CheckearTodo()"></td>
	<td><a href="JavaScript:Proceso('O','L');">Lote</a></td>
	<td><a href="JavaScript:Proceso('O','S');">SubProducto</a></td>
	<td><a href="JavaScript:Proceso('O','P');">Proveedor</a></td>
	<td>C.Cdv</td>
	<td>C.Enm</td>
	<td>Ver</td>
	<td>Cod.Recep</td>
	<td><a href="JavaScript:Proceso('O','C');">Canje</a></td>
	<td align="center">S.A</td>
	<td align="center">Est</td>
	<td align="center">Retalla</td>
	<td align="center">Est</td>
	<td align="center">Paralela</td>
	<td align="center">Est</td>
    <td align="center">Hum</td>
	</tr>
	<?php
	if($Buscar=='S')
	{
		echo "<input type='hidden' name='CheckCod'>";
		$Consulta ="select t1.canjeable,t3.recepcion,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.abreviatura as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto,";
		$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.nombre_subclase as nom_recepcion,t1.certificado,t1.estado_lote, t1.certificado_enm ";
		$Consulta.="from age_web.lotes t1 left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
		$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='3104' and t1.cod_recepcion=t8.nombre_subclase ";
		switch($TipoBusqueda)
		{
			case "BL"://POR LOTE
				$Consulta.= "where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
				break;
			case "BM"://POR MES
				if ($CmbAno<2006)
				{
					$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
					$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
				}
				else
				{
					$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
					$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
				}
				$Consulta.= "where t1.lote between '".$LoteIni."' and '".$LoteFin."'";
				break;
		}	
		if ($CmbSubProducto!="S")
			$Consulta.=" and t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
		if ($CmbProveedor!="S")
			$Consulta.=" and t1.rut_proveedor='".$CmbProveedor."' ";
		if ($TxtNomProveedor!="")
			$Consulta.=" and t4.nombre_prv like '%".$TxtNomProveedor."%' ";
		if($Opt=='C')
			if($BuscarCanje=='')
				$Consulta.=" and t1.estado_lote='4' ";
			else
				if($BuscarCanje=='S')
					$Consulta.=" and t1.estado_lote='4' and t1.canjeable='S' ";	
				else
					$Consulta.=" and t1.estado_lote ='4' and t1.canjeable='N' ";	
		else
			if($BuscarCanje=='')
				$Consulta.=" and t1.estado_lote not in ('4','6') ";	
			else
				if($BuscarCanje=='S')
					$Consulta.=" and t1.estado_lote not in ('4','6') and t1.canjeable='S' ";	
				else
					$Consulta.=" and t1.estado_lote not in ('4','6') and t1.canjeable='N' ";	
		$Consulta.= " and t3.mostrar_age='S' and t1.estado_lote not in ('2','3')";			
		switch ($Orden)
		{
			case "L"://LOTE
				$Consulta.= " order by t1.lote ";
				break;
			case "S"://SUBPRODUCTO
				$Consulta.= " order by nom_subproducto, t1.lote ";
				break;
			case "P"://PROVEEDOR
				$Consulta.= " order by nom_prv, t1.lote ";
				break;
			case "C"://POR CANJE
				$Consulta.= " order by t1.canjeable, nom_subproducto, nom_prv, t1.lote ";
				break;
			default://POR LOTE
				$Consulta.= " order by t1.lote ";
				break;
		}	
			
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		while($Fila = mysqli_fetch_array($Resp))
		{
			$DatosLote= array();
			$ArrLeyes=array();
			$DatosLote["lote"]=$Fila["lote"];
			LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","",$link);
			echo "<tr>";
			echo "<td><input type='checkbox' name='CheckCod' value='".$Fila["lote"]."'></td>";
			$TxtLote=$Fila["lote"];
			//SOLICITUD DEL LOTE
			$Consulta = "select distinct t2.nro_solicitud ,t2.recargo , t2.estado_actual, t3.nombre_subclase";
			$Consulta.= " from age_web.lotes t1 ";
			$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
			$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
			$Consulta.= " where t1.lote = '".$TxtLote."' and t2.estado_actual not in ('7','16')";			
			$Consulta.= " and (t2.recargo='0' or t2.recargo='') ";	
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))
			{
				$SA=$FilaAux["nro_solicitud"];
				$Recargo=$FilaAux["recargo"];
				$EstadoSA=$FilaAux["nombre_subclase"];
				$CodEstadoSA=$FilaAux["estado_actual"];
			}
			else
			{
				$SA="";$Recargo="";$EstadoSA="";$CodEstadoSA="";
			}
			$Consulta="select peso_neto from age_web.detalle_lotes where lote='".$TxtLote."'";
			$RespDet=mysqli_query($link, $Consulta);$LoteConPeso='N';
			if($FilaDet=mysqli_fetch_assoc($RespDet))
				$LoteConPeso='S';
			if($Opt!='C'&&$LoteConPeso=="N")//ELIMINAR LOTES QUE NO TENGAN PESO
				echo "<td><a href=\"JavaScript:DetalleLote('".$TxtLote."')\">".$TxtLote."</a>&nbsp;<input type='button' name='BtnEliminar' value='X' onClick=Proceso('ELI','".$TxtLote."') width='3'></td>";
			else
				echo "<td><a href=\"JavaScript:DetalleLote('".$TxtLote."')\">".$TxtLote."</a></td>";
			echo "<td>".$Fila["nom_subproducto"]."</td>";
			echo "<td>".$Fila["rut_proveedor"]." ".substr($Fila["nom_prv"],0,20)."</td>";
			if($Fila["certificado"]!='')
			{
				echo "<td align='center'><a href=\"JavaScript:DetalleLeyes('".$Fila["lote"]."','".$Fila["estado_lote"]."','CDV','".$Fila["canjeable"]."')\"><img src='../Principal/imagenes/ico_pag2.gif' width='18' height='9' border='0'></a></td>";
			}
			else
			{
				echo "<td align='center'><a href=\"JavaScript:DetalleLeyes('".$Fila["lote"]."','".$Fila["estado_lote"]."','CDV','".$Fila["canjeable"]."')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'></a></td>";
			}
			if($Fila["certificado_enm"]!='')
			{
				echo "<td align='center'><a href=\"JavaScript:DetalleLeyes('".$Fila["lote"]."','".$Fila["estado_lote"]."','ENM','".$Fila["canjeable"]."')\"><img src='../Principal/imagenes/ico_pag2.gif' width='18' height='9' border='0'></a></td>";				
			}	
			else
			{
				echo "<td align='center'><a href=\"JavaScript:DetalleLeyes('".$Fila["lote"]."','".$Fila["estado_lote"]."','ENM','".$Fila["canjeable"]."')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'></a></td>";
			}
			echo "<td align='center'><a href=\"JavaScript:DescargaArchivos('".$Fila["lote"]."')\"><img src='../Principal/imagenes/ico_arriba.gif' border='0'><a></td>";	
			echo "<td>$Fila[nom_recepcion]&nbsp;</td>";
			echo "<td align='center'>".$Fila["canjeable"]."&nbsp;</td>";
			//RETALLA
			$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
			$Consulta.= " from age_web.lotes t1 ";
			$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
			$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
			$Consulta.= " where t1.lote = '".$TxtLote."' ";			
			$Consulta.= " and t2.recargo='R' ";	
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))
			{
				$SA_Retalla=$FilaAux["nro_solicitud"];
				$EstadoRetalla=$FilaAux["nombre_subclase"];
				$CodEstadoRetalla=$FilaAux["estado_actual"];
			}
			else
			{
				$SA_Retalla="";$EstadoRetalla="";$CodEstadoRetalla="";
			}
			//MUESTRA PARALELA
			$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
			$Consulta.= " from age_web.lotes t1 ";
			$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.muestra_paralela=t2.id_muestra  and year(t1.fecha_recepcion)=year(t2.fecha_muestra) ";
			$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
			$Consulta.= " where t1.lote = '".$TxtLote."' ";			
			$Consulta.= " and (t2.recargo='0' or t2.recargo='' or isnull(t2.recargo)) and estado_actual not in ('7','16')";	
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))
			{
				$SA_Paralela=$FilaAux["nro_solicitud"];
				$EstadoParalela=$FilaAux["nombre_subclase"];
				$CodEstadoParalela=$FilaAux["estado_actual"];
			}
			else
			{
				$SA_Paralela="";$EstadoParalela="";$CodEstadoParalela="";
			}
			if 	($SA=="")
				echo "<td>&nbsp;</td>\n";		
			else
			{
				if ($SA!="")
					echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($SA,4)."</a></td>\n";
			}			
			if ($CodEstadoSA!=6 && $EstadoSA!="")
				echo "<td bgcolor='yellow' align='center'><a href=\"JavaScript:DetalleAnalisis('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($EstadoSA,0,3)."&nbsp;</a></td>\n";
			else
			{
				if ($EstadoSA!="")
					echo "<td bgcolor='#FFFFFF' align='center'>".substr($EstadoSA,0,3)."&nbsp;</td>\n";
				else
					echo "<td>&nbsp;</td>\n";
			}
			if 	($SA_Retalla=="")
				echo "<td>&nbsp;</td>\n";		
			else
				echo "<td><a href=\"JavaScript:Historial('".$SA_Retalla."','R')\" class=\"LinksAzul\">".substr($SA_Retalla,4)."</a></td>\n";
			if ($CodEstadoRetalla!=6 && $EstadoRetalla!="")
				echo "<td bgcolor='yellow' align='center'><a href=\"JavaScript:DetalleAnalisis('".$SA_Retalla."','R')\" class=\"LinksAzul\">".substr($EstadoRetalla,0,3)."&nbsp;</a></td>\n";
			else
				if 	($SA_Retalla!="")
					echo "<td bgcolor='#FFFFFF' align='center'>".substr($EstadoRetalla,0,3)."&nbsp;</td>\n";
				else
					echo "<td>&nbsp;</td>\n";		
			if 	($SA_Paralela=="")
				echo "<td>&nbsp;</td>\n";		
			else
				echo "<td><a href=\"JavaScript:Historial('".$SA_Paralela."','0')\" class=\"LinksAzul\">".substr($SA_Paralela,4)."</a></td>\n";
			if ($CodEstadoParalela!=6 && $EstadoParalela!="")
				echo "<td bgcolor='yellow' align='center'><a href=\"JavaScript:DetalleAnalisis('".$SA_Paralela."','0')\" class=\"LinksAzul\">".substr($EstadoParalela,0,3)."&nbsp;</a></td>\n";
			else
				if($SA_Paralela!="")
					echo "<td bgcolor='#FFFFFF' align='center'>".substr($EstadoParalela,0,3)."&nbsp;</td>\n";
				else
					echo "<td>&nbsp;</td>\n";
			//
			
			$Consulta = "select cod_leyes,valor ";
			$Consulta.= " from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and id_muestra = '".$TxtLote."' and recargo > 0 and (cod_leyes='01' and valor IS NULL) and cod_producto= '1' and cod_subproducto not in ('16','17','18','56') ";			
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))
				echo "<td bgcolor='red'>&nbsp;</td>\n";
			else
				echo "<td>&nbsp;</td>\n";		
			echo "</tr>";
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
