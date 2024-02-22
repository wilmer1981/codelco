<?php 
include("../principal/conectar_sea_web.php");
//Proceso=B&cmbproductos=-1&dia=1&mes=1&ano=2022

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}
if(isset($_REQUEST["cmbproductos"])) {
	$cmbproductos = $_REQUEST["cmbproductos"];
}else{
	$cmbproductos = '';
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano = date("Y");
}
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes = date("m");
}
if(isset($_REQUEST["dia"])) {
	$dia = $_REQUEST["dia"];
}else{
	$dia = date("d");
}

?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_guia()
{
var f = document.frmPoPup;
   
    f.action="sea_ing_prod_vent_auto_anodos_det.php?Proceso=B";
	f.submit();
}

function Proceso(opt)
{
	var f = document.frmPoPup;
	switch (opt)
	{
		case "S":
			//window.opener.document.formulario.action="sea_ing_prod_vent_auto.php";
			//window.opener.document.formulario.submit();
			window.close();
			break;
	}
}

function Imprimir()
{
	var f = document.frmPoPup;
	f.BtnBuscar.style.visibility = "hidden";
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	window.print();
	f.BtnBuscar.style.visibility = "visible";
	f.BtnImprimir.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
</style>
</head>

<body>
<form name="frmPoPup" method="post" action="">
    <table width="500" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior" >
      <tr class="ColorTabla02"> 
        <td colspan="3"><div align="center">Busqueda de Datos</div></td>
      </tr>
      <tr> 
        <td width="108" height="32">Fecha Busqueda</td>
        <td colspan="2"><font color="#000000" size="2"> 
          <SELECT name="dia">
            <?php
			if($Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
          </SELECT>
          </font> <font color="#000000" size="2"> 
          <SELECT name="mes">
            <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
          </SELECT>
          <SELECT name="ano">
            <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
          </SELECT>
          </font></td>
      </tr>
      <tr> 
        <td>Tipo Producto</td>
        <td width="213"><SELECT name="cmbproductos">
		<option  value = "-1" SELECTed>VER TODOS</option>
		<?php 		
			$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = '17' AND cod_subproducto in (4,8,11)";
   	        include("../principal/conectar_principal.php");
			$rs = mysqli_query($link, $consulta);

			while ($row = mysqli_fetch_array($rs))
			{			
			if ($row['cod_subproducto'] == $cmbproductos and ($Proceso == 'B'))
				echo '<option value="'.$row['cod_subproducto'].'" SELECTed>'.$row['descripcion'].'</option>';
			else 
				echo '<option value="'.$row['cod_subproducto'].'">'.$row['descripcion'].'</option>';
			}

			 echo'';
	   
	   ?></SELECT></td>
	   </td>
        <td width="159"><input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70" onClick="buscar_guia();" value="Buscar"></td>
      </tr>
  </table>
    <br><br>
	<table width="500" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle" >
      <tr align="center" class="ColorTabla01">
        <td colspan="5"><strong>HORNADAS CREADAS Y FINALIZADAS </strong></td>
      </tr>
      <tr align="center" class="ColorTabla01">         
        <td width="172">Tipo Anodo</td>
        <td width="79">Hornada</td>
        <td width="99">Unidades</td>
        <td width="84"><strong>Peso</strong></td>
      </tr> 
<?php
if($Proceso == 'B')
{
	$fecha = $ano.'-'.$mes.'-'.$dia;
	$consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada, t1.unidades, t2.abreviatura ";
	$consulta.= " FROM sea_web.movimientos t1 inner join proyecto_modernizacion.subproducto t2 ";
	$consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
	$consulta.= " WHERE t1.tipo_movimiento = '1' ";
	$consulta.= " AND t1.fecha_movimiento = '".$fecha."' ";
	$consulta.= " AND t1.cod_producto = '17' ";
	if ($cmbproductos != "-1")
		$consulta.= " AND t1.cod_subproducto = '".$cmbproductos."'";
	else
		$consulta.= " AND t1.cod_subproducto in(4,8) ";
	$consulta.= " order by t1.cod_producto, t1.cod_subproducto, t1.hornada "; 
	$rs = mysqli_query($link, $consulta);
	$total_unidades=0;	
	$total_peso=0;
	while ($row = mysqli_fetch_array($rs))
	{	
		echo "<tr>";
		echo "<td align='center'>".$row["abreviatura"]."</td>";
		echo "<td align='center'>".substr($row["hornada"],6,6)."</td>";	
		echo "<td align='center'>".number_format($row["unidades"],0,",",".")."</td>";	
		$consulta = "SELECT peso_unidades FROM sea_web.hornadas ";
		$consulta.= " where hornada_ventana = '".$row["hornada"]."' AND cod_producto = '17' AND cod_subproducto = '".$row["cod_subproducto"]."'"; 
		$rs2 = mysqli_query($link, $consulta);	
		if($row2 = mysqli_fetch_array($rs2))
		{
			echo "<td align='center'>".number_format($row2["peso_unidades"],0,",",".")."</td>";
		}
		$total_unidades = $total_unidades + $row["unidades"];
		$total_peso = $total_peso + $row2["peso_unidades"];
	}                     
	
}

?>	<tr> 
	<td colspan="2"><strong>TOTAL ACUMULADO</strong></td>
	<td width="99" align="center"><?php echo number_format($total_unidades,0,",","."); ?></td>
	<td width="84" align="center"><?php echo number_format($total_peso,0,",","."); ?></td>
  </tr> </table>  
    <br>
    <table width="500" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle" >
      <tr align="center" class="ColorTabla01">
        <td colspan="4"><strong>HORNADAS CREADAS EN PESAJE </strong></td>
      </tr>
      <tr align="center" class="ColorTabla01">
        <td width="30%">Tipo Anodo</td>
        <td width="20%">Hornada</td>
        <td width="21%">Unidades</td>
        <td width="18%"><strong>Peso</strong></td>
      </tr>
      <?php
$total_unidades = 0;
$total_peso = 0;	  
if($Proceso == 'B')
{	
	$fecha = $ano.'-'.$mes.'-'.$dia;
	$Consulta = "SELECT distinct t1.cod_producto, t1.cod_subproducto, t1.hornada, t2.abreviatura ";
	$Consulta.= " FROM sea_web.detalle_pesaje t1 inner join proyecto_modernizacion.subproducto t2 ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
	$Consulta.= " WHERE t1.fecha between '".$fecha." 00:00:00' AND '".$fecha." 23:59:59' ";
	$Consulta.= " AND t1.cod_producto = '17' ";
	if ($cmbproductos != "-1")
		$Consulta.= " AND t1.cod_subproducto = '".$cmbproductos."'"; 
	$Consulta.= " AND t1.estado <> 'F'"; 
	$Consulta.= " order by t1.cod_producto, t1.cod_subproducto, t1.hornada";
	$rs = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($rs))
	{	
		$Consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso ";
		$Consulta.= " FROM sea_web.detalle_pesaje ";
		$Consulta.= " WHERE fecha between '".$fecha." 00:00:00' AND '".$fecha." 23:59:59' ";
		$Consulta.= " and hornada = '".$row["hornada"]."'";
		$Consulta.= " AND cod_producto = 17 AND cod_subproducto = '".$row["cod_subproducto"]."'"; 
		$rs2 = mysqli_query($link, $Consulta);
		$Unidades = 0;
		$Peso = 0;
		if($row2 = mysqli_fetch_array($rs2))
		{	
			$Unidades = $row2["unidades"];
			$Peso = $row2["peso"];
		}
		echo "<tr><td align='center'>".$row["abreviatura"]."</td>";
		echo "<td align='center'>".substr($row["hornada"],6,6)."</td>";
		echo "<td align='center'>".number_format($Unidades,0,",",".")."</td>";			
		echo "<td align='center'>".number_format($Peso,0,",",".")."</td>";
		$total_unidades = $total_unidades + $Unidades;
		$total_peso = $total_peso + $Peso;
	}                     
	
}

?>
      <tr>
        <td colspan="2"><strong>TOTAL ACUMULADO</strong></td>
        <td width="21%" align="center"><?php echo number_format($total_unidades,0,",","."); ?></td>
        <td width="18%" align="center"><?php echo number_format($total_peso,0,",","."); ?></td>
      </tr>
    </table>
    <br>
    <br>
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td align="center">  
		    <input name="BtnImprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
        <input name="BtnSalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Proceso('S')">        </td>
      </tr>
  </table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
