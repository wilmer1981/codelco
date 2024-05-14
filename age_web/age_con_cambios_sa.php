<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 91;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	
	$Mostrar      = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Orden        = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$Mes          = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("n");
	$Ano          = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Busq         = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
    $ChkSolicitud = isset($_REQUEST["ChkSolicitud"])?$_REQUEST["ChkSolicitud"]:"S";
	$TxtFiltroPrv     = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";

	//CONSULTO FECHA CIERRE ANEXO
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
	$RespCierre = mysqli_query($link, $Consulta);
	$CierreBalance = false;	
	$FechaCierreAnexo="";
	if ($FilaCierre = mysqli_fetch_array($RespCierre))
	{
		if ($FilaCierre["estado"]=="C")
		{
			$CierreBalance = true;
			$FechaCierreAnexo=$FilaCierre["fecha_cierre"];
		}
	}
	
?>
<html>
<head>
<title>AGE-Consulta Comparacion Muestra Paralela</title>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt,valor)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "AM"://AGREGA VALORES MANUALES
			var url="age_con_cambios_sa_ajuste_manual.php?Proceso=N";
			window.open(url,"","top=70,left=50,width=500,height=350,scrollbars=yes,resizable = yes");					
			break;
		case "S":
			if (f.Sistema.value=="CAL")
				f.action = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			else
				f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=30";
			f.submit();
			break;
		case "I":
			window.print();
			break;		
		case "R":
			f.action = "age_con_cambios_sa.php";
			f.submit(); 
			break;
		case "C":
			f.action = "age_con_cambios_sa.php?Mostrar=S";
			f.submit(); 
			break;
		case "E":
			f.action = "age_con_cambios_sa_excel.php?Mostrar=S&Orden=<?php echo $Orden; ?>";
			f.submit(); 
			break;		
		case "O": //ORDENA
			f.action = "age_con_cambios_sa.php?Mostrar=S&Orden=" + valor;
			f.submit();
			break;
		case "M"://MODIFICAR
			var Valores="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkAjuste" && f.elements[i].checked==true)
				{
					Valores=f.elements[i].value;
					break;
				}
			}
			if (Valores=="")
			{
				alert("No hay nada seleccionado para Modificar");
				return;
			}
			else
			{
				var url="age_con_cambios_sa_ajuste_manual.php?Proceso=M&TxtValores="+Valores;
				window.open(url,"","top=70,left=50,width=500,height=350,scrollbars=yes,resizable = yes");
			}
			break;
	}	
}

