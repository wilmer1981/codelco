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

                elseif ($CookieTipoUsuario!='1')
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
<title>Fundición</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-size: 3px;
	font-weight: bold;
}
-->
</style>
</head>

<Script language="JavaScript">
<!--



function ing_user()
{
var Campo4=FrmPrincipal.Campo4.value;
        
     FrmPrincipal.Campo4.value = Campo4.replace(",",".") 
  
 		
        FrmPrincipal.action='Ingreso_Fundicion.php';
        FrmPrincipal.submit();
}



function ver_datos()
{


        FrmPrincipal.action='Ver_Fundicion.php?Proceso=V';
        FrmPrincipal.submit();

}

function ver_nov()
{

        FrmPrincipal.action='Ver_Novedades.php';
        FrmPrincipal.submit();

}

//-->

</script>


<body background="imagenes/fondo4.gif" onload="JavaScript:document.FrmPrincipal.Campo1.focus();">
<form name="FrmPrincipal" method="post" action="JavaScript:ing_user()">
  <div align="center"> 
    <table width="87%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaDetalle">
      <tr bgcolor="#6666CC" class="ColorTabla01"> 
        <td height="26"><div align="center"><strong><font color="#FFFFFF" size="4">Fundici&oacute;n</font></strong></div></td>
        <td width="13%" height="26"><div align="left"><font color="#FFFFFF"><? echo $CookieUsuario ?></font></div></td>
        <td width="48%"><font color="#FFFFFF"><? echo $CookieNombreUsuario ?></font></td>
      </tr>
      <tr> 
        <td width="39%" height="25"><div align="center"><strong><font size="1">Fecha</font></strong><font size="1"> 
            </font><font color="#333333" size="2">
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
            </font><font size="1"> </font></div>
          <div align="center"><font color="#000000" size="1"><strong> </strong></font></div>
        <div align="center"></div></td>
        <td colspan="2"><input name="Ver" type="submit" value="Ver Datos" onClick="ver_datos()";" target="_blank">          
        <input name="novedades" type="submit" id="novedades" value="Novedades" onClick="ver_nov()";"></td>
      </tr>
    </table>
    <table width="87%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaDetalle">
      <tr bgcolor="#6666CC" class="ColorTabla01"> 
        <td colspan="5" ><div align="center"><strong><font color="#FFFFFF" size="3">Covertidor 
        Teniente</font></strong></div></td>
      </tr>
      <tr> 
        <td width="21%"> <div align="left"><font color="#000000" size="1"><strong> 
        Carga Total</strong></font></div></td>
        <td width="18%"> <div align="left"> <font color="#000000" size="1"> 
            <input name="Campo1" type="text" id="Campo110" value="0" size="8" onClick="FrmPrincipal.Campo1.value=''">
        Tms</font> </div></td>
        <td width="8%"><font color="#000000" size="1"> <strong> 
          <input name="Campo6" type="text" id="Campo62" size="1" maxlength="2">
        </strong>F/S </font></td>
        <td><font color="#000000" size="1"><strong>Tpo. Soplado c/Iny</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo5" type="text" id="Campo52" value="0,00" size="8" onClick="FrmPrincipal.Campo5.value=''">
          Hrs.</font></td>
      </tr>
      <tr> 
        <td> <div align="left"><font color="#000000" size="1"><strong>Carga 
        N. U . Iny</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo2" type="text" id="Campo210" value="0" size="8" onClick="FrmPrincipal.Campo2.value=''">
        Tms</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td width="18%"><font color="#000000" size="1"><strong>Metal Blanco</strong></font></td>
        <td width="35%"><font color="#000000" size="1"> 
<input name="Campo7" type="text" id="Campo72" value="000,0" size="8" onClick="FrmPrincipal.Campo7.value=''">          
Ollas</font> </td>
      </tr>
      <tr> 
        <td> <div align="left"><font color="#000000" size="1"><strong>Circulante</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo3" type="text" id="Campo3" value="0" size="8" onClick="FrmPrincipal.Campo3.value=''">
        Tms</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td><div align="left"><font color="#000000" size="1"><strong>Ley CU Metal 
            Blanco </strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo8" type="text" id="Campo82" value="00,0" size="8" onClick="FrmPrincipal.Campo8.value=''">
          %</font> </td>
      </tr>
      <tr> 
        <td> <div align="left"><font color="#000000" size="1"><strong>Tpo. 
        Soplado</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo4" type="text" id="Campo42" value="0,00" size="8" onClick="FrmPrincipal.Campo4.value=''">
        Hrs.</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1"><strong>Escoria CT  </strong></font></td>
        <td><font color="#000000" size="1">
