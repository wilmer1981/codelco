<?php
	include("../principal/conectar_principal.php");
	$CookieRut  = $_COOKIE["CookieRut"];
	$limpiar     = isset($_REQUEST["limpiar"])?$_REQUEST["limpiar"]:""; 
	$cmbcircuito     = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
	$mostrar     = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:""; 
	$recarga     = isset($_REQUEST["recarga"])?$_REQUEST["recarga"]:""; 
	$Buscar      = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 


	function concatena_observacion($fecha,$cod_grupo,$link)
	  {
	    $observacion='';
	    $consulta="select * from ref_web.observaciones where fecha='".$fecha."' and cod_grupo='".$cod_grupo."'";
		//echo $consulta;
	    $respuesta=mysqli_query($link, $consulta);
		$row_obs = mysqli_fetch_array($respuesta);
		$observacion='Deposito:';
		if ($row_obs["normal"]<>'0')
		   {$observacion=$observacion.$row_obs["normal"].',';}
	    if ($row_obs["rayado"]<>'0')
		   {$observacion=$observacion.$row_obs["rayado"].',';}		
	    if ($row_obs["cristalizado"]<>'0')
		   {$observacion=$observacion.$row_obs["cristalizado"].',';}
	    if ($row_obs["granulado"]<>'0')
		   {$observacion=$observacion.$row_obs["granulado"].',';}
	    if ($row_obs["c_barro"]<>'0')
		   {$observacion=$observacion.$row_obs["c_barro"].',';}
	    if ($row_obs["cordon"]<>'0')
		   {$observacion=$observacion.$row_obs["cordon"].',';}
	    if ($row_obs["rigido"]<>'0')
		   {$observacion=$observacion.$row_obs["rigido"];}
											
											
		$observacion=$observacion.chr(13);
		$observacion=$observacion.'Tipo Corte:';									
		
	    if ($row_obs["abierto"]<>'0')
		   {$observacion=$observacion.$row_obs["abierto"].',';}
        if ($row_obs["abierto_c_barro"]<>'0')
		   {$observacion=$observacion.$row_obs["abierto_c_barro"].',';}
		if ($row_obs["cerrado"]<>'0')
		   {$observacion=$observacion.$row_obs["cerrado"].',';}											  											  
		if ($row_obs["cristalizado2"]<>'0')
		   {$observacion=$observacion.$row_obs["cristalizado2"].',';}
		if ($row_obs["puntual"]<>'0')
		   {$observacion=$observacion.$row_obs["puntual"].',';}
		if ($row_obs["extendido"]<>'0')
		   {$observacion=$observacion.$row_obs["extendido"].',';}
		if ($row_obs["fino"]<>'0')
		   {$observacion=$observacion.$row_obs["fino"];}
       	
		$observacion=$observacion.chr(13);
		$observacion=$observacion.'Ubicacion:';
		
		if ($row_obs["estampa"]<>'0')
		   {$observacion=$observacion.$row_obs["estampa"].',';}
        if ($row_obs["dispersa"]<>'0')
		   {$observacion=$observacion.$row_obs["dispersa"].',';}
		if ($row_obs["remache"]<>'0')
		   {$observacion=$observacion.$row_obs["remache"].',';}											  											  
		if ($row_obs["oreja"]<>'0')
		   {$observacion=$observacion.$row_obs["oreja"].',';}
		if ($row_obs["superior"]<>'0')
		   {$observacion=$observacion.$row_obs["superior"].',';}
		if ($row_obs["inferior"]<>'0')
		   {$observacion=$observacion.$row_obs["inferior"].',';}
		if ($row_obs["lateral"]<>'0')
		   {$observacion=$observacion.$row_obs["lateral"];}									
									  	 											
		return $observacion;																			  
	  }
	
	
	
	if ($limpiar!='N') 
	{
	    $limpiar="delete from ref_web.leyes";
	    mysqli_query($link, $limpiar);
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
<title>Informe de Cortocircuitos</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	  // {f.action = "cortes2_aux.php?recarga=S"+"&dia1="+f.dia1.value+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&circuito="+f.cmbcircuito.value+"&mostrar=S&Buscar=N";}
	   {
		f.action = "ref_informe_cortos2.php?mostrar=S"+"&cmbcircuito="+f.cmbcircuito.value+"&recarga=S"+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value;}
	f.submit();
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
	
	var URL ="../ref_web/ref_grafico_cortos.php?fecha1="+fecha1+"&fecha2="+fecha2+"&circuito="+f.cmbcircuito.value;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=650 scrollbars=no");
}	
function Excel(f)

