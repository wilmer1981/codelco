<!--
//----------------------------------------------------------------------------------------------------
function chr(CharCode){
	return String.fromCharCode(CharCode);
}
//----------------------------------------------------------------------------------------------------
function busqueda_caracter(cadena,lugar,caracter){
	contador=1;
	for(l=0;l<cadena.length;l++){
		if (cadena.substring(l,l+1) == caracter){
			if (lugar == contador){
				return(l);
			}else{
				contador++;
			}
		}
	}
	return (l);
}
//----------------------------------------------------------------------------------------------------
var url = Array();
var texto_huella = Array();
var parametros = Array();
var color_huella = Array();

var cont_url = 0; 
var fecha = ""
var usuario = "";
var espacio = "";
var usrNameSRVsgBDD = ""
var TABMeses = new Array(); 
TABMeses[0] = 'Enero';		TABMeses[1] = 'Febrero';	
TABMeses[2] = 'Marzo';		TABMeses[3] = 'Abril';
TABMeses[4] = 'Mayo';		TABMeses[5] = 'Junio';
TABMeses[6] = 'Julio';		TABMeses[7] = 'Agosto';
TABMeses[8] = 'Septiembre';	TABMeses[9] = 'Octubre';
TABMeses[10] = 'Noviembre';	TABMeses[11] = 'Diciembre';
//----------------------------------------------------------------------------------------------------
for (i=0;i<Huella_dll.length;i++){
	num0 = - 1;
	num1 = busqueda_caracter(Huella_dll[i],1,chr(255));
	num2 = busqueda_caracter(Huella_dll[i],2,chr(255));
	num3 = busqueda_caracter(Huella_dll[i],3,chr(255));
	num4 = busqueda_caracter(Huella_dll[i],4,chr(255));
	num5 = busqueda_caracter(Huella_dll[i],5,chr(255));
	num6 = Huella_dll[i].length;
	
	tipo_param = Huella_dll[i].substring(num0 + 1,num1);

	if ((tipo_param == "#FECHA#")||(tipo_param == "#USUARIO#") || (tipo_param == "#HORA#") || (tipo_param == "#PERFIL#") || (tipo_param == "#RUT#")){
		if (tipo_param == "#FECHA#"){
			fecha = Huella_dll[i].substring(num1 + 1,num2);			
		}else if (tipo_param == "#USUARIO#"){
			usuario=Huella_dll[i].substring(num1 + 1,num2);			
		}		
	}else{
		numero_param=Huella_dll[i].substring(num2 + 1,num3);	
		//alert(numero_param);	
		if (numero_param == 1){
			num1 = busqueda_caracter(Huella_dll[i],1,chr(255));
			texto_huella[cont_url] = Huella_dll[i].substring(0,num1);
			url[cont_url] = Huella_dll[i].substring(num1+1,num2);
			parametros[cont_url] = Huella_dll[i].substring(num3+1,num4);
			color_huella[cont_url] = Huella_dll[i].substring(num4+1,num5);
			cont_url++;
		}else{
			parametros[cont_url]= parametros[cont_url] + Huella_dll[i].substring(num3+1,num4);
		}
	}
}
usrNameSRVsgBDD = usuario;
//----------------------------------------------------------------------------------------------------

<!--
document.write('<STYLE TYPE="text/css" MEDIA="print">.noprint {display: none;}</STYLE>');
document.write('<div class="noprint">');
document.write('<table width="767" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">');
document.write('<tr>');
document.write('<td class="titulo_cafe"><img src="images/menu_botones/1pixel.gif" width="4" height="8">'); //<a href="/browse.asp?pagina=codelco/home.htm"><span class="titulo_cafe">Inicio</span></a>&nbsp;&gt');

if (cont_url > 0){	
	espacio = "&nbsp;&gt"
	if (cont_url > 1){
   	document.write('&nbsp;');
		for(i=0;i<=cont_url-1;i++){
				if (url[i].substring(url[i].length-3,url[i].length) != ".js"){	
					
					if(url[i].substring(url[i].length - 8, url[i].length) == 'home.htm'){
						document.write('<a href="' + url[i] + '" ><span class="titulo_cafe">' + texto_huella[i] + '</span></a>&nbsp;&gt&nbsp;');
					}else{
						document.write('<a href="' + url[i] + parametros[i] + '" ><span class="titulo_cafe">' + texto_huella[i] + '</span></a>&nbsp;&gt&nbsp;');
					}
				}
		}
	}	
	/*if (url[cont_url - 1].substring(url[cont_url - 1].length-3,url[cont_url - 1].length) != ".js"){
		document.write(texto_huella[cont_url - 1] + espacio);
	}*/
	
			
	
}


document.write('<td class="titulo_cafe"><div align="right">' +  '&nbsp;' + fecha.substring(0,2) + ' de ' +  TABMeses[Number(fecha.substring(3,5)) - 1] + ' ' + fecha.substring(6,fecha.length) + '<img src="images/menu_botones/1pixel.gif" width="7" height="8"></div></td>');
document.write('</tr>');
document.write('</table>');
document.write('</div>');


//-->
