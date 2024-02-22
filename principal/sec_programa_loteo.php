<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 10;
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
	var Frm=document.FrmProgLoteo;

	window.open("sec_programa_loteo_anteriores.php","","top=195,left=180,width=410,height=230,scrollbars=no,resizable = no");	
	
}
function ModificarFechaPreembarque()
{
	var Frm=document.FrmProgLoteo;
	var Valores=new String();
	
	for (i=1;i<Frm.CheckFecha.length;i++)
	{
		if (Frm.CheckFecha[i].checked==true)
		{
			Valores=Valores + Frm.CheckFecha[i].value +"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		//window.open("sec_programa_loteo_modificar_fecha.php?Valores="+Valores+"&CmbAnoMax="+Frm.CmbAno.value+"&CmbMesMax="+Frm.CmbMes.value+"&CmbDiasMax="+Frm.CmbDias.value,"","top=195,left=180,width=415,height=130,scrollbars=no,resizable = no");
		window.open("sec_programa_loteo_modificar_fecha.php?Valores="+Valores,"","top=195,left=180,width=415,height=130,scrollbars=no,resizable = no");
	}	
	
}
function Recarga()
{
	var Frm=document.FrmProgLoteo;
	var Programa="";
	
	if (Frm.OpcPrograma[0].checked)
	{
		Programa="S";
	}
	else
	{
		Programa="N";
	}
	Frm.action="sec_programa_loteo.php?Programa="+Programa;
	Frm.submit();
	
}

function Buscar()
{
	var Frm=document.FrmProgLoteo;
	
	Frm.action="sec_programa_loteo.php";
	Frm.submit();

}
function RecuperarValores()
{
	var Frm=document.FrmProgLoteo;
	var Valores=new String();
	
	for (i=1;i<Frm.CheckProgLoteo.length;i++)
	{
		if ((Frm.CheckProgLoteo[i].checked==true)&&(Frm.NumProgLoteo[i].value==''))
		{
			Valores=Valores + Frm.CheckProgLoteo[i].value +"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
	
} 
function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmProgLoteo;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			Valores=RecuperarValores();
			if (Valores!='')
			{
				//window.open("sec_programa_loteo_proceso.php?Proceso="+Proceso+"&Valores="+Valores+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value,"","top=195,left=180,width=410,height=190,scrollbars=no,resizable = no");
				window.open("sec_programa_loteo_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=195,left=180,width=410,height=190,scrollbars=no,resizable = no");
			}	
			break;
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
			if (!isset($Programa))
			{
				$Programa='N';
			}
			echo "<td align='left'>";
			echo "<input type='button' name='BtnPLAnteriores' onclick='VerAnteriores()' style='width:90' value='Ver Anteriores'>";
			echo "<td align='center'>";
			if ($Programa=='S')
			{
				echo "Con N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()' checked>";
			}
			else
			{
				echo "Con N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>";
			}	
			echo "</td>";
			echo "<td>";
			if ($Programa=='N')
			{
				echo "Sin N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()' checked>";	
			}
			else
			{
				echo "Sin N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>";	
			}			
			echo "</td>";
	  ?>
	  </tr>
	  </table></div><br>
	  <div style="position:absolute; left: 15px; top: 85px; width: 740px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="735" border="0" cellpadding="1" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
		   	<td width='20' align="center"></td>
			<td width='40' align="center">I.E</td>
			<td width='170' align="center">Nave/Cliente</td>
			<td width='60' align="center">Contrato</td>
			<td width='100' align="center">Peso(Kg)Prog</td>
			<td width='100' align="center">Fecha Prog</td>
			<td width='100' align="center">Fecha Preembarque</td>
			<td width='80' align="center">Prog Loteo N�</td>
			<td width="40" align="center">Estado</td>
          </tr>
        </table></div>
		<div style="position:absolute; left: 17px; top: 115px; width: 750px; height: 240px; OVERFLOW: auto;" id="div2">
		<?php
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$MostrarBoton=false;
			$CrearTmp ="create temporary table if not exists sec_web.tmpprograma "; 
			$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
			$CrearTmp =$CrearTmp."cantidad_programada bigint(8),num_prog_loteo int(11),producto varchar(30),";
			$CrearTmp =$CrearTmp."subproducto varchar (30),pto_destino varchar (30),pto_emb varchar (30),";
			$CrearTmp =$CrearTmp."tipo char(1),cod_contrato varchar(10),estado char(1),fecha_disponible date)";
			mysqli_query($link, $CrearTmp);
			//CONSULTA TABLA PROGRAMA ENAMI
			$Consulta="select t1.fecha_disponible,t1.estado2,t1.cod_marca,t6.descripcion as producto,t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,t5.sigla_cliente,";
			$Consulta=$Consulta."t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.fecha_embarque,t1.num_prog_loteo";
			$Consulta=$Consulta." from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
			$Consulta=$Consulta." where t1.estado2 <>'C' and t1.estado2 <>'L'";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="insert into sec_web.tmpprograma (corr_ie,cliente_nave,fecha_programacion,cantidad_programada,num_prog_loteo ,producto,subproducto,pto_destino ,pto_emb,tipo,cod_contrato,estado,fecha_disponible) values(";
				$Insertar=$Insertar."$Fila["corr_enm"],'".$Fila["sigla_cliente"]."','$Fila[eta_programada]','$Fila["cantidad_embarque"]','$Fila[num_prog_loteo]','$Fila["producto"]','".$Fila["subproducto"]."','$Fila[pto_destino]','$Fila[pto_emb]','E','$Fila["cod_marca"]','".$Fila["estado2"]."','".$Fila["fecha_disponible"]."')";
				mysqli_query($link, $Insertar);
			}
			//CONSULTA TABLA PROGRAMA CODELCO
			$Consulta="select t1.fecha_disponible,t1.estado2,t1.cod_contrato_maquila,(case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.fecha_programacion,t1.cantidad_programada,t1.num_prog_loteo";
			$Consulta=$Consulta." from sec_web.programa_codelco  t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
			$Consulta=$Consulta." where t1.estado2 <>'C' and t1.estado2 <>'L'";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="insert into sec_web.tmpprograma (corr_ie,cliente_nave,fecha_programacion,cantidad_programada,num_prog_loteo ,producto,subproducto,tipo,cod_contrato,estado,fecha_disponible) values(";
				$Insertar=$Insertar."$Fila["corr_codelco"],'$Fila["nombre_cliente"]','$Fila["fecha_programacion"]',$Fila["cantidad_programada"],'$Fila[num_prog_loteo]','$Fila["producto"]','".$Fila["subproducto"]."','C','$Fila["cod_contrato_maquila"]','".$Fila["estado2"]."','".$Fila["fecha_disponible"]."')";
				mysqli_query($link, $Insertar);   
			}
			if ($Programa=='S')
			{
				$Consulta="select * from sec_web.tmpprograma where not isnull(num_prog_loteo) and  num_prog_loteo<>'' order by num_prog_loteo";
			}
			else
			{
				$Consulta="select * from sec_web.tmpprograma where isnull(num_prog_loteo) or num_prog_loteo='' order by fecha_programacion";
			}
			$Respuesta=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckProgLoteo'><input type='hidden' name ='NumProgLoteo'><input type='hidden' name='CheckFecha'>";
			while ($Valor=mysqli_fetch_array($Respuesta))
			{
				$MostrarBoton=true;
				$Cont2++;
				if ($Valor[estado]=='A')
				{
					echo "<tr class='colortabla04'>"; 							
				}
				else
				{
					if (($Valor[estado]=='M')||(date($Valor[fecha_disponible])<=date("Y-m-d")))
					{
						echo "<tr class='colortabla03'>";
					}	 							
					else
					{					
						echo "<tr>";
					}	 
				}					
				if ((is_null($Valor[num_prog_loteo]))||($Valor[num_prog_loteo]=='')||($Valor[num_prog_loteo]==0))
				{
					if ($Valor[estado]=='A')
					{
						echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' disabled ><input type='hidden' name ='NumProgLoteo' value='".$Valor[num_prog_loteo]."'></td>";					
					}
					else
					{
						echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' value='".$Valor["corr_ie"]."~~".$Valor[tipo]."'><input type='hidden' name ='NumProgLoteo' value=''></td>";
					}	
				}
				else
				{
					echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' disabled checked><input type='hidden' name ='NumProgLoteo' value='".$Valor[num_prog_loteo]."'></td>";					
				}	
				echo "<td width='40'  onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>";
				echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>Producto:&nbsp;</b>".$Valor["producto"]."&nbsp;<b>Sub-Producto:&nbsp;</b>".$Valor["subproducto"]." </font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Puerto Embarque: </b>".$Valor[pto_emb]."&nbsp;<b>Puerto Destino: </b>".$Valor[pto_destino]."</font><br>";
				echo "</div>".$Valor["corr_ie"]."</td>";
				echo "<td width='170'>".$Valor["cliente_nave"]."&nbsp;</td>";
				echo "<td width='60'>".$Valor["cod_contrato"]."&nbsp;</td>";
				echo "<td width='80' align='right'>".$Valor["cantidad_programada"]."&nbsp;</td>";
				echo "<td width='100' align='right'>".$Valor["fecha_programacion"]."</td>";
				if ((is_null($Valor[num_prog_loteo]))||($Valor[num_prog_loteo]==''))
				{
					echo "<td width='100' align='center'><input type='checkbox' name='CheckFecha' value='".$Valor["corr_ie"]."~~".$Valor[tipo]."'>&nbsp;".$Valor[fecha_disponible]."</td>";						
				}
				else
				{
					echo "<td width='100' align='center'><input type='checkbox' name='CheckFecha' disabled>&nbsp;".$Valor[fecha_disponible]."</td>";
				}	
				if ($Valor[num_prog_loteo]==0)
				{
					$Valor[num_prog_loteo]='';
				}
				echo "<td class='colortabla02' width='80' align='center'>".$Valor[num_prog_loteo]."&nbsp;</td>";
				echo "<td width='40' align='center'>".$Valor[estado]."&nbsp;</td>";
				echo "</tr>";
			}
			$BorrarTmp="drop table sec_web.tmpprograma";
			mysqli_query($link, $BorrarTmp);
			echo "</table>";	
		?>
		</div>
        <br>
		<div style="position:absolute; left: 15px; top: 370px; width: 750px; height: 48px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" class="tablainterior">
          <tr>
            <td align="center">
			<?php
				if ($MostrarBoton==false)
				{
					echo "<input type='button' name='BtnNuevo' value='Nuevo P.Loteo' style='width:90' onClick=MostrarPopupProceso('N'); disabled>";	
				}
				else
				{
					echo "<input type='button' name='BtnNuevo' value='Nuevo P.Loteo' style='width:90' onClick=MostrarPopupProceso('N');>";					
				}
			?>
			
			<!--<input type="button" name="BtnModificar" value="Elim. P.Loteo" style="width:90" onClick="MostrarPopupProceso('E');">-->  
			<input type="button" name="BtnModificar" value="Modificar Fecha" style="width:95" onClick="ModificarFechaPreembarque();">
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
