<?php include("../principal/conectar_ref_web.php"); 
function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4)."  ".substr($f,11,2).":".substr($f,14,2);
		return $fecha;
	}
echo "fecha :".$fecha;	
$ano1=substr($fecha,0,4);
$mes1=substr($fecha,5,2);
$dia1=substr($fecha,8,2)
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
function Modificar(fecha)
{
    var f = document.FrmPrincipal;
    f.action = "Ingreso_produccion_maquinas.php?entrar=S"+"&fecha="+fecha;
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
      <TR  vAlign=top  class=dt>  
        <TD width="90%" vAlign=bottom colspan=3> <H4><B>PRODUCCION MAQUINAS DEL 
            : &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
        <?php 
	       echo'<TD width="14%" ><div align="right">';
		   echo "<a href=\"JavaScript:Imprimir()\">";
		   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>';
       ?>
      </TR>
      <TR class=lcol vAlign=top> 
        <TD colSpan=6 bgcolor="#0066CC"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
              <TR class=lcol> 
                <TD width=7% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
                <TD width="4%" align="center"><div align="center"><font size="6"><strong>Turno</strong></font></div></TD>
                <TD width="11%" align="center"><div align="center"><font size="6"><strong>MFCI</strong></font></div></TD>
                <TD width="12%" align="center"><font size="6"><strong>MDB</strong></font></TD>
                <TD width="11%" align="center"><font size="6"><strong>MCO</strong></font></TD>
                <TD width="53%" align="center"><font size="6"><strong>Observaciones</strong></font></TD>
              </TR>
              <?php
			       $consulta = "SELECT * FROM ref_web.iniciales ";
				   $consulta = $consulta." WHERE fecha = '".$fecha."' ";
				   $consulta = $consulta." ORDER BY turno";
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
						  echo '<td width="54" align="center">'.$row[turno].'</td>';
						  echo '<td width="82" align="center">'.$row[produccion_mfci].'</td>';			
						  echo '<td width="166" align="center">'.$row[produccion_mdb].'</td>';
						  echo '<td width="95" align="center">'.$row[produccion_mco].'</td>';
						  echo '<td width="165" align="left">'.$row["observacion"].'</td>';
						  echo '</tr>';
					     }
					  } 
            ?>
          </TABLE>
		 <p>&nbsp;&nbsp;</p> 
		 
		 
        <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
          <TR  vAlign=top  class=dt> 
            <TD vAlign=bottom colspan=3> <H4><B>DETALLE STOCK PRODUCCION MAQUINAS:</B></H4></TD>
          <TR class=lcol> 
		   <?php
			       $consulta = "SELECT * FROM ref_web.detalle_iniciales";
				   $consulta = $consulta." WHERE fecha = '".$fecha."' ";
				   $rs = mysqli_query($link, $consulta);
				   $row = mysqli_fetch_array($rs);
					
            ?>
            <TD width="60%" align="left"><div align="left"><font size="6"><strong>STOCK</strong></font></div></TD>
            <TD align="left"><div align="left"><font size="6"></font></div>
              <font size="6"><?php echo $row[stock]; ?>&nbsp;</font></TD>
          </TR>
          <TR class=lcol> 
            <TD align="left"><font size="6"><strong>RECHAZO CAT. INI.</strong></font></TD>
            <TD align="left"><?php echo $row[rechazo_cat_ini]; ?>&nbsp;</TD>
          </TR>
          <TR class=lcol> 
            <TD align="left"><font size="6"><strong>RECHAZO DIARIO DE LAMINAS 
              INICIALES</strong></font></TD>
            <TD align="left"><?php echo $row[rechazo_lam_ini]; ?>&nbsp;</TD>
          </TR>
          <TR class=lcol> 
            <TD align="left"><font size="6"><strong>RECHAZO CATODOS EN RENOVACION</strong></font></TD>
            <TD align="left"><?php echo $row[catodos_en_renovacion]; ?>&nbsp;</TD>
          </TR>
         </table>	  
         </TD>
      </TR>
	 </TABLE>
	    <TR  vAlign=top  class=dt>  
        
        <?php 
	       echo'<TD width="10%" ><div align="center">';
		   echo "<a href=\"JavaScript:Modificar('$fecha')\">";
		   echo '<img src="archivos/modificar.gif" width="20" height="20" title="Modificar datos"></A></div></TD>';
	     ?>
      </TR>
</form>
</body>
</html>
