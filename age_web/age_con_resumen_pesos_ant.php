<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 92;
	include("../principal/conectar_principal.php");
	if(!isset($TxtFechaIni))
	{
		$TxtFechaIni=date("Y-m")."-01";
		$TxtFechaFin=date("Y-m-d");
	}
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action="age_con_resumen_pesos_web.php";
			f.submit();
			break;
		case "E":
			f.action="age_con_resumen_pesos_excel.php";
			f.submit();
			break;
		case "R":
			f.action="age_con_resumen_pesos.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=70&Nivel=1";
			f.submit();
			break;
	}
}
</script>
<title>Agencia Ventanas</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="middle">
	  <table width="500" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr align="center">
            <td colspan="2" class="Detalle01">DETALLE PESO HUMEDO Y SECO </td>
          </tr>
          <tr>
            <td width="109" class="Detalle02">&gt;&gt;Periodo:</td>
            <td width="372" align="left"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Asignacion:</td>
            <td align="left">
			  <select name="CmbRecepcion" style="width:200" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbRecepcion');" onChange="Proceso('R')">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
				$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
				/*$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
				$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));*/
				$Consulta = "select distinct cod_recepcion from age_web.lotes where fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				$Consulta.= " and cod_recepcion <>'' order by cod_recepcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbRecepcion == $Fila["cod_recepcion"])
						echo "<option selected value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
				}
			  ?>
            </select></td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Clase Producto :</td>
            <td align="left">
			<select name="CmbClaseProd" style="width:200" onkeydown="TeclaPulsada2('N',false,this.form,'BtnConsulta');">
              <option class="NoSelec" value="S">TODOS</option>
			  <option value="M">METALICOS</option>
			  <option value="P">MINEROS</option>
            </select></td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2">   
              <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C');">
			  <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E');">
		    <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br> 
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
?>