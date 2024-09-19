<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	
	$CodigoDeSistema = 8;
	$CodigoDePantalla = 2;

	$CmbProductos   = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$Buscar 		= isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$TxtFechaIni    = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m-d');
	$TxtFechaFin    = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m-d');
		
?>
<html>
<head>
<title>Consulta Puntos de Control</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<?php
//echo '<link href="../principal/estilos/css_sipa_web.css" rel="stylesheet" type="text/css">';
?>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "B":
			f.action = "rec_consulta_puntos_control.php?Buscar=S";
			f.submit();
			break;
		case "E"://GENERA EXCEL
			URL='rec_consulta_puntos_control_excel.php?TxtFechaIni='+f.TxtFechaIni.value+'&TxtFechaFin='+f.TxtFechaFin.value+'&CmbProductos='+f.CmbProductos.value+'&CmbSubProducto='+f.CmbSubProducto.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;	
		case "R":
			f.action = "rec_consulta_ejes.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=24";
			f.submit(); 
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
.Estilo1 {color: #FFFFFF}
</style>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form action="" method="post" name="frmPrincipal">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="100%" height="316" align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
          <tr class="ColorTabla01">
            <td colspan="4" align="center">CONSULTA PUNTOS DE CONTROL </td>
          </tr>

          <tr bgcolor="#FFFFFF">
            <td width="92">Fecha Inicio:</td>
            <td width="228"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
                <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> </td>
            <td width="103">Fecha T&eacute;rmino:</td>
            <td width="235"><input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
                <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td width="87" > Producto</td>
            <td colspan="3"><font size="1"><font size="1"><font size="2"><strong>
              <SELECT name="CmbProductos" style="width:280" onChange="Proceso('R')">
                <option value='T' SELECTed>Todos</option>
                <?php 					
					$Consulta="SELECT t2.cod_producto,t2.descripcion from sipa_web.registro_puntos_control t1 inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto where t1.cod_producto<>''  group by t2.cod_producto order by t2.descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
							echo "<option value = '".$Fila["cod_producto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						else
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				?>
              </SELECT><?php //echo $Consulta;?>
            </strong></font></font></font></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>SubProducto</td>
            <td colspan="3"><font size="1"><font size="2"><strong>
              <SELECT name="CmbSubProducto" style="width:280" onChange="Proceso('R')">
                <option value="T" SELECTed>Todos</option>
                <?php
					$Consulta="SELECT t1.cod_subproducto,t1.descripcion from proyecto_modernizacion.subproducto t1 inner join sipa_web.registro_puntos_control t2 on t1.cod_subproducto=t2.cod_subproducto where t1.cod_producto = '".$CmbProductos."'  group by t1.cod_subproducto order by t1.descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
							echo "<option value = '".$Fila["cod_subproducto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						else
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				?>
              </SELECT>
            </strong></font></font></td>
          </tr>
        </table>
          <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
            <tr>
              <td align="center" bgcolor="#FFFFFF"><span class="Estilo1">
                <input type="button" name="btnWeb" value="Buscar" onClick="Proceso('B');" style="width:90px">
                <input type="button" name="btnExcel" value="Excel" onClick="Proceso('E');" style="width:90px">
                <input type="button" name="btnsalir" value="Salir" onClick="Proceso('S');" style="width:90px">
              </span></td>
            </tr>
        </table>
          <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaDetalle" >
            <tr align="center" class="ColorTabla01">
              <td width="12%" >Fecha Hora</td>
              <td width="12%" >Operador</td>
              <td width="10%" >Producto</td>
              <td width="10%" >SubProducto</td>
              <td width="6%" >Patente</td>
			  <td width="5%" >Gu&iacute;a</td>
              <td width="8%" >Peso Bruto Sipa (Kg)</td>
			  <td width="8%" >Peso Bruto Sec (Kg)</td>
              <td width="8%" >Peso Control (Kg)</td>
			  <td width="8%" >Diferencia (Kg)</td>
			  <td width="12%" >Operaci&oacute;n</td>
            </tr>
            <?php		
				if($Buscar=='S')
				{
					$FDesde=$TxtFechaIni." 00:00:00";
					$FHasta=$TxtFechaFin." 23:59:59";
					$Consulta="SELECT t1.*,t2.descripcion as Prod,t3.descripcion as SubProd from sipa_web.registro_puntos_control t1 ";
					$Consulta.=" left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
					$Consulta.=" left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
					$Consulta.=" where t1.correlativo<>'' ";
					if($CmbProductos!='T')
						$Consulta.=" and t1.cod_producto='".$CmbProductos."'";
					if($CmbSubProducto!='T')
						$Consulta.=" and t1.cod_subproducto='".$CmbSubProducto."'";
					$Consulta.=" and t1.fecha_hora between '".$FDesde."' and '".$FHasta."'";	
					$Consulta.=" order by t1.fecha_hora,t2.cod_producto,t3.cod_subproducto";
					//echo 	$Consulta."<br>";
					echo "<input name='CheckTipo' type='hidden'  value=''>";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						$Consulta="SELECT * from proyecto_modernizacion.funcionarios where rut='".$Fila["rut_operador"]."'";
						$Respuesta2 = mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Respuesta2))
							$NomOperador=$Fila2["apellido_paterno"]." ".$Fila2["apellido_materno"]." ".$Fila2["nombres"];
						$FechaHora=explode(' ',$Fila["fecha_hora"]);
						$Fecha=explode('-',$FechaHora[0]);
						$Fecha=$Fecha[2]."-".$Fecha[1]."-".$Fecha[0];
						$Hora=$FechaHora[1];
						?>
						<tr bgcolor="#FFFFFF">
						  <td align='center'><?php echo $Fecha." ".$Hora;?></td>
						  <td align='left'><?php echo ucwords(strtolower($NomOperador));?></td>
						  <td align='left'><?php echo ucwords(strtolower($Fila["Prod"]));?></td>
						  <td align='left'><?php echo ucwords(strtolower($Fila["SubProd"]));?></td>
						  <td align='left'><?php echo $Fila["patente"];?></td>
						  <td align='right'><?php echo $Fila["guia_despacho"];?></td>
						  <td align='right'><?php echo number_format($Fila["peso_bruto"],0,',','.');?></td>
						  <td align='right'><?php echo number_format($Fila["peso_sec"],0,',','.');?></td>
						  <td align='right'><?php echo $Fila["peso_control"];?></td>
						  <td align='right'><?php echo $Fila["diferencia"];?></td>
						  <?php
						  if($Fila["operacion_realizada"]=='C')
						  {
						  ?>
						  	  <td align='right'>PESAJE CANCELADO</td>
						  <?php
						  }
						  else
						  {
						  ?>	  
						  	 <td align='right'>PESAJE ACEPTADO</td>
						  <?php
						  }
						  ?>
						  
						</tr>
						<?php
					}					
				}	
			?>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
