<?php include("../principal/conectar_ref_web.php"); ?>


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
    fecha_auxiliar=fecha;
	fecha2=f.ano1.value+'-'+f.mes1.value+'-'+f.dia1.value;
    f.action = "his_produccion_laminas_iniciales.php?proceso=C"+"&fecha2="+fecha2+"&fecha="+fecha_auxiliar;
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
<TD vAlign=bottom> <H4><B>HISTORIA PRODUCCION LAMINAS INICIALES</B></H4></TD>
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
            <TD width=12% rowspan="2" ><div align="center"><font size="6"><strong>FECHA</strong></font></div></TD>
            <TD width=4% rowspan="2" ><div align="center"><font size="6"><strong>Grupo</strong></font></div></TD>
            <TD colspan="3" ><div align="center"><font size="6"><strong>Rechazo</strong></font></div></TD>
            <TD width="14%" ><div align="center"></div></TD>
          </TR>
          <TR class=lcol> 
            <TD width=22% ><div align="center"><font size="6"><strong>Delgadas</strong></font></div></TD>
            <TD width=25% ><div align="center"><font size="6"><strong>Granuladas</strong></font></div></TD>
            <TD width=23% ><div align="center"><font size="6"><strong>Gruesas</strong></font></div></TD>
            <TD ><div align="center"><font size="6"><strong>Total</strong></font></div></TD>
          </TR>
          <TR class=lcol> 
            <?php 
			    if ($proceso == "C")
              	 {           
				    $consulta="select * from ref_web.produccion ";
					$consulta.="where fecha between '".$fecha2."' and '".$fecha."' order by fecha, cod_grupo"; 
					$rs = mysqli_query($link, $consulta);
					$cont=1;
					while ($row = mysqli_fetch_array($rs))
					  {
					    if ( $j==1)
					     {$color= "lcol";
						  $j=0;}
					    else{$color= "lcolver";
							 $j=1;}
					    echo '<TR class='.$color.'>';
						echo "<td><div align='center'><font color='blue'>".$row["fecha"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row["cod_grupo"]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row[rechazo_delgadas]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row[rechazo_granuladas]."&nbsp;</font></td>\n";
						echo "<td><div align='center'><font color='blue'>".$row[rechazo_gruesas]."&nbsp;</font></td>\n";
						$total=$row[rechazo_delgadas]+$row[rechazo_granuladas]+$row[rechazo_gruesas];
						echo "<td><div align='center'><font color='blue'>".$total."&nbsp;</font></td>\n";
						$cont=$cont+1;
						if ($cont==5)
						   {
						    echo '<tr>';
						    echo "<td colspan='6' class=dt><div align='center'><font color='blue'>&nbsp;</font></td>\n";
							echo '</tr>';
						    $cont=1;
						   }
						echo '</TR>';
					  }			 
					  
				}			  
							  
			?>
            <td height="4"></TBODY> 
            <td height="4">&nbsp;</TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>

</FORM>
</BODY>
</HTML>

