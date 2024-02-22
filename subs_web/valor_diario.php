<?Php
	/********************** Establecer Codigos ***********/
	$CodigoDeSistema=19;
	$CodigoDePantalla=2;
?>
<!-------------------------------------- Inicio Html  -------------------------------------->
<html>
<head>
	<title>Calculo Subsidio e Incapacidad Laboral</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<Script languaje = "Javascript" src="funciones.js">/* Validador Puntitos */</script>
	<script language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!--- Salir --->
		function Salir ()
		// Funcion que me cierra la ventana
		{
			var f = document.form1;
			window.close();
		}
		<!--- InvisibleTextoMesAno --->		
		function InvisibleTextoMesAno()
		// Funcion que me permite colocar invisible los años y meses  (3 meses antes de las licencia)
		// para su futo traspaso de recarga de pagina
		{
			var f = document.form1;
			f.ano1.style.visibility='hidden';
			f.ano2.style.visibility='hidden';
			f.ano3.style.visibility='hidden';			
			f.mes1.style.visibility='hidden';
			f.mes2.style.visibility='hidden';
			f.mes3.style.visibility='hidden';			
		}
		<!------  Limpiar ----------->
		function Limpiar ()
		// Funcion que me Limpias los Campos de Ingreso para el calculo
		{
			var f = document.form1;
			f.dia1.value="";			
			f.dia2.value="";			
			f.dia3.value="";						
			f.imponible1.value="";			
			f.imponible2.value="";						
			f.imponible3.value="";									
		}
		<!------  PoPuPDetalle ----------->
		function PoPuPDetalle(fila, afecto, descuento)
		// Funcion  que me abre la ventana que me muestra el Imp. Unico de un mes dado
		{
			var f=document.form1;
			var ano="";
			var palabrames="";
			var valor_afecto=afecto;
			var rebaja =descuento;
			// Me ve que fila seleciono para ver el detalle
			switch (fila)
			{
				case "1":					
					ano=f.ano1.value;
					palabrames=f.mes1.value;
					break;
				
				case "2":				
					ano=f.ano2.value;
					palabrames=f.mes2.value;
					break;

				case "3":				
					ano=f.ano3.value;
					palabrames=f.mes3.value;
					break;
			}	
			//alert (valor_afecto);
			//alert (fila);
			window.open("detalle_iu.php?valor_afecto="+ valor_afecto + "&mes=" +palabrames+"&ano="+ano+"&rebaja="+rebaja,"detalle"," fullscreen=no,left=0,top=10,width=412,height=395,scrollbars=yes,resizable = no");					
		}
		<!------  Validar ----------->
		function Validar()
		// Funcion que me valida el ingreso de valores (dias, imponibles) no esten en blanco
		{
			var f = document.form1;
			var opc = "s";
			var msg_dias="Dias Trabajados en Blanco"
			var msg_impo="Imponibles en Blanco";
			switch (opc)
				{
					case "s":
						if (f.dia1.value=="")
						{
							alert(msg_dias);
							return('no_ok');
							break;		
						}
						if (f.dia2.value=="")
						{
							alert(msg_dias);
							return('no_ok');
							break;		
						}
						if (f.dia3.value=="")
						{
							alert(msg_dias);
							return('no_ok');
							break;		
						}
						if (f.imponible1.value=="")
						{
							alert(msg_impo);
							return('no_ok');
							break;		
						}
						if (f.imponible2.value=="")
						{
							alert(msg_impo);
							return('no_ok');
							break;		
						}
						if (f.imponible3.value=="")
						{
							alert(msg_impo);
							return('no_ok');
							break;		
						}
						
				}		
				return('ok');
		}
		<!------  Calcular ----------->
		function Calcular (dias_licencias, porc_afp, esfonasa, pac_uf, numfila, filaselec)
		// Funcion que me recarga la pagina para realizar los calculos
		{
            var f = document.form1;
			var tipod = "";			
			if (Validar()=='ok')
			{
				 tipod = f.tipod.value;
				f.action = "valor_diario.php?inicializa_var=n&opc_calcular=s&filaselec="+filaselec+"&numfila="+numfila+"&dias_licencias=" + dias_licencias + "&esfonasa=" + esfonasa + "&porc_afp=" + porc_afp + "&pac_uf=" + pac_uf  + "&tipod="+ tipod+"&dia1=" + f.dia1.value + "&dia2=" + f.dia2.value + "&dia3=" + f.dia3.value + "&imponible1=" + f.imponible1.value+ "&imponible2=" + f.imponible2.value+ "&imponible3=" + f.imponible3.value +"&mes1="+f.mes1.value+"&mes2="+f.mes2.value+"&mes3=" + f.mes3.value;
				f.submit();		 	
			}
		}
		<!------  Aceptar ----------->		
		function Aceptar(numfila, filaselec, total_a_pagar, porc_salud, valor_diario)
		// Funcion que me pasa el valor "total a pagar" al la pagina de licencias
		{
			var f=document.form1;
			if (Validar()=='ok')
			{
				window.close();
				window.opener.document.form1.action ="ing_trab.php?porc_salud="+porc_salud+"&opcion=AF&filasel="+filaselec+"&colocar_valor="+total_a_pagar+"&n="+numfila+"&valor_diario="+valor_diario;
				window.opener.document.form1.submit();			
			}
		}
		
		
		<!------  InhabilitarAcptVer ----------->
		function InhabilitarAcptVer ()
		// Funcion que me inhabilita el boton Acptar y las opciones de detalles
		{
			var f = document.form1;
			f.BtnAceptar.disabled=true;			
			f.opcdetalle[0].disabled=true;
			f.opcdetalle[1].disabled=true;
			f.opcdetalle[2].disabled=true;			
		}
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->			
	</script>
