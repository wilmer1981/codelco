/*function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.lenght;
	var Valores = "";
	for (i=0; i < LargoForm;i++)
	{
		if (f.elements[i].name == Nombre) && (f.elements[i].checked == true)
		{
			Valores = Valores + f.elements[i].value + "/";
		}
	}
	return Valores;
}*/
//Funcion que permite llevar numeros a letras hasta un rango maximo de 999.999.999
//==================================================================================================init 
function validarEmail(valor) {
if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor)){
//alert("La direcci�n de email " + valor + " es correcta.") 
return (true)
} else {
//alert("La direcci�n de email es incorrecta.");
return (false);
}
}

function SoloNumeros(PermiteDecimales,f) 
{ 
	var teclaCodigo = event.keyCode; 
	
	//alert(event.keyCode);
	if (PermiteDecimales==true)
	{
		if(teclaCodigo==110)
		{
		   event.keyCode=46;
		   f.value=f.value+",";
		}
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}
	else
	{
		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}	
}
//=================================================================================================
function init()
{ 
	sVacio = '' 
	sCantidadFormateada = sVacio 
	sEnLetra = sVacio 
	sEntero = sVacio 
	sSeparador = sVacio 
	sDecimal = sVacio 
	un = false 
} 
//==================================================================================================errorCantidad 
function errorCantidad(){ 
document.frm.txtCantidad.focus() 
idCantidad.style.color = "red" 
} 
//==================================================================================================valCantidad 
function valCantidad(inTxt){ 
aChars = strToArray(inTxt) 
cPoint = '.' 
iPoint = 0 
for (var i = 0; i < aChars.length; i++){ 
var c = aChars[i] 
if( (c >= "0" && c <= "9") || c == cPoint ){ 
if(c == cPoint){ 
iPoint++ 
} 
continue 
}else{ 
return false 
} 
} 
if(iPoint > 1){ 
return false 
} 
return true 
} 
//==================================================================================================strToArray 
function strToArray(inTxt)
{ 
	aChars = inTxt.split(''); 
	return (aChars); 
} 
//==================================================================================================formatoCantidad 
function formatoCantidad(inTxt)
{ 
	var aChars = new Array(); 
	var cPoint = '.'; 
	aChars = strToArray(inTxt); 
	//Formato para la cantidad "cero" o "punto" 
	if((inTxt == '0') || (aChars.length == 1 && aChars[0] == cPoint))
	{ 
		sCantidadFormateada = "0.0"; 
		return sCantidadFormateada;
	} 
	//eliminar ceros a la izquierda ingresados en la parte entera 
	for (var i = 0; i < aChars.length; i++)
	{ 
		var c = aChars[i] 
		if( (c >= "1" && c <= "9"))
		{ 
			break; 
		} 
		if(c == cPoint)
		{ 
			break; 
		} 
	} 
	sCantidadFormateada = inTxt.substring(i) 
	// Agregar el punto decimal y un cero si no se ingreso el punto 
	if(sCantidadFormateada.indexOf('.') == -1)
	{ 
		sCantidadFormateada += ".0"; 
	} 
	// Agregar un cero y el punto decimal si no se ingreso el punto 
	if(sCantidadFormateada.substring(0,sCantidadFormateada.indexOf('.'))== sVacio)
	{ 
		sCantidadFormateada = "0" + sCantidadFormateada; 
	} 
	// Agregar un cero si despues del punto decimal no hay nada 
	if(sCantidadFormateada.substring(sCantidadFormateada.indexOf('.')+1)== sVacio)
	{ 
		sCantidadFormateada = sCantidadFormateada + "0"; 
	} 
	return sCantidadFormateada; 
} 
//==================================================================================================parteEntera 
function parteEntera(inTxt){ 
var inTxtI = '' 
inTxtI = inTxt.substring(0,inTxt.indexOf('.')) 
return inTxtI 
} 
//==================================================================================================parteDecimal 
function parteDecimal(inTxt){ 
var inTxtF = '' 
inTxtF = inTxt.substring(inTxt.indexOf('.') + 1) 
return inTxtF 
} 
//==================================================================================================cantidadEnLetra 
function cantidadEnLetra(sCantidad){ 
sEnLetra = sVacio 
switch(sCantidad.length){ 
case 1 : 
sEnLetra = unidades(sEnLetra,sCantidad) 
break 
case 2 : 
sEnLetra = decenas(sEnLetra,sCantidad) 
break 
case 3 : 
sEnLetra = centenas(sEnLetra,sCantidad) 
break 
case 4 : 
sEnLetra = miles(sEnLetra,sCantidad) 
break 
case 5 : 
sEnLetra = dMiles(sEnLetra,sCantidad) 
break 
case 6 : 
sEnLetra = cMiles(sEnLetra,sCantidad) 
break 
case 7 : 
sEnLetra = millones(sEnLetra,sCantidad) 
break 
case 8 : 
sEnLetra = dMillones(sEnLetra,sCantidad) 
break 
case 9 : 
sEnLetra = cMillones(sEnLetra,sCantidad) 
break 
default : 
sEnLetra = "fuera de rango" 
break 
} 
return sEnLetra 
} 
//idStatus.style.visibility = 'hidden' 
//==================================================================================================unidades 
function unidades(sEnLetra,inTxt){ 
switch(parseInt(inTxt)){ 
case 0 : 
sEnLetra = sEnLetra + "cero" 
return sEnLetra; 
case 1 : 
if(!un){ 
sEnLetra = sEnLetra + "uno" 
}else{ 
sEnLetra = sEnLetra + "un" 
} 
return sEnLetra; 
case 2 : 
sEnLetra = sEnLetra + "dos" 
return sEnLetra; 
case 3 : 
sEnLetra = sEnLetra + "tres" 
return sEnLetra; 
case 4 : 
sEnLetra = sEnLetra + "cuatro" 
return sEnLetra; 
case 5 : 
sEnLetra = sEnLetra + "cinco" 
return sEnLetra; 
case 6 : 
sEnLetra = sEnLetra + "seis" 
return sEnLetra; 
case 7 : 
sEnLetra = sEnLetra + "siete" 
return sEnLetra; 
case 8 : 
sEnLetra = sEnLetra + "ocho" 
return sEnLetra; 
case 9 : 
sEnLetra = sEnLetra + "nueve" 
return sEnLetra; 
default : 
sEnLetra = "Ocurrio una excepcisn en unidades" 
return sEnLetra 
} 
} 
//==================================================================================================centenas 
function decenas(sEnLetra,inTxt){ 
switch(parseInt(inTxt)){ 
case 10 : 
sEnLetra = sEnLetra + "diez" 
return sEnLetra; 
case 11 : 
sEnLetra = sEnLetra + "once" 
return sEnLetra; 
case 12 : 
sEnLetra = sEnLetra + "doce" 
return sEnLetra; 
case 13 : 
sEnLetra = sEnLetra + "trece" 
return sEnLetra; 
case 14 : 
sEnLetra = sEnLetra + "catorce" 
return sEnLetra; 
case 15 : 
sEnLetra = sEnLetra + "quince" 
return sEnLetra; 
} 
if(parseInt(inTxt) >= 16 && parseInt(inTxt) <= 99){ 
aChars = strToArray(inTxt) 
switch(parseInt(aChars[0])){ 
case 1 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "diez" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "dieci" 
} 
break 
case 2 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "veinte" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "veinti" 
} 
break 
case 3 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "treinta" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "treinta y " 
} 
break 
case 4 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "cuarenta" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "cuarenta y " 
} 
break 
case 5 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "cincuenta" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "cincuenta y " 
} 
break 
case 6 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "sesenta" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "sesenta y " 
} 
break 
case 7 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "setenta" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "setenta y " 
} 
break 
case 8 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "ochenta" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "ochenta y " 
} 
break 
case 9 : 
if(parseInt(aChars[1]) == 0){ 
sEnLetra = sEnLetra + "noventa" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "noventa y " 
} 
break 
default : 
sEnLetra = "Ocurrio una excepcisn en decenas" 
break 
} 
sEnLetra = unidades(sEnLetra,aChars[1]) 
return sEnLetra 
} 
} 
//==================================================================================================centenas 
function centenas(sEnLetra,inTxt){ 
var unidad = sVacio 
var decena = sVacio 
if(parseInt(inTxt) >= 100 && parseInt(inTxt) <= 999){ 
aChars = strToArray(inTxt) 
switch(parseInt(aChars[0])){ 
case 1 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "cien" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "ciento " 
} 
break 
case 2 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "doscientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "doscientos " 
} 
break 
case 3 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "trescientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "trescientos " 
} 
break 
case 4 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "cuatrocientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "cuatrocientos " 
} 
break 
case 5 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "quinientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "quinientos " 
} 
break 
case 6 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "seiscientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "seiscientos " 
} 
break 
case 7 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "setecientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "setecientos " 
} 
break 
case 8 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "ochocientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "ochocientos " 
} 
break 
case 9 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
sEnLetra = sEnLetra + "novecientos" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "novecientos " 
} 
break 
default : 
sEnLetra = "Ocurrio una excepcisn en decenas" 
break 
} 
if(parseInt(aChars[1]) == 0){ 
unidad = aChars[2] 
sEnLetra = unidades(sEnLetra,unidad) 
}else{ 
decena = aChars[1] + aChars[2] 
sEnLetra = decenas(sEnLetra,decena) 
} 
return sEnLetra 
} 
} 
//==================================================================================================miles 
function miles(sEnLetra,inTxt){ 
var unidad = sVacio 
var decena = sVacio 
var centena = sVacio 
if(parseInt(inTxt) >= 1000 && parseInt(inTxt) <= 
9999){ 
aChars = strToArray(inTxt) 
switch(parseInt(aChars[0])){ 
case 1 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "mil " 
} 
break 
case 2 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "dos mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "dos mil " 
} 
break 
case 3 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "tres mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "tres mil " 
} 
break 
case 4 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "cuatro mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "cuatro mil " 
} 
break 
case 5 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "cinco mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "cinco mil " 
} 
break 
case 6 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "seis mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "seis mil " 
} 
break 
case 7 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "siete mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "siete mil " 
} 
break 
case 8 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "ocho mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "ocho mil " 
} 
break 
case 9 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
sEnLetra = sEnLetra + "nueve mil" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "nueve mil " 
} 
break 
default : 
sEnLetra = "Ocurrio una excepcisn en miles" 
break 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0){ 
unidad = aChars[3] 
sEnLetra = unidades(sEnLetra,unidad) 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
!= 0){ 
decena = aChars[2] + aChars[3] 
sEnLetra = decenas(sEnLetra,decena) 
} 
centena = aChars[1] + aChars[2] + aChars[3] 
if(parseInt(centena) >= 100){ 
sEnLetra = centenas(sEnLetra,centena) 
} 
return sEnLetra 
} 
} 
//==================================================================================================dMiles 
function dMiles(sEnLetra,inTxt){ 
var unidad = sVacio 
var decena = sVacio 
var centena = sVacio 
var millar = sVacio 
var aChars = new Array() 
if(parseInt(inTxt) >= 10000 && parseInt(inTxt) <= 
99999){ 
aChars = strToArray(inTxt) 
if(parseInt(aChars[0]) >= 1 || parseInt(aChars[0]) 
<= 9){ 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0){ 
decena = aChars[0] + aChars[1] 
sEnLetra = decenas(sEnLetra,decena) 
sEnLetra += " mil" 
return sEnLetra 
}else{ 
un = true 
decena = aChars[0] + aChars[1] 
sEnLetra = decenas(sEnLetra,decena) 
sEnLetra += " mil " 
un = false 
} 
}else{ 
sEnLetra = "Ocurrio una excepcisn en dMiles" 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0){ 
unidad = aChars[4] 
sEnLetra = unidades(sEnLetra,unidad) 
} 
if(parseInt(aChars[1]) != 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) != 0){ 
unidad = aChars[4] 
sEnLetra = unidades(sEnLetra,unidad) 
} 
if(parseInt(aChars[2]) == 0 && parseInt(aChars[3]) 
!= 0){ 
decena = aChars[3] + aChars[4] 
sEnLetra = decenas(sEnLetra,decena) 
} 
centena = aChars[2] + aChars[3] + aChars[4] 
if(parseInt(centena) >= 100 && parseInt(centena) <= 
999){ 
sEnLetra = centenas(sEnLetra,centena) 
} 
millar = aChars[1] + aChars[2] + aChars[3] + 
aChars[4] 
if(parseInt(millar) >= 10000 && parseInt(millar) <= 
99999){ 
sEnLetra = miles(sEnLetra,millar) 
} 
return sEnLetra 
} 
} 
//==================================================================================================dMiles 
function cMiles(sEnLetra,inTxt){ 
var unidad = sVacio 
var decena = sVacio 
var centena = sVacio 
var millar = sVacio 
var aChars = new Array() 
aChars = strToArray(inTxt) 
centena = aChars[0] + aChars[1] + aChars[2] 
if(parseInt(aChars[2]) == 1){ 
un = true 
}else{ 
un = false 
} 
if(parseInt(centena) >= 100){ 
sEnLetra = centenas(sEnLetra,centena) 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0){ 
sEnLetra += " mil" 
return sEnLetra 
}else{ 
sEnLetra += " mil " 
} 
} 
un = false 
if(parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 
0 && parseInt(aChars[5]) != 0){ 
unidad = aChars[5] 
sEnLetra = unidades(sEnLetra,unidad) 
} 
if(parseInt(aChars[3]) == 0 && parseInt(aChars[4]) != 
0){ 
decena = aChars[4] + aChars[5] 
sEnLetra = decenas(sEnLetra,decena) 
} 
if(parseInt(aChars[3]) != 0){ 
centena = aChars[3] + aChars[4] + aChars[5] 
sEnLetra = centenas(sEnLetra,centena) 
} 
return sEnLetra 
} 
//==================================================================================================millones 
function millones(sEnLetra,inTxt){ 
var unidad = sVacio 
var decena = sVacio 
var centena = sVacio 
var millar = sVacio 
var dm = sVacio 
var cm = sVacio 
var aChars = new Array() 
if(parseInt(inTxt) >= 1000000 && parseInt(inTxt) <= 
9999999){ 
aChars = strToArray(inTxt) 
switch(parseInt(aChars[0])){ 
case 1 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "un millon" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "un millon " 
} 
break 
case 2 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "dos millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "dos millones " 
} 
break 
case 3 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "tres millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "tres millones " 
} 
break 
case 4 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "cuatro millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "cuatro millones " 
} 
break 
case 5 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "cinco millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "cinco millones " 
} 
break 
case 6 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "seis millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "seis millones " 
} 
break 
case 7 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "siete millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "siete millones " 
} 
break 
case 8 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "ocho millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "ocho millones " 
} 
break 
case 9 : 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) == 0){ 
sEnLetra = sEnLetra + "nueve millones" 
return sEnLetra 
}else{ 
sEnLetra = sEnLetra + "nueve millones " 
} 
break 
default : 
sEnLetra = "Ocurrio una excepciOn en millones" 
break 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 
&& parseInt(aChars[6]) != 0){ 
unidad = aChars[6] 
sEnLetra = unidades(sEnLetra,unidad) 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) == 0 && parseInt(aChars[5]) != 0){ 
decena = aChars[5] + aChars[6] 
sEnLetra = decenas(sEnLetra,decena) 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) == 0 && 
parseInt(aChars[4]) != 0){ 
centena = aChars[4] + aChars[5] + aChars[6] 
sEnLetra = centenas(sEnLetra,centena) 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
== 0 && parseInt(aChars[3]) != 0){ 
millar = aChars[3] + aChars[4] + aChars[5] + 
aChars[6] 
sEnLetra = miles(sEnLetra,millar) 
} 
if(parseInt(aChars[1]) == 0 && parseInt(aChars[2]) 
!= 0){ 
dm = aChars[2] + aChars[3] + aChars[4] + aChars[5] 
+ aChars[6] 
sEnLetra = dMiles(sEnLetra,dm) 
} 
if(parseInt(aChars[1]) != 0){ 
cm = aChars[1] + aChars[2] + aChars[3] + aChars[4] 
+ aChars[5] + aChars[6] 
sEnLetra = cMiles(sEnLetra,cm) 
} 
} 
return sEnLetra 
} 
//==================================================================================================dMiles 
function dMillones(sEnLetra,inTxt)
{ 
var unidad = sVacio 
var decena = sVacio 
var centena = sVacio 
var millar = sVacio 
var aChars = new Array() 
if(parseInt(inTxt) >= 10000000 && parseInt(inTxt) <= 99999999)
{ 
	aChars = strToArray(inTxt) 
	if(parseInt(aChars[0]) >= 1 || parseInt(aChars[0])<= 9)
	{ 
		if(parseInt(aChars[1]) == 0 && parseInt(aChars[2])== 0 && parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0&& parseInt(aChars[6]) == 0 && parseInt(aChars[7]) ==0)
		{ 
			decena = aChars[0] + aChars[1] 
			sEnLetra = decenas(sEnLetra,decena) 
			//sEnLetra += " mil millones" 
			sEnLetra += " millones" 
			return sEnLetra 
		}
		else
		{ 
			un = true 
			decena = aChars[0] + aChars[1] 
			sEnLetra = decenas(sEnLetra,decena) 
			//sEnLetra += " mil millones " 
			sEnLetra += " millones " 
			un = false 
		} 
	}
	else
	{ 
		sEnLetra = "Ocurrio una excepcion en dMillones" 
	} 
	if(parseInt(aChars[1]) == 0 && parseInt(aChars[2])== 0 && parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0&& parseInt(aChars[6]) == 0)
	{ 
		unidad = aChars[7] 
		sEnLetra = unidades(sEnLetra,unidad) 
	} 
	if(parseInt(aChars[1]) != 0 && parseInt(aChars[2])== 0 && parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 && parseInt(aChars[6]) != 0)
	{ 
		unidad = aChars[7] 
		sEnLetra = unidades(sEnLetra,unidad) 
	} 
	if(parseInt(aChars[2]) == 0 && parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 && parseInt(aChars[6]) != 0)
	{ 
		decena = aChars[6] + aChars[7] 
		sEnLetra = decenas(sEnLetra,decena) 
	} 
	if(parseInt(aChars[2]) == 0 && parseInt(aChars[3])== 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) != 0)
	{ 
		centena = aChars[5] + aChars[6] + aChars[7] 
		sEnLetra = centenas(sEnLetra,centena) 
	} 
	if(parseInt(aChars[2]) == 0 && parseInt(aChars[3]) == 0 && parseInt(aChars[4]) != 0)
	{ 
		millar = aChars[4] + aChars[5] + aChars[6] + 
		aChars[7] 
		sEnLetra = miles(sEnLetra,millar) 
	} 
	if(parseInt(aChars[2]) == 0 && parseInt(aChars[3]) != 0)
	{ 
		dm = aChars[3] + aChars[4] + aChars[5] + aChars[6] + aChars[7] 
		sEnLetra = dMiles(sEnLetra,dm) 
	} 
	if(parseInt(aChars[2]) != 0)
	{ 
	cm = aChars[2] + aChars[3] + aChars[4] + aChars[5] + aChars[6] + aChars[7] 
	sEnLetra = cMiles(sEnLetra,cm) 
	}
	return sEnLetra 
} 
}
//******************************************************//
function cMillones(sEnLetra,inTxt)
{ 
var unidad = sVacio 
var decena = sVacio 
var centena = sVacio 
var millar = sVacio 
var aChars = new Array() 
if(parseInt(inTxt) >= 100000000 && parseInt(inTxt) <= 999999999)
{ 
	aChars = strToArray(inTxt) 
	if(parseInt(aChars[0]) >= 1 || parseInt(aChars[0])<= 9)
	{ 
		if(parseInt(aChars[1]) == 0 && parseInt(aChars[2])== 0 && parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0&& parseInt(aChars[6]) == 0 && parseInt(aChars[7]) ==0 && parseInt(aChars[8]) ==0)
		{ 
			centena = aChars[0] + aChars[1] + aChars[2]
			sEnLetra = centenas(sEnLetra,centena) 
			sEnLetra += " millones" 
			return sEnLetra 
		}
		else
		{ 
			un = true 
			centena = aChars[0] + aChars[1] + aChars[2]
			sEnLetra = centenas(sEnLetra,centena) 
			sEnLetra += " millones " 
			un = false 
		} 
	}
	else
	{ 
		sEnLetra = "Ocurrio una excepcion en dMillones" 
	} 
	if(parseInt(aChars[2])== 0 && parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 && parseInt(aChars[6]) == 0 && parseInt(aChars[7]) == 0)
	{ 
		unidad = aChars[8] 
		sEnLetra = unidades(sEnLetra,unidad) 
	} 
	if(parseInt(aChars[2]) != 0 && parseInt(aChars[3])== 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 && parseInt(aChars[6]) == 0 && parseInt(aChars[7]) != 0)
	{ 
		unidad = aChars[8] 
		sEnLetra = unidades(sEnLetra,unidad) 
	} 
	if(parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) == 0 && parseInt(aChars[6]) == 0 && parseInt(aChars[7]) != 0)
	{ 
		decena = aChars[7] + aChars[8] 
		sEnLetra = decenas(sEnLetra,decena) 
	} 
	if(parseInt(aChars[3]) == 0 && parseInt(aChars[4])== 0 && parseInt(aChars[5]) == 0 && parseInt(aChars[6]) != 0)
	{ 
		centena = aChars[6] + aChars[7] + aChars[8] 
		sEnLetra = centenas(sEnLetra,centena) 
	} 
	if(parseInt(aChars[3]) == 0 && parseInt(aChars[4]) == 0 && parseInt(aChars[5]) != 0)
	{ 
		millar = aChars[5] + aChars[6] + aChars[7] + aChars[8] 
		sEnLetra = miles(sEnLetra,millar) 
	} 
	if(parseInt(aChars[3]) == 0 && parseInt(aChars[4]) != 0)
	{ 
		dm = aChars[4] + aChars[5] + aChars[6] + aChars[7] + aChars[8] 
		sEnLetra = dMiles(sEnLetra,dm) 
	} 
	if(parseInt(aChars[3]) != 0)
	{ 
	cm = aChars[3] + aChars[4] + aChars[5] + aChars[6] + aChars[7] + aChars[8]
	sEnLetra = cMiles(sEnLetra,cm) 
	}
	return sEnLetra 
} 
} 
 
