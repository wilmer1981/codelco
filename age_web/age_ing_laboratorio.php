<?php
	include("../principal/conectar_principal.php");
	$CodigoDeSistema=15;
	$CodigoDePantalla=99;
	if (!isset($ChkDefin))
		$ChkDefin = "S";
	if (!isset($ChkAplic))
		$ChkAplic = "C";
	switch ($ChkDefin)
	{
		case "S":
			$CmbProveedor="S";
			$CmbContrato="S";
			break;
		case "P":
			$CmbContrato="S";
			break;
		case "C":
			$CmbProveedor="S";
			break;
	}
?>
<html>
<head>
<title>AGE-Ingreso Laboratorio</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f= document.frmPrincipal;
	switch (opt)
	{
		case "I":
			f.BtnNuevo.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnModificar.style.visibility = "hidden";
			f.BtnEliminar.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnNuevo.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnModificar.style.visibility = "visible";
			f.BtnEliminar.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;
		case "N":
			var URL = "age_ing_laboratorio02.php?Proc=N";
			window.open(URL,"","top=50px,left=30px,width=520px,height=350px,scrollbars=yes,resizable=yes");
			break;
		case "E":
			if (f.ChkSelec.value=="")
			{
				alert("No hay nada Seleccionado para ELIMINAR");
				return;
			}
			var msg=confirm("¿Seguro que desea Eliminar este Dato?");
			if (msg==true)
			{
				f.action = "age_ing_laboratorio01.php?Proceso=E";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "M":
			if (f.ChkSelec.value=="")
			{
				alert("No hay nada Seleccionado para MODIFICAR");
				return;
			}
			var URL = "age_ing_laboratorio02.php?Proc=M&Valores="+f.ChkSelec.value;
			window.open(URL,"","top=50px,left=30px,width=520px,height=350px,scrollbars=yes,resizable=yes");
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=40";
			f.submit();
			break;
		case "R":
			f.action = "age_ing_laboratorio.php";
			f.submit();
			break;
	}
}

function Seleccionar(obj)
{
	var f=document.frmPrincipal;
	f.ChkSelec.value=obj.value;
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="ChkSelec" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><br>
        <table width="550" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr align="center">
            <td width="513" class="Detalle01"><strong>LABORATORIOS DE ANALISIS ARBITRAL </strong></td>
          </tr>
          <tr>
            <td align="center"><input name="BtnNuevo" type="button" id="BtnNuevo" value="Nuevo" style="width:70px " onClick="Proceso('N')">
              <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
              <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:70px " onClick="Proceso('M')">
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
          </tr>
        </table>
	    <br>
	    <table width="550" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01">
            <td width="30">Selec</td>
            <td width="200">Laboratorio</td>
            <td width="80">Tipo Moneda</td>
            <td width="80">Valor Cu </td>
            <td width="80">Valor Ag </td>
            <td width="80">Valor Au </td>
          </tr>
<?php		  
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15009' order by nombre_subclase";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Clave = $Fila["cod_subclase"];
		echo "<tr>\n";
		echo "<td align='center'><input type='radio' name='ChkReg' value='".$Clave."' onClick='Seleccionar(this)'></td>\n";
		echo "<td>".strtoupper($Fila["nombre_subclase"])."</td>\n";
		echo "<td>".$Fila["valor_subclase1"]."</td>\n";		
		echo "<td>".$Fila["valor_subclase2"]."</td>\n";		
		echo "<td>".$Fila["valor_subclase3"]."</td>\n";		
		echo "<td>".$Fila["valor_subclase4"]."</td>\n";		
		echo "</tr>\n";
	}
?>		  
        </table>
	    <br></td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>