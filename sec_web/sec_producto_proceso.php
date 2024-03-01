<?php 	
	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 1;
	include("../principal/conectar_sec_web.php");

	$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "OTROS PESAJES", 19=> "RESTOS ANODOS", 17=> "ANODOS");

	/*echo $Pro."<br>";*/
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$cmbproducto  = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"-1";
	$cmbsubproducto  = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"-1";
	$TxtNombreGDE  = isset($_REQUEST["TxtNombreGDE"])?$_REQUEST["TxtNombreGDE"]:"";
	$TxtCodSAP  = isset($_REQUEST["TxtCodSAP"])?$_REQUEST["TxtCodSAP"]:"";
	$TxtUnidadSAP  = isset($_REQUEST["TxtUnidadSAP"])?$_REQUEST["TxtUnidadSAP"]:"";

	switch($Proceso)
	{
		case "N":
			break;
		case "M": 
			$Cod_Producto = $Valores;
			$Matriz=explode("-",$Valores);
			$cmbproducto=$Matriz[0];
			$cmbsubproducto=$Matriz[1];
			$Consulta="select * from sec_web.homologacion_producto_sap where cod_producto_sec='".$Matriz[0]."' and cod_subproducto_sec='".$Matriz[1]."'"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodSAP=$Fila["codigo_material"];
			$TxtNombre=$Fila["denominacion_sap"];
			$TxtNombreGDE=$Fila["denominacion_sap"];
			$TxtUnidadSAP=$Fila["cod_unidad_sap"];
		break;	
	}

?>
<html>
<head>
<script language="JavaScript">
/*document.onkeydown = TeclaPulsada; 

function TeclaPulsada (tecla) 
{ 
var teclaCodigo = event.keyCode; 
var teclaReal = String.fromCharCode(teclaCodigo); 
alert("C�digo de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 


function Grabar(Proceso)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtCodSAP.value == "")
	{
		alert("Debe Ingresar el c�digo producto de SAP")
		Frm.TxtCodSAP.focus();
		return;
	}	
	
	if (Frm.TxtNombreGDE.value == "")
	{
		alert("Debe Ingresar Denominaci�n SAP")
		Frm.TxtNombreGDE.focus();
		return;3
	}
	if (Frm.TxtUnidadSAP.value == "")
	{
		alert("Debe Ingresar Unidad")
		Frm.TxtUnidadSAP.focus();
		return;
	}
	Frm.action="sec_producto_proceso01.php?Proceso="+Proceso;
	Frm.submit();
	
}

function Recargar2()
{
	var f = document.FrmProceso;
	
		f.action = "sec_producto_proceso.php?cmbproducto="+f.cmbproducto.value+"&cmbsubproducto="+f.cmbsubproducto.value;
		
	f.submit();
}

function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">

<form name="FrmProceso" method="post" action="">
  <table width="100%" height="200" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="100%" border="0" cellpadding="5" class="TablaInterior">
    	<tr>
    		<td>C&oacuted.Producto</td>
    		<td>
    			<select name="cmbproducto" onChange="Recargar2()" style="width: 150">
    				<option value="-1">Seleccione</option>
					<?php
					
						foreach($productos as $clave => $valor)
						{
							if ($clave == $cmbproducto)
								echo '<option value="'.$clave.'" selected>'.$valor.'</option>';
							else 
								echo '<option value="'.$clave.'">'.$valor.'</option>';
						}	
					
					?>			
		        </select><span class=" InputRojo">(*)</span>
		    </td>
		    		<td>C&oacuted.SubProducto</td>
		    		<td>
		    			<select name="cmbsubproducto" onChange="Recargar2()" style="width: 150">
		    				<option value="-1">Seleccione</option>
		                <?php	
							$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = ".$cmbproducto;
							//echo '<option value="-1">'.$consulta.'</option>';
							$var1 = $consulta;
							$rs = mysqli_query($link, $consulta);
							while ($row = mysqli_fetch_array($rs))
							{
								$codigo = $row["cod_subproducto"];
								$descripcion = $row["descripcion"];
							//	if (($cmbmovimiento == 3) and ($cmbproducto == 48) and ($codigo == 1))	
							//		$descripcion = "LAMINAS";
							
								if ($codigo == $cmbsubproducto)
									echo '<option value="'.$codigo.'" selected>'.$descripcion.'</option>';
								else
									echo '<option value="'.$codigo.'">'.$descripcion.'</option>';
							}						
						?>
		          		</select><span class=" InputRojo">(*)</span>
    				</td>
    	</tr>

          <tr> 
          	
            <td>Denominaci&oacute;n&nbsp;SAP</td>
            <td colspan="3"> 
            	<input type='text' name='TxtNombreGDE' id="TxtNombreGDE"  maxlength="40" style="width:305" value="<?php echo $TxtNombreGDE;?>"><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            
            <td>C&oacuted.Producto SAP</td>
            <td>
            	<input type="text" name="TxtCodSAP" id="TxtCodSAP" maxlength="10" style="width:80" value="<?php echo $TxtCodSAP;?>"><span class=" InputRojo">(*)</span>
            </td>
               <td>C&oacuted.Unidad SAP</td>
            <td>
            	<input type="text" name="TxtUnidadSAP" maxlength="2" id="TxtUnidadSAP" style="width:50" value="<?php echo $TxtUnidadSAP;?>"><span class=" InputRojo">(*)</span>
            </td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="407">
            	<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
