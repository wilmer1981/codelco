<?php 	
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores,ValorCheck,CmbAnoMax,CmbMesMax,CmbDiasMax)
{
	var Frm=document.FrmProceso;
	
	Frm.action="sec_programa_loteo_proceso01.php?Proceso=M&Valores="+Valores+"&ValorCheck="+ValorCheck+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&CmbAnoMax="+CmbAnoMax+"&CmbMesMax="+CmbMesMax+"&CmbDiasMax="+CmbDiasMax;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Modificacion Fecha Preembarque</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body onload="document.FrmProceso.CmbDias.focus()" background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="409" height="119" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" >
          <tr> 
            <td width="116">&nbsp;</td>
            <td width="269" align="right">&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td><strong>Fecha Preembarque</strong></td>
            <td>
			<?php
				echo "<select name='CmbDias'>";
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
				echo"</select>";
				echo"<select name='CmbMes'>";
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
				echo "</select>";
				echo "<select name='CmbAno'>";
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
				echo "</select>";
				echo "</td>";
			?>			
			</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="395" border="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $ValorCheck;?>','<?php echo $CmbAnoMax;?>','<?php echo $CmbMesMax;?>','<?php echo $CmbDiasMax;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
