<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 7;
	include("../principal/conectar_principal.php");

?>
<html>
<head>
<title>Orden de Producci&oacute;n</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	var Valor="";
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
			f.action = "inter_orden_produccion.php";
			f.submit();
			break; 
		case "E"://ELIMINAR
			var Valores="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkOrden" && f.elements[i].checked==true)
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
					f.action = "inter_orden_produccion01.php";
					f.submit();
				}
			}
			break; 
		case "R"://RECARGA
			f.action = "inter_orden_produccion.php";
			f.submit();
			break;
	}	
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
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
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="ValoresAux" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="620" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td colspan="2" class="ColorTabla02"><strong>ORDENES DE PRODUCCION </strong></td>
        </tr>
        <tr align="center">
          <td width="310" height="30"> <!--<input name="BtnNuevo" type="button" id="BtnNuevo" style="width:70px;" onClick="Proceso('N')" value="Nuevo">
            <input name="BtnModificar" type="button" id="BtnModificar" style="width:70px;" onClick="Proceso('M')" value="Modificar">            
            <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px;" onClick="Proceso('E')" value="Eliminar"> -->             </td>
          <td width="310"><!--<input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
            <input name="BtnExcel" type="button" id="BtnExcel2" style="width:70px;" onClick="Proceso('E')" value="Excel">-->
            <input name="BtnImprimir" type="button" id="BtnImprimir2" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        
        <br>
        <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000">
    <tr class="ColorTabla01">
      <td width="30" align="center">&nbsp;</td>
      <td width="100">Asignacion</td>
      <td width="100">Producto</td>
      <td width="120">SubProducto</td>
      <td width="70">Codigo OP </td> 
      <td width="70" align="center">Material.SAP</td>
      <td width="70" align="center">Unid.Medida</td>
      <td width="70" align="center">Centro</td>
      <td width="100" align="center">Clase.Valoriz</td>
      </tr>
<?php	
	$Consulta = "select t1.asignacion, t1.cod_producto, t1.cod_subproducto, t2.abreviatura as nom_producto, ";
	$Consulta.= " t3.abreviatura as nom_subproducto, t1.codigo_op, t1.cod_material_sap, t1.unidad_medida, t1.centro, t1.clase_valorizacion";
	$Consulta.= " from interfaces_codelco.ordenes_produccion t1  inner join proyecto_modernizacion.productos t2 ";
	$Consulta.= " on t1.cod_producto=t2.cod_producto inner join proyecto_modernizacion.subproducto t3 on ";
	$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " order by t1.cod_producto, t1.cod_subproducto, t1.asignacion ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		echo "<tr bgcolor=\"#FFFFFF\">\n";
		$ClaveChk=$Fila["asignacion"]."~".$Fila["cod_producto"]."~".$Fila["cod_subproducto"];
		echo "<td ><input type=\"checkbox\" name=\"ChkOrden\" value=\"".$ClaveChk."\"></td>\n";
		echo "<td >".$Fila["asignacion"]."</td>\n";
		echo "<td >".$Fila["nom_producto"]."</td>\n";
		echo "<td >".$Fila["nom_subproducto"]."</td>\n";		
		echo "<td align=\"center\">".$Fila["codigo_op"]."</td>\n";
		echo "<td align=\"center\">".$Fila["cod_material_sap"]."</td>\n";
		echo "<td align=\"center\">".$Fila["unidad_medida"]."</td>\n";
		echo "<td align=\"center\">".$Fila["centro"]."</td>\n";
		echo "<td align=\"center\">".$Fila["clase_valorizacion"]."</td>\n";		
		echo "</tr>\n";
	}		
?>	
</table>	  
        <br>
      <br></td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>