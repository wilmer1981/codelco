<?php 
	include("../principal/conectar_ref_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 3;
	
    function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4);
		return $fecha;
	}
    $mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";	
	$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$ano1   = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$mes1   = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$dia1   = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	
    if ($fecha!="")
    {
	   $ano1=substr($fecha,0,4);
	   $mes1=substr($fecha,5,2);
	   $dia1=substr($fecha,8,2);
	   $mostrar='S';
	}
   if ( strlen($mes1)==1 )
      {$mes1='0'.$mes1;}	
   if ( strlen($dia1)==1 )
      {$dia1='0'.$dia1;}
  /*
   if (!isset($dia1))
	{
		$dia1 = date("d");
		$mes1 = date("m");
		$ano1 = date("Y");
	}*/
?>
<html>
<head>
<title>Detalle Cortocircuitos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Imprimir(f)
{
	window.print();
}
/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=11";
}
/*****************/
function Buscar()
{
var  f=document.frmPrincipal;

	f.action='ref_cortocircuitos.php?mostrar=S';
	f.submit();
}
</script>
</head>
<BODY background="../principal/imagenes/fondo3.gif" >

<form name="frmPrincipal" action="" method="post">
  <tr> 
    <td width="720" height="100" align="center" valign="top"> <div align="center"></div>

        <table width="720" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">
          <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
            <td colspan="19" align="center"><strong>Informe Cortociruitos Grupos 
              del: <?php echo $dia1.'-'.$mes1.'-'.$ano1;?> 
              <input type="hidden" name="dia1" size="2" value="<?php echo $dia1 ?>">
              <input type="hidden" name="mes1" size="2" value="<?php echo $mes1 ?>">
              <input type="hidden" name="ano1" size="4" value="<?php echo $ano1 ?>">
              </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
            <td colspan="10" align="center"><strong>Anodos Nuevos</strong></td>
            <td colspan="9" align="center"><strong>Semi Anodos</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
            <td colspan="10" align="center"><strong>Dias</strong></td>
            <td colspan="9" align="center"><strong>Dias</strong></td>
          </tr>
          <tr class="ColorTabla02"> 
            <td  width="37" align="center" bordercolor="#FFFFFF"><strong>Grupo</strong></td>
            <td  width="37" align="center" bordercolor="#FFFFFF"><strong>1</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>2</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>3</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>4</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>5</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>6</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>7</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>8</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>9</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF" ><strong>1</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>2</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>3</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>4</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>5</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>6</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>7</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>8</strong></td>
            <td width="37" align="center" bordercolor="#FFFFFF"><strong>Tot.</strong></td>
          </tr>
        </table>
        <table width="720" border="1"  cellspacing="0" cellpadding="0" class="TablaInterior">
