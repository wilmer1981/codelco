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
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	Frm.action="sec_conf_inicial_lotes_proceso01.php?Proceso="+Proceso+"&CodBulto="+Frm.CmbCodBulto.value+"&NumBulto="+Frm.NumBulto.value+"&CodPaqueteI="+Frm.CmbCodPaqueteI.value +"&NumPaqueteI="+Frm.NumPaqueteI.value +"&NumPaqueteF="+Frm.NumPaqueteF.value+"&Marca="+Frm.Marca.value+"&ENM="+Frm.ENM.value+"&Estado="+Frm.CmbEstado.value;
	Frm.submit();
}
function Salir()
{
	window.close();
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
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" >
          <tr> 
            <td width="111"><font size="2">&nbsp; </font><font size="1"><font size="2"><font size="1"><font size="2"><font size="2">
              </font></font></font></font></font></td>
            <td colspan="3">Confeccion Inicial de Lotes</td>
            <td width="114">
              </font></font></font></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2">N&deg; Serie Inicial Lote</td>
            <td colspan="3">
			<select name="CmbCodBulto">
			<?php
			$Consulta=" select MONTH(NOW()) as mes ";
			$Respuesta1=mysqli_query($link, ($Consulta));
			$Fila1=mysqli_fetch_array($Respuesta1);
			$Consulta="select * from proyecto_modernizacion.sub_clase ";
			$Consulta.=" where cod_clase='3004' and cod_subclase between 1 and 12   ";
           	$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbCodBulto==$Fila1[mes])
				{
					echo "<option value=".$Fila["nombre_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
				}
				else
				{
					echo "<option value=".$Fila["nombre_subclase"].">".$Fila["nombre_subclase"]."</option>";	
				}
			}
		    ?>
			  </select>
              -
              <input name="NumBulto" type="text" id="NumBulto" value="<?php echo $NumBulto; ?>"> </td>
          </tr>
          <tr> 
		 
            <td colspan="2">N&deg; Serie Inicial Sub -Lote</td>
            <td colspan="3"> <select name="CmbCodPaqueteI">
			<?php
			$Consulta=" select MONTH(NOW()) as mes ";
			$Respuesta1=mysqli_query($link, ($Consulta));
			$Fila1=mysqli_fetch_array($Respuesta1);
			$Consulta="select * from proyecto_modernizacion.sub_clase ";
			$Consulta.=" where cod_clase='3004' and cod_subclase between 1 and 12   ";
           	$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbCodPaqueteI==$Fila1[mes])
				{
					echo "<option value=".$Fila["nombre_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
				}
				else
				{
					echo "<option value=".$Fila["nombre_subclase"].">".$Fila["nombre_subclase"]."</option>";	
				}
			}
		    ?>
              </select>
              - 
              <input name="NumPaqueteI" type="text" id="NumPaqueteI" value="<?php  echo $NumPaqueteI;  ?>"></td>
          </tr>
          <tr> 
            <td colspan="2">N&deg; Serie Final Sub -Lote</td>
            <td colspan="3"> 
              <input name="NumPaqueteF" type="text" id="NumPaqueteF" value="<?php   echo $NumPaqueteF;  ?>"></td>
          </tr>
          <tr> 
            <td colspan="2">Marca</td>
            <td colspan="3"><input name="Marca" type="text" id="Marca" value="<?php  echo $Marca;  ?>"></td>
          </tr>
          <tr> 
            <td colspan="2">ENM</td>
            <td colspan="3"><input name="ENM" type="text" id="ENM" value="<?php  echo $ENM;     ?>"></td>
          </tr>
          <tr> 
            <td colspan="2">Estado</td>
            <td colspan="3">
				<select name="CmbEstado">
				<?php
				$Consulta="select * from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='3003' and (cod_subclase='2' or cod_subclase='4')";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					
					if ($CmbEstado == $Fila["cod_subclase"])
					{
						echo "<option value='".$Fila["valor_subclase1"]."' selected>".$Fila["nombre_subclase"]."</option>";
					}
					else
					{
						echo "<option value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>";
					}
				}
				
				?>
              
			  
			  </select>
              &nbsp; </td>
          </tr>
        </table>
        <br>
        <table width="395" border="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
