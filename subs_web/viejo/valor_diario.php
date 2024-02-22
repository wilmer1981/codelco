<?	/***Rescata la AFP e ISAPRE del rut en cuestion ******/
 include("cerrar.php");
 include("conectar_rrhh.php");

	$buscar_afp = "SELECT cod_afp, cod_isapre from bd_rrhh.antecedentes_personales where rut = '".$rut_dv."' group by cod_afp, cod_isapre ";
	 $respuesta = mysql_query($buscar_afp);
	  $row = mysql_fetch_array($respuesta);
	  $codigo_afp = $row[cod_afp];
	  $codigo_isapre = $row[cod_afp];
  
	include("cerrar_rrhh.php");
?>

<? include("conectar.php");
	 /******** prepara fecha para rescatar datos******/ 
  	  $fecha = explode("-",$fecha_acc); // Poner fecha en formato BBDD
	  $Mes = $fecha[1]; 
	  if(strlen($fecha[1]) == '1'){ // Si fecha tiene una cifra le agrega un cero inicial
	  		$fecha[1] = '0'.$fecha[1];
			}	 
	  $fecha_acc = $fecha[0]."-".$fecha[1]."-".$fecha[2];
	 
  //****Busca dias trabajados e valor imponible para dichas fechas**********/
  $consulta = "SELECT dias, pagado from subs_web.liquidacion where (rut = '".$rut_dv."') and (fecha < '".$fecha_acc."')order by fecha desc limit 3";	
  $cons = mysql_query($consulta);
  	   $i=1;
	   while($row=mysql_fetch_array($cons)){
		 $dias[$i] = $row[dias];
		 $valor_imponible[$i] = $row[pagado];
		 $i++;
        }

/*
 $a = date("m", mktime(0,0,0,$mes-2,25,2004));
 $b = date("m", mktime(0,0,0,$mes-3,25,2004));
 $c = date("m", mktime(0,0,0,$mes-4,25,2004));	
	$fecha1 = $Meses[$a];
	$fecha2 = $Meses[$b];
	$fecha3 = $Meses[$c];
*/
/******Porcentaje afp **********/
	$buscar_afp = "SELECT porcent_afp from subs_web.afp where COD_AFP = '".$codigo_afp."'";
    $respuesta = mysql_query($buscar_afp);
	$row = mysql_fetch_array($respuesta);
	$porc_afp = $row[porcent_afp];
	  	  for($i=1; $i<4; $i++){
		 	$valor_afp[$i] = ($valor_imponible[$i] * ($porc_afp / 100));
			$valor_afp[$i] = number_format($valor_afp[$i], 2, '.', '');
          }

/******Porcentaje Fonasa**********/
	  $porc_fonasa = "SELECT porcent from subs_web.fonasa where fecha=(SELECT max(fecha) from subs_web.fonasa where fecha < '".$fecha_acc."') and cod_fonasa=(SELECT max(cod_fonasa) from subs_web.fonasa)";
	  $respuesta = mysql_query($porc_fonasa);
	  $row = mysql_fetch_array($respuesta);
	  $porc_salud = $row[porcent];
	     for($i=1; $i<4; $i++){
		 $fonasa[$i] = ($valor_imponible[$i] * ($porc_salud / 100));
        }
/******Calcular_valor_afecto*******/

/******Calcular_valor_diario*******/

/******Calcular_total_a_pagar*******/
$total_a_pagar = ($valor_diario * $dias_licencia);
/*******Formatear_Fecha************/
if($rut_dv){
}
		if($Mes >'3'){
			  $fecha1 = $Meses[$Mes-2];
			  $fecha2 = $Meses[$Mes-3];
			  $fecha3 = $Meses[$Mes-4];}
		if($Mes =='1'){
			  $fecha1 = $Meses['11'];
			  $fecha2 = $Meses['10'];
			  $fecha3 = $Meses['9'];}
		if($Mes =='2'){
			  $fecha1 = $Meses['0'];
			  $fecha2 = $Meses['11'];
			  $fecha3 = $Meses['10'];}
		if($Mes =='3'){
			  $fecha1 = $Meses['1'];
			  $fecha2 = $Meses['0'];
			  $fecha3 = $Meses['11'];}
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<Script languaje = "Javascript" src="funciones.js">/* Validador Puntitos */</script>
</head>

