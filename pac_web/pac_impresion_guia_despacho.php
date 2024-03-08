<?php
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	include("../principal/conectar_pac_web.php");
	$FechaHora = date("Y-m-d h:i");
	$FechaHora1 = date("d-m-Y h:i");
	$Rut =$CookieRut;
	include("../principal/funciones/class.ezpdf.php");
	$pdf =& new Cezpdf('a4');
    $pdf->selectFont('../principal/funciones/fonts/Helvetica.afm');
	$NumGuias=$Valores;
	for ($i=0;$i<=strlen($NumGuias);$i++)
	{
		if (substr($NumGuias,$i,2)=='//')
		{
			$NumGuia=substr($NumGuias,0,$i);
			$Consulta ="select t1.rut_cliente,t1.fecha_hora,t1.num_guia,t1.nro_patente,t2.nombre as transportista,t5.tipo2,t1.volumen_m3,t1.toneladas,t1.nro_patente,t5.marca,t5.tara,t5.carga,";
			$Consulta.="t1.descripcion,t1.valor_unitario,t1.fecha_hora_romana,t3.nombre as cliente,t3.direccion as direc_cliente,t4.direccion,t3.ciudad,t4.nombre as chofer,t4.rut_chofer,t4.direccion,t4.registro,t4.tipo,t5.tipo2,t1.tipo_guia ";
			$Consulta.="from pac_web.guia_despacho t1 left join pac_web.transportista t2 on t1.rut_transportista = t2.rut_transportista ";
			$Consulta.="left join pac_web.clientes t3 on t1.rut_cliente = t3.rut_cliente ";
			$Consulta.="left join pac_web.choferes t4 on t1.rut_transportista = t4.rut_transportista and t1.rut_chofer=t4.rut_chofer ";
			$Consulta.="left join pac_web.camiones_por_transportista t5 on t1.rut_transportista = t5.rut_transportista and t1.nro_patente =t5.nro_patente where t1.num_guia='".$NumGuia."'";
			//echo $Consulta;
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$pdf->addTextWrap(45,765,350,11,strtoupper(nl2br($Fila[cliente])),$justification='left',0,0);
			$pdf->addTextWrap(45,750,350,11,strtoupper($Fila[direc_cliente].", ".$Fila["ciudad"]),$justification='left',0,0);
			if ($Fila["tipo_guia"]=='C')//SOLO SI ES CAMION MUESTRA LA FECHA
			{
				$pdf->addTextWrap(430,747,50,12,substr($Fila["fecha_hora"],8,2),$justification='left',0,0);
				$pdf->addTextWrap(460,747,80,12,$meses[substr($Fila["fecha_hora"],5,2)-1],$justification='left',0,0);
				$pdf->addTextWrap(569,747,50,12,substr($Fila["fecha_hora"],0,4),$justification='left',0,0);
			}
			$pdf->addTextWrap(0,720,150,11,"RUT : ".$Fila[rut_cliente],$justification='left',0,0);	
			if ($Fila["tipo_guia"]=='C')//SOLO SI ES CAMION MUESTRA TONELADAS
			{
			    $toneladas=number_format($Fila[toneladas],2);
				$pdf->addTextWrap(160,618,150,12,number_format($Fila[toneladas],2),$justification='left',0,0);
			}
			$Descripcion=nl2br($Fila["descripcion"]);
			$Detalle=explode('<br',$Descripcion);
			$Pos=618;
			while (list($Clave,$Valor)=each($Detalle))
			{
				$PosAux=$Pos;
				if (strlen($Valor)<40)
				{
					if(substr($Valor,0,3)==' />')
						$pdf->addText(225,$PosAux,11,trim(strtoupper(substr($Valor,4))),0,0);
					else
						$pdf->addText(225,$PosAux,11,strtoupper($Valor),0,0);
					$Pos=$Pos-15;
				}
				else
				{
					if(substr($Valor,0,3)==' />')
						$pdf->addText(225,$PosAux,11,trim(strtoupper(substr($Valor,4,40))),0,0);
					else
						$pdf->addText(225,$PosAux,11,trim(strtoupper(substr($Valor,0,40))),0,0);	
					$Pos=$Pos-15;
				}	
			}
			$pdf->addTextWrap(540,618,150,12,"US$ ".$Fila[valor_unitario],$justification='left',0,0);
			$Consulta="select * from pac_web.parametros where codigo='17'";
			$RespEncargado=mysqli_query($link, $Consulta);
			if($FilaEncargado=mysqli_fetch_array($RespEncargado))
			{
				$pdf->addTextWrap(5,420,200,11,strtoupper($FilaEncargado[valor1]),$justification='center',0,0);
				$pdf->addTextWrap(5,405,200,11,$FilaEncargado["nombre"],$justification='center',0,0);
			}
			if ($Fila["tipo_guia"]=='C')//SOLO SI ES CAMION MUESTRA DATOS
			{
				$FechaRomana=substr($Fila[fecha_hora_romana],0,10);
				$HoraRomana=substr($Fila[fecha_hora_romana],11,8);
				if (($FechaRomana<>'0000-00-00') and ($HoraRomana<>'00:00:00'))
		        {
					$Consulta="select peso_bruto,peso_tara,peso_neto from sipa_web.despachos where patente='".$Fila["nro_patente"]."' and fecha='".$FechaRomana."' and hora_entrada='".$HoraRomana."'";
				}
				else 
				{
					$consulta_fecha="select max(fecha) as fecha from sipa_web.despachos where patente='".$Fila["nro_patente"]."'";
					$Respfecha=mysqli_query($link, $consulta_fecha);
					$Fila_fecha=mysqli_fetch_array($Respfecha);
					//echo $consulta_fecha;
					$Consulta="select peso_bruto,peso_tara,peso_neto from sipa_web.despachos where patente='".$Fila["nro_patente"]."' and fecha='".$Fila_fecha["fecha"]."' ";}
					$RespPesaje=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($RespPesaje);
					if ($Fila[tipo2]=='E')
					{
						$pdf->addTextWrap(230,250,200,11,"XX",$justification='left',0,0);
						//pdf_show_xy($g,"XX",248,-570);
					}
					else
					{
						$pdf->addTextWrap(230,218,200,11,"XX",$justification='left',0,0);
						//pdf_show_xy($g,"XX",248,-590);
					}
					if ($Fila[tipo2]=='E')
					{
						$pdf->addTextWrap(552,250,200,11,"XX",$justification='left',0,0);
						//pdf_show_xy($g,"XX",550,-570);
					}
					else
					{
						$pdf->addTextWrap(552,218,200,11,"XX",$justification='left',0,0);
						//pdf_show_xy($g,"XX",550,-590);
					}
					$pdf->addTextWrap(50,185,200,11,strtoupper($Fila[chofer]),$justification='left',0,0);
					$pdf->addTextWrap(55,170,200,11,strtoupper($Fila[rut_chofer]),$justification='left',0,0);
					$pdf->addTextWrap(100,157,200,11,strtoupper($Fila[registro]),$justification='left',0,0);
					$pdf->addTextWrap(50,143,200,11,strtoupper($Fila["direccion"]),$justification='left',0,0);
					$pdf->addTextWrap(370,185,200,11,strtoupper($Fila[transportista]),$justification='left',0,0);
					$pdf->addTextWrap(370,170,200,11,strtoupper($Fila[marca]),$justification='left',0,0);
					$pdf->addTextWrap(370,157,200,11,strtoupper($Fila["nro_patente"]),$justification='left',0,0);					
					/*pdf_show_xy($g,strtoupper($Fila[chofer]),77,-620);
					pdf_show_xy($g,strtoupper($Fila[rut_chofer]),80,-634);
					pdf_show_xy($g,strtoupper($Fila[registro]),130,-646);
					pdf_show_xy($g,strtoupper($Fila["direccion"]),75,-658);
					pdf_show_xy($g,strtoupper($Fila[transportista]),380,-620);
					pdf_show_xy($g,strtoupper($Fila[marca]),380,-634);
					pdf_show_xy($g,strtoupper($Fila["nro_patente"]),380,-646);
					pdf_set_font($g,$TipoLetra2, 12,"host", 0 );*/
					if (($Fila[tipo2]=='P') and ($FechaRomana<>'0000-00-00') and ($HoraRomana<>'00:00:00'))
					{
						$pdf->addTextWrap(380,145,50,11,number_format(($Fila2[peso_bruto]/1000),2),$justification='right',0,0);	
						$pdf->addTextWrap(380,130,50,11,number_format(($Fila2["peso_tara"]/1000),2),$justification='right',0,0);	
						$pdf->addTextWrap(380,115,50,11,number_format(($Fila2[peso_neto]/1000),2),$justification='right',0,0);	
						//pdf_show_xy($g,number_format(($Fila2[peso_bruto]/1000),2),410,-658);
						//pdf_show_xy($g,number_format(($Fila2["peso_tara"]/1000),2),410,-673);
						//pdf_show_xy($g,number_format(($Fila2[peso_neto]/1000),2),410,-686);
					}
					else if (($Fila[tipo2]=='P') and($FechaRomana=='0000-00-00') and ($HoraRomana=='00:00:00'))
							  {
							 
							   $Fila2["peso_tara"]= number_format(($Fila2["peso_tara"]/1000),2);
								$pdf->addTextWrap(380,145,50,11,number_format($Fila2["peso_tara"]+$Fila[toneladas],2),$justification='right',0,0);	
								$pdf->addTextWrap(380,130,50,11,number_format(($Fila2["peso_tara"]/1000),2),$justification='right',0,0);	
								$pdf->addTextWrap(380,115,50,11,number_format(($Fila[toneladas]/1000),2),$justification='right',0,0);	
							   
							   //pdf_show_xy($g,number_format($Fila2["peso_tara"]+$Fila[toneladas],2),410,-658);
							   //pdf_show_xy($g,number_format($Fila2["peso_tara"],2),410,-673);
							   //pdf_show_xy($g,number_format($Fila[toneladas],2),410,-686);           						  
							  
							  }
					else 
					{
						$pdf->addTextWrap(380,145,50,11,number_format($Fila[tara]+$Fila[toneladas],2),$justification='right',0,0);	
						$pdf->addTextWrap(380,130,50,11,number_format($Fila[tara],2),$justification='right',0,0);	
						$pdf->addTextWrap(380,115,50,11,number_format($Fila[toneladas],2),$justification='right',0,0);	

						//pdf_show_xy($g,number_format($Fila[tara]+$Fila[toneladas],2),410,-658);
						//pdf_show_xy($g,number_format($Fila[tara],2),410,-673);
						//pdf_show_xy($g,number_format($Fila[toneladas],2),410,-686);
					}
					//pdf_set_font($g,$TipoLetra2, 10,"host", 0 );
					//pdf_end_page($g);
			}
			else
			{
				if ($Fila[tipo2]=='E')
				{
					$pdf->addTextWrap(230,250,200,11,"XX",$justification='left',0,0);
					//pdf_show_xy($g,"XX",248,-570);
				}
				else
				{
					$pdf->addTextWrap(230,218,200,11,"XX",$justification='left',0,0);
					//pdf_show_xy($g,"XX",248,-590);
				}
				if ($Fila[tipo2]=='E')
				{
					$pdf->addTextWrap(552,250,200,11,"XX",$justification='left',0,0);
					//pdf_show_xy($g,"XX",550,-570);
				}
				else
				{
					$pdf->addTextWrap(552,218,200,11,"XX",$justification='left',0,0);
					//pdf_show_xy($g,"XX",550,-590);
				}
				$pdf->addTextWrap(370,185,200,11,strtoupper($Fila[transportista]),$justification='left',0,0);
				$pdf->addTextWrap(370,170,200,11,strtoupper($Fila[marca]),$justification='left',0,0);				
				/*pdf_show_xy($g,strtoupper($Fila[transportista]),380,-620);
				pdf_show_xy($g,strtoupper($Fila[marca]),380,-634);
				pdf_end_page($g);*/
			}							
			$NumGuias=substr($NumGuias,$i+2);
			$i=0;
		}
	}
	$pdf->ezStream();
	$pdf->Output();		
?>