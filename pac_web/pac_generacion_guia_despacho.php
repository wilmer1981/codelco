<?php
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	include("../principal/conectar_pac_web.php");
	$FechaHora = date("Y-m-d h:i");
	$FechaHora1 = date("d-m-Y h:i");
	$Rut =$CookieRut;
	include("../principal/funciones/class.ezpdf.php");
	$pdf = new Cezpdf('a4');
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
			$pdf->addTextWrap(0,830,350,16,"CORPORACION NACIONAL DEL COBRE",$justification='left',0,0);
			$pdf->addTextWrap(0,820,350,11,"GIRO:MINERIA",$justification='left',0,0);
			$pdf->addTextWrap(0,810,350,11,"HUERFANOS 1270 -FONOS:9999998-99999999",$justification='left',0,0);
			$pdf->addTextWrap(0,800,350,11,"CASILLA 999-D",$justification='left',0,0);
			$pdf->addTextWrap(0,790,350,11,"SANTIAGO CENTRO",$justification='left',0,0);
			$pdf->rectangle(350,715, 245,125);
			$pdf->addTextWrap(350,800,245,20,"R.U.T.:61.704.000 - K",$justification='center',0,0);
			$pdf->addTextWrap(350,770,245,20,"GUIA DE DESPACHO",$justification='center',0,0);
			$pdf->addTextWrap(350,740,245,20,"N° ".$NumGuia,$justification='center',0,0);
			$pdf->addTextWrap(350,700,245,14,"S.I.I.- SANTIAGO CENTRO",$justification='center',0,0);
			$pdf->selectFont('../principal/funciones/fonts/Helvetica-Bold.afm');
			$pdf->addTextWrap(0,750,140,28,"CODELCO",$justification='left',0,0);
			$pdf->selectFont('../principal/funciones/fonts/Helvetica.afm');
			$pdf->rectangle(5,35, 590,575);
			$pdf->rectangle(5,195, 70,415);
			$pdf->rectangle(75,195, 70,415);
			$pdf->rectangle(145,195, 100,415);
			$pdf->rectangle(245,195, 240,415);
			$pdf->rectangle(485,195, 240,415);
			$pdf->line(5,580, 595,580);
			$pdf->line(5,145, 595,145);
			$pdf->addTextWrap(0,695,350,10,"SE�OR(ES)",$justification='left',0,0);
			$pdf->addTextWrap(45,680,350,11,strtoupper(nl2br($Fila[cliente])),$justification='left',0,0);
			$pdf->addTextWrap(45,665,350,11,strtoupper($Fila[direc_cliente].", ".$Fila["ciudad"]),$justification='left',0,0);
			
			if ($Fila["tipo_guia"]=='C')//SOLO SI ES CAMION MUESTRA LA FECHA
			{
				$pdf->addTextWrap(430,665,50,12,substr($Fila["fecha_hora"],8,2),$justification='left',0,0);
				$pdf->addTextWrap(460,665,80,12,$meses[substr($Fila["fecha_hora"],5,2)-1],$justification='left',0,0);
				$pdf->addTextWrap(535,665,50,12,"DE",$justification='left',0,0);
				$pdf->addTextWrap(569,665,50,12,substr($Fila["fecha_hora"],0,4),$justification='left',0,0);
			}
			$pdf->addTextWrap(0,635,150,11,"RUT : ".$Fila[rut_cliente],$justification='left',0,0);	
			$pdf->addTextWrap(0,625,250,11,"MUY SE�OR(ES) NUESTROS(S)",$justification='left',0,0);	
			$pdf->addTextWrap(0,615,450,11,"CON ESTA FECHA LE(S) ESTAMOS ENVIANDO LO QUE A CONTINUACION SE INDICA:",$justification='left',0,0);	
			$pdf->addTextWrap(15,590,50,9,"DOCTO.",$justification='center',0,0);
			$pdf->addTextWrap(75,590,60,9,"N�",$justification='center',0,0);
			$pdf->addTextWrap(140,590,120,9,"CANTIDAD",$justification='center',0,0);
			$pdf->addTextWrap(200,590,320,9,"DESCRIPCION",$justification='center',0,0);
			$pdf->addTextWrap(480,590,120,9,"VALOR UNITARIO",$justification='center',0,0);	
			
			if ($Fila["tipo_guia"]=='C')//SOLO SI ES CAMION MUESTRA TONELADAS
			{
			    $toneladas=number_format($Fila[toneladas],2);
				$pdf->addTextWrap(190,550,150,12,number_format($Fila[toneladas],2),$justification='left',0,0);
			}
			$Descripcion=nl2br($Fila["descripcion"]);
			$Detalle=explode('<br',$Descripcion);
			$Pos=550;
			while (list($Clave,$Valor)=each($Detalle))
			{
				$PosAux=$Pos;
				if (strlen($Valor)<40)
				{
					if(substr($Valor,0,3)==' />')
						$pdf->addText(255,$PosAux,11,trim(strtoupper(substr($Valor,4))),0,0);
					else
						$pdf->addText(255,$PosAux,11,strtoupper($Valor),0,0);
					$Pos=$Pos-15;
				}
				else
				{
					if(substr($Valor,0,3)==' />')
						$pdf->addText(255,$PosAux,11,trim(strtoupper(substr($Valor,4,40))),0,0);
					else
						$pdf->addText(255,$PosAux,11,trim(strtoupper(substr($Valor,0,40))),0,0);	
					$Pos=$Pos-15;
				}	
			}
			$pdf->addTextWrap(540,550,150,12,"US$ ".$Fila[valor_unitario],$justification='left',0,0);
			$Consulta="select * from pac_web.parametros where codigo='17'";
			$RespEncargado=mysqli_query($link, $Consulta);
			if($FilaEncargado=mysqli_fetch_array($RespEncargado))
			{
				$pdf->addTextWrap(5,380,200,11,strtoupper($FilaEncargado[valor1]),$justification='center',0,0);
				$pdf->addTextWrap(5,365,200,11,$FilaEncargado["nombre"],$justification='center',0,0);
			}
			$pdf->addTextWrap(10,170,200,9,"IDENTIFICACION",$justification='left',0,0);
			$pdf->addTextWrap(10,160,200,9,"DEL CONDUCTOR",$justification='left',0,0);
			$pdf->addTextWrap(310,170,200,9,"IDENTIFICACION",$justification='left',0,0);
			$pdf->addTextWrap(310,160,200,9,"DEL VEHICULO",$justification='left',0,0);
			$pdf->addTextWrap(40,175,200,9,"CODELCO",$justification='right',0,0);
			$pdf->addTextWrap(40,155,200,9,"PARTICULAR",$justification='right',0,0);
			$pdf->addTextWrap(300,175,200,9,"CODELCO",$justification='right',0,0);
			$pdf->addTextWrap(300,155,200,9,"PARTICULAR",$justification='right',0,0);
			$pdf->rectangle(255,170, 45,15);
			$pdf->rectangle(255,150, 45,15);
			$pdf->rectangle(515,170, 45,15);
			$pdf->rectangle(515,150, 45,15);
			$pdf->addTextWrap(10,120,200,9,"NOMBRE",$justification='left',0,0);
			$pdf->addTextWrap(10,105,200,9,"C.IDENTIDAD",$justification='left',0,0);
			$pdf->addTextWrap(10,90,200,9,"REG.NAC.CONDUCTORES N�",$justification='left',0,0);
			$pdf->addTextWrap(10,75,200,9,"DOMICILIO",$justification='left',0,0);
			$pdf->addTextWrap(300,120,200,9,"PROPIETARIO",$justification='left',0,0);
			$pdf->addTextWrap(300,105,200,9,"MARCA",$justification='left',0,0);
			$pdf->addTextWrap(300,90,200,9,"PATENTE",$justification='left',0,0);					
			$pdf->addTextWrap(300,75,200,9,"PESO BRUTO",$justification='left',0,0);
			$pdf->addTextWrap(300,60,200,9,"TARA",$justification='left',0,0);
			$pdf->addTextWrap(300,45,200,9,"CARGA",$justification='left',0,0);
			$pdf->line(110,50, 250,50);
			$pdf->addTextWrap(170,40,100,9,"FIRMA",$justification='left',0,0);
										
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
						$pdf->addTextWrap(270,175,200,11,"XX",$justification='left',0,0);
					else
						$pdf->addTextWrap(270,153,200,11,"XX",$justification='left',0,0);
					if ($Fila[tipo2]=='E')
						$pdf->addTextWrap(532,175,200,11,"XX",$justification='left',0,0);
					else
						$pdf->addTextWrap(532,153,200,11,"XX",$justification='left',0,0);
					$pdf->addTextWrap(60,120,200,9,strtoupper($Fila[chofer]),$justification='left',0,0);
					$pdf->addTextWrap(85,105,200,9,strtoupper($Fila[rut_chofer]),$justification='left',0,0);
					$pdf->addTextWrap(145,90,200,9,strtoupper($Fila[registro]),$justification='left',0,0);
					$pdf->addTextWrap(60,75,200,9,strtoupper($Fila[direccion]),$justification='left',0,0);
					$pdf->addTextWrap(370,120,200,9,strtoupper($Fila[transportista]),$justification='left',0,0);
					$pdf->addTextWrap(370,105,200,9,strtoupper($Fila[marca]),$justification='left',0,0);
					$pdf->addTextWrap(370,90,200,9,strtoupper($Fila["nro_patente"]),$justification='left',0,0);					
					if (($Fila[tipo2]=='P') and ($FechaRomana<>'0000-00-00') and ($HoraRomana<>'00:00:00'))
					{
						$pdf->addTextWrap(380,75,50,9,number_format(($Fila2[peso_bruto]/1000),2),$justification='right',0,0);	
						$pdf->addTextWrap(380,60,50,9,number_format(($Fila2["peso_tara"]/1000),2),$justification='right',0,0);	
						$pdf->addTextWrap(380,45,50,9,number_format(($Fila2[peso_neto]/1000),2),$justification='right',0,0);	
					}
					else if (($Fila[tipo2]=='P') and($FechaRomana=='0000-00-00') and ($HoraRomana=='00:00:00'))
							  {
							 
							   $Fila2["peso_tara"]= number_format(($Fila2["peso_tara"]/1000),2);
								$pdf->addTextWrap(380,75,50,9,number_format($Fila2["peso_tara"]+$Fila[toneladas],2),$justification='right',0,0);	
								$pdf->addTextWrap(380,60,50,9,number_format(($Fila2["peso_tara"]/1000),2),$justification='right',0,0);	
								$pdf->addTextWrap(380,45,50,9,number_format(($Fila[toneladas]/1000),2),$justification='right',0,0);	
							  }
					else 
					{
						$pdf->addTextWrap(380,75,50,9,number_format($Fila[tara]+$Fila[toneladas],2),$justification='right',0,0);	
						$pdf->addTextWrap(380,60,50,9,number_format($Fila[tara],2),$justification='right',0,0);	
						$pdf->addTextWrap(380,45,50,9,number_format($Fila[toneladas],2),$justification='right',0,0);	
					}
			}
			else
			{
				if ($Fila[tipo2]=='E')
					$pdf->addTextWrap(230,175,200,9,"XX",$justification='left',0,0);
				else
					$pdf->addTextWrap(230,153,200,9,"XX",$justification='left',0,0);
				if ($Fila[tipo2]=='E')
					$pdf->addTextWrap(532,175,200,9,"XX",$justification='left',0,0);
				else
					$pdf->addTextWrap(532,153,200,9,"XX",$justification='left',0,0);
				$pdf->addTextWrap(370,120,200,9,strtoupper($Fila[transportista]),$justification='left',0,0);
				$pdf->addTextWrap(370,105,200,9,strtoupper($Fila[marca]),$justification='left',0,0);				
			}
			$pdf->addTextWrap(5,15,200,9,"RECIBI CONFORME OFICINA RECEPTORA:",$justification='left',0,0);
			$pdf->line(190,15, 595,15);							
			$NumGuias=substr($NumGuias,$i+2);
			$i=0;
		}
	}
	
	$pdf->ezStream();
	$pdf->Output();		
?>