</head>
<!--------------------------- Cuerpo Principal  -------------------------------------------->
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
<?Php
    if ($inicializa_var == 's')// Si inicializas las variables
    {
		include("limpiavalores.php");
    }
/*******Formatear_Fecha************/
	include("funcion.php");
  	$Ano=$FechaDesde[6]."".$FechaDesde[7]."".$FechaDesde[8]."".$FechaDesde[9];
	$Mes=$FechaDesde[3]."".$FechaDesde[4];
	if($Mes >'03')
	{
	  $mes1 = sacarmestexto ($Mes-1);
	  $mes2 = sacarmestexto ($Mes-2);
	  $mes3 = sacarmestexto ($Mes-3);
	  $ano1=$Ano;
  	  $ano2=$Ano;
  	  $ano3=$Ano;
	}
	if($Mes =='01')
	{
	  $mes1 = sacarmestexto ('12');
	  $mes2 = sacarmestexto ('11');
	  $mes3 = sacarmestexto ('10');
	  $ano1=$Ano-1;
  	  $ano2=$Ano-1;
  	  $ano3=$Ano-1;
	}	  
	if($Mes =='02')
	{
	  $mes1 = sacarmestexto ('01');
	  $mes2 = sacarmestexto ('12');
	  $mes3 = sacarmestexto ('11');
  	  $ano1=$Ano;
  	  $ano2=$Ano-1;
  	  $ano3=$Ano-1;
	}
	if($Mes =='03')
	{
	  $mes1 = sacarmestexto ('02');
	  $mes2 = sacarmestexto ('01');
	  $mes3 = sacarmestexto ('12');
  	  $ano1=$Ano;
  	  $ano2=$Ano;
  	  $ano3=$Ano-1;
	}
	if ( $esfonasa == 's') { // Me quiere decir que es fonasa y no isapre		
		$porc_fonasa=$pac_uf;
	} else {
		$porc_fonasa="0,00";
	}
	//************ C A L C U L O ***********************//
	if ($opc_calcular =='s') 
	// Aca se procedera al calculo de Incapacidad laboral y subsidio
	{
		include("conectar.php"); //Conecto la BD SUBS_WEB
		//---------------------------------//
		$dia1 = str_replace('.','',$dia1);
		$dia2 = str_replace('.','',$dia2);
		$dia3 = str_replace('.','',$dia3);		
		$imponible1 = str_replace('.','',$imponible1);
		$imponible2 = str_replace('.','',$imponible2);
		$imponible3 = str_replace('.','',$imponible3);		
		//--------------------------------------//
/*		if (date( "w", mktime(0,0,0,date("m"),24,date("Y"))) == 0)
		// Esto me verifica que se debe ingresar la UF el dia 24 de cada mes, pero si cae dia domingo entonces
		// se debe ingresar un dia anterior (Sabado)
		{
			 $dia=23;
		} else {
			$dia=24;
		} */

		$muf1= sacarmes($mes1);
		$muf2= sacarmes($mes2);
		$muf3= sacarmes($mes3);
		if (date( "w", mktime(0,0,0,$muf1,24,$ano1)) == 0)
		// Esto me verifica que se debe ingresar la UF el dia 24 de cada mes, pero si cae dia domingo entonces
		// se debe ingresar un dia anterior (Sabado)
		{
			 $duf1 =23;
		} else {
			$duf1 =24;
		}

		$fecha_actual=date("Y")."-".date("m")."-".$dia;
		$fechauf1 = $ano1."-".$muf1."-".$duf1;
		//$consulta = "Select valor from subs_web.mes_uf where fecha ='".$fecha_actual."'";
		$consulta = "SELECT valor from subs_web.mes_uf where fecha = '".$fechauf1."'";
		$variable = mysql_query($consulta,$link);
		$row = mysql_fetch_array($variable); 
		$valor_uf1 =$row["valor"];
		$tope1 = $valor_uf1 * 60;
				
		if (date( "w", mktime(0,0,0,$muf2,24,$ano2)) == 0)
		// Esto me verifica que se debe ingresar la UF el dia 24 de cada mes, pero si cae dia domingo entonces
		// se debe ingresar un dia anterior (Sabado)
		{
			 $duf2 = 23;
		} else {
			$duf2 = 24;
		}

		//$fecha_actual=date("Y")."-".date("m")."-".$dia;
		$fechauf2 = $ano2."-".$muf2."-".$duf2;
		//$consulta = "Select valor from subs_web.mes_uf where fecha ='".$fecha_actual."'";
		$consulta = "SELECT valor from subs_web.mes_uf where fecha = '".$fechauf2."'";
		$variable = mysql_query($consulta,$link);
		$row = mysql_fetch_array($variable); 
		$valor_uf2 =$row["valor"];
		$tope2 = $valor_uf2 * 60;
		
		if (date( "w", mktime(0,0,0,$muf3,24,$ano3)) == 0)
		// Esto me verifica que se debe ingresar la UF el dia 24 de cada mes, pero si cae dia domingo entonces
		// se debe ingresar un dia anterior (Sabado)
		{
			 $duf3 =23;
		} else {
			$duf3 =24;
		}

		//$fecha_actual=date("Y")."-".date("m")."-".$dia;
		$fechauf3 = $ano3."-".$muf3."-".$duf3;
		//$consulta = "Select valor from subs_web.mes_uf where fecha ='".$fecha_actual."'";
		$consulta = "SELECT valor from subs_web.mes_uf where fecha = '".$fechauf3."'";
		$variable = mysql_query($consulta,$link);
		$row = mysql_fetch_array($variable); 
		$valor_uf3 =$row["valor"];
		$tope3 = $valor_uf3 * 60;
		
		//--------------------------------------------//
		/*   % UF  */
		$valor_uf = $valor_uf1;
		$porc_afp_1=$porc_afp;
		$porc_afp_2=$porc_afp;
		$porc_afp_3=$porc_afp;				
		/*  calculo de Valor Afp  */
		if ($imponible1 > $tope1)
		{
				$valor_afp[1] = round(($tope1*$porc_afp)/100);
		}
		else
		{
				$valor_afp[1]=round((($imponible1*$porc_afp)/100));
		}
		if ($imponible2 > $tope2)
		{
				$valor_afp[2]=round(($tope2*$porc_afp)/100);
		}
		else
		{
			$valor_afp[2]=round((($imponible2*$porc_afp)/100));
		}
		if ($imponible3 > $tope3)
		{
			$valor_afp[3]=round(($tope3*$porc_afp)/100);
		}
		else
		{
			$valor_afp[3]=round((($imponible3*$porc_afp)/100));
		}
		for($i=0; $i<=3;$i++)
		{
			$mostrar_valor_afp[$i]=number_format($valor_afp[$i],0,',','.');			
		}
		/*   Ver si es de fonasa o es de Isapre  */
		if ( $esfonasa == 's') { // Me quiere decir que es fonasa y no isapre		
			for($i=1;$i<=3;$i++)
			{	
				$uf_isapre[$i]="--------";
				$valor_isapre[$i]="---------";
			}
			if ($imponible1 > $tope1)
			{
				$fonasa[1]=round((($tope1*porc_fonasa)/100));
			}
			else
			{
				$fonasa[1]=round((($imponible1*$porc_fonasa)/100));
			}
			if ($imponible2 > $tope2)
			{
				$fonasa[2]=round((($tope2*porc_fonasa)/100));
			}
			else
			{
				$fonasa[2]=round((($imponible2*$porc_fonasa)/100));
			}
			if ($imponible3 > $tope3)
			{
				$fonasa[3]=round((($tope3*porc_fonasa)/100));
			}
			else
			{
				$fonasa[3]=round((($imponible3*$porc_fonasa)/100));
			}
			for($i=0; $i<=3;$i++)
			{
				$mostrar_fonasa[$i]=number_format($fonasa[$i],0,',','');			
				$mostrar_valor_isapre[$i]="---------";
				$uf_isapre[$i]="-------";
			}															
			$total_salud[1]=(($imponible1*$porc_fonasa)/100);
			$total_salud[2]=(($imponible2*$porc_fonasa)/100);
			$total_salud[3]=(($imponible3*$porc_fonasa)/100);									

		} else {
			$porc_fonasa="0,00";			
			for($i=1;$i<=3;$i++)
			{
				$mostrar_fonasa[$i]="-----------";
				$uf_isapre[$i]=$pac_uf;
				if ($i==1)
				{
					if ($tipod=="U")
					{
						$valor_isapre[1] = round(($valor_uf1*$pac_uf));
						$total_salud[1]  = ($valor_uf1*pac_uf);
					}
					elseif ($tipod=="P")
					{
						if ($imponible1 > $tope1)
						{
							$valor_isapre[1]=round((($tope1*$pac_uf)/100));
							$total_salud[1]=round((($tope1*$pac_uf)/100));
						}
						else
						{
							$valor_isapre[1] = round(($imponible1 * $pac_uf) / 100);
							$total_salud[1]  = round(($imponible1 * $pac_uf) / 100);
						}
					}
				}
				if ($i==2)
				{
					if ($tipod=="U")
					{
						$valor_isapre[2] = round(($valor_uf2*$pac_uf));
						$total_salud[2]  = ($valor_uf2*pac_uf);
					}
					elseif($tipod=="P")
					{
						if ($imponible2 > $tope2)
						{
							$valor_isapre[2] = round((($tope2 * $pac_uf)/100));
							$total_salud[2]  = round((($tope2 * $pac_uf)/100));
						}
						else
						{
							$valor_isapre[2] = round(($imponible2 * $pac_uf) / 100);
							$total_salud[2]  = round(($imponible2 * $pac_uf) / 100);
						}
					}
				}
				if ($i==3)
				{
					if ($tipod=="U")
					{
					     $valor_isapre[3] = round(($valor_uf3*$pac_uf));
					     $total_salud[3]  = ($valor_uf3*pac_uf);
										}
					elseif($tipod=="P")
					{
						if ($imponible3 > $tope3)
						{
							$valor_isapre[3] = round(($tope3 * $pac_uf) / 100);
							$total_salud[3]  = round(($tope3 * $pac_uf) / 100);
						}
						else
						{
							$valor_isapre[3] = round(($imponible3 * $pac_uf) / 100);
							$total_salud[3]  = round(($imponible3 * $pac_uf) / 100);
						}
					}
	 
				}

				//$valor_isapre[$i]= round(($valor_uf*$pac_uf));				
				$mostrar_valor_isapre[$i]=number_format($valor_isapre[$i],0,',','');						
				//$total_salud[$i]= ($valor_uf*$pac_uf);					
			}					
		}
		
			if ( $esfonasa == 's')
			{
				$valor_afecto[1]=round($imponible1 - ($valor_afp[1] + $mostrar_fonasa[1]));
				$valor_afecto[2]=round($imponible2 - ($valor_afp[2] + $mostrar_fonasa[2]));
				$valor_afecto[3]=round($imponible3 - ($valor_afp[3] + $mostrar_fonasa[3]));
				
			}	
			else
			{
				$valor_afecto[1]=round($imponible1 - ($valor_afp[1] + $valor_isapre[1]));
				$valor_afecto[2]=round($imponible2 - ($valor_afp[2] + $valor_isapre[2]));
				$valor_afecto[3]=round($imponible3 - ($valor_afp[3] + $valor_isapre[3]));
				//echo "calculo".$imponible1."-".$valor_afp[1]."-".$valor_isapre[1];
				//echo "valor_afecto".$valor_afecto[1];
			}

		for($i=1;$i<=3;$i++)
		{	
			$mostrar_valor_afecto[$i]=number_format($valor_afecto[$i],0,',','.');			
			
			//echo "valor_afect[$i]".$valor_afecto[$i];
		}
	/*    descuento de valor afectado neto   */
		// --- Primera fila --- //
		if (date( "w", mktime(0,0,0,sacarmes($mes1),24,$ano1)) == 0)
		// Esto me verifica que se debe ingresar la UF el dia 24 de cada mes, pero si cae dia domingo entonces
		// se debe ingresar un dia anterior (Sabado)
		{
			 $dia_1=23;
		} else {
			$dia_1=24;
		}
		$fechadetalle1=$ano1."-".sacarmes($mes1)."-".$dia_1;
		
		$valor_afecto[1] = abs($valor_afecto[1]);
		
		$conssql = "SELECT  factor, rebaja FROM subs_web.detalle_mes WHERE (fecha = '".$fechadetalle1."') AND  (((desde <= '".trim($valor_afecto[1])."') AND ( hasta >= '".trim($valor_afecto[1])."')) OR (((posicion = 8 ) AND (desde <= '".trim($valor_afecto[1])."'))))";		
		$respuesta = mysql_query($conssql);		
		if ($row = mysql_fetch_array($respuesta))
		{
			$desc_valor_afecto[1]=$row[rebaja];

		  //Valor total afectado (Incluido su descuento)	 
	      //la formula es: rebaja= valor_afectado*factor - rebaja
		  //$total_afecto[1]=round($valor_afecto_1-($row[factor]*$row[rebaja]));					
			 //poly$total_afecto[1]=round((($valor_afecto_1*$row[factor])-$row[rebaja]));
			 
			 $total_afecto[1]=round($valor_afecto[1]-((($valor_afecto[1]*$row[factor])-$row[rebaja])));

			$mostrar_total_afecto[1]=number_format($total_afecto[1],0,',','.');
		} else {
			$muestra_msg1='s';
		}	
		// --- Segunda fila --- //
		if (date( "w", mktime(0,0,0,sacarmes($mes2),24,$ano2)) == 0)
		// Esto me verifica que se debe ingresar la UF el dia 24 de cada mes, pero si cae dia domingo entonces
		// se debe ingresar un dia anterior (Sabado)
		{
			 $dia_2=23;
		} else {
			$dia_2=24;
		}
		$fechadetalle2=$ano2."-".sacarmes($mes2)."-".$dia_2;
		$valor_afecto[2] = abs($valor_afecto[2]);
		$conssql2 = "SELECT  factor, rebaja FROM subs_web.detalle_mes WHERE (fecha = '".$fechadetalle2."') AND  (((desde <= '".trim($valor_afecto[2])."') AND ( hasta >= '".trim($valor_afecto[2])."')) OR (((posicion = 8 ) AND (desde <= '".trim($valor_afecto[2])."'))))";		
		
		$respuesta2 = mysql_query($conssql2);		//.$valor_afecto_1."
		if ($row = mysql_fetch_array($respuesta2)) 
		{		
			$desc_valor_afecto[2]= $row[rebaja];
	   		//Valor total afectado (Incluido su descuento)	 
			//poly $total_afecto[2]=round(($valor_afecto_2*$row[factor])-$row[rebaja]);		
			 $total_afecto[2]=round($valor_afecto[2]-((($valor_afecto[2]*$row[factor])-$row[rebaja])));

			//poly$total_afecto[2]=round(($valor_afecto[2]*$row[factor])-$row[rebaja]);
			//echo "VALOR AFECT2 : ".$valor_afecto[2]."por ".$row[factor]."menos ".$row[rebaja]."total_afecto2 : ".$total_afecto[2];					

					
			$mostrar_total_afecto[2]=number_format($total_afecto[2],0,',','.');			
		} else {
			$muestra_msg2='s';
		}		
		// --- Tercera fila --- //
		if (date( "w", mktime(0,0,0,sacarmes($mes3),24,$ano3)) == 0)
		// Esto me verifica que se debe ingresar la UF el dia 24 de cada mes, pero si cae dia domingo entonces
		// se debe ingresar un dia anterior (Sabado)
		{
			 $dia_3=23;
		} else {
			$dia_3=24;
		}
		$fechadetalle3=$ano3."-".sacarmes($mes3)."-".$dia_3;
		$valor_afecto[3] = abs($valor_afecto[3]);
		$conssql3 = "SELECT  factor, rebaja FROM subs_web.detalle_mes WHERE (fecha = '".$fechadetalle3."') AND  (((desde <= '".trim($valor_afecto[3])."') AND ( hasta >= '".trim($valor_afecto[3])."')) OR (((posicion = 8 ) AND (desde <= '".trim($valor_afecto[3])."'))))";				
//		$respuesta = mysql_query($conssql);		//.$valor_afecto_1."
		$respuesta3 = mysql_query($conssql3);
		if ($row = mysql_fetch_array($respuesta3))
		{
			$desc_valor_afecto[3]=$row[rebaja];
		   //Valor total afectado (Incluido su descuento)	 
		   	$total_afecto[3]=round($valor_afecto[3]-((($valor_afecto[3]*$row[factor])-$row[rebaja])));

			//poly$total_afecto[3]=round(($valor_afecto[3]*$row[factor])-$row[rebaja]);			
							
			$mostrar_total_afecto[3]=number_format($total_afecto[3],0,',','.');			
		} else {
			$muestra_msg3='s';
		}
	/*  Calculo Valor Diario  */	
		$suma_total_afecto=0;
		$suma_dias=$dia1+$dia2+$dia3;
		for ($i=1;$i<=3; $i++)
		{
			 $suma_total_afecto=$suma_total_afecto+$total_afecto[$i];
		}
		$valor_diario=$suma_total_afecto/$suma_dias;
		$mostrar_valor_diario=number_format(($valor_diario),2,',','.');///$suma_dias
	/*	Dias de Licencias	*/
		$mostrar_dias_licencia=$dias_licencias;
	/*	Total a Pagar	*/
		$mostrar_total_a_pagar=number_format($dias_licencias*($valor_diario),2,',','.');//$dias_licencia*($suma_total_afecto/$suma_dias);
		$total_a_pagar=$mostrar_total_a_pagar;
	} // fin : if ($inicializa_var == 's')..	
	if (($muestra_msg3=='s') || ($muestra_msg2=='s') || ($muestra_msg1=='s'))
	{
		include("limpiavalores.php");		
	}