<?php
      $color1=1;
     $fecha=$ano1.'-'.$mes1.'-'.$dia1;
     $borra_tmp="delete from ref_web.tmp_cir_electrolitico";
	 mysqli_query($link, $borra_tmp);
	 $varindice = '';
	 $wgrupo = '';
	 $llena_tmp="SELECT distinct cod_grupo,cod_circuito from ref_web.grupo_electrolitico2 where cod_grupo not in ('01','02')";
	 $llena_tmp.=" order by cod_circuito,cod_grupo";
	 $rsll =mysqli_query($link, $llena_tmp);
	 while($rowll=mysqli_fetch_array($rsll))
	 {  
	 	$varindice = $rowll["cod_grupo"];
		if($rowll["cod_circuito"]=='01' && $rowll["cod_grupo"]=='07')
		{
			$insertar="insert into ref_web.tmp_cir_electrolitico (cod_grupo,cod_circuito,cod_indice)";
			$insertar.=" values('7A','".$rowll["cod_circuito"]."','07')";
			mysqli_query($link, $insertar);
			$insertar="insert into ref_web.tmp_cir_electrolitico (cod_grupo,cod_circuito,cod_indice)";
			$insertar.=" values('7B','".$rowll["cod_circuito"]."','08')";
			mysqli_query($link, $insertar);
		}
		else
		{	
			if($rowll["cod_circuito"]=='01' && $rowll["cod_grupo"]=='08')
				$varindice = '09';
			if($rowll["cod_circuito"]=='01' && $rowll["cod_grupo"]=='49')
				$varindice = '10';
			$insertar="insert into ref_web.tmp_cir_electrolitico (cod_grupo,cod_circuito,cod_indice)";
			$insertar.=" values('".$rowll["cod_grupo"]."','".$rowll["cod_circuito"]."','".$varindice."')";
			mysqli_query($link, $insertar);
		}
		$varindice = '';
	}   
  	//$consulta_fecha="SELECT distinct cod_grupo,cod_circuito from ref_web.grupo_electrolitico2 where cod_grupo not in ('01','02','07')";	
  	$consulta_fecha="SELECT cod_grupo,cod_circuito from ref_web.tmp_cir_electrolitico";	
	$consulta_fecha.=" order by cod_circuito,cod_indice,cod_grupo";
	$rs = mysqli_query($link, $consulta_fecha);
	while ($row = mysqli_fetch_array($rs))
	{ 
		if (($row["cod_circuito"]=='01') || ($row["cod_circuito"]=='03') || ($row["cod_circuito"]=='05') || ($row["cod_circuito"]=='07'))
        {
			 $color1=1;
		}
		else {$color1=2;}		
	    $nuevo = array();
		$semi = array();
		$total_nuevo = array();
		$total_semi = array ();
		//$total1=array();
		$total2=array();
		echo '<tr>';
		if ($color1==1)
			 {echo '<td width="37" align="center" class="detalle01">'.$row["cod_grupo"].'&nbsp;</td>';}	
		else {echo '<td width="37" align="center" class="detalle02">'.$row["cod_grupo"].'&nbsp;</td>';}
		$consulta_fecha="select max(fecha) as fecha from ref_web.cortocircuitos where cod_grupo='".$row["cod_grupo"]."' and fecha <='".$fecha."' ";
		//if($row["cod_grupo"]=='7A' || $row["cod_grupo"]== '7B')
		//	echo "maxfecha".$consulta_fecha."<br>";
		$rs_fecha = mysqli_query($link, $consulta_fecha);
	    $row_fecha = mysqli_fetch_array($rs_fecha);
		$fecha = isset($row_fecha["fecha"])?$row_fecha["fecha"]:"0000-00-00";
		$consulta="select max(cont_dia) as max_contdia from ref_web.cortocircuitos where cod_grupo='".$row["cod_grupo"]."' and fecha='".$fecha."'";
		//if($row["cod_grupo"]=='7A' || $row["cod_grupo"]== '7B')
    	//	echo "MaxCont". $consulta."<br>";
		$rs2 = mysqli_query($link, $consulta);
	    $row2 = mysqli_fetch_array($rs2);
		$sql="SELECT  SUBDATE('".$fecha."',INTERVAL '".$row2['max_contdia']."' DAY) as fecha";
        $result=mysqli_query($link, $sql);
        $row_fecha_menos_dias = mysqli_fetch_array($result);
		$consulta_datos="select * from ref_web.cortocircuitos where cod_grupo='".$row["cod_grupo"]."' and fecha between '".$row_fecha_menos_dias["fecha"]. "' and '".$fecha."' order by fecha asc  ";
		//if($row["cod_grupo"]=='7A' || $row["cod_grupo"]== '7B')
		//		echo "datos". $consulta_datos."<br>";
		$rs5 = mysqli_query($link, $consulta_datos);
		//$nuevo = array();/**/
		//$semi = array();/**/
		$cont_dia=0;/**/
		$circuito1=0;$circuito2=0;$circuito3=0;
		$circuito4=0;$circuito5=0;$circuito6=0;
		$total_cortos_ref=0;
		$total2[9]=0;
		while ($row5 = mysqli_fetch_array($rs5))
		{
			//       $nuevo[$row5[cont_dia]-1]=$nuevop;
			//	   $semi[$row5[cont_dia]-1]= $semip;

			$nuevo[$row5['cont_dia']-1]=$row5['cortos_nuevo'];
			$semi[$row5['cont_dia']-1]= $row5['cortos_semi'];
			if ($row5["cod_circuito"]=='01')
			{
				$circuito1=$circuito1+$row5['cortos_nuevo']+$row5['cortos_semi'];
			}
			if ($row5["cod_circuito"]=='02')
			{
				$circuito2=$circuito2+$row5['cortos_nuevo']+$row5['cortos_semi'];
			}
			if ($row5["cod_circuito"]=='03')
			{
				$circuito3=$circuito3+$row5['cortos_nuevo']+$row5['cortos_semi'];
			}
			if ($row5["cod_circuito"]=='04')
			{
				$circuito4=$circuito4+$row5['cortos_nuevo']+$row5['cortos_semi'];
			}
			if ($row5["cod_circuito"]=='05')
			{
				$circuito5=$circuito5+$row5['cortos_nuevo']+$row5['cortos_semi'];
			} 
			if ($row5["cod_circuito"]=='06')
			{
				$circuito6=$circuito6+$row5['cortos_nuevo']+$row5['cortos_semi'];
			}
			$total_nuevocont_dia2 = isset($total_nuevo[$row5['cont_dia']-2])?$total_nuevo[$row5['cont_dia']-2]:0;
			$total_semicont_dia2  = isset($total_semi[$row5['cont_dia']-2])?$total_semi[$row5['cont_dia']-2]:0;
			$total_nuevo[$row5['cont_dia']-1]= $total_nuevocont_dia2 + $row5['cortos_nuevo'];
			$total_semi[$row5['cont_dia']-1] = $total_semicont_dia2  + $row5['cortos_semi'];
			$total2[9]        = $total2[9] + $row5['cortos_semi'] + $row5['cortos_nuevo'];  
			$total_cortos_ref = $total_cortos_ref + $row5['cortos_nuevo'] + $row5['cortos_semi'];
			$cont_dia++;
		} 
		$cont=0;	
		while ($cont<=8)
		{   $nuevocont=isset($nuevo[$cont])?$nuevo[$cont]:"";
			if ($color1==1)
			{
				echo '<td width="37" align="center" class="detalle01">'.$nuevocont.'&nbsp;</td>';
			}
			else 
			{
				echo '<td width="37" align="center" class="detalle02">'.$nuevocont.'&nbsp;</td>'; 
			}   
			$cont=$cont+1;	  
		}
		$cont=0;
		while ($cont<=8)
		{  $semicont=isset($semi[$cont])?$semi[$cont]:"";
			if ($color1==1)
			{
				echo '<td width="37" align="center" class="detalle01">'.$semicont.'&nbsp;</td>';
			}
			else 
			{
				echo '<td width="37" align="center" class="detalle02">'.$semicont.'&nbsp;</td>';
			}
			$cont=$cont+1;	  
		}	   	
		echo '</tr>';
		echo '<tr>';
		if ($color1==1)
		{
			 echo '<td width="37" align="center" class="detalle01"><font color="red">&nbsp;&nbsp;&nbsp;Ac.&nbsp;&nbsp;&nbsp;&nbsp;</font></td>';
		}
		else 
		{
			echo '<td width="37" align="center" class="detalle02"><font color="red">&nbsp;&nbsp;&nbsp;Ac.&nbsp;&nbsp;&nbsp;&nbsp;</font></td>';
		}  	
		$cont=0;
		while ($cont<=8)
		{ 	$total_nuevocont=isset($total_nuevo[$cont])?$total_nuevo[$cont]:0;
			if ($color1==1)
			{
				echo '<td width="37" align="center" class="detalle01"><font color="red"><strong>'.$total_nuevocont.'&nbsp;</strong></font></td>';
			}
			else
			{
				echo '<td width="37" align="center" class="detalle02"><font color="red"><strong>'.$total_nuevocont.'&nbsp;</strong></font></td>';
			}
			$cont=$cont+1;	  
		}
		$cont=0;
		//echo '<td width="47" align="center"  class="ColorTabla01"><font color="white"><strong>'.$total1[9].'&nbsp;</strong></font></td>'; 
		while ($cont<=7)
		{	$total_semicont=isset($total_semi[$cont])?$total_semi[$cont]:0;
			if ($color1==1)
			{
				echo '<td width="37" align="center" class="detalle01"><font color="red"><strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$total_semicont.'&nbsp;</strong></font></td>';
			}
			else
			{
				echo '<td width="37" align="center" class="detalle02"><font color="red"><strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$total_semicont.'&nbsp;</strong></font></td>';
			}
					$cont=$cont+1;	  
		} 
		$total29 = isset($total2[9])?$total2[9]:0;
		echo '<td width="37" align="center"  class="ColorTabla01" ><font color="white"><strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$total29.'&nbsp;</strong></font></td>';  
		echo '</tr>';
	}
