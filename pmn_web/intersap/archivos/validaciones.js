<!--
function MenosPuntos(strval){
	var strtemp="";
	var strcopia = strval;
	for(var intpos = 0; intpos < strval.length; intpos++)
		if ((strval.charAt(intpos) != ".") && (strval.charAt(intpos) != ","))
			strtemp = strtemp + strval.charAt(intpos)
		if (strtemp == "")
			return(strcopia);
		return(strtemp);
}

function trim(variable){
	largo=variable.length;
	m=0;
	while(m<largo){
		caracter=variable.substring(m,m+1);
		if(caracter != " "){
			break;
		}
		m++;
	}
	if(m==largo){
		return "";
	}
	n=0;
	while(n<largo){
		caracter=variable.substring(largo-n-1,largo-n);
		if (caracter != " "){
			break;
		}
		n++;
	}
	variable=variable.substring(m,largo-n);
	return variable;
}

function solorut(){
	if(((event.keyCode>47)&&(event.keyCode<58))||(event.keyCode==75)||(event.keyCode==107)){
		event.returnValue=true;
	}else{
		event.returnValue=false;	
	}
}

function solonum(){
	if((event.keyCode>47)&&(event.keyCode<58)){
		event.returnValue=true;
	}else{
		event.returnValue=false;	
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
	forma.rut_temp.value=forma.rut_temp.value.toUpperCase();
	if (forma.rut_temp.value != "")
	{
		valor=forma.rut_temp.value;
		forma.rut.value=valor;
		if (valor.length > 1)
		{
			forma.rut_temp.value=insertapuntos(valor.substring(0,valor.length - 1)) + '-' + valor.substring(valor.length - 1,valor.length);
		}
	}
}

function formatear_e()
{
	document.registro.rut_temp.value=document.registro.rut_temp.value.toUpperCase();
	if (document.registro.rut_temp.value != "")
	{
		valor=document.registro.rut_temp.value;
		document.registro.rut.value=valor;
		if (valor.length > 1)
		{
			document.registro.rut_temp.value=insertapuntos(valor.substring(0,valor.length - 1)) + '-' + valor.substring(valor.length - 1,valor.length);
		}
	}
}

function formatearb(forma)
{
	forma.rut_temp.value=forma.rut.value;
}


//function formatear2(forma)
//{
	//forma.rut_temp.value=forma.rut_temp.value.toUpperCase();
	//forma.rut_temp.value=forma.rut.value;
//}

function formatearrutayuda(forma)
{
	//forma.rut_temp.value=forma.rut_temp.value.toUpperCase();
	forma.rut_temp.value=forma.rut.value;
}


function Right(strvar,intcant){
	strtemp = "";
	intlargo = strvar.length -1;
	for(i=1;i<=intcant;i++){
		strtemp = strtemp + strvar.charAt(intlargo);
		intlargo--;	
	}
	strtmp2=""
	for(intlargo = strtemp.length -1;intlargo >= 0;intlargo--){
		strtmp2 = strtmp2 + strtemp.charAt(intlargo);
	}
	return(strtmp2);
}

function insertapuntos(strval){
	var A = new Array();
	var strtemp = strval;
	strtemp = new Number(strtemp);
	strtemp = new String(strtemp);
	if(strtemp.length > 3){
		for(var i = 0; strtemp.length > 3; i++){
			A[i] = Right(strtemp,3);
			strtemp /= 1000;
			strtemp=new String(strtemp);
			if(strtemp.indexOf('.') != -1){
      				strtemp = strtemp.substr(0,strtemp.indexOf('.'));
      			}
		}
		for(i-- ;i >= 0 ;i--){
			strtemp = strtemp + "." + A[i];
		}
	}
	return(strtemp);			
}

function correo(texto){
	var supported = 0;
	booleano2=false;
	if (window.RegExp){
		var tempStr = "a";
	  	var tempReg = new RegExp(tempStr);
	  	if (tempReg.test(tempStr)) 
			supported = 1;
	}
	if (!supported){
		booleano2 = (texto.indexOf(".") > 2) && (texto.indexOf("@") > 0);
	  	return booleano2;		
	}
	var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
	var r2 = new
	RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
	booleano2=(!r1.test(texto) && r2.test(texto));
	return booleano2;
}

function pres_num(){
	if((event.keyCode<48) || (event.keyCode>57))
		event.returnValue = false;
}

/*function Particionar(valor)
{
	if (valor.length > 255)
	{
		inicio = 0;
		blanco = " ";
		sValorAuxiliar = "";
		k = 0;
		while (valor.length - inicio > 0)
		{
			if (k != 0)
			{
				sValorAuxiliar = sValorAuxiliar + "', '";
			}
			else
			{
				k = 1;
			}
			if (valor.substring(inicio, valor.length).length > 255)
			{
				espacios = valor.substring(inicio, inicio + 255);
				tiene = espacios.lastIndexOf(blanco); 
				inicio = inicio + tiene;
				if (tiene > 0 )
				{
					espacios = espacios.substring(0, tiene);
				}
			}
			else
			{
				espacios = valor.substring(inicio, valor.length);
				inicio = valor.length
			}
			sValorAuxiliar = sValorAuxiliar + espacios;
		}
	}
	else
	{
		sValorAuxiliar = valor;
	}
	return sValorAuxiliar;
}
*/
function Particionar(valor)
{
if (valor.length > 255) {
		seguir = true;
        sValorAuxiliar = "";
		k = 0; 
		espacios='';
        while (seguir) {
          if (k != 0) {
            	sValorAuxiliar = sValorAuxiliar + "', '";
          }
          if (valor.substring(0, valor.length).length > 255) {
	            espacios = valor.substring(0, 255);
				valor = valor.substring(255, valor.length);
				k=1;
				seguir=true;
          } else {
        	    espacios = valor;
				seguir=false;
				k=0;		
          }
          sValorAuxiliar = sValorAuxiliar + espacios;
        }
} else {
        sValorAuxiliar = valor;
}
return sValorAuxiliar;
}

function Captura(Tipo){
	if (navigator.appName == 'Netscape') {
		if (Tipo == "T"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiTexto;
		}
		if (Tipo == "N"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiNumero;
		}
		if (Tipo == "D"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiDecimal;
		}
		if (Tipo == "A"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiAlfanumerico;
		}
		if (Tipo == "E"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiEmail;
		}
		if (Tipo == "R"){
			window.captureEvents(Event.KEYPRESS);
			window.onKeyPress = valiRut;
		}

	}
}

function JValidaCaracter(Tipo, Adicional){
	var strNumeros ="0123456789";
	var strDecimal ="0123456789.";
	var Minusculas = "abcdefghijklmnñopqrstuvwxyz";
	var Mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	var strTexto = Minusculas + Mayusculas + " ";
	var strAlfanumerico = strTexto + strNumeros + "/-_,;";
	var strRut = strNumeros + ".-Kk";
	
	var strMail = Minusculas + Mayusculas + strNumeros + "@_-.";
	
	var TextoTotal = new String();
	TextoTotal = Adicional;
	
	switch(Tipo){
		case "Decimal":{
			TextoTotal += strDecimal;
			break;	
		}
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
		case "RUT":{
			TextoTotal += strRut;
			break;	
		}
	}
		
	strCaracter = new String();
	strCaracter = String.fromCharCode(window.event.keyCode);
	var Pos = TextoTotal.indexOf (strCaracter);
	if(Pos > -1){
		return true;
	}else{
		window.event.keyCode = 0;
		return false;			
	}
}

function JValidaCaracter2(Tipo, Adicional, Caracter){
	var strNumeros ="0123456789";
	var strDecimal ="0123456789.,";
	var Minusculas = "abcdefghijklmnñopqrstuvwxyz";
	var Mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	var strTexto = Minusculas + Mayusculas + " ";
	var strAlfanumerico = strTexto + strNumeros + "/-_,;";
	var strRut = strNumeros + ".-Kk";
	
	var strMail = Minusculas + Mayusculas + strNumeros + "@_-.";
	
	var TextoTotal = new String();
	TextoTotal = Adicional;
	
	switch(Tipo){
		case "Decimal":{
			TextoTotal += strDecimal;
			break;	
		}
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
		case "RUT":{
			TextoTotal += strRut;
			break;	
		}

	}
	strCaracter = new String();
	strCaracter = String.fromCharCode(Caracter);
	var Pos = TextoTotal.indexOf (strCaracter);
	if(Pos > -1){
		return true;
	}else{
		return false;			
	}
}
	

function valiTexto(e) {
	key = "";
	key = e.which;
	tipo = e.id;
	if (	JValidaCaracter2('Texto','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}

function valiNumero(e) {
	key = "";
	key = e.which;
	tipo = e.id;
	if (	JValidaCaracter2('Numerico','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}

function valiDecimal(e) {
	key = "";
	key = e.which;
	tipo = e.id;
	if (	JValidaCaracter2('Decimal','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}

function valiAlfanumerico(e) {
	key = "";
	key = e.which;
	tipo = e.id;
	if (	JValidaCaracter2('Alfanumerico','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}
 
function valiEmail(e) {
	key = "";
	key = e.which;
	tipo = e.id;
	if (	JValidaCaracter2('Email','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}

function valiRut(e) {
	key = "";
	key = e.which;
	tipo = e.id;
	if (	JValidaCaracter2('RUT','',key) || key == 8) {
		return true;
	}else{
		return false;
	}
}
function PonerMasPorBlanco(url){
	var cambio= / /gi;
	url2 = url.replace(cambio, "+");
	return url2;
}
function PonerMas(r, url){
	var url2;
	var cambio= / /gi;
	url2 = url.replace(cambio, "+");
	r.href = url2;
}
function CodArea(){
document.write('<select name="carea">');
document.write('<option selected>Area</option>');
document.write('<option value="02">02</option>');
document.write('<option value="32">32</option>');
document.write('<option value="33">33</option>');
document.write('<option value="34">34</option>');
document.write('<option value="35">35</option>');
document.write('<option value="41">41</option>');
document.write('<option value="42">42</option>');
document.write('<option value="43">43</option>');
document.write('<option value="45">45</option>');
document.write('<option value="51">51</option>');
document.write('<option value="52">52</option>');
document.write('<option value="53">53</option>');
document.write('<option value="55">55</option>');
document.write('<option value="57">57</option>');
document.write('<option value="58">58</option>');
document.write('<option value="61">61</option>');
document.write('<option value="63">63</option>');
document.write('<option value="64">64</option>');
document.write('<option value="65">65</option>');
document.write('<option value="67">67</option>');
document.write('<option value="71">71</option>');
document.write('<option value="72">72</option>');
document.write('<option value="73">73</option>');
document.write('<option value="75">75</option>');
document.write('</select>');

}

//--->
