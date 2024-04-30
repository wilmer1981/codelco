<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 2;
?>

<html>
<head>
<title>Programa de Renovacion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar()
{
	var  f=document.frmPrincipal;
	var fecha=f.ano1.value+"-"+f.mes1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	
	



	document.location = "../ref_web/Renovacion_grupos5.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1;
}
function ValorCheckBox(f)
{
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			return f.checkbox[i].value;
	}
}
/***********************/
function SeleccionarTodos(f)
{
	try{	
		if (f.checkbox[0].checked == true)
			valor = true
		else valor = false;
				
		for(i=1; i<f.checkbox.length; i++)	
			f.checkbox[i].checked = valor;
	}catch(e){
	}
}
/************************/
function ValoresChequeados(f)
{
	valores = "";
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			valores = valores + f.checkbox[i].value + '-';
	}
	return valores;
}
/************************/
function CantidadChecheado(f)
{
	cont = 0;
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			cont++;
	}	
	return cont;
}
/************************/
function Proceso(f,opc)
{
	linea = "opcion=" + opc;
	if (opc == 'M')
	{
		cantidad = CantidadChecheado(f);
		if (cantidad == 1)
		{
			linea = linea + "&txtgrupo=" + ValorCheckBox(f);
		}
		else if (cantidad == 0)
		{
			alert("Debe Selecionar Una Casilla para Modificar");
			return;
		}
		else
		{
			alert("Hay ms de Una Casilla Marcada");
			return;
		}
	}	
		
	window.open("ref_ing_ren_prog_prod.php?Proceso=M&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value + "","","top=70,left=100,width=400,height=400,scrollbars=yes,resizable = yes");
}
/*****************/
function Eliminar(f)
{
	var valores = ValoresChequeados(f);
	valores = valores.substr(0,valores.length-1);

	
	if (valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "sec_ing_grupo_electrolitico_proceso01.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}

function Imprimir(f)
{
	window.print();
}

/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10";
}

</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
  
  <table width="770" height="500" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">
<div style="position:absolute; left: 12px; top: 57px; width: 730px; height: 30px;" id="div1"> 
                  <table width="750" border="0" cellpadding="3" class="TablaInterior">
            <tr>
              <td width="80">Informe del:</td>
              <td colspan="2"> 
                <select name="mes1" size="1" id="mes1">
		       	<?php
				$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for($i=1;$i<13;$i++)
					{
						if (isset($mes1))
							{
								if ($mes1 == $i)
									echo "<option selected value='".$i."'>".ucwords(strtolower($meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($meses[$i - 1]))."</option>\n";
							}
							else
							{
								if ($i == date("n"))
									echo "<option selected value='".$i."'>".ucwords(strtolower($meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($meses[$i - 1]))."</option>\n";
							}
					}
				?>
                </select> <select name="ano1" size="1" id="select4">
        		<?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($ano1))
							{
								if ($ano1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("Y"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
					}
				?>
                </select>&nbsp;&nbsp;<input name="buscar" type="button" value="buscar" onClick="Buscar()" ></td>
            </tr>
          </table>
</div>

        <div style="position:absolute; left: 10px; top: 93px; width: 730px; height: 30px;" id="div1"> 
          <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="75" height="20" align="left"><input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
                Todo</td>
              <td width="74" align="center">Antiguos</td>
			  <td width="54" align="center">Fecha</td>
              <td width="82" align="center">TA</td>
              <td width="72" align="center">TB</td>
              <td width="180" align="center">Desc. Normal.</td>
              <td width="85" align="center">Desc. Parcial</td>
              <td width="105" align="center">E.W.</td>
          </tr>
          </table>
 
 </div>
 
		
        <div style="position:absolute; left: 10px; top: 126px; width: 751px; height: 371px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php	
	if ($opcion=="H")
	  {
			if ($mes1<=9)
				{$mes1=strval($mes1);
				  $mes1='0'.$mes1;
				  $fecha=$ano1.'-'.$mes1;
                  $fecha2=$fecha;}
			$consulta_fecha="SELECT distinct fecha_renovacion,dia_renovacion from sec_web.renovacion_prog_prod where dia_renovacion between '1' and '31' and fecha_renovacion like '".$fecha."%' and cod_grupo<>''";
			$rss = mysqli_query($link, $consulta_fecha);
            $datos='F';
			while ($rows = mysqli_fetch_array($rss))
		  
				{
                  if ($rows[fecha_renovacion]<>"")
					if (strlen($rows["dia_renovacion"])==1)
					$rows["dia_renovacion"]='0'.$rows["dia_renovacion"];
					$fecha=	substr($rows[fecha_renovacion],0,8).$rows["dia_renovacion"];

					echo '<tr>';
					echo '<td width="55" height="25"><input type="checkbox" name="checkbox" value="'.$row[fecha_renovacion].'"></td>';
                    echo '<td width="70" align="center"> <img src ="../principal/imagenes/ico_ok.gif" ></td>';
					echo '<td width="70" align="center">'.$fecha.'</td>';
                   $consulta="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta=$consulta."where dia_renovacion=".$rows["dia_renovacion"]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='A' order by dia_renovacion,cod_grupo";
                    $respuesta = mysqli_query($link, $consulta);
                    $i=0;
                    while($row = mysqli_fetch_array($respuesta))
                       {$arreglo[$i]=$row["cod_grupo"];
                        $i++;}
						
						
                    echo '<td width="70" align="center">'.$arreglo[0].'-'.$arreglo[1].'-'.$arreglo[2].'&nbsp;</td>';
                    $consulta2="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta2=$consulta2."where dia_renovacion=".$rows["dia_renovacion"]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='B' order by dia_renovacion,cod_grupo";
                    $respuesta2 = mysqli_query($link, $consulta2);
                    $i=0;
                    while($row2 = mysqli_fetch_array($respuesta2))
                       {$arreglo2[$i]=$row2["cod_grupo"];
                        $i++;}
						
						
                    echo '<td width="70" align="center">'.$arreglo2[0].'-'.$arreglo2[1].'-'.$arreglo2[2].'&nbsp;</td>';
                    $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta3=$consulta3."where dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%' and cod_concepto='D' order by dia_renovacion,cod_grupo";
                    $respuesta3 = mysqli_query($link, $consulta3);
                    $i=0;
                    while($row3 = mysqli_fetch_array($respuesta3))
                       {
                           if  ($row3["cod_grupo"]=="")
                             {$arreglo3[$i]=" ";}
                            else $arreglo3[$i]=$row3["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center">'.$arreglo3[0].' '.$arreglo3[1].' '.$arreglo3[2].'&nbsp;</td>';
                    $consulta4="select distinct dia_renovacion,desc_parcial from sec_web.renovacion_prog_prod ";
                    $consulta4=$consulta4."where fila_renovacion='1' and dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta = mysqli_query($link, $consulta4);
                    $rowe = mysqli_fetch_array($respuesta);
                    if ($rowe[desc_parcial]=="")
                       {$rowe[desc_parcial]='-';}
				    echo '<td width="70" align="center">'.$rowe[desc_parcial].'&nbsp;</td>';
                    $consulta5="select distinct dia_renovacion,electro_win from sec_web.renovacion_prog_prod ";
                    $consulta5=$consulta5."where fila_renovacion='1' and dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta5 = mysqli_query($link, $consulta5);
                    $rowe = mysqli_fetch_array($respuesta5);
                    if ($rowe[electro_win]=="")
                       {$rowe[electro_win]='-';}
                    echo '<td width="70" align="center">'.$rowe[electro_win].'&nbsp;</td>';
                   	echo '</tr>';
                    $datos='V';
				}
            if ($datos=='F')
               {$listo='N';
			    $listo1='N';
				$listo2='N';
				$listo3='N';
				$listo4='N';
			    /*busca ultimo mes con datos ingresados*/
                $consulta="select max(fecha_renovacion)as fecha ";
                $consulta.="from sec_web.renovacion_prog_prod where cod_grupo <>''";
				/*echo $consulta;*/
                $respuesta = mysqli_query($link, $consulta);
                $rowe = mysqli_fetch_array($respuesta);
                $fecha=	substr($rowe["fecha"],0,7);
                /*busca ultimo dia del mes que tiene datos*/
                $consulta_dia=" select max(dia_renovacion) as dia ";
                $consulta_dia.="from sec_web.renovacion_prog_prod ";
                $consulta_dia.="where fecha_renovacion like '".$fecha."%'  and cod_grupo<>''";
				/*echo $consulta_dia;*/
                $respuesta_dia = mysqli_query($link, $consulta_dia);
                $row_dia = mysqli_fetch_array($respuesta_dia);
                $row_dia[dia]=($row_dia[dia]-'7');
                
                $fecha_bus=$fecha.'-'.$row_dia[dia];
                $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                $cant_dias=array('31','28','31','30','31','30','31','31','30','31','30','31');
                $indice=(intval($mes1)-1);
                $c=$cant_dias[$indice];
                $fecha_renovacion=$ano1.'-'.$mes1;
                $j=1;
                $dia_mes_anterior=$row_dia[dia];/*trae el inicio de la fecha busqueda del mes anterior */
                $dia_mes_ant_str=strval($dia_mes_anterior);

                while ($j<=$c)
                  {
                   $dia_mes_ant_str=strval($dia_mes_anterior);
                   echo '<tr>';
                   echo '<td width="55" height="25" align="center"><input type="checkbox" name="checkbox" value="'.$row[fecha_renovacion].'"></td>';
                   echo '<td width="70" align="center"> <img src ="../principal/imagenes/ico_x.gif" ></td>';
                   $dia=strval($j);
                   if (strlen($dia)==1)
                       {$dia='0'.$dia;}
                   $fecha_renovacion=$ano1.'-'.$mes1.'-'.$dia;
                   echo '<td width="70" align="center">'.$fecha_renovacion.'&nbsp;</td>';
                   $fecha_mes_anterior=$fecha.'-'.$dia_mes_ant_str;
                   $consulta_nom_dia="select DAYNAME('".$fecha_renovacion."')as dia";
          		   $respuesta_nom_dia = mysqli_query($link, $consulta_nom_dia);
                   /*echo $consulta_nom_dia;*/
                   $row_nom_dia = mysqli_fetch_array($respuesta_nom_dia);
                   if ($row_nom_dia[dia]<>'Sunday')
                       {
                         $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
           				 $consulta3=$consulta3."where dia_renovacion=$dia_mes_anterior and fecha_renovacion like '".$fecha."%' and cod_concepto='A' order by dia_renovacion,cod_grupo";
						/* echo $consulta3;*/
                  		 $respuesta3 = mysqli_query($link, $consulta3);
                         $b=0;
           				 while($row3 = mysqli_fetch_array($respuesta3))
           					{
               				  if  ($row3["cod_grupo"]=="")
                					{$arregloa[$b]=" ";}
                   			  else {$arregloa[$b]=$row3["cod_grupo"];
                                   $b++;}
                            }
						 $listo3='N';	
						 if ($listo3<>'S')
                             {						 
								 $fecha_x=substr($fecha_renovacion,0,7);
								  $dia_x=substr($fecha_renovacion,8,2);
								  $fila_x=1;
								  $insertar = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
								  $insertar = $insertar." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arregloa[0].",'hola','hola')";		
								  /*echo $insertar."<br>";*/
								  mysqli_query($link, $insertar);
								  $insertar2 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
								  $insertar2 = $insertar2." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arregloa[1].",'hola','hola')";		
								  /*echo $insertar2."<br>";*/
								  mysqli_query($link, $insertar2);
								  $insertar3 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
								  $insertar3 = $insertar3." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arregloa[2].",'hola','hola')";		
								  /*echo $insertar3."<br>";*/
								 mysqli_query($link, $insertar3);
								 $listo3='S';
	                         }					
						
						
							
                         echo '<td width="70" align="center">'.$arregloa[0].' '.$arregloa[1].' '.$arregloa[2].'&nbsp;</td>';
                         $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
           				 $consulta3=$consulta3."where dia_renovacion=$dia_mes_anterior and fecha_renovacion like '".$fecha."%' and cod_concepto='B' order by dia_renovacion,cod_grupo";
                  		 $respuesta3 = mysqli_query($link, $consulta3);
                         $dia_mes_anterior=$dia_mes_anterior+1;
                         $b=0;
           				 while($row4 = mysqli_fetch_array($respuesta3))
           					{
               				  if  ($row4["cod_grupo"]=="")
                					{$arreglob[$b]=" ";}
                   			  else {$arreglob[$b]=$row4["cod_grupo"];
                                   $b++;}
                            }
						 $listo4='N';	
						 if ($listo4<>'S')
						    { 	
							  $fecha_x=substr($fecha_renovacion,0,7);
							  $dia_x=substr($fecha_renovacion,8,2);
							  $fila_x=1;
							 
							  $insertar4 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
							  $insertar4 = $insertar4." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','B',".$arreglob[0].",'hola','hola')";		
							  /*echo $insertar4."<br>";*/
							  mysqli_query($link, $insertar4);
							  $insertar5 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
							  $insertar5 = $insertar5." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','B',".$arreglob[1].",'hola','hola')";		
							  /*echo $insertar5."<br>";*/
							  mysqli_query($link, $insertar5);
							  $insertar6 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
							  $insertar6 = $insertar6." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','B',".$arreglob[2].",'hola','hola')";		
							  /*echo $insertar6."<br>";*/
							  mysqli_query($link, $insertar6);
							  $listo4='S';
						     }	
                         echo '<td width="70" align="center">'.$arreglob[0].' '.$arreglob[1].' '.$arreglob[2].'&nbsp;</td>';

                         }
                      if($row_nom_dia[dia]=='Sunday')
                             {
                               $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
           				       $consulta3=$consulta3."where dia_renovacion=$dia_mes_anterior and fecha_renovacion like '".$fecha."%' and cod_concepto='A' order by dia_renovacion,cod_grupo";
                               $respuesta3 = mysqli_query($link, $consulta3);
                               /*$dia_mes_anterior=$dia_mes_anterior+1;*/
                               $b=0;
           				       while($row3 = mysqli_fetch_array($respuesta3))
           					      {
               				        if  ($row3["cod_grupo"]=="")
                					    {$arreglo3[$b]=" ";}
                   			        else {$arreglo3[$b]=$row3["cod_grupo"];
                                          $b++;}

                                  }
								 $listo='N';
								 if ($listo<>'S')
								     { 
									   	 $fecha_x=substr($fecha_renovacion,0,7);
						                 $dia_x=substr($fecha_renovacion,8,2);
						                 $fila_x=1;
										 $insertar7 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
			/*inserta para el domingo*/	 $insertar7 = $insertar7." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arreglo3[0].",'hola','hola')";		
										 /*echo $insertar7."<br>";*/
										mysqli_query($link, $insertar7);
										$insertar8 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
										 $insertar8 = $insertar8." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arreglo3[1].",'hola','hola')";		
										/* echo $insertar8."<br>";*/
										mysqli_query($link, $insertar8);
										$insertar9 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
										 $insertar9 = $insertar9." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arreglo3[2].",'hola','hola')";		
										 /*echo $insertar9."<br>";*/
										mysqli_query($link, $insertar9);
										 $listo='S';
	                                 }							  
                                echo '<td width="70" align="center">'.$arreglo3[0].' '.$arreglo3[1].' '.$arreglo3[2].'&nbsp;</td>';
							    echo '<td width="70" align="center">&nbsp;</td>';
                                echo '<td width="70" align="center">&nbsp;</td>';
                                echo '<td width="70" align="left">&nbsp;</td>';
                                echo '<td width="70" align="left">&nbsp;</td>';
				                echo '<td width="70" align="center">&nbsp;</td>';
				                echo '<td width="70" align="center">&nbsp;</td>';
				                echo '</tr>';

                      /*****************************************************************/

                                $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
           			            $consulta3=$consulta3."where dia_renovacion=$dia_mes_anterior and fecha_renovacion like '".$fecha."%' and cod_concepto='B' order by dia_renovacion,cod_grupo";
                                /*echo $consulta3."<br>";*/
                                $respuesta3 = mysqli_query($link, $consulta3);
                                $dia_mes_anterior=$dia_mes_anterior+1;
                                $b=0;
           			            while($row3 = mysqli_fetch_array($respuesta3))
           					       {
               				        if  ($row3["cod_grupo"]=="")
                					    {$arreglo_sab_tb[$b]=" ";}
                   			        else {$arreglo_sab_tb[$b]=$row3["cod_grupo"];
                                         $b++;}
                                   }
                                $consulta4="select cod_grupo from sec_web.renovacion_prog_prod ";
           			            $consulta4=$consulta4."where dia_renovacion=$dia_mes_anterior and fecha_renovacion like '".$fecha."%' and cod_concepto='A' order by dia_renovacion,cod_grupo";
                                $respuesta4 = mysqli_query($link, $consulta4);

                                $dia_mes_anterior=$dia_mes_anterior+1;
                                /* $j=$dia_mes_anterior+1;*/
                                $b=0;
           			            while($row3 = mysqli_fetch_array($respuesta4))
           					       {
               				        if  ($row3["cod_grupo"]=="")
                					    {$arreglo_dom_ta[$b]=" ";}
                   			        else {$arreglo_dom_ta[$b]=$row3["cod_grupo"];
                                         $b++;}
                                   }

                                 $i=0;
                                 while ($i<=2)
                                     {

                                       $Consulta =  "select max(fecha) as fecha,cod_grupo,cod_circuito,calle_puente_grua,cubas_lavado ";
                                       $Consulta = $Consulta." from sec_web.grupo_electrolitico2 ";
                                       $Consulta = $Consulta." where fecha <= '".$fecha.'-'.'01'."'and cod_grupo= '".$arreglo_dom_ta[$i]."' group by cod_grupo";
                                       $respuesta= mysqli_query($link, $Consulta);
           			                   $row1 = mysqli_fetch_array($respuesta);
                                       if (($row1["cod_grupo"]=='09') or ($row1["cod_grupo"]=='10') or ($row1["cod_grupo"]=='15') or ($row1["cod_grupo"]=='16'))
                                          {
                                           $arr_aux_ta[$i]=$row1["cod_grupo"];
                                           $Consulta2 =  "select max(fecha) as fecha,cod_grupo,cod_circuito,calle_puente_grua,cubas_lavado ";
                                           $Consulta2 = $Consulta2." from sec_web.grupo_electrolitico2 ";
                                           $Consulta2 = $Consulta2." where fecha <= '".$fecha.'-'.'01'."'and cod_grupo= '".$arreglo_sab_tb[$i]."' group by cod_grupo";
                                           $respuesta2= mysqli_query($link, $Consulta2);
 			                               $row2 = mysqli_fetch_array($respuesta2);
                                           $arr_aux_tb[$i]=$row2["cod_grupo"];

                                          }
                                       else
                                           {
                                             $Consulta2 =  "select max(fecha) as fecha,cod_grupo,cod_circuito,calle_puente_grua,cubas_lavado ";
                                             $Consulta2 = $Consulta2." from sec_web.grupo_electrolitico2 ";
                                             $Consulta2 = $Consulta2." where fecha <= '".$fecha.'-'.'01'."'and cod_grupo= '".$arreglo_sab_tb[$i]."' group by cod_grupo";
                                             $respuesta2= mysqli_query($link, $Consulta2);
 			                                 $row2 = mysqli_fetch_array($respuesta2);
                                             if ($i==0)
                                               {
                                                 $arr_aux_ta=$row2["cod_grupo"];
                                                 $arr_aux_tb=$row1["cod_grupo"];
                                               }
                                              else {
                                                    $Consulta_grupo_anterior="select max(fecha) as fecha,cod_grupo,cod_circuito,calle_puente_grua,cubas_lavado ";
                                                    $Consulta_grupo_anterior=$Consulta_grupo_anterior."from sec_web.grupo_electrolitico2 ";
                                                    $Consulta_grupo_anterior=$Consulta_grupo_anterior."where fecha<='".$fecha.'-'.'01'."' and cod_grupo='".$arr_aux_ta[$i-1]."' group by cod_grupo";
                                                    $respuesta_grupo_anterior= mysqli_query($link, $Consulta_grupo_anterior);
        			                                $row_grupo_anterior = mysqli_fetch_array($respuesta_grupo_anterior);
                                                    $Consulta_grupo="select max(fecha) as fecha,cod_grupo,cod_circuito,calle_puente_grua,cubas_lavado ";
                                                    $Consulta_grupo=$Consulta_grupo."from sec_web.grupo_electrolitico2 ";
                                                    $Consulta_grupo=$Consulta_grupo."where fecha<='".$fecha.'-'.'01'."' and cod_grupo='".$arreglo_sab_tb[$i]."' group by cod_grupo";
                                                    $respuesta_grupo= mysqli_query($link, $Consulta_grupo);
        			                                $row_grupo = mysqli_fetch_array($respuesta_grupo);
													if ($row_grupo_anterior[cod_circuito]==$row_grupo[cod_circuito])
													    {  $arr_aux_tb[$i]=$row_grupo["cod_grupo"];
                                                            $arr_aux_ta[$i]=$arreglo_dom_ta[$i];}
													 else if($row_grupo_anterior[cubas_lavado]==$row_grupo[cubas_lavado])
                                                            { $arr_aux_tb[$i]=$row_grupo["cod_grupo"];
                                                              $arr_aux_ta[$i]=$arreglo_dom_ta[$i]; }		
													      else if ($row_grupo_anterior[calle_puente_grua]==$row_grupo[calle_puente_grua])
                                                                    {  $arr_aux_tb[$i]=$row_grupo["cod_grupo"];
                                                                       $arr_aux_ta[$i]=$arreglo_dom_ta[$i]; }
															    else { $arr_aux_tb[$i]=$arreglo_dom_ta[$i];
                                                                       $arr_aux_ta[$i]=$row_grupo["cod_grupo"]; }
																	   
																	  
													
                                                   }

                                           }

                                      $i=$i+1;
                                     }

     					   echo '<td width="55" height="25"><input type="checkbox" name="checkbox" value="'.$row[fecha_renovacion].'"></td>';
                           echo '<td width="70" align="center"> <img src ="../principal/imagenes/ico_x.gif" ></td>';
						   if ($dia < 10)
						     {$dia='0'.(strval($dia)+1);}
						   $fecha_renovacion=$ano1.'-'.$mes1.'-'.$dia;
						   $listo1='N';
						   if ($listo1<>'S')
								     { 
									   	 $fecha_x=substr($fecha_renovacion,0,7);
						                 $dia_x=substr($fecha_renovacion,8,2);
						                 $fila_x=1;
										 $insertar10 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
			/*inserta para el domingo*/	 $insertar10 = $insertar10." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arr_aux_ta[0].",'hola','hola')";		
										 /*echo $insertar10."<br>";*/
										mysqli_query($link, $insertar10);
										$insertar11 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
										 $insertar11 = $insertar11." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arr_aux_ta[1].",'hola','hola')";		
										/*echo $insertar11."<br>";*/
										mysqli_query($link, $insertar11);
										$insertar12 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
										$insertar12 = $insertar12." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','A',".$arr_aux_ta[2].",'hola','hola')";		
										/*echo $insertar12."<br>";*/
										mysqli_query($link, $insertar12);
										$listo1='S';
	                                 }
							$listo2='N';		 
							if ($listo2<>'S')
								     { 
									   	 $fecha_x=substr($fecha_renovacion,0,7);
						                 $dia_x=substr($fecha_renovacion,8,2);
						                 $fila_x=1;
										 $insertar13 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
			/*inserta para el domingo*/	 $insertar13 = $insertar13." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','B',".$arr_aux_tb[0].",'hola','hola')";		
										 /*echo $insertar13."<br>";*/
										mysqli_query($link, $insertar13);
										$insertar14 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
										 $insertar14 = $insertar14." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','B',".$arr_aux_tb[1].",'hola','hola')";		
										/* echo $insertar14."<br>";*/
										mysqli_query($link, $insertar14);
										$insertar15 = "INSERT INTO sec_web.renovacion_prog_prod(fecha_renovacion,dia_renovacion,fila_renovacion,cod_concepto,cod_grupo,desc_parcial,electro_win)";
										 $insertar15 = $insertar15." VALUES ('".$fecha_x."-01','".$dia_x."','".$fila_x."','B',".$arr_aux_tb[2].",'hola','hola')";		
										 /*echo $insertar15."<br>";*/
										mysqli_query($link, $insertar15);
										 $listo2='S';
	                                 }
						   		 
						   
						   
                           echo '<td width="70" align="center">'.$fecha_renovacion.'&nbsp;</td>';
                           echo '<td width="70" align="center">'.$arr_aux_ta[0].' '.$arr_aux_ta[1].' '.$arr_aux_ta[2].'&nbsp;</td>';
                           echo '<td width="70" align="center">'.$arr_aux_tb[0].' '.$arr_aux_tb[1].' '.$arr_aux_tb[2].'&nbsp;</td>';
				           echo '<td width="70" align="left">&nbsp;</td>';
				           echo '<td width="70" align="left">&nbsp;</td>';
				           echo '<td width="70" align="center">&nbsp;</td>';
				           echo '<td width="70" align="center">&nbsp;</td>';
						  
				           echo '</tr>';
						   

                   /*echo '<td width="70" align="center">&nbsp;</td>';*/
                        }
                   $datos='V';
                   $j=$j+1;
				   /*echo '<td width="70" align="left">&nbsp;</td>';
				   echo '<td width="70" align="left">&nbsp;</td>';
				   echo '<td width="70" align="center">&nbsp;</td>';
				   echo '<td width="70" align="center">&nbsp;</td>';
				   echo '</tr>';*/


                  }
				  $datos='V';

               }
      }



?>
</table>
</div>

<div style="position:absolute; left: 12px; width: 730px; height: 26px; top: 515px;" id="div3">
<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
<tr>
<td align="center">
<!--<input name="btnnuevo" type="button" id="btnnuevo" value="Nuevo" style="width:70" onClick="JavaScript:Proceso(this.form,'N')">
<input name="btnmodificar" type="button" id="btnmodificar" value="Modificar" style="width:70" onClick="JavaScript:Proceso(this.form,'M')">
<input name="btneliminar" type="button" id="btneliminar" value="Eliminar"style="width:70"  onClick="JavaScript:Eliminar(this.form)"> -->
<input name="btninprimir" type="button" id="btnimprimir" value="Imprimir"style="width:70"  onClick="JavaScript:Imprimir(this.form)">
<input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="JavaScript:Salir()"></td>
</tr>
</table>
</div>

</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
<?php
	if (isset($mensaje))
	{
		echo '<script language="JavaScript">';		
		echo 'alert("'.$mensaje.'");';			
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>
