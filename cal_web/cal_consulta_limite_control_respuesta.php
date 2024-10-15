<?php include("../principal/conectar_principal.php");
$CookieRut=$_COOKIE["CookieRut"];


if(isset($_REQUEST["CmbProductos"])) {
	$CmbProductos = $_REQUEST["CmbProductos"];
}else{
	$CmbProductos ="";
}
if(isset($_REQUEST["CmbSubProducto"])) {
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
}else{
	$CmbSubProducto ="";
}
if(isset($_REQUEST["CmbPeriodo"])) {
	$CmbPeriodo = $_REQUEST["CmbPeriodo"];
}else{
	$CmbPeriodo ="";
}
if(isset($_REQUEST["CmbTipo"])) {
	$CmbTipo = $_REQUEST["CmbTipo"];
}else{
	$CmbTipo ="";
}
if(isset($_REQUEST["CmbTipoAnalisis"])) {
	$CmbTipoAnalisis = $_REQUEST["CmbTipoAnalisis"];
}else{
	$CmbTipoAnalisis ="";
}
if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias=1;
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes=date("n");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno=date("Y");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT=date("j");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT=date("n");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT = date("Y");
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin = 50;
}
if(isset($_REQUEST["Opc"])) {
	$Opc = $_REQUEST["Opc"];
}else{
	$Opc = 1;
}
if(isset($_REQUEST["Chk"])) {
	$Chk = $_REQUEST["Chk"];
}else{
	$Chk = "";
}

if(isset($_REQUEST["ChkAgrupacion"])) {
	$ChkAgrupacion = $_REQUEST["ChkAgrupacion"];
}else{
	$ChkAgrupacion = "";
}
if(isset($_REQUEST["ChkFechaMuestra"])) {
	$ChkFechaMuestra = $_REQUEST["ChkFechaMuestra"];
}else{
	$ChkFechaMuestra = "";
}
if(isset($_REQUEST["ChkProducto"])) {
	$ChkProducto = $_REQUEST["ChkProducto"];
}else{
	$ChkProducto = "";
}
if(isset($_REQUEST["ChkSubProducto"])) {
	$ChkSubProducto = $_REQUEST["ChkSubProducto"];
}else{
	$ChkSubProducto = "";
}
if(isset($_REQUEST["ChkPesoMuestra"])) {
	$ChkPesoMuestra = $_REQUEST["ChkPesoMuestra"];
}else{
	$ChkPesoMuestra = "";
}
if(isset($_REQUEST["ChkObservacion"])) {
	$ChkObservacion = $_REQUEST["ChkObservacion"];
}else{
	$ChkObservacion = "";
}
if(isset($_REQUEST["ChkFechaEntrada"])) {
	$ChkFechaEntrada = $_REQUEST["ChkFechaEntrada"];
}else{
	$ChkFechaEntrada = "";
}

if(isset($_REQUEST["ChkLimite"])) {
	$ChkLimite = $_REQUEST["ChkLimite"];
}else{
	$ChkLimite = "";
}

/***************************************************************** */
if(isset($_REQUEST["CmbProveedores"])) {
	$CmbProveedores = $_REQUEST["CmbProveedores"];
}else{
	$CmbProveedores ="";
}
if(isset($_REQUEST["CmbCCosto"])) {
	$CmbCCosto = $_REQUEST["CmbCCosto"];
}else{
	$CmbCCosto ="";
}
if(isset($_REQUEST["CmbAreasProceso"])) {
	$CmbAreasProceso = $_REQUEST["CmbAreasProceso"];
}else{
	$CmbAreasProceso ="";
}

