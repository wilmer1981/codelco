<?
include("conectar.php");

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
                elseif ($CookieTipoUsuario!='4')
                {
                        Header("Location:Mensaje_Error.htm");
                        exit;
                }

        }
        $consulta="select * from usuarios where rut='$CookieUsuario'";
        $result=mysql_query($consulta);
        while ($row=mysql_fetch_array($result))
        {
                $nombre=$row[NOMBRE_APELLIDO];
				$rut=$row[RUT]; 
        }
                include("cerrar.php");

?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<Script language="JavaScript">
<!--

function ing_user()
{
var Campo9=FrmPrincipal.Campo9.value;
var Campo10=FrmPrincipal.Campo10.value;
var Campo11=FrmPrincipal.Campo11.value;
        
     FrmPrincipal.Campo9.value = Campo9.replace(",",".") 
     FrmPrincipal.Campo10.value = Campo10.replace(",",".") 
     FrmPrincipal.Campo11.value = Campo11.replace(",",".") 

        FrmPrincipal.action='Ingreso_TermOxig.php';
        FrmPrincipal.submit();
}


function ver_datos()
{

        FrmPrincipal.action='Ver_TermOxig.php?Proceso=V';
        FrmPrincipal.submit();

}

function ver_nov()
{

        FrmPrincipal.action='Ver_Novedades.php';
        FrmPrincipal.submit();

}

function Salir_F()
{
window.history.back();
}


//-->
</script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body  background="imagenes/fondo.gif" onLoad="JavaScript:document.FrmPrincipal.Campo1.focus();">
<form name="FrmPrincipal" method="post">
  <div align="center"> 
    <table width="87%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td width="46%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">C. 
            T&eacute;rmica y Pta. Oxigeno</font></strong></div></td>
        <td width="15%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $CookieUsuario ?></font></div></td>
        <td width="39%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $CookieNombreUsuario ?></font></td>
      </tr>
      <tr> 
        <td height="25"><div align="center"><strong><font size="1">Fecha</font></strong> 
            <font size="1"> </font><font color="#333333" size="2">
            <select name="dia" size="1" style="font-face:verdana;font-size:10">
              <?
			if($mostrar2=='S')
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
		if ($mostrar2=='S')
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
	if($mostrar2=='S')
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
            </font><font size="1"> </font></div></td>
        <td colspan="2"><input name="Ver" type="submit" value="Ver Datos" onClick="ver_datos()";" target="_blank"> 
          <input name="novedades" type="submit" id="novedades" value="Novedades" onClick="ver_nov()";"></td>
      </tr>
    </table>
  </div>
  <div align="center"> 
    <table width="87%" border="0" bgcolor="#F4D284">
      <tr> 
        <td colspan="2" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Descripci&oacute;n</strong></font></div></td>
        <td width="29%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Valor</strong></font></div></td>
        <td width="20%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Calderas</strong></font></div>
          <div align="center"><font color="#FFFFFF" size="3"></font></div></td>
        <td width="11%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Ton/d&iacute;a</strong></font></div></td>
        <td width="9%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>F/S</strong></font></div></td>
      </tr>
      <tr> 
        <td width="18%"><font color="#000000" size="1"><strong>Producci&oacute;n 
          </strong></font></td>
        <td width="13%"><font color="#000000" size="1"><strong>LOX</strong></font></td>
        <td><font size="1"> 
          <input name="Campo1" type="text" value="000,00" size="11" onClick="FrmPrincipal.Campo1.value=''">
          <font color="#000000">Ton/d&iacute;a</font></font></td>
        <td><div align="center"><font color="#000000" size="1"><strong>K-3</strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo9" type="text" value="000,00" size="10" onClick="FrmPrincipal.Campo9.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo12" type="text" id="Campo12" size="1" maxlength="2" onClick="FrmPrincipal2.Campo1.value=''">
            <font color="#FFFFFF" size="2"></font></div></td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Producci&oacute;n </strong></font></td>
        <td><font color="#000000" size="1"><strong>GOX</strong></font></td>
        <td><font size="1"> 
          <input name="Campo2" type="text" value="000,00" size="11" onClick="FrmPrincipal.Campo2.value=''">
          <font color="#000000">Ton/d&iacute;a</font></font> </td>
        <td><div align="center"><font color="#000000" size="1"><strong>K-4</strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo10" type="text" value="000,00" size="10" onClick="FrmPrincipal.Campo10.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo13" type="text" id="Campo13" size="1" onClick="FrmPrincipal.Campo13.value=''">
            <font color="#FFFFFF" size="2"></font></div></td>
      </tr>
      <tr> 
        <td height="23"><font color="#000000" size="1"><strong>Consumo Real </strong></font></td>
        <td><font color="#000000" size="1"><strong>(FQI 165-B)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo3" type="text" value="000,00" size="11" onClick="FrmPrincipal.Campo3.value=''">
          <font color="#000000">Ton/d&iacute;a</font></font> </td>
        <td><div align="center"><font color="#000000" size="1"><strong>K-5</strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo11" type="text" value="000,00" size="10" onClick="FrmPrincipal.Campo11.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo14" type="text" id="Campo14" size="1" onClick="FrmPrincipal.Campo14.value=''">
          </div></td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Nivel</strong></font></td>
        <td><font color="#000000" size="1"><strong>BO1</strong></font></td>
        <td><font size="1"> 
          <input name="Campo4" type="text" value="00.000,00" size="11" onClick="FrmPrincipal.Campo4.value=''">
          <font color="#000000">Lts.</font></font><font size="1">&nbsp;</font></td>
        <td><font color="#FFFFFF" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Consignas Planta</strong></font></td>
        <td><font color="#000000" size="1"><strong>GOX</strong></font></td>
        <td> <font color="#FFFFFF" size="1"> 
          <input name="Campo5" type="text" value="00,00" size="11" onClick="FrmPrincipal.Campo5.value=''">
          <font color="#000000"> KNm3/hr</font></font> <font size="1">&nbsp;</font></td>
        <td><font color="#FFFFFF" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Consignas Planta</strong></font></td>
        <td><font color="#000000" size="1"><strong>LOX</strong></font></td>
        <td><font size="1"> 
          <input name="Campo6" type="text" value="00,00" size="11" onClick="FrmPrincipal.Campo6.value=''">
          <font color="#000000">KNm3/hr</font></font> <font size="1">&nbsp;</font></td>
        <td><font size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong> Flujo Turbina</strong></font></td>
        <td><font color="#000000" size="1"><strong> (FIC 540)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo7" type="text" value="00,00" size="11" onClick="FrmPrincipal.Campo7.value=''">
          <font color="#000000">KNm3/hr</font></font> <font size="1">&nbsp;</font></td>
        <td><font size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>PDI</strong></font></td>
        <td><font color="#000000" size="1"><strong> (540/542)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo8" type="text" value="00,00" size="11" onClick="FrmPrincipal.Campo8.value=''">
          <font color="#000000">KPa-g</font></font><font size="1">&nbsp;</font></td>
        <td><font size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td colspan="2"><div align="center"><font color="#000000" size="1"><strong>Factor 
            de Potencia(COSPI) Acum.</strong></font></div></td>
        <td><input name="Campo15" type="text" value="00,000"  size="11" onClick="FrmPrincipal.Campo15.value=''"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td height="25" colspan="6"><div align="center"> 
            <p> 
              <input name="Guardar" type="submit"  value="Guardar" onClick="ing_user()" >
              <input name="Salir" type="button" value="Salir" >
            </p>
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>