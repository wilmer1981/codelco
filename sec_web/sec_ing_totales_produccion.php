<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 3;
?>
<html>
<head>
<title>Ingreso Totales de Produccion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValorCheckBox(f)
{
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			return f.checkbox[i].value;
	}
}
/***********************/
function SeleccionarTodos(f)
{
	try{
		if (f.checkbox[0].checked == true)
			valor = true
		else valor = false;
				
		for(i=1; i<f.checkbox.length; i++)	
			f.checkbox[i].checked = valor;
	}catch (e){
		//Cuando ocuure error.
	}
}
/************************/
function ValoresChequeados(f)
{
	valores = "";
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			valores = valores + f.checkbox[i].value + '~';
	}
	return valores;
}
/************************/
function CantidadChecheado(f)
{
	cont = 0;
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			cont++;
	}	
	return cont;
}
/***********************/
function Proceso(f,opc)
{
	linea = "opcion=" + opc;
	if (opc == 'M')
	{
		cantidad = CantidadChecheado(f);
		if (cantidad == 1)
		{
			linea = linea + "&parametros=" + ValorCheckBox(f);
		}
		else if (cantidad == 0)
		{
			alert("Debe Selecionar Una Casilla para Modificar");
			return;
		}
		else
		{
			alert("Hay ms de Una Casilla Marcada");
			return;
		}
	}	
		
	window.open("sec_ing_totales_produccion_proceso.php?"+linea,"","top=195,left=180,width=437,height=187,scrollbars=no,resizable = no");
}
/**********************/
function Eliminar(f)
{
	var valores = ValoresChequeados(f);
	valores = valores.substr(0,valores.length-1);

	if (valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
		if (confirm("Esta Seguro de Eliminar los Registros Seleccionados"))
		{
			f.action = "sec_ing_totales_produccion_proceso01.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}
/*********************/
function Salir()
{	
	document.location = "../principal/sistemas_usuario.php?CodSistema=3";
}
</script></head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
<table width="770" height="500" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
<td width="762" align="center" valign="middle"> 


<div style="position:absolute; left: 15px; top: 70px; width: 730.px; height: 24px;" id="div1">
          <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="61" height="25"><input type="checkbox" name="checkbox" value="checkbox" onClick="SeleccionarTodos(this.form)">
                Todo</td>
              <td width="43" align="center">Activa</td>
              <td width="96" align="center">Fecha</td>
              <td width="62" align="center">Revisi&oacute;n</td>
              <td width="151" align="center">Catodos Comerciales</td>
              <td width="135" align="center">Descrobrizacion Nornal</td>
              <td width="166" align="center">Despuntes y L&aacute;minas</td>
            </tr>
          </table> 
		
		
        </div>		
		
<div style="position:absolute; left: 13px; top: 98px; width: 750; height: 378;OVERFLOW: auto;" id="div2";>
        <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
		<?php        			
			$consulta = "SELECT * FROM sec_web.totales_produccion ORDER BY fecha DESC,revision DESC"; 
			$rs = mysqli_query($link, $consulta);
			
			while ($row = mysqli_fetch_array($rs))
			{
				echo '<tr>';
				echo '<td width="61" height="25"><input type="checkbox" name="checkbox" value="'.$row["fecha"]."/".$row[revision].'"></td>';
				if ($row["estado"] == 0)
					echo '<td width="43" align="center">&nbsp;</td>';
				else 
					echo '<td width="43" align="center"><img src="../principal/imagenes/ico_ok.gif"></td>';
					
				echo '<td width="96" align="center">'.substr($row["fecha"],5,2).'/'.substr($row["fecha"],0,4).'</td>';
				echo '<td width="62" align="center">'.$row[revision].'</td>';
				echo '<td width="151" align="center">'.$row[cant_catodos_comerciales].'</td>';
				echo '<td width="135" align="center">'.$row[cant_descobrizacion_normal].'</td>';
				echo '<td width="166" align="center">'.$row[cant_despuntes_laminas].'</td>';
				echo '</tr>';
			}		
		?>
        </table>
</div>				

<div style="position:absolute; left: 15px; top: 513px; width: 730px; height: 24px;">
        <table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
            <td align="center"><input name="btnnuevo" type="button" value="Nuevo" style="width:70" onClick="Proceso(this.form,'N')">
              <input name="btnmodificar" type="button" value="Modificar" style="width:70" onClick="Proceso(this.form,'M')">
              <input name="btneliminar" type="button" value="Eliminar" style="width:70" onClick="Eliminar(this.form)">
              <input name="btnsalir" type="button" value="Salir" style="width:70" onClick="Salir()"></td>
          </tr>
        </table>
</div>		

</td>
</tr>
</table>

<?php include("../principal/pie_pagina.php") ?>
</form>
<?php
	if (isset($mensaje))
	{
		echo '<script language="JavaScript">';		
		echo 'alert("'.$mensaje.'");';			
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>

