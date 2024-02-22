<?php 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 14;
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2";
}
/***************/
function Generar(f)
{
	f.action = "sea_ing_anexo01.php";
	f.submit(); 
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" align="center" valign="middle">
	  
<table width="400" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
      <td width="175" height="23">Fecha </td>
            <td width="219"> 
              <select name="mes" size="1">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($generar_h=='S')
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
              <select name="ano" size="1">
                <?php
	if($generar_h=='S')
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
      </td>
  </tr>
</table>
  <br>
  <table width="400" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td height="29" align="center"><input name="btngenerar" type="button" style="width=70;" value="Generar" onClick="JavaScript:Generar(this.form)">
        <input name="btnsalir" type="button" value="Salir" style="width=70;" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>
</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
