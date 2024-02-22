<? include("conectar.php") ?>

<html>
<head>
<title></title>
<LINK href="style3.css" rel=StyleSheet type=text/css>
<Script language=JavaScript>
function tratar(combo)
{  
  f = document.forms[0];
  if (f != 1) 
  {
    if (f.num_cps[0].checked)
      num_cps = f.num_cps[0].value;
    else if (f.num_cps[1].checked)
           num_cps = f.num_cps[1].value;
         else if (f.num_cps[2].checked)
                num_cps = f.num_cps[2].value;
              else if (f.num_cps[3].checked)
	             num_cps = f.num_cps[3].value;

    if (combo.value.length == 19)
      location.href =  combo.value +'?num_cps='+num_cps;
    else location.href =  combo.value + '&num_cps='+num_cps;
  }  
}
//******************//
function enviar(combo)
{
  var url = combo.value;
  
  if (url != -1)
    location.href = url;    
}


</Script>
</head>
<body background="fondo.jpg" bgcolor="ffffff" text="#000000" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5">
<form name=form1 action="" method="post">


<div align=left ID=letra1>Planificación y Control Metalúrgico</div> 
<div align=left ID=letra2>SEF-BD</div>
<div align=center ID=titulo2>INDICADORES DIARIOS DE FUNDICIÓN</div><br>
<div align=center ID=titulo3><b>EQUIPOS Y DATOS DISPONIBLES</b></div><br>

<table width="100%" border=1>
  <tr> 
    <td width="50%" height="185"><br>
      <div align="center" ID=titulo1>CONVERTIDOR TENIENTE</div><br>   
      <table border=0>            	
<? 
  //CNU acumulado del mes.
  $consulta = "select max(Fecha) as fec_mov from movimientos where (Cod_equipo = 5) and (Cod_producto = 1)";
  $rs_fec_mov = mysql_query($consulta);
  $row_fec_mov = mysql_fetch_array($rs_fec_mov);
  
  $fecha_aux =  substr($row_fec_mov["fec_mov"],0,8).""."01" ; //fecha inicio del mes

  $consulta = "select sum(Cantidad_mov) as Suma_mov from movimientos where (Cod_equipo = 5) and (Cod_producto = 1) and ((Fecha >= '$fecha_aux') and (Fecha <= '".$row_fec_mov["fec_mov"]."'))";
  $rs_cnu = mysql_query($consulta);
  $row_cnu = mysql_fetch_array($rs_cnu);

  echo "<tr><td></td><td ID=campo1>Mov.a la Fecha ".substr($row_fec_mov["fec_mov"],8,2)."/".substr($row_fec_mov["fec_mov"],5,2)."/".substr($row_fec_mov["fec_mov"],0,4)."</td><tr>";
  echo "<tr><td width=50></td>";
  echo "<td width=300 heigth=100 ID=campo2>";
  
  echo "CNU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".number_format($row_cnu["Suma_mov"],0,',','.')." Toneladas</td></tr>";

  //Horas Desconexion del mes.
  $consulta = "select max(Fecha) as fec_des from tiempo_desconexion where (Cod_equipo = 5)";
  $rs_fec_des = mysql_query($consulta);
  $row_fec_des = mysql_fetch_array($rs_fec_des);

  $fecha_aux = substr($row_fec_des["fec_des"],0,8).""."01"; //fecha inicio del mes

  $consulta = "select sum(Horas_desc) as hrs from tiempo_desconexion where (Cod_equipo = 5) and ((Fecha >= '$fecha_aux') and (Fecha <= '".$row_fec_des["fec_des"]."'))";
  $rs_hrs = mysql_query($consulta);
  $row_hrs = mysql_fetch_array($rs_hrs);
  
  $dia = substr($row_fec_des["fec_des"],8,2);
  $formula = ((($dia * 24) - $row_hrs["hrs"]) / ($dia * 24)) * 100;

  echo "<tr><td></td><td ID=campo2>Disponobilidad: ".number_format($formula,2,',','.')." %</td></tr>";  
  echo "</table><br>";

