<?
include("conectar.php");
$Consulta = "SELECT * FROM subs_web.usuarios WHERE password = $Pass AND rut = '$Rut' ";
$rs = mysqli_query($link, $Consulta);
if ($row = mysql_fetch_array($rs))
{
                $dia=date("d"); //ENTREGA NUMERO DE DIA SIN CERO (1-31)
                $mes=date("m"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
                $ano=date("Y"); //ENTREGA NUMERO DE A�O DE 4 DIGITOS (2002)
                $HoraAcceso = date("Y-m-d H:i:s");
                $fecha_ingreso="$dia/$mes/$ano";

                @setcookie("CookieUsuario",$row["rut"]);
                @setcookie ("CookiePass",$row["password"]);
                @setcookie ("CookieTipoUsuario",$row["tipo_usuario"]);
                @setcookie ("CookieFechaIngreso",$fecha_ingreso);

                if ($row[tipo_usuario] == 1)
                {
                        header("location:main.php");
                        include("cerrar.php");
                }
                elseif ($row[tipo_usuario] == 2)
                {
                        header("location:main.php");
                        include("cerrar.php");
                }
				
}

include("cerrar.php");
       echo "<Script>
       alert('Lo Sentimos Pero este Usuario No Existe o Ingreso Erroneamente Su Clave');  
       JavaScript:window.history.back();
	   </Script>";
?>