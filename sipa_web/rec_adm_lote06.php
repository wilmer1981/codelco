<?php
	//echo "TIPO PROCESO:".$TipoProceso."<BR>";
	//echo "PROCESO:".$Proceso;
	$CodigoDeSistema=24;
	$CodigoDePantalla=16;
	include("../principal/conectar_principal.php");
	include("funciones.php");



	$EstadoInput='';
	if(isset($_REQUEST["TipoConsulta"])){
		$TipoConsulta = $_REQUEST["TipoConsulta"];
	}else{
		$TipoConsulta = '';
	}
	if(isset($_REQUEST["Proc"])){
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = '';
	}

	if(isset($_REQUEST["TxtCorr"])){
		$TxtCorr = $_REQUEST["TxtCorr"];
	}else{
		$TxtCorr = '';
	}
	if(isset($_REQUEST["CmbRecarga"])){
		$CmbRecarga = $_REQUEST["CmbRecarga"];
	}else{
		$CmbRecarga = '';
	}
	if(isset($_REQUEST["TipoProceso"])){
		$TipoProceso = $_REQUEST["TipoProceso"];
	}else{
		$TipoProceso = '';
	}
	

	$Consulta="SELECT * from sipa_web.otros_pesaje where correlativo='".$TxtCorr."'";
	$Rs = mysqli_query($link, $Consulta);
	//echo $consulta."<br>";
	if($Row = mysqli_fetch_array($Rs))
	{
		$TxtPatente=$Row["patente"];
		$TxtFecha=$Row["fecha"];
		$TxtPesoBruto=$Row["peso_bruto"];
		$TxtCorrelativo=$Row["correlativo"];
		$TxtHoraE=$Row["hora_entrada"];
		$TxtPesoTara=$Row["peso_tara"];
		$TxtHoraS=$Row["hora_salida"];
		$TxtPesoNeto=$Row["peso_neto"];
		$Productos=$Row["nombre"];
		$SubProductos=$Row["descripcion"];
		$Conjunto=$Row["conjunto"];
		$TxtObs=$Row["observacion"];
	}
