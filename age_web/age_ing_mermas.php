<?php
	include("../principal/conectar_principal.php");
	$CodigoDeSistema=15;
	$CodigoDePantalla=90;

	$ChkDefin   = isset($_REQUEST["ChkDefin"])?$_REQUEST["ChkDefin"]:"S";
	$ChkAplic   = isset($_REQUEST["ChkAplic"])?$_REQUEST["ChkAplic"]:"C";


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
<title>AGE-Ingreso Mermas</title>
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
			var URL = "age_ing_mermas02.php?Proc=N";
			window.open(URL,"","top=50px,left=30px,width=650px,height=380px,scrollbars=yes,resizable=yes");
			break;
		case "E":
			if (f.ChkSelec.value=="")
			{
				alert("No hay nada Seleccionado para ELIMINAR");
				return;
			}
			var msg=confirm("¿Sefuro que desea Eliminar esta Regla?");
			if (msg==true)
			{
				f.action = "age_ing_mermas01.php?Proceso=E";
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
			var URL = "age_ing_mermas02.php?Proc=M&Valores="+f.ChkSelec.value;
			window.open(URL,"","top=50px,left=30px,width=650px,height=350px,scrollbars=yes,resizable=yes");
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=60";
			f.submit();
			break;
		case "R":
			f.action = "age_ing_mermas.php";
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
        <table width="620" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr align="center">
            <td width="513" class="Detalle01"><strong>DEFINICION DE PORCENTAJES DE MERMA </strong></td>
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
	    <table width="750" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01">
            <td width="29">Selec</td>
            <td width="123">SubProducto</td>
            <td width="200">Proveedor</td>
            <td width="94">Contrato</td>
            <td width="70">Tipo Aplic.</td>
            <td width="112">Referencia</td>
            <td width="47">Porc(%)</td>
			<td width="80">Fecha</td>
          </tr>
<?php		  
	$Consulta = "select * from age_web.mermas t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='15001' and t1.referencia=t4.nombre_subclase ";
	$Consulta.= " left join ram_web.tipo_lugar t5 on t5.cod_tipo_lugar=t1.referencia ";
	$Consulta.= " order by t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t1.cod_contrato, ";
	$Consulta.= " t1.tipo_aplicacion, t1.referencia, t1.porc ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Clave = "1~~".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"]."~~".$Fila["cod_contrato"]."~~".$Fila["tipo_aplicacion"]."~~".$Fila["referencia"];
		echo "<tr>\n";
		echo "<td align='center'><input type='radio' name='ChkReg' value='".$Clave."' onClick='Seleccionar(this)'></td>\n";
		echo "<td>".$Fila["abreviatura"]."</td>\n";
		if ($Fila["NOMPRV_A"]=="")
			echo "<td align='center'>-</td>\n";
		else
			echo "<td>".strtoupper($Fila["NOMPRV_A"])."</td>\n";
		if ($Fila["cod_contrato"]=="")
			echo "<td align='center'>-</td>\n";
		else
			echo "<td>".$Fila["cod_contrato"]."</td>\n";		
		if ($Fila["tipo_aplicacion"]=="C")
		{
			echo "<td align='center'>Clase Prod.</td>\n";
			echo "<td align='center'>".ucwords(strtolower($Fila["valor_subclase1"]))."</td>\n";
		}
		else
		{
			if ($Fila["tipo_aplicacion"]=="L")
			{
				echo "<td align='center'>Lugar Dest.</td>\n";
				echo "<td align='center'>".ucwords(strtolower($Fila["descripcion_lugar"]))."</td>\n";
			}
			else
			{
				echo "<td align='center'>-</td>\n";
				echo "<td align='center'>-</td>\n";
			}
		}
		echo "<td align='right'>".$Fila["porc"]."</td>\n";
		echo "<td align='right'>".$Fila["fecha"]."</td>\n";
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