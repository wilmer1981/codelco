<?
include("conectar.php");
$Fecha =$ano."-".$mes."-".$dia;

       if (empty($CookieUsuario))
        {
                Header("Location:Mensaje_Error.htm");
                exit;
        }
		
        $consulta="select * from usuarios where rut='$CookieUsuario'";
        $result=mysql_query($consulta);
        while ($row=mysql_fetch_array($result))
        {
                $nombre=$row[NOMBRE_APELLIDO];
				$rut=$row[RUT]; 
        }
                 $diaact=date("d");
                 $mesact=date("m");
                 $anoact=date("Y");
                 $fecha_actual="$diaact/$mesact/$anoact";
      include("cerrar.php");

?>		
		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<Script language="JavaScript">
<!--


function ing_user()
{

        FrmPrincipal.action='Ingreso_novedades.php';
        FrmPrincipal.submit();
}


function ver_nov()
{

        FrmPrincipal.action='ver_Novedades.php';
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
        <td width="13%" height="22" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF"><? echo $CookieFecha ?></font></div></td>
        <td width="14%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF"><? echo $rut ?></font></div></td>
        <td width="45%" height="22" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $nombre ?></font></td>
      </tr>
      <tr> 
        <td colspan="4"> <div align="center"> </div>
          <div align="center"></div>
          <p align="center"><font color="#000000" size="1"><strong>Ingrese Texto</strong></font></p>
          <p align="center"> <font color="#000000" size="1"> 
            <textarea name="Texto" cols="100" rows="15"></textarea>
            </font></p>
          <p align="center"><font color="#000000" size="1"><strong>Para Ver las 
            Novedades Ingrese la Fecha</strong></font> </p></td>
      </tr>
      <tr> 
        <td height="25" colspan="4"><div align="center"> 
            <p> 
              <input name="Volver" type="submit"  value="Volver" onClick="Volver_Atras()";" target="_blank">
              <input name="Guardar" type="submit"  value="Guardar" onClick="ing_user()";" target="_blank">
              <input name="Salir" type="submit" value="Salir" onClick="Salir_F()";" target="_blank">
            </p>
          </div></td>
      </tr>
    </table>
    
  </div>
</form>
</body>
</html>