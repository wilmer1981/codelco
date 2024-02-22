<!----
function insertapuntos(strval)
{
	var A = new Array();
	var strtemp = strval;
			
	strtemp = new Number(strtemp);
	strtemp = new String(strtemp);
	if (strtemp.length > 3)
	{
		for(var i = 0; strtemp.length > 3; i++)
		{
			A[i] = Right(strtemp,3);
			strtemp /= 1000;
			strtemp=new String(strtemp);
			if (strtemp.indexOf('.') != -1)
			{
      				strtemp = strtemp.substr(0,strtemp.indexOf('.'));
      			}
		}
		for(i-- ;i >= 0 ;i--)
		{
			strtemp = strtemp + "." + A[i];
		}
	}
	return(strtemp);			
}

function replace(s, t, u) {
  i = s.indexOf(t);
  r = "";
  if (i == -1) return s;
  r += s.substring(0,i) + u;
  if ( i + t.length < s.length)
    r += replace(s.substring(i + t.length, s.length), t, u);
  return r;
  }
  
function isEmpty(s)
{
	return ((s == null) || (s.length == 0))
}

function isDigit (c)
{
	return ((c >= "0") && (c <= "9"))
}

function isInteger (s)
{
	var i;
	if (isEmpty(s)) 
		if (isInteger.arguments.length == 1)
			return false;
	else
		return (isInteger.arguments[1] == true);
	for (i = 0; i < s.length; i++)
	{   
		var c = s.charAt(i);
		if (!isDigit(c)) return false;
	}
	return true;
}

function solonum()
{
	if ((event.keyCode<48)||(event.keyCode>57))
	{
		event.returnValue=false;
	}
}

function solonum_fono(ref)
{
	if (((event.keyCode == 45) && (ref.value.length == 2) && (ref.value != "2-")) || ((event.keyCode == 45) && (ref.value == "2")))
	{
		event.returnValue=true;
		return;
	}
	if ((event.keyCode<48)||(event.keyCode>57))
	{
		event.returnValue=false;
	}
}

function trim(variable)
{
	largo=variable.length;
	m=0;
	while (m<largo){
		caracter=variable.substring(m,m+1);
		if (caracter != " ")	
		{
			break;
		}
		m++;
	}
	if (m==largo)
	{
		return "";
	}
	n=0;
	while (n<largo)
	{
		caracter=variable.substring(largo-n-1,largo-n);
		if (caracter != " ")	
		{
			break;
		}
		n++;
	}
	variable=variable.substring(m,largo-n);
	return variable;
}

function borrar()
{
	document.formulario.reset();
}

function mail(texto)
{
	var supported = 0;
	booleano2=false;
	if (window.RegExp)
	{
		var tempStr = "a";
		var tempReg = new RegExp(tempStr);
		if (tempReg.test(tempStr)) supported = 1;
	}
	if (!supported) 
	{
		booleano2=(texto.indexOf(".") > 2) && (texto.indexOf("@") > 0);
		return booleano2;
	}
	var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
	var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
	booleano2=(!r1.test(texto) && r2.test(texto));
	return booleano2;
}

function buscarchar(cadena1,cadena2)
{
	var s = cadena1.indexOf(cadena2);
	return (s) ;
}

function Right(strvar,intcant)
{
	strtemp = "";
	intlargo = strvar.length -1;
	for(i = 1;i <= intcant; i++)
	{
		strtemp = strtemp + strvar.charAt(intlargo);
		intlargo--;	
	}
	strtmp2=""
	for(intlargo = strtemp.length -1; intlargo >=0; intlargo--)
	{
		strtmp2 = strtmp2 + strtemp.charAt(intlargo);
	}
	return(strtmp2);
}


