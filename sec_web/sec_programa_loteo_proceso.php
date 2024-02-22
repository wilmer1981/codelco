<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 1;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Consulta="select max(fecha_maxima) as fecha_mayor from sec_web.programa_loteo"; 
	$Respuesta=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Respuesta))
	{
		$FechaMaxima=$Fila[fecha_mayor];
	}
	else
	{
		$FechaMaxima=date('Y-m-d');
	}	
	switch($Proceso)
	{
		case "N":
			$Consulta = "select max(ceiling(num_prog_loteo)) as CodMayor from sec_web.programa_loteo";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resultado))
			{
				$NroPrg=$Fila[CodMayor]+1;	
			}
			else
			{
				$NroPrg=1;	
			}
			break;
		case "M":
			$Datos=explode('~~',$Valores);
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$CodDescripcion=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($CodDescripcion);$j++)
					{
						if (substr($CodDescripcion,$j,2)=="~~")
						{
							$Codigo=substr($CodDescripcion,0,$j);
							$Descripcion=substr($CodDescripcion,$j+2);
						}	
					}
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">
/*document.onkeydown = TeclaPulsada; 

function TeclaPulsada (tecla) 
{ 
var teclaCodigo = event.keyCode; 
var teclaReal = String.fromCharCode(teclaCodigo); 
alert("Código de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 
function MostrarPaquetes(cod_bulto,num_bulto,ie)
{

	window.open("sec_paquetes_series.php?CodBulto="+cod_bulto+"$NumBulto="+num_bulto+"&IE="+ie,"","top=110,left=30,width=690,height=340,scrollbars=no,resizable = yes");

}


function Grabar(Proceso,Valores,FechaMaxima)
{
	var Frm=document.FrmProceso;
	var FechaMaximaNueva="";
	var Mes ="";
	var Dia="";
	
	if (Frm.CmbMes.value.length==1)
	{
		Mes="0"+Frm.CmbMes.value;
	}
	else
	{
		Mes=Frm.CmbMes.value;
	}
	if (Frm.CmbDias.value.length==1)
	{
		Dia="0"+Frm.CmbDias.value;
	}
	else
	{
		Dia=Frm.CmbDias.value;
	}
	FechaMaximaNueva=Frm.CmbAno.value+"-"+Mes+"-"+Dia;
	if (FechaMaxima>FechaMaximaNueva)
	{
		alert("Fecha no puede ser Menor a Fecha Maxima de una Solicitud Anterior");
		return;
	}
	Frm.action="sec_programa_loteo_proceso01.php?Proceso="+Proceso+"&TxtNroLoteo="+Frm.TxtNroLoteo.value+"&Valores="+Valores;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body onload="document.FrmProceso.TxtNroLoteo.focus()" background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" >
          <tr> 
            <td width="113">&nbsp;</td>
            <td width="272" align="right"><strong>Fecha:&nbsp;<?php echo date('Y:m:d')?></strong>&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td>Programa Loteo N°&nbsp;</td>
            <td> 
              <?php
					echo "<input type='Text' name='TxtNroLoteo' style='width:60' maxlength='3' value='$NroPrg' readonly>";					
				?>
            </td>
          </tr>
          <tr> 
            <td>Fecha Maxima</td>
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
			?>
			</td>
          </tr>
          <tr> 
            <td>Descripcion</td>
            <td rowspan="4"><textarea name="TxtDescripcion" style="width:270;height:50"></textarea></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="395" border="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $FechaMaxima?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
