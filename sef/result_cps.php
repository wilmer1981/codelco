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
  f.action = 'result_cps_excel.php';
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
  parametros = "fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value+"&opc="+f.opc.value+"&cod_eq="+f.cod_eq.value+"&origen="+f.origen.value+"&cod_pro=" + f.cod_pro.value + "&num_cps=" + f.num_cps.value;
 
  open("menu_graf_cps.php?"+parametros,"","toolbar=no,directories=no,menubar=no,status=yes,width=300,height=200,top=250,left=200");
}

</Script>
</head>

<body bgcolor="#ffffff" text="#000000" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5">
<form name=form1 action="" method="post">

<?
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

  echo "<table border=0><tr><td width=125></td><td>";
  echo "Periodo Consultado: ".substr($fecha_inicio,8,2)."/".substr($fecha_inicio,5,2)."/".substr($fecha_inicio,0,4)." al ".substr($fecha_final,8,2)."/".substr($fecha_final,5,2)."/".substr($fecha_final,0,4);
  echo "</td></tr></table><br>";
  
  echo "<table border=0 align=center ID=tabla1>";
  echo "<tr>"; 
  echo "<th width=100 height=20 ID=campo1>Fecha</th>";
  
  if ($ck1 == 1)
    echo "<th width=150 height=20 ID=campo1>Nº de cargas</th>";
  if ($ck3 == 1)
    echo "<th width=150 height=20 ID=campo1>Cantidad de Movimiento</th>";
  if ($ck4 == 1) 
    echo "<th width=150 height=20 ID=campo1>Peso Movimiento</th>";
  if ($ck2 == 1) 
    echo "<th width=150 height=20 ID=campo1>Unidad</th>";      
  if ($ck5 == 1) 
    echo "<th width=150 heigth=20 ID=campo1>Origen</th>";
  if ($ck6 == 1) 
    echo "<th width=150 heigth=20 ID=campo1>Destino</th>";


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
    echo "<td width=100 height=20 ID=campo2>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";
    if ($ck1 == 1)
      echo "<td width=150 height=20 ID=campo2>".$row["Num_carga"]."</td>";
    if (($ck3 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Cantidad_mov"],2,',','.')."</td>";
    if (($ck3 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Suma_mov"],2,',','.')."</td>";    
    if (($ck4 == 1) and ($ck1 == 1))  
      echo "<td width=150 height=20 ID=campo2>".number_format(($row["Cantidad_mov"] * $row_peso["Peso_base"]),0,',','.')."</td>";
    if (($ck4 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20 ID=campo2>".number_format(($row["Suma_mov"] * $row_peso["Peso_base"]),0,',','.')."</td>";
    if ($ck2 == 1) 
      echo "<td width=150 height=20 ID=campo2>".cambiar_unidad($row["Cod_Unidad"])."</td>";      
    if ($ck5 == 1)
      echo "<td width=150 heigth=20 ID=campo2>".cambiar($row["Origen"])."</td>";
    if ($ck6 == 1)
      echo "<td width=150 heigth=20 ID=campo2>".cambiar($row["Destino"])."</td>";
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

  echo "<input type=hidden name=cod_pro value=$cod_pro>";
  echo "<input type=hidden name=cod_eq  value=$cod_eq>";
  echo "<input type=hidden name=opc     value=$opc>";
  echo "<input type=hidden name=num_cps value=$num_cps>";
  echo "<input type=hidden name=origen  value=$origen>";
?>

</form>
</body>
</html>

