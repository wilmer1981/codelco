<?php include("../principal/conectar_ref_web.php"); 
function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4)."  ".substr($f,11,2).":".substr($f,14,2);
		return $fecha;
	}
$fecha=ltrim($fecha);	
$ano1=substr($fecha,0,4);
$mes1=substr($fecha,5,2);
$dia1=substr($fecha,8,2);		
?>


<html>
<head>
<title>Conexiones y Desconexiones</title>
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Eliminar(fecha,cod_grupo,tipo_desconexion,fecha_desconexion)
{
	var f = document.FrmPrincipal;
	if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
     f.action = "sec_ing_estadistica_cortes_proceso01_ref.php?fecha="+fecha+"&cod_grupo="+cod_grupo+"&tipo_desconexion="+tipo_desconexion+"&fecha_desconexion="+fecha_desconexion+"&proceso=E";
	 f.submit();
	} 
}
function Modificar(fecha,cod_grupo,tipo_desconexion,fecha_desconexion)
{
    var f = document.FrmPrincipal;
    f.action = "sec_ing_estadistica_cortes_proceso_ref.php?fecha="+fecha+"&grupo="+cod_grupo+"&tipo_desconexion="+tipo_desconexion+"&fecha_desconexion="+fecha_desconexion+"&opcion=M";
	f.submit();
}	
function Imprimir()
{
	window.print();
}
//-->
</script>


<body>

<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo ''.$fecha.''; ?>">
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
 <TBODY>
      <TR  vAlign=top  class=dt>  
        <TD width="90%" vAlign=bottom colspan=3> <H4><B>Conexiones y Desconexiones 
            del: &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
        <?php 
	       echo'<TD width="14%" ><div align="right">';
		   echo "<a href=\"JavaScript:Imprimir()\">";
		   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>';
	     ?>
      </TR>
      <TR class=lcol vAlign=top> 
        <TD colSpan=6 bgcolor="#0066CC"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TBODY>
              <TR class=lcol> 
                <TD width=7% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
                <TD width=2% ><div align="center"><font size="6"><img src="ARCHIVOS/ICONO35.GIF"></font></div></TD>
                <TD width="4%" align="center"><div align="center"><font size="6"><strong>Grupo</strong></font></div></TD>
                <TD width="11%" align="center"><div align="center"><font size="6"><strong>TipoDesconexi&ograve;n</strong></font></div></TD>
                <TD width="20%" align="center"><font size="6"><strong>Fecha y Hora Desconexion</strong></font></TD>
                <TD width="9%" align="center"><font size="6"><strong>KAh dir d.</strong></font></TD>
                <TD width="21%" align="center"><font size="6"><strong>Fecha y Hora Conexion</strong></font></TD>
                <TD width="26%" align="center"><font size="6"><strong>KAh dir c.</strong></font></TD>
              </TR>
              <?php
			       $desde=$fecha;
				   $hasta=$fecha;
				   $consulta = "SELECT * FROM sec_web.cortes_refineria AS t1";
				   $consulta = $consulta." INNER JOIN proyecto_modernizacion.sub_clase AS t2";
				   $consulta = $consulta." ON t1.tipo_desconexion = t2.valor_subclase1";
				   $consulta = $consulta." WHERE t2.cod_clase = 3000";
				   $consulta = $consulta." AND t1.fecha_desconexion BETWEEN '".$desde." 00:00:00' AND '".$hasta." 23:59:59'";
				   $consulta = $consulta." ORDER BY t1.fecha_desconexion asc";
				   //echo $consulta."<br>";
				   $rs = mysqli_query($link, $consulta);
				   if(!$row = mysqli_fetch_array($rs))
                   {
				      echo'<TR class=lcol> ';
					  echo'<TD colspan="8" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				   }
				else {
				       $rs = mysqli_query($link, $consulta);
					   $i=0;
					   while ($row = mysqli_fetch_array($rs))
						{	
						  $i++;	
						  echo '<tr class=lcol>';
						  echo '<td width="54" align="center">'.$i.'</td>';
						  echo '<td width="63" height="25">';
						  echo '<td width="54" align="center">'.$row["cod_grupo"].'</td>';
						  echo '<td width="82" align="center">'.$row["nombre_subclase"].'</td>';			
						  echo '<td width="166" align="center">'.FormatoFecha($row[fecha_desconexion]).'</td>';
						  echo '<td width="95" align="center">'.$row[kahdird].'</td>';
						  echo '<td width="165" align="center">'.FormatoFecha($row[fecha_conexion]).'</td>';
						  echo '<td width="89" align="center">'.$row[kahdirc].'</td>';
						  echo'<TD width="10%" ><div align="center">';
						  echo "<a href=\"JavaScript:Eliminar('$fecha','$row["cod_grupo"]','$row[tipo_desconexion]','$row[fecha_desconexion]')\">";
						  echo '<img src="archivos/papelera.gif" width="15" height="15"></A></div></TD>';
						  echo'<TD width="10%" ><div align="center">';
						  echo "<a href=\"JavaScript:Modificar('$fecha','$row["cod_grupo"]','$row[tipo_desconexion]','$row[fecha_desconexion]')\">";
						  echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
						  echo '</tr>';
					   }
					  } 
            ?>
            </TBODY>
          </TABLE>
            </TD>
      </TR>
    </TBODY>
  </TABLE>
</form>
            
</body>
</html>
