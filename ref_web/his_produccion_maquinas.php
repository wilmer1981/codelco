<?php include("../principal/conectar_ref_web.php"); 
    $proceso = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:date("Y-m-d");
	$fecha2   = isset($_REQUEST["fecha2"])?$_REQUEST["fecha2"]:date("Y-m-d");
	$ano1   = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$mes1   = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$dia1   = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");

?>


<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Buscar(fecha)
{
	var f = document.FrmPrincipal;
    fecha_auxiliar = fecha;
	fecha2         = f.ano1.value+'-'+f.mes1.value+'-'+f.dia1.value;
    f.action = "his_produccion_maquinas.php?proceso=C"+"&fecha2="+fecha2+"&fecha="+fecha_auxiliar;
	f.submit();
}
function Imprimir()
{
	window.print();
}


//-->
</script>
<body>
<FORM action="" method=post name=FrmPrincipal>
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
<TR  vAlign=top  class=dt> 
<TD vAlign=bottom> <H4><B>HISTORIA PRODUCCION MAQUINAS</B></H4></TD>
<?php 
  echo'<TD width="14%" ><div align="right">';
  echo "<a href=\"JavaScript:Imprimir()\">";
  echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>'; 
?>
</TR>
<TR  vAlign=top  class=dt> 
  <TD width="45%" vAlign=bottom colspan=2> <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
  <TR> 
    <TD align=middle width="100%"> <TABLE cellSpacing=0 cellPadding=0 width="100%"  border=0>
    <TR bgcolor="#FFFFFF"> 
      <TD width="1" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <TD width="722" align="center">
      <TABLE height="100%" cellSpacing=0 cellPadding=0    align="center" width="100%" border=0>
      <TR> 
        <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
      </TR>
      <TR> 
         <TD> 
         <TABLE cellSpacing=0 cellPadding=0 width="80%" border=0>
         <TR> 
           <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7 border=0></TD>
           <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
           <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
        </TR>
        <TR> 
          <TD width="100%" colSpan=3> <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
          <TR> 
            <TD width="0%">&nbsp; </TD>
            <TD width="3%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
            <TD width="78%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Desde::</FONT> 
                                        <select name="dia1" size="1" >
                                          <?php
				 for($i=1;$i<=31;$i++)
					{
						if (isset($dia1))
						{
							if ($i == $dia1)
								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						else
						{
							if ($i == date("j"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}						
					}
				?>
                                        </select>
                                        <select name="mes1" size="1" id="select2">
                                          <?php
				$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for($i=1;$i<13;$i++)
					{
						if (isset($mes1))
						{
							if ($i == $mes1)
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
							else
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}
						else
						{
							if ($i == date("n"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
							else
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}						
					}
				?>
                                        </select>
                                        <select name="ano1" size="1" id="select3">
                                          <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($ano1))
						{
							if ($i == $ano1)
								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						else
						{
							if ($i == date("Y"))

								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
					}
				?>
                                        </select>
                                        <FONT style="FONT-WEIGHT: bold; COLOR: #000000">Hasta::<?php echo $fecha; ?></FONT> 
                                        <input name=b222222 type=submit   value="Buscar"   onClick="JavaScript:Buscar('<?php echo $fecha; ?>');"></font></b> 
                                    <TD width="19%"><IMG height=8 src="archivos/spaceit.gif" width=10 border=0></TD>
          </TR>
          </TABLE>
          </TD>
       </TR>
       <TR> 
         <TD width=7><IMG height=7  src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
         <TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
         <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
       </TR>
       </TABLE>
       </TD>
       </TR>
       <TR> 
          <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
       </TR>
       </TABLE>
       </TD>
    </TR>
    </TABLE></TD>
    </TR>
    </TABLE></TD>
    </TR>
    <TR class=lcol vAlign=top> 
    <TD colSpan=4 bgcolor="#ffffff"> 
    <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
          <TR class=lcol> 
            <TD width=14% rowspan="2" ><div align="center"><font size="6"><strong>FECHA</strong></font></div></TD>
            <TD colspan="3" ><div align="center"><font size="6"><strong>MFCI</strong></font></div></TD>
            <TD colspan="3" ><div align="center"><font size="6"><strong>MDB</strong></font></div></TD>
            <TD colspan="3" ><div align="center"><font size="6"><strong>MCO</strong></font></div></TD>
          </TR>
          <TR class=lcol> 
            <TD width=8% ><div align="center"><font size="6"><strong>TA</strong></font></div></TD>
            <TD width=11% ><div align="center"><font size="6"><strong>TB</strong></font></div></TD>
            <TD width=12% ><div align="center"><font size="6"><strong>TC</strong></font></div></TD>
            <TD width=9% ><div align="center"><font size="6"><strong>TA</strong></font></div></TD>
            <TD width=11% ><div align="center"><font size="6"><strong>TB</strong></font></div></TD>
            <TD width=8% ><div align="center"><font size="6"><strong>TC</strong></font></div></TD>
            <TD width=9% ><div align="center"><font size="6"><strong>TA</strong></font></div></TD>
            <TD width=8% ><div align="center"><font size="6"><strong>TB</strong></font></div></TD>
            <TD width=10% ><div align="center"><font size="6"><strong>TC</strong></font></div></TD>
          </TR>
          <TR class=lcol> 
            <?php 
			    if ($proceso == "C")
              	 {           
				    $consulta="select t1.fecha as fecha,t1.produccion_mfci as mfci_ta,t1.produccion_mdb as mdb_ta,t1.produccion_mco as mco_ta, ";
					$consulta.="t2.produccion_mfci as mfci_tb,t2.produccion_mdb as mdb_tb,t2.produccion_mco as mco_tb, ";
					$consulta.="t3.produccion_mfci as mfci_tc,t3.produccion_mdb as mdb_tc, t3.produccion_mco as mco_tc ";
					$consulta.="from ref_web.iniciales as t1 ";
					$consulta.="left join ref_web.iniciales as t2 on t1.fecha=t2.fecha and t2.turno='B' ";
					$consulta.="left join ref_web.iniciales as t3 on t1.fecha=t3.fecha and t3.turno='C' ";
					$consulta.="where t1.fecha between '".$fecha2."' and '".$fecha."' and t1.turno='A'";         
					$rs = mysqli_query($link, $consulta);
					$j=1;
					while ($row = mysqli_fetch_array($rs))
					  {
					    if($j==1)
					    {$color= "lcol";
						  $j=0;
						}
					    else{
							$color= "lcolver";
							$j=1;
						}
					    echo '<TR class='.$color.'>';
						echo "<td><div align='center'><font color='blue'>".$row["fecha"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mfci_ta"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mfci_tb"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mfci_tc"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mdb_ta"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mdb_tb"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mdb_tc"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mco_ta"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mco_tb"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["mco_tc"]."&nbsp;</font></td>\n";
					    echo '</TR>';
					  }			 
				}			  
			?>
          <TR bgcolor="#FFFFFF" > </TR></TBODY>
        </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>

</FORM>
</BODY>
</HTML>

