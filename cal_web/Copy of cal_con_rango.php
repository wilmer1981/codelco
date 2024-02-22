<?php
	$CodigoDeSistema = 1;
	include("../principal/conectar_principal.php");
	$Rut =$CookieRut;
?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			f.submit(); 
			break;
		case "C":
			var TotalDiasT=0;
			var CantDiasI=0;
			var CantDiasT=0;
			var TotalDiasI=0;
			var DifDias=0;
			var Mostrar =1;
			CantDiasI=365*parseInt(f.AnoIni.value);
			TotalDiasI=parseInt(CantDiasI)+(31*parseInt(f.MesIni.value))+parseInt(f.DiaIni.value);
			CantDiasT=365*parseInt(f.AnoFin.value);
			TotalDiasT=CantDiasT+(31*parseInt(f.MesFin.value))+parseInt(f.DiaFin.value);
			DifDias=TotalDiasT-TotalDiasI;
			if (DifDias > 65)
			{
				alert("Rango de busqueda debe ser 2 meses aprox.")
				Mostrar=2;
				return;
			}
			if (f.AnoFin.value==f.AnoIni.value)
			{
				if ((f.MesFin.value-f.MesIni.value)>2)
				{
					alert("El rango de fecha debe ser menor o igual a 2 meses");
					Mostrar=2;
					return;
				}
			}
			if (Mostrar == 1)
			{
				f.action = "cal_con_rango.php";
				f.submit();
			}
			break;
		case "E":
			f.action = "cal_xls_enabal.php?LimitIni="+f.LimitIni.value+"&LimitFin="+f.LimitFin.value;
			f.submit();
			break;
	}
}

function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function Recarga(URL,LimiteIni)
{
	var frm=document.frmPrincipal;
	
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni;
	frm.submit(); 
}

</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<?php
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="765" border="0">
    <tr> 
      <td width="695" align="center" valign="middle"><strong>Consulta de Limite 
        Rango </strong></td>
    </tr>
  </table>
  <br>
  <table width="760" border="0" class="TablaDetalle">
    <tr> 
      <td height="24"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Usuario:</font></font></td>
      <td><strong> 
        <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
		
			}
		  ?>
        </strong></td>
      <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:</font></font></td>
      <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> 
        </strong>&nbsp; <strong> 
        <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
				$FechaHora=date('Y-m-d H:i');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
        </strong></font></font></td>
    </tr>
    <tr> 
      <td width="93" height="24">Fecha Inicio</td>
      <td width="222"><select name="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoIni" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select> </td>
      <td width="98">Fecha Termino</td>
      <td width="326"><select name="DiaFin" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesFin" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoFin" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select> </td>
    </tr>
    <tr align="center" valign="middle"> 
      <td height="24"><div align="left">&nbsp;</div></td>
      <td height="24"><div align="left"><strong>
          <input name="LimitFin" type="hidden" id="LimitFin" value="<?php echo $LimitFin;?>" size="12" maxlength="12">
          </strong></div></td>
      <td height="24" colspan="2"><div align="left"> 
          <input type="button" name="BtnConsulta2" value="Consultar" onClick="Proceso('C');" style="width:70px;">
          <input type="button" name="BtnSalir2" value="Salir" onClick="Proceso('S')" style="width:70px;">
        </div></td>
    </tr>
  </table>
  <br>
