<?php 	
$CodigoDeSistema = 1;
$CodigoDePantalla = 45;

$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

if(isset($_REQUEST["TxtCant"])) {
	$TxtCant = $_REQUEST["TxtCant"];
}else{
	$TxtCant = "";
}

if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias = date("d");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes = date("n");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno = date("Y");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT = date("d");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT=date("n");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT = date("Y");
}



?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opcion)
{
	var Frm=document.FrmProceso;
	
	switch (Opcion)
	{
		case "R":
			Frm.action="actualizar_candados01.php";
			Frm.submit();
			break;
		case "C":
			Frm.action="consulta_cand_no_cerrados.php";
			Frm.submit();
			break;
		case "S":
			Frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=44";
			Frm.submit();
			break;
	}
}	
function Salir()
{
	window.close();
	
}
</script>
<title>PROCESO CANDADOS</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="771" border="0" cellpadding="5" cellspacing="0"  left="5" class="TablaPrincipal">
    <tr> 
      <td width="141">&nbsp;</td>
      <td width="461">&nbsp;</td>
      <td width="121">&nbsp;</td>
      <td width="14">&nbsp;</td>
    </tr>
    <tr> 
      <td>FECHA INICIO</td>
      <td><select name="CmbDias" size="1" style="width:42px;">
          <?php
				
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDias))
				{
					if ($i==$CmbDias)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
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
        </select> <select name="CmbMes" size="1" style="width:100px;">
          <?php
		  for($i=1;$i<13;$i++)
		  {
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
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
        </select> <select name="CmbAno" size="1" style="width:70px;">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
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
        </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>FECHA TERMINO</td>
      <td><select name="CmbDiasT" size="1" style="width:42px;">
          <?php
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDiasT))
				{
					if ($i==$CmbDiasT)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
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
        </select> <select name="CmbMesT" size="1" style="width:100px;">
          <?php
			  for($i=1;$i<13;$i++)
			  {
					if (isset($CmbMesT))
					{
						if ($i==$CmbMesT)
						{
							echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
						}
						else
						{
							echo "<option value='$i'>".$meses[$i-1]."</option>\n";
						}
					
					}	
					else
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
        </select> <select name="CmbAnoT" size="1" style="width:70px;">
          <?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAnoT))
					{
						if ($i==$CmbAnoT)
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}
					else
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
        </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>
	  <input type="button" name="Procesar" value="Reparar" style="width:65" onClick="Proceso('R');">
	  <input type="button" name="Procesar" value="Consultar" style="width:65" onClick="Proceso('C');">
	  <input type="button" name="Procesar" value="Salir" style="width:65" onClick="Proceso('S');">
	  </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>Cant SA: <input type="text" name="TxtCant" value="<?php echo $TxtCant;?>" style="width:60"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
