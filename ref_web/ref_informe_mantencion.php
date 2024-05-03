<?php 
	include("../principal/conectar_ref_web.php"); 

	$CookieRut  = $_COOKIE["CookieRut"];
	$proceso     = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:""; 
	$opcion     = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:""; 
	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 

	if (strlen($DiaIni) ==1)
		$DiaIni = "0".$DiaIni;
	if (strlen($MesIni)==1)
		$MesIni = "0".$MesIni;
	if (strlen($DiaFin) == 1)
		$DiaFin = "0".$DiaFin;
	if (strlen($MesFin) == 1)
		$MesFin = "0".$MesFin;

 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	$si_auto = 0;
	//echo ".....".$CookieRut;
	$revisa_u="select usuario_auto as autori from ref_web.usuarios_autorizados where rut = '".$CookieRut."'";
	$res_u=mysqli_query($link, $revisa_u);
	if ($fila_u=mysqli_fetch_array($res_u))
	{
			$si_auto = $fila_u["autori"];
	}

?>
		
<HTML>
<HEAD>
      <TITLE> Informe Semanal Planta Tratamiento Electrolito</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
/**********/
function Recarga1()
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini.php?recargapag1=S";
	f.submit();
}
function Grabar(opt)
{	
	
	var f = document.frmPrincipal;
	var texto = 0;
	var Valores="";
	var Valores2="";
	var cuenta = 0;
	if (opt=="A")
	{
		var Vfin = f.num.value;
		for (i=0;i <Vfin;i++)
		{
			texto = f.atencion[i].value;
			texto = texto.substring(0,(texto.length));
			if (texto!='')
			{
				Valores=Valores+f.codigo[i].value+"%"+f.atencion[i].value+"~~";
				cuenta = cuenta + 1;
			}
			else
			{
				Valores2=Valores2+f.codigo[i].value+"~~";
			}
		 }
	}
	if (opt=="B")
	{
		var Vfin = f.num2.value;
		for (i=0;i <Vfin;i++)
		{
			texto = f.atencionHM[i].value;
			texto = texto.substring(0,(texto.length));
			if (texto!='')
			{
				Valores=Valores+f.codigoHM[i].value+"%"+f.atencionHM[i].value+"~~";
				cuenta = cuenta + 1;
			}
			else
			{
				Valores2=Valores2+f.codigoHM[i].value+"~~";
			}
		 }
	 }
	if (opt=="C")
	{
		var Vfin = f.num3.value;
		for (i=0;i <Vfin;i++)
		{
			texto = f.atencionPT[i].value;
			texto = texto.substring(0,(texto.length));
			if (texto!='')
			{
				Valores=Valores+f.codigoPT[i].value+"%"+f.atencionPT[i].value+"~~";
				cuenta = cuenta + 1;
			}
			else
			{
				Valores2=Valores2+f.codigoPT[i].value+"~~";
			}
		 }
	}
	//alert (Valores);
	//alert (Valores2);
	//alert (cuenta);
	if (cuenta > 0)
	{
		f.action = "graba_requerimiento.php?Valores="+ Valores+"&Proceso2=MM&Valores2="+Valores2;
		f.submit();
	}

}

