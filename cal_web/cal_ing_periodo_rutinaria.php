<?php
include("../principal/conectar_principal.php");

$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$HoraActual = date("H");
$MinutoActual = date("i");
?>


<html>
<head>

<script language="JavaScript">
function Validar(ValorMuestras,ValorPeriodo,ValorSolAut,BuscarDetalle,BuscarPrv,Modificar,CmbProductos,CmbSubProducto,NombrePlantillaSA)
{
	var frm=document.frmingprogramador ;

	frm.action ="cal_ing_periodo_rutinaria01.php?Muestras=" + ValorMuestras + "&Periodo=" + ValorPeriodo + "&SolAut="+ValorSolAut+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&Modificar="+Modificar+"&CmbProductos="+CmbProductos+"&CmbSubProducto="+CmbSubProducto+"&NombrePlantillaSA="+NombrePlantillaSA;
	frm.submit();
}
</script>
<title>Programacion</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body background="../principal/imagenes/fondo3.gif"><center>
<form name="frmingprogramador" method="post" action="">
    <table width="606" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
      <tr>
        <td height="201">
			<table width="603"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
            <tr>
             <td width="597" height="40">
				<div align="center">
				<font style="font-size:15px">
				<?php
				switch ($Periodo)
				{
					case "1":
						echo "<strong>FECHA DE TOMA DE LA MUESTRA(Muestra Diaria)</strong>";
					break;
					case "2":
						echo "<strong>FECHA DE TOMA DE LA MUESTRA(Composito Semanal)</strong>";
					break;
					case "3":
						echo "<strong>FECHA DE TOMA DE LA MUESTRA(Composito Mensual)</strong>";
					break;
					case "4":
						echo "<strong>FECHA DE TOMA DE LA MUESTRA(Muestra por Turno)</strong>";
					break;
					case "5":
						echo "<strong>FECHA DE TOMA DE LA MUESTRA(Composito Quincenal)</strong>";
					break;
				}
				?>
				</font>
				</div>
			</td>
            </tr>
          </table>
          <br>
          <table width="604" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
            <tr> 
              <td><strong>Fecha de Muestra</strong>
                <select name="CmbDias" id="select7" size="1" style="width:40px;">
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
                <select name="CmbMes" size="1" style="width:90px;">
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
                <select name="CmbAno" size="1" style="width:70px;">
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
                </select>
                &nbsp;<strong>Hora Muestra</strong>&nbsp; 
                <select name="CmbHora" id="select33">
                  <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($HoraAnalisis))
					{	
						if ($HoraAnalisis == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                </select>
                <strong>:</strong> 
                <select name="CmbMinutos">
                  <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($CmbMinutos))
					{	
						if ($MinutosLixiv == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                </select>
            </td>
            </tr>
          </table>
          <br>
          <table width="604"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
            <tr> 
              <td width="279"><div align="right">
                  <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70" value="Grabar" onClick="javascript:Validar('<?php echo $Muestras; ?>','<?php echo $Periodo;?>','<?php echo $SolAut; ?>','<?php echo $BuscarDetalle; ?>','<?php echo $BuscarPrv ;?>','<?php echo $Modificar;?>','<?php echo $CmbProductos;?>','<?php echo $CmbSubProducto;?>','<?php echo $NombrePlantillaSA;?>');">
                </div></td>
              <td width="293"><input name="BtnSalir" type="Button"  value="Salir" style="width:70"onClick="JavaScript:window.close();"></td>
            </tr>
          </table><br>
          <table width="604"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
            <tr> 
            	<td>
				<strong>LA FECHA DE LA MUESTRA DEBE SER LA FECHA REAL EN QUE SE TOMO LA MUESTRA</strong>
				</td>
            </tr>
          </table></td>
      </tr>
    </table><p>&nbsp;</p>
    </form>
</center>
</body>
</html>
