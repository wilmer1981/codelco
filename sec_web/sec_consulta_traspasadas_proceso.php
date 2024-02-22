<?php 	
	include("../principal/conectar_sec_web.php");


	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$hh = isset($_REQUEST["hh"])?$_REQUEST["hh"]:date("H");
	$mm = isset($_REQUEST["mm"])?$_REQUEST["mm"]:date("i");

	$Datos=explode('|',$Valores);
	$Hornada=$Datos[0];
	$FechaTrasp=$Datos[1];
	$SubProd=$Datos[5];
	$Peso=$Datos[4];
?>
<html>
<head>
<script language="JavaScript">
function Modificar()
{
	var Frm=document.FrmModifFechaTrasp;
		
	if (confirm('Esta Seguro de Modificar Fecha Traspaso'))
	{
		Frm.action="sec_consulta_traspasadas_proceso01.php?Proceso=M";
		Frm.submit();
	}	
}

function Salir()
{
	window.close();
	
}
</script>
<title>Modificar Fecha Traspaso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
 <form name="FrmModifFechaTrasp" method="post" action="">
 <input type="hidden" name="Valores" value="<?php echo $Valores;?>">
  <table width="445" height="185" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	<td align="center"><br>
		<table width="346" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
          <tr>
			  <td width="98" align="left" class="Detalle01">Hornada</td>
			  <td width="233" colspan="2" align="left" class="Detalle01"><?php echo $Hornada;?>&nbsp;</td>
		  </tr>
		  <tr>
			  <td width="98" align="left" class="Detalle01">Fecha Traspaso </td>
			  <td colspan="2" align="left" class="Detalle01"><?php echo $FechaTrasp;?>&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="left" class="Detalle01">Producto</td>
		    <td colspan="2" align="left" class="Detalle01"><?php echo $SubProd;?>&nbsp;</td>
	      </tr>
		  <tr>
		    <td align="left" class="Detalle01">Peso</td>
		    <td colspan="2" align="left" class="Detalle01"><?php echo number_format($Peso,0,',','.');?>&nbsp;</td>
	      </tr>
		</table>
		<br>
		<table width="346" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
		  <tr>
			  <td width="98">Fecha Modificar </td>
			  <td width="233"><SELECT name="dia" size="1">
                <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		for ($i=1;$i<=31;$i++)
		{	
			if (($mostrar == "S") && ($i == $dia))			
				echo "<option SELECTed value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($mostrar != "S")) 
					echo "<option SELECTed value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}		
	?>
              </SELECT>
                <SELECT name="mes" size="1" id="SELECT">
                  <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes))
							echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
						else if (($i == date("n")) && ($mostrar != "S"))
								echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
						else
							echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
					}		  
				?>
							</SELECT>
							<SELECT name="ano" size="1">
							<?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano))
							echo "<option SELECTed value ='$i'>$i</option>";
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo "<option SELECTed value ='$i'>$i</option>";
						else	
							echo "<option value='".$i."'>".$i."</option>";
					}
				?>
                </SELECT>
</td>
		  </tr>
		  <tr>
			  <td>Hora Modificar </td>
			  <td>	<SELECT name="hh" id="SELECT5">
                <?php
					for($i=0; $i<=23; $i++)
					{
						if (($mostrar == "S") && ($i == $hh))
							echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
						else if (($i == date("H")) && ($mostrar != "S"))
							echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
						else	
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </SELECT>
				:
				<SELECT name="mm">
				<?php
							for($i=0; $i<=59; $i++)
							{
								if (($mostrar == "S") && ($i == $mm))
									echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
								else if (($i == date("i")) && ($mostrar != "S"))
									echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
								else	
									echo '<option value="'.$i.'">'.$i.'</option>';
							}
						?>
				</SELECT></td>
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
