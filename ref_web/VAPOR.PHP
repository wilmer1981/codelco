 <?php 
 include("../principal/conectar_ref_web.php"); 
 
 $fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
 $turno     = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
 
 ?>


<HTML>
<HEAD>
<TITLE>Corto Circuitos</TITLE>
<script language="JavaScript">
function Grabar(f,fecha)
{
 f.action ="Ing_vapor01.php?Proceso=G&fecha="+fecha;
 f.submit();		
}
function Recarga(f,fecha)
{
 f.action="Vapor.php?fecha="+fecha;
 f.submit();
}
function Imprimir()
{
	window.print();
}
</script>

<LINK href="estilos/css_sea_web.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<BODY>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="Proceso" value="E">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">


<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm dyl">
      <TR vAlign=top  class=dt> 
        <TD width="90%"  colSpan="9" vAlign=bottom> <H4><B>CONDICIONES DE VAPOR</B></H4></TD>
        <TD width="10%" ><div align="right"><a href="JavaScript:Imprimir()"><img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>
      </TR>
      <TR vAlign=top  class=dt> 
        <TD colSpan="10"  width="100%" align="center" vAlign=bottom><div align="left"><strong>TURNO:
            <?php
					echo "<select name='turno' onChange=Recarga(this.form,'$fecha')>";
					echo '<option value="Todo">Todos los Turnos</option>';
					$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
					$respuesta = mysqli_query($link, $consulta);
					while ($fila1=mysqli_fetch_array($respuesta))
 					   {
						if ($turno==$fila1["turno"])
						   echo "<option value='".$fila1["turno"]."' selected>".$fila1["turno"]."</option>";
						else
							echo "<option value='".$fila1["turno"]."'>".$fila1["turno"]."</option>";
						}
					echo '</select></td>';
                   ?>
            </strong></div></TD>
      </TR>

