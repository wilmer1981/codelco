
 
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
     return false;

  return true;
}
function mostrarUnidades(id,objeto){
if (objeto.checked==true) 
   $('#'+id).css('display','block');
 else
   $('#'+id).css('display','none');
 
}
function recargarCombos(Pagina,Opcion,combollenar,form){
			//alert();
		var DatosEnviar=	BuscarInfo(form);
	 

		$("#"+combollenar).empty();

		//console.log(DatosEnviar);
		$.ajax({
	        type: "post",
			dataType:"json",
	        url: "?p="+Pagina+"&Opcion="+Opcion,
			timeout:10000,
			data: DatosEnviar,
			success: function(data){

				$("#"+combollenar).append("<option value='-1' >Seleccionar </option>");
				
				if(data.dato != null)
				{
						$.each( data.dato, function( key, value ) {
							//console.log( value.nombre );
							$("#"+combollenar).append("<option value="+value.id+" "+value.selected+">"+value.nombre+"</option>");
						});
				}
			}
	    })	
}



function modal(urlModal,urlModalOpciones,idModal,divContenedor)
{
	var $contenedorModal = $('#'+divContenedor);
	Cargando('block');
	$(idModal).modal("hide");
	$contenedorModal.load(urlModal+urlModalOpciones, function(response) {
		$(idModal).modal("show");
		Cargando('none');
	});     	
}

