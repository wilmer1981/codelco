<?php include("../principal/conectar_ref_web.php"); 
	include("../principal/conectar_principal.php"); 
	if(!isset($FechaInicio))
		$FechaInicio=date('Y-m-d');
	if(!isset($FechaTermino))
		$FechaTermino=date('Y-m-d');
		
		if ($Mostrar <> 'S')
		{
			$dia = 01;
			$FechaInicio  =substr($FechaInicio,0,8)."01";
		}

	if ($opcion == "M" || $opcion =="E")   
	{
		//echo "FECHA".$opcion."--".$FechaInicio1."--".$FechaTermino1."---".$cmbgrua;
		$FechaInicio = $FechaInicio1;
		$FechaTermino= $FechaTermino1;
	}
?>
<HTML>
<HEAD>
<TITLE>Grúas Nave Electrolitica</TITLE>
<script language="JavaScript">



function Recarga()
{
	var f=document.FrmPrincipal;
	var numgrua = "";
	numgrua=(f.cmbgrua.value);
 	f.action="principal_gruas.php?Mostrar=S&numgrua="+numgrua;
 	f.submit();
}

function Modificar(cmbgrua,fecha_grua,turno,FechaInicio,FechaTermino)
{
   var f = document.FrmPrincipal;
 //  alert (FechaInicio);
   //alert (FechaTermino);
   f.action = "Ingreso_gruas.php?cod_grua=" + cmbgrua+"&fecha_grua="+fecha_grua+"&turno="+turno+"&FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino+"&opcion=M";
   f.submit();
}
function Imprimir()
{
	window.print();
}


function Procesoxx(opt)
{
	   var f = document.FrmPrincipal;
	switch (opt)
	{
		case "C":
			//f.action ="sec_con_inf_despacho_diario_poly.php";
			f.action ="principal_gruas.php?Mostrar=S";
			f.submit();
			break;
	}
}	


function Eliminar(cmbgrua,fecha_grua,turno,FechaInicio,FechaTermino)
{
	var f = document.FrmPrincipal;
	if (confirm("Esta Seguro que Desea Eliminar Información"))
	{
	   f.action = "ingreso_gruas02.php?cod_grua=" + cmbgrua+"&fecha_grua="+fecha_grua+"&turno="+turno+"&FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino+"&opcion=E";
	  f.submit();
	} 
	else 
	{
	 return;
	 }

}
</script>
<LINK href="estilos/css_sea_web.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<BODY>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>


