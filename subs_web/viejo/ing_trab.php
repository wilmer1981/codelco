<? include("conectar.php") ;
if(($rut)&&($dv)){
	$rut_dv = $rut."-".$dv;
	/*****Consulta Nombre********/
	  $buscar="SELECT apellido_paterno, apellido_materno, nombres, cod_centro_costo from proyecto_modernizacion.funcionarios where (rut='".$rut_dv."')";
	  $respuesta = mysql_query($buscar);
	  if($row=mysql_fetch_array($respuesta)){
		  $ap_paterno = $row["apellido_paterno"];
		  $ap_materno = $row["apellido_materno"];
		  $nombres = $row["nombres"];
		  
		  $c_costo = $row[cod_centro_costo];
		  $c_costo = str_replace('.','', $c_costo); // Elimina puntos
		  $c_costo = substr($c_costo,3,6); // Corta los 3 primeros caracteres

	/*****Consulta Centro Costo****/
	  $buscar_cc="SELECT descripcion from proyecto_modernizacion.centro_costo where (centro_costo='".$c_costo."')";
	  $respuesta_cc = mysql_query($buscar_cc);
	  $row=mysql_fetch_array($respuesta_cc);
	  $descrip = $row["descripcion"];

	/********Consulta Previcion****************/
	include("cerrar.php");
	include("conectar_rrhh.php"); // Conectar a base de datos rrhh
	
	//  $buscar_afp = "SELECT AFP from bd_rrhh.afp where COD_AFP = (SELECT COD_AFP from bd_rrhh.antecedentes_personales where RUT =('".$rut."-".$dv."'))"; 
   $buscar_afp = "SELECT AFP from bd_rrhh.afp as t1 inner join antecedentes_personales as t2 on t1.COD_AFP = t2.COD_AFP where RUT = ('".$rut."-".$dv."')";
	  $respuesta_afp = mysql_query($buscar_afp);
	  $row = mysql_fetch_array($respuesta_afp);
	  $nom_afp = $row[AFP];

//	  $buscar_isa = "SELECT ISAPRE from bd_rrhh.ISAPRE where COD_ISAPRE = (SELECT COD_ISAPRE from bd_rrhh.antecedentes_personales where RUT =('".$rut."-".$dv."'))"; 
	  $buscar_isa= "SELECT ISAPRE from bd_rrhh.isapre as t1 inner join antecedentes_personales as t2 on t1.COD_ISAPRE = t2.COD_ISAPRE where (RUT='".$rut."-".$dv."')";
	  $respuesta_isa = mysql_query($buscar_isa);
	  $row = mysql_fetch_array($respuesta_isa);
	  $nom_isapre = $row[ISAPRE];

     include("cerrar_rrhh.php"); // Cerrar base de datos RRHH
	 include("conectar.php") ;
	 /*****************************************/
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
	  }else{
	  echo ' <script languaje = "Javascript">' ;
	  echo ' alert ("El trabajador buscado no se encuentra en la base de datos.");';
	  echo ' </script>';
	  }
}
if(($opcion == "GF")&&($rut_dv)){
   while(list($clave,$valor) = each($desde_lic)){
	  $cadena = explode("/", $desde_lic[$clave]); // Poner fecha en formato BBDD.
	  $desde_lic[$clave] = $cadena[2]."-".$cadena[1]."-".$cadena[0];
	  
  	  $cadena = explode("/", $hasta_lic[$clave]); // Poner fecha en formato BBDD.
	  $hasta_lic[$clave] = $cadena[2]."-".$cadena[1]."-".$cadena[0];

	  $pagado_lic[$clave] = str_replace('.','', $pagado_lic[$clave]); // Elimina puntos a los miles	
	  $insertar = "INSERT INTO subs_web.licencias (rut,desde,hasta,dias,valor) values ('".$rut_dv."','".$desde_lic[$clave]."','".$hasta_lic[$clave]."','".$dias_lic[$clave]."','".$pagado_lic[$clave]."')";
	  $consulta = mysql_query($insertar);
	}
	for($i=1; $i<4; $i++){
		$fecha_liq = date("Y-m-d", mktime(0,0,0,$Mes - $i,25,$ano));
		$pagado[$i] = str_replace('.','', $pagado[$i]);
		$insertar="INSERT INTO subs_web.liquidacion (rut, fecha, dias, pagado) values ('".$rut_dv."','".$fecha_liq."','".$num_dias[$i]."','".$pagado[$i]."')";
		$consulta = mysql_query($insertar);
	}
	/*****Enviar datos a pagina valor diario ***********/
	echo '<script languaje = "Javascript">';
	echo 'var f = document.form1;';
	echo 'f.submit();';
	echo '</script>';					 
}
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<Script languaje = "Javascript" src="funciones.js">/* Validador Puntitos */</script>
<Script languaje = "Javascript" src="script_fecha.js">/* Validador fechas ##/##/#### */</script>
<Script languaje = "Javascript">
/*********************************************************/
function buscar_rut()//Busca rut en la base de datos.
{
var f = document.form1;
/*	if(f.digito.value =='k'){
		f.digito.value = (toUpperCase(f.digito.value));
	} */
	resp = (RutValido(f.rut.value, f.dv.value));
	if(resp){
		f.action = "main.php?valor=ing_trab.php";
		f.submit();
	}else{
		f.rut.value = "";
		f.dv.value = "";
	}
}
/*************************************************/
// Valida que la cantidad de dias no sea mayor a 31
function validar_dias(){
	var f = document.form1;
	if (f.num_dias[1].value > 31){
		alert("El mes NO tiene m�s de 31 dias!!");
		f.num_dias[1].value = "";
		f.num_dias[1].focus(); }
	if (f.num_dias[2].value > 31 ){
 		alert("El mes NO tiene m�s de 31 dias!!");
		f.num_dias[2].value = "";
		f.num_dias[2].focus();}	
	if (f.num_dias[3].value > 31 ){
 		alert("El mes NO tiene m�s de 31 dias!!");
		f.num_dias[3].value = "";
		f.num_dias[3].focus(); }			
}
/******************Agregar**********************/
function agregar(numero){ //Agregar Fila Licencia
   var f = document.form1;
   numero = numero + 1;
	f.action = "main.php?opcion=AF&n=" + numero + "#punto";
	f.submit();
}
/******************Borrar**********************/
function borrar(numero){ //Borrar Fila Licencia
	var f = document.form1;
	if (numero >= 1){
    	numero = numero - 1;
		f.action = "main.php?opcion=AF&n=" + numero +"#punto" ;
		f.submit();
		}
}
/****************Guardar Datos*****************/
 function guardar_info_lic(){//Guarda los datos de la pagina
	var f = document.form1;
	f.action = "main.php?opcion=GF&rut_dv="+ f.rut_dv.value + "&fecha_acc=" +f.fecha_acc.value + "&valor=valor_diario.php";
	f.submit();	
}
/*********************************************/
</script>
</head>

