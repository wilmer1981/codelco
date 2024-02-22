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

                elseif ($CookieTipoUsuario!='2')
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

<html><title> Refino a Fuego</title>

<link href="style.css" rel="stylesheet" type="text/css">
<head>
<Script language="JavaScript">
<!--


function ing_user()
{
var Campo1=FrmPrincipal.Campo1.value;
var Campo2=FrmPrincipal.Campo2.value;
        
     FrmPrincipal.Campo1.value = Campo1.replace(",",".") 
     FrmPrincipal.Campo2.value = Campo2.replace(",",".") 
	 
	   FrmPrincipal.action='Ingreso_Refino.php';
       FrmPrincipal.submit();
}


function ver_datos()
{

        FrmPrincipal.action='Ver_Refino.php?Proceso=V';
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

</head>
<body  background="imagenes/fondo.gif" onLoad="JavaScript:document.FrmPrincipal.Campo1.focus();">
<form name="FrmPrincipal" method="post">
  <div align="center"> 
    <table width="89%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td width="41%" height="26" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Refino 
            a Fuego</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $CookieUsuario ?></font></div></td>
        <td width="47%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $CookieNombreUsuario ?></font></td>
      </tr>
      <tr> 
        <td height="26"><div align="center"><strong><font size="1">Fecha</font></strong> 
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
    <table width="89%" border="0" align="center" bgcolor="#F4D284">
      <tr> 
        <td width="25%" rowspan="3" bgcolor="#6666CC"><font color="#FFFFFF" size="3"><strong>Producci&oacute;n 
          de Vapor</strong></font></td>
        <td width="37%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="2"><strong>Caldera</strong></font></div></td>
        <td width="26%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="2">Valor</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF">F/S</font></strong></div>
          <div align="center"><strong></strong></div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">Caldera 
            Raf - 1 </font></strong></font></div></td>
        <td><div align="center"> <font size="1"> 
            <input name="Campo1" type="text" value="000,00" size="9" maxlength="11" onClick="FrmPrincipal.Campo1.value=''">
            <font color="#000000">T/Ds</font></font></div></td>
        <td><div align="center"><strong><font color="#FFFFFF" size="2"> 
            <input name="Campo3" type="text"  size="1" maxlength="2">
            </font></strong></div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">Caldera 
            Raf - 2</font></strong></font></div></td>
        <td><div align="center"> <font size="1"> 
            <input name="Campo2" type="text" value="000,00" size="9" maxlength="11" onClick="FrmPrincipal.Campo2.value=''">
            <font color="#000000">T/Ds </font></font></div></td>
        <td><div align="center"><strong><font color="#FFFFFF" size="2"> 
            <input name="Campo4" type="text" id="Campo42" size="1" maxlength="2">
            </font></strong></div></td>
      </tr>
    </table>
    <table width="89%" border="0" bgcolor="#F4D284">
      <tr> 
        <td width="7%" rowspan="5" bgcolor="#6666CC"><strong><font color="#FFFFFF" size="3">Prog. 
          Moldeo </font></strong></td>
        <td width="18%" height="14" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="2">Hornos</font></strong></div></td>
        <td width="14%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="2">Hornada/Sol</font></strong></div></td>
        <td width="11%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">Prog. 
            Hrs.</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">Real 
            Hrs.</font></strong></div></td>
        <td width="13%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">Retraso 
            Hrs.</font></strong></div></td>
        <td width="13%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">AS(PPM)</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">SB(PPM)</font></strong></div></td>
      </tr>
      <tr> 
        <td height="21"><div align="center"><font size="1"><strong><font color="#000000">Horno 
            N&ordm; 1</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo5" type="text" id="Campo52" value="0000-000" size="9" maxlength="10" onClick="FrmPrincipal.Campo5.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo9" type="text" id="Campo82" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo9.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo13" type="text" id="Campo112" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo13.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo17" type="text" id="Campo142" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo17.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo21" type="text" value="0"  size="9" onClick="FrmPrincipal.Campo21.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo25" type="text" id="Campo25" value="0" size="9" onClick="FrmPrincipal.Campo25.value=''">
          </div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">Horno 
            N&ordm; 2</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo6" type="text" id="Campo62" value="0000-000" size="9" maxlength="10" onClick="FrmPrincipal.Campo6.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo10" type="text" id="Campo92" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo10.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo14" type="text" id="Campo122" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo14.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo18" type="text" id="Campo152" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo18.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo22" type="text" id="Campo22" value="0" size="9" onClick="FrmPrincipal.Campo22.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo26" type="text" id="Campo26" value="0" size="9" onClick="FrmPrincipal.Campo26.value=''">
          </div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">H. 
            Basculante 1</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo7" type="text" id="Campo72" value="0000-000" size="9" maxlength="10" onClick="FrmPrincipal.Campo7.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo11" type="text" id="Campo102" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo11.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo15" type="text" id="Campo132" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo15.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo19" type="text" id="Campo162" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo19.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo23" type="text" id="Campo23" value="0" size="9" onClick="FrmPrincipal.Campo23.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo27" type="text" id="Campo27" value="0" size="9" onClick="FrmPrincipal.Campo27.value=''">
          </div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">H. 
            Basculante 2</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo8" type="text" id="Campo72" value="0000-000" size="9" maxlength="10" onClick="FrmPrincipal.Campo8.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo12" type="text" id="Campo102" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo12.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo16" type="text" id="Campo132" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo16.value=''">
          </div></td>
        <td><div align="center"> 
            <input name="Campo20" type="text" id="Campo162" value="00:00" size="8" maxlength="5" onClick="FrmPrincipal.Campo20.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo24" type="text" id="Campo24" value="0" size="9" onClick="FrmPrincipal.Campo24.value=''">
          </div></td>
        <td><div align="center">
            <input name="Campo28" type="text" id="Campo28" value="0" size="9" onClick="FrmPrincipal.Campo28.value=''">
          </div></td>
      </tr>
    </table>
    <table width="89%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="3"><div align="center"><font size="1"><strong>Ollas Escoria Horno Retenci&oacute;n</strong></font> 
            <input name="Campo29" type="text" id="Campo29" value="00,0" size="8" maxlength="10" onClick="FrmPrincipal.Campo29.value=''">
          </div></td>
        <td colspan="2"><div align="center"> <font color="#000000" size="1"><strong>Ollas 
            Escoria Horno Basculante</strong></font> 
            <input name="Campo30" type="text" id="Campo30" value="00,0" size="8" maxlength="10" onClick="FrmPrincipal.Campo30.value=''">
          </div></td>
      </tr>
	  <tr><td colspan="5">&nbsp;</td></tr>
      <tr>
        <td width="25%" rowspan="3" bgcolor="#6666CC"><strong><font color="#FFFFFF" size="3">Producto en proceso RAF </font></strong></td>
        <td width="12%"><font size="1"><strong><font color="#000000">H.Ret&eacute;n</font></strong></font></td>
        <td width="16%"><input name="Campo31" type="text" id="Campo31" value="00,0" size="8" maxlength="10" onClick="FrmPrincipal.Campo31.value=''">
        <font size="1"><strong><font color="#000000">Ollas</font></strong></font></td>
        <td width="10%" height="22"><font size="1"><strong><font color="#000000">H.Basculante</font></strong></font></td>
      <td width="37%"><input name="Campo32" type="text" id="Campo32" value="00,0" size="8" maxlength="10" onClick="FrmPrincipal.Campo32.value=''">
        <font size="1"><strong><font color="#000000">Ollas</font></strong></font></td>
      </tr>
      <tr>
        <td height="22"><font size="1"><strong><font color="#000000">Horno1</font></strong></font></td>
        <td><input name="Campo33" type="text" id="Campo33" value="0000,0" size="10" maxlength="10" onClick="FrmPrincipal.Campo33.value=''">
        <font size="1"><strong><font color="#000000">Ton.</font></strong></font></td>
        <td height="22"><font size="1"><strong><font color="#000000">Horno2</font></strong></font></td>
      <td height="22"><input name="Campo34" type="text" id="Campo34" value="0000,0" size="10" maxlength="10" onClick="FrmPrincipal.Campo34.value=''">
        <font size="1"><strong><font color="#000000">Ton.</font></strong></font></td>
      </tr>
      <tr>
        <td height="22"><font size="1"><strong><font color="#000000">Blister,Restos y Rechazos </font></strong></font></td>
        <td><input name="Campo35" type="text" id="Campo35" value="0000,0" size="10" maxlength="10" onClick="FrmPrincipal.Campo35.value=''">
        <font size="1"><strong><font color="#000000">Ton</font></strong></font><font size="1"><strong><font color="#000000">.</font></strong></font></td>
        <td height="22">&nbsp;</td>
      <td height="22">&nbsp;</td>
      </tr>
      <tr> 
        <td height="22" colspan="5"><div align="center"> 
            <input name="Guardar" type="button"  value="Guardar" onClick="ing_user()" >
            <input name="Salir" type="button" id="Salir" value="Salir" onClick="Salir_F()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
