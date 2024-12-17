 
 
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
     return false;

  return true;
}
  $(".btnModal").click(function(){

      event.preventDefault();

      var $contenedorModal = $('#contieneModal');
      var urlModal         = $(this).attr("href");
      var urlModalOpciones = $(this).attr("id");
      var idModal          = $(this).data("idmodal");

      $(idModal).modal("hide");
      $contenedorModal.load(urlModal+urlModalOpciones, function(response) {
        //console.log(idModal);
        $(idModal).modal("show");
      });     
  });

function Cargapagina(Pagina,DIV,form)
{
	var Data = "";
	if(form!='')
		Data = ValidarDatosFormulario(form);
	Cargando('block');

	console.log("?p="+Pagina);
	$.ajax({
		url:"?p="+Pagina,
		type: "post",
		data: Data,
		timeout:10000,
		success:function(html){
			console.log(html);
			$("#"+DIV).html(html);
			Cargando("none");
		}
	});
}

function ProcesarAccion(Pagina,Opcion,form)
{
	var Data = "";
	if(form!='')
		Data = ValidarDatosFormulario(form);
 
 	Cargando('block');
	$.ajax({
		url:"?p="+Pagina+"&Opcion="+Opcion,
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

function RetornoSuccessAjax(Data,Pagina)
{
	//alert(Pagina);
	switch(Pagina)
	{
		case "changepass"://Opcion Login
		case "agua_tipo_muestra"://Opcion Login		
			Cargapagina(Pagina,"","");
		break;
		case "index"://Opcion Login		
		 	location.href = '?p='+Data.p;
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



function Cargando(Option)
{
	$("#Cargando").css("display",Option);
}


$(".btnDelete").click(function(){
	event.preventDefault();
	var Opcion=$(this).attr("name");
	var url=$(this).attr("href");
	if(confirm("Esta seguro de eliminar el registro")){
		ProcesarAccion(url,Opcion,'');
	}
});




$(window).ready(function(){Cargando("none");})

