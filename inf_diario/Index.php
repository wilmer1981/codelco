<?php
include("../principal/conectar_principal.php");
$Rut = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
$Pass = isset($_REQUEST["Pass"])?$_REQUEST["Pass"]:"";
$sql = "SELECT * FROM informe_diario.usuarios WHERE PASSWORD = '$Pass' and RUT like '%$Rut%'";
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result))
{
                $dia=date("d"); //ENTREGA NUMERO DE DIA SIN CERO (1-31)
                $mes=date("m"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
                $ano=date("Y"); //ENTREGA NUMERO DE AÑO DE 4 DIGITOS (2002)
                $HoraAcceso = date("Y-m-d H:i:s");
                $fecha_ingreso="$dia/$mes/$ano";

                @setcookie("CookieUsuario",$row["RUT"]);
                @setcookie ("CookiePass",$row["PASSWORD"]);
                @setcookie ("CookieTipoUsuario",$row["Grupo"]);
				@setcookie ("CookieNombreUsuario",$row["NOMBRE_APELLIDO"]);
                @setcookie ("CookieFechaIngreso",$fecha_ingreso);

                if ($row["Grupo"] == "1")
                {
                        header("location:Fundicion.php");
                        include("cerrar.php");
                }
                elseif ($row["Grupo"] == "2")
                {
                        header("location:Refino.php");
                        include("cerrar.php");
                }
                elseif ($row["Grupo"] == "3")
                {
                        header("location:PlantaAcid.php");
                        include("cerrar.php");
                }
                elseif ($row["Grupo"] == "4")
                {
                        header("location:TermOxig.php");
                        include("cerrar.php");
                }
                   elseif ($row["Grupo"] == "5")
                {
                        header("location:Novedades_Ref.php");
                        include("cerrar.php");
                }
                     elseif ($row["Grupo"] == "6")
                {
                        header("location:Novedades_seg.php");
                        include("cerrar.php");
                }
                     elseif ($row["Grupo"] == "7")
                {
                        header("location:Novedades_pol.php");
                        include("cerrar.php");
                }
                      elseif ($row["Grupo"] == "8")
                {
                        header("location:Novedades_segi.php");
                        include("cerrar.php");
                }
				
				   elseif ($row["Grupo"] == "9")
                {
				
                        header("location:Novedades_Prod_Met.php");
                        include("cerrar.php");
                }
					elseif ($row["Grupo"] == "10")
                {
				
                        header("location:Novedades_Prod_Finales.php");
                        include("cerrar.php");
                }

					/*elseif ($row["Grupo"] == "11")
                {
				
                        header("location:Novedades_Pmn.php");
                        include("cerrar.php");
                }*/


}

include("cerrar.php");
       echo "<Script>
       alert('Lo Sentimos Pero este Usuario No Existe o Ingreso Erroneamente Su Clave');  
       JavaScript:window.history.back();
	   </Script>";


?>
