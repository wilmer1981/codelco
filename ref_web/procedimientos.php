<?php include("../principal/conectar_ref_web.php");

$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
$cmbtema = isset($_REQUEST["cmbtema"])?$_REQUEST["cmbtema"]:"";
$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";

   if ($cmbtema=="")
    {
	    $cmbtema='Todo';
	}
    $ano1=substr($fecha,0,4);
    $mes1=substr($fecha,5,2);
    $dia1=substr($fecha,8,2)	   
	   
 ?>

<html>
<head>
<title>Procedimientos</title>
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Eliminar(cod_procedimiento,fecha,cmbtema)
{
	var frm = document.FrmPrincipal;
	if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
     frm.action = "ing_procedimientos01.php?cod_procedimiento=" + cod_procedimiento+"&fecha="+fecha+"&Proceso=E"+"&cmbtema="+cmbtema;
	 frm.submit();
	}
}
function Imprimir()
{
	window.print();
}
function Recarga(fecha)
{
 var f = document.FrmPrincipal;
 f.action="procedimientos.php?fecha="+fecha+"&cmbtema="+f.cmbtema.value;
 f.submit();
}
function Modificar(FECHA,COD_TIPO_PROCEDIMIENTO,FECHA,DESDE,HASTA,PROCEDIMIENTO,COD_PROCEDIMIENTO)
{
 var f = document.FrmPrincipal;
 f.action="ing_procedimientos.php?tema="+COD_TIPO_PROCEDIMIENTO+"&fecha="+FECHA+"&DESDE="+DESDE+"&HASTA="+HASTA+"&PROCEDIMIENTO="+PROCEDIMIENTO+"&COD_PROCEDIMIENTO="+COD_PROCEDIMIENTO+"&modificar=S";
 f.submit();
}
</script>


<body>

