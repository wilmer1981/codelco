<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 9;
	include("../principal/conectar_principal.php");

?>
<html>
<head>
<title>Asignaciones</title>
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
					f.action = "inter_asignaciones01.php?Proceso=E&Valores="+Valores;
					f.submit();
				}
			}
			break; 
		case "R"://RECARGA
			f.action = "inter_asignaciones.php";
			f.submit();
			break;
		case "N":	
			var URL = "inter_asignaciones_proceso.php?Proceso=N";
			window.open(URL,"","top=120,left=30,width=500,height=250,menubar=no,resizable=yes,scrollbars=yes");
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
					f.ValoresAux.value=Valores;
					var URL = "inter_asignaciones_proceso.php?Proceso=M&Valores="+Valores;
					window.open(URL,"","top=120,left=30,width=500,height=250,menubar=no,resizable=yes,scrollbars=yes");
					//f.action = "inter_orden_produccion_proceso.php?Proceso=M&Valores="+Valores;
					//f.submit();
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
          <td class="ColorTabla02"><strong>ASIGNACIONES</strong></td>
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
      <td width="100">Rut Proveedor</td>
      <td width="100">Asignacion</td>
      <td width="120">Entrada</td>
      <td width="70">Salida</td> 
	  <td width="70">Agrupados</td> 
      </tr>
<?php	
	$Consulta = "select * from interfaces_codelco.asignaciones";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		echo "<tr bgcolor=\"#FFFFFF\">\n";
		$ClaveChk=$Fila["rut_proveedor"]."~".$Fila["asignacion"];
		echo "<td ><input type=\"checkbox\" name=\"ChkAsig\" value=\"".$ClaveChk."\"></td>\n";
		echo "<td >".$Fila["rut_proveedor"]."</td>\n";
		echo "<td >".$Fila["asignacion"]."</td>\n";
		echo "<td >".$Fila["entrada"]."</td>\n";		
		echo "<td >".$Fila["salida"]."</td>\n";		
		echo "<td >".$Fila["agrupados"]."</td>\n";		
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