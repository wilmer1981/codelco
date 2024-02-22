<?php
	    ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 66;
	include("../principal/conectar_principal.php");

	$ChkSolicitud = $_REQUEST["ChkSolicitud"];
	$Mes = $_REQUEST["Mes"];
	$Ano = $_REQUEST["Ano"];
	$CmbProductos = $_REQUEST["CmbProductos"];
	$SubProducto = $_REQUEST["SubProducto"];
	$CmbEstado = $_REQUEST["CmbEstado"];
	$Mostrar = $_REQUEST["Mostrar"];
	$Orden = $_REQUEST["Orden"];


	//if (!isset($ChkSolicitud))
		//$ChkSolicitud="S";
	
?>
<html>
<head>
<title>Consulta de Estados </title>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt,valor)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
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
			f.action = "cal_con_estados_sa.php";
			f.submit(); 
			break;
		case "C":
			f.action = "cal_con_estados_sa.php?Mostrar=S";
			f.submit(); 
			break;
		case "E":
			f.action = "cal_con_estados_sa_excel.php?Mostrar=S";
			f.submit(); 
			break;		
		case "O": //ORDENA
			f.action = "age_con_estados_sa.php?Mostrar=S&Orden=" + valor;
			f.submit();
			break;
	}	
}

function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function DetalleAnalisis(SA,Rec)
{
	window.open("age_con_detalle_leyes.php?SA="+ SA+"&Recargo="+Rec,"","top=70,left=50,width=400,height=430,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<input type="hidden" name="Sistema" value="<?php echo $Sistema; ?>">
  <table width="770" border="0" cellpadding="5" cellspacing="0" >
    <tr> 
      <td width="762"  align="center" valign="top">          <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
		  <tr>
			  <td><strong>Producto</strong></td>
			  <td><strong>SubProducto</strong></td>
			  <td><strong>Id Muestra</strong> </td> 
			  <td><strong>FechaMuestra</strong></td>
			  <td><strong>Recep.Lab</strong></td>
			  <td><strong>Finaliz.</strong></td>
			  <td width="80"><strong>Solicitud</strong></td> 
			  <td><strong>Estado</strong></td>
	      </tr>		
<?php		
		
if ($Mostrar=="S")
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
	$Consulta = "SELECT distinct t1.cod_producto, t1.cod_subproducto,t1.id_muestra,t1.fecha_muestra,t1.recargo, ";
	$Consulta.= " t1.nro_solicitud, t1.estado_actual, t5.nombre_subclase as estado ";
	if($Ano<2009 &&  $Ano>0) 
		$Consulta.= " from cal_histo.solicitud_analisis_a_".$Ano." t1   ";
		else
		$Consulta.= " from cal_web.solicitud_analisis t1   ";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='1002' and t1.estado_actual=t5.cod_subclase ";
	//$Consulta.= " left join proyecto_modernizacion.subproducto t6 on t6.cod_producto='1' and t6.cod_subproducto=t1.cod_subproducto ";
	if(strlen($Mes)==1)
		$Mes='0'.$Mes;
	$Consulta.= " where substring(t1.fecha_muestra,1,7)='".$Ano."-".$Mes."' ";
	if ($CmbProductos != "S")
		$Consulta.= " and t1.cod_producto='".$CmbProductos."' ";
	
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_subproducto='".$SubProducto."'";
	if ($CmbEstado!="S")
		$Consulta.= " and t1.estado_actual='".$CmbEstado."' ";	
	$Consulta.= " order by t1.nro_solicitud ";		
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$ContSA=0;
	$ContLotes=0;
	$ContSA_Fin=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$SA=$Fila["nro_solicitud"];		
		if ($Fila["nro_solicitud"]!="")
			$ContSA++;		
		$Recargo=$Fila["recargo"];
		$FechaMuestra=$Fila["fecha_muestra"];
		$IdMuestra=$Fila["id_muestra"];
		$EstadoSA=$Fila["estado_actual"];
		$DesEstado=$Fila["estado"];
		if($Recargo =='R')
			$SAR=$SA.'-'.$Recargo;
		if ($Fila["estado_actual"]=="6")
			$ContSA_Fin++;
		//FECHA RECEPCION LABORATORIO
		$Consulta = "SELECT * ";
		if($Ano<2009 && $Ano>0)
			$Consulta.= " from cal_histo.estados_por_solicitud_a_".$Ano." t1 ";
		else
			$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.recargo='".$Recargo."' ";	
		$Consulta.= " and t1.cod_estado='4' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaRecepLab=$FilaAux["fecha_hora"];
		}
		else
		{
			$FechaRecepLab="";
		}		
		$Consulta = "SELECT t1.descripcion,t2.descripcion as SubDes";
		$Consulta.= " from proyecto_modernizacion.productos t1  ";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";			
		$Consulta.= " where t2.cod_producto = '".$Fila["cod_producto"]."' and t2.cod_subproducto='".$Fila["cod_subproducto"]."' ";			
		$RespProd = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		if ($FilaProd=mysqli_fetch_array($RespProd))
		{
			$DesPro=$FilaProd["descripcion"];
			$DesSubPro=$FilaProd["SubDes"];
		}
		
		
		//FECHA FINALIZADA SA
		$FechaFinalizSA="";
		$FechaFinalizRetalla="";
		$FechaFinalizParalela="";
		$Consulta = "select * ";
		if($Ano<2009 && $Ano>0)
			$Consulta.= " from cal_histo.estados_por_solicitud_a_".$Ano." t1 ";
			else
			$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.recargo='".$Recargo."' ";	
		$Consulta.= " and t1.cod_estado='6' "; //FINALIZADO
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinalizSA=$FilaAux["fecha_hora"];
		}		
		
		echo "<tr align=\"center\">\n";
		echo "<td align=\"left\">".$DesPro."&nbsp;</td>\n";
		echo "<td align=\"left\">".$DesSubPro."&nbsp;</td>\n";
		echo "<td>".$IdMuestra."</td>\n";
		echo "<td>".substr($FechaMuestra,8,2)."/".substr($FechaMuestra,5,2)."/".substr($FechaMuestra,2,2)."</td>\n";
		if ($FechaRecepLab=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaRecepLab,8,2)."/".substr($FechaRecepLab,5,2)."/".substr($FechaRecepLab,2,2)."</td>\n";
		if ($FechaFinalizSA=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaFinalizSA,8,2)."/".substr($FechaFinalizSA,5,2)."/".substr($FechaFinalizSA,2,2)."</td>\n";

		if 	($SA=="")
			echo "<td>&nbsp;</td>\n";		
		else
		{
			if ($SA!="")
			{	
				if($Recargo != "")
					echo "<td>".substr($SA,4)."-".$Recargo."</td>\n";
				else
					echo "<td>".substr($SA,4)."</td>\n";
			}	
		}			
		if (($EstadoSA!=6 && $EstadoSA != 32 && $EstadoSA!=""))
			echo "<td bgcolor='yellow'>".$DesEstado.";</td>\n";
		else
		{
			if ($EstadoSA!="")
				echo "<td bgcolor='#FFFFFF'>".$DesEstado."&nbsp;</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
	}
}//FIN MOSTRAR = S	
?>
	  
  </table>	  
    <blockquote>
            <p><br>
              <br>
            </p>
    </blockquote></td></tr>
</table>
</form>
</body>
</html>
