<?
  include("conectar.php");
  include("funciones.php");
  
?>

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
  f.action = 'result_he_excel.php';
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
  parametros = "fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value+"&opc="+f.opc.value+"&cod_eq="+f.cod_eq.value+"&ley="+f.ley.value+"&cod_pro=" + f.cod_pro.value;
 
  if (f.opc.value == 1)
    parametros = parametros + '&destino='+ f.destino.value; 
 
   open("menu_graf_he.php?"+parametros,"","toolbar=no,directories=no,menubar=no,status=yes,width=300,height=250,top=250,left=200");
}

</Script>
</head>

<body bgcolor="#ffffff" text="#000000" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5">
<form name=form1 action="" method="post">

<?
  $consulta = "SELECT * from equipos where cod_equipo=".$cod_eq;  
  $rs_eq = mysql_query($consulta);
  $row_eq = mysql_fetch_array($rs_eq);

  $consulta = "SELECT * from productos where cod_producto=".$cod_pro;
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

  echo "<table border=0><tr><td width=125></td><td>";
  echo "Periodo Consultado: ".substr($fecha_inicio,8,2)."/".substr($fecha_inicio,5,2)."/".substr($fecha_inicio,0,4)." al ".substr($fecha_final,8,2)."/".substr($fecha_final,5,2)."/".substr($fecha_final,0,4);
  echo "</td></tr></table><br>";
  
  echo "<table border=0 align=center ID=tabla1>";
  echo "<tr>"; 
  echo "<th width=100 height=20 ID=campo1>Fecha</th>";
  

  if ($ck1 == 1)
    echo "<th width=150 height=20 ID=campo1>Turno</th>";
  if ($ck2 == 1)
    echo "<th width=150 height=20 ID=campo1>Cantidad de Movimiento</th>";
  if ($ck3 == 1) 
    echo "<th width=150 height=20 ID=campo1>Peso Movimiento</th>";
  if ($ck4 == 1) 
    echo "<th width=150 height=20 ID=campo1>Unidad</th>";  
  if (($ck5 == 1) and ($ck1 == 1)) 
    echo "<th width=150 heigth=20 ID=campo1>Origen</th>";
  if (($ck6 == 1) and ($ck1 == 1)) 
    echo "<th width=150 heigth=20 ID=campo1>Destino</th>";
   
  if (($ley == 1) or ($ley == 2))  
  {
    if ($ck7 == 1)
      echo "<th width=150 heigth=20 ID=campo1>Cobre</th>";
  }
  if ($ley == 2)
  {
    if ($ck8 == 1)
      echo "<th width=150 heigth=20 ID=campo1>Azufre</th>";
    if ($ck9 == 1)
      echo "<th width=150 heigth=20 ID=campo1>Fierro</th>";      
    if ($ck10 == 1)
      echo "<th width=150 heigth=20 ID=campo1>Silice</th>";
    if ($ck11 == 1)  
      echo "<th width=150 heigth=20 ID=campo1>Magnetita</th>";
  }    

  //opc = 1 Salida. 

  if (($opc == 1) and ($ck1 == 1))
    $consulta = "SELECT * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cod_movimiento = 'S') and (Destino = $destino)";

  if (($opc == 1) and ($ck1 == 0))
    $consulta = "SELECT Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cod_movimiento = 'S') and (Destino = $destino) group by Fecha,Cod_Unidad";

  //opc = 2 Entrada. 
  if (($opc == 2) and ($ck1 == 1))
    $consulta = "SELECT * from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cod_movimiento = 'E')";
  
  if (($opc == 2) and ($ck1 == 0))
    $consulta = "SELECT Fecha,Cod_Unidad,sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cod_movimiento = 'E') group by Fecha,Cod_Unidad";
    
   
  //consultar el peso base
  $consulta2 = "SELECT * from Producto_por_equipo where (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro)";
  $rs_peso = mysql_query($consulta2);
  $row_peso = mysql_fetch_array($rs_peso);  
   
  $rs = mysql_query($consulta); //desplega los datos de movimientos. 
  while ($row = mysql_fetch_array($rs))
  {
    echo "<tr align=center>";
    echo "<td width=100 height=20 ID=campo2>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";
    if ($ck1 == 1)
      echo "<td width=150 height=20 ID=campo2>".$row["Turno"]."</td>";
    if (($ck2 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Cantidad_mov"],2,',','.')."</td>";
    if (($ck2 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Suma_mov"],2,',','.')."</td>";    
    if (($ck3 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20 ID=campo2>".number_format(($row["Cantidad_mov"] * $row_peso["Peso_base"]),0,',','.')."</td>";
    if (($ck3 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20 ID=campo2>".number_format(($row["Suma_mov"] * $row_peso["Peso_base"]),0,',','.')."</td>";
    if ($ck4 == 1) 
      echo "<td width=150 height=20 ID=campo2>".cambiar_unidad($row["Cod_Unidad"])."</td>";
    if (($ck5 == 1) and ($ck1 == 1))
      echo "<td width=150 heigth=20 ID=campo2>".cambiar($row["Origen"])."</td>";
    if (($ck6 == 1) and ($ck1 == 1))
      echo "<td width=150 heigth=20 ID=campo2>".cambiar($row["Destino"])."</td>";
    
    //consulta leyes asociadas a los movimientos.
    if (($ley == 1) or ($ley == 2))  
    {
      if (($ley == 1) and ($ck1 == 1)) //Por Turno (MB).
        $consul_ley = "SELECT Cobre from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Turno = '".$row["Turno"]."')";
  
      if ((($ley == 1) or ($ley == 2)) and ($ck1 == 0)) //Por Dia (MB y ESC).
        $consul_ley = "SELECT avg(Cobre) as prom_cobre from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cobre <> 0)";
    
      if (($ley == 2) and ($ck1 == 1)) //Por Turno (ESC).
        $consul_ley = "SELECT Cobre,Azufre,Fierro,Silice,Magnetita from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Turno = '".$row["Turno"]."')";	


      // Consultas leyes asociadas a los movimientos. 
      
      $rs_ley = mysql_query($consul_ley);
 
      if ($row_ley = mysql_fetch_array($rs_ley))
	$estado = true;
      else $estado = false;

         
      if (($ck1 == 1) and ($ck7 == 1)) //muestra el Cobre por turno (MB y ESC) .
      {  
        if ($estado)
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_ley["Cobre"],2,',','.')."</td>";
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";            
      }

      if (($ck1 == 1) and ($ck8 == 1)) //muestra el Azufre por turno (ECS).
      {
        if ($estado)
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_ley["Azufre"],2,',','.')."</td>"; 
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";  
      }
	
      if (($ck1 == 1) and ($ck9 == 1)) //muestra el Fierro por turno (ECS).
      {
        if ($estado)
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_ley["Fierro"],2,',','.')."</td>"; 
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";  
      }

      if (($ck1 == 1) and ($ck10 == 1)) //muestra el Silice por turno (ESC).
      {
        if ($estado)
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_ley["Silice"],2,',','.')."</td>"; 
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";  
      }

      if (($ck1 == 1) and ($ck11 == 1)) //muestra el Magnetita por turno (ESC).
      {
        if ($estado)
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_ley["Magnetita"],2,',','.')."</td>"; 
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";  
      }

      //Promedios Diarios.
      
      if ((($ley == 1) or ($ley == 2)) and ($ck1 == 0) and ($ck7 == 1)) //muestra el promedio del Cobre por dia (MB y ECS).
      {
        if ($estado)
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_ley["prom_cobre"],2,',','.')."</td>";
	else  echo "<td width=150 heigth=20 ID=campo2>0,00</td>";  
      }
      

      if (($ley == 2) and ($ck1 == 0) and ($ck8 == 1)) //muestra el promedio del Azufre por dia (ESC).
      {     
        $consul_ley = "SELECT avg(Azufre) as prom_azufre from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Azufre <> 0)";	
	$rs_prom = mysql_query($consul_ley);
	if ($row_prom = mysql_fetch_array($rs_prom))
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_prom["prom_azufre"],2,',','.')."</td>";  
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";
      }	  


      if (($ley == 2) and ($ck1 == 0) and ($ck9 == 1)) //muestra el promedio del Fierro por dia (ESC).
      {     
        $consul_ley = "SELECT avg(Fierro) as prom_fierro from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Fierro <> 0)";	
	$rs_prom = mysql_query($consul_ley);
	if ($row_prom = mysql_fetch_array($rs_prom))
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_prom["prom_fierro"],2,',','.')."</td>";  
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";
      }	  

      if (($ley == 2) and ($ck1 == 0) and ($ck10 == 1)) //muestra el promedio del Silice por dia (ESC).
      {     
        $consul_ley = "SELECT avg(Silice) as prom_silice from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Silice <> 0)";	
	$rs_prom = mysql_query($consul_ley);
	if ($row_prom = mysql_fetch_array($rs_prom))
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_prom["prom_silice"],2,',','.')."</td>";  
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";
      }	  

      if (($ley == 2) and ($ck1 == 0) and ($ck11 == 1)) //muestra el promedio del Magnetita por dia (ESC).
      {     
        $consul_ley = "SELECT avg(Magnetita) as prom_mag from leyes_turno where (Fecha = '".$row["Fecha"]."') and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Magnetita <> 0)";
	$rs_prom = mysql_query($consul_ley);
	if ($row_prom = mysql_fetch_array($rs_prom))
          echo "<td width=150 heigth=20 ID=campo2>".number_format($row_prom["prom_mag"],2,',','.')."</td>";
	else echo "<td width=150 heigth=20 ID=campo2>0,00</td>";
      }	  
    }

    echo "</tr>";
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
  echo "<input type=hidden name=fecha_final value=$fecha_final>";
 
  echo "<input type=hidden name=ck1 value=$ck1>";
  echo "<input type=hidden name=ck2 value=$ck2>";
  echo "<input type=hidden name=ck3 value=$ck3>";
  echo "<input type=hidden name=ck4 value=$ck4>";
  echo "<input type=hidden name=ck5 value=$ck5>";
  echo "<input type=hidden name=ck6 value=$ck6>";

  echo "<input type=hidden name=ck7 value=$ck7>";
  echo "<input type=hidden name=ck8 value=$ck8>";
  echo "<input type=hidden name=ck9 value=$ck9>";
  echo "<input type=hidden name=ck10 value=$ck10>";
  echo "<input type=hidden name=ck11 value=$ck11>";
    
  echo "<input type=hidden name=cod_pro value=$cod_pro>";
  echo "<input type=hidden name=cod_eq  value=$cod_eq>";
  echo "<input type=hidden name=opc     value=$opc>";
  echo "<input type=hidden name=ley     value=$ley>";
  if ($opc == 1)
    echo "<input type=hidden name=destino value=$destino>";
?>

</form>
</body>
</html>