function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Recarga3()
{
	var Frm = frmPrincipal;
	Frm.action="age_con_cambios_sa.php?Busq=S";
	Frm.submit();	
}
function UsarAjuste(opt)
{
	var f = document.frmPrincipal;
	var Valores="";
	switch (opt)
	{		
		case "GA": //VALORES AUTOMATICOS
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkUsar" && f.elements[i].checked==true)
					Valores=Valores + f.elements[i].value + "///";
			}
			if (Valores=="")
			{
				alert("No hay nada seleccionado para Grabar");
				return;
			}
			else
			{
				var Largo=Valores.length;
				Valores = Valores.substring(0,Largo-3);
				f.TxtValores.value=Valores;
				f.action="age_con_cambios_sa01.php?Proceso=U";
				f.submit();
			}
			break;
		case "E":
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkAjuste" && f.elements[i].checked==true)
					Valores=Valores + f.elements[i].value + "///";
			}
			if (Valores=="")
			{
				alert("No hay nada seleccionado para Eliminar");
				return;
			}
			else
			{
				if (confirm("¿Seguro que desea Eliminar estos Ajustes?"))
				{
					var Largo=Valores.length;
					Valores = Valores.substring(0,Largo-3);
					f.TxtValores.value=Valores;
					f.action="age_con_cambios_sa01.php?Proceso=E";
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
	}
	
}
function DetalleLote(Lote)
{
	window.open("../age_web/age_adm_cierre_lote.php?Orden=<?php echo $Orden; ?>&EsPopup=S&TxtLote="+Lote,"","top=0,left=0,width=800,height=600,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="TxtValores" value="">
<input type="hidden" name="Sistema" value="<?php echo $Sistema; ?>">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="851" height="313" align="center" valign="top"><table width="750" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>CAMBIOS EN  SOLICITUDES<br>
            </strong></td>
        </tr>
        <tr align="center">
          <td height="23" colspan="4" class="Detalle01">Muestra todoas las Leyes que hayan sido modificadas luego de la fecha de cierre del Anexo<br>
y cuyo valor sea distinto al ingresado anteriormente </td>
          </tr>
        <tr>
          <td width="71" align="right">Periodo:</td>
          <td>
            <select name="Mes">
              <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
            </select>
            <select name="Ano" size="1">
              <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
            </select>          
            </td>
          <td align="right">Proveedor:</td>
          <td><select name="Proveedor" style="width:300" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select * from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' "; 				
				$Consulta.= " order by t1.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
				}
			?>
          </select></td>
        </tr>
        <tr>
          <td align="right">Producto:</td>
          <td width="267"><select name="SubProducto" style="width:250" onChange="Proceso('R')">
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
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
          </select></td>
          <td width="76" align="right">Filtro Prv</td>
          <td width="301">>
              <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
         </td>
        </tr>
        <tr>
          <td align="right">Fecha Cierre: </td>
          <td><?php 
		if ($FechaCierreAnexo!="")
			echo substr($FechaCierreAnexo,8,2)."/".substr($FechaCierreAnexo,5,2)."/".substr($FechaCierreAnexo,0,4)." ".substr($FechaCierreAnexo,11);
		else
			echo "<font color='RED'><b>No se ha Cerrado el Mes</b></font>";
	
	?></td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="4" class="Detalle01"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">              
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
		<tr align="center" class="Detalle01">
			<td colspan="14">AJUSTES AUTOMATICOS OFRECIDOS POR EL SISTEMA </td>
		  </tr>
		<tr align="center" class="ColorTabla01">
			
		  <td width="80" rowspan="2"><a href="JavaScript:Proceso('O','PD');" class="LinksBlancoRaya">Producto</a></td>
		  <td width="92" rowspan="2"><a href="JavaScript:Proceso('O','PV');" class="LinksBlancoRaya">Proveedor</a></td>
		  <td width="41" rowspan="2"><a href="JavaScript:Proceso('O','L');" class="LinksBlancoRaya">Lote</a></td>
		  <td width="64" rowspan="2"><a href="JavaScript:Proceso('O','S');" class="LinksBlancoRaya">Solicitud</a></td>
		  <td width="39" rowspan="2">Estado </td>
		  <td width="28" rowspan="2">Ley</td>
		  <td height="18" colspan="3">Valores Anteriores</td>
		  <td colspan="3">Nuevos Valores </td>
		  <td width="62" rowspan="2">Ajuste</td>
		  <td width="24" rowspan="2">Usar
		    <input name="BtnUsar" type="button" id="BtnUsar" value="OK" onClick="UsarAjuste('GA')"></td>
		</tr>
		<tr class="ColorTabla01" align="center">
			<td width="30" height="18">Fecha</td> 
			<td width="60">Funcionario</td>
			<td width="27">Valor</td>
		    <td width="30">Fecha</td>
		    <td width="60">Funcionario</td>
		    <td width="27">Valor</td>
	      </tr>		
<?php		
		
if ($Mostrar=="S" && $FechaCierreAnexo!="")
{
	if ($Ano<2006)
	{
		$LoteIni = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."000";
		$LoteFin = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."999";
	}
	else
	{
		$LoteIni = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."0000";
		$LoteFin = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."9999";
	}
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON MUESTRA PARALELA
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto,t1.lote, t4.nro_solicitud, t4.recargo,t4.fecha_hora as fecha_sa,t4.rut_funcionario as rut_sa, t1.rut_proveedor, t3.nomprv_a, t4.nro_solicitud, ";
	$Consulta.= " t4.estado_actual, t4.peso_muestra,t4.peso_retalla,t5.nombre_subclase as estado, t6.abreviatura as nom_prod, t1.fecha_recepcion, t7.rut_proceso as rut_funcionario, ";
	$Consulta.= " t7.fecha_hora, t7.cod_leyes, t7.cod_unidad, t7.rut_proceso, t8.cod_leyes as cod_leyes_ant, t9.nombre_subclase, ";
	$Consulta.= " t8.fecha_hora as fecha_hora_ant, t8.rut_proceso as rut_funcionario_ant, t8.valor as valor_ant, ";
	$Consulta.= " t10.apellido_paterno, t10.apellido_materno, t10.nombres, t11.apellido_paterno as apellido_paterno_ant, ";
	$Consulta.= " t11.apellido_materno as apellido_materno_ant, t11.nombres as nombres_ant "; 
	//$Consulta.= " , t7.valor";
	$Consulta.= " ,(select t16.valor from cal_web.registro_leyes t16 where t4.nro_solicitud=t16.nro_solicitud and t4.recargo=t16.recargo and t7.cod_leyes=t16.cod_leyes and t16.candado='1' and t16.fecha_hora > '".$FechaCierreAnexo."'   order by t16.fecha_hora desc limit 1) as valor";
	$Consulta.= " ,(select t15.valor from cal_web.registro_leyes t15 where t7.nro_solicitud=t15.nro_solicitud and t7.recargo=t15.recargo and t7.cod_leyes=t15.cod_leyes and t15.fecha_hora < t7.fecha_hora and t15.candado=1 order by t15.fecha_hora desc limit 1) as valor_ant"; 
	$Consulta.= " from age_web.lotes t1 ";
	$Consulta.= " inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
	$Consulta.= " inner join cal_web.solicitud_analisis t4 on t1.lote=t4.id_muestra ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='1002' and t4.estado_actual=t5.cod_subclase  ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t6 on t6.cod_producto='1' and t6.cod_subproducto=t1.cod_subproducto ";
	$Consulta.= " inner join cal_web.registro_leyes t7 on t4.nro_solicitud=t7.nro_solicitud and t4.recargo=t7.recargo ";
	$Consulta.= " inner join cal_web.registro_leyes t8 on t7.nro_solicitud=t8.nro_solicitud and t7.recargo=t8.recargo and t7.cod_leyes=t8.cod_leyes ";
	$Consulta.= " and t8.fecha_hora < t7.fecha_hora and t8.candado=1 ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t9 on t9.cod_clase='1002' and t9.cod_subclase=t4.estado_actual  ";
	$Consulta.= " left join proyecto_modernizacion.funcionarios t10 on t7.rut_proceso=t10.rut ";
	$Consulta.= " left join proyecto_modernizacion.funcionarios t11 on t8.rut_proceso=t11.rut ";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."'  ";
	//$Consulta.= " and (t4.recargo='0' or t4.recargo='' or isnull(t4.recargo))  ";
	$Consulta.= " and t7.cod_leyes in('01','02','04','05') and t7.candado='1' ";
	$Consulta.= " and t7.fecha_hora > '".$FechaCierreAnexo."' ";
	//$Consulta.= " and t7.valor<>t8.valor ";
	//$Consulta.= " and t7.valor<>valor_ant ";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " group by t1.lote,t7.cod_leyes ";			
	switch ($Orden)
	{
		case "L":
			$Consulta.= " order by t1.lote, t7.cod_leyes ";
			break;
		case "S":
			$Consulta.= " order by t4.nro_solicitud, t7.cod_leyes ";
			break;
		case "PD":
			$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0'), t1.lote, t7.cod_leyes ";
			break;
		case "PV":
			$Consulta.= " order by lpad(t1.rut_proveedor,11,'0'), t1.lote, t7.cod_leyes ";
			break;
		case "FR":
			$Consulta.= " order by t1.fecha_recepcion, t1.lote, t7.cod_leyes ";
			break;
		default:
			$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0'), t1.lote, t7.cod_leyes ";
			break;
	}	
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$ContSA=0;
	$ContLotes=0;
	$ContSA_Fin=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{	
		$ValAntIf=round($Fila['valor_ant'] * 100) / 100;
		$ValActIf=round($Fila['valor'] * 100) / 100;
		//echo "if(".$ValActIf."<>".$ValAntIf.")<br>";
		if($ValActIf<>$ValAntIf)
		{			
		echo "<tr align=\"center\">\n";
		echo "<td align=\"left\">".substr($Fila["nom_prod"],0,20)."&nbsp;</td>\n";
		echo "<td align=\"left\">".substr($Fila["nomprv_a"],0,20)."&nbsp;</td>\n";
		echo "<td><a href=\"JavaScript:DetalleLote('".$Fila[lote]."')\">$Fila[lote]</a></td>";
		//echo "<td>".$Fila["lote"]."</td>\n";		
		if 	($Fila["nro_solicitud"]=="")
			echo "<td>&nbsp;</td>\n";		
		else
		{
			if ($Fila["nro_solicitud"]!="")
				echo "<td><a href=\"JavaScript:Historial('".$Fila["nro_solicitud"]."','".$Fila["recargo"]."')\" class=\"LinksAzul\">".substr($Fila["nro_solicitud"],4)."</a></td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}			
		if ($Fila["estado_actual"]!=6)
			echo "<td bgcolor='yellow'>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
		else
		{
			if ($Fila["nombre_subclase"]!="")
				echo "<td>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		switch ($Fila["cod_leyes"])
		{
			case "01":
				$NomLey="H2O";
				$Conversion=100;
				$Decimales=2;
				break;
			case "02":
				$NomLey="Cu";
				$Conversion=100;
				$Decimales=2;
				break;
			case "04":
				$NomLey="Ag";
				$Conversion=1000;
				$Decimales=2;
				break;
			case "05":
				$NomLey="Au";
				$Conversion=1000;
				$Decimales=2;
				break;
		}
		echo "<td>".$NomLey."</td>\n";
		//RESCATA PESO
		$ValorAnt=0;
		$ValorActual=0;
		$DatosLote = array();
		$ArrLoteLeyes=array();
		$DatosLote["lote"]=$Fila["lote"];
		$DatosLote["recargo"]="";
		LeyesLote($DatosLote,$ArrLoteLeyes,"N","S","S","","","",$link);				
		if($Fila["recargo"]=='R')//CUANDO HAY DIFERENCIA EN LA RETALLA
		{
			$ValorLeyIncActual = $ArrLoteLeyes[$Fila["cod_leyes"]][2];
			$ValorLey=$ArrLoteLeyes[$Fila["cod_leyes"]][2]-$ArrLoteLeyes[$Fila["cod_leyes"]][22];
			$PesoRetalla=$Fila["peso_retalla"];
			$PesoMuestra=$Fila["peso_muestra"];
			if ($PesoRetalla>0 && $PesoMuestra>0)
				$IncRetalla = ($ValorLey - $Fila["valor_ant"]) * ($PesoRetalla/$PesoMuestra);  //VALOR					
			else
				$IncRetalla = 0;  //VALOR		
			$ValorLeyIncAnt=$ValorLey+$IncRetalla;
			$ValorAnt=$ValorLeyIncAnt;
			$ValorActual=$ValorLeyIncActual;
		}
		else
		{
			//$ValorLeyIncActual = $ArrLoteLeyes[$Fila["cod_leyes"]][2];
			$IncRetallaAnt=0;$IncRetallaAct=0;
			$Consulta="select valor from age_web.leyes_por_lote where lote='".$Fila["lote"]."' and recargo='R' and cod_leyes='".$Fila["cod_leyes"]."'";
			$RespRetalla=mysqli_query($link, $Consulta);
			if($FilaRet=mysqli_fetch_array($RespRetalla))
			{
				//echo $Consulta."<br>";
				$ValorRet=$FilaRet[valor];
				$Consulta="select * from cal_web.solicitud_analisis where fecha_hora='".$Fila[fecha_sa]."' and rut_funcionario='".$Fila[rut_sa]."' and id_muestra='".$Fila["lote"]."' and nro_solicitud='".$Fila["nro_solicitud"]."' and recargo='R'";
				//echo $Consulta."<br>";
				$RespSA=mysqli_query($link, $Consulta);
				$FilaSA=mysqli_fetch_array($RespSA);
				$PesoRetalla=$FilaSA["peso_retalla"];
				$PesoMuestra=$FilaSA["peso_muestra"];
				//echo "ret".$Fila["peso_retalla"]."<br>";
				//echo "ret2".$Fila["peso_muestra"]."<br>";
				if ($PesoRetalla>0 && $PesoMuestra>0)
				{
					$IncRetallaAnt = ($Fila["valor_ant"] - $ValorRet) * ($PesoRetalla/$PesoMuestra);  //VALOR					
					$IncRetallaAct = ($Fila["valor"] - $ValorRet) * ($PesoRetalla/$PesoMuestra);  //VALOR
					//echo "aaa".$IncRetallaAnt."<br>";
					//echo "aaa".$IncRetallaAct."<br><br>";
				}	
			}
			$Consulta="select * from cal_web.registro_leyes where rut_funcionario='".$Fila[rut_sa]."' and nro_solicitud='".$Fila["nro_solicitud"]."' and recargo='".$Fila["recargo"]."' and cod_leyes='".$Fila["cod_leyes"]."'";
			//$Consulta.=" and fecha_hora<='".$FechaCierreAnexo."' ";
			$Consulta.="order by fecha_hora desc";
			//echo $Consulta."<br>";
			$RespLeyAct=mysqli_query($link, $Consulta);
			$FilaLeyAct=mysqli_fetch_array($RespLeyAct);
			//echo $FilaLeyAnt[valor];
			$ValorActual=$FilaLeyAct["valor"]+abs($IncRetallaAct);
			
			$ValorAnt=$Fila["valor_ant"]+abs($IncRetallaAnt);
			//$ValorActual=$Fila["valor"]+abs($IncRetallaAct);
		}
		//VALORES ANTERIORES
		$NombreQuim=strtoupper(substr($Fila["nombres_ant"],0,1)).".".ucwords(strtolower($Fila["apellido_paterno_ant"]));		
		echo "<td>".substr($Fila["fecha_hora_ant"],8,2)."/".substr($Fila["fecha_hora_ant"],5,2)."/".substr($Fila["fecha_hora_ant"],2,2)."</td>\n";
		echo "<td>".$NombreQuim."</td>\n";
		echo "<td align=\"right\">".number_format($ValorAnt,$Decimales,",",".")."</td>\n";
		//CAMBIOS
		$NombreQuim=strtoupper(substr($Fila["nombres"],0,1)).".".ucwords(strtolower($Fila["apellido_paterno"]));
		echo "<td>".substr($Fila["fecha_hora"],8,2)."/".substr($Fila["fecha_hora"],5,2)."/".substr($Fila["fecha_hora"],2,2)."</td>\n";
		echo "<td>".$NombreQuim."</td>\n";
		echo "<td align=\"right\">".number_format($ValorActual,$Decimales,",",".")."</td>\n";
		if ($Fila["cod_leyes"]=="01")
		{
			$Consulta = "select sum(peso_neto) as peso_neto from age_web.detalle_lotes ";
			$Consulta.= " where lote='".$Fila["lote"]."'";
			//$Consulta.= " and recargo='".$Fila["recargo"]."' group by lote";
			$RespAux=mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))
			{
				$PesoHum = $FilaAux["peso_neto"];
				$PS_ANT=($Fila["valor_ant"]*$PesoHum)/$Conversion;
				$PS_ACT=($Fila["valor"]*$PesoHum)/$Conversion;
				$DIF=abs($PS_ACT-$PS_ANT);
				$Ajuste=$DIF;
				/*echo $PS_ACT."<br>";
				echo $PS_ANT."<br>";
				echo $DIF."<br>";
				$DifLeyes=$Fila["valor_ant"] - $Fila["valor"];
				echo "ant:".$Fila["valor_ant"]."<br>";
				echo "act:".$Fila["valor"]."<br>";
				echo "Ph:".$PesoHum ."<br><br>";
				/*echo "dif:".$DifLeyes."<br><br>";*/
				//$Ajuste = ($DifLeyes*$PesoHum)/$Conversion;
				//$Ajuste = $PesoHum-($DifLeyes*$PesoHum);
				$AjusteCu = ($ArrLoteLeyes["02"][2] * $Ajuste)/100;
				$AjusteAg = ($ArrLoteLeyes["04"][2] * $Ajuste)/1000;
				$AjusteAu = ($ArrLoteLeyes["05"][2] * $Ajuste)/1000;
				
				//echo $Fila["lote"]."  ".$ArrLoteLeyes["02"][2]."-".$ArrLoteLeyes["04"][2]."-".$ArrLoteLeyes["05"][2]."<br><br>";
				//echo $Ajuste."-".$AjusteCu."-".$AjusteAg."-".$AjusteAu."<br>";
			}
			else
			{
				$Ajuste=0;
			}
		}
		else
		{
			$PesoSeco = $DatosLote["peso_seco"];
			if($Fila["recargo"]=='R')
			{
				switch ($Fila["cod_leyes"])
				{
					case "02":
						$ValorLeyIncActual = $ArrLoteLeyes["02"][2];
						$ValorLey=$ArrLoteLeyes["02"][2]-$ArrLoteLeyes["02"][22];
						break;
					case "04":
						$ValorLeyIncActual =  $ArrLoteLeyes["04"][2];
						$ValorLey=$ArrLoteLeyes["04"][2]-$ArrLoteLeyes["04"][22];
						break;
					case "05":
						$ValorLeyIncActual = $ArrLoteLeyes["05"][2];
						$ValorLey=$ArrLoteLeyes["05"][2]-$ArrLoteLeyes["05"][22];
						//echo $ValorLey."<br>";
						//echo $ArrLoteLeyes["05"][22]."<br><br>";
						break;
				}
				$PesoRetalla=$Fila["peso_retalla"];
				$PesoMuestra=$Fila["peso_muestra"];
				if ($PesoRetalla>0 && $PesoMuestra>0)
				{
					$IncRetalla = ($ValorLey - $Fila["valor_ant"]) * ($PesoRetalla/$PesoMuestra);  //VALOR					
					//$IncRetalla = ((($FilaAux["valor"] - $LeyParRetalla)) / $PesoMuestra)*$PesoRetalla;  //VALOR
					//echo "(".$FilaAux["valor"]." - ".$LeyParRetalla.") * (".$PesoRetalla."/".$PesoMuestra.")<br>";
				}	
				else
					$IncRetalla = 0;  //VALOR		
				$ValorLeyIncAnt=$ValorLey+$IncRetalla;
				$DifLeyes=$ValorLeyIncActual - $ValorLeyIncAnt;
				//echo $Fila["lote"]."   ".$Fila["valor_ant"]." - ".$Fila["valor"]." - INC_ANT: ".$ValorLeyIncAnt." - INC_ACT: ".$ValorLeyIncActual."<br><br>";
			}
			else	
			{	//$DifLeyes=$Fila["valor_ant"] - $Fila["valor"];FARA 03-09-06
				//$DifLeyes=$Fila["valor"] - $Fila["valor_ant"];
				$DifLeyes=$ValorActual - $ValorAnt;
				$FinoAnt=($ValorAnt*$PesoSeco)/$Conversion;
				$FinoAct=($ValorActual*$PesoSeco)/$Conversion;
				/*echo "FINO ACTUAL: ".$FinoAct."<br>";
				echo "FINO ANT: ".$FinoAnt."<br>";
				echo "AJUSTE(FINO_ACT-FINO_ANT): ".($FinoAct-$FinoAnt)."<br>";
				echo "PESO SECO: ".$PesoSeco."<br>";
				echo "CONVER: ".$Conversion."<br><br>";*/
			}
			//$Ajuste=$FinoAct-$FinoAnt;	
			$Ajuste = ($DifLeyes*$PesoSeco)/$Conversion;
		}		
		echo "<td align=\"right\">".number_format($Ajuste,$Decimales,",",".")."</td>\n";
		$ClaveChk=$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"]."~~".$Fila["cod_leyes"]."~~".$Ajuste;
		if ($Fila["cod_leyes"]=="01")
		{
			//AJUSTA FINO DE Cu, Ag, Au
			$ClaveChk.= "///".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"]."~~02~~".$AjusteCu;
			$ClaveChk.= "///".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"]."~~04~~".$AjusteAg;
			$ClaveChk.= "///".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"]."~~05~~".$AjusteAu;

		}
		echo "<td><input type=\"checkbox\" name=\"ChkUsar\" value=\"".$ClaveChk."\"></td>\n";
		}
	}
}//FIN MOSTRAR = S	
?>
	<tr align="center">
		<td colspan="14" class="Detalle01">&nbsp;</td>
		</tr>
</table>	  
<?php
	$MesAjuste = date("n", mktime(0,0,0,$Mes+1,1,$Ano));
	$AnoAjuste = date("Y", mktime(0,0,0,$Mes+1,1,$Ano));
	$NomMesAjuste = $Meses[$MesAjuste-1];
?>       
          <br>
          <table width="700" border="1" align="center" cellpadding="2" cellspacing="0">
            <tr align="center" class="Detalle01">
              <td height="18" colspan="4" class="Detalle01">Ajustes Usados (Auto. y Manuales) en el mes de <b><?php echo $NomMesAjuste; ?></b></td>
              <td height="18" colspan="5" class="Detalle01"><input name="BtnAgregar" type="button" id="BtnAgregar" value="Ajuste Manual" style="width:100px " onClick="Proceso('AM')">
              <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:70px " onClick="Proceso('M')">
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="UsarAjuste('E')"></td>
            </tr>
            <tr align="center" class="ColorTabla01">
              <td width="31" rowspan="2">A&ntilde;o</td>
              <td width="39" rowspan="2">Mes</td>
              <td width="133" rowspan="2">Producto</td>
              <td width="192" rowspan="2">Proveedor</td>
              <td height="18" colspan="4">Ajustes</td>
              <td width="33" rowspan="2">Selec.</td>
            </tr>
            <tr class="ColorTabla01" align="center">
              <td width="61" height="18">Peso</td>
              <td width="56">Cu (Kg) </td>
              <td width="48">Ag (g/t)</td>
              <td width="51">Au (g/t) </td>
            </tr>
            <?php		
				$TotalPesoSeco=0;
				$TotalFinoCu=0;
				$TotalFinoAg=0;
				$TotalFinoAu=0;
			if ($Mostrar=="S" && $FechaCierreAnexo!="")
			{
				$Consulta = "select t1.ano, t1.mes, t1.cod_producto, t1.cod_subproducto, t2.abreviatura, t1.peso_seco, ";
				$Consulta.= " t1.fino_cu, t1.fino_ag, t1.fino_au, t1.rut_proveedor, t3.nomprv_a";
				$Consulta.= " from age_web.ajustes t1 inner join proyecto_modernizacion.subproducto t2 ";
				$Consulta.= " on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.= " inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
				$Consulta.= " where t1.ano='".$AnoAjuste."' and t1.mes='".$MesAjuste."'";
				$Consulta.= " order by t1.cod_subproducto, t1.rut_proveedor ";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$TotalPesoSeco=0;
				$TotalFinoCu=0;
				$TotalFinoAg=0;
				$TotalFinoAu=0;
				while ($Fila=mysqli_fetch_array($Resp))
				{
					echo "<tr>\n";
					echo "<td align=\"center\">".$Fila["ano"]."</td>\n";
					echo "<td align=\"center\">".$Meses[$Fila["mes"]-1]."</td>\n";
					echo "<td>".$Fila["abreviatura"]."</td>\n";
					echo "<td>".$Fila["nomprv_a"]."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["peso_seco"],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["fino_cu"],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["fino_ag"],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["fino_au"],2,",",".")."</td>\n";
					$ClaveAjuste=$Fila["ano"]."~~".$Fila["mes"]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".$Fila["rut_proveedor"];
					echo "<td align=\"center\"><input type=\"checkbox\" name=\"ChkAjuste\" value=\"".$ClaveAjuste."\"></td>\n";
					echo "</tr>\n";
					$TotalPesoSeco=$TotalPesoSeco+$Fila["peso_seco"];
					$TotalFinoCu=$TotalFinoCu+$Fila["fino_cu"];
					$TotalFinoAg=$TotalFinoAg+$Fila["fino_ag"];
					$TotalFinoAu=$TotalFinoAu+$Fila["fino_au"];
				}
			}//FIN MOSTRAR = S	
?>
            <tr align="center">
              <td colspan="4" class="Detalle01">TOTAL AJUSTES </td>
              <td class="Detalle01" align="right"><?php echo number_format($TotalPesoSeco,2,",",".");?></td>
              <td class="Detalle01" align="right"><?php echo number_format($TotalFinoCu,2,",",".");?></td>
              <td class="Detalle01" align="right"><?php echo number_format($TotalFinoAg,2,",",".");?></td>
              <td class="Detalle01" align="right"><?php echo number_format($TotalFinoAu,2,",",".");?></td>
              <td class="Detalle01">&nbsp;</td>
            </tr>
      </table></td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
