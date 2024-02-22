<?Php
	$CodigoDeSistema=19;
	$CodigoDePantalla=2;
	 // S E R V I D O R  139  //
//    include("conectar.php") ; //Conecta la Base de Dato de Subs_web//		
//	 echo $rut_completo;
	//    S E R V I D O R  50  *//	
	// include("conectar_rrhh.php"); //Conecta con la Base de Dato de RRHH del Servidor 50
	// Busco el codigo ISAPRE en la BD RRHH	 
	// $buscar_isapre = "SELECT cod_isapre from bd_rrhh.antecedentes_personales where rut = '".$rut_completo."'";
	// $respuesta = mysql_query($buscar_isapre); //Ejecuto la consulta
	// $row = mysql_fetch_array($respuesta);
/*	echo "0".$rut_completo;
		$ConsSql="SELECT * FROM bd_rrhh.antecedentes_personales WHERE rut = '0".$rut_completo."'";	
		$ConsSql="SELECT * from bd_rrhh.antecedentes_personales where (RUT ='04155073-2')";//.$rut_completo."')";
	  	$RespSql = mysql_query($ConsSql);		
		$row=mysql_fetch_array($RespSql);
		echo $row["nombres"];
/*	 	if($row=mysql_fetch_array($RespSql)){
			 $cod_isapre = $row[COD_ISAPRE];// Almaceno el codigo de isapre*/
	/* 		 if ( $cod_isapre == 50)	 {
				$porc_salud = $pac_uf; // Me quiere decir que es fonasa y no isapre		
				$fonasa[1] = (($imponible1 * $porc_salud )/ 100);		
				$fonasa[2] = (($imponible2 * $porc_salud )/ 100);		
		 		$fonasa[3] = (($imponible3 * $porc_salud )/ 100);				
			 } else	 {
	 			$fonasa='n';	
			 }
		} else {
			echo "no se encuentra";
		}*/
// 	 include("cerrar_rrhh.php"); // cierrea la conexion de la BD RRHH

?>

<?Php
	 // S E R V I D O R  139  //
	 include("conectar.php"); //Conecto la BD SUBS_WEB
	 /******** prepara fecha para rescatar datos******/ 
//  	  $fecha = explode("-",$fecha_acc); // Poner fecha en formato BBDD
	//  $Mes = $fecha[1]; 
	// if(strlen($fecha[1]) == '1'){ // Si fecha tiene una cifra le agrega un cero inicial
	//  	$fecha[1] = '0'.$fecha[1];
//		}	 
//	  $fecha_acc = $fecha[0]."-".$fecha[1]."-".$fecha[2];
	 


	  	
	  	
	
	  	
	  
	  //****Busca dias trabajados y el valor imponible para dichas fechas**********/
	 /* $consulta = "SELECT dias, pagado from subs_web.liquidacion where (rut = '".$rut_dv."') and (fecha < '".$fecha_acc."')order by fecha desc limit 3";	
	  $cons = mysql_query($consulta);
	  $i=1;
	  while($row=mysql_fetch_array($cons)){ // se recorre 3 veces
		 $dias[$i] = $row[dias];
		 $valor_imponible[$i] = $row[pagado];
		 $i++;
	  } // Fin del While .....
	
	/*
	 $a = date("m", mktime(0,0,0,$mes-2,25,2004));
	 $b = date("m", mktime(0,0,0,$mes-3,25,2004));
	 $c = date("m", mktime(0,0,0,$mes-4,25,2004));	
	$fecha1 = $Meses[$a];
	$fecha2 = $Meses[$b];
	$fecha3 = $Meses[$c];
	*/
/*************************  Fonasa o Isapre  ***********************/
	 if ( $esfonasa == 's')	 {
		echo "sip";
		$porc_salud = $pac_uf; // Me quiere decir que es fonasa y no isapre		
		$fonasa[1] = (($imponible1 * $porc_salud )/ 100);		
		$fonasa[2] = (($imponible2 * $porc_salud )/ 100);		
 		$fonasa[3] = (($imponible3 * $porc_salud )/ 100);				
	 } 



	/******Porcentaje afp **********/
