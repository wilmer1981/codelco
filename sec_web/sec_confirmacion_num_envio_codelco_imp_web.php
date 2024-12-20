<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 20;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
		
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$Tipo = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
		
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$FechaProgramada=$Datos2[0];
		$CodNave= isset($Datos2[1])?$Datos2[1]:"";
		$NombreNave=isset($Datos2[2])?$Datos2[2]:"";
		$CodAgAduanero=isset($Datos2[3])?$Datos2[3]:"";
		$CodAgEstiva=isset($Datos2[4])?$Datos2[4]:"";
		$FechaSantiago=isset($Datos2[5])?$Datos2[5]:"";
		$FechaEmbarqueVen=isset($Datos2[6])?$Datos2[6]:"";
		$Consulta="select nombre from sec_web.prestador where cod_prestador_servicio='".$CodAgAduanero."'";
		$Respuesta=mysqli_query($link,$Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$NombreAgAduanero=isset($Fila["nombre"])?$Fila["nombre"]:"";
		$Consulta="select nombre from sec_web.prestador where cod_prestador_servicio='".$CodAgEstiva."'";
		$Respuesta=mysqli_query($link,$Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$NombreAgEstiva=isset($Fila["nombre"])?$Fila["nombre"]:"";
	}		

?>
<html>
<head>
<script language="JavaScript">
function Recarga()
{
	var Frm=document.FrmConfirmacion;
	var Tipo="";
	if(Frm.radio[0].checked)
	{
		Tipo="ConEnvio";
	
	}
	else
	{
		Tipo="SinEnvio";
	
	}
	Frm.action= "sec_confirmacion_num_envio_codelco_imp_web.php?Tipo="+Tipo;
	Frm.submit();
}


function Imprimir(opt)
{
	var f=document.FrmConfirmacion;
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	window.print();
	f.BtnImprimir.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
}

</script>
<title>Confirmacion - Codelco</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConfirmacion" method="post" action="">  
    <table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td align="center"><strong> SELECCION DE NUMERO DE ENVIO PARA DESPACHO CODELCO </strong></td>
      </tr>
    </table>
    <table width="650" border="0" align="center">
      <tr> 
        <td width="354" align="center"> ConEnvio 
		<?php
		if ($Tipo=="ConEnvio")
		{	
			echo "<input name='radio' type='radio'  value='ConEnvio' onClick='Recarga();' checked>";
	    	echo"<select name='CmbMes'  onChange='Recarga();' >";
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
			echo "</select>";
			echo "<select name='CmbAno' onChange='Recarga();'>";
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
			echo "</select>";//<input name='BtnFax' type='button' style='width:90' value='Fax' onClick=\"Fax('$Tipo');\">";
		}
		else
		{
				echo "<input name='radio' type='radio'  value='ConEnvio' onClick='Recarga();' >";
		}
		?>
		</td>
        <td width="366" align="center">
		<?php
		if ($Tipo=="SinEnvio")
			echo "<input name='radio' type='radio'  value='SinEnvio' onClick='Recarga();' checked>";
			else
				echo "<input name='radio' type='radio'  value='SinEnvio' onClick='Recarga();'>";
        ?>
		  Sin Envio </td>
      </tr>
  </table>
	    <br>	  
          <table width="650" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr align="center" class="ColorTabla01">
              <td width='30'>I.E.</td>
              <td width='41'>Envio</td>
              <td width='89'><div align="center">Cliente</div></td>
              <td width='60'>Lote</td>
              <td width='33'><div align="left">Cant.</div></td>
              <td width='35'><div align="left">Peso</div></td>
              <td width='120'>Marca</td>
              <td width='73'>Fecha.Prog</td>
			  <td width='45'>Estado</td>
			  <td width='61'>Embarque</td>
            </tr>        
  <?php			
			//CONSULTA TABLA PROGRAMA ENAMI
			if($Tipo=="ConEnvio")
			{
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$Fecha_Envio=$CmbAno."-".$CmbMes;
				$Consulta=" select distinct t1.corr_codelco,t1.cod_cliente,t2.sigla_cliente,t4.num_envio,t4.tipo_embarque,t1.fecha_programacion,t5.cod_via_transporte,    ";
				$Consulta.=" t1.fecha_disponible,t1.fecha_programacion,t1.cod_producto,t1.cod_subproducto,t2.sigla_cliente as nombre,t5.nombre_nave as nombre	";
				$Consulta.=" from sec_web.programa_codelco t1";
				$Consulta.=" left join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente ";
				$Consulta.=" inner join sec_web.lote_catodo t3 on t1.corr_codelco=t3.corr_enm	";
				$Consulta.=" inner join sec_web.embarque_ventana t4 on t1.corr_codelco=t4.corr_enm 			";
				$Consulta.=" left join sec_web.nave t5 on t1.cod_cliente=t5.cod_nave 			";
				$Consulta.=" where (t1.estado2 <> 'A')  and (not isnull(t1.num_prog_loteo)) ";
				//$Consulta.=" and left(t3.disponibilidad,1)='E' and substring(t4.fecha_envio,1,7) ='".$Fecha_Envio."'   order by t1.corr_codelco,t4.num_envio";
				$Consulta.=" and t3.disponibilidad='T' and substring(t4.fecha_envio,1,7) ='".$Fecha_Envio."'   order by t4.num_envio desc,t1.corr_codelco";				
			}
			else
			{
				$Consulta=" select distinct t1.corr_codelco,t1.cod_cliente,t2.sigla_cliente as nombre,t5.nombre_nave as nombre,t4.num_envio,t1.fecha_programacion,    ";
				$Consulta.=" t1.fecha_disponible,t1.fecha_programacion,t1.cod_producto,t1.cod_subproducto,t4.tipo_embarque		";
				$Consulta.=" from sec_web.programa_codelco t1";
				$Consulta.=" left join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente ";
				$Consulta.=" inner join sec_web.lote_catodo t3 on t1.corr_codelco=t3.corr_enm	";
				$Consulta.=" left join sec_web.embarque_ventana t4 on t1.corr_codelco=t4.corr_enm 			";
				$Consulta.=" left join sec_web.nave t5 on t1.cod_cliente=t5.cod_nave 			";
				$Consulta.=" where (t1.estado2 <> 'A')  and (not isnull(t1.num_prog_loteo)) ";
				//$Consulta.=" and left(t3.disponibilidad,1)='E' and  isnull(t4.corr_enm) order by t1.corr_codelco,t4.num_envio";
				$Consulta.=" and t3.disponibilidad='T' and  isnull(t4.corr_enm) order by t1.corr_codelco,t4.num_envio";
			}
			$Respuesta=mysqli_query($link,$Consulta);
			echo "<input type='hidden' name='OptSeleccionar'><input type='hidden' name='NumEnvioO'><input type='hidden' name='CodelcoO'><input type='hidden' name='FaxO'>";
			$Cont2=0;
			$TipoEmbarque="";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				$corr_codelco = isset($Fila["corr_codelco"])?$Fila["corr_codelco"]:"";
				$fecha_programacion = isset($Fila["fecha_programacion"])?$Fila["fecha_programacion"]:"0000-00-00"; 
				$fecha_disponible = isset($Fila["fecha_disponible"])?$Fila["fecha_disponible"]:"";
				$cod_producto = isset($Fila["cod_producto"])?$Fila["cod_producto"]:"";
				$cod_subproducto = isset($Fila["cod_subproducto"])?$Fila["cod_subproducto"]:"";
				$cod_cliente = isset($Fila["cod_cliente"])?$Fila["cod_cliente"]:"";					

				$Consulta="select t1.disponibilidad,t1.cod_estado,t3.descripcion as marca,t1.cod_bulto,t1.num_bulto,t1.cod_marca, ";
				$Consulta.=" sum(t2.peso_paquetes) as peso_preparado,sum(t1.num_paquete) as unidades from sec_web.lote_catodo   ";
				$Consulta.=" t1 inner join sec_web.paquete_catodo t2 on ";
				$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
				$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
				if($Tipo=="ConEnvio")
				{
					$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_codelco"]." group by t1.corr_enm";
				}
				else
				{
					$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_codelco"]." and t1.cod_estado='a' and t1.cod_estado = t2.cod_estado  group by t1.corr_enm";
				}	
				$Respuesta2=mysqli_query($link,$Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$peso_preparado = isset($Fila2["peso_preparado"])?$Fila2["peso_preparado"]:0;
				$cod_marca = isset($Fila2["cod_marca"])?$Fila2["cod_marca"]:"";
				$cod_bulto = isset($Fila2["cod_bulto"])?$Fila2["cod_bulto"]:"";
				$num_bulto = isset($Fila2["num_bulto"])?$Fila2["num_bulto"]:"";
				$marca = isset($Fila2["marca"])?$Fila2["marca"]:"";
				$cod_estado = isset($Fila2["cod_estado"])?$Fila2["cod_estado"]:"";
								
				$Consulta="select count(*) as cantpaquetes from sec_web.lote_catodo";
				if($Tipo=="ConEnvio")
				{
					$Consulta=$Consulta." where corr_enm=".$Fila["corr_codelco"];
				}
				else
				{
					$Consulta=$Consulta." where corr_enm=".$Fila["corr_codelco"]." and cod_estado='a'";
				}	
				$Respuesta3=mysqli_query($link,$Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3);
				$cantpaquetes   = isset($Fila3["cantpaquetes"])?$Fila3["cantpaquetes"]:0;
				
				$MostrarBoton=true;
				echo "<tr>"; 
				$Cont2++;
				$Campos=$corr_codelco."~~".$cod_bulto."~~".$num_bulto."~~".$fecha_programacion."~~";
				$Campos=$Campos.$fecha_disponible."~~".$peso_preparado."~~".$cantpaquetes."~~";
				$Campos=$Campos.$cod_marca."~~".$cod_producto."~~".$cod_subproducto."~~".$cod_cliente;				
				echo "<td align='right'>".$corr_codelco."&nbsp;</td>";
				echo "<td align='right'>".$Fila["num_envio"]."&nbsp;</td>";
				echo "<td>".$Fila["nombre"]."&nbsp;</td>";
				echo "<td align='center'>".$cod_bulto."-".$num_bulto."</a>&nbsp;</td>";
				echo "<td align='right'>".$cantpaquetes."&nbsp;</td>";
				echo "<td align='right'>".$peso_preparado."&nbsp;</td>";
				echo "<td align='left'>".$marca."&nbsp;</td>";
				echo "<td align='left'>".substr($fecha_programacion,8,2)."/".substr($fecha_programacion,5,2)."/".substr($fecha_programacion,0,4)."&nbsp;</td>";
				if ($cod_estado=='a')
					$Estado="Abierto";
				else
					$Estado="Cerrado";
				echo "<td align='left'>".$Estado."&nbsp;</td>";
				if ($Fila["tipo_embarque"]=="T")
					$TipoEmbarque="Terrestre";
				if ($Fila["tipo_embarque"]=="A")
					$TipoEmbarque="Acopio";	
				if ($Fila["tipo_embarque"]=="E")
					$TipoEmbarque="Estiba";	
				echo "<td align='center'>".$TipoEmbarque."&nbsp;</td>";
				echo "</tr>";
			}
		?> </table>  <br>
		<br>
          <table width="650" border="0" align="center">
          <tr>
              <td align="center"> 			 
			    <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:90" onClick="Imprimir('W');" value="Imprimir">
			    <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="JavaScript:window.close()">			</td>
          </tr>
  </table>
</form>
</body>
</html>