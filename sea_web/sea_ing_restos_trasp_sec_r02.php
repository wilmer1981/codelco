<?php 
  	include("../principal/conectar_sea_web.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 51;
	if (!isset($TxtFechaFin))
		$TxtFechaFin = date("Y-m-d");
	/*$Consulta="SELECT distinct hornada from movimientos where tipo_movimiento = '10' and cod_producto = '19' and cod_subproducto = '2' and fecha_movimiento='2006-05-04' order by hornada";	
	$Resp=mysqli_query($link, $Consulta);
	$Cont=1;
	while($Fila=mysqli_fetch_array($Resp))
	{
		$Actualizar="UPDATE hornadas set estado='0' where cod_producto = '19' and cod_subproducto = '2' and fecha_movimiento='2006-05-04' and hornada_ventana='".$Fila[hornada]."'";
		echo $Actualizar."<br>";
		mysqli_query($link, $Actualizar);
		$Cont++;
	}
	echo $Cont;*/
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga(f)
{
	vector = f.cmbproducto.value.split("-");
	chequeado = "S";

	f.action = "sea_ing_restos_trasp_sec_r02.php?recargapag=S&cmbproducto=" + f.cmbproducto.value + "&activar=" + chequeado;		
	f.submit();	
}
function Recarga2(f)
{
	vector = f.cmbproducto.value.split("-");
	chequeado = "S";
	f.action = "sea_ing_restos_trasp_sec_r02.php?cmbproducto=" + f.cmbproducto.value + "&activar=" + chequeado;		
	f.submit();	
}
function VerDatos()
{
   	window.open("sea_ing_restos_trasp_sec02.php", "","menubar=no resizable=no Top=50 Left=200 width=530 height=500 scrollbars=yes");

}
function RescataPeso(f)
{
	if(f.CmbLote.value!='-1')
	{
		vector = f.CmbLote.value.split("-");
		f.TxtPesoTot.value=vector[2];
	}
	else
		f.TxtPesoTot.value=0;	
}

/**************/
function Excel(f)
{
	vector = f.cmbproducto.value.split("-");
	chequeado = "S";

	f.action = "sea_xls_ing_restos_trasp_sec_r01.php?recargapag=S&cmbproducto=" + f.cmbproducto.value + "&activar=" + chequeado;		
	f.submit();	
}
/**************/
function Imprimir()
{	
	window.print();
}
function Traspaso()
{
	var f=document.frm1;
	var Valores="";
	
	if(f.TxtPesoTot.value==0||f.TxtPesoSelec.value==0)
	{
		alert('Peso Ingresado o Peso Seleccionado Debe Ser Mayor a Cero');
		return;
	}
	if (parseInt(f.TxtPesoSelec.value)<parseInt(f.TxtPesoTot.value))
	{
		alert('Peso Seleccionado Debe ser Mayor o Igual Peso Total');
		return;
	}
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="OptSelec" && f.elements[i].checked==true)
		{	
			Valores=Valores+f.elements[i+1].value+"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substring(0,(Valores.length-2));
		if(confirm('Esta Seguro de Traspasar los Datos Seleccionados'))
		{
			f.action="sea_ing_restos_trasp_sec01_r01.php?Proceso=G&Valores="+Valores;
			f.submit();	
		}	
	}
	else
		alert('Debe Seleccionar Grupo A Traspasar');	
		
}
function AcumularPeso(Obj)
{
	var f=document.frm1;

	f.TxtPesoSelec.value=0
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="OptSelec" && f.elements[i].checked==true)
		{	
			if (parseInt(f.TxtPesoSelec.value)<parseInt(f.TxtPesoTot.value))
				f.TxtPesoSelec.value=parseInt(f.TxtPesoSelec.value) + parseInt(f.elements[i].value);
			else
				f.elements[i].checked=false;
				
		}	
	}
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2"
}
</script>
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	  <td width="762" height="316" align="center" valign="top"> 
        <table width="400" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="118">Tipo de Producto</td>
            <td><SELECT name="cmbproducto" style="width:220px" onChange="Recarga2(this.form)">
              <option value="0-0">SELECCIONAR</option>
              <?php					
				$consulta = "SELECT DISTINCT * FROM proyecto_modernizacion.subproducto ";
				$consulta.= " WHERE cod_producto IN(19) and cod_subproducto in('1','2','3','4','8') ORDER BY cod_producto,cod_subproducto";
				$rs3 = mysqli_query($link, $consulta);
				while ($row3 = mysqli_fetch_array($rs3))
				{
					$prod = $row3["cod_producto"].'-'.$row3["cod_subproducto"];
											
					if ($prod == $cmbproducto)
						echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'" SELECTed>'.$row3["cod_subproducto"].'-'.$row3["descripcion"].'</option>';
					else 
						echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'">'.$row3["cod_subproducto"].'-'.$row3["descripcion"].'</option>';
				}
				?>
            </SELECT></td>
          </tr>
          <tr>
            <td>Lote</td>
            <td><SELECT name="CmbLote" onChange="RescataPeso(this.form);">
              <option value="-1"SELECTed>Seleccionar</option>
              <?php
			$CmbAno=date("Y");
			$Prod = explode("-", $cmbproducto); 
			switch($Prod[1])
			{
				case "1":
					$SubProd=21;//PRODUCTO EMBARQUE HVL
					break;
				case "2":
					$SubProd=22;//PRODUCTO EMBARQUE TTE
					break;
				case "3":
					$SubProd=23;//PRODUCTO EMBARQUE SUR ANDES
					break;
				case "4":
					$SubProd=25;//PRODUCTO EMBARQUE VENTANAS
					break;
				case "8":
					$SubProd=26;//PRODUCTO EMBARQUE HM VENTANAS
					break;
			}
			if($cmbproducto!='0-0')
			{
				$Consulta="SELECT t1.cod_bulto,t1.num_bulto,sum(peso_paquetes) as peso,ifnull(t3.peso,0) as peso_trasp from sec_web.lote_catodo t1";
				$Consulta.=" inner join  sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
				$Consulta.=" left join sea_web.traspasos_sec t3 on t1.cod_bulto=t3.cod_bulto and t1.num_bulto=t3.num_bulto and LEFT(t3.fecha,4)='2006' and t3.cod_producto='19' and t3.cod_subproducto='".$SubProd."' ";				
				$Consulta.=" where LEFT(t1.fecha_creacion_lote,4)='".$CmbAno."' and t2.cod_producto='".$Prod[0]."' and t2.cod_subproducto='".$SubProd."'";
				$Consulta.=" and (t1.disponibilidad='P' or t1.disponibilidad='T' or t1.sw='2') group by cod_bulto,num_bulto";
				//echo "uno ".$Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if (($Fila[peso_trasp]=="0")||($Fila[peso_trasp]!=$Fila["peso"]))
					{
						if ($CmbLote==$Fila[cod_bulto]."-".$Fila["num_bulto"]."-".abs($Fila["peso"]-$Fila[peso_trasp]))
							echo "<option value='".$Fila[cod_bulto]."-".$Fila["num_bulto"]."-".abs($Fila["peso"]-$Fila[peso_trasp])."' SELECTed>".$Fila[cod_bulto]."-".$Fila["num_bulto"]."</option>";
						else
							echo "<option value='".$Fila[cod_bulto]."-".$Fila["num_bulto"]."-".abs($Fila["peso"]-$Fila[peso_trasp])."'>".$Fila[cod_bulto]."-".$Fila["num_bulto"]."</option>";
					}
				}
			}	
			?>
            </SELECT><?php //echo $Consulta;?></td>
          </tr>
          <tr>
            <td>Peso Total </td>
            <td><input type="text" name="TxtPesoTot" size="12" value='<?php echo $TxtPesoTot;?>'>
            (Kg.)</td>
          </tr>
          <tr> 
            <td>Peso Seleccionado</td>
            <td width="262"><input type="text" name="TxtPesoSelec" readonly="true" size="12">
            <input type="button" name="Ver" value="Ver Traspasados" onClick="VerDatos();"> </td>
          </tr>
          <tr align="center"> 
            <td align="left">Fecha Movimiento </td>
            <td align="left">
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false">			  &nbsp;			  </td>
          </tr>
          <tr align="center"> 
            <td colspan="2"> <input name="BtnCansultar" type="button" value="Consultar" onClick="JavaScritp:Recarga(this.form)" style="width:70px">
              <input name="BtnTraspasar" type="button" value="Traspasar" onClick="JavaScritp:Traspaso(this.form)" style="width:70px"> 
              <input name="btnimprimir2" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()"> 
              <input name="BtnExcel" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px"> 
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="400" border="1" cellspacing="0" cellpadding="3">
          <tr align="center" class="ColorTabla01">
            <td width="30">Selec</td>
            <td width="54">Grupo</td>
			<td width="54">Hornada</td>
            <td width="90">Fecha</td>
            <td width="70">Unidades</td>
            <td width="80">Peso(Kg)</td>
          </tr>
        
		<?php
			if($recargapag=='S')
			{
				$FechaConsulta = substr($TxtFechaFin,0,8)."31";
				$FechaInicio = substr($TxtFechaFin,0,8)."01";
				//echo $FechaConsulta."<br>";
				//echo $FechaInicio."<br>";
				$TotalStockIniUnid = 0;
				$TotalStockIniPeso = 0;
				$TxtUnidPrep = 0;
				$TxtPesoPrep = 0;
				$TotalRecepUnid = 0;
				$TotalRecepPeso = 0;
				$TotalBenefUnid = 0;
				$TotalBenefPeso = 0;
				$TotalProdUnid = 0;
				$TotalProdPeso = 0;
				$TotalTrasUnid = 0;
				$TotalTrasPeso = 0;
				$TotalOtrosUnid = 0;
				$TotalOtrosPeso = 0;
				$TotalStockFinUnid = 0;
				$TotalStockFinPeso = 0;
				$TotalPisoUnid = 0;
				$TotalPisoPeso = 0;			
				if ($recargapag == "S")
				{
					$arreglo = explode("-", $cmbproducto); //0: Producto, 1: SubProducto.
					//Hornadas del mes pasado		
					$consulta = "SELECT distinct t1.hornada, t1.cod_producto, t1.cod_subproducto";
					$consulta.= " FROM sea_web.stock t1 ";
					$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
					$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
					$consulta.= " AND t1.ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and t1.mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
					$consulta.= " ORDER BY t1.hornada";
					$array_hornadas = array();
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						$consulta = "SELECT campo2, CASE WHEN LENGTH(campo2) = 1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo";
						$consulta.= " FROM sea_web.movimientos";
						$consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = '".$row["cod_producto"]."'";
						$consulta.= " AND cod_subproducto = '".$row["cod_subproducto"]."'";
						$consulta.= " AND hornada = ".$row[hornada];
						$consulta.= " GROUP BY hornada";
						//echo $consulta."<br>";
						$rs1 = mysqli_query($link, $consulta);
						$row1 = mysqli_fetch_array($rs1);
						$clave = $row1["grupo"].'-'.$row["cod_producto"].'-'.$row["cod_subproducto"].'-'.substr($row[hornada],6,6);		
						$array_hornadas[$clave] = array($row[hornada], $row["cod_producto"], $row["cod_subproducto"], $row1[campo2]);
					}				
					//Hornadas del mes actual.
					$consulta = "SELECT distinct t1.hornada, t1.cod_producto, t1.cod_subproducto, t1.campo2,";
					$consulta.= " CASE WHEN LENGTH(campo2) = 1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo";
					$consulta.= " FROM sea_web.movimientos t1";
					$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
					$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
					$consulta.= " AND t1.fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."'";
					$consulta.= " AND t1.tipo_movimiento = 3";
					//echo $consulta."<br>";
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						$clave = $row["grupo"].'-'.$row["cod_producto"].'-'.$row["cod_subproducto"].'-'.substr($row[hornada],6,6);
						$array_hornadas[$clave] = array($row[hornada], $row["cod_producto"], $row["cod_subproducto"], $row[campo2]);				
					}
					echo "<input type='hidden' name='TxtPesoTotGrupo'>";
					//ksort($array_hornadas); //Orderna por la clave.						
					reset($array_hornadas);
					while (list($clave,$valor) = each($array_hornadas))
					{
						//echo '<tr>';
						//echo '<td><input type="checkbox" name="OptSelec" onclick="AcumularPeso(this.form)"></td>';
						//Grupo.
						if ($valor[3] != "")
							$Grupo=$valor[3];
							//echo '<td align="center">'.$valor[3].'</td>';
						else 
							$Grupo="";
							//echo '<td align="center">&nbsp;</td>';					
						$hornadas = $valor[0];
						//Consulta la fecha de produccion de movimiento, para obtener la hornada restos de restos.
						$consulta = "SELECT DISTINCT fecha_movimiento,campo2,campo1 FROM sea_web.movimientos";
						$consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = ".$valor[1]." AND cod_subproducto = ".$valor[2];
						$consulta.= " AND hornada = ".$valor[0];
						//echo $consulta."<br>";
						$rs = mysqli_query($link, $consulta);
						if ($row = mysqli_fetch_array($rs))
						{
							//Fecha de Produccion.
							//echo '<td align="center">'.$row[fecha_movimiento].'</td>';
							$FechaMov=$row[fecha_movimiento];
							$consulta = "SELECT * FROM sea_web.movimientos";
							$consulta.= " WHERE tipo_movimiento = 3 AND campo1 = '".$row[campo1]."' AND campo2 = '".$row[campo2]."'";
							$consulta.= " AND fecha_movimiento = '".$row[fecha_movimiento]."' AND cod_subproducto = 30";
							//echo $consulta."<br>";
							$rs1 = mysqli_query($link, $consulta);
							if ($row1 = mysqli_fetch_array($rs1))
								$hornadas = $hornadas.",".$row1[hornada];
						}
						//STOCK INICIAL
						$peso_aux = 0;
						$unid_aux = 0;
						//Consulta mes anterior.
						$consulta = "SELECT ifnull(SUM(unid_fin),0) as unidades, ifnull(SUM(peso_fin),0) as peso ";
						$consulta.= " FROM sea_web.stock ";
						$consulta.= " WHERE cod_producto = '".$arreglo[0]."' ";
						//$consulta.= " AND cod_subproducto = '".$arreglo[1]."'";
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";
						//echo $consulta."<br>";
						$rs1 = mysqli_query($link, $consulta);
						$row1 = mysqli_fetch_array($rs1);
						$unid_aux = $unid_aux + $row1["unidades"];						
						$peso_aux = $peso_aux + $row1["peso"];
						$TotalStockIniUnid = $TotalStockIniUnid + $unid_aux;
						$TotalStockIniPeso = $TotalStockIniPeso + $peso_aux;
						//PRODUCCION.
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento = '3'";
						//echo $consulta."<br>";				
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalProdUnid = $TotalProdUnid + $row1["unidades"];
							$TotalProdPeso = $TotalProdPeso + $row1["peso"];
							$unid_aux = $unid_aux + $row1["unidades"];						
							$peso_aux = $peso_aux + $row1["peso"];
						}
						//TRASPASOS RAF.
						$consulta = "SELECT  ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento = '4'";
						//echo $consulta."<br>";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalTrasUnid = $TotalTrasUnid + $row1["unidades"];
							$TotalTrasPeso = $TotalTrasPeso + $row1["peso"];
							$unid_aux = $unid_aux - $row1["unidades"];						
							$peso_aux = $peso_aux - $row1["peso"];
						}
						//TRASPASOS EMBARQUE.
						$consulta = "SELECT  ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento = '10'";
						//echo $consulta."<br>";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalTrasUnid = $TotalTrasUnid + $row1["unidades"];
							$TotalTrasPeso = $TotalTrasPeso + $row1["peso"];
							$unid_aux = $unid_aux - $row1["unidades"];						
							$peso_aux = $peso_aux - $row1["peso"];
						}
						//OTROS DESTINOS
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento in(5,9)";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalOtrosUnid = $TotalOtrosUnid + $row1["unidades"];
							$TotalOtrosPeso = $TotalOtrosPeso + $row1["peso"];
							$unid_aux = $unid_aux - $row1["unidades"];						
							$peso_aux = $peso_aux - $row1["peso"];
						}						
						/*******************/
						//AJUSTES (99)
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento in (99)";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{					
							$unid_ajuste = $unid_aux - $row1["unidades"];											
						}					
						/*******************/
						//STOCK FINAL.
						/*if ($unid_ajuste > 0)
						{
							echo '<td align="right"><font color="blue">'.$unid_aux.'</font></td>';
							echo '<td align="right"><font color="blue">'.$peso_aux.'</font></td>';					
						}
						else 
						{
							echo '<td align="right"><font color="blue">0</font></td>';
							echo '<td align="right"><font color="blue">0</font></td>';					
						}*/
						$TotalStockFinUnid = $TotalStockFinUnid + $unid_aux;
						$TotalStockFinPeso = $TotalStockFinPeso + $peso_aux;					
						//STOCK EN PISO
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.stock_piso_raf ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.=" AND cod_subproducto = ".$arreglo[1];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						//echo $consulta."<br>";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalPisoUnid = $TotalPisoUnid + $row1["unidades"];
							$TotalPisoPeso = $TotalPisoPeso + $row1["peso"];
						}
						/*echo "UNIDADES:".$hornadas."<br>"; 
						echo "UNIDADES:".$unid_aux."<br><br>"; */
						// Veo Preparados
						if ($unid_aux > 0)
						{
							$consulta ="Select * from sea_web.restos_a_sec where hornada = '".$hornadas."' and grupo = '".$Grupo."' and cod_producto ='".$arreglo[0]."'";
							$consulta.=" and tipo_movimiento = '1'";
							//echo $consulta."</br>";
							$rsp_sec = mysqli_query($link, $consulta);
							if ($FilaN = mysqli_fetch_array($rsp_sec))
							{
								
								$TxtUnidPrep = $TxtUnidPrep + $unid_aux;
								$TxtPesoPrep = $TxtPesoPrep + $peso_aux;
								$Datos=$Grupo."~".$FechaMov."~".$unid_aux."~".$peso_aux."~".$hornadas;
								echo '<tr>';
								echo '<td><input type="checkbox" name="OptSelec" onclick="AcumularPeso(this.form)" value="'.$peso_aux.'"><input type="hidden" name="TxtDatos" value="'.$Datos.'"></td>';
								echo '<td align="center">'.$Grupo.'</td>';
								echo '<td align="center">'.$hornadas.'</td>';
								echo '<td align="center">'.$FechaMov.'</td>';
								echo '<td align="right"><font color="blue">'.$unid_aux.'</font></td>';
								echo '<td align="right"><font color="blue">'.$peso_aux.'</font></td>';					
								//echo "<input type='hidden' name='TxtPesoTotGrupo' value='$peso_aux'>";
								echo '</tr>';
							}
						}	
					}								
				}
			}	
		?>
		<tr>
		<td colspan="4">TOTAL</td>
		<td align="right"><font color="blue"><?php echo $TxtUnidPrep; //$TotalStockFinUnid; ?></font></td>
		<td align="right"><font color="blue"><?php echo $TxtPesoPrep; //$TotalStockFinPeso; ?></font></td>
		</tr>
		</table>
		<br>
        <br>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="BtnCansultar2" type="button" value="Consultar" onClick="JavaScritp:Recarga(this.form)" style="width:70px">
              <input name="BtnTraspasar" type="button" value="Traspasar" onClick="JavaScritp:Traspaso(this)" style="width:70px"> 
              <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()">
              <input name="BtnExcel2" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px">
              <input name="btnsalir" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
