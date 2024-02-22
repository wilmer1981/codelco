<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");

	if(isset($_REQUEST["Buscar"])){
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}

	if(isset($_REQUEST["CmbSubProducto"])){
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = "";
	}

	/***************************************************** */
	$DatosLeyes=array();
	$Consulta = "SELECT distinct cod_leyes, LPAD(cod_leyes,4,'0') as orden, abreviatura as ley,cod_unidad ";
	$Consulta.=" from proyecto_modernizacion.leyes ";
	$Consulta.= " where cod_leyes<>''";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		$DatosLeyes[$Fila["cod_leyes"]]=$Fila["ley"];
		//$Datos[$Fila["cod_leyes"]]=$Fila["cod_leyes"];
	}
	
?>
<html>
<head>
<title>Informe Leyes Proveedores</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "C":
			f.action = "rec_con_leyes_proveedores.php?Buscar=S";
			f.submit();
			break;
		case "E":
			f.action = "rec_con_leyes_proveedores.php?Buscar=S";
			f.submit();
			break;
		case "I":
			f.BtnConsultar.style.visibility = "hidden";
			//f.BtnExcel.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnConsultar.style.visibility = "visible";
			//f.BtnExcel.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=24";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<table width="700"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
    <td colspan="2"><strong>CONSULTA LEYES PROVEEDORES </strong></td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF">SubProducto:</td>
    <td width="401">
<span class="ColorTabla02">
	<!--
<SELECT name="CmbSubProducto" style="width:250" <?php echo $HabilitarCmb;?>>-->
<SELECT name="CmbSubProducto" style="width:250">
  <option value="S" SELECTed class="NoSelec">TODOS</option>
  <?php
				$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod, ";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.=" FROM sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.=" WHERE t1.cod_grupo='1' order by nom_subprod";
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
</span><!--<input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
      <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false">-->
	  </td>
  </tr>
  <tr align="center">
    <td height="30" colspan="2">
	<input name="BtnConsultar" type="button" value="Consultar" style="width:70px " onClick="Proceso('C')">
	<!--<input name="BtnExcel" type="button" value="Excel" style="width:70px " onClick="Proceso('E')">-->
	<input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td></tr>
</table><br>
<table width="700" border="1" align="center" cellpadding="2" cellspacing="0" >
  <tr class="ColorTabla02">
    <td width="100" align="center">RUT</td>
	<td width="330" align="center">PROVEEDOR</td>
    <td width="170" align="center">SUBPRODUCTO</td>
    <td width="40" align="center">LEYES</td>
    <td width="40" align="center">IMPUREZAS</td>
  </tr>
<?php
if($Buscar=='S')
{
	$CodProd=explode('~',$CmbSubProducto);
	$Consulta="SELECT t1.cod_subproducto,t2.abreviatura as nom_prod,t3.nombre_prv,t1.rut_proveedor,t1.leyes,t1.impurezas from age_web.relaciones t1 left join proyecto_modernizacion.subproducto t2 on ";
	$Consulta.="t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto inner join sipa_web.proveedores t3 on ";
	$Consulta.="t1.rut_proveedor=t3.rut_prv ";
	if($CmbSubProducto!='S')
		$Consulta.="where t1.cod_producto='1' and t1.cod_subproducto='".$CodProd[1]."' ";
	$Consulta.=" and t1.leyes <>'' group by t1.rut_proveedor,t1.cod_producto,t1.cod_subproducto order by T3.nombre_prv ";
	//echo $Consulta;
	$RespProv=mysqli_query($link, $Consulta);
	while($FilaProv=mysqli_fetch_array($RespProv))
	{
		echo "<tr align='left'>";
		echo "<td align='left'>".str_pad($FilaProv["rut_proveedor"],10,'0',STR_PAD_LEFT)."</td>";
		echo "<td>".$FilaProv["nombre_prv"]."</td>";
		echo "<td align='left'>".$FilaProv["nom_prod"]."</td>";
		$Leyes=explode('~',$FilaProv["leyes"]);
		$StrLeyes='';
		foreach($Leyes as  $c =>$v)
		{
			$StrLeyes=$StrLeyes.$DatosLeyes[$v].",";
		}
		$StrLeyes=substr($StrLeyes,0,strlen($StrLeyes)-1);
		$Impurezas=explode('~',$FilaProv["impurezas"]);
		$StrImp='';
		foreach($Impurezas as $c => $v)
		{
			//$StrImp=$StrImp.$DatosLeyes[$v].",";
			if(isset($DatosLeyes[$v])){
				$DatLey=$DatosLeyes[$v];
			}else{
				$DatLey="";
			}
			$StrImp=$StrImp.$DatLey.",";
		}
		$StrImp=substr($StrImp,0,strlen($StrImp)-1);
		echo "<td align='left'>".$StrLeyes."</td>";
		echo "<td align='left'>".$StrImp."</td>";
		echo "</tr>";
	}
}
?>
</table>
</form>
</body>
</html>