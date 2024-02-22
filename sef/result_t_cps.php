<? include("conectar.php") ?>

<html>
<head>
<title></title>
<LINK href="style2.css" rel=StyleSheet type=text/css>
<Script language=JavaScript>
function volver(f)
{
  f.action = 'index.php';
  f.submit();
}

//**********************//
function excel(f)
{
  f.action = 'result_t_cps_excel.php';
  f.submit();
}

//**********************//
function imprimir()
{
  window.print();
}

//**********************//
function graficar(f)
{
  open("menu_graf_t_cps.php?fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value+"&cod_eq="+f.cod_eq.value+"&num_cps="+f.num_cps.value,"","toolbar=no,directories=no,menubar=no,status=yes,width=300,height=200,top=250,left=200");  
}

</Script>
</head>

<body bgcolor="#ffffff" text="#000000" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5">
<form name=form1 action="" method="post">

<?
  $consulta = "select * from equipos where cod_equipo=".$cod_eq;  
  $rs_eq = mysql_query($consulta);
  $row_eq = mysql_fetch_array($rs_eq);

  echo "<table align=center border=0>";
  echo "<tr>";
  echo "<td width=80 height=20><b>Equipo:</b></td>";
  echo "<td width=260 height=20><b>".$row_eq["Nombre_equipo"]."</b></td>";
  echo "</tr>";
  echo "</table>"; 
  
  echo "<table border=0><tr><td width=125></td><td>";
  echo "Periodo Consultado: ".substr($fecha_inicio,8,2)."/".substr($fecha_inicio,5,2)."/".substr($fecha_inicio,0,4)." al ".substr($fecha_final,8,2)."/".substr($fecha_final,5,2)."/".substr($fecha_final,0,4);
  echo "</td></tr></table><br>";
  
  echo "<table border=0 align=center ID=tabla1>";
  echo "<tr>"; 
  echo "<th width=100 height=20 ID=campo1>Fecha</th>";
  
  if ($ck1 == 1)
    echo "<th width=150 height=20 ID=campo1>Nº de Carga</th>";
  if ($ck2 == 1)
    echo "<th width=150 height=20 ID=campo1>Hrs. Soplado</th>";
  echo "</tr>";  


  if ($num_cps == 0)
    $consulta = "select * from detalle_cps where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') and (Cod_equipo in (7,8,9))";    
  else $consulta = "select * from detalle_cps where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') and (Cod_equipo = $cod_eq)"; 
  
  if ($ck1 == 1) //muestra el detalle por numero de carga
  {
    $rs = mysql_query($consulta);
    while ($row = mysql_fetch_array($rs))
    {
      echo "<tr align=center>";
      echo "<td width=100 height=20 ID=campo2>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";
    
      if ($ck1 == 1)
        echo "<td width=150 height=20 ID=campo2>".$row["Num_carga"]."</td>";
    
      if ($ck2 == 1) 
      {
        $h1 = substr($row["Inicio_soplado"],0,2);
        $m1 = substr($row["Inicio_soplado"],3,2);
        $h2 = substr($row["Fin_soplado"],0,2);
        $m2 = substr($row["Fin_soplado"],3,2);
        
	if ((($h2 == 0) or ($h2 == 1) or ($h2 == 2)) and (($h1 == 23) or ($h1 == 22) or ($h1 == 21)))
	  $h2 = 24;

        $hora1 = $h1 + ($m1 / 60);
        $hora2 = $h2 + ($m2 / 60);

        if ($hora2 > $hora1)
          $resto = ($hora2 - $hora1);
        else $resto = ($hora1 - $hora2);  
 
      }
      if ($ck2 == 1)
        echo "<td width=150 height=20 ID=campo2>".number_format($resto,2,',','.')."</td>";      
      echo "</tr>";
    } 
  }


  if ($ck1 == 0)  //muestra el total por dia
  {
    $resto = 0;
    $cont = 0;
    $fecha_aux = '0000-00-00'; 
    $rs = mysql_query($consulta);
    $cantidad = 0;
    while ($row = mysql_fetch_array($rs))
    {         
      if ($row["Fecha"] != $fecha_aux)
      {
        echo "<tr align=center>";
        echo "<td width=100 height=20 ID=campo2>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";     
        $fecha_aux = $row["Fecha"];

        if ($num_cps == 0)
          $consul_cant = "select count(*) as cantidad from detalle_cps where (Fecha = '$fecha_aux') and (Cod_equipo in (7,8,9))";    
        else $consul_cant = "select count(*) as cantidad from detalle_cps where (Fecha = '$fecha_aux') and (Cod_equipo = $cod_eq)";

        $rs_cant = mysql_query($consul_cant);
	$row_cant = mysql_fetch_array($rs_cant);

      }  	
      
      if ($row["Fecha"] == $fecha_aux)
      {
        $cont = $cont + 1;
        $h1 = substr($row["Inicio_soplado"],0,2);
        $m1 = substr($row["Inicio_soplado"],3,2);
        $h2 = substr($row["Fin_soplado"],0,2);
        $m2 = substr($row["Fin_soplado"],3,2);

	if ((($h2 == 0) or ($h2 == 1) or ($h2 == 2)) and (($h1 == 23) or ($h1 == 22) or ($h1 == 21)))
	  $h2 = 24;

        $hora1 = $h1 + ($m1 / 60);
        $hora2 = $h2 + ($m2 / 60);

        if ($hora2 > $hora1)
          $resto = $resto + ($hora2 - $hora1);
        else $resto = $resto + ($hora1 - $hora2);   
      }
      
      if ($row_cant["cantidad"] == $cont)
      {
        if ($ck2 == 1)
	  echo "<td width=150 height=20 ID=campo2>".number_format($resto,2,',','.')."</td>";
	echo "</tr>";
	$cont = 0;
	$resto = 0;
      }	
    }      
  }  
    
  echo "</table><br><br>";  
    
?>  

<?
  echo "<center>";
  echo "<input type=button value=Imprimir onClick='JavaScript:imprimir()' ID=boton1>\n";
  echo "<input type=button value=Excel onClick='JavaScript:excel(this.form)' ID=boton1>\n";
  echo "<input type=button value=Graficar onClick='JavaScript:graficar(this.form)' ID=boton1>\n";
  echo "<input type=button value=Volver onClick='JavaScript:window.history.back();' ID=boton1>\n";
  echo "<input type=button value='Volver al Menu' onClick='JavaScript:volver(this.form)' ID=boton1></td>";
  echo "</center>";
?>
  
<?
  //campos ocultos
  echo "<input type=hidden name=fecha_inicio value=$fecha_inicio>";
  echo "<input type=hidden name=fecha_final  value=$fecha_final>";

  echo "<input type=hidden name=ck1 value=$ck1>";
  echo "<input type=hidden name=ck2 value=$ck2>";

  echo "<input type=hidden name=cod_eq value=$cod_eq>";
  echo "<input type=hidden name=num_cps value=$num_cps>";
?>

</form>
</body>
</html>


    
  



