<?php
	include("../principal/conectar_ref_web.php"); 

	$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";

	$ano1 = substr($fecha,0,4);
	$mes1 = substr($fecha,5,2);
	$dia1 = substr($fecha,8,2);
?>
<html>
<head>
<title>Novedades</title>
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
function Eliminar(cod_novedad)
{
	var f = document.FrmPrincipal;
	if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
	  f.action = "ing_general_jefe_hm01.php?cod_novedad=" + cod_novedad;
	  f.submit();
	}  
}
function Imprimir()
{
	window.print();
}
function Modificar(fecha,cod_novedad,turno)
{
   var f = document.FrmPrincipal;
   f.action = "ing_general_jefe_hm.php?cod_novedad=" + cod_novedad+"&fecha="+fecha+"&turno="+turno+"&opcion=M";
   f.submit();
}
</script>


<body>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="Proceso" value="E">
<input type="hidden" name="fecha" value="<?php echo ''.$fecha.''; ?>">
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
 <TBODY>
      <TR  vAlign=top  class=dt>  
        <TD width="90%" vAlign=bottom colspan=3> <H4><B>Novedades &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
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
              <TD width=4% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
              <TD width=17% ><div align="center"><font size="6"><strong>USUARIO</strong></font></div></TD>
              <TD width="6%"><div align="center"><font size="6"><strong>TURNO</strong></font></div></TD>
              <TD width="73%"><div align="center"><font size="6"><strong>OBSERVACIONES</strong></font></div></TD>
            </TR>
           <?php
                 $consulta ="select t1.COD_NOVEDAD,t1.NOVEDAD,t1.usuario,T1.TURNO, t2.valor_subclase1 ";
                 $consulta .="from ref_web.novedades_jefe_hm as t1 ";
                 $consulta .="inner join proyecto_modernizacion.sub_clase as t2 "; 
                 $consulta .="on t1.TURNO=t2.nombre_subclase and t2.cod_clase = '1' ";
                 $consulta .="WHERE fecha = '".$fecha."' and mantencion not in ('S') "; 
                 $consulta .="ORDER BY t2.valor_subclase1,t1.FECHA ASC ";
				 //echo $consulta;		   
           		//$consulta = "select * from ref_web.novedades WHERE fecha = '".$fecha."' ORDER BY FECHA ASC";
				//echo $consulta;
				$respuesta=mysqli_query($link, $consulta);
                if(!$row = mysqli_fetch_array($respuesta))
                {
				      echo'<TR class=lcol> ';
					  echo'<TD colspan="7" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				}
				else
				{
				      $respuesta=mysqli_query($link, $consulta);
                      while($row = mysqli_fetch_array($respuesta))
                      {
                         $i++;
						 $cod_novedad= $row["COD_NOVEDAD"];
						 $observacion= $row["NOVEDAD"];
						 $turno= $row["TURNO"];
						 $usuario=$row["usuario"];
						 echo'<TR class=lcol> ';
						 echo'<TD ><div align="center"><B>'.$i.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.strtoupper($usuario).'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$turno.'</B></div></TD>';
						 echo'<TD ><div align="left"><B>'.strtoupper($observacion).'</B></div></TD>';
						 echo"<TD ><div align='center'><a href=JavaScript:Eliminar(".$cod_novedad.");><img src='archivos/papelera.gif' width='15' height='15'></A></div></TD>";
						 echo'<TD width="10%" ><div align="center">';
						 echo "<a href=\"JavaScript:Modificar('$fecha','$cod_novedad','$turno')\">";
						 echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
						 echo'</TR>';
					  }
				}	
                //}
            ?>
          </TBODY>
        </TABLE>
       </TD>
      </TR>
	  <tr >
	     <td bgcolor="#0066CC" colspan="8">&nbsp;</td>
	  </tr>
	 <TR  vAlign=top  class=dt>  
	  <TD width="90%" vAlign=bottom colspan=4> <H4><B>Mantenciones Pendientes al &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
       
      </TR>
      <TR class=lcol vAlign=top> 
        <TD colSpan=6 bgcolor="#0066CC"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TBODY>
              <TR class=lcol> 
			  <TD width=2% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
                <TD width=15% ><div align="center"><font size="6"><strong>USUARIO      </strong></font></div></TD>
                <TD width="5%"><div align="center"><font size="6"><strong>TURNO        </strong></font></div></TD>
                <TD width="15%"><div align="center"></div><font size="6"><strong>FECHA EMISION</strong></font></div></TD>
                <TD width="14%"><div align="center"><font size="6"><strong>AREA        </strong></font></div></TD>
				<TD width="14%"><div align="center"><font size="6"><strong>COND.INSEG. </strong></font></div></TD>
				<TD width="49%"><div align="center"><font size="6"><strong>OBSERVACIONES</strong></font></div></TD>
			</TR>
              <?php
                 $consulta ="select t1.fecha,t1.COD_NOVEDAD,t1.NOVEDAD,t1.usuario,T1.TURNO,t1.compromiso,t1.area,t1.Condicion_insegura, t2.valor_subclase1 ";
                 $consulta .="from ref_web.novedades_jefe_hm as t1 ";
                 $consulta .="inner join proyecto_modernizacion.sub_clase as t2 "; 
                 $consulta .="on t1.TURNO=t2.nombre_subclase and t2.cod_clase = '1' ";
                 $consulta .="WHERE mantencion in ('S') and estado='1'"; 
                // $consulta .="ORDER BY t2.valor_subclase1,t1.FECHA ASC ";  
				 $consulta .="ORDER BY t1.FECHA desc"; 
           		//$consulta = "select * from ref_web.novedades WHERE fecha = '".$fecha."' ORDER BY FECHA ASC";
				//echo $consulta;
				$respuesta=mysqli_query($link, $consulta);
                if(!$row = mysqli_fetch_array($respuesta))
                {
				      echo'<TR class=lcol> ';
					  echo'<TD colspan="7" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				}
				else
				{
				      $respuesta=mysqli_query($link, $consulta);
                      while($row = mysqli_fetch_array($respuesta))
                      {
                         $i++;
						 $cod_novedad= $row["COD_NOVEDAD"];
						 $observacion= $row["NOVEDAD"];
						 $turno= $row["TURNO"];
						 $condicion=$row["Condicion_insegura"];
						 $usuario=$row["usuario"];
						 $compromiso=$row["compromiso"];
						 $Area=$row["area"];
						 if ($Area==1)
						    {$Area="M. Mecanica";
							 $icono="Indicator1.gif";}
						 else if ($Area==2)
						         {$Area="M. Instrumentista";
								  $icono="Indicator2.gif";}
							  else if ($Area==3)
							          {$Area="M. Obras y Serv.";
									  $icono="Indicator3.gif";}
									else if ($Area==4)
									        {$Area="Electricistas";
											$icono="ico_negro.gif";} 
									else if ($Area==5)
									        {$Area="Personal Aseo";
											$icono="ico_cafe.gif";} 
									else if ($Area==6)
									        {$Area="Ingenieria";
											$icono="ico_naranja.gif";} 
									else if ($Area==7)
									        {$Area="Mec.Gr�as";
											$icono="ico_blanco.gif";} 
									else if ($Area==8)
									        {$Area="Lubricaci�n";
											$icono="Indicator4.gif";} 

						 
						 
						 
						 
						 
						 
						/* if ($Area==1)
						    {$Area="M. Mecanica";}
						 else if ($Area==2)
						         {$Area="M. Instrumentista";}
							  else if ($Area==3)
							          {$Area="M. Obras y Serv.";}
									else if ($Area==4)
									        {$Area="M. Electricas";}  	*/  	
						 echo'<TR class=lcol> ';
						 echo'<TD ><div align="center"><B>'.$i.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.strtoupper($usuario).'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$turno.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$compromiso.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$Area.'</B></div></TD>';
						 if ($condicion == 'S')
						{
							$condicion ='';
						 	$ico = "ico_x.gif";
							echo'<TD ><div align="center"><B>'.$condicion.'<img src="archivos/'.$ico.'" width="12" height="12"></B></div></TD>';
						}
						else
						{
							echo'<td> <div align="center">&nbsp;</div></td>';
						}

						 
						 
						 echo'<TD ><div align="left"><B>'.strtoupper($observacion).'</B></div></TD>';
						 echo"<TD ><div align='center'><a href=JavaScript:Eliminar(".$cod_novedad.");><img src='archivos/papelera.gif' width='15' height='15'></A></div></TD>";
						 echo'<TD width="10%" ><div align="center">';
						 echo "<a href=\"JavaScript:Modificar('$fecha','$cod_novedad','$turno')\">";
						 echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
						 echo'</TR>';
					    }
					}	
                //}
            ?>
            </TBODY>
          </TABLE>
       </TD>
	   		  	  <tr >
	     <td bgcolor="#0066CC" colspan="8">&nbsp;</td>
	  </tr>
	 <TR  vAlign=top  class=dt> 
	 <?php 
	     $sql="SELECT  SUBDATE('".$ano1.'-'.$mes1.'-'.$dia1."',INTERVAL 7 DAY) as fecha";
         $result=mysqli_query($link, $sql);
         $row = mysqli_fetch_array($result);
         $ano2=substr($row["fecha"],0,4);
         $mes2=substr($row["fecha"],5,2);
         $dia2=substr($row["fecha"],8,2)
	 ?> 
	  <TD width="90%" vAlign=bottom colspan=4> <H4><B>Mantenciones Realizadas entre&nbsp;&nbsp;<?php echo $dia2.'-'.$mes2.'-'.$ano2; ?>&nbsp;&nbsp;y&nbsp;&nbsp; <?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
       
      </TR>
      <TR class=lcol vAlign=top> 
        <TD colSpan=6 bgcolor="#0066CC"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TBODY>
              <TR class=lcol> 
                <TD width=2% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
                <TD width=15% ><div align="center"><font size="6"><strong>USUARIO</strong></font></div></TD>
                <TD width="5%"><div align="center"><font size="6"><strong>TURNO</strong></font></div></TD>
                <TD width="18%"><font size="6"><strong>FECHA EJECUCION</strong></font></TD>
				<TD width="13%"><font size="6"><strong>FECHA REAL</strong></font></TD>
                <TD width="15%"><div align="center"><font size="6"><strong>AREA</strong></font></div></TD>
                <TD width="32%"><font size="6"><strong>OBSERVACIONES</strong></font></TD>
              </TR>
              <?php
                 $consulta ="select t1.COD_NOVEDAD,t1.NOVEDAD,t1.usuario,T1.TURNO,t1.compromiso,t1.area,t1.fecha_real, t2.valor_subclase1 ";
                 $consulta .="from ref_web.novedades_jefe_hm as t1 ";
                 $consulta .="inner join proyecto_modernizacion.sub_clase as t2 "; 
                 $consulta .="on t1.TURNO=t2.nombre_subclase and t2.cod_clase = '1' ";
                 $consulta .="WHERE t1.fecha between '".$ano2.'-'.$mes2.'-'.$dia2."' and '".$fecha."' and t1.mantencion in ('S') and t1.estado='2'"; 
                 $consulta .=" ORDER BY t2.valor_subclase1,t1.FECHA ASC ";		   
				$respuesta=mysqli_query($link, $consulta);
                if(!$row = mysqli_fetch_array($respuesta))
                   {
				      echo'<TR class=lcol> ';
					  echo'<TD colspan="7" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				   }
				else {
				      $respuesta=mysqli_query($link, $consulta);
                      while($row = mysqli_fetch_array($respuesta))
                        {
                         $i++;
						 $cod_novedad= $row['COD_NOVEDAD'];
						 $observacion= $row['NOVEDAD'];
						 $turno= $row['TURNO'];
						 $usuario=$row[usuario];
						 $compromiso=$row[compromiso];
						 $Area=$row[area];
						 $fecha_real=$row[fecha_real];
						/* if ($Area==1)
						    {$Area="M. Mecanica";}
						 else if ($Area==2)
						         {$Area="M. Instrumentista";}
							  else if ($Area==3)
							          {$Area="M. Obras y Serv.";}
									else if ($Area==4)
									        {$Area="M. Electricas";}  */
							
							
						 if ($Area==1)
						    {$Area="M. Mecanica";}
						 else if ($Area==2)
						         {$Area="M. Instrumentista";}
							  else if ($Area==3)
							          {$Area="M. Obras y Serv.";}
									else if ($Area==4)
									        {$Area="M. Electricas";}  	 
									else if ($Area==5)
											{$Area= "Personal Aseo";}
									else if ($Area==6)
										{$Area="Ingenieria";}
									else if ($Area==7)
										{$Area="Mec. Gr�a";}
									else if	($Area==8)
										{$Area="Lubricaci�n";}

											
												  	
						 echo'<TR class=lcol> ';
						 echo'<TD ><div align="center"><B>'.$i.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.strtoupper($usuario).'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$turno.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$compromiso.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$fecha_real.'</B></div></TD>';
						 echo'<TD ><div align="center"><B>'.$Area.'</B></div></TD>';
						 echo'<TD><div align="left"><B>'.strtoupper($observacion).'</B></div></TD>';
						 echo"<TD ><div align='center'><a href=JavaScript:Eliminar(".$cod_novedad.");><img src='archivos/papelera.gif' width='15' height='15'></A></div></TD>";
						 echo'<TD width="10%" ><div align="center">';
						 echo "<a href=\"JavaScript:Modificar('$fecha','$cod_novedad','$turno')\">";
						 echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
						 echo'</TR>';
					    }
					}	
            ?>
            </TBODY>
          </TABLE>
       </TD>

    </TBODY>
  </TABLE>
</form>
</body>
</html>
