<?php
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("Y-m-d");
	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
	$ValoresSA=str_replace('||','~~',$ValoresSA);
	$ValoresSA = substr($ValoresSA,0,strlen($ValoresSA)-2);	
	$Datos=explode('//',$ValoresSA);
	while(list($c,$v)=each($Datos))
	{
		$Datos2=explode('~~',$v);
		$SA=$Datos2[0];
		$Rut=$Datos2[1];
		$Recargo=$Datos2[2];
		if ($Recargo =='N')
		{
			$Criterio=$Criterio."(nro_solicitud =".$SA." and rut_funcionario='".$Rut."') or ";   
		}
		else
		{
			$Criterio=$Criterio."(nro_solicitud =".$SA." and rut_funcionario='".$Rut."' and recargo='".$Recargo."') or ";   							
		}		
	}
	$Criterio = substr($Criterio,0,strlen($Criterio)-3);	
?>
<html>
<head>
<script language="JavaScript">
function CheckearTodo()
{
	var Frm=document.FrmIngresoValorLeyes;
	try
	{
		Frm.CheckSA[0];
		for (i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckTodos.checked==true&&Frm.CheckSA[i].disabled==false)
			{
				Frm.CheckSA[i].checked=true;
			}
			else
			{
				Frm.CheckSA[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function Grabar(Solicitudes)
{
	var Frm=document.FrmIngresoValorLeyes;
	var ValoresSA="";
	var Valores="";
	var Valor="";
	ValoresSA=Solicitudes;
	for(i=1;i<Frm.CheckSA.length;i++)
	{
		if(Frm.CheckSA[i].checked==true)
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
				Valores=Valores+Frm.CheckSA[i].value+"~~"+Valor+"~~"+Frm.CmbUnidad[i].value+"//";
			}
		}	
	}
	if (Valores!="")
	{
		Frm.action="cal_ingreso_valor_leyes_virtuales01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=L&Opcion=G";
		Frm.submit();
	}
	else
	{
		alert('Debe Seleccionar un elemento');
	}
}
function Salir(Valores)
{
	var Frm=document.FrmIngresoValorLeyes;
	Frm.action="cal_ingreso_valor_leyes_virtuales01.php?Opcion=S&Valores="+Valores;
	Frm.submit();
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngresoValorLeyes" method="post" action="">
  <table width="510" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="490" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Ingreso de Valores Leyes Virtuales</div></td>
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
        </table>
        <BR>    
        <table width="490" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td align="right">
            <input name="BtnGrabar2" type="button" id="BtnGrabar2" value="Grabar" style="width:60" onClick="Grabar('<?php echo $ValoresSA;?>');">
            <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="JavaScript:window.close();">
			</td>
          </tr>
        </table>
		<BR>
        <table width="490" height="51" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
        <tr class="ColorTabla01" align="center">
		  <td width="50" height="20"><input name="CheckTodos" type="checkbox" onClick="CheckearTodo()"></td>	
  		  <td width="91" height="20">Solicitud</td>
          <td width="91" height="20">Ley</td>
          <td width="86">Valor</td>
          <td width="108">Unidad</td>
        </tr>
		<?php
        	$Consulta ="select t1.virtual as virt,t1.fecha_hora,t1.cod_leyes,t1.nro_solicitud,t1.cod_producto,t1.rut_funcionario,t1.recargo,t2.abreviatura,";
			$Consulta.="t1.valor2,t1.cod_unidad,t1.candado,t1.signo from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";
			$Consulta.="and t2.cod_leyes <> '01' and t2.cod_leyes in('02','04','05') and (tipo_leyes = 0 or tipo_leyes = 1 or tipo_leyes = 3) where ".$Criterio." order by t1.nro_solicitud,t1.cod_leyes";
			$Respuesta=mysqli_query($link, $Consulta);
			$Cont=1;
			echo "<input type='hidden' name ='CheckSA'><input type='hidden' name='TxtValor'><input type='hidden' name='CmbUnidad'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
					$Consulta = "select estado_actual,cod_producto,cod_subproducto from cal_web.solicitud_analisis where rut_funcionario='".$Fila["rut_funcionario"]."' and fecha_hora='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"];
				else
					$Consulta = "select estado_actual,cod_producto,cod_subproducto from cal_web.solicitud_analisis where rut_funcionario='".$Fila["rut_funcionario"]."' and fecha_hora='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"]." and recargo='".$Fila["recargo"]."'";				
				$RespEstado=mysqli_query($link, $Consulta);
				$FilaEstado=mysqli_fetch_array($RespEstado);
				if ((!is_null($Fila["recargo"]))&&($Fila["recargo"]!=''))
					$Recargo=$Fila["recargo"];
				else
					$Recargo='N';				
				$Datos=$Fila["nro_solicitud"]."~~".$Recargo."~~".$Fila[rut_funcionario]."~~".$Fila["cod_leyes"];
				echo "<tr align='center'>";
				if($Fila["virt"]=='S')
					echo "<td height='15'><input type='checkbox' name='CheckSA' value='$Datos'></td>";
				else
					echo "<td height='15'><input type='checkbox' name='CheckSA' value='$Datos' disabled></td>";	
				echo "<td height='28'>$Fila["nro_solicitud"]</td>";
				echo "<td height='28'>$Fila["abreviatura"]</td>";
				if($Fila["virt"]=='S')
				{
					echo "<td><input type='text' name='TxtValor' style='width:90' value = \"".$Fila["valor2"]."\" class='InputCen'></td>";
					echo "<td><select name='CmbUnidad' style='width:75'>";
				}	
				else
				{
					echo "<td><input type='text' name='TxtValor' style='width:90' value = \"".$Fila["valor2"]."\" class='InputColor' readonly='true'></td>";
					echo "<td><select name='CmbUnidad' style='width:75' disabled>";
				}
				$Consulta="select abreviatura,cod_unidad from proyecto_modernizacion.unidades order by abreviatura";
				$Respuesta2=mysqli_query($link, $Consulta);
				while($Fila2=mysqli_fetch_array($Respuesta2))
				{
					if (($Fila2["cod_unidad"])==($Fila["cod_unidad"]))
						echo "<option  value='".$Fila2["cod_unidad"]."' selected>".$Fila2["abreviatura"]."</option>";
					else
						echo "<option value='".$Fila2["cod_unidad"]."'>".$Fila2["abreviatura"]."</option>";						
				}
				echo "</select></td>";
				echo "</tr>";
				$Cont=$Cont + 1;
			}
		?>
      </table>
      <br>
      <table width="490" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td align="right"> 
            <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $ValoresSA;?>');"> 
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="JavaScript:window.close();">
			</td>
          </tr>
        </table> </td>
    </tr>
  </table>
	<?php include("../principal/cerrar_principal.php"); ?> 
</form>
</body>
</html>