// se utiliza
function ValidaCaracter(Tipo, Adicional, Enter)
{
		var strNumeros ="0123456789";
		var Minusculas = "abcdefghijklmnñopqrstuvwxyzáéíóú() ";
		var Mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ´´´";
		var Contrat = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ./-0123456789";
		var Espe = "áéíóúabcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ./-0123456789 ";
		var strTexto = Minusculas + Mayusculas + " " + "\r\n";
		var strAlfanumerico = strTexto + strNumeros + "/-_,;.:¿?¡!-()%#@";
		var strContrat = Contrat ;
		var strEspe = Espe ;
		var strMail = Minusculas + Mayusculas + strNumeros + "@_-.";
		var TextoTotal = new String();
		TextoTotal = Adicional;
		switch(Tipo){
			case "Numerico":{
				TextoTotal += strNumeros;
			break;	
			}
			case "Texto":{
				TextoTotal += strTexto;
			break;	
			}
			case "Alfanumerico":{
				TextoTotal += strAlfanumerico;
			break;	
			}
			case "Contrato":{
				TextoTotal = strContrat;
			break;	
			}
			case "Especialidad":{
				TextoTotal = strEspe;
			break;	
			}
			case "Email":{
				TextoTotal += strMail;
			break;	
			}
		}
					
		strCaracter = new String();
		strCaracter = String.fromCharCode(window.event.keyCode);
         	if (Enter) {     
              		if(window.event.keyCode==13) {
                   		revisar(document.formulario);
                   		return true;
              		}
         	}		
		var Pos = TextoTotal.indexOf (strCaracter);
		if(Pos > -1){
			return true;
		}else{
			window.event.keyCode = 0;
			return false;			
		}
}

// se utiliza
function ValidaCaracter_Asunto(Tipo, Adicional, Enter)
{
		var strNumeros ="0123456789";
		var Minusculas = "abcdefghijklmnñopqrstuvwxyzáéíóú() ";
		var Mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ´´´";
		var strTexto = Minusculas + Mayusculas + " ";
		var strAlfanumerico = strTexto + strNumeros + "/-_,;.@";
		var strMail = Minusculas + Mayusculas + strNumeros + "@_-.";
		var TextoTotal = new String();
		TextoTotal = Adicional;
		switch(Tipo){
			case "Numerico":{
				TextoTotal += strNumeros;
			break;	
			}
			case "Texto":{
				TextoTotal += strTexto;
			break;	
			}
			case "Alfanumerico":{
				TextoTotal += strAlfanumerico;
			break;	
			}
			case "Email":{
				TextoTotal += strMail;
			break;	
			}
		}
					
		strCaracter = new String();
		strCaracter = String.fromCharCode(window.event.keyCode);
         	if (Enter) {     
              		if(window.event.keyCode==13) {
                   		revisar(document.formulario);
                   		return true;
              		}
         	}		
		var Pos = TextoTotal.indexOf (strCaracter);
		if(Pos > -1){
			return true;
		}else{
			window.event.keyCode = 0;
			return false;			
		}
}

function ValidaCaracter2(Tipo, Adicional, Caracter)
{
		var strNumeros ="0123456789";
		var Minusculas = "abcdefghijklmnñopqrstuvwxyz";
		var Mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
		var strTexto = Minusculas + Mayusculas + " ";
		var strAlfanumerico = strTexto + strNumeros + "/-_,;.";
		var strMail = Minusculas + Mayusculas + strNumeros + "@_-.";
		var TextoTotal = new String();
		TextoTotal = Adicional;
		
		//alert(Caracter);
		switch(Tipo){
			case "Numerico":{
				TextoTotal += strNumeros;
			break;	
			}
			case "Texto":{
				TextoTotal += strTexto;
			break;	
			}
			case "Alfanumerico":{
				TextoTotal += strAlfanumerico;
			break;	
			}
			case "Email":{
				TextoTotal += strMail;
			break;
			}
		}
		strCaracter = new String();
		strCaracter = String.fromCharCode(Caracter);
		
		if (Caracter == 13){ 
		    revisar(document.formulario);
		
		}
		
		var Pos = TextoTotal.indexOf (strCaracter);
		if(Pos > -1){
			return true;
		}else{
			//window.event.keyCode = 0;
			return false;			
		}
}
	
