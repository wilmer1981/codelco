<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 13;
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
function VerAnteriores()
{
	var Frm=document.FrmRelacIELote;

	window.open("sec_programa_loteo_anteriores.php","","top=195,left=180,width=410,height=230,scrollbars=no,resizable = no");	
	
}
function ModificarFechaPreembarque()
{
	var Frm=document.FrmRelacIELote;
	var Valores=new String();
	
	for (i=1;i<Frm.CheckFecha.length;i++)
	{
		if (Frm.CheckFecha[i].checked==true)
		{
			Valores=Valores + Frm.CheckFecha[i].value +"~~";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		window.open("sec_programa_loteo_modificar_fecha.php?Valores="+Valores+"&CmbAnoMax="+Frm.CmbAno.value+"&CmbMesMax="+Frm.CmbMes.value+"&CmbDiasMax="+Frm.CmbDias.value,"","top=195,left=180,width=415,height=130,scrollbars=no,resizable = no");
	}	
	
}

function Buscar()
{
	var Frm=document.FrmRelacIELote;
	
	Frm.action="sec_relacion_instruccion_emb_lote.php";
	Frm.submit();

}
function RecuperarValores()
{
	var Frm=document.FrmRelacIELote;
	var Valores=new String();
	
	for (i=1;i<Frm.CheckRelacion.length;i++)
	{
		Valores=Valores + Frm.CheckRelacion[i].value +"~~";
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		return('');	
	}	
	
} 
function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmRelacIELote;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "N":
			window.open("sec_relacion_instruccion_emb_lote_proceso.php?Proceso="+Proceso+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&MesActual=S","","top=170,left=180,width=410,height=315,scrollbars=no,resizable = no");
			break;
		case "E":
			Valores=RecuperarValores();
			if (Valores!='')
			{
				Resp=confirm("Esta seguro de Eliminar los Datos Seleccionados");
				if (Resp==true)
				{
					Frm.action="sec_relacion_instruccion_emb_lote_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}	
			}	
			break;
	} 
}

function Salir()
{
	var Frm=document.FrmRelacIELote;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();  
	
}
</script>
<title>Relacion Instruccion Embarque Lote ENAMI</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmRelacIELote" method="post" action="">
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
			echo "<td align='center'>";
			echo "</td>";
			echo "<td align='center'>";
			echo "Fecha Inicio&nbsp;&nbsp;<select name='CmbDias'>";
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDias))
				{
					if ($i==$CmbDias)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
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
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			echo"</select>";
			echo"<select name='CmbMes'>";
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
			echo "<select name='CmbAno'>";
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
			echo "</select>&nbsp;&nbsp;";
			echo "Fecha Termino&nbsp;&nbsp;<select name='CmbDiasT'>";
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDiasT))
				{
					if ($i==$CmbDiasT)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
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
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			echo"</select>";
			echo"<select name='CmbMesT'>";
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMesT))
				{
					if ($i==$CmbMesT)
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
			echo "<select name='CmbAnoT'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAnoT))
				{
					if ($i==$CmbAnoT)
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
			echo "</select>&nbsp;<input type='button' name='TxtBuscar' value='Buscar' style='width:60' onclick='Buscar()'>";
			echo "</td>";
	  ?>
	  </tr>
	  </table></div><br>
	  <div style="position:absolute; left: 15px; top: 85px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0" cellpadding="2" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
		  	<td width='20' align="center">&nbsp;</td>
			<td width='40' align="center">I.E</td>
			<td width='50' align="center">Peso Prog</td>
			<td width='190' align="center">Cliente</td>
			<td width='40' align="center">Cod.Lote</td>
			<td width='45' align="center">N�Lote</td>
			<td width='50' align="center">Cant.Pqte</td>
			<td width="50" align="center">Peso Lote</td>
			<td width="40" align="left">Unid.Pqte</td>
			<td width="110" align="center">Marca Lote</td>
			<td width="100" align="center">Eta Emb</td>
          </tr>
        </table></div>
		<div style="position:absolute; left: 15px; top: 120px; width: 750px; height: 240px; OVERFLOW: auto;" id="div2">
		<?php
			
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			if (isset($CmbAno))
			{
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				if (strlen($CmbDias)==1)
				{
					$CmbDias="0".$CmbDias;
				}
				if (strlen($CmbMesT)==1)
				{
					$CmbMesT="0".$CmbMesT;
				}
				if (strlen($CmbDiasT)==1)
				{
					$CmbDiasT="0".$CmbDiasT;
				}
				$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias;	
				$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT;	
			}
			else
			{
				$FechaInicio=date('Y-m-d');	
				$FechaTermino=date('Y-m-d');
			}
			$Consulta="select t1.cod_lote,t1.num_lote,t1.cantidad_paquetes,t1.peso_lote,t1.marca,t4.descripcion as marca_catodo,t1.corr_ie,t2.cantidad_embarque,t3.nombre_cliente,t2.eta_programada";
			$Consulta=$Consulta." from sec_web.relacion_lote_enami_codelco t1";
			$Consulta=$Consulta." inner join sec_web.programa_enami t2 on t1.corr_ie = t2.corr_ie ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente = t3.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.marca_catodos t4 on t1.marca = t4.cod_marca ";
			$Consulta=$Consulta." where t1.fecha_relacion between '".$FechaInicio."' and '".$FechaTermino."' and cod_estado='A'";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckRelacion'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				$Cont++;
				echo "<td><input type='checkbox' name='CheckRelacion' value='".$Fila["corr_ie"]."'></td>";
				echo "<td width='40'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' bgcolor='#cccccc'>";
				echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>Sub-Producto:&nbsp;&nbsp;: </b>".$Fila["subproducto"]." <b>Puerto Embarque: </b>".$Fila["pto_emb"]."</font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Puerto Destino: </b>".$Fila["pto_destino"]."</font><br>";
				echo "</div>".$Fila["corr_ie"]."<input type='hidden' name='CheckProgLoteo' value='$Fila["corr_ie"]'><input type='hidden' name ='NumProgLoteo' value='$Fila["num_prog_loteo"]'></td>";
				echo "<td width='50'>".($Fila[cantidad_embarque]*1000)."</td>";
				echo "<td width='200'>".$Fila["nombre_cliente"]."&nbsp;</td>";
				echo "<td width='60' align='center'>".$Fila[cod_lote]."</td>";
				echo "<td width='60' align='center'>".$Fila[num_lote]."</td>";
				echo "<td width='60' align='right'>".$Fila[cantidad_paquetes]."</td>";
				echo "<td width='60' align='right'>".$Fila[peso_lote]."</td>";
				$Consulta="select sum(t2.num_unidades) as unidad_paquete from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete";
				$Consulta=$Consulta." where cod_bulto='".$Fila[cod_lote]."' and num_bulto=".$Fila[num_lote]." group by cod_bulto,num_bulto";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta);
				$UnidadPaquete=$Fila2[unidad_paquete];
				echo "<td width='60' align='right'>$UnidadPaquete&nbsp;</td>";
				echo "<td width='150' align='left'>".$Fila[marca_catodo]."&nbsp;</td>";
				echo "<td width='100' align='center'>".$Fila["eta_programada"]."&nbsp;</td>";
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
			<input type="button" name="BtnNuevo" value="Nuevo" style="width:80" onClick="MostrarPopupProceso('N');">  
			<input type="button" name="BtnEliminar" value="Eliminar" style="width:80" onClick="MostrarPopupProceso('E');">
			<input type="button" name="BtnSalir" value="Salir" style="width:80" onClick="Salir();">
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
