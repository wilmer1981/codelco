<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 66;
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["ChkSolicitud"])) {
		$ChkSolicitud = $_REQUEST["ChkSolicitud"];
	}else{
		$ChkSolicitud="S";
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["CmbProductos"])) {
		$CmbProductos = $_REQUEST["CmbProductos"];
	}else{
		$CmbProductos ="";
	}
	if(isset($_REQUEST["SubProducto"])) {
		$SubProducto = $_REQUEST["SubProducto"];
	}else{
		$SubProducto ="";
	}
	if(isset($_REQUEST["CmbEstado"])) {
		$CmbEstado = $_REQUEST["CmbEstado"];
	}else{
		$CmbEstado ="";
	}
	if(isset($_REQUEST["Mostrar"])) {
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar ="";
	}
	if(isset($_REQUEST["Orden"])) {
		$Orden = $_REQUEST["Orden"];
	}else{
		$Orden ="";
	}
	
	
	



	
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
			f.action = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
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
			f.action = "cal_con_estados_sa_excel.php?Mostrar=S&Orden=<?php echo $Orden; ?>";
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
	window.open("cal_con_detalle_leyes.php?SA="+ SA+"&Recargo="+Rec,"","top=70,left=50,width=400,height=430,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<input type="hidden" name="Sistema" value="<?php echo $Sistema; ?>">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="750" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>ESTADOS DE SOLICITUDES</strong></td>
        </tr>
        <tr>
          <td width="68" height="23" align="right">Periodo:</td>
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
			for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
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
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="23" align="right">Producto:</td>
          <td width="291" height="23"><select name="CmbProductos" style="width:250" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "SELECT cod_producto, descripcion ";
				//$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " FROM proyecto_modernizacion.productos ";
				//$Consulta.= " where cod_producto='".$CmbProducto."' ";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProductos == $Fila["cod_producto"])
						echo "<option selected value='".$Fila["cod_producto"]."'>".str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_producto"]."'>".str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
          </select></td>
          <td width="87" align="right">SubProducto:</td>
          <td width="269"><select name="SubProducto" style="width:250">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "SELECT cod_subproducto, descripcion ";
				//$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='".$CmbProductos."' ";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
          </select>
		  <?php //echo $Consulta; ?>		  </td>
        </tr>
        <tr>
          <td height="30" align="right">Ver Estado:</td>
          <td height="30"><select name="CmbEstado" style="width:220"  >
            <option value="S" selected>Todas</option>
            <?php
			 $Consulta =  "SELECT * from sub_clase ";
			 $Consulta.= " where cod_clase = '1002' ";
			 $Consulta.= " and cod_subclase in('1','2','3','4','5','6','7','8','13','16')";
			 $Resultado = mysqli_query($link, $Consulta);
			 while ($Fila =mysqli_fetch_array ($Resultado))
			 {
				if ($CmbEstado == $Fila["cod_subclase"])
					echo"<option selected value='".$Fila["cod_subclase"]."'>".str_pad($Fila["cod_subclase"],2,'0',STR_PAD_LEFT)." - ".$Fila["nombre_subclase"]."</option>";
				else
					echo"<option value='".$Fila["cod_subclase"]."'>".str_pad($Fila["cod_subclase"],2,'0',STR_PAD_LEFT)." - ".$Fila["nombre_subclase"]."</option>";
			}
			 ?>
          </select></td>
          <td height="30" colspan="2"><table width="300" border="0" align="center" cellpadding="1" cellspacing="0">
            <tr>
              <td width="50" bgcolor="#FFFFFF">&nbsp;</td>
              <td>Finalizada</td>
              <td width="50" bgcolor="#FFFF00">&nbsp;</td>
              <td>No Finalizada </td>
            </tr>
          </table></td>
          </tr>
        <tr align="center">
          <td height="30" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">              
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        
      <br>
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
		<tr class="ColorTabla01">
			<td>Producto</td>
			<td>SubProducto</td>
			<td>Id Muestra </td> 
			<td>FechaMuestra</td>
			<td>Recep.Lab</td>
			<td>Finaliz.</td>
			<td width="80">Solicitud</td> 
			<td>Estado</td>
		  </tr>		
<?php		
$ContSA=0;
$ContSA_Fin=0;	
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
	if($Ano<2009 && $Ano>0)
		$Consulta.= " from cal_histo.solicitud_analisis_a_".$Ano." t1   ";
		else
		$Consulta.= " , t1.nro_sa_lims from cal_web.solicitud_analisis t1   ";
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
		if ($Fila["nro_sa_lims"]=='') {
				$SA=$Fila["nro_solicitud"];
				$SALims='';
		}else{
			$SA=$Fila["nro_solicitud"];
			$SALims=$Fila["nro_sa_lims"];
		}

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
		$Consulta = "SELECT * ";
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


				if($Recargo != ""){

					if ($SALims!='') {
						echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".$SALims."-".$Recargo."</a></td>\n";
					}else{
						echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($SA,4)."-".$Recargo."</a></td>\n";
					}
  				}
				else{

					if ($SALims!='') {
						echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".$SALims."</a></td>\n";
					}else{
						echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($SA,4)."</a></td>\n";
					}

					//echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($SA,4)."</a></td>\n";
				}
			}	
		}			
		if (($EstadoSA!=6 && $EstadoSA != 32 && $EstadoSA!=""))
			echo "<td bgcolor='yellow'><a href=\"JavaScript:DetalleAnalisis('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".$DesEstado."</a>&nbsp;</td>\n";
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
	<tr align="center">
		<td colspan="10"><strong>TOTAL:&nbsp;&nbsp;</strong><strong><?php echo number_format($ContSA,0,",","."); ?></strong> Solicitudes y <strong><?php echo number_format($ContSA_Fin,0,",","."); ?></strong> Finalizadas </td>
		</tr>
</table>	  
        <blockquote>
          <p><br>
            <br>
          </p>
      </blockquote></td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