<body>
<form name="form1" method="post" action="">
<input name="valor" type="hidden" value="valor_diario.php">
  <p align="center"><b><br>
    Calculo Subsidio</b></p>
  <table width="575" border="1" align="center">
    <tr align="center"> 
      <td width="60"><div align="center"><b>Fecha</b></div></td>
      <td width="0" rowspan="4"> <div align="center"></div></td>
      <td width="40"><div align="center"><b>D&iacute;as<br>
          Trab. </b></div></td>
      <td width="66"><div align="center"><b>Valor Imponible</b></div></td>
      <td width="0" rowspan="4"><div align="center"></div></td>
      <td width="45"><div align="center"><b>%AFP</b></div></td>
      <td width="50"><div align="center"><b>&nbsp;</b></div></td>
      <td width="0" rowspan="4"><div align="center"></div></td>
      <td width="58"><div align="center"><b><? echo $porc_salud; ?>%<br>
          Salud<br>
          (Fonasa)</b></div></td>
      <td width="0" rowspan="4"><div align="center"></div></td>
      <td width="43"><div align="center"><b>Isapre<br>
          (UF)</b></div></td>
      <td width="50"><div align="center"><b>&nbsp;</b></div></td>
      <td width="0" rowspan="4"><div align="center"></div></td>
      <td width="75"><div align="center"><b>Valor Afect. U.I</b></div></td>
    </tr>
    <tr> 
      <td><input name="fecha1" type="text" size="12" maxlength="12" value="<? echo $fecha1; ?>" readonly></td>
      <td><input name="dias[1]" type="text" value="<? echo $dias[1]; ?>" size="3" maxlength="2" ></td>
      <td><input name="valor_imponible[1]" type="text" value="<? echo $valor_imponible[1]; ?>" size="11" maxlength="11"></td>
      <td><input name="porc_afp_1 "  type="text" value="<? echo $porc_afp;?>" size="5" maxlength="5"></td>
      <td><input name="valor_afp[1]" type="text" value="<? echo $valor_afp[1]; ?>" id="valor_afp[1]"  size="11" maxlength="11"></td>
      <td><input name="fonasa[1]" type="text" value="<? echo $fonasa[1]; ?>" size="11" maxlength="11"></td>
      <td><input name="isapre[1]" type="text" value="<? echo $uf_isapre;?>" size="5" maxlength="5"></td>
      <td><input name="valor_isapre[1]" type="text" value="<? echo $valor_isapre[1]; ?>" size="11" maxlength="11"></td>
      <td><input name="valor_afecto[1]" type="text" value="<? echo $valor_afecto[1]; ?>" size="15" maxlength="15"></td>
    </tr>
    <tr> 
      <td><input name="fecha2" type="text" size="12" maxlength="12" value="<? echo $fecha2; ?>" readonly></td>
      <td><input name="dias[2]" type="text" size="3" maxlength="2" value="<? echo $dias[2]; ?>"></td>
      <td><input name="valor_imponible[2]" type="text" value="<? echo $valor_imponible[2]; ?>" size="11" maxlength="11"></td>
      <td><input name="porc_afp_2 " type="text" value="<? echo $porc_afp;?>" size="5" maxlength="5"></td>
      <td><input name="valor_afp[2]" type="text" value="<? echo $valor_afp[2]; ?>" size="11" maxlength="11"></td>
      <td><input name="fonasa[2]" type="text" value="<? echo $fonasa[2]; ?>" size="11" maxlength="11"></td>
      <td><input name="isapre[2]" type="text" value="<? echo $uf_isapre;?>" size="5"></td>
      <td><input name="valor_isapre[2]" type="text" value="<? echo $valor_isapre[2]; ?>" size="11" maxlength="11"></td>
      <td><input name="valor_afecto[2]" type="text" value="<? echo $valor_afecto[2]; ?>" size="15" maxlength="15"></td>
    </tr>
    <tr> 
      <td><input name="fecha3" type="text" size="12" maxlength="12" value="<? echo $fecha3; ?>" readonly></td>
      <td><input name="dias[3]" type="text" value="<? echo $dias[3]; ?>" size="3" maxlength="3" ></td>
      <td><input name="valor_imponible[3]" type="text" value="<? echo $valor_imponible[3]; ?>" size="11" maxlength="11"></td>
      <td><input name="porc_afp_3 " type="text" value="<? echo $porc_afp;?>" size="5" maxlength="5"></td>
      <td><input name="valor_afp[3]" type="text" value="<? echo $valor_afp[3]; ?>" size="11" maxlength="11"></td>
      <td><input name="fonasa[3]" type="text" value="<? echo $fonasa[3]; ?>" size="11" maxlength="11"></td>
      <td><input name="isapre[3]" type="text" value="<? echo $uf_isapre; ?>" size="5"></td>
      <td><input name="valor_isapre[3]" type="text" value="<? echo $valor_isapre[2]; ?>" size="11" maxlength="11"></td>
      <td><input name="valor_afecto[3]" type="text" value="<? echo $valor_afecto[3]; ?>" size="15" maxlength="15"></td>
    </tr>
  </table>
  <br>
  <table border="1" align="center">
    <tr> 
      <td width="77"><div align="center"><b>Dias Licencia</b></div></td>
      <td width="15" rowspan="2"><div align="center"><b>x</b></div></td>
      <td width="86"><div align="center"><b>Valor Diario</b></div></td>
      <td width="13" rowspan="2"><div align="center"><b>=</b></div></td>
      <td width="84"><div align="center"><b>Total a Pagar</b></div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <input name="dias_licencia" value="<? echo $dias_licencia; ?>" type="text" size="10">
        </div></td>
      <td> <div align="center"> 
          <input name="valor_diario" value="<? echo $valor_diario; ?>" type="text" size="12">
        </div></td>
      <td> <div align="center"> 
          <input name="total_a_pagar" value="<? echo $total_a_pagar; ?>" type="text" size="12">
        </div></td>
    </tr>
  </table>
  <p>&nbsp; </p>
</form>
</body>
</html>