?>     
     <table border=0><tr><td width=50></td><td>       
        <select name=ct onChange="enviar(this)" ID=combo1>
          <option value=-1 selected>[Seleccionar Consulta]</option>
          <option value="consultar_ct.php?cod_eq=5&cod_pro=5&opc=1&ley=1">Metal Blanco</option>
          <option value="consultar_ct.php?cod_eq=5&cod_pro=6&opc=1&ley=2">Escoria</option>
          <option value="consultar_ct.php?cod_eq=5&cod_pro=3&opc=1&ley=0">Circulantes</option>
          <option value="consultar_ct.php?cod_eq=5&cod_pro=2&opc=1&ley=0">Fundentes</option>
          <option value="consultar_ct.php?cod_eq=5&cod_pro=1&opc=1&ley=0">CNU</option>
          <option value="consultar_ct.php?cod_eq=5&cod_pro=2&opc=2&ley=0">Flujos CT</option> 
	  <option value="consultar_t_ct.php?cod_eq=5">Soplado</option>
        </select>	  
      </td><tr></table> 

    </td>
    
    <td width="50%" height="185"><br>
    <div align="center" size=3 ID=titulo1>PLANTA DE ÁCIDO</div><br>
      <table border=0>
<?
  $consulta = "select max(Fecha) as fec from detalle_pta_acido where (Cod_equipo = 13)";
  $rs_fec = mysql_query($consulta);
  $row_fec = mysql_fetch_array($rs_fec);

  $fecha_aux = substr($row_fec["fec"],0,8).""."01"; //fecha inicio del mes

  $consulta = "select sum(Produccion) as Suma_prod from detalle_pta_acido where (Fecha >= '$fecha_aux') and (Cod_equipo = 13)";
  $rs_pro = mysql_query($consulta);
  $row_pro = mysql_fetch_array($rs_pro);  
  
  echo "<tr><td></td><td ID=campo1>Mov. a la Fecha ".substr($row_fec["fec"],8,2)."/".substr($row_fec["fec"],5,2)."/".substr($row_fec["fec"],0,4)."</td><tr>";
  echo "<tr><td width=50></td>";
  echo "<td width=300 heigth=100 ID=campo2>";
  
  echo "Producción: ".number_format($row_pro["Suma_prod"],1,',','.')." Toneladas</td></tr>";
  echo "<tr><td>&nbsp;</td></tr></table><br>";
?>
      <table border=0><tr><td width=50></td><td> 
      <select name=pa onChange="enviar(this)" ID=combo1>
        <option value=-1 selected>[Seleccionar Consulta]</option>
	<option value="consultar_pa.php?cod_eq=13">Detalle Planta de Ácido</option>
      </select>
      </td></tr></table>
    </td>    
  </tr>
  <tr> 
    <td width="50%" height="300">
      <div align="center" size=3 ID=titulo1>CONVERTIDOR PEIRCE SMITH</div><br>  

<?
  //Carga fria del mes
  $consulta = "select max(Fecha) as fec from movimientos where (Cod_equipo in (7,8,9)) and (Cod_Producto = 8) and (Cod_movimiento = 'E')";
  $rs_fec = mysql_query($consulta);
  $row_fec = mysql_fetch_array($rs_fec);

  $fecha_aux = substr($row_fec["fec"],0,8).""."01"; //fecha inicio del mes
  
  $consulta = "select sum(Cantidad_mov) as Suma_mov from movimientos where ((Fecha >= '".$fecha_aux."') and (Fecha <= '".$row_fec["fec"]."')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = 8) and (Cod_movimiento = 'E')";
  $rs_mov = mysql_query($consulta);
  $row_mov = mysql_fetch_array($rs_mov);

  $consulta = "select count(*) as cant from movimientos where ((Fecha >= '".$fecha_aux."') and (Fecha <= '".$row_fec["fec"]."')) and (Cod_equipo in (7,8,9)) and (Cod_Producto = 8) and (Cod_movimiento = 'E')";
  $rs_cant = mysql_query($consulta);
  $row_cant = mysql_fetch_array($rs_cant);

  $result = ($row_mov["Suma_mov"] / $row_cant["cant"]);

  echo "<table border=0>";
  echo "<tr><td></td><td ID=campo1>Mov. a la Fecha ".substr($row_fec["fec"],8,2)."/".substr($row_fec["fec"],5,2)."/".substr($row_fec["fec"],0,4)."</td></tr>";
  echo "<tr><td width=50></td>";
  echo "<td width=300 heigth=100 ID=campo2>Carga Fría: ".number_format($result,2,',','.')." Ollas Prom. por Carga</td><tr><td>&nbsp;</td></tr>";
  echo "</tr></table>";

