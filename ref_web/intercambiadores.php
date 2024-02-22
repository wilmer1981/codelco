 <?php include("../principal/conectar_sec_web.php"); 
    $ano1=substr($fecha,0,4);
    $mes1=substr($fecha,5,2);
    $dia1=substr($fecha,8,2)
 
 ?>


<HTML>
<HEAD>
<TITLE>Intercambiadores de Calor</TITLE>

<LINK href="estilos/css_sea_web.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Eliminar(fecha,hora,intercambiador)
{
	var f = document.FrmPrincipal;
	if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
      f.action = "Ing_intercambiadores01.php?fecha="+fecha+"&hora="+hora+"&intercambiador="+intercambiador+"&Proceso=E";
	  f.submit();
	}  
}
function Imprimir()
{
	window.print();
}
function Modificar(fecha,intercambiador)
{
	var f = document.FrmPrincipal;
	f.action = "Ing_intercambiadores.php?intercambiador="+intercambiador+"&fecha="+fecha;
	f.submit();
}
//-->
</script>
<BODY>
<FORM action="" method=post name="FrmPrincipal">
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm dyl">
 <TR vAlign=top  class=dt> 
   <TD vAlign=bottom     width="90%"  colSpan=5 ><H4><B>INTERCAMBIADORES&nbsp;-&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
    <TD width="10%" ><div align="right"><a href="JavaScript:Imprimir()"><img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>
 </TR>
 <TR vAlign=top> 
   <TD  colSpan=6 bgcolor="#FFCC00"> 
   <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
      <TR class=lcolam> 
         <TD width="128" height=24> <div align="center"><b>EQUIPOS</b></div></TD>
         <TD width="59" height=24><div align="center"><b>SITU</b></font></div></TD>
         <TD width="76" height=24><div align="center"><b>ULT. FECHA</b></font></div></TD>
         <TD width="718" height="24" colspan="3"> <div align="center"><b>OBSERVACIONES DEL DIA</b></div></TD>
      </TR>
             <?php
			 
			    $consulta="select t1.fecha,t1.cod_intercambiador,t1.hora,t1.observacion,t1.situacion,t2.intercambiador ";
				$consulta.="from ref_web.historia_intercambiadores as t1 ";
				$consulta.="inner join ref_web.intercambiadores as t2 on t1.cod_intercambiador=t2.cod_intercambiador ";
				$consulta.="where t1.fecha=(select max(fecha) from ref_web.historia_intercambiadores where cod_intercambiador=t1.cod_intercambiador and fecha<='".$fecha."') ";
				$consulta.="and t1.hora=(select max(hora) from ref_web.historia_intercambiadores where cod_intercambiador=t1.cod_intercambiador and fecha=t1.fecha) order by t1.cod_intercambiador asc";
			    //echo $consulta;
			 	$resultado=mysqli_query($link, $consulta);
				if(!$row1 = mysqli_fetch_array($resultado))
                   {
				      echo'<TR class=lcolam> ';
					  echo'<TD colspan="6" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				   }
				else {
				        $resultado=mysqli_query($link, $consulta);				
						while($row1 = mysqli_fetch_array($resultado))
							{    	  
							  if($row1[situacion]=="En Servicio")
								  {$icono="Indicator1.gif";}
							  if($row1[situacion]=="Fuera de Servicio")
								  {$icono="Indicator2.gif";}
							  if($row1[situacion]=="En Observacion")
								   {$icono="Indicator3.gif";}
							  if($row1[situacion]=="En Mantencion")
								   {$icono="Indicator4.gif";}  
							  echo'<TR class=lcolam> ';
							  echo'<TD width="118" ><div align="center"><B>'.$row1[intercambiador].'</B></div></TD>';
							  echo'<TD width="72" ><div align="center"><img src="archivos/'.$icono.'" width="12" height="12"></div></TD>';
							  echo'<TD width="128" ><div align="center"><B>'.$row1["fecha"].'</B></div></TD>';
							  echo'<TD width="273" ><div align"center"><B>&nbsp;'.$row1["observacion"].'</B></div></TD>';
							  echo'<TD width="5%" ><div align="center">';
							  echo "<a href=\"JavaScript:Eliminar('$row1["fecha"]','$row1[hora]','$row1[cod_intercambiador]')\">";
							  echo '<img src="archivos/papelera.gif" width="15" height="15" border="0"></A></div></TD>';
 						      echo'<TD width="5%" ><div align="center">';
							  echo "<a href=\"JavaScript:Modificar('$fecha','$row1[cod_intercambiador]')\">";
							  echo '<img src="archivos/modificar.gif" width="15" height="15" border="0"></A></div></TD>';
							  echo'</TR>';
							}
					}		
			  ?>
            </TBODY>
          </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>
<br>
<br>
</FORM>
</BODY>
</HTML>
