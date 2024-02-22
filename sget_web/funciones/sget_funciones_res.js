ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false


function FechaReajuste(Fecha,meses)
{	
	var anio;
	var mes;
	var dia;
	var tmpanio;
	var tmpmes;
	var anionew;
	//tres variables de dia, mes y año
	anio=parseInt(Fecha.substr(0,4));
	mes=(Fecha.substr(5,2))*1;
	dia=parseInt(Fecha.substr(8,2));
	//Sumamos los meses requeridos
	tmpanio=parseFloat(meses/12);
	tmpmes=meses%12;
	anionew=parseInt(anio)+tmpanio;
	mesnew=mes+tmpmes;
	 if (mesnew>12)
	 {
		  mesnew=mesnew-12;
		  if (mesnew<10)
		  {
		   mesnew="0"+mesnew;	
		  }
		  anionew=parseInt(anionew)+1;
	 }
	 var miFecha1 = new Date(anionew, (mesnew-1), dia )	
	 var suma=miFecha1.getTime()
	 miFecha1.setTime(suma) 
	 var diastring =miFecha1.toLocaleString()
	 var FechaNueva=FechaCortaAAAAMMDD(diastring)
	 return  (FechaNueva)//Ponemos la fecha en formato americano y la devolvemos
}
function Recarga() 
{
	document.FrmProceso.action='sget_hoja_ruta.php';
	document.FrmProceso.submit();
}
function muestra(numero) 
{
 	
	if (ns4){ 
 		eval("document.Div" + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Div" + numero + ".style.visibility = 'visible'");
			//eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Div" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function ImprimirForm()
{
	window.print();
}
function ImprimirForm2(Num)
{
	URL="sgc_itinerario_impresion.php?Referencia="+Num;
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=700,height=500,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
	
}
function SacaMiles(objeto)
{
	var result="";
	valor=objeto;
	valor=valor.split(".");
	for(i=0;i<valor.length;i++)
		result=result + valor[i];
	return result;
}
function PoneMiles(donde,caracter)
{
	//alert(donde);
	//alert(caracter);
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
function DetalleProceso(tipo,num)
{
	switch(tipo)
	{
		case "S":
			URL="sgc_buscar_general_detalle.php?Tipo=S&NumSol="+num+"&Ptl=ES";
			opciones='top=10,toolbar=0,resizable=0,menubar=0,status=1,width=730,height=550,scrollbars=1';
			//verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case "L":
			URL="sgc_buscar_general_detalle_licit.php?Tipo=S&NumSol="+num;
			opciones='top=10,toolbar=0,resizable=0,menubar=0,status=1,width=730,height=550,scrollbars=1';
			//verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case "C":
			URL="sgc_buscar_contrato_detalle.php?Tipo=S&NumSol="+num;
			opciones='top=10,toolbar=0,resizable=0,menubar=0,status=1,width=730,height=550,scrollbars=1';
			//verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
	}
}
function DetalleAct(Num)
{
	URL="sgc_detalle_actividades.php?NumIdAct="+Num;
	opciones='top=10,toolbar=0,resizable=1,menubar=0,status=1,width=780,height=550,scrollbars=1';
	//verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
}
function buscar_op(Pagina,form,obj,objfoco,InicioBusq,Recargar){ 
   var f = document.FrmRecepcion;
   var letra = String.fromCharCode(event.keyCode) 
   if(puntero >= digitos){ 
       cadena=""; 
       puntero=0; 
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto... 
   if (event.keyCode == 13||event.keyCode == 27)
   { 
       borrar_buffer(); 
       if(event.keyCode != 27&&objfoco!=0) //evita foco a otro objeto si objfoco=0 
		if(Recargar=='S')
		{	
			form.action=Pagina+"?ObjFoco="+objfoco.name;
			form.submit();
		}
		else
		   objfoco.focus(); 
    } 
   //sino busco la cadena tipeada dentro del combo... 
   else{ 
       buffer[puntero]=letra; 
       //guardo en la posicion puntero la letra tipeada 
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array 
       puntero++; 

       //barro todas las opciones que contiene el combo y las comparo la cadena... 
       for (var opcombo=0;opcombo < obj.length;opcombo++){ 
          if(obj[opcombo].text.substr(InicioBusq,puntero).toLowerCase()==cadena.toLowerCase()){ 
          obj.SELECTedIndex=opcombo; 
          } 
       } 
    } 
   event.returnValue = false; //invalida la acci�n de pulsado de tecla para evitar busqueda del primer caracter 

} 

function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}
function Recuperar(f,inputchk,niv,rutc)
{
	var Valores="";
	var Encontro=false;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
		{
			if(niv=='4')
			{
				if(eval("document."+f+".elements["+i+2+"].value")==rutc)
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
//				alert(eval("document."+f+".elements["+i+2+"].value"));
				}
				else
				{
					alert("Ud No tiene Acceso a Modificar el Requerimiento");
					Valores="";
				}
			}
			else
			{
				if(niv=='AN')
				{
					if((eval("document."+f+"."+inputchk+"["+i+"].checked")) == true)
					{
						Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))+ "~" + "A" + "//" ;
						Encontro=true;
					}
				}
				else
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
				}
			}
		}
		else
		{
			if(niv=='AN')
			{
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))  + "~" + "R" + "//" ;
				Encontro=true;
			}
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
//function Recuperar2(f,inputchk,option1,option2,inputchk2,txt)
function Recuperar2(f,inputchk,option1,option2,inputchk2,txt,orden)
{
	var Valores="";
	var Encontro=false;
	var Datos="";
	var Inicio="";
	var Fin="";
	for(i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+option1+"["+i+"].checked")==true)
		{	
			Inicio=(eval("document."+f+"."+orden+"["+i+"].value"));
			Check1='S';
		}
		else
				Check1='N';
				if (eval("document."+f+"."+option2+"["+i+"].checked")==true)
				{
					Fin=(eval("document."+f+"."+orden+"["+i+"].value"));
					Check2='S';
				}
				else
					Check2='N';	
				if (eval("document."+f+"."+inputchk2+"["+i+"].checked")==true)
					Check3='S';
				else
					Check3='N';		
				Datos = Datos + (eval("document."+f+"."+inputchk+"["+i+"].value")) +"~~"+Check1+"~~"+Check2+"~~"+Check3+"~~"+(eval("document."+f+"."+txt+"["+i+"].value"))+"//";
				Encontro=true;
	}
	if (Inicio < Fin )
		Datos =Datos.substr(0,Datos.length-2);
	else{
		if(Inicio==Fin)
			Datos="";
		else{
			alert("Inicio es Mayor que Fin");
			Datos="";
		}
	}
	return(Datos);	
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
function SoloUnElemento(f,inputchk,Opc)
{
	var CantCheck=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			CantCheck++;
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
	
	
function RecuperarDatosCheck(f,Tipo)
{
	var LargoForm = eval("document."+f+".elements.length");
	var Valores3="";
	var Compara="";
	for (i=0;i < LargoForm;i++)
	{
		
		Compara=eval("document."+f+".elements["+i+"].name").substring(0,11);
		if (Compara=='CheckFechaT')
		{
			//alert(i);
			/*if(eval("document."+f+".elements["+(i)+"].value") != "")				
			{	*/
				if (eval("document."+f+".elements["+i+"].checked") == true)
					Valores3 = Valores3 +"S"+"~~"
				else	
				Valores3 = Valores3 +"N"+"~~"
			//}
		}
	}
	Valores3=Valores3.substr(0,Valores3.length-2);
	//alert(Valores3);
	return(Valores3);
}
function RecuperarFechasMiscelaneos(f,Tipo)
{
	var LargoForm = eval("document."+f+".elements.length");
	var Valores="";
	var Compara="";
	for (i=0;i < LargoForm;i++)
	{
		
		Compara=eval("document."+f+".elements["+i+"].name").substring(0,9);
		if (Compara=='TxtFechaT')
		{
			//alert(i);
			/*if(eval("document."+f+".elements["+(i)+"].value") != "")				
			{	*/
				Valores = Valores +eval("document."+f+".elements["+(i)+"].value")+"~~";
			//}
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	//alert(Valores);
	return(Valores);
}
function RecuperarEmpMiscelaneos(f,Tipo)
{
	var LargoForm = eval("document."+f+".elements.length");
	var Valores2="";
	var Compara="";
	for (i=0;i < LargoForm;i++)
	{
		Compara=eval("document."+f+".elements["+i+"].name");
		var nom= Compara.split("~~");
		Compara=nom[0]
		
		if (Compara=='CheckRut2')
		{
			if (eval("document."+f+".elements["+i+"].checked") == true)
				Valores2 = Valores2 +eval("document."+f+".elements["+(i)+"].value")+"~~"+"S"+"//"
			else
				Valores2 = Valores2 +eval("document."+f+".elements["+(i)+"].value")+"~~"+"N"+"//"
		}
	}
	Valores2=Valores2.substr(0,Valores2.length-2);
	//alert(Valores2);
	return(Valores2);
}
function Recuperar3(f,Tipo)
{
	var LargoForm = eval("document."+f+".elements.length");
	var Valores="";
	for (i=0;i < LargoForm;i++)
	{ 
		if(Tipo=='Evaluacion')
		{
			if ((eval("document."+f+".elements["+i+"].name") == "Campos2"))
				if ((eval("document."+f+".elements["+(i+1)+"].value") != "" ))
					Valores = Valores +eval("document."+f+".elements["+(i)+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"//";
		}
		else
		{
			if(Tipo=='ALCANCE')//ALCANCE:PANTALLA MODIFICACION
			{
				if ((eval("document."+f+".elements["+i+"].name") == "CheckDiv")&&(eval("document."+f+".elements["+i+"].checked")==true))
					Valores = Valores +eval("document."+f+".elements["+(i)+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"//";
			}
			else
			{
				/*alert(eval("document."+f+".elements["+i+"].name"));
				alert(eval("document."+f+".elements["+i+"].value"));
				alert(i);*/
			
				if ((eval("document."+f+".elements["+i+"].name") == "CodHito"))
				{
				
		//if ((eval("document."+f+".elements["+(i+1)+"].value") != "" ) || (eval("document."+f+".elements["+(i+3)+"].value") != "" ))
						//Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"//"  ;
						if ((eval("document."+f+".elements["+(i+1)+"].value") != "" ))
						{
							if(Tipo=='I')
							{
								if(eval("document."+f+".elements["+(i+4)+"].value")=='S')
									{
										Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"~~"+eval("document."+f+".elements["+(i+4)+"].value")+"~~"+eval("document."+f+".elements["+(i+5)+"].value")+"//";
									}
								else				
									{
										Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"~~"+eval("document."+f+".elements["+(i+4)+"].value")+"//";
									}
							}
							else
							{
								//alert("else");
								//alert(Tipo);
								if(Tipo=='R')
								{
									Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"~~"+eval("document."+f+".elements["+(i+4)+"].value")+"~~"+eval("document."+f+".elements["+(i+5)+"].value")+"//";
									
									//alert(Valores);
								}
								else
								{
								Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"//";			
								}
							}
						}
						else					
							Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"//";
				}
			}
		}
	}
	//alert(Valores);
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}

function Recuperar4(f,Tipo)
{
	var LargoForm = eval("document."+f+".elements.length");
	var Valores="";
	for (i=0;i < LargoForm;i++)
	{ 
		if(Tipo=='Evaluacion')
		{
			if ((eval("document."+f+".elements["+i+"].name") == "Campos2"))
				if ((eval("document."+f+".elements["+(i+1)+"].value") != "" ))
					Valores = Valores +eval("document."+f+".elements["+(i)+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"//";
		}
		else
		{
			if(Tipo=='ALCANCE')//ALCANCE:PANTALLA MODIFICACION
			{
				if ((eval("document."+f+".elements["+i+"].name") == "CheckDiv")&&(eval("document."+f+".elements["+i+"].checked")==true))
					Valores = Valores +eval("document."+f+".elements["+(i)+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"//";
			}
			else
			{
				if ((eval("document."+f+".elements["+i+"].name") == "CodHito"))
				{
						if ((eval("document."+f+".elements["+(i+1)+"].value") != "" ))
						{
							if(Tipo=='I')
							{
								if(eval("document."+f+".elements["+(i+4)+"].value")=='S')
									{
										Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"~~"+eval("document."+f+".elements["+(i+4)+"].value")+"~~"+eval("document."+f+".elements["+(i+5)+"].value")+"~~"+eval("document."+f+".elements["+(i+6)+"].value")+"//";
									}
								else				
									{
										Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"~~"+eval("document."+f+".elements["+(i+4)+"].value")+"//";
									}
							}
							else
							{
								if(Tipo=='R')
								{
									Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"~~"+eval("document."+f+".elements["+(i+4)+"].value")+"~~"+eval("document."+f+".elements["+(i+5)+"].value")+"~~"+eval("document."+f+".elements["+(i+6)+"].value")+"//";
								}
								else
								{
								 	Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"~~"+eval("document."+f+".elements["+(i+2)+"].value")+"~~"+eval("document."+f+".elements["+(i+3)+"].value")+"//";			
								}
							}
						}
						else					
							Valores = Valores +eval("document."+f+".elements["+i+"].value")+"~~"+eval("document."+f+".elements["+(i+1)+"].value")+"//";
				}
			}
		}
	}
	//alert(Valores);
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
//funcion que verifica si un popup esta abierto
function verificar_popup(popup)
{
	if(popup)
	{
		if(!popup.closed)
			popup.close();
	}
}
function RecuperarValida(f,inputchk,Opc)
{
	//alert(f);
	var Valores="";
	var Encontro=false;
	var Cont=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if(Opc!="")
		{
			if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			{
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
				Encontro=true;
				Cont++;
			}
		}
		else
		{
			//alert("else")
			Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
			Encontro=true;
			Cont++;
		}
	}
	//alert(Encontro);
	if (Encontro==true)
	{
		if(Opc=='E')
		{//OPCION ELIMINAR
			//Valores=Valores.substr(0,Valores.length-2);
			return(Valores);
		}
		else
		{
			if(Opc=='M')
			{//OPCION MODIFICAR
				if(Cont==1)
				{
					//Valores=Valores.substr(0,Valores.length-2);
					return(Valores);
				}
				else
				{
					alert("Debe Seleccionar solo un Elemento");
					Valores="";
					return(Valores);
				}
			}
			else//
				return(Valores);
		}
	}
	else
	{
		if(Opc != 'N')
		{
			if(Opc!="")
			{
				if(f != 'FrmAdjudica')
				{
					alert("Debe Seleccionar un Elemento");
				}
				Valores="";
				return(Valores);
			}
			else
				return(Valores);
		}
		else{
			Valores="//";
			return(Valores);
		}
	}
}
////////FUNCION QUE VALIDA ENTRADA DE FECHAS CON AUTOFORMATO DD/MM/AAAA////////////
var isNav4 = false, isNav5 = false, isIE4 = false
var strSeperator = "/"; 
// If you are using any Java validation on the back side you will want to use the / because 
// Java date validations do not recognize the dash as a valid date separator.

var vDateType = 3; // Global value for type of date format
//                1 = mm/dd/yyyy
//                2 = yyyy/dd/mm  (Unable to do date check at this time)
//                3 = dd/mm/yyyy

var vYearType = 4; //Set to 2 or 4 for number of digits in the year for Netscape
var vYearLength = 2; // Set to 4 if you want to force the user to enter 4 digits for the year before validating.

var err = 0; // Set the error code to a default of zero


if(navigator.appName == "Netscape") 
{
   if (navigator.appVersion < "5")  
   {
      isNav4 = true;
      isNav5 = false;
	}
   else
   if (navigator.appVersion > "4") 
   {
      isNav4 = false;
      isNav5 = true;
	}
}
else  
{
   isIE4 = true;
}
function DiferenciaFechas(FechaIngreso,FechaSalida) 
{

	CadenaFecha1 = FechaIngreso
	CadenaFecha2 = FechaSalida
	
	var fecha1 = new fecha( CadenaFecha1 )   
	var fecha2 = new fecha( CadenaFecha2 )
	var miFecha1 = new Date(fecha1.anio, fecha1.mes, fecha1.dia )
	var miFecha2 = new Date(fecha2.anio, fecha2.mes, fecha2.dia )
	var diferencia = miFecha1.getTime() - miFecha2.getTime()
	var dias =parseFloat(Math.floor(diferencia / (1000 * 60 * 60 * 24)));

	return dias

}

function FechaCorta(FechaLarga)
{
	var diastring=FechaLarga
	var fecharetorno=""
	var Meses= new Array('Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre')
	var NumeroMes=""
	var pos = diastring.indexOf(" ")
	var Dia = diastring.substr(pos+1,2);
	var largo=diastring.length;
	diastring=diastring.substr(pos+7,largo)
	pos = diastring.indexOf(" ")
	var Mes=diastring.substr(0,pos)
	var A�o=diastring.substr(pos+4,4)
	for(i=0;i<12;i++)
		{
			if(Mes===Meses[i])
			{
				NumeroMes=i+1
				if(NumeroMes<10)
				{
				NumeroMes="0"+NumeroMes
				}
			}
		}
	
	FechaLarga=(Dia+"/"+NumeroMes+"/"+A�o)
		
	return FechaLarga
}
function FechaCortaAAAAMMDD(FechaLarga)
{
	var diastring=FechaLarga
	var fecharetorno=""
	var Meses= new Array('Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre')
	var NumeroMes=""
	var pos = diastring.indexOf(" ")
	var Dia = diastring.substr(pos+1,2);
	var largo=diastring.length;
	diastring=diastring.substr(pos+7,largo)
	pos = diastring.indexOf(" ")
	var Mes=diastring.substr(0,pos)
	var A�o=diastring.substr(pos+4,4)
	for(i=0;i<12;i++)
		{
			if(Mes.toUpperCase()===Meses[i].toUpperCase())
			{
				NumeroMes=i+1
				if(NumeroMes<10)
				{
				NumeroMes="0"+NumeroMes
				}
			}
		}
	
	FechaLarga=(A�o+"-"+NumeroMes+"-"+Dia)
		
	return FechaLarga
}



function numDias(d,m,a)
{  
	m = (m + 9) % 12; 
 	a = a - Math.floor(m/10); 
 	return 365*a+Math.floor(a/4)-Math.floor(a/100)+Math.floor(a/400)+Math.floor((m*306+5)/10)+d-1 
}
 
function difDias(d1,m1,a1,d2,m2,a2)
{  

dia1=numDias(d2,m2,a2);
dia2=numDias(d1,m1,a1);

Total=(dia1-dia2);

return (Total)
}


function CalculaDias(FechaInicio,FechaTermino)
{
	

	Matriz1= FechaInicio.split("/");
	Matriz2= FechaTermino.split("/");
	dia=parseFloat(Matriz1[0]);//dias
	mes=parseFloat(Matriz1[1]);//mes
	ano=parseFloat(Matriz1[2]);//año
	dia2=parseFloat(Matriz2[0]);//dias
	mes2=parseFloat(Matriz2[1]);//mes
	ano2=parseFloat(Matriz2[2]);//año
	var Dif=0;
	F1=numDias(dia,mes,ano)
	F2=numDias(dia2,mes2,ano2)
	//alert(dia+","+mes+","+ano+" = "+F1)
	//alert(dia2+","+mes2+","+ano2+" = "+F2)
	Dif=(F2-F1)
	return(Dif)
}

function fecha( cadena ) 
{

   //Separador para la introduccion de las fechas
   var separador = "/"
   //Separa por dia, mes y año
   if ( cadena.indexOf( separador ) != -1 ) 
   {
        var posi1 = 0
        var posi2 = cadena.indexOf( separador, posi1 + 1 )
        var posi3 = cadena.indexOf( separador, posi2 + 1 )
        this.dia = cadena.substring( posi1, posi2 )
        this.mes = cadena.substring( posi2 + 1, posi3 )
        this.anio = cadena.substring( posi3 + 1, cadena.length )
   } else 
   {
        this.dia = 0
        this.mes = 0
        this.anio = 0   
   }

}

//ESTA ES LA FUNCION PARA ITINERARIOS
function DateFormat2(vDateName, vDateValue, e, dateCheck, dateType,eleo,tipo)  {
var fs=eleo;



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
         vDateName.SELECT();
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
               vDateName.SELECT();
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
                  vDateName.SELECT();
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
                     vDateName.SELECT();
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
                     vDateName.SELECT();
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
           	   }
               
               // Create temp. variable for storing the current vDateType
               var vDateTypeTemp = vDateType;
               
               // Change vDateType to a 1 for standard date format for validation
               // Type will be changed back when validation is completed.
               vDateType = 1;
                var mTodayActual = new Date();//CREO EL OBJETO FECHA, PARA OBTNER LA FECHA ACTUAL
              	var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
				var DifA�o=5;// VARIABLE QUE ALMACENA EL RANGO DE A�OS
				var checkYearSuperior = mTodayActual.getFullYear()+ DifA�o; 
				var checkYearInferior = mTodayActual.getFullYear()- DifA�o;
               // Store reformatted date to new variable for validation.
               var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
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
					alert("La fecha ingresada no puede ser mayor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
				if(mYear < checkYearInferior )
				{
					alert("La fecha ingresada no puede ser menor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
			  
			 	 vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
                  
                  // Store the new value back to the field.  This function will
                  // not work with date type of 2 since the year is entered first.
                  
                  if (vDateTypeTemp == 1) // mm/dd/yyyy
                     vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
                  if (vDateTypeTemp == 3) // dd/mm/yyyy
                     vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
				///LLAMADA  DE FUNCION//////////////	
					
					
               } 
               	if(mYear > checkYearSuperior )
				{
					alert("La fecha ingresada no puede ser mayor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
				if(mYear < checkYearInferior )
				{
					alert("La fecha ingresada no puede ser menor que "+DifA�o+" años de la actual ")
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
				//alert(pos+" "+elemento)
					switch (tipo)
					{
  					  	case 'I':
							Actualiza_Fecha(vDateName,fs)
							vDateType = vDateTypeTemp;
    					   break
    					case 'F':
							Traspasa_Fecha(vDateName,fs)
               				vDateType = vDateTypeTemp;
						break
						case 'RIF':
							Traspasa_Fecha_RH(vDateName,fs)
               				vDateType = vDateTypeTemp;
							//alert("adadn")
						break
						case 'RII':
							sumadias(vDateName,fs)
               				vDateType = vDateTypeTemp;
						break
						
						case 'X':
							sumadiasf(vDateName,fs)
               				vDateType = vDateTypeTemp;
						break
						
					}
               		return true;
			   
			   }
            
            }
            else
            {
              
				if(tipo=='F' &&  vDateName.value=='')
				{
				LimpiaCant(vDateName,fs)
				
				}
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
               vDateName.SELECT();
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
            vDateName.SELECT();
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

// SOLO PARA REGISTRO HITOS CALCULA CANTIDAD DE DIAS SOLO PARA UNA LINEA
function DateFormatRegHitos(vDateName, vDateValue, e, dateCheck, dateType,eleo,tipo)  {
var fs=eleo;

	
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
         vDateName.SELECT();
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
               vDateName.SELECT();
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
                  vDateName.SELECT();
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
                     vDateName.SELECT();
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
                     vDateName.SELECT();
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
           	   }
               
               // Create temp. variable for storing the current vDateType
               var vDateTypeTemp = vDateType;
               
               // Change vDateType to a 1 for standard date format for validation

               // Type will be changed back when validation is completed.
               vDateType = 1;
               	var mTodayActual = new Date();//CREO EL OBJETO FECHA, PARA OBTNER LA FECHA ACTUAL
				var DifA�o=5;// VARIABLE QUE ALMACENA EL RANGO DE A�OS
				var checkYearSuperior = mTodayActual.getFullYear()+ DifA�o; 
				var checkYearInferior = mTodayActual.getFullYear()- DifA�o; 
               // Store reformatted date to new variable for validation.	
			   var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
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
					alert("La fecha ingresada no puede ser mayor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
				if(mYear < checkYearInferior )
				{
					alert("La fecha ingresada no puede ser menor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
				 
				 vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
                  
                  // Store the new value back to the field.  This function will
                  // not work with date type of 2 since the year is entered first.
                  
                  if (vDateTypeTemp == 1) // mm/dd/yyyy
                     vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
                  if (vDateTypeTemp == 3) // dd/mm/yyyy
                     vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
			
					
					
               } 
				if(mYear > checkYearSuperior )
				{
					alert("La fecha ingresada no puede ser mayor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
				if(mYear < checkYearInferior )
				{
					alert("La fecha ingresada no puede ser menor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
               	///LLAMADA  DE FUNCION//////////////	
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
					
						
						if(tipo=="FF")
						{
							Traspasa_Fecha_RH(vDateName,fs)
							vDateType = vDateTypeTemp;
						}
						if(tipo=="FI")
						{
							//alert("ALFA")
							Traspasa_Fecha_RHFI(vDateName,fs)
							vDateType = vDateTypeTemp;					
						}
						if(tipo=="FF2")
						{
							Traspasa_Fecha_RH2(vDateName,fs)
							vDateType = vDateTypeTemp;
						}
						return true;
				
				
					
					
				}
            
            }
            else
            {
             
				if(tipo=="FF2")
			 		LimpiaCant(vDateName,fs)
				if(tipo=="FF")
					LimpiaCant(vDateName,fs)
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
               vDateName.SELECT();
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
            vDateName.SELECT();
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
//ESTA ES LA FUNCION  PARA VALIDAR FECHAS 
// SI VAL = S VALIDA SI QUE FECHA INGRESADA NO DEBE SER MAYOR QUE LA ACTUAL
// SI VAL = N  O VACIA PUEDE INGRESAR FECHAS SUPERIOR A LA ACTUAL Y SOLO INGRESO DE FECHA(EL FORMATO)




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
         vDateName.SELECT();
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
               vDateName.SELECT();
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
                  vDateName.SELECT();
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
                     vDateName.SELECT();
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
                     vDateName.SELECT();
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
				var DifA�o=100;// VARIABLE QUE ALMACENA EL RANGO DE A�OS
				var mTodayActual = new Date();//CREO EL OBJETO FECHA, PARA OBTNER LA FECHA ACTUAL
				var checkYearSuperior = mTodayActual.getFullYear()+ DifA�o; 
				var checkYearInferior = mTodayActual.getFullYear()- DifA�o; 
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
						alert("La fecha ingresada no puede ser mayor que "+DifA�o+" años de la actual ")
						vDateName.value = "";
						vDateName.focus();
						return true;
					}
					if(mYear < checkYearInferior )
					{
						alert("La fecha ingresada no puede ser menor que "+DifA�o+" años de la actual ")
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
					alert("La fecha ingresada no puede ser menor que "+DifA�o+" años de la actual ")
					vDateName.value = "";
					vDateName.focus();
					return true;
				}
				if(mYear < checkYearInferior )
				{
					alert("La fecha ingresada no puede ser menor que "+DifA�o+" años de la actual ")
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
               vDateName.SELECT();
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
            vDateName.SELECT();
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

function NumNEGPOS()
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
		var Minusculas = "abcdefghijklmn�opqrstuvwxyz�����() ";
		var Mayusculas = "ABCDEFGHIJKLMN�OPQRSTUVWXYZ���";
		var Contrat = "abcdefghijklmn�opqrstuvwxyzABCDEFGHIJKLMN�OPQRSTUVWXYZ./-0123456789";
		var Espe = "�����abcdefghijklmn�opqrstuvwxyzABCDEFGHIJKLMN�OPQRSTUVWXYZ./-0123456789 ";
		var strTexto = Minusculas + Mayusculas + " " + "\r\n";
		var strAlfanumerico = strTexto + strNumeros + "/-_,;.:�?�!-()%#@";
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
		var Minusculas = "abcdefghijklmn�opqrstuvwxyz�����() ";
		var Mayusculas = "ABCDEFGHIJKLMN�OPQRSTUVWXYZ���";
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
		var Minusculas = "abcdefghijklmn�opqrstuvwxyz";
		var Mayusculas = "ABCDEFGHIJKLMN�OPQRSTUVWXYZ";
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
		var Minusculas = "abcdefghijklmn�opqrstuvwxyz�����() ";
		var Mayusculas = "ABCDEFGHIJKLMN�OPQRSTUVWXYZ���";
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
/*function CalculaDv(Texto,Dig,Form)
{	
	var f=document.Form;
	if (Texto!="")
	{
		var M=0,S=1;
		for(;Texto;Texto=Math.floor(Texto/10))
		S=(S+Texto%10*(9-M++%6))%11;
		f.Dig.value= S?S-1:'k';
	}
	else
	{
		return;
	}
}*/

function ValidaIngreso(ValidaNum,PermiteDecimales,formulario,CampoSgte) 
{ 
	var teclaCodigo = event.keyCode; 
	//alert(ValidaNum);
	//alert(teclaCodigo);
	if(teclaCodigo == 17 ||teclaCodigo == 16)
		return;
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
function ValidaIngreso2(ValidaNum,PermiteDecimales,formulario,CampoSgte) 
{ 
	var teclaCodigo = event.keyCode; 
	
	//alert(teclaCodigo);
	if(teclaCodigo == 17 ||teclaCodigo == 16)
		return;
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
			}//FIN VALIDA DECIMALES
		}//FIN SI VALIDA NUMERO
	}//FIN SI ES ENTER
}

function CalculaDv(form,nomrut,nomdv)
{	
	var num=0,dv=new Object();
	
	num=eval("document."+form.name+"."+nomrut+".value");
	if (num!="")
	{
		var M=0,S=1;
		for(;num;num=Math.floor(num/10))
			S=(S+num%10*(9-M++%6))%11;
		dv=eval("document."+form.name+"."+nomdv);
		dv.value=S?S-1:'k';
	}
	else
		return;
}

function ValidaFec(AI,MI,DI,AT,MT,DT,Res,Opcion)
{
	var Encontro=false;
	if (AI > AT) 
		Encontro=true;
	else{
		if(MI > MT)
			Encontro=true;
			else{
				if(DI > DT)
					Encontro=true;
			}
	}
	if (Encontro==true)
	{
		alert("Fecha Inicio es Mayor que fecha Termino");
		Res=false;
		return;
	}
	else{
		Res=true;
	}
	//alert();
	//alert(Res);//
	return(Res)	
}
//calcular la edad de una persona 
//recibe la fecha como un string en formato español 
//devuelve un entero con la edad. Devuelve false en caso de que la fecha sea incorrecta o mayor que el dia actual 
function calcular_edad(fecha){ 

    //calculo la fecha de hoy 
    hoy=new Date() 
    //alert(hoy) 

    //calculo la fecha que recibo 
    //La descompongo en un array 
    var array_fecha = fecha.split("/") 
    //si el array no tiene tres partes, la fecha es incorrecta 
    if (array_fecha.length!=3) 
       return false 

    //compruebo que los ano, mes, dia son correctos 
    var ano 
    ano = parseInt(array_fecha[2]*1); 
    if (isNaN(ano)) 
       return false 

    var mes 
    mes = parseInt(array_fecha[1]*1);
    if (isNaN(mes)) 
       return false 

    var dia 
    dia = parseInt(array_fecha[0]*1); 
    if (isNaN(dia)) 
       return false 


    //si el año de la fecha que recibo solo tiene 2 cifras hay que cambiarlo a 4 
    if (ano<=99) 
       ano +=1900 

    //resto los años de las dos fechas 
    edad=hoy.getYear()- ano - 1; //-1 porque no se si ha cumplido años ya este año 

	 //si resto los meses y me da menor que 0 entonces no ha cumplido años. Si da mayor si ha cumplido 
	if (hoy.getMonth() + 1 - mes < 0) //+ 1 porque los meses empiezan en 0 
	   return edad
	if (hoy.getMonth() + 1 - mes > 0) 
	   return edad+1 	
    //entonces es que eran iguales. miro los dias 
    //si resto los dias y me da menor que 0 entonces no ha cumplido años. Si da mayor o igual si ha cumplido 
	if (hoy.getUTCDate() - dia >= 0) 
       return edad + 1 

    return edad 
}
// funcion que valida el rut 
function revisarDigito(dvr, foco)
{	
	dv = dvr + ""	
	if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K')	
	{		
		alert("Debe ingresar un digito verificador valido para el "+name);		
		foco;	
		return false;	
	}	
	return true;
}

function revisarDigito2(crut, foco, name) 
{	
	largo = crut.length;	
	if ( largo < 2 )	
	{		
		alert("Debe ingresar el "+name+" completo")		
		foco;		
		return false;	
	}	
	if ( largo > 2 )		
		rut = crut.substring(0, largo - 1);	
	else		
		rut = crut.charAt(0);	
	dv = crut.charAt(largo-1);	
	revisarDigito(dv, name);	

	if ( rut == null || dv == null )
		return 0	

	var dvr = '0'	
	suma = 0	
	mul  = 2	

	for (i= rut.length -1 ; i >= 0; i--)	
	{	
		suma = suma + rut.charAt(i) * mul		
		if (mul == 7)			
			mul = 2		
		else    			
			mul++	
	}	
	res = suma % 11	
	if (res==1)		
		dvr = 'k'	
	else if (res==0)		
		dvr = '0'	
	else	
	{		
		dvi = 11-res		
		dvr = dvi + ""	
	}
	if ( dvr != dv.toLowerCase() )	
	{		
		alert("El "+name+" es incorrecto")		
		foco;	
		return false	
	}

	return true
}

function Rut( texto, name, foco, valor) 
{	
	
	var tmpstr = "";	
	for ( i=0; i < texto.length ; i++ )		
		if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
			tmpstr = tmpstr + texto.charAt(i);	
	texto = tmpstr;	
	largo = texto.length;	

	if ( largo < 2 )	
	{		
		alert("Debe ingresar completo el "+name)		
		foco;
		return false;	
	}	

	for (i=0; i < largo ; i++ )	
	{			
		if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" )
 		{			
			alert("El valor de "+name+" no corresponde a un R.U.T valido");			
			foco;			
			return false;		
		}	
	}	

	var invertido = "";	
	for ( i=(largo-1),j=0; i>=0; i--,j++ )		
		invertido = invertido + texto.charAt(i);	
	var dtexto = "";	
	dtexto = dtexto + invertido.charAt(0);	
	dtexto = dtexto + '-';	
	cnt = 0;	

	for ( i=1,j=2; i<largo; i++,j++ )	
	{		
		//alert("i=[" + i + "] j=[" + j +"]" );		
		if ( cnt == 3 )		
		{			
			dtexto = dtexto;			
			j++;			
			dtexto = dtexto + invertido.charAt(i);			
			cnt = 1;		
		}		
		else		
		{				
			dtexto = dtexto + invertido.charAt(i);			
			cnt++;		
		}	
	}	

	invertido = "";	
	for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )		
		invertido = invertido + dtexto.charAt(i);	

	valor = invertido.toUpperCase()		

	if ( revisarDigito2(texto, foco, name) )		
		return true;	

	return false;
}
