<?php 
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
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
	$Array2[$ArrayLeyes[$i]][0]=$ArrayDesc[$i];
	//al arreglo2 se le asigna en la  posicion ["cod_leyes"][1] se asigna ""
	//ya que va  a ir el valor
	$Array2[$ArrayLeyes[$i]][1]="";
}
//posiciono el array2 en la 1� posicion 
reset($Array2);
//K corresponde a la posicion o al codigo de la ley que ahora va aser el indice
//V[0] corresponde al valor o descripcion
//V[1] corresponde al que voy a recuperar de la consulta
//se pasa el arreglo2 a K donde K va a ser las posicion o indice de las filas  
//V corresponde al valor de las columnas
while (list($K,$V)=each($Array2))
{
	//A leyes se asigna los indices que van a ser los   codigos de las leyes
	$Leyes=$Leyes."(t3.cod_leyes = '".$K."')or";
}
//corto el ultimo or
$Pregunta=substr($Leyes,0,strlen($Leyes)-2);
?>
<html>
<head>
<title>Consulta Por Productos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.FrmConsulta;
	switch (Opcion)
	{
		case "R":
			frm.action="cal_con_multiple_producto.php?TxtProducto=" + frm.TxtProducto.value + "&TxtSubProducto=" + frm.TxtSubProducto.value;
			frm.submit();
			break;
		case "A":
			Asignar();
			break;
		case "S":
			Salir();
			break;
	}
}	
function Salir()
{
	var frm=document.FrmConsulta;
	/*frm.action="cal_con_leyes_producto01.php?Salir=2";
	frm.submit();*/
	window.history.back();
}
function Imprimir()
{
	window.print();
}
</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsulta" method="post" action="">
    <table width="782" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="770"><font size="1"><font size="1"><font size="2"> </font></font></font> 
        <table width="774" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="3"><div align="right">Fecha Inicio</div></td>
            <td width="105"><?php echo $FechaI   ?></td>
            <td width="100">Fecha Termino</td>
            <td width="125"><?php echo $FechaT   ?></td>
          <?php 
		  //Consulta que devuelve el nomnbre del periodo y la asigna a la variable tipo periodo
		  $Consulta ="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase = '2'";
		  $Consulta =$Consulta." and cod_subclase = '".$Periodo."'";
     	  $Respuesta= mysqli_query($link, $Consulta);
		  $Fila= mysqli_fetch_array($Respuesta); 
		  $TipoPeriodo= $Fila["nombre_subclase"];
		  ?>
		    <td width="44">Periodo</td>
            <td width="167"><?php echo $TipoPeriodo  ?></td>
          </tr>
          <tr> 
            <td colspan="8"><font size="1"><font size="2"> </font><font size="2"><strong></strong></font></font></td>
          </tr>
          <tr> 
            <td colspan="8"><div align="center"><font size="1"><font size="1"><font size="2"><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></font></font></font></font></div></td>
          </tr>
        </table>
        <br>
        <table width="767" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="243"><div align="center">Producto</div></td>
            <td width="254"><div align="center">Sub-Producto</div></td>
           	<td width="244"><div align="center">#SA</div></td>
		   <?php 
			//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
			//Se posiciona en la 1� posicion
			reset($Array2);
			//recorro el arreglo y le paso el array2 a K
			while(list($Clave,$Valor)=each($Array2))
			{
				echo "<td>";
				//muestro el valor de la columna
				echo $Valor[0];
				echo "</td>";
			}  
			for ($j = 0;$j <= strlen($ProSubPro); $j++)
			{
					if (substr($ProSubPro,$j,2) == "//")
					{
						$ProSPro = substr($ProSubPro,0,$j);
						for ($x=0;$x<=strlen($ProSPro);$x++)
						{
							if (substr($ProSPro,$x,2) == "~~")
							{
								$FechaI = $FechaI.' 00:01';
								$FechaT = $FechaT.' 23:59';
								$Producto = substr($ProSubPro,0,$x);			
								$SubProducto = substr($ProSPro,$x+2,strlen($ProSPro));
								$Consulta = "select descripcion,cod_producto from proyecto_modernizacion.productos where cod_producto =".$Producto." ";
								$Respuesta=mysqli_query($link, $Consulta); 
								$Fila=mysqli_fetch_array($Respuesta); 
								$DesProd=$Fila["descripcion"];
								$Consulta = "select descripcion as DesSubProducto,cod_subproducto from proyecto_modernizacion.subproducto where cod_subproducto =".$SubProducto." and cod_producto='".$Fila["cod_producto"]."' ";
								$Respuesta1=mysqli_query($link, $Consulta); 
								$Fila1=mysqli_fetch_array($Respuesta1); 
								$DesSubP=$Fila1["DesSubProducto"];	
								$Consulta ="select distinct t3.nro_solicitud,t1.recargo,t1.tipo_solicitud from cal_web.solicitud_analisis t1 "; 
								$Consulta = $Consulta." inner join cal_web.periodos_solicitud_analisis t2 on t1.rut_funcionario=t2.rut_funcionario";
								$Consulta = $Consulta." and t1.id_muestra = t2.id_muestra inner join cal_web.leyes_por_solicitud t3";
								$Consulta = $Consulta." on t1.nro_solicitud = t3.nro_solicitud  inner join 	proyecto_modernizacion.leyes t4 ";
								$Consulta = $Consulta." on t3.cod_leyes = t4.cod_leyes where ";
								$Consulta = $Consulta." (t3.fecha_hora between  '".$FechaI."' and '".$FechaT."') and";
								$Consulta = $Consulta." (".$Pregunta.") and(t1.estado_actual = 5 or t1.estado_actual = 6 )and (t1.cod_periodo='".$Periodo."')"; 
								$Consulta = $Consulta." and (t3.cod_producto = '".$Fila["cod_producto"]."' and t3.cod_subproducto = '".$Fila1["cod_subproducto"]."')   ";						
								//echo $Consulta."<br>";
								$Respuesta2=mysqli_query($link, $Consulta);
								while ($Fila2=mysqli_fetch_array($Respuesta2))
								{
									echo "<tr>";	
									echo "<td>".$DesProd."</td>";	
									echo "<td>".$DesSubP."</td>";
										
									if ($Fila2["tipo_solictud"]=='R')
									{
										echo "<td>".$Fila2["nro_solicitud"]."</td>";
									}	
									else
									{
										if ((is_null($Fila2["recargo"])) || ($Fila2["recargo"]==''))	
										{										
											echo "<td>".$Fila2["nro_solicitud"]."</td>";										
										}
										else
										{
											echo "<td>".$Fila2["nro_solicitud"].'-'.$Fila2["recargo"]."</td>";
										}
									}
									//SE LIMPIA EL ARREGLO
									reset($Array2);
									//limpia el arreglo en la posicion de los valores 
									while(list($Clave,$Valor)=each($Array2))
									{
										$Array2[$Clave][1]="&nbsp;";				
									}
									$Consulta ="select cod_leyes,valor,signo from cal_web.leyes_por_solicitud where nro_solicitud = ".$Fila2["nro_solicitud"]." and recargo='".$Fila2["recargo"]."'";
									$Respuesta3=mysqli_query($link, $Consulta);
									$Respuesta3=mysqli_query($link, $Consulta);
									while($Fila3=mysqli_fetch_array($Respuesta3))
									{
										if ($Fila3["signo"]=="N")
										{
											$Array2[$Fila3["cod_leyes"]][1]="ND";
										}
										else
										{
											$Array2[$Fila3["cod_leyes"]][1]=$Fila3["valor"];
										}		
									}
									//posiono el arreglo en la 1�posicion 
									reset($Array2);
									//a CLAVE se van los indices del arreglo2 
									//VALOR se van los valores de la columna 1
									while(list($Clave,$Valor)=each($Array2))
									{
										echo "<td>";
										//musetro el valor en la posicion 1  
										echo $Valor[1]."&nbsp";
	
										echo "</td>";
									}  
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
        <br>
        <table width="772" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="99"><div align="center"> </div></td>
            <td width="60">&nbsp;</td>
            <td width="245"><div align="center">
                <input name="BtnImprimir" type="button" id="BtnImprimir2" value="Imprimir" style="width:60" onClick="Imprimir('');">
              </div></td>
            <td width="86"><div align="center"> 
                <input name="BtnSalir" type="Button"  value="Salir" style="width:60" onClick="Salir();">
              </div></td>
            <td width="249">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
 </form>
</body>
</html>
