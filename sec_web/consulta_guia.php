<?php
	include("../principal/conectar_sec_web.php"); 
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$rut = $CookieRut;
?>
<html>
<head>
<script language="JavaScript">
function salir()
{
	window.close();
}
function detalle():
{
}
</script>

<title>Consulta Guia</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="guias" method="post" action="">
  <table width="735" height="175" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="730">
	  	<table width="730" border="0" cellspacing="0" cellpadding="3" bordercolor="#b26c4a" class="TablaDetalle" >
          <tr class="ColorTabla01"> 
            <td width="60" height="18">Num Guia</td>
			<td width="30">Fecha Guia</td>
            <td width="50">Chofer</td>
            <td width="40">Patente</td>
            <td width="60">Transportista</td>
            <td width="40">Peso Guia</td>
            <td width="60">Otros Destinos</td>
		
          </tr>
        </table>
		<br>
		<?php
		echo "<table width='720' border='1'cellpadding='3' cellspacing='0'>";
		
		$consulta="SELECT * from sec_web.guia_despacho_emb where corr_enm ='".$ie."' and num_envio ='".$envio."' and  cod_bulto = '".$cod_lote."' and num_bulto ='".$num_lote."'";
		$respuesta = mysqli_query($link, $consulta);
		while ($fila=mysqli_fetch_array($respuesta))
		{
			echo"<td width='50'>".$fila['num_guia']."&nbsp;>"; 
		}
	
		echo "<input name ='checkbox' type='hidden'</input>";
		
		
		?> 
		<table width="720" border="0" class="TablaInterior">
			<tr>
				
            <td height="22" align="center"> 
              <input name="Detalle" type="button" id="Detalle" style="width:60" onClick="detalle();" value="Detalle">
              <input name="Salir" type="submit" style="width:60" id="Salir" value="Salir" onClick="salir();"> 
            </td>
			</tr>
		</table>	
			
		
      </td>
    </tr>
  </table>
</form>

</body>
</html>
