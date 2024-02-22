<?php include("../principal/conectar_sec_web.php"); 

$carpeta="archivos/";

if(!isset($ingreso)){$ingreso="Todos";} ?>
<html>
<head>
<script language="JavaScript">
function Proceso(opcion)
{
	 var f = document.FrmPrincipal;
     fecha=f.ano1.value+'-'+f.mes1.value+'-'+f.dia1.value;
	 f.action ="his_bombas.php?fecha="+fecha;
	 f.submit();
}
function Imprimir()
{
	window.print();
}
</script>
<title>Documento sin t&iacute;tulo</title>
</head>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<body>
<FORM action="" method="post" name="FrmPrincipal" >
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
 <TR  vAlign=top  class=dt> 
  <TD vAlign=bottom> <H4><B>BUSCAR HISTORIA BOMBAS</B></H4></TD>
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
     <TD width="1" align="center">&nbsp;</td>
     <TD width="722" align="center">
     <TABLE height="100%" cellSpacing=0 cellPadding=0  align="center" width="100%" border=0>
       <TR> 
         <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
       </TR>
       <TR> 
         <TD> 
	       <TABLE cellSpacing=0 cellPadding=0 width="99%" border=0>
           <TR> 
            <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7  bord er=0></TD>
            <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
            <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
           </TR>
           <TR> 
            <TD width="100%" colSpan=3>
           <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
             <TR> 
              <TD width="0%" rowspan="2">&nbsp; </TD>
              <TD width="20%"><input type=radio value="En Servicio" name=ingreso   <?php if($ingreso=="En Servicio"){echo'checked';} ?>  > 
              <FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Servicio</font></TD>
              <TD width="21%"><input type=radio value="Fuera de Servicio" name=ingreso   <?php if($ingreso=="Fuera de Servicio"){echo'checked';} ?>  > 
              <font style="FONT-WEIGHT: bold; COLOR: #000000">Fuera de Servicio</font> 
              <TD width="11%"> 
              <input type=radio value="Todos" name=ingreso <?php if($ingreso=="Todos"){echo'checked';} ?>  > 
              <font style="FONT-WEIGHT: bold; COLOR: #000000">Todo</font> 
              <TD width="48%"><font style="FONT-WEIGHT: bold; COLOR: #000000">Desde</font> 
              <select name="dia1" size="1" >
               <?php
				for($i=1;$i<31;$i++)
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
                </select> <b><font face="Arial, Helvetica, sans-serif"> 
                <select name="mes1" size="1" id="select">
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
           <select name="ano1" size="1" id="select2">
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
           </font></b><img height=8 src="archivos/spaceit.gif" width=10 border=0><b><font face="Arial, Helvetica, sans-serif"></font></b> 
           <b><font face="Arial, Helvetica, sans-serif"> 
           <input name="buscar" type=submit onClick="JavaScript:Proceso('G')" value="Buscar">
           </font></b> 
           <div align="left"><b><font face="Arial, Helvetica, sans-serif"> 
           </font></b></div></TR>
           <TR> 
            <TD><input type=radio value="En Observacion" name=ingreso   <?php if($ingreso=="En Observacion"){echo'checked';} ?>  > 
            <font style="FONT-WEIGHT: bold; COLOR: #000000">En Observación</font> </TD>
            <TD width="21%"><input type=radio value="En Mantencion" name=ingreso   <?php if($ingreso=="En Mantencion"){echo'checked';} ?>  > 
            <font style="FONT-WEIGHT: bold; COLOR: #000000">En Mantención</font>
            <TD width="11%">&nbsp;
            <TD><font style="FONT-WEIGHT: bold; COLOR: #000000">Bomba</font> 
            <select name="bomba"  size="1">
             <option value="x" selected>Seleccionar</option>
             <?php
	           $Consulta = "SELECT * FROM ref_web.bombas ORDER BY bomba";
	           $Respuesta = mysqli_query($link, $Consulta);
	           while ($Row = mysqli_fetch_array($Respuesta))
		           {
		            $cod_bomba=$Row[cod_bomba];
			        if ($bomba==$cod_bomba)
			          {
			           echo "<option value='".$cod_bomba."' selected>".$Row['bomba']."</option>\n";
                      }
                   else {
			             echo "<option value='".$Row['cod_bomba']."'>".$Row['bomba']."</option>\n";
				        }
		         }
            ?>
           </select>
          </TR>
        </TABLE>
           <TR> 
             <TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
             <TD vAlign=bottom> <IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
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
      <TD width=5% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
      <TD width=5% ><div align="center"><font size="6"><strong>SITU</strong></font></div></TD>
      <TD width=10% ><div align="center"><font size="6"><strong>FECHA</strong></font></div></TD>
      <TD width=10% ><div align="center"><font size="6"><strong>HORA</strong></font></div></TD>
      <TD width=10% ><div align="center"><font size="6"><strong>BOMBA</strong></font></div></TD>
      <TD width=60% ><div align="left"><font size="6"><strong>OBSERVACION</strong></font></div></TD>
    </TR>
