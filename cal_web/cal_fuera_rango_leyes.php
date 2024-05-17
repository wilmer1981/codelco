<?php
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("Y-m-d");
	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
	if($ValoresSA!='')
	{
		$Datos = explode("//",$ValoresSA);	
		while (list($clave,$Codigo)=each($Datos))
		{
			if($Codigo!='')
			{
				$MAT= explode("~",$Codigo);	
				$Actualizar="UPDATE cal_web.leyes_por_solicitud set observacion ='".$MAT[7]."' where ";
				$Actualizar.=" nro_solicitud='".$MAT[1]."' and cod_producto='".$MAT[2]."' and cod_subproducto='".$MAT[3]."' and cod_leyes='".$MAT[4]."' and cod_unidad='".$MAT[5]."' and recargo='".$MAT[6]."'";
				mysqli_query($link, $Actualizar);
			}      
		}
		?>
		<script language="javascript">
		window.close();
		</script>
		<?php
	}
?>
<html>
<head>
<script language="JavaScript">
function Grabar()
{
	var Frm=document.FrmIngresoValorLeyes;
	var ValoresSA="";
	var Valores="";
	var Valor=true;
	for(i=1;i<Frm.length;i++)
	{
		Name=Frm.elements[i].name
		Matriz=Name.split('~');
		if(Matriz[0]=='Txt')
		{
			if(Frm.elements[i].value=='')
			{
				alert("Debe Ingresar Observacion")
				Frm.elements[i].focus();
				Valor=false;
				return;
				
			}
			Valores=Valores+Frm.elements[i].name+"~"+Frm.elements[i].value+"//";
		}
	}
	if(Valor==true)
	{
		Frm.ValoresSA.value=Valores;
		Frm.action="cal_fuera_rango_leyes.php";
		Frm.submit();
	}
}

function Seguridad(CB,ValoresSA,Tipo)
{
	var Frm=document.FrmIngresoValorLeyes;
	var Valores= "";
	var ValoresAux="";
	var Valor="";
	
	ValoresAux=Frm.TxtSAO[CB.value].value +"~~"+Frm.TxtRutO[CB.value].value+"||"+Frm.TxtCodLeyesO[CB.value].value+""+Frm.TxtRecargoO[CB.value].value+"//"+Frm.TxtValor[CB.value].value;
	if (Frm.TxtCandadoO[CB.value].value == '1')
	{
		window.open("cal_desbloquear_leyes.php?ValoresSA="+ValoresSA+"&Valores="+ValoresAux+"&Tipo=L","","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
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
			Frm.action="cal_ingreso_valor_leyes01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=L&Opcion=G&PonerCandado=S";
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
	var Frm=document.FrmIngresoValorLeyes;
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
				Frm.action="cal_seleccion_leyes01.php?Pantalla=L&ValoresSA="+ValoresSA+"&ValoresCheck="+ValoresCheck+"&Proceso="+Proceso;
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
			window.open("cal_seleccion_leyes.php?Pantalla=L&ValoresSA="+ValoresSA+"&SA="+SA+"&Recargo="+Recargo+"&Ley="+Ley+"&Proceso="+Proceso,"","top=100,left=20,width=700,height=550,scrollbars=yes,resizable = no");	
		}
		else
		{
			alert("Debe Seleccionar Solicitud de Analisis");
			return;
		}
	}	
}

