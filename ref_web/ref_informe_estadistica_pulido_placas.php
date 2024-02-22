<?php
	include("../principal/conectar_principal.php");
	
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Estadistica Pulido de Placas</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	//alert(opcion);
    if (f.opcion[0].checked)
	    {
		  f.action = "ref_informe_estadistica_pulido_placas.php?opcion=PN";
		}	
	else if (f.opcion[1].checked)
	        {
	         f.action = "ref_informe_estadistica_pulido_placas.php?opcion=PP";
	        }
			   
    f.submit();
}
function Buscar()
{
 var f = document.frmPrincipal;
 if (f.opcion[0].checked)
	    {
		  opcion="PN";
		  var correcto="S";
		}	
	else if (f.opcion[1].checked)
	        {
	         opcion="PP";
			 var correcto="S";
	        }
	else if (f.opcion[2].checked)
	        {
	         opcion="T";
			 var correcto="S";
			 //break;
	        }
	else {
	      alert("Debe seleccionar Tipo de Informe");
		  var correcto="N";
		 }
 if (correcto=='S')
    {		 				
	 f.action = "ref_informe_estadistica_pulido_placas.php?buscar=S"+"&opcion="+opcion;
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
function Excel(opcion,FechaInicio,FechaTermino)
{

 var f = document.frmPrincipal;
 if (f.opcion[0].checked)
	    {
		  opcion="PN";
		}	
	else if (f.opcion[1].checked)
	        {
	         opcion="PP";
	        }
	else if (f.opcion[2].checked)
	        {
	         opcion="T";
	        }		
 f.action = "ref_informe_estadistica_pulido_placas_xls.php?buscar=S"+"&opcion="+opcion+"&FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino;
 f.submit();
} 
function Grafico(opcion,FechaInicio,FechaTermino)
{
  var f = document.frmPrincipal;
  if (opcion !='T')
   {
    var URL ="../ref_web/ref_grafico_estadistica_pulido_placas.php?FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino+"&opcion="+opcion;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=750 scrollbars=no");
   }
  else{
       var URL ="../ref_web/ref_grafico_estadistica_pulido_placas_total.php?FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino+"&opcion="+opcion;
       window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=930 height=750 scrollbars=yes");
      } 

}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="6" class="ColorTabla01"><strong>INFORME ESTADISTICAS PULIDO 
        DE PLACAS</strong></td>
    </tr>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr> 
      <td width="132">Fecha Inicio:</td>
      <td colspan="2"><select name="DiaIni" style="width:50px;">
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
      <td width="97">Fecha Termino:</td>
      <td width="281"><select name="DiaFin" style="width:50px;">
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
        </select> </td>
    </tr>
    <tr align="center"> 
      <td height="10" colspan="5"> 
    <tr> 
      <td width="132" height="11">Placas Negras  
        <?php 
			if ($opcion=='PN')
		      {  ?>
                    <input type="radio" name="opcion" value="PN" checked></td>
      		<?php }
	         else { ?>
      				<input type="radio" name="opcion" value="PN"></td>
      <?php } ?>
      <td width="181"> Placas con Pernos 
        <?php 
			    if ($opcion=='PP')
			      {  ?>
        			<input type="radio" name="opcion" value="PP" checked></td>
      			<?php } 
	            else { ?>
      					<input type="radio" name="opcion" value="PP"></td>
      			  <?php }  ?>
		 
      <td width="181"> Ambos 
        <?php 
			    if ($opcion=='T')
			      {  ?>
        <input type="radio" name="opcion" value="T" checked></td>
      			<?php } 
	            else { ?>
      					<input type="radio" name="opcion" value="T"></td>
      			  <?php }  ?>		  
    </tr>
    <tr> 
      <td height="12">&nbsp;</td>
      <TD width="36" rowspan="2"><b> </b></TD>
      <TD width="181" colspan="1" rowspan="2"><input name="buscar" type="button" value="buscar" onClick="Buscar()" >
        <input name="grafico" type="button" value="Graficar" onClick="Grafico('<?php echo $opcion; ?>','<?php echo $FechaInicio; ?>','<?php echo $FechaTermino;?>')" ></TD>
      <td height="12">&nbsp; </td>
    </tr>
  </table>
  </td></p>
      <td colspan="2"></td></tr>
  </table>
  <table width="687" align="center">
    <?php 
    if (($buscar=='S') and (($opcion=='PP') or ($opcion=='PN')))
        {	   
		      echo '<tr align="center">';
			  echo '<td>';
			  echo '<table width="756" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
              echo '<tr class="ColorTabla01">';
			  if ($opcion=='PN')
			     {echo '<td colspan="9" align="center"><strong>Placas Negras</strong></td>';}
			  else if ($opcion='PP')
			          {echo '<td colspan="9" align="center"><strong>Placas con Pernos</strong></td>';}	 
              echo '</tr>';
			  echo '<tr class="ColorTabla01">';
			  echo '<td width="90" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
			  echo '<td colspan="3" align="center"><strong>Arman</strong><strong></strong></td>';
			  echo '<td colspan="3" align="center"><strong>Cambian</strong></td>';
			  echo '<td colspan="2" align="center"><strong>Stock</strong></td>';
			  echo '</tr>';
			  echo '<tr class="ColorTabla01"> ';
			  echo '<td width="44" align="center"><strong>Turno A</strong></td>';
			  echo '<td width="48" align="center"><strong>Turno B</strong></td>';
			  echo '<td width="55" align="center"><strong>Total</strong></td>';
			  echo '<td width="62" align="center"><strong>Turno A</strong></td>';
			  echo '<td width="70" align="center"><strong>Turno B</strong></td>';
			  echo '<td width="70" align="center"><strong>Total</strong></td>';
			  echo '<td width="101" align="center"><strong>Turno A</strong></td>';
			  echo '<td width="107" align="center"><strong>Turno B</strong></td>';
			  echo '</tr>';
			  if ($opcion=='PN')
			     {
				   $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
                   $respuesta=mysqli_query($link, $consulta);
				   while ($row=mysqli_fetch_array($respuesta))
				        {
						 echo '<tr>';
						 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
					     $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;
						 $total_cambian=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
							     echo '<td align="center">'.$row_placas[placas_negras].'</td>';
								 $total_arman=$total_arman+$row_placas[placas_negras];
							   }
						 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
						 $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas[placas_negras].'</td>';
								 $total_cambian=$total_cambian+$row_placas[placas_negras];
						       }
						 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
						  $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas[placas_negras].'</td>';
						       }
						
						}
							
				   
				 }
			  else if ($opcion=='PP')
			          {
					    $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
					    $respuesta=mysqli_query($link, $consulta);
					    while ($row=mysqli_fetch_array($respuesta))
							{
							 echo '<tr>';
							 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;
							 $total_cambian=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas[placas_pernos].'</td>';
									 $total_arman=$total_arman+$row_placas[placas_pernos];
								   }
							 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas[placas_pernos].'</td>';
									 $total_cambian=$total_cambian+$row_placas[placas_pernos];
								   }
							 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
							  $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas[placas_pernos].'</td>';
								   }
							
						}
				} 
    	    }
		 else if ($opcion=='T')
		         { 
				  echo '<tr align="center">';
				  echo '<td>';
				  echo '<table width="756" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
				  echo '<tr class="ColorTabla01">';
				  echo '<td colspan="9" align="center"><strong>Placas Negras</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">';
				  echo '<td width="90" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Arman</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Cambian</strong></td>';
				  echo '<td colspan="2" align="center"><strong>Stock</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">';
				  echo '<td width="44" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="48" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="55" align="center"><strong>Total</strong></td>';
				  echo '<td width="62" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="70" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="70" align="center"><strong>Total</strong></td>';
				  echo '<td width="101" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="107" align="center"><strong>Turno B</strong></td>';
				  echo '</tr>';
				  				   $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
                   $respuesta=mysqli_query($link, $consulta);
				   while ($row=mysqli_fetch_array($respuesta))
				        {
						 echo '<tr>';
						 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
					     $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;
						 $total_cambian=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
							     echo '<td align="center">'.$row_placas[placas_negras].'</td>';
								 $total_arman=$total_arman+$row_placas[placas_negras];
							   }
						 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
						 $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas[placas_negras].'</td>';
								 $total_cambian=$total_cambian+$row_placas[placas_negras];
						       }
						 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
						  $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas[placas_negras].'</td>';
						       }
						
						}

                  echo '</table>';
				  echo '<tr align="center">';
				  echo '<td>&nbsp;</td>';
				  echo '</tr>';
				  echo '<table width="756" border="2" align="center" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
				  echo '<tr class="ColorTabla01">'; 
				  echo '<td colspan="9" align="center"><strong>Placas con Pernos</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">'; 
				  echo '<td width="90" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Arman</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Cambian</strong></td>';
				  echo '<td colspan="2" align="center"><strong>Stock</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">'; 
				  echo '<td width="44" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="48" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="55" align="center"><strong>Total</strong></td>';
				  echo '<td width="62" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="70" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="70" align="center"><strong>Total</strong></td>';
				  echo '<td width="101" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="107" align="center"><strong>Turno B</strong></td>';
				  echo '</tr>';
				   $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
					    $respuesta=mysqli_query($link, $consulta);
					    while ($row=mysqli_fetch_array($respuesta))
							{
							 echo '<tr>';
							 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;
							 $total_cambian=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas[placas_pernos].'</td>';
									 $total_arman=$total_arman+$row_placas[placas_pernos];
								   }
							 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas[placas_pernos].'</td>';
									 $total_cambian=$total_cambian+$row_placas[placas_pernos];
								   }
							 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
							  $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas[placas_pernos].'</td>';
								   }
							}	   
				  echo '</table>';
         }		  
 ?>
      
      <p>&nbsp;</p>
      <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel('<?php echo $opcion; ?>','<?php echo $FechaInicio; ?>','<?php echo $FechaTermino;?>')"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html>
