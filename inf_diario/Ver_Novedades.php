<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
      
   @setcookie ("CookieFecha",$Fecha);    
   
   $sql = "SELECT Fecha, Rut, Nombre, Texto FROM novedades WHERE Fecha = '$Fecha'and Cod_Tipo = '$CookieTipoUsuario' ";
   $result = mysql_query($sql, $link);


   if ($row = mysql_fetch_array($result))
   {
        $Rut = $row["Rut"];
	if($Rut == $CookieUsuario)
	    {	
	   $Fecha = $row["Fecha"]; 
       $Nombre = $row["Nombre"];
       $Texto = $row["Texto"];
       }    
   else
       {
       echo "<Script>
       alert('Otro Usuario ingreso novedades para esta Fecha');	     
	  </Script>";
	   $Rut = $row["Rut"];
	   $Fecha = $row["Fecha"]; 
       $Nombre = $row["Nombre"];
       $Texto = $row["Texto"];

       }
}	
else	
{     
 header("Location:novedades.php");
}

?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

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


        FrmPrincipal.action='Ingreso_novedades.php';
        FrmPrincipal.submit();
}

function mod_info()
{
        var Fecha;
		Fecha = <? echo $dia/$mes/$ano ?> 
		FrmPrincipal.action='Modificar_Novedades.php';
        FrmPrincipal.submit();
}

function elim_info()
{
        FrmPrincipal.action='Eliminar_Novedades.php';
        FrmPrincipal.submit();
}

function Salir_F()
{
        FrmPrincipal.action='Salir.php';
        FrmPrincipal.submit();

}

function Volver_Atras()
{
        FrmPrincipal.action="JavaScript:window.history.back();";
        FrmPrincipal.submit();

}


//-->

</script>


<body  background="imagenes/fondo.gif" onload="JavaScript:document.FrmPrincipal.Texto.focus();">
<form name="FrmPrincipal" method="post">
  <div align="center">
    <table width="87%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr bgcolor="#006699"> 
        <td width="28%" height="22" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Novedades</font></strong></div></td>
        <td width="13%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF"><? echo $Fecha ?></font></div></td>
        <td width="14%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF"><? echo $Rut ?></font></div></td>
        <td width="45%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $Nombre ?></font></div></td>
      </tr>
      <tr> 
        <td colspan="4"><div align="center"></div>
          <p align="center"><font color="#000000" size="1"><strong>Ingrese Texto</strong></font></p>
          <p align="center"> <font color="#000000" size="1"> 
            <textarea name="Texto" cols="100" rows="15" value="<? echo $Texto ?>" ><? echo $Texto ?></textarea>
            </font></p>
          <p align="center"><font color="#000000" size="1"><strong>Para Ver las 
            Novedades Ingrese la Fecha</strong></font> </p></td>
      </tr>
      <tr> 
        <td height="25" colspan="4"> <div align="center"> 
            <p><font size="1"> 
              <input name="Volver" type="submit"  value="Volver" onClick="Volver_Atras()";" target="_blank">
              <input name="Modificar" type="submit"  value="Modificar" onClick="mod_info()";" target="_blank">
              <input name="Eliminar" type="submit" value="Eliminar" onClick="elim_info()";" target="_blank">
              <input name="Salir" type="submit" value="Salir" onClick="Salir_F()";" target="_blank">
              </font></p>
          </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </div>
</form>
</body>
</html>