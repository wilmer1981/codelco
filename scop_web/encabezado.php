<?
	include("../principal/conectar_scop_web.php");
	if ((isset($CodigoDeSistema)) && (isset($CodigoDePantalla)))
	{
		$Consulta = "Select * from proyecto_modernizacion.pantallas where cod_sistema = ".$CodigoDeSistema." and cod_pantalla = ".$CodigoDePantalla;
		$Resultado = mysql_query($Consulta);
		if ($Row = mysql_fetch_array($Resultado))
		{
			$TituloPagina = ucwords(strtolower($Row["descripcion"]));
		}
		if (intval($CodigoDeSistema) < 10)
			$NumSistema = "0".$CodigoDeSistema;
		else	$NumSistema = $CodigoDeSistema;		
	}
	else
	{
		if (isset($CodigoDeSistema))
		{
			if (intval($CodigoDeSistema) < 10)
				$NumSistema = "0".$CodigoDeSistema;
			else	$NumSistema = $CodigoDeSistema;
		}
		else
		{
			$NumSistema = "00";
		}
	}
?>
  <TABLE height="48" border=0 cellPadding=0 cellSpacing=0 align="center">
      <TR> 
        <td valign="top">
		<table width="100%" height="45" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="586" height="45" background="archivos/cabecera_sistema_izq.png" align="left"></td>
		  <td width="384" height="45" background="archivos/cabecera_sistema_der.png" align="left"></td>
        </tr>
         </table></td>
	     </TR>
  </TABLE>