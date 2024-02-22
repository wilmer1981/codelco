<?
include("conectar47.php");
$Fecha ="$dia/$mes/$ano";
       if (empty($CookieUsuario))
        {
                Header("Location:Mensaje_Error.htm");
                exit;
        }
        else
        {
                $dia=date("d");
                  $mes=date("m");
                  $ano=date("Y");
                  $fecha_actual="$dia/$mes/$ano";
                if ($CookieFechaIngreso!=$fecha_actual)
                {
                        Header("Location:Mensaje_Error.htm");
                        exit;
                }
                elseif ($CookieTipoUsuario!='6')
                {
                        Header("Location:Mensaje_Error.htm");
                        exit;
                }

        }
        $consulta="select * from funcionarios where rut='$CookieUsuario'";
        $result=mysql_query($consulta);
        while ($row=mysql_fetch_array($result))
        {
                $nombres=$row[nombres];
				$apellido_paterno=$row["apellido_paterno"];
				$apellido_materno=$row["apellido_materno"];
				$nombre = "$apellido_paterno $apellido_materno $nombres";
				$rut=$row[rut]; 
        }
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

        FrmPrincipal.action='Ingreso_Novedades_Seg.php';
        FrmPrincipal.submit();
}


function ver_nov()
{

        FrmPrincipal.action='Ver_Novedades_Seg.php?Proceso=V';
        FrmPrincipal.submit();

}

function Salir_F()
{
        FrmPrincipal.action='Salir.php';
        FrmPrincipal.submit();

}


//-->

</script>



<body  background="imagenes/fondo.gif" onload="JavaScript:document.FrmPrincipal.Texto.focus();">
<form name="FrmPrincipal" method="post">
  <div align="center">
    <table width="87%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr bgcolor="#006699"> 
        <td height="20" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Observaciones 
            Mantenci&oacute;n </font></strong></div></td>
        <td width="11%" height="20" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $rut ?></font></td>
        <td width="50%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $nombre ?></font></td>
      </tr>
      <tr> 
        <td width="39%"> <div align="center"><font size="1"><strong>Fecha</strong> 
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
            <select  name="mes" size="1" id="select5" style="FONT-FACE:verdana;FONT-SIZE:10">
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
            <select name="ano" size="1"   style="FONT-FACE:verdana;FONT-SIZE:10">
              <?
	if($Proceso=='V')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
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
            </font></div>
          <div align="center"><font color="#000000" size="1"></font></div></td>
        <td colspan="2"><input name="Ver" type="submit" value="Ver Observaciones" onClick="ver_nov()";" target="_blank"></td>
      </tr>
      <tr> 
        <td height="177" colspan="3"><p align="center"><font color="#000000" size="1"><strong>Ingrese 
            Texto</strong></font></p>
          <p align="center"> <font color="#000000" size="1"> 
            <textarea name="Texto" cols="100" rows="15"></textarea>
            </font></p>
          <p align="center"><font color="#000000" size="1"><strong>Para Ver las 
            Novedades Ingrese la Fecha</strong></font> </p></td>
      </tr>
      <tr> 
        <td height="22" colspan="3"><div align="center"> 
            <p> 
              <input name="Guardar" type="submit"  value="Guardar" onClick="ing_user()";" target="_blank">
              <input name="Salir" type="submit" value="Salir" onClick="Salir_F()";" target="_blank">
            </p>
          </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </div>
</form>
</body>
</html>