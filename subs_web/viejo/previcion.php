<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<Script languaje = "Javascript" src="funciones.js"></script>
<script language="JavaScript">
function guardar_prev(salvar){
    var f=document.form1;
	 /************Salvar_Afp*************/
if(salvar == 'A'){
	   if(f.combo_afp.value == "-1" || f.porcent_afp.value == ""){
	     alert("Existe un campo vacio\nIngrese un valor para continuar.");
	   }else{
	   f.action="proceso_prev.php?guardar=S"+"&combo_afp="+f.combo_afp.value+"&porcent="+f.porcent_afp.value+"&salvar="+salvar;
	   f.submit();
      } 
	 } 
	 /**********Salvar_Isapre**********/
	 if(salvar == 'I'){
	  if((f.nombre_isa.value == "") || (f.rut_isa.value == "") || (f.dv.value == "")){
	  alert("Existe un campo vacio\nVerifique los valores para continuar");
	  }else{
	  	resp = (RutValido(f.rut_isa.value, f.dv.value));
		if(resp){
		    if (f.convenio[0].checked){
				 var conv='S';
			}else if (f.convenio[1].checked){
					  var conv='N';
			}		
	   		f.action="proceso_prev.php?guardar=S"+"&nombre_isa="+f.nombre_isa.value+"&rut_isa="+f.rut_isa.value+"&dv="+f.dv.value+"&convenio="+conv+"&salvar="+salvar;
	   		f.submit();
      	}else{
			f.nombre_isa.value = "";
			f.rut_isa.value = "";
			f.dv.value = "";
		}
	   }  
	 }		
	 /*********Salvar_Fonasa***********/
	  if(salvar == 'F'){
		  if(f.porc_fonasa.value != ""){
		  f.action="proceso_prev.php?guardar=S"+"&porc_fonasa="+f.porc_fonasa.value+"&fecha="+f.fecha.value+"&salvar="+salvar;
	   	  f.submit();
	   }else{
	   	  alert("El Porcentaje FONASA esta vac�o\nIngrese un valor para continuar.");
	   }
      }  	
}
function limpiar(opcion){
	var f= document.form1;
	if(opcion == 'A'){
		f.nombre_afp.value = "";
		f.porcent_afp.value = "";
	}
	if(opcion == 'I'){
		f.nombre_isa.value = "";
		f.rut_isa.value = "";
		f.dv.value = "";
	}
	if(opcion == 'F'){
		f.porc_fonasa.value = "";
	}
}

/****Funcion de recarga*******/
function recarga(){
	var f = document.form1;
	f.action = "main.php?combo_afp=" + f.combo_afp.value;
	f.submit();
}
/****Funcion de PopUp A******/
function popup(letra){
	var f = document.form1;
	if (letra =="A"){
	window.open("popup_afp.php",""," fullscreen=no,left=165,top=100,width=330,height=370,scrollbars=yes,resizable = no");
	}
	if (letra =="I"){
	window.open("popup_isapre.php",""," fullscreen=no,left=165,top=100,width=330,height=370,scrollbars=yes,resizable = no");
	}
}
/*****************************/
</script>
</head>

