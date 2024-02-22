<?php
	/*session_start();
	session_register("Datos");
	if (session_is_registered("Datos")) 
	{
		$Datos=array();
	}*/
	include("../principal/conectar_principal.php");
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


	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
	$Solicitudes=$ValoresSA;
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
	var Frm=document.FrmIngresoValorHum;
	var ValoresSA="";
	var Valores="";
	
	ValoresSA=Solicitudes;
	for(i=1;i<Frm.CheckCandado.length;i++)
	{
		if (isNaN(Number(Frm.TxtPesoH[i].value.replace(",",".")))) 
		{
			alert("Peso Humedo Ingresado no es Valido");
			Frm.TxtPesoH[i].focus();
			return;
		}
		if (isNaN(Number(Frm.TxtPesoS[i].value.replace(",",".")))) 
		{
			alert("Peso Seco Ingresado no es Valido");
			Frm.TxtPesoS[i].focus();
			return;
		}
		if ((Number(Frm.TxtPesoS[i].value))< (Number(Frm.TxtPesoH[i].value)))
		{
			Valores=Valores+Frm.TxtSAO[i].value +"~~"+Frm.TxtRutO[i].value+"||"+Frm.TxtCodLeyesO[i].value+""+Frm.TxtRecargoO[i].value+"//"+Frm.TxtValor[i].value+"!!"+Frm.CmbUnidad[i].value+"??"+Frm.TxtPesoH[i].value+"@@"+Frm.TxtPesoS[i].value+"**";
		}
		else
		{
			if ((Frm.TxtPesoS[i].value!='') && (Frm.TxtPesoH[i].value!=''))
			{
				alert("Peso Seco debe ser menor que Peso Humedo");
				Frm.TxtValor[i].value='';
				Frm.TxtPesoS[i].focus();
				return;
				break;
			}
		}	
	}
	Frm.action="cal_ingreso_valor_humedad01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=H&Opcion=G&CheckT=N";
	Frm.submit();
}

