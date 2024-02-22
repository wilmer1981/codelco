$(".btn-login").click(function(){

    if(Fn.validaRut($("#inputRut").val()))
    {
        $("#inputRut").parents(".control-group").removeClass("error");

        var LargoPass = $("#inputPassword").val().length;
        if(LargoPass >= 7)
        {
            ProcesarAccion("index","login","Login");
            $("#inputPassword").parents(".control-group").addClass("error");
        }
        else
            $("#inputPassword").parents(".control-group").removeClass("error");
    }
    else
        $("#inputRut").parents(".control-group").addClass("error");
})
$(function(){         
    $("#inputRut").rut({formatOn: 'keyup', validateOn: 'keyup'}).on('rutInvalido', function(){ $(this).parents(".control-group").addClass("error")}).on('rutValido', function(){ $(this).parents(".control-group").removeClass("error")});
}); 

function alfanumerico(pwd,id)  
{ 
 var letras = /[A-Za-z]/;
 var numeros = /[0-9]/;
 var simbolo = /[^A-Za-z0-9]/;  
 if(pwd.match(letras)&&pwd.match(numeros)&&pwd.match(simbolo)==null)   
  {  
   //return "correcta"; 
    $("#"+id).removeClass("inputError"); 
  }
  else
  {
     if (pwd.match(simbolo)!=null) 
      {    
       //return "simbolo";  
        $("#"+id).addClass("inputError");  
      }
      else
      {
        //return "incorrecta";
        $("#"+id).addClass("inputError");          
      }
  }   
 } 

$(".btn-Change").click(function(){

    if($("#inputNew").val() != $("#inputNew2").val())
    {
        swal("Mensaje de Sistema","Las contrase\u00f1as no coinciden","error");
        return;
    }
    ProcesarAccion("index","change","Change");
})