function Cargapagina(Pagina,DIV,form)
{
	var Data = "";
	if(form!='')
		Data = ValidarDatosFormulario(form);
	Cargando('block');

	$(".nav > li").removeClass("active");
 	$("button.navbar-toggle.toggled").click();
	//console.log(Data);
	$.ajax({
		url:"?p="+Pagina,
		type: "post",
		data: Data,
		timeout:60000,
		success:function(html){
			//console.log(html);

			$("#"+Pagina).addClass("active");
			//$("#"+Pagina+" p").css("display",'none');

			$("#"+DIV).html(html);
			Cargando("none");
		},
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
	});
}
function validrechas(Pagina,DIV,IdHora,IdMuestra,FormularioVisible,Opcion)
{
	var Data = "";
	if(FormularioVisible!='')
		Data = ValidarDatosFormulario(FormularioVisible);
	Cargando('block');

	$.ajax({
		url:"?p="+Pagina+"&idhora="+IdHora+"&idmues="+IdMuestra+"&Opcion="+Opcion,
		type: "post",
		dataType:"json",
		data: Data,
		timeout:10000,
		success:function(DataObj){
			Cargando('none');
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

function CargapaginaResumen(Pagina,DIV,form,Opcion)
{
	var Data = "";
	if(form!='')
		Data = ValidarDatosFormulario(form);
	Cargando('block');

	$.ajax({
		url:"?p="+Pagina+Opcion,
		type: "post",
		data: Data,
		timeout:10000,
		success:function(html){
			//console.log(html);
			$("#"+DIV).html(html);
			Cargando("none");
		}
	});
}

function logout(Pagina, Opcion){

  swal({
   title: "Esta seguro de Salir del sistema?",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: "Si, Salir!",
   closeOnConfirm: false
  },
  function(){
      ProcesarAccion(Pagina,Opcion,'');
  });
}

function GuardarValorMuestra(Pagina,Opcion,form)
{

	swal({
		title: "Esta seguro de Grabar el dato para Planta: " + $("#planta option:selected").html()+ " Del Campamento:" + $("#campamento option:selected").html()+  "?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Si, Grabar!",
		closeOnConfirm: false
	},
	function(){
		ProcesarAccion(Pagina,Opcion,form);
	});		
}

function ProcesarAccion(Pagina,Opcion,form)
{

	var Data = "";var Pasa = 'S';
	if((Opcion.substr(0,6) == 'buscar' ||  Opcion.substr(0,8) == 'eliminar' || Opcion.substr(0,8) == 'eliminar_detalle'))
	{
		
		if(form!='')
			Data = BuscarInfo(form);

	}
	else
	{ 	
		if(form!='')
			Data = ValidarDatosFormulario(form);		
		if(Data == ''){
			Pasa = 'N';
			if(Opcion=='logout')
				Pasa= 'S';
		}

		//if(Opcion == 'aplicarLeyes')
			//Data+= BuscarInfo('formulario3');	
	}

	//console.log(Data);
	if(Pasa == 'S')
	{
		Cargando('block');
		$.ajax({
			url:"?p="+Pagina+"&Opcion="+Opcion,
			type: "post",
			dataType:"json",
			data: Data,
			timeout:10000,
			success:function(DataObj){
				Cargando('none'); 
				//alert ("aqui1");
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


}

function RetornoSuccessAjax(Data,Pagina)
{
	
	switch(Data.tipoRefresh)
	{
		case "Pagina":
 			 //alert ("aqui");
			$("#"+Data.p).submit();
		break;
		case "Refresco":
				//if ($('#leyesNew').val() && $('#impurezasNew').val();) {
					$('#leyesNew').val(Data.cadenaLeyes);
					$('#impurezasNew').val(Data.cadenaImpurezas);
				
 				$('#leyesSave').val(Data.cadenaLeyes);
 				

 				$('#impurezasSave').val(Data.cadenaImpurezas);
 				//$('#impurezasNew').val(Data.cadenaImpurezas);
 				//alert ($('#impurezas').val());
		break;
	}
}

function ValidarDatosFormulario(Form)
{
	var Cadena = "";var Pasa = true;

	$("#"+Form).find(':input, select').each(function() {			
	    var elemento= this;

	    $(this).removeClass("inputRojo");
	    if(elemento.required && (elemento.value == "" || elemento.value == "-1"))      
	    {
	      $(this).addClass("inputRojo");
	      Pasa = false;
	    }

	    if(elemento.type == "checkbox" || elemento.type == "radio")
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
function BuscarInfo(Form)
{
	var Cadena = "";var Pasa = true;

	$("#"+Form).find(':input, select').each(function() {			
	    var elemento= this;

	    if(elemento.type == "checkbox" || elemento.type == "radio")
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

	$("#remuestreo"+idhora+"_"+idmuestra).css("display","none");
	
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

					if(data[4] != '#99FF99')
					{
						if ($("#issupervisor").val()!='operador') {
							if ($("#estado"+idhora+"_"+idmuestra).val()=='P') 
							{
								//$("#botonRechazar"+idhora+"_"+idmuestra).css("display","block");
								$("#botonValidar"+idhora+"_"+idmuestra).css("display","block");
							}
							$("#fueraNorma"+idhora+"_"+idmuestra).val('S');
						}
						else
							$("#fueraNorma"+idhora+"_"+idmuestra).val('S');	

						if(data[4] == '#ff3333' && $("#estado"+idhora+"_"+idmuestra).val()!='A')
						{
							$("#remuestreo"+idhora+"_"+idmuestra).css("display","block");	
						}							
					}
					else
					{
						$("#fueraNorma"+idhora+"_"+idmuestra).val('N');
						//$("#botonRechazar"+idhora+"_"+idmuestra).css("display","none");
						$("#botonValidar"+idhora+"_"+idmuestra).css("visibility","hidden");						
					}
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

function VerificaRangoR(idhora,idmuestra)
{
	var valueCampo = $("#DataValoresR"+idhora+"_"+idmuestra).val();

	var Rangos = $("#rangoMuestra"+idhora+"_"+idmuestra).val();

	var Explorar = Rangos.split("||");

	$("#DataValoresR"+idhora+"_"+idmuestra).css("background","white");
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
					$("#DataValoresR"+idhora+"_"+idmuestra).css("background",data[4]);
					$("#DataValoresR"+idhora+"_"+idmuestra).css("color","black");

					if(data[4] != '#99FF99')
					{
						if ($("#issupervisor").val()!='operador') {
							if ($("#estado"+idhora+"_"+idmuestra).val()=='P') 
							{
								//$("#botonRechazar"+idhora+"_"+idmuestra).css("display","block");
								$("#botonValidarR"+idhora+"_"+idmuestra).css("display","block");
							}
							$("#fueraNorma"+idhora+"_"+idmuestra).val('S');
						}
						else
							$("#fueraNorma"+idhora+"_"+idmuestra).val('S');	
					}
					else
					{
						$("#fueraNorma"+idhora+"_"+idmuestra).val('N');
						//$("#botonRechazar"+idhora+"_"+idmuestra).css("display","none");
						$("#botonValidarR"+idhora+"_"+idmuestra).css("visibility","hidden");						
					}
				}
								
				if(valueCampo > "99999")
				{
					$("#DataValoresR"+idhora+"_"+idmuestra).css("background","red");
					$("#DataValoresR"+idhora+"_"+idmuestra).css("color","black");				
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

		//console.log(IdHoraIdMuestra[0]+'-'+IdHoraIdMuestra[1]);

		try {
			  VerificaRango(IdHoraIdMuestra[0],IdHoraIdMuestra[1]);
		} catch (e) {
		  console.log(e.name + ': ' + e.message);
		}

		
	})


	$(".ValoresRecorrerR").each(function(){

		var IdHoraIdMuestra = $(this).attr('id').replace("DataValoresR",'');

		IdHoraIdMuestra = IdHoraIdMuestra.split("_");

		try {
			  VerificaRangoR(IdHoraIdMuestra[0],IdHoraIdMuestra[1]);
		} catch (e) {
		  console.log(e.name + ': ' + e.message);
		}
		
	})
}

function Cargando(Option)
{
	$("#Cargando").css("display",Option);
}

function eliminar(url,Opcion){
 
  
  swal({
   title: "Esta seguro de eliminar el registro?",
   text: "No podras recuperar el registro eliminado!",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: "Si, Eliminar!",
   closeOnConfirm: false
  },
  function(){
      ProcesarAccion(url,Opcion,'');
  });
 
}
 

$(window).ready(function(){
	Cargando("none");
})

 
