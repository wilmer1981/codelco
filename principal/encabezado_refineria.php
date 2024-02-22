<?php
	include("../principal/conectar_principal.php");
	if ((isset($CodigoDeSistema)) && (isset($CodigoDePantalla)))
	{
		$Consulta = "Select * from proyecto_modernizacion.pantallas where cod_sistema = ".$CodigoDeSistema." and cod_pantalla = ".$CodigoDePantalla;
		$Resultado = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Resultado))
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
  <TABLE width="100%" height="45" border=0 cellPadding=0 cellSpacing=0>
        <tr > 
          <td width="385" align="left"   valign="middle"><img src="../principal/imagenes/cab_sis_<?php echo $NumSistema; ?>.jpg"></td>
		  <td align="center" valign="middle"><img src="../principal/imagenes/medio_ref2.gif" width="100%" height="110%"></td>
           <td width="385" height="45" background="../principal/imagenes/cab_sis_der.jpg"><font class="Cabecera"><strong>Fecha:</strong> 
            <?php
			echo date("d")."-".date("m")."-".date("Y");
			?>
            </font><br>
            <font class="Cabecera"><strong><?php echo $TituloPagina;?></strong></font></td>
        </tr>
  </TABLE>