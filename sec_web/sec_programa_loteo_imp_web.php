<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 10;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
	
?>
<html>
<head>
<script language="JavaScript">
function VerAnteriores()
{
	var Frm=document.FrmProgLoteo;

	window.open("sec_programa_loteo_anteriores.php","","top=195,left=180,width=410,height=230,scrollbars=no,resizable = no");	
	
}

function Recarga()
{
	var Frm=document.FrmProgLoteo;
	var Programa="";
	
	if (Frm.OpcPrograma[0].checked)
	{
		Programa="S";
	}
	if (Frm.OpcPrograma[1].checked)
	{
		Programa="N";
	}
	if (Frm.OpcPrograma[2].checked)
	{
		Programa="A";
	}
	Frm.action="sec_programa_loteo_imp_web.php?Programa="+Programa;
	Frm.submit();
}

function Buscar()
{
	var Frm=document.FrmProgLoteo;
	
	Frm.action="sec_programa_loteo.php";
	Frm.submit();

}

function Imprimir(opt)
{
	var f=document.FrmProgLoteo;
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	window.print();
	f.BtnImprimir.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
}
</script>
<title>Programa de Loteo Enami - Codelco</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
-->
</style>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action=""> 	
<table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center"><strong>PROGRAMA DE LOTEO ENAMI-CODELCO</strong></td>
  </tr>
