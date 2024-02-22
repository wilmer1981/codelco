<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =11;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	window.close();
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmProceso" method="post" action="">


 <table width="500" border="1" align="center" cellpadding="3" cellspacing="0"  class="TablaDetalle">
 	<tr class="ColorTabla02"> 
   <td width="100"><strong>PUERTO/NAVE :</strong> 
<?php
	$Consulta = "SELECT nom_aero_puerto from sec_web.puertos ";
	$Consulta.= " where cod_puerto = '".$puerto."'";
	$Resp = mysqli_query($link, $Consulta);
	
	if ($Fila3=mysqli_fetch_array($Resp))
	{
		$Consulta = "SELECT nombre_nave from sec_web.nave ";
		$Consulta.= " where cod_nave = '".$nave."'";
		$Resp1 = mysqli_query($link, $Consulta);
		if ($Fila4=mysqli_fetch_array($Resp1))
		{
		   echo "<td>".$Fila3["nom_aero_puerto"]."&nbsp;&nbsp;".$Fila4["nombre_nave"]."</td>";
		}
	}	
?>
</td>
	</tr>
	</table>
	<BR>
 <table width="500" border="1" align="center" cellpadding="5" cellspacing="0"  class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="74"><div align="center">Fecha Guia</div></td>
              <td width="70"><div align="center">Inst.Emb.</div></td>
              <td width="180" align="center">Chofer</div></td>
              <td width="70"><div align="center">Camiones</div></td>
              <td width="84" align="left"><div align="center">Numero Gu�a</div></td>
            </tr>
  </table>
       
          <?php
  		echo "<table width='500' border='1' align='center' cellpadding='5' cellspacing='0'>";
		$ContGuia= 0;
		$Camiones1=0;
		$Patente_ant='';
		$Fecha_ant ='';
	 $FechaAux = $FechaInicio;
	while ($FechaInicio<= $FechaTermino)  
	{
		$Consulta = "SELECT  t2.fecha_guia,t2.num_guia, t2.patente_guia, t1.corr_enm,t2.rut_chofer,t3.nombre_persona";
  		$Consulta.= " from sec_web.embarque_ventana  t1, sec_web.guia_despacho_emb t2,sec_web.persona t3";
		$Consulta.= " where t1.cod_puerto = '".$puerto."'  and t2.fecha_guia ='".$FechaInicio."' and t1.cod_nave = '".$nave."' ";
		$Consulta.= " and t1.corr_enm = t2.corr_enm  and t2.cod_estado <> 'A'  and t2.rut_chofer = t3.rut_persona and t2.corr_enm <9999";
		$Consulta.= " and t1.cod_puerto != '' order by t2.fecha_guia,t2.patente_guia";
	//echo "RR".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		
		while  ($Fila=mysqli_fetch_array($Respuesta))
		{
			$ContGuia = $ContGuia + 1;
			$Camiones1 = $Camiones1 + 1;
			//$ContCamiones = $ContCamiones +1;
			if ($Fila[patente_guia] == $Patente_ant )
			{
				echo "<tr bgcolor=\"#F9900\">";
				$Camiones1 = $Camiones1 - 1;
			}
			echo "<td width='74'>".$Fila[fecha_guia]."</td>";

			echo "<td width='70'>".$Fila["corr_enm"]."</td>";
			$Patente_ant = $Fila[patente_guia];
			
			echo "<td width='180'>".$Fila[nombre_persona]."</td>";
			echo "<td width='70'>".$Fila[patente_guia]."</td>";
			echo "<td width='84'>".$Fila["num_guia"]."</td>";
			echo "</tr>";
		}
		$consulta = "SELECT DATE_ADD('".$FechaInicio."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$FechaInicio = $row10["fecha"];
						
	}
	
	
		$Consulta=" SELECT  count(patente_camion) as camiones";
 		$Consulta.=" from sec_web.tmpcamiones where puerto_camion = '".$puerto."' and nave_camion=  '".$nave."'";
		$rs100 = mysqli_query($link, $Consulta);
		$row100 = mysqli_fetch_array($rs100);
		$Camiones = $row100[camiones]; 
		
		echo "</table>";
		?>
          <br>
         <table width="500" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="74"><div align="left">TOTAL</div></td>
              <?php 
			  	
				echo "<td>&nbsp;</td>\n";  
				if ($Camiones1 <> $Camiones)
					echo "<td width='80'align='center'> ".$Camiones." </td>";
				else
					echo "<td width='80'align='center'> ".$Camiones1." </td>";	
				echo "<td width='84' align='center'> ".$ContGuia." </td>";
			?>
            </tr>
          </table>
          <table width="500" border="0" align="center" class="TablaInterior">
            <tr> 
              <td width="500"  align="center"> 
                <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              </td>
            </tr>
          </table></td>


	

	
</form>
</body>
</html>
