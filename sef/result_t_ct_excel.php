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
    echo "<th width=150 height=20 ID=campo1>Turno</th>";
  if ($ck2 == 1)
    echo "<th width=150 height=20 ID=campo1>Hrs. Desconexion</th>";
  echo "</tr>";  

  if ($ck1 == 1) 
    $consulta = "select Fecha,Turno,sum(Horas_desc) as Suma_hrs from tiempo_desconexion where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') and (Cod_equipo = $cod_eq) group by Fecha,Turno";    
   
  if ($ck1 == 0)
    $consulta = "select Fecha,sum(Horas_desc) as Suma_hrs from tiempo_desconexion where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') and (Cod_equipo = $cod_eq) group by Fecha";

  $rs = mysql_query($consulta);
  while ($row = mysql_fetch_array($rs))
  {
    echo "<tr align=center>";
    echo "<td width=100 height=20 ID=campo2>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";
    if ($ck1 == 1)
      echo "<td width=150 height=20 ID=campo2>".$row["Turno"]."</td>";
      
    if ($ck2 == 1) 
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Suma_hrs"],2,',','.')."</td>";
       
    echo "</tr>";
  }
  echo "</table><br><br>";  
?>  