?>	
<html><head>
<title>Modificar Circulantes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.FrmOtrosPesajes;
	var Valores='';
	//alert(f.TipoProceso.value);
	switch (opt)
	{
		case "S"://SALIR
			   window.opener.document.frmPrincipal.action='rec_adm_lote.php?TipoCon=CF';
			   window.opener.document.frmPrincipal.submit();
			   window.close();
   			break;
		case "M"://MODIFICAR
			f.TipoProceso.value="S";
			if(f.Productos.value=='S')
			{
				alert('No ha Seleccionado Producto');
				f.Productos.focus();
				return;
			}
			if(f.SubProductos.value=='S')
			{
				alert('No ha Seleccionado Sub-Producto');
				f.SubProductos.focus();
				return;
			}
			if(f.Conjunto.value=='S')
			{
				alert('No ha Seleccionado Conjunto');
				f.Conjunto.focus();
				return;
			}
			if(f.TxtObs.value=='S')
			{
				alert('No ha Ingresado Observaci�n');
				f.TxtObs.focus();
				return;
			}
			f.action = "rec_circulantes01.php?Proceso=MC";//MODIFICA CIRCULANTE
			f.submit();	
			break;
	}
}
function Recarga(ObjFoco,Tipo,CmbRecarga)
{
	var f = document.FrmOtrosPesajes;
	
	if(f.TxtPatente.value==''&&Tipo=='S')
		return;
	f.action = "rec_adm_lote06.php?CmbRecarga="+CmbRecarga+"&TxtCorr="+f.TxtCorr.value;
	f.submit();		
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
.Estilo2 {color: #FF0000}
</style></head>
<body>
<form action="" method="post" name="FrmOtrosPesajes" >
<input type="hidden" name="SoloTara" value="">
<input type="hidden" name="TxtCorr" value="<?php echo $TxtCorr?>">
<?php
	if(!isset($TipoProceso))
		echo "<input type='hidden' name='TipoProceso' value=''>";
	else
		echo "<input type='hidden' name='TipoProceso' value='$TipoProceso'>";
?>

<table width="700"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="6"><strong>Modifica datos Circulantes </strong></td>
  </tr>
  <tr>
    <td width="91" align="right" class="ColorTabla02">Patente:</td>
    <td width="156" class="ColorTabla02" ><input name="TxtPatente" type="text" class="InputCen" id="TxtPatente2" value="<?php echo strtoupper($TxtPatente); ?>" size="10" maxlength="10" readonly="true">    
      <td width="91" align="right" class="ColorTabla02">Fecha:</td>
    <td width="106" class="ColorTabla02" ><input name="TxtFecha" type="text" class="InputCen" value="<?php echo $TxtFecha; ?>" size="12" maxlength="10" readonly="true" ></td>
    <td width="111" align="right" class="ColorTabla02">Peso Bruto :	</td>	
    <td width="111" class="ColorTabla02">
	<input name="TxtPesoBruto" type="text" class="InputCen" value="<?php echo $TxtPesoBruto; ?>" size="10" maxlength="10" readonly="true"></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Correlativo:</td>
	<td class="ColorTabla02">
    <input <?php echo $EstadoInput; ?> name="TxtCorrelativo" type="text" class="InputCen" id="TxtCorrelativo" value="<?php echo $TxtCorrelativo; ?>" size="10" maxlength="10"  readonly="true">	</td>
	<td align="right" class="ColorTabla02">Hora Entrada:</td>
    <td class="ColorTabla02"><input name="TxtHoraE" type="text" class="InputCen" value="<?php echo $TxtHoraE; ?>" size="10" maxlength="10" readonly="true" ></td>
    <td align="right" class="ColorTabla02">Peso Tara :</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoTara" type="text" class="InputCen" id="TxtPesoTara" value="<?php echo $TxtPesoTara; ?>" size="10" maxlength="10"  readonly="true"></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Producto:</td>
    <td class="ColorTabla02"><SELECT name="Productos" style="width:200" onChange="Recarga(SubProductos,'S','S')">
      <option SELECTed value="S">Seleccionar</option>
      <?php
	$Consulta = "SELECT * from proyecto_modernizacion.productos where cod_producto ='42' order by descripcion";
	$result = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($result))
	{
		if ($Productos == $Row["cod_producto"])
		{
			echo "<option SELECTed value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
	}
?>
    </SELECT>
    <td align="right" class="ColorTabla02">Hora Salida:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtHoraS" type="text" class="InputCen" id="TxtHoraS2" value="<?php echo $TxtHoraS; ?>" size="10" maxlength="10" readonly="true"></td>
    <td align="right" class="ColorTabla02">Peso Neto:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoNeto" type="text" class="InputCen" id="TxtNeto" value="<?php echo $TxtPesoNeto; ?>" size="10" maxlength="10" readonly="true"></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">SubProducto:</td>
    <td class="ColorTabla02"><SELECT name="SubProductos" style="width:200" onChange="Recarga(Conjunto,'S','S');">
      <option SELECTed value="S">Seleccionar</option>
      <?php
	$Consulta = "SELECT distinct t1.cod_subproducto,t1.cod_subproducto,t1.descripcion from proyecto_modernizacion.subproducto t1 inner join ram_web.conjunto_ram t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.= "where t1.cod_producto = '".$Productos."' and t2.estado='a' order by t1.descripcion";
	$result = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($result))
	{
		if ($SubProductos == $Row["cod_subproducto"])
		{
			echo "<option SELECTed value='".$Row["cod_subproducto"]."'>".str_pad($Row["cod_subproducto"],3,'0',STR_PAD_LEFT)."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["cod_subproducto"]."'>".str_pad($Row["cod_subproducto"],3,'0',STR_PAD_LEFT)."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
	}
?>
    </SELECT></td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td colspan="3" align="left" class="ColorTabla02">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Conjunto:</td>
    <td colspan="5" class="ColorTabla02"><SELECT name="Conjunto" style="width:250">
      <option SELECTed value="S">Seleccionar</option>
      <?php
	$VarFecha=explode('-',date('Y-m-d'));
	$FechaDesde=date('Y-m-d',mktime(0,0,0,$VarFecha[1]-12,$VarFecha[2],$VarFecha[0]));
	$FechaHasta=date('Y-m-d');
	$Consulta = "SELECT distinct num_conjunto ";
	$Consulta.= " from ram_web.conjunto_ram ";
	$Consulta.= " where cod_producto = '".$Productos."' ";
	$Consulta.= " and cod_subproducto = '".$SubProductos."' and estado='a' and fecha_creacion between '".$FechaDesde."' and '".$FechaHasta."'";
	$Consulta.= " order by num_conjunto";
	$result = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($result))
	{
		$Consulta = "SELECT descripcion ";
		$Consulta.= " from ram_web.conjunto_ram ";
		$Consulta.= " where cod_producto = '".$Productos."' ";
		$Consulta.= " and cod_subproducto = '".$SubdProductos."' ";
		$Consulta.= " and num_conjunto = '".$Row["num_conjunto"]."' and estado='a'";
		$Consulta.= " order by num_conjunto";
		$Resultado = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resultado))
		{
			$Descripcion = $Row2["descripcion"];
		}
		if ($Conjunto == $Row["num_conjunto"])
		{
			echo "<option SELECTed value='".$Row["num_conjunto"]."'>".$Row["num_conjunto"]."&nbsp;-&nbsp;".ucwords(strtolower($Descripcion))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["num_conjunto"]."'>".$Row["num_conjunto"]."&nbsp;-&nbsp;".ucwords(strtolower($Descripcion))."</option>\n";
		}
	}
