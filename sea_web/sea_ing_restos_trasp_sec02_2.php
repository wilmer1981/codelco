<?php include("../principal/conectar_sea_web.php")?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_datos()
{
	var f = frmPoPup;

    f.action="sea_ing_restos_trasp_sec02.php?Proceso=B";
	f.submit();
}
function EliminarMov(Obj,Datos)
{
	var f = frmPoPup;
	
	if(Obj.checked==true)
	{
		if(confirm('Esta Seguro de Eliminar el Movimiento'))
		{
			f.action="sea_ing_restos_trasp_sec01.php?Proceso=EM&Valores="+Datos;
	        f.submit();
		}
		else
			Obj.checked=false;
	}
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
        <td width="213"><font color="#000000" size="2">&nbsp; </font><font color="#000000" size="2"> 
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
          </font><font color="#000000" size="2">&nbsp; </font></td>
        <td width="159"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_datos();">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()"></td>
      </tr>
    </table>
<?php
if($Proceso == 'B')
{
	 $lm = strlen($mes);
	 if ($lm==1)
	 {
	 	$mes = "0$mes";
	 }
	 $ld = strlen($dia);
	 if ($ld==1)
	 {
	 	$dia = "0$dia";
	 }
	$fecha = $ano.'-'.$mes.'-'.$dia;
	
	$FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
	$FechaTermino =date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano))." 07:59:59";

	echo '<table width="500"  border="1" cellspacing="0" cellpadding="0" align="center"><tr class="ColorTabla01">';
	echo '<td width="100" align="center">FECHA</td>';
	echo '<td width="100" align="center">HORNADA</td>';
	echo '<td width="100" align="center">GRUPO</td>';
	echo '<td width="100"align="center">CANTIDAD</td>';
	echo '<td width="100" align="center">PESO<br>KGS.</td></tr>';
	$TotalCantidad = 0;
	$TotalPeso = 0;
	$Consulta="SELECT distinct t1.cod_subproducto,t2.descripcion from sea_web.restos_a_sec t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.="where fecha_movimiento = '".$fecha."' and t1.tipo_movimiento = '4'";
	//echo $Consulta;
	$RespProd=mysqli_query($link, $Consulta);
	while($FilaProd=mysqli_fetch_array($RespProd))
	{
		switch($FilaProd["cod_subproducto"])
		{
			case "21":
				$SubProd=1;
				break;
			case "22":
				$SubProd=2;
				break;
			case "23":
				$SubProd=3;
				break;
			case "25":
				$SubProd=4;
				break;
			case "26":
				$SubProd=8;
				break;

		}
		$Datos=$fecha."~".$SubProd;
		echo '<tr class="ColorTabla02">';
		echo '<td align="left" colspan="5">'.$FilaProd["descripcion"].'&nbsp;&nbsp;&nbsp;---->ELIM.MOV&nbsp;<input type="checkbox" name="CheckTrasp" onclick=EliminarMov(this,"'.$Datos.'")></td>';
		$TotProdCantidad = 0;
		$TotProdPeso = 0;
		echo '<input type="hidden" name="CheckTrasp">';
		$consulta = "SELECT distinct cod_producto, cod_subproducto FROM sea_web.restos_a_sec";
		$consulta.= " WHERE tipo_movimiento = '4' AND cod_producto = 19  and fecha_movimiento = '".$fecha."' ";//and hora between '$FechaInicio' and '$FechaTermino'";
		//echo "uno".$consulta."<br>";
		$rs2 = mysqli_query($link, $consulta);		
		while ($row2 = mysqli_fetch_array($rs2))
		{							
			$TotProdPeso = 0;
			$TotProdCantidad = 0;		
			$consulta1 = "SELECT hornada,grupo,fecha_movimiento, sum(unidades) as unidades, sum(peso) as peso from sea_web.restos_a_sec";
			$consulta1.=" where tipo_movimiento = '4' and cod_producto = '19' and cod_subproducto = '".$row2["cod_subproducto"]."' and fecha_movimiento = '".$fecha."'";
			$consulta1.=" group by hornada, grupo,fecha_movimiento order by grupo, hornada";
			$rs3=mysqli_query($link, $consulta1);
			while ($fila = mysqli_fetch_array($rs3))
			{			 
				echo '<tr>';
				$Datos='';
				echo '<td width="100"><center>'.$fecha.'</center></td>';
				echo '<td width="100"><center>'.$fila[hornada].'</center>';
				echo '<td width="100" align="center">'.$fila["grupo"].'</td>';
				echo '<td width="100" align="center">';
				echo $fila["unidades"].'</td>';
				echo '<td width="100" align="center">';
				echo $fila["peso"].'</td>';
				$TotalCantidad = $TotalCantidad + $row2["unidades"];
				$TotProdCantidad = $TotProdCantidad + $row2["unidades"];
				$TotProdPeso = $TotProdPeso + $row2["peso"];
				$TotalPeso = $TotalPeso + $row2["peso"];
			}
				echo '<tr class="ColorTabla02">';
				echo '<td width="300" align="left" colspan="3">&nbsp;TOTAL DIA </td>';
				echo '<td width="100" align="center">'.$TotProdCantidad.'</td>';
				echo '<td width="100" align="center">'.$TotProdPeso.'</td></tr>';
				echo '</table><br>';

	}	
	echo '<tr class="ColorTabla02">';
	echo '<td width="300" align="left" colspan="3">&nbsp;TOTAL DIA </td>';
	echo '<td width="100" align="center">'.$TotalCantidad.'</td>';
	echo '<td width="100" align="center">'.$TotalPeso.'</td></tr>';
	echo '</table><br>';
}
?>
</table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
