<?php	include("../principal/conectar_sec_web.php"); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.js" type="text/javascript"></script>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function Eliminar()
{
	var Frm=document.frmPopUp;
	var Valores=new String();
	var TipoEstado="";

	for (i=1;i<Frm.CheckElim.length;i++)
	{
		
		if (Frm.CheckElim[i].checked==true)
		{
			
			if (typeof Frm.Valor[0] == 'undefined') {
				Valores=Valores + Frm.Valor.value +"~"; //Frm.CheckElim[i].value +"~";
			}else{
				Valores=Valores + Frm.Valor[i-1].value +"~"; //Frm.CheckElim[i].value +"~";
			}
			
			TipoEstado=Frm.elements[i+2].value;
		}
	}
	if (Valores!='')
	{
		
			Valores=Valores.substr(0,Valores.length-1);
			//alert(Valores);
			if (confirm('Esta Seguro de Eliminar  Los Registros Seleccionados'))
			{						
				Frm.action="sec_ing_produccion_popup2_22.php?&fecha=<?php echo $fecha; ?>&fecha2=<?php echo $Fecha2;?>&proceso=ELICUBA&Valores="+Valores
				//alert("sec_ing_produccion_popup2_22.php?&fecha=<?php echo $fecha; ?>&fecha2=<?php echo $Fecha2;?>&proceso=ELICUBA&Valores="+Valores);
				Frm.submit();
			}	
		
	}
	else
	{
		alert("No ha Seleccionado para Eliminar");
		return;
	}	
}


function CheckElim_Onclick(peso){
	var suma=0;
	//$(document).ready(function() {
		
		$('input[type=checkbox]').each( function() {		
			if (this.checked){
			} else {
				//alert($('#Total').val());
				suma = suma + parseInt($(this).val()) ;
			}
		});
		$('#Total').val(suma);
		//$("#Total").text(suma);
		//$("#Total").text = suma;
  //  });
}
</script>
<script language="JavaScript">
/***************/
/***************/
function Atras()
{	var Frm = document.frmPopUp;
	Frm.action="sec_ing_produccion_popup2.php?&cmbproducto=<?php echo $cmbproducto;?>&cmbsubproducto=<?php echo $cmbsubproducto;?>";	
	Frm.submit();
}
/***************/
function Salir()
{	
	window.close();
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
	echo '<input name="cod_grupo" type="hidden" value="'.$cod_grupo.'">';
	echo '<input name="fecha" type="hidden" value="'.$fecha.'">';
	echo '<input name="Fecha2" type="hidden" value="'.$Fecha2.'">';
	
	echo '<input name="fecha_par" type="hidden" value="">';
	echo '<input name="hora_par" type="hidden" value="">';
	
	echo '<div style="position:absolute; left: 15px; top: 50px; width:518px; height:200px; id="div2">';
	echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
	echo '<tr>';
	echo '<td width="250" align="center">Grupo</td>';
	echo '<td width="250" align="center">Fecha</td>';	
	echo '<td width="250" align="center">Hora</td>';
	echo '<td width="250" align="center">Peso</td>';			
	echo '</tr>';	 
	echo '</table>';
	echo '</div>';

	echo '<div style="position:absolute; left: 15px; top: 75px; width:518px; height:223px; OVERFLOW: auto;" id="div5">';
	echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';

	if ($cod_grupo == "99")
	{
		$consulta = "SELECT * FROM sec_web.produccion_desc_normal";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_grupo = '".$cod_grupo."'";
		$consulta.= " ORDER BY cod_cuba";
		//echo $consulta."<br>";
	}
	else 
	{
		$consulta = "SELECT * FROM sec_web.produccion_catodo";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_grupo = '".$cod_grupo."'";
		$consulta.= " ORDER BY cod_cuba";
		//echo $consulta."<br>";
		
	}
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		$Total = $Total + $row["peso_produccion"];
	}
	//echo '<input name="Total" id="Total" type="hidden" value="'.$Total.'">';

	$rs = mysqli_query($link, $consulta);

	while ($row = mysqli_fetch_array($rs))
	{

		echo '<tr>';
		echo '<td width="125" align="center">'.$row["cod_grupo"].'</td>';
		echo '<td width="125" align="center">'.$row[fecha_produccion].'</td>';
		echo '<td width="125" align="center">'.$row[hora].'</td>';
		echo '<td width="125" align="center">'.$row["peso_produccion"].'</td>';		
		echo '<td width="1" align="center"><input type="checkbox" name="CheckElim" onClick="CheckElim_Onclick('.$row["peso_produccion"].')" value="'.$row["peso_produccion"].'">';
		echo '<input name="Fecha_sel" type="hidden" value="'.$row[fecha_produccion].'"/>';
		echo '<input name="Hora_sel" type="hidden" value="'.$row[hora].'"/>';
		echo '<input name="Peso_sel" type="hidden" value="'.$row["peso_produccion"].'"/>';
		echo '<input name="Valor" type="hidden" value="'.$row["cod_grupo"].'/'.$row[cod_cuba].'/'.$row[cod_lado].'/'.$row[fecha_produccion].'/'.$row["cod_producto"].'/'.$row["cod_subproducto"].'/'.$row[hora].'"/>';
		echo '</input>';
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr >';
	echo '<td width="125" align="center" ></td>';
	echo '<td width="125" align="center" ></td>';
	echo '<td width="125" align="center" ></td>';
	echo '<td width="125" align="center">';
	echo '<b><input name="Total" id="Total" value="'.$Total.'"  disabled size="4" style="text-align:center; ; color:#000000; font-weight:bold"></input></b>';
	echo '</td>';	
	echo '</tr>';
	echo '</table>';
	echo '</div>';	
?>

<div style="position:absolute; left: 15px; top: 310px;" id="div5">
<table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td  align="center"><input name="btnatras" type="button" style="width:70" value="Atras" onClick="Atras()">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
 <input name="btneliminar" type="button" style="width:70" value="Eliminar" onClick="Eliminar()">
 </td>
 </td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>