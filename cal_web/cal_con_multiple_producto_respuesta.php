<?php 
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
//CodLeyes=" + frm.TxtCodLeyes.value + "&AbrevLey=" + frm.TxtLeyesAbrev.value + "&Enabal="+Ena ;
if(isset($_REQUEST["ProSubPro"])) {
	$ProSubPro = $_REQUEST["ProSubPro"];
}else{
	$ProSubPro =  "";
}
if(isset($_REQUEST["Periodo"])) {
	$Periodo = $_REQUEST["Periodo"];
}else{
	$Periodo =  "";
}
if(isset($_REQUEST["Tipo"])) {
	$Tipo = $_REQUEST["Tipo"];
}else{
	$Tipo =  "";
}
if(isset($_REQUEST["Analisis"])) {
	$Analisis = $_REQUEST["Analisis"];
}else{
	$Analisis =  "";
}
if(isset($_REQUEST["Producto"])) {
	$Producto = $_REQUEST["Producto"];
}else{
	$Producto =  "";
}
if(isset($_REQUEST["SubProducto"])) {
	$SubProducto = $_REQUEST["SubProducto"];
}else{
	$SubProducto =  "";
}
if(isset($_REQUEST["FechaI"])) {
	$FechaI = $_REQUEST["FechaI"];
}else{
	$FechaI =  "";
}
if(isset($_REQUEST["FechaT"])) {
	$FechaT = $_REQUEST["FechaT"];
}else{
	$FechaT =  "";
}
if(isset($_REQUEST["CodLeyes"])) {
	$CodLeyes = $_REQUEST["CodLeyes"];
}else{
	$CodLeyes =  "";
}
if(isset($_REQUEST["AbrevLey"])) {
	$AbrevLey = $_REQUEST["AbrevLey"];
}else{
	$AbrevLey =  "";
}
if(isset($_REQUEST["Enabal"])) {
	$Enabal = $_REQUEST["Enabal"];
}else{
	$Enabal =  "";
}

if (!isset($ff))
{
	echo "<input type='hidden' name ='TxtCodLeyes' value='$CodLeyes'>";
	$TxtCodLeyes=$CodLeyes; 
	echo "<input type='hidden' name ='TxtDesCodLeyes' value='$AbrevLey'>";
	$TxtDesCodLeyes=$AbrevLey; 
}
else
{
	$TxtCodLeyes=$CodigoL;
	$TxtDesCodLeyes=$DesCodigoL;
	echo "<input type='hidden' name ='TxtCodLeyes' value='$CodigoL'>";
	echo "<input type='hidden' name ='TxtDesCodLeyes' value='$DesCodigoL'>";
}
//if ($TxtCodLeyes!="")
	//corta el signo ultimo del string - 
	$CodLeyes=substr($TxtCodLeyes,0,strlen($TxtCodLeyes)-1);
	//echo "leyes".$CodLeyes."<br>";
	//se crea un arreglo y se elimna las ~
	$ArrayLeyes = explode("~",$CodLeyes);
	//se crea un arreglo y se elimna las ~~
	$ArrayDesc = explode("~~",$AbrevLey);
	$ArrayDesc = explode("~~",$TxtDesCodLeyes);
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
	if (!isset($ff))
	{
		//while (list($K,$V)=each($Array2))
		foreach($Array2 as $K=>$V)
		{
			//A leyes se asigna los indices que van a ser los   codigos de las leyes
			$Leyes=$Leyes." t3.cod_leyes = ".$K." or";
			$LeySola=$LeySola." cod_leyes = ".$K." or";
		}
		//corto el ultimo or doinde van las leyes
		$Pregunta=substr($Leyes,0,strlen($Leyes)-2);
		$ConsultaLey=substr($LeySola,0,strlen($LeySola)-2);
		echo "<input type='hidden' name ='TxtPregunta' value='$Pregunta'>";
		$TxtPregunta=$Pregunta;
		echo "<input type='hidden' name ='TxtPeriodo' value='$Periodo'>";
		$TxtPeriodo=$Periodo;
		echo "<input type='hidden' name ='TxtTipo' value='$Tipo'>";
		$TxtTipo=$Tipo;
		echo "<input type='hidden' name ='TxtTipoAnalisis' value='$Analisis'>";
		$TxtTipoAnalisis=$Analisis;
		echo "<input type='hidden' name ='TxtFecha' value='$FechaI'>";
		$TxtFecha=$FechaI;
		echo "<input type='hidden' name ='TxtFechaT' value='$FechaT'>";
		$TxtFechaT=$FechaT;	
		$ProS = $ProSubPro;
		
	}
	else
	{
		echo "<input name='TxtPregunta' type='hidden' value='$ff'>";
		$TxtPregunta=$ff;
		$TxtPeriodo=$Per;
		$TxtTipo=$Tip;
		$TxtTipoAnalisis=$TipAn;
		$TxtFecha=$FechaInicio;
		$TxtFechaT=$FechaTermino;
	}

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
	frm.action="cal_con_leyes_producto01.php?Salir=2";
	frm.submit();
	//window.history.back();
}
function Imprimir()
{
	window.print();
}
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
//function Recarga(URL,LimiteIni)
//function Recarga(FechaI,FechaT,Pregunta,Periodo,Producto,SubProducto,LimiteIni)
function Recarga(LimiteIni,E)
{
	var frm=document.FrmConsulta;
	//alert(E);
	frm.LimitIni.value = LimiteIni;
	frm.action="cal_con_multiple_producto_respuesta.php?ProS=" + frm.ProS.value + "&LimitIni=" + LimiteIni + "&Enabal="+E;
	frm.submit(); 
}
	
