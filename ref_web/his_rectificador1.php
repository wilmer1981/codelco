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
function Buscar()
{
	var f = document.FrmPrincipal;
	fecha=f.ano1.value+'-'+f.mes1.value;
    f.action = "his_rectificador1.php?proceso=C"+"&campo="+f.campo.value+"&fecha="+fecha;
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
<TD vAlign=bottom> <H4><B>HISTORIA LECTURA RECTIFICADOR 1</A></B></H4></TD>
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
            <TD width="78%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Buscar::</FONT> 
                                        <input type="hidden" name="campo">
                                        <b><font face="Arial, Helvetica, sans-serif">
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
                                        <input name=b222222 type=submit id=b222222  value="Buscar"   onClick="JavaScript:Buscar();">
                                        </font></b> <TD width="19%"><IMG height=8 src="archivos/spaceit.gif" width=10 border=0></TD>
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
            <TD width=15% ><div align="center"><font size="6"><strong>FECHA</strong></font></div></TD>
            <TD width=22% ><div align="center"><font size="6"><strong>K.A.H. REC-1</strong></font></div></TD>
            <TD width=63% ><div align="left"><font size="6"><strong>PROMEDIO K.A</strong></font></div></TD>
          </TR>
          <TR class=lcol> 
		  <?php 
			    if ($proceso == "C")
              	 {           
				             
							  $consulta="select fecha,lectura_rectificador from ref_web.detalle_produccion where fecha between '".$fecha."-01' and '".$fecha."-31' order by fecha asc";
							  //echo $consulta;
							  $respuesta = mysqli_query($link, $consulta);
					          while ($row= mysqli_fetch_array($respuesta))
						            {
									  $meses=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
									  $dia=substr($row["fecha"],8,2);
									  $mes=substr($row["fecha"],5,2);
									  $ano=substr($row["fecha"],0,4);
									  $cont=intval($mes);
							          $mes1=$meses[$cont-1];
	                                  $fecha2=$dia."-".$mes1;
									  if ( $j==1)
					         			{$color= "lcol";
						    			 $j=0;}
					      			  else{$color= "lcolver";
							   		 $j=1;} //color fila
					      			echo '<TR class='.$color.'>';
									  echo "<td><div align='center'><font color='blue'>".$fecha2."&nbsp;</font></td>\n";
									  echo "<td><div align='center'><font color='blue-red-white'>".$row[lectura_rectificador]."&nbsp;</font></td>\n";
									  if ($dia=='01')
									     {
										   $mes_aux=intval($mes);
										   if ($mes_aux==1)
										      {
											    $mes_aux=strval(12);
												$ano_aux=strval(intval($ano-1));
												$ano=$ano_aux;
												$fecha_ini=$ano."-".$mes_aux."-01";
												$fecha_ter=$ano."-".$mes_aux."-31";
											  }
										   else{$mes_aux=($mes_aux-1);
										        $fecha_ini=$ano."-".$mes_aux."-01";
												$fecha_ter=$ano."-".$mes_aux."-31";}
										   $consulta2="select max(fecha) as fecha from ref_web.detalle_produccion where fecha between '$fecha_ini' and '$fecha_ter' ";
										   $respuesta2 = mysqli_query($link, $consulta2);
					                       $row2= mysqli_fetch_array($respuesta2);
										   $consulta_rect_ant="select fecha,lectura_rectificador from ref_web.detalle_produccion where fecha ='".$row2["fecha"]."' ";
										   $respuesta_rect_ant = mysqli_query($link, $consulta_rect_ant);
					                       $row_rect_ant= mysqli_fetch_array($respuesta_rect_ant); 
										  }	
										       
										   else {$dia_aux=strval(intval($dia-1));
										        $fecha_ini=$ano."-".$mes."-".$dia_aux;
												$consulta2="select max(fecha) as fecha from ref_web.detalle_produccion where fecha = '$fecha_ini' ";
												$respuesta2 = mysqli_query($link, $consulta2);
					                            $row2= mysqli_fetch_array($respuesta2);
												$consulta_rect_ant="select fecha,lectura_rectificador from ref_web.detalle_produccion where fecha = '$fecha_ini' ";
												$respuesta_rect_ant = mysqli_query($link, $consulta_rect_ant);
					                            $row_rect_ant= mysqli_fetch_array($respuesta_rect_ant); 	}   
										   
										   
										 
									  $consulta3="select lectura_rectificador from ref_web.detalle_produccion where fecha ='".$row2["fecha"]."'";
									  $respuesta3 = mysqli_query($link, $consulta3);
					                  $row3= mysqli_fetch_array($respuesta3);
										   
										
									  $promedio=number_format((($row[lectura_rectificador]-$row_rect_ant[lectura_rectificador])/24),"2",".","");
									  if ($promedio < 0)
									     {$promedio = 0;
										  }
									  echo "<td><div align='left'>$promedio&nbsp;</td>\n";
									  echo "</tr>\n";
									 }
				}			  
							  
			?>  

          <TR bgcolor="#FFFFFF" > 
           
          </TR></TBODY>
        </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>

</FORM>
</BODY>
</HTML>