?>

 <form name="form1" method="post" action="">
  <!--------------------------------Tabla Principal ---------------------------------->
  <input type="hidden" name="tipod" value="<? echo $tipod; ?>" >
  <table width="769" height="200"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>			
      <td height="523" valign="top"> <br>
	  	<? //include("../principal/encabezado.php");?>
			<center><b><h3>C&aacute;lculo de Subsidio e Incapacidad Laboral</h3></b></center>
        <!----------------------------------- tabla de Ingreso de imponibilidad  ------>
        <table width="705" border="1" align="center"cellpadding="2"  cellspacing="0" class="TablaInterior">
          <tr align="left" class="ColorTabla01" >
							<td colspan="4"> <b>Ingreso de Valores Imponibles</b></td>					
						</tr>
						<tr class="ColorTabla02" align="center">
							<td width="223"><b><? echo $mes3;?>&nbsp;&nbsp;<? echo $ano3; ?></b></td>
							<td width="230"><b><? echo $mes2;?>&nbsp;&nbsp;<? echo $ano2; ?></b></td>
							<td width="231"><b><? echo $mes1;?>&nbsp;&nbsp;<? echo $ano1; ?></b></td>				
						</tr>
						<tr>							
							<td>D&iacute;as Trabajados :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="dia3" size="6" value="<? echo $dia3; ?>"  style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" tabindex="1" class="InputDer"></td>
							<td>D&iacute;as Trabajados :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="dia2"  size="6" value="<? echo $dia2;?>"  style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" tabindex="3" class="InputDer"></td>
							<td>D&iacute;as Trabajados :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="dia1"  size="6" value="<? echo $dia1;?>"  style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" tabindex="5" class="InputDer"></td>
							
						</tr>
						<tr>
							<td>Valor Imponible($):&nbsp&nbsp;&nbsp;&nbsp;<input type="text" name="imponible3" value="<? echo number_format($imponible3,0,',','.');?>" size="14"  style="text-align:right"  onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" tabindex="2" class="InputDer"></td>							
							<td>Valor Imponible($):&nbsp&nbsp;&nbsp;&nbsp;<input type="text" name="imponible2" value="<? echo number_format($imponible2,0,',','.');?>" size="14"  style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" tabindex="4" class="InputDer"></td>							
							<td>Valor Imponible($):&nbsp&nbsp;&nbsp;&nbsp;<input type="text" name="imponible1" value="<? echo number_format($imponible1,0,',','.');?>" size="14"  style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" tabindex="6" class="InputDer"></td>							
						</tr>						
			  </table>	
				<input type="text"  name="ano1" value="<? echo $ano1; ?>">
				<input type="text" name="mes1" value="<? echo $mes1;?>">
				<input type="text"  name="ano2" value="<? echo $ano2; ?>">
				<input type="text" name="mes2" value="<? echo $mes2;?>">
				<input type="text"  name="ano3" value="<? echo $ano3; ?>">
				<input type="text" name="mes3" value="<? echo $mes3;?>">
			  <script>
				 InvisibleTextoMesAno();			
			 </script>
			  <?
			  	if ($inicializa_var == 's')		
				{
					echo ' <script languaje = "Javascript">';
						echo ' Limpiar()';
					echo ' </script>';

				}
				?>
			 
       <!----------------------------------- Fin Tabla de Ingreso de imponibilidad  ------>


			<table width="697" height="212" border="1" align="center"cellpadding="2"  cellspacing="0" class="TablaInterior">
          <tr align="center" class="ColorTabla01">
				<td  align="left"colspan="12"><b>Detalles</b></td>
		   	  </tr> 
    	      <tr align="center" class="ColorTabla02"> 				
				  <td width="56"><div align="center"><b>Fecha</b></div></td>
			  	  <td width="34"><div align="center"><b>D&iacute;as<br>Trab. </b></div></td>
				  <td width="61"><div align="center"><b>Valor Imponible</b></div></td>
				  <td width="38"><div align="center"><b>% AFP</b></div></td>
  				  <td width="50"><div align="center"><b>Valor AFP</b></div></td>				  
				  <td width="58"><div align="center"><b><? echo $porc_fonasa; ?>% Salud<br>(Fonasa)</b></div></td>
				  <? if ($tipod=="P")
				  	{
						$dest = "(%)";
					}
					else
					{
						$dest = "(UF)";
					} ?>
				  <td width="41"><div align="center"><b>Isapre<br><? echo $dest;?></b></div></td>
				  <td width="45"><div align="center"><b>Valor Isapre</b></div></td>
				  <td width="63"><div align="center"><b>Valor Afect. I.U</b></div></td>
  				  <td width="67"><div align="center"><b>Desc. Valor Afect. I.U</b></div></td>
				  <td width="22"><div align="center"><b>Ver</b></div></td>
  				  <td width="87"><div align="center"><b>Valor Total Afect. I.U</b></div></td>

			</tr>
			<tr> 			  
	          <td align="left"><? echo $mes3; ?></td>
			  <td align="right"><? echo $dia3; ?></td>
			  <td align="right"><? echo $imponible3; ?></td>			  
			  <td align="right"><? echo $porc_afp_3;?></td>
			  <td align="right"><? echo $mostrar_valor_afp[3]; ?></td>
			  <td align="right"><? echo $mostrar_fonasa[3]; ?></td>
			  <td align="center"><? echo $uf_isapre[3];?></td>
			  <td align="right"><? echo $mostrar_valor_isapre[3]; ?></td>
			  <td align="right"><? echo $mostrar_valor_afecto[3]; ?></td>
  			  <td align="right"><? echo $desc_valor_afecto[3]; ?></td>
  			  <td><input type="radio" name="opcdetalle" value="5" onClick="PoPuPDetalle('3',<? echo "'".$valor_afecto[3]."','".$desc_valor_afecto[3]."'"; ?>)"></td>
  			  <td align="right"><? echo $mostrar_total_afecto[3]; ?></td>
			 </tr>
			<tr> 
			  <td align="left"><? echo $mes2; ?></td>
			  <td align="right"><? echo $dia2; ?></td>
			  <td align="right"><? echo $imponible2; ?></td>
			  <td align="right"><? echo $porc_afp_2;?></td>
			  <td align="right"><? echo $mostrar_valor_afp[2]; ?></td>
			  <td align="right"><? echo $mostrar_fonasa[2]; ?></td>
			  <td align="center"><? echo $uf_isapre[2];?></td>
			  <td align="right"><? echo $mostrar_valor_isapre[2]; ?></td>
			  <td align="right"><? echo $mostrar_valor_afecto[2]; ?></td>
	  		  <td align="right"><? echo $desc_valor_afecto[2]; ?></td>
			  <td><input type="radio" name="opcdetalle" value="5" onClick="PoPuPDetalle('2','<? echo $valor_afecto[2]."','".$desc_valor_afecto[2]."'"; ?>)"></td>
   			  <td align="right"><? echo $mostrar_total_afecto[2]; ?></td>			  
			</tr>
			<tr> 
			  <td align="left"><? echo $mes1; ?></td>
			  <td align="right"><? echo $dia1; ?></td>
			  <td align="right"><? echo $imponible1; ?></td>
			  <td align="right"><? echo $porc_afp_1; ?></td>
			  <td align="right"><? echo $mostrar_valor_afp[1]; ?></td>
			  <td align="right"><? echo $mostrar_fonasa[1]; ?></td>
			  <td align="center"><? echo $uf_isapre[1]; ?></td>
			  <td align="right"><? echo $mostrar_valor_isapre[1]; ?></td>			  
			  <td align="right"><? echo $mostrar_valor_afecto[1]; ?></td>
  			  <td align="right"><? echo $desc_valor_afecto[1]; ?></td>			  
			  <td><input type="radio" name="opcdetalle"  value="5" onClick="PoPuPDetalle('1','<? echo $valor_afecto[1]."','".$desc_valor_afecto[1]."'";?>)"></td>
			  <td align="right"><? echo $mostrar_total_afecto[1]; ?></td>
			</tr>
			<tr>			
				
            <td height="71" colspan="12" align="center" class="Detalle02"> 
              <table border="1" align="center" cellpadding="2"  cellspacing="0" class="TablaInterior">
						<tr> 
						  <td width="90" class="ColorTabla02"><div align="center"><b>Dias Licencia</b></div></td>
						  <td width="15" rowspan="2"><div align="center"><b>x</b></div></td>
						  <td width="86" class="ColorTabla02"><div align="center"><b>Valor Diario</b></div></td>
						  <td width="13" rowspan="2"><div align="center"><b>=</b></div></td>
						  <td width="84" class="ColorTabla02"><div align="center"><b>Total a Pagar</b></div></td>
						</tr>
						<tr> 
						  <td><div align="center"> 
							  <? echo $mostrar_dias_licencia; ?>
							</div></td>
						  <td> <div align="center">  	
							  <? echo $mostrar_valor_diario; ?>
							</div></td>
						  <td> <div align="center">						  		
								  <b><? echo $mostrar_total_a_pagar; ?></b>
							</div></td>
						</tr>
				  </table>		  			
				</td>
			</tr>
		  </table>
		  <br><br>		
		   <table width="389" border="0" align="center" class="TablaInterior">
          <tr align="center">
					<td>	
						<input type="button" name="calcular" value="Calcular" style="width:70px" onClick="Calcular(<? echo $dias_licencias.",".$porc_afp.",'".$esfonasa."',".$pac_uf.",'".$numfila."','".$filaselec."'";?>)">
						<input type="button" name="BtnAceptar" value="Aceptar" style="width:70px" onClick="Aceptar(<? echo "'".$numfila."','".$filaselec."','".$total_a_pagar."','".$pac_uf."','".$mostrar_valor_diario."'";?>)"> 
						<input type="button" name="BtnLimpiar" value="Limpiar" style="width:70px" onClick="Limpiar()">
						<input type="button"  id="BtnSalir" name="BtnSalir" value="Salir" style="width:70px"  onClick="Salir()" >
						<input type="hidden" name="rut_completo" value="<? echo $rut_completo; ?>">					    
					</td>
				</tr>
			  </table>
	   </td>
	 </tr>
	</table>  
