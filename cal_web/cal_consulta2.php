<?php
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Sistema Control De Calidad</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<script language="JavaScript">
function Proceso()
{
	var f = document.frmPrincipal;

	f.BtnImprimir.style.visibility = 'hidden';
	window.print();
	
}	
</script>	

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="600" height="46" border="0" align="center">
    <tr> 
      <td align="center" colspan="3">
<p><img src="../principal/imagenes/letrasenami.gif" width="160" height="40"></p>
        </tr>
	<tr>
	  <td width="451">
	  Fundicion y Refineria Ventanas
	  </td>	
	  <td width="18">N&deg; </td>	
	  <td width="117">: 
	  <?php
			$Sol =$nro_solicitud;
			$Cert =$nro_certificado; 

			include("../principal/conectar_principal.php");
			mysqli_query($link, $Eliminar);
			$FechaHora = date("Y-m-d h:i");
			
			$Rut = $CookieRut;

			//Consulta que devuelve el mayor de los elementos de la tabla certificados
			$Consulta = "SELECT nro_certificado as numero,fecha_hora as fecha FROM cal_web.certificados WHERE nro_solicitud = $Sol";
			$rs2 = mysqli_query($link, $Consulta);
			//echo $Consulta;
			

			if($row2 = mysqli_fetch_array($rs2))
			{
			$FechaHora1 = date($row2["fecha"],("h:i d-m-Y"));


					$NroCert = $row2["numero"];
					$Correlativo = str_pad($NroCert,7,"0",STR_PAD_LEFT);
			}
			/*$FechaHora1 =date("h:i d-m-Y")*/
			echo '<strong>'.$Correlativo.'</strong>';
			
	  ?>
	  </td>	
	</tr>
	<tr>
	  <td>
	  Control Calidad
	  </td>	
	  <td>SA </td>	
	  <td> : 
	  <?php
		echo '<strong>'.$Sol.'</strong>';

	  ?>
	  </td>	
	</tr>
	</table>
    
  <p></p>
  <p></p>
	<table width="600" height="46" border="0" align="center">
	<tr>
	   <td colspan="3" align="center">
        <font style="Titulo1">&nbsp;</font>
        <p class="Titulo1"><strong><u>CERTIFICADO CONTROL CALIDAD</u></strong> 
        </p>
        </font>
	
	</tr>
	</table>
    
  <p></p>
  <p></p>
  <p></p>
	
  <table width="650" height="46" border="0" align="center">
    <?php

			$Consulta ="select distinct(id_muestra) as id_muestra from cal_web.solicitud_analisis where nro_solicitud = '".$Sol."'";
			$Respuesta1 = mysqli_query($link, $Consulta);
			if ($Fila1=mysqli_fetch_array($Respuesta1))
			{
				$Muestra = $Fila1["id_muestra"];
			}

			$Consulta ="select t2.cod_producto,t3.cod_subproducto,t2.descripcion as DesProducto,t3.descripcion as DesSubProducto from cal_web.solicitud_analisis t1 ";
			$Consulta = $Consulta." inner join proyecto_modernizacion.productos t2 ";
			$Consulta = $Consulta." on t1.cod_producto = t2.cod_producto ";
			$Consulta = $Consulta." inner join proyecto_modernizacion.subproducto t3 ";
			$Consulta = $Consulta." on t1.cod_subproducto = t3.cod_subproducto and t1.cod_producto = t3.cod_producto";
			$Consulta = $Consulta." where t1.nro_solicitud = '".$Sol."'"; 
			$Respuesta2=mysqli_query($link, $Consulta);
			if ($Fila2=mysqli_fetch_array($Respuesta2))			
			{
				$CodProducto = $Fila2["cod_producto"];
				$CodSubProducto = $Fila2["cod_subproducto"];
				$Producto = $Fila2["DesProducto"];
				$SubProducto= $Fila2["DesSubProducto"];
			}						
		?>
    <tr> 
      <td width="87">Tipo Producto</td>
      <td width="5">:</td>
      <td width="533"> 
        <?php
			echo $Producto;
		?>
      </td>
    </tr>
    <tr> 
      <td>Tipo SubProducto</td>
      <td>:</td>
      <td>
        <?php
			echo $SubProducto
		?>
      </td>
    </tr>
    <tr> 
      <td>Id Muestra</td>
      <td>:</td>
      <td>
        <?php
			echo $Muestra
		?>
      </td>
    </tr>
		<?php
			$Consulta = "select t1.id_muestra,t1.tipo_solicitud,t1.rut_proveedor,t1.agrupacion,t2.nombre_subclase,t3.nombre_subclase as tipo from cal_web.solicitud_analisis t1 ";
			$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on (t1.agrupacion = t2.cod_subclase and t2.cod_clase ='1004') ";
			$Consulta.=" left join proyecto_modernizacion.sub_clase t3 on (t1.tipo = t3.cod_subclase and t3.cod_clase ='1005') ";
			$Consulta.=" where nro_solicitud = '".$Sol."' ";						
			$Resp = mysqli_query($link, $Consulta);
			$Fil=mysqli_fetch_array($Resp);
			$Tipo=$Fil["tipo_solicitud"];

			if (($Tipo == 'A') && ($Fil["agrupacion"] == '1') && (!is_null($Fil["rut_proveedor"])))
			{
				$Consulta="select distinct(t1.r_prov_a),t1.d_prov_a,t3.nommin_a,t3.sierra_a,t1.d_clas_a from rec_web.recepciones t1 ";
				$Consulta.=" inner join cal_web.solicitud_analisis t2 on t1.lote_a = t2.id_muestra and t1.r_prov_a = t2.rut_proveedor ";
				$Consulta.=" inner join rec_web.minaprv t3 on t1.r_prov_a = t3.rutprv_a  and t1.c_faen_a = t3.codmin_a ";
				$Consulta.=" where t2.nro_solicitud = ".$Sol." and t2.id_muestra = ".$Fil["id_muestra"]." and t2.rut_proveedor = '".$Fil["rut_proveedor"]."' "; 
				$Respuesta1=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);

				echo"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
				echo"<tr> 
				  <td width='131'>Nombre Vendedor</td>
				  <td>:</td>
				  <td>"; 
						echo $Fila1["d_prov_a"];
				  echo"</td></tr>";
				
				echo"<tr> 
				  <td>Mina/Planta</td>
				  <td>:</td>
				  <td>";
						echo $Fila1["nommin_a"];
				  echo"</td></tr>";
				echo"<tr> 
				  <td>Sierra</td>
				  <td>:</td>
				  <td>";
						echo $Fila1["sierra_a"];
				  echo"</td></tr>";
				echo"<tr> 
				  <td>Clase</td>
				  <td>:</td>
				  <td>";
						echo $Fila1["d_clas_a"];
				  echo"</td></tr>";
				
			}

			//Carbon
			if($CodProducto == '53' && ($CodSubProducto == '4' || $CodSubProducto == '1' || $CodSubProducto == '5' || $CodSubProducto == '6'))
			{
				$Consulta = "SELECT observacion FROM cal_web.solicitud_analisis WHERE cod_producto = '$CodProducto'";
				$Consulta = $Consulta." AND cod_subproducto = '$CodSubProducto' AND nro_solicitud = $Sol";
				$Rs = mysqli_query($link, $Consulta);
				$Row = mysqli_fetch_array($Rs);
			    echo"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
				echo"<tr> 
				  <td width='131'>Observaci�n</td>
				  <td>:</td>
				  <td rowspan='5'>"; 
						echo nl2br($Row["observacion"]);
				echo"</td></tr>";
				echo"<tr> 
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    </tr>";				
				echo"<tr> 
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    </tr>";				
				echo"<tr> 
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    </tr>";				
			}
			//Catodos
			if($CodProducto == '18' && ($CodSubProducto == '6' || $CodSubProducto == '8' || $CodSubProducto == '9' || $CodSubProducto == '10' || $CodSubProducto == '12' || $CodSubProducto == '45'))
			{
				$Consulta = "SELECT observacion FROM cal_web.solicitud_analisis WHERE cod_producto = '$CodProducto'";
				$Consulta = $Consulta." AND cod_subproducto = '$CodSubProducto' AND nro_solicitud = $Sol";
				$Rs = mysqli_query($link, $Consulta);
				$Row = mysqli_fetch_array($Rs);
			    echo"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
				echo"<tr> 
				  <td width='131'>Observaci�n</td>
				  <td>:</td>
				  <td rowspan='5'>"; 
						echo nl2br($Row["observacion"]);
				echo"</td></tr>";
			}
			
		?>

  </table>
  <table width="500" height="46" border="0" align="center">
	<tr>
	  <td align="center">
	  	Resultado Analitico
	  </td>	  
	</tr>
  </table>
  <table width="400" height="46" border="0" align="center">
	<?php
			$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
			$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
			$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
			$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
			$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta =$Consulta." and t1.recargo = t2.recargo ";
			$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
			$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes ";
			$Consulta =$Consulta."  left join proyecto_modernizacion.unidades t4 ";
			$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
			/*$Consulta =$Consulta."  where (t3.tipo_leyes = '0' or t3.tipo_leyes = '3') and (t2.estado_actual = '6' or t2.estado_actual = '32') and t1.nro_solicitud = '".$Sol."' and (t1.recargo = '0' or t1.recargo = '') and t1.cod_leyes <> '01' order by secuencia ";*/
			$Consulta =$Consulta."  where  t1.nro_solicitud = '".$Sol."'  order by secuencia ";
			$Respuesta3 = mysqli_query($link, $Consulta);										
			while ($Fila3=mysqli_fetch_array($Respuesta3))
			{
						
						echo "<tr>";
						echo "<td>".$Fila3["abrevLey"]."</td>";
						echo "<td>".$Signo."</td>";
						$Valor = round($Fila3["valor"],3);
						echo "<td>".$Valor."</td>";
						echo "<td>".$Fila3["abrevUnidad"]."</td>";
						echo "</tr>";
			}											



	/*poly			if ($Tipo =='A')
				{
					//selenio y selenio comercial 
					if (($CodProducto=='31')&&($CodSubProducto=='1'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '40'  ";//SELENIO
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaSelenio=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -2 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '44'  ";//TELURO
						$Resp2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Resp2);
						$SecuenciaTelurio=$Fila2["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
					}

					//barros y barro cobre teluro
					if (($CodProducto=='27')&&($CodSubProducto=='1'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '44'  ";//TELURIO
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaTelurio=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -2 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
						
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '40'  ";//SELENIO
						$Resp2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Resp2);
						$SecuenciaSelenio=$Fila2["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
					}

					//paladio platino
					if ($CodProducto=='33')
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '37'  ";//ley platino
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaPlatino=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '37'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '37'";
						mysqli_query($link, $Actualizar);
					}	

					//PRODUCTO GRANALLA Y SUBPRODUCTO GRANALLA DE PLATA
					if (($CodProducto=='29')&&($CodSubProducto=='4'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '04'  ";//PLATA
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaPlata=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '04'";
						mysqli_query($link, $Actualizar);
					}

					//PRODUCTO ORO Y BARROS DE ORO
					if (($CodProducto=='34')&&($CodSubProducto=='2'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '05'  ";//ORO
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaOro=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '05'";
						mysqli_query($link, $Actualizar);
					}

					//COMIENZAN LA LEYES DEL RECARGO 0
					$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
					$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
					$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
					$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
					$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta =$Consulta." and t1.recargo = t2.recargo ";
					$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
					$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes ";
					$Consulta =$Consulta."  left join proyecto_modernizacion.unidades t4 ";
					$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
					$Consulta =$Consulta."  where (t3.tipo_leyes = '0' or t3.tipo_leyes = '3') and (t2.estado_actual = '6' or t2.estado_actual = '32') and t1.nro_solicitud = '".$Sol."' and (t1.recargo = '0' or t1.recargo = '') and t1.cod_leyes <> '01' order by secuencia ";
					//echo $Consulta."<br>";
		aqui		$Respuesta3 = mysqli_query($link, $Consulta);										
					while ($Fila3=mysqli_fetch_array($Respuesta3))
					{
						if ($Fila3["signo"] == 'N')
						{
							$Valor = 'ND';
							$Signo = "";
						}
						else
						{
							$Valor = round($Fila3["valor"],3);
							$Signo = $Fila3["signo"];
						}
						echo "<tr>";
						echo "<td>".$Fila3["abrevLey"]."</td>";
						echo "<td>".$Signo."</td>";
						if($Valor == 0)
							echo "<td>0.0</td>";
						else
						{
							if($CodProducto == 47 AND $CodSubProducto == 1 AND $Fila3["cod_leyes"] == 44)
								echo "<td>".number_format($Valor,2,'.','')."</td>";
							else	
								echo "<td>".$Valor."</td>";
						}
						echo "<td>".$Fila3["abrevUnidad"]."</td>";
						echo "</tr>";
					}											

					//IMPUREZAS PRODUCTOS MINEROS CON RECARGO
					echo "<tr>";										
					echo "<td colspan='6'>&nbsp;</td>";										
					echo "</tr>";
					$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
					$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
					$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
					$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
					$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta =$Consulta." and t1.recargo = t2.recargo ";
					$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
					$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes ";
					$Consulta =$Consulta."  left join proyecto_modernizacion.unidades t4 ";
					$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
					$Consulta =$Consulta."  where t3.tipo_leyes = '1' and (t2.estado_actual = '6' or t2.estado_actual = '32') and t1.nro_solicitud = '".$Sol."' and t1.recargo ='0' order by secuencia  ";
					$Respuesta4 = mysqli_query($link, $Consulta);
					while ($Fila4=mysqli_fetch_array($Respuesta4))											
					{
						if ($Fila4["signo"] == 'N')
						{
							$Valor = 'ND';
							$Signo = "";
						}
						else
						{
							$Valor = round($Fila4["valor"],3);
							$Signo = $Fila4["signo"];
						}
						echo "<tr>";
						echo "<td>".$Fila4["abrevLey"]."</td>";
						echo "<td>".$Signo."</td>";
						if($Valor == 0)
							echo "<td>0.0</td>";
						else
						{
							if($CodProducto == 47 AND $CodSubProducto == 1 AND $Fila4["cod_leyes"] == 44)
								echo "<td>".number_format($Valor,2,'.','')."</td>";
							else	
								echo "<td>".$Valor."</td>";
						}
						echo "<td>".$Fila4["abrevUnidad"]."</td>";
						echo "</tr>";
					}											

					/////fin de tabla para de productos mineros con recargo										
					//--------------------------Consulta que devuelve las leyes asociadas al Recargo R ---------------------------------------------------------
					$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
					$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
					$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
					$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
					$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta =$Consulta." and t1.recargo = t2.recargo ";
					$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
					$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes ";
					$Consulta =$Consulta."  left join proyecto_modernizacion.unidades t4 ";
					$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
					$Consulta =$Consulta."  where t3.tipo_leyes = '0' and (t2.estado_actual = '6' or t2.estado_actual = '32') and t1.nro_solicitud = '".$Sol."' and t1.recargo = 'R' and t1.cod_leyes <> '01' order by secuencia ";
					$Respuesta5 = mysqli_query($link, $Consulta);
					$Contador = 1;											 
					while ($Fila5=mysqli_fetch_array($Respuesta5))
					{	
						if ($Contador == 1)
						{
							echo "<tr><td>&nbsp;</td></tr>";										
							echo "<tr><td>RETALLA</td></tr>";
						}	
						$Contador++;																					
						if ($Fila5["signo"] == 'N')
						{
							$Valor = 'ND';
							$Signo = "";
						}
						else
						{
							$Valor = round($Fila5["valor"],3);
							$Signo = $Fila5["signo"];
						}
						echo "<tr>";
						echo "<td>".$Fila5["abrevLey"]."</td>";
						echo "<td>".$Signo."</td>";
						if($Valor == 0)
							echo "<td>0.0</td>";
						else
						{
							if($CodProducto == 47 AND $CodSubProducto == 1 AND $Fila5["cod_leyes"] == 44)
								echo "<td>".number_format($Valor,2,'.','')."</td>";
							else	
								echo "<td>".$Valor."</td>";
						}
						echo "<td>".$Fila5["abrevUnidad"]."</td>";
						echo "</tr>";
					}											

					//----------------Rescata el peso del tamiz y retalla-------- 		
					$Consulta = "select * from cal_web.solicitud_analisis where nro_solicitud = '".$Sol."' ";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($Fila["recargo"]=='R')
						{
							$TxtRetalla=$Fila["peso_muestra"]; 
							$TxtTamiz=$Fila["peso_retalla"];
							echo "<tr><td>&nbsp;</td></tr>";										
							echo "<tr><td>PESO RETALLA</td>";
							echo "<td>=</td>";
							echo "<td>".$TxtRetalla."</td></tr>";										
							echo "<tr><td>PESO TAMIZ</td>";										
							echo "<td>=</td>";
							echo "<td>".$TxtTamiz."</td></tr>";										
						}
					}
					//----------------Fin Para Rescatar el pedso del tamiz y retalla-------- 
					//---------------------fin recargo R------------------------------------
					//------------HUMEDADES DE LOS RECARGOS---------------------------------
					//ciclo que las rescata
					$Consulta =" select t1.recargo,t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
					$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
					$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
					$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
					$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta =$Consulta." and t1.recargo = t2.recargo ";
					$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
					$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes ";
					$Consulta =$Consulta."  left join proyecto_modernizacion.unidades t4 ";
					$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
					$Consulta =$Consulta."  where t3.tipo_leyes = '0' and (t2.estado_actual = '6' or t2.estado_actual = '32') and t1.nro_solicitud = '".$Sol."' and t1.cod_leyes = '01' order by recargo_ordenado,secuencia ";
					$Respuesta = mysqli_query($link, $Consulta);
					$Contador2 = 1;											 
					while ($Fila6 = mysqli_fetch_array($Respuesta))
					{
						if($Contador2 == 1)
						{
							echo "<tr><td>&nbsp;</td></tr>";										
							echo "<tr><td>HUMEDAD</td></tr>";										
						}
						$Contador2++;
						if (($Fila6["recargo"] != 0) || ($Fila6["recargo"]!='R'))
						{
							$Recar= $Fila6["recargo"];
							$Ley= $Fila6["abrevLey"];
							$ValorHumedad=$Fila6["valor"];
							$Unidad=$Fila6["abrevUnidad"];												
							echo "<tr>";
							echo "<td>Recargo: ".$Recar." ".$Ley."</td>";

							if ($Fila6["signo"] == 'N')
							{
								$Valor = 'ND';
								$Signo = "";
							}
							else
							{
								$Valor = round($Fila6["valor"],3);
								$Signo = $Fila6["signo"];
							}
							$Consulta="select t1.peso_neto as pesont_a from sipa_web.recepciones t1 ";
							$Consulta.=" inner join cal_web.solicitud_analisis t2 on t1.lote = t2.id_muestra and t1.rut_prv = t2.rut_proveedor ";
							$Consulta.=" where t2.nro_solicitud = ".$Sol." and t2.id_muestra = '".$Fil["id_muestra"]."' and t2.rut_proveedor = '".$Fil["rut_proveedor"]."' and t1.recargo = ".$Recar." ";
						//echo $Consulta."<br>";
							$Resp2=mysqli_query($link, $Consulta);
							$Fil2=mysqli_fetch_array($Resp2);
							echo "<td>".$Signo."</td>";
							if($Valor == 0)
								echo "<td>0.0</td>";
							else
							{
								if($CodProducto == 47 AND $CodSubProducto == 1 AND $Fila6["cod_leyes"] == 44)
									echo "<td>".number_format($Valor,2,'.','')."</td>";
								else	
									echo "<td>".$Valor."</td>";
							}
							echo "<td>".$Unidad."</td>";										
							echo "<td>Peso Humedo: </td>";										
							echo "<td>".number_format($Fil2["pesont_a"],0,"",".")."</td></tr>";										
							$Total = $Total + $Fil2["pesont_a"]; 
						}										
						
					}

					//SELENIO Y SELENIO COMERCIAÑ
					if (($CodProducto=='31')&&($CodSubProducto=='1'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaSelenio."' where cod_leyes = '40'";//SELENIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaTelurio."' where cod_leyes = '44'";//TELURO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
					}

					//BARROS Y BARRO COBRE TELURIO
					if (($CodProducto=='27')&&($CodSubProducto=='1'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaSelenio."' where cod_leyes = '40'";//SELENIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '40'";//SELENIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaTelurio."' where cod_leyes = '44'";//TELURIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '44'";//TELURIO
						mysqli_query($link, $Actualizar);
					}

					//PLATINO-PALADIO 
					if ($CodProducto=='33')
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaPlatino."' where cod_leyes = '37'";//PLATINO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '37'";
						mysqli_query($link, $Actualizar);
					}	

					//GRANALLA Y GRANALLA DE PLATA 
					if (($CodProducto=='29')&&($CodSubProducto=='4'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia ='".$SecuenciaPlata."' where cod_leyes = '04'";
						mysqli_query($link, $Actualizar);
					}										

					//PRODUCTO ORO Y BARROS DE ORO
					if (($CodProducto=='34')&&($CodSubProducto=='2'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaOro."' where cod_leyes = '05'";
						mysqli_query($link, $Actualizar);
					}						

					if ((!is_null($Recar)) && ($Recar != '0') && ($Recar !='R'))
					{
						
						echo "<tr><td colspan='4'>&nbsp;</td>";
						echo "<td>Total : </td>";
						echo "<td>".number_format($Total,0,"",".")."</td></tr>";	
					}
					//-------------Fin Humedades--------------------------/	
				//--------------------------Fin If de Solicitudes con recargo------------------------------------								
				}
				if (strtoupper($Tipo) == "R")				
				{
					//selenio y selenio comercial 
					if (($CodProducto=='31')&&($CodSubProducto=='1'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '40'  ";//SELENIO
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaSelenio=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -2 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '44'  ";//TELURO
						$Resp2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Resp2);
						$SecuenciaTelurio=$Fila2["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
					}

					//barros y barro cobre teluro
					if (($CodProducto=='27')&&($CodSubProducto=='1'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '44'  ";//TELURIO
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaTelurio=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -2 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
						
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '40'  ";//SELENIO
						$Resp2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Resp2);
						$SecuenciaSelenio=$Fila2["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
					}

					//paladio platino
					if ($CodProducto=='33')
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '37'  ";//ley platino
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaPlatino=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '37'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 0 where cod_leyes = '37'";
						mysqli_query($link, $Actualizar);
					}	

					//PRODUCTO GRANALLA Y SUBPRODUCTO GRANALLA DE PLATA
					if (($CodProducto=='29')&&($CodSubProducto=='4'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '04'  ";//PLATA
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaPlata=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '04'";
						mysqli_query($link, $Actualizar);
					}

					//PRODUCTO ORO Y BARROS DE ORO
					if (($CodProducto=='34')&&($CodSubProducto=='2'))
					{
						$Consulta="select secuencia,tipo_leyes from proyecto_modernizacion.leyes where cod_leyes = '05'  ";//ORO
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						$SecuenciaOro=$Fila1["secuencia"];
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = -1 where cod_leyes = '05'";
						mysqli_query($link, $Actualizar);
					}

					//Consulta que devuelve las leyes asociadas a cualquier producto excepto catodoss y productos mineros con recargos  
					$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad, ";
					$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
					$Consulta =$Consulta." t4.abreviatura as abrevUnidad,t1.signo ";
					$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
					$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta =$Consulta." and t1.recargo = t2.recargo ";
					$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
					$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes ";
					$Consulta =$Consulta."  left join proyecto_modernizacion.unidades t4 ";
					$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
					$Consulta =$Consulta."  where (t3.tipo_leyes = '0' or t3.tipo_leyes = '3')  and (t2.estado_actual = '6' or t2.estado_actual = '32') and t1.nro_solicitud = '".$Sol."' order by secuencia ";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila5=mysqli_fetch_array($Respuesta))
					{											
						if ($Fila5["signo"] == 'N')
						{
							$Valor = 'ND';
							$Signo = "";
						}
						else
						{
							$Valor = round($Fila5["valor"],3);
							$Signo = $Fila5["signo"];
						}
						echo "<tr>";
						echo "<td>".$Fila5["abrevLey"]."</td>";
						echo "<td>".$Signo."</td>";
						if($Valor == 0)
							echo "<td>0.0</td>";
						else
						{
							if($CodProducto == 47 AND $CodSubProducto == 1 AND $Fila5["cod_leyes"] == 44)
								echo "<td>".number_format($Valor,2,'.','')."</td>";
							else	
								echo "<td>".$Valor."</td>";
						}
						echo "<td>".$Fila5["abrevUnidad"]."</td>";
						echo "</tr>";
					}											
					echo "<tr>";										
					echo "<td colspan='4'>&nbsp;</td>";										
					echo "</tr>";

					//Consulta que devuelve las impurezas asociadas a cualquier producto excepto catodoss y productos mineros con recargos  
					$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
					$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
					$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
					$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
					$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta =$Consulta." and t1.recargo = t2.recargo ";
					$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
					$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes ";
					$Consulta =$Consulta."  left join proyecto_modernizacion.unidades t4 ";
					$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
					$Consulta =$Consulta."  where t3.tipo_leyes = '1' and (t2.estado_actual = '6' or t2.estado_actual = '32') and t1.nro_solicitud = '".$Sol."' order by secuencia ";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila6=mysqli_fetch_array($Respuesta))
					{													
						if ($Fila6["signo"] == 'N')
						{
							$Valor = 'ND';
							$Signo = "";
						}
						else
						{
							$Valor = round($Fila6["valor"],3);
							$Signo = $Fila6["signo"];
						}

						echo "<tr>";
						echo "<td>".$Fila6["abrevLey"]."</td>";
						echo "<td>".$Signo."</td>";
						if($Valor == 0)
							echo "<td>0.0</td>";
						else
						{
							if($CodProducto == 47 AND $CodSubProducto == 1 AND $Fila6["cod_leyes"] == 44)
								echo "<td>".number_format($Valor,2,'.','')."</td>";
							else	
								echo "<td>".$Valor."</td>";
						}
						echo "<td>".$Fila6["abrevUnidad"]."</td>";
						echo "</tr>";
					}											

					//SELENIO Y SELENIO COMERCIAL
					if (($CodProducto=='31')&&($CodSubProducto=='1'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaSelenio."' where cod_leyes = '40'";//SELENIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '40'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaTelurio."' where cod_leyes = '44'";//TELURO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '44'";
						mysqli_query($link, $Actualizar);
					}

					//BARROS Y BARRO COBRE TELURIO
					if (($CodProducto=='27')&&($CodSubProducto=='1'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaSelenio."' where cod_leyes = '40'";//SELENIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '40'";//SELENIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaTelurio."' where cod_leyes = '44'";//TELURIO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '44'";//TELURIO
						mysqli_query($link, $Actualizar);
					}

					//PLATINO-PALADIO 
					if ($CodProducto=='33')
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaPlatino."' where cod_leyes = '37'";//PLATINO
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE proyecto_modernizacion.leyes set tipo_leyes = 1 where cod_leyes = '37'";
						mysqli_query($link, $Actualizar);
					}	

					//GRANALLA Y GRANALLA DE PLATA 
					if (($CodProducto=='29')&&($CodSubProducto=='4'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia ='".$SecuenciaPlata."' where cod_leyes = '04'";
						mysqli_query($link, $Actualizar);
					}										

					//PRODUCTO ORO Y BARROS DE ORO
					if (($CodProducto=='34')&&($CodSubProducto=='2'))
					{
						$Actualizar="UPDATE proyecto_modernizacion.leyes set secuencia = '".$SecuenciaOro."' where cod_leyes = '05'";
						mysqli_query($link, $Actualizar);
					}
				}//fin if si no es p minero o otro producto con recargo
			

			$insertar ="insert into cal_web.certificados (rut_generador,nro_solicitud,fecha_hora,nro_certificado)";
			$insertar.="values ('".$Rut."','".$Sol."','".$FechaHora."','".$NroCert."')";
			mysqli_query($link, $insertar);								
			$SolRecargo = substr($SolRecargo,$j + 2);
poly*/
			echo '</tr></table>';		
			echo '<p>&nbsp;</p>';
			echo '<p>&nbsp;</p>';
			echo '<p>&nbsp;</p>';
			echo '<p>&nbsp;</p>';
			echo '<p>&nbsp;</p>';
			echo '<p>&nbsp;</p>';

			
			$Consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '$CookieRut'";
			$rs = mysqli_query($link, $Consulta);
			if($row = mysqli_fetch_array($rs))
			{
				$sigla = '/'.substr($row[nombres],0,1).substr($row["apellido_paterno"],0,1).substr($row["apellido_materno"],0,1);
			}
			/*echo '<table width="400" height="46" border="0" align="center">';
			echo '<tr>';
			echo '<td>&nbsp;</td>';
			echo '<td align="right"><strong>JEFE CONTROL CALIDAD</strong></td>';
			echo '</tr></table>';
			echo '<p>&nbsp;</p>';
			echo '<table width="600" height="46" border="0" align="center">';
			echo '<tr>';
			echo '<td>'.$sigla.'</td></tr>';
			echo '<tr><td align="left">'.$FechaHora1.'</td>';
			echo '</tr></table>';*/
	
?>		

			
  <div align="center" style="position:absolute; top: 830px; left: 230px;"> 
    <table width="400" height="46" border="0" align="center">
      <tr> 
        <td>&nbsp;</td>
        <td align="right"><strong>JEFE CONTROL CALIDAD</strong></td>
      </tr>
    </table>
  </div>  	  
  <div align="center" style="position:absolute; top: 840px; left: 130px;"> 
	<table width="400" height="46" border="0" align="center">
	 <tr>
	   <td colspan="2"><?php echo $sigla ?></td>
	 </tr>
	 <tr>
	   <td align="left" colspan="2"><?php echo $FechaHora1 ?></td>
	 </tr>
	 <tr>
	   <td width="210">&nbsp;</td>
	   <td align="left"><input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso();"> </td>
	 </tr>
	</table>
  </div>

</form>	
</body>
</html>