?>
</table> 
        <table width="720" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr> 
            <td colspan="5" align="center">&nbsp; </td>
           <?php echo '<td width="250" align="left"  class="ColorTabla01" ><font color="white"><strong>Total Cortocircuitos en Refineria:&nbsp;</strong></font></td>';  
		       echo '<td width="50" align="left"  class="ColorTabla01" ><font color="white"><strong>'.$total_cortos_ref.'&nbsp;</strong></font></td>'; ?>
          </tr>
		  </table>
		  <tr>&nbsp;</tr>
		  <table width="300" border="1" align="center" cellspacing="0" cellpadding="3" class="tablainterior">
		    <tr>
		      <?php
			   $arreglo[0]=$circuito1;
			   $arreglo[1]=$circuito2;
			   $arreglo[2]=$circuito3;
			   $arreglo[3]=$circuito4;
			   $arreglo[4]=$circuito5;
			   $arreglo[5]=$circuito6;
			   echo '<tr>';
			   echo '<td width="300" align="center"  class="ColorTabla01" colspan="3"><strong>Resumen Cortocircuitos Dia</strong></td>';  
			   echo '</tr>';			   			   			   			   
			   echo '<td width="300" align="center"  class="ColorTabla01" ><strong>Circuito</strong></td>';  
			   echo '<td width="300" align="center"  class="ColorTabla01" ><strong>Referenciales</strong></td>';  
			   echo '<td width="300" align="center"  class="ColorTabla01" ><strong>Totales al dia</strong></td>';  
			   $consulta_circuito="select cod_circuito from sec_web.circuitos";
			   $rs_cir = mysqli_query($link, $consulta_circuito);
			   $i=0;
			    while ($row_cir = mysqli_fetch_array($rs_cir))
			    {   $cod_circuito = isset($row_cir["cod_circuito"])?$row_cir["cod_circuito"]:"";
					 echo '<tr>';
					 $consulta_fecha="select max(fecha) as fecha from ref_web.referenciales where cod_circuito='".$row_cir["cod_circuito"]."' and fecha<='".$ano1.'-'.$mes1.'-'.$dia1."' ";
					// if($row_cir["cod_circuito"]=='01')
					 //	echo "circ-1".$consulta_fecha."<br>" ;
					 $rs_fecha = mysqli_query($link, $consulta_fecha);
			         $row_fecha = mysqli_fetch_array($rs_fecha);
					 $fecha = isset($row_fecha["fecha"])?$row_fecha["fecha"]:"0000-00-00";
			         $consulta_ref="select * from ref_web.referenciales where cod_circuito='".$row_cir["cod_circuito"]."' and fecha='".$fecha."'";
					 //if($row_cir["cod_circuito"]=='01')
					//	 echo "refe".$consulta_ref."<br>";
			         $rs_ref = mysqli_query($link, $consulta_ref);
			         $row_ref = mysqli_fetch_array($rs_ref);
					 $ref_cir      = isset($row_ref['ref_cir'])?$row_ref['ref_cir']:0;
					 
					 $consulta_acumulados="select * from ref_web.cortos_acumulado where fecha='".$ano1.'-'.$mes1.'-'.$dia1."' and cod_circuito='".$row_cir["cod_circuito"]."' order by cod_circuito,fecha";
					 //if($row_cir["cod_circuito"]=='01')
					 //	echo "acum".$consulta_acumulado."</br>";
					 $rs_acumulados = mysqli_query($link, $consulta_acumulados);
					 $arregloi = isset($arreglo[$i])?$arreglo[$i]:0;
			        if (!$row_acumulados = mysqli_fetch_array($rs_acumulados))
					{
						 $insertar_acumulados = "INSERT INTO ref_web.cortos_acumulado (cod_circuito,fecha,acumulado) "; 
						 $insertar_acumulados = $insertar_acumulados."VALUES ('".$row_cir["cod_circuito"]."','".$ano1.'-'.$mes1.'-'.$dia1."','".$arregloi."')";
						 mysqli_query($link, $insertar_acumulados);
					} 
					else 
					{
					       $actualiza = "UPDATE ref_web.cortos_acumulado set acumulado ='".$arregloi."'";
						   $actualiza.= " where cod_circuito= '".$row_cir["cod_circuito"]."' and fecha='".$ano1.'-'.$mes1.'-'.$dia1."'";
						   //echo $actualiza;
						   mysqli_query($link, $actualiza);					 
					}
					 
			         echo '<td width="300" align="center"  class="detalle01" ><strong>&nbsp;&nbsp;'.$row_cir["cod_circuito"].'&nbsp;&nbsp;</strong></td>';
					 echo '<td width="300" align="center"  class="detalle02" ><strong>'.$ref_cir.'</strong></td>';
					 if ($ref_cir<$arregloi)
					    {  
					     echo '<td width="300" align="center"  class="detalle01" ><strong><font color="red">'.$arregloi.'</font></strong></td>';
						}
					 else {	
					        echo '<td width="300" align="center"  class="detalle01" ><strong>'.$arregloi.'</strong></td>';
						  }
					 $i++;
					 echo '</tr>';	
				    }
			?> 
		  </tr>	
		  </table>
		  <table width="720" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
		  <tr> 
            <td colspan="6" align="center">
			  <input name="btninprimir" type="button" id="btninprimir" value="Imprimir"style="width:70"  onClick="JavaScript:Imprimir(this.form)"> 
          </td>
          </tr>
        </table>
      </td>
</tr>
</table>
</form>
</body>
</html>
<?php include("../principal/cerrar_ref_web.php"); ?>
