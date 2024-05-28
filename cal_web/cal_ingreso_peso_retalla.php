<?php
	include("../principal/conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];
	$Fecha_Hora = date("Y-m-d");

	if(isset($_REQUEST["ValoresSA"])) {
		$ValoresSA = $_REQUEST["ValoresSA"];
	}else{
		$ValoresSA = "";
	}
	if(isset($_REQUEST["CheckT"])) {
		$CheckT = $_REQUEST["CheckT"];
	}else{
		$CheckT = "";
	}
	if(isset($_REQUEST["FechaBusqueda"])) {
		$FechaBusqueda = $_REQUEST["FechaBusqueda"];
	}else{
		$FechaBusqueda = "";
	}

	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
	$Solicitudes=$ValoresSA;
	$Criterio = "";
	for ($j = 0;$j <= strlen($ValoresSA); $j++)
	{
		if (substr($ValoresSA,$j,2) == "//")
		{
			$SARutRecargo = substr($ValoresSA,0,$j);
			for ($x=0;$x<=strlen($SARutRecargo);$x++)
			{
				if (substr($SARutRecargo,$x,2) == "~~")
				{
					$SA = substr($SARutRecargo,0,$x);			
					$RutRecargo=substr($SARutRecargo,$x+2,strlen($SARutRecargo));
					for ($y=0;$y<=strlen($RutRecargo);$y++)
					{
						if (substr($RutRecargo,$y,2) == "||")
						{
							$Rut = substr($RutRecargo,0,$y);
							$Recargo=substr($RutRecargo,$y+2,strlen($RutRecargo));
							$Criterio=$Criterio."(nro_solicitud =".$SA." and rut_funcionario='".$Rut."' and recargo='".$Recargo."') or ";   							
						}	
					}
				}
			}	
			$ValoresSA = substr($ValoresSA,$j + 2);
			$j = 0;
		}
	}			
	$Criterio = substr($Criterio,0,strlen($Criterio)-3);
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Solicitudes)
{
	var Frm=document.FrmIngresoPesoRetalla;
	var ValoresSA="";
	var Valores="";
	var Valor="";
	
	ValoresSA=Solicitudes;
	for(i=1;i<Frm.TxtPesoRetalla.length;i++)
	{
		Valor=Frm.TxtPesoRetalla[i].value.toUpperCase();
		if (isNaN(Number(Frm.TxtPesoRetalla[i].value.replace(",",".")))) 
		{
			if ((Valor!="ND") && (Valor!=""))
			{
				alert("Valor Ingresado no es Valido");
				Frm.TxtPesoRetalla[i].focus();
				return;
			}		
		}
		if (Valor!="")
		{
			Valores=Valores+Frm.TxtNroSA[i].value +"~~"+Frm.TxtPesoRetalla[i].value+"//";
		}		
	}
	if (Valores!="")
	{
		Frm.action="cal_ingreso_peso_retalla01.php?ValoresSA="+ValoresSA+"&Valores="+Valores;
		Frm.submit();
	}
}
function Salir(Valores)
{
	var Frm=document.FrmIngresoPesoRetalla;
	ValoresSA=Solicitudes;
	Frm.window.close();
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngresoPesoRetalla" method="post" action="">
  <table width="330" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="315" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Ingreso Peso Tamiz</div></td>
          </tr>
        </table>
		<br>
        <table width="315" border="0" cellpadding="5" class="TablaInterior">
          <tr>
            <td width="301">Quimico:
			<?php  
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
			?>						
			</td>
          </tr>
        </table><br>
            <table width="315" height="51" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01" align="center"> 
            <td width="78" >Solicitud</td>
            <td width="79" >Peso Retalla</td>
            <td width="118">Peso Tamiz</td>
          </tr>
          <?php
        	$Consulta ="select distinct nro_solicitud,peso_muestra,peso_retalla from cal_web.solicitud_analisis where ".$Criterio." order by nro_solicitud";
			$Respuesta=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='TxtNroSA'><input type='hidden' name ='TxtPesoRetalla'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr align='center'>";
				echo "<td height='28'><input type='text' name='TxtNroSA' style='width:100' disabled value = ".$Fila["nro_solicitud"]."></td>";
				echo "<td height='28'><input type='text' name='TxtPesoMuestra' style='width:75' disabled value = ".$Fila["peso_muestra"]."></td>";
				echo "<td height='28'><input type='text' name='TxtPesoRetalla' style='width:75' value = ".$Fila["peso_retalla"]."></td>";
				echo "</tr>";
			}
		  ?>
          </table>
      <br>
      <table width="315" border="0" cellpadding="5">
          <tr>
          <td width="144"><div align="right">
              <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Solicitudes;?>');">
            </div></td>
          <td width="148"><input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
        </tr>
      </table> </td>
	  </tr>
	  </table>
   </form>
</body>
</html>