</table> 
	  <table width="650" border="0">
	  <tr>
	  
	  <?php
			if (!isset($Programa))
			{
				$Programa='N';
			}
			echo "<td align='left'>&nbsp;";
			//echo "<input type='button' name='BtnPLAnteriores' onclick='VerAnteriores()' style='width:90' value='Ver Anteriores'>";
			echo "<td align='center'>";
			switch ($Programa)
			{
				case "S":
					echo "Con N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()' checked>&nbsp;&nbsp;Fecha:&nbsp;&nbsp;";
					echo"<select name='CmbMes' onchange='Recarga()'>";
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
					echo "<select name='CmbAno' onchange='Recarga()'>";
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
					echo "Sin N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>&nbsp;&nbsp;";	
					echo "Anuladas<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>";
					break;
				case "N":
					echo "Con N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>&nbsp;&nbsp;";
					echo "Sin N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()' checked>&nbsp;&nbsp;";	
					echo "Anuladas<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>";
					break;
				case "A":
					echo "Con N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>&nbsp;&nbsp;";
					echo "Sin N� Programa<input type='radio' name='OpcPrograma' value='' onclick='Recarga()'>&nbsp;&nbsp;";	
					echo "Anuladas<input type='radio' name='OpcPrograma' value='' onclick='Recarga()' checked>";
					break;
			}
			echo "</td>";
			echo "<td>";
			echo "</td>";
	  ?>
	  

	  </tr>
	  </table><br>	  
	      <table width="650" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
              <td width='30' align="center">I.E</td>
              <td width='130' align="center">Nave/Cliente</td>
              <td width='47' align="center">Asig.</td>
              <td width='52' align="center">Contrato</td>
              <td width='38' align="center">Cuota</td>
              <td width='55' align="center">Puerto<br>
                Destino<br>
              </td>
              <td width='51' align="center">Tons.</td>
              <td width='74' align="center">Fecha <br>
                Prog</td>
              <td width='59' align="center">Fecha<br>
                Preemb</td>
              <td width='37' align="center">Prog Loteo</td>
              <td width="30" align="center">Est.</td>
            </tr>
  <?php
			if (strlen($CmbMes)==1)
			{
				$CmbMes="0".$CmbMes;
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-01 00:00:00";
			$FechaTermino=$CmbAno."-".$CmbMes."-31 23:59:59";			
			$MostrarBoton=false;
			$CrearTmp ="create temporary table if not exists sec_web.tmpprograma "; 
			$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
			$CrearTmp =$CrearTmp."cantidad_programada double(10,1),num_prog_loteo int(11),producto varchar(30),";
			$CrearTmp =$CrearTmp."subproducto varchar (30),pto_destino varchar (30),pto_emb varchar (30),";
			$CrearTmp =$CrearTmp."tipo char(1),cod_contrato varchar(10),estado char(1),fecha_disponible date,";
			$CrearTmp =$CrearTmp."descripcion varchar(255),enm_code char(1),contrato varchar(20), cuota int(2), cod_puerto varchar(10), cod_puerto_destino varchar(10))";
			mysqli_query($link, $CrearTmp);
			//CONSULTA TABLA PROGRAMA ENAMI
			$Consulta="select t1.descripcion,t1.fecha_disponible,t1.estado2,t1.cod_marca,t6.descripcion as producto,";
			$Consulta=$Consulta."t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,";
			$Consulta=$Consulta."(case when not isnull(t6.nombre_nave) then t6.nombre_nave else t5.sigla_cliente end) as nombre_cliente,";
			$Consulta=$Consulta." t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.fecha_embarque,t1.num_prog_loteo, ";
			$Consulta=$Consulta." t1.cod_contrato, t1.mes_cuota, t1.cod_puerto, t1.cod_puerto_destino ";
			$Consulta=$Consulta." from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.nave t6 on t1.cod_nave=t6.cod_nave ";
			if ($Programa=='S')
			{
				$Consulta=$Consulta." left join sec_web.programa_loteo t7 on t1.num_prog_loteo=t7.num_prog_loteo ";
				$Consulta=$Consulta." where t1.tipo <> 'V' and t1.estado2 <>'L' and t7.fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'";
			}
			else
			{
				$Consulta=$Consulta." where t1.tipo <> 'V' and t1.estado2 <>'C' and t1.estado2 <>'L'";
			}
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="insert into sec_web.tmpprograma (corr_ie,cliente_nave,fecha_programacion,cantidad_programada,num_prog_loteo ,producto,subproducto,pto_destino ,pto_emb,tipo,cod_contrato,estado,fecha_disponible,descripcion,enm_code,contrato,cuota,cod_puerto,cod_puerto_destino) values(";
				$Insertar=$Insertar."$Fila["corr_enm"],'".$Fila["nombre_cliente"]."','$Fila["eta_programada"]','$Fila[cantidad_embarque]','$Fila["num_prog_loteo"]','$Fila["producto"]','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["cod_marca"]."','".$Fila["estado2"]."','".$Fila["fecha_disponible"]."','$Fila["descripcion"]','E','$Fila["cod_contrato"]','$Fila["mes_cuota"]','$Fila["cod_puerto"]','$Fila[cod_puerto_destino]')";
				mysqli_query($link, $Insertar);
			}
			//CONSULTA TABLA PROGRAMA CODELCO
			$Consulta="select t1.descripcion,t1.fecha_disponible,t1.estado2,t1.cod_contrato_maquila,(case when not isnull(t4.nombre_nave) then t4.nombre_nave else t3.nombre_cliente end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,";
			$Consulta=$Consulta." t1.fecha_programacion,t1.cantidad_programada,t1.num_prog_loteo,t1.cod_contrato, t1.mes_cuota,t1.cod_puerto,t1.cod_puerto_destino ";
			$Consulta=$Consulta." from sec_web.programa_codelco  t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
			if ($Programa=='S')
			{
				$Consulta=$Consulta." left join sec_web.programa_loteo t7 on t1.num_prog_loteo=t7.num_prog_loteo ";
				$Consulta=$Consulta." where t1.estado2 <>'L' and t7.fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'";
			}
			else
			{
				$Consulta=$Consulta." where t1.estado2 <>'C' and t1.estado2 <>'L'";
			}			
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="insert into sec_web.tmpprograma (corr_ie,cliente_nave,fecha_programacion,cantidad_programada,num_prog_loteo ,producto,subproducto,tipo,cod_contrato,estado,fecha_disponible,descripcion,enm_code,contrato,cuota,cod_puerto,cod_puerto_destino) values(";
				$Insertar=$Insertar."$Fila["corr_codelco"],'".$Fila["nombre_cliente"]."','$Fila["fecha_programacion"]',$Fila["cantidad_programada"],'$Fila["num_prog_loteo"]','$Fila["producto"]','".$Fila["subproducto"]."','C','$Fila["cod_contrato_maquila"]','".$Fila["estado2"]."','".$Fila["fecha_disponible"]."','$Fila["descripcion"]','C','$Fila["cod_contrato"]','$Fila["mes_cuota"]','$Fila["cod_puerto"]','$Fila[cod_puerto_destino]')";
				mysqli_query($link, $Insertar);   
			}
			switch ($Programa)
			{
				case "S":
					$Consulta="select * from sec_web.tmpprograma where estado<>'A' and not isnull(num_prog_loteo) and  num_prog_loteo<>'' order by num_prog_loteo desc";
					break;
				case "N":
					$Consulta="select * from sec_web.tmpprograma where estado<>'A' and (isnull(num_prog_loteo) or num_prog_loteo='') order by fecha_programacion";	
					break;	
				case "A":
					$Consulta="select * from sec_web.tmpprograma where estado='A' order by fecha_programacion";	
					break;	
			}
			$Respuesta=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckProgLoteo'><input type='hidden' name ='NumProgLoteo'><input type='hidden' name='CheckFecha'>";
			while ($Valor=mysqli_fetch_array($Respuesta))
			{
				$MostrarBoton=true;
				$Cont2++;				
				echo "<tr>";					
				echo "<td width='40'>";
				echo $Valor["corr_ie"]."</td>";
				if ($Valor["cliente_nave"]<>"")
					echo "<td width='85'>".$Valor["cliente_nave"]."</td>";
				else	echo "<td width='85'>&nbsp;</td>";
				if ($Valor["cod_contrato"]<>"")
					echo "<td width='72'>".$Valor["cod_contrato"]."</td>";
				else
					echo "<td width='72'>&nbsp;</td>";
				if ($Valor[contrato]<>"")
					echo "<td width='69'>".$Valor[contrato]."</td>";
				else	echo "<td width='69'>&nbsp;</td>";
				if ($Valor[cuota]!="")
					echo "<td  align='center'>".$Valor[cuota]."</td>";
				else	echo "<td width='69'>&nbsp;</td>";
				if ($Valor[cod_puerto_destino]!="")
					echo "<td align='center'>".$Valor[cod_puerto_destino]."</td>";
				else	echo "<td width='69'>&nbsp;</td>";
				if ($Valor["cantidad_programada"]!="")
					echo "<td align='right'>".number_format($Valor["cantidad_programada"],1,",",".")."&nbsp;</td>";
				else	echo "<td width='69'>&nbsp;</td>";
				if ($Valor["fecha_programacion"]!="")
					echo "<td align='right'>".substr($Valor["fecha_programacion"],8,2)."/".substr($Valor["fecha_programacion"],5,2)."/".substr($Valor["fecha_programacion"],0,4)."</td>";
				else	echo "<td width='69'>&nbsp;</td>";
				if ((is_null($Valor["num_prog_loteo"]))||($Valor["num_prog_loteo"]=='')||($Valor["num_prog_loteo"]==0))
				{
					echo "<td align='center'>".substr($Valor["fecha_disponible"],8,2)."/".substr($Valor["fecha_disponible"],5,2)."/".substr($Valor["fecha_disponible"],0,4)."</td>";						
				}
				else
				{
					echo "<td align='center'>".substr($Valor["fecha_disponible"],8,2)."/".substr($Valor["fecha_disponible"],5,2)."/".substr($Valor["fecha_disponible"],0,4)."</td>";					
				}	
				if ($Valor["num_prog_loteo"]==0)
				{
					$Valor["num_prog_loteo"]='';
				}
				if ($Valor["num_prog_loteo"]!="")
					echo "<td align='center'>".$Valor["num_prog_loteo"]."</td>";
				else	echo "<td width='69'>&nbsp;</td>";
				if ($Valor["estado"]!="")
					echo "<td align='center'>".$Valor["estado"]."</td>";
				else	echo "<td width='69'>&nbsp;</td>";					
				echo "</tr>";
			}
			$BorrarTmp="drop table sec_web.tmpprograma";
			mysqli_query($link, $BorrarTmp);
		?></table>
        <br>		
          <table width="650" border="0" align="center">
          <tr>
            <td align="center">
			
			<input name="BtnImprimir" type="button" id="BtnImprimir" style="width:90" onClick="Imprimir('W');" value="Imprimir">
			<input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="JavaScript:window.close();">              </td>
          </tr>
  </table>
</form>
</body>
</html>
