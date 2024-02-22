<?php
$CodigoDeSistema = 1;
include("../principal/conectar_principal.php");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];
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
			f.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=10";
			f.submit(); 
			break;
		case "C1":	
			if (f.Producto.value == "S")
			{
				alert("Debe Seleccionar Producto");
				f.Producto.focus();
				return;
			}		
			if (f.SubProducto.value == "S")
			{
				alert("Debe Seleccionar Sub-Producto");
				f.SubProducto.focus();
				return;
			}	
			f.action = "cal_ing_granulometria00.php?TipoBus=1";
			f.submit();
			break;
		case "C2":			
			f.action = "cal_ing_granulometria00.php?TipoBus=2";
			f.submit();
			break;
		case "R":			
			f.action = "cal_ing_granulometria00.php";
			f.submit();
			break;
		case "P"://PLANTILLAS				
			window.open("cal_ing_granulometria_carga_plantilla.php?Principal=S","","top=50,left=20,width=550,height=380,scrollbars=yes,resizable = yes");					
			break;
	}
}

function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function Recarga(URL)
{
	var frm=document.frmPrincipal;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL;
	frm.submit(); 
}
function Imprimir()
{
	window.print();
}

function Granulometria()
{
	var frm =document.frmPrincipal;
	for (i=1;i<frm.elements.length;i++)
	{
		if (frm.elements[i].name=="ChkSA" && frm.elements[i].checked)
		{
			window.open("cal_ing_granulometria.php?SA="+ frm.elements[i].value + "&Recargo=" + frm.elements[i+1].value,"","top=50,left=20,width=550,height=380,scrollbars=yes,resizable = yes");					
			break;
		}	
	}
}

function Certificado()
{
	var frm =document.frmPrincipal;
	for (i=1;i<frm.elements.length;i++)
	{
		if (frm.elements[i].name=="ChkSA" && frm.elements[i].checked)
		{			
			if (frm.elements[i+2].value == "C")
			{
				var DescCliente = prompt("Ingrese Cliente al que va el Certificado");
				var DescProducto = prompt("Ingrese Descripcion del Producto");
				window.open("cal_ing_granulometria_certificado.php?DescCliente=" + DescCliente + "&DescProducto=" + DescProducto + "&SA="+ frm.elements[i].value + "&Recargo=" + frm.elements[i+1].value,"","top=40,left=20,width=750,height=460,scrollbars=yes,resizable = yes");					
			}
			else
			{
				alert("Esta Solicitud no tiene estado \"Cerrado Granulometria\", o no tiene \"Analisis Granulometrico\"");
				return;
			}
			break;
		}	
	}
}
</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="765" border="0">
    <tr> 
      <td width="695" align="center" valign="middle"><strong>ANALISIS GRANULOMETRICO </strong></td>
    </tr>
  </table>
  <br>
  <table width="750" border="0" class="TablaDetalle">
    <tr>
      <td height="22">Producto</td>
      <td colspan="3"><select name="Producto" id="Producto" onChange="Proceso('R');">
	  <option value="S">Seleccionar</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Fila["cod_producto"] == $Producto)
			echo "<option selected value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
	}
?>	  
      </select></td>
      <td>SubProducto</td>
      <td colspan="3"><select name="SubProducto" id="SubProducto">
		<option value="S">Seleccionar</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' order by descripcion";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Fila["cod_subproducto"] == $SubProducto)
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
	}
