<?php
	include("../principal/conectar_principal.php"); 

$TipoRegistro = isset($_REQUEST["TipoRegistro"])?$_REQUEST["TipoRegistro"]:'';
$TxtValores   = isset($_REQUEST["TxtValores"])?$_REQUEST["TxtValores"]:'';
$Operacion    = isset($_REQUEST["Operacion"])?$_REQUEST["Operacion"]:'';
$EstOpe       = isset($_REQUEST["EstOpe"])?$_REQUEST["EstOpe"]:'';
$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:'';
$Proc         = isset($_REQUEST["Proc"])?$_REQUEST["Proc"]:'';



?>
<html>
<head>
<title>Sistema de Recepciones</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			if (f.TxtMotivo.value=='')
			{
				alert("No ha Ingresado Motivo");
				return;
			}
			f.action = "rec_cierre_lote_masivo_proceso01.php?Proceso="+f.Operacion.value;
			f.submit();
			break;
		case "S":
		    window.opener.document.frmPrincipal.action = 'rec_cierre_lote_masivo.php'
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Operacion" value="<?php echo $Operacion; ?>">
<input type="hidden" name="TipoRegistro" value="<?php echo $TipoRegistro; ?>">
<input type="hidden" name="TxtValores" value="<?php echo $TxtValores; ?>">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><strong>
	<?php
		switch($Operacion)
		{
			case "N":
				echo "CERRAR LOTE(S)";
				break;
			case "S":
				echo "ABRIR LOTE(S)";
				break;
		}
	
	?>
	</strong></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td width="109" class="Colum01">Lote(s):</td>
    <td width="376" class="Colum01">
	<?php 
	
	echo str_replace("//","; ",$TxtValores); 
	?></td>
    </tr>
  <tr class="ColorTabla02">
    <td colspan="2" class="Colum01">&nbsp;</td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">MOTIVO CIERRE </td>
    <td class="Colum01">      <span class="ColorTabla02">
      </span></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">&nbsp;</td>
    <td class="Colum01"><textarea name="TxtMotivo" id="TxtMotivo" cols="80" rows="5"></textarea></td>
  </tr>
  <tr align="center" class="Colum01">
    <td height="30" colspan="2" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar3" value="Grabar" style="width:70px " onClick="Proceso('G')">      
      <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