<form name="FrmPrincipal" method="post" action="">
  <TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
    <TR  vAlign=top  class=dt> 
      <TD width="45%" vAlign=bottom colspan=2> 
        <H4><B>Comunicados &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
      <TD width="45%" vAlign=bottom><strong>TEMA:</strong> 
	  <?php
	         echo "<select name='cmbtema' onChange=\"JavaScript:Recarga('$fecha')\">";
			 echo '<option value="Todo">Todos los Procedimientos</option>';
			 $Consulta = "SELECT * FROM ref_web.tipo_procedimientos ORDER BY TIPO_PROCEDIMIENTO";
			 $Respuesta = mysqli_query($link, $Consulta);
			 while ($fila1=mysqli_fetch_array($Respuesta))
 			   {
				 if ($cmbtema==$fila1["COD_TIPO_PROCEDIMIENTO"])
				    echo "<option value='".$fila1["COD_TIPO_PROCEDIMIENTO"]."' selected>".$fila1["TIPO_PROCEDIMIENTO"]."</option>";
				 else
					echo "<option value='".$fila1["COD_TIPO_PROCEDIMIENTO"]."'>".$fila1["TIPO_PROCEDIMIENTO"]."</option>";
				}
			 echo '</select></td>';
                 
	       echo'<TD width="14%" ><div align="right">';
		   echo "<a href=\"JavaScript:Imprimir()\">";
		   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>';
	    ?>
    </TR>
    <?php
	    if ($cmbtema=='Todo')
		   {

			 $sqla = "select * from ref_web.tipo_procedimientos ORDER BY COD_TIPO_PROCEDIMIENTO";
		     $resulta=mysqli_query($link, $sqla);
		     while($rowa = mysqli_fetch_array($resulta))
			   {
				 $cod_tipo_procedimiento= $rowa['COD_TIPO_PROCEDIMIENTO'];
				 $tipo_procedimiento= $rowa['TIPO_PROCEDIMIENTO'];
			  	 echo'<TABLE width="95%" align="center" cellPadding=0 cellSpacing=0 >';
				 echo'<TBODY>';
			     echo'<TR  vAlign=top class=dt>'; 
			     echo'<TD width="90%" vAlign=bottom colspan=4> <H4><B>'.$tipo_procedimiento.'</B></H4></TD>';
			     echo'<TD  width="10%" vAlign=bottom><div align="right"></div></TD>';
			     echo'</TR>';
			     echo' <TR vAlign=top>'; 
			     echo'<TD colSpan=5 bgcolor="#0066CC">'; 
				 echo'<TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>';
				 echo'<TBODY>';
			     echo' <TR class=lcol>'; 
			     echo'<TD width=5% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>';
			     echo'<TD width=10% ><div align="center"><font size="6"><strong>USUARIO</strong></font></div></TD>';
			     echo'<TD width="20%"><div align="center"><font size="6"><strong>DESDE</strong></font></div></TD>';
			     echo'<TD width="20%"><div align="center"><font size="6"><strong>HASTA</strong></font></div></TD>';
			     echo'<TD width="50%" colspan="3"><div align="center"><font size="6"><strong>OBSERVACIONES</strong></font></div></TD>';
			     echo'</TR>';
				 $sqls = "select * from ref_web.procedimientos WHERE COD_TIPO_PROCEDIMIENTO = '$cod_tipo_procedimiento' and HASTA >='".$fecha."' and DESDE <= '".$fecha."' ORDER BY FECHA ASC";
				 $results=mysqli_query($link, $sqls);
				 $num = mysqli_num_rows($results);
			  	 $sql = "select * from ref_web.procedimientos WHERE COD_TIPO_PROCEDIMIENTO = '$cod_tipo_procedimiento' and HASTA >='".$fecha."' and DESDE <= '".$fecha."'ORDER BY FECHA ASC";
				 $result=mysqli_query($link, $sql);
				 if($num==0)
				   {
					  echo'<TR class=lcol> ';
					  echo'<TD colspan="8" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				   }
				 else
					{	$i=0;
					   while($row = mysqli_fetch_array($result))
					      {
						   $i++;
						   $tipo_procedimiento=$row["COD_TIPO_PROCEDIMIENTO"];
						   $cod_procedimiento= $row["COD_PROCEDIMIENTO"];
						   $procedimiento= $row["PROCEDIMIENTO"];
						   $desde= trim($row["DESDE"]);
						   $hasta= trim($row["HASTA"]);
						   $vigencia= $row["VIGENCIA"];
						   $usuario= $row["usuario"];
						   echo'<TR class=lcol> ';
						   echo'<TD width="5%" ><div align="center"><B>'.$cod_procedimiento.'</B></div></TD>';
						   echo'<TD width="10%" ><div align="center"><B>'.strtoupper($usuario).'</B></div></TD>';
						   echo'<TD width="20%" ><div align="center"><B>'.$desde.'</B></div></TD>';
						   echo'<TD width="20%" ><div align="center"><B>'.$hasta.'</B></div></TD>';
						   echo'<TD width="50%" ><div align="center"><B>'.strtoupper($procedimiento).'</B></div></TD>';
						   echo'<TD width="10%" ><div align="center">';
						   echo "<a href=\"JavaScript:Eliminar('$cod_procedimiento','$row[FECHA]')\">";
						   echo '<img src="archivos/papelera.gif" width="15" height="15" border="0"></A></div></TD>';
						   echo'<TD width="10%" ><div align="center">';
					       echo "<a href=\"JavaScript:Modificar('$fecha','$tipo_procedimiento','$fecha','$desde','$hasta','$procedimiento','$cod_procedimiento')\">";
					       echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
					       echo'</TR>';
						  }
					}
				echo'</TBODY>';
			    echo'</TABLE>';
			    echo'</TD>';
			    echo'</TR>';
				echo'</TBODY>';
			    echo'</TABLE>';
			    echo'<br>';
			 }	   
        }
		else {
		       $consulta = "select * ";
			   $consulta.="from ref_web.tipo_procedimientos  ";
			   $consulta.="where COD_TIPO_PROCEDIMIENTO='".$cmbtema."' ";
			   $resultado=mysqli_query($link, $consulta);
		       $row = mysqli_fetch_array($resultado);
		       echo'<TABLE width="95%" align="center" cellPadding=0 cellSpacing=0 >';
			   echo'<TBODY>';
			   echo'<TR  vAlign=top class=dt>'; 
			   echo'<TD width="90%" vAlign=bottom colspan=4> <H4><B>'.$row["TIPO_PROCEDIMIENTO"].'</B></H4></TD>';
			   echo'<TD  width="10%" vAlign=bottom><div align="right"></div></TD>';
			   echo'</TR>';
			   echo' <TR vAlign=top>'; 
			   echo'<TD colSpan=5 bgcolor="#0066CC">'; 
			   echo'<TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>';
			   echo'<TBODY>';
			   echo' <TR class=lcol>'; 
			   echo'<TD width=5% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>';
			   echo'<TD width=10% ><div align="center"><font size="6"><strong>USUARIO</strong></font></div></TD>';
			   echo'<TD width="20%"><div align="center"><font size="6"><strong>DESDE</strong></font></div></TD>';
			   echo'<TD width="20%"><div align="center"><font size="6"><strong>HASTA</strong></font></div></TD>';
			   echo'<TD width="50%" colspan="3"><div align="center"><font size="6"><strong>OBSERVACIONES</strong></font></div></TD>';
			   echo'</TR>';
		       $consulta = "select t1.COD_TIPO_PROCEDIMIENTO,t1.TIPO_PROCEDIMIENTO,t2.COD_PROCEDIMIENTO,t2.PROCEDIMIENTO,t2.DESDE,t2.DESDE,t2.HASTA,t2.VIGENCIA,t2.FECHA,t2.usuario ";
			   $consulta.="from ref_web.tipo_procedimientos as t1 ";
			   $consulta.="inner join ref_web.procedimientos as t2 on t1.COD_TIPO_PROCEDIMIENTO=t2.COD_TIPO_PROCEDIMIENTO ";
			   $consulta.="where t1.COD_TIPO_PROCEDIMIENTO='".$cmbtema."' and t2.COD_TIPO_PROCEDIMIENTO='".$cmbtema."' and  t2.HASTA >='".$fecha."' and t2.DESDE <= '".$fecha."'";
			   $resultado=mysqli_query($link, $consulta);
			   $cantidad = mysqli_num_rows($resultado);
			   if($cantidad==0)
				   {
					  echo'<TR class=lcol> ';
					  echo'<TD colspan="8" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
					  echo'</TR>';
				   }
				 else{$resultado=mysqli_query($link, $consulta);
		              while($row2 = mysqli_fetch_array($resultado))
					        {
							  echo'<TR class=lcol> ';
						      echo'<TD width="5%" ><div align="center"><B>'.$row2["COD_PROCEDIMIENTO"].'</B></div></TD>';
						      echo'<TD width="10%" ><div align="center"><B>'.strtoupper($row2["usuario"]).'</B></div></TD>';
						      echo'<TD width="20%" ><div align="center"><B>'.$row2["DESDE"].'</B></div></TD>';
						      echo'<TD width="20%" ><div align="center"><B>'.$row2["HASTA"].'</B></div></TD>';
						      echo'<TD width="40%" ><div align="center"><B>'.strtoupper($row2["PROCEDIMIENTO"]).'</B></div></TD>';
						      echo'<TD width="10%" ><div align="center">';
						      echo "<a href=\"JavaScript:Eliminar('".$row2["COD_PROCEDIMIENTO"]."','".$row2["FECHA"]."','$cmbtema')\">";
						      echo '<img src="archivos/papelera.gif" width="15" height="15" border="0"></A></div></TD>';
							  echo'<TD width="10%" ><div align="center">';
					          echo "<a href=\"JavaScript:Modificar('$fecha','".$row2["COD_TIPO_PROCEDIMIENTO"]."','".$row2["FECHA"]."','".$row2["DESDE"]."','".$row2["HASTA"]."','".$row2["PROCEDIMIENTO"]."','".$row2["COD_PROCEDIMIENTO"]."')\">";
					          echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
					  	      echo'</TR>';
							
							} 
					  
					 }
			   
			     
			  } 
	
     ?>
  </table>	 
</form>

</body>
</html>
