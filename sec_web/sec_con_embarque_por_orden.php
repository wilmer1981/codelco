<?php
	include("../principal/conectar_principal.php"); 

	$Orden = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$CodProducto = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";

	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");

	$MesIni = str_pad($MesIni,2,"0",STR_PAD_LEFT);
 	$FechaInicio = $AnoIni."-".$MesIni."-01";
	$FechaTermino = $AnoIni."-".$MesIni."-31";
?>
<html>
<head>
<title>Sistema Estadistico de Catodo</title>
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_embarque_por_orden.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_embarque_por_orden_excel.php?Orden=<?php echo $Orden; ?>";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "R":
			f.action ="sec_con_embarque_por_orden.php?Orden=<?php echo $Orden; ?>";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Orden(opt)
{
	var f=document.frmPrincipal;
	f.action ="sec_con_embarque_por_orden.php?Orden="+opt;
	f.submit();
}
function Fax(Orden)
{
	var Frm=document.frmPrincipal;
	ValoresCheck=Orden+"~~"+"//";
	Frm.target="_blank";
	Frm.action="sec_con_fax_codelco.php?ValoresCheck="+ValoresCheck;
	Frm.submit();
	Frm.target="_parent";
	//window.open("sec_con_fax_codelco.php?ValoresCheck="+ValoresCheck+"&Tipo="+Tipo,"","top=50,left=50,fullscreen=no,width=760,height=600,scrollbars=yes,resizable = yes");
}
</script>

<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style type="text/css">
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
</style>
</head>

<body class="TablaPrincipal">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>CONSULTA ORDEN DE EMBARQUE </strong></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" class="TablaInterior">
    <tr>
      <td>Producto:</td>
      <td width="403"><SELECT name="CodProducto" onChange="Proceso('R')">
	  <option value="S">TODOS</option>
        <?php
		
	$Consulta = "SELECT * from proyecto_modernizacion.productos ";
	$Consulta.= " where cod_producto in('18','48','19','64') order by lpad(cod_producto,2,'0')";
	
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
	
		if ($CodProducto==$Fila["cod_producto"])
			echo "<option value=\"".$Fila["cod_producto"]."\" SELECTed>".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value=\"".$Fila["cod_producto"]."\" >".strtoupper($Fila["descripcion"])."</option>\n";			
	}
?>
      </SELECT>        </td>
    </tr>
    <tr>
      <td>SubProducto:</td>
      <td><SELECT name="SubProducto">
        <option value="S">TODOS</option>
        <?php
		
		if ($CodProducto == '19' || $CodProducto == '64')
		{
			if ($CodProducto == '19')
			{
				$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='".$CodProducto."' and cod_subproducto in('21','22','23')order by lpad(cod_subproducto,2,'0')";
				$Resp = mysqli_query($link, $Consulta);
				
			}	
			else
			{
				$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto ";
				$Consulta.= " WHERE cod_producto = '".$CodProducto."' and";
				$Consulta.= " cod_subproducto in('6') order by descripcion";
				$Resp = mysqli_query($link, $Consulta);
			}
			
		}
		else	
		{	
				$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='".$CodProducto."' order by lpad(cod_subproducto,2,'0')";
				$var=$Consulta;
				$Resp = mysqli_query($link, $Consulta);
		}
		
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($SubProducto==$Fila["cod_subproducto"])
			echo "<option value=\"".$Fila["cod_subproducto"]."\" SELECTed>".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value=\"".$Fila["cod_subproducto"]."\" >".strtoupper($Fila["descripcion"])."</option>\n";			
	}
	
?>
      </SELECT></td>
    </tr>
    <tr>
      <td width="83">Periodo: </td>
      <td>
        <SELECT name="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}/*
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}*/
		}
		?>
        </SELECT>
        <SELECT name="AnoIni" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
		}
		?>
      </SELECT></td>
    </tr>
    <tr>
      <td height="40" colspan="2" align="center">
        <input type="submit" name="Submit" value="Consultar">
        <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
        <input name="btnExcel" type="button" id="btnExcel" style="width:70;" onClick="JavaScript:Proceso('E')" value="Excel">
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir">
      </td>
    </tr>
  </table>