/*	$buscar_afp = "SELECT porcent_afp from subs_web.afp where COD_AFP = '".$codigo_afp."'";
	$respuesta = mysql_query($buscar_afp);
	$row = mysql_fetch_array($respuesta);
	$porc_afp = $row[porcent_afp];*/


	
		$valor_afp[1] = (($imponible1 * $porc_afp) / 100);
		$valor_afp[1] = number_format($valor_afp[1], 2, '.', '');
		$valor_afp[2] = (($imponible2 * $porc_afp) / 100);
		$valor_afp[2] = number_format($valor_afp[2], 2, '.', '');
		$valor_afp[3] = (($imponible3 * $porc_afp) / 100);
		$valor_afp[3] = number_format($valor_afp[3], 2, '.', '');
	
	
	/******Porcentaje Fonasa*********
   $porc_fonasa = "SELECT porcent from subs_web.fonasa where fecha=(SELECT max(fecha) from subs_web.fonasa where fecha < '".$fecha_acc."') and cod_fonasa=(SELECT max(cod_fonasa) from subs_web.fonasa)";
   $respuesta = mysql_query($porc_fonasa);
   $row = mysql_fetch_array($respuesta);
   $porc_salud = $row[porcent];
   for($i=1; $i<4; $i++){
	 $fonasa[$i] = (($valor_imponible[$i] * $porc_salud )/ 100);
   }
	
	/******Calcular_valor_afecto*******/
	
	/******Calcular_valor_diario*******/
	
	/******Calcular_total_a_pagar*******/
	$total_a_pagar = ($valor_diario * $dias_licencia);
	/*******Formatear_Fecha************/
  	$Ano=$FechaDesde[6]."".$FechaDesde[7]."".$FechaDesde[8]."".$FechaDesde[9];
    $Mes=$FechaDesde[3]."".$FechaDesde[4];
	if($Mes >'03'){
	  $mes1 = $Meses[$Mes-2];
	  $mes2 = $Meses[$Mes-3];
	  $mes3 = $Meses[$Mes-4];
	  $ano1=$Ano;
  	  $ano2=$Ano;
  	  $ano3=$Ano;}
	if($Mes =='01'){
	  $mes1 = $Meses['11'];
	  $mes2 = $Meses['10'];
	  $mes3 = $Meses['9'];
	  $ano1=$Ano-1;
  	  $ano2=$Ano-1;
  	  $ano3=$Ano-1;}
	  
	if($Mes =='02'){
	  $mes1 = $Meses['0'];
	  $mes2 = $Meses['11'];
	  $mes3 = $Meses['10'];
  	  $ano1=$Ano;
  	  $ano2=$Ano-1;
  	  $ano3=$Ano-1;}
	if($Mes =='03'){
	  $mes1 = $Meses['1'];
	  $mes2 = $Meses['0'];
	  $mes3 = $Meses['11'];
  	  $ano1=$Ano;
  	  $ano2=$Ano;
  	  $ano3=$Ano-1;}
?>
<!-------------------------------------- Inicio Html  -------------------------------------->
<html>
<head>
	<title>Calculo Subsidio e Incapacidad Laboral</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<Script languaje = "Javascript" src="funciones.js">/* Validador Puntitos */</script>
	<script language="JavaScript">
		<!---------------------------- Funcion Proceso (Salir)  ----------------------------------------------->
