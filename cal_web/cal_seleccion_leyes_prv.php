<?php
	include("../principal/conectar_principal.php");
	$CodLeyes=$CodLeyes."~".$CodImpurezas."~";
?>
<html>
<head>
<title>Seleccion Leyes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,pag)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":				
			var Valores=f.TxtCodLeyes.value;
			var Valores2=f.TxtLeyesMuestra.value;
			var Valores3=f.TxtCodImpurezas.value;
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{
					if((f.elements[i].value=='01')||(f.elements[i].value=='02')||(f.elements[i].value=='03')||(f.elements[i].value=='04')||(f.elements[i].value=='05'))
						Valores = Valores + f.elements[i].value + "~";
					else
						Valores3 = Valores3 + f.elements[i].value + "~";
					Valores2 = Valores2 + f.elements[i+1].value + ",";
				}
			}
			if (Valores!="")
			{
				Valores = Valores.substring(0,(Valores.length)-1);
				Valores3 = Valores3.substring(0,(Valores3.length)-1);
				Valores2 = Valores2.substring(0,(Valores2.length)-1);
			}
			if(pag=='LeyesCanje')
			{
				
				window.opener.FrmProceso.TxtCodLeyes.value=Valores;
				window.opener.FrmProceso.TxtCodImpurezas.value=Valores3;
				window.opener.FrmProceso.TxtLeyes.value=Valores2;
				window.close();
			}
			else
			{
				window.opener.frmRegistros.TxtCodLeyes.value=Valores;
				window.opener.frmRegistros.TxtCodImpurezas.value=Valores3;
				window.opener.frmRegistros.TxtLeyesMuestra.value=Valores2;
				window.close();
			}	
			break;		
		case "S":
			window.close();
			break;
		case "MT":
			var Valor=false;
			if (f.ChkTodos.checked==true)
				Valor=true;
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes")
					f.elements[i].checked = Valor;
			}
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPopUp" action="" method="post">
<input name="TxtLeyesMuestra" type="hidden"  value='<?php echo $TxtLeyesMuestra;?>'>
<input name="TxtCodLeyes" type="hidden" value="<?php echo $TxtCodLeyes;?>">
<input name="TxtCodImpurezas" type="hidden" value="<?php echo $TxtCodImpurezas;?>">
<table width="350"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" >
    <td colspan="12" class="ColorTabla02"><input name="BtnOK" type="button" id="BtnOK" value="OK" style="width:70px " onClick="Proceso('G','<?php echo $Pag; ?>')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td colspan="2"><input type="checkbox" name="ChkTodos" value="S" onClick="Proceso('MT')">
    Todos</td>
    <td colspan="10"><strong>Analitos</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="30">Selec.</td>
    <td width="95">Ley</td>
    <td width="30">Selec</td>
    <td width="95">Ley</td>
    <td width="30">Selec.</td>
    <td width="95">Ley</td>
    <td width="30">Selec</td>
    <td width="95">Ley</td>
  </tr>
  <?php
	$RegPorColum=5;
	$Consulta = "select distinct t1.cod_leyes, LPAD(t1.cod_leyes,4,'0') as orden, t3.abreviatura as ley,t1.cod_unidad ";
	$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
	$Consulta.= " t1.cod_leyes=t3.cod_leyes";
	$Consulta.= " where t1.cod_leyes<>'' and t3.abreviatura <>'' ";
	$Consulta.= " group by t1.cod_leyes order by orden";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$ContColum = 1;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{  		
		$pos = strpos($CodLeyes, $Fila["cod_leyes"]."~");
		if ($pos === false)
			echo "<td class='Detalle01' align='center'><input type='checkbox' name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";
		else
			echo "<td class='Detalle01' align='center'><input type='checkbox' name='ChkLeyes' value='".$Fila["cod_leyes"]."' checked>";
		echo "<input type='hidden' name='ChkAbrevLeyes' value='".$Fila["ley"]."'></td>\n";
		echo "<td class='ColorTabla03' align='left'>".$Fila["ley"]."</td>\n";
		if ($ContColum == 4)
		{		
			echo "</tr>\n";
			echo "<tr>\n";
			$ContColum = 1;
		}
		else
			$ContColum++;
	}
	echo "</tr>\n";
?></table>
</form>

</body>
</html>