function valiTexto(e) 
{
	key = "";
	key = e.which;
	tipo = e.id;
	if (	ValidaCaracter2('Texto','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}

function valiNumero(e) 
{
	key = "";
	key = e.which;
	tipo = e.id;
	if (	ValidaCaracter2('Numerico','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}

function valiAlfanumerico(e) 
{
	key = "";
	key = e.which;
	tipo = e.id;
	if (	ValidaCaracter2('Alfanumerico','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}
 
function valiEmail(e) 
{
	key = "";
	key = e.which;
	tipo = e.id;
	if (	ValidaCaracter2('Email','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}

function Captura(Tipo)
{
	if (navigator.appName == 'Netscape') 
	{
		if (Tipo == "T"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiTexto;
		}
		if (Tipo == "N"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiNumero;
		}
		if (Tipo == "A"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiAlfanumerico;
		}
		if (Tipo == "E"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiEmail;
		}
	}
}

function solorut(){
	if (navigator.appName != 'Netscape'){
		if (((event.keyCode>47)&&(event.keyCode<58))||(event.keyCode==75)||(event.keyCode==107)){
			event.returnValue=true;
		}else	{
			event.returnValue=false;
		}
	}
}

function rut(variable,digit)
{
	Sum = 0;
	digito = 0;
	factor = 2;
	largo = variable.length;
	while (largo !== 0)
	{
		Sum = Sum + (variable.substring(largo, largo-1) * factor);
		if (factor == 7)
			{
				factor = 2;
			}
		else
		{
			factor = factor + 1;
		}
		largo = largo - 1;
	}
	d = 11 - Sum % 11;
	if (d == "10")
	{
		digito = "K";
        }
	else 
	{
		if (d == "11")
		{
			digito = 0;
		}
		else
		{
			digito = d;
		}
	}
	if (digito == digit)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function formatear(forma)
{
	forma.prsn_id_temp.value=forma.prsn_id_temp.value.toUpperCase();
	if (forma.prsn_id_temp.value != "")
	{
		valor=forma.prsn_id_temp.value;
		forma.prsn_id.value=valor;
		if (valor.length > 1)
		{
			forma.prsn_id_temp.value=insertapuntos(valor.substring(0,valor.length - 1)) + '-' + valor.substring(valor.length - 1,valor.length);
		}
	}
}

function formatear2(forma)
{
	forma.prsn_id_temp.value=forma.prsn_id.value;
}

function ReemplazaPorSignoMas(arr)
{
	var nomemp = "";
	for (i=0;i<arr.length;i++)
	{
		if (arr.substring(i,i+1) == ' ')
		{
			nomemp = nomemp + '+'
		}
		else
		{
			nomemp = nomemp + (arr.substring(i,i+1))
		}
	}
	return(nomemp);
}

function ValidaCaracter_Hora(Tipo, Adicional, Enter)
{
		var strNumeros ="0123456789:";
		var Minusculas = "abcdefghijklmnñopqrstuvwxyzáéíóú() ";
		var Mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ´´´";
		var strTexto = Minusculas + Mayusculas + " ";
		var strAlfanumerico = strTexto + strNumeros + "/-_,;.@";
		var strMail = Minusculas + Mayusculas + strNumeros + "@_-.";
		var TextoTotal = new String();
		TextoTotal = Adicional;
		switch(Tipo){
			case "Numerico":{
				TextoTotal += strNumeros;
			break;	
			}
			case "Texto":{
				TextoTotal += strTexto;
			break;	
			}
			case "Alfanumerico":{
				TextoTotal += strAlfanumerico;
			break;	
			}
			case "Email":{
				TextoTotal += strMail;
			break;	
			}
		}
					
		strCaracter = new String();
		strCaracter = String.fromCharCode(window.event.keyCode);
         	if (Enter) {     
              		if(window.event.keyCode==13) {
                   		revisar(document.formulario);
                   		return true;
              		}
         	}		
		var Pos = TextoTotal.indexOf (strCaracter);
		if(Pos > -1){
			return true;
		}else{
			window.event.keyCode = 0;
			return false;			
		}
}

function replace2(s) {
	s = replace(s,'\r\n','|');
	s = replace(s,"'"," ");
	s = replace(s,'"',' ');
	s = replace(s,'<','(');
	s = replace(s,'>',')');
  	return s;
  }
  
function nombre_archivo_adjunto(nombre_archivo) {

	var matriz;	
	
	matriz = nombre_archivo.split("/");	
	return matriz[matriz.length - 1];
	
}

//COLOCA IMAGEN ASOCIADA AL TIPO DE LIBRO
function ver_tipo_libro(tipo_libro,especialidad)
{
	if (tipo_libro != '')
	{
		if ((tipo_libro == 'Maestro') || (tipo_libro == 'M'))
		{
			document.write('<img src="images/menu_botones/label_lod_maestro.gif" border="0">');
		}
		else if ((tipo_libro == 'Multidivisional') || (tipo_libro == 'D'))
		{
			document.write('<img src="images/menu_botones/label_lod_divisional.gif" border="0">');
		}
		else
		{
			document.write('<img src="images/menu_botones/label_lod_auxiliar.gif" border="0" alt="' + especialidad + '">');
		}
	}
	else
	{
		document.write('&nbsp;');
	}
}

//COLOCA IMAGEN ASOCIADA A LA DIVISION DEL LIBRO
function ver_division_libro(division_libro)
{
	if (division_libro != '')
	{
		if (division_libro == 'AN01')
		{
			document.write('<img src="images/menu_botones/label_andina.gif" border="0">');
		}
		else if (division_libro == 'MA01')
		{
			document.write('<img src="images/menu_botones/label_casa_matriz.gif" border="0">');
		}
		else if (division_libro == 'CH01')
		{
			document.write('<img src="images/menu_botones/label_codelco_norte.gif" border="0">');
		}
		else if (division_libro == 'TE01')
		{
			document.write('<img src="images/menu_botones/label_elteniente.gif" border="0">');
		}
		else if (division_libro == 'SL01')
		{
			document.write('<img src="images/menu_botones/label_salvador.gif" border="0">');
		}
		else
		{
			document.write('<img src="images/menu_botones/label_ventanas.gif" border="0">');
		}
	}
	else
	{
		document.write('&nbsp;');
	}
}
//Agrega la imagen de la division a partir del nombre de la division
function ver_division_libro_nombre(division_libro)
{
	if (division_libro != '')
	{
		if (division_libro == 'Andina')
		{
			document.write('<img src="images/menu_botones/label_andina.gif" border="0">');
		}
		else if (division_libro == 'Casa Matriz')
		{
			document.write('<img src="images/menu_botones/label_casa_matriz.gif" border="0">');
		}
		else if (division_libro == 'Codelco Norte')
		{
			document.write('<img src="images/menu_botones/label_codelco_norte.gif" border="0">');
		}
		else if (division_libro == 'Teniente')
		{
			document.write('<img src="images/menu_botones/label_elteniente.gif" border="0">');
		}
		else if (division_libro == 'Salvador')
		{
			document.write('<img src="images/menu_botones/label_salvador.gif" border="0">');
		}
		else
		{
			document.write('<img src="images/menu_botones/label_ventanas.gif" border="0">');
		}
	}
	else
	{
		document.write('&nbsp;');
	}
}


//------>
//CORTA A numero(variable) DE CARACTERES UNA CADENA DE STRING
function corta_caracteres(cadena,numero)
{
	var cortar, cadenafinal;
	cortar = cadena.length;
	if (cortar > numero)
	{
   		cadenafinal = cadena.substr(0, numero);  
		document.write(' '+ cadenafinal +'...');
	}
	else
	{
		cadenafinal = cadena;
		document.write(' '+ cadenafinal +'');
	}
}



function corta_caracteres2(cadena,numero)
{
	var cortar, cadenafinal;
	cortar = cadena.length;
	if (cortar > numero)
	{
   		cadenafinal = cadena.substr(0, numero);  
		return(''+ cadenafinal +'. ');
	}
	else
	{
		cadenafinal = cadena;
		return(''+ cadenafinal +'');
	}
}
//------>
//cuenta el numero de palabras existentes dentro de un string, considerando un caracter separador de palabras
  function cuenta_palabras(palabra, separador){ 
    var sTxt = palabra; 
    var sTx2 = ""; 
    var sSep = separador; 
    var iRes = 0; 
    var bPalabra = false; 
    for (var j = 0; j < sTxt.length; j++){ 
     if (sSep.indexOf(sTxt.charAt(j)) != -1){ 
      if (bPalabra) sTx2 += " "; 
      bPalabra = false; 
     } else { 
      bPalabra = true; 
      sTx2 += sTxt.charAt(j); 
     } 
    } 
    if (sTx2.charAt(sTx2.length - 1) != " ") sTx2 += " "; 
    for (var j = 0; j < sTx2.length; j++) 
     if (sTx2.charAt(j) == " ") iRes++; 
    if (sTx2.length == 1) iRes = 0; 
    return(iRes); 
   } 


//abrevia un string, por ejemplo, nombres: juan andres->j.p.,apellidos:perez gonzalez->perez g.
//donde valor=1 significa si se acorta todas las palabras a un caracter(en el caso de nombres) o valor=2 significa que 
//se mantiene la primera palabra  y las siguientes se acortan a un caracter(en el caso de los apelllidos)

function abrevia_cadena(cadena,valor)
{
	var cadena_final;
	var nueva_cadena=cadena;
	var contador=cuenta_palabras(cadena," ");

	if (contador > 1)//mas de una palabra
	{
		var arreglo=nueva_cadena.split(" ");
		var parte=0;

		if(valor == 1)//es nombre
		{
			var palabra_abreviada = corta_caracteres2(arreglo[0],1);//recorta solo el primer nombre a un caracter
			document.write(''+ palabra_abreviada +'');
		}
		if(valor == 2)//es apellido
		{
			while (parte < contador)
	 		{
				if(parte==0)
				{
					var palabra_completa = arreglo[parte];
					document.write(palabra_completa);
				}
				else
				{
					var palabra_abreviada = corta_caracteres2(arreglo[parte],1);
					document.write(' '+ palabra_abreviada +'');				
				}
			parte+=1;
			}
		}
	}
	else
	{
		if(valor == 1)//es nombre
		{
			var palabra_abreviada = corta_caracteres2(cadena,1);//recorta solo el primer nombre a un caracter
			document.write(''+ palabra_abreviada +'');
		}
		if(valor == 2)//es apellido
		{
			document.write(cadena);					
		}
	}
}

function tipo_libro_cabecera(tipo_libro)
{
	if (tipo_libro != '')
	{
		if ((tipo_libro == 'Maestro') || (tipo_libro == 'M'))
		{
			document.write('Maestro');
		}
		else if ((tipo_libro == 'Multidivisional') || (tipo_libro == 'D'))
		{
			document.write('Multidivisional');
		}
		else
		{
			document.write('Auxiliar');
		}
	}
	else
	{
		document.write('&nbsp;');
	}
}

document.write('<STYLE TYPE="text/css" MEDIA="print">.body_general {font-family: Verdana,Arial,Helvetica;font-size: 8pt;color:#666666;background-image: url();}</STYLE>')