</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsulta" method="post" action="">
 <?php
	if (!isset($LimitIni))
		$LimitIni = 0;
?>
<input type="hidden" name="ff" value="<?php echo $TxtPregunta; ?>">
<input type="hidden" name="Per" value="<?php echo $TxtPeriodo; ?>">
<input type="hidden" name="Tip" value="<?php echo $TxtTipo; ?>">
<input type="hidden" name="TipAn" value="<?php echo $TxtTipoAnalisis; ?>">
<input type="hidden" name="FechaInicio" value="<?php echo $TxtFecha; ?>">
<input type="hidden" name="FechaTermino" value="<?php echo $TxtFechaT; ?>">
<input type="hidden" name="ProS" value="<?php echo $ProS; ?>">
<input type="hidden" name="CodigoL" value="<?php echo $TxtCodLeyes; ?>">
<input type="hidden" name="DesCodigoL" value="<?php echo $TxtDesCodLeyes; ?>">
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="694" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="146"><div align="right">Fecha Inicio</div></td>
      <td width="105"><?php echo $FechaI   ?></td>
      <td width="100">Fecha Termino</td>
      <td width="125"><?php echo $FechaT   ?></td>
      <?php 
		  //Consulta que devuelve el nomnbre del periodo y la asigna a la variable tipo periodo
		  $Consulta ="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase = '2'";
		  $Consulta =$Consulta." and cod_subclase = '".$TxtPeriodo."'";
     	  $Respuesta= mysqli_query($link, $Consulta);
		  $Fila= mysqli_fetch_array($Respuesta); 
		  $TipoPeriodo= $Fila["nombre_subclase"];
		  ?>
      <td width="44">Periodo</td>
      <td width="135"><?php echo $TipoPeriodo  ?></td>
      <?php $LimitFin = '30';   ?>
    </tr>
    <tr>
      <td> <div align="right">Tipo Muestreo</div></td>
      <?php 
	  //Consulta que devuelve el nomnbre del periodo y la asigna a la variable tipo periodo
	  $Consulta ="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase=1005";
	  $Consulta =$Consulta." and cod_subclase = '".$TxtTipo."'";
	  $Respuesta= mysqli_query($link, $Consulta);
	  $Fila= mysqli_fetch_array($Respuesta); 
	  $Tipo= $Fila["nombre_subclase"];
	  ?>
	  <td>
	  	<?php 
	  	if ($TxtTipo=='-1')
	  	{	
			echo "Todos";
		}
		else
		{	
			echo $Tipo ;
		 }
		 ?>
	 	</td>
      <td>Tipo Analisis</td>
      <td>
	  <?php 
	  if ($TxtTipoAnalisis=='-1')
	  {
	 	 echo "Todos";
	  }
	  else
	  {	
	  	if ($TxtTipoAnalisis=='1')
	 	 {
		 	echo "Quimico";  
		 }
		 else
		 {
		 	echo "Fisico";  
		 }
	  } 	
	  ?>
	  </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
   <br>
<?php
	reset($Array2);
	$Contador = 1;
	while(list($Clave,$Valor)=each($Array2))
	{
		$Contador++;
	}  
	$AnchoTabla = ($Contador * 80) + 550;
