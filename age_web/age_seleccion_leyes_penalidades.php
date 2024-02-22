<?php
	include("../principal/conectar_principal.php");
	//$TxtLeyesMuestra='Cu,Ag,Au,';
	//$TxtCodLeyes="02~Cu~1~100~%~2//04~Ag~4~1000~g/T~0//05~Au~4~1000~g/T~1//";
	if (strlen($MesApl)==1)
		$FechaApl = $AnoApl."0".$MesApl;
		else
		$FechaApl = $AnoApl.$MesApl;
?>
<html>
<head>
<title>Carga Leyes</title>
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
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{
					Valores = Valores + f.elements[i].value + "~"+ f.elements[i+2].value +"//";
					Valores2 = Valores2 + f.elements[i+1].value + ",";
				}
			}
			if (Valores!="")
			{
				Valores = Valores.substring(0,(Valores.length)-2);
				Valores2 = Valores2.substring(0,(Valores2.length)-1);
			}
			if(pag=='LeyesCanje')
			{
				window.opener.FrmProceso.TxtCodLeyes.value=Valores;
				window.opener.FrmProceso.TxtLeyes.value=Valores2;
				window.close();
			}
			else
			{
				window.opener.frmPrincipal.TxtCodLeyes.value=Valores;
				window.opener.frmPrincipal.TxtLeyesMuestra.value=Valores2;
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
<input name="TxtLeyesMuestra" type="hidden"  value='<?php echo $TxtLeyesMuestra;?>'><input name="TxtCodLeyes" type="hidden" value="<?php echo $TxtCodLeyes;?>">
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
	<td width="95">Unid</td>
    <td width="30">Selec</td>
    <td width="95">Ley</td>
	<td width="95">Unid</td>
    <td width="30">Selec.</td>
    <td width="95">Ley</td>
	<td width="95">Unid</td>
    <td width="30">Selec</td>
    <td width="95">Ley</td>
	<td width="95">Unid</td>
  </tr>
  <?php
	//$RegPorColum = round($CantLeyes/4);
	$RegPorColum=5;
	$SinPen=0;
	$Consulta = "select distinct t1.cod_leyes, LPAD(t1.cod_leyes,4,'0') as orden, t2.abreviatura as ley,t1.limite_minimo,t1.limite_medio,t1.limite_maximo, t1.anomes ";
	$Consulta.= "from age_web.limites t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes";
	//if($Plantilla!='S')
		$Consulta.= " where t1.cod_plantilla = '".$Plantilla."'";		
	$Consulta.= " group by t1.cod_leyes order by orden";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$ContColum = 1;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{ 
		if ($Fila["anomes"]<= $FechaApl)
		{ 
			$Datos=$Fila["cod_leyes"]."~".$Fila["ley"]."~".$Fila["limite_minimo"]."~".$Fila["limite_medio"]."~".$Fila["limite_maximo"];			
			echo "<td class='Detalle01' align='center'><input type='checkbox' name='ChkLeyes' value='".$Datos."'>";
			echo "<input type='hidden' name='ChkAbrevLeyes' value='".$Fila["ley"]."'></td>\n";
			echo "<td class='ColorTabla03' align='left'>".$Fila["ley"]."</td>\n";
			echo "<td class='ColorTabla03' align='left'><select name='CmbUnidad' style='width:50'>";
			$Consulta="select cod_unidad,abreviatura as unidad,conversion from proyecto_modernizacion.unidades where cod_unidad in ('1','2','4')";
			$RespUnid=mysqli_query($link, $Consulta);
			while($FilaUnid=mysqli_fetch_array($RespUnid))
			{
				if($Fila[cod_unidad]==$FilaUnid[cod_unidad])
					echo "<option value='".$FilaUnid["cod_unidad"]."~".$FilaUnid["conversion"]."~".$FilaUnid["unidad"]."~".$Decimales."' selected>".$FilaUnid["unidad"]."</option>";
				else
					echo "<option value='".$FilaUnid["cod_unidad"]."~".$FilaUnid["conversion"]."~".$FilaUnid["unidad"]."~".$Decimales."'>".$FilaUnid["unidad"]."</option>";
			}
			echo "</select></td>\n";
			if ($ContColum == 4)
			{		
				echo "</tr>\n";
				echo "<tr>\n";
				$ContColum = 1;
			}
			else
			{
				$ContColum++;
			}
		}
		
	}
	echo "</tr>\n";
?></table>
</form>

</body>
</html>
