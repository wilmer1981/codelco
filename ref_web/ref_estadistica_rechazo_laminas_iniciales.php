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
<title>Informe Rechazo Laminas Iniciales</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	   {f.action = "ref_estadistica_rechazo_laminas_iniciales.php?cmbgrupo="+f.cmbgrupo.value+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value;}
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
	
	var URL ="ref_grafico_rechazo_lam_iniciales.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value+"&cmbgrupo="+f.cmbgrupo.value;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=650 scrollbars=no");
}	
function Excel(f)

{
	document.location = "ref_estadistica_rechazo_laminas_iniciales_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value+"&cmbgrupo="+f.cmbgrupo.value+"&mostrar=S";
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

	var URL ="ref_global_rechazo_laminas_iniciales.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value;
    window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=700 height=200 scrollbars=yes");
}
function Recuperado() 
{
 var f=document.frmPrincipal;
 window.open("ref_recuperado_laminas_iniciales.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" > 
      <td colspan="4" class="ColorTabla01"><strong>INFORME DE RECHAZO LAMINAS 
        INICIALES </strong></td>
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
            <td width="355" height="41"> Grupo 
              <select name="cmbgrupo" id="select3" >
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT distinct cod_grupo from ref_web.grupo_electrolitico2 where hojas_madres<>'0' ";
				$consulta.= " ORDER BY cod_grupo";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if  ($row["cod_grupo"] == $cmbgrupo)
						echo '<option value="'.$row["cod_grupo"].'" selected>Grupo '.$row["cod_grupo"].'</option>';
					else 
						echo '<option value="'.$row["cod_grupo"].'">Grupo '.$row["cod_grupo"].'</option>';
				}			
				
			    if ($cmbgrupo=='99') 
				    { ?>
                <option value="99" selected>Todos</option>
                <?php } 
				    else {?>
                <option value="99">Todos</option>
                <?php }?>
              </select> <input name="buscar" type="button" value="buscar" onClick="Recarga1('S')" > 
            </td>
            <td width="373"><input name="globales2" type="button" value="Recuperado" onClick="Recuperado(this.form)" > 
              <input name="globales" type="button" value="Globales" onClick="Globales(this.form)" > 
              <input name="graficar" type="button" value="Grafico" onClick="Grafico(this.form)" ></td>
          </tr>
        </table>
	    <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)"> 
              <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
              <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
          </tr>
        </table>
        </p>
        </td>
  </tr>
