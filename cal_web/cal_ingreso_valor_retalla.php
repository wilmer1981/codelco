<?php
	include("../principal/conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];
	$Fecha_Hora = date("Y-m-d");

	if(isset($_REQUEST["ValoresSA"])) {
		$ValoresSA = $_REQUEST["ValoresSA"];
	}else{
		$ValoresSA = "";
	}
	if(isset($_REQUEST["CheckT"])) {
		$CheckT = $_REQUEST["CheckT"];
	}else{
		$CheckT = "";
	}
	if(isset($_REQUEST["FechaBusqueda"])) {
		$FechaBusqueda = $_REQUEST["FechaBusqueda"];
	}else{
		$FechaBusqueda = "";
	}
	$Popup = isset($_REQUEST["Popup"])?$_REQUEST["Popup"]:"";

	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
	$Solicitudes=$ValoresSA;
	$Criterio = "";
	for ($j = 0;$j <= strlen($ValoresSA); $j++)
	{
		if (substr($ValoresSA,$j,2) == "//")
		{
			$SARutRecargo = substr($ValoresSA,0,$j);
			for ($x=0;$x<=strlen($SARutRecargo);$x++)
			{
				if (substr($SARutRecargo,$x,2) == "~~")
				{
					$SA = substr($SARutRecargo,0,$x);			
					$RutRecargo=substr($SARutRecargo,$x+2,strlen($SARutRecargo));
					for ($y=0;$y<=strlen($RutRecargo);$y++)
					{
						if (substr($RutRecargo,$y,2) == "||")
						{
							$Rut = substr($RutRecargo,0,$y);
							$Recargo=substr($RutRecargo,$y+2,strlen($RutRecargo));
							if ($Recargo =='N')
							{
								$Criterio=$Criterio."(nro_solicitud =".$SA." and rut_funcionario='".$Rut."') or ";   
							}
							else
							{
								$Criterio=$Criterio."(nro_solicitud =".$SA." and rut_funcionario='".$Rut."' and recargo='".$Recargo."') or ";   							
							}		
						}	
					}
				}
			}	
			$ValoresSA = substr($ValoresSA,$j + 2);
			$j = 0;
		}
	}			
	$Criterio = substr($Criterio,0,strlen($Criterio)-3);
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Solicitudes)
{
	var Frm=document.FrmIngresoValorRetalla;
	var ValoresSA="";
	var Valores="";
	var Valor="";
	
	ValoresSA=Solicitudes;
	for(i=1;i<Frm.CheckCandado.length;i++)
	{
		Valor=Frm.TxtValor[i].value.toUpperCase();
		if (isNaN(Number(Frm.TxtValor[i].value.replace(",",".")))) 
		{
			if ((Valor!="ND") && (Valor!=""))
			{
				alert("Numero Ingresado no es Valido");
				Frm.TxtValor[i].focus();
				return;
			}		
		}
		if (Valor!="")
		{
			Valores=Valores+Frm.TxtSAO[i].value +"~~"+Frm.TxtRutO[i].value+"||"+Frm.TxtCodLeyesO[i].value+""+Frm.TxtRecargoO[i].value+"//"+Valor+"!!"+Frm.CmbUnidad[i].value+Frm.CmbSigno[i].value+"**";
		}		
		
	}
	if (Valores!="")
	{
		Frm.action="cal_ingreso_valor_leyes01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=R&Opcion=G";
		Frm.submit();
	}
}
function PesoRetalla(Solicitudes)
{
	var Frm=document.FrmIngresoValorRetalla;
	var ValoresSA="";
	
	ValoresSA=Solicitudes;
	window.open("cal_ingreso_peso_retalla.php?ValoresSA="+ValoresSA,"","top=150,left=175,width=355,height=280,scrollbars=yes,resizable = no");	
}

