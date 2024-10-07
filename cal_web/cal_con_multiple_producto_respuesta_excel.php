<?php
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename="";
if ( preg_match( '/MSIE/i', $userBrowser ) ) {
$filename = urlencode($filename);
}
$filename = iconv('UTF-8', 'gb2312', $filename);
$file_name = str_replace(".php", "", $file_name);
header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");

header("content-disposition: attachment;filename={$file_name}");
header( "Cache-Control: public" );
header( "Pragma: public" );
header( "Content-type: text/csv" ) ;
header( "Content-Dis; filename={$file_name}" ) ;
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../principal/conectar_principal.php");

$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;

$ProSubPro = $_REQUEST["ProSubPro"];
$Periodo = $_REQUEST["Periodo"];
$Tipo = $_REQUEST["Tipo"];
$Analisis = $_REQUEST["Analisis"];
$Producto = $_REQUEST["Producto"];
$SubProducto = $_REQUEST["SubProducto"];
$FechaI = $_REQUEST["FechaI"];
$FechaT = $_REQUEST["FechaT"];
$CodLeyes = $_REQUEST["CodLeyes"];
$AbrevLey = $_REQUEST["AbrevLey"];
$Enabal = $_REQUEST["Enabal"];

//corta el signo ultimo del string - 
$CodLeyes=substr($CodLeyes,0,strlen($CodLeyes)-1);
//se crea un arreglo y se elimna las ~
$ArrayLeyes = explode("~",$CodLeyes);
//se crea un arreglo y se elimna las ~~
$ArrayDesc = explode("~~",$AbrevLey);
//cuenta los elementos del arreglo y los asigna a una variable 
$LargoArray = count($ArrayLeyes);
//El arreglo se posiciona en la 1� Posicion 
reset($ArrayLeyes);
reset($ArrayDesc);
//Se crea el arreglo 2
$Array2 = array();
//se recorre ele arreglo 
for ($i=0;$i<$LargoArray;$i++)
{
	//al arreglo2 se le asigna en la  posicion ["cod_leyes"][0] la descripcion
	//["cod_leyes"] va a tomar la posicion del indice 
	$Array2[$ArrayLeyes[$i]][0]="";
	$Array2[$ArrayLeyes[$i]][1]=$ArrayDesc[$i];
	//al arreglo2 se le asigna en la  posicion ["cod_leyes"][1] se asigna ""
	//ya que va  a ir el valor
	$Array2[$ArrayLeyes[$i]][2]="";
}
//posiciono el array2 en la 1� posicion 
reset($Array2);
//K corresponde a la posicion o al codigo de la ley que ahora va aser el indice
//V[0] corresponde al valor o descripcion
//V[1] corresponde al que voy a recuperar de la consulta
//se pasa el arreglo2 a K donde K va a ser las posicion o indice de las filas  
//V corresponde al valor de las columnas
//while (list($K,$V)=each($Array2))
foreach($Array2 as $K=>$V)
{
	//A leyes se asigna los indices que van a ser los   codigos de las leyes
	$Leyes=$Leyes."(t3.cod_leyes = '".$K."')or";
	$LeySola=$LeySola."(cod_leyes = '".$K."')or";
}
//corto el ultimo or
$Pregunta=substr($Leyes,0,strlen($Leyes)-2);
$ConsultaLey=substr($LeySola,0,strlen($LeySola)-2);
?>
<html>
<head>
<title>Consulta Por Productos</title>
</head>
<body>
<table width="767" border="0">
  <tr>
    <td colspan="3"><table width="767" border="0" cellpadding="3" cellspacing="0">
        <tr align="left"> 
          <td width="123"><strong>Fecha Inicio</strong></td>
          <td width="632" colspan="4"><?php echo $FechaI   ?></td>
          <?php 
		  //Consulta que devuelve el nomnbre del periodo y la asigna a la variable tipo periodo
		  $Consulta ="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase = '2'";
		  $Consulta =$Consulta." and cod_subclase = '".$Periodo."'";
     	  $Respuesta= mysqli_query($link, $Consulta);
		  $Fila= mysqli_fetch_array($Respuesta); 
		  $TipoPeriodo= $Fila["nombre_subclase"];
		  ?>
        </tr>
        <tr align="left"> 
          <td><strong>Fecha Termino</strong></td>
          <td colspan="4"><?php echo $FechaT   ?></td>
        </tr>
        <tr align="left"> 
          <td><strong>Periodo</strong></td>
          <td colspan="4"><?php echo $TipoPeriodo  ?></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
        
