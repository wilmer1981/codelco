<?
  header("Content-Type:  application/vnd.ms-excel");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

  include("conectar.php");
  include("funciones.php");
 

  $consulta = "select * from equipos where cod_equipo=".$cod_eq;  
  $rs_eq = mysql_query($consulta);
  $row_eq = mysql_fetch_array($rs_eq);

  if ($opc == 1)
  {
    $consulta = "select * from productos where cod_producto=".$cod_pro;
    $rs_pr = mysql_query($consulta);
    $row_pr = mysql_fetch_array($rs_pr);
  }  
   
  echo "<table align=center border=0>";
  echo "<tr>";
  echo "<td width=80 height=20><b>Equipo:</b></td>";
  echo "<td width=260 height=20><b>".$row_eq["Nombre_equipo"]."</b></td>";
  if ($opc == 1)
  {
    echo "<td width=80 height=20><b>Producto:</b></td>";
    echo "<td width=290 height=20><b>".$row_pr["Nom_Producto"]."</b></td>";
  }  
  echo "</tr>";
  echo "</table>";  

  echo "<table border=1 align=center>";
  echo "<tr>"; 
  echo "<th width=100 height=20>Fecha</th>";

  if ($opc == 1)
  {
    if ($ck1 == 1)
      echo "<th width=150 height=20>Turno</th>";
    if ($ck2 == 1)
      echo "<th width=150 height=20>Cantidad de Movimiento</th>";
    if ($ck3 == 1) 
      echo "<th width=150 height=20>Peso Movimiento</th>";
    if ($ck4 == 1) 
      echo "<th width=150 height=20>Unidad</th>";  
    if (($ck5 == 1) and ($ck1 == 1))
      echo "<th width=150 heigth=20>Origen</th>";
    if (($ck6 == 1) and ($ck1 == 1))
      echo "<th width=150 heigth=20>Destino</th>";

    if (($ley == 1) or ($ley == 2))  
    {
      if ($ck7 == 1)
        echo "<th width=150 heigth=20>Cobre</th>";
    }
    if ($ley == 2)
    {  
      if ($ck8 == 1)
        echo "<th width=150 heigth=20>Silice</th>";
      if ($ck9 == 1)  
        echo "<th width=150 heigth=20>Magnetita</th>";
    }  
  }
  if ($opc == 2)
  {
    if ($ck1 == 1)
      echo "<th width=150 height=20>Turno</th>"; 
    if ($ck2 == 1) 
      echo "<th width=150 height=20>Tobera</th>";  
    if ($ck3 == 1) 
      echo "<th width=150 height=20>Aire Soplado</th>";  
    if ($ck4 == 1) 
      echo "<th width=150 height=20>Oxigeno</th>";  
    if ($ck5 == 1) 
      echo "<th width=150 height=20>Temperatura</th>";  
    if ($ck6 == 1) 
      echo "<th width=150 height=20>Gas</th>";  
  }
  echo "</tr>";
    
  // elegir la consulta de acuerdo a la opc. 
  if (($opc == 1) and ($ck1 == 1))
    $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and ((Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro)) and (Cod_movimiento = 'S')"; 
  
  if (($opc == 1) and ($ck1 == 0))
    $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'S') group by Fecha,Cod_Unidad";
  
  if (($opc == 1) and ($ck1 == 1) and (($cod_pro == 3) or ($cod_pro == 2) or ($cod_pro == 1))) //Circulantes,Fundentes ó CNU
    $consulta = "select * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and ((Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro)) and (Cod_movimiento = 'E')"; 

  if (($opc == 1) and ($ck1 == 0) and (($cod_pro == 3) or ($cod_pro == 2) or ($cod_pro == 1))) //Circulantes,Fundentes ó CNU
    $consulta = "select Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_Producto = $cod_pro) and (Cod_movimiento = 'E') group by Fecha,Cod_Unidad";

  
  if (($opc == 2) and ($ck1 == 1))
    $consulta = "select * from detalle_ct where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq)";
  
  if (($opc == 2) and ($ck1 == 0))  //solo busco la fecha para luego sacar los promedios.
    $consulta = "select Fecha from detalle_ct where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) group by Fecha";
  
  //consultar el peso base
  if ($opc == 1)
  {
    $consulta2 = "select * from Producto_por_equipo where (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro)";
    $rs_peso = mysql_query($consulta2);
    $row_peso = mysql_fetch_array($rs_peso);   
  }  

  $rs = mysql_query($consulta);
  while ($row = mysql_fetch_array($rs))
  {
    echo "<tr align=center>";
    echo "<td width=100 height=20>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";

    if ($opc == 1)
    {
      if ($ck1 == 1)
        echo "<td width=150 height=20>".$row["Turno"]."</td>";
      if (($ck2 == 1) and ($ck1 == 1)) 
        echo "<td width=150 height=20>".number_format($row["Cantidad_mov"],2,',','.')."</td>";
      if (($ck2 == 1) and ($ck1 == 0)) 
        echo "<td width=150 height=20>".number_format($row["Suma_mov"],2,',','.')."</td>";		
      if (($ck3 == 1) and ($ck1 == 1))        
        echo "<td width=150 height=20>".number_format(($row["Cantidad_mov"] * $row_peso["Peso_base"]),2,',','.')."</td>";
      if (($ck3 == 1) and ($ck1 == 0))
        echo "<td width=150 height=20>".number_format(($row["Suma_mov"] * $row_peso["Peso_base"]),2,',','.')."</td>";
      if ($ck4 == 1) 
        echo "<td width=150 height=20>".cambiar_unidad($row["Cod_Unidad"])."</td>";
      if (($ck5 == 1) and ($ck1 == 1))
        echo "<td width=150 heigth=20>".cambiar($row["Origen"])."</td>";
      if (($ck6 == 1) and ($ck1 == 1))
        echo "<td width=150 heigth=20>".cambiar($row["Destino"])."</td>";


      //consulta leyes asociadas a los movimientos.
      if (($ley == 1) or ($ley == 2))  
      {
        if (($ley == 1) and ($ck1 == 1)) //Por Turno (MB).
          $consul_ley = "select Cobre from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Turno = '".$row["Turno"]."')";
  
        if ((($ley == 1) or ($ley == 2)) and ($ck1 == 0)) //Por Dia (MB y ESC).	
          $consul_ley = "select avg(Cobre) as prom_cobre from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cobre <> 0)";
    
        if (($ley == 2) and ($ck1 == 1)) //Por Turno (ESC).
          $consul_ley = "select Cobre,Silice,Magnetita from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Turno = '".$row["Turno"]."')";	     	


        // Consultas leyes asociadas a los movimientos. 
      
        $rs_ley = mysql_query($consul_ley);
 
        if ($row_ley = mysql_fetch_array($rs_ley))
            $estado = true;
        else $estado = false;


        if (($ck1 == 1) and ($ck7 == 1)) //muestra el Cobre por turno (MB y ESC) .
        {  
          if ($estado)
            echo "<td width=150 heigth=20>".number_format($row_ley["Cobre"],2,',','.')."</td>";
	  else echo "<td width=150 heigth=20>0,00</td>";            
        }


        if (($ck1 == 1) and ($ck8 == 1)) //muestra el Silice por turno (ESC).
        {
          if ($estado)
            echo "<td width=150 heigth=20>".number_format($row_ley["Silice"],2,',','.')."</td>"; 
	  else echo "<td width=150 heigth=20>0,00</td>";  
        }


        if (($ck1 == 1) and ($ck9 == 1)) //muestra el Magnetita por turno (ESC).
        {
          if ($estado)
            echo "<td width=150 heigth=20>".number_format($row_ley["Magnetita"],2,',','.')."</td>"; 
	  else echo "<td width=150 heigth=20>0,00</td>";  
        }


        //Promedios Diarios.
        
	if ((($ley == 1) or ($ley == 2)) and ($ck1 == 0) and ($ck7 == 1)) //muestra el promedio del Cobre por dia (MB y ECS).
        {
          if ($estado)
            echo "<td width=150 heigth=20>".number_format($row_ley["prom_cobre"],2,',','.')."</td>";
	  else  echo "<td width=150 heigth=20>0,00</td>";  
        }


        if (($ley == 2) and ($ck1 == 0) and ($ck8 == 1)) //muestra el promedio del Silice por dia (ESC).
        {     
          $consul_ley = "select avg(Silice) as prom_silice from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Silice <> 0)";	
	  $rs_prom = mysql_query($consul_ley);
	  if ($row_prom = mysql_fetch_array($rs_prom))
            echo "<td width=150 heigth=20>".number_format($row_prom["prom_silice"],2,',','.')."</td>";  
	  else echo "<td width=150 heigth=20>0,00</td>";
        }	  


        if (($ley == 2) and ($ck1 == 0) and ($ck9 == 1)) //muestra el promedio del Magnetita por dia (ESC).
        {     
          $consul_ley = "select avg(Magnetita) as prom_mag from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Magnetita <> 0)";
	  $rs_prom = mysql_query($consul_ley);
	  if ($row_prom = mysql_fetch_array($rs_prom))
            echo "<td width=150 heigth=20>".number_format($row_prom["prom_mag"],2,',','.')."</td>";
	  else echo "<td width=150 heigth=20>0,00</td>";
        }
      }	
    }
 
    if ($opc == 2)
    {
      if ($ck1 == 1)       
        echo "<td width=150 height=20>".$row["Turno"]."</td>";      
      if (($ck2 == 1) and ($ck1 == 1))
        echo "<td width=150 height=20>".$row["Tobera"]."</td>";  
	
      if (($ck3 == 1) and ($ck1 == 1))
        echo "<td width=150 height=20>".number_format($row["Aire_soplado"],2,',','.')."</td>";    
      if (($ck3 == 1) and ($ck1 == 0))
      {
        $consulta = "select avg(Aire_soplado) as prom_aire from detalle_ct where (Fecha = '".$row["Fecha"]."') and (Aire_soplado <> 0)";
	$rs_aire = mysql_query($consulta);
	$row_aire = mysql_fetch_array($rs_aire);	
        echo "<td width=150 height=20>".number_format($row_aire["prom_aire"],2,',','.')."</td>";    
      }	
	
      if (($ck4 == 1) and ($ck1 == 1))
        echo "<td width=150 height=20>".number_format($row["Oxigeno"],2,',','.')."</td>";  
      if (($ck4 == 1) and ($ck1 == 0))
      {
        $consulta = "select avg(Oxigeno) as prom_oxig from detalle_ct where (Fecha ='".$row["Fecha"]."') and (Oxigeno <> 0)";
	$rs_oxig = mysql_query($consulta);
	$row_oxig = mysql_fetch_array($rs_oxig);	
        echo "<td width=150 height=20>".number_format($row_oxig["prom_oxig"],2,',','.')."</td>";  
      }	
      if (($ck5 == 1) and ($ck1 == 1))
        echo "<td width=150 height=20>".number_format($row["Temperatura"],2,',','.')."</td>";  
      if (($ck5 == 1) and ($ck1 == 0))
      { 
        $consulta = "select avg(Temperatura) as prom_temp from detalle_ct where (Fecha ='".$row["Fecha"]."') and (Temperatura <> 0)";
	$rs_temp = mysql_query($consulta);
	$row_temp = mysql_fetch_array($rs_temp);	
        echo "<td width=150 height=20>".number_format($row_temp["prom_temp"],2,',','.')."</td>";  
      }	
	
      if (($ck6 == 1) and ($ck1 == 1))
        echo "<td width=150 height=20>".number_format($row["Gas"],2,',','.')."</td>"; 
      if (($ck6 == 1) and ($ck1 == 0))
      {
        $consulta = "select avg(Gas) as prom_gas from detalle_ct where (Fecha ='".$row["Fecha"]."') and (Gas <> 0)";
	$rs_gas = mysql_query($consulta);
	$row_gas = mysql_fetch_array($rs_gas);	
        echo "<td width=150 height=20>".number_format($row_gas["prom_gas"],2,',','.')."</td>";  
      }	
    }  
    echo "</tr>";
  }	
  echo "</table><br><br>";
?>