$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
$CCosto      = isset($_REQUEST["CCosto"])?$_REQUEST["CCosto"]:"";
$Areas       = isset($_REQUEST["Areas"])?$_REQUEST["Areas"]:"";
$Enabal      = isset($_REQUEST["Enabal"])?$_REQUEST["Enabal"]:"";
/*********************************************************************** */


 	$Seleccion1= "select distinct t3.cod_leyes,t4.abreviatura";
	$Seleccion2= "select distinct t1.nro_solicitud,t1.nro_sa_lims, t1.recargo,t1.rut_proveedor ";
	$Seleccion3= "select count(distinct t1.nro_solicitud,t1.recargo) as total_registros ";

	$Eliminar="Delete from cal_web.tmp_limite_control where usuario='".$CookieRut."'";
	mysqli_query($link, $Eliminar);
	if($CmbProductos == "" && $CmbSubProducto == "")
	{
		$Producto="Todos";
		$SubProducto="Todos";
	}
	else
	{
		$ConsultaAux = "select t1.cod_producto, t2.cod_subproducto, t1.descripcion as nom_prod, t2.descripcion as nom_subprod from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2 ";
		$ConsultaAux.= " on t1.cod_producto=t2.cod_producto ";
		$ConsultaAux.= " where t1.cod_producto='".$CmbProductos."' and t2.cod_subproducto='".$CmbSubProducto."'";
		$Resp=mysqli_query($link, $ConsultaAux);
		if ($Fila=mysqli_fetch_array($Resp))
		{
			$Producto=$Fila["nom_prod"];
			$SubProducto=$Fila["nom_subprod"];
		}
	}
	$Proveedor="";
	if($CmbProveedores=='T' || $CmbProveedores!='' )
	{
		if($CmbProveedores=='T')
		{
			$Proveedor="Todos";
		}
		else
		{
			$ConsultaProv="select rut_prv,nombre_prv from sipa_web.proveedores where rut_prv='".$CmbProveedores."' order by nombre_prv"; 
			$Respuesta = mysqli_query($link, $ConsultaProv);
			if($Fila=mysqli_fetch_array($Respuesta))
			{
				$Proveedor=str_pad($Fila["rut_prv"], 10, "0", STR_PAD_LEFT)." - ".ucwords(strtolower($Fila["nombre_prv"]));
			}
		}
	}		
	else
	{
		$CmbProveedores='';
	}				
	//--------------------------------------
	//CONSULTA CENTRO COSTO
	$ConsultaAux = "select descripcion from proyecto_modernizacion.centro_costo ";
	$ConsultaAux.= " where centro_costo='".$CmbCCosto."' ";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$CCosto=$Fila["descripcion"];
	}
	//--------------------------------------
	//CONSULTA AREA
	$ConsultaAux = "select nombre_subclase from proyecto_modernizacion.sub_clase ";
	$ConsultaAux.= " where cod_clase = 3 and cod_subclase='".$CmbAreasProceso."' order by cod_subclase";
	$Resp=mysqli_query($link, $ConsultaAux);
	$Areas=""; //WSO
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$Areas=$Fila["nombre_subclase"];
	}
	//--------------------------------------
	$Consulta1 ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	$Fila1=mysqli_fetch_array($Respuesta1);
	$Nivel=$Fila1["nivel"];
	/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 50;*/

	///echo $LimitIni."   ".$LimitFin."<br>";	
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 22;
	if ($CmbTipo=='-1')
	{
		$Tipo='';
	}
	else
	{
		$Tipo=" and t1.tipo='".$CmbTipo."'";
	}
	if ($CmbTipoAnalisis=='-1')
	{
		$TipoAnalisis='';
	}
	else
	{
		$TipoAnalisis=" and t1.cod_analisis='".$CmbTipoAnalisis."'";
	}
	$Consulta =" "; // WSO
	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
	$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
	$Consulta = $Consulta."	left join 	proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
	$Consulta = $Consulta." where ((t1.estado_actual ='6' or t1.estado_actual='32') and t1.recargo<>'R') ";
	if($CmbPeriodo!='T')
		$Consulta =$Consulta." and (t1.cod_periodo='".$CmbPeriodo."')";
	$Consulta =$Consulta.$Tipo.$TipoAnalisis;
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5')||($Nivel=='8')||($CmbCCosto=='6150'))
	{
		$Consulta = $Consulta."  ";
	}
	else
	{
		$Consulta = $Consulta." and t1.cod_producto <> 1 ";
	
	}
	if ($CmbSubProducto==-2)
	{
		if ($CmbProductos!="-1")
		{
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		}
	}
	else
	{
		if ($CmbProductos!="-1")
		{
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		}
		if ($CmbSubProducto!="-2")
		{
			$Consulta=$Consulta." and t1.cod_subproducto ='".$CmbSubProducto."'";
		}
	}
	if($Proveedor!='')
	{
		if($CmbProveedores!='T')
			$Consulta = $Consulta." and  t1.rut_proveedor='".$CmbProveedores."' ";
	}
	
	if(strlen($CmbMes)==1){
		$CmbMes = "0".$CmbMes;
	}
	if(strlen($CmbDias)==1){
		$CmbDias = "0".$CmbDias;
	}
	if(strlen($CmbMesT)==1){
		$CmbMesT = "0".$CmbMesT;
	}
	if(strlen($CmbDiasT)==1){
		$CmbDiasT = "0".$CmbDiasT;
	}
	$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta = $Consulta." and (t1.fecha_muestra between '".$FechaI."' and '".$FechaT."')";
	//echo $Consulta;
	if($ChkLimite=="S")
	{
		$Marca="N";
		$Eliminar="Delete from cal_web.tmp_limite_control where usuario='".$CookieRut."'";
		mysqli_query($link, $Eliminar);
		$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud ";
		$Respuesta2=mysqli_query($link, $Criterio);
		//echo $Criterio."<br>";
		$FilaDatos= array(); //WSO
		while ($Fila=mysqli_fetch_array($Respuesta2))
		{		
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==""))
				{
					$Recargo='N';
					$Consulta5 ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
					$Consulta5=$Consulta5." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
					$Consulta5=$Consulta5." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto "; 
					$Consulta5=$Consulta5." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"]." and t1.recargo<>'R' ";
				
					$Resultado=mysqli_query($link, $Consulta5);
					$FilaDatos=mysqli_fetch_array($Resultado);
					$CodProdSol=$FilaDatos["cod_producto"];
					$CodSubProdSol=$FilaDatos["cod_subproducto"];
				}
				else
				{
					$Consulta5 ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
					$Consulta5=$Consulta5." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
					$Consulta5=$Consulta5." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
					$Consulta5=$Consulta5." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
					$Resultado=mysqli_query($link, $Consulta5);
					$FilaDatos=mysqli_fetch_array($Resultado);
					$CodProdSol=$FilaDatos["cod_producto"];
					$CodSubProdSol=$FilaDatos["cod_subproducto"];
				}	
				
				$Consulta6 ="select t1.cod_producto,t1.cod_subproducto,t1.cod_unidad,t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
				
				//echo $Consulta6."<br>";
				$Respuesta3=mysqli_query($link, $Consulta6);
				while($Fila3=mysqli_fetch_array($Respuesta3))
				{		
					$Tiene="N";
					
					
					
					$Valor=$Fila3["valor"];
					/*echo "CmbProductos".$CmbProductos."<br>";
					echo "CmbSubProducto".$CmbSubProducto."<br>";*/
					//ValorLimiteControl($CmbProductos,$CmbSubProducto,$Fila3["cod_leyes"],$Fila3["cod_unidad"],$Fila["rut_proveedor"],&$Valor,&$Tiene);
					ValorLimiteControl($CodProdSol,$CodSubProdSol,$Fila3["cod_leyes"],$Fila3["cod_unidad"],$Fila["rut_proveedor"],$Valor,$Tiene,$link);
					if($Tiene=='S')
					{
					
						$Insertar="insert into cal_web.tmp_limite_control(nro_solicitud,recargo,usuario) values(";
						$Insertar.="'".$Fila["nro_solicitud"]."','".$Fila["recargo"]."','".$CookieRut."')";
						mysqli_query($link, $Insertar);
						$Marca="S";
					}
				}
						
		
		}
				
		$Consulta= " from cal_web.solicitud_analisis t1 ";
		$Consulta.=" inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and ";
		$Consulta.=" t1.fecha_hora = t3.fecha_hora and t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
		$Consulta.=" inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes inner join  cal_web.tmp_limite_control t5 ";
		$Consulta.=" on t3.nro_solicitud=t5.nro_solicitud and t3.recargo=t5.recargo where t5.usuario='".$CookieRut."' and t1.recargo<>'R' ";
	}
	$Criterio=$Seleccion1.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud";// LIMIT ".$LimitIni.", ".$LimitFin;
	$Arreglo=array();
	$Respuesta1=mysqli_query($link, $Criterio);
	$AnchoTabla=0; //WSO
	while($Fila1=mysqli_fetch_array($Respuesta1))
	{
		$Arreglo[$Fila1["cod_leyes"]][0]=$Fila1["abreviatura"];
		$Arreglo[$Fila1["cod_leyes"]][1]="";
		$AnchoTabla=$AnchoTabla	+ 60;		
	
	}
	$ConcRIT2=$Seleccion3.$Consulta;
	$Criterio2=$ConcRIT2;
