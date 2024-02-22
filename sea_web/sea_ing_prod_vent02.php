<?php
include("../principal/conectar_sea_web.php");

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
	$ano = "";
}
if(isset($_REQUEST["mes"])) {
	$mes= $_REQUEST["mes"];
}else{
	$mes = "";
}
if(isset($_REQUEST["dia"])) {
	$dia= $_REQUEST["dia"];
}else{
	$dia = "";
}

?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_guia()
{
var f = frmPoPup;

   	 if(f.cmbproductos.value == -1)
	 {  
	   alert("Debe ingresar el Producto");
	   f.cmbproductos.focus();
	   return
	 }


    f.action="sea_ing_prod_vent02.php?Proceso=B";
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
  <div align="left"> 
    <table cellpadding="3" cellspacing="0" width="500" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla02"> 
        <td colspan="3"><div align="center">Busqueda de Datos</div></td>
      </tr>
      <tr> 
        <td width="108" height="32">Fecha Busqueda</td>
        <td width="213"><font color="#000000" size="2"> 
          <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
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
          <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
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
          <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
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
        <td width="159">&nbsp;</td>
      </tr>
      <tr> 
        <td>Tipo Producto</td>
        <td>
		<?php 
		 echo '<SELECT name="cmbproductos" style="width:200">
            <option  value = "-1" SELECTed>Productos</option>';
			
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' AND cod_subproducto in (4,8,11)";
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
	   
	   ?>
	   </td>
        <td><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_guia();"></td>
      </tr>
    </table>
<?php
if($Proceso == 'B')
{
echo'<table cellpadding="3" cellspacing="0" width="500" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla01"> 
        <td width="20%"><div align="center">Hornada</div></td>
        <td width="20%"><div align="center">Unidades</div></td>
        <td width="20%"><div align="center">Peso</div></td>
		<td width="20%"><div align="center">Fecha/Hora</div></td>
      </tr>
    </table>
  </div>

  <div align="left" style="position:absolute; overflow:auto; top: 115px; height: 380px;"> 
  <table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">';   

 	include("../principal/conectar_sea_web.php");
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$fecha2 = date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano));
		$FechaInicio = $ano.'-'.$mes.'-'.$dia." 08:00:00";
		$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano))." 07:59:59";
	
					$consulta = "SELECT hornada,unidades,peso FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and ";
					$consulta.=" '".$fecha2."' AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' and hora between '".$FechaInicio."' and '".$FechaTermino."' "; 
					$consulta.=" group by hornada,sub_tipo_movim ";
					//echo $consulta;
					$total_unidades = 0;
					$total_peso = 0;
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{	
						echo '<tr><td width="20%"><div align="center">'.substr($row["hornada"],6,6).'</div></td>';
						echo '<td width="20%"><div align="right">'.number_format($row["unidades"],0,",",".").'</div></td>';
						echo '<td width="20%"><div align="right">'.number_format($row["peso"],0,",",".").'</div></td>';
						
					   /*$consulta = "SELECT peso_unidades FROM hornadas where hornada_ventana = $row["hornada"] AND cod_producto = 17 AND cod_subproducto = $cmbproductos"; 
					   //echo $consulta;
					   $rs2 = mysqli_query($link, $consulta);
						
						if($row2 = mysqli_fetch_array($rs2))
						{
						echo '<td width="20%"><div align="center">'.$row2["peso_unidades"].'</div></td>';
					    } */
						echo '<td width="20%"><div align="center">'.$row["hora"].'</div></td>';
						$total_unidades = $total_unidades + $row["unidades"];
						$total_peso = $total_peso + $row["peso"];
					}
   			echo'<tr>'; 
      		echo'<td width="162"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="20%"><div align="right">'.number_format($total_unidades,0,",",".").'</div></td>';
      		echo'<td width="20%"><div align="right">'.number_format($total_peso,0,",",".").'</div></td>';
			echo'<td width="120"><div align="right">&nbsp;</div></td>';
    echo'</tr>
  		</table></div>';  

}

?>	
  <div align="left" style="position:absolute; top: 475px; left: 24px;">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
		    <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
