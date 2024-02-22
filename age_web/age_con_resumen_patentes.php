<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 94;
	include("../principal/conectar_principal.php");
	if(!isset($TxtFechaIni))
	{
		$TxtFechaIni=date("Y-m")."-01";
		$TxtFechaFin=date("Y-m-d");
	}	
	if (!isset($OptVer))
		$OptVer="P";
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
			f.action="age_con_resumen_patentes_web.php";
			f.submit();
			break;
		case "E":
			f.action="age_con_resumen_patentes_excel.php";
			f.submit();
			break;
		case "R":
			f.action="age_con_resumen_patentes.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=70&Nivel=1";
			f.submit();
			break;
	}
}
function Recarga3()
{
	var Frm = frmPrincipal;
	Frm.action="age_con_resumen_patentes.php?Busq=S";
	Frm.submit();	
}
</script>
<title>Resumen de Recepciones Por Camiones</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>

<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="middle">
	  <table width="650" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
            <td width="111" class="Detalle02">&gt;&gt;Periodo:</td>
            <td width="432" align="left">
			  <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
          </tr>

          <tr>
            <td class="Detalle02">&gt;&gt;SubProducto:</td>
            <td align="left"><select name="CmbSubProducto" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');" onChange="Proceso('R')">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
            </select></td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Proveedor:</td>
            <td align="left"><select name="CmbProveedor" style="width:300" onkeydown="TeclaPulsada2('N',false,this.form,'BtnConsulta');">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select distinct t1.rut_proveedor, t2.nombre_prv ";
				$Consulta.= " from age_web.relaciones t1 left join sipa_web.proveedores t2 on t1.rut_proveedor = t2.rut_prv ";
				$Consulta.= " where t1.cod_producto='1' and t2.nombre_prv<>'' ";
				if($CmbSubProducto!='S')
					$Consulta.= "and t1.cod_subproducto= '".$CmbSubProducto."' ";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t2.nombre_prv like '%".$TxtFiltroPrv."%' ";  							
				$Consulta.= "order by t2.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
				}
			?>
            </select>
              ---> Filtro Prv&nbsp;
              <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
            </td>
          </tr>
         <?php
		 /* <tr> 
            <td width="109" class="Detalle02">&gt;&gt;Ver:</td>
            <td width="372" align="left">
<?php			
switch ($OptVer)
{
	case "P":
		echo "<input checked name=\"OptVer\" type=\"radio\" value=\"P\">Detalle&nbsp;&nbsp;\n";
		echo "<input name=\"OptVer\" type=\"radio\" value=\"L\">Acumulado\n";
		break;
	case "L":
		echo "<input name=\"OptVer\" type=\"radio\" value=\"P\">Detalle&nbsp;&nbsp;\n";
		echo "<input checked name=\"OptVer\" type=\"radio\" value=\"L\">Acumulado\n";
		break;
}
 
          </tr>?>*/
		  ?>
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