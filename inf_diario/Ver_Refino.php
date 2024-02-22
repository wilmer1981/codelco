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
   }
}	
else	
{     
   echo "<Script>
     alert('No hay datos ingresados en esta Fecha');
     JavaScript:window.location ='Refino.php';  
	</Script>"; 

}

?>
<html><title> Refino a Fuego</title>

<link href="style1.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css">
<head>
<Script language="JavaScript">
<!--
function mod_info()
{

var Campo1=FrmPrincipal.Campo1.value;
var Campo2=FrmPrincipal.Campo2.value;
        
     FrmPrincipal.Campo1.value = Campo1.replace(",",".") 
     FrmPrincipal.Campo2.value = Campo2.replace(",",".") 
     
	 FrmPrincipal.action='Modificar_Refino.php';
     FrmPrincipal.submit();
}

function elim_info()
{


        FrmPrincipal.action='Eliminar_Refino.php';
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
        FrmPrincipal.action='Salir.php';
        FrmPrincipal.submit();

}

function Volver_Refino()
{
        FrmPrincipal.action="JavaScript:window.history.back();";
        FrmPrincipal.submit();

}

//-->

</script>

</head>
<body  background="imagenes/fondo.gif" onload="JavaScript:document.FrmPrincipal.Campo1.focus();">
<form name="FrmPrincipal" method="post" action="JavaScript:ing_user()">
  <div align="center"> 
    <table width="89%" border="0" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td width="41%" height="24" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="4">Refino 
            a Fuego</font></strong></div></td>
        <td width="11%" bgcolor="#6666CC"><div align="left"><font color="#FFFFFF"><? echo $Rut ?></font></div></td>
        <td width="48%" bgcolor="#6666CC"><font color="#FFFFFF"><? echo $Nombre ?></font></td>
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
    <table width="89%" border="0" align="center" bgcolor="#F4D284">
      <tr> 
        <td width="25%" rowspan="3" bgcolor="#6666CC"><font color="#FFFFFF" size="3"><strong>Producci&oacute;n 
          de Vapor</strong></font></td>
        <td width="38%" bgcolor="#6666CC"><div align="center"><font color="#FFFFFF" size="2"><strong>Caldera</strong></font></div></td>
        <td width="25%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="2">Valor</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF">F/S</font></strong></div>
          <div align="center"><strong></strong></div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">Caldera 
            Raf - 1 </font></strong></font></div></td>
        <td><div align="center"> <font size="1"> 
            <input name="Campo1" type="text" value="<? echo $Campo1 ?>" size="9" maxlength="11">
            <font color="#000000">T/Ds</font></font></div></td>
        <td><div align="center"><strong><font color="#FFFFFF" size="2"> 
            <input name="Campo3" type="text" value="<? echo $Campo3 ?>" size="1" maxlength="2">
            </font></strong></div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">Caldera 
            Raf - 2</font></strong></font></div></td>
        <td><div align="center"> <font size="1"> 
            <input name="Campo2" type="text" value="<? echo $Campo2 ?>" size="9" maxlength="11">
            <font color="#000000">T/Ds </font></font></div></td>
        <td><div align="center"><strong><font color="#FFFFFF" size="2"> 
            <input name="Campo4" type="text" value="<? echo $Campo4 ?>" size="1" maxlength="2">
            </font></strong></div></td>
      </tr>
    </table>
  </div>
  <div align="center"> 
    <table width="89%" border="0" bgcolor="#F4D284">
      <tr> 
        <td width="7%" rowspan="5" bgcolor="#6666CC"><strong><font color="#FFFFFF" size="3">Prog. 
          Moldeo </font></strong></td>
        <td width="18%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="2">Hornos</font></strong></div></td>
        <td width="13%" bgcolor="#6666CC"><div align="center"><strong><font color="#FFFFFF" size="2">Hornada/Sol</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">Prog. 
            Hrs.</font></strong></div></td>
        <td width="13%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">Real 
            Hrs.</font></strong></div></td>
        <td width="13%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">Retraso 
            Hrs.</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">AS(PPM)</font></strong></div></td>
        <td width="12%" bgcolor="#6666CC" ><div align="center"><strong><font color="#FFFFFF" size="2">SB(PPM)</font></strong></div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">Horno 
            N&ordm; 1</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo5" type="text" value="<? echo $Campo5 ?>" size="9" maxlength="10">
          </div></td>
        <td><div align="center"> 
            <input name="Campo9" type="text" id="Campo9" value="<? echo $Campo9 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo13" type="text" id="Campo13" value="<? echo $Campo13 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo17" type="text" id="Campo17" value="<? echo $Campo17 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo21" type="text" id="Campo21" value="<? echo $Campo21 ?>" size="9">
          </div></td>
        <td><div align="center"> 
            <input name="Campo25" type="text" id="Campo25" value="<? echo $Campo25 ?>" size="9">
          </div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">Horno 
            N&ordm; 2</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo6" type="text" value="<? echo $Campo6 ?>" size="9" maxlength="10">
          </div></td>
        <td><div align="center"> 
            <input name="Campo10" type="text" id="Campo10"  value="<? echo $Campo10 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo14" type="text" id="Campo14" value="<? echo $Campo14 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo18" type="text" id="Campo18" value="<? echo $Campo18 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo22" type="text" id="Campo22" value="<? echo $Campo22 ?>" size="9">
          </div></td>
        <td><div align="center"> 
            <input name="Campo26" type="text" id="Campo26" value="<? echo $Campo26 ?>" size="9">
          </div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">H. 
            Basculante 1</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo7" type="text" value="<? echo $Campo7 ?>" size="9" maxlength="10">
          </div></td>
        <td><div align="center"> 
            <input name="Campo11" type="text" id="Campo11" value="<? echo $Campo11 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo15" type="text" id="Campo15" value="<? echo $Campo15 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo19" type="text" id="Campo19" value="<? echo $Campo19 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo23" type="text" id="Campo23" value="<? echo $Campo23 ?>" size="9">
          </div></td>
        <td><div align="center"> 
            <input name="Campo27" type="text" id="Campo27" value="<? echo $Campo27 ?>" size="9">
          </div></td>
      </tr>
      <tr> 
        <td><div align="center"><font size="1"><strong><font color="#000000">H. 
            Basculante 2</font></strong></font></div></td>
        <td><div align="center"> 
            <input name="Campo8" type="text" id="Campo8" value="<? echo $Campo8 ?>" size="9" maxlength="10">
          </div></td>
        <td><div align="center"> 
            <input name="Campo12" type="text" id="Campo12" value="<? echo $Campo12 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo16" type="text" id="Campo16" value="<? echo $Campo16 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo20" type="text" id="Campo20" value="<? echo $Campo20 ?>" size="8" maxlength="5">
          </div></td>
        <td><div align="center"> 
            <input name="Campo24" type="text" id="Campo24" value="<? echo $Campo24 ?>" size="9">
          </div></td>
        <td><div align="center"> 
            <input name="Campo28" type="text" id="Campo28" value="<? echo $Campo28 ?>" size="9">
          </div></td>
      </tr>
    </table>
    <table width="89%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#F4D284">
      <tr> 
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="3"><div align="center"><font size="1"><strong>Ollas Escoria 
            Horno Retenci&oacute;n</strong></font> <font size="1"> 
            <input name="Campo29" type="text" id="Campo29" value="<? echo $Campo29 ?>" size="8" maxlength="10">
            </font></div></td>
        <td colspan="2"><div align="center"> <font color="#000000" size="1"><strong>Ollas 
            Escoria Horno Basculante</strong></font> <font size="1"> 
            <input name="Campo30" type="text" id="Campo30" value="<? echo $Campo30 ?>" size="8" maxlength="10">
            </font></div></td>
      </tr>
	  <tr><td colspan="5">&nbsp;</td></tr>
      <tr>
        <td width="25%" rowspan="3" bgcolor="#6666CC"><strong><font color="#FFFFFF" size="3">Producto en proceso RAF </font></strong></td>
        <td width="12%"><font size="1"><strong><font color="#000000">H.Ret&eacute;n</font></strong></font></td>
        <td width="16%"><input name="Campo31" type="text" id="Campo31" value="<? echo $Campo31 ?>" size="8" maxlength="10" >
        <font size="1"><strong><font color="#000000">Ollas</font></strong></font></td>
        <td width="10%" height="22"><font size="1"><strong><font color="#000000">H.Basculante</font></strong></font></td>
      <td width="37%"><input name="Campo32" type="text" id="Campo32" value="<? echo $Campo32 ?>" size="8" maxlength="10" >
        <font size="1"><strong><font color="#000000">Ollas</font></strong></font></td>
      </tr>
      <tr>
        <td height="22"><font size="1"><strong><font color="#000000">Horno1</font></strong></font></td>
        <td><input name="Campo33" type="text" id="Campo33" value="<? echo $Campo33 ?>" size="10" maxlength="10" >
        <font size="1"><strong><font color="#000000">Ton.</font></strong></font></td>
        <td height="22"><font size="1"><strong><font color="#000000">Horno2</font></strong></font></td>
      <td height="22"><input name="Campo34" type="text" id="Campo34" value="<? echo $Campo34 ?>" size="10" maxlength="10" >
        <font size="1"><strong><font color="#000000">Ton.</font></strong></font></td>
      </tr>
      <tr>
        <td height="22"><font size="1"><strong><font color="#000000">Blister,Restos y Rechazos </font></strong></font></td>
        <td><input name="Campo35" type="text" id="Campo35" value="<? echo $Campo35 ?>" size="10" maxlength="10" >
        <font size="1"><strong><font color="#000000">Ton</font></strong></font><font size="1"><strong><font color="#000000">.</font></strong></font></td>
        <td height="22">&nbsp;</td>
      <td height="22">&nbsp;</td>
      </tr>
	  
      <tr> 
        <td height="25" colspan="5" ><div align="center"> 
            <input name="Volver" type="submit" id="Volver" value="Volver" onClick="Volver_Refino()";" target="_blank">
            <input name="Modificar" type="submit"  value="Modificar" onClick="mod_info()";" target="_blank">
            <input name="Eliminar2" type="submit" value="Eliminar" onClick="elim_info()";">
            <input name="Salir" type="submit" value="Salir" onClick="Salir_F()";" target="_blank">
          </div>
          <div align="center"></div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
