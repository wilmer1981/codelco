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
  f.action = 'result_pa_excel.php';
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
  open("menu_graf_pa.php?fecha_inicio="+f.fecha_inicio.value+"&fecha_final="+f.fecha_final.value,"","toolbar=no,directories=no,menubar=no,status=yes,width=300,height=200,top=250,left=200");  
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
    echo "<th width=150 height=20 ID=campo1>Turno</th>";
  if ($ck2 == 1)
    echo "<th width=150 height=20 ID=campo1>Caudal</th>";
  if ($ck3 == 1) 
    echo "<th width=150 height=20 ID=campo1>Horas Op.</th>";
  if ($ck4 == 1) 
    echo "<th width=150 height=20 ID=campo1>Azufre</th>";  
  if ($ck5 == 1)  
    echo "<th width=150 heigth=20 ID=campo1>Produccion</th>";
  echo "</tr>";  

  if ($ck1 == 1) 
    $consulta = "select * from Detalle_Pta_Acido where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq)";    
   
  if ($ck1 == 0)
    $consulta = "select Fecha,sum(Caudal) as Suma_caudal,sum(HorasOp) as Suma_horas,sum(Azufre) as Suma_azufre,sum(Produccion) as Suma_produccion from Detalle_Pta_Acido where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) group by Fecha";

  $rs = mysql_query($consulta);
  while ($row = mysql_fetch_array($rs))
  {
    echo "<tr align=center>";
    echo "<td width=100 height=20 ID=campo2>".substr($row["Fecha"],8,2).'-'.substr($row["Fecha"],5,2).'-'.substr($row["Fecha"],0,4)."</td>";
    if ($ck1 == 1)
      echo "<td width=150 height=20 ID=campo2>".$row["Turno"]."</td>";
      
    if (($ck2 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Caudal"],2,',','.')."</td>";
    if (($ck2 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Suma_caudal"],2,',','.')."</td>";    
      
    if (($ck3 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["HorasOp"],2,',','.')."</td>";
    if (($ck3 == 1) and ($ck1 == 0))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Suma_horas"],2,',','.')."</td>";
      
    if (($ck4 == 1) and ($ck1 == 1))
      echo "<td width=150 height=20 ID=campo2>".number_format($row["Azufre"],2,',','.')."</td>";
    if (($ck4 == 1) and ($ck1 == 0))
      echo "<td width=150 heigth=20 ID=campo2>".number_format($row["Suma_azufre"],2,',','.')."</td>";
      
    if (($ck5 == 1) and ($ck1 == 1))
      echo "<td width=150 heigth=20 ID=campo2>".number_format($row["Produccion"],2,',','.')."</td>";
    if (($ck5 == 1) and ($ck1 == 0))
      echo "<td width=150 heigth=20 ID=campo2>".number_format($row["Suma_produccion"],2,',','.')."</td>";      
      
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
  echo "<input type=hidden name=fecha_final  value=$fecha_final>";

  echo "<input type=hidden name=ck1 value=$ck1>";
  echo "<input type=hidden name=ck2 value=$ck2>";
  echo "<input type=hidden name=ck3 value=$ck3>";
  echo "<input type=hidden name=ck4 value=$ck4>";
  echo "<input type=hidden name=ck5 value=$ck5>";

  echo "<input type=hidden name=cod_eq value=$cod_eq>";
?>

</form>
</body>
</html>


    
  