</table>
<?php if ($cmbgrupo<>'99')
   {?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <table width="753" border="2" cellspacing="2" align="center" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="117" align="center"><strong>Grupo <?php echo $cmbgrupo; ?></strong></td>
      <td colspan="5" align="center"><div align="center"><strong>Rechazo</strong></div></td>
    </tr>
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td align="center"><div align="center"><strong>Fecha</strong></div></td>
      <td width="69" align="center"><div align="center"><strong>Delgadas</strong></div></td>
      <td width="82" align="center"><div align="center"><strong>Granuladas</strong></div></td>
      <td width="75" align="center"><div align="center"><strong>Gruesas</strong></div></td>
      <td width="65" align="center"><div align="center"><strong>Total</strong></div></td>
      <td width="85" align="center"><div align="center"><strong>%</strong></div></td>
    </tr>
    <?php
	   $cmbgrupo=intval($cmbgrupo);
	   $consulta="select * from ref_web.produccion where cod_grupo='".$cmbgrupo."' and fecha between '".$FechaInicio."' and '".$FechaTermino."'";
	   $respuesta=mysqli_query($link, $consulta);
	   while ($row=mysqli_fetch_array($respuesta))
	      {
		   echo "<tr>\n";
		   echo "<td align='center' class=detalle01>".$row["fecha"]."&nbsp</td>\n";
		   echo "<td align='center'>".$row[rechazo_delgadas]."&nbsp</td>\n";
		   echo "<td align='center'>".$row[rechazo_granuladas]."&nbsp</td>\n";
		   echo "<td align='center'>".$row[rechazo_gruesas]."&nbsp</td>\n";
		   $total_rechazo=$row[rechazo_delgadas]+$row[rechazo_granuladas]+$row[rechazo_gruesas];
		   echo "<td align='center'>".$total_rechazo."&nbsp</td>\n";
		   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <=  '".$row["fecha"]."' and cod_grupo ='0".$cmbgrupo."' group by cod_grupo";
		   $respuesta_fecha = mysqli_query($link, $consulta_fecha);
		   $row_fecha = mysqli_fetch_array($respuesta_fecha);
		   $consulta_datos_grupo =  "select max(fecha) as fecha,cod_grupo,cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
		   $consulta_datos_grupo.= " where fecha = '".$row_fecha["fecha"]."' and cod_grupo ='0".$cmbgrupo."' group by cod_grupo ";
		   $respuesta_datos_grupo = mysqli_query($link, $consulta_datos_grupo);
	   	   $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
		   $produccion=(($row_datos_grupo["hojas_madres"]*$row_datos_grupo[num_catodos_celdas])*2);
		   $porcentaje_rechazado=number_format(($total_rechazo/$produccion)*100,"2",".",".");
		   echo "<td align='center'>".$porcentaje_rechazado."&nbsp</td>\n";
		  
		  }
	?>
  </table>
  <?php } 
  else { ?>
  <?php 
		  $consulta_grupo="select distinct cod_grupo from ref_web.grupo_electrolitico2 where hojas_madres<>'0' order by cod_grupo";
		  $respuesta_grupo=mysqli_query($link, $consulta_grupo);
		  while ($row_grupo=mysqli_fetch_array($respuesta_grupo))
			  {
			     
				     echo '<tr>';
					 echo '<td>&nbsp;</td>';
					 echo '</tr>';
					 echo '<table width="753" border="2" cellspacing="2" align="center" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
					 echo '<tr bgcolor="#FFFFFF" class="ColorTabla01"> ';
					 echo '<td width="117" align="center"><strong>Grupo '.$row_grupo["cod_grupo"].'</strong></td>';
					 echo '<td colspan="5" align="center"><strong>Rechazo</strong></td>';
					 echo '</tr>';
					 echo '<tr bgcolor="#FFFFFF" class="ColorTabla01"> ';
					 echo ' <td align="center"><strong>Fecha</strong></td>';
					 echo '<td width="69" align="center"><strong>Delgadas</strong></td>';
					 echo '<td width="82" align="center"><strong>Granuladas</strong></td>';
					 echo '<td width="75" align="center"><strong>Gruesas</strong></td>';
					 echo '<td width="65" align="center"><strong>Total</strong></td>';
					 echo '<td width="85" align="center"><strong>%</strong></td>';
					 echo '</tr>';
					 $row_grupo["cod_grupo"]=intval($row_grupo["cod_grupo"]);
					 $consulta="select * from ref_web.produccion where cod_grupo='".$row_grupo["cod_grupo"]."' and fecha between '".$FechaInicio."' and '".$FechaTermino."'";
					 $respuesta=mysqli_query($link, $consulta);
 				     while ($row=mysqli_fetch_array($respuesta))
						  {
						   echo "<tr>\n";
						   echo "<td align='center' class=detalle01>".$row["fecha"]."&nbsp</td>\n";
						   echo "<td align='center'>".$row[rechazo_delgadas]."&nbsp</td>\n";
						   echo "<td align='center'>".$row[rechazo_granuladas]."&nbsp</td>\n";
						   echo "<td align='center'>".$row[rechazo_gruesas]."&nbsp</td>\n";
						   $total_rechazo=$row[rechazo_delgadas]+$row[rechazo_granuladas]+$row[rechazo_gruesas];
						   echo "<td align='center'>".$total_rechazo."&nbsp</td>\n";
						   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <=  '".$row["fecha"]."' and cod_grupo ='0".$row_grupo["cod_grupo"]."' group by cod_grupo";
						   $respuesta_fecha = mysqli_query($link, $consulta_fecha);
						   $row_fecha = mysqli_fetch_array($respuesta_fecha);
						   $consulta_datos_grupo =  "select max(fecha) as fecha,cod_grupo,cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
						   $consulta_datos_grupo.= " where fecha = '".$row_fecha["fecha"]."' and cod_grupo ='0".$row_grupo["cod_grupo"]."' group by cod_grupo ";
						   $respuesta_datos_grupo = mysqli_query($link, $consulta_datos_grupo);
						   $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
						   $produccion=(($row_datos_grupo["hojas_madres"]*$row_datos_grupo[num_catodos_celdas])*2);
						   $porcentaje_rechazado=number_format(($total_rechazo/$produccion)*100,"2",".",".");
						   echo "<td align='center'>".$porcentaje_rechazado."&nbsp</td>\n";
						   
						 }
					 echo '</table>';
					 echo '<tr>';
					 echo '<td>&nbsp;</td>';
					 echo '</tr>';
			 }
  }
  ?>
</form>
</body>
</html>