<TR vAlign=top> 
  <TD  colSpan=10 bgcolor="#FFCC00"> 
    <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
              <TR class=lcolam> 
                <TD height="24" colspan="13" ><div align="center"><b>DATOS</b></div></TD>
              </TR>
              <TR class=lcolam> 
                <TD colspan="2" rowspan="2"> <div align="center"><b>INSTANTE</b></div></TD>
                <TD height="24" colspan="2"><div align="center"><b>MATRIZ ENTRADA</b></div></TD>
                <TD colspan="2"><div align="center"><b>CIRUICTOS 1 a 4</b></div></TD>
                <TD colspan="2"><div align="center"><b>CIRCUITO 5</b></div></TD>
                <TD colspan="2"><div align="center"><b>CIRCUITO 6</b></div></TD>
				<TD colspan="2"><div align="center"><b>CIRCUITO 7</b></div></TD>
              </TR>
              <TR class=lcolam> 
                <TD height=24 ><div align="center"><b>PRESION</b></div></TD>
                <TD ><div align="center"><b>TEMP.</b></div></TD>
                <TD height=24 <div align="center"><b>PRESION</b></div></TD>
                <TD ><div align="center"><b>TEMP.</b></div></TD>
                <TD height=24 ><div align="center"><b>PRESION</b></div></TD>
                <TD ><div align="center"><b>TEMP.</b></div></TD>
                <TD height=24 ><div align="center"><b>PRESION</b></div></TD>
                <TD ><div align="center"><b>TEMP.</b></div></TD>
                <TD height=24 ><div align="center"><b>PRESION</b></div></TD>
                <TD ><div align="center"><b>TEMP.</b></div></TD>
              </TR>
              <?php
			    if ($turno<>'Todo') 
				  {
                        $sql  = "select * from ref_web.vapor WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '1'";
				        //echo $sql;
					    $result=mysqli_query($link, $sql);
					    $row = mysqli_fetch_array($result);
  					    $pre1A= isset($row["PRE1"])?$row["PRE1"]:0;                   
						$temp1A= isset($row["TEMP1"])?$row["TEMP1"]:0;
						$pre2A= isset($row["PRE2"])?$row["PRE2"]:0; 
						$temp2A= isset($row["TEMP2"])?$row["TEMP2"]:0;
						$pre3A= isset($row["PRE3"])?$row["PRE3"]:0; 
						$temp3A= isset($row["TEMP3"])?$row["TEMP3"]:0;
						$pre4A= isset($row["PRE4"])?$row["PRE4"]:0; 
						$temp4A= isset($row["TEMP4"])?$row["TEMP4"]:0;
						$pre5A= isset($row["PRE5"])?$row["PRE5"]:0; 
						$temp5A= isset($row["TEMP5"])?$row["TEMP5"]:0;
						echo'<TR class=lcol> ';
						echo'<TD width="10%" rowspan="3"><div align="center"><b>TURNO '.$turno.'</b></div></TD>';
						echo'<TD width="5%"><div align="center"><b>In. Turno</b></div></TD>';
						echo'<TD width="5%"  height=25 ><div align="center"><B>'.$pre1A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp1A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre2A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp2A.'</B></div></TD>';
						echo'<TD width="5%"  ><div align="center"><B>'.$pre3A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp3A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre4A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp4A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre5A.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp5A.'</B></div></TD>';
						echo'</TR>';
				        $sql1  = "select * from vapor WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '2' ORDER BY FECHA ASC";
					    $result1=mysqli_query($link, $sql1);
					    $row1 = mysqli_fetch_array($result1);
						$pre1B= isset($row1["PRE1"])?$row1["PRE1"]:0; 
						$temp1B= isset($row1["TEMP1"])?$row1["TEMP1"]:0;
						$pre2B= isset($row1["PRE2"])?$row1["PRE2"]:0; 
						$temp2B= isset($row1["TEMP2"])?$row1["TEMP2"]:0;
						$pre3B= isset($row1["PRE3"])?$row1["PRE3"]:0; 
						$temp3B= isset($row1["TEMP3"])?$row1["TEMP3"]:0;
						$pre4B= isset($row1["PRE4"])?$row1["PRE4"]:0; 
						$temp4B= isset($row1["TEMP4"])?$row1["TEMP4"]:0;
						$pre5B= isset($row1["PRE5"])?$row1["PRE5"]:0; 
						$temp5B= isset($row1["TEMP5"])?$row1["TEMP5"]:0;
						echo'<TR class=lcol> ';
  					    echo'<TD width="10%" height=25 ><div align="center"><b>1/2 Turno</b></div></TD>';
						echo'<TD width="5%"  ><div align="center"><B>'.$pre1B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp1B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre2B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp2B.'</B></div></TD>';
						echo'<TD width="5%"  ><div align="center"><B>'.$pre3B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp3B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre4B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp4B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre5B.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp5B.'</B></div></TD>';
					    echo'</TR>';
					    $sql2  = "select * from vapor WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '3' ORDER BY FECHA ASC";
					    $result2=mysqli_query($link, $sql2);
					    $row2 = mysqli_fetch_array($result2);
						$pre1C= isset($row2["PRE1"])?$row2["PRE1"]:0; 
						$temp1C=isset($row2["TEMP1"])?$row2["TEMP1"]:0;
						$pre2C= isset($row2["PRE2"])?$row2["PRE2"]:0; 
						$temp2C= isset($row2["TEMP2"])?$row2["TEMP2"]:0;
						$pre3C= isset($row2["PRE3"])?$row2["PRE3"]:0; 
						$temp3C= isset($row2["TEMP3"])?$row2["TEMP3"]:0;
						$pre4C= isset($row2["PRE4"])?$row2["PRE4"]:0; 
						$temp4C= isset($row2["TEMP4"])?$row2["TEMP4"]:0;
						$pre5C= isset($row2["PRE5"])?$row2["PRE5"]:0; 
						$temp5C= isset($row2["TEMP5"])?$row2["TEMP5"]:0;
					    echo'<TR class=lcol> ';
						echo'<TD width="10%" height=25 ><div align="center"><b>Final Turno</b></div></TD>';
						echo'<TD width="5%"  ><div align="center"><B>'.$pre1C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp1C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre2C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp2C.'</B></div></TD>';
	 				    echo'<TD width="5%"  ><div align="center"><B>'.$pre3C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp3C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre4C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp4C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$pre5C.'</B></div></TD>';
						echo'<TD width="5%" ><div align="center"><B>'.$temp5C.'</B></div></TD>';
					   	echo'</TR>';
				        $promedio_temp1 = $temp1A  + $temp1B  + $temp1C;  
				        $promedio_temp2 = $temp2A  + $temp2B  + $temp2C;
				        $promedio_temp3 = $temp3A  + $temp3B  + $temp3C;
				        $promedio_temp4 = $temp4A  + $temp4B  + $temp4C;
						$promedio_temp5 = $temp5A  + $temp5B  + $temp5C;
				        $promedio_pres1 = $pre1A  + $pre1B  + $pre1C;
				        $promedio_pres2 = $pre2A  + $pre2B  + $pre2C;
				        $promedio_pres3 = $pre3A  + $pre3B  + $pre3C;
				        $promedio_pres4 = $pre4A  + $pre4B  + $pre4C;
						$promedio_pres5 = $pre5A  + $pre5B  + $pre5C;
				        $i=3;
				        $promedio_temp1 = number_format($promedio_temp1/$i,1,',','.');
				   		$promedio_temp2 = number_format($promedio_temp2/$i,1,',','.');
				   		$promedio_temp3 = number_format($promedio_temp3/$i,1,',','.');
				   		$promedio_temp4 = number_format($promedio_temp4/$i,1,',','.');
				   		$promedio_temp5 = number_format($promedio_temp5/$i,1,',','.');
						$promedio_pres1 = number_format($promedio_pres1/$i,1,',','.');
				   		$promedio_pres2 = number_format($promedio_pres2/$i,1,',','.');
				   		$promedio_pres3 = number_format($promedio_pres3/$i,1,',','.');
				   		$promedio_pres4 = number_format($promedio_pres4/$i,1,',','.');
						$promedio_pres5 = number_format($promedio_pres5/$i,1,',','.');
				   		
			?>
              <TR   bgcolor="#339966"> 
                <TD colspan=2 ><div align="center" colspan=2><strong><font color="#FFFFFF">PROMEDIO</font></strong></div></TD>
                <TD height=25 ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres1  ?></strong></font></div></TD>
                <TD > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_temp1  ?></strong></font></div></TD>
                <TD > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres2  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_temp2  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres3   ?></strong></font></div></TD>
                <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_temp3  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres4  ?></strong></font></div></TD>
                <TD ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_temp4  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres5  ?></strong></font></div></TD>
                <TD ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_temp5  ?></strong></font></div></TD>
              </TR>
              <?php	   
                }
			else { 
			       $consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1' order by valor_subclase1 asc";
				   $respuesta = mysqli_query($link, $consulta);
				   while ($fila1=mysqli_fetch_array($respuesta))
 					   {
					     $consulta_instante="select distinct INSTANTE from ref_web.vapor order by INSTANTE asc";      
					     $respuesta_instante = mysqli_query($link, $consulta_instante);
						 echo'<TR class=lcol> ';
							  echo'<TD width="10%" rowspan="3"><div align="center"><b>TURNO '.$fila1["turno"].'</b></div></TD>';
						 $total_presion1=0;
						 $total_presion2=0;
						 $total_presion3=0;
						 $total_presion4=0;
						 $total_presion5=0;
						 $total_temp1=0;
						 $total_temp2=0;
						 $total_temp3=0;
						 $total_temp4=0;
						 $total_temp5=0;		   
				         while ($fila_instante=mysqli_fetch_array($respuesta_instante))
						      {
							    $consulta_datos="select * from ref_web.vapor where FECHA='".$fecha."' and TURNO='".$fila1["turno"]."' and INSTANTE='".$fila_instante["INSTANTE"]."'";
								$respuesta_datos= mysqli_query($link, $consulta_datos);
								$fila_datos=mysqli_fetch_array($respuesta_datos);
								$pre1C= isset($fila_datos['PRE1'])?$fila_datos['PRE1']:0;
						        $temp1C= isset($fila_datos['TEMP1'])?$fila_datos['TEMP1']:0;
						        $pre2C= isset($fila_datos['PRE2'])?$fila_datos['PRE2']:0;
						        $temp2C= isset($fila_datos['TEMP2'])?$fila_datos['TEMP2']:0;
						        $pre3C= isset($fila_datos['PRE3'])?$fila_datos['PRE3']:0;
						        $temp3C= isset($fila_datos['TEMP3'])?$fila_datos['TEMP3']:0;
						        $pre4C= isset($fila_datos['PRE4'])?$fila_datos['PRE4']:0;
						        $temp4C= isset($fila_datos['TEMP4'])?$fila_datos['TEMP4']:0;
						        $pre5C= isset($fila_datos['PRE5'])?$fila_datos['PRE5']:0;
						        $temp5C= isset($fila_datos['TEMP5'])?$fila_datos['TEMP5']:0;
								if ($fila_instante["INSTANTE"]=='1')
								   {$instante='Inicio Turno';}
								if ($fila_instante["INSTANTE"]=='2')
									{$instante='1/2 Turno';}
								if ($fila_instante["INSTANTE"]=='3')
									{$instante='Final Turno';}	 	 
						        echo'<TD width="10%" height=25  class=lcol><div align="center"><b>'.$instante.'</b></div></TD>';
						        echo'<TD width="5%"   class=lcol><div align="center"><B>'.$pre1C.'</B></div></TD>';
						        echo'<TD width="5%"   class=lcol><div align="center"><B>'.$temp1C.'</B></div></TD>';
						        echo'<TD width="5%"   class=lcol><div align="center"><B>'.$pre2C.'</B></div></TD>';
						        echo'<TD width="5%"   class=lcol><div align="center"><B>'.$temp2C.'</B></div></TD>';
				                echo'<TD width="5%"   class=lcol><div align="center"><B>'.$pre3C.'</B></div></TD>';
						        echo'<TD width="5%"  class=lcol><div align="center"><B>'.$temp3C.'</B></div></TD>';
						        echo'<TD width="5%"  class=lcol><div align="center"><B>'.$pre4C.'</B></div></TD>';
						        echo'<TD width="5%"   class=lcol><div align="center"><B>'.$temp4C.'</B></div></TD>';
						        echo'<TD width="5%"  class=lcol><div align="center"><B>'.$pre5C.'</B></div></TD>';
						        echo'<TD width="5%"   class=lcol><div align="center"><B>'.$temp5C.'</B></div></TD>';
							    echo'</TR>';
								$total_presion1=$total_presion1+$pre1C;
						        $total_presion2=$total_presion2+$pre2C;
						        $total_presion3=$total_presion3+$pre3C;
						        $total_presion4=$total_presion4+$pre4C;
								$total_presion5=$total_presion5+$pre5C;
						        $total_temp1=$total_temp1+$temp1C;
						        $total_temp2=$total_temp2+$temp2C;
						        $total_temp3=$total_temp3+$temp3C;
						        $total_temp4=$total_temp4+$temp4C;
								$total_temp5=$total_temp5+$temp5C;   
								$i=3;
								$promedio1 = number_format($total_temp1/$i,1,',','.');
								$promedio2 = number_format($total_temp2/$i,1,',','.');
								$promedio3 = number_format($total_temp3/$i,1,',','.');
								$promedio4 = number_format($total_temp4/$i,1,',','.');
								$promedio5 = number_format($total_temp5/$i,1,',','.');
								$promedio_pres1 = number_format($total_presion1/$i,1,',','.');
								$promedio_pres2 = number_format($total_presion2/$i,1,',','.');
								$promedio_pres3 = number_format($total_presion3/$i,1,',','.');
								$promedio_pres4 = number_format($total_presion4/$i,1,',','.');
								$promedio_pres5 = number_format($total_presion5/$i,1,',','.');
							  }
							   ?>
              <TR   bgcolor="#339966"> 
                <TD colspan=2 ><div align="center" colspan=2><strong><font color="#FFFFFF">PROMEDIO</font></strong></div></TD>
                <TD height=25 ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres1  ?></strong></font></div></TD>
                <TD > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio1  ?></strong></font></div></TD>
                <TD > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres2  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio2  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres3   ?></strong></font></div></TD>
                <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio3  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres4  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio4  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio_pres5  ?></strong></font></div></TD>
                <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio5  ?></strong></font></div></TD>
               
              </TR>
              <?php  
					   }
			     }	
            ?>
           </TABLE>
	   </TD>
      </TR>
	 
  </TABLE>
  </FORM>
</BODY>
</HTML>