<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="Proceso" value="E">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
  <TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm dyl">
    <TR vAlign=top  class=dt> 
      <TD width="90%"  colSpan="5" vAlign=bottom> <H4><B>GRUAS NAVE ELECTROLITICA</B></H4></TD>
      <TD width="10%" ><div align="right"><a href="JavaScript:Imprimir()"><img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>
    </TR>
    <TR vAlign=top  class=dt> 
      <TD colSpan="6"  width="100%" align="center" vAlign=bottom><div align="left"><strong>GRUAS: 
          <select name="cmbgrua"  size="1" id="cmbgrua" onChange="Recarga();">
            <option value="x" selected>Seleccionar</option>
            <?php
					$Consulta = "SELECT nombre_subclase as gruas FROM proyecto_modernizacion.sub_clase where cod_clase = 10004 ";
					$Consulta.= "and cod_subclase >= 1 and cod_subclase < 20  ORDER BY cod_subclase";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($cmbgrua==$Row[gruas])
							echo "<option value='".$Row[gruas]."' selected>".$Row[gruas]."</option>";
						else
							echo "<option value='".$Row[gruas]."'>".$Row[gruas]."</option>";
		    		}
					//$var1=$Mostrar;
        			?>
          </select>
       
          Fecha Inicio: 
          <input name="FechaInicio" type="text" class="InputCen" value="<?php echo $FechaInicio; ?>" size="15" maxlength="10" readonly>
          <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(FechaInicio,FechaInicio,popCal);return false"> 
          Fecha Termino:
		  
		  
         <input name="FechaTermino" type="text" class="InputCen" id="FechaTermino" value="<?php echo $FechaTermino; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(FechaTermino,FechaTermino,popCal);return false"> 

		   
          <input name="txt_buscar" type="button" onClick="JavaScript:Procesoxx('C')" value='Buscar'>
          </strong></div></TD>
    </TR>
    <TR vAlign=top> 
      <TD  colSpan=6 bgcolor="#FFCC00"> <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
          <TR class=lcolam> </TR>
          <TR class=lcolam> 
            <TD align="center"><font color="#0000CC"><b>FECHA</b></font></TD>
            <TD align="center"><font color="#0000CC"><b>TURNO</b></font></TD>
            <TD align="center"><font color="#0000CC"><b>AREA MANTECIÓN</b></font></TD>
            <TD align="center"><font color="#0000CC"><b>ESTADO</b></font></TD>
            <TD align="center"><font color="#0000CC"><b>CON.INSEG.</b></font></TD>
            <TD align="center"><font color="#0000CC"><b>OBSERVACIÓN</b></font></TD>
			<TD align="center"><font color="#0000CC"><b></b></font></TD>
			<TD align="center"><font color="#0000CC"><b></b></font></TD>
          </TR>
		  <?php
				$FechaInicio2= $FechaInicio;
				$consulta = "select * from ref_web.historia_gruas where fecha  between ";
				if ($Mostrar <> 'S')
					$consulta.= " '".$FechaInicio."' and '".$FechaTermino."' ";
				else
					$consulta.= " '".$FechaInicio2."'  and '".$FechaTermino."' ";
				$consulta.= " and cod_grua = '".$cmbgrua."' ";
				//echo "CC".$consulta;
				$Respuesta = mysqli_query($link, $consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{ 
					echo'<TR class=lcol> '; 
					//echo "<tr>\n";
					$fecha = $Fila["fecha"];
					$turno =$Fila["turno"];
					//aqui buscar novedades
					$consulta ="select t1.COD_NOVEDAD,t1.NOVEDAD,t1.usuario,T1.TURNO, t2.valor_subclase1 ";
                	$consulta .="from ref_web.novedades as t1 ";
                 	$consulta .="inner join proyecto_modernizacion.sub_clase as t2 "; 
                 	$consulta .="on t1.TURNO=t2.nombre_subclase and t2.cod_clase = '1' ";
                 	$consulta .="WHERE fecha = '".$fecha."' and mantencion not in ('S')"; 
				    $consulta .="ORDER BY t1.turno,t1.FECHA ASC ";	

					
					
					
					echo "<td align='center'>".$Fila["fecha"].           "</td>\n";
					echo "<td align='center'>".$Fila["turno"].           "</td>\n";
					echo "<td align='center'>".$Fila["area_mantencion"]. "</td>\n";
					echo "<td align='center'>".$Fila["estado"].          "</td>\n";
					echo "<td align='center'>".$Fila["condicion"].       "</td>\n";
					echo "<td align='center'>".$Fila["observacion"].     "</td>\n";
					echo'<TD width="5%" ><div align="center">';
					echo "<a href=\"JavaScript:Eliminar('$cmbgrua','$Fila["fecha"]','$turno','$FechaInicio','$FechaTermino')\">";
					echo '<img src="archivos/papelera.gif" alt="Pulse Aqui Para Eliminar Datos" width="16" height="16" border="0" align="absmiddle"   width="12" height="12"> </A></div></TD>';
					echo'<TD width="10%" ><div align="center">';
					echo "<a href=\"JavaScript:Modificar('$cmbgrua','$Fila["fecha"]','$turno','$FechaInicio','$FechaTermino')\">";
					echo '<img src="archivos/modificar.gif" alt="Pulse Aqui Para Modificar Datos" width="16" height="16" border="0" align="absmiddle"   width="12" height="12"> </A></div></TD>';
					echo "</tr>\n";
				}
		  ?>
        </TABLE></TD>
    </TR>
  </TABLE>
</FORM>
</BODY>
</HTML>
