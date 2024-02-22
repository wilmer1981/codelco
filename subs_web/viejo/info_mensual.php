<html>
<head>
<title>UF - Impuesto Unico</title>
<script javacript language="JavaScript" src="funciones.js">/* puntitos*/</script>
<script javacript language="JavaScript">
/* Activar modificar factor*/
function detalles(){
	var f = document.form1;
	if (f.boton_iu.value == "Ingreso Imp. Unico"){
	   f.action="main.php?valor=info_mensual.php&var=2&opciones=N&valor_uf="+f.valor_uf.value;
	   f.submit();
	}
	if (f.boton_iu.value == "Ocultar Imp. Unico"){
	   f.action="main.php?valor=info_mensual.php&var=1&opciones=S";
	   f.submit();
	}
}
/****************Guardar_Impuesto_Unico(UF)*********************/
function guardar_iu(){
	var f = document.form1;
	if (f.boton_iu.value == "Ingreso Imp. Unico"){ //* Abre Ingreso Uf
		if(f.valor_uf.value != ""){ // Si valor uf es distinto de vacio...
		  f.action="proceso_im.php?guardar=uf"+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&valor_uf="+f.valor_uf.value;
      	  f.submit();
		}else{
	  	  alert("El campo de la UF esta vacio\nIngrese un valor para continuar");
	    }}
	if (f.boton_iu.value == "Ocultar Imp. Unico"){ /* Abre Ingreso a Uf y Impuesto Mensual */
		for(i=5;i<=35;i++){
			if(f.elements[i].value == ""){
				alert("Existe un campo vacio, verifique e\ningrese un valor para continuar");
				f.elements[i].focus();
				return;
				}
		}
		 if(f.valor_uf.value == ""){ /* Guarda Im pero no Uf*/
   		 var estado = confirm("El campo de la UF esta vac�o\n�Desea Continuar?\n\n(Solo se ingresara el impuesto unico, no la UF.)");
		    if(estado){
			 f.action="proceso_im.php?guardar=im";
			 f.submit();
			}else{
			f.valor_uf.focus();
			}
		}
		 if(f.valor_uf.value != ""){ /* Guarda Im y Uf */
		     f.action="proceso_im.php?guardar=ui"+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&valor_uf="+f.valor_uf.value;
			 f.submit();
		 }   
   }
}	
/************************LIMPIAR_PANTALLA*****************************/
function limpiar_iu(){
var f = document.form1;
	f.valor_uf.value = "";
	if (f.boton_iu.value == "Ocultar Imp. Unico"){
		var x = 6;
		for(i=4;i<=35;i++){
			if(i!=(6*i)){
			f.elements[i].value = "";
			}
		}
	}
}
/************************Copia_Desde_-_Hasta****************************/
function copiar(){
var f = document.form1;
	var col = 4;
	f.elements[col].value = "0";
	f.elements[col+29].value = "y M�s...";
	if(f.elements[col+1].value != ""){
		f.elements[col+4].value = f.elements[col+1].value;
		}
	if((f.elements[col+5].value != "")&&(f.elements[col+5].value > f.elements[col+1].value)){
		f.elements[col+8].value = f.elements[col+5].value;
		}
	if((f.elements[col+9].value != "")&&(f.elements[col+9].value > f.elements[col+5].value)){
		f.elements[col+12].value = f.elements[col+9].value;
		}
	if((f.elements[col+13].value != "")&&(f.elements[col+13].value > f.elements[col+9].value)){
		f.elements[col+16].value = f.elements[col+13].value;
		}
	if((f.elements[col+17].value != "")&&(f.elements[col+17].value > f.elements[col+13].value)){
		f.elements[col+20].value = f.elements[col+17].value;
		}
	if((f.elements[col+21].value != "")&&(f.elements[col+21].value > f.elements[col+17].value)){
		f.elements[col+24].value = f.elements[col+21].value;
		}
	if((f.elements[col+25].value != "")&&(f.elements[col+25].value > f.elements[col+21].value)){
		f.elements[col+28].value = f.elements[col+25].value;
		}
}
</script>
</head>

