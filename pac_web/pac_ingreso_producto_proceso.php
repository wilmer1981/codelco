<?php 	
	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");

	/*echo $Pro."<br>";*/
	switch($Proceso)
	{
		case "N":
			break;
		case "M": 
			$Cod_Producto=$Valores;
			for ($i=0;$i<=strlen($Cod_Producto);$i++)

			$Consulta="select * from pac_web.pac_productos where cod_producto='".$Cod_Producto."'"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Cod_sap=$Fila["cod_sap"];
			$Nombre=$Fila["nombre"];
			$Concentracion=$Fila["concentracion"];
			$NU=$Fila["NU"];
			$Estado="";
			$CmbSubProducto=$Fila["cod_sipa"];
			if($Fila["activo"]==1)
				$Estado="checked";

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

function testfunc() {
  var testnr = document.getElementById("TxtConcentracion").value;
  document.getElementById("TxtConcentracion").value = testnr.replace(/,/g, '.');
}

function Grabar(Proceso)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtCodSap.value == "")
	{
		alert("Debe Ingresar el codigo SAP")
		Frm.TxtCodSap.focus();
		return;
	}	
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre")
		Frm.TxtNombre.focus();
		return;
	}
	if (Frm.TxtConcentracion.value == "")
	{
		alert("Debe Ingresar Concentracion en decimales( , )")
		Frm.TxtConcentracion.focus();
		return;
	}
		if (Frm.TxtNU.value == "")
	{
		alert("Debe Ingresar Nombre")
		Frm.TxtNU.focus();
		return;
	}
	
	if (Frm.CheckEst.checked == true)
	{
		Frm.CheckEst.value=1;
	}
	else
	{
		Frm.CheckEst.value=0;
	}
	if (Frm.CmbProductoSipa.value == "S")
	{
		alert("Debe seleccionar homologaci�n SIPA")
		Frm.CmbProductoSipa.focus();
		return;
	}
	var testnr = document.getElementById("TxtConcentracion").value;  
  	var testnr = testnr.replace(/,/g, '.');
  	var lastDigit = testnr.toString().slice(-1);
  	if (lastDigit == ".") {
  		var testnr = testnr+"0";
  	}
  	/*alert(testnr);*/
  	if (testnr >= 100) {
  		alert("Debe Ingresar un numero menor a 100, es un porcentaje.");
  		Frm.TxtConcentracion.focus();
  		return;
  	}
  	document.getElementById("TxtConcentracion").value = testnr.replace(/,/g, '.');

	Frm.action="pac_ingreso_producto_proceso01.php?Proceso="+Proceso;
	Frm.submit();
	
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.TxtCodSap.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtNombre.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td>
            	<input type="hidden" name="cod_producto" id="cod_producto" value="<?php echo $Cod_Producto; ?>">C&oacute;digo SAP
            </td>
            <td> 
            	<input type='text' name='TxtCodSap'  value='<?php echo $Cod_sap;?>' style='width:80' maxlength='18'><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input type="text" name="TxtNombre" id="TxtNombre" style="width:200" maxlength="40" value="<?php echo $Nombre; ?>"> <span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>Concentraci&oacute;n %</td>
            <td><input type="text" name="TxtConcentracion" id="TxtConcentracion" style="width:80" maxlength="7" max="100" value="<?php echo $Concentracion; ?>"><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>N.U.</td>
            <td><input type="text" name="TxtNU" id="TxtNU" style="width:80" maxlength="8" value="<?php echo $NU; ?>"><span class=" InputRojo">(*)</span> 
            </td>
          </tr>
          <tr>
            <td>Estado</td>
            <td align='left'><input type='checkbox' name='CheckEst' <?php echo $Estado; ?> value="0" ></td>
          </tr>
          <tr>
            <td>Homologaci&oacute;n&nbsp;SIPA</td>
            <td align='left'>
           <select name="CmbProductoSipa" style="width:auto"  >
      <option value="S" selected class="NoSelec">Seleccionar</option>
      <?php
				$Consulta="select  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod, ";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.="where t1.cod_grupo='4' order by nom_subprod";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_producto"]."~".$Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
					else
						echo "<option value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
				}
			  ?>
    </select><span class=" InputRojo">(*)</span> 
            </td>
          </tr>
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
      </table> </td>
  </tr>
</table>
  </form>
  <script type="text/javascript">
  	
  </script>
</body>
</html>
