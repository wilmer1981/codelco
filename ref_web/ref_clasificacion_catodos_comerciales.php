<?php
	set_time_limit(500);
	include("../principal/conectar_principal.php");

	$cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
	$opcion      = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:""; 
	$Buscar      = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:""; 

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 
	
	if (strlen($DiaIni)==1)
		$DiaIni = "0".$DiaIni;
	if (strlen($MesIni)==1)
		$MesIni = "0".$MesIni;
	if (strlen($DiaFin)==1)
		$DiaFin = "0".$DiaFin;
	if (strlen($MesFin)==1)
		$MesFin = "0".$MesFin;

 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Clasificacion Catodos Comerciales</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1()
{	
	var f = document.frmPrincipal;
	var correcto="";
	if (f.opcion[0].checked)
	    {
		  opcion="P";
		  var correcto="S";
		   //alert ("hola1");
		}	
	else if (f.opcion[1].checked)
	        {
	         opcion="L";
			 var correcto="S";
			 //alert ("hola2");
	        }
	    else { 
		      alert("Debe seleccionar Tipo de Informe");
		       var correcto="N";
			 }		
	if (correcto=='S')
	   {
	    f.action = "ref_clasificacion_catodos_comerciales.php?cmbcircuito="+f.cmbcircuito.value+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&opcion="+opcion;
	    f.submit();
	  }
}
function Imprimir(f)
{
	window.print();
}
function Salir(f)
{
 f.action ="../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
 f.submit();
}
function Grafico(f)
{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	
	var URL ="../ref_web/ref_grafico_clacificacion_cat_comerciales.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value+"&cmbcircuito="+f.cmbcircuito.value;
    window.open(URL,"","menubar=no resizable=no top=30 left=50 width=930 height=650 scrollbars=no");
}	 
function Excel(f)
{
	var correcto="";
	if (f.opcion[0].checked)
	    {
		  opcion="P";
		  var correcto="S";
		}	
	else if (f.opcion[1].checked)
	        {
	         opcion="L";
			 var correcto="S";
	        }
	    else { 
		      alert("Debe seleccionar Tipo de Informe");
		       var correcto="N";
			 }		

	if (correcto=='S')
		{
		
			document.location = "ref_clasificacion_catodos_comerciales_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value+"&cmbcircuito="+f.cmbcircuito.value+"&opcion="+opcion+"&mostrar=S";	
		}



	
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
function Globales()
{
	var f=document.frmPrincipal;
	var FechaInicio=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var FechaTermino=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	var correcto="";
	if (f.opcion[0].checked)
	    {
		  opcion="P";
		  var correcto="S";
		   //alert ("hola1");
		}	
	else if (f.opcion[1].checked)
	        {
	         opcion="L";
			 var correcto="S";
			 //alert ("hola2");
	        }
	    else { 
		      alert("Debe seleccionar Tipo de Informe");
		       var correcto="N";
			 }		

    if (correcto=='S')
		{
			var URL ="ref_globales_selec_catodos.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value+"&cmbcircuito="+f.cmbcircuito.value+"&opcion="+opcion;
			window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=800 height=200 scrollbars=yes");
		}	
}
function Detalle()
{
    var f=document.frmPrincipal;
	var FechaInicio=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var FechaTermino=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	var correcto="";
	if (f.opcion[0].checked)
	    {
		  opcion="P";
		  var correcto="S";
		   //alert ("hola1");
		}	
	else if (f.opcion[1].checked)
	        {
	         opcion="L";
			 var correcto="S";
			 //alert ("hola2");
	        }
	    else { 
		      alert("Debe seleccionar Tipo de Informe");
		       var correcto="N";
			 }
					
   if (f.cmbcircuito.value!='99')
   	{
    	if (correcto=='S')
			{
				var URL ="ref_detalle_rechazo_clasificacion_cat_comercial.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value+"&cmbcircuito="+f.cmbcircuito.value+"&opcion="+opcion;
				window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=800 height=200 scrollbars=yes fullscreen=yes");
			}
	}
 else {
 		var URL ="ref_detalle_global_rechazo_clasificacion_cat_comercial.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value+"&cmbcircuito="+f.cmbcircuito.value+"&opcion="+opcion;
		window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=800 height=200 scrollbars=yes fullscreen=yes");
	  }				
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" > 
      <td colspan="4" class="ColorTabla01"><strong>INFORME DE CLASIFICACION FISICA 
        DE CATODOS COMERCIALES</strong></td>
  </tr>
  <tr> 
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr> 
    <td width="92">Fecha Inicio:</td>
    <td width="263"><select name="DiaIni" style="width:50px;">
        <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
      </select> <select name="MesIni" style="width:90px;">
        <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
      </select> <select name="AnoIni" style="width:60px;">
        <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
      </select></td>
    <td width="112">Fecha Termino:</td>
    <td width="264"><select name="DiaFin" style="width:50px;">
        <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
      </select> <select name="MesFin" style="width:90px;">
        <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
      </select> <select name="AnoFin" style="width:60px;">
        <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
      </select>
    </td>
  </tr>
    <tr align="center"> 
      <td height="10" colspan="4">
<table width="738" height="68" border="0">
          <tr> 
            <td width="206" height="41">Circuito 
              <select name="cmbcircuito" id="select3" >
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sec_web.circuitos ";
				$consulta.= " ORDER BY cod_circuito";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if  ($row["cod_circuito"] == $cmbcircuito)
						echo '<option value="'.$row["cod_circuito"].'" selected>Circuito '.$row["cod_circuito"].'</option>';
					else 
						echo '<option value="'.$row["cod_circuito"].'">Circuito '.$row["cod_circuito"].'</option>';
				}			
				
			    if ($cmbcircuito=='99') 
				    { ?>
                <option value="99" selected>Todos</option>
                <?php } 
				    else {?>
                <option value="99">Todos</option>
                <?php }?>
              </select>
            </td>
            <td width="103" height="11">Porcentajes 
              <?php 
			if ($opcion=='P')
		      {  ?>
              <input type="radio" name="opcion" value="P" checked> 
              <?php }
	       else { ?>
              <input type="radio" name="opcion" value="P"> 
              <?php } ?>
            <td width="80"> Unidades 
              <?php 
		  if ($opcion=='L')
		     {  ?>
              <input type="radio" name="opcion" value="L" checked> 
              <?php } 
	     else { ?>
              <input type="radio" name="opcion" value="L"> 
              <?php }  ?>
            </td>
            <td width="331"><input name="buscar" type="button" value="Buscar" onClick="Recarga1()" ></td>
          </tr>
        </table>
	  </p>
        <input name="globales" type="button" value="Globales" onClick="Globales(this.form)" > 
        <input name="graficar" type="button" value="Grafico" onClick="Grafico(this.form)" >
		<?php if ($opcion!='L') 
			{?> 
        		<input name="detalle" type="button" value="Detalle" onClick="Detalle(this.form)" disabled title="Habilitado solo para Informe por Unidades">
		 <?php } 
		   else { ?>
		   			<input name="detalle" type="button" value="Detalle" onClick="Detalle(this.form)">
			<?php 	}	?>	
      </td>
  </tr>
</table>
  <?php if ($cmbcircuito<>'99')
   {?>
  <table width="850" border="2" cellspacing="1" align="center" cellpadding="1" bordercolor="#b26c4a" class="TablaDetalle">
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
	<?php if ($opcion=='P') 
		{?>
      		<td colspan="7" align="center"><strong>Circuito <?php echo $cmbcircuito; ?></strong></td>
	<?php 
		}
	else   { ?>
				<td colspan="8" align="center"><strong>Circuito <?php echo $cmbcircuito; ?></strong></td>		
	    <?php } ?>
	<td colspan="7" align="center"><strong>totales</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="96" rowspan="2" align="center"><strong>Fecha</strong><strong></strong></td>
      <td width="38" rowspan="2" align="center"><strong>Grupo</strong><strong></strong></td>
      <td colspan="2" align="center"><strong>Lado</strong></td>
	  <?php if ($opcion=='P')
	        {?>
			  <td width="142" rowspan="2" align="center"><strong>Seleccion Inicial (%)</strong></td>
			  <td width="140" rowspan="2" align="center"><strong>Recuperado (%)</strong></td>
			  <td width="191" rowspan="2" align="center"><strong>Estandar (%)</strong></td>
		<?php } 
		else if ($opcion=='L')
		        { ?> 
				<td width="142" rowspan="2" align="center"><strong>Produccion (Unid.)</strong></td>
				 <td width="142" rowspan="2" align="center"><strong>Seleccion Inicial (Unid.)</strong></td>
			     <td width="140" rowspan="2" align="center"><strong>Recuperado (Unid.)</strong></td>
			     <td width="191" rowspan="2" align="center"><strong>Estandar (Unid.)</strong></td>
			<?php } ?> 
		<td width="19" rowspan="2" align="center"><strong>NE</strong></td>
		<td width="19" rowspan="2" align="center"><strong>ND</strong></td>
		<td width="19" rowspan="2" align="center"><strong>RA</strong></td>
		<td width="19" rowspan="2" align="center"><strong>CS</strong></td>
		<td width="19" rowspan="2" align="center"><strong>CL</strong></td>
		<td width="19" rowspan="2" align="center"><strong>QU</strong></td>
		<td width="19" rowspan="2" align="center"><strong>RE</strong></td>
		<td width="19" rowspan="2" align="center"><strong>AI</strong></td>
		<td width="19" rowspan="2" align="center"><strong>OT</strong></td>	
    </tr>
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="42" align="center"><strong>Mar</strong></td>
      <td width="43" align="center"><strong>Tierra</strong></td>
    </tr>
	<?php
	   $consulta="SELECT t1.fecha_produccion as fecha,t2.cod_circuito as circuito,t1.cod_grupo as grupo ";
       $consulta.="from sec_web.produccion_catodo as t1 ";
       $consulta.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
       $consulta.="where t1.fecha_produccion BETWEEN '".$FechaInicio."' and '".$FechaTermino."' and t2.cod_circuito='".$cmbcircuito."' ";
       $consulta.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
       $consulta.="GROUP by t1.fecha_produccion,t2.cod_circuito,t1.cod_grupo ";
       $consulta.="ORDER by t1.fecha_produccion,t2.cod_grupo ";
	   $respuesta = mysqli_query($link, $consulta);
	   $produccion_total=0;
	   $seleccion_inicial_total=0;
	   $recuperado_total=0;
	   $rechazado_total=0;
	   $total_ne=0;
	   $total_nd=0;
	   $total_ra=0;
	   $total_cs=0;
	   $total_cl=0;
	   $total_qu=0;
	   $total_re=0;
	   $total_ai=0;
	   $total_ot=0;
	   $total_rechazo=0;
 	    while ($fila = mysqli_fetch_array($respuesta))
	    { 
		$fecha = isset($fila["fecha"])?$fila["fecha"]:"0000-00-00";
		$grupo = isset($fila["grupo"])?$fila["grupo"]:"";
		?>
			    <tr onMouseOver="if(!this.contains(event.fromElement)){this.bgColor='class=ColorTabla02';} if(!document.all){style.cursor='pointer'};style.cursor='hand';" onMouseOut="if(!this.contains(event.toElement)){this.bgColor=''; }" >
				<?php
				echo "<td align='center' class=detalle01>".$fila["fecha"]."&nbsp</td>\n";
				echo "<td align='center' class=detalle02>".$fila["grupo"]."&nbsp</td>\n";
				/******************saca rechazos de tabla rechazo catodos de control de calidad*****************************************/
				$consulta2="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,sum(cordon_superior) as cs,sum(cordon_lateral) as cl,";
				$consulta2.="sum(quemados) as qu,sum(redondos) as re, sum(aire) as ai,sum(otros) as ot ";
				$consulta2.="from cal_web.rechazo_catodos where fecha='".$fecha."' and grupo='".$grupo."'";
				$respuesta2= mysqli_query($link, $consulta2);
				$fila2 = mysqli_fetch_array($respuesta2);
				$suma_rechazo=$fila2["ne"]+$fila2["nd"]+$fila2["ra"]+$fila2["cs"]+$fila2["cl"]+$fila2["qu"]+$fila2["re"]+$fila2["ai"]+$fila2["ot"];
				/***********************************************************************************************************************/
				/******************obtiene datos del grupo electrolitico 2 **********************************************************/
				$consulta_max_fecha_ge="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo='".$grupo."' and fecha<='".$fecha."' ";
				$respuesta_max_fecha_ge= mysqli_query($link, $consulta_max_fecha_ge);
				$row_max_fecha_ge = mysqli_fetch_array($respuesta_max_fecha_ge);
				$consulta_det_grupo = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos,ifnull(hojas_madres,0) as hojas_madres  from ref_web.grupo_electrolitico2 ";
			    $consulta_det_grupo = $consulta_det_grupo."where cod_grupo = '".$grupo."' and  fecha = '".$row_max_fecha_ge["fecha"]."'";
			    $respuesta_det_grupo = mysqli_query($link, $consulta_det_grupo);
				$row_det_grupo = mysqli_fetch_array($respuesta_det_grupo);
				/**********************************************************************************************************************/
				$divisor=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"];
				$divisor2=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"]-$row_det_grupo["hojas_madres"];
				$divisor2=$divisor2*$row_det_grupo["num_catodos"];
				if ($opcion=='P')
				{   
					if($divisor2>0){
						$seleccion_inicial=(($suma_rechazo+$fila2["recuperado_tot"])/$divisor2)*100;
						$porc_recuperado=(($fila2["recuperado_tot"]/$divisor2)*100);
						$total_por_rechazado=(($suma_rechazo/$divisor2)*100);
					}else{
						$seleccion_inicial=0;
						$porc_recuperado=0;
						$total_por_rechazado=0;
					}		
					
				}
				 else if ($opcion=='L')
				         {
						  $seleccion_inicial=$suma_rechazo+$fila2["recuperado_tot"];
					      $porc_recuperado=$fila2["recuperado_tot"];
					      $total_por_rechazado=$suma_rechazo;
						 }  
				/************************************************************************/
				/*****************************************************************************/
				$arr_meses=array('Enero','Febrero_nor','Marzo','Abril','Mayo','Junio','Julio','Agosto','septiembre','Octubre','Noviembre','Diciembre');
				$arr_dias=array(31,28,31,30,31,30,31,31,30,31,30,31); 
				$ano_aux=intval(substr($fecha,0,4));
				$mes_aux=intval(substr($fecha,5,2));
				$calculo=$ano_aux/4;
				$calculo2=number_format($calculo,"0","","");
				$resto=$calculo2-$calculo;
				if ($resto==0)
					{$bisiesto='S';
					 $mes_dia=28;}
				else {$bisiesto='N';}
				$dia_aux=intval(substr($fecha,8,2));
				if ($dia_aux < 9)
				   { $restantes= 8-$dia_aux;
					 if ($mes_aux==1)
						{$mes_aux=strval(12);
						  $ano_aux=strval($ano_aux-1);
						  $dia_aux=$arr_dias[(intval($mes_aux))-1];
						  $dia_aux=strval($dia_aux-$restantes);}
					 else if (($mes_aux==3) and ($bisiesto=='N'))
							{$mes_aux=strval(2);
							 $dia_aux=$arr_dias[intval($mes_aux)-1];
							 $dia_aux=strval($dia_aux-$restantes);}
							else if (($mes_aux==3) and ($bisiesto=='S'))
								{$mes_aux=strval(2);
								  $dia_aux=strval($mes_dia-$restantes);} 	  
					 else{$mes_aux=strval(intval($mes_aux)-1);	
						  $dia_aux=$arr_dias[intval($mes_aux)-1];
						  $dia_aux=strval($dia_aux-$restantes);}
					}
				else{$dia_aux=strval($dia_aux-8);
					  $mes_aux=strval($mes_aux);
					  $ano_aux=strval($ano_aux);}		
				if (strlen($dia_aux)==1)
					{$dia_aux='0'.$dia_aux;}
				if (strlen($mes_aux)==1)
					{$mes_aux='0'.$mes_aux;}	
				
				$fecha_ant=$ano_aux."-".$mes_aux."-".$dia_aux;
				$cons_subp2="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
				$cons_subp2=$cons_subp2."where t1.tipo_movimiento='2' and t1.campo2='".$grupo."' and t1.fecha_movimiento='".$fecha_ant."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
				//echo $cons_subp2;
				$Resp_subp2 = mysqli_query($link, $cons_subp2);
				$Fila_subp2 = mysqli_fetch_array($Resp_subp2);
				$cons_subp="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
				$cons_subp=$cons_subp."where t1.tipo_movimiento='2' and t1.campo2='".$grupo."' and t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
				$Resp_subp = mysqli_query($link, $cons_subp);
				$Fila_subp = mysqli_fetch_array($Resp_subp);
				$producto=isset($Fila_subp["producto"])?$Fila_subp["producto"]:0;
				if ($producto==1)
					{
					if ($Fila_subp["campo1"]=='M' )
					   {
						 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
						 echo h."</td>\n";
						 if ($Fila_subp2["producto"]==1)
					        {echo "<td align='center'>h&nbsp</td>\n";}
				         else if ($Fila_subp2["producto"]==4)
					             {echo "<td align='center'>V&nbsp</td>\n";}
				              else if ($Fila_subp2["producto"]==2)
					                  {echo "<td align='center'>T&nbsp</td>\n";}
				                   else if ($Fila_subp2["producto"]==3)
					                        {echo "<td align='center'>D&nbsp</td>\n";}
					                    else  {echo "<td align='center'>&nbsp</td>\n";}
					   }
					else if ($Fila_subp["campo1"]=='T' )
					        {
   						     if ($Fila_subp2["producto"]==1)
					            {echo "<td align='center'>h&nbsp</td>\n";}
				            else if ($Fila_subp2["producto"]==4)
					                {echo "<td align='center'>V&nbsp</td>\n";}
				                 else if ($Fila_subp2["producto"]==2)
					                     {echo "<td align='center'>T&nbsp</td>\n";}
				                      else if ($Fila_subp2["producto"]==3)
					                        {echo "<td align='center'>D&nbsp</td>\n";}
					                      else  {echo "<td align='center'>&nbsp</td>\n";}

						     echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
							 echo h."</td>\n";
							 
                            }   	 
					}
					
				else if ($producto==4)
					{
					 if ($Fila_subp["campo1"]=='M' )
					   {
						  echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
						  echo V."</td>\n";
						  if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
                       }
					 else if ($Fila_subp["campo1"]=='T' )
					        {
							 if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				  					
							 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
						     echo V."</td>\n";				
					        }
					
					}
				else if ($producto==2)
					{
					  if ($Fila_subp["campo1"]=='M' )
					   {
					    echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
					    echo T."</td>\n";
						if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
					   }
					  else if ($Fila_subp["campo1"]=='T' )
					        {
							  if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
	  					    echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
	  				        echo T."</td>\n";
				
							} 
					}
				else if ($producto==3)
					{
					   if ($Fila_subp["campo1"]=='M' )
					   {
						 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
					     echo D."</td>\n";
						 if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
					   }
					   else if ($Fila_subp["campo1"]=='T' )
					          {
							    if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							    else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
								echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
					            echo D."</td>\n";			
							  }  	 
					}
					else  {
					       echo "<td align='center'>&nbsp</td>\n";
						  
						  }

				/*******************************************************************************/
				/*******************************************************************************/
				if ($opcion=='P')
				{
					echo "<td align='center'>".number_format($seleccion_inicial,"2",".",",")."&nbsp</td>\n";
					echo "<td align='center'>".number_format($porc_recuperado,"2",".",",")."&nbsp</td>\n";
					echo "<td align='center'>".number_format($total_por_rechazado,"2",".",",")."&nbsp</td>\n";
					$consulta_rechazo="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,sum(cordon_superior) as cs,sum(cordon_lateral) as cl,";
					$consulta_rechazo.="sum(quemados) as qu,sum(redondos) as re, sum(aire) as ai,sum(otros) as ot , fecha from cal_web.rechazo_catodos ";
					$consulta_rechazo.=" where fecha ='".$fila["fecha"]."'  and grupo='".intval($fila["grupo"])."' group by fecha";
					$respuesta_rechazo = mysqli_query($link, $consulta_rechazo);
					$row_rechazo=mysqli_fetch_array($respuesta_rechazo);
						$ne=isset($row_rechazo["ne"])?$row_rechazo["ne"]:0;
						$nd=isset($row_rechazo["nd"])?$row_rechazo["nd"]:0;
						$ra=isset($row_rechazo["ra"])?$row_rechazo["ra"]:0;
						$cs=isset($row_rechazo["cs"])?$row_rechazo["cs"]:0;
						$cl=isset($row_rechazo["cl"])?$row_rechazo["cl"]:0;
						$qu=isset($row_rechazo["qu"])?$row_rechazo["qu"]:0;
						$re=isset($row_rechazo["re"])?$row_rechazo["re"]:0;
						$ai=isset($row_rechazo["ai"])?$row_rechazo["ai"]:0;
						$ot=isset($row_rechazo["ot"])?$row_rechazo["ot"]:0;
						
					echo "<td align='center'>".$ne."&nbsp</td>\n";
					echo "<td align='center'>".$nd."&nbsp</td>\n";
					echo "<td align='center'>".$ra."&nbsp</td>\n";
					echo "<td align='center'>".$cs."&nbsp</td>\n";
					echo "<td align='center'>".$cl."&nbsp</td>\n";
					echo "<td align='center'>".$qu."&nbsp</td>\n";
					echo "<td align='center'>".$re."&nbsp</td>\n";
					echo "<td align='center'>".$ai."&nbsp</td>\n";
					echo "<td align='center'>".$ot."&nbsp</td>\n";		
					
					$rechazo_dia=$ne + $nd+$ra+$cs+$cl+$ot;
					$rechazo_dia=$rechazo_dia+$qu+$re+$ai;
					$total_ne=$total_ne+$ne;
					$total_nd=$total_ne+$nd;
					$total_ra=$total_ne+$ra;
					$total_cs=$total_ne+$cs;
					$total_cl=$total_ne+$cl;
					$total_qu=$total_ne+$qu;
					$total_re=$total_ne+$re;
					$total_ai=$total_ne+$ai;
					$total_ot=$total_ne+$ot;
					
					/*$rechazo_dia=$row_rechazo["ne"]+$row_rechazo["nd"]+$row_rechazo["ra"]+$row_rechazo["cs"]+$row_rechazo["cl"]+$row_rechazo["ot"];
					$rechazo_dia = $rechazo_dia + $row_rechazo["qu"]+ $row_rechazo["re"]+ $row_rechazo["ai"];					
					$total_ne=$total_ne+$row_rechazo["ne"];
					$total_nd=$total_ne+$row_rechazo["nd"];
					$total_ra=$total_ne+$row_rechazo["ra"];
					$total_cs=$total_ne+$row_rechazo["cs"];
					$total_cl=$total_ne+$row_rechazo["cl"];
					$total_qu=$total_ne+$row_rechazo["qu"];
					$total_re=$total_ne+$row_rechazo["re"];
					$total_ai=$total_ne+$row_rechazo["ai"];
					$total_ot=$total_ne+$row_rechazo["ot"];*/					
						
				}
			   else if ($opcion=='L')
			           {
					    echo "<td align='center'>".$divisor2."&nbsp</td>\n";
						$produccion_total=$produccion_total+$divisor2;
					    echo "<td align='center'>".$seleccion_inicial."&nbsp</td>\n";
						$seleccion_inicial_total=$seleccion_inicial_total+$seleccion_inicial;
					    echo "<td align='center'>".$porc_recuperado."&nbsp</td>\n";
						$recuperado_total=$recuperado_total+$porc_recuperado;
					    echo "<td align='center'>".$total_por_rechazado."&nbsp</td>\n";
						$rechazado_total=$rechazado_total+$total_por_rechazado;
						$consulta_rechazo="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,sum(cordon_superior) as cs,";
						$consulta_rechazo.="sum(cordon_lateral) as cl,sum(quemados) as qu,sum(redondos) as re,sum(aire) as ai,sum(otros) as ot , fecha from cal_web.rechazo_catodos ";
		  				$consulta_rechazo.=" where fecha ='".$fila["fecha"]."'  and grupo='".intval($fila["grupo"])."' group by fecha";
		  				$respuesta_rechazo = mysqli_query($link, $consulta_rechazo);
						$row_rechazo=mysqli_fetch_array($respuesta_rechazo);
						$ne=isset($row_rechazo["ne"])?$row_rechazo["ne"]:0;
						$nd=isset($row_rechazo["nd"])?$row_rechazo["nd"]:0;
						$ra=isset($row_rechazo["ra"])?$row_rechazo["ra"]:0;
						$cs=isset($row_rechazo["cs"])?$row_rechazo["cs"]:0;
						$cl=isset($row_rechazo["cl"])?$row_rechazo["cl"]:0;
						$qu=isset($row_rechazo["qu"])?$row_rechazo["qu"]:0;
						$re=isset($row_rechazo["re"])?$row_rechazo["re"]:0;
						$ai=isset($row_rechazo["ai"])?$row_rechazo["ai"]:0;
						$ot=isset($row_rechazo["ot"])?$row_rechazo["ot"]:0;
						
						echo "<td align='center'>".$ne."&nbsp</td>\n";
						echo "<td align='center'>".$nd."&nbsp</td>\n";
						echo "<td align='center'>".$ra."&nbsp</td>\n";
						echo "<td align='center'>".$cs."&nbsp</td>\n";
						echo "<td align='center'>".$cl."&nbsp</td>\n";
						echo "<td align='center'>".$qu."&nbsp</td>\n";
						echo "<td align='center'>".$re."&nbsp</td>\n";
						echo "<td align='center'>".$ai."&nbsp</td>\n";
						echo "<td align='center'>".$ot."&nbsp</td>\n";
						$rechazo_dia=$ne + $nd + $ra + $cs + $cl + $ot;
						$rechazo_dia=$rechazo_dia+$qu + $re + $ai;
						$total_ne=$total_ne+$ne;
						$total_nd=$total_nd+$nd;
						$total_ra=$total_ra+$ra;
						$total_cs=$total_cs+$cs;
						$total_cl=$total_cl+$cl;
						$total_qu=$total_qu+$qu;
						$total_re=$total_re+$re;
						$total_ai=$total_ai+$ai;
						$total_ot=$total_ot+$ot;
						$total_rechazo=$total_rechazo+$rechazo_dia;
					   }
			  echo '</tr>';		     	
	    }
		if ($opcion=='L')
		{ 
			echo '<tr class="ColorTabla01">';
			echo "<td align='center' colspan='4'><strong>Totales&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$produccion_total."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$seleccion_inicial_total."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$recuperado_total."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$rechazado_total."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_ne."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_nd."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_ra."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_cs."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_cl."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_qu."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_re."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_ai."&nbsp</strong></td>\n";
			echo "<td align='center'><strong>".$total_ot."&nbsp</strong></td>\n";
			echo '</tr>'; 
		}
	?>
  </table>
  <?php 
} 
else 
{ ?>     
 <?php           
		  $consulta_circuito="select * from sec_web.circuitos";  
		  $respuesta_circuito=mysqli_query($link, $consulta_circuito);
		  $produccion_total=0;
		  $seleccion_inicial_total=0;
		  $recuperado_total=0;
		  $rechazado_total=0;
		  while ($row_circuito=mysqli_fetch_array($respuesta_circuito))
			  {
					echo '<table width="753" border="2" cellspacing="2" align="center" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
					echo '<tr bgcolor="#FFFFFF" class="ColorTabla01">';
					if ($opcion=='P')
						{
							echo '<td colspan="7" align="center"><strong>'.$row_circuito["descripcion_circuito"].'</strong></td>';
						}
					else {echo '<td colspan="8" align="center"><strong>'.$row_circuito["descripcion_circuito"].'</strong></td>';}		
					echo '</tr>';
					echo '<tr bgcolor="#FFFFFF" class="ColorTabla01">';
					echo '<td width="96" rowspan="2" align="center"><strong>Fecha</strong><strong></strong></td>';
					echo '<td width="38" rowspan="2" align="center"><strong>Grupo</strong><strong></strong></td>';
					echo '<td colspan="2" align="center"><strong>Lado</strong></td>';
					if ($opcion=='P')
					   {
						echo '<td width="142" rowspan="2" align="center"><strong>Seleccion Inicial (%)</strong></td>';
						echo '<td width="140" rowspan="2" align="center"><strong>Recuperado (%)</strong></td>';
						echo '<td width="191" rowspan="2" align="center"><strong>Estandar (%)</strong></td>';
					   }
					else if ($opcion=='L')
					        { 
							 echo '<td width="142" rowspan="2" align="center"><strong>Produccion (Unid.)</strong></td>';
					          echo '<td width="142" rowspan="2" align="center"><strong>Seleccion Inicial (Unid.)</strong></td>';
						      echo '<td width="140" rowspan="2" align="center"><strong>Recuperado (Unid.)</strong></td>';
						      echo '<td width="191" rowspan="2" align="center"><strong>Estandar (Unid.)</strong></td>';
						    }  
					echo '</tr>';
					echo '<tr bgcolor="#FFFFFF" class="ColorTabla01">';
					echo '<td width="42" align="center"><strong>Mar</strong></td>';
					echo '<td width="43" align="center"><strong>Tierra</strong></td>';
					echo '</tr>';
					   $consulta="SELECT t1.fecha_produccion as fecha,t2.cod_circuito as circuito,t1.cod_grupo as grupo ";
					   $consulta.="from sec_web.produccion_catodo as t1 ";
					   $consulta.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
					   $consulta.="where t1.fecha_produccion BETWEEN '".$FechaInicio."' and '".$FechaTermino."' and t2.cod_circuito='".$row_circuito["cod_circuito"]."' ";
					   $consulta.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
					   $consulta.="GROUP by t1.fecha_produccion,t2.cod_circuito,t1.cod_grupo ";
					   $consulta.="ORDER by t1.fecha_produccion,t2.cod_grupo ";
					   $respuesta = mysqli_query($link, $consulta);
					   $produccion_total=0;
					   $seleccion_inicial_total=0;
					   $recuperado_total=0;
					   $rechazado_total=0;
					   while ($fila = mysqli_fetch_array($respuesta))
							 {
								echo "<tr>\n";
								echo "<td align='center' class=detalle01>".$fila["fecha"]."&nbsp</td>\n";
								echo "<td align='center' class=detalle02>".$fila["grupo"]."&nbsp</td>\n";
								/******************saca rechazos de tabla rechazo catodos de control de calidad*****************************************/
								$consulta2="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(otros) as ot, ";
								$consulta2.="sum(quemados) as qu,sum(redondos) as re,sum(aire) as ai ";
								$consulta2.="from cal_web.rechazo_catodos where fecha='".$fila["fecha"]."' and grupo='".$fila["grupo"]."'";
								$respuesta2= mysqli_query($link, $consulta2);
								$fila2 = mysqli_fetch_array($respuesta2);
								$suma_rechazo=$fila2["ne"]+$fila2["nd"]+$fila2["ra"]+$fila2["cs"]+$fila2["cl"]+$fila2["ot"]+$fila2["qu"]+$fila2["re"]+$fila2["ai"];
								/***********************************************************************************************************************/
								/******************obtiene datos del grupo electrolitico 2 **********************************************************/
								$consulta_max_fecha_ge="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo='".$fila["grupo"]."' and fecha<='".$fila["fecha"]."' ";
								$respuesta_max_fecha_ge= mysqli_query($link, $consulta_max_fecha_ge);
								$row_max_fecha_ge = mysqli_fetch_array($respuesta_max_fecha_ge);
								$consulta_det_grupo = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos,ifnull(hojas_madres,0) as hojas_madres  from ref_web.grupo_electrolitico2 ";
								$consulta_det_grupo = $consulta_det_grupo."where cod_grupo = '".$fila["grupo"]."' and  fecha = '".$row_max_fecha_ge["fecha"]."'";
								$respuesta_det_grupo = mysqli_query($link, $consulta_det_grupo);
								$row_det_grupo = mysqli_fetch_array($respuesta_det_grupo);
								/**********************************************************************************************************************/
								$divisor=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"];
								$divisor2=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"]-$row_det_grupo["hojas_madres"];
								$divisor2=$divisor2*$row_det_grupo["num_catodos"];
								if ($opcion=='P')
								   {
									if($divisor2>0){	
									$seleccion_inicial=(($suma_rechazo+$fila2["recuperado_tot"])/$divisor2)*100;
									$porc_recuperado=(($fila2["recuperado_tot"]/($divisor*$row_det_grupo["num_catodos"]))*100);
									$total_por_rechazado=(($suma_rechazo/($divisor*$row_det_grupo["num_catodos"]))*100);
									}else{
										$seleccion_inicial=0;
										$porc_recuperado=0;
										$total_por_rechazado=0; 
									}
								   }
								 else if ($opcion=='L')
								         {
										   $seleccion_inicial=$suma_rechazo+$fila2["recuperado_tot"];
									       $porc_recuperado=$fila2["recuperado_tot"];
									       $total_por_rechazado=$suma_rechazo;
										 }  	
								/************************************************************************/
								/*****************************************************************************/
								$arr_meses=array('Enero','Febrero_nor','Marzo','Abril','Mayo','Junio','Julio','Agosto','septiembre','Octubre','Noviembre','Diciembre');
								$arr_dias=array(31,28,31,30,31,30,31,31,30,31,30,31); 
								$ano_aux=intval(substr($fila["fecha"],0,4));
								$mes_aux=intval(substr($fila["fecha"],5,2));
								$calculo=$ano_aux/4;
								$calculo2=number_format($calculo,"0","","");
								$resto=$calculo2-$calculo;
								if ($resto==0)
									{$bisiesto='S';
									 $mes_dia=28;}
								else {$bisiesto='N';}
								$dia_aux=intval(substr($fila["fecha"],8,2));
								if ($dia_aux < 9)
								   { $restantes= 8-$dia_aux;
									 if ($mes_aux==1)
										{$mes_aux=strval(12);
										  $ano_aux=strval($ano_aux-1);
										  $dia_aux=$arr_dias[(intval($mes_aux))-1];
										  $dia_aux=strval($dia_aux-$restantes);}
									 else if (($mes_aux==3) and ($bisiesto=='N'))
											{$mes_aux=strval(2);
											 $dia_aux=$arr_dias[intval($mes_aux)-1];
											 $dia_aux=strval($dia_aux-$restantes);}
											else if (($mes_aux==3) and ($bisiesto=='S'))
												{$mes_aux=strval(2);
												  $dia_aux=strval($mes_dia-$restantes);} 	  
									 else{$mes_aux=strval(intval($mes_aux)-1);	
										  $dia_aux=$arr_dias[intval($mes_aux)-1];
										  $dia_aux=strval($dia_aux-$restantes);}
									}
								else{$dia_aux=strval($dia_aux-8);
									  $mes_aux=strval($mes_aux);
									  $ano_aux=strval($ano_aux);}		
								if (strlen($dia_aux)==1)
									{$dia_aux='0'.$dia_aux;}
								if (strlen($mes_aux)==1)
									{$mes_aux='0'.$mes_aux;}	
								
								$fecha_ant=$ano_aux."-".$mes_aux."-".$dia_aux;
								$cons_subp2="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
								$cons_subp2=$cons_subp2."where t1.tipo_movimiento='2' and t1.campo2='".$fila["grupo"]."' and t1.fecha_movimiento='".$fecha_ant."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
								//echo $cons_subp2;
								$Resp_subp2 = mysqli_query($link, $cons_subp2);
								$Fila_subp2 = mysqli_fetch_array($Resp_subp2);
								$cons_subp="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
								$cons_subp=$cons_subp."where t1.tipo_movimiento='2' and t1.campo2='".$fila["grupo"]."' and t1.fecha_movimiento='".$fila["fecha"]."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
								$Resp_subp = mysqli_query($link, $cons_subp);
								$Fila_subp = mysqli_fetch_array($Resp_subp);
								$producto= isset($Fila_subp["producto"])?$Fila_subp["producto"]:"";
								if ($producto==1)
									{
									if ($Fila_subp["campo1"]=='M' )
									   {
										 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
										 echo h."</td>\n";
										 if ($Fila_subp2["producto"]==1)
											{echo "<td align='center'>h&nbsp</td>\n";}
										 else if ($Fila_subp2["producto"]==4)
												 {echo "<td align='center'>V&nbsp</td>\n";}
											  else if ($Fila_subp2["producto"]==2)
													  {echo "<td align='center'>T&nbsp</td>\n";}
												   else if ($Fila_subp2["producto"]==3)
															{echo "<td align='center'>D&nbsp</td>\n";}
														else  {echo "<td align='center'>&nbsp</td>\n";}
									   }
									else if ($Fila_subp["campo1"]=='T' )
											{
											 if ($Fila_subp2["producto"]==1)
												{echo "<td align='center'>h&nbsp</td>\n";}
											else if ($Fila_subp2["producto"]==4)
													{echo "<td align='center'>V&nbsp</td>\n";}
												 else if ($Fila_subp2["producto"]==2)
														 {echo "<td align='center'>T&nbsp</td>\n";}
													  else if ($Fila_subp2["producto"]==3)
															{echo "<td align='center'>D&nbsp</td>\n";}
														  else  {echo "<td align='center'>&nbsp</td>\n";}
				
											 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
											 echo h."</td>\n";
											 
											}   	 
									}
									
								else if ($producto==4)
									{
									 if ($Fila_subp["campo1"]=='M' )
									   {
										  echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
										  echo V."</td>\n";
										  if ($Fila_subp2["producto"]==1)
												{echo "<td align='center'>h&nbsp</td>\n";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td align='center'>V&nbsp</td>\n";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td align='center'>T&nbsp</td>\n";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td align='center'>D&nbsp</td>\n";}
															else  {echo "<td align='center'>&nbsp</td>\n";}				
									   }
									 else if ($Fila_subp["campo1"]=='T' )
											{
											 if ($Fila_subp2["producto"]==1)
												{echo "<td align='center'>h&nbsp</td>\n";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td align='center'>V&nbsp</td>\n";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td align='center'>T&nbsp</td>\n";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td align='center'>D&nbsp</td>\n";}
															else  {echo "<td align='center'>&nbsp</td>\n";}				  					
											 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
											 echo V."</td>\n";				
											}
									
									}
								else if ($producto==2)
									{
									  if ($Fila_subp["campo1"]=='M' )
									   {
										echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
										echo T."</td>\n";
										if ($Fila_subp2["producto"]==1)
												{echo "<td align='center'>h&nbsp</td>\n";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td align='center'>V&nbsp</td>\n";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td align='center'>T&nbsp</td>\n";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td align='center'>D&nbsp</td>\n";}
															else  {echo "<td align='center'>&nbsp</td>\n";}				
									   }
									  else if ($Fila_subp["campo1"]=='T' )
											{
											  if ($Fila_subp2["producto"]==1)
												{echo "<td align='center'>h&nbsp</td>\n";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td align='center'>V&nbsp</td>\n";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td align='center'>T&nbsp</td>\n";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td align='center'>D&nbsp</td>\n";}
															else  {echo "<td align='center'>&nbsp</td>\n";}				
											echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
											echo T."</td>\n";
								
											} 
									}
								else if ($producto==3)
									{
									   if ($Fila_subp["campo1"]=='M' )
									   {
										 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
										 echo D."</td>\n";
										 if ($Fila_subp2["producto"]==1)
												{echo "<td align='center'>h&nbsp</td>\n";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td align='center'>V&nbsp</td>\n";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td align='center'>T&nbsp</td>\n";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td align='center'>D&nbsp</td>\n";}
															else  {echo "<td align='center'>&nbsp</td>\n";}				
									   }
									   else if ($Fila_subp["campo1"]=='T' )
											  {
												if ($Fila_subp2["producto"]==1)
												{echo "<td align='center'>h&nbsp</td>\n";}
												else if ($Fila_subp2["producto"]==4)
													 {echo "<td align='center'>V&nbsp</td>\n";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td align='center'>T&nbsp</td>\n";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td align='center'>D&nbsp</td>\n";}
															else  {echo "<td align='center'>&nbsp</td>\n";}				
												echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
												echo D."</td>\n";			
											  }  	 
									}
									else  {
										   echo "<td align='center'>&nbsp</td>\n";
										  
										  }
				
								/*******************************************************************************/
								/*******************************************************************************/
								if ($opcion=='P')
								    {
									  echo "<td align='center'>".number_format($seleccion_inicial,"2",".",",")."&nbsp</td>\n";
									  echo "<td align='center'>".number_format($porc_recuperado,"2",".",",")."&nbsp</td>\n";
									  echo "<td align='center'>".number_format($total_por_rechazado,"2",".",",")."&nbsp</td>\n";
									}
							    else if ($opcion=='L')
								        {
										 	echo "<td align='center'>".$divisor2."&nbsp</td>\n";
											$produccion_total=$produccion_total+$divisor2;
											echo "<td align='center'>".$seleccion_inicial."&nbsp</td>\n";
											$seleccion_inicial_total=$seleccion_inicial_total+$seleccion_inicial;
											echo "<td align='center'>".$porc_recuperado."&nbsp</td>\n";
											$recuperado_total=$recuperado_total+$porc_recuperado;
											echo "<td align='center'>".$total_por_rechazado."&nbsp</td>\n";
											$rechazado_total=$rechazado_total+$total_por_rechazado;
										}
												  
							 }
							 if ($opcion=='L')
								{ 
									echo '<tr class="ColorTabla01">';
									echo "<td align='center' colspan='4'><strong>Totales&nbsp</strong></td>\n";
									echo "<td align='center'><strong>".$produccion_total."&nbsp</strong></td>\n";
									echo "<td align='center'><strong>".$seleccion_inicial_total."&nbsp</strong></td>\n";
									echo "<td align='center'><strong>".$recuperado_total."&nbsp</strong></td>\n";
									echo "<td align='center'><strong>".$rechazado_total."&nbsp</strong></td>\n";
									echo '</tr>'; 
							   }
							
				  echo '</table>';
				  echo '<tr>';
				  echo '<td>&nbsp</td>';
				  echo '</tr>';
			 }		  
  }
  ?>
  
  
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html>