<br>
			
                <table width="550" height="48" border="1" align="center" cellpadding="1" cellspacing="0" background="../principal/imagenes/fondo3.gif" bgcolor="#FFFFFF" class="TablaInterior">
                  <tr>
                    <td colspan="6" class="ColorTabla01"><em><strong>ESTADOS:</strong></em></td>
                  </tr>
                  <tr>
                    <td width="30" align="center">&nbsp;</td>
                    <td width="130">Sin Prog. de Loteo </td>
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
  <BR>
  <table width="1000" height="14"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="63" align="center"><a href="JavaScript:Orden('Or_01');">#O.E.</a></td>
	  <td width="100" align="center"><a href="JavaScript:Orden('Or_05');">ASIGNACION</a></td>
      <td width="35" align="center"><a href="JavaScript:Orden('Or_04');">SUBPRODUCTO</a></td>
      <td width="224" align="center">MARCA</td>
	  <td width="65" align="center">ATAD.</td>
      <td width="45" align="center">PIEZAS</td>     
      <td width="73" align="center">PESO NETO </td>
	  <td width="82" align="center">PESO BRUTO </td> 
	  <td width="61" align="center"><a href="JavaScript:Orden('Or_02');">F.DISP.</a></td>
	  <td width="61" align="center"><a href="JavaScript:Orden('Or_03');">F.RETIRO</a></td>  
	  <td width="50" align="center">CON/CUO/PAR</td>      
      <td width="25" align="center">EST.</td>
      <td width="25" align="center">SAP</td>
	  <td width="50" align="center">SUBPRODUCTO PESAJE</td>
    </tr>
    <?php  
	
		//$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT);
	//echo "<br>FECHA:".$FechaAux;
   // $FechaControl = $FechaAux - 1; //desactivado por WSO, error al activar
	$FechaControl = $FechaAux;
     // echo "FECHA".$FechaControl;
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	//echo "Con".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($FilaMes = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $FilaMes["nombre_subclase"];
	}
		
	$CrearTmp = "create temporary table if not exists sec_web.tmp_orden "; 
	//$CrearTmp = "create  table if not exists sec_web.tmp_orden "; 
	$CrearTmp.= "(corr_enm bigint(8), ";
	$CrearTmp.= " cod_producto varchar(10), ";
	$CrearTmp.= " cod_subproducto varchar(10), ";
	$CrearTmp.= " cod_cliente varchar(30), ";
	$CrearTmp.= " fecha_disponible date, ";
	$CrearTmp.= " fecha_embarque date, ";
	$CrearTmp.= " estado char(1), ";
	$CrearTmp.= " nom_subprod varchar(50), ";
	$CrearTmp.= " asignacion varchar(20))";
	mysqli_query($link, $CrearTmp);
	//CONSULTA TABLA PROGRAMA ENAMI
	$Consulta="SELECT t1.corr_enm,t1.cod_producto, t1.cod_subproducto, t1.fecha_disponible, t1.fecha_embarque,t1.cod_cliente, t1.estado2  ";
	$Consulta.= " from sec_web.programa_enami t1 ";
	$Consulta.= " where  t1.fecha_embarque between '".$FechaInicio."' and '".$FechaTermino."' ";
	if ($CodProducto!="S")
		$Consulta.= " and  t1.cod_producto='".$CodProducto."' ";
	if ($SubProducto!="S")
		$Consulta.= " and  t1.cod_subproducto='".$SubProducto."' ";
	$Resultado=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		$Insertar = "insert into sec_web.tmp_orden (corr_enm,cod_producto, cod_subproducto,cod_cliente,fecha_disponible, fecha_embarque, estado, asignacion, nom_subprod) values(";
		$Insertar.= "'".$Fila["corr_enm"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila["cod_cliente"]."','".$Fila["fecha_disponible"]."','".$Fila["fecha_embarque"]."','".$Fila["estado2"]."','','')";
		mysqli_query($link, $Insertar);
	}
	//CONSULTA TABLA PROGRAMA CODELCO
	$Consulta = " SELECT t1.corr_codelco, t1.cod_producto, t1.cod_subproducto, t1.cod_cliente, t1.fecha_disponible, t1.estado2, t1.cod_contrato_maquila, t2.abreviatura ";
	$Consulta.= " from sec_web.programa_codelco  t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
	$Consulta.= " where  t1.fecha_disponible between '".$FechaInicio."' and '".$FechaTermino."' ";
	if ($CodProducto!="S")
		$Consulta.= " and  t1.cod_producto='".$CodProducto."' ";
	if ($SubProducto!="S")
		$Consulta.= " and  t1.cod_subproducto='".$SubProducto."' ";
	$Resultado=mysqli_query($link, $Consulta);
	//echo $Consulta;
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		$Insertar = "insert into sec_web.tmp_orden (corr_enm,cod_producto, cod_subproducto, cod_cliente,fecha_disponible, fecha_embarque, estado, asignacion, nom_subprod) values(";
		$Insertar.= "'".$Fila["corr_codelco"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila["cod_cliente"]."','".$Fila["fecha_disponible"]."', '".$Fila["fecha_disponible"]."', '".$Fila["estado2"]."', '".$Fila["cod_contrato_maquila"]."', '".$Fila["abreviatura"]."')";
		/*if ($Fila["corr_codelco"]=='9061')
		
			echo $Insertar;*/
		mysqli_query($link, $Insertar);
	}
	//aqui poner un SELECT para 18 y otros  *******if ($CodProducto == '18')
	
		$Consulta = "SELECT t0.corr_enm, t0.fecha_embarque, t0.fecha_disponible, count(*) as num_paquetes, sum(t2.num_unidades) as unidades, ";
		$Consulta.= " t0.cod_cliente, ifnull(sum(t2.peso_paquetes),0) as peso, t3.descripcion, t0.estado, t0.asignacion, t0.nom_subprod ";
		$Consulta.= " from sec_web.tmp_orden t0 left join sec_web.lote_catodo t1 on t0.corr_enm=t1.corr_enm";
		$Consulta.= " left join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete=t2.fecha_creacion_paquete ";
		$Consulta.= " left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
		//$Consulta.= " inner join proyecto_modernizacion.subproducto t4 on t2.cod_producto=t4.cod_producto and t2.cod_subproducto=t4.cod_subproducto ";
 		$Consulta.= " where t0.corr_enm <80000 and t0.estado<>'A' and t0.fecha_embarque between '".$FechaInicio."' and '".$FechaTermino."' ";
		$Consulta.= " and year(t1.fecha_creacion_lote)  >= '".$FechaControl."'";
			
	if ($CodProducto!="S")
		$Consulta.= " and  t0.cod_producto='".$CodProducto."' ";
	if ($SubProducto!="S")
		$Consulta.= " and  t0.cod_subproducto='".$SubProducto."' ";
	$Consulta.= " group by t0.corr_enm ";
	switch ($Orden)
	{
		case "Or_01":
			$Consulta.= "order by t0.corr_enm";
			break;
		case "Or_02":
			$Consulta.= "order by t0.fecha_disponible, t0.corr_enm ";
			break;
		case "Or_03":
			$Consulta.= "order by t0.fecha_embarque, t0.corr_enm ";
			break;
		case "Or_04":
			$Consulta.= "order by t0.nom_subprod, t0.fecha_embarque, t0.corr_enm ";
			break;
		case "Or_05":
			$Consulta.= "order by t0.asignacion, t0.corr_enm ";
			break;
	}


	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPesoBr = 0;
	$TotalPeso = 0;
	$TotalPaquetes = 0;
	$TotalUnidades = 0;
	$MaqAnt=""; 
	$Asig="";
	//echo $Consulta."<br>";
	$TotalAsigPesoBr = 0;
	$TotalAsigPeso = 0;
	$TotalAsigPaquetes = 0;
	$TotalAsigUnidades = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if(isset($Fila["asignacion"])){
			$Asig=$Fila["asignacion"];
		}
		//CONSULTA ASIGNACION Y FECHA DISPONIBILIDAD		
		$Asignacion="";
		$FechaDisp = "";
		$FechaEmb = "";	
		$Consulta = "SELECT * from sec_web.programa_codelco t1 inner join ";
		$Consulta.= " proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
		$Consulta.= " where t1.corr_codelco='".$Fila["corr_enm"]."'";
		//echo $Consulta;
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$Asignacion= $FilaAux["cod_contrato_maquila"];
			$NomSubProducto=$FilaAux["abreviatura"];
			//$FechaDisp = $FilaAux["fecha_disponible"];
		}
		else
		{
			$Consulta = "SELECT * from sec_web.programa_enami t1 inner join proyecto_modernizacion.subproducto t2 ";
			$Consulta.= " on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " where t1.corr_enm='".$Fila["corr_enm"]."'";
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))
			{
				$Asignacion="MAQ ENM";
				$NomSubProducto=$FilaAux["abreviatura"];
				//$FechaDisp = $FilaAux["fecha_disponible"];
			}
		}		
		$ClienteNave = "";
		$Contrato    = $FilaAux["cod_contrato"];
		$Cuota		 = $FilaAux["mes_cuota"];
		$Partida	 = $FilaAux["partida"];
		$ClienteNave = $Contrato."/".$Cuota."/".$Partida;
				 		
		$FechaEmb = $Fila["fecha_embarque"];	
		$FechaDisp = $Fila["fecha_disponible"];
		if ($Fila["peso"]=="0")
		{
			$Paquetes=0;
			$Unidades=0;
		}
		else
		{
			$Paquetes=$Fila["num_paquetes"];
			$Unidades=$Fila["unidades"];
		}
		//-------------------------
		if ($MaqAnt != $Fila["asignacion"] && $MaqAnt!="" && $Orden=="Or_05")
		{	
			echo "<tr class=\"Detalle02\">\n";
			echo "<td align=\"center\" colspan=\"4\"><b>TOTAL&nbsp;&nbsp;".strtoupper($MaqAnt)."</b></td>\n";
			echo "<td align=\"right\">".number_format($TotalAsigPaquetes,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($TotalAsigUnidades,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($TotalAsigPeso,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format(($TotalAsigPeso+$TotalAsigPaquetes),0,",",".")."</td>\n";
			echo "<td>&nbsp;</td>\n";		
			echo "<td>&nbsp;</td>\n";		
			echo "<td align=\"center\">&nbsp;</td>\n";
			echo "<td align='center'>&nbsp;</td>\n";	
			echo "</tr>\n";
			$TotalAsigPesoBr = 0;
			$TotalAsigPeso = 0;
			$TotalAsigPaquetes = 0;
			$TotalAsigUnidades = 0;
		}
		//CONSULTA SI YA FUE TRASPASADO A SAP
		$LoteCons=substr($AnoIni,2,2).str_pad($MesIni,2,"0",STR_PAD_LEFT).$Fila["corr_enm"];
		//echo $LoteCons." ".$Fila["corr_enm"]."<br>";
		$Consulta = "SELECT * from interfaces_codelco.registro_traspaso ";
		$Consulta.= " where (referencia='".$LoteCons."' )";// or referencia='".$Fila["corr_enm"]."') ";
		$Consulta.= " and tipo_movimiento='921'";
		$RespSap=mysqli_query($link, $Consulta);
		$Traspasado=false;
		if ($FilaSap=mysqli_fetch_array($RespSap))
		{
			/*echo substr($FilaSap["registro"],44,18)."<br>";
			if (intval(substr($FilaSap["registro"],44,18))==3)*/
				$Traspasado=true; 
		}
		//-----------------------------------		
		if ($Traspasado==true)
			echo "<tr class=\"Detalle01\">\n";
		else
			echo "<tr bgcolor=\"white\">\n";
		echo "<td align='center'>";
		$Consulta = "SELECT * from sec_web.embarque_ventana where corr_enm='".$Fila["corr_enm"]."'";
		$RespAux=mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
			echo "<a href=\"JavaScript:Fax('".$Fila["corr_enm"]."')\"><font class=\"LinksAzulRaya\">".$Fila["corr_enm"]."</font></a>";
		else
			echo $Fila["corr_enm"];
		echo "</td>\n";
		echo "<td align=\"center\">".strtoupper($Asignacion)."&nbsp;</td>\n";
		echo "<td>".strtoupper($NomSubProducto)."&nbsp;</td>\n";	
		echo "<td>".strtoupper($Fila["descripcion"])."&nbsp;</td>\n";						
		echo "<td align=\"right\">".number_format($Paquetes,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($Unidades,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format(($Fila["peso"]+$Paquetes),0,",",".")."</td>\n";
		echo "<td>".substr($FechaDisp,8,2)."/".substr($FechaDisp,5,2)."/".substr($FechaDisp,2,2)."</td>\n";		
		echo "<td>".substr($FechaEmb,8,2)."/".substr($FechaEmb,5,2)."/".substr($FechaEmb,2,2)."</td>\n";		
		echo "<td align=\"center\">".strtoupper($ClienteNave)."</td>\n";
		if ($Fila["estado"]=="")
			echo "<td align=\"center\">&nbsp;</td>\n";	
		else
			echo "<td align=\"center\">".strtoupper($Fila["estado"])."</td>\n";	
		if ($Traspasado)
			echo "<td align=\"center\">SI</td>\n";
		else
			echo "<td align=\"center\">NO</td>\n";
		//BUSCA EL SUBPRODUCTO CUANDO SE A PESADO	
		$Consulta="SELECT distinct t3.abreviatura as nom_subproducto from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete=t2.fecha_creacion_paquete ";
		$Consulta.="left join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
		$Consulta.="where corr_enm='".$Fila["corr_enm"]."'";
		$RespSubProd=mysqli_query($link, $Consulta);
		if($FilaSubProd=mysqli_fetch_array($RespSubProd))
			echo "<td align=\"center\">".$FilaSubProd["nom_subproducto"]."</td>\n";	
		else
			echo "<td align=\"center\">&nbsp;</td>\n";	
		echo "</tr>\n";
		$TotalPesoBr = $TotalPesoBr + ($Fila["peso"]+$Fila["num_paquetes"]);
		$TotalPeso = $TotalPeso + $Fila["peso"];
		$TotalPaquetes = $TotalPaquetes + $Fila["num_paquetes"];
		$TotalUnidades = $TotalUnidades + $Fila["unidades"];
		//TOTALES ASIGANCION
		$TotalAsigPesoBr = $TotalAsigPesoBr + ($Fila["peso"]+$Fila["num_paquetes"]);
		$TotalAsigPeso = $TotalAsigPeso + $Fila["peso"];
		$TotalAsigPaquetes = $TotalAsigPaquetes + $Fila["num_paquetes"];
		$TotalAsigUnidades = $TotalAsigUnidades + $Fila["unidades"];
		//-----------------------------------------------------
		$MaqAnt=$Fila["asignacion"]; 
	}
	//if ($MaqAnt != $Fila["asignacion"] && $MaqAnt!="" && $Orden=="Or_05")
	if ($MaqAnt != $Asig && $MaqAnt!="" && $Orden=="Or_05")
	{	
		echo "<tr class=\"Detalle02\">\n";
		echo "<td align=\"center\" colspan=\"4\"><b>TOTAL&nbsp;&nbsp;".strtoupper($MaqAnt)."</b></td>\n";
		echo "<td align=\"right\">".number_format($TotalAsigPaquetes,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($TotalAsigUnidades,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($TotalAsigPeso,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format(($TotalAsigPeso+$TotalAsigPaquetes),0,",",".")."</td>\n";
		echo "<td>&nbsp;</td>\n";		
		echo "<td>&nbsp;</td>\n";		
		echo "<td align=\"center\">&nbsp;</td>\n";
		echo "<td align='center'>&nbsp;</td>\n";	
		echo "</tr>\n";
		$TotalAsigPesoBr = 0;
		$TotalAsigPeso = 0;
		$TotalAsigPaquetes = 0;
		$TotalAsigUnidades = 0;
	}
	/*$BorrarTmp="drop table sec_web.tmp_orden";
	mysqli_query($link, $BorrarTmp);*/
?>
    <tr class="ColorTabla02"> 
      <td colspan="4" align="left"><strong>TOTALES</strong></td>
      <td align="right"><strong><?php echo number_format($TotalPaquetes,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalUnidades,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalPeso,0,",","."); ?></strong></td>
	  <td align="right"><strong><?php echo number_format($TotalPesoBr,0,",","."); ?></strong></td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td colspan="4" align="right">&nbsp;</td>
    </tr>
  </table>  
  <br>
</form>
</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>