//==================================================================================================test 
//FUNCION QUE PERMITE FORMATEAR UN NUMERO YA SEA ENTERO O DECIMAL
function test(txtValIni,txtValFin,txtInc){ 
var r = sVacio 
if(txtInc == ""){ 
txtInc = 1 
} 
var nNumDec = txtInc.substring(txtInc.indexOf('.')+1) 
if(nNumDec == ""){ 
nNumDec = 0 
}else{ 
nNumDec = nNumDec.length 
} 
for(var i = parseFloat(txtValIni); i <= 
parseInt(txtValFin); i += parseFloat(txtInc)){ 
if((i%10) != 0){ 
r += "<font style='font-family: Verdana; font-size:11px; color: white'>" + 
main(decimales(i,nNumDec).toString(),false) + 
'</font><br>' 
}else{ 
r += "<b style='font-family: Verdana; font-size:11px; color: navy'>"+ 
main(decimales(i,nNumDec).toString(),false) + '</b>' + 
'<br>' 
} 
} 
document.writeln('<body bgcolor=#6699CC>' + r) 
} 
//==================================================================================================decimales 
function decimales(nValor, nDecimales){ 
if(nDecimales >= 0){ 
var x = parseFloat(nValor); 
x = x * Math.pow(10, nDecimales); 
x = Math.round(x); 
x = x / Math.pow(10, nDecimales); 
return x 
}else{ 
return nValor 
} 
} 
function oNumero(numero)
{
//Propiedades 
this.valor = numero || 0
this.dec = -1;
//M�todos 
this.formato = numFormat;
this.ponValor = ponValor;
//Definici�n de los m�todos 
function ponValor(cad)
{
if (cad =='-' || cad=='+') return
if (cad.length ==0) return
if (cad.indexOf(',') >=0)
    this.valor = parseFloat(cad);
else 
    this.valor = parseInt(cad);
} 
function numFormat(dec, miles)
{
var num = this.valor, signo=3, expr;
var cad = ""+this.valor;
var ceros = "", pos, pdec, i;

for (i=0; i < dec; i++)
ceros += '0';
pos = cad.indexOf(',')
if (pos < 0)
    cad = cad+","+ceros;
else
    {
    pdec = cad.length - pos -1;
    if (pdec <= dec)
        {
        for (i=0; i< (dec-pdec); i++)
            cad += '0';
        }
    else
        {
        num = num*Math.pow(10, dec);
        num = Math.round(num);
        num = num/Math.pow(10, dec);
        cad = new String(num);
        }
    }
pos = cad.indexOf(',')
if (pos < 0) pos = cad.lentgh
if (cad.substr(0,1)=='-' || cad.substr(0,1) == '+') 
       signo = 4;
if (miles && pos > signo)
    do{
        expr = /([+-]?\d)(\d{3}[\.\,]\d*)/
        cad.match(expr)
        cad=cad.replace(expr, RegExp.$1+'.'+RegExp.$2)
        }
while (cad.indexOf('.') > signo)
    if (dec<0) cad = cad.replace(/\,/,'')
        return cad;
}
}
//PERMITE BLOQUEAR LA ENTRADA DE LETRAS Y CARACTERES NO VALIDOS COMO NUMEROS
//ADEMAS PERMITE EL INGRESO DE DECIMALES PASANDOLE EL PARAMETRO=true
function TeclaPulsada (PermiteDecimales) 
{ 
	var teclaCodigo = event.keyCode; 
	
	if (PermiteDecimales==true)
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}
	else
	{
		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}	
}


