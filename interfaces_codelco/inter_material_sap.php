<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 11;
	include("../principal/conectar_principal.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Existe  = isset($_REQUEST["Existe"])?$_REQUEST["Existe"]:false;

?>
<html>
<head>
<title>Materiales SAP</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	var Valor="";
	//alert (opt)
	switch (opt)
	{
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=21&Nivel=1&CodPantalla=6";
			f.submit();
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "C"://CONSULTAR
			f.action = "inter_asignaciones.php";
			f.submit();
			break; 
		case "E"://ELIMINAR
			var Valores="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkAsig" && f.elements[i].checked==true)
					Valores = Valores + f.elements[i].value + "~~";
			}
			if (Valores=="")
			{
				alert("Debe Seleccinar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("¿Desea Eliminar este Elemento?"))
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					f.ValoresAux.value=Valores;
					f.action = "inter_ingreso_material01.php?Proceso=E&Valores="+Valores;
					f.submit();
				}
			}
			break; 
		case "R"://RECARGA
			f.action = "inter_material_sap.php";
			f.submit();
			break;
		case "N":
			var URL = "inter_ingreso_material_sap.php?Proceso=N";
			window.open(URL,"","top=120,left=30,width=600,height=300,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			var Valores="";
			var contador="";
		
			for (i=1;i<f.elements.length;i++)  
			{
				if (f.elements[i].name=="ChkAsig" && f.elements[i].checked==true)
				{
					Valores = Valores + f.elements[i].value + "~~";
					contador=contador+1;
				}	
			}
			//alert(Valores);
			if (Valores=="")
			{
				alert("Debe Seleccinar un Elemento para Modificar");
				return;
			}
			else
			{
				if (contador == 1)
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					//alert (Valores);
					f.ValoresAux.value=Valores;
					//alert (Valores);
					var URL = "inter_ingreso_material_sap.php?Proceso=M&Valores="+Valores;
					window.open(URL,"","top=120,left=30,width=600,height=300,menubar=no,resizable=yes,scrollbars=yes");
					//f.action = "inter_orden_produccion_proceso.php?Proceso=M&Valores="+Valores;
					f.submit();
				}
				else
					alert("Debe Seleccionar Solo un Elemento");
			}
		break;
		case "E":
		break;
	}	
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {
	color: #0066CC;
	font-weight: bold;
}

</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="ValoresAux" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="620" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
            <td class="ColorTabla02"><strong>MATERIALES SAP</strong></td>
        </tr>
        <tr align="center">
          <td height="30"> <!--<input name="BtnNuevo" type="button" id="BtnNuevo" style="width:70px;" onClick="Proceso('N')" value="Nuevo">
            <input name="BtnModificar" type="button" id="BtnModificar" style="width:70px;" onClick="Proceso('M')" value="Modificar">            
            <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px;" onClick="Proceso('E')" value="Eliminar"> -->             <!--<input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
            <input name="BtnExcel" type="button" id="BtnExcel2" style="width:70px;" onClick="Proceso('E')" value="Excel">-->
            <input name="BtnNuevo22" type="button" id="BtnNuevo2" style="width:70px;" onClick="Proceso('N')" value="Nuevo">
            <input name="BtnModificar" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('M')" value="Modificar">
            <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px;" onClick="Proceso('E')" value="Eliminar">
            <input name="BtnImprimir" type="button" id="BtnImprimir2" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')">            </td>
          </tr>
      </table>        
        <br>
        <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000">
    <tr class="ColorTabla01">
      <td width="30" align="center">&nbsp;</td>
      <td width="100" align="center">Producto</td>
      <td width="100" align="center">Subproducto</td>
      <td width="120" align="center">Unidad Medida Ven</td>
      <td width="70" align="center">Material SAP</td> 
	  <td width="70" align="center">Pedido</td> 
	  <td width="120" align="center">Unidad Medida SAP</td> 
	  <td width="70" align="center">Centro</td> 
	  <td width="70" align="center">Empaque</td> 
	 
      </tr>
<?php
	$Consulta = "SELECT t1.unidad_medida, t1.cod_producto, t1.cod_subproducto, t2.abreviatura";
 	$Consulta.= " as nom_producto, t3.abreviatura as nom_subproducto, t4.descripcion,";
	$Consulta.= " t1.materiales_sap, t1.pedido, t1.unidad_medida_sap, t1.centro, t1.cod_empaque";
 	$Consulta.= " FROM interfaces_codelco.homologacion t1,";
 	$Consulta.= " proyecto_modernizacion.productos t2,";
	$Consulta.= " proyecto_modernizacion.subproducto t3,";
	$Consulta.= " interfaces_codelco.empaque t4";
	$Consulta.= " WHERE t1.cod_producto = t2.cod_producto";
	$Consulta.= " AND t1.cod_producto   = t3.cod_producto";
	$Consulta.= " AND t1.cod_subproducto=t3.cod_subproducto";
	$Consulta.= " AND t1.cod_empaque    = t4.cod_empaque";
	$Consulta.= " order by t1.cod_producto, t1.cod_subproducto, t1.materiales_sap";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		echo "<tr bgcolor=\"#FFFFFF\">\n";
		//$ClaveChk=$Fila["cod_producto"]."~".$Fila["cod_subproducto"];
		$ClaveChk=$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Fila["cod_empaque"];
		echo "<td ><input type=\"checkbox\" name=\"ChkAsig\" value=\"".$ClaveChk."\"></td>\n";
		echo "<td >".$Fila["nom_producto"].		"</td>\n";
		echo "<td >".$Fila["nom_subproducto"].	"</td>\n";
		echo "<td >".$Fila["unidad_medida"].	"</td>\n";		
		echo "<td >".$Fila["materiales_sap"].	"</td>\n";		
		echo "<td >".$Fila["pedido"].			"</td>\n";
		echo "<td >".$Fila["unidad_medida_sap"]."</td>\n";
		echo "<td >".$Fila["centro"].			"</td>\n";
		echo "<td >".$Fila["descripcion"].		"</td>\n";		
		echo "</tr>\n";
	}		
?>	
</table>	  
        <br>
      <br>
      <table width="620" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="30">
            <input name="BtnNuevo222" type="button" id="BtnNuevo222" style="width:70px;" onClick="Proceso('N')" value="Nuevo">
            <input name="BtnModificar2" type="button" id="BtnModificar" style="width:70px;" onClick="Proceso('M')" value="Modificar">
            <input name="BtnEliminar2" type="button" id="BtnEliminar2" style="width:70px;" onClick="Proceso('E')" value="Eliminar">
            <input name="BtnImprimir2" type="button" id="BtnImprimir3" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')">
          </td>
        </tr>
      </table></td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>