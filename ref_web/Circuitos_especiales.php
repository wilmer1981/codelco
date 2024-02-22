<?php 	
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 20;
	include("../principal/conectar_ref_web.php");
?>
<html>
<head>
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
	}catch(e){
	}
}
/*****************/
function ValoresChequeados(f)
{
	valores = "";
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			valores = valores + f.checkbox[i].value + '-';
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
/************************/
function Proceso(f,opc)
{
	linea = "opcion=" + opc;
	if (opc == 'M')
	{
		cantidad = CantidadChecheado(f);
		if (cantidad == 1)
		{
			linea = linea + "&circuito=" + ValorCheckBox(f);
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
		
	window.open("Circuitos_especiales_proceso.php?"+linea,"","top=195,left=160,width=450,height=250,scrollbars=no,resizable = no");
}
/*****************/
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
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "Circuitos_especiales_proceso01.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}
/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=11";
}
</script>
<title>Ingreso Circuito Electrolitico</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCircuito" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <table width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="78"><input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
              Todos</td>
            <td width="73" align="center">Cod. Circuito</td>
            <td width="174" align="left"><div align="center">Descripcion Circuito</div></td>
            <td width="80" align="center">Nros. de Grupos</td>
            <td width="79" align="center">Nros de Celdas Grupo</td>
            <td width="75" align="center">N&deg;Catodos por Celda</td>
            <td width="64" align="center">Rectificador</td>
            <td width="74" align="center">Nave</td>
          </tr>
        </table>
		<?php
			echo '<table width="700" border="2" cellpadding="2" cellspacing="2" class="TablaDetalle">';
			$consulta = "SELECT * FROM ref_web.circuitos_especiales ORDER BY cod_circuito";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				echo '<tr>';
				echo '<td width="72" height="25"><input type="checkbox" name="checkbox" value="'.$row[cod_circuito].'"></td>';
				echo '<td width="86" align="center">'.$row[cod_circuito].'</td>';
				echo '<td width="206" align="left">'.$row[descripcion_circuito].'</td>';
				echo '<td width="59" align="center">'.$row[cantidad_grupos].'&nbsp;</td>';
				echo '<td width="81" align="center">'.$row[num_celdas_grupos].'&nbsp;</td>';
				echo '<td width="81" align="center">'.$row[num_catodos_celda].'&nbsp;</td>';
				echo '<td width="72" align="center">'.$row[rectificador].'&nbsp;</td>';
				echo '<td width="66" align="center">'.$row[nave].'&nbsp;</td>';				
				echo "</tr>";
			}
			echo "</table>";
		?>
        <br>
        <table width="480" border="0" class="tablainterior">
          <tr> 
            <td align="right" width="235"> <input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="JavaScript:Proceso(this.form,'N')"> 
              <input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="JavaScript:Proceso(this.form,'M')">
            </td>
            <td align="left" width="235"><input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="JavaScript:Eliminar(this.form)"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="JavaScript:Salir()"></td>
          </tr>
        </table><br></td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if (isset($EncontroRelacion))
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
?>