//--> 

// FUNCION PARA VERIFICAR RUT
function RutValido(Numero,dv)
{
	var M=0,S=1;
	    Digito='';
    for(;Numero;Numero=Math.floor(Numero/10))
		S=(S+Numero%10*(9-M++%6))%11;
	Digito=S?S-1:'k';
	if (Digito==dv)
	{
		return true;			
	}
	else
	{
		return false;
	}
}
//-->
//FUNCION PARA MARCAR LA FILA DE UNA TABLA
<!--
ie = document.all?1:0
///FUNCION DE MARCAR FILA
function CCA(Obj,Clase)
{
	if (Obj.type=="checkbox" || Obj.type=="radio")
	{			
		var Chekeado = "";
		if (Obj.checked)
			Chekeado = "S";		
		else
			Chekeado = "N";
		if (ie)
		{
			while (Obj.tagName!="TR")
			{
				Obj=Obj.parentElement;
			}
		}		
		if (Chekeado=="S")
			Obj.className = Clase;				
		else
			Obj.className = "CL02";				
	}
	else
	{	
		if (Obj.className!="CL03")
		{
			if (ie)
			{
				while (Obj.tagName!="TR")
				{
					Obj=Obj.parentElement;
				}
			}		
			Obj.className = Clase;			
		}
	}
}
//////////////////////
//-->
//PERMITE BLOQUEAR LA ENTRADA DE LETRAS Y CARACTERES NO VALIDOS COMO NUMEROS
//ADEMAS PERMITE EL INGRESO DE DECIMALES PASANDOLE EL PARAMETRO=true
function TeclaPulsada2(ValidaNum,PermiteDecimales,formulario,CampoSgte) 
{ 
	var teclaCodigo = event.keyCode; 
	
	if (teclaCodigo == 13)
	{		
		if (CampoSgte!="")
			eval("formulario." + CampoSgte + ".focus();");
	}
	else
	{	
		if (ValidaNum == "S")
		{
			if (PermiteDecimales==true)
			{
				if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
					{
					   if ((teclaCodigo < 96) || (teclaCodigo > 105))
					   {
							event.keyCode=46;
					   }		
					}   
				}
			}
			else
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
					{
					   if ((teclaCodigo < 96) || (teclaCodigo > 105))
					   {
							event.keyCode=46;
					   }		
					}   
				}
			}//FIN VALIDA DECIMALES
		}//FIN SI VALIDA NUMERO
	}//FIN SI ES ENTER
}
function Recuperar(f,inputchk,niv,rutc)
{
	var Valores="";
	var Encontro=false;

	try
	{
		for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
		{
			if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			{
				if(niv=='M')
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
					break;
				}
				else
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
				}
			}
		}
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);
	}
	catch (e)
	{
	}	
}
function SoloUnElemento(f,inputchk,Opc)
{
	var CantCheck=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			CantCheck++;
		if(CantCheck>1)
			break;
			
	}
	if (Opc=='M')
	{
		if (CantCheck > 1 ||CantCheck==0)
		{
			if(CantCheck==0)
				alert("Debe Seleccionar un Elemento");
			else
				alert("Debe Seleccionar solo un Elemento");
			return(false);
		}
		else
			return(true);
	}
	else
	{
		if(CantCheck==0)
			alert("Debe Seleccionar un Elemento");
		else
			return(true);			
	}
}
function CheckearTodo(f,nomchk,nomchkT)
{
	var Check=new Object();
	var CheckT=new Object();
	
	try
	{
		eval("document."+f.name+"."+nomchk+"[0]");
		Check=eval("document."+f.name+"."+nomchk);
		CheckT=eval("document."+f.name+"."+nomchkT);
		for (i=1;i<Check.length;i++)
		{
			if (CheckT.checked==true){
				if(Check[i].disabled==false)
					Check[i].checked=true;
			}
			else{
				if(Check[i].disabled==false)
					Check[i].checked=false;
			}
		}
	}
	catch (e)
	{
	}
}
function CerrarDiv(NomDiv)
{

	NomDiv.style.visibility='hidden';

}
function DateFormat(vDateName, vDateValue, e, dateCheck, dateType,Frm,Val)  
{
	
  vDateType = dateType;
  isIE4 = true
   if (vDateValue == "~")
   {
      alert("AppVersion = "+navigator.appVersion+" \nNav. 4 Version = "+isNav4+" \nNav. 5 Version = "+isNav5+" \nIE Version = "+isIE4+" \nYear Type = "+vYearType+" \nDate Type = "+vDateType+" \nSeparator = "+strSeperator);
      vDateName.value = "";
      vDateName.focus();
      return true;
   }
      
   var whichCode = (window.Event) ? e.which : e.keyCode;

 	// Check to see if a seperator is already present.
   // bypass the date if a seperator is present and the length greater than 8
   if (vDateValue.length > 8 && isNav4)
   {
      
	  if ((vDateValue.indexOf("-") >= 1) || (vDateValue.indexOf("/") >= 1))
       return true;
   }
   
   //Eliminate all the ASCII codes that are not valid
   var alphaCheck = " abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/-";
   if (alphaCheck.indexOf(vDateValue) >= 1)  
   {
      if (isNav4)
      {
         vDateName.value = "";
         vDateName.focus();
         vDateName.select();
         return false;
      }
      else
      {
         vDateName.value = vDateName.value.substr(0, (vDateValue.length-1));
         return false;
      } 
   }
   if (whichCode == 8) //Ignore the Netscape value for backspace. IE has no value
      return false;
   else 
   {
      //Create numeric string values for 0123456789/
      //The codes provided include both keyboard and keypad values
      
      var strCheck = '47,48,49,50,51,52,53,54,55,56,57,58,59,95,96,97,98,99,100,101,102,103,104,105,39,37,46';
      if (strCheck.indexOf(whichCode) != -1)  
      {
		
         if (isNav4)  
         {
			 
            if (((vDateValue.length < 6 && dateCheck) || (vDateValue.length == 7 && dateCheck)) && (vDateValue.length >=1))
            {
               alert("Fecha no v�lida\n Formato DD/MM/AAAA");
               vDateName.value = "";
               vDateName.focus();
               vDateName.select();
               return false;
            }
            if (vDateValue.length == 6 && dateCheck)  
            {
               var mDay = vDateName.value.substr(2,2);
               var mMonth = vDateName.value.substr(0,2);
               var mYear = vDateName.value.substr(4,4)
               
               //Turn a two digit year into a 4 digit year
               if (mYear.length == 2 && vYearType == 4) 
               {
                  var mToday = new Date();
                  
                  //If the year is greater than 30 years from now use 19, otherwise use 20
                  var checkYear = mToday.getFullYear() + 30; 
                  var mCheckYear = '20' + mYear;
                  if (mCheckYear >= checkYear)
                     mYear = '19' + mYear;
                  else
                     mYear = '20' + mYear;
               }
               var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
               
               if (!dateValid(vDateValueCheck))  
               {
                  alert("Fecha no v�lida\n Formato DD/MM/AAA");
                  vDateName.value = "";
                  vDateName.focus();
                  vDateName.select();
                  return false;
		        }
				
               return true;
            
            }
            else
            {
				
               // Reformat the date for validation and set date type to a 1
               
               
               if (vDateValue.length >= 8  && dateCheck)  
               {
              
				 if (vDateType == 1) // mmddyyyy
                  {
                     var mDay = vDateName.value.substr(2,2);
                     var mMonth = vDateName.value.substr(0,2);
                     var mYear = vDateName.value.substr(4,4)
                     vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
                  }
                  if (vDateType == 2) // yyyymmdd
                  {
                     var mYear = vDateName.value.substr(0,4)
                     var mMonth = vDateName.value.substr(4,2);
                     var mDay = vDateName.value.substr(6,2);
                     vDateName.value = mYear+strSeperator+mMonth+strSeperator+mDay;
                  }
                  if (vDateType == 3) // ddmmyyyy
                  {
                     var mMonth = vDateName.value.substr(2,2);
                     var mDay = vDateName.value.substr(0,2);
                     var mYear = vDateName.value.substr(4,4)
                     vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
					
                  }
                  
                  //Create a temporary variable for storing the DateType and change
                  //the DateType to a 1 for validation.
                  
                  var vDateTypeTemp = vDateType;
                  vDateType = 1;
                  var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
                  
                  if (!dateValid(vDateValueCheck))  
                  {
                     alert("Fecha no v�lida\n Formato DD/MM/AAA");
                     vDateType = vDateTypeTemp;
                     vDateName.value = "";
                     vDateName.focus();
                     vDateName.select();
                     return false;
		            }
                 
					vDateType = vDateTypeTemp;
                     return true;
	            }
               else
               {
                  if (((vDateValue.length < 8 && dateCheck) || (vDateValue.length == 9 && dateCheck)) && (vDateValue.length >=1))
                  {
                     alert("Fecha no v�lida\n Formato DD/MM/AAA");
                     vDateName.value = "";
                     vDateName.focus();
                     vDateName.select();
                     return false;
                  }
               }
            }
         }
         else  
         {
			 
			
         // Non isNav Check
            if (((vDateValue.length < 8 && dateCheck) || (vDateValue.length == 9 && dateCheck)) && (vDateValue.length >=1))
            {
               alert("Fecha no v�lida\n Formato DD/MM/AAA");
               vDateName.value = "";
               vDateName.focus();
               return true;
            }
        
            // Reformat date to format that can be validated. mm/dd/yyyy
            if (vDateValue.length >= 8 && dateCheck)  
            {
            
               // Additional date formats can be entered here and parsed out to
               // a valid date format that the validation routine will recognize.
               
               if (vDateType == 1) // mm/dd/yyyy
               {
                  var mMonth = vDateName.value.substr(0,2);
                  var mDay = vDateName.value.substr(3,2);
                  var mYear = vDateName.value.substr(6,4)
               }
               if (vDateType == 2) // yyyy/mm/dd
               {
                  var mYear = vDateName.value.substr(0,4)
                  var mMonth = vDateName.value.substr(5,2);
                  var mDay = vDateName.value.substr(8,2);
               }
               if (vDateType == 3) // dd/mm/yyyy
               {
                  var mDay = vDateName.value.substr(0,2);
                  var mMonth = vDateName.value.substr(3,2);
                  var mYear = vDateName.value.substr(6,4)
               }
              if (vYearLength == 4)
               {
              	   if (mYear.length < 4)
                  {
              		 alert("Fecha no v�lida\n Formato DD/MM/AAA");
                     vDateName.value = "";
                     vDateName.focus();
                     return true;
                  }
              // alert("hola");
			   }
			   
               
               // Create temp. variable for storing the current vDateType
               var vDateTypeTemp = vDateType;
               
               // Change vDateType to a 1 for standard date format for validation

               // Type will be changed back when validation is completed.
              	vDateType = 1;
               
              	var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
				var DifAno=100;// VARIABLE QUE ALMACENA EL RANGO DE A�OS
				var mTodayActual = new Date();//CREO EL OBJETO FECHA, PARA OBTNER LA FECHA ACTUAL
				var checkYearSuperior = mTodayActual.getFullYear()+ DifAno; 
				var checkYearInferior = mTodayActual.getFullYear()- DifAno; 
	      // Store reformatted date to new variable for validation.
               if (mYear.length == 2 && vYearType == 4 && dateCheck)  
               {
                 
				 //Turn a two digit year into a 4 digit year
					var mToday = new Date();
						//If the year is greater than 30 years from now use 19, otherwise use 20
					var checkYear = mToday.getFullYear() + 30;
					var mCheckYear = '20' + mYear;
					if (mCheckYear >= checkYear)
						mYear = '19' + mYear;
					else
						mYear = '20' + mYear;
							
					if(mYear > checkYearSuperior )
					{
						alert("La fecha ingresada no puede ser mayor que "+DifAno+" años de la actual ")
						vDateName.value = "";
						vDateName.focus();
						return true;
					}
					if(mYear < checkYearInferior )
					{
						alert("La fecha ingresada no puede ser menor que "+DifAno+" años de la actual ")
						vDateName.value = "";
						vDateName.focus();
						return true;
					}
					 vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
					 // Store the new value back to the field.  This function will
					 // not work with date type of 2 since the year is entered first.
		
					if (vDateTypeTemp == 1) // mm/dd/yyyy
					{ 
					
						vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
				
					}
					if (vDateTypeTemp == 3) // dd/mm/yyyy
					{
					
						vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
					//LLAMADA  DE FUNCION//////////////	
					}
					
               } 
				if(mYear > checkYearSuperior )
				{
					alert("La fecha ingresada no puede ser menor que "+DifAno+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
				if(mYear < checkYearInferior )
				{
					alert("La fecha ingresada no puede ser menor que "+DifAno+" a�os de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
			   
               	if (!dateValid(vDateValueCheck))  
               	{
                  alert("Fecha no v�lida\n Formato DD/MM/AAA");
                  vDateType = vDateTypeTemp;
                  vDateName.value = "";
                  vDateName.focus();
                  return true;
		         }
				else///////AQUI VA LA NUEVA FUNCION
				{
					//alert(vDateName.value);
					if(Val == 'EDAD')
						Frm.TxtEdad.value=calcular_edad(vDateName.value);	

				}
					vDateType = vDateTypeTemp;
				  	return true; 	         
			
            	}
            else
            {
              
               if (vDateType == 1)
               {
                  if (vDateValue.length == 2)  
                  {
                 
				   vDateName.value = vDateValue+strSeperator;
                  }
                  if (vDateValue.length == 5)  
                  {
                     vDateName.value = vDateValue+strSeperator;
                  }
               }
               if (vDateType == 2)
               {
                  if (vDateValue.length == 4)  
                  {
                     vDateName.value = vDateValue+strSeperator;
                  }
                  if (vDateValue.length == 7)  
                  {
                     vDateName.value = vDateValue+strSeperator;
                  }
               } 
               if (vDateType == 3)
               {
                 // alert("Valido");
				  if (vDateValue.length == 2)  
                  {
                     vDateName.value = vDateValue+strSeperator;
			      }
                  if (vDateValue.length == 5)  
                  {
                     vDateName.value = vDateValue+strSeperator;
			      }
               }
               return true;
            }
         }
         if (vDateValue.length == 10   && dateCheck)  
         {
            if (!dateValid(vDateName))  
            {
// Un-comment the next line of code for debugging the dateValid() function error messages
//               alert(err);  
               alert("Fecha no v�lida\n Formato DD/MM/AAA");
               vDateName.focus();
               vDateName.select();
	         }
         }
         return false;
      }
      else  
      {
      
		// If the value is not in the string return the string minus the last
         // key entered.
         if (isNav4)
         {
            vDateName.value = "";
            vDateName.focus();
            vDateName.select();
            return false;
         }
         else
         {
            vDateName.value = vDateName.value.substr(0, (vDateValue.length-1));
            return false;
         }
		}
	}
}

   function dateValid(objName) {
      var strDate;
      var strDateArray;
      var strDay;
      var strMonth;
      var strYear;
      var intday;
      var intMonth;
      var intYear;
      var booFound = false;
      var datefield = objName;
      var strSeparatorArray = new Array("-"," ","/",".");
      var intElementNr;
      // var err = 0;
      var strMonthArray = new Array(12);
      strMonthArray[0] = "Jan";
      strMonthArray[1] = "Feb";
      strMonthArray[2] = "Mar";
      strMonthArray[3] = "Apr";
      strMonthArray[4] = "May";
      strMonthArray[5] = "Jun";
      strMonthArray[6] = "Jul";
      strMonthArray[7] = "Aug";
      strMonthArray[8] = "Sep";
      strMonthArray[9] = "Oct";
      strMonthArray[10] = "Nov";
      strMonthArray[11] = "Dec";
      
      //strDate = datefield.value;
      strDate = objName;
      
      if (strDate.length < 1) {
         return true;
      }
      for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
         if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) 
         {
            strDateArray = strDate.split(strSeparatorArray[intElementNr]);
            if (strDateArray.length != 3) 
            {
               err = 1;
               return false;
            }
            else 
            {
               strDay = strDateArray[0];
               strMonth = strDateArray[1];
               strYear = strDateArray[2];
            }
            booFound = true;
         }
      }
      if (booFound == false) {
         if (strDate.length>5) {
            strDay = strDate.substr(0, 2);
            strMonth = strDate.substr(2, 2);
            strYear = strDate.substr(4);
         }
      }
      //Adjustment for short years entered
      if (strYear.length == 2) {
         strYear = '20' + strYear;
      }
      strTemp = strDay;
      strDay = strMonth;
      strMonth = strTemp;
      intday = parseInt(strDay, 10);
      if (isNaN(intday)) {
         err = 2;
		 
         return false;
      }
      
      intMonth = parseInt(strMonth, 10);
      if (isNaN(intMonth)) {
         for (i = 0;i<12;i++) {
            if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
               intMonth = i+1;
               strMonth = strMonthArray[i];
               i = 12;
            }
         }
         if (isNaN(intMonth)) {
            err = 3;
            return false;
         }
      }
      intYear = parseInt(strYear, 10);
      if (isNaN(intYear)) {
         err = 4;
         return false;
      }
      if (intMonth>12 || intMonth<1) {
         err = 5;
         return false;
      }
      if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
         err = 6;
         return false;
      }
      if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
         err = 7;
         return false;
      }
      if (intMonth == 2) {
         if (intday < 1) {
            err = 8;
            return false;
         }
         if (LeapYear(intYear) == true) {
            if (intday > 29) {
               err = 9;
               return false;
            }
         }
         else {
            if (intday > 28) {
               err = 10;
               return false;
            }
         }
      }
         return true;
      }

   function LeapYear(intYear) {
      if (intYear % 100 == 0) {
         if (intYear % 400 == 0) { return true; }
      }
      else {
         if ((intYear % 4) == 0) { return true; }
      }
         return false;
      }
//  End -->

///////////////////////FIN//////////////////////////////////////////////////////////

