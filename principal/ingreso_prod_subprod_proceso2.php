<?php 	
	//include("../principal/conectar_comet_web.php");
	include("conectar_principal.php");

	$Proceso         = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
    $Valores         = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$cod_subproducto = isset($_REQUEST["cod_subproducto"])?$_REQUEST["cod_subproducto"]:"";

	$EncontroCoincidencia = isset($_REQUEST["EncontroCoincidencia"])?$_REQUEST["EncontroCoincidencia"]:"";

	$Datos=explode('//',$Valores);
	$TxtCodigo=$Datos[0];
	//echo "Aqui".$Valores;
	switch($Proceso)
	{
		case "NS":
			$Consulta = "select ifnull(max(ceiling(cod_subproducto))+1,1) as mayor from proyecto_modernizacion.subproducto where cod_producto='$TxtCodigo'";
			//echo "CCC".$Consulta;
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodSubProdu=$Fila["mayor"];
			$TxtDescripcion='';$Txtmostrar='';$TxtAbrevia='';$TxtLotes='';$TxtFlujos='';$TxtAnodo='';$TxtMostrarSea='';$TxtAplicacion='';$TxtRutProv='';
			$TxtProdRam='';$TxtMostrarPmn='';$TxtTipMov='';$TxtStockSec='';$TxtOrdenStockSec='';$TxtMostrar2='';$TxtTipoMovPmn='';$TxtProductoSipa='';
			$TxtRecepcion='';$TxtMostrarAge='';$TxtClaseProducto='';$TxtHumedad='';$TxtBalanceSec='';$TxtEtiqueta='';
			break;
		case "MS":
			$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='$TxtCodigo' and cod_subproducto='$cod_subproducto'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodSubProdu=$cod_subproducto;
			$TxtDescripcion=$Fila["descripcion"];$Txtmostrar=$Fila["mostrar"];
			$TxtAbrevia=$Fila["abreviatura"];$TxtLotes=$Fila["lotes"];
			$TxtFlujos=$Fila["flujos"];$TxtAnodo=$Fila["mostrar_anodos"];
			$TxtMostrarSea=$Fila["mostrar_sea"];$TxtAplicacion=$Fila["ap_subproducto"];
			$TxtRutProv=$Fila["rut_prov"];$TxtProdRam=$Fila["prod_ram"];
			$TxtMostrarPmn=$Fila["mostrar_pmn"];$TxtTipMov=$Fila["tipo_mov"];
			$TxtStockSec=$Fila["stock_sec"];$TxtOrdenStockSec=$Fila["orden_stock_sec"];
			$TxtMostrar2=$Fila["mostrar2"];$TxtTipoMovPmn=$Fila["tipo_mov_pmn"];
			$TxtProductoSipa=$Fila["producto_sipa"];$TxtRecepcion=$Fila["recepcion"];
			$TxtMostrarAge=$Fila["mostrar_age"];$TxtClaseProducto=$Fila["clase_producto"];
			$TxtHumedad=$Fila["humedad"];$TxtBalanceSec=$Fila["balance_sec"];$TxtEtiqueta=$Fila["abreviatura_etiqueta_sec"];
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{

	var Frm=document.FrmProceso;
	
	if (Frm.TxtCodSubProdu.value=='0'||Frm.TxtCodSubProdu.value=='')
	{
		alert("Debe Ingresar Codigo Subproducto")
		Frm.TxtCodSubProdu.focus();
		return;
	}
	if (Frm.TxtProdRam.value=='')
	{
		alert("Debe Ingresar Codigo Numerico Para Prod. ram")
		Frm.TxtProdRam.focus();
		return;
	}
	if (Frm.TxtOrdenStockSec.value=='')
	{
		alert("Debe Ingresar Codigo Numerico Para Orden Stock Sec")
		Frm.TxtOrdenStockSec.focus();
		return;
	}
	if (Frm.TxtMostrar2.value=='')
	{
		alert("Debe Ingresar Codigo Numerico Para Mostrar2")
		Frm.TxtMostrar2.focus();
		return;
	}
	if (Frm.TxtDescripcion.value == "")
	{
		alert("Debe Ingresar Nombre Subproducto")
		Frm.TxtNombre.focus();
		return;
	}

	Frm.action="ingreso_prod_subprod_proceso01.php?&Proceso="+Proceso+"&Valores="+Valores;
	Frm.submit();
}
function Eliminar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (confirm("Esta seguro de Eliminar el Subproducto"))
	{
		Frm.action="ingreso_prod_subprod_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
		Frm.submit();
	}
}

function Recarga(Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_clase_subclase_proceso2.php?Recarga=S&Proceso="+Proceso;
	Frm.submit();
	
}
function Cancelar(Valores,Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_prod_subprod_proceso2.php?Proceso="+Proceso+"&Valores="+Valores;
	Frm.submit();
	
}