<?php
  $consulta_f_sist="select left(sysdate(),10) as f_actual";
  $resultado=mysqli_query($link, $consulta_f_sist);
  $row_f_sist = mysqli_fetch_array($resultado);
  $color_i=0;
  if(!isset($page))
    {
	 $page =1;
	}
  if($ingreso=="Todos")
	{
	 $sql = "select * from ref_web.historia_bombas where fecha between '".$fecha."' and '".$row_f_sist[f_actual]."' and cod_bomba='".$bomba."' ORDER BY fecha DESC";
	}
 else{
      $sql = "select * from ref_web.historia_bombas WHERE situacion = '$ingreso' and fecha between '".$fecha."' and '".$row_f_sist[f_actual]."'  and cod_bomba='".$bomba."' ORDER BY FECHA DESC";
	 }
 $result=mysqli_query($link, $sql);
 $encontrados=1 ;
 $cantidad =1   ;
 $contador=0;
 while($row = mysqli_fetch_array($result))
  {
   $contador=$contador+1;
   if($contador >= 50*($page-1))
     {
      if($contador <= 50*$page)
       {
        $situacion= $row[situacion];
        $cod_equipo=$row[cod_bomba];
		if($situacion=="En Servicio")
		  {
		   $icono="Indicator1.gif";
		  }
		if($situacion=="Fuera de Servicio")
		  {
		   $icono="Indicator2.gif";
		  }
		if($situacion=="En Observacion")
		  {
		   $icono="Indicator3.gif";
		  }
		if($situacion=="En Mantencion")
		  {
		   $icono="Indicator4.gif";
		  }
        $cantidad=$cantidad+1   ;
        $indice=$contador;
        if ( $j==1)
		   {
		    $color= "lcol";$j=0;
		   }
		else{
		     $color= "lcolver";$j=1;
			} //color fila

		$sql3 = "select * from ref_web.bombas WHERE cod_bomba= '$cod_equipo'";
        $result3=mysqli_query($link, $sql3);
        $row3 = mysqli_fetch_array($result3);
        $equipo=$row3[bomba];
        echo '<TR class='.$color.'>';
        echo '<TD align=center height=15>'.$indice.'</TD>';
        echo '<TD ><div align="center"><img src="archivos/'.$icono.'" width="12" height="12"></div></TD>';
        echo '<TD align=center>'.$row["fecha"].'</TD>';
        echo '<TD align=center>'.$row[hora].'</TD>';
        echo '<TD align=center>'.$equipo.'</TD>';
        echo '<TD align=left>'.$row["observacion"].'</TD>';
        }
      }
    }
echo ' </TR> ';
echo ' </TABLE> ';

$sql="select * from ref_web.historia_bombas  where fecha between '".$fecha."' and '".$row_f_sist[f_actual]."' and cod_bomba='".$bomba."'";
$result=mysqli_query($link, $sql);
if($row = mysqli_fetch_array($result))
  {
    $cuenta=0  ;
    while($row = mysqli_fetch_array($result))
     {
      $cuenta=$cuenta+1;
     }
  }
$paginas=ceil(($contador/50)) ;
echo '<TR>';
echo '<TD align=middle colSpan=3 >';
echo '<HR>'; 
echo '</TD>'; 
echo '</TR>';
echo '<TR>';
echo '<TD align=middle colSpan=3  bgcolor="#ffffff"> PAGINAS</TD>'; 
echo '</TR>';
echo '<TR>';
echo '<TD align=middle colSpan=3  bgcolor="#ffffff">'; 
if($page != 1) 
  { 
   echo'<A href="his_bombas.php?page='.($page - 1).'&fecha='.$fecha.'"><strong>&lt;&lt;&lt;</strong></A>&nbsp; &nbsp; &nbsp;'; 
  }
$in = 1;
while($in <= $paginas)
 {
  if($in==$page)
    {
     echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT color=#0000FF><b>'.$in.'</b></FONT>&nbsp;&nbsp;&nbsp;';
    }
 else
     {
      echo '&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;<A href="his_bombas.php?ingreso='.$ingreso.'&amp;page='.$in.'&fecha='.$fecha.'"><FONT class=tiny>'.$in.'</FONT></A>&nbsp;&nbsp;&nbsp;';
      if($in==$paginas)
        {
         echo '&nbsp; &nbsp; &nbsp; <A href="his_bombas.php?page='.($page + 1).'&fecha='.$fecha.'">&gt;&gt;&gt;</A>';
        }
     }
     $in = $in + 1;
    }
echo '</TD>';
echo '</TR>';
?>
</TABLE>
</TD> 
</TR> 
<TR>        
<TD>         
</table>
</FORM>
</BODY>
</HTML>