{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	document.location = "../ref_web/ref_informe_cortos2_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value+"&circuito="+f.cmbcircuito.value+"&mostrar=S";
}
function Globales()
{
	var f=document.frmPrincipal;
	var FechaInicio=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var FechaTermino=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;

	var URL ="ref_globales_cortocircuitos.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value+"&cmbcircuito="+f.cmbcircuito.value;
    window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=780 height=500 scrollbars=yes");
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" > 
      <td colspan="4" class="ColorTabla01"><strong>INFORME CORTOCIRCUITOS</strong></td>
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
            <td width="355" height="41" rowspan="2">Circuito 
              <select name="cmbcircuito" id="select3"  onChange="Recarga1('S')">
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
				
			?>
              </select> <input name="buscar" type="button" value="buscar" onClick="Recarga1('S')" > 
            </td>
            <td width="373"><input name="graficar" type="button" value="Grafico" onClick="Grafico(this.form)" >
              <input name="globales" type="button" value="Globales" onClick="Globales(this.form)" >
            </td>
          </tr>
          <tr>
            <td height="14"><strong>R: En Renovacion</strong></td>
          </tr>
        </table>
	  </p>
        <table width="239" border="0" align="center" cellpadding="2">
          <tr>
            <td width="231"> 
              <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)">
              <input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)">
              <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
          </tr>
        </table>
</td>
  </tr>
</table>
<table width="955" align="center">
 <?php $consulta="select distinct cod_grupo from ref_web.grupo_electrolitico2 where cod_circuito='".$cmbcircuito."' order by cod_grupo";
	$rs = mysqli_query($link, $consulta);
	$cont=0;
	while ($row = mysqli_fetch_array($rs))
	    {
		  if ($cont==4)
		   {echo '<tr>';}
		  echo '<td>';
		  echo '<table width="200" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
          echo '<tr bgcolor="#FFFFFF" class="ColorTabla01">'; 
          echo '<td colspan="4" align="center"><strong>Grupo '.$row["cod_grupo"].'</strong></td>';
          echo '</tr>';
          echo '<tr bgcolor="#FFFFFF" class="ColorTabla01"> ';
		  echo '<td width="200" align="center"><strong>Fecha</strong><strong></strong></td>';
          echo '<td width="20" align="center"><strong>Dias</strong><strong></strong></td>';
          echo '<td width="20" align="center">Anodo Nuevo</td>';
          echo '<td width="20" align="center">Semi Anodo</td>';
          echo '</tr>';
		  $consulta_cortos="select cortos_nuevo, cortos_semi, cont_dia, fecha from ref_web.cortocircuitos where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."' and cod_circuito='".$cmbcircuito."' and cod_grupo='".$row["cod_grupo"]."'";
		  $respuesta_cortos = mysqli_query($link, $consulta_cortos);
	 	  while ($row_cortos = mysqli_fetch_array($respuesta_cortos))
		        { 
				  //$obs=concatena_observacion($row_cortos["fecha"],row["cod_grupo"]);
				?>
				  <tr onMouseOver="if(!this.contains(event.fromElement)){this.bgColor='class=ColorTabla02';} if(!document.all){style.cursor='pointer'};style.cursor='hand';" onMouseOut="if(!this.contains(event.toElement)){this.bgColor=''; }" title="<?php echo concatena_observacion($row_cortos["fecha"],$row["cod_grupo"],$link); ?>">
				 <?php echo '<td width="257" align="center">'.$row_cortos["fecha"].'</td>';
				  if ($row_cortos["cont_dia"]==0)
				      {
					   echo '<td width="20" align="center" class=detalle02>R</td>';
					  }
				  else {
				        echo '<td width="20" align="center" class=detalle01>'.$row_cortos["cont_dia"].'</td>';
					   }	
				  echo '<td width="20" align="center">'.$row_cortos["cortos_nuevo"].'</td>';
				  echo '<td width="20" align="center">'.$row_cortos["cortos_semi"].'</td>';
				  echo '</tr>';
				}  
		  $cont++;
          echo '</table>';
          echo '</td>';
		}       
 ?> 
</table>
</form>
</body>
</html>
