<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 12;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function Salir()
{
	var Frm=document.FrmProgLoteo;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
	
}
</script>
<title>Programa de Loteo Enami - Codelco</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="350" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <div style="position:absolute; left: 15px; top: 55px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0">
	  <tr>
	  <?php
			echo "<td align='left'>";
			echo "</td>";
	  ?>
	  </tr>
	  </table></div><br>
	  <div style="position:absolute; left: 15px; top: 85px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
		    <td width='120' align="center">Fecha Programa</td>
			<td width='70' align="center">Cod.Nave</td>
			<td width='200' align="center">Nave</td>
			<td width='70' align="center">Cod.Puerto</td>
			<td width='200' align="center">Puerto.</td>
	      </tr>
        </table></div>
		<div style="position:absolute; left: 15px; top: 105px; width: 750px; height: 255px; OVERFLOW: auto;" id="div2">
		<?php
			//CONSULTA TABLA PROGRAMA ENAMI
			$Consulta="select t1.eta_embarque,t1.cod_nave,t4.cod_puerto_destino,t4.nom_aero_puerto as pto_destino,t5.sigla_cliente,";
			$Consulta=$Consulta." from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
			$Consulta=$Consulta." where t1.estado2 <>'C' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo))) group by t1.eta_embarque,cod_cliente";
			echo $Consulta;
			$Respuesta=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckSeleccion'><input type='hidden' name ='NumProgLoteo'><input type='hidden' name='CheckFecha'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td width='120'>".$Fila[eta_embarque]."&nbsp;</td>";
				echo "<td width='70' align='center'>".$Fila["cod_cliente"]."</td>";
				echo "<td width='200' align='right'>".$Fila["sigla_cliente"]."</td>";
				echo "<td width='70' align='right'>".$Fila["cod_nave"]."&nbsp;</td>";
				echo "<td width='200' align='right'>".$Fila[pto_puerto_destino]."&nbsp;</td>";
				echo "</tr>";
			}
			echo "</table>";	
		?>
		</div>
        <br>
		<div style="position:absolute; left: 15px; top: 370px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
        <table width="730" border="0" class="tablainterior">
          <tr>
              <td align="center"> 
                <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
			</td>
          </tr>
        </table></div><br></td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if (isset($EncontroRelacion))
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."');";	
		echo "</script>";
	}
?>