<input name="Campo35" type="text" id="Campo35" value="000,0" size="8" onClick="FrmPrincipal.Campo35.value=''">
Ollas        </font></td>
      </tr>
    </table>
    <table width="87%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaDetalle">
      <tr bgcolor="#6666CC" class="ColorTabla01"> 
        <td colspan="5"><div align="center"><strong><font color="#FFFFFF" size="3">Planta 
        Secado </font></strong></div></td>
      </tr>
      <tr> 
        <td width="21%"> <div align="left"><font color="#000000" size="1"><strong>Alimentac. 
        Secado</strong></font></div></td>
        <td width="18%"><font color="#000000" size="1"> 
          <input name="Campo9" type="text" id="Campo93" value="0" size="8" onClick="FrmPrincipal.Campo9.value=''">
        Tmh</font></td>
        <td width="11%"><font color="#000000" size="1"> 
          <input name="Campo10" type="text" id="Campo103" size="1" maxlength="2">
        F/S </font></td>
        <td width="28%"> <div align="left"><font color="#000000" size="1"><strong>Tpo. 
        Operaci&oacute;n</strong></font></div></td>
        <td width="22%"><font color="#000000" size="1"> 
          <input name="Campo11" type="text" id="Campo113" value="0,00" size="8" onClick="FrmPrincipal.Campo11.value=''">
        Hrs.</font> </td>
      </tr>
    </table>
    <table width="87%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaDetalle">
      <tr bgcolor="#6666CC" class="ColorTabla01"> 
        <td colspan="6" ><div align="center" class="Estilo1"><font color="#FFFFFF">Convertidores 
        Tradicionales </font></div></td>
      </tr>
      <tr> 
        <td width="21%"><div align="left"><font color="#000000" size="1"><strong> 
            C. Fr&iacute;a [S/Precip]</strong></font></div></td>
        <td width="18%"><font color="#000000" size="1"> 
          <input name="Campo12" type="text" id="Campo122" value="0,0" size="8" onClick="FrmPrincipal.Campo12.value=''">
          Tms</font> </td>
        <td width="11%"><font color="#000000" size="1"> 
          <input name="Campo16" type="text" id="Campo162" size="1" maxlength="2">
          F/S </font></td>
        <td width="18%"><font color="#000000" size="1"><strong>Num. Cargas C_2</strong></font></td>
        <td width="20%"><font color="#000000" size="1"> 
          <input name="Campo18" type="text" id="Campo182" value="0" size="5" onClick="FrmPrincipal.Campo18.value=''">
          D</font> <font color="#000000" size="1"> 
          <input name="Campo19" type="text" id="Campo192" value="0" size="3" onClick="FrmPrincipal.Campo19.value=''">
          AC </font></td>
        <td width="12%"><font color="#FFFFFF" size="1"> 
          <input name="Campo23" type="text" id="Campo232" size="1" maxlength="2">
          <font color="#000000">F/S</font> </font></td>
      </tr>
      <tr> 
        <td><div align="left"><font color="#000000" size="1"><strong>Precipitado</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo13" type="text" id="Campo132" value="0,0" size="8" onClick="FrmPrincipal.Campo13.value=''">
          Tms</font> </td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td><div align="left"><font color="#000000" size="1"><strong>Num. Cargas 
            C_3</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo20" type="text" id="Campo202" value="0" size="5" onClick="FrmPrincipal.Campo20.value=''">
          D 
          <input name="Campo21" type="text" id="Campo212" value="0" size="3" onClick="FrmPrincipal.Campo21.value=''">
          AC </font></td>
        <td><font color="#FFFFFF" size="1"> 
          <input name="Campo24" type="text" id="Campo242" size="1" maxlength="2">
          <font color="#000000">F/S</font> </font></td>
      </tr>
      <tr> 
        <td><div align="left"><font color="#000000" size="1"><strong>Num. Cargas 
            C_1</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo14" type="text" id="Campo142" value="0" size="5" onClick="FrmPrincipal.Campo14.value=''">
          D</font> <font color="#000000" size="1"> 
          <input name="Campo15" type="text" id="Campo152" value="0" size="3" onClick="FrmPrincipal.Campo15.value=''">
          AC </font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo17" type="text" id="Campo172" size="1" maxlength="2">
          F/S </font></td>
        <td><font color="#000000" size="1"><strong>Blister Tot Tras</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo22" type="text" id="Campo222" value="0,0" size="8" onClick="FrmPrincipal.Campo22.value=''">
          T/d</font> </td>
        <td><font size="1">&nbsp;</font></td>
      </tr>
    </table>
    <table width="87%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaDetalle">
      <tr bgcolor="#6666CC" class="ColorTabla01"> 
        <td colspan="6"><div align="center"><strong><font color="#FFFFFF" size="3">Horno 
        El&eacute;ctrico</font></strong></div></td>
      </tr>
      <tr> 
        <td width="17%"><font color="#000000" size="1"><strong>Escoria 
          CT Trastada</strong></font></td>
        <td width="14%"><font color="#000000" size="1"> 
          <input name="Campo25" type="text" id="Campo253" value="0,00" size="8" onClick="FrmPrincipal.Campo25.value=''">
        Ollas</font> </td>
        <td width="18%"><strong><font color="#000000" size="1">Circulante</font></strong></td>
        <td width="18%"><font color="#000000" size="1"> 
          <input name="Campo26" type="text" id="Campo26" value="0,00" size="8" onClick="FrmPrincipal.Campo26.value=''">
        T/d</font></td>
        <td width="18%"><font color="#000000" size="1"><strong>Metal Blanco</strong></font></td>
        <td width="15%"><font color="#000000" size="1"> 
          <input name="Campo27" type="text" id="Campo27" value="0,00" size="8" onClick="FrmPrincipal.Campo27.value=''">
          Ollas</font></td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Ley CU Metal Blanco </strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo28" type="text" id="Campo282" value="0,00" size="8" onClick="FrmPrincipal.Campo28.value=''">
          %</font> </td>
        <td><font color="#000000" size="1"><strong>Ley CU Escoria</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo29" type="text" id="Campo292" value="0,00" size="8" onClick="FrmPrincipal.Campo29.value=''">
          %</font> </td>
        <td><font color="#000000" size="1"><strong>Ley Fe3o4 Escoria</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo30" type="text" id="Campo302" value="0,00" size="8" onClick="FrmPrincipal.Campo30.value=''">
          %</font> </td>
      </tr>
      <tr bgcolor="#6666CC" class="ColorTabla01"> 
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Ollas MB 
          a Pozo</strong></font></td>
        <td colspan="2"><font color="#000000" size="1"> 
          <input name="Campo31" type="text" id="Campo31" value="00,0" size="8" onClick="FrmPrincipal.Campo31.value=''">
        </font></td>
        <td><font color="#000000" size="1"><strong>Ollas Escoria Oxido a Pozo 
          </strong></font><font color="#FFFFFF" size="1">&nbsp;</font></td>
        <td colspan="2"><font color="#FFFFFF" size="1"> 
          <input name="Campo33" type="text" id="Campo33" value="00,0" size="8" onClick="FrmPrincipal.Campo33.value=''">
          </font><font color="#000000" size="1">&nbsp; </font></td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Ollas Oxido 
          a CT</strong></font></td>
        <td colspan="2"><font color="#000000" size="1"> 
          <input name="Campo32" type="text" id="Campo32" value="00,0" size="8" onClick="FrmPrincipal.Campo32.value=''">
        </font></td>
        <td><font color="#000000" size="1"><strong>Ollas Fun. + Raf a Pozo</strong></font></td>
        <td colspan="2"><font color="#000000" size="1"> 
         <input name="Campo34" type="text" id="Campo34" value="00,0" size="8" onClick="FrmPrincipal.Campo34.value=''">
        </font></td>
      </tr>
      <tr align="center"> 
        <td height="40" colspan="6"><div align="center"> 
          <input name="Guardar" type="submit"  value="Guardar" onClick="ing_user()";" target="_blank" style="width:70px">            
          <input name="Salir" type="button" value="Salir" onClick=" window.location='http://10.56.11.4/index.php?Pagina=index_inf_diario.php'" style="width:70px">
          </div>
        <div align="center"></div></td>
      </tr>
    </table>
    
  </div>
</form>
</body>
</html>
