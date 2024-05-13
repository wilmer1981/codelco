<?php
	include("../principal/conectar_principal.php");
	
	$TipoConsulta  = isset($_REQUEST["TipoConsulta"])?$_REQUEST["TipoConsulta"]:"";
	$Pag  = isset($_REQUEST["Pag"])?$_REQUEST["Pag"]:"";

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
			var Valores="";
			var Valores2="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{
					Valores = Valores + f.elements[i].value + "~";
					Valores2 = Valores2 + f.elements[i+1].value + ", ";
				}
			}
			if (Valores!="")
			{
				Valores = Valores.substring(0,(Valores.length)-1);
				Valores2 = Valores2.substring(0,(Valores2.length)-2);
			}
			if(pag=='LeyesCanje')
			{
				window.opener.FrmProceso.TxtCodLeyes.value=Valores;
				window.opener.FrmProceso.TxtLeyes.value=Valores2;
				window.close();
			}
			else
			{
				window.opener.FrmPrincipal.TxtCodLeyes.value=Valores;
				window.opener.FrmPrincipal.TxtLeyesMuestra.value=Valores2;
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
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<form name="frmPopUp" action="" method="post">
<table width="350"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" >
    <td colspan="8" class="ColorTabla02"><input name="BtnOK" type="button" id="BtnOK" value="OK" style="width:70px " onClick="Proceso('G','<?php echo $Pag; ?>')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td colspan="2"><input type="checkbox" name="ChkTodos" value="S" onClick="Proceso('MT')">
    Todos</td>
    <td colspan="6"><strong>Analitos</strong></td>
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
	//$RegPorColum = round($CantLeyes/4);
	$RegPorColum=5;
	$Consulta = "select distinct t1.cod_leyes, LPAD(t1.cod_leyes,4,'0') as orden, t3.abreviatura as ley ";
	$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
	$Consulta.= " t1.cod_leyes=t3.cod_leyes";
	$Consulta.= " where t1.cod_leyes<>'01' and t1.cod_leyes<>'' and length(t1.cod_leyes)>=2";
	$Consulta.= " order by orden";
	$Resp = mysqli_query($link, $Consulta);
	$ContColum = 1;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{  		
		echo "<td class='Detalle01' align='center'><input type='checkbox' name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";
		echo "<input type='hidden' name='ChkAbrevLeyes' value='".$Fila["ley"]."'></td>\n";
		echo "<td class='ColorTabla03' align='center'>".$Fila["ley"]."</td>\n";
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
	echo "</tr>\n";
?></table>
</form>

</body>
</html>