?>
    </SELECT><?php //echo $Consulta;?></td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Observacion:</td>
    <td colspan="5" class="ColorTabla02"><input name="TxtObs" type="text" class="InputIzq" id="TxtObs2" value="<?php echo $TxtObs; ?>" size="100" <?php echo $EstadoInput; ?>>	</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td colspan="2" align="left" class="ColorTabla02">&nbsp;</td>
  </tr>
	</table>
	<br>
	<table width="700" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
	  <tr bgcolor="#FFFFFF">
	  <td align="center" class="ColorTabla02"><input name="BtnModificar" type="button" id="BtnModificar" style="width:70px " onClick="Proceso('M')" value="Modificar">
	    <input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
	</table>  
</td>

</form>
</body>
</html>
<?php
echo "<script lenguaje='javascript'>;";
	if($Msj=='S')
		echo "alert('Registro Modificado')";
echo "</script>;";
/*	function resta_fechas($fecha1,$fecha2)
	{
		 // echo "f_1".$fecha1."<br>"; 
		  //echo "f_2".$fecha2."<br>"; 
		  if($fecha1 != '0000-00-00' && $fecha2 != '0000-00-00')
		  {
			  $fecha1=substr($fecha1,8,2)."-".substr($fecha1,5,2)."-".substr($fecha1,0,4);
			  $fecha2=substr($fecha2,8,2)."-".substr($fecha2,5,2)."-".substr($fecha2,0,4);
			  //echo "f1".$fecha1."<br>";
			  //echo "f2".$fecha2."<br>";
			  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
					  list($dia1,$mes1,$año1)=split("-",$fecha1);
			  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
					  list($dia1,$mes1,$año1)=split("-",$fecha1);
			  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
					  list($dia2,$mes2,$año2)=split("-",$fecha2);
			  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
					  list($dia2,$mes2,$año2)=split("-",$fecha2);
			  $dif = mktime(0,0,0,$mes1,$dia1,$año1,1) - mktime(0,0,0,$mes2,$dia2,$año2,1);
			  //echo "dif".$dif."<br>";
			  $ndias=floor($dif/(24*60*60));
			 //echo "DIAS:".$ndias."<br><br>";
		 }
		 else 
			 $ndias=0;
		  return($ndias);
	}
//echo "AAAAAA".$Mensaje;
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje');";
	echo "var f = document.FrmOtrosPesajes;";
	echo "IngresaTara();";
	//echo "f.TxtPatente.focus();";
	echo "</script>";
}
echo "<script language='JavaScript'>";
echo "var f = document.FrmOtrosPesajes;";
echo "f.TxtNumRomana.value = LeerRomana(f.TxtNumRomana.value);";
//echo "alert(f.TxtNumRomana.value);";
echo "</script>";*/

/*function PesoHistorico($Patente,$TxtPesoHistorico,$Proc)
{

}*/
?>