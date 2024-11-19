 <?php include("../principal/conectar_ref_web.php");

$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";

$ano1=substr($fecha,0,4);
$mes1=substr($fecha,5,2);
$dia1=substr($fecha,8,2);
 //echo "Fecha:".$fecha;

?>

<HTML>
<HEAD>
<TITLE>Bombas</TITLE>

<LINK href="estilos/css_sea_web.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Eliminar(fecha,hora,cod_bomba,iso)
{
	var f = document.FrmPrincipal;
	if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
     f.action = "Ing_bombas01.php?fecha="+fecha+"&hora="+hora+"&cod_bomba="+cod_bomba+"&iso="+iso+"&Proceso=E";
	 f.submit();
	} 
}
function Imprimir()
{
	window.print();
}
function Modificar(fecha,circuito,bomba,iso,hora)
{
	var f = document.FrmPrincipal;
	f.action = "Ing_bombas.php?circuito="+circuito+"&bomba="+bomba+"&fecha="+fecha+"&iso="+iso+"&horas="+hora;
	f.submit();
}
//-->
</script>
<BODY>
<FORM action=""  method="post" name="FrmPrincipal">
  <TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm or">
    <TBODY>
      <TR vAlign=top  class=dt> 
        <TD vAlign=bottom> <H4><B>BOMBAS&nbsp;-&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
        <TD  width="25%" vAlign=bottom><div align="right"></div></TD>
        <TD  width="3%" vAlign=bottom><div align="right"></div></TD>
       <?php 
	       echo'<TD width="14%" ><div align="right">';
		   echo "<a href=\"JavaScript:Imprimir()\">";
		   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>';
	  ?>
      </TR>
      <TR vAlign=top> 
        <TD  colSpan=6   bgcolor="#FF9933">
          <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TBODY>
              <TR class=lcolor>
			   <TD width="111" height=24> <div align="center"><b>FUNCION</b></div></TD>
                <TD width="111" height=24> <div align="center"><b>NUMERACION</b></div></TD>
				<TD width="111" height=24> <div align="center"><b>ISO</b></div></TD>
				
                <TD width="47" height=24><div align="center"><b>SITU</b></font></div></TD>
                <TD width="71" height=24><div align="center"><b>ULT. FECHA</b></font></div></TD>
                
                <TD width="477" height="24" colspan="3"> <div align="center"><b>OBSERVACIONES 
                    DEL DIA</b></div></TD>
              </TR>
              <?php
			    $consulta="select t1.fecha,t1.cod_bomba,t1.iso,t1.hora,t1.observacion,t1.situacion,t2.bomba,t3.circuito,t3.cod_circuito ";
				$consulta.="from ref_web.historia_bombas as t1 ";
				$consulta.="inner join ref_web.bombas as t2 on t1.cod_bomba=t2.cod_bomba ";
				$consulta.="inner join ref_web.circuitos_bombas as t3 on t2.cod_circuito=t3.cod_circuito ";
				$consulta.="where t1.fecha=(select max(fecha) from ref_web.historia_bombas where cod_bomba=t1.cod_bomba and fecha<='".$fecha."') ";
				$consulta.="and t1.hora=(select max(hora) from ref_web.historia_bombas where cod_bomba=t1.cod_bomba and fecha=t1.fecha) order by t1.cod_bomba";
				$resultado=mysqli_query($link, $consulta);
				if(!$row1 = mysqli_fetch_array($resultado))
                   {
				      echo'<TR class=lcolor> ';
					  echo'<TD colspan="8" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				   }
				else {
				        $resultado=mysqli_query($link, $consulta);
						while($row1 = mysqli_fetch_array($resultado))
						{    	  
							  if($row1["situacion"]=="En Servicio")
								  {$icono="Indicator1.gif";}
							  if($row1["situacion"]=="Fuera de Servicio")
								  {$icono="Indicator2.gif";}
							  if($row1["situacion"]=="En Observacion")
								   {$icono="Indicator3.gif";}
							  if($row1["situacion"]=="En Mantencion")
								   {$icono="Indicator4.gif";}  
							  echo'<TR class=lcolor> ';
							  echo'<TD width="118" ><div align="center"><B>'.$row1["circuito"].'</B></div></TD>';
							  echo'<TD width="118" ><div align="center"><B>'.$row1["bomba"].'</B></div></TD>';
							  if ($row1["iso"]=='S')
							     {
								   echo'<TD width="118" ><div align="center"><B><img src="../principal/imagenes/ico_ok.gif" width="12" height="12"></B></div></TD>';
								 }
							  else{
							       echo'<TD width="118" ><div align="center"><B>&nbsp;</B></div></TD>';
							      }   
							  echo'<TD width="72" ><div align="center"><img src="archivos/'.$icono.'" width="12" height="12"></div></TD>';
							  echo'<TD width="128" ><div align="center"><B>'.$row1["fecha"].'</B></div></TD>';
							 // echo'<TD width="128" ><div align"center"><B>&nbsp;'.$row1["hora"].'</B></div></TD>';
							  echo'<TD width="273" ><div align"center"><B>&nbsp;'.$row1["observacion"].'</B></div></TD>';
							  echo'<TD width="5%" ><div align="center">';
							  echo "<a href=\"JavaScript:Eliminar('".$row1["fecha"]."','".$row1["hora"]."','".$row1["cod_bomba"]."','".$row1["iso"]."')\">";
							  echo '<img src="archivos/papelera.gif" width="15" height="15" border="0"></A></div></TD>';
							  echo'<TD width="5%" ><div align="center">';
							  echo "<a href=\"JavaScript:Modificar('".$row1["fecha"]."','".$row1["cod_circuito"]."','".$row1["cod_bomba"]."','".$row1["iso"]."','".$row1["hora"]."')\">";

							  //echo "<a href=\"JavaScript:Modificar('$fecha','".$row1["cod_circuito"]."','".$row1["cod_bomba"]."','".$row1["iso"]."','".$row1["hora"]."')\">";
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
