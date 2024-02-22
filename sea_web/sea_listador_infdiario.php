<?php

$CodigoDeSistema = 2;
$CodigoDePantalla = 37;

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
}
if(isset($_REQUEST["recargapag1"])) {
	$recargapag1 = $_REQUEST["recargapag1"];
}else{
	$recargapag1 = "";
}

if(isset($_REQUEST["dia_t"])) {
	$dia_t = $_REQUEST["dia_t"];
}else{
	$dia_t = date("d");
}
if(isset($_REQUEST["mes_t"])) {
	$mes_t = $_REQUEST["mes_t"];
}else{
	$mes_t =  date("m");
}
if(isset($_REQUEST["ano_t"])) {
	$ano_t = $_REQUEST["ano_t"];
}else{
	$ano_t =  date("Y");
}

?>

<html>
<head>
<title>Listado &Aacute;nodos Rechazados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<script language="JavaScript">

function listar_datos()
{
var f=formulario;
    f.action = "sea_lst_infdiario_produccion.php";
    f.submit()
}

function listar_Excel()
{
var f=formulario;
    f.action = "sea_xls_infdiario_produccion.php";
    f.submit()
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}

</script>
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>

<body>
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?>
<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center" valign="top">
  <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><div align="right">Fecha</div></td>
            <td><SELECT name="dia_t" size="1" style="font-face:verdana;font-size:10">
                <?php      
			if($Proceso=='V' || $recargapag1=='S')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia_t)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
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
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }
		?>
              </SELECT> <SELECT  name="mes_t" size="1" id="SELECT" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php	           
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $recargapag1=='S')
		{
		
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes_t)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  

    ?>
              </SELECT> <SELECT name="ano_t" size="1" id="SELECT2"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php            
	if($Proceso=='V' || $recargapag1=='S')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano_t)
			{
			echo "<option SELECTed value ='$i'>$i</option>";
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
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }
	?>
              </SELECT></td>
          </tr>
          <tr> 
            <td width="267" height="28"><div align="right"></div></td>
            <td width="468">&nbsp; </td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><br>
        </p>
        <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><div align="center"><font color="#000000"> 
			  <input name="listar" type="button" style="width:100" value="Listar Web" onClick="listar_datos();">&nbsp;
			  <input name="listar" type="button" style="width:100" value="Listar Excel" onClick="listar_Excel();">&nbsp;
              <input name="salir" type="button" style="width:100" onClick="salir_menu();" value="Salir">
                </font></div></td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
