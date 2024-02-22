<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 36;
	include("../principal/conectar_principal.php");	
	set_time_limit(400);
?>
<html>
<head>
<title>AGE-Ingreso Muestra Paralela</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function Detalle(Valores)
{
	window.open("age_leyes_virtuales_detalle.php?Valores="+Valores,"","top=60,left=100,width=580,height=385,scrollbars=yes,resizable = no");
}
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "B"://BUSCAR
			if(Frm.TxtIni.value!=''&&Frm.TxtFin.value=='')
				Frm.TxtFin.value=Frm.TxtIni.value;
			Frm.action='age_ing_muestra_paralela.php?Proceso=B&Mostrar=S';
			Frm.submit();		
			break;
		case "G"://GRABAR
			if (SeleccionoCheck()) 
			{
				if(confirm('Esta Seguro de Grabar los Datos'))
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action='age_ing_muestra_paralela01.php?Proceso=G&Valores='+Valores;
					Frm.submit();
				}						
			}	
			break;
		case "R"://RECARGA
			Frm.action='age_ing_muestra_paralela.php';
			Frm.submit();		
			break;
		case "S"://SALIR
			Frm.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=30&Nivel=1";
			Frm.submit();
			break;
	} 
}
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
				Valores=Valores + Frm.CheckCod[i].value+"~~"+Frm.TxtLote[i].value +"//";
		}
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);
	}
	catch (e)
	{
	}
}
function CheckearTodo()
{
	var Frm=document.FrmPrincipal;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
				Frm.CheckCod[i].checked=true;
			else
				Frm.CheckCod[i].checked=false;
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmPrincipal;
	var CantCheck=0;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
				CantCheck=CantCheck+1;
		}
		if (CantCheck > 1)
		{
			alert("Debe Seleccionar solo un Elemento");
			return(false);
		}
		else
			return(true);
	}
	catch (e)
	{
	}
}
function SeleccionoCheck()
{
	var Frm=document.FrmPrincipal;
	var Encontro="";
	
	Encontro=false; 
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
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
			return(true);
	}
	catch (e)
	{}	
}
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 3p�xele;
	margin-bottom: 3p�xele;
	background-image: url();
}
body,td,th {
	font-size: 10p�xele;
}
-->
</style></head>

