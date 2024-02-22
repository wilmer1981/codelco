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
    }
}	
else	
{     
  echo "<Script>
     alert('No hay datos ingresados en esta Fecha');  
     JavaScript:window.location ='TermOxig.php';
	</Script>"; 

}


?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<Script language="JavaScript">
<!--


function mod_info()
{
var Campo9=FrmPrincipal.Campo9.value;
var Campo10=FrmPrincipal.Campo10.value;
var Campo11=FrmPrincipal.Campo11.value;
        
     FrmPrincipal.Campo9.value = Campo9.replace(",",".") 
     FrmPrincipal.Campo10.value = Campo10.replace(",",".") 
     FrmPrincipal.Campo11.value = Campo11.replace(",",".") 

        FrmPrincipal.action='Modificar_TermOxig.php';
        FrmPrincipal.submit();
}

function elim_info()
{

        FrmPrincipal.action='Eliminar_TermOxig.php';
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
        FrmPrincipal.action='Salir.php';
        FrmPrincipal.submit();

}

function Volver_TermOxig()
{
        FrmPrincipal.action="JavaScript:window.history.back();";
        FrmPrincipal.submit();

}


//-->
</script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body  background="imagenes/fondo.gif" onload="JavaScript:document.FrmPrincipal.Campo1.focus();">
<form name="FrmPrincipal" method="post" action="JavaScript:ing_user()">
  <div align="center"> 
    <table width="87%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td width="46%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">C. 
            T&eacute;rmica y Pta. Oxigeno</font></strong></div></td>
        <td width="15%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $Rut ?></font></div></td>
        <td width="39%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $Nombre ?></font></td>
      </tr>
      <tr> 
        <td height="25"><div align="center"><strong><font size="1">Fecha</font></strong> 
            <font size="1"> </font><font color="#333333" size="2"> 
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
        <td colspan="2" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Descripci&oacute;n</strong></font></div></td>
        <td width="29%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Valor</strong></font></div></td>
        <td width="20%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Calderas</strong></font></div>
          <div align="center"><font color="#FFFFFF" size="3"></font></div></td>
        <td width="12%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>Ton/d&iacute;a</strong></font></div></td>
        <td width="8%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="3"><strong>F/S</strong></font></div></td>
      </tr>
      <tr> 
        <td width="18%"><font color="#000000" size="1"><strong>Producci&oacute;n 
          </strong></font></td>
        <td width="13%"><font color="#000000" size="1"><strong>LOX</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo1" type="text" value="<? echo $Campo1 ?>" size="11">
          Ton/d&iacute;a</font></td>
        <td><div align="center"><font color="#000000" size="1"><strong>K-3</strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo9" type="text" value="<? echo $Campo9 ?>" size="10">
          </div></td>
        <td><div align="center"> 
            <input name="Campo12" type="text" id="Campo12" value="<? echo $Campo12 ?>" size="1" maxlength="2">
            <font color="#FFFFFF" size="2"></font></div></td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Producci&oacute;n </strong></font></td>
        <td><font color="#000000" size="1"><strong>GOX</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo2" type="text" value="<? echo $Campo2 ?>" size="11">
          Ton/d&iacute;a</font> </td>
        <td><div align="center"><font color="#000000" size="1"><strong>K-4</strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo10" type="text" value="<? echo $Campo10 ?>" size="10">
          </div></td>
        <td><div align="center"> 
            <input name="Campo13" type="text" id="Campo13" value="<? echo $Campo13 ?>" size="1">
            <font color="#FFFFFF" size="2"></font></div></td>
      </tr>
      <tr> 
        <td height="23"><font color="#000000" size="1"><strong>Consumo Real </strong></font></td>
        <td><font color="#000000" size="1"><strong>(FQI 165-B)</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo3" type="text" value="<? echo $Campo3 ?>" size="11">
          Ton/d&iacute;a</font> </td>
        <td><div align="center"><font color="#000000" size="1"><strong>K-5</strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo11" type="text" value="<? echo $Campo11 ?>" size="10">
          </div></td>
        <td><div align="center"> 
            <input name="Campo14" type="text" id="Campo14" value="<? echo $Campo14 ?>" size="1">
          </div></td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Nivel</strong></font></td>
        <td><font color="#000000" size="1"><strong>BO1</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo4" type="text" value="<? echo $Campo4 ?>" size="11">
          Lts.</font><font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Consignas Planta</strong></font></td>
        <td><font color="#000000" size="1"><strong>GOX</strong></font></td>
        <td> <font color="#000000" size="1"> 
          <input name="Campo5" type="text" value="<? echo $Campo5 ?>" size="11">
          KNm3/hr</font> <font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1"><strong>Consignas Planta</strong></font></td>
        <td><font color="#000000" size="1"><strong>LOX</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo6" type="text" value="<? echo $Campo6 ?>" size="11">
          KNm3/hr</font> <font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td height="23"><font color="#000000" size="1"><strong> Flujo Turbina</strong></font></td>
        <td><font color="#000000" size="1"><strong> (FIC 540)</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo7" type="text" value="<? echo $Campo7 ?>" size="11">
          KNm3/hr</font> <font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td height="21"><font color="#000000" size="1"><strong>PDI</strong></font></td>
        <td><font color="#000000" size="1"><strong> (540/542)</strong></font></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo8" type="text" value="<? echo $Campo8 ?>" size="11">
          KPa-g</font><font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font><font color="#000000" size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><font color="#000000" size="1">&nbsp;</font></td>
        <td colspan="2"><div align="center"><font color="#000000" size="1"><strong>Factor 
            de Potencia(COSPI) Acum.</strong></font></div></td>
        <td><font color="#000000" size="1"> 
          <input name="Campo15" type="text" value="<? echo $Campo15 ?>"  size="11">
          </font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td height="25" colspan="6"><div align="center"> 
            <p> 
              <input name="Volver" type="submit" id="Volver" value="Volver" onClick="Volver_TermOxig()";" target="_blank">
              <input name="Modificar" type="submit"  value="Modificar" onClick="mod_info()";" target="_blank">
              <input name="Eliminar" type="submit" value="Eliminar" onClick="elim_info()";">
              <input name="Salir" type="submit" value="Salir" onClick="Salir_F()";" target="_blank">
            </p>
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>