?>
<html>
<head>
<script language="JavaScript">
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleLimite(SA,Producto,SubProducto,CodLey,Unidad,Proveedor,Recargo)
{
		URL="cal_consulta_limite_control_detalle.php?SA="+SA+"&Producto="+Producto+"&SubProducto="+SubProducto+"&CodLey="+CodLey+"&Unidad="+Unidad+"&Proveedor="+Proveedor+"&Recargo="+Recargo;
		window.open(URL,"","top=30,left=30,width=510,height=300,status=yes,menubar=0,resizable=yes,scrollbars=yes");
}
function Imprimir()
{
	var f=document.FrmConsultaGeneral;
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnImprimir2.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	f.BtnSalir2.style.visibility = "hidden";
	window.print();
	f.BtnImprimir.style.visibility = "visible";
	f.BtnImprimir2.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
	f.BtnSalir2.style.visibility = "visible";

}
function Salir()
{
	var frm=document.FrmConsultaGeneral;
	frm.action="cal_consulta_limite_control.php";
	frm.submit();
}
function Recarga(LimitIni,Producto,SubProducto,CCosto,Areas,CmbProductos,CmbSubProducto,CmbCCosto,CmbAreasProceso,CmbPeriodo,CmbAno,CmbMes,CmbDias,CmbAnoT,CmbMesT,CmbDiasT,E,CmbTipoAnalisis,CmbTipo,ChkLimite,CmbProveedores)
{
	var frm=document.FrmConsultaGeneral;
	frm.action="cal_consulta_limite_control_respuesta.php?LimitIni="+LimitIni+"&Producto="+Producto+"&SubProducto="+SubProducto+"&CCosto="+CCosto+"&CmbCCosto="+CmbCCosto + "&CmbProductos="+CmbProductos+"&CmbSubProducto="+CmbSubProducto+"&Areas="+Areas+"&CmbPeriodo="+CmbPeriodo+"&CmbAreasProceso="+CmbAreasProceso + "&CmbAno="+CmbAno+"&CmbMes="+CmbMes+"&CmbDias="+CmbDias+"&CmbAnoT="+CmbAnoT+"&CmbMesT="+CmbMesT+"&CmbDiasT="+CmbDiasT+"&Enabal="+E+"&CmbTipoAnalisis="+CmbTipoAnalisis+"&CmbTipo="+CmbTipo+"&ChkLimite="+ChkLimite+"&CmbProveedores="+CmbProveedores;
	frm.submit(); 
}