?>        
  <table width="<?php echo $AnchoTabla;  ?>" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
    <tr class="ColorTabla01"> 
            <td width="87"><div align="center">Producto</div></td>
            <td width="97"><div align="center">Sub-Producto</div></td>
			<td width="120"><div align="center">#SA</div></td>
			<td width="127"><div align="center">Agrupacion</div>
			<td width="127"><div align="center">Id Muestra</div>
			<td width="130"><div align="center">Fecha Creacion</div></td>
			<td width="130"><div align="center">Fecha Muestra</div></td>
           	
		   <?php 
			//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
			//Se posiciona en la 1� posicion
			reset($Array2);
			//recorro el arreglo y le paso el array2 a K
			while(list($Clave,$Valor)=each($Array2))
			{
				echo "<td width='70'>";
				//muestro el valor de la columna osea las abreviaturas de las leyes
				echo $Valor[0];
				echo "</td>";
			} 
			echo "<td width='130'><div align='center'>Fecha Recepcion</div></td>";
			echo "<td width='130'><div align='center'>Fecha Finalizada</div></td>";
			$ProSAux=$ProS;
			for ($j = 0;$j <= strlen($ProS); $j++)
			{
					if (substr($ProS,$j,2) == "//")
					{
						$ProSPro = substr($ProS,0,$j);
						for ($x=0;$x<=strlen($ProSPro);$x++)
						{
							if (substr($ProSPro,$x,2) == "~~")
							{
								$TxtFecha = $TxtFecha;
								$TxtFechaT = $TxtFechaT;
								$Producto = substr($ProS,0,$x);			
								$SubProducto = substr($ProSPro,$x+2,strlen($ProSPro));
								$Consulta = "select abreviatura,cod_producto from proyecto_modernizacion.productos where cod_producto =".$Producto." ";
								$Respuesta=mysqli_query($link, $Consulta); 
								$Fila=mysqli_fetch_array($Respuesta); 
								$DesProd=$Fila["abreviatura"];
								$Consulta = "select abreviatura as DesSubProducto,cod_subproducto from proyecto_modernizacion.subproducto where cod_subproducto =".$SubProducto." and cod_producto='".$Fila["cod_producto"]."' ";
								$Respuesta1=mysqli_query($link, $Consulta); 
								$Fila1=mysqli_fetch_array($Respuesta1); 
								$DesSubP=$Fila1["DesSubProducto"];	
								$Consulta ="select distinct STRAIGHT_JOIN t1.nro_solicitud,t1.nro_sa_lims,t1.recargo,t1.tipo_solicitud,t1.fecha_hora,t1.id_muestra,t1.fecha_muestra,t5.nombre_subclase,t1.rut_funcionario from cal_web.solicitud_analisis t1 "; 
								$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3";
								$Consulta = $Consulta." on (t1.nro_solicitud = t3.nro_solicitud and t3.candado='1' and t1.recargo = t3.recargo and t1.rut_funcionario = t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora) and (t1.estado_actual = 5 or t1.estado_actual = 6 or t1.estado_actual = 31 or t1.estado_actual = 32)  ";
								$Consulta = $Consulta." inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes ";
								$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t5 on cod_clase = 1004 and t1.agrupacion = t5.cod_subclase  ";
								$Consulta = $Consulta." where (t1.fecha_muestra between  '".$TxtFecha." 00:01' and '".$TxtFechaT." 23:59') and";
								$Consulta = $Consulta." (".$TxtPregunta.") and t1.cod_periodo = '".$TxtPeriodo."'";
								$Consulta = $Consulta." and (t1.cod_producto = '".$Fila["cod_producto"]."' and t1.cod_subproducto = '".$Fila1["cod_subproducto"]."')";
								if ($Enabal=="S")
								{
									$Consulta = $Consulta." and t1.enabal = 'S'";						
								}
								if ($TxtTipo != '-1')
								{
									$Consulta = $Consulta." and t1.tipo='".$TxtTipo."'"; 
								}
								if ($TxtTipoAnalisis != '-1')
								{
									$Consulta = $Consulta." and t1.cod_analisis='".$TxtTipoAnalisis."'"; 
								}
								$Consulta = $Consulta." order by t1.fecha_muestra,t1.nro_solicitud";						
								$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
								//polyta   echo "CON".$Consulta;
								$Respuesta2=mysqli_query($link, $Consulta);
								while ($Fila2=mysqli_fetch_array($Respuesta2))
								{
									echo "<tr>";	
									echo "<td>".$DesProd."</td>";	
									echo "<td>".$DesSubP."</td>";
										
									if ($Fila2["tipo_solicitud"]=='R')
									{
										if ((is_null($Fila2["recargo"])) || ($Fila2["recargo"]==''))
										{
											$Recargo='N';
										}	
										echo "<td width='120'><a href=\"JavaScript:Historial(".$Fila2["nro_solicitud"].",'".$Recargo."')\">\n";

										if ($Fila2["nro_sa_lims"]=='') {
		              						$VarSA=$Fila2["nro_solicitud"];
			              				}else{
			              					$VarSA=$Fila2["nro_sa_lims"];
			              				}
										echo $Fila2["nro_solicitud"]."</a></td>\n";

										echo "<td>".$Fila2["nombre_subclase"]."</td>";
										echo "<td>".$Fila2["id_muestra"]."</td>";
										echo "<td>".$Fila2["fecha_hora"]."</td>";
										echo "<td>".$Fila2["fecha_muestra"]."&nbsp</td>";
									}	
									else
									{
										if ($Fila2["nro_sa_lims"]=='') {
		              						$VarSA=$Fila2["nro_solicitud"];
			              				}else{
			              					$VarSA=$Fila2["nro_sa_lims"];
			              				}


										
										if ((is_null($Fila2["recargo"])) || ($Fila2["recargo"]==''))	
										{										
											$Recargo='N';																
											echo "<td width='120' ><a href=\"JavaScript:Historial(".$Fila2["nro_solicitud"].",'".$Recargo."')\">\n";
											echo $VarSA."</a></td>\n";
										}
										else
										{
											echo "<td width='120'><a href=\"JavaScript:Historial(".$Fila2["nro_solicitud"].",'".$Fila2["recargo"]."')\">\n";
											echo $VarSA."-".$Fila2["recargo"]."</td>\n";
										}
										echo "<td>".$Fila2["nombre_subclase"]."</td>";
										echo "<td>".$Fila2["id_muestra"]."</td>";
										echo "<td>".$Fila2["fecha_hora"]."</td>";
										echo "<td>".$Fila2["fecha_muestra"]."&nbsp</td>";
									}
									
									//SE LIMPIA EL ARREGLO
									reset($Array2);
									//limpia el arreglo en la posicion de los valores 
									while(list($Clave,$Valor)=each($Array2))
									{
										$Array2[$Clave][1]="&nbsp;";
										$Array2[$Clave][2]="&nbsp;";
										$Array2[$Clave][3]="&nbsp;";													
									}
									$Consulta ="select STRAIGHT_JOIN  t3.cod_leyes,t3.valor,t3.signo,t2.abreviatura from cal_web.leyes_por_solicitud t3 ";
									$Consulta.= " inner join proyecto_modernizacion.unidades t2 on t3.cod_unidad = t2.cod_unidad ";  
									$Consulta.=" where nro_solicitud = ".$Fila2["nro_solicitud"]." and recargo='".$Fila2["recargo"]."' and (".$TxtPregunta.") order by t3.cod_leyes ";
									$Respuesta3=mysqli_query($link, $Consulta);
									while($Fila3=mysqli_fetch_array($Respuesta3))
									{
										if ($Fila3["signo"]=="N")
										{
											$Array2[$Fila3["cod_leyes"]][1]="ND";
										}
										else
										{
											if ($Fila3["signo"]=="=")
											{
												$Valor=number_format($Fila3["valor"],3);
												$Array2[$Fila3["cod_leyes"]][2]=$Valor;
												$Array2[$Fila3["cod_leyes"]][3]=$Fila3["abreviatura"];
											}
											else
											{
												$Valor=number_format($Fila3["valor"],3);
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
									while(list($Clave,$Valor)=each($Array2))
									{
										echo "<td>";
										//musetro el valor en la posicion 1  
										echo $Valor[1]."&nbsp;".$Valor[2]."&nbsp".$Valor[3];
										echo "</td>";
									}
									if ((is_null($Fila2["recargo"])) || ($Fila2["recargo"]==''))
									{
										$Consulta="select fecha_hora from cal_web.estados_por_solicitud where rut_funcionario='".$Fila2["rut_funcionario"]."'";
										$Consulta=$Consulta." and nro_solicitud='".$Fila2["nro_solicitud"]."' and recargo='".$Fila2["recargo"]."' and cod_estado='4'";
										$RespuestaEstados=mysqli_query($link, $Consulta);
										$FilaEstado=mysqli_fetch_array($RespuestaEstados);
										$FechaEstado1=$FilaEstado["fecha_hora"];
										$Consulta="select fecha_hora from cal_web.estados_por_solicitud where rut_funcionario='".$Fila2["rut_funcionario"]."'";
										$Consulta=$Consulta." and nro_solicitud='".$Fila2["nro_solicitud"]."' and recargo='".$Fila2["recargo"]."' and cod_estado='6'";
										$RespuestaEstados=mysqli_query($link, $Consulta);
										$FilaEstado=mysqli_fetch_array($RespuestaEstados);
										$FechaEstado2=$FilaEstado["fecha_hora"];
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
						$ProS = substr($ProS,$j + 2);
						$j = 0;	 
					}	
			 }
			?>
        </table>
        
  <br>
  <table width="695" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr>
      <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
    	<?php	
		for ($j = 0;$j <= strlen($ProSAux); $j++)
		{
			if (substr($ProSAux,$j,2) == "//")
			{
				$ProSProAux = substr($ProSAux,0,$j);
				for ($x=0;$x<=strlen($ProSProAux);$x++)
				{
					if (substr($ProSProAux,$x,2) == "~~")
					{
						$ProductoAux = substr($ProSAux,0,$x);			
						$SubProductoAux = substr($ProSProAux,$x+2,strlen($ProSProAux));
						$Consulta ="select count(distinct t1.nro_solicitud,t1.recargo) as total_registro"; 
						$Consulta = $Consulta." from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t3";
						$Consulta = $Consulta." on (t1.nro_solicitud = t3.nro_solicitud and t3.candado='1' and t1.recargo = t3.recargo and t1.rut_funcionario = t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora) and (t1.estado_actual = 5 or t1.estado_actual = 6 or t1.estado_actual = 31 or t1.estado_actual = 32)  ";
						$Consulta = $Consulta." inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes ";
						$Consulta = $Consulta." where (t1.fecha_muestra between  '".$TxtFecha." 00:01' and '".$TxtFechaT." 23:59') and";
						$Consulta = $Consulta." (".$TxtPregunta.") and t1.cod_periodo = '".$TxtPeriodo."'";
						$Consulta = $Consulta." and (t1.cod_producto = '".$ProductoAux."' and t1.cod_subproducto = '".$SubProductoAux."')   ";						
						if ($Enabal=="S")
						{
							$Consulta = $Consulta." and t1.enabal = 'S'";						
						}
						if ($TxtTipo != '-1')
						{
							$Consulta = $Consulta." and t1.tipo='".$TxtTipo."'"; 
						}
						if ($TxtTipoAnalisis != '-1')
						{
							$Consulta = $Consulta." and t1.cod_analisis='".$TxtTipoAnalisis."'"; 
						}
						$Respuesta = mysqli_query($link, $Consulta);
						$Row = mysqli_fetch_array($Respuesta);
						$Total1=$Total1 + $Row["total_registro"];
					}	
				}
				$ProSAux = substr($ProSAux,$j + 2);
				$j = 0;	 
			}
		}			
		$Coincidencias = $Total1;
		$NumPaginas = ($Coincidencias / $LimitFin);
		$LimitFinAnt = $LimitIni;
		$StrPaginas = "";
		for ($i = 0; $i <= $NumPaginas; $i++)
		{
			$LimitIni = ($i * $LimitFin);
			if ($LimitIni == $LimitFinAnt)
			{
				$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
			}
			else
			{
				$Limite=($i * $LimitFin);
				$Reemplazo="$Limite";
				$Reemplazo = str_replace(" ","%20",$Reemplazo);
				
				
				$StrPaginas.=  "<a href=JavaScript:Recarga($Reemplazo,'$Enabal');>";				
				//$StrPaginas.=  "<a href=JavaScript:Recarga($FechaI,$FechaT,$Pregunta,$Periodo,$Producto,$SubProducto,$Limite);>";				
				$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
		
		?>
	
	
	</td>	
	</tr>
  </table>
  <br>
        
  <table width="695" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
            <td width="99"><div align="center"> </div></td>
            <td width="60">&nbsp;</td>
            <td width="245"><div align="center">
                <input name="BtnImprimir" type="button" id="BtnImprimir2" value="Imprimir" style="width:60" onClick="Imprimir('');">
              </div></td>
            <td width="86"><div align="center"> 
                <input name="BtnSalir" type="Button"  value="Salir" style="width:60" onClick="Salir();">
              </div></td>
            <td width="197">&nbsp;</td>
          </tr>
        </table>
 </form>
</body>
</html>