<?php
	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;
	$Consulta =" select distinct cod_producto,cod_subproducto,cod_ley from cal_web.rango order by cod_producto,cod_subproducto ";
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Pregunta=$Pregunta."  (t1.cod_producto = '".$Fila["cod_producto"]."' and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.cod_leyes='".$Fila[cod_ley]."') or";
	}
	if ($Pregunta!='')
	{
		$Pregunta=substr($Pregunta,0,strlen($Pregunta)-2);
		$Pregunta2=substr($Pregunta2,0,strlen($Pregunta2)-2);
		$Consulta="select distinct(t1.cod_leyes), t3.abreviatura from cal_web.leyes_por_solicitud t1 ";
		$Consulta.=" inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud  and t1.recargo = t2.recargo   ";
		$Consulta.=" inner join proyecto_modernizacion.leyes t3 on t1.cod_leyes = t3.cod_leyes ";
		$Consulta.=" where (t2.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59') and  (t2.estado_actual = '5' or t2.estado_actual ='6') and";
		$Consulta.="(".$Pregunta.")";
		$Respuesta = mysqli_query($link, $Consulta);
		$LargoArreglo = 0;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			$ArregloLeyes[$LargoArreglo][0] = $Row["cod_leyes"];
			$ArregloLeyes[$LargoArreglo][1] = $Row["abreviatura"];
			$LargoArreglo++;
		}
		$Total = ($LargoArreglo * 70) +650;
	}
?>	    
  <table width="<?php echo $Total; ?>" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="136"><strong># Solicitud</strong></td>
     <td width="90"><strong>Producto</strong></td>
      <td width="90"><strong>SubProducto</strong></td>
     
      <?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		echo "<td width='70'>".$ArregloLeyes[$i][1]."</td>\n";
	}
