<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$dia="$dia";
$mes="$mes";
$ano="$ano";

$sql = "SELECT * FROM fundicion WHERE Fecha = '$Fecha' and Cod_Tipo = '$CookieTipoUsuario'";
$result = mysql_query($sql, $link);


if ($row = mysql_fetch_array($result))
{

    $Rut = $row["Rut"];
	if($Rut == $CookieUsuario)
	{		
	$Nombre = $row["Nombre"];
    $Campo1 = $row["Campo1"];
    $Campo2 = $row["Campo2"];
    $Campo3 = $row["Campo3"];
    $Campo4 = $row["Campo4"];
    $Campo5 = $row["Campo5"];
    $Campo6 = $row["Campo6"];
    $Campo7 = $row["Campo7"];
    $Campo8 = $row["Campo8"];
    $Campo9 = $row["Campo9"];
    $Campo10 = $row["Campo10"];
    $Campo11 = $row["Campo11"];
    $Campo12 = $row["Campo12"];
    $Campo13 = $row["Campo13"];
    $Campo14 = $row["Campo14"];
    $Campo15 = $row["Campo15"];
    $Campo16 = $row["Campo16"];
    $Campo17 = $row["Campo17"];
    $Campo18 = $row["Campo18"];
    $Campo19 = $row["Campo19"];
    $Campo20 = $row["Campo20"];
    $Campo21 = $row["Campo21"];
    $Campo22 = $row["Campo22"];
    $Campo23 = $row["Campo23"];
    $Campo24 = $row["Campo24"];
    $Campo25 = $row["Campo25"];
    $Campo26 = $row["Campo26"];
    $Campo27 = $row["Campo27"];
    $Campo28 = $row["Campo28"];
    $Campo29 = $row["Campo29"];
    $Campo30 = $row["Campo30"];
    $Campo31 = $row["Campo31"];
    $Campo32 = $row["Campo32"];
    $Campo33 = $row["Campo33"];
    $Campo34 = $row["Campo34"];
	$Campo35 = $row["Campo35"];
	$Campo36 = $row["Campo36"];
  }    
   else
    {
     echo "<Script>
     alert('Otro Usuario ingreso datos para esta Fecha');  
     </Script>";
	 
	$Rut = $row["Rut"];
	$Nombre = $row["Nombre"];
    $Campo1 = $row["Campo1"];
    $Campo2 = $row["Campo2"];
    $Campo3 = $row["Campo3"];
    $Campo4 = $row["Campo4"];
    $Campo5 = $row["Campo5"];
    $Campo6 = $row["Campo6"];
    $Campo7 = $row["Campo7"];
    $Campo8 = $row["Campo8"];
    $Campo9 = $row["Campo9"];
    $Campo10 = $row["Campo10"];
    $Campo11 = $row["Campo11"];
    $Campo12 = $row["Campo12"];
    $Campo13 = $row["Campo13"];
    $Campo14 = $row["Campo14"];
    $Campo15 = $row["Campo15"];
    $Campo16 = $row["Campo16"];
    $Campo17 = $row["Campo17"];
    $Campo18 = $row["Campo18"];
    $Campo19 = $row["Campo19"];
    $Campo20 = $row["Campo20"];
    $Campo21 = $row["Campo21"];
    $Campo22 = $row["Campo22"];
    $Campo23 = $row["Campo23"];
    $Campo24 = $row["Campo24"];
    $Campo25 = $row["Campo25"];
    $Campo26 = $row["Campo26"];
    $Campo27 = $row["Campo27"];
    $Campo28 = $row["Campo28"];
    $Campo29 = $row["Campo29"];
    $Campo30 = $row["Campo30"];
    $Campo31 = $row["Campo31"];
    $Campo32 = $row["Campo32"];
    $Campo33 = $row["Campo33"];
    $Campo34 = $row["Campo34"];
	$Campo35 = $row["Campo35"];
	$Campo36 = $row["Campo36"];
    }
}	
else	
{     
 echo "<Script>
 	
     alert('No hay datos ingresados en esta Fecha');  
     JavaScript:window.location ='Fundicion.php';
	</Script>"; 

}


?>

<html>
<head>
<title>Fundición</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<Script language="JavaScript">
<!--