<body>
<form name="FrmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<table width="770" height="330" border="0" cellpadding="2" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td align="center" valign="top">
    <table width="400" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr align="center">
        <td height="23" colspan="4" class="Detalle02"><strong>ASIGNACION MUESTRA PARALELA</strong></td>
      </tr>
      <tr>
        <td height="28" class="Colum01">SubProducto:</td>
        <td height="28" colspan="3"><select name="SubProducto" style="width:300" onChange="Proceso('R')" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');">
          <option class="NoSelec" value="S">TODOS</option>
          <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
        </select></td>
      </tr>
      <tr>
        <td height="23" class="Colum01">Periodo:</td>
        <td height="23" colspan="3"><select name="Mes" id="Mes">
		<?php
		for ($i=1;$i<=12;$i++)
		{
			if (!isset($Mes))
			{
				if ($i==date("n"))
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i==$Mes)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
		?>
        </select>
        <select name="Ano" id="Ano">
		<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (!isset($Ano))
			{
				if ($i==date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i==$Ano)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
      </tr>
      <tr>
        <td class="Colum01">Muestra //s:</td>
		<td align="left" colspan="3">
		Inicial&nbsp;
		<input name="TxtIni" type="text" value="<?php echo $TxtIni;?>" size="10" onKeyDown="TeclaPulsada(false)" maxlength='8'>&nbsp;&nbsp;&nbsp;
		Final&nbsp;
		<input name="TxtFin" type="text" value="<?php echo $TxtFin;?>" size="10" onKeyDown="TeclaPulsada(false)" maxlength='8'>
		</td>
      </tr>
      <tr>
        <td height="23" colspan="4" align="center" class="Detalle02"><input name="BtnBuscar" type="button" style="width:70px;" onClick="Proceso('B')" value="Buscar">
            <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70px;" onClick="Proceso('G')" value="Grabar" >
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
    <br>
      <table width="370" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaInterior">
        <tr class="ColorTabla01">
          <td width="10" align="center"><input type="checkbox" name="CheckTodos" onClick="CheckearTodo()"></td>
          <td width="120" align="center">Muestra Paralela</td>
          <td width="120" align="center">S.A.</td>
          <td width="120" align="center">Lote</td>
        </tr>
        <?php
		if($Mes=='1')
		{
			$MesAux='12';
			$AnoAux=$Ano-1;
		}
		else
		{
			$MesAux=$Mes;
			$AnoAux=$Ano;
		}
		$FechaIni = $Ano."-".$Mes."-01 00:00:01";
		$FechaFin = $Ano."-".$Mes."-31 23:59:59";		
		$FechaIniNew = $Ano."-".$Mes."-01";
		$FechaFinNew = $Ano."-".$Mes."-31";		
		$AnoMes=substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT);
		if ($Mostrar=="S")
		{ 		
			
			$Consulta = "select distinct t1.cod_subproducto,t3.descripcion as nom_subproducto from cal_web.solicitud_analisis t1 left join age_web.lotes t2 on t1.id_muestra=t2.muestra_paralela and isnull(t2.muestra_paralela) ";
			$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto ";
			$Consulta.= "where t1.cod_producto='1' and t1.tipo='4' ";
			if($SubProducto!='S')
				$Consulta.=" and t1.cod_subproducto='$SubProducto'";
			if($TxtIni!='')
				$Consulta.=" and t1.id_muestra between '$TxtIni' and '$TxtFin'";
				else
				$Consulta.=" and t1.fecha_muestra between '$FechaIni' and  '$FechaFin'";	
			$RespProd=mysqli_query($link, $Consulta);
		    //echo "uno".$Consulta;
			while($FilaProd=mysqli_fetch_array($RespProd))
			{
				$Consulta = "select t2.lote,t1.nro_solicitud,t1.recargo,t1.id_muestra from cal_web.solicitud_analisis t1 left join age_web.lotes t2 on trim(t1.id_muestra)=trim(t2.muestra_paralela) and t2.fecha_recepcion between '$FechaIniNew' and  '$FechaFinNew' ";
				$Consulta.= "where t1.cod_producto='1' and t1.tipo='4' and t1.recargo='0' and isnull(t2.muestra_paralela) ";
				$Consulta.= "and t1.cod_subproducto='$FilaProd["cod_subproducto"]'";
				if($TxtIni!='')
					$Consulta.=" and t1.id_muestra between '$TxtIni' and '$TxtFin'";
					else	
					$Consulta.=" and t1.fecha_muestra between '$FechaIni' and  '$FechaFin' ";	
				$Consulta.=" and t1.estado_actual not in ('7','16')";	
				$Respuesta=mysqli_query($link, $Consulta);
				//echo "dos".$Consulta;
				echo "<input type='hidden' name='CheckCod'><input type='hidden' name='TxtLote'>";
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					echo "<td align='center'><input type='checkbox' name='CheckCod' value='$Fila["id_muestra"]'></td>";
					echo "<td align='center'>".$Fila["id_muestra"]."</td>";
					if(!is_null($Fila["recargo"])&&$Fila["recargo"]!='')
						echo "<td align='center'><a href=\"JavaScript:Historial('".$Fila["nro_solicitud"]."','".$Fila["recargo"]."')\">".$Fila["nro_solicitud"]."-".$Fila["recargo"]."</a></td>";
						
					else
						echo "<td align='center'><a href=\"JavaScript:Historial('".$Fila["nro_solicitud"]."','N')\">".$Fila["nro_solicitud"]."</a></td>";
					echo "<td align='center'><input name='TxtLote' type='text' value='' size='10' onkeydown='TeclaPulsada(false)' class='InputCen' maxlength='8'></td>";
					echo "</tr>";
				}
				echo "<tr>";
				echo "<td colspan='4' align='left' class='Detalle01'>$FilaProd["nom_subproducto"]</td>";
				echo "</tr>";
			}
		}
		?>
      </table>
    </td>
  </tr>
</table> 
</table>
<?php include ("../principal/pie_pagina.php") ?>     
</form>
</body>
</html>
