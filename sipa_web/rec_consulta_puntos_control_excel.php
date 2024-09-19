<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");	
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");	
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
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
<title>Consulta Puntos de Control Excel</title>
<?php
//echo '<link href="../principal/estilos/css_sipa_web.css" rel="stylesheet" type="text/css">';
?>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "S":
			f.action='rec_consulta_puntos_control.php';
			f.submit();
			//window.history.back();
		break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
  <table width="100%" height="330" border="1" cellpadding="0" cellspacing="0" left="5" >
    <tr>
          <table width="100%" border="1" cellpadding="2" cellspacing="1">
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
				$Buscar='S';
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