?>
    </tr>
    <?php	
	$Consulta =" select  cod_producto,cod_subproducto,cod_ley,rango_inicial,rango_final,unidad from cal_web.rango order by cod_producto,cod_subproducto ";
	$Respuesta1=mysqli_query($link, $Consulta);
	$LargoArreglo1 = 0;
	while ($Row1 = mysqli_fetch_array($Respuesta1))
	{
		$ArregloLeyes1[$LargoArreglo1][0] = $Row1[cod_ley];
		$ArregloLeyes1[$LargoArreglo1][1] = $Row1["cod_producto"];
		$ArregloLeyes1[$LargoArreglo1][2] = $Row1["cod_subproducto"];
		$ArregloLeyes1[$LargoArreglo1][3] = $Row1[rango_inicial];
		$ArregloLeyes1[$LargoArreglo1][4] = $Row1[rango_final];
		$ArregloLeyes1[$LargoArreglo1][5] = $Row1[unidad];
		$LargoArreglo1++;
	}
	$Cont=0;
	for ($i = 0; $i < $LargoArreglo1; $i++)
	{
		
		$Consulta1="select count(*) as total_registros   "; 
		$Consulta1.="  from cal_web.solicitud_analisis t1 ";
		$Consulta1.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto= t2.cod_producto ";
		$Consulta1.=" and t1.cod_subproducto= t2.cod_subproducto ";
		$Consulta1.=" inner join cal_web.leyes_por_solicitud t3 on t1.nro_solicitud = t3.nro_solicitud ";
		$Consulta1.=" and t1.recargo = t3.recargo ";
		$Consulta1.=" where (t1.fecha_muestra between '".$FechaIni." 00:00:00' ";
		$Consulta1.=" and '".$FechaFin." 23:59:59') and (not isnull(t1.nro_solicitud) or t1.nro_solicitud = '') ";
		$Consulta1.=" and (t1.estado_actual = '5' or t1.estado_actual ='6') and (not isnull(t3.valor) or t3.valor = '')  ";
		$Consulta1.= " and (t3.cod_leyes = '".$ArregloLeyes1[$i][0]."' and t1.cod_producto='".$ArregloLeyes1[$i][1]."' and t1.cod_subproducto='".$ArregloLeyes1[$i][2]."' and t3.cod_unidad='".$ArregloLeyes1[$i][5]."'";
		$Consulta1.="	and not(t3.valor between '".$ArregloLeyes1[$i][3]."' and '".$ArregloLeyes1[$i][4]."')) ";
		$Respuesta3=mysqli_query($link, $Consulta1);
		$Fila3=mysqli_fetch_array($Respuesta3);
		$Suma=$Suma+$Fila3["total_registros"];
		
		
		$Consulta="select t1.fecha_muestra,t1.nro_solicitud,t1.recargo,t1.cod_producto,t1.cod_subproducto, "; 
		$Consulta.=" if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
		$Consulta.=" t1.id_muestra, t1.rut_funcionario, t1.fecha_hora,t1.agrupacion,t3.valor from cal_web.solicitud_analisis t1 ";
		$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto= t2.cod_producto ";
		$Consulta.=" and t1.cod_subproducto= t2.cod_subproducto ";
		$Consulta.=" inner join cal_web.leyes_por_solicitud t3 on t1.nro_solicitud = t3.nro_solicitud ";
		$Consulta.=" and t1.recargo = t3.recargo ";
		$Consulta.=" where (t1.fecha_muestra between '".$FechaIni." 00:00:00' ";
		$Consulta.=" and '".$FechaFin." 23:59:59') and (not isnull(t1.nro_solicitud) or t1.nro_solicitud = '') ";
		$Consulta.=" and (t1.estado_actual = '5' or t1.estado_actual ='6') and (not isnull(t3.valor) or t3.valor = '')  ";
		$Consulta.=" and (t3.cod_leyes = '".$ArregloLeyes1[$i][0]."' and t1.cod_producto='".$ArregloLeyes1[$i][1]."' and t1.cod_subproducto='".$ArregloLeyes1[$i][2]."' and t3.cod_unidad='".$ArregloLeyes1[$i][5]."'";
		$Consulta.=" and not(t3.valor between '".$ArregloLeyes1[$i][3]."' and '".$ArregloLeyes1[$i][4]."')) ";
		$Consulta.=" order by t1.nro_solicitud,recargo_ordenado				";
		$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr align='left' valign='middle'>\n";
			if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			{
				$Recargo='N';
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
				echo $Row["nro_solicitud"]."</a></td>\n";
			}
			else
			{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
				echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
			}
			//----------------------Producto y  Subproducto --------------------------------------
			$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
			$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
			$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
			$Consulta.= " where t1.nro_solicitud = '".$Row["nro_solicitud"]."' ";
			if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			{	
				$Consulta = $Consulta;
			}
			else	
			{
				$Consulta.= " and recargo = '".$Row["recargo"]."'";
			}
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);  
			echo "<td align ='center'>".$Fila[AbrevProducto]."</td>";
			echo "<td align = 'center'>".$Fila[AbrevSubProducto]."</td>";
			for ($j = 0; $j < $LargoArreglo; $j++)
			{
				$Consulta="select * from cal_web.leyes_por_solicitud t1"; 
				$Consulta.=" inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad ";  
				$Consulta.=" where t1.nro_solicitud = ".$Row["nro_solicitud"]." and t1.cod_leyes='".$ArregloLeyes[$j][0]."'	";
				if (!is_null($Row["recargo"]) || ($Row["recargo"] != ""))
				{
					$Consulta.= " and t1.recargo = '".$Row["recargo"]."' ";
				}
				$Respuesta1=mysqli_query($link, $Consulta);
				if ($Row2 = mysqli_fetch_array($Respuesta1))
				{
					echo "<td width='70'>".number_format($Row2[valor],2).$Row2["abreviatura"]."</td>\n";
				}
				else
				{
					echo "<td width='70' align='center'><img src='../principal/imagenes/ico_x.gif'></td>\n";
				
				}
			}
			echo "</tr>";
		$Cont++;
		}
	}	
?>
  </table>
  <table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
            <?php		
				$Coincidencias = $Suma;
				$NumPaginas = ($Coincidencias / $LimitFin);
				$LimitFinAnt = $LimitIni;
				$StrPaginas = "";
				for ($i = 0; $i <= $NumPaginas; $i++)
				{
					$LimitIni = ($i * $LimitFin);
					if ($LimitIni == $LimitFinAnt)
					{
						$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
					}
					else
					{
						$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_rango.php','".($i * $LimitFin)."');>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
				}
				echo substr($StrPaginas,0,-15);
			?>
            </td>
          </tr></table>
</form>
</body>
</html>