<body>
<form action="" method="post" name="form1" id="form1">
  <p align="center"><strong><br>
    Ingreso de Valores Mensuales UF - Impuesto Unico</strong></p>
  <table width="350" border="1" align="center" bgcolor="#FFFFCC">
    <tr bgcolor="#FFFFCC"> 
      <td width="75"><strong>Mes:</strong></td>
      <td width="86"><SELECT name="mes1" size="1" id="SELECT">
      
		  <?
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	for($i=1;$i<13;$i++){
	   if (isset($mes1)){
		 if ($i == $mes1)
		    echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
		 else
		    echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
		}else{
		if ($i == date("n"))
		   echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
		else
		   echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
		}						
	 }
	?>
        </SELECT> 
	  
	  </td>
      <td width="67"><strong>A&ntilde;o: </strong></td>
      <td width="94"><strong> 
        <SELECT name="ano1" size="1" id="SELECT2">
          <?
	  for ($i=date("Y")-1;$i<=date("Y")+1;$i++){
		 if (isset($ano1)){
			if ($i == $ano1)
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
        </strong></td>
    </tr>
    <tr bgcolor="#FFFFCC"> 
      <td><strong>Valor UF :</strong></td>
      <td><input name="valor_uf" type="text" id="valor_uf2" size="10" maxlength="6" style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="<? echo $valor_uf;?>" ></td>
      <td colspan="2"><div align="center">
       <?    
         if(($opciones == "S") || ($opciones == "")){
			echo '<input type="button" name="boton_iu" value="Ingreso Imp. Unico" onClick="detalles()"> ';

         }else{
   			echo '<input type="button" name="boton_iu" value="Ocultar Imp. Unico" onClick="detalles()"> ';
		}
		?>
		</div></td>
    </tr>
  </table>
  <br>
  <!-- Carga de Campos Impuesto Mensual  -->
  <? if(($var=='2') && ($var !="")){ ?>
  <table width="350" border="1" align="center">
    <tr bgcolor="#FFFFCC"> 
      <td colspan="2"><div align="center"><strong>Monto de la Renta<br>
          Liquida Imponible</strong></div></td>
      <td width="81" rowspan="2"><div align="center"><strong>Factor</strong></div></td>
      <td width="80" rowspan="2"><div align="center"><strong>Cantidad a Rebajar</strong></div></td>
    </tr>
    <tr bgcolor="#FFFFCC"> 
      <td width="79"><div align="center"><strong>Desde</strong></div></td>
      <td width="82"><div align="center"><strong>Hasta</strong></div></td>
    </tr>
    <tr> 
      <td colspan="4"><div align="center"> 
  <?  if(strlen($mes1) == '1'){
	  			$mes1 = '0'.$mes1;
				}
	  $fecha_min = $ano1."-".$mes1."-01";
	  $fecha_max = $ano1."-".$mes1."-31";	 
	  $consulta = "SELECT factor FROM subs_web.detalle_mes WHERE (fecha >= '".$fecha_min."') and (fecha <= '".$fecha_max."') GROUP BY fecha, posicion";
	  $respuesta = mysql_query($consulta);
	  $consulta = mysql_query($consulta);
	 if($fila=mysql_fetch_array($consulta)){
	   $i='0';
	   while($row=mysql_fetch_array($respuesta)){
		  echo '<tr align="center">';
		  echo '<td><input type="text" name="desde['.$i.']" size="10" maxlength="9" readonly></td>';
		  echo '<td><input type="text" name="hasta['.$i.']" size="10" maxlength="9" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" onBlur="copiar()"></td>';
		  echo '<td><input type="text" name="factor['.$i.']" size="10" maxlength="6" value="'.$row[factor].'"></td>';
		  echo '<td><input type="text" name="rebaja['.$i.']" size="10" maxlength="9" ></td>';
	 	  echo '</tr>';
		  $i++;
        }
	  }else{
	  $respuesta = mysql_query($consulta);
 	  $consulta = "SELECT factor FROM subs_web.detalle_mes WHERE fecha = (SELECT max(fecha) from subs_web.detalle_mes) GROUP BY fecha, posicion";
	  $respuesta = mysql_query($consulta);
	  $i='0';
	  while($row=mysql_fetch_array($respuesta)){
		  echo '<tr align="center">';
		  echo '<td><input type="text" name="desde['.$i.']" size="10" maxlength="9" readonly></td>';
		  echo '<td><input type="text" name="hasta['.$i.']" size="10" maxlength="9" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" onBlur="copiar()"></td>';
		  echo '<td><input type="text" name="factor['.$i.']"size="10" maxlength="6" value="'.$row[factor].'"></td>';
		  echo '<td><input type="text" name="rebaja['.$i.']" size="10" maxlength="9"></td>';
	 	  echo '</tr>';
		  $i++;
	  }
	 }
	  ?>
        </div>
        <div align="center"> </div>
        <div align="center"> </div>
        <div align="center"> </div></td>
    </tr>
  </table>
  <p align="center">
    <? } ?>
    <br>
    <center>
      <input type="button" name="Submit" value="Guardar" style="width:75" onClick="guardar_iu(this.form);">
      <input type="button" name="Submit2" value="Limpiar" style="width:75" onClick="limpiar_iu()">
    </center>
  </p>
</form>
</body>
</html>
