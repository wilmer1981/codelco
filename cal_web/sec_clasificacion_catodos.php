<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 77;
	include("../principal/conectar_principal.php");

?>
<html>
<head>
<title>Clasificacion Catodos STD</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	var Valor="";
	switch (opt)
	{
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=44";
			f.submit();
			break;
		case "I"://IMPRIMIR
			window.print();
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
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("¿Desea Eliminar este Elemento?"))
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					f.ValoresAux.value=Valores;
					f.action = "sec_clasificacion_catodos_01.php?Proceso=E&Valores="+Valores;
					f.submit();
				}
			}
			break; 
		case "N":	
			var URL = "sec_clasificacion_catodos_proceso.php?Proceso=N";
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
				alert("Debe Seleccionar un Elemento para Modificar");
				return;
			}
			else
			{
				if (contador == 1)
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					f.ValoresAux.value=Valores;
					var URL = "sec_clasificacion_catodos_proceso.php?Proceso=M&Valores="+Valores;
					window.open(URL,"","top=120,left=30,width=500,height=250,menubar=no,resizable=yes,scrollbars=yes");
					//f.action = "inter_orden_produccion_proceso.php?Proceso=M&Valores="+Valores;
					//f.submit();
				}
				else
					alert("Debe Seleccionar Solo un Elemento");
			}
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
</style>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="ValoresAux" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">
	  <table width="500" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td class="ColorTabla02"><strong>Clasificaci&oacute;n Catodos Comerciales</strong></td>
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
        <table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000">
    <tr class="ColorTabla01">
      <td width="30" align="center">&nbsp;</td>
      <td width="100">Ley</td>
      <td width="100">Simbolo</td>
	 <!-- <td width="100">Unidad</td>-->
        <td width="100">Grado A Codelco</td>
        <td width="100">Grado A Enami</td>
        <td width="100">Rechazo</td>
        <td width="100">Estandar </td>
        <td width="100">Off Grade</td>
       </tr>
<?php	
	$Consulta = "select t1.cod_leyes,t1.*,t3.abreviatura as uni,t2.abreviatura as ley,t2.nombre_leyes from cal_web.clasificacion_catodos t1";
	$Consulta.= " inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
	$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad=t3.cod_unidad order by t2.nombre_leyes ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		echo "<tr bgcolor=\"#FFFFFF\">\n";
		$ClaveChk=$Fila["cod_leyes"];
		echo "<td ><input type=\"checkbox\" name=\"ChkAsig\" value=\"".$ClaveChk."\"></td>\n";
		echo "<td >".$Fila["nombre_leyes"]."</td>\n";
		echo "<td >".$Fila["ley"]."</td>\n";
		/*echo "<td >".$Fila["uni"]."</td>\n";*/
		echo "<td >".$Fila["grado_a_codelco"]."</td>\n";
		echo "<td >".$Fila["grado_a_enami"]."</td>\n";
		echo "<td >".$Fila["rechazo"]."</td>\n";
		echo "<td >".$Fila["estandar"]."</td>\n";
		echo "<td >".$Fila["off_grade"]."</td>\n";
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