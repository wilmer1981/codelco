<?php
	$CodigoDeSistema = 7;
	$CodigoDePantalla =15; 
	include("../principal/conectar_principal.php")
?>
<html>
<head>
<title>Sistema Carga Historica Concentrado</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "C":
			
			f.action = "ram_flujo24_web_historico.php";				
			f.submit();		
			break;	
			
			case "S":
			
			 window.open('','_parent','');
             window.close(); 
		
	}
}
function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "ram_flujo24_historico.php";
	f.submit();
}
</script>
</head>

<SCRIPT LANGUAGE="JavaScript">
function cerrar_sin()
{  
 window.open('','_parent','');
 window.close(); 
} 
</script> 

<SCRIPT LANGUAGE="JavaScript">
function cerrar_con()
{  
 window.close(); 
} 
</script> 

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="ConsComun" value="<?php echo $ConsComun; ?>">
<?php include("../principal/encabezado.php"); ?>
  <table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
  
      <tr> 
        <td width="27%">Periodo a cargar del Flujo CONCENTRADO :</td>
	  </tr>  
		<br> 
		<br> 
    <tr>
      <td valign="top">
     <table width="76%" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
       				
		<tr> 	
            <select name="Mes" id="select5" style="width:110px">
                <?php
			  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i = 1; $i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
              </select>
              <select name="Ano" style="width:70px">
                <?php
				for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
            </select></td>
          </tr>
         </table>
      <br>      
	  <br>      <table width="76%" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr>
          <td width="100%" align="center"><input name="BtnConsultar2" type="button" value="Cargar Flujos" style="width:70px" onClick="Proceso('C');">
              <input name="BtnSalir2" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"></td>

        </tr>
      </table></td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
