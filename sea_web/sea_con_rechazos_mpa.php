<?php 
include("../principal/conectar_sea_web.php");

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso =  "";
}
if(isset($_REQUEST["Todos"])) {
	$Todos = $_REQUEST["Todos"];
}else{
	$Todos =  "";
}
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes =  date("m");
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano =  date("Y");
}
if(isset($_REQUEST["cmbproductos"])) {
	$cmbproductos = $_REQUEST["cmbproductos"];
}else{
	$cmbproductos =  "";
}

?>

<html>
<head>
<title>Recepci�n de Productos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function BuscarRechazos()
{
var f = frmPoPup;

    f.action="sea_con_rechazos_mpa.php?Proceso=B";
	f.submit();
}

function Imprimir()
{
	window.print();
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <?php
$control = 0;
if($Proceso != "B")
{
 	echo'<table cellpadding="3" cellspacing="0" width="520" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla02"> 
    	<td colspan="2"><div align="center">Busqueda de Rechazos</div></td>
    </tr>
    <tr> 
    	<td width="108" height="32">Fecha Busqueda</td>
        <td width="213"><font color="#000000" size="2">'; 
		echo'<SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">';
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
  	echo'</SELECT>';
       
    echo'<SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">';
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
    echo'</SELECT>';
	echo'</font></td>
        <td width="159">&nbsp;</td>
      </tr>
      <tr> 
        <td>Tipo Producto</td>
        <td>';
	 
		 echo '<SELECT name="cmbproductos" style="width:200">
            <option  value = "-1" SELECTed>Todos</option>';
			
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' AND cod_subproducto IN(1,2,3,4,8)";
   	        include("../principal/conectar_principal.php");
			$rs = mysqli_query($link, $consulta);

			while ($row = mysqli_fetch_array($rs))
			{			
			if ($row['cod_subproducto'] == $cmbproductos and ($Proceso == 'B'))
				echo '<option value="'.$row['cod_subproducto'].'" SELECTed>'.$row['descripcion'].'</option>';
			else 
				echo '<option value="'.$row['cod_subproducto'].'">'.$row['descripcion'].'</option>';
			}

			 echo'</SELECT></td>';
	   echo'</td>
        <td>
		    <input name="buscar" type="button" style="width:70" value="Ver Datos" onClick="BuscarRechazos();">
		</td>           
      </tr>
    </table>';	
}
?>
  <?php
if($mes==1 || $mes==3 ||$mes==5 ||$mes==7 ||$mes==8 ||$mes==10 ||$mes==12)
	$diaf = 31;
if($mes==4 ||$mes==6 ||$mes==9 ||$mes==11)
	$diaf = 30; 
if($mes==2) 
	$diaf = 28;
$Todos="N";
if($cmbproductos =="-1")
	$Todos = "S";

if($Proceso == "B")
{
	echo'<center><img src="../principal/imagenes/letrasenami.gif" width="120" height="30"></center>';
	echo'<center><font size="7">Fecha: '.$mes.'-'.$ano.'</font></center><br>';	
	echo'<div align="center"><table cellpadding="3" cellspacing="0" width="300" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      	<tr class="ColorTabla02"> 
        	<td colspan="7"><div align="center"><strong>Rechazos MPA</strong></div></td>
      	</tr>
		</table><br>';
}

if($Proceso =="B" && $Todos =="N")
{
	$total_unidades = 0;
	$total_peso = 0;
	$fecha =  $ano.'-'.$mes.'-01';
	$FechaHI = $ano.'-'.$mes.'-01 08:00:00';
	$dia = '01';
	$fecha2 =date("Y-m-d", mktime(1,0,0,$mes,($diaf +1),$ano))." 07:59:59";

	
	$FechaHF= $fecha2;
	echo'<div align="center"><table cellpadding="0" cellspacing="0" width="520" border="1" bordercolor="#b26c4a" class="TablaPrincipal">';
    echo' <tr class="ColorTabla02">'; 
	if($cmbproductos=='1')
    	echo'<td colspan="7"><div align="center">�nodos HVL Ctes.</div></td>';
	if($cmbproductos=='2')
    	echo'<td colspan="7"><div align="center">�nodos TTE. Ctes.</div></td>';
	if($cmbproductos=='3')
    	echo'<td colspan="7"><div align="center">�nodos A. America Ctes.</div></td>';
	if($cmbproductos=='4')
    	echo'<td colspan="7"><div align="center">�nodos VTNAS. Ctes.</div></td>';
	if($cmbproductos=='8')
    	echo'<td colspan="7"><div align="center">�nodos VTNAS. H.M.</div></td>';
    echo'</tr>';
      echo'<tr class="ColorTabla01">'; 
        echo'<td width="15%"><div align="center">Hornada</div></td>';
        echo'<td width="12%"><div align="center">Fecha </div></td>';
        echo'<td width="12%"><div align="center">Unidades</div></td>';
        echo'<td width="13%"><div align="center">Peso</div></td>';
      echo'</tr>';

 	include("../principal/conectar_sea_web.php");
    $fecha = $ano.'-'.$mes.'-01';
	$consulta = "SELECT hornada,fecha_movimiento,sum(unidades) as unidades,sum(peso)as peso FROM sea_web.movimientos WHERE tipo_movimiento = 1";
	$consulta.=" AND year(fecha_movimiento) = '".$ano."' and month(fecha_movimiento) = '".$mes."' and cod_producto = 17 and ";
	$consulta.=" cod_subproducto = '".$cmbproductos."' and sub_tipo_movim = 4  and hora between '".$FechaHI."' and '".$FechaHF."'";
	$consulta.=" group by hornada";                    
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{	
		$control = $control + 1;
		echo '<tr><td width="15%"><div align="center">'.$row["hornada"].'</div></td>';
		echo '<td width="20%"><div align="center">'.$row["fecha_movimiento"].'</div></td>';
		echo '<td width="15%"><div align="center">'.$row["unidades"].'</div></td>';
		echo '<td width="15%"><div align="center">'.$row["peso"].'</div></td></tr>';
	}
  	echo'</table></div><br>';  

}

if($Todos == "S" && $Proceso =="B")
{
	$total_unidades = 0;
	$total_peso = 0;

	echo'<div align="center"><table cellpadding="0" cellspacing="0"  width="520" border="1" bordercolor="#b26c4a" class="TablaPrincipal">';
    echo'<tr class="ColorTabla01">'; 
    echo'<td width="15%"><div align="center">Hornada</div></td>';
	echo'<td width="15%"><div align="center">Tipo Anodo</div></td>';
    echo'<td width="15%"><div align="center">Fecha</div></td>';
    echo'<td width="12%"><div align="center">Unidades</div></td>';
    echo'<td width="13%"><div align="center">Peso</div></td></tr>';
 	include("../principal/conectar_sea_web.php");
    $fecha = $ano.'-'.$mes.'-01';
	$FechaHI = $fecha." 08:00:00";
	$fecha2 =date("Y-m-d", mktime(1,0,0,$mes,($diaf +1),$ano))." 07:59:59";
	$FechaHF = $fecha2;
	$consulta = "SELECT cod_subproducto,hornada,fecha_movimiento,sum(unidades) as unidades,sum(peso) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 1";
	$consulta.=" and cod_producto = 17 and sub_tipo_movim = 4 and year(fecha_movimiento) = '".$ano."' and month(fecha_movimiento)='".$mes."'";
	$consulta.=" and hora between '".$FechaHI."' and '".$FechaHF."' group by cod_subproducto,hornada ";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		$control = $control + 1;	
		$TipoA ="";
		if($row["cod_subproducto"]==1)
			$TipoA = "HVL Ctes.";
		if($row["cod_subproducto"]==2)
			$TipoA = "TTE Ctes.";
		if($row["cod_subproducto"]==3)
			$TipoA = "ANGLO Ctes.";
		if($row["cod_subproducto"]==4)
			$TipoA = "VTNAS Ctes.";
		if($row["cod_subproducto"]==8)
			$TipoA = "VTNAS H.M..";
		echo '<tr><td width="15%"><div align="center">'.$row["hornada"].'</div></td>';
		echo '<td width="20%"><div align="center">'.$TipoA.'</div></td>';
		echo '<td width="20%"><div align="center">'.$row["fecha_movimiento"].'</div></td>';
		echo '<td width="15%"><div align="right">'.$row["unidades"].'</div></td>';
		echo '<td width="15%"><div align="right">'.$row["peso"].'</div></td>';					
		echo'</tr>';
	}
  	echo '</table></div><br>';  

}
if($control > 1 && $Proceso=="B")
{
	echo'<div align="center"><table cellpadding="3" cellspacing="0" width="300" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      	<tr class="ColorTabla02"> 
        	<td colspan="7"><div align="center"><strong>Resumen Rechazos MPA Por Hornada</strong></div></td>
      	</tr>
		</table><br>';
	echo'<div align="center"><table cellpadding="0" cellspacing="0" width="420" border="1" bordercolor="#b26c4a" class="TablaPrincipal">';
      echo'<tr class="ColorTabla01">'; 
        echo'<td width="15%"><div align="center">Anodos </div></td>';
        echo'<td width="15%"><div align="center">Hornada</div></td>';
        echo'<td width="12%"><div align="center">Unidades</div></td>';
        echo'<td width="13%"><div align="center">Peso</div></td>';
      echo'</tr>';
	$consulta2 = "SELECT hornada,cod_subproducto,sum(unidades) as unidades,sum(peso)as peso FROM sea_web.movimientos WHERE tipo_movimiento = 1";
	$consulta2.=" AND year(fecha_movimiento) = '".$ano."' and month(fecha_movimiento) = '".$mes."' and cod_producto = 17 ";
	if($Todos=="N")
		$consulta2.=" and cod_subproducto = '".$cmbproductos."'";
	$consulta2.=" and sub_tipo_movim = 4  and hora between '".$FechaHI."' and '".$FechaHF."'";
	$consulta2.=" group by hornada,cod_subproducto";
	$resp=mysqli_query($link, $consulta2);
	$tipoA = "";
	while($Fila=mysqli_fetch_array($resp))
	{
		if($Fila["cod_subproducto"]==1)
			$tipoA = "Ctes. HVL ";
		if($Fila["cod_subproducto"]==2)
			$tipoA = "Ctes. TTE ";
		if($Fila["cod_subproducto"]==3)
			$tipoA = "Ctes. Anglo ";
		if($Fila["cod_subproducto"]==4)
			$tipoA = "Ctes. VTNAS.";
		if($Fila["cod_subproducto"]==8)
			$tipoA = "H.M. VTNAS.";
		echo '<tr><td width="15%"><div align="left">'.$tipoA.'</div></td>';
		echo '<td width="15%"><div align="center">'.$Fila["hornada"].'</div></td>';
		echo '<td width="15%"><div align="right">'.$Fila["unidades"].'</div></td>';
		echo '<td width="15%"><div align="right">'.$Fila["peso"].'</div></td></tr>';					
	}
	echo '</table>';	                    
	
}
?>
  <br>
  <table cellpadding="3" cellspacing="0" width="520" border="0" align="center">
		  <tr>
			<td> <div align="center">
				<input name="btnsalir" type="button" style="width:100" value="Cerra Ventana" onClick="self.close()">
			  </div></td>
		  </tr>
		</table>
	
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
