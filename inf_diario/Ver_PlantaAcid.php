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
    }
}	
else	
{     
  echo "<Script>
     alert('No hay datos ingresados en esta Fecha');  
     JavaScript:window.location ='PlantaAcid.php';
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
        FrmPrincipal.action='Modificar_PlantaAcid.php';
        FrmPrincipal.submit();
}

function elim_info()
{

        FrmPrincipal.action='Eliminar_PlantaAcid.php';
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
        FrmPrincipal.action='Salir.php';
        FrmPrincipal.submit();

}

function Volver_PlantaAcid()
{
        FrmPrincipal.action="JavaScript:window.history.back();";
        FrmPrincipal.submit();

}

//-->

</script>

<body  background="imagenes/fondo.gif" onload="JavaScript:document.FrmPrincipal.Campo1.focus();">
<form name="FrmPrincipal" method="post" action="JavaScript:ing_user()">
  <div align="center"> 
    <table width="87%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td width="41%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Planta 
            de &Aacute;cido </font></strong></div></td>
        <td width="11%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $Rut ?></font></div></td>
        <td width="48%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $Nombre ?></font></td>
      </tr>
      <tr> 
        <td><div align="center"><strong><font size="1"> Fecha</font></strong> 
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
        <td><font size="1"> 
          <input name="Campo1" type="text" value="<? echo $Campo1 ?>" size="11">
          <font color="#000000">hr/d&iacute;a</font></font> </td>
        <td><font color="#000000" size="1"><strong>Minima</strong></font></td>
        <td><font size="1"> 
          <input name="Campo6" type="text" value="<? echo $Campo6 ?>" size="10">
          <font color="#000000"><strong>&ordm;C</strong></font></font></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Producci&oacute;n</strong></font></td>
        <td><font size="1"> 
          <input name="Campo2" type="text" value="<? echo $Campo2 ?>" size="11">
          <font color="#000000">Ton.</font></font> <font size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1"><strong>M&aacute;xima</strong></font></td>
        <td><font size="1"> 
          <input name="Campo7" type="text" value="<? echo $Campo7 ?>" size="10">
          <font color="#000000"><strong>&ordm;C</strong></font></font></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Flujo Gases Prom.</strong></font></td>
        <td><font size="1"> 
          <input name="Campo3" type="text" value="<? echo $Campo3 ?>" size="11">
          <font color="#000000">M3/hrs</font></font> <font size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1"><strong>K3 (59,4)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo8" type="text" value="<? echo $Campo8 ?>" size="10">
          </font></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Conc. SO2 Prom.</strong></font></td>
        <td><font size="1"> 
          <input name="Campo4" type="text" value="<? echo $Campo4 ?>" size="11">
          <font color="#000000">%</font></font><font size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1"><strong>K5 (83,8)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo9" type="text" value="<? echo $Campo9 ?>" size="10">
          </font></td>
      </tr>
      <tr>
        <td><font color="#000000" size="1"><strong>Conc &Aacute;cido Prom (Ayer)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo5" type="text" value="<? echo $Campo5 ?>" size="11">
          <font color="#000000">%</font></font><font size="1">&nbsp;</font></td>
        <td><font color="#000000" size="1"><strong>K6 (89,7)</strong></font></td>
        <td><font size="1"> 
          <input name="Campo10" type="text" value="<? echo $Campo10 ?>" size="10">
          </font></td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><font color="#000000" size="1"><strong>Purgas de &Aacute;cido</strong></font></td>
        <td><font size="1"> 
          <input name="Campo11" type="text" value="<? echo $Campo11 ?>" size="10">
          </font></td>
      </tr>
      <tr> 
        <td height="25" colspan="4" ><div align="center"> 
            <input name="Volver" type="submit" value="Volver" onClick="Volver_PlantaAcid()";" target="_blank">
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