</script>
<title>Consulta General</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaGeneral" method="post" action="">

  <table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999" class="TablaInterior">
  <?php if ($CCosto!=""){?>
	<?php }
	if ($Areas!="") { ?>
	<?php } ?>
    <tr bgcolor="#FFFFFF">
      <td > Tipo Analisis:</td>
      <td width="496" align="left" bgcolor="#EFEFEF">
        <?php
			  if ($CmbTipoAnalisis=='-1')
			  {
				 echo "Todos";
			  }
			  else
			  {	
				if ($CmbTipoAnalisis=='1')
				 {
					echo "Quimico";  
				 }
				 else
				 {
					echo "Fisico";  
				 }
			  } 	
			?>      </td>
    </tr>
	<?php if ($Producto!="") { ?>
    <tr bgcolor="#FFFFFF">
      <td width="90">Producto:</td>
      <td align="left" bgcolor="#EFEFEF"><?php echo $Producto; ?></td>
    </tr>
	<?php } 
	if ($SubProducto!="") {?>
    <tr bgcolor="#FFFFFF">
      <td>SubProducto:</td>
      <td bgcolor="#EFEFEF"><?php echo $SubProducto; ?></td>
    </tr>
	<?php } ?>
    <?php 	  if($CmbProductos=='1')
		  {
				 if ($Proveedor!="") {?>
			    <tr bgcolor="#FFFFFF">
			  	<td>Proveedor:</td>
			 	<td bgcolor="#EFEFEF"><?php echo $Proveedor; ?></td>
				</tr>
		  <?php
		  }
		  }
		  ?>
    <tr bgcolor="#FFFFFF">
      <td>Tipo Muestra:</td>
      <td bgcolor="#EFEFEF">
        <?php 
				$Con="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase=1005";
				$Con=$Con." and cod_subclase = '".$CmbTipo."'";
				$Respuesta= mysqli_query($link, $Con);
				$Fila= mysqli_fetch_array($Respuesta); 
				if(isset($Fila["nombre_subclase"])){
					$Tipo= $Fila["nombre_subclase"];
				}else{
					$Tipo= "";
				}
				
				if ($CmbTipo=='-1')
				{	
					echo "Todos";
				}
				else
				{	
					echo $Tipo ;
				}
			?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>Periodo:</td>
      <td bgcolor="#EFEFEF">
        <?php 
		        //$AnchoTabla = $AnchoTabla + 490;
				$ConsultaN = "select * from proyecto_modernizacion.sub_clase where cod_clase = 2 ";
				if($CmbPeriodo!='T')
					$ConsultaN.= " and cod_subclase = '".$CmbPeriodo."' ";
				$ConsultaN.= " order by cod_subclase";
				$RespuestaN= mysqli_query($link, $ConsultaN);
				$Periodo=""; //WSO
				while ($FilaN = mysqli_fetch_array($RespuestaN))
				{
					$Periodo=$FilaN["nombre_subclase"];
				}
				if($CmbPeriodo=='T')
					echo "Todos&nbsp;&nbsp;&nbsp;&nbsp;";
				else
					echo $Periodo."&nbsp;&nbsp;&nbsp;&nbsp;";
				switch ($CmbPeriodo)
				{
					case "1":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
					case "2":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;		
					case "3":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
					case "4":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
					case "5":
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;
					default:
					
						echo "<strong>Fecha Inicio:</strong> ".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."/".$CmbAno." <strong>Fecha Termino:</strong>  ".str_pad($CmbDiasT,2,'0',STR_PAD_LEFT)."/".str_pad($CmbMesT,2,'0',STR_PAD_LEFT)."/".$CmbAnoT;	
						break;	
				}
			?>      </td>
    </tr>
    <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70" onClick="Imprimir();" value="Imprimir">
