<?php
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	include("../principal/conectar_pac_web.php");
	$FechaHora = date("Y-m-d h:i");
	$FechaHora1 = date("d-m-Y h:i");
	$Rut =$CookieRut;
	$TipoLetra='Helvetica';
	$TipoLetra2='Helvetica';
	$TipoLetra3='Helvetica-BoldOblique';
	$f = fopen("guia_despacho.pdf", "w");
	$g = pdf_open($f);
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
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			pdf_begin_page($g, 612,793);
			pdf_translate($g, 0,793);
			pdf_set_font($g,$TipoLetra, 18,"host", 0 );
			pdf_set_font($g,$TipoLetra2, 10,"host", 0 );
			pdf_show_xy($g,strtoupper(nl2br($Fila[cliente])),70,-70);
			pdf_show_xy($g,strtoupper($Fila[direc_cliente].", ".$Fila["ciudad"]),70,-85);
			pdf_set_font($g,$TipoLetra2, 12,"host", 0 );
			pdf_show_xy($g,substr($Fila["fecha_hora"],8,2),430,-87);
			pdf_show_xy($g,$meses[substr($Fila["fecha_hora"],5,2)-1],460,-87);
			pdf_show_xy($g,substr($Fila["fecha_hora"],0,4),565,-87);
			pdf_set_font($g,$TipoLetra2, 10,"host", 0 );
			pdf_show_xy($g,"RUT : ".$Fila[rut_cliente],0,-110);			
			pdf_set_font($g,$TipoLetra2, 10,"host", 0 );
			pdf_show_xy($g,number_format($Fila[toneladas],2),175,-210);
			$Descripcion=nl2br($Fila["descripcion"]);
			$Detalle=explode("<br>",$Descripcion);
			$Pos=210;
			while (list($Clave,$Valor)=each($Detalle))
			{
				if (strlen($Valor)<40)
				{
					$PosAux="-".$Pos;
					pdf_show_xy($g,strtoupper($Valor),240,$PosAux);
					$Pos=$Pos+15;
				}
				else
				{
					pdf_show_xy($g,strtoupper(substr($Valor,0,40)),240,-210);
				}	
			}
			
			/*$Descripcion='';
			$Pos=210;
			$Largo=strlen($Fila["descripcion"]);
			$Cont=0;
			for ($j=0;$j<=$Largo;$j++)
			{
				$Descripcion=$Descripcion.substr($Fila["descripcion"],$j,1);
				if ($Cont==40)
				{
					$PosAux="-".$Pos;
					pdf_show_xy($g,strtoupper($Descripcion),240,$PosAux);//MAX 45 CARACTERES POR LINEA
					$Pos=$Pos+15;
					$Descripcion='';
					$Cont=0;
				}
				$Cont++;
			}
			$PosAux="-".$Pos;			
			pdf_show_xy($g,strtoupper($Descripcion),240,$PosAux);//MAX 45 CARACTERES POR LINEA*/
			pdf_show_xy($g,"US$ ".$Fila[valor_unitario],535,-210);
			if ($Fila["tipo_guia"]=='C')//SOLO SI ES CAMION MUESTRA DATOS
			{
				$FechaRomana=substr($Fila[fecha_hora_romana],0,10);
				$HoraRomana=substr($Fila[fecha_hora_romana],11,8);
				$Consulta="select pesobr_a,pesotr_a,pesont_a from rec_web.otros_pesajes where patent_a='".$Fila["nro_patente"]."' and fecha_a='".$FechaRomana."' and hora_a='".$HoraRomana."'";
				$RespPesaje=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($RespPesaje);
				if ($Fila[tipo2]=='E')
				{
					pdf_show_xy($g,"XX",248,-570);
				}
				else
				{
					pdf_show_xy($g,"XX",248,-590);
				}
				if ($Fila[tipo2]=='E')
				{
					pdf_show_xy($g,"XX",550,-570);
				}
				else
				{
					pdf_show_xy($g,"XX",550,-590);
				}
				pdf_show_xy($g,strtoupper($Fila[chofer]),77,-620);
				pdf_show_xy($g,strtoupper($Fila[rut_chofer]),80,-634);
				pdf_show_xy($g,strtoupper($Fila[registro]),130,-646);
				pdf_show_xy($g,strtoupper($Fila["direccion"]),75,-658);
				pdf_show_xy($g,strtoupper($Fila[transportista]),380,-620);
				pdf_show_xy($g,strtoupper($Fila[marca]),380,-634);
				pdf_show_xy($g,strtoupper($Fila["nro_patente"]),380,-646);
				if ($Fila[tipo2]=='P')
				{
					pdf_show_xy($g,number_format(($Fila2[pesobr_a]/1000),2),410,-658);
					pdf_show_xy($g,number_format(($Fila2[pesotr_a]/1000),2),410,-673);
					pdf_show_xy($g,number_format(($Fila2[pesont_a]/1000),2),410,-684);
				}
				else
				{
					pdf_show_xy($g,number_format($Fila[tara]+$Fila[toneladas],2),410,-658);
					pdf_show_xy($g,number_format($Fila[tara],2),410,-673);
					pdf_show_xy($g,number_format($Fila[toneladas],2),410,-684);
				}
				pdf_end_page($g);
			}							
			$NumGuias=substr($NumGuias,$i+2);
			$i=0;
		}
	}
	pdf_close($g);
	header("location:guia_despacho.pdf");
?>