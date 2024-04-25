<?php include("../principal/conectar_ref_web.php"); 

$fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";

$ano1=substr($fecha,0,4);
$mes1=substr($fecha,5,2);
$dia1=substr($fecha,8,2);

function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4)."  ".substr($f,11,2).":".substr($f,14,2);
		return $fecha;
	}
?>


<html>
<head>
<title>Conexiones y Desconexiones</title>
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
function Imprimir()
{
	window.print();
}
</script>
<body>

<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo ''.$fecha.''; ?>">
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
 <TBODY>
      <TR  vAlign=top  class=dt>  
        <TD width="90%" vAlign=bottom colspan=3> <H4><B>Riles del: &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
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
                <TD width=8% ><div align="center"><font size="6"><strong>Turno</strong></font></div>
                  <div align="center"></div></TD>
                <TD width="10%" align="center"><div align="center"><font size="6"><strong>Fecha 
                    y Hora muestra</strong></font></div></TD>
                <TD width="9%" align="center"><font size="6">Cu <strong>[mg/lt]</strong></font></TD>
                <TD width="9%" align="center"><font size="6">As<strong> [mg/lt]</strong></font></TD>	
                <TD width="9%" align="center"><font size="6">Sb <strong>[mg/lt]</strong></font></TD>
				<TD width="9%" align="center"><font size="6">Zn <strong>[mg/lt]</strong></font></TD>
                <TD width="9%" align="center"><font size="6">Ni <strong>[mg/lt]</strong></font></TD>
                <TD width="11%" align="center"><font size="6">Pb <strong>[mg/lt]</strong></font></TD>
                <TD width="18%" align="center"><font size="6">pH<strong> [unit.pH]</strong></font></TD>
              </TR>
              <?php
			    $consulta="select t1.fecha_muestra, t1.id_muestra,t1.cod_producto,t1.cod_subproducto, ";
				$consulta.="t2.nro_solicitud,t2.cod_leyes,t2.valor,t2.cod_unidad ";
				$consulta.="from cal_web.solicitud_analisis as t1 ";
				$consulta.="inner join cal_web.leyes_por_solicitud as t2 ";
				$consulta.="on t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora ";
				$consulta.="and t1.id_muestra=t2.id_muestra and t1.recargo=t2.recargo and "; 
				$consulta.="t1.nro_solicitud=t2.nro_solicitud and t1.cod_producto=t2.cod_producto and ";
				$consulta.="t1.cod_subproducto=t2.cod_subproducto ";
				$consulta.="where left(t1.fecha_muestra,10)='".$fecha."' and t1.cod_producto='45' and ";
				$consulta.="t2.cod_subproducto='15' and t1.id_muestra like 'pte-t%' ";
				$consulta.="and t2.cod_leyes in ('02','08','10','36','70','09','39') ";
				$consulta.="order by t1.fecha_muestra asc,t2.cod_leyes ";
				$respuesta = mysqli_query($link, $consulta);
				$num_ant='';
				$cont=0;
				while ($row = mysqli_fetch_array($respuesta))
				    {
					 if ($num_ant != $row["nro_solicitud"])
					    {
						 $num_ant = $row["nro_solicitud"];
					     echo '<tr class=lcol>';
						 $Consulta = "select case when right('".$row["fecha_muestra"]."',8) between '00:00:00' and '07:59:59' then 'C' else ";
		                 $Consulta.= " case when right('".$row["fecha_muestra"]."',8) between '08:00:00' and '15:59:59' then 'A' else ";
		                 $Consulta.= " case when right('".$row["fecha_muestra"]."',8) between '16:00:00' and '23:59:59' then 'B' end end end as turno ";
		                 $Respuesta = mysqli_query($link, $Consulta);
		                 $Fila = mysqli_fetch_array($Respuesta);
					     echo '<td width="54" align="center">'.$Fila["turno"].'</td>';
					     echo '<td width="54" align="center">'.$row["fecha_muestra"].'</td>';
						}
						 echo '<td width="90" align="center">'.number_format($row["valor"],"2",".",",").'</td>';			
						 $cont++;
					  if ($cont==7)
					    {
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
  <tr>&nbsp;</tr>
  <?php echo "<img src='grafico_riles.php?fecha=".$fecha."'>"; ?>
  <tr>&nbsp;</tr>
  <?php echo "<img src='grafico_riles_cobre.php?fecha=".$fecha."'>"; ?>
  <tr>&nbsp;</tr>
  <?php echo "<img src='grafico_riles_arsenico.php?fecha=".$fecha."'>"; ?>
</form>
            
</body>
</html>