<body>
<form name="form1" method="post" action="">
   <p align="center"><strong><br>
   <input name="valor" type="hidden" value="previcion.php">
    Ingreso Datos Previcionales<br>
    </strong></p>
  <p align="center"><a href="main.php?valor=previcion.php&tipo=afp">AFP</a><br>
    <a href="main.php?valor=previcion.php&tipo=isa">Isapre</a><br>
    <a href="main.php?valor=previcion.php&tipo=fon">Fonasa</a></p>
  <p align="center"><strong> 
  		
    <? if($tipo=='afp'){?>
	<input name="tipo" type="hidden" value="afp">
    </strong></p>
    <table width="328" border="1" align="center">
    <tr> 
<!-- ***************Combo AFP***********************/	-->
      <td width="96">Nombre AFP:</td>
      <td width="216"><SELECT name="combo_afp" onChange="recarga()">
          <option value='-1'>Seleccionar...</option>
 <? 
	include("cerrar.php"); // Cerrar base de datos SUBSWEB
	include("conectar_rrhh.php");
		  
			$consulta = "Select * from bd_rrhh.afp order by afp asc";
			$var = mysql_query($consulta);
				while($row = mysql_fetch_array($var)){
					if($row[COD_AFP] == $combo_afp){
					echo '<option value ="'.$row[COD_AFP].'" SELECTed>'.$row[AFP].' </option>';
					}else{
					echo '<option value ="'.$row[COD_AFP].'">'.$row[AFP].' </option>';
					}
				}
	include("cerrar_rrhh.php");// Cerrar base de datos RRHH
	include("conectar.php");

	  			$consulta = "Select porcent_afp from subs_web.afp where cod_afp = '".$combo_afp."'";
				$var = mysql_query($consulta);
				$row = mysql_fetch_array($var); 
				$porcent_afp =$row[porcent_afp];
				
	  ?>
</SELECT></td>
    </tr>
    <tr> 
      <td>Porcentaje :</td>
      <td><input name="porcent_afp" value="<? echo $porcent_afp ; ?>" type="text" size="6" maxlength="5" onKeyDown="TeclaPulsada(true)">
        % </td>
    </tr>
  </table>
  <br><center>
      <input type="button" name="Submit" value="Guardar" style="width:75" onClick="guardar_prev('A')">
      <input type="button" name="Submit2" value="Limpiar" style="width:75" onClick="limpiar('A') ">
    <br>
    <br>
    <input type="button" name="Submit3" value="Listar Valores AFP" style="width:155" onClick="popup('A') ">
  </center>
  <br>
  <br>
 <? } if($tipo=='isa'){?>
  <table width="328" height="81" border="1" align="center">
    <tr> 
      <td width="96" height="26">Nombre Isapre:</td>
      <td width="216"><input name="nombre_isa" type="text" size="40" maxlength="25">
      </td>
    </tr>
    <tr> 
      <td height="26">Rut Isapre:</td>
      <td><input name="rut_isa" type="text" size="10" maxlength="8" onKeyDown="TeclaPulsada('false')">
        - 
        <input name="dv" type="text" id="dv" size="1" maxlength="1" > </td>
    </tr>
    <tr> 
      <td height="25">Convenio:</td>
      <td><input type="radio" name="convenio" value="S">
        Si
        <input type="radio" name="convenio" value="N" checked>
        No</td>
    </tr>
  </table>
  <br><center>
    <input type="button" name="Submit" value="Guardar" style="width:75" onClick="guardar_prev('I')">
    <input type="button" name="Submit2" value="Limpiar" style="width:75" onClick="limpiar('I')">
    <br>
    <br>
    <input type="button" name="Submit32" value="Listar Valores Isapre" style="width:155" onClick="popup('I') ">
  </center>
  <br>
  <br>
 <? } if($tipo=='fon'){ ?>
  <table width="328" border="1" align="center">
    <tr> 
      <td width="27%">Fonasa (Salud):</td>
	  <? $consulta = "SELECT porcent as mayor from subs_web.fonasa where fecha=(SELECT max(fecha) from subs_web.fonasa) and cod_fonasa=(SELECT max(cod_fonasa) from subs_web.fonasa)";
	  $respuesta = mysql_query($consulta);
	  $row=mysql_fetch_array($respuesta);
	  /*fecha*/
	  $fecha_ingreso = date("Y")."-".date("m")."-".date("d");
	  ?>
      <td width="58%"><input name="porc_fonasa" type="text" size="10" maxlength="6" value="<? echo $row["mayor"]; ?>" onKeyDown="TeclaPulsada(true)" >
        % 
        <input type="hidden" name="fecha" value="<? echo $fecha_ingreso;?>"></td>
    </tr>
  </table>
  <div align="center"><br>
    <br>
    <input type="button" name="Submit" value="Guardar" style="width:75" onClick="guardar_prev('F')">
    <input type="button" name="Submit2" value="Limpiar" style="width:75" onClick="limpiar('F')">
   </div>
    <? } ?>
  <p>&nbsp;</p>
</form>
</body>
</html>