&nbsp;
      <input name="BtnSalir" type="button" id="BtnSalir" style="width:70" onClick="Salir();" value="Salir"></td>
    </tr>
  </table>
  <br>
		<?php
			$AnchoTabla=$AnchoTabla+90;
			if ($ChkAgrupacion=="S") 
				$AnchoTabla=$AnchoTabla+60;
			if ($ChkFechaMuestra=="S")
				$AnchoTabla=$AnchoTabla+130;
			if ($ChkProducto=="S")
				$AnchoTabla=$AnchoTabla+100;
			if ($ChkSubProducto=="S")
				$AnchoTabla=$AnchoTabla+100;
			if ($ChkPesoMuestra=="S")
				$AnchoTabla=$AnchoTabla+60;
			if (($CmbProductos=='42')&&($CmbSubProducto=='33'))
				$AnchoTabla=$AnchoTabla+130;
			if ($ChkObservacion=="S")
				$AnchoTabla=$AnchoTabla+350; 
		?>
        <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999" style="font-size:9px ">
  
				<tr class="ColorTabla01">
				<?php 
				$OBSLEY=""; //WSO
				if (count($Arreglo)>0)
				{ ?>
					<td width="50" align="center">S.A</td>
					<td width="50" align="center">Id.Muestra</td>
					<!--<td width="80" align="center">Producto</td>
                    <td width="100" align="center">SubProducto</td>-->
					
					
					<?php
					//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
					reset($Arreglo);
					foreach($Arreglo as $Clave=>$Valor)
					{
						echo "<td  align=\"center\" colspan=\"2\">".$Valor[0]."</td>";
					}
					?>
					<?php if ($ChkAgrupacion=="S") {?>
					<td width="60" align="center">Agrup.</td>
					<?php }if ($ChkFechaMuestra=="S") {?>
					<td width="130" align="center">Fecha Muestra</td>
					<?php }if ($ChkProducto=="S") {?>
					<td width="100" align="center">Producto</td>
					<?php }//if ($ChkSubProducto=="S") {?>
					<td width="100" align="center">SubProducto</td>
					<?php //} 
					if ($ChkPesoMuestra=="S") {?>
					<td width="60" align="center">Peso Muestra</td>
					<?php }
					if (($CmbProductos=='42')&&($CmbSubProducto=='33'))
					{ ?>
					     <td width="130" align="center">Fecha Entrada</td>
					<?php }if ($ChkObservacion=="S") {?>
					<td width="350" align="center">Observaci&oacute;n</td>
					<?php } ?>
					<td width="350" align="center">Observaci&oacute;n Leyes</td>
		  </tr>
					<?php
					
					$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud LIMIT ".$LimitIni.", ".$LimitFin;
					$Respuesta2=mysqli_query($link, $Criterio);
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						echo "<tr bgcolor=\"#FFFFFF\">";
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==""))
						{
							$Recargo='N';
							if ($Fila["nro_sa_lims"]=='') {
								echo "<td align=\"center\"><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">".intval(substr($Fila["nro_solicitud"],4))."</a></td>";
							}else{
								echo "<td align=\"center\"><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">".$Fila["nro_sa_lims"]."</a></td>";
							}
							//echo "<td align=\"center\"><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">".intval(substr($Fila["nro_solicitud"],4))."</a></td>";
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto "; 
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"];
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td align=\"left\">".$FilaDatos["id_muestra"]."</td>";	
							/*$DesPros=SubProducto($FilaDatos["cod_producto"],$FilaDatos["cod_subproducto"]);
							$arrayDes=explode("~",$DesPros);
							echo "<td align=\"left\">".$arrayDes[0]."</td>";
							echo "<td align=\"left\">".$arrayDes[1]."</td>";	*/	
							$CodProdSol=$FilaDatos["cod_producto"];
							$CodSubProdSol=$FilaDatos["cod_subproducto"];						
						}
						else
						{
							echo "<td align=\"center\"><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."')\">".intval(substr($Fila["nro_solicitud"],4))."-".$Fila["recargo"]."</a></td>";								
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td  width='100' align=\"left\">".$FilaDatos["id_muestra"].    "    </td>";	
							$CodProdSol=$FilaDatos["cod_producto"];
							$CodSubProdSol=$FilaDatos["cod_subproducto"];
							/*$DesPros=SubProducto($FilaDatos["cod_producto"],$FilaDatos["cod_subproducto"]);
							$arrayDes=explode("~",$DesPros);
							echo "<td align=\"left\">".$arrayDes[0]."</td>";
							echo "<td align=\"left\">".$arrayDes[1]."</td>";	*/									
						}	
						//SE LIMPIA EL ARREGLO
						reset($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach($Arreglo as $Clave => $Valor )
						{
							$Arreglo[$Clave][1]="&nbsp;";				
						}
						$OBSLEY='';//SE ASIGNAN LOS VALORES AL ARREGLO
						$Consulta ="select t1.cod_producto,t1.cod_subproducto,t3.abreviatura as ley,t1.cod_unidad,t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad inner join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
						$Respuesta3=mysqli_query($link, $Consulta);
						
						while($Fila3=mysqli_fetch_array($Respuesta3))
						{
							if ($Fila3["signo"]=="N")
							{
								$Arreglo[$Fila3["cod_leyes"]][1]="ND";
								$Arreglo[$Fila3["cod_leyes"]][2]="";
							}
							else
							{
								if ($Fila3["signo"]=="=")
								{
									$Valor=ValorColor($Fila["nro_solicitud"],$CodProdSol,$CodSubProdSol,$Fila3["cod_leyes"],$Fila3["cod_unidad"],$Fila["rut_proveedor"],$Fila3["valor"],$Fila["recargo"],$link);
									$M=explode('~',$Valor);
									if($M[1]!='')
										$OBSLEY=$OBSLEY.$Fila3["ley"].":".$M[1]."/";
									$Arreglo[$Fila3["cod_leyes"]][1]=$M[0];
									$Arreglo[$Fila3["cod_leyes"]][2]=$Fila3["abreviatura"];
								}
								else
								{
										$Valor=ValorColor($Fila["nro_solicitud"],$CodProdSol,$CodSubProdSol,$Fila3["cod_leyes"],$Fila3["cod_unidad"],$Fila["rut_proveedor"],$Fila3["valor"],$Fila["recargo"],$link);
									$M=explode('~',$Valor);
									if($M[1]!='')
										$OBSLEY=$OBSLEY.$Fila3["ley"].":".$M[1]."/";
								
									$Arreglo[$Fila3["cod_leyes"]][1]=$Fila3["signo"]."".$M[0];
									$Arreglo[$Fila3["cod_leyes"]][2]=$Fila3["abreviatura"];
								}
							}		
						}
						//SE LLENA LA LISTA CON VALORES DEL ARREGLO
						reset($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach($Arreglo as $Clave => $Valor )
						{
							//echo "valor".$Valor[1]."--".$Valor[2]."</br>";
							$Valor1 = isset($Valor[1])?$Valor[1]:"";
							$Valor2 = isset($Valor[2])?$Valor[2]:"";
							echo "<td align=\"right\" >".$Valor1."</td>";
							echo "<td align=\"center\" bgcolor=\"#efefef\" ><span style=\"font-size:9px \">".$Valor2."</span></td>";
						}
						if ($ChkAgrupacion=="S")
							echo "<td align=\"left\">".$FilaDatos["nombre_subclase"]."</td>";							
						if ($ChkFechaMuestra=="S")
							echo "<td align=\"center\">".substr($FilaDatos["fecha_muestra"],8,2)."/".substr($FilaDatos["fecha_muestra"],5,2)."/".substr($FilaDatos["fecha_muestra"],2,2)." ".substr($FilaDatos["fecha_muestra"],11,5)."</td>";
						if ($ChkProducto=="S")
							echo "<td align=\"left\">".$FilaDatos["producto"]."</td>";
						//if ($ChkSubProducto=="S")
							echo "<td align=\"left\">".$FilaDatos["subproducto"]."</td>";		
						if (($FilaDatos["cod_producto"]=='42')&&(($FilaDatos["cod_subproducto"]=='33')||($FilaDatos["cod_subproducto"]=='35')||($FilaDatos["cod_subproducto"]=='53')))
						{
							$pos = strpos(strtoupper($FilaDatos["id_muestra"]),"R-");
							if ($pos === false)
							{
								if ($ChkPesoMuestra=="S")
									echo "<td align=\"center\">&nbsp;</td>";
								if ($ChkFechaEntrada=="S")
									echo "<td align=\"center\">&nbsp;</td>";
								if ($ChkObservacion=="S")
									echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
							}
							else
							{
					            $Consulta="select pesont_a from rec_web.despachos where lote_a='".substr($FilaDatos["id_muestra"],0,6)."' and recarg_a='".trim(substr($FilaDatos["id_muestra"],$pos+2))."'";
								$Resp=mysqli_query($link, $Consulta);
								if ($FilaPeso=mysqli_fetch_array($Resp))
								{								     
									if ($ChkPesoMuestra=="S")
										echo "<td align=\"right\">".$FilaPeso["pesont_a"]."</td>";
								    $Consultan="select fecha_a,hora_a from rec_web.despachos where lote_a='".substr($FilaDatos["id_muestra"],0,6)."' and recarg_a='".trim(substr($FilaDatos["id_muestra"],$pos+2))."'";
								    $Respn=mysqli_query($link, $Consultan);
								    if ($FilaFechan=mysqli_fetch_array($Respn))
									{
									   if ($ChkFechaEntrada=="S")
											echo "<td align=\"center\">".substr($FilaFechan["fecha_a"],8,2)."/".substr($FilaFechan["fecha_a"],5,2)."/".substr($FilaFechan["fecha_a"],2,2)." ".substr($FilaFechan["hora_a"],0,5)."</td>";
									}
									else
									{
										if ($ChkFechaEntrada=="S")
											echo "<td align=\"center\">&nbsp;</td>";
									}
									if ($ChkObservacion=="S")
										echo "<td >".$FilaDatos["observacion"]."&nbsp;</td>";
								}
								else
								{
									if ($ChkPesoMuestra=="S")
										echo "<td align=\"right\">&nbsp;</td>";
									if ($ChkFechaEntrada=="S")
										echo "<td align=\"center\">&nbsp;</td>";
									if ($ChkObservacion=="S")
										echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
								}
							}
						}
						else
						{
							if ($ChkPesoMuestra=="S")
								echo "<td>&nbsp;</td>";
							if ($ChkObservacion=="S")
								echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
						}	
						if($OBSLEY!='')
						$OBSLEY=substr($OBSLEY,0,strlen($OBSLEY)-1);
							echo "<td>".$OBSLEY."&nbsp;</td>";
						echo "</tr>";
					}
				}
				else
				{
					if(isset($FilaDatos["observacion"])){
						$filObservac = $FilaDatos["observacion"];
					}else{
						$filObservac ="";
					}
					if ($ChkPesoMuestra=="S")
						echo "<td>&nbsp;</td>";
					if ($ChkObservacion=="S")
						//echo "<td>".$FilaDatos["observacion"]."&nbsp;</td>";
						echo "<td>".$filObservac."&nbsp;</td>";
					if($OBSLEY!='')
						$OBSLEY=substr($OBSLEY,0,strlen($OBSLEY)-1);
							echo "<td>".$OBSLEY."&nbsp;</td>";
					echo "</tr>";
				}
			?>
  </table>
        <br>
        <table width="755" border="0" align="center" cellpadding="3" cellspacing="1"><!-- class="TablaInterior">-->
          <tr>
            <td align="center">
			<?php 
				if($Criterio2!='')
				{
				$Respuesta = mysqli_query($link, $Criterio2);
				$Row = mysqli_fetch_array($Respuesta);
				$Coincidencias = $Row["total_registros"];
				$NumPaginas = ($Coincidencias / 50);
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
						$LimiteInicial=$i * $LimitFin;
						$Param="$LimiteInicial,'$Producto','$SubProducto','$CCosto','$Areas','$CmbProductos','$CmbSubProducto','$CmbCCosto','$CmbAreasProceso','$CmbPeriodo','$CmbAno','$CmbMes','$CmbDias','$CmbAnoT','$CmbMesT','$CmbDiasT','$Enabal','$CmbTipoAnalisis','$CmbTipo','$ChkLimite','$CmbProveedores'";
						$Param=str_replace(" ","%20",$Param);
						//$StrPaginas.=  "<a href=JavaScript:Recarga('$LimiteInicial','$Producto','$SubProducto','$CCosto','$Areas','$CmbProductos','$CmbSubProducto','$CmbCCosto','$CmbAreasProceso','$CmbPeriodo','$CmbAno','$CmbMes','$CmbDias','$CmbAnoT','$CmbMesT','$CmbDiasT');>";
						$StrPaginas.=  "<a href=JavaScript:Recarga($Param);>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
				}
				echo substr($StrPaginas,0,-15);
				}	//echo $StrPaginas;
			?>	
		   </td>
		  </tr>
          <tr s>
            <td align="center"> <input name="BtnImprimir2" type="button" id="BtnImprimir2" style="width:70" onClick="Imprimir();" value="Imprimir">