<table width="767" border="1" cellpadding="3" cellspacing="0">
  <tr> 
            <td><div align="center">Producto</div></td>
            <td><div align="center">Sub-Producto</div></td>
			<td><div align="center">#SA</div></td>
			<td><div align="center">Id Muestra</div>
			<td><div align="center">Fecha Creacion</div></td>
			<td ><div align="center">Fecha Muestra</div></td>
           	
		   <?php 
			//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
			//Se posiciona en la 1� posicion
			reset($Array2);
			//recorro el arreglo y le paso el array2 a K
			//while(list($Clave,$Valor)=each($Array2))
			foreach($Array2 as $Clave=>$Valor)
			{
				echo "<td width='15'>";
				echo $Valor[0]."Signo";//Signo
				echo "</td>";
				echo "<td width='50'>";
				echo $Valor[1];//Descripcion
				echo "</td>";
				echo "<td width='15'>";
				echo $Valor[2]."Unidad";//Abreviatura
				echo "</td>";	
			}
			echo "<td width='130'><div align='center'>Fecha Recepcion</div></td>";
			echo "<td width='130'><div align='center'>Fecha Finalizada</div></td>";
			for ($j = 0;$j <= strlen($ProSubPro); $j++)
			{
					if (substr($ProSubPro,$j,2) == "//")
					{
						$ProSPro = substr($ProSubPro,0,$j);
						for ($x=0;$x<=strlen($ProSPro);$x++)
						{
							if (substr($ProSPro,$x,2) == "~~")
							{
								//$FechaI = $FechaI.' 00:01';
								//$FechaT = $FechaT.' 23:59';
								$Producto = substr($ProSubPro,0,$x);			
								$SubProducto = substr($ProSPro,$x+2,strlen($ProSPro));
								$Consulta = "select abreviatura,cod_producto from proyecto_modernizacion.productos where cod_producto ='".$Producto."' ";
								$Respuesta=mysqli_query($link, $Consulta); 
								$Fila=mysqli_fetch_array($Respuesta); 
								$DesProd=$Fila["abreviatura"];
								$Consulta = "select abreviatura as DesSubProducto,cod_subproducto from proyecto_modernizacion.subproducto where cod_subproducto ='".$SubProducto."' and cod_producto='".$Fila["cod_producto"]."' ";
								$Respuesta1=mysqli_query($link, $Consulta); 
								$Fila1=mysqli_fetch_array($Respuesta1); 
								$DesSubP=$Fila1["DesSubProducto"];	
								$Consulta ="select distinct (t3.nro_solicitud),t1.nro_sa_lims,t3.recargo,t1.tipo_solicitud,t1.fecha_hora,t1.id_muestra,t1.fecha_muestra,t1.rut_funcionario from cal_web.solicitud_analisis t1 "; 
								$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3";
								$Consulta = $Consulta." on (t1.nro_solicitud = t3.nro_solicitud and t3.candado='1' and t1.recargo = t3.recargo  and t1.fecha_hora = t3.fecha_hora and t1.rut_funcionario = t3.rut_funcionario)  inner join 	proyecto_modernizacion.leyes t4 ";
								$Consulta = $Consulta." on t3.cod_leyes = t4.cod_leyes where ";
								$Consulta = $Consulta." (t1.fecha_muestra between  '".$FechaI." 00:01' and '".$FechaT." 23:59') and";
								$Consulta = $Consulta." (".$Pregunta.") and(t1.estado_actual = 5 or t1.estado_actual = 6 or t1.estado_actual = 31 or t1.estado_actual = 32)and ";
								$Consulta = $Consulta." (t1.cod_producto = '".$Fila["cod_producto"]."' and t1.cod_subproducto = '".$Fila1["cod_subproducto"]."') and t1.cod_periodo = '".$Periodo."' ";						
								if ($Enabal=="S")
								{
									$Consulta = $Consulta." and t1.enabal = 'S'";						
								}
								if ($Tipo!='-1')
								{
									$Consulta = $Consulta." and t1.tipo='".$Tipo."'"; 
								}
								if ($Analisis!='-1')
								{
									$Consulta = $Consulta." and t1.cod_analisis='".$Analisis."'"; 
								}
								$Consulta = $Consulta." order by t1.fecha_muestra,t1.nro_solicitud";
								$Respuesta2=mysqli_query($link, $Consulta);
								while ($Fila2=mysqli_fetch_array($Respuesta2))
								{
									echo "<tr>";	
									echo "<td>".$DesProd."</td>";	
									echo "<td>".$DesSubP."</td>";
										
									if ($Fila2["tipo_solicitud"]=='R')
									{

										if ($Fila2["nro_sa_lims"]=='') {
			              					echo "<td>".$Fila2["nro_solicitud"]."</td>";
			              				}else{
			              					echo "<td>".$Fila2["nro_sa_lims"]."</td>";
			              				}


										 
										echo "<td>".$Fila2["id_muestra"]."</td>";
										echo "<td>".$Fila2["fecha_hora"]."</td>";
										echo "<td>".$Fila2["fecha_muestra"]."&nbsp</td>";
									}	
									else
									{
										
										if ((is_null($Fila2["recargo"])) || ($Fila2["recargo"]==''))	
										{

											if ($Fila2["nro_sa_lims"]=='') {
				              					echo "<td>".$Fila2["nro_solicitud"]."</td>";
				              				}else{
				              					echo "<td>".$Fila2["nro_sa_lims"]."</td>";
				              				}


											 										
										}
										else
										{

											if ($Fila2["nro_sa_lims"]=='') {
			              						echo "<td>".$Fila2["nro_solicitud"].'-'.$Fila2["recargo"]."</td>";
				              				}else{
				              					echo "<td>".$Fila2["nro_sa_lims"].'-'.$Fila2["recargo"]."</td>";
				              				}


											 
										}
										echo "<td>".$Fila2["id_muestra"]."</td>";
										echo "<td>".$Fila2["fecha_hora"]."</td>";
										echo "<td>".$Fila2["fecha_muestra"]."&nbsp</td>";
									}
									//SE LIMPIA EL ARREGLO
									reset($Array2);
									//limpia el arreglo en la posicion de los valores 
									//while(list($Clave,$Valor)=each($Array2))
									foreach($Array2 as $Clave=>$Valor)
									{
										$Array2[$Clave][1]="&nbsp;";
										$Array2[$Clave][2]="&nbsp;";
										$Array2[$Clave][3]="&nbsp;";
									}
									$Consulta ="select t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 ";
									$Consulta.= " inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad ";  
									$Consulta.=" where nro_solicitud = ".$Fila2["nro_solicitud"]." and recargo='".$Fila2["recargo"]."' and (".$ConsultaLey.") order by cod_leyes ";
									$Respuesta3=mysqli_query($link, $Consulta);
									//echo $Consulta."<br>";
									while($Fila3=mysqli_fetch_array($Respuesta3))
									{
										if ($Fila3["signo"]=="N")
										{
											$Array2[$Fila3["cod_leyes"]][2]="ND";
										}
										else
										{
											if ($Fila3["signo"]=="=")
											{
												$Valor=number_format($Fila3["valor"],3,",","");
												$Array2[$Fila3["cod_leyes"]][2]=$Valor;
												$Array2[$Fila3["cod_leyes"]][3]=$Fila3["abreviatura"];
											}
											else
											{
												$Valor=number_format($Fila3["valor"],3,",","");
												$Array2[$Fila3["cod_leyes"]][1]=$Fila3["signo"];
												$Array2[$Fila3["cod_leyes"]][2]=$Valor;
												$Array2[$Fila3["cod_leyes"]][3]=$Fila3["abreviatura"];
													
											}
										}		
									}
									//posiono el arreglo en la 1�posicion 
									reset($Array2);
									//a CLAVE se van los indices del arreglo2 
									//VALOR se van los valores de la columna 1
									//while(list($Clave,$Valor)=each($Array2))
									foreach($Array2 as $Clave=>$Valor)
									{
										echo "<td width='10'>";
										//musetro el valor en la posicion 1  
										echo $Valor[1]."&nbsp;";//signo
										echo "</td>";
										echo "<td>";
										echo $Valor[2];//valor
										echo "</td>";
										echo "<td width='15'>";
										echo $Valor[3];//abreviatura
										echo "</td>";
									}
									if ((is_null($Fila2["recargo"])) || ($Fila2["recargo"]==''))
									{
										$Consulta="select fecha_hora from cal_web.estados_por_solicitud where rut_funcionario='".$Fila2["rut_funcionario"]."'";
										$Consulta=$Consulta." and nro_solicitud='".$Fila2["nro_solicitud"]."' and recargo='".$Fila2["recargo"]."' and cod_estado='4'";
										$RespuestaEstados=mysqli_query($link, $Consulta);
										$FilaEstado=mysqli_fetch_array($RespuestaEstados);
										$FechaEstado1=isset($FilaEstado["fecha_hora"])?$FilaEstado["fecha_hora"]:"";
										$Consulta="select fecha_hora from cal_web.estados_por_solicitud where rut_funcionario='".$Fila2["rut_funcionario"]."'";
										$Consulta=$Consulta." and nro_solicitud='".$Fila2["nro_solicitud"]."' and recargo='".$Fila2["recargo"]."' and cod_estado='6'";
										$RespuestaEstados=mysqli_query($link, $Consulta);
										$FilaEstado=mysqli_fetch_array($RespuestaEstados);
										$FechaEstado2=isset($FilaEstado["fecha_hora"])?$FilaEstado["fecha_hora"]:"";
									}
									else
									{
										$Consulta="select fecha_hora from cal_web.estados_por_solicitud where rut_funcionario='".$Fila2["rut_funcionario"]."'";
										$Consulta=$Consulta." and nro_solicitud='".$Fila2["nro_solicitud"]."' and cod_estado='4'";
										$RespuestaEstados=mysqli_query($link, $Consulta);
										$FilaEstado=mysqli_fetch_array($RespuestaEstados);
										$FechaEstado1=$FilaEstado["fecha_hora"];
										$Consulta="select fecha_hora from cal_web.estados_por_solicitud where rut_funcionario='".$Fila2["rut_funcionario"]."'";
										$Consulta=$Consulta." and nro_solicitud='".$Fila2["nro_solicitud"]."' and cod_estado='6'";
										$RespuestaEstados=mysqli_query($link, $Consulta);
										$FilaEstado=mysqli_fetch_array($RespuestaEstados);
										$FechaEstado2=$FilaEstado["fecha_hora"];
									}
									echo "<td>".$FechaEstado1."</td>";
									echo "<td>".$FechaEstado2."</td>";
									echo "</tr>\n";														
								}	
	
							}
						}				
						$ProSubPro = substr($ProSubPro,$j + 2);
						$j = 0;	 
					}	
			 }
			?>
        </table>
        </body>
</html>
