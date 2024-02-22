<html><title> Ingreso</title>
<link href="style.css" rel="stylesheet" type="text/css">
<head>


<Script language="JavaScript">
<!--

function Ventana(URL)
{
        var lista = window.open(URL,"","top=150,left=150,width=300,height=160,status=no,scrollbars=no");
        if ((document.window != null) && (!lista.opener))
        lista.opener = document.window;
}


function ing_user()
{
        if (FrmPrincipal.Rut.value=='')
        {
                alert ("Ingrese su Rut");
                FrmPrincipal.Rut.focus();
                return
        }
        if (FrmPrincipal.Pass.value=='')
        {
                alert ("Debe ingresar su Contraseña");
                FrmPrincipal.Pass.focus();
                return
        }
        FrmPrincipal.action='index.php';
        FrmPrincipal.submit();
}

//-->
</script>

</head>


<body  background="imagenes/fondo.gif" onLoad="JavaScript:document.FrmPrincipal.Rut.focus();">
<table width="97%" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td width="27%" height="48" > <div align="left"></div></td>
    <script>
    function makeLinkTo(s) 
    { window.top.location.href = s.options[s.selectedIndex].value; }
    </script>
    <td width="50%" bgcolor="#FFFFFF"><div align="center"><font size="6"><img src="imagenes/tituloenami.gif" width="220" height="27"></font></div></td>
    <td width="23%"> <div align="center">
        <script>
	<!-- 
	fecha=new Date();
	dias=new Array();
	meses=new Array();
	
	var diasem; var diames; var mes; var ano;
	
	diasem=fecha.getDay();
	diames=fecha.getDate();
	mes=fecha.getMonth();
	ano=fecha.getYear();
	
	dias[0]="Domingo";
	dias[1]="Lunes";  
	dias[2]="Martes";
	dias[3]="Miercoles";  
	dias[4]="Jueves";
	dias[5]="Viernes";  
	dias[6]="Sabado";
	 
	meses[0]="Enero";
	meses[1]="Febrero";
	meses[2]="Marzo";
	meses[3]="Abril";
	meses[4]="Mayo";
	meses[5]="Junio";
	meses[6]="Julio";
	meses[7]="Agosto";
	meses[8]="Septiembre";
	meses[9]="Octubre";
	meses[10]="Noviembre";
	meses[11]="Diciembre";
	 
	document.write("<font  size='2' color='#6666CC'><strong>"+dias[diasem]+" "+diames+" de " +meses[mes]+" de "+ano+"</strong></font>" );
	</script>
      </div></td>
  </tr>
</table>
<p align="center"><font size="4"><strong>Sistema de Informe Diario Fundicion y Refiner&iacute;a Ventanas</strong></font></p>
<p align="center">&nbsp;</p>

<form name="FrmPrincipal" method="post" action="JavaScript:ing_user()">
  <div align="center">
    <table width="32%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td colspan="2" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="3">Ingrese 
            su Cuenta</font></strong></div></td>
      </tr>
      <tr> 
        <td width="42%"><font color="#000000" size="2"><strong>Rut</strong></font></td>
        <td> <div align="left"> 
            <input name="Rut" type="text" size="12" maxlength="10">
          </div></td>
      </tr>
      <tr> 
        <td><strong><font color="#000000" size="2">Password</font></strong></td>
        <td> <div align="left"> 
            <input name="Pass" type="password" size="4" maxlength="4">
          </div></td>
      </tr>
      <tr> 
        <td height="25">&nbsp;</td>
        <td> <div align="center"> </div>
          <input type="submit" name="ingreso" value="Ingreso" onClick="ing_user()"; target="_blank"></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p><strong><a href="http://<? echo HTTP_SERVER; ?>/proyecto/sistemas.html"><img src="BotonVolver.gif" width="74" height="20" border="0"></a></strong></p>
    <p>&nbsp;</p>

  </div>
    </form>

</body>
</html>
