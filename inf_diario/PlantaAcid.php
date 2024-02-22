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
                elseif ($CookieTipoUsuario!='3')
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
     var Campo2=FrmPrincipal.Campo2.value;

     FrmPrincipal.Campo2.value = Campo2.replace(",",".")
     
        FrmPrincipal.action='Ingreso_PlantaAcid.php';
        FrmPrincipal.submit();
}


function ver_datos()
{

        FrmPrincipal.action='Ver_PlantaAcid.php?Proceso=V';
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
<form name="FrmPrincipal" method="post" action="">
  <div align="center">
    <table width="87%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td width="41%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Planta 
            de &Aacute;cido </font></strong></div></td>
        <td width="11%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $CookieUsuario ?></font></div></td>
        <td width="48%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $CookieNombreUsuario ?></font></td>
      </tr>
      <tr> 
        <td><div align="center"><strong><font size="1">Fecha</font></strong> <font size="1"> 
            </font><font color="#333333" size="2">
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
            </font><font size="1"> </font></div></td>
        <td colspan="2"><input name="Ver" type="submit" value="Ver Datos" onClick="ver_datos()";" target="_blank"> 
          <input name="novedades" type="submit" id="novedades" value="Novedades" onClick="ver_nov()";"></td>
      </tr>
    </table>
  </div>
  <div align="center"> 
    <table width="87%" border="0" bgcolor="#F4D284">
      <tr> 
        <td width="24%" rowspan="2" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Descripci&oacute;n</strong></font></div></td>
        <td width="26%" rowspan="2" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Valor</strong></font></div></td>
        <td width="26%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Temperaturas 
            </strong></font></div></td>
        <td width="24%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Rangos</strong></font></div></td>
      </tr>
      <tr> 
        <td colspan="2" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Descanso 
            Axial </strong></font></div></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Tiempo de Operaci&oacute;n</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo1" type="text" value="00,0" size="11" onClick="FrmPrincipal.Campo1.value=''">
          hr/d&iacute;a</font> </td>
        <td><font color="#000000" size="1"><strong>Minima</strong></font></td>
        <td><input name="Campo6" type="text" value="000,0" size="10" onClick="FrmPrincipal.Campo6.value=''"> <font color="#000000" size="2"><strong>&ordm;C</strong></font></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Producci&oacute;n</strong></font></td>
        <td><font size="1"> 
          <input name="Campo2" type="text" value="0.000,00" size="11" onClick="FrmPrincipal.Campo2.value=''">
          <font color="#000000">Ton.</font></font> </td>
        <td><font color="#000000" size="1"><strong>M&aacute;xima</strong></font></td>
        <td><font size="1"> 
          <input name="Campo7" type="text" value="000,0" size="10" onClick="FrmPrincipal.Campo7.value=''">
          <font color="#000000"><strong>&ordm;C</strong></font></font></td>
      </tr>
      <tr>
        <td height="23"><font color="#000000" size="1"><strong>Flujo Gases Prom.</strong></font></td>
        <td><font size="1"> 
          <input name="Campo3" type="text" value="0.000,00" size="11" onClick="FrmPrincipal.Campo3.value=''">
          <font color="#000000">M3/hrs</font></font> </td>
        <td><font color="#000000" size="1"><strong>K3 (59,4)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo8" type="text" size="10" onClick="FrmPrincipal.Campo8.value=''">
          </font></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Conc. SO2 Prom.</strong></font></td>
        <td><font size="1"> 
          <input name="Campo4" type="text" value="00,00" size="11" onClick="FrmPrincipal.Campo4.value=''">
          <font color="#000000">%</font></font></td>
        <td><font color="#000000" size="1"><strong>K5 (83,8)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo9" type="text" size="10" onClick="FrmPrincipal.Campo9.value=''">
          </font></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Conc &Aacute;cido Prom (Ayer)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo5" type="text" value="00,00" size="11" onClick="FrmPrincipal.Campo5.value=''">
          <font color="#000000">%</font></font></td>
        <td><font color="#000000" size="1"><strong>K6 (89,7)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo10" type="text" size="10" onClick="FrmPrincipal.Campo10.value=''">
          </font></td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><font color="#000000" size="1"><strong>Purgas de Acido</strong></font></td>
        <td><font size="1"> 
          <input name="Campo11" type="text" size="10" onClick="FrmPrincipal.Campo11.value=''">
          </font></td>
      </tr>
      <tr> 
        <td height="24" colspan="4"><div align="center"> 
            <input name="Guardar" type="button"  value="Guardar" onClick="ing_user()" target="_blank">
            <input name="Salir" type="button" value="Salir" onClick="Salir_F()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
