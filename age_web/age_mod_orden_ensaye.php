<?php 	
	include("../principal/conectar_principal.php");
	switch($Proceso)
	{
		case "M":
			$Actualizar = "UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$TxtValor1."' where cod_clase='15010' and cod_subclase='1'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			$Actualizar = "UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$CmbLaboratorios."' where cod_clase='15010' and cod_subclase='2'";
			mysqli_query($link, $Actualizar);
			$Actualizar = "UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$TxtFechaCanje."' where cod_clase='15010' and cod_subclase='3'";
			mysqli_query($link, $Actualizar);
			$Actualizar = "UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$TxtFechaSolPqts."' where cod_clase='15010' and cod_subclase='4'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			break;
		default:
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='1'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			//echo $Consulta;
			$TxtValor1=$Fila["valor_subclase1"];
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='2'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			//echo $Consulta;
			$CmbLaboratorios=$Fila["valor_subclase1"];
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='3'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			//echo $Consulta;
			$TxtFechaCanje=$Fila["valor_subclase1"];
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='4'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			//echo $Consulta;
			$TxtFechaSolPqts=$Fila["valor_subclase1"];

			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtValor1.value == "")
	{
		alert("Debe Ingresar N� Orden de Ensaye")
		Frm.TxtValor1.focus();
		return;
	}
	Frm.action="age_mod_orden_ensaye.php?Proceso="+Proceso+"&TxtValor1="+Frm.TxtValor1.value;
	Frm.submit();
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr align="center"> 
            <td colspan="2" class="Detalle01">MODIFICACION PARAMETROS CANJE </td>
            </tr>
          <tr> 
            <td width="127">N&deg; Orden Ensaye </td>
            <td width="379"><input  type="text" name="TxtValor1" value="<?php echo $TxtValor1;?>" style="width:100"></td>
          </tr>
          <tr> 
            <td width="127">N&deg; Laboratorio</td>
            <td width="379"><select name="CmbLaboratorios" style="width:150">
	 <option value="S">Ninguno</option>
	 <?php
	 	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase=15009";
		$RespLab=mysqli_query($link, $Consulta);
		while($FilaLab=mysqli_fetch_array($RespLab))
		{
			if($FilaLab["cod_subclase"]==$CmbLaboratorios)
				echo "<option value='".$FilaLab["cod_subclase"]."' selected>".$FilaLab["nombre_subclase"]."</option>";
			else
				echo "<option value='".$FilaLab["cod_subclase"]."'>".$FilaLab["nombre_subclase"]."</option>";
			
		}
	 ?>
	 </select></td>
          </tr>
          <tr> 
            <td width="127">N&deg; Fecha Canje </td>
            <td width="379"><input name="TxtFechaCanje" type="text" class="InputCen" id="TxtFechaCanje" value="<?php echo $TxtFechaCanje; ?>" size="15" maxlength="10" >
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaCanje,TxtFechaCanje,popCal);return false"></td>
          </tr>
          <tr> 
            <td width="127">N&deg; Fecha Solic.Paqts</td>
            <td width="379"><input name="TxtFechaSolPqts" type="text" class="InputCen" value="<?php echo $TxtFechaSolPqts; ?>" size="15" maxlength="10" >
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaSolPqts,TxtFechaSolPqts,popCal);return false"> </td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('M','')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>