function Seguridad(CB,ValoresSA,Tipo)
{
	var Frm=document.FrmIngresoValorHum;
	var Valores = "";
	var ValoresAux="";
	
	ValoresAux=Frm.TxtSAO[CB.value].value +"~~"+Frm.TxtRutO[CB.value].value+"||"+Frm.TxtCodLeyesO[CB.value].value+""+Frm.TxtRecargoO[CB.value].value+"//"+Frm.TxtValor[CB.value].value;
	if (Frm.TxtCandadoO[CB.value].value == '1')
	{
		window.open("cal_desbloquear_leyes.php?ValoresSA="+ValoresSA+"&Valores="+ValoresAux+"&Tipo=H","","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
	}
	else
	{
		if (Frm.TxtPesoH[CB.value].value=="") 
		{
			alert("Debe Ingresar Peso Humedo");
			Frm.TxtPesoH[CB.value].focus();
			Frm.CheckCandado[CB.value].checked=false;
			return;
		}
		if (Frm.TxtPesoS[CB.value].value=="") 
		{
			alert("Debe Ingresar Peso Seco");
			Frm.TxtPesoS[CB.value].focus();
			Frm.CheckCandado[CB.value].checked=false;
			return;
		}
		if (isNaN(Number(Frm.TxtPesoH[CB.value].value.replace(",",".")))) 
		{
			alert("Peso Humedo Ingresado no es Valido");
			Frm.TxtPesoH[CB.value].focus();
			Frm.CheckCandado[CB.value].checked=false;
			return;
		}
		if (isNaN(Number(Frm.TxtPesoS[CB.value].value.replace(",",".")))) 
		{
			alert("Peso Seco Ingresado no es Valido");
			Frm.TxtPesoS[CB.value].focus();
			Frm.CheckCandado[CB.value].checked=false;
			return;
		}
		if ((Number(Frm.TxtPesoS[CB.value].value))<(Number(Frm.TxtPesoH[CB.value].value)))
		{

		}
		else
		{
			if ((Frm.TxtPesoS[CB.value].value!='') && (Frm.TxtPesoH[CB.value].value!=''))
			{
				alert("Peso Seco debe ser menor que Peso Humedo");
				Frm.TxtValor[CB.value].value='';
				Frm.CheckCandado[CB.value].checked=false;				
				Frm.TxtPesoS[CB.value].focus();
				return;
			}	
		}
		Valores=Frm.TxtSAO[CB.value].value +"~~"+Frm.TxtRutO[CB.value].value+"||"+Frm.TxtCodLeyesO[CB.value].value+""+Frm.TxtRecargoO[CB.value].value+"//"+Frm.TxtValor[CB.value].value+"!!"+Frm.CmbUnidad[CB.value].value+"??"+Frm.TxtPesoH[CB.value].value+"@@"+Frm.TxtPesoS[CB.value].value+"**";				
		Frm.action="cal_ingreso_valor_humedad01.php?Opcion=G&ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=H"+"&ValoresAux="+ValoresAux+"&PonerCandado=S";
		Frm.submit();	
	}
}

function Todos(Solicitudes)
{
	
	var Frm=document.FrmIngresoValorHum;
	var ValoresSA="";
	var Valores="";
	ValoresSA=Solicitudes;
	if (Frm.CheckTodos.checked==false)
	{
		return;
	}
	for(i=1;i<Frm.CheckCandado.length;i++)
	{
		if (Frm.TxtPesoH[i].value=="") 
		{
			alert("Debe Ingresar Peso Humedo");
			Frm.TxtPesoH[i].focus();
			Frm.CheckTodos.checked=false;
			return;
		}
		if (Frm.TxtPesoS[i].value=="") 
		{
			alert("Debe Ingresar Peso Seco");
			Frm.TxtPesoS[i].focus();
			Frm.CheckTodos.checked=false;
			return;
		}
		if (isNaN(Number(Frm.TxtPesoH[i].value.replace(",",".")))) 
		{
			alert("Peso Humedo Ingresado no es Valido");
			Frm.TxtPesoH[i].focus();
			Frm.CheckTodos.checked=false;
			return;
		}
		if (isNaN(Number(Frm.TxtPesoS[i].value.replace(",",".")))) 
		{
			alert("Peso Seco Ingresado no es Valido");
			Frm.TxtPesoS[i].focus();
			Frm.CheckTodos.checked=false;
			return;
		}
		if ((Number(Frm.TxtPesoS[i].value))< (Number(Frm.TxtPesoH[i].value)))
		{
			Valores=Valores+Frm.TxtSAO[i].value +"~~"+Frm.TxtRutO[i].value+"||"+Frm.TxtCodLeyesO[i].value+""+Frm.TxtRecargoO[i].value+"//"+Frm.TxtValor[i].value+"!!"+Frm.CmbUnidad[i].value+"??"+Frm.TxtPesoH[i].value+"@@"+Frm.TxtPesoS[i].value+"**";
		}
		else
		{
			if ((Frm.TxtPesoS[i].value!='') && (Frm.TxtPesoH[i].value!=''))
			{
				alert("Peso Seco debe ser menor que Peso Humedo");
				Frm.TxtValor[i].value='';
				Frm.CheckTodos.checked=false;
				Frm.TxtPesoS[i].focus();
				return;
				break;
			}
		}	
	}
	Frm.action="cal_ingreso_valor_humedad01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=H&Opcion=G&PonerCandado=S&CheckT=S";
	Frm.submit();
}
function Eliminar(Solicitudes)
{
	var Frm=document.FrmIngresoValorHum;
	var ValoresSA="";
	var CheckeoLeyes="";
	var Respuesta ="";
	var ValoresCheck="";
	
	CheckeoLeyes=false;
	ValoresSA=Solicitudes;
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
			Frm.action="cal_seleccion_leyes01.php?Pantalla=H&ValoresSA="+ValoresSA+"&ValoresCheck="+ValoresCheck+"&Proceso=E";
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
function Salir(Valores)
{
	var Frm=document.FrmIngresoValorHum;
	Frm.action="cal_ingreso_valor_Humedad01.php?Opcion=S&Valores="+Valores;
	Frm.submit();
}

/*function CalcularHum(CB)
{
	var Frm=document.FrmIngresoValorHum;
	alert(CB.value);
}*/
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngresoValorHum" method="post" action="">
  <table width="710" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td width="720"><div align="center"></div>
        <table width="710" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Ingreso Valores de Humedad</div></td>
          </tr>
        </table>
		<br>
        <table width="710" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="387">Quimico: 
              <?php  
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
			?>
            </td>
            <td width="297">
                <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:60" onClick="Eliminar('<?php echo $Solicitudes;?>');" value="Eliminar">
				<input name="BtnGrabar2" type="button" id="BtnGrabar23" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Solicitudes;?>');">
                <input name="BtnSalir2" type="button" id="BtnSalir23" value="Salir" style="width:60" onClick="JavaScript:window.close();">
              </td>
          </tr>
        </table>
        <table width="711"  border="0" >
          <tr>
            <?php
	        	$Consulta ="select count(t1.candado) as encontro from cal_web.leyes_por_solicitud t1 where (".$Criterio.") and (t1.cod_leyes='01') and (t1.candado='0')";
				$RespTodosCandados=mysqli_query($link, $Consulta);
				$FilaTodosCandados=mysqli_fetch_array($RespTodosCandados);
				if ($FilaTodosCandados[encontro]==0)
				{
					$CheckT="S";
				}
				else
				{
					$CheckT="N";
				}
				if ($CheckT=="S")
				{
					echo "<td align='right'><input type='checkbox' name='CheckTodos' checked value='checkbox' onClick=Todos('$Solicitudes')>Todos&nbsp;<img src='../principal/imagenes/cand_cerrado.gif'></td>";
				}
				else
				{
					echo "<td align='right'><input type='checkbox' name='CheckTodos' value='checkbox' onClick=Todos('$Solicitudes')>Todos&nbsp;<img src='../principal/imagenes/cand_abierto.gif'></td>";
				}	
			?>	
          </tr>
        </table>
		<table width="710" height="51" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
        <tr class="ColorTabla01" align="center">
		  <td width="50" height="20"></td>	
  		  <td width="79" height="20">Solicitud</td>
		  <td width="70" height="20">Recargo</td>
          <td width="53" height="20">Ley</td>
          <td width="80">Peso Humedo</td>
          <td width="80">Peso Seco</td>			  
          <td width="80">Valor</td>
          <td width="79">Unidad</td>
		  <td width="78">Candado</td>
        </tr>
		<?php
        	$Consulta ="select t1.observacion,t1.cod_leyes,t1.nro_solicitud,t1.rut_funcionario,t1.recargo,t2.abreviatura,t1.valor,t1.cod_unidad,t1.candado,t1.peso_humedo,t1.peso_seco,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes  and t2.cod_leyes = '01' where ".$Criterio." order by t1.nro_solicitud,recargo_ordenado";
			$Respuesta=mysqli_query($link, $Consulta);
			$Cont=1;
			echo "<input type='hidden' name ='CheckSA'><input type='hidden' name ='CheckCandado'><input type='hidden' name ='TxtCandadoO'><input type='hidden' name ='TxtSAO'><input type='hidden' name ='TxtRutO'><input type='hidden' name ='TxtCodLeyesO'><input type='hidden' name ='TxtRecargoO'><input type='hidden' name='TxtValor'><input type='hidden' name='CmbUnidad'><input type='hidden' name='TxtPesoH'><input type='hidden' name='TxtPesoS'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{	
				if($Fila["observacion"]==$CookieRut)
					$Popup='S';	
				echo "<tr align='center'>";
				echo "<td height='15'><input type='checkbox' name='CheckSA'></td>";
				echo "<td height='28'><input type='text' name='TxtNroSA' style='width:100' disabled value = '".$Fila["nro_solicitud"]."'></td>";
				if ((!is_null($Fila["recargo"])) and ($Fila["recargo"]!=''))
				{
					echo "<td height='28'><input type='text' name='TxtRecargo' style='width:70' disabled value = '".$Fila["recargo"]."'></td>";
				}
				else
				{
					echo "<td height='28'><input type='text' name='TxtRecargo' style='width:70' disabled value = 'Sin Recargo'></td>";
				}
				echo "<td height='28'><input type='text' name='TxtLey' style='width:75' disabled value = '".$Fila["abreviatura"]."'></td>";
				if ($Fila["candado"]=='1')
				{
					echo "<td height='28'><input type='text' name='TxtPesoH' style='width:100' disabled value = '".$Fila["peso_humedo"]."'></td>";
					echo "<td height='28'><input type='text' name='TxtPesoS' style='width:100' disabled value = '".$Fila["peso_seco"]."' ></td>";
					echo "<td><input type='text' name='TxtValor' style='width:60' disabled value = '".$Fila["valor"]."'></td>";				
					echo "<td><select name='CmbUnidad' style='width:75' disabled>";
				}
				else
				{
					if (is_null($Fila["peso_humedo"])||($Fila["peso_humedo"]==''))
					{
						echo "<td height='28'><input type='text' name='TxtPesoH' style='width:100' value = '500'></td>";
					}
					else
					{
						echo "<td height='28'><input type='text' name='TxtPesoH' style='width:100' value = '".$Fila["peso_humedo"]."'></td>";					
					}	
					echo "<td height='28'><input type='text' name='TxtPesoS' style='width:100' value = '".$Fila["peso_seco"]."'></td>";
					echo "<td><input type='text' name='TxtValor' style='width:60' disabled value = '".$Fila["valor"]."'></td>";				
					echo "<td><select name='CmbUnidad' style='width:75'>";				
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
				/*$Datos[$Cont][0]=$TxtCandadoO;
				$Datos[$Cont][1]=$TxtSAO;
				$Datos[$Cont][2]=$TxtRutO;
				$Datos[$Cont][3]=$TxtCodLeyesO;
				$Datos[$Cont][4]=$TxtRecargoO;
				$Datos[$Cont][5]=$TxtValor;
				$Datos[$Cont][6]=$CmbUnidad;
				$Datos[$Cont][7]=$TxtPesoH;
				$Datos[$Cont][0]=$TxtPesoS;*/
				$Cont=$Cont + 1;
			}
		?>
      </table>
      <br>
      <table width="710" border="0" cellpadding="5">
        <tr>
          <td width="341"><div align="right">
              <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Solicitudes;?>');">
            </div></td>
          <td width="343"><input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
        </tr>
      </table> </td>
	  </tr>
	  </table>
   </form>
</body>
</html><?php

if($Popup=='S')
{
	?>
	<script language="javascript">
	window.open("cal_fuera_rango_leyes.php?&RutFunt=<?php echo $Rut;?>&Recargo=<?php echo $Recargo;?>","","top=200,left=35,width=640,height=300,scrollbars=yes,resizable = yes,status=yes");					
	</script>
	<?php
}