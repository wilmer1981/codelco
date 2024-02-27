<?php	include("../principal/conectar_sec_web.php"); ?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar1()
{	
	var f = document.frmPopUp;	
	
	f.action = "sec_ing_produccion_popup1.php?mostrar=S";
	f.submit();
}
function Marca()
{	
	var f = document.frmPopUp;	
	
	

	var ValorChk = false;
		if (f.ChkMarcaTodo.checked)
			ValorChk = true;
		for (i=1;i<f.CheckElim.length;i++)
		{
			
				f.CheckElim[i].checked=ValorChk;
			
		}
}
/***************/
function Chequear(r)
{
	var f = document.frmPopUp;
	
	window.opener.document.frm1.action = "sec_ing_produccion01.php?proceso=B5&parametros=" + r.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	window.opener.document.frm1.submit();	
	window.close();
}
/***************/
function Atras()
{	var Frm = document.frmPopUp;
	Frm.action="sec_ing_produccion_popup22.php?&fecha=<?php echo $fecha; ?>&fecha2=<?php echo $Fecha2;?>&cmbproducto=<?php echo $cmbproducto;?>&cmbsubproducto=<?php echo $cmbsubproducto;?>&grupo=<?php echo $cod_grupo;?>";
	Frm.submit();
}
/***************/
function Salir()
{	
	window.close();
}
function Eliminar()
{
	var Frm=document.frmPopUp;
	var Valores=new String();
	var TipoEstado="";
	for (i=1;i<Frm.CheckElim.length;i++)
	{
		if (Frm.CheckElim[i].checked==true)
		{
			Valores=Valores + Frm.CheckElim[i].value +"~";
			TipoEstado=Frm.elements[i+2].value;
		}	
	}
	if (Valores!='')
	{
		
			Valores=Valores.substr(0,Valores.length-1);
			if (confirm('Esta Seguro de Eliminar  Los Registros Seleccionados'))
			{						
				Frm.action="sec_ing_produccion01.php?&fecha=<?php echo $fecha; ?>&fecha2=<?php echo $Fecha2;?>&proceso=ELICUBA&Valores="+Valores;
				Frm.submit();
			}	
		
	}
	else
	{
		alert("No ha Seleccionado para Eliminar");
		return;
	}	
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="CheckElim" value=''>
<div style="position:absolute; left: 15px; top: 15px;" id="div0">
<table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
        <td align="center" >Datos de Produccion</td>
  </tr>
</table>
</div>

<?php 
	//Campos Ocultos.
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
	echo '<input name="fecha" type="hidden" value="'.$fecha.'">';
	echo '<input name="Fecha2" type="hidden" value="'.$Fecha2.'">';
	echo '<div style="position:absolute; left: 15px; top: 50px; width:518px; height:200px; id="div2">';
	echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
	echo '<tr>';
	echo '<td width="250" align="center">Grupo</td>';
	echo '<td width="250" align="center">Lado</td>';
	echo '<td width="250" align="center">Cuba</td>';	
	echo '<td width="250" align="center">Peso</td>';	
	echo '<td width="1" align="center"><input type="checkbox" class="ColorTabla01"  name="ChkMarcaTodo" value="" onClick="Marca()" class="SinBorde"></td>';	
echo '</tr>';	 
	echo '</table>';
	echo '</div>';

	echo '<div style="position:absolute; left: 15px; top: 75px; width:518px; height:223px; OVERFLOW: auto;" id="div5">';
	echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';

	if ($cod_grupo == "99")
	{
		$consulta = "SELECT * FROM sec_web.produccion_desc_normal";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_grupo = '".$cod_grupo."' AND cod_lado = '".$lado."'";
		$consulta.= " ORDER BY cod_cuba";
		//echo $consulta."<br>";
	}
	else 
	{
		$consulta = "SELECT * FROM sec_web.produccion_catodo";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_grupo = '".$cod_grupo."' AND cod_lado = '".$lado."'";
		$consulta.= " ORDER BY cod_cuba";
		//echo $consulta."<br>";	
	}
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
		echo '<td width="125"><input type="radio" name="radiobutton" value="'.$row["cod_grupo"].'/'.$row[cod_cuba].'/'.$row[cod_lado].'/'.$row[fecha_produccion].'" onClick="Chequear(this)">'.$row["cod_grupo"].'</td>';
		
		echo '<td width="125" align="center">'.$row[cod_lado].'</td>';
		echo '<td width="125" align="center">'.$row[cod_cuba].'</td>';
		echo '<td width="125" align="center">'.$row["peso_produccion"].'</td>';
		echo '<td width="1" align="center"><input type="checkbox" name="CheckElim"  value="'.$row["cod_grupo"].'/'.$row[cod_cuba].'/'.$row[cod_lado].'/'.$row[fecha_produccion].'/'.$row["cod_producto"].'/'.$row["cod_subproducto"].'/'.$row[hora].'"></td>';
		echo '</tr>';
	}
	
	echo '</table>';
	echo '</div>';	
?>

<div style="position:absolute; left: 15px; top: 310px;" id="div5">
<table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td align="center"><input name="btnatras" type="button" style="width:70" value="Atras" onClick="Atras()">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
 <input name="btneliminar" type="button" style="width:70" value="Eliminar" onClick="Eliminar()"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>