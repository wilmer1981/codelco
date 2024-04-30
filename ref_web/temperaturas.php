 <?php 
 include("../principal/conectar_ref_web.php"); 

 $fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
 $turno     = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
 
 
 ?>


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
  <TD  colSpan=6 bgcolor="#FFCC00"> 
  <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
  <TR class=lcolam> 
  <TD height="24" colspan="20" ><div align="center"><b>DATOS</b></div></TD>
  </TR>
   <TR class=lcolam> 
     <TD colspan="2" > <div align="center"><b>INSTANTE</b></div></TD>
     <TD height="24" colspan="2"><div align="center"><b>CIRCUITO 1</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 2</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 3</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 4</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 5</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO 6</b></div></TD>
	 <TD colspan="2"><div align="center"><b>CIRCUITO 7</b></div></TD>
     <TD colspan="2"><div align="center"><b>CIRCUITO HM</b></div></TD>
     <TD colspan="2"><div align="center"><b>PARCIAL</b></div></TD>
   </TR>
   <?php
       if ($turno<>'Todo') 
		{
		  $sql  = "select * from temperaturas WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '1'";
		  $result=mysqli_query($link, $sql);
		  $row = mysqli_fetch_array($result);
		  $TEMP11 = isset($row["TEMP1"])?$row["TEMP1"]:0;
		  $TEMP21 = isset($row["TEMP2"])?$row["TEMP2"]:0;
		  $TEMP31 = isset($row["TEMP3"])?$row["TEMP3"]:0;
		  $TEMP41 = isset($row["TEMP4"])?$row["TEMP4"]:0;
		  $TEMP51 = isset($row["TEMP5"])?$row["TEMP5"]:0;
		  $TEMP61 = isset($row["TEMP6"])?$row["TEMP6"]:0;
		  $TEMP71 = isset($row["TEMP7"])?$row["TEMP7"]:0;
		  $TEMP81 = isset($row["TEMP8"])?$row["TEMP8"]:0;
		  $TEMP91 = isset($row["TEMP9"])?$row["TEMP9"]:0;
		  $TEMP101 = isset($row["TEMP10"])?$row["TEMP10"]:0;
		  $TEMP111 = isset($row["TEMP11"])?$row["TEMP11"]:0;
		  $TEMP121 = isset($row["TEMP12"])?$row["TEMP12"]:0;
		  $TEMP131 = isset($row["TEMP13"])?$row["TEMP13"]:0;
		  $TEMP141 = isset($row["TEMP14"])?$row["TEMP14"]:0;
		  $TEMP151 = isset($row["TEMP15"])?$row["TEMP15"]:0;
		  $TEMP161 = isset($row["TEMP16"])?$row["TEMP16"]:0;
		  $TEMP171 = isset($row["TEMP17"])?$row["TEMP17"]:0;
		  $TEMP181 = isset($row["TEMP18"])?$row["TEMP18"]:0;

		  echo'<TR class=lcol> ';
		  echo'<TD width="10%" rowspan="3"><div align="center"><b>Turno '.$turno.'</b></div></TD>';
		  echo'<TD width="5%"><div align="center"><b>In. Turno</b></div></TD>';
		  echo'<TD width="5%" height=25  ><div align="center"><B>'.$TEMP11.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP21.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP31.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP41.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP51.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP61.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP71.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP81.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP91.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP101.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP111.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP121.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP171.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP181.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP131.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP141.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP151.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP161.'</B></div></TD>';
          echo'</TR>';
		  $sql  = "select * from temperaturas WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '2'";
		  $result=mysqli_query($link, $sql);
		  $row2 = mysqli_fetch_array($result);

		  $TEMP12 = isset($row2["TEMP1"])?$row2["TEMP1"]:0;
		  $TEMP22 = isset($row2["TEMP2"])?$row2["TEMP2"]:0;
		  $TEMP32 = isset($row2["TEMP3"])?$row2["TEMP3"]:0;
		  $TEMP42 = isset($row2["TEMP4"])?$row2["TEMP4"]:0;
		  $TEMP52 = isset($row2["TEMP5"])?$row2["TEMP5"]:0;
		  $TEMP62 = isset($row2["TEMP6"])?$row2["TEMP6"]:0;
		  $TEMP72 = isset($row2["TEMP7"])?$row2["TEMP7"]:0;
		  $TEMP82 = isset($row2["TEMP8"])?$row2["TEMP8"]:0;
		  $TEMP92 = isset($row2["TEMP9"])?$row2["TEMP9"]:0;
		  $TEMP102 = isset($row2["TEMP10"])?$row2["TEMP10"]:0;
		  $TEMP112 = isset($row2["TEMP11"])?$row2["TEMP11"]:0;
		  $TEMP122 = isset($row2["TEMP12"])?$row2["TEMP12"]:0;
		  $TEMP132 = isset($row2["TEMP13"])?$row2["TEMP13"]:0;
		  $TEMP142 = isset($row2["TEMP14"])?$row2["TEMP14"]:0;
		  $TEMP152 = isset($row2["TEMP15"])?$row2["TEMP15"]:0;
		  $TEMP162 = isset($row2["TEMP16"])?$row2["TEMP16"]:0;
		  $TEMP172 = isset($row2["TEMP17"])?$row2["TEMP17"]:0;
		  $TEMP182 = isset($row2["TEMP18"])?$row2["TEMP18"]:0;

		  echo'<TR class=lcol> ';
		  echo'<TD width="5%"><div align="center"><b>Medio Turno</b></div></TD>';
		  echo'<TD width="5%"  height=25 ><div align="center"><B>'.$TEMP12.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP22.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP32.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP42.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP52.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP62.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP72.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP82.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP92.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP102.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP112.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP122.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP172.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP182.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP132.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP142.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP152.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP162.'</B></div></TD>';
          echo'</TR>';
		  $sql  = "select * from temperaturas WHERE FECHA = '".$fecha."' and TURNO = '".$turno."' AND INSTANTE = '3'";
		  $result=mysqli_query($link, $sql);
		  $row3 = mysqli_fetch_array($result);
		  $TEMP13 = isset($row3["TEMP1"])?$row3["TEMP1"]:0;
		  $TEMP23 = isset($row3["TEMP2"])?$row3["TEMP2"]:0;
		  $TEMP33 = isset($row3["TEMP3"])?$row3["TEMP3"]:0;
		  $TEMP43 = isset($row3["TEMP4"])?$row3["TEMP4"]:0;
		  $TEMP53 = isset($row3["TEMP5"])?$row3["TEMP5"]:0;
		  $TEMP63 = isset($row3["TEMP6"])?$row3["TEMP6"]:0;
		  $TEMP73 = isset($row3["TEMP7"])?$row3["TEMP7"]:0;
		  $TEMP83 = isset($row3["TEMP8"])?$row3["TEMP8"]:0;
		  $TEMP93 = isset($row3["TEMP9"])?$row3["TEMP9"]:0;
		  $TEMP103 = isset($row3["TEMP10"])?$row3["TEMP10"]:0;
		  $TEMP113 = isset($row3["TEMP11"])?$row3["TEMP11"]:0;
		  $TEMP123 = isset($row3["TEMP12"])?$row3["TEMP12"]:0;
		  $TEMP133 = isset($row3["TEMP13"])?$row3["TEMP13"]:0;
		  $TEMP143 = isset($row3["TEMP14"])?$row3["TEMP14"]:0;
		  $TEMP153 = isset($row3["TEMP15"])?$row3["TEMP15"]:0;
		  $TEMP163 = isset($row3["TEMP16"])?$row3["TEMP16"]:0;
		  $TEMP173 = isset($row3["TEMP17"])?$row3["TEMP17"]:0;
		  $TEMP183 = isset($row3["TEMP18"])?$row3["TEMP18"]:0;
		  echo'<TR class=lcol> ';
		  echo'<TD width="5%"><div align="center"><b>Fin Turno</b></div></TD>';
		  echo'<TD width="5%"  height=25  ><div align="center"><B>'.$TEMP13.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP23.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP33.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP43.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP53.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP63.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP73.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP83.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP93.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP103.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP113.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP123.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP173.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP183.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP133.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP143.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP153.'</B></div></TD>';
		  echo'<TD width="5%" ><div align="center"><B>'.$TEMP163.'</B></div></TD>';
          echo'</TR>';

          $promedio1 = $TEMP11 + $TEMP12 + $TEMP13;
		  $promedio2 = $TEMP21 + $TEMP22 + $TEMP23;
		  $promedio3 = $TEMP31 + $TEMP32 + $TEMP33;
		  $promedio4 = $TEMP41 + $TEMP42 + $TEMP43;
		  $promedio5 = $TEMP51 + $TEMP52 + $TEMP53;
		  $promedio6 = $TEMP61 + $TEMP62 + $TEMP63;
		  $promedio7 = $TEMP71 + $TEMP72 + $TEMP73;
		  $promedio8 = $TEMP81 + $TEMP82 + $TEMP83;
		  $promedio9 = $TEMP91 + $TEMP92 + $TEMP93;
		  $promedio10 = $TEMP101 + $TEMP102 + $TEMP103;
		  $promedio11 = $TEMP111 + $TEMP112 + $TEMP113;
		  $promedio12 = $TEMP121 + $TEMP122 + $TEMP123;
		  $promedio13 = $TEMP131 + $TEMP132 + $TEMP133;
		  $promedio14 = $TEMP141 + $TEMP142 + $TEMP143;
		  $promedio15 = $TEMP151 + $TEMP152 + $TEMP153;
		  $promedio16 = $TEMP161 + $TEMP162 + $TEMP163;
		  $promedio17 = $TEMP171 + $TEMP172 + $TEMP173;
		  $promedio18 = $TEMP181 + $TEMP182 + $TEMP183;
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
          $promedio17 = number_format($promedio17/$i,1,',','.');
          $promedio18 = number_format($promedio18/$i,1,',','.');
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
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio17?></strong></font></div></TD>
		 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio18?></strong></font></div></TD>
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
		           echo'<TD width="10%" rowspan="3"><div align="center"><b>Turno '.$fila1["turno"].'</b></div></TD>';
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
				   $suma17=0;
				   $suma18=0;
				   while ($fila_instante=mysqli_fetch_array($respuesta_instante))
					   {
						$consulta_datos="select * from ref_web.temperaturas where FECHA='".$fecha."' and TURNO='".$fila1["turno"]."' and INSTANTE='".$fila_instante["INSTANTE"]."'";
					    $respuesta_datos= mysqli_query($link, $consulta_datos);
					    $row=mysqli_fetch_array($respuesta_datos);
						if ($fila_instante["INSTANTE"]=='1')
						   {$instante='Inicio Turno';}
						if ($fila_instante["INSTANTE"]=='2')
						   {$instante='1/2 Turno';}
						if ($fila_instante["INSTANTE"]=='3')
						    {$instante='Final Turno';}	

						$TEMP1 = isset($row["TEMP1"])?$row["TEMP1"]:0;
						$TEMP2 = isset($row["TEMP2"])?$row["TEMP2"]:0;
						$TEMP3 = isset($row["TEMP3"])?$row["TEMP3"]:0;
						$TEMP4 = isset($row["TEMP4"])?$row["TEMP4"]:0;
						$TEMP5 = isset($row["TEMP5"])?$row["TEMP5"]:0;
						$TEMP6 = isset($row["TEMP6"])?$row["TEMP6"]:0;
						$TEMP7 = isset($row["TEMP7"])?$row["TEMP7"]:0;
						$TEMP8 = isset($row["TEMP8"])?$row["TEMP8"]:0;
						$TEMP9 = isset($row["TEMP9"])?$row["TEMP9"]:0;
						$TEMP10 = isset($row["TEMP10"])?$row["TEMP10"]:0;
						$TEMP11 = isset($row["TEMP11"])?$row["TEMP11"]:0;
						$TEMP12 = isset($row["TEMP12"])?$row["TEMP12"]:0;
						$TEMP13 = isset($row["TEMP13"])?$row["TEMP13"]:0;
						$TEMP14 = isset($row["TEMP14"])?$row["TEMP14"]:0;
						$TEMP15 = isset($row["TEMP15"])?$row["TEMP15"]:0;
						$TEMP16 = isset($row["TEMP16"])?$row["TEMP16"]:0;
						$TEMP17 = isset($row["TEMP17"])?$row["TEMP17"]:0;
						$TEMP18 = isset($row["TEMP18"])?$row["TEMP18"]:0;

						echo'<TD width="5%" class=lcol><div align="center"><b>'.$instante.'</b></div></TD>';
					    echo'<TD width="5%"  height=25  class=lcol><div align="center"><B>'.$TEMP1.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP2.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP3.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP4.'</B></div></TD>';
					    echo'<TD width="5%"  class=lcol><div align="center"><B>'.$TEMP5.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP6.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP7.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP8.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol ><div align="center"><B>'.$TEMP9.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP10.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP11.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP12.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP17.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP18.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol ><div align="center"><B>'.$TEMP13.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP14.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP15.'</B></div></TD>';
					    echo'<TD width="5%" class=lcol><div align="center"><B>'.$TEMP16.'</B></div></TD>';
					    echo'</TR>';
						$suma1=$suma1+$TEMP1;
						$suma2=$suma2+$TEMP2;
						$suma3=$suma3+$TEMP3;
						$suma4=$suma4+$TEMP4;
						$suma5=$suma5+$TEMP5;
						$suma6=$suma6+$TEMP6;
						$suma7=$suma7+$TEMP7;
						$suma8=$suma8+$TEMP8;
						$suma9=$suma9+$TEMP9;
						$suma10=$suma10+$TEMP10;
						$suma11=$suma11+$TEMP11;
						$suma12=$suma12+$TEMP12;
						$suma13=$suma13+$TEMP13;
						$suma14=$suma14+$TEMP14;
						$suma15=$suma15+$TEMP15;
						$suma16=$suma16+$TEMP16;
						$suma17=$suma17+$TEMP17;
						$suma18=$suma18+$TEMP18;
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
						$promedio17 = number_format($suma17/$i,1,',','.');
						$promedio18 = number_format($suma18/$i,1,',','.');
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
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio17?></strong></font></div></TD>
					 <TD  > <div align="center"><font color="#FFFFFF"><strong><?php echo $promedio18?></strong></font></div></TD>
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
