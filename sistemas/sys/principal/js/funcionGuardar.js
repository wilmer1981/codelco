$(".Guardar").click(function(){
	
	var Opcion=$(this).attr("name");
	var form=$(this).attr("id");
	var Pagina=$(this).data("idpagina")
	//alert(form);
	ProcesarAccion(Pagina,Opcion,form);
});
 
function SoloNumeros(e,field) 
{ 
     var field = $(field);
     key = e.keyCode ? e.keyCode : e.which;
 

     if (key == 8) return true;
     if (key > 47 && key < 58) {
       if (field.val() === "") return true;
       var existePto = (/[.]/).test(field.val());
       if (existePto === false){
           regexp = /.[0-9]{10}$/; //PARTE ENTERA 10
       }
       else {
         regexp = /.[0-9]{2}$/; //PARTE DECIMAL2
       }
       return !(regexp.test(field.val()));
     }
     //ESTE IF ES PARA SABER SI ACEPTO PUNTO 46 O DECIMAL 44
     //alert (key);
     if (key == 46) {
       if (field.val() === "") return false;
       regexp = /^[0-9]+$/;
       return regexp.test(field.val());
     }
     return false;
}

function VerificaRango(idhora,idmuestra)
{
	var valueCampo = $("#DataValores"+idhora+"_"+idmuestra).val();

	var Rangos = $("#rangoMuestra"+idhora+"_"+idmuestra).val();

	var Explorar = Rangos.split("||");

	$("#DataValores"+idhora+"_"+idmuestra).css("background","white");
	if(valueCampo > 0)
	{
		for(var i=0;i<Explorar.length;i++)
		{
			var data = Explorar[i].split('_');


			var sigmin=data[1];

			var sigmax=data[3];

			if (sigmin!='' && sigmax!='') 
			{

				if(eval(parseFloat(valueCampo) +sigmin+ parseFloat(data[0])) && eval (parseFloat(valueCampo) +sigmax+ parseFloat(data[2])))
				{
					$("#DataValores"+idhora+"_"+idmuestra).css("background",data[4]);
					$("#DataValores"+idhora+"_"+idmuestra).css("color","black");
					
				}
				
				if(valueCampo > "99999")
				{
					$("#DataValores"+idhora+"_"+idmuestra).css("background","red");
					$("#DataValores"+idhora+"_"+idmuestra).css("color","black");				
				}
			}
		}		
	}
}

function RecorreRangos()
{
	$(".ValoresRecorrer").each(function(){

		var IdHoraIdMuestra = $(this).attr('id').replace("DataValores",'');

		IdHoraIdMuestra = IdHoraIdMuestra.split("_");

		//console.log(IdHoraIdMuestra[0]+);

		VerificaRango(IdHoraIdMuestra[0],IdHoraIdMuestra[1]);
	})
}


function ProcesarAccion(Pagina,Opcion,form)
{
	var Data = "";
	if(form!='')
		Data = ValidarDatosFormulario(form);		

	console.log(Data);
	$.ajax({
		url:"?p="+Pagina+"&Opcion="+Opcion,
		type: "post",
		dataType:"json",
		data: Data,
		timeout:10000,
		success:function(DataObj){
			//console.log(DataObj);
			if(DataObj.sucess)
			{
				if(DataObj.MuestraMensaje)
				{
					swal({
					  title: DataObj.Titulo,
					  text: DataObj.mensaje,
					  type: DataObj.typeMsj,
					  showCancelButton: false,
					  confirmButtonColor: "#DD6B55",
					  confirmButtonText: "OK",
					  closeOnConfirm: true
					},
					function(){
						RetornoSuccessAjax(DataObj,Pagina);
					});						
				}
				else
					RetornoSuccessAjax(DataObj,Pagina);
			}
			else
			{
				swal(DataObj.Titulo,DataObj.mensaje,DataObj.typeMsj);
			}
		}
	});
}


function ValidarDatosFormulario(Form)
{
	var Cadena = "";var Pasa = true;
	$("form#"+Form).find(':input, select').each(function() {			
	    var elemento= this;

	    $(this).removeClass("inputRojo");
	    if(elemento.required && (elemento.value == "" || elemento.value == "-1"))      
	    {
	      $(this).addClass("inputRojo");
	      Pasa = false;
	    }

	    if(elemento.type == "checkbox")
	    {
	      if(elemento.checked)
	        Cadena = Cadena + elemento.id+"=S&";
	      else
	        Cadena = Cadena + elemento.id+"=N&";
	    }
	    else
	      Cadena = Cadena + elemento.id+"="+elemento.value+"&";
	});  
	Cadena = Cadena.substr(0,Cadena.length-1);

	if(Pasa == true)
	  return Cadena;
	else
	  return "";
}
