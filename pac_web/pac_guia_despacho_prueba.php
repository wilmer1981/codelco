<?php 	
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 12;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Fecha_Hora = date("Y-m-d" );
	
	//prueba para imprimir guia 22-07-2008
?>
<html>
<head>

<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmGuia;
	var Valores="";
	for (i=1;i<Frm.CheckGuia.length;i++)
	{
		if (Frm.CheckGuia[i].checked==true)
		{
	
			Valores=Valores + Frm.TxtNumGuiaO[i].value+"//";
		}
	}
	return(Valores);
}	
function CheckearTodo()
{
	var Frm=document.FrmGuia;
	try
	{
		Frm.CheckGuia[0];
		for (i=1;i<Frm.CheckGuia.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckGuia[i].checked=true;
			}
			else
			{
				Frm.CheckGuia[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmGuia;
	var CantCheck=0;
	for (i=1;i<Frm.CheckGuia.length;i++)
	{
		if (Frm.CheckGuia[i].checked==true)
		{
			CantCheck=CantCheck+1;
		}
	}
	if (CantCheck > 1)
	{
		alert("Debe Seleccionar solo un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}
function SeleccionoCheck()
{
	var Frm=document.FrmGuia;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckGuia.length;i++)
	{
		if (Frm.CheckGuia[i].checked==true)
		{
			Encontro=true;
			break;
		}
	}
	if (Encontro==false)
	{
		alert("Debe Seleccionar un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}
function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmGuia;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_guia_despacho_proceso.php?Proceso="+Proceso +"&Ver=C","","top=0,left=0,width=770,height=480,scrollbars=yes,resizable = yes,status=yes");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_guia_despacho_proceso.php?Proceso="+Proceso +"&Valores="+Valores,"","top=0,left=0,width=770,height=480,scrollbars=yes,resizable = yes");
				}	
			}	
			break;
		case "A":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de Anular los Datos Seleccionados");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action="pac_guia_despacho_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Salir()
{
	var Frm=document.FrmGuia;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9";
	Frm.submit();
}
function VerAnuladas()
{
	var Frm=document.FrmGuia;
	Frm.action="pac_guia_despacho.php?Proceso=V";
	Frm.submit();
}
function VerGeneradas()
{
	var Frm=document.FrmGuia;
	Frm.action="pac_guia_despacho.php?Proceso=G";
	Frm.submit();
}
function Cancelar()
{
	var Frm=document.FrmGuia;
	Frm.action="pac_guia_despacho.php";
	Frm.submit();
}
function Salir2()
{
	var Frm=document.FrmGuia;
	Frm.action="pac_guia_despacho_Proceso01.php?Proceso=S";
	Frm.submit();
}

function Historial(NG)
{
	var Frm=document.FrmGuia;
	var Valores="";
	window.open("pac_guia_despacho02.php?Valores="+NG,"","top=110,left=30,width=690,height=340,scrollbars=no,resizable = yes");
}
function Recarga()
{
	var Frm=document.FrmGuia;
	Frm.action="pac_guia_despacho.php";
	Frm.submit();
}
function Generar(Opcion)
{
	var Frm=document.FrmGuia;
	if (SeleccionoCheck()) 
	{
		switch (Opcion)
		{
			case "P":
				Valores=RecuperarValoresCheckeado();
				window.open("pac_generacion_guia_despacho.php?Valores="+Valores +"&Proceso=I","","top=0px,left=5px,width=770px,height=550px,scrollbars=yes,resizable = yes");					
				//Frm.action="pac_generacion_guia_despacho.php?Valores="+Valores +"&Proceso=I";
				//Frm.submit();
				break;
			case "I":
				Valores=RecuperarValoresCheckeado();
				window.open("pac_impresion_guia_despacho_prueba.php?Valores="+Valores +"&Proceso=I","","top=0px,left=5px,width=770px,height=550px,scrollbars=yes,resizable = yes");									
				//Frm.action="pac_impresion_guia_despacho.php?Valores="+Valores +"&Proceso=I";
				//Frm.submit();
				break;
		}
	}     
}
</script>
<title>Guia Despacho</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmGuia" method="post" action="" >
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
	      
 <?php
	echo "<table width='755' border='0'>";
	echo "<tr>";
	echo "<td align='center'>";
	/*echo "<select name='CmbDia' size='1' style='width:40px;'>";
	for ($i=1;$i<=31;$i++)
	{
		if ($Proceso=='M')
		{
			if ($i==$Dia)
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
			if (isset($CmbDia))
			{
				if ($i==$CmbDia)
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
	}
  	echo "</select>";*/
	echo "<select name='CmbMes' size='1' style='width:90px;' onchange='Recarga()'>";
	for($i=1;$i<13;$i++)
	{
		if ($Proceso=='M')
		{
			if ($i==$CmbMes)
			{
				echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$meses[$i-1]."</option>";
			}
		}
		else
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
	}
	echo "</select>";
	echo "<select name='CmbAno' size='1' style='width:70px;' onchange='Recarga()'>";
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
	{
		if ($Proceso=='M')
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
	}
	echo "</select>";
	echo "<select name='CmbTipoGuia' style='width:150' onchange='Recarga();'>";
	switch ($CmbTipoGuia)
	{
		case "G":
			echo "<option value='G' selected>Creadas/Generadas</option>";
			echo "<option value='V'>Anuladadas</option>";
			break;
		case "V":
			echo "<option value='G'>Creadas/Generadas</option>";
			echo "<option value='V' selected>Anuladadas</option>";
			break;
		default:	
			echo "<option value='G' selected>Creadas/Generadas</option>";
			echo "<option value='V'>Anuladadas</option>";
			break;
	}
	echo "</select>";
	echo "</td>";
	echo "<td>";
		echo "Rev Ok&nbsp;"; 
		echo "<input type='text' style='width:15' style= 'background:green' >"; 
		echo "Rev Venc&nbsp;"; 
		echo "<input type='text' style='width:15' style= 'background:red' >"; 
	echo "</td>";
	echo "</tr>";
	echo "</table><br>";
    echo " <table width='730' border='1' cellpadding='2' cellspacing='0' >";
    echo "<tr class='ColorTabla01'>";
	if ($CmbTipoGuia != 'V')
	{
		echo "<td width='15'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
	}
	echo "<td width='60' align='left'>N�Guia</td>";
	echo "<td width='58' align='left'>Patente</td>";
	echo "<td width='143' align='left'>Transp</td>";
	echo "<td width='174' align='left'>Cliente</td>";
	echo "<td width='73' align='left'>Estanque</td>";
	echo "<td width='67' align='center'>Cant</td>";
	echo "<td width='67' align='left'>Tipo</td>";
	echo "<td width='65' align='left'>Estado</td>";
	echo "</tr>";
	echo "</table>";
	?>
	<div style="position:absolute; left: 18px; top: 135px; width: 755px; height: 190px; OVERFLOW: auto;" id="div2">
	<?php
	$FechaInicio=$CmbAno."-".$CmbMes."-01 00:00:01";
	$FechaTermino=$CmbAno."-".$CmbMes."-31 23:59:59";
	echo "<table width='730' border='1' cellpadding='2' cellspacing='0' >";
	$Consulta ="select t1.num_guia,t1.nro_patente,t2.nombre as transportista,t1.toneladas,t3.nombre as cliente,t4.nombre as chofer,t5.nombre_subclase,tipo_guia ";
	$Consulta.="from pac_web.guia_despacho t1 left join pac_web.transportista t2 on t1.rut_transportista = t2.rut_transportista ";
	$Consulta.="left join pac_web.clientes t3 on t1.rut_cliente = t3.rut_cliente ";
	$Consulta.="left join pac_web.choferes t4 on t2.rut_transportista = t4.rut_transportista ";
	$Consulta.="left join proyecto_modernizacion.sub_clase t5 on cod_clase ='9001' and t1.cod_estanque= t5.cod_subclase ";
	if ($CmbTipoGuia == 'V')
	{
		$Consulta.= " where (t1.fecha_hora between '".$FechaInicio."' and '".$FechaTermino."') and estado = 'N' group by t1.num_guia order by t1.num_guia desc";
	}
	else
	{
		if ($CmbTipoGuia == 'G')
		{
			$Consulta.= " where (t1.fecha_hora between '".$FechaInicio."' and '".$FechaTermino."') and (estado = 'I' or estado ='S') group by t1.num_guia order by t1.num_guia desc";
		}
		else
		{
			$Consulta.= " where (t1.fecha_hora between '".$FechaInicio."' and '".$FechaTermino."') and (estado = 'S' or estado ='I') group by t1.num_guia order by t1.num_guia desc";
		}
	}
	$Resultado=mysqli_query($link, $Consulta);
	//echo $Consulta."<br>";
	echo "<input type='hidden' name='CheckGuia'><input type='hidden' name='TxtNumGuiaO'>";
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		echo "<tr>"; 
		if ($CmbTipoGuia !='V') 	
			echo "<td width='15' align='left'><input type='checkbox' name='CheckGuia' value='checkbox'></td>";
		echo "<td width='58'><a href=\"JavaScript:Historial('".$Fila["num_guia"]."')\">\n";
		echo $Fila["num_guia"]."</a></td>\n";
		echo "<td width='60' align='left'>".$Fila["nro_patente"]."&nbsp;<input type='hidden' name ='TxtNumGuiaO' value ='".$Fila["num_guia"]."'></td>";
		echo "<td width='140' align='left'>".$Fila["transportista"]."</td>";
		echo "<td width='175' align='left'>".$Fila["cliente"]."</td>";
		echo "<td width='80' align='left'>".$Fila["nombre_subclase"]."&nbsp;</td>";
		echo "<td width='67' align='center'>".number_format($Fila["toneladas"],2)."</td>";
		if ($Fila["tipo_guia"]=='C')
			$TipoGuia='Camion';
		else
			$TipoGuia='Buque';
		echo "<td width='67' align='left'>".$TipoGuia."</td>";
		$Consulta ="select fecha_rev_tecnica,fecha_cert_estanque from pac_web.camiones_por_transportista where nro_patente = '".$Fila["nro_patente"]."' ";
		$Respuesta2=mysqli_query($link, $Consulta);
		$Fila2=mysqli_fetch_array($Respuesta2);
		if ((date($Fila2[fecha_rev_tecnica])) < (date($Fecha_Hora)))
			echo "<td width='68' align='center'><input type='text' style='width:20' style= 'background:red' ></td>";
		else
			echo "<td width='68' align='center'><input type='text' style='width:20' style= 'background:green' ></td>";
		echo "</tr>";
	}
	echo "</table>";
	?>
	</div>
    <br>
	<div style="position:absolute; left: 15px; top: 337px; width: 750px; height: 210px; OVERFLOW: auto;" id="div2">	
    <table width="730" border="0" class="tablainterior">
      <tr> 
        <td align="center">
		<?php
		if (($CmbTipoGuia!='V'))
	    {
			 echo "<input type='button' name='BtnNuevo' value='Nuevo' style='width:75' onClick=\"MostrarPopupProceso('N');\">";
			 echo " &nbsp; <input type='button' name='BtnModificar' value='Modificar' style='width:75' onClick=\"MostrarPopupProceso('M');\"> ";
			 echo "&nbsp; <input name='BtnAnular' type='button' id='BtnAnular' style='width:75' onClick=\"MostrarPopupProceso('A');\" value='Anular'>";
        	 echo "&nbsp; <input type='button' name='BtnGenerar' value='Vista Previa' style='width:75' onClick=Generar('P');>";
			 echo "&nbsp; <input type='button' name='BtnImprimir' value='Imprimir' style='width:75' onClick=Generar('I');>";
			 echo "&nbsp; <input type='button' name='BtnSalir' value='Salir' style='width:75' onClick='Salir();'>";
	         echo" &nbsp;";
		 }
		if ($CmbTipoGuia=='G')
		{
			/*echo "&nbsp; <input type='button' name='BtnGenerar' value='Generar' style='width:60' onClick='Generar();'>";
	    	echo "&nbsp; <input name='BtnAnular' type='button' id='BtnAnular' style='width:60' onClick=\"MostrarPopupProceso('A');\" value='Anular'>";
			echo " &nbsp;";*/
		}
		if (($CmbTipoGuia=='V'))
		{ 
		 	echo "<input name='BtnSalir' type='button' id='BtnCancelar' style='width:60' onClick='Salir2();' value='Salir'>";
		}
       ?>
	  </td>
	  </tr>
    </table>
	</div>
    <br></td></tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>

