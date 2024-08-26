<?php 	
	include("../principal/conectar_principal.php");

	$FechaInicio  = isset($_REQUEST["FechaInicio"])?$_REQUEST["FechaInicio"]:"";
	$FechaTermino = isset($_REQUEST["FechaTermino"])?$_REQUEST["FechaTermino"]:"";

?>
<html>
<head>
<title>Orden de Embarque</title>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmProceso;
	switch (opt)
	{
		case "S":
			window.close();
		break;
	}
}	
function MostrarDetalle(puerto,nave,enm,FechaInicio,FechaTermino,Camiones)
{

	window.open("sec_camiones_detalle.php?puerto="+puerto+"&nave="+nave+"&enm="+enm+"&Camiones="+Camiones+"&FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino,"","top=200,left=20,width=550,height=400,scrollbars=yes,resizable = yes");

}  
</script>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmProceso" method="post" action="">



    <td width="628"><table width="627" border="0" align="center" cellpadding="1" cellspacing="1" class="TablaInterior">
        <tr> 
          <td colspan="6"> <div align="center"> 
              <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
            </div></td>
        </tr>
		<br>
        <tr> 
        <td width="225" align="center"><strong>Detalle Camiones a Puerto CODELCO</strong></td>		
          <td width="45"><strong> Periodo: </strong></td>
          <td width="59"><strong><?php echo $FechaInicio ?></strong>   </td>
		  <td width="28"> <strong>Al</strong> </td>
		  <td width="251"><strong><?php echo $FechaTermino ?> </strong>   </td>
       
	

</table>
<br>
 
<table width="500" border="1" align="center" cellpadding="3" cellspacing="1"  class="TablaDetalle">
        <tr class="ColorTabla01"> 
			<td width="119" align="center">Puerto</td>
        	<td width="119" align="center">Moto Nave</td>
			<td width="100" align="center">Asignaci&oacute;n</td>
          	<td width="70" align="center">Camiones</td>
          
        </tr>
        <?php  
	    $cont = 0;
		$cont1 = 0;
		$Eliminar="drop table sec_web.tmpcamiones";
		//$Eliminar="delete from sec_web.tmpcamiones";
		mysqli_query($link, $Eliminar);
					//creo tabla de Paso   
		$CrearTmp="create table sec_web.tmpcamiones "; 
		$CrearTmp.=" (fecha_camion varchar(10),patente_camion varchar(10),nave_camion varchar(4),asignacion varchar(30),puerto_camion varchar(10),hora_camion time,enm_camion int(10))";
		mysqli_query($link, $CrearTmp);
		//echo "RR".$CrearTmp;
		$Eliminar="delete from sec_web.tmpcamiones";
		
		$Consulta = "SELECT distinct  puerto from sec_web.tmp_despacho_diario";
		$Consulta.= " where enm < 9999 and puerto != '' order by puerto desc";
		$Resp100= mysqli_query($link, $Consulta);
		//$TotalCamiones = 0;//WSO
		while ($Row1 = mysqli_fetch_array($Resp100))
		{
			//$TotalCamiones = 0;
			$Consulta = "SELECT  t2.fecha_guia,t2.patente_guia,t2.hora_guia,t1.cod_nave,t1.cod_puerto,t1.corr_enm";
  			$Consulta.= " from sec_web.embarque_ventana  t1, sec_web.guia_despacho_emb t2 ";
			$Consulta.= " where t1.cod_puerto = '".$Row1["puerto"]."'  and t2.fecha_guia between  '".$FechaInicio."' and '".$FechaTermino."' ";
			$Consulta.= " and t1.corr_enm = t2.corr_enm  and t2.cod_estado <> 'A'   and t2.corr_enm <9999 ";
			$Consulta.=" order by t2.fecha_guia,t2.patente_guia,t1.cod_nave";
		   //	echo "CC".$Consulta."<br>";		
			$Resp200 = mysqli_query($link, $Consulta);
			while ($Row11 = mysqli_fetch_array($Resp200))
			{
				$a=0;
				$horas1 = 0;
				$horas2 = 0;
				$Consulta = "SELECT *  from sec_web.tmpcamiones";
				$Consulta.= " where fecha_camion = '".$Row11["fecha_guia"]."' and patente_camion ='".$Row11["patente_guia"]."'";
				//echo "QQ".$Consulta."<br";
			//echo "WWW".$Row11["fecha_guia"]."--".$Row11["patente_guia"]."---".$Row11["cod_nave"]."<br>";			
				$Resp300 = mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Resp300))
				{
					if ($Row11["cod_puerto"] == 'LX1')
					{
						$hora1 = substr($Fila2["hora_camion"],0,2);
						$hora2 = substr($Row11["hora_guia"],0,2);
					
						if (abs($hora1 - $hora2) > 3)
							$a = 0;
						else  
							$a = 1;
					}
					else
					{
						$hora1 = substr($Fila2["hora_camion"],0,2);
						$hora2 = substr($Row11["hora_guia"],0,2);
					
						if (abs($hora1 - $hora2) > 5)
							$a = 0;
						else  
							$a = 1;
					}
					$cont1 = $cont1 + 1;    	
					//$a=1;
				}
				if ($a==0)
				{
				
				$Consulta = "SELECT nave,asignacion from sec_web.tmp_despacho_diario";
				$Consulta.= " where  puerto = '".$Row1["puerto"]."' and nave = '".$Row11["cod_nave"]."' and enm < 9999 ";
				$Consulta.= " and enm = '".$Row11["corr_enm"]."'  group by nave, asignacion";
			//	echo "AA".$Consulta."<br>";  
				$Resp1000= mysqli_query($link, $Consulta);
				if ($Row20 = mysqli_fetch_array($Resp1000))
				{
					$Asignacion = $Row20["asignacion"];
				}
					//if ($Row11["cod_nave"] == '1244')
					//echo "SSS".$Row20["asignacion"]."<br>";
					$Insertar= "insert into sec_web.tmpcamiones(fecha_camion,patente_camion,nave_camion,asignacion,puerto_camion,hora_camion,enm_camion) values(";
					$Insertar.= " '".$Row11["fecha_guia"]."','".$Row11["patente_guia"]."','".$Row11["cod_nave"]."','".$Asignacion."','".$Row11["cod_puerto"]."','".$Row11["hora_guia"]."','".$Row11["corr_enm"]."')";
					mysqli_query($link, $Insertar);
					//echo "QQ".$Insertar."<br>";
					$cont = $cont + 1;
				}
			}	
		}
		$Consulta ="SELECT distinct puerto_camion  from sec_web.tmpcamiones  order by puerto_camion";
		$RespuestaC = mysqli_query($link, $Consulta);
		//echo "RRRR".$Consulta;
		$TotalCamiones = 0;
		while($Fila4=mysqli_fetch_array($RespuestaC))
		{
			$TotalPuerto =0;			
			$Consulta = "SELECT nom_aero_puerto from sec_web.puertos"; 
			$Consulta.= " where cod_puerto = '".$Fila4["puerto_camion"]."'";
			$Respuesta1 = mysqli_query($link, $Consulta);
			//echo "EEEE".$Consulta;
			while($Fila3=mysqli_fetch_array($Respuesta1))
			{
				echo "<tr>\n";
				echo "<td>".$Fila3["nom_aero_puerto"]."&nbsp;</td>\n";
				$puerto = $Fila4["puerto_camion"];
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "</tr>\n";			
				$Consulta = "SELECT distinct  nave_camion";
				$Consulta.= " from sec_web.tmpcamiones";
				$Consulta.= " where puerto_camion =  '".$Fila4["puerto_camion"]."'";
				$Consulta.= " order by nave_camion";
				//echo "Neeeeeeeeee".$Consulta;
				$RespuestaN = mysqli_query($link, $Consulta);
				while($FilaN=mysqli_fetch_array($RespuestaN))
				{
					$Consulta = "SELECT nombre_nave, cod_nave from sec_web.nave";
					$Consulta.= " where cod_nave = '".$FilaN["nave_camion"]."'";
				//	echo "NAVE".$Consulta;
				
					$RespNave = mysqli_query($link, $Consulta);
					$FilaNave=mysqli_fetch_array($RespNave);
					echo "<tr>\n";
					echo "<td>&nbsp;</td>\n";
					//echo "RR".$FilaN["enm_camion"];
					echo "<td width='180' align='left'> <a href=\"JavaScript:MostrarDetalle('".$Fila4["puerto_camion"]."','".$FilaNave["cod_nave"]."','".$FilaN["enm_camion"]."','".$FechaInicio."','".$FechaTermino."','".$Camiones."')\">\n";
					echo $FilaNave["nombre_nave"]."</a></td>\n";
					echo "<td>&nbsp;</td>\n";
					echo "<td>&nbsp;</td>\n";
					echo "</tr>\n";
					$TotalCamionesNave=0;
					$Consulta = "SELECT distinct nave_camion,asignacion, count(patente_camion) as camiones";
					$Consulta.= " from sec_web.tmpcamiones ";
					$Consulta.= " where puerto_camion = '".$Fila4["puerto_camion"]."' and nave_camion = '".$FilaNave["cod_nave"]."'";
					$Consulta.= " group by nave_camion, asignacion";
			//		echo "OO".$Consulta;
					$Respasig= mysqli_query($link, $Consulta);
					while ($Filaasig = mysqli_fetch_array($Respasig))
					{
						echo "<tr>\n";
						echo "<td>&nbsp;</td>\n";
						echo "<td>&nbsp;</td>\n";
						echo "<td>".$Filaasig["asignacion"]."&nbsp;</td>\n";
						echo "<td align='right'>".number_format($Filaasig["camiones"],0,",",".")."</td>\n";
						echo "</tr>\n";
						$TotalCamionesNave = $TotalCamionesNave + $Filaasig["camiones"]; 
						$TotalCamiones     = $TotalCamiones + $Filaasig["camiones"];
						$TotalPuerto       = $TotalPuerto +  $Filaasig["camiones"];
					}
					
					echo "<tr>";
					echo "<tr class='ColorTabla02'>";
				//	echo "<td>&nbsp;</td>\n";
					echo "<td align'left' colspan='3'<strong>CAMIONES NAVE</srtong></td>\n";
					echo "<td align='right'>".number_format($TotalCamionesNave,0,",",".")."</td>\n";	
					echo "</tr>";
				//echo "TT".$TotalCamionesNave;	
				}				
			}			
			echo "</tr>";
			echo "<tr class='ColorTabla01'>";
			echo "<td align'left' colspan='3'<strong>CAMIONES PUERTO</srtong></td>\n";
			echo "<td align='right'>".number_format($TotalPuerto,0,",",".")."</td>\n";
			 
		}			
		/*	echo "</tr>";
			echo "<tr class='ColorTabla01'>";
			echo "<td align'left' colspan='3'<strong>CAMIONES PUERTO</srtong></td>\n";
			echo "<td align='right'>".number_format($TotalPuerto,0,",",".")."</td>\n";
		}*/
		
      ?>
	  
	<tr class="ColorTabla02"> 
    	<td align="left" colspan="3"><strong>TOTAL CAMIONES</strong></td>
     	<td align="right"><strong><?php echo number_format($TotalCamiones,0,",","."); ?></strong></td>	  
   	</tr>
</table></td>
</form>
</body>
</html>