&nbsp;
<input name="BtnSalir2" type="button" id="BtnSalir2" style="width:70" onClick="Salir();" value="Salir"></td>
          </tr>
  </table>
        <br>
        </td>
        </tr>
        </table>
</form>
</body>
</html>
<?php 
	function ValorLimiteControl($Producto,$SubProducto,$CodLey,$Unidad,$RutProveedor,$Valor,$Tiene,$link)
	{
	
		
		$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='".$RutProveedor."'";
		$RespColor = mysqli_query($link, $Consulta);
		if($FilaColor=mysqli_fetch_array($RespColor))
		{
			if(($Valor>=$FilaColor["limite_inicial"]) && ( $Valor<=$FilaColor["limite_final"] ))
			{
				$Valor=number_format($Valor,3,",",".");
				$Existe='N';
			}
			else
			{
				$Existe='S';
				$Valor="<span class='InputRojo'>".number_format($Valor,3,",",".")."</span>";
			}
			
		}
		else
		{
			$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
			$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='T'";
			$RespColor = mysqli_query($link, $Consulta);
			if($FilaColor=mysqli_fetch_array($RespColor))
			{
			
			//    0 <= 70   && 60 >= 70
				if(($Valor>=$FilaColor["limite_inicial"]) && ( $Valor<=$FilaColor["limite_final"] ))
				{
					$Existe='N';
				}
				else
				{
					$Existe='S';
				}
			}
			else
			{
				$Existe='N';
			}
		}
		if($Tiene=='N' && $Existe=='S')
			$Tiene='S';
			
		return($Tiene);
	}
	
	function ValorColor($SA,$Producto,$SubProducto,$CodLey,$Unidad,$RutProveedor,$Valor,$Recargo,$link)
	{
		$Obs='';
		$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='".$RutProveedor."'";
		$RespColor = mysqli_query($link, $Consulta);
		if($FilaColor=mysqli_fetch_array($RespColor))
		{
		//	echo $FilaColor["limite_inicial"]." ".$Valor." ".$FilaColor["limite_final"];
			if(($Valor>=$FilaColor["limite_inicial"]) && ( $Valor<=$FilaColor["limite_final"] ))
			{
				$ValorR=number_format($Valor,3,",",".");
			}
			else
			{
				$Consulta="Select valor,observacion from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
				$Consulta.=" and cod_leyes='".$CodLey."' and cod_unidad='".$Unidad."'  and recargo='".$Recargo."'";
				$Resp12= mysqli_query($link, $Consulta);
				if($Fila12=mysqli_fetch_array($Resp12))
				{
					$Obs=$Fila12["observacion"];
				}
				$ValorR="<a href=JavaScript:DetalleLimite('$SA','$Producto','$SubProducto','$CodLey','$Unidad','$RutProveedor','$Recargo');><span class='LinksinLinea'>".number_format($Valor,3,",",".")."</span></a>";
			}
		}
		else
		{
			$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
			$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='T'";
			$RespColor = mysqli_query($link, $Consulta);
			if($FilaColor=mysqli_fetch_array($RespColor))
			{
				if(($Valor>=$FilaColor["limite_inicial"]) && ( $Valor<=$FilaColor["limite_final"] ))
				{
					$ValorR=number_format($Valor,3,",",".");
				}
				else
				{
					$Consulta="Select valor,observacion from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
					$Consulta.=" and cod_leyes='".$CodLey."' and cod_unidad='".$Unidad."'  and recargo='".$Recargo."'";
					$Resp12= mysqli_query($link, $Consulta);
					if($Fila12=mysqli_fetch_array($Resp12))
					{
						$Obs=$Fila12["observacion"];
					}
					$ValorR="<a href=JavaScript:DetalleLimite('$SA','$Producto','$SubProducto','$CodLey','$Unidad','T','$Recargo');><span class='LinksinLinea'>".number_format($Valor,3,",",".")."</span></a>";
				}
			}
			else
			{
				$ValorR=number_format($Valor,3,",",".");
			}
		}
		$Retorno=$ValorR."~".$Obs;
		return($Retorno);
	}

	function SubProducto($CodProd,$CodSubPro,$link)
	{
		$ConsultaDes= "select t1.cod_producto, t2.cod_subproducto, t1.descripcion as nom_prod, t2.descripcion as nom_subprod from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2 ";
		$ConsultaDes.= " on t1.cod_producto=t2.cod_producto ";
		$ConsultaDes.= " where t1.cod_producto='".$CodProd."' and t2.cod_subproducto='".$CodSubPro."'";
		$RespDes=mysqli_query($link, $ConsultaDes);
		if ($FilaDes=mysqli_fetch_array($RespDes))
		{
			$DesProducto=$FilaDes["nom_prod"];
			$DesSubProducto=$FilaDes["nom_subprod"];
			$DesProSub=$DesProducto."~".$DesSubProducto;
			return($DesProSub);
		}
		
	}


?>