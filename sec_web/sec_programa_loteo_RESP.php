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
function AnularIE()
{
	var Frm=document.FrmProgLoteo;
	var Valores="";
	
	if (confirm('Esta Seguro de Anular la Instruccion de Embarque'))
	{
		Valores=RecuperarValores();
		if (Valores!='')
		{
			Frm.action="sec_programa_loteo_proceso01.php?Proceso=A&Valores="+Valores;
			Frm.submit();
		}	
	}
}
function IngresarDescripcion()
{
	var Frm=document.FrmProgLoteo;
	var ValorCheck=new String();
	
	ValorCheck=RecuperarValores();
	window.open("sec_programa_loteo_ingreso_descripcion.php?ValorCheck="+ValorCheck,"","top=195,left=180,width=415,height=150,scrollbars=no,resizable = no");
}

function ModificarFechaPreembarque()
{
	var Frm=document.FrmProgLoteo;
	var Valores=new String();
	var ValorCheck=new String();
	
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
		ValorCheck=RecuperarValores();
		//window.open("sec_programa_loteo_modificar_fecha.php?Valores="+Valores+"&CmbAnoMax="+Frm.CmbAno.value+"&CmbMesMax="+Frm.CmbMes.value+"&CmbDiasMax="+Frm.CmbDias.value,"","top=195,left=180,width=415,height=130,scrollbars=no,resizable = no");
		window.open("sec_programa_loteo_modificar_fecha.php?Valores="+Valores+"&ValorCheck="+ValorCheck,"","top=195,left=180,width=415,height=130,scrollbars=no,resizable = no");
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
	if (Frm.OpcPrograma[1].checked)
	{
		Programa="N";
	}
	if (Frm.OpcPrograma[2].checked)
	{
		Programa="A";
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

function ModifContrato()
{
	var Frm=document.FrmProgLoteo;
	var Valores="";
	var Resp="";
	var Proceso="MC"; //MODIFICA CONTRATO;	
	var Frm=document.FrmProgLoteo;
	var Valores=new String();
	for (i=1;i<Frm.CheckProgLoteo.length;i++)
	{
		if (Frm.CheckProgLoteo[i].checked==true)
		{
			Valores=Valores + Frm.CheckProgLoteo[i].value +"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);	
		window.open("sec_programa_loteo_contrato.php?Proceso="+Proceso+"&Valores="+Valores,"","top=50,left=20,width=700,height=300,scrollbars=no,resizable = no");
	}
}

function Salir()
{
	var Frm=document.FrmProgLoteo;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
	
}

function Imprimir(opt)
{
	var f=document.FrmProgLoteo;
	switch (opt)
	{
		case "W":
			window.open("sec_programa_loteo_imp_web.php", "","menubar=no resizable=yes Top=30 Left=50 width=670 height=500 scrollbars=yes");
			 break;
	}
}
</script>
<title>Programa de Loteo Enami - Codelco</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="425" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
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
	  </table></div><br>
	  <div style="position:absolute; left: 15px; top: 85px; width: 740px; height: 250px; OVERFLOW: auto;" id="div2">
	      <table width="735" border="0" cellpadding="1" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width='15' align="center"></td>
              <td width='35' align="center">I.E</td>
              <td width='109' align="center">Nave/Cliente</td>
              <td width='70' align="center">Asignacion</td>
              <td width='66' align="center">Contrato</td>
              <td width='41' align="center">Cuota</td>
              <td width='61' align="center">Puerto<br>
                Destino<br>
              </td>
              <td width='63' align="center">Tons.</td>
              <td width='63' align="center">Fecha <br>
                Prog</td>
              <td width='109' align="center">Fecha<br>
                Preemb</td>
              <td width='32' align="center">Prog Loteo</td>
              <td width="44" align="center">Est.</td>
            </tr>
          </table>
        </div>
		<div style="position:absolute; left: 17px; top: 115px; width: 750px; height: 240px; OVERFLOW: auto;" id="div2">
		<?php
			if (strlen($CmbMes)==1)
			{
				$CmbMes="0".$CmbMes;
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-01 00:00:00";
			$FechaTermino=$CmbAno."-".$CmbMes."-31 23:59:59";
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
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
				$Insertar=$Insertar."$Fila["corr_enm"],'$Fila["nombre_cliente"]','$Fila["eta_programada"]','$Fila[cantidad_embarque]','$Fila["num_prog_loteo"]','$Fila["producto"]','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','$Fila["pto_emb"]','E','$Fila["cod_marca"]','".$Fila["estado2"]."','".$Fila["fecha_disponible"]."','$Fila["descripcion"]','E','$Fila["cod_contrato"]','$Fila["mes_cuota"]','$Fila["cod_puerto"]','$Fila[cod_puerto_destino]')";
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
				$Insertar=$Insertar."$Fila["corr_codelco"],'$Fila["nombre_cliente"]','$Fila["fecha_programacion"]',$Fila["cantidad_programada"],'$Fila["num_prog_loteo"]','$Fila["producto"]','".$Fila["subproducto"]."','C','$Fila["cod_contrato_maquila"]','".$Fila["estado2"]."','$Fila["fecha_disponible"]','$Fila["descripcion"]','C','$Fila["cod_contrato"]','$Fila["mes_cuota"]','$Fila["cod_puerto"]','$Fila[cod_puerto_destino]')";
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
				if ($Valor["estado"]=='A')
				{
					echo "<tr class='colortabla04'>"; 							
				}
				else
				{
					if (($Programa!='S')&&(($Valor["estado"]=='M')||(date($Valor["fecha_disponible"])<=date("Y-m-d"))))
					{
						echo "<tr class='colortabla06'>";
					}	 							
					else
					{					
						echo "<tr>";
					}	 
				}					
				if ((is_null($Valor["num_prog_loteo"]))||($Valor["num_prog_loteo"]=='')||($Valor["num_prog_loteo"]==0))
				{
					if ($Valor["estado"]=='A')
					{
						//echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' disabled ><input type='hidden' name ='NumProgLoteo' value='".$Valor["num_prog_loteo"]."'></td>";					
						echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' value='".$Valor["corr_ie"]."~~".$Valor["tipo"]."'><input type='hidden' name ='NumProgLoteo' value='".$Valor["num_prog_loteo"]."'></td>";					
					}
					else
					{
						$pos = strpos($ValorCheck, $Valor["corr_ie"]."~~".$Valor["tipo"]."//");
						if ($pos === false)
						{ 						
							echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' value='".$Valor["corr_ie"]."~~".$Valor["tipo"]."'><input type='hidden' name ='NumProgLoteo' value=''></td>";
						}
						else
						{
							//echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' value='".$Valor["corr_ie"]."~~".$Valor["tipo"]."' checked><input type='hidden' name ='NumProgLoteo' value=''></td>";						
							echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' value='".$Valor["corr_ie"]."~~".$Valor["tipo"]."'><input type='hidden' name ='NumProgLoteo' value=''></td>";						
						}	
					}	
				}
				else
				{
					//echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' disabled checked><input type='hidden' name ='NumProgLoteo' value='".$Valor["num_prog_loteo"]."'></td>";					
					echo "<td width='15'><input type='checkbox' name='CheckProgLoteo' value='".$Valor["corr_ie"]."~~".$Valor["tipo"]."'><input type='hidden' name ='NumProgLoteo' value='".$Valor["num_prog_loteo"]."'></td>";					
				}	
				echo "<td width='40'  onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>";
				echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>Producto:&nbsp;</b>".$Valor["producto"]."&nbsp;<b>Sub-Producto:&nbsp;</b>".$Valor["subproducto"]." </font><br>";
				if ($enm_code == "E")
					echo "<font face='courier' color='#000000' size=1><b>Puerto Embarque: </b>".$Valor["pto_emb"]."&nbsp;<b>Puerto Destino: </b>".$Valor["pto_destino"]."</font><br>";
				else
					echo "<font face='courier' color='#000000' size=1><b>Puerto Embarque: </b>".$Valor["cod_puerto"]."&nbsp;<b>Puerto Destino: </b>".$Valor[cod_puerto_destino]."</font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Descripcion: </b>".$Valor["descripcion"]."</font><br>";
				echo "</div>".$Valor["corr_ie"]."</td>";
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
				echo "<td width='42' align='center'>".$Valor[cuota]."</td>";
				echo "<td width='60' align='center'>".$Valor[cod_puerto_destino]."</td>";
				echo "<td width='80' align='right'>".number_format($Valor["cantidad_programada"],1,",",".")."&nbsp;</td>";
				echo "<td width='100' align='right'>".$Valor["fecha_programacion"]."</td>";
				if ((is_null($Valor["num_prog_loteo"]))||($Valor["num_prog_loteo"]=='')||($Valor["num_prog_loteo"]==0))
				{
					echo "<td width='100' align='center'><input type='checkbox' name='CheckFecha' value='".$Valor["corr_ie"]."~~".$Valor["tipo"]."'>&nbsp;".$Valor["fecha_disponible"]."</td>";						
				}
				else
				{
					echo "<td width='100' align='center'><input type='checkbox' name='CheckFecha' disabled>&nbsp;".$Valor["fecha_disponible"]."</td>";					
				}	
				if ($Valor["num_prog_loteo"]==0)
				{
					$Valor["num_prog_loteo"]='';
				}
				echo "<td class='colortabla02' width='50' align='center'>".$Valor["num_prog_loteo"]."&nbsp;</td>";
				echo "<td width='40' align='center'>".$Valor["estado"]."&nbsp;</td>";
				echo "</tr>";
			}
			$BorrarTmp="drop table sec_web.tmpprograma";
			mysqli_query($link, $BorrarTmp);
			echo "</table>";	
		?>
		</div>
        <br>
		<div style="position:absolute; left: 15px; top: 370px; width: 750px; height: 110px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" class="tablainterior">
          <tr>
            <td align="center">
			<?php
				switch ($Programa)
				{
					case "N":
						echo "<input type='button' name='BtnNuevo' value='Nuevo P.Loteo' style='width:90' onClick=MostrarPopupProceso('N');>&nbsp;";					
						echo "<input type='button' name='BtnModificar' value='Modificar Fecha' style='width:95' onClick='ModificarFechaPreembarque();'>&nbsp;";
						echo "<input type='button' name='BtnDescripcion' value='Descripcion' style='width:95' onClick='IngresarDescripcion();'>&nbsp;";
						echo "<input type='button' name='BtnAnular' value='Anular' style='width:95' onClick='AnularIE();'>&nbsp;";
						break;
					case "S":
						//echo "<input type='button' name='BtnAnular' value='Anular' style='width:95' onClick='AnularIE();'>&nbsp;";
						break;	
				
				}
			?>
			<input name="BtnImprimir" type="button" id="BtnImprimir" style="width:90" onClick="Imprimir('W');" value="Imprimir">
			<input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
                <input type="button" name="BtnModifContrato" value="Mod. Contrato" style="width:90" onClick="ModifContrato();"><br><br>
                <table width="550" height="48" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaInterior">
                  <tr>
                    <td colspan="6" class="ColorTabla01"><em><strong>ESTADOS:</strong></em></td>
                  </tr>
                  <tr>
                    <td width="30" align="center"><strong>A</strong></td>
                    <td width="130">Anulado</td>
                    <td width="30" align="center"><strong>P</strong></td>
                    <td width="130">Pesandose</td>
                    <td width="40" align="center"><strong>AUTO</strong></td>
                    <td width="163">Pesaje Produccion diario </td>
                  </tr>
                  <tr>
                    <td align="center"><strong>M</strong></td>
                    <td>Peso Modificado </td>
                    <td align="center"><strong>T</strong></td>
                    <td>Terminado de Pesar </td>
                    <td align="center"><strong>C</strong></td>
                    <td>Con Numero de Envio </td>
                  </tr>
                </table>                
              <br>              </td>
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
