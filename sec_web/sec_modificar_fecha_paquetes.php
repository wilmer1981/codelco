<?php 	
	include("../principal/conectar_sec_web.php");

// Valores=J//50001//2023-12-01//a&CodigoLote=J&NumeroLote=50000&Ano=2022&subproducto=11

$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
$CodigoLote  = isset($_REQUEST["CodigoLote"])?$_REQUEST["CodigoLote"]:"";
$NumeroLote  = isset($_REQUEST["NumeroLote"])?$_REQUEST["NumeroLote"]:"";
$Ano         = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$subproducto = isset($_REQUEST["subproducto"])?$_REQUEST["subproducto"]:"";

$NumI        = isset($_REQUEST["NumI"])?$_REQUEST["NumI"]:"";
$NumF        = isset($_REQUEST["NumF"])?$_REQUEST["NumF"]:"";
$MesI        = isset($_REQUEST["MesI"])?$_REQUEST["MesI"]:"";
//$MesF        = $_REQUEST["MesF"];

?>
<html>
<head>
<script language="JavaScript">
function Modificar()
{
	var Frm=document.FrmModifFechaPqte;
		
	if (confirm('Esta Seguro de Modificar Fecha Hora Creacion Paquete'))
	{
		Frm.action="sec_modificar_fecha_paquetes01.php?Proceso=M";
		Frm.submit();
	}	
}

function Salir()
{
	window.close();
	
}
</script>
<title>Modificar Fecha Creacion Paquete</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
 <form name="FrmModifFechaPqte" method="post" action="">
 <input name="Valores" type="hidden" value="<?php echo $Valores;?>">
 <input name="Ano" type="hidden" value="<?php echo $Ano;?>">
 <input name="NumI" type="hidden" value="<?php echo $NumI  ?>">
 <input name="NumF" type="hidden" value="<?php echo $NumF  ?>">
 <input name="MesI" type="hidden" value="<?php echo $MesI  ?>">
 <input name="CodigoLote" type="hidden" value="<?php echo $CodigoLote  ?>">
 <input name="NumeroLote" type="hidden" value="<?php echo $NumeroLote  ?>">
 <input name="subproducto" type="hidden" value="<?php echo $subproducto;?>">
 
  <table width="445" height="185" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	<td align="center"><br>
		<table width="346" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
          <tr>
			  <td width="98" align="left" class="Detalle01">Paquetes</td>
			  <td width="233" colspan="2" align="left" class="Detalle01">
			  <?php
			  	$Paquetes=str_replace('@@',' -- ',$Valores);
			  ?>
		      <textarea name="textarea" cols="30" rows="3"><?php echo $Paquetes;?></textarea></td>
		  </tr>
		</table>
		<br>
		<table width="346" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
		  <tr>
			  <td width="98">Fecha Modificar </td>
			  <td width="233">
				<select name="dia" size="1">
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{	
						if (($mostrar == "S") && ($i == $dia))			
							echo "<option selected value= '".$i."'>".$i."</option>";				
						else if (($i == date("j")) and ($mostrar != "S")) 
								echo "<option selected value= '".$i."'>".$i."</option>";											
						else					
							echo "<option value='".$i."'>".$i."</option>";												
					}		
				?>
              </select>
                <select name="mes" size="1" id="select">
                  <?php
						for($i=1;$i<13;$i++)
						{
							if (($mostrar == "S") && ($i == $mes))
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							else if (($i == date("n")) && ($mostrar != "S"))
									echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							else
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
						}		  
					?>
                </select>
                <select name="ano" size="1">
                  <?php
						for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
						{
							if (($mostrar == "S") && ($i == $ano))
								echo "<option selected value ='$i'>$i</option>";
							else if (($i == date("Y")) && ($mostrar != "S"))
								echo "<option selected value ='$i'>$i</option>";
							else	
								echo "<option value='".$i."'>".$i."</option>";
						}
					?>
                </select>
</td>
		  </tr>
		  <tr>
			  <td>Hora Modificar </td>
			  <td>	<select name="hh" id="select5">
                <?php
					for($i=0; $i<=23; $i++)
					{
						if (($mostrar == "S") && ($i == $hh))
							echo '<option selected value ="'.$i.'">'.$i.'</option>';
						else if (($i == date("H")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else	
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select>
			:
			<select name="mm">
			<?php
						for($i=0; $i<=59; $i++)
						{
							if (($mostrar == "S") && ($i == $mm))
								echo '<option selected value ="'.$i.'">'.$i.'</option>';
							else if (($i == date("i")) && ($mostrar != "S"))
								echo '<option selected value ="'.$i.'">'.$i.'</option>';
							else	
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
			</select>
</td>
	      </tr>
		</table>
        <br><br>
		<table width="346" border="0" class="tablainterior">
          <tr>
			<td width="491" align="center">
			<input type="button" name="BtnOK" value="Modificar" style="width:70" onClick="Modificar();">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
			</td>
		  </tr>
		</table>
	</td>
  </tr>
  </table>
</form>
</body>
</html>
