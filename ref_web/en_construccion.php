<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 10;
	$fecha=ltrim($fecha);
    $ano1=substr($fecha,0,4);
	$mes1=substr($fecha,5,2);
	$dia1=substr($fecha,8,2);
	$opcion='H';
	
?>

<html>
<head>
<title>Programa de Renovacion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar()
{
	var  f=document.frmPrincipal;
	var fecha=f.ano1.value+"-"+f.mes1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	
	document.location = "../ref_web/Renovacion_grupos.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1;
}
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
/************************/
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
	switch (opc)
	{
		case "M":
			var valores = "";	
			for(i=1; i<f.elements.length; i++)	
			{
				if ((f.elements[i].name == "checkbox") && (f.elements[i].checked))
					valores = valores + f.elements[i].value;
			}
			if (valores == "")
			{
				alert("Debe seleccionar un registro para Modificar");
				return;
			}
			else
			{				
				window.open("ref_ing_ren_prog_prod.php?Proceso=M&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value + "","","top=70,left=100,width=400,height=400,scrollbars=yes,resizable = yes");
				break;
			}
			break;
		case "A":
			f.action = "Renovacion_grupos.php?opcion=H";
			f.submit();
			break;
	}
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
			f.action = "sec_ing_grupo_electrolitico_proceso01.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}

function Imprimir(f)
{
	window.print();
}

/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}

</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="763" height="393" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle"><img src="archivos/MenAtWork.gif" width="260" height="276">
        <table width="75%" border="0" align="center">
          <tr>
            <td align="center"><strong><font color="#FF0000">Estamos trabajando 
              por</font></strong> <p><font color="#FF0000"><strong>entregarle 
                la mejor</strong></font></p>
              <p><font color="#FF0000"><strong>de nuestras p&aacute;ginas.</strong></font></p>
              <p></p></td>
          </tr>
        </table> </td>
</tr>
</table>
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
<?php include("../principal/cerrar_sec_web.php"); ?>
