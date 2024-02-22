<?
  include("conectar_odbc.php");
  include("conectar_mysql.php"); 
  
  
  //Extrae los datos del mes actual y el anterior a este y los deja en archivos de texto.  
  
  //Tabla Detalle_CPS
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);


  $anio_1 = odbc_result($rs,"fec");

  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta) or die ("error".odbc_errormsg());
  $mes_1 = odbc_result($rs,"fec");
  
  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
  
  $Archivo = fopen("Archivos/detalle_cps.txt","w+");
  $Consulta = "SELECT * from detalle_cps where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  //echo 	$Consulta;
  while ($Fila = odbc_fetch_row($Respuesta))
  {
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        
    
    if (odbc_result($Respuesta,"Inicio_emision") == "")
    {
      $emi_ini = "";
      $emi_fin = "";
    }  
    else 
    {
      $emi_ini = substr(odbc_result($Respuesta,"Inicio_emision"),11,5);
      $emi_fin = substr(odbc_result($Respuesta,"Fin_emision"),11,5);
    }  

    if (odbc_result($Respuesta,"Inicio_soplado") == "")
    {
      $sop_ini = "";
      $sop_fin = "";
    }
    else 
    {
      $sop_ini = substr(odbc_result($Respuesta,"Inicio_soplado"),11,5);
      $sop_fin = substr(odbc_result($Respuesta,"Fin_soplado"),11,5);
    }                 

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Turno").'","'.odbc_result($Respuesta,"Num_Carga").'","'.odbc_result($Respuesta,"Toberas").'","'.$emi_ini.'","'.$emi_fin.'","'.$sop_ini.'","'.$sop_fin.'";';

    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);


//*****************************///
  //Tabla Detalle_CT
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);
  $anio_1 = odbc_result($rs,"fec");
  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta);
  $mes_1 = odbc_result($rs,"fec");
  
  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
  
  $Archivo = fopen("Archivos/detalle_ct.txt","w+");
  $Consulta = "SELECT * from detalle_ct where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  while ($Fila = odbc_fetch_row($Respuesta))
  {
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Turno").'","'.odbc_result($Respuesta,"Tobera").'","'.odbc_result($Respuesta,"Aire_soplado").'","'.odbc_result($Respuesta,"Oxigeno").'","'.odbc_result($Respuesta,"Temperatura").'","'.odbc_result($Respuesta,"Gas").'";';

    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);


//***********************************//
  //Tabla Detalle_Pta_Acido
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);
  $anio_1 = odbc_result($rs,"fec");
  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta);
  $mes_1 = odbc_result($rs,"fec");  

  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
  
  $Archivo = fopen("Archivos/detalle_pta_acido.txt","w+");
  $Consulta = "SELECT * from detalle_pta_acido where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  while ($Fila = odbc_fetch_row($Respuesta))
  {    
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Turno").'","'.odbc_result($Respuesta,"Caudal").'","'.odbc_result($Respuesta,"HorasOp").'","'.odbc_result($Respuesta,"Azufre").'","'.odbc_result($Respuesta,"Produccion").'";';

    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);


//*******************************///
  //Tabla Informe_Turno
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);
  $anio_1 = odbc_result($rs,"fec");
  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta);
  $mes_1 = odbc_result($rs,"fec"); 
  
  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
  
  $Archivo = fopen("Archivos/informe_turno.txt","w+");
  $Consulta = "SELECT * from informe_turno where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  while ($Fila = odbc_fetch_row($Respuesta))
  {  
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Turno").'";';
  
    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);

//********************************//
  //Tabla Leyes_Diarias
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);
  $anio_1 = odbc_result($rs,"fec");
  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta);
  $mes_1 = odbc_result($rs,"fec");
  
  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
  
  $Archivo = fopen("Archivos/leyes_diarias.txt","w+");
  $Consulta = "SELECT * from leyes_diarias where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  while ($Fila = odbc_fetch_row($Respuesta))
  {
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Cod_producto").'","'.odbc_result($Respuesta,"Cobre").'","'.odbc_result($Respuesta,"Plata").'","'.odbc_result($Respuesta,"Oro").'","'.odbc_result($Respuesta,"Azufre").'","'.odbc_result($Respuesta,"Fierro").'","'.odbc_result($Respuesta,"Silice").'","'.odbc_result($Respuesta,"Magnetita").'";';

    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);

