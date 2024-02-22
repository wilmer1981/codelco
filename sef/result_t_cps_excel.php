<?
  header("Content-Type:  application/vnd.ms-excel");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  include("conectar.php");

  $consulta = "select * from equipos where cod_equipo=".$cod_eq;  
  $rs_eq = mysql_query($consulta);
  $row_eq = mysql_fetch_array($rs_eq);

  echo "<table align=center border=0>";
  echo "<tr>";
  echo "<td width=80 height=20><b>Equipo:</b></td>";
  echo "<td width=260 height=20><b>".$row_eq["Nombre_equipo"]."</b></td>";
  echo "</tr>";
  echo "</table>"; 
  
  echo "<table border=1 align=center ID=tabla1>";
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
