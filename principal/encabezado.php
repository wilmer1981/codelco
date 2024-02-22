<?php
	include("../principal/conectar_index.php");

	$TituloPagina='';
	if ((isset($CodigoDeSistema)) && (isset($CodigoDePantalla)))
	{
		$Consulta = "SELECT * from proyecto_modernizacion.pantallas where cod_sistema = '".$CodigoDeSistema."' and cod_pantalla = '".$CodigoDePantalla."' ";
		//echo $Consulta;
		
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
	//include("../principal/cerrar_principal.php");
?>
  <TABLE width=770 height="48" border=0 cellPadding=0 cellSpacing=0>
      <TR> 
        <td valign="top"><table width="770" height="45" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="385" align="center" valign="middle" background="../principal/imagenes/cab_sis_
			<?php
				
				switch ($CodigoDeSistema)
				{
					case "24":
						switch ($CodigoDePantalla)
						{
							case 3: //RECEPCION
								echo $NumSistema."_R"; 
								break;
							case 4: //DESPACHO
								echo $NumSistema."_D";
								break;
							case 5: //OTROS PESAJES
								echo $NumSistema."_O"; 
								break;
							case 16: //OTROS PESAJES
								echo $NumSistema."_C"; 
								break;

							default:
								echo $NumSistema; 
								break;
						}
						break;
					default:
						echo $NumSistema; 
						break;
				}	
			?>.jpg">&nbsp;</td>
          <td width="385" height="45" background="../principal/imagenes/cab_sis_der.jpg"><font class="Cabecera"><strong>Fecha:</strong> 
            <?php
			echo date("d")."-".date("m")."-".date("Y");
			?>
            </font><br>
            <font class="Cabecera"><strong><?php echo $TituloPagina; ?></strong></font></td>
        </tr>
      </table></td>
      </TR>
  </TABLE>