//1		function PoPuPDetalle(ano, mes, afecto) <? echo $ano3;?>,<? echo $mes3; ?>,<? echo $valor_afecto[3]; ?>
//ano=" + ano +"&mes=" +  mes +"&afecto=" + afecto
		function PoPuPDetalle(fila)
		{
			f=document.form1;
			var ano="";
			var palabrames="";
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
			window.open("detalle_iu.php?mes=" +palabrames+"&ano="+ano,""," fullscreen=no,left=0,top=10,width=412,height=400,scrollbars=yes,resizable = no");					
		}
		function Calcular (opc_det,porc_afp,pac_uf)
		{
            f = document.form1;
/*			if ((f.dia1.value=="") || (f.dia2.value=="")|| (f.dia3.value=="")) 
			{
				alert("Debe Ingresar todos los Datos");
			}	 			
			else 
			{*/
				f.action = "valor_diario.php?porc_afp=" + porc_afp + "&pac_uf=" + pac_uf + "&opc_detalle=" + opc_det+"&dia1=" + f.dia1.value + "&dia2=" + f.dia2.value + "&dia3=" + f.dia3.value + "&imponible1=" + f.imponible1.value+ "&imponible2=" + f.imponible2.value+ "&imponible3=" + f.imponible3.value +"&mes1="+f.mes1.value+"&mes2="+f.mes2.value+"&mes3=" + f.mes3.value;
				f.submit();		 	
/*			 } */
		}
		function Volver(n)
		{
			var f=document.form1;
			window.close();
			}
		function Proceso(opt)
		{
			var f = document.form1;
			switch (opt)
			{
				case "S":
					f.action = "../principal/sistemas_usuario.php?CodSistema=19";
					f.submit();
					break;					
			}
		}	
	</script>