<body>
<form action="" method="post" name="form1" id="form1">
  
  <p align="center"> <strong>
    <input type="hidden" name="valor" value="ing_trab.php" ><!-- recarga la misma pagina-->
    <br>
    Informaci&oacute;n Del Accidentado</strong></p> 
  <table width="425" border="1" align="center" bgcolor="#FFFFCC" id="dv">
    <tr>
      <td>Ingrese Rut:</td>
      <td width="277" colspan="3"><input name="rut" type="text" id="rut" size="10" maxlength="8" value="<? echo $rut; ?>">
        - 
        <input name="dv" type="text" id="dv" size="1" maxlength="1" value="<? echo $dv; ?>"> 
        <input type="button" name="Submit" value="Buscar" onClick="buscar_rut()"> 
        <input name="rut_dv" type="hidden" value="<? echo $rut.'-'.$dv;?> ">
      </td>
    </tr>
    <tr> 
      <td width="155">Ingrese Fecha Accidente:</td>
      <td colspan="3"><SELECT name="dia" >
          <? for ($i=1;$i<=31;$i++){
					if (isset($dia)){
					   if ($i == $dia)
						   echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}else{
						if ($i == date("j"))
						   echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				}
		 ?>
        </SELECT> <SELECT name='Mes'>
          <? for ($i=1;$i<=12;$i++){
			  if (isset($Mes)){
				   if ($i == $Mes)
					   echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
					  else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
				}else{
					if ($i == date("n"))
					   echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
			  		}
			  }
			?>
        </SELECT> <SELECT name="ano">
          <?   for ($i=date("Y");$i<=date("Y")+1;$i++){
				 if (isset($Mes)){
					   if ($i == $ano)
							echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
						  else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}else{
						if ($i == date("Y"))
							 echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				  }
			   ?>
        </SELECT>
        <input name="fecha_acc" type="hidden" value="<? echo $ano.'-'.$Mes.'-'.$dia;?> "> 
      </td>
    </tr>
  </table>
  <br>
  <br>
  <table width="475" border="1" align="center" id="dv">
    <tr> 
      <td width="75">Nombres:</td>
      <td width="152"> <input name="nombres" type="text" value="<? echo $nombres = ucwords ($nombres);?>" size="25" maxlength="50" readonly>
      </td>
      <td width="67">Apellidos:</td>
      <td width="150"> <input name="apellidos" type="text" value="<? echo $ap_paterno = ucwords($ap_paterno)." ".$ap_materno = ucwords($ap_materno); ?>" size="25" maxlength="50" readonly></td>
    </tr>
    <tr> 
      <td>Centro Costo:</td>
      <td colspan="3"><input name="c_costo" type="text" value="<? echo $c_costo ;?>" size="4" maxlength="6" readonly>
        - 
        <input type="text" name="descrip" value="<? echo $descrip = ucwords($descrip) ; ?>" size="50" maxlength="100" readonly>
      </td>
    </tr>
    <tr> 
      <td>AFP:</td>
      <td colspan="2"><input name="nom_afp" type="text" value="<? echo $nom_afp = ucwords($nom_afp) ;?>" size="40" maxlength="45" readonly></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Isapre:</td>
      <td colspan="2"><input name="nom_isapre" type="text" value="<? echo $nom_isapre = substr($nom_isapre,1,40); $nom_isapre = ucwords ($nom_isapre) ; ?>" size="40" maxlength="45" readonly></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
  <br>
  <table width="310" border="1" align="center">
    <tr> 
      <td colspan="4"><strong>D�as de Licencia</strong></td>
    </tr>
    <tr> 
      <td width="28%">Desde:</td>
      <td width="28%">Hasta:</td>
      <td width="16%">D&iacute;as:</td>
      <td width="28%">Valor:</td>
    </tr>
    <tr> 
      <td colspan="4"> 
	  <? if($opcion=='AF'){// Si opcion es AF agregar Fila
		   for($i=0;$i<$n;$i++){

			  $punt = "puntitos(this,this.value.charAt(this.value.length-1))";
			  $df1 = "DateFormat(this,this.value,event,true, 3)";
			  $df2 = "DateFormat(this,this.value,event,false, 3)";
			  $js = "javascript:vDateType=3";
			  
		  echo '<tr align="center">';
		  echo '<td><input type="text" name="desde_lic['.$i.']" value="'.$desde_lic[$i].'" size="11" maxlength="10" onblur="'.$df1.'" onkeyup="'.$df2.'" onfocus="'.$js.'"></td>';
		  echo '<td><input type="text" name="hasta_lic['.$i.']" value="'.$hasta_lic[$i].'"size="11" maxlength="10" onblur="'.$df1.'" onkeyup="'.$df2.'" onfocus="'.$js.'"></td>';
		  echo '<td><input type="text" name="dias_lic['.$i.']" value="'.$dias_lic[$i].'" size="4" maxlength="3"></td>' ;
		  echo '<td><input type="text" name="pagado_lic['.$i.']" value="'.$pagado_lic[$i].'" size="11" maxlength="10" onKeyUp="'.$punt.'" > </td>';
		  echo '</tr>';
		  $num = $n;
		  $valor = "";
		}
	  }	
	  ?>
        </td>
    </tr>
    <tr> 
      <td colspan="4"><div align="center">
          <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
          <div align="left"></div>
          <div align="left"> <font face="Arial, Helvetica, sans-serif"> </font></div>
          <div align="left"></div>
          <div align="center"><font face="Arial, Helvetica, sans-serif"> 
		  <? if ($num=='')
		       {$num=0;} ?>
           <input name="boton_agregar" type="button" value="Agregar Fila" style="width:100" onClick="agregar(<? echo $num;?>)">
            <input name="boton_borrar" type="button" value="Eliminar Fila" style="width:100" onClick="borrar(<? echo $num ; ?>)">
            </font></div>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <br>
  <table width="310" border="1" align="center">
    <tr> 
      <td colspan="3"><strong>Liquidaciones</strong></td>
    </tr>
    <tr> 
      <td width="108">Fecha Liquidaci&oacute;n:</td>
      <td width="82">Dias:</td>
      <td width="98">Pagado:</td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <input name="fecha1" type="text" size="12" maxlength="12" value="<? echo $fecha1; ?>" readonly>
        </div></td>
      <td><div align="center"> 
          <input name="num_dias[1]" type="text" size="4" maxlength="2" value="<? echo $num_dias[1]; ?>">
        </div></td>
      <td><div align="center"> 
          <input name="pagado[1]" type="text" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="<? echo $pagado[1]; ?>" size="11" maxlength="10">
        </div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <input name="fecha2" type="text" size="12" maxlength="12" value="<? echo $fecha2; ?>" readonly>
        </div></td>
      <td><div align="center"> 
          <input name="num_dias[2]" type="text" size="4" maxlength="2" value="<? echo $num_dias[2]; ?>">
        </div></td>
      <td><div align="center"> 
          <input name="pagado[2]" type="text" size="11" maxlength="10" value="<? echo $pagado[2]; ?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))">
        </div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <input name="fecha3" type="text" size="12" maxlength="12" value="<? echo $fecha3; ?>" readonly>
        </div></td>
      <td><div align="center"> 
          <input name="num_dias[3]" type="text" size="4" maxlength="2" value="<? echo $num_dias[3]; ?>">
        </div></td>
      <td><div align="center"> 
          <input name="pagado[3]" type="text" size="11" maxlength="10" value="<? echo $pagado[3]; ?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))">
        </div></td>
    </tr>
  </table>
  <br>
  <br>
  <table width="50%" border="1" align="center">
    <tr> 
      <td><strong>Saldo a favor</strong></td>
    </tr>
    <tr> 
      <td>Saldo a favor de X por 
        <input type="text" name="textfield5"></td>
    </tr>
  </table>
  <p align="center"> 
    <input type="button" name="Submit3" value="Guardar los datos y realizar el calculo del subsidio." onClick="guardar_info_lic()">
  </p>
  <p align="center">&nbsp; </p>
</form>
</body>
</html>
