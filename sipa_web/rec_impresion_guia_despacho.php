<?php
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	include("../principal/conectar_principal.php");
	include("funciones.php");
	include("../principal/funciones/class.ezpdf.php");

	$FechaHora = date("Y-m-d h:i");
	$FechaHora1 = date("d-m-Y h:i");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$RutProved = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$NombreProved = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";


	$pdf = new Cezpdf('a4');
    $pdf->SELECTFont('../principal/funciones/fonts/Helvetica.afm');
	$Datos=explode('//',$Valores);
	foreach($Datos as $c => $v)
	{
		$Corr=$v;
		if (isset($Corr))
		{
			$Consulta = "SELECT t1.transportista,t1.lote,t1.recargo,t1.correlativo,t1.bascula_entrada , t1.bascula_salida, t1.rut_operador, t1.lote, t1.correlativo, t1.peso_bruto, ";
			$Consulta.= "t1.hora_entrada , t1.fecha, t1.recargo, t1.ult_registro, t1.peso_tara, t1.hora_salida, t1.peso_neto, t1.rut_prv, t3.nombre_prv, ";
			$Consulta.= "t1.cod_producto, t1.cod_subproducto, t5.descripcion as nom_subproducto,t1.nombre_chofer,t1.rut_chofer,num_sello,t1.observacion, ";
			$Consulta.= "t1.observacion, t1.patente, t1.guia_despacho,t6.nombre_subclase as tipo_despacho ";
			$Consulta.= "from sipa_web.despachos t1 ";
			$Consulta.= "left join proyecto_modernizacion.subproducto t5 on t1.cod_producto=t5.cod_producto and t1.cod_subproducto=t5.cod_subproducto ";
			$Consulta.= "left join proyecto_modernizacion.sub_clase t6 on t6.valor_subclase1= t1.cod_despacho ";
			$Consulta.= "left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv ";
			 
			$Consulta.= "where correlativo='".$Corr."'";
			//echo $Consulta;
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$RutProved = $Fila["rut_prv"];
	        $NombreProved = $Fila["nombre_prv"];

			$NombreProved = ObtenerProveedorDespacho('D',$Fila["rut_prv"],$Fila["correlativo"],$Fila["guia_despacho"],$RutProved,$NombreProved,$link);
			$NomProv = $NombreProved;
			
			
			/*pdf_begin_page($g, 612,793);
			pdf_translate($g, 0,793);
			pdf_set_font($g,$TipoLetra, 18,"host", 0 );
			pdf_set_font($g,$TipoLetra2, 10,"host", 0 );
			pdf_show_xy($g,strtoupper(nl2br($NomProv)),70,-70);*/
			$pdf->addTextWrap(45,765,350,11,strtoupper(nl2br($NomProv)),$justification='left',0,0);
			
			$Consulta = "SELECT * from sipa_web.proveedores where rut_prv='".$Fila["rut_prv"]."'";
			$RespDirec=mysqli_query($link, $Consulta);
			if($FilaDirec=mysqli_fetch_array($RespDirec))
				//pdf_show_xy($g,strtoupper($FilaDirec["direccion"]),70,-85);
				$pdf->addTextWrap(45,750,350,11,strtoupper($FilaDirec["direccion"]),$justification='left',0,0);	
			else
				//pdf_show_xy($g,"",70,-85);
				$pdf->addTextWrap(45,750,150,11,"",$justification='left',0,0);
			$pdf->addTextWrap(325,730,150,12,"Ventanas ".substr($Fila["fecha"],8,2),$justification='left',0,0);
			$pdf->addTextWrap(425,730,150,12,$meses[substr($Fila["fecha"],5,2)-1],$justification='left',0,0);
			$pdf->addTextWrap(490,730,150,12,substr($Fila["fecha"],0,4),$justification='left',0,0);
			$pdf->addTextWrap(35,720,150,11,"RUT : ".$Fila["rut_prv"],$justification='left',0,0);
			$pdf->addTextWrap(230,585,350,13,$Fila["nom_subproducto"],$justification='left',0,0);
			$pdf->addTextWrap(230,553,150,13,"LOTE: ".$Fila["lote"],$justification='left',0,0);
			$pdf->addTextWrap(230,523,150,13,"RECARGO: ".$Fila["recargo"],$justification='left',0,0);
			$pdf->addTextWrap(230,492,150,13,"N� SELLO: ".$Fila["num_sello"],$justification='left',0,0);
			$pdf->addTextWrap(230,461,150,13,$Fila["observacion"],$justification='left',0,0);
			$pdf->addTextWrap(55,170,150,13,$Fila["nombre_chofer"],$justification='left',0,0);
			$pdf->addTextWrap(60,160,150,13,$Fila["rut_chofer"],$justification='left',0,0);
			$pdf->addTextWrap(120,156,150,13,$Fila["registro"],$justification='left',0,0);
			$pdf->addTextWrap(55,144,150,13,$Fila["direccion"],$justification='left',0,0);
			$pdf->addTextWrap(380,170,150,13,$Fila["transportista"],$justification='left',0,0);
			$pdf->addTextWrap(380,168,150,13,$Fila["marca"],$justification='left',0,0);
			$pdf->addTextWrap(378,156,150,11,$Fila["patente"],$justification='left',0,0);
			$pdf->addTextWrap(410,144,150,12,$Fila["peso_bruto"],$justification='left',0,0);
			$pdf->addTextWrap(410,130,150,12,$Fila["peso_tara"],$justification='left',0,0);
			$pdf->addTextWrap(410,117,150,12,$Fila["peso_neto"],$justification='left',0,0);
			$pdf->addTextWrap(370,75,150,12,$Fila["marca"],$justification='left',0,0);
			
			
			/*
			pdf_show_xy($g,strtoupper($Fila[nombre_chofer]),77,-630);
			pdf_show_xy($g,strtoupper($Fila["rut_chofer"]),80,-644);
			pdf_show_xy($g,strtoupper($Fila[registro]),130,-646);
			pdf_show_xy($g,strtoupper($Fila["direccion"]),75,-658);
			pdf_show_xy($g,strtoupper($Fila[transportista]),380,-630);
			pdf_show_xy($g,strtoupper($Fila["marca"]),380,-634);
			pdf_show_xy($g,strtoupper($Fila["patente"]),380,-646);
			pdf_set_font($g,$TipoLetra2, 12,"host", 0 );
		    pdf_show_xy($g,$Fila["peso_bruto"],410,-658);
		    pdf_show_xy($g,$Fila["peso_tara"],410,-673);
		    pdf_show_xy($g,$Fila["peso_neto"],410,-686);           						  
		    pdf_set_font($g,$TipoLetra2, 10,"host", 0 );
			pdf_show_xy($g,strtoupper($Fila["marca"]),380,-634);
			pdf_end_page($g);*/
			$Corr=substr($Corr,$i+2);
			$i=0;
		}
	}
	$pdf->ezStream();
	$pdf->Output();	
?>