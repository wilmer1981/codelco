<?php 	
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:""; 
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$FechaMaxima = isset($_REQUEST["FechaMaxima"])?$_REQUEST["FechaMaxima"]:"";

	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$CodDisp=$Datos2[3];	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	var Mes ="";
	var Dia="";
	
	Frm.action="sec_disponibilidad_lotes_proceso01.php?Valores="+Valores;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body onload="document.FrmProceso.CmbDispLotes.focus()" background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="445" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="433"><table width="433" border="0" >
          <tr> 
            <td width="113">&nbsp;</td>
            <td width="310" align="right"><strong>Fecha:&nbsp;<?php echo date('Y:m:d')?></strong>&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td>Fecha</td>
            <td> 
              <?php
				echo "<SELECT name='CmbDias'>";
				for ($i=1;$i<=31;$i++)
				{
					if (isset($CmbDias))
					{
						if ($i==$CmbDias)
						{
							echo "<option SELECTed value= '".$i."'>".$i."</option>";
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
							echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{
						  echo "<option value='".$i."'>".$i."</option>";
						}
					}	
				}
				echo"</SELECT>";
				echo"<SELECT name='CmbMes'>";
				for($i=1;$i<13;$i++)
				{
					if (isset($CmbMes))
					{
						if ($i==$CmbMes)
						{
							echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
							echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
						}
						else
						{
							echo "<option value='$i'>".$meses[$i-1]."</option>\n";
						}
					}	
				}
				echo "</SELECT>";
				echo "<SELECT name='CmbAno'>";
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAno))
					{
						if ($i==$CmbAno)
							{
								echo "<option SELECTed value ='$i'>$i</option>";
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
								echo "<option SELECTed value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}		
				}
				echo "</SELECT>";			
			?>
              <font size="1"><font size="2"> </font></font> </td>
          </tr>
          <tr> 
            <td>Disponibilidades</td>
            <td>
              <?php
					echo "<SELECT name='CmbDispLotes'>";
					echo "<option value='-1' SELECTed>Seleccionar</option>";
					if ($CodDisp=='T')
					{	
						echo "<option value='PLE' >Lote por Lavar, Pesar y Enzunchar(PLE)</option>";	
						echo "<option value='PLP' >Lote por Lavar, Pesado(PLP)</option>";
					}
					else
					{		
						if (($CodDisp=='PLE')||($CodDisp=='PLP'))
						{
							echo "<option value='EPL' >Lote Terminado de Pesar(EP)</option>";	
							echo "<option value='EPLE' >Lote por Lavar,Pesar y Enzunchar(EPLE)</option>";
							echo "<option value='EPLP' >Lote por Lavar,Pesado(EPLP)</option>";	
						}	
					}	
					echo "</SELECT>";	
			  ?>
            </td>
          </tr>
        </table>
        <br>
        <table width="430" border="0">
          <tr> 
            <td  align="center" width="424"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $FechaMaxima?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