function Seguridad(CB,ValoresSA,Tipo)
{
	var Frm=document.FrmIngresoValorRetalla;
	var Valores = "";
	var ValoresAux="";
	var Valor="";
			
	ValoresAux=Frm.TxtSAO[CB.value].value +"~~"+Frm.TxtRutO[CB.value].value+"||"+Frm.TxtCodLeyesO[CB.value].value+""+Frm.TxtRecargoO[CB.value].value+"//"+Frm.TxtValor[CB.value].value;
	if (Frm.TxtCandadoO[CB.value].value == '1')
	{
		window.open("cal_desbloquear_leyes.php?ValoresSA="+ValoresSA+"&Valores="+ValoresAux+"&Tipo=R","","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
	}
	else
	{
		Valor=Frm.TxtValor[CB.value].value.toUpperCase();
		if (isNaN(Number(Frm.TxtValor[CB.value].value.replace(",",".")))) 
		{
			if ((Valor!="ND") && (Valor!=""))
			{
				alert("Numero Ingresado no es Valido");
				CB.checked=false;
				Frm.TxtValor[CB.value].focus();
				return;
			}		
		}
		if (Valor!="")
		{
			Valores=Valores+Frm.TxtSAO[CB.value].value +"~~"+Frm.TxtRutO[CB.value].value+"||"+Frm.TxtCodLeyesO[CB.value].value+""+Frm.TxtRecargoO[CB.value].value+"//"+Valor+"!!"+Frm.CmbUnidad[CB.value].value+Frm.CmbSigno[CB.value].value+"**";		
			Frm.action="cal_ingreso_valor_leyes01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=R&Opcion=G&PonerCandado=S";
			Frm.submit();
		}
		else
		{
			CB.checked=false;
			return;		
		}		
	}
}
function Modificar(Solicitudes,Proceso)
{
	var Frm=document.FrmIngresoValorRetalla;
	var ValoresSA="";
	var SA="";
	var Ley="";
	var Recargo="";
	var CheckeoLeyes="";
	var Respuesta ="";
	var ValoresCheck="";
	
	CheckeoLeyes=false;
	ValoresSA=Solicitudes;
	if (Proceso=='E')
	{
		Respuesta=confirm("Esta Seguro de Eliminar la Ley ");
		if (Respuesta==true)
		{
			for(i=1;i<Frm.CheckSA.length;i++)
			{
				if (Frm.CheckSA[i].checked==true)
				{
					CheckeoLeyes=true;
					ValoresCheck=ValoresCheck+Frm.TxtSAO[i].value+"~~"+Frm.TxtRecargoO[i].value+"||"+Frm.TxtCodLeyesO[i].value+"//";
				}
			}
			if (CheckeoLeyes==true)
			{
				Frm.action="cal_seleccion_leyes01.php?Pantalla=R&ValoresSA="+ValoresSA+"&ValoresCheck="+ValoresCheck+"&Proceso="+Proceso;
				Frm.submit();
			}
			else
			{
				alert("Debe Seleccionar Solicitud");
				return;
			}
		}
		else
		{
			return;
		}	
	}
	else
	{
		for(i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckSA[i].checked==true)
			{
				CheckeoLeyes=true;
				SA=Frm.TxtSAO[i].value;
				Ley=Frm.TxtCodLeyesO[i].value;
				Recargo=Frm.TxtRecargoO[i].value;
				break;
			}
		}
		if (CheckeoLeyes==true)
		{
			window.open("cal_seleccion_leyes.php?Pantalla=R&ValoresSA="+ValoresSA+"&SA="+SA+"&Recargo="+Recargo+"&Ley="+Ley+"&Proceso="+Proceso,"","top=100,left=20,width=700,height=550,scrollbars=yes,resizable = no");	
		}
		else
		{
			alert("Debe Seleccionar Solicitud");
			return;
		}
	}		
}