<?	
	if (($muestra_msg3=='s') || ($muestra_msg2=='s') || ($muestra_msg1=='s'))
	{
		if (($muestra_msg1=='s') && ($muestra_msg2=='s') && ($muestra_msg3=='s')){
			$nommes=$mes1." ".$mes2." ".$mes3;
		}
		if (($muestra_msg1=='s') && ($muestra_msg2=='s') && ($muestra_msg3!='s')){
			$nommes=$mes1." ".$mes2;
		}
		if (($muestra_msg1=='s') && ($muestra_msg2!='s') && ($muestra_msg3=='s')){
			$nommes=$mes1." ".$mes3;
		}
		if (($muestra_msg1!='s') && ($muestra_msg2=='s') && ($muestra_msg3=='s')){
			$nommes=$mes2." ".$mes3;			
		}
		if (($muestra_msg1=='s') && ($muestra_msg2!='s') && ($muestra_msg3!='s')){
			$nommes=$mes1;
		}		
		if (($muestra_msg1!='s') && ($muestra_msg2=='s') && ($muestra_msg3!='s')){
			$nommes=$mes2;
		}		
		if (($muestra_msg1!='s') && ($muestra_msg2!='s') && ($muestra_msg3=='s')){
			$nommes=$mes3;
		}		
		echo ' <script languaje = "Javascript">';
			echo 'Limpiar();';
			echo ' InhabilitarAcptVer();';		
			echo " alert(' No se han Ingresado los I.U de los meses ".$nommes."');";
		echo ' </script>';
	}
	if ($inicializa_var == 's')
	{
		echo ' <script languaje = "Javascript">';
			echo ' InhabilitarAcptVer();';		
		echo ' </script>';
	}						
?>
  </form>  
 </body>
</html>