function Proceso(f)
{
	var f = document.frmPrincipal;
	f.action = "ref_informe_mantencion.php?proceso=C";
	f.submit();
}
/**********/
function Modificar()
{
	var f = document.frmPrincipal;
	f.action = "desc_par01.php?proceso=M";
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<BODY background="../principal/imagenes/fondo3.gif" >
<FORM name="frmPrincipal" action="" method="post">
  <?php /*include("../principal/encabezado.php");*/ ?>
  
  <?php
?>
 
          
  <p align="center"><font color="#0000FF"><strong><H3 align="center">Informe de Mantenci�n</H3></strong></font></p>
          </div>
        <div align="left"> 
          
    <table width="980" border="0" align="center" cellpadding="3" class="TablaInterior">
      <tr> 
        <td width="95">Informe Desde</td>
        <td width="271"> <select name="DiaIni" style="width:50px;">
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
						{$Meses=array('Enero','Febrero','Marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
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
        <td width="63"> <div align="left">Hasta</div></td>
        <td width="489"> <div align="left"> 
            <select name="DiaFin" style="width:50px;">
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
            </select>
            <select name="MesFin" style="width:90px;">
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
            </select>
            <select name="AnoFin" style="width:60px;">
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
            <input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
			<input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">

          </div></td>
      </tr>
    </table>
          <font face="Arial, Helvetica, sans-serif"> </font></div></td>
    </tr>
    <tr> 
      <td height="88" align="center" bordercolor="#0000FF"><div align="left"> 
          
        <table width="980" height="36" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td height="13" colspan="1"><div align="center"><font color="#FFFFFF"><strong>JEFE 
                DE TURNO</strong></font></div>
              <div align="center"></div>
              <div align="center"></div></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="10%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>fecha</strong></div></td>
			<td width="6%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Turno</strong></div></td>
            <td width="42%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Novedad</strong></div></td>
			<td width="22%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Responsable</strong></div></td>
			<td width="5%"  height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Cond. Ins.</strong></div></td>
			<?php 
			if ($si_auto=='1')
			{ ?>
				<td width="20%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Comentarios 			<input name="btgr" type="button" style="width:30" value="O'K" onClick="Grabar('A')"> </strong></div></td>
         	<?php 
			}
			else
			{
			 ?>
				<td width="20%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Comentarios </strong></div></td>
		 	<?php
			} 
			?>
		  </tr>
        </table>
          <table width="980" align="center"border="1">
            <tr>
			<?php 
			   if ($proceso='C')
			     {
					$l=0;
					$consulta="select * from ref_web.novedades where fecha between '".$FechaInicio."' and '".$FechaTermino."' and mantencion='S'";
					$respuesta = mysqli_query($link, $consulta);
					while ($row= mysqli_fetch_array($respuesta))
					   {
					    $l++;
					    $codigo = $row["COD_NOVEDAD"];
						echo'<input name="codigo" type="hidden" id="codigo" value="'.$codigo.'">';
					    echo "<tr>";
						echo "<td width='10%' align='center' class=detalle01><font color='blue'>".$row["FECHA"]."&nbsp;</font></td>\n";
						echo "<td width='6%' align='center' class=detalle01><font color='blue'>".$row["TURNO"]."&nbsp;</font></td>\n";						
						echo "<td width='42%' align='left'>".strtoupper($row["NOVEDAD"])."&nbsp;</td>\n";
						
						echo "<td width='22%' align='left'>".strtoupper($row["usuario"])."&nbsp;</td>\n";
						if ($row["Condicion_insegura"]=='S')
							$condicion_insegura="SI";
						else
							$condicion_insegura ="NO";	
						
						echo "<td width='5%' align='center'>".$condicion_insegura."&nbsp;</td>\n";
						$consulta="select * from ref_web.requrimiento where cod_novedad = '".$codigo."'";
						$resp=mysqli_query($link, $consulta);
						 if ($filab=mysqli_fetch_array($resp))
						 {
						 	$atencion = $filab["atencion"];
						 }
						 else
						 {
						 	$atencion = "";
						 }
						echo "<td width='20%'><B><textarea name='atencion' align='left' cols='15' rows='2'>".strtoupper($atencion)."</textarea></B></td>\n";
						echo "</tr>";
					   }
					 /*tabla jefe hojas madres*/
					 echo '</table>';  
					 echo '<tr>';
					 echo '<td colspan="3">&nbsp;</td>';
					 echo '</tr>';  
					 echo '<table width="980" align="center" height="22"  border="0" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">';
					 echo '<tr class="ColorTabla01"> ';
            		 echo '<td height="11" colspan="1"><div align="center"><font color="#FFFFFF"><strong>JEFE DE HOJAS MADRES</strong></font></div><div align="center"></div><div align="center"></div></td>';
                     echo '</tr>';
					 echo '<tr class="ColorTabla01">'; 
					 echo '<td width="10%" height="22"><div align="center"><font color="#FFFFFF"><strong>fecha</strong></font></div></td>';
					 echo '<td width="6%" height="22"><div align="center"><font color="#FFFFFF"><strong>Turno</strong></font></div></td>';
					 echo '<td colspan="42%" align="center"><div align="center"><strong>Novedad</strong></div></td>';
					 echo '<td width="22%" align="center"><div align="center"><strong>Responsable</strong></div></td>';
					 echo '<td width="5%"  align="center"><div align="center"><strong>Cond. Ins.</strong></div></td>'; 				 			
					if ($si_auto=='1')
					{ ?>
						<td width="20%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Comentarios 			<input name="btgr" type="button" style="width:30" value="O'K" onClick="Grabar('A')"> </strong></div></td>
         			<?php 
					}
					else
					{
			 		?>
						<td width="20%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Comentarios </strong></div></td>
		 			<?php
					} 
					echo '</tr>';					 
					echo '</table>';
					echo '<table width="980" align="center" border="1">';
					$m=0;
					$consulta="select * from ref_web.novedades_jefe_hm where fecha between '".$FechaInicio."' and '".$FechaTermino."' and mantencion='S'";   
					$respuesta = mysqli_query($link, $consulta);
					while ($row= mysqli_fetch_array($respuesta))
					{
					    $m++;
					    $codigoHM = $row["COD_NOVEDAD"];
						echo'<input name="codigoHM" type="hidden" id="codigoHM" value="'.$codigoHM.'">';
					    echo "<tr>";
						echo "<td width='110%' align='center' class=detalle01><font color='blue'>".$row["FECHA"]."&nbsp;</font></td>\n";
						echo "<td width='6%' align='center' class=detalle01><font color='blue'>".$row["TURNO"]."&nbsp;</font></td>\n";						
						echo "<td width='42%' align='left'>".strtoupper($row["NOVEDAD"])."&nbsp;</td>\n";
						echo "<td width='22%' align='left'>".strtoupper($row["usuario"])."&nbsp;</td>\n";
						if ($row["Condicion_insegura"]=='S')
							$condicion_insegura="SI";
						else
							$condicion_insegura ="NO";	
						echo "<td width='5%' align='center'>".$condicion_insegura."&nbsp;</td>\n";
						$consulta2="select * from ref_web.requrimiento where cod_novedad = '".$codigoHM."'";
						$resp2=mysqli_query($link, $consulta2);
						 if ($filab=mysqli_fetch_array($resp))
						 {
						 	$atencionHM = $filab["atencion"];
						 }
						 else
						 {
						 	$atencionHM = "";
						 }

						echo "<td width='20%'><B><textarea name='atencionHM' align='left' cols='15' rows='2'>".strtoupper($atencionHM)."</textarea></B></td>\n";
						echo "</tr>";
					   }
					 /* fin tabla jefe hojas madres*/
					 /*tabla jefe PTE*/
					 echo '</table>';  
					 echo '<tr>';
					 echo '<td colspan="3">&nbsp;</td>';
					 echo '</tr>';  
					 echo '<table width="980" align="center" height="22" border="0" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">';
					 echo '<tr class="ColorTabla01"> ';
            		 echo '<td height="11" colspan="1"><div align="center"><font color="#FFFFFF"><strong>JEFE PTE</strong></font></div><div align="center"></div><div align="center"></div></td>';
                     echo '</tr>';
					 echo '<tr class="ColorTabla01">'; 
					 echo '<td width="10%" height="22"><div align="center"><font color="#FFFFFF"><strong>fecha</strong></font></div></td>';
					 echo '<td width="6%" height="22"><div align="center"><font color="#FFFFFF"><strong>Turno</strong></font></div></td>';					 
					 echo '<td colspan="42%" align="center"><div align="center"><strong>Novedad</strong></div></td>';
					 echo '<td width="22%" align="center"><div align="center"><strong>Responsable</strong></div></td>';
					 echo '<td width="5%"  align="center"><div align="center"><strong>Cond. Ins.</strong></div></td>';						
					if ($si_auto=='1')
					{ ?>
						<td width="20%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Comentarios 			<input name="btgr" type="button" style="width:30" value="O'K" onClick="Grabar('A')"> </strong></div></td>
         			<?php 
					}
					else
					{
			 		?>
						<td width="20%" height="11"> <div align="center"><font color="#FFFFFF"></font><strong>Comentarios </strong></div></td>
		 			<?php
					} 
					echo '</tr>';
					echo '</table>';
					echo '<table width="980" align="center" border="1">';
					$k=0;
					$consulta="select * from ref_web.novedades_jefe_pte where fecha between '".$FechaInicio."' and '".$FechaTermino."' and mantencion='S'";   
					$respuesta = mysqli_query($link, $consulta);
					while ($row= mysqli_fetch_array($respuesta))
					   {
					    $k++;
					    $codigoPT = $row["COD_NOVEDAD"];
						echo'<input name="codigoPT" type="hidden" id="codigoPT" value="'.$codigoPT.'">';
					    echo "<tr>";
						echo "<td width='15%' align='center' class=detalle01><font color='blue'>".$row["FECHA"]."&nbsp;</font></td>\n";
						echo "<td width='10%' align='center' class=detalle01><font color='blue'>".$row["TURNO"]."&nbsp;</font></td>\n";						
						echo "<td width='40%' align='left'>".strtoupper($row["NOVEDAD"])."&nbsp;</td>\n";
						echo "<td width='40%' align='left'>".strtoupper($row["usuario"])."&nbsp;</td>\n";
						if ($row["Condicion_insegura"]=='S')
							$condicion_insegura="SI";
						else
							$condicion_insegura ="NO";	
						echo "<td width='15%' align='center'>".$condicion_insegura."&nbsp;</td>\n";
						$busca="select * from ref_web.requrimiento where cod_novedad = '".$codigoPT."'";
						$resp3=mysqli_query($link, $busca);
						 if ($fil3=mysqli_fetch_array($resp3))
						 {
						 	$atencionPT = $fil3["atencion"];
						 }
						 else
						 {
						 	$atencionPT= "";
						 }
						echo "<td width='20%'><B><textarea name='atencionPT' align='left' cols='15' rows='2'>".strtoupper($atencionPT)."</textarea></B></td>\n"; 
						echo "</tr>";
					   }
					 /* fin tabla jefe PTE*/
				 }	
				$num = $l;
				echo'<input type="hidden" name="num" id="num" value="'.$num.'">';
				$num2 = $m;
				echo'<input type="hidden" name="num2" id="num2" value="'.$num2.'">';
				$num3 = $k;
				echo'<input type="hidden" name="num3" id="num3" value="'.$num3.'">';

			?>  
          </table>
		  
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
	<td height="30" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif"> 
          <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
          <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
          </font></div></td>
		  </tr>
    <tr> 
	  <td height="40" align="center" valign="middle"> <font face="Arial, Helvetica, sans-serif">&nbsp; 
        </font><br>

 <?php /*include("../principal/pie_pagina.php");*/ ?>
  <font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp; 
  </font> 
</FORM>
</BODY>
</HTML>
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	
	}
?>
