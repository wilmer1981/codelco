<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 1;
	include("../principal/conectar_principal.php");
	$datos = explode("//",$Valores);	
	$Consulta="select *,t2.cod_subclase from sec_web.lote_catodo t1  ";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase =3004 and t1.cod_bulto=t2.nombre_subclase	";
	$Consulta.=" where t1.cod_bulto='".$datos[0]."' and t1.num_bulto='".$datos[1]."' and ";
	$Consulta.=" t1.cod_paquete='".$datos[2]."' and t1.num_paquete='".$datos[3]."' and t1.fecha_creacion_lote='".$datos[4]."' ";															
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$CodBulto=$Fila["cod_bulto"];
	$NumBulto=$Fila["num_bulto"];
	$NumPaquete=$Fila["num_paquete"];
	/*datos = explode("&&",$Valores);	
	while(list($c,$v) = each($datos)) 
	{
		$arreglo=explode("//",$datos)
		$arreglo[0]
	}*/
?>
<html>
<head>
<script language="JavaScript">
function Asignar()
{
	var frm=document.FrmProceso;
	var LargoForm = frm.elements.length;
    var CheckeoPaquete=false;
	var ValoresPaquetes="";
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name =="CheckPaquete") && (frm.elements[i].checked == true))
		{
			CheckeoPaquete= true;
			ValoresPaquetes = ValoresPaquetes + frm.elements[i].value + "@@";
		}
	}
	frm.action="sec_conf_inicial_lotes_proceso01.php?Proceso=Asignar&Valores="+ValoresPaquetes+"&CodBulto="+frm.CodBulto.value+"&NumBulto="+frm.NumBulto.value ;
	alert(frm.action);
	frm.submit();
}
function Salir()
{
	//window.close();
}
function Recarga()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_conf_inicial_lotes_proceso.php?Proceso="+P +"&CmbMes="+M;
	Frm.submit();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmProceso" method="post" action="">
  <table width="437" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="425"><table width="418" border="0" >
          <tr> 
            <td width="107"><font size="2">&nbsp; </font><font size="1"><font size="2"><font size="1"><font size="2"><font size="2"> 
              </font></font></font></font></font></td>
            <td colspan="3">Detalle Paquetes Disponibles</td>
            <td width="111"> </font></font></font>
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp; </td>
            <td>&nbsp; </td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
            <td colspan="3">&nbsp; </td>
          </tr>
        </table>
        <?php
		echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
		echo "<tr>";
		$cont=1;	 
		$Consulta="select * from sec_web.paquete_catodo " ;
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			if($cont==5) 
			{
				echo '</tr>';
				echo '<tr>';
				$cont=1;
			}
				$Consulta="select * from sec_web.lote_catodo ";
				$Consulta.=" where cod_paquete='".$Fila["cod_paquete"]."' and num_paquete='".$Fila["num_paquete"]."' ";
				$Respuesta1=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if($Fila1=mysqli_fetch_array($Respuesta1))
				{
					//nada
				}
				else
				{
					echo "<td width='150' align='left'><input type='checkbox' name ='CheckPaquete' value='".$Fila["cod_paquete"]."//".$Fila["num_paquete"]."'>".$Fila["cod_paquete"]."-".$Fila["num_paquete"];
					echo '</td>';
					$cont =$cont+ 1;
				}
		}
		echo "</table>";
		?>
		
		
		<br>
        <table width="416" border="0">
          <tr> 
            <td  align="center" width="410">&nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
