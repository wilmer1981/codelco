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