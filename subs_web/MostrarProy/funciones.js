//C�digo para colocar 
//los indicadores de miles mientras se escribe
function puntitos(donde,caracter){
pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
valor = donde.value
largo = valor.length
crtr = true
if(isNaN(caracter) || pat.test(caracter) == true){
  if (pat.test(caracter)==true) {
    caracter = "\\" + caracter
     }
  carcter = new RegExp(caracter,"g")
  valor = valor.replace(carcter,"")
  donde.value = valor
  crtr = false
 }
else{
  var nums = new Array()
  cont = 0
  for(m=0;m<largo;m++){
     if(valor.charAt(m) == "." || valor.charAt(m) == " "){
      continue;
      }
    else{
      nums["cont"] = valor.charAt(m)
      cont++
      }
   }
}

var cad1="",cad2="",tres=0
if(largo > 3 && crtr == true){
   for (k=nums.length-1;k>=0;k--){
     cad1 = nums[k]
     cad2 = cad1 + cad2
     tres++
     if((tres%3) == 0){
        if(k!=0){
          cad2 = "." + cad2
          }
        }
      }
    donde.value = cad2
  }
} 

/**********************************************************************/
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
		alert("Rut no Valido!");
		return false;
	}
}
/**************************************************************************/
//PERMITE BLOQUEAR LA ENTRADA DE LETRAS Y CARACTERES NO VALIDOS COMO NUMEROS
//ADEMAS PERMITE EL INGRESO DE DECIMALES PASANDOLE EL PARAMETRO=true
function TeclaPulsada (PermiteDecimales){ 
	var teclaCodigo = event.keyCode; 
	if (PermiteDecimales==true){
		if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)){
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57)){
			   if ((teclaCodigo < 96) || (teclaCodigo > 105)){
					event.keyCode=46;
			   }		
			}   
		}
	}else{
		if ((teclaCodigo != 37)&&(teclaCodigo != 39)){
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57)){
			   if ((teclaCodigo < 96) || (teclaCodigo > 105)){
					event.keyCode=46;
			   }		
			}   
		}
	}	
}
/******************Numero de dias entre 2 fechas***********************/
function DiferenciaFechas(a){

 var f = document.form1;

   var CadenaFecha1 = f.elements[a+18].value; //Obtiene los datos del formulario
   var CadenaFecha2 = f.elements[a+17].value;

   var fecha1 = new fecha(CadenaFecha1); //Obtiene dia, mes y año  
   var fecha2 = new fecha(CadenaFecha2);
   
   var miFecha1 = new Date( fecha1.anio, fecha1.mes, fecha1.dia );//Obtiene objetos Date
   var miFecha2 = new Date( fecha2.anio, fecha2.mes, fecha2.dia );

   var diferencia = miFecha1.getTime() - miFecha2.getTime(); //Resta fechas y redondea
   var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
   
	f.elements[a+19] = dias;
  
  // return false
}
function fecha(cadena) {
   var separador = "/" //Separador para la introduccion de las fechas
   if ( cadena.indexOf( separador ) != -1 ) {   //Separa por dia, mes y año
        var posi1 = 0;
        var posi2 = cadena.indexOf(separador, posi1 + 1);
        var posi3 = cadena.indexOf(separador, posi2 + 1);
        var dia = cadena.substring(posi1, posi2);
        var mes = cadena.substring(posi2 + 1, posi3);
        var anio = cadena.substring(posi3 + 1, cadena.length);
   } else {
        dia = 0;
        mes = 0;
        anio = 0;   
   }
}