?>	  
      <br><br>
      <center> 
      <font size=2>
      <input type=radio name="num_cps" value=0 checked ><b>Todos</b>
      <input type=radio name="num_cps" value=1 ><b>CPS 1</b>
      <input type=radio name="num_cps" value=2 ><b>CPS 2</b>
      <input type=radio name="num_cps" value=3 ><b>CPS 3</b>
      </font>
      </center>
      <table border=0 align=center>
        <tr><td ID=letra3>Entrada</td><td ID=letra3>Salida</td></tr>
        <tr>	  
          <td width=220 >
           <select name=cps_ent onchange="tratar(this)">
	     <option value=-1 selected>[Seleccionar Consulta]</option>
	     <option value="consultar_cps.php?cod_pro=5&opc=1&origen=5">Metal Blanco CT</option>
	     <option value="consultar_cps.php?cod_pro=5&opc=1&origen=2">Metal Blanco HE</option>
	     <option value="consultar_cps.php?cod_pro=6&opc=1&origen=1">Escoria Basculante</option>
	     <option value="consultar_cps.php?cod_pro=6&opc=1&origen=3">Escoria Reten</option>
	     <option value="consultar_cps.php?cod_pro=8&opc=1&origen=-1">Carga Fría</option>
	     <option value="consultar_t_cps.php">Soplado</option>
	   </select>  
         </td>
         <td width=220 >
	  <select name=cps_sal onChange="tratar(this)"> 
	    <option value=-1 selected>[Seleccionar Consulta]</option>
            <option value="consultar_cps.php?cod_pro=7&opc=2&origen=-1">Blíster</option>
            <option value="consultar_cps.php?cod_pro=6&opc=2&origen=-1">Escoria</option>
	    <option value="consultar_cps.php?cod_pro=5&opc=2&origen=-1">Metal Blanco</option>
	  </select>  
          </td>
        </tr>
      </table>     	
    </td>
    <td width="50%" height="300"><br>
      <div align="center" size=3 ID=titulo1>HORNO ELÉCTRICO</div><br>