function Consultar(Valores)
{
	window.open("ingreso_prod_subprod_popup.php?Valores="+Valores,"","top=120,left=120,width=550,height=350,scrollbars=yes,resizable = no");		
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.TxtDescripcion.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<form name="FrmProceso" method="post" action="">
  <table width="565" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="617"><table width="550" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="93">Cod_Producto</td>
            <td width="428"> 
              <?php
				echo "<input type='text' name='TxtCodigo' size='10' maxlength='9' value='$TxtCodigo' readonly>";
				
  			  ?>
</td>
          </tr>
          <tr> 
            <td>Cod_SubProducto </td>
            <td><input name="TxtCodSubProdu" type="text" value='<?php echo $TxtCodSubProdu;?>' size="10" maxlength="5"> </td>
          </tr>
          <tr> 
            <td>Descripcion</td>
            <td><input name="TxtDescripcion" type="text" value='<?php echo $TxtDescripcion;?>' size="80" maxlength="80"> </td>
          </tr>
		  <tr> 
            <td>Mostrar</td>
            <td><input name="Txtmostrar" type="text" value='<?php echo $Txtmostrar;?>' size="2" maxlength="1"> </td>
          </tr>
          <tr> 
            <td>Abreviatura</td>
            <td><input name="TxtAbrevia" type="text" value='<?php echo $TxtAbrevia;?>' size="40" maxlength="20"> 
            </td>
          </tr>
		  </table><br>
		  <table width="550" border="1" cellpadding="1" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="105">Lotes</td>
            <td width="174"><input type="text" name="TxtLotes" size="2" maxlength="1" value="<?php echo $TxtLotes;?>">            
            <td width="92" >Flujos</td>
			<td width="160"><input type="text" name="TxtFlujos" size="20" maxlength="10" value="<?php echo $TxtFlujos;?>"> 
            </td>
          </tr>
          <tr> 
            <td >Mostrar Anodos</td>
            <td><input type="text" name="TxtAnodos" size="2" maxlength="1" value="<?php echo $TxtAnodo;?>"> 
			<td>Mostrar Sea </td>
            <td><input type="text" name="TxtMostrarSea" size="2" maxlength="1" value="<?php echo $TxtMostrarSea;?>"> 
            </td>
          </tr>
          <tr> 
            <td>Aplicacion S.P.</td>
            <td><input type="text" name="TxtAplicacion" size="20" maxlength="10" value="<?php echo $TxtAplicacion;?>"> 
			<td>Rut Proveedor </td>
            <td><input type="text" name="TxtRutProv" size="20" maxlength="10" value="<?php echo $TxtRutProv;?>"> 
            </td>
          </tr>
		  <tr> 
            <td>Prod. Ram</td>
            <td><input type="text" name="TxtProdRam" size="20" maxlength="10" value="<?php echo $TxtProdRam;?>"> 
			<td>Mostrar Pmn</td>
            <td><input type="text" name="TxtMostrarPmn" size="20" maxlength="10" value="<?php echo $TxtMostrarPmn;?>"> 
            </td>
          </tr>
		  <tr> 
            <td>Tipo Movimiento</td>
            <td><input type="text" name="TxtTipMov" size="20" maxlength="5" value="<?php echo $TxtTipMov;?>"> 
			<td>Stock Sec </td>
            <td><input type="text" name="TxtStockSec" size="2" maxlength="1" value="<?php echo $TxtStockSec;?>"> 
            </td>
          </tr>
		   <tr> 
            <td>Orden Stock Sec </td>
            <td><input type="text" name="TxtOrdenStockSec" size="4" maxlength="2" value="<?php echo $TxtOrdenStockSec;?>"> 
			<td>Mostrar 2 </td>
            <td><input type="text" name="TxtMostrar2" size="2" maxlength="1" value="<?php echo $TxtMostrar2;?>"> 
            </td>
          </tr>
		     <tr> 
            <td>Tipo Mov. pmn </td>
            <td><input type="text" name="TxtTipoMovPmn" size="20" maxlength="20" value="<?php echo $TxtTipoMovPmn;?>">			
              <td>Producto Sipa </td>
              <td><input type="text" name="TxtProductoSipa" size="20" maxlength="20" value="<?php echo $TxtProductoSipa;?>"> 
            </td>
          </tr>
		   <tr> 
            <td>Recepcion</td>
            <td><input type="text" name="TxtRecepcion" size="20" maxlength="10" value="<?php echo $TxtRecepcion;?>"> 
			<td>Mostrar Age </td>
            <td><input type="text" name="TxtMostrarAge" size="2" maxlength="1" value="<?php echo $TxtMostrarAge;?>"> 
            </td>
          </tr>
		   <tr> 
            <td>Clase Producto </td>
            <td><input type="text" name="TxtClaseProducto" size="2" maxlength="1" value="<?php echo $TxtClaseProducto;?>"> 
			<td>Humedad</td>
            <td><input type="text" name="TxtHumedad" size="2" maxlength="1" value="<?php echo $TxtHumedad;?>"> 
            </td>
          </tr>
		   <tr> 
            <td>Balance Sec </td>
            <td colspan="3"><input type="text" name="TxtBalanceSec" size="50" maxlength="50" value="<?php echo $TxtBalanceSec;?>">
			</tr>
			
			<tr> 
            <td>Descripci&oacute;n Etiqueta </td>
            <td colspan="3"><input type="text" name="TxtEtiqueta" size="50" maxlength="50" value="<?php echo $TxtEtiqueta;?>">
			</tr>

			
			
        </table>
        <br>
        <table width="551" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="534">
			  <?php 
			  if ($Proceso=='MS')
			  {
			  ?>	
			  <input type="button" name="BtnGrabar" value="Modificar" style="width:70" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
			  <?php 
			  }
			  else
			  {
			  $Proceso=='NS';
			  ?>
			  <input type="button" name="BtnGrabar" value="Grabar" style="width:70" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
			  <?php
			  }
			  ?>
              <input type="button" name="BtnConsultar" value="Consultar" style="width:70" onClick="Consultar('<?php echo $Valores;?>')">
			  <input type="button" name="BtnEliminar" value="Eliminar" style="width:70" onClick="Eliminar('ES','<?php echo $Valores;?>')">
			  <input type="button" name="BtnCancelar" value="Cancelar" style="width:70" onClick="Cancelar('<?php echo $Valores;?>','NS')">
			  <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
            </td>
          </tr>
        </table> </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
	if ($EncontroCoincidencia!="")
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