function Todos(Solicitudes)
{
	var Frm=document.FrmIngresoValorRetalla;
	var ValoresSA="";
	var Valores="";
	var Valor="";
	
	ValoresSA=Solicitudes;
	if (Frm.CheckTodos.checked==false)
	{
		return;
	}
	for(i=1;i<Frm.CheckCandado.length;i++)
	{
		Valor=Frm.TxtValor[i].value.toUpperCase();
		if (isNaN(Number(Frm.TxtValor[i].value.replace(",",".")))) 
		{
			if ((Valor!="ND") && (Valor!=""))
			{
				alert("Numero Ingresado no es Valido");
				CB.checked=false;
				Frm.TxtValor[i].focus();
				return;
			}		
		}
		if (Valor!="")
		{		
			Valores=Valores+Frm.TxtSAO[i].value +"~~"+Frm.TxtRutO[i].value+"||"+Frm.TxtCodLeyesO[i].value+""+Frm.TxtRecargoO[i].value+"//"+Valor+"!!"+Frm.CmbUnidad[i].value+Frm.CmbSigno[i].value+"**";
		}	
	}
	if (Valores!="")
	{
		Frm.action="cal_ingreso_valor_leyes01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=R&Opcion=G&PonerCandado=S";
		Frm.submit();
	}	

}
function Salir(Valores)
{
	var Frm=document.FrmIngresoValorRetalla;
	Frm.action="cal_ingreso_valor_leyes01.php?Opcion=S&Valores="+Valores;
	Frm.submit();
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngresoValorRetalla" method="post" action="">
  <table width="510" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="490" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Ingreso de Valores Retalla</div></td>
          </tr>
        </table>
		<br>
        <table width="490" border="0" cellpadding="5" class="TablaInterior">
          <tr>
            <td>Quimico:
			<?php  
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
			?>						
			</td>
          </tr>
        </table><br>
            <?php
				echo "<table width='490' border='0' cellpadding='5' class='TablaInterior'>";
				echo "<tr>";
				echo "<td>";
				echo "<input name='BtnPeso2' type='button' value='Peso Retalla' style='width:80' onClick=PesoRetalla('$Solicitudes');>&nbsp;";
				echo "<input name='BtnEliminar2' type='button' id='BtnEliminar' style='width:60' onClick=Modificar('$Solicitudes','E'); value='Eliminar'>&nbsp;"; 
            	echo "<input name='BtnGrabar2' type='button' value='Grabar' style='width:80' onClick=Grabar('$Solicitudes');>&nbsp;";
                echo "<input name='BtnSalir2' type='button' value='Salir' style='width:80' onClick=JavaScript:window.close();>";				
				$Consulta ="select count(t1.candado) as encontro from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes and tipo_leyes = 0 where (".$Criterio.") and (t1.candado='0')";
				$RespTodosCandados=mysqli_query($link, $Consulta);
				$FilaTodosCandados=mysqli_fetch_array($RespTodosCandados);
				if ($FilaTodosCandados["encontro"]==0)
				{
					echo "<td align='right'>&nbsp;Todos<input type='checkbox' name='CheckTodos' checked value='checkbox' onClick=Todos('$Solicitudes')>&nbsp;&nbsp;<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				}
				else
				{
					echo "<td align='right'>&nbsp;Todos<input type='checkbox' name='CheckTodos' value='checkbox' onClick=Todos('$Solicitudes')>&nbsp;&nbsp;<img src='../principal/imagenes/cand_abierto.gif'>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				}
				echo "</td>";
				echo "</tr>";
				echo "</table>";
			?><br>	
		<table width="490" height="51" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
        <tr class="ColorTabla01" align="center">
		  <td width="50" height="20"></td>	
  		  <td width="91" height="20">Solicitud</td>
          <td width="91" height="20">Ley</td>
		  <td width="86">Signo</td>		  
          <td width="86">Valor</td>
          <td width="108">Unidad</td>
		  <td width="88">Candado</td>
        </tr>
		<?php
        	$Consulta ="select t1.observacion,t1.cod_leyes,t1.nro_solicitud,t1.rut_funcionario,t1.recargo,t2.abreviatura,t1.valor,t1.cod_unidad,t1.candado,t1.signo from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes where ".$Criterio." order by t1.nro_solicitud,t1.cod_leyes";
			$Respuesta=mysqli_query($link, $Consulta);
			$Cont=1;
			echo "<input type='hidden' name ='CheckSA'><input type='hidden' name ='CheckCandado'><input type='hidden' name ='TxtCandadoO'><input type='hidden' name ='TxtSAO'><input type='hidden' name ='TxtRutO'><input type='hidden' name ='TxtCodLeyesO'><input type='hidden' name ='TxtRecargoO'><input type='hidden' name='TxtValor'><input type='hidden' name='CmbUnidad'><input type='hidden' name='CmbSigno'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if($Fila["observacion"]==$CookieRut)
					$Popup='S';	
				echo "<tr align='center'>";
				echo "<td height='15'><input type='checkbox' name='CheckSA'></td>";
				echo "<td height='28'><input type='text' name='TxtNroSA' style='width:100' disabled value = ".$Fila["nro_solicitud"]."></td>";
				echo "<td height='28'><input type='text' name='TxtLey' style='width:75' disabled value = '".$Fila["abreviatura"]."'></td>";
				if ($Fila["candado"]=='1')
				{
					echo "<td><select name='CmbSigno' style='width:40' disabled>";
				}
				else
				{
					echo "<td><select name='CmbSigno' style='width:40'>";
				}
				if (($Fila["signo"]=='N')||($Fila["signo"]=='=')||(is_null($Fila["signo"]))||($Fila["signo"]==''))
				{
					echo "<option  value='=' selected>=</option>";
					echo "<option  value='>'>></option>";
					echo "<option  value='<'><</option>";
				}	
				if ($Fila["signo"]=='>')
				{
					echo "<option  value='>' selected>></option>";
					echo "<option  value='='>=</option>";
					echo "<option  value='<'><</option>";
				}
				if ($Fila["signo"]=='<')
				{
					echo "<option  value='<' selected><</option>";
					echo "<option  value='>'>></option>";
					echo "<option  value='='>=</option>";
				}
				echo "</select></td>";
				if ($Fila["candado"]=='1')
				{
					if ($Fila["signo"]=='N')
					{
						echo "<td><input type='text' name='TxtValor' style='width:60' disabled value = 'ND'></td>";
						echo "<td><select name='CmbUnidad' style='width:75' disabled>";
					}
					else
					{
						echo "<td><input type='text' name='TxtValor' style='width:60' disabled value = ".$Fila["valor"]."></td>";
						echo "<td><select name='CmbUnidad' style='width:75' disabled>";
					}	
				}
				else
				{
					if ($Fila["signo"]=='N')
					{
						echo "<td><input type='text' name='TxtValor' style='width:60' value = 'ND'></td>";
						echo "<td><select name='CmbUnidad' style='width:75'>";
					}
					else
					{
						echo "<td><input type='text' name='TxtValor' style='width:60' value = ".$Fila["valor"]."></td>";
						echo "<td><select name='CmbUnidad' style='width:75'>";
					}					
				}	
				$Consulta="select abreviatura,cod_unidad from proyecto_modernizacion.unidades order by abreviatura";
				$Respuesta2=mysqli_query($link, $Consulta);
				while($Fila2=mysqli_fetch_array($Respuesta2))
				{
					if (($Fila2["cod_unidad"])==($Fila["cod_unidad"]))
					{
						echo "<option  value='".$Fila2["cod_unidad"]."' selected>".$Fila2["abreviatura"]."</option>";
					}
					else
					{
						echo "<option value='".$Fila2["cod_unidad"]."'>".$Fila2["abreviatura"]."</option>";						
					}	
				}
				echo "</select></td>";
				if ((!is_null($Fila["recargo"])) and ($Fila["recargo"]!=''))
				{
					$Recargo=$Fila["recargo"];
				}
				else
				{
					$Recargo='N';				
				}
				if ($Fila["candado"]=='1')
				{
					echo "<td align='left'><input type='Checkbox' name ='CheckCandado' value = '".$Cont."' checked onclick =\"Seguridad(this,'$Solicitudes');\">&nbsp;&nbsp;&nbsp;";
					echo "<img src='../principal/imagenes/cand_cerrado.gif' ><input type='hidden' name ='TxtCandadoO' value='1'><input type='hidden' name ='TxtSAO' value = ".$Fila["nro_solicitud"]."><input type='hidden' name ='TxtRutO' value = ".$Fila["rut_funcionario"]."><input type='hidden' name ='TxtCodLeyesO' value = ".$Fila["cod_leyes"]."><input type='hidden' name ='TxtRecargoO' value = ".$Recargo."></td>";
				}
				else
				{
					echo "<td align='left'><input type='Checkbox' name ='CheckCandado' value='".$Cont."' onclick=\"Seguridad(this,'$Solicitudes');\">&nbsp;&nbsp;&nbsp;";
					echo "<img src='../principal/imagenes/cand_abierto.gif' ><input type='hidden' name ='TxtCandadoO' value='0'><input type='hidden' name ='TxtSAO' value = ".$Fila["nro_solicitud"]."><input type='hidden' name ='TxtRutO' value = ".$Fila["rut_funcionario"]."><input type='hidden' name ='TxtCodLeyesO' value = ".$Fila["cod_leyes"]."><input type='hidden' name ='TxtRecargoO' value = ".$Recargo."></td>";				
				}	
				echo "</tr>";
				$Cont=$Cont + 1;
			}
		?>
      </table>
      <br>
      <table width="490" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td align="left">
			<input name="BtnPeso" type="button" value="Peso Retalla" style="width:60" onClick="PesoRetalla('<?php echo $Solicitudes;?>');">&nbsp;
			<input name="BtnEliminar" type="button" id="BtnEliminar" style="width:60" onClick="Modificar('<?php echo $Solicitudes;?>','E');" value="Eliminar"> 
            <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Solicitudes;?>');">&nbsp;
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
          </tr>
        </table> </td>
	  </tr>
	  </table>
   </form>
</body>
</html>
<?php
$Popup='N';
if($Popup=='S')
{
	?>
	<script language="javascript">
	window.open("cal_fuera_rango_leyes.php?&RutFunt=<?php echo $Rut;?>&Recargo=<?php echo $Recargo;?>","","top=200,left=35,width=640,height=300,scrollbars=yes,resizable = yes,status=yes");					
	</script>
	<?php
}