function Todos(Solicitudes)
{
	var Frm=document.FrmIngresoValorLeyes;
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
				Frm.TxtValor[i].focus();
				Frm.CheckTodos.checked=true;
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
		Frm.action="cal_ingreso_valor_leyes01.php?ValoresSA="+ValoresSA+"&Valores="+Valores+"&Tipo=L&Opcion=G&PonerCandado=S";
		Frm.submit();
	}
}
function Salir(Valores)
{
	var Frm=document.FrmIngresoValorLeyes;
	Frm.action="cal_ingreso_valor_leyes01.php?Opcion=S&Valores="+Valores;
	Frm.submit();
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngresoValorLeyes" method="post" action="">
<input type="hidden" name="ValoresSA" value="<?php echo $ValoresSA;?>"> 
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
        <tr class="ColorTabla01" align="center">
		  <td width="16%" >SA</td>
	      <td width="7%" >Ley</td>
		   <td width="10%">Valor</td>
          <td width="14%" >Unidad</td>
		   <td width="13%" >Limite&nbsp;Inicial </td>
          <td width="8%" >Limite&nbsp;Final</td>
		  <td width="32%" >Observaci�n</td>
         
        </tr>
		<?php $Popup='N';	
        	$Consulta ="select t1.observacion,t1.fecha_hora,t1.cod_leyes,t1.nro_solicitud,t3.rut_proveedor,t1.cod_producto,t1.cod_subproducto,t1.rut_funcionario,t1.recargo,t2.abreviatura,t1.valor,t1.cod_unidad,t1.candado,t1.signo from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";
			$Consulta.=" inner join cal_web.solicitud_analisis t3 on t1.nro_solicitud=t3.nro_solicitud where t1.observacion='".$CookieRut."' ";
			$Consulta.=" group by t1.nro_solicitud,t1.cod_producto,t1.cod_subproducto,t1.cod_leyes,t1.cod_unidad,t1.recargo  order by t1.nro_solicitud,t1.cod_leyes";
			$Respuesta=mysqli_query($link, $Consulta);
			$Cont=1;
			
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				
					$Consulta="Select * from cal_web.limite where cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."'";
					$Consulta.=" and cod_ley='".$Fila["cod_leyes"]."' and unidad='".$Fila["cod_unidad"]."' and rut_proveedor='".$Fila["rut_proveedor"]."'";
				//	echo $Consulta."<br>";
					$Resp1= mysqli_query($link, $Consulta);
					if($Fila1=mysqli_fetch_array($Resp1))
					{
							$LimitIni=$Fila1[limite_inicial];
							$LimitFin=$Fila1[limite_final];
				
					}
					else
					{
					
						$Consulta="Select * from cal_web.limite where cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."'";
						$Consulta.=" and cod_ley='".$Fila["cod_leyes"]."' and unidad='".$Fila["cod_unidad"]."' and rut_proveedor='T'";
						$Resp1= mysqli_query($link, $Consulta);
						if($Fila1=mysqli_fetch_array($Resp1))
						{
								$LimitIni=$Fila1[limite_inicial];
								$LimitFin=$Fila1[limite_final];
						}
					}
			?>
				<tr align='center'>
				<td height='28'><?php echo $Fila["nro_solicitud"]."-".$Fila["recargo"];?></td>
				<td height='28'><?php echo $Fila["abreviatura"];?></td>
				<td><span class="InputRojo"><?php echo $Fila["valor"]; ?></span></td>
				<td><?php 
				$Consulta="select abreviatura,cod_unidad from proyecto_modernizacion.unidades where cod_unidad='".$Fila["cod_unidad"]."' ";
				$Respuesta2=mysqli_query($link, $Consulta);
				if($Fila2=mysqli_fetch_array($Respuesta2))
					echo $Fila2["abreviatura"];
					
				?></td>
				<td><?php echo $LimitIni;?></td>
				<td><?php echo $LimitFin;?></td> 
				<td>  <textarea name="Txt~<?php echo $Fila["nro_solicitud"]."~".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Fila["cod_leyes"]."~".$Fila["cod_unidad"]."~".$Fila["recargo"];?>" cols="30" rows="2" wrap="VIRTUAL" ></textarea></td>				                
				              
				</tr><?php
				$Cont=$Cont + 1;
			}
		?>
      </table>
      <br>
      <table width="50%" align="center" border="0" cellpadding="5" >
          <tr> 
            <td  align="center" BORDER="0"> 
			    <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar();">	            
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="JavaScript:window.close();">
			</td>
          </tr>
        
  </table>
	<?php include("../principal/cerrar_principal.php"); ?> 
</form>
</body>
</html>
