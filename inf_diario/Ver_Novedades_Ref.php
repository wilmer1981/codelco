<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

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
   echo "<Script>
     alert('No hay novedades ingresadas en esta Fecha');
     JavaScript:window.location ='Novedades_Ref.php';  
	</Script>"; 

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


function mod_info()
{
        var Fecha;
		FrmPrincipal.action='Modificar_Novedades_Ref.php';
        FrmPrincipal.submit();
}

function elim_info()
{
        FrmPrincipal.action='Eliminar_Novedades_Ref.php';
        FrmPrincipal.submit();
}

function ver_nov()
{

        FrmPrincipal.action='Ver_Novedades_Ref.php?Proceso=V';
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
        <td width="39%" height="20" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Novedades 
            Refineria </font></strong></div>
          <div align="center"></div>
          <div align="center"></div></td>
        <td width="11%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $Rut ?></font></div></td>
        <td width="50%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $Nombre ?></font></td>
      </tr>
      <tr> 
        <td> <div align="center"><font size="1"><strong>Fecha</strong> </font><font color="#333333" size="2">
            <select name="dia" size="1" style="font-face:verdana;font-size:10">
              <?
			if($Proceso=='V')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
            </select>
            <select name="mes" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
              <?
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
            </select>
            <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
              <?
	if($Proceso=='V')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
            </select>
            </font><font size="1"> </font></div>
          <div align="center"><font color="#000000" size="1"></font></div></td>
        <td colspan="2"><input name="Ver" type="submit" value="Ver Novedades" onClick="ver_nov()";" target="_blank"></td>
      </tr>
      <tr> 
        <td colspan="3"><div align="center"> 
            <p><font color="#000000" size="1"><strong>Ingrese Texto</strong></font></p>
            <p align="center"> <font color="#000000" size="1"> 
              <textarea name="Texto" cols="100" rows="15" value="<? echo $Texto ?>" ><? echo $Texto ?></textarea>
              </font></p>
            <p><font color="#000000" size="1"><strong>Para Ver las Novedades Ingrese 
              la Fecha</strong></font> </p>
          </div></td>
      </tr>
      <tr> 
        <td height="22" colspan="3"> <div align="center"> 
            <p><font size="1"> 
              <input name="Volver" type="submit"  value="Volver" onClick="Volver_Atras()";" target="_blank">
              <input name="Modificar" type="submit"  value="Modificar" onClick="mod_info()";" target="_blank">
              <input name="Eliminar" type="submit" value="Eliminar" onClick="elim_info()";" target="_blank">
              <input name="Salir" type="submit" value="Salir" onClick="Salir_F()";" target="_blank">
              </font></p>
          </div></td>
      </tr>
    </table>
    <p align="left">&nbsp;</p>
  </div>
</form>
</body>
</html>