?>	  	  
      </select></td>
    </tr>
    <tr>
      <td height="14">Fecha Ini </td>
      <td colspan="3"><select name="DiaIni">
        <?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaIni))
		{
			if ($DiaIni == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if (date("d") == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		
	}
?>
      </select>
        <select name="MesIni">
          <?php
	for ($i=1;$i<=12;$i++)
	{
		if (isset($MesIni))
		{
			if ($MesIni == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if (date("n") == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		
	}
?>
        </select>
        <select name="AnoIni">
          <?php
	for ($i=2004;$i<=(date("Y")+1);$i++)
	{
		if (isset($AnoIni))
		{
			if ($AnoIni == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if (date("Y") == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		
	}
?>
        </select></td>
      <td>Fecha Fin </td>
      <td colspan="2"><select name="DiaFin">
        <?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaFin))
		{
			if ($DiaFin == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if (date("d") == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		
	}
?>
      </select>
        <select name="MesFin">
          <?php
	for ($i=1;$i<=12;$i++)
	{
		if (isset($MesFin))
		{
			if ($MesFin == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if (date("n") == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		
	}
?>
        </select>
        <select name="AnoFin">
          <?php
	for ($i=2004;$i<=(date("Y")+1);$i++)
	{
		if (isset($AnoFin))
		{
			if ($AnoFin == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if (date("Y") == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		
	}
?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="14" colspan="4">        Con Analisis Granulometrico Solamente 
	  <?php 
		if ($ConAnalisis == "S")  	
	      	echo "<input checked name='ConAnalisis' type='checkbox' value='S'>\n";
		else
			echo "<input name='ConAnalisis' type='checkbox' value='S'>\n";
	  ?></td>
      <td>Estado</td>
      <td colspan="2"><select name="Estado">
        <option value="T">Todas</option>
        <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1008' order by cod_subclase";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Estado == $Fila["nombre_subclase"])
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";	
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";	
	}
?>
      </select></td>
      <td><input type="button" name="BtnConsulta23" value="Buscar" onClick="Proceso('C1');" style="width:70px;"></td>
    </tr>
    <tr>
      <td height="24" colspan="8">&nbsp;</td>
    </tr>
    <tr> 
      <td width="88" height="24"><font size="1"><font size="2">#SolI</font></font></td>
      <td width="60"><font size="1"><font size="1"><font size="2"> 
        <select name="AnoIni2" style="width:60px;">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni2))
				{
					if ($i == $AnoIni2)
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
        </select>
        </font></font></font> </td>
      <td width="61"><font size="1"><font size="1"><font size="1"><font size="2"> 
        <input name="NumIni" type="text" id="NumIni" value="<?php echo $NumIni; ?>" size="10" maxlength="15">
        </font></font></font></font></td>
      <td width="88"><div align="right"><font size="1"><font size="1"></font></font></div></td>
      <td width="72"><font size="1"><font size="1"><font size="2">#SolF</font></font></font></td>
      <td width="114"><select name="AnoFin2" style="width:60px;">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoFin2))
				{
					if ($i == $AnoFin2)
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
        </select>        </td>
      <td width="134"><input name="NumFin" type="text" id="NumFin2" value="<?php echo $NumFin; ?>" size="10" maxlength="15"></td>
      <td width="96">      <input type="button" name="BtnConsulta22" value="Buscar" onClick="Proceso('C2');" style="width:70px;"></td>
    </tr>
    <tr align="center"> 
      <td height="24" colspan="8"> 
          <input type="button" name="BtnConsulta2" value="Buscar" onClick="Proceso('C');" style="width:70px;">
          <input name="BtnGranulometria" type="button" id="BtnActualizar" value="Granulometria" onClick="Granulometria();">
          <input name="BtnCertificado" type="button" id="BtnGranulometria"  style="width:70px;" value="Certificado" onClick="Certificado();">
          <input name="BtnActualizar" type="button" id="BtnActualizar" style="width:70px;" value="Actualizar" onClick="Proceso('R');">
          <input name="BtnPlantillas" type="button" id="BtnPlantillas" style="width:70px;" onClick="Proceso('P')" value="Plantillas">
          <input type="button" name="BtnSalir2" value="Salir" onClick="Proceso('S')" style="width:70px;"></td>
    </tr>
  </table>
  <br>    
  <table width="750" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="20">&nbsp;</td>
      <td width="102"><strong># SA </strong></td>
      <td width="89"><strong>Agrupacion</strong></td>
	  <td width="89"><strong>Id. Muestra</strong></td>
      <td width="145"><strong>Fecha Muestra</strong></td>
      <td width="75"><strong>Producto</strong></td>
      <td width="95"><strong>SubProducto</strong></td>
      <td width="58"><strong>Est.</strong></td>
      <td width="58"><strong>Est. Gran.</strong></td>
    </tr>
    <?php	
if ($TipoBus == 1 || $TipoBus == 2)
{	
	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni." 00:00:00";
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin." 23:59:59";
	$SolIni = $AnoIni2."".str_pad($NumIni,6,"0",STR_PAD_LEFT);
	$SolFin = $AnoFin2."".str_pad($NumFin,6,"0",STR_PAD_LEFT);
	$Consulta = "select fecha_muestra,nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta.= " rut_funcionario, fecha_hora,agrupacion,fecha_muestra ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";	
	$Consulta.= " where (not isnull(nro_solicitud) or nro_solicitud = '')";	
	if ($TipoBus == 2)
	{
		$Consulta.= " and (t1.nro_solicitud between '".$SolIni."' and '".$SolFin."') ";
	}
	else
	{
		if ($TipoBus == 1)
		{
			$Consulta.= " and t1.fecha_muestra between '".$FechaIni."' and '".$FechaFin."' ";
			if ($Producto != "S")
				$Consulta.= " and cod_producto = '".$Producto."'";
			if ($SubProducto != "S")
				$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		}
	}	
	$Consulta.= " order by nro_solicitud,recargo_ordenado";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$Mostrar = true;
		if ($ConAnalisis=="S" && $Estado == "T")
		{
			$Consulta = "select * from cal_web.granulometria where nro_solicitud = '".$Row["nro_solicitud"]."' and recargo='".$Row["recargo"]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$Mostrar = true;
			}
			else
			{
				$Mostrar = false;
			}	
		}		
		else
		{
			if ($ConAnalisis=="S" || $Estado != "T")
			{
				$Consulta = "select * from cal_web.granulometria where nro_solicitud = '".$Row["nro_solicitud"]."' and recargo='".$Row["recargo"]."'";
				$Resp2 = mysqli_query($link, $Consulta);			
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{				
					if ($Estado == $Fila2["cod_estado"])
						$Mostrar = true;
					else
						$Mostrar = false;		
				}
				else
				{
					$Mostrar = false;
				}
			}
			else
			{
				if ($ConAnalisis != "S")
				{
					$Mostrar == true;
				}			
			}
		}
		if ($Mostrar)
		{
			if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
				$Recargo="N";
			echo "<tr align='left' valign='middle'>\n";
			echo "<td><input type='radio' name='ChkSA' value='".$Row["nro_solicitud"]."'><input type='hidden' name='ChkRecargo' value='".$Row["recargo"]."'></td>\n";
			if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
				echo $Row["nro_solicitud"]."</a></td>\n";
			}
			else
			{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
				echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
			}
			$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Row["agrupacion"]."'";
			$Resp1=mysqli_query($link, $Consulta);
			$Fil1=mysqli_fetch_array($Resp1);
			echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
			echo "<td>".$Row["id_muestra"]."</td>\n";
			if ((!is_null($Row[fecha_muestra])) && ($Row[fecha_muestra] != ""))
				echo "<td align='center'>".substr($Row[fecha_muestra],8,2)."/".substr($Row[fecha_muestra],5,2)."/".substr($Row[fecha_muestra],0,4)." ".substr($Row[fecha_muestra],11,5)."</td>\n";
			else
				echo "<td align='center'>&nbsp;</td>\n";
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
			//---------ESTADO ACTUAL---------------------------------------
			$Consulta = "select * from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.sub_clase t2 ";
			$Consulta.= " on t2.cod_clase = '1002' and t1.estado_actual = t2.cod_subclase ";		
			$Consulta.= " where nro_solicitud = '".$Row["nro_solicitud"]."'";
			if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
				$Consulta = $Consulta;
			else	
				$Consulta.= " and recargo = '".$Row["recargo"]."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp))
				echo "<td>".$Row2["nombre_subclase"]."</td>\n";
			else	
				echo "<td>&nbsp;</td>\n";
			//-------------------------------------------------------	
			//---------ESTADO GRANULOMETRIA---------------------------------------
			$Consulta = "select distinct t1.cod_estado as estado, t2.valor_subclase1 as nom_estado from cal_web.granulometria t1 inner join proyecto_modernizacion.sub_clase t2 ";
			$Consulta.= " on t2.cod_clase = '1008' and t1.cod_estado = t2.nombre_subclase ";
			$Consulta.= " where t1.nro_solicitud = '".$Row["nro_solicitud"]."' and t1.recargo = '".$Row["recargo"]."'";	
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				echo "<td align='center'>".$Fila2["nom_estado"]."<input type='hidden' name='EstGranu' value='".$Fila2["estado"]."'></td>\n";
			else	
				echo "<td>&nbsp;<input type='hidden' name='EstGranu' value='N'></td>\n";
			//-------------------------------------------------------				
			echo "</tr>\n";
		}
	}
}
?>
  </table>
  <table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">&nbsp;</td>
          </tr></table>
</form>
</body>
</html>
