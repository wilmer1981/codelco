<?
  header("Content-Type:  application/vnd.ms-excel");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  include("conectar.php");
  include("funciones.php");
  
  $consulta = "select * from equipos where cod_equipo=".$cod_eq;  
  $rs_eq = mysql_query($consulta);
  $row_eq = mysql_fetch_array($rs_eq);

  $consulta = "select * from productos where cod_producto=".$cod_pro;
  $rs_pr = mysql_query($consulta);
  $row_pr = mysql_fetch_array($rs_pr);
  
  echo "<table align=center border=0>";
  echo "<tr>";
  echo "<td width=80 height=20><b>Equipo:</b></td>";
  echo "<td width=260 height=20><b>".$row_eq["Nombre_equipo"]."</b></td>";
  echo "<td width=80 height=20><b>Producto:</b></td>";
  echo "<td width=290 height=20><b>".$row_pr["Nom_Producto"]."</b></td>";
  echo "</tr>";
  echo "</table>";  

  echo "<table border=1 align=center>";
  echo "<tr>"; 
  echo "<th width=100 height=20>Fecha</th>";
  
  if ($ck1 == 1)
    echo "<th width=150 height=20>Nº de cargas</th>";
  if ($ck3 == 1)
    echo "<th width=150 height=20>Cantidad de Movimiento</th>";
  if ($ck4 == 1) 
    echo "<th width=150 height=20>Peso Movimiento</th>";
  if ($ck2 == 1) 
    echo "<th width=150 height=20>Unidad</th>";      
  if ($ck5 == 1) 
    echo "<th width=150 heigth=20>Origen</th>";
  if ($ck6 == 1) 
    echo "<th width=150 heigth=20>Destino</th>";


  //se selecciona la consulta de acuerdo al equipo de origen.
  
  if (($origen == 5) or ($origen == 2) or ($origen == 1) or ($origen == 3))
  {

    //si ck1 (Nº de carga) esta seleccionado mostrar los detelles del dia.
    //opc = 1 Entrada; opc = 2 Salida. 
    if (($opc == 1) and ($num_cps == 0) and ($ck1 == 1))                  
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E') and (Origen = $origen)";

    if (($opc == 1) and ($num_cps !=0) and ($ck1 == 1))
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E') and (Origen = $origen)";

    if (($opc == 2) and ($num_cps == 0) and ($ck1 == 1))
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S') and (Origen = $origen)";

    if (($opc == 2) and ($num_cps != 0) and ($ck1 == 1))  
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S') and (Origen = $origen)";

    //si ck1 (Nº de carga) no esta seleccionado realizar agrupamientos por dia.
    if (($opc == 1) and ($num_cps == 0) and ($ck1 == 0))	
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E') and (Origen = $origen) group by Fecha,Cod_Unidad";

    if (($opc == 1) and ($num_cps != 0) and ($ck1 == 0))
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E') and (Origen = $origen) group by Fecha,Cod_Unidad";

    if (($opc == 2) and ($num_cps == 0) and ($ck1 == 0))
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S') and (Origen = $origen) group by Fecha,Cod_Unidad";

    if (($opc == 2) and ($num_cps != 0) and ($ck1 == 0))  
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S') and (Origen = $origen) group by Fecha,Cod_Unidad";
 
  }
  else
  {
    if (($opc == 1) and ($num_cps == 0) and ($ck1 == 1))                  
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E')";

    if (($opc == 1) and ($num_cps != 0) and ($ck1 == 1))
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E')";

    if (($opc == 2) and ($num_cps == 0) and ($ck1 == 1))
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S')";

    if (($opc == 2) and ($num_cps != 0) and ($ck1 == 1))  
      $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S')";

    //si ck1 (Nº de carga) no esta seleccionado realizar agrupamientos por dia.
    if (($opc == 1) and ($num_cps == 0) and ($ck1 == 0))	
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E') group by Fecha,Cod_Unidad";

    if (($opc == 1) and ($num_cps != 0) and ($ck1 == 0))
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E') group by Fecha,Cod_Unidad";

    if (($opc == 2) and ($num_cps == 0) and ($ck1 == 0))
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S') group by Fecha,Cod_Unidad";

    if (($opc == 2) and ($num_cps != 0) and ($ck1 == 0))  
      $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S') group by Fecha,Cod_Unidad";
  }

  //consultar el peso base
  $consulta2 = "select * from Producto_por_equipo where (Cod_equipo = 6) and (Cod_producto = $cod_pro)";
  $rs_peso = mysql_query($consulta2);
  $row_peso = mysql_fetch_array($rs_peso);  

  $rs = mysql_query($consulta);
  while ($row = mysql_fetch_array($rs))
  {
    echo "<tr align=center>";
    echo "<td width=100 height=20>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";
    if ($ck1 == 1)
      echo "<td width=150 height=20>".$row["Num_carga"]."</td>";
    if (($ck3 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20>".number_format($row["Cantidad_mov"],2,',','.')."</td>";
    if (($ck3 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20>".number_format($row["Suma_mov"],2,',','.')."</td>";    
    if (($ck4 == 1) and ($ck1 == 1))  
      echo "<td width=150 height=20>".number_format(($row["Cantidad_mov"] * $row_peso["Peso_base"]),0,',','.')."</td>";
    if (($ck4 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20>".number_format(($row["Suma_mov"] * $row_peso["Peso_base"]),0,',','.')."</td>";
    if ($ck2 == 1) 
      echo "<td width=150 height=20>".cambiar_unidad($row["Cod_Unidad"])."</td>";      
    if ($ck5 == 1)
      echo "<td width=150 heigth=20>".cambiar($row["Origen"])."</td>";
    if ($ck6 == 1)
      echo "<td width=150 heigth=20>".cambiar($row["Destino"])."</td>";
    echo "</tr>";
  }
  echo "</table><br><br>";  
?>  