<?
  //MB a CT acumulado del mes
  $consulta = "select max(Fecha) as fec_mb from movimientos where (Cod_equipo = 2) and (Cod_producto = 5) and (Cod_movimiento = 'S') and (Destino =6)";  
  $rs_fec_mb = mysql_query($consulta);
  $row_fec_mb = mysql_fetch_array($rs_fec_mb);
 
  $fecha_aux = substr($row_fec_mb["fec_mb"],0,8).""."01"; //fecha inicio del mes
   
  $consulta = "select  sum(Cantidad_mov) as suma_mov from movimientos where ((Fecha >= '$fecha_aux') and (Fecha <= '".$row_fec_mb["fec_mb"]."')) and (Cod_equipo = 2) and (Cod_producto = 5) and (Cod_movimiento = 'S') and (Destino = 6)";
  $rs_mov_mb = mysql_query($consulta);
  $row_mov_mb = mysql_fetch_array($rs_mov_mb);

  echo "<table border=0>";
  echo "<tr><td></td><td ID=campo1>Mov. a la Fecha ".substr($row_fec_mb["fec_mb"],8,2)."/".substr($row_fec_mb["fec_mb"],5,2)."/".substr($row_fec_mb["fec_mb"],0,4)."</td></tr>";
  echo "<tr>";
  echo "<td width=50></td><td width=300 heigth=100 ID=campo2>MB&nbsp;: ";
  printf("%' 5d",$row_mov_mb["suma_mov"]);
  echo " Ollas";


   //Promedio Ley de Cobre (MB.)
  $consulta = "select max(Fecha) as fec_mb from leyes_turno where (Cod_equipo = 2) and (Cod_producto = 5)";
  $rs_cu_mb = mysql_query($consulta);
  $row_cu_mb = mysql_fetch_array($rs_cu_mb);

  $fecha_aux = substr($row_cu_mb["fec_mb"],0,8).""."01"; //fecha inicio del mes
  
  $consulta = "select avg(Cobre) as prom_dia from leyes_turno where ((Fecha >= '$fecha_aux') and (Fecha <= '".$row_cu_mb["fec_mb"]."')) and (Cod_equipo = 2) and (Cod_producto = 5) and (Cobre <> 0) group by Fecha";
  $suma_cu_mb = 0;
  $rs_dia = mysql_query($consulta);
  $cant = 0;
  while ($row_dia = mysql_fetch_array($rs_dia))
  {
    $suma_cu_mb = $row_dia["prom_dia"] + $suma_cu_mb;
    $cant = $cant + 1;
  }  
  $promedio = ($suma_cu_mb / $cant); 
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ley de Cu: ".number_format($promedio,2,',','.')." %</td></tr>";

  
  //ESC a Botadero de mes
  $consulta = "select max(Fecha) as fec_esc from movimientos where (Cod_equipo = 2) and (Cod_producto = 6) and (Cod_movimiento = 'S') and (Destino = 11)";  
  $rs_fec_esc = mysql_query($consulta);
  $row_fec_esc = mysql_fetch_array($rs_fec_esc);
 
  $fecha_aux = substr($row_fec_esc["fec_esc"],0,8).""."01"; //fecha inicio del mes
   
  $consulta = "select  sum(Cantidad_mov) as suma_mov from movimientos where ((Fecha >= '$fecha_aux') and (Fecha <= '".$row_fec_mb["fec_mb"]."')) and (Cod_equipo = 2) and (Cod_producto = 6) and (Cod_movimiento = 'S') and (Destino = 11)";
  $rs_mov_esc = mysql_query($consulta);
  $row_mov_esc = mysql_fetch_array($rs_mov_esc);

  echo "<tr><td></td><td ID=campo2>ESC: ";
  printf("%' 5d",$row_mov_esc["suma_mov"]);
  echo " Ollas";

  //Promedio Ley de Cobre (ESC.)
  $consulta = "select max(Fecha) as fec_esc from leyes_turno where (Cod_equipo = 2) and (Cod_producto = 6)";

  $rs_cu_esc = mysql_query($consulta);
  $row_cu_esc = mysql_fetch_array($rs_cu_esc);

  $fecha_aux = substr($row_cu_esc["fec_esc"],0,8).""."01"; //fecha inicio del mes

  $consulta = "select avg(Cobre) as prom_dia from leyes_turno where ((Fecha >= '$fecha_aux') and (Fecha <= '".$row_cu_mb["fec_mb"]."')) and (Cod_equipo = 2) and (Cod_producto = 6) and (Cobre <> 0) group by Fecha";  
  $suma_cu_esc = 0;
  $rs_dia = mysql_query($consulta);
  $cant = 0;
  while ($row_dia = mysql_fetch_array($rs_dia))
  {
    $suma_cu_esc = $row_dia["prom_dia"] + $suma_cu_esc;  
    $cant = $cant + 1;
  }
  $promedio = ($suma_cu_esc / $cant);

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ley de Cu: ".number_format($promedio,2,',','.')." %</td></tr>"; 

  echo "</tr></table><br><br><br>";
?>
      <table border=0><tr><td>&nbsp;<br></td></tr><tr><td width=50></td><td width=300>
      <select name=he onChange="enviar(this)" ID=combo1>
        <option value=-1 selected>[Seleccionar Consulta]</option>
	<option value="consultar_he.php?cod_eq=2&cod_pro=6&destino=11&opc=1&ley=2">Escoria a Pozo
</option>
        <option value="consultar_he.php?cod_eq=2&cod_pro=5&destino=6&opc=1&ley=1">Metal Blanco a CPS</option>
	<option value="consultar_he.php?cod_eq=2&cod_pro=5&destino=10&opc=1&ley=0">Metal Blanco a Pozo</option>
	<option value="consultar_he.php?cod_eq=2&cod_pro=12&opc=2&ley=0">Carbon</option>
	<option value="consultar_he.php?cod_eq=2&cod_pro=3&opc=2&ley=0">Circulantes</option>
      </select>	
      </td></tr></table><br>
      
    </td>
  </tr>
</table>

</form>
</body>
</html>
