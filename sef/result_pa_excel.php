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
  
  echo "<table border=1 align=center>";
  echo "<tr>"; 
  echo "<th width=100 height=20>Fecha</th>";
  
  if ($ck1 == 1)
    echo "<th width=150 height=20>Turno</th>";
  if ($ck2 == 1)
    echo "<th width=150 height=20>Caudal</th>";
  if ($ck3 == 1) 
    echo "<th width=150 height=20>Horas Op.</th>";
  if ($ck4 == 1) 
    echo "<th width=150 height=20>Azufre</th>";  
  if ($ck5 == 1)  
    echo "<th width=150 heigth=20>Produccion</th>";
  echo "</tr>";  

  if ($ck1 == 1) 
    $consulta = "select * from Detalle_Pta_Acido where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq)";    
   
  if ($ck1 == 0)
    $consulta = "select Fecha,sum(Caudal) as Suma_caudal,sum(HorasOp) as Suma_horas,sum(Azufre) as Suma_azufre,sum(Produccion) as Suma_produccion from Detalle_Pta_Acido where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) group by Fecha";

  $rs = mysql_query($consulta);
  while ($row = mysql_fetch_array($rs))
  {
    echo "<tr align=center>";
    echo "<td width=100 height=20>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";
    if ($ck1 == 1)
      echo "<td width=150 height=20>".$row["Turno"]."</td>";
      
    if (($ck2 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20>".number_format($row["Caudal"],2,',','.')."</td>";
    if (($ck2 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20>".number_format($row["Suma_caudal"],2,',','.')."</td>";    
      
    if (($ck3 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20>".number_format($row["HorasOp"],2,',','.')."</td>";
    if (($ck3 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20>".number_format($row["Suma_horas"],2,',','.')."</td>";
      
    if (($ck4 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20>".number_format($row["Azufre"],2,',','.')."</td>";
    if (($ck4 == 1) and ($ck1 == 0))
      echo "<td width=150 heigth=20>".number_format($row["Suma_azufre"],2,',','.')."</td>";
      
    if (($ck5 == 1) and ($ck1 == 1))
      echo "<td width=150 heigth=20>".number_format($row["Produccion"],2,',','.')."</td>";
    if (($ck5 == 1) and ($ck1 == 0))
      echo "<td width=150 heigth=20>".number_format($row["Suma_produccion"],2,',','.')."</td>";      
      
    echo "</tr>";
  }
  echo "</table><br><br>";  
?>  