</head>
<!--------------------------- Cuerpo Principal  -------------------------------------------->
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
	<form name="form1" method="post" action="">
  <!--------------------------------Tabla Principal ---------------------------------->
  <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
		  <tr>
			<td height="313" valign="top">  		 
			  <br>
        <!-- 	  	<input name="valor" type="hidden" value="">
	  	<? //include("../principal/encabezado.php");?>
	<!--	<div align="left"></div>		   -->
        <!----------------------------------- tabla de Ingreso de imponibilidad  ------>
        <table width="312" border="1" align="center"cellpadding="2"  cellspacing="0" class="TablaInterior">
				  <tr align="left" class="ColorTabla01" >
							<td colspan="4"> <b>Ingreso de Valores Imponibles</b></td>					
						</tr>
						<tr class="ColorTabla02" align="center">
							<td width="45"><b>A&ntilde;o</b></td>	
							<td width="57"><b>Mes</b></td>
							<td width="90"><b>D&iacute;as Trabajados</b></td>
							<td width="93"><b>Valor Imponible ($)</b></td>				
						</tr>
						<tr align="center">							
							<td>&nbsp;<input type="text"  name="ano1" value="<? echo $ano1; ?>" size="4"></td>
							<td >&nbsp;<input type="text" name="mes1" value="<? echo $mes1;?>" size="11"></td>	
							<td>&nbsp;<input type="text" name="dia1" size="4" value="<? echo $dia1; ?>"></td>
							<td>&nbsp;<input type="text" name="imponible1" value="<? echo $imponible1;?>" size="11"></td>
						</tr>
						<tr align="center">
							<td>&nbsp;<input type="text" name="ano2" value="<? echo $ano2; ?>" size="4"></td>
							<td >&nbsp;<input type="text" name="mes2" value="<? echo $mes2;?>" size="11"></td>	
							<td>&nbsp;<input type="text" name="dia2"  size="4" value="<? echo $dia2;?>"></td>
							<td>&nbsp;<input type="text" name="imponible2" value="<? echo $imponible2;?>" size="11"></td>
						</tr>
						<tr align="center">
							<td>&nbsp;<input type="text"  name="ano3"value="<? echo $ano3; ?>" size="4"></td>
							<td >&nbsp;<input type="text" name="mes3" value="<? echo $mes3;?>" size="11"></td>	
							<td>&nbsp;<input type="text" name="dia3" value="<? echo $dia3 ;?>" size="4"></td>
							<td>&nbsp;<input type="text" name="imponible3" value="<? echo $imponible3;?>" size="11"></td>
						</tr>					
			  </table>			
			  <br>
			  <table align="center" border="1">
			  	<tr>
					<td>	
						<input type="button" name="calcular" value="Calcular" style="width:70px" onClick="Calcular('s',<? echo $porc_afp.",".$pac_uf;?>)">
						<input type="button"  id="BtnVolver" name="BtnVolver" value="Volver" style="width:70px"  onClick="Volver()">
						<input type="hidden" name="rut_completo" value="<? echo $rut_completo; ?>">						
					</td>
				</tr>
			  </table>
       <!----------------------------------- Fin Tabla de Ingreso de imponibilidad  ------>
        <br>	
		 <?
			if ($opc_detalle == 's')
			{ ?>	  	 
			  <table width="575" border="1" align="center"cellpadding="2"  cellspacing="0" class="TablaInterior">
				<tr align="center" class="ColorTabla01"> 				
				  <td width="60"><div align="center"><b>Fecha</b></div></td>
			  	  <td width="40"><div align="center"><b>D&iacute;as<br>Trab. </b></div></td>
				  <td width="66"><div align="center"><b>Valor Imponible</b></div></td>
				  <td width="45"><div align="center"><b>%AFP</b></div></td>
  				  <td width="45"><div align="center"><b>Valor AFP</b></div></td>				  
				  <td width="58"><div align="center"><b><? echo $porc_salud; ?>%<br> Salud<br>(Fonasa)</b></div></td>
				  <td width="43"><div align="center"><b>Isapre<br>(UF)</b></div></td>
				  <td width="50"><div align="center"><b>Valor Isapre</b></div></td>
				  <td width="75"><div align="center"><b>Valor Afect. I.U</b></div></td>
  				  <td width="75"><div align="center"><b>Desc. Valor Afect. I.U</b></div></td>
				  <td width="75"><div align="center"><b>Ver</b></div></td>

			</tr>
			<tr> 			  
	          <td><input name="mes_det_1" type="text" size="12" maxlength="12" value="<? echo $mes1; ?>" readonly></td>
			  <td><input name="dias_det_1" type="text" value="<? echo $dia1; ?>" size="3" maxlength="2" ></td>
			  <td><input name="imponible_det_1" type="text" value="<? echo $imponible1; ?>" size="11" maxlength="11"></td>			  
			  <td><input name="porc_afp_1 "  type="text" value="<? echo $porc_afp;?>" size="5" maxlength="5"></td>
			  <td><input name="valor_afp[1]" type="text" value="<? echo $valor_afp[1]; ?>" id="valor_afp[1]"  size="11" maxlength="11"></td>
			  <td><input name="fonasa[1]" type="text" value="<? echo $fonasa[1]; ?>" size="11" maxlength="11"></td>
			  <td><input name="isapre[1]" type="text" value="<? echo $uf_isapre;?>" size="5" maxlength="5"></td>
			  <td><input name="valor_isapre[1]" type="text" value="<? echo $valor_isapre[1]; ?>" size="11" maxlength="11"></td>
			  <td><input name="valor_afecto[1]" type="text" value="<? echo $valor_afecto[1]; ?>" size="15" maxlength="15"></td>
  			  <td> <input name="desc_valor_afecto[1]" type="text" value="<? echo $desc_valor_afecto[1]; ?>" size="15" maxlength="15"></td>
  			  <td><input type="radio" name="opcdetalle" value="5" onClick="PoPuPDetalle('1')"></td>
			 </tr>
			<tr> 
			  <td><input name="mes_det_2" type="text" size="12" maxlength="12" value="<? echo $mes2; ?>" readonly></td>
			  <td><input name="dias_det_2" type="text" size="3" maxlength="2" value="<? echo $dia2; ?>"></td>
			  <td><input name="imponible_det_2" type="text" value="<? echo $imponible2; ?>" size="11" maxlength="11"></td>
			  <td><input name="porc_afp_2 " type="text" value="<? echo $porc_afp;?>" size="5" maxlength="5"></td>
			  <td><input name="valor_afp[2]" type="text" value="<? echo $valor_afp[2]; ?>" size="11" maxlength="11"></td>
			  <td><input name="fonasa[2]" type="text" value="<? echo $fonasa[2]; ?>" size="11" maxlength="11"></td>
			  <td><input name="isapre[2]" type="text" value="<? echo $uf_isapre;?>" size="5"></td>
			  <td><input name="valor_isapre[2]" type="text" value="<? echo $valor_isapre[2]; ?>" size="11" maxlength="11"></td>
			  <td><input name="valor_afecto[2]" type="text" value="<? echo $valor_afecto[2]; ?>" size="15" maxlength="15"></td>
	  		  <td><input name="desc_valor_afecto[2]" type="text" value="<? echo $desc_valor_afecto[2]; ?>" size="15" maxlength="15"></td>
			  <td><input type="radio" name="opcdetalle" value="5" onClick="PoPuPDetalle('2')"></td>
			</tr>
			<tr> 
			  <td><input name="mes_det_3" type="text" size="12" maxlength="12" value="<? echo $mes3; ?>" readonly></td>
			  <td><input name="dias_det_3" type="text" value="<? echo $dia3; ?>" size="3" maxlength="3" ></td>
			  <td><input name="imponible_det_3" type="text" value="<? echo $imponible3; ?>" size="11" maxlength="11"></td>
			  <td><input name="porc_afp_3 " type="text" value="<? echo $porc_afp;?>" size="5" maxlength="5"></td>
			  <td><input name="valor_afp[3]" type="text" value="<? echo $valor_afp[3]; ?>" size="11" maxlength="11"></td>
			  <td><input name="fonasa[3]" type="text" value="<? echo $fonasa[3]; ?>" size="11" maxlength="11"></td>
			  <td><input name="isapre[3]" type="text" value="<? echo $uf_isapre; ?>" size="5"></td>
			  <td><input name="valor_isapre[3]" type="text" value="<? echo $valor_isapre[2]; ?>" size="11" maxlength="11"></td>			  
			  <td><input name="valor_afecto[3]" type="text" value="<? echo $valor_afecto[3]; ?>" size="15" maxlength="15"></td>
  			  <td><input name="desc_valor_afecto[3]" type="text" value="<? echo $desc_valor_afecto[3]; ?>" size="15" maxlength="15"></td>			  
			  <td><input type="radio" name="opcdetalle" value="5" onClick="PoPuPDetalle('3')"></td>
			</tr>
		  </table>
		  <br>
		  <table border="1" align="center" cellpadding="2"  cellspacing="0" class="TablaInterior">
			<tr> 
			  <td width="90" class="ColorTabla01"><div align="center"><b>Dias Licencia</b></div></td>
			  <td width="15" rowspan="2"><div align="center"><b>x</b></div></td>
			  <td width="86" class="ColorTabla01"><div align="center"><b>Valor Diario</b></div></td>
			  <td width="13" rowspan="2"><div align="center"><b>=</b></div></td>
			  <td width="84" class="ColorTabla01"><div align="center"><b>Total a Pagar</b></div></td>
			</tr>
			<tr> 
			  <td><div align="center"> 
				  <input name="dias_licencia" value="<? echo $rut_dv; ?>" type="text" size="10"  readonly="">
				</div></td>
			  <td> <div align="center"> 
				  <input name="valor_diario" value="<? echo $valor_diario; ?>" type="text" size="12" readonly="">
				</div></td>
			  <td> <div align="center"> 
				  <input name="total_a_pagar" value="<? echo $total_a_pagar; ?>" type="text" size="12" readonly="">
				</div></td>
			</tr>
		  </table>		  

	  <? } ?>
		  </td>
		 </tr>
		 <tr>
		 	
      <td align="left"> 
        <!-----------------------------  Tabla principal de los detalle de los meses ------------------------------------>
    </tr>
	</table>  
		 <?// include("../principal/pie_pagina.php");?>
	</form>
	</body>
</html>
