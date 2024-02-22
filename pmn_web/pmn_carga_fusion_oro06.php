<?php
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
include("../principal/conectar_principal.php");
/*$Consulta="select * from pmn_web.carga_fusion_oro where num_electrolisis = '".$Elect."' ";
$Consulta.=" and fecha= '".$Fecha."' and num_barra = '".$Barra."' and sobrante ='".$Sobrante."' ";
//echo $Consulta."<br>";
$Respuesta=mysqli_query($link, $Consulta);
if ($Fila=mysqli_fetch_array($Respuesta))
{
	$TxtPesoSob=$Fila[peso_sobrante];
	if ($Fila[sobrante]=="S")
	{
		$Ver='N';
		$Mostrar="S";
	}
	else
	{
		$Ver='S';
		$Mostrar='S';
	}
}
if ($Ver=='S')
{
	$Consulta="select count(num_electrolisis) as cantidad from pmn_web.carga_fusion_oro  ";
	$Consulta.="	where num_electrolisis='".$Elect."' and fecha='".$Fecha."' and sobrante='S' ";
	$Respuesta1=mysqli_query($link, $Consulta);
	$Fila1=mysqli_fetch_array($Respuesta1);
	$Cantidad=$Fila1[cantidad];
	if ($Cantidad >=1)
	{
		$Mostrar='N';
	}
}*/
?>
<html>
<head>
<title>Ingreso Valores Muestras</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 110 )&&(teclaCodigo != 190 ))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
function Grabar(E,F)//Electrolisis,Fecha del dia
{
	var frm =document.FrmRetalla;	 
	FechaA=frm.CmbAno.value + '-' + frm.CmbMes.value + '-' + frm.CmbDias.value;
	frm.action="pmn_carga_fusion_oro01.php?ElectBarras="+E + "&Fe="+F + "&Acta="+frm.TxtActa.value + "&FechaActa="+FechaA +  "&Proceso=Acta";
	frm.submit(); 
}
function Salir()
{
	var frm =document.FrmRetalla;	 
	window.close();
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="FrmRetalla" method="post" action="">
  <table width="426" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="483"><table width="415" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="5"><div align="center" class="TituloCabeceraAzul">Ingreso Acta</div></td>
          </tr>
          <tr> 
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">N&deg;Acta</td>
            <td colspan="2">: <input name="TxtActa" type="text" style="width:40px;" id="TxtActa"></td>
            <td width="63">&nbsp;</td>
            <td width="112"><font size="2">&nbsp; </font> <font size="2">&nbsp; 
              </font> </td>
          </tr>
          <tr> 
            <td width="62" class="titulo_azul">Fecha</td>
            <td colspan="4">:<font size="2"> 
              <select name="CmbDias" style="width:40px;">
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
              </select>
              <select name="CmbMes" style="width:90px;">
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
              </select>
              <select name="CmbAno" style="width:70px;">
                <?php
			for ($i=date("Y");$i<=date("Y");$i++)
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
              </select>
              </font></td>
          </tr>
        <?php
		 $Cont=1;
		$AuxElectBarras=$ElectBarras; 
		 for($j= 0;$j <= strlen($ElectBarras); $j++)
		 {
			if (substr($ElectBarras,$j,2) == "//")
			{
				$ElecBarra =substr($ElectBarras,0,$j);	
				for ($x=0;$x<= strlen($ElecBarra);$x++)
				{
					if (substr($ElecBarra,$x,2) == "~~")
					{
						$Electrolisis = substr($ElecBarra,0,$x);
						$Barra = substr($ElecBarra,$x+2,strlen($ElecBarra));
						$Consulta="select num_acta from pmn_web.carga_fusion_oro ";
						$Consulta.=" where num_electrolisis='".$Electrolisis."' and num_barra ='".$Barra."' and fecha='".$Fecha."'  ";
						//echo $Consulta."<br>";
						$Respuesta=mysqli_query($link, $Consulta); 
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							if ((!is_null($Fila[num_acta])) || ($Fila[num_acta]!=""))
							{
								$Mostrar="N";
							}
						}
						if ($Cont==1)
						{			
							$BarraInicial=$Barra;		
						}
						$BarraFinal=$Barra;						
						$Cont++;
					}	
				}	
				$ElectBarras = substr($ElectBarras,$j + 2);
				$j = 0;
			}
		}
		$TxtBarraInicial=$BarraInicial;
		$TxtBarraFinal=$BarraFinal;
		?> 
		  <tr> 
            <td class="titulo_azul">BarraI</td>
            <td width="68">:
			<input name="TxtBarraInicial" type="text" id="TxtBarraInicial" style="width:50px;" value="<?php echo $TxtBarraInicial;  ?>"></td>
            <td width="77" class="titulo_azul">BarraF</td>
            <td>:
			<input name="TxtBarraFinal" type="text" id="TxtBarraFinal" style="width:50px;" value="<?php  echo $TxtBarraFinal;  ?>"></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="416" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="185"><div align="right">
				<?php
					echo "<input name='BtnOk' type='button' style='width:50'  value='OK' onClick=\"Grabar('$AuxElectBarras','$Fecha')\"; >";
				?>																					
              </div></td>
            <td width="11">&nbsp;</td>
            <td width="199"><input name="BtnSalir" style="width:50" type="button" id="BtnSalir" value="Salir" onClick="Salir();">
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php

echo "<script language='JavaScript'>";
if ($Mostrar=='N')
{
	
	echo "var Frm=document.FrmRetalla;";
	echo "alert('Ya existe un Acta para esta barra ');";
	echo "Frm.TxtActa.focus();";
}
echo "</script>";
?>
