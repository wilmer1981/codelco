<?php
	session_start();
	session_register("arreglo");
	if (session_is_registered("arreglo")) 
		$arreglo = array();
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<script language="JavaScript">
var fila = 1; //Posicion Inicial de la Fila.
var col = 2;

function Todos(f)
{
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = f.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].type != 'checkbox')
			return;
		else 
			f.elements[i].checked = valor;
	}	
}
/************************/
function AlgunChequeado(f)
{
	try{
		pos = fila; //Posicion del Checkbox que Indica la Primera Fila.
		largo = f.elements.length;
		for (i=pos; i<largo; i=i+col)
		{	
			if (f.elements[i].type != 'checkbox')
				return false;
			else if (f.elements[i].checked == true)
					return true;
		}	
		return false;
	}catch(e){	
		return false;
	}
}
/************************/
function CantidadChequeados(f)
{		
	pos = fila; //Posicion del Primer Checkbox del formulario.
	largo = f.elements.length;
	cont = 0;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].type != 'checkbox')
			return cont;
		else if (f.elements[i].checked)
				cont++;
	}	
	return cont;
}
/***********************/
function Proceso(f)
{	

	//alert("Casillas Seleccionadas: " + 	CantidadChequeados(f));
	
	f.action="prueba_arreglo01.php";
	f.submit();
}
</script>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="checkbox" name="todos" onClick="Todos(this.form)">Todos<br>
<table width="500">
<?php 
	for($i=0; $i<10; $i++)
	{
		echo '<tr>';
		echo '<td width="50"><input type="checkbox" name="a['.$i.']"></td>'; 
		echo '<td width="50"><input type="text" size="10" name="unidades['.$i.']"></td>';
/*		echo '<td width="50"><input type="text" size="10" name="text" value="'.($i+1).'"></td>';
		echo '<td width="50"><input type="text" size="10" name="text" value="'.($i+2).'"></td>';
		echo '<td width="50"><input type="text" size="10" name="text" value="'.($i+3).'"></td>';
		echo '<td width="50"><input type="text" size="10" name="text" value="'.($i+4).'"></td>';
		echo '<td width="50"><input type="text" size="10" name="text" value="'.($i+5).'"></td>';
		echo '<td width="50"><input type="text" size="10" name="text" value="'.($i+6).'"></td>';
		
		$arreglo[$i][0] = $i; 
		$arreglo[$i][1] = $i+1;
		$arreglo[$i][2] = $i+2;
		$arreglo[$i][3] = $i+3;
		$arreglo[$i][4] = $i+4;
		$arreglo[$i][5] = $i+5;
		$arreglo[$i][6] = $i+6;						
*/
		echo '</tr>';
	} 
	//echo '<input type="hidden" name="caca" value="'.$arreglo.'">';
?>
</table>
<input type="button" name="btnProceso" value="Aceptar" onClick="Proceso(this.form);">
</form>
</body>
</html>
