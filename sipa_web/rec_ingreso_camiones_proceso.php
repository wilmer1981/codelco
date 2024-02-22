<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");
	$NombreBoton='Grabar';
	$Habilitar='';	
	if($Proceso=='M')
	{
		$NombreBoton='Modificar';
		$Habilitar='disabled';		
		$Datos2=explode('~~',$Valores);
		$TxtPatente=$Datos2[0];
		$CmbProveedor=$Datos2[1];
		$CmbMinaPrv=$Datos2[2];
		$CmbSubProducto=$Datos2[3];
		$TxtPromBr=$Datos2[4];
		$TxtPromTr=$Datos2[5];
	}
	
?>
<html>
<head>
<title>Proceso</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			f.action='rec_ingreso_camiones_proceso01.php?Proceso=N';
			f.submit();
			break;
		case 'M'://MODIFICAR
			f.action='rec_ingreso_camiones_proceso01.php?Proceso=M';
			f.submit();
			break;
		case 'S'://SALIR
			window.close();
			break;
	}
	
}
function Recarga(Tipo)
{
	var f = document.frmPrincipal;
	switch(Tipo)
	{
		case '1'://BUSCAR POR PATENTE
			f.action='rec_ingreso_camiones.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '2'://BUSCAR POR PROVEEDOR
			f.action='rec_ingreso_camiones_proceso.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '3'://BUSCAR POR PRODUCTO
			f.action='rec_ingreso_camiones.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '5'://BUSCAR TODOS
			f.action='rec_ingreso_camiones.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
	}
	f.submit();		
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="Valores" value="<?php echo $Valores;?>">
	    <table width="461" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td width="71" align="right">Patente:</td>
			<td width="375"><div align="left">
			  <input type="text" name="TxtPatente" size="15" value='<?php echo $TxtPatente;?>' <?php echo $Habilitar;?>>
			</div></td> 
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td height="28" align="right">Proveedor:</td>
			<td><div align="left">
			  <SELECT name="CmbProveedor" style="width:300" onChange="Recarga('2')" <?php echo $Habilitar;?>>
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "SELECT distinct RUTPRV_A,NOMPRV_A from sipa_web.proved t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rutprv_a=t2.rut_proveedor ";
				//$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				$Consulta.= " order by t1.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["RUTPRV_A"])
						echo "<option SELECTed value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>\n";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>\n";
				}
			?>
              </SELECT>
			</div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">SubProducto:
			</td>
            <td><div align="left">
              <SELECT name="CmbSubProducto" style="width:300" <?php echo $Habilitar;?>>
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "SELECT cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
              </SELECT>
            </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Mina:</td>
            <td align="left">
			<SELECT name="CmbMinaPrv" style="width:300" <?php echo $Habilitar;?>>
              <option class="NoSelec" value="S">Seleccionar</option>
              <?php
				$Consulta = "SELECT * ";
				$Consulta.= " from sipa_web.minaprv ";
				$Consulta.= " where RUTPRV_A='".$CmbProveedor."' ";
				$Consulta.= " order by NOMMIN_A ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbMinaPrv == $Fila["CODMIN_A"])
						echo "<option SELECTed value='".$Fila["CODMIN_A"]."'>".str_pad($Fila["CODMIN_A"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["NOMMIN_A"])."</option>\n";
					else
						echo "<option value='".$Fila["CODMIN_A"]."'>".str_pad($Fila["CODMIN_A"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["NOMMIN_A"])."</option>\n";
				}
			  ?>
            </SELECT>
			</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td>&nbsp;</td>
            <td align="left">Prom.Bruto
            <input name="TxtPromBr" type="text" size="10" value="<?php echo $TxtPromBr;?>" onKeyDown="TeclaPulsada(true)" >
            &nbsp;Kg.&nbsp;&nbsp;
            Prom.Tara
            <input name="TxtPromTr" type="text" size="10" value="<?php echo $TxtPromTr;?>" onKeyDown="TeclaPulsada(true)" > 
            Kg. </td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="2"><input name="BtnNuevo" type="button" style="width:70px;" value="<?php echo $NombreBoton;?>" onClick="Procesos('<?php echo $Proceso;?>')">
              <input name="BtnSalir" type="button" style="width:70px;" value="Salir" onClick="Procesos('S')"></td>
          </tr>
		 </table>
	    <br>
	    <br></td>
 </tr>
</table>
</form>
</body>
</html>