//******************************//
  //Tabla Leyes_Turno
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);
  $anio_1 = odbc_result($rs,"fec");
  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta);
  $mes_1 = odbc_result($rs,"fec");
  
  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
    

  $Archivo = fopen("Archivos/leyes_turno.txt","w+");
  $Consulta = "SELECT * from leyes_turno where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  while ($Fila = odbc_fetch_row($Respuesta))
  {  
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Cod_producto").'","'.odbc_result($Respuesta,"Turno").'","'.odbc_result($Respuesta,"Cobre").'","'.odbc_result($Respuesta,"Plata").'","'.odbc_result($Respuesta,"Oro").'","'.odbc_result($Respuesta,"Azufre").'","'.odbc_result($Respuesta,"Fierro").'","'.odbc_result($Respuesta,"Silice").'","'.odbc_result($Respuesta,"Magnetita").'";';
  
    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);

//****************************///

  //Tabla Movimientos
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);
  $anio_1 = odbc_result($rs,"fec");
  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta);
  $mes_1 = odbc_result($rs,"fec");
  
  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
  
  $Archivo = fopen("Archivos/movimientos.txt","w+");
  $Consulta = "SELECT * from movimientos where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  while ($Fila = odbc_fetch_row($Respuesta))
  {
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Turno").'","'.odbc_result($Respuesta,"Num_Carga").'","'.odbc_result($Respuesta,"Cod_producto").'","'.odbc_result($Respuesta,"Cod_movimiento").'","'.odbc_result($Respuesta,"Origen").'","'.odbc_result($Respuesta,"Destino").'","'.odbc_result($Respuesta,"Cod_Unidad").'","'.odbc_result($Respuesta,"Cantidad_mov").'","'.odbc_result($Respuesta,"Peso_mov").'";';

    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);


//******************************///
  //Tabla Tiempo_Desconexion
  $consulta = "SELECT max(Ano) as fec from detalle_cps";
  $rs = odbc_exec($conexion,$consulta);
  $anio_1 = odbc_result($rs,"fec");
  
  $consulta = "SELECT max(Mes) as fec from detalle_cps where Ano = ".$anio_1;
  $rs = odbc_exec($conexion,$consulta);
  $mes_1 = odbc_result($rs,"fec");  

  if ($mes_1 == 1)
  {
    $anio_2 = $anio_1 - 1;
    $mes_2 = 12;
  }  
  else
  {
    $mes_2 = $mes_1 - 1;
    $anio_2 = $anio_1;
  }  
  
  $Archivo = fopen("Archivos/tiempo_desconexion.txt","w+");
  $Consulta = "SELECT * from tiempo_desconexion where ((Ano = $anio_1) and (Mes = $mes_1)) or ((Ano = $anio_2) and (Mes = $mes_2))";
  $Respuesta= odbc_exec($conexion,$Consulta);
  while ($Fila = odbc_fetch_row($Respuesta))
  {
    if (strlen(odbc_result($Respuesta,"Mes")) == 1)
      $mes = "0".odbc_result($Respuesta,"Mes");
    else $mes = odbc_result($Respuesta,"Mes");
    if (strlen(odbc_result($Respuesta,"Dia")) == 1)
      $dia = "0".odbc_result($Respuesta,"Dia");
    else $dia = odbc_result($Respuesta,"Dia");        

    $Linea = '"'.odbc_result($Respuesta,"Ano").'-'.$mes.'-'.$dia.'","'.odbc_result($Respuesta,"Cod_equipo").'","'.odbc_result($Respuesta,"Turno").'","'.odbc_result($Respuesta,"Num_desc").'","'.odbc_result($Respuesta,"Cod_observacion").'","'.odbc_result($Respuesta,"Horas_desc").'";';

    fwrite($Archivo,$Linea); 
  }
  fclose($Archivo);



 
//*****************************************************************************///
 
  // Actualiza la Base de Dato Sef creada en  MySql con los datos de los archivos de texto.

  //Tabla detalle_cps
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/detalle_cps.txt" replace into table detalle_cps fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);

  //Tabla datalle_ct
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/detalle_ct.txt" replace into table detalle_ct fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);  

  //Tabla detalle_pta_acido	
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/detalle_pta_acido.txt" replace into table detalle_pta_acido fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);
 
  //Tabla informe_turno
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/informe_turno.txt" replace into table informe_turno fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);

  //Tabla leyes_diarias
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/leyes_diarias.txt" replace into table leyes_diarias fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);  
 
  //Tabla leyes_turno
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/leyes_turno.txt" replace into table leyes_turno fields terminated by "," enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);

 //Tabla movimientos
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/movimientos.txt" replace into table movimientos fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);

  //Tabla tiempo_desconaxion
  $linea = 'load data local infile "F:/Apache/Apache2/htdocs/Proyecto/sef/TraspasoParcial/Archivos/tiempo_desconexion.txt" replace into table tiempo_desconexion fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
  mysql_query($linea);

  odbc_close_all();
  mysql_close($link);
  
  echo "Actualizacion de la BD lista";
?>