function mod_info()
{
		alert("entro aca");


        FrmPrincipal.action='Modificar_Fundicion.php';
        FrmPrincipal.submit();
}

function elim_info()
{
var Campo4=FrmPrincipal.Campo4.value;
        
     FrmPrincipal.Campo4.value = Campo4.replace(",",".") 

        FrmPrincipal.action='Eliminar_Fundicion.php';
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

function Salir_F()
{
        FrmPrincipal.action='Salir.php';
        FrmPrincipal.submit();

}

function Volver_Fundicion()
{

        FrmPrincipal.action="JavaScript:window.history.back();";
        FrmPrincipal.submit();

}
//-->

</script>


<body background="imagenes/fondo.gif" onload="JavaScript:document.FrmPrincipal.Campo1.focus();">
<form name="FrmPrincipal" method="post" action="JavaScript:ing_user()">
  <div align="center"> 
    <table width="87%" border="0" bgcolor="#F4D284">
      <tr> 
        <td height="26" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Fundici&oacute;n</font></strong></div></td>
        <td width="13%" height="26" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $Rut ?></font></div></td>
        <td width="48%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $Nombre ?></font></td>
      </tr>
      <tr> 
        <td width="39%" height="25" bgcolor="#F4D284"><div align="center"></div>
          <div align="center"></div>
          <div align="center"><font color="#000000" size="1"><strong>Fecha</strong></font><font size="1"> 
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
        <td colspan="2" bgcolor="#F4D284"><input name="Ver" type="submit" value="Ver Datos" onClick="ver_datos()";" target="_blank"> 
          <input name="novedades" type="submit" id="novedades" value="Novedades" onClick="ver_nov()";"></td>
      </tr>
    </table>
    <table width="87%" border="0" bgcolor="#F4D284">
      <tr> 
        <td colspan="5" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="3">Covertidor 
            Teniente</font></strong></div></td>
      </tr>
      <tr> 
        <td width="21%" bgcolor="#F4D284"> <div align="left"><font color="#000000" size="1"><strong> 
            Carga Total</strong></font></div></td>
        <td width="18%" bgcolor="#F4D284"> <div align="left"> <font color="#000000" size="1"> 
            <input name="Campo1" type="text" id="Campo110" value="<? echo $Campo1 ?>" size="8">
            Tms</font> </div></td>
        <td width="8%" bgcolor="#F4D284"><font color="#000000" size="1"> <strong> 
          <input name="Campo6" type="text" id="Campo62" value="<? echo $Campo6 ?>" size="1" maxlength="2">
          </strong>F/S </font></td>
        <td><font color="#000000" size="1"><strong>Tpo. Soplado c/Iny</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo5" type="text" id="Campo52" value="<? echo $Campo5 ?>" size="8">
          Hrs.</font></td>
      </tr>
      <tr> 
        <td bgcolor="#F4D284"> <div align="left"><font color="#000000" size="1"><strong>Carga 
            N. U . Iny</strong></font></div></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo2" type="text" id="Campo210" value="<? echo $Campo2 ?>" size="8">
          Tms</font></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1">&nbsp;</font></td>
        <td width="18%"><font color="#000000" size="1"><strong>Metal Blanco</strong></font></td>
        <td width="35%"><font color="#000000" size="1"> 
          <input name="Campo7" type="text" id="Campo72" value="<? echo $Campo7 ?>" size="8">
          Ollas</font> </td>
      </tr>
      <tr> 
        <td bgcolor="#F4D284"> <div align="left"><font color="#000000" size="1"><strong>Circulante</strong></font></div></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo3" type="text" id="Campo34" value="<? echo $Campo3 ?>" size="8">
          Tms</font></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1">&nbsp;</font></td>
        <td><div align="left"><font color="#000000" size="1"><strong>Ley CU Metal 
            Blanco </strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo8" type="text" id="Campo82" value="<? echo $Campo8 ?>" size="8">
          %</font> </td>
      </tr>
      <tr> 
        <td bgcolor="#F4D284"> <div align="left"><font color="#000000" size="1"><strong>Tpo. 
            Soplado</strong></font></div></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo4" type="text" id="Campo42" value="<? echo $Campo4 ?>" size="8">
          Hrs.</font></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1">&nbsp;</font></td>
        <td width="18%"><font color="#000000" size="1"><strong>Escoria CT </strong></font></td>
        <td width="35%"><font color="#000000" size="1">
<input name="Campo35" type="text" id="Campo35" value="<? echo $Campo35 ?>" size="8">
%        </font></td>
      </tr>
    </table>
    <table width="87%" border="0" bgcolor="#F4D284">
      <tr> 
        <td colspan="5" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="3">Planta 
            Secado </font></strong></div></td>
      </tr>
      <tr> 
        <td width="21%" bgcolor="#F4D284"> <div align="left"><font color="#000000" size="1"><strong>Alimentac. 
            Secado</strong></font></div></td>
        <td width="18%" bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo9" type="text" id="Campo93" value="<? echo $Campo9 ?>" size="8">
          Tmh</font></td>
        <td width="11%" bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo10" type="text" id="Campo103" value="<? echo $Campo10 ?>" size="1" maxlength="2">
          F/S </font></td>
        <td width="28%" bgcolor="#F4D284"> <div align="left"><font color="#000000" size="1"><strong>Tpo. 
            Operaci&oacute;n</strong></font></div></td>
        <td width="22%" bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo11" type="text" id="Campo113" value="<? echo $Campo11 ?>" size="8">
          Hrs.</font> </td>
      </tr>
    </table>
    <table width="87%" border="0" bgcolor="#F4D284">
      <tr> 
        <td colspan="6" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="3">Convertidores 
            Tradicionales </font></strong></div></td>
      </tr>
      <tr bgcolor="#F4D284"> 
        <td width="21%"><div align="left"><font color="#000000" size="1"><strong> 
            C. Fr&iacute;a [S/Precip]</strong></font></div></td>
        <td width="18%"><font color="#000000" size="1"> 
          <input name="Campo12" type="text" id="Campo122" value="<? echo $Campo12 ?>" size="8">
          Tms</font> </td>
        <td width="11%"><font color="#000000" size="1"> 
          <input name="Campo16" type="text" id="Campo162" value="<? echo $Campo16 ?>" size="1" maxlength="2">
          F/S </font></td>
        <td width="18%"><font color="#000000" size="1"><strong>Num. Cargas C_2</strong></font></td>
        <td width="20%"><font color="#000000" size="1"> 
          <input name="Campo18" type="text" id="Campo182" value="<? echo $Campo18 ?>" size="5">
          D</font> <font color="#000000" size="1"> 
          <input name="Campo19" type="text" id="Campo192" value="<? echo $Campo19 ?>" size="3">
          AC </font></td>
        <td width="12%"><font color="#FFFFFF" size="1"> 
          <input name="Campo23" type="text" id="Campo232" value="<? echo $Campo23 ?>" size="1" maxlength="2">
          <font color="#000000">F/S</font> </font></td>
      </tr>
      <tr bgcolor="#F4D284"> 
        <td><div align="left"><font color="#000000" size="1"><strong>Precipitado</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo13" type="text" id="Campo132" value="<? echo $Campo13 ?>" size="8">
          Tms</font> </td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td><div align="left"><font color="#000000" size="1"><strong>Num. Cargas 
            C_3</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo20" type="text" id="Campo202" value="<? echo $Campo20 ?>" size="5">
          D 
          <input name="Campo21" type="text" id="Campo212" value="<? echo $Campo21 ?>" size="3">
          AC </font></td>
        <td><font color="#FFFFFF" size="1"> 
          <input name="Campo24" type="text" id="Campo242" value="<? echo $Campo24 ?>" size="1" maxlength="2">
          <font color="#000000">F/S</font> </font></td>
      </tr>
      <tr bgcolor="#F4D284"> 
        <td><div align="left"><font color="#000000" size="1"><strong>Num. Cargas 
            C_1</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo14" type="text" id="Campo142" value="<? echo $Campo14 ?>" size="5">
          D</font> <font color="#000000" size="1"> 
          <input name="Campo15" type="text" id="Campo152" value="<? echo $Campo15 ?>" size="3">
          AC </font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo17" type="text" id="Campo172" value="<? echo $Campo17 ?>" size="1" maxlength="2">
          F/S </font></td>
        <td><font color="#000000" size="1"><strong>Blister Tot Tras</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo22" type="text" id="Campo222" value="<? echo $Campo22 ?>" size="8">
          T/d</font> </td>
        <td><font size="1">&nbsp;</font></td>
      </tr>
    </table>
    <table width="87%" border="0" cellspacing="1" cellpadding="1" bgcolor="#F4D284">
      <tr> 
        <td colspan="6" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="3">Horno 
            El&eacute;ctrico</font></strong></div></td>
      </tr>
      <tr> 
        <td width="17%" bgcolor="#F4D284"><font color="#000000" size="1"><strong>Escoria 
          CT Trastada</strong></font></td>
        <td width="15%" bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo25" type="text" id="Campo25" value="<? echo $Campo25 ?>" size="8">
          Ollas</font> </td>
        <td width="17%" bgcolor="#F4D284"><strong><font color="#000000" size="1">Circulante</font></strong></td>
        <td width="18%" bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo26" type="text" id="Campo263" value="<? echo $Campo26 ?>" size="8">
          T/d</font></td>
        <td width="18%"><font color="#000000" size="1"><strong>Metal Blanco</strong></font></td>
        <td width="15%"><font color="#000000" size="1"> 
          <input name="Campo27" type="text" id="Campo27" value="<? echo $Campo27 ?>" size="8">
          Ollas</font></td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Ley CU Metal Blanco </strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo28" type="text" id="Campo282" value="<? echo $Campo28 ?>" size="8">
          %</font> </td>
        <td><font color="#000000" size="1"><strong>Ley CU Escoria</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo29" type="text" id="Campo292" value="<? echo $Campo29 ?>" size="8">
          %</font> </td>
        <td><font color="#000000" size="1"><strong>Ley Fe3o4 Escoria</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo30" type="text" id="Campo302" value="<? echo $Campo30 ?>" size="8">
          %</font> </td>
      </tr>
	  <tr> 
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td ><font color="#000000" size="1"><strong>Escoria HETE </strong></font></td>
        <td ><font color="#000000" size="1">
          <input name="Campo36" type="text" id="Campo36" value="<? echo $Campo36 ?>" size="8">
        </font> <font color="#000000" size="1">Ollas</font></td>
	  </tr>
      <tr> 
        <td colspan="6" bgcolor="#6666CC">&nbsp;</td>
      </tr>
      <tr> 
        <td bgcolor="#F4D284"><font color="#000000" size="1"><strong>Ollas MB 
          a Pozo</strong></font></td>
        <td colspan="2" bgcolor="#F4D284"><font color="#000000" size="1"> 
          <input name="Campo31" type="text" id="Campo31" value="<? echo $Campo31 ?>" size="8">
          </font></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1"><strong>Ollas Escoria 
          Oxido a Pozo </strong></font><font color="#FFFFFF" size="1">&nbsp;</font></td>
        <td colspan="2"><font color="#000000" size="1">
          <input name="Campo33" type="text" id="Campo33" value="<? echo $Campo33 ?>" size="8">
          </font></td>
      </tr>
      <tr> 
        <td bgcolor="#F4D284"><font color="#000000" size="1"><strong>Ollas Oxido 
          a CT</strong></font></td>
        <td colspan="2" bgcolor="#F4D284"><font color="#000000" size="1">
          <input name="Campo32" type="text" id="Campo32" value="<? echo $Campo32 ?>" size="8">
          </font></td>
        <td bgcolor="#F4D284"><font color="#000000" size="1"><strong>Ollas Fun. 
          + Raf a Pozo</strong></font></td>
        <td colspan="2"><font color="#000000" size="1">
          <input name="Campo34" type="text" id="Campo34" value="<? echo $Campo34 ?>" size="8">
          </font></td>
      </tr>
      <tr> 
        <td height="25" colspan="6" > <div align="center"> 
            <input name="Volver" type="submit" id="Volver" value="Volver" onClick="Volver_Fundicion()";" target="_blank">
            <input name="Modificar" type="submit"  value="Modificar" onClick="mod_info()";" target="_blank">
            <input name="Eliminar" type="submit" value="Eliminar" onClick="elim_info()";">
            <input name="Salir" type="submit" value="Salir" onClick="Salir_F()";" target="_blank">
          </div>
          <div align="center"></div></td>
      </tr>
    </table>
    
  </div>
  </form>
</body>
</html>
