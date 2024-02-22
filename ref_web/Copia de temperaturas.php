 <?php include("../principal/conectar_ref_web.php"); ?>


<HTML>
<HEAD>
<TITLE>Corto Circuitos</TITLE>
<script language="JavaScript">
function Recarga(f,fecha)
{
 f.action="temperaturas.php?fecha="+fecha;
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
        <TD width="90%"  colSpan="5" vAlign=bottom> <H4><B>TEMPERATURAS</B></H4></TD>
        <TD width="10%" ><div align="right"><a href="JavaScript:Imprimir()"><img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>
      </TR>
      <TR vAlign=top  class=dt> 
        <TD colSpan="6"  width="100%" align="center" vAlign=bottom><div align="left"><strong>TURNO:
            <?php
					echo "<select name='turno' onChange=Recarga(this.form,'$fecha')>";
					echo '<option value="Todo">Todos los Turnos</option>';
					$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
					$respuesta = mysqli_query($link, $consulta);
					while ($fila1=mysqli_fetch_array($respuesta))
 					   {
						if ($turno==$fila1[turno])
						   echo "<option value='".$fila1[turno]."' selected>".$fila1[turno]."</option>";
						else
							echo "<option value='".$fila1[turno]."'>".$fila1[turno]."</option>";
						}
					echo '</select></td>';
                   ?>
            </strong></div></TD>
      </TR>

<TR vAlign=top> 
  <TD  colSpan=6 bgcolor="#FFCC00"> 
  <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
  <TR class=lcolam> 
  <TD height="24" colspan="18" ><div align="center"><b>DATOS</b></div></TD>
  </TR>
   <TR class=lcolam> 
     <TD colspan="2" > <div align="center"><b>INSTANTE</b></div></TD>
     <TD height="24" colspan="2"><div align="center"><b>CIRUICTO 1</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRUICTO 2</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 3</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 4</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 5</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 6</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO HM</b></div></TD>
     <TD colspan="2"><div align="center"><b>PARCIAL</b></div></TD>
   </TR>
   <?php
       if ($turno<>'Todo') 
		{
		  $sql  = "select * from temperaturas WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '1'";
		  $result=mysqli_query($link, $sql);
		  $row = mysqli_fetch_array($result);
		  echo'<TR class=lcol> ';
		  echo'<TD width="10%" rowspan="3"><div align="center"><b>Turno '.$turno.'</b></div></TD>';
		  echo'<TD width="5%"><div align="center"><b>In. Turno</b></div></TD>';
		  echo'<TD width="5%"  height=25  ><div align="center"><B>'.$row[TEMP1].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP2].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP3].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP4].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row[TEMP5].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP6].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP7].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP8].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row[TEMP9].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP10].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP11].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP12].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row[TEMP13].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP14].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP15].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row[TEMP16].'</B></div></TD>';
          echo'</TR>';
		  $sql  = "select * from temperaturas WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '2'";
		  $result=mysqli_query($link, $sql);
		  $row2 = mysqli_fetch_array($result);
		  echo'<TR class=lcol> ';
		  echo'<TD width="5%"><div align="center"><b>Medio Turno</b></div></TD>';
		  echo'<TD width="5%"  height=25  ><div align="center"><B>'.$row2[TEMP1].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP2].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP3].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP4].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row2[TEMP5].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP6].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP7].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP8].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row2[TEMP9].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP10].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP11].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP12].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row2[TEMP13].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP14].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP15].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row2[TEMP16].'</B></div></TD>';
          echo'</TR>';
		  $sql  = "select * from temperaturas WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '3'";
		  $result=mysqli_query($link, $sql);
		  $row3 = mysqli_fetch_array($result);
		  echo'<TR class=lcol> ';
		  echo'<TD width="5%"><div align="center"><b>Fin Turno</b></div></TD>';
		  echo'<TD width="5%"  height=25  ><div align="center"><B>'.$row3[TEMP1].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP2].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP3].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP4].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row3[TEMP5].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP6].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP7].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP8].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row3[TEMP9].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP10].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP11].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP12].'</B></div></TD>';
		  echo'<TD width="5%"  ><div align="center"><B>'.$row3[TEMP13].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP14].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP15].'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$row3[TEMP16].'</B></div></TD>';
          echo'</TR>';

          $promedio1 = $row[TEMP1]+$row2[TEMP1]+$row3[TEMP1];
		  $promedio2 = $row[TEMP2]+$row2[TEMP2]+$row3[TEMP2];
		  $promedio3 = $row[TEMP3]+$row2[TEMP3]+$row3[TEMP3];
		  $promedio4 = $row[TEMP4]+$row2[TEMP4]+$row3[TEMP4];
		  $promedio5 = $row[TEMP5]+$row2[TEMP5]+$row3[TEMP5];
		  $promedio6 = $row[TEMP6]+$row2[TEMP6]+$row3[TEMP6];
		  $promedio7 = $row[TEMP7]+$row2[TEMP7]+$row3[TEMP7];
		  $promedio8 = $row[TEMP8]+$row2[TEMP8]+$row3[TEMP8];
		  $promedio9 = $row[TEMP9]+$row2[TEMP9]+$row3[TEMP9];
		  $promedio10 = $row[TEMP10]+$row2[TEMP10]+$row3[TEMP10];
		  $promedio11 = $row[TEMP11]+$row2[TEMP11]+$row3[TEMP11];
		  $promedio12 = $row[TEMP12]+$row2[TEMP12]+$row3[TEMP12];
		  $promedio13 = $row[TEMP13]+$row2[TEMP13]+$row3[TEMP13];
		  $promedio14 = $row[TEMP14]+$row2[TEMP14]+$row3[TEMP14];
		  $promedio15 = $row[TEMP15]+$row2[TEMP15]+$row3[TEMP15];
		  $promedio16 = $row[TEMP16]+$row2[TEMP16]+$row3[TEMP16];
          $i=3;
          $promedio1 = number_format($promedio1/$i,1,',','.');
          $promedio2 = number_format($promedio2/$i,1,',','.');
          $promedio3 = number_format($promedio3/$i,1,',','.');
          $promedio4 = number_format($promedio4/$i,1,',','.');
          $promedio5 = number_format($promedio5/$i,1,',','.');
          $promedio6 = number_format($promedio6/$i,1,',','.');
          $promedio7 = number_format($promedio7/$i,1,',','.');
          $promedio8 = number_format($promedio8/$i,1,',','.');
          $promedio9 = number_format($promedio9/$i,1,',','.');
          $promedio10 = number_format($promedio10/$i,1,',','.');
          $promedio11 = number_format($promedio11/$i,1,',','.');
          $promedio12 = number_format($promedio12/$i,1,',','.');
          $promedio13 = number_format($promedio13/$i,1,',','.');
          $promedio14 = number_format($promedio14/$i,1,',','.');
          $promedio15 = number_format($promedio15/$i,1,',','.');
          $promedio16 = number_format($promedio16/$i,1,',','.');
     ?>
		 <TR bgcolor="#339966"> 
		 <TD COLSPAN=2><div align="center"><font color="#FFFFFF"><strong>PROMEDIO ACUM. </strong></font></div></TD>
		 <TD height=25 ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio1?></strong></font></div></TD>
		 <TD> <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio2?></strong></font></div></TD>
		 <TD> <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio3?></strong></font></div></TD>
		 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio4?></strong></font></div></TD>
		 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio5?></strong></font></div></TD>
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio6?></strong></font></div></TD>
		 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio7?></strong></font></div></TD>
		 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio8?></strong></font></div></TD>
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio9?></strong></font></div></TD>
		 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio10?></strong></font></div></TD>
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio11?></strong></font></div></TD>
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio12?></strong></font></div></TD>
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio13?></strong></font></div></TD>
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio14?></strong></font></div></TD>
		 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio15?></strong></font></div></TD>
		 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio16?></strong></font></div></TD>
		 </TR>
		 </TABLE>
		 </TD>
		 </TR>
		</TABLE>
   <?php } 
   else {
          $consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1' order by valor_subclase1 asc";
		  $respuesta = mysqli_query($link, $consulta);
		  while ($fila1=mysqli_fetch_array($respuesta))
 				{
				   $consulta_instante="select distinct INSTANTE from ref_web.temperaturas order by INSTANTE asc";      
				   $respuesta_instante = mysqli_query($link, $consulta_instante);
				   echo'<TR class=lcol> ';
		           echo'<TD width="10%" rowspan="3"><div align="center"><b>Turno '.$fila1[turno].'</b></div></TD>';
				   $suma1=0;
				   $suma2=0;
				   $suma3=0;
				   $suma4=0;
				   $suma5=0;
				   $suma6=0;
				   $suma7=0;
				   $suma8=0;
				   $suma9=0;
				   $suma10=0;
				   $suma11=0;
				   $suma12=0;
				   $suma13=0;
				   $suma14=0;
				   $suma15=0;
				   $suma16=0;
				   while ($fila_instante=mysqli_fetch_array($respuesta_instante))
					   {
						$consulta_datos="select * from ref_web.temperaturas where FECHA='".$fecha."' and TURNO='".$fila1[turno]."' and INSTANTE='".$fila_instante[INSTANTE]."'";
					    $respuesta_datos= mysqli_query($link, $consulta_datos);
					    $row=mysqli_fetch_array($respuesta_datos);
						if ($fila_instante[INSTANTE]=='1')
						   {$instante='Inicio Turno';}
						if ($fila_instante[INSTANTE]=='2')
						   {$instante='1/2 Turno';}
						if ($fila_instante[INSTANTE]=='3')
						    {$instante='Final Turno';}	
						echo'<TD width="5%" class=lcol><div align="center"><b>'.$instante.'</b></div></TD>';
					    echo'<TD width="5%"  height=25  class=lcol><div align="center"><B>'.$row[TEMP1].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP2].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP3].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP4].'</B></div></TD>';
					    echo'<TD width="5%"  class=lcol><div align="center"><B>'.$row[TEMP5].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP6].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP7].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP8].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol ><div align="center"><B>'.$row[TEMP9].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP10].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP11].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP12].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol ><div align="center"><B>'.$row[TEMP13].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP14].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP15].'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$row[TEMP16].'</B></div></TD>';
					    echo'</TR>';
						$suma1=$suma1+$row[TEMP1];
						$suma2=$suma2+$row[TEMP2];
						$suma3=$suma3+$row[TEMP3];
						$suma4=$suma4+$row[TEMP4];
						$suma5=$suma5+$row[TEMP5];
						$suma6=$suma6+$row[TEMP6];
						$suma7=$suma7+$row[TEMP7];
						$suma8=$suma8+$row[TEMP8];
						$suma9=$suma9+$row[TEMP9];
						$suma10=$suma10+$row[TEMP10];
						$suma11=$suma11+$row[TEMP11];
						$suma12=$suma12+$row[TEMP12];
						$suma13=$suma13+$row[TEMP13];
						$suma14=$suma14+$row[TEMP14];
						$suma15=$suma15+$row[TEMP15];
						$suma16=$suma16+$row[TEMP16];
						 $i=3;
					    $promedio1 = number_format($suma1/$i,1,',','.');
					    $promedio2 = number_format($suma2/$i,1,',','.');
					    $promedio3 = number_format($suma3/$i,1,',','.');
					    $promedio4 = number_format($suma4/$i,1,',','.');
					    $promedio5 = number_format($suma5/$i,1,',','.');
					    $promedio6 = number_format($suma6/$i,1,',','.');
					    $promedio7 = number_format($suma7/$i,1,',','.');
					    $promedio8 = number_format($suma8/$i,1,',','.');
					    $promedio9 = number_format($suma9/$i,1,',','.');
					    $promedio10 = number_format($suma10/$i,1,',','.');
					    $promedio11 = number_format($suma11/$i,1,',','.');
					    $promedio12 = number_format($suma12/$i,1,',','.');
					    $promedio13 = number_format($suma13/$i,1,',','.');
					    $promedio14 = number_format($suma14/$i,1,',','.');
					    $promedio15 = number_format($suma15/$i,1,',','.');
					    $promedio16 = number_format($suma16/$i,1,',','.');
					}?>
					 <TR bgcolor="#339966"> 
		             <TD COLSPAN=2><div align="center"><font color="#FFFFFF"><strong>PROMEDIO ACUM. </strong></font></div></TD>
					 <TD height=25 ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio1?></strong></font></div></TD>
					 <TD> <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio2?></strong></font></div></TD>
					 <TD> <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio3?></strong></font></div></TD>
					 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio4?></strong></font></div></TD>
					 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio5?></strong></font></div></TD>
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio6?></strong></font></div></TD>
					 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio7?></strong></font></div></TD>
					 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio8?></strong></font></div></TD>
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio9?></strong></font></div></TD>
					 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio10?></strong></font></div></TD>
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio11?></strong></font></div></TD>
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio12?></strong></font></div></TD>
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio13?></strong></font></div></TD>
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio14?></strong></font></div></TD>
					 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio15?></strong></font></div></TD>
					 <TD  ><div align="center"><font color="#FFFFFF"><strong><?php echo $promedio16?></strong></font></div></TD>
					 </TR>
					
					
				
			<?php }
   
   
   
         }?>

</FORM>
</BODY>
</HTML>
