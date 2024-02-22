<?php 	
	$CodigoDeSistema = 3;

	include("../principal/conectar_sec_web.php");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");$datos = explode("//",$Valores);	
?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_conf_inicial_lotes.php?Mostrar="+Frm.Mostrar01.value+"&CmbCodBulto="+Frm.MesBulto.value +"&Mes="+Frm.MesBulto.value+"&NumBulto="+Frm.NumBulto01.value+"&Mes1="+Frm.MesPaquete.value+"&NumPaqueteI="+Frm.NumPaqueteI01.value+"&NumPaqueteF="+Frm.NumPaqueteF01.value;
	Frm.submit();
}
function Recarga()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_conf_inicial_lotes_proceso.php?Proceso="+P +"&CmbMes="+M;
	Frm.submit();
}
function Recarga2(URL,LimiteIni,Cont2)
{
	var frm=document.frmPrincipal;
	
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni;
	frm.submit(); 
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmProceso" method="post" action="">
<input name="Mostrar01" type="hidden" value="<?php echo $Mostrar  ?>">
<input name="MesBulto" type="hidden" value="<?php echo $Mes  ?>">
<input name="MesPaquete" type="hidden" value="<?php echo $Mes1  ?>">
<input name="NumBulto01" type="hidden" value="<?php echo $NumBulto01  ?>"> 
<input name="NumPaqueteI01" type="hidden" value="<?php echo $NumPaqueteI  ?>"> 
<input name="NumPaqueteF01" type="hidden" value="<?php echo $NumPaqueteF  ?>"> 
<?php
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 50;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">

<?php include("../principal/encabezado.php")?>
  <table width="769" height="330px" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="757"><div style="position:absolute; left: 16px; width: 730px; height: 26px; top: 78px;" id="div3"> 
          <table width="757" border="0" class="tablainterior">
            <tr> 
              <td align="right" width="233">&nbsp; </td>
              <td align="left" width="487"> 
                <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();"></td>
            </tr>
          </table>
        </div>
        <div style="position:absolute; left: 17px; top: 109px; width: 730px; height: 30px;" id="div1"> 
          <table width="757" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="74"> <div align="left"></div>
                <div align="left"></div>
                <div align="left">#Paquete</div></td>
              <td width="50">unidad</td>
              <td width="46">Peso</td>
              <td width="69">#Paquete</td>
              <td width="45">unidad</td>
              <td width="49">Peso</td>
              <td width="78"><div align="center">#Paquete</div></td>
              <td width="38"><div align="center">unidad</div></td>
              <td width="39">Peso</td>
              <td width="73">#Paquete</td>
              <td width="44">unidad</td>
              <td width="50">Peso</td>
            </tr>
          </table>
        </div>
        <br>
		<br>
        <div style="position:absolute; left: 15px; top: 136px; width: 770px; height: 257px; OVERFLOW: auto;" id="div2"> 
          <?php
		
		echo "<table width='750px' border='1' cellpadding='3' cellspacing='1' bordercolor='#b26c4a'>";
		echo "<tr>";
		$cont=1;
		$Cont2=0;	 
		$Consulta=" SELECT * from sec_web.paquete_catodo t1 ";
		$Consulta.=" left join sec_web.lote_catodo t2 ";
		$Consulta.=" on t1.cod_paquete=t2.cod_paquete ";
		$Consulta.=" and t1.num_paquete=t2.num_paquete  and ";
		$Consulta.=" t1.cod_estado=t2.cod_estado ";
		$Consulta.=" where t1.cod_estado='a' ";
		$Consulta.=" and  isnull(t2.cod_bulto) order by t1.cod_paquete,t1.num_paquete 				";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			if($cont==5) 
			{
				echo '</tr>';
				echo '<tr>';
				$cont=1;
			}
			echo '<td>';
			echo $Fila["cod_paquete"]."-".$Fila["num_paquete"];
			echo '</td>';
			echo '<td>';
			echo $Fila["num_unidades"];
			echo '</td>';
			echo '<td>';
			echo $Fila["peso_paquetes"];
			echo '</td>';
			$cont =$cont+ 1;
		}
		
		/*$Consulta="SELECT * from sec_web.paquete_catodo where  cod_estado ='a' order by cod_paquete,num_paquete" ;
		$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			if($cont==5) 
			{
				echo '</tr>';
				echo '<tr>';
				$cont=1;
			}
				$Consulta="SELECT * from sec_web.lote_catodo ";
				$Consulta.=" where cod_paquete='".$Fila["cod_paquete"]."' and num_paquete='".$Fila["num_paquete"]."' and cod_estado='a'";
				$Respuesta1=mysqli_query($link, $Consulta);
				if($Fila1=mysqli_fetch_array($Respuesta1))
				{
					//nada
				}
				else
				{
					$Consulta="SELECT * from sec_web.paquete_catodo ";
					$Consulta.=" where cod_paquete='".$Fila["cod_paquete"]."' and num_paquete='".$Fila["num_paquete"]."' and cod_estado ='a' order by cod_paquete,num_paquete";
					$Respuesta2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Respuesta2);
					echo '<td>';
					echo $Fila["cod_paquete"]."-".$Fila["num_paquete"];
					echo '</td>';
					echo '<td>';
					echo $Fila2["num_unidades"];
					echo '</td>';
					echo '<td>';
					echo $Fila2["peso_paquetes"];
					echo '</td>';
					$cont =$cont+ 1;
					$Cont2=$Cont2+1;
				}
		}*/
		echo "</table>";
		?>
        </div>
	    
      </td>
  </tr>
</table>
   <?php include("../principal/pie_pagina.php")?>
  </form>
</body>
</html>
