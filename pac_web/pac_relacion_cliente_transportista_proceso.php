<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 3;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$EncontroCoincidencia = isset($_REQUEST["EncontroCoincidencia"])?$_REQUEST["EncontroCoincidencia"]:"";
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$Patente=substr($Datos,0,$i);
				}
			}
			$Consulta = "select t2.rut_cliente,t2.nombre as nombre_cliente,t3.rut_transportista,t3.nombre as nombre_transp,t1.nro_patente,t1.marca,t1.modelo,t1.a�o,t1.carga,t1.tara,t1.fecha_rev_tecnica,t1.fecha_cert_estanque,t1.tipo,t1.tipo2 from pac_web.camiones_por_transportista t1 inner join pac_web.clientes t2 on t1.rut_cliente=t2.rut_cliente";
			$Consulta = $Consulta." inner join pac_web.transportista t3 on t1.rut_transportista=t3.rut_transportista where nro_patente ='".$Patente."' order by t2.nombre_cliente,t3.nombre_transp";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Cliente=$Fila["nombre_cliente"];
			$RutCliente=$Fila["rut_cliente"];
			$Transportista=$Fila["nombre_transp"];
			$RutTransp=$Fila["rut_transportista"];
			$Marca=$Fila["marca"];
			$Modelo=$Fila["modelo"];
			$Ano=$Fila["año"];
			$Carga=$Fila["carga"];
			$Tara=$Fila["tara"];
			if (!is_null($Fila["fecha_rev_tecnica"]))
			{
				$AnoRT=substr($Fila["fecha_rev_tecnica"],0,4);
				$MesRT=substr($Fila["fecha_rev_tecnica"],5,2);
				$DiaRT=substr($Fila["fecha_rev_tecnica"],8,2);
			}
			else
			{
				$AnoRT=date("Y");
				$MesRT=date("n");
				$DiaRT=date("j");
			}
			if (!is_null($Fila["fecha_cert_estanque"]))
			{
				$AnoCE=substr($Fila["fecha_cert_estanque"],0,4);
				$MesCE=substr($Fila["fecha_cert_estanque"],5,2);
				$DiaCE=substr($Fila["fecha_cert_estanque"],8,2);
			}
			else
			{
				$AnoCE=date("Y");
				$MesCE=date("n");
				$DiaCE=date("j");
			}
			$TipoTransp=$Fila["tipo"];
			$Tipo2=$Fila["tipo2"];	
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">

function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	var Tipo='';
	var Validar='S';
	
	if (Proceso=='N')
	{
		if (Frm.CmbCliente.value == "-1")
		{
			alert("Debe Seleccionar Cliente")
			Frm.CmbCliente.focus();
			return;
		}
		if (Frm.CmbTransp.value == "-1")
		{
			alert("Debe Seleccionar Transportista")
			Frm.CmbTransp.focus();
			return;
		}
	}
	Frm.action="pac_relacion_cliente_transportista_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&Tipo="+Tipo;
	Frm.submit();
	
}
function Recarga(Opcion,Proceso)
{
	var Frm=document.FrmProceso;
	Frm.action="pac_relacion_cliente_transportista_proceso.php?TipoTransp="+Opcion+"&Proceso="+Proceso;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.CmbCliente.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="140"></td>
            <td width="229"> 
            </td>
          </tr>
          <tr> 
            <td>Cliente</td>
            <td> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='hidden' name ='TxtRutCliente' value =".$RutCliente.">";
						echo $RutCliente."  ".strtoupper($Cliente);
					}
					else
					{
						echo "<select name='CmbCliente'>";
						echo "<option value ='-1' selected>Seleccionar</option>";
						$Consulta="select rut_cliente,nombre,corr_interno_cliente from clientes order by nombre";
						$Respuesta=mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<option value ='".$Fila["rut_cliente"]."~".$Fila["corr_interno_cliente"]."'>".$Fila["rut_cliente"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						}
               			echo "</select>";

					}	
				?>
            </td>
          </tr>
          <tr> 
            <td>Transp.</td>
            <td> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='hidden' name ='TxtRutTransp' value =".$RutTransp.">";
						echo $RutTransp."  ".strtoupper($Transportista);
					}
					else
					{
						echo "<select name='CmbTransp'>";
						echo "<option value ='-1' selected>Seleccionar</option> ";
						$Consulta="select rut_transportista,nombre from transportista order by nombre";
						$Respuesta=mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<option value ='".$Fila["rut_transportista"]."'>".$Fila["rut_transportista"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						}
						echo "</select>";
					}	
				?>
			<TD>
          </tr>
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr>
		  <td  align='center' width='509'>
		  <?php
				echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:60' onClick=Grabar('$Proceso','$Valores');>";
		  ?> 
		  <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">&nbsp;</td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
<?php
	if ($EncontroCoincidencia!="")
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('Relacion Ya Existe');";
			echo "Frm.CmbCliente.focus();";
			echo "</script>";
		}
	}
?>
