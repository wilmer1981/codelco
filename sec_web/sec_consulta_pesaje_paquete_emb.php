<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 55;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	if (!isset($CmbDias))
	{
		$CmbDias=date('j');
		$CmbMes=date('n');
		$CmbAno=date('Y');
	}
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

function Imprimir()
{
	var Frm=document.FrmProgLoteo;
	
	window.print();	
}
function Recarga()
{
	var Frm=document.FrmProgLoteo;
	
	Frm.action="sec_consulta_pesaje_paquete_emb.php";
	Frm.submit();
}
function Excel()
{
	var Frm=document.FrmProgLoteo;
	
	Frm.action="sec_consulta_pesaje_paquete_emb_excel.php";
	Frm.submit();

}

function Salir()
{
	var Frm=document.FrmProgLoteo;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	Frm.submit();
	
}
</script>
<title>Consulta Pesaje de Paquetes a Embarque</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
 
	  
  <table width="730" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr>
	  <td align="center">
	  <?php
		echo "<SELECT name='CmbDias' onchange='Recarga()'>";
		for ($i=1;$i<=31;$i++)
		{
			if (isset($CmbDias))
			{
				if ($i==$CmbDias)
				{
					echo "<option SELECTed value= '".$i."'>".$i."</option>";
				}
				else
				{
				  echo "<option value='".$i."'>".$i."</option>";
				}
			}
			else
			{
				if ($i==date("j"))
				{
					echo "<option SELECTed value= '".$i."'>".$i."</option>";
				}
				else
				{
				  echo "<option value='".$i."'>".$i."</option>";
				}
			}	
		}
		echo"</SELECT>";
		echo"<SELECT name='CmbMes' onchange='Recarga()'>";
		for($i=1;$i<13;$i++)
		{
			if (isset($CmbMes))
			{
				if ($i==$CmbMes)
				{
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}	
		}
		echo "</SELECT>";
		echo "<SELECT name='CmbAno' onchange='Recarga()'>";
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (isset($CmbAno))
			{
				if ($i==$CmbAno)
					{
						echo "<option SELECTed value ='$i'>$i</option>";
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
						echo "<option SELECTed value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}		
		}
		echo "</SELECT></td>";			
	  ?>
	  </td>
	  </tr>
	  </table><br>
	  <table width="730" border="1" cellpadding="3" align="center" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01">
		  <?php
			echo "<td width='160' align='center'>Producto</td>";
			echo "<td width='45' align='center'>I.E</td>";
			echo "<td width='160 align='center'>Cliente/Destinatario</td>";
			echo "<td width='40' align='center'>Tons.</td>";
			echo "<td width='40' align='center'>Marca</td>";
			echo "<td width='10' align='center'>&nbsp;</td>";
			echo "<td width='90' align='center'>Serie Pqte.</td>";
			echo "<td width='30' align='center'>Pqts.</td>";
			echo "<td width='40' align='center'>Ctds.</td>";
			echo "<td width='70' align='center'>Peso Neto</td>";
		  ?>	
          </tr>
		  <tr>
		  <?php
		  	if (strlen($CmbDias)==1)
			{
				$CmbDias="0".$CmbDias;
			}
		  	if (strlen($CmbMes)==1)
			{
				$CmbMes="0".$CmbMes;
			}
			$Fecha=$CmbAno."-".$CmbMes."-".$CmbDias;
			$Fecha2=date('Y-m-d', mktime(1,0,0,$CmbMes,intval($CmbDias)+1,$CmbAno));
			//echo "fecha1".$Fecha."-".$Fecha2;
			$TotPqts=0;
			$TotCatodos=0;
			$TotPesoNeto=0;
			$Consulta="SELECT t2.cod_producto,t2.cod_subproducto,t3.descripcion from sec_web.lote_catodo t1 "; 
			$Consulta.="inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and ";
			$Consulta.="t1.num_paquete=t2.num_paquete inner join proyecto_modernizacion.subproducto t3 on ";
			$Consulta.="t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
			$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59' and t2.cod_producto in (18,48,19) ";
                     //poly 20-02-2008 se agtrga que busque entre  fecha creacion paquete  t1 y fecha creacion paquete t2
            $Consulta.="and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t2.fecha_creacion_paquete between '".$Fecha."' and '".$Fecha2."' ";
			$Consulta.="group by t2.cod_producto,t2.cod_subproducto";
			//echo "con".$Consulta;
			$RespuestaAgrup=mysqli_query($link, $Consulta);
			while($FilaAgrup=mysqli_fetch_array($RespuestaAgrup))
			{
				$SubTotPqts=0;
				$SubTotCatodos=0;
				$SubTotPesoNeto=0;
				$CrearTmp ="create temporary table if not exists sec_web.tmpConsultaEmb "; 
				$CrearTmp =$CrearTmp."(subproducto varchar (30),corr_ie bigint(8),cliente_nave varchar(30),";
				$CrearTmp =$CrearTmp."toneladas bigint(8),marca varchar(10),cod_lote varchar(1),num_lote_inicio varchar(12),";
				$CrearTmp =$CrearTmp."num_lote_final varchar(12),paquetes bigint(8),catodos bigint(8),peso_neto bigint(8))";
				mysqli_query($link, $CrearTmp);
				$Eliminar="delete from sec_web.tmpConsultaEmb";
				mysqli_query($link, $Eliminar);
				$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,t4.cantidad_embarque as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,t1.cod_marca,sum(peso_paquetes) as peso_neto,";
				$Consulta.="(case when not isnull(t6.nombre_nave) then t6.nombre_nave else t5.sigla_cliente end) as nombre_cliente ";
				$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
				$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
				$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
				$Consulta.="inner join sec_web.programa_enami t4 on t1.corr_enm=t4.corr_enm ";
				$Consulta.="left join sec_web.cliente_venta t5 on t4.cod_cliente=t5.cod_cliente ";
				$Consulta.="left join sec_web.nave t6 on t4.cod_nave=t6.cod_nave ";
				$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t2.cod_producto='".$FilaAgrup["cod_producto"]."' and t2.cod_subproducto='".$FilaAgrup["cod_subproducto"]."' group by t1.corr_enm";
    //echo "con".$Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					$Insertar="insert into sec_web.tmpConsultaEmb(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
					$Insertar.="'".$Fila["subproducto"]."','$Fila["corr_enm"]','$Fila["nombre_cliente"]','$Fila[toneladas]','$Fila["cod_marca"]','$Fila["cod_paquete"]','$Fila[lote_inicio]','$Fila[lote_final]','$Fila["paquetes"]','$Fila[catodos]','$Fila["peso_neto"]')";
					mysqli_query($link, $Insertar);
				}
				$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,t4.cantidad_programada as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,t1.cod_marca,sum(peso_paquetes) as peso_neto,";
				$Consulta.="(case when not isnull(t5.nombre_cliente) then t5.nombre_cliente else t6.nombre_nave end) as nombre_cliente ";
				$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
				$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
				$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
				$Consulta.="inner join sec_web.programa_codelco t4 on t1.corr_enm=t4.corr_codelco ";
				$Consulta.="left join sec_web.cliente_venta t5 on t4.cod_cliente=t5.cod_cliente ";
				$Consulta.="left join sec_web.nave t6 on ceiling(t4.cod_cliente)=t6.cod_nave ";
				$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59'  and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t2.cod_producto='".$FilaAgrup["cod_producto"]."' and t2.cod_subproducto='".$FilaAgrup["cod_subproducto"]."' ";
                $Consulta.="and t2.fecha_creacion_paquete between '".$Fecha."' and '".$Fecha2."' group by t1.corr_enm,t1.cod_paquete";
				//echo "con".$Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					$Insertar="insert into sec_web.tmpConsultaEmb(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
					$Insertar.="'".$Fila["subproducto"]."','$Fila["corr_enm"]','$Fila["nombre_cliente"]','$Fila[toneladas]','$Fila["cod_marca"]','$Fila["cod_paquete"]','$Fila[lote_inicio]','$Fila[lote_final]','$Fila["paquetes"]','$Fila[catodos]','$Fila["peso_neto"]')";
					mysqli_query($link, $Insertar);
				}
				$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,t4.peso_programado as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,t1.cod_marca,sum(peso_paquetes) as peso_neto ";
				$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
				$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
				$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
				$Consulta.="inner join sec_web.instruccion_virtual t4 on t1.corr_enm=t4.corr_virtual ";
				//$Consulta.="or t1.corr_enm like '%200705%' ";
				
				$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t2.cod_producto='".$FilaAgrup["cod_producto"]."' and t2.cod_subproducto='".$FilaAgrup["cod_subproducto"]."' group by t1.corr_enm";
				//echo "con".$Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					$Insertar="insert into sec_web.tmpConsultaEmb(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
					$Insertar.="'".$Fila["subproducto"]."','$Fila["corr_enm"]','','$Fila[toneladas]','$Fila["cod_marca"]','$Fila["cod_paquete"]','$Fila[lote_inicio]','$Fila[lote_final]','$Fila["paquetes"]','$Fila[catodos]','$Fila["peso_neto"]')";
					mysqli_query($link, $Insertar);
				}
				$Consulta="SELECT * from sec_web.tmpConsultaEmb";
				
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					echo "<td>$Fila["subproducto"]</td>";
					echo "<td>$Fila["corr_ie"]</td>";
					echo "<td>$Fila["cliente_nave"]&nbsp;</td>";
					echo "<td align='right'>".number_format($Fila[toneladas],0,'','.')."</td>";
					echo "<td align='center'>$Fila["marca"]</td>";
					echo "<td align='center'>$Fila[cod_lote]</td>";
					echo "<td>".$Fila[num_lote_inicio]."-".$Fila[num_lote_final]."</td>";
					echo "<td align='right'>".number_format($Fila["paquetes"],0,'','.')."</td>";
					echo "<td align='right'>".number_format($Fila[catodos],0,'','.')."</td>";
					echo "<td align='right'>".number_format($Fila["peso_neto"],0,'','.')."</td>";				
					echo "</tr>";
					$SubTotPqts=$SubTotPqts+$Fila["paquetes"];
					$SubTotCtds=$SubTotCtds+$Fila[catodos];
					$SubTotPesoNeto=$SubTotPesoNeto+$Fila["peso_neto"];
					$TotPqts=$TotPqts+$Fila["paquetes"];
					$TotCtds=$TotCtds+$Fila[catodos];
					$TotPesoNeto=$TotPesoNeto+$Fila["peso_neto"];
				}
				echo "<tr class='detalle02'>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>Sub-Total</td>";
				echo "<td align='right'>".number_format($SubTotPqts,0,'','.')."</td>";
				echo "<td align='right'>".number_format($SubTotCtds,0,'','.')."</td>";
				echo "<td align='right'>".number_format($SubTotPesoNeto,0,'','.')."</td>";				
				echo "</tr>";
			}	
			echo "<tr class='detalle01'>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>Total</td>";
			echo "<td align='right'>".number_format($TotPqts,0,'','.')."</td>";
			echo "<td align='right'>".number_format($TotCtds,0,'','.')."</td>";
			echo "<td align='right'>".number_format($TotPesoNeto,0,'','.')."</td>";				
			echo "</tr>";
		   ?>
		  </tr>
        </table>
		<br>
		
  <table width="730" border="0" align="center" class="tablainterior">
    <tr>
              <td align="center">
			   	<input type="button" name="BtnImprimir" value="Imprimir" style="width:90" onClick="Imprimir();">
				<input type="button" name="BtnExcel" value="Excel" style="width:90" onClick="Excel();">		
                <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
			</td>
          </tr>
        </table><br>

</form>
</body>
</html>
