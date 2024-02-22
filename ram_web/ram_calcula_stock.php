<?php 
	include("../principal/conectar_principal.php"); 
	$CodigoDeSistema=7;


?>
<html>
<head>
<title>Sistemas de Informaci&oacute;n</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<!--<script language="vbscript"></script>-->
<script language="JavaScript">
function Proceso()
{
	var f = document.frmPrincipal;
	//var ProcessRun = "N";

	//alert('PRUEBA DVS');
	//validaProceRun('hola');
	//ProcessRun=validaProceRun(ProcessRun);
	//if(ProcessRun=="N")
	//{
	var Recepcion = "N";
	if (f.ChkRecep.checked)
	{
		Recepcion = "R";
	}
	f.action = "ram_calcula_stock.php?Proceso=E&Recep=" + Recepcion;
	f.submit();
	/*}
	else
	{
		alert("Proceso Ejecutandose...");
		
	}*/
}
function VerLog()
{
	var f = document.frmPrincipal;
	var Recepcion = "N";
	if (f.ChkRecep.checked)
	{
		Recepcion = "R";
	}
	f.action = "ram_calcula_stock.php?Proceso=L&Recep=" + Recepcion;
	f.submit();
}
function Salir()
{
	var f = document.frmPrincipal;
    f.action ="../principal/sistemas_usuario.php?CodSistema=7";
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php");?>
<table width="770" border="0" class="TablaPrincipal">
  <tr>
      <td height="313" align="center" valign="top"> 
        <table width="720" border="0" align="center" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td height="17" colspan="4">EJECUTAR PROGRAMA DE STOCK RAM</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td width="81">Fecha Inicio:</td>
            <td width="294"><select name="DiaIni" style="width:45;">
                <?php
		  	for ($i=1;$i<=31;$i++)
			{
				if (!isset($DiaIni))
				{
					if ($i == date("j"))
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if (($DiaIni * 1) == $i)
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		  ?>
              </select> <select name="MesIni" style="width:90;">
                <?php
		  	for ($i=1;$i<=12;$i++)
			{
				if (!isset($MesIni))
				{
					if ($i == date("n"))
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				else
				{
					if (($MesIni * 1) == $i)
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
			}
		  ?>
              </select> <select name="AnoIni" style="width:60;">
                <?php
		  	for ($i=2003;$i<=(date("Y")+1);$i++)
			{
				if (!isset($AnoIni))
				{
					if ($i == date("Y"))
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($AnoIni == $i)
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		  ?>
              </select></td>
            <td width="97">Fecha Termino:</td>
            <td width="220"><select name="DiaFin" style="width:45;">
                <?php
		  	for ($i=1;$i<=31;$i++)
			{
				if (!isset($DiaFin))
				{
					if ($i == date("j"))
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if (($DiaFin * 1) == $i)
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		  ?>
              </select> <select name="MesFin" style="width:90;">
                <?php
		  	for ($i=1;$i<=12;$i++)
			{
				if (!isset($MesFin))
				{
					if ($i == date("n"))
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				else
				{
					if (($MesFin * 1) == $i)
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
			}
		  ?>
              </select> <select name="AnoFin" style="width:60;">
                <?php
		  	for ($i=2003;$i<=(date("Y")+1);$i++)
			{
				if (!isset($AnoFin))
				{
					if ($i == date("Y"))
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($AnoFin == $i)
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		  ?>
              </select></td>
          </tr>
          <tr>
            <td colspan="4"><?php
			if ($Recep == "R")
			{
				echo "<input type='checkbox' name='ChkRecep' checked='true' value='".$Recep."'>Con Recepcion";
			}
			else
			{
				if ($Recep == "N")
				{
					echo "<input type='checkbox' name='ChkRecep' value='".$Recep."'>Con Recepcion";
				}
				else
				{
					echo "<input type='checkbox' name='ChkRecep' checked value='".$Recep."'>Con Recepcion";
				}
			}
				?>
              </td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="4">
	      <input type="button" name="Submit" value="Ejecutar" style="width:70;" onClick="Proceso();">
 	      <input type="button" name="Submit" value="Ver Log" style="width:70;" onClick="VerLog();">
              <input type="submit" name="button" value="Salir" style="width:70;" onClick="Salir()"> 
            </td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4">NOTA: Este programa corre sobre el servidor, el tiempo 
              para ver resultados de un dia es app 45' y un mes 2''</td>
          </tr>
        </table> 
        <br>
        <br>
<?php
	
	switch($Proceso)
	{
		case "E":
		//GRABA ARCHIVO DE CONFIGURACION
		if ($DiaIni < 10)
		{
			$DiaIni = "0".$DiaIni;
		}
		if ($MesIni < 10)
		{
			$MesIni = "0".$MesIni;
		}
		if ($DiaFin < 10)
		{
			$DiaFin = "0".$DiaFin;
		}
		if ($MesFin < 10)
		{
			$MesFin = "0".$MesFin;
		}
		$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
		$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;


		$FechaAux = $FechaInicio;

			$Archivo = "ram.txt";
			if ($Arr = file($Archivo)) 
			{
				$i = 0;
				while (list ($Linea, $Contenido) = each ($Arr)) 
				{
					$Linea0 = $Contenido;			
					//echo "Linea Nº ".$Linea." = ".$Contenido."<br>";
				}
			}

			$ArchivoNuevo = fopen("ram.txt","w+");
			if ($Recep == "R")
			{
				$Pos0 = "R";
			}
			else
			{
				$Pos0 = "N";
			}
			//echo $Pos0."<br>";
			$Pos1 = substr($Linea0,1,1);
			//echo $Pos1."<br>";
			$Pos2 = substr($Linea0,2,10);
			//echo $Pos2."<br>";
			$Pos3 = substr($Linea0,12,10);
			//echo $Pos3."<br>";
			$Pos4 = substr($Linea0,22,1);
			//echo $Pos4."<br>";
			$NuevaLinea = $Pos0.$Pos1.$FechaInicio.$FechaTermino.$Pos4;
			//echo $NuevaLinea;
			fwrite($ArchivoNuevo,$NuevaLinea);		
			fclose($ArchivoNuevo);
			
			//------------EJECUTA PROGRAMA AUTOMATICO------------
	
			//$command="runas /user:cmadmres@codelco AutomaticoRam.exe";

			//$command="runas /env /user:codelco\pfari002_oper  AutomaticoRam.exe";

			exec('AutomaticoRam.exe');
			//passthru('pato.bat');
	
			break;
		case "L"://VER LOG DE EJECUCION
			echo "<table width='550' border='0' class='TablaInterior'>\n";
			$Archivo = "ramlog.txt";
			if ($Arr = file($Archivo)) 
			{
				while (list ($Linea, $Contenido) = each ($Arr)) 
				{
					echo "<tr>\n";				
					echo "<td>".$Contenido."</td>\n";
					echo "</tr>\n";
				}
			}
			echo "</table>\n";  	
			break;

	}
	
?>		
      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php");?>
<?php include("../principal/cerrar_principal.php");?>
</form>
</body>
</html>
