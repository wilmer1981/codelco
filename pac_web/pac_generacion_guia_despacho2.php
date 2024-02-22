<?php
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
function FormatTexto($Texto,$MaxLen)
{
	if (strlen($Texto) < $MaxLen)
	{
		for ($i = strlen($Texto); $i <= $MaxLen; $i++)
		{
			$Texto = $Texto." ";
		}
	}
	else
	{
		$Texto = substr($Texto,0,$MaxLen);
	}
	return $Texto;
}

function FormatNumero($Texto,$MaxLen)
{
	if (strlen($Texto) < $MaxLen)
	{
		for ($i = strlen($Texto); $i <= $MaxLen; $i++)
		{
			$Texto = "0".$Texto;
		}
	}
	else
	{
		$Texto = substr($Texto,-$MaxLen);
	}
	return $Texto;
}

	include("../principal/conectar_pac_web.php");
	$FechaHora = date("Y-m-d h:i");
	$FechaHora1 = date("d-m-Y h:i");
	$Rut =$CookieRut;
	$TipoLetra='Helvetica-Bold';
	$f = fopen("guia_despacho.pdf", "w");
	$g = pdf_open($f);
	pdf_begin_page($g, 609, 790);
	pdf_translate($g, 0, 790);
	pdf_set_font($g,$TipoLetra, 16,"host", 0 );
	pdf_show_xy($g,"EMPRESA NACIONAL DE MINERIA",0,-9);
	pdf_rect($g, 370,-120, 235,120);
	pdf_end_page($g);						
	pdf_close($g);
	header("location:guia_despacho.pdf");
	
?>