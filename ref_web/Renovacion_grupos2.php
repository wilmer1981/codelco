<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 10;

	$CookieRut = $_COOKIE["CookieRut"];
	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
	$fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$DiaIniDParcial    = isset($_REQUEST["DiaIniDParcial"])?$_REQUEST["DiaIniDParcial"]:"";
	$DiaIniElectro    = isset($_REQUEST["DiaIniElectro"])?$_REQUEST["DiaIniElectro"]:"";
	$DesParcial    = isset($_REQUEST["DesParcial"])?$_REQUEST["DesParcial"]:"";
	$ElecWin    = isset($_REQUEST["ElecWin"])?$_REQUEST["ElecWin"]:"";

	$consulta="select * from ref_web.usuarios_autorizados where rut='".$CookieRut."'";
	//echo $consulta;
	$rss = mysqli_query($link, $consulta);
    $rows = mysqli_fetch_array($rss);
	$permiso= isset($rows["ren_comercial"])?$rows["ren_comercial"]:"";
	

?>

<html>
<head>
<title>Programa de Renovacion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Buscar()
{
	var  f=document.frmPrincipal;
	var fecha=f.ano1.value+"-"+f.mes1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	document.location = "../ref_web/Renovacion_grupos2.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1;
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
	switch (opc)
	{
		case "M":
			var valores = "";	
			for(i=1; i<f.elements.length; i++)	
			{
				if ((f.elements[i].name == "checkbox") && (f.elements[i].checked))
					valores = valores + f.elements[i].value;
			}
			if (valores == "")
			{
				alert("Debe seleccionar un registro para Modificar");
				return;
			}
			else
			{				
				window.open("ref_ing_ren_prog_prod.php?Proceso=M&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value + "","","top=70,left=100,width=400,height=400,scrollbars=yes,resizable = yes");
				break;
			}
			break;
		case "MT"://MODIFICA TODOS LOS DIAS EXCEPTO A DESC.PARCIAL Y E.W
			var valores = "";	
			if(confirm('Esta Seguro de Modificar Los Datos'))
			{
				for(i=4; i<f.elements.length; i++)	
				{
					if (f.elements[i].name == "checkbox")
						//valores = valores + f.elements[i].value+"~"+f.TxtTurnoAG1[i+1].value+"~"+f.TxtTurnoAG2[i+2].value+"~"+f.TxtTurnoBG1[i+3].value+"~"+f.TxtTurnoBG2[i+4].value+"//";//+"~"+f.TxtTurnoCG1[i+5].value+"~"+f.TxtTurnoCG2[i+6].value+"~"+f.TxtDesc1[i+7].value+"~"+f.TxtDesc2[i+8].value+"~"+f.TxtDesc3[i+9].value+"//";
						valores = valores + f.elements[i].value+"~"+f.elements[i+1].value+"~"+f.elements[i+2].value+"~~"+f.elements[i+3].value+"~"+f.elements[i+4].value+"~~"+f.elements[i+5].value+"~"+f.elements[i+6].value+"~~"+f.elements[i+7].value+"~"+f.elements[i+8].value+"~"+f.elements[i+9].value+"~"+f.elements[i+10].value+"~"+f.elements[i+11].value+"//";
				}
				valores=valores.substring(0,(valores.length-2));
				//alert(valores);
				f.action = "ref_ing_ren_prog_prod01.php?Proceso=MT&Valores="+valores;
				f.submit();			
			}	
			break;
		case "A":
			f.action = "Renovacion_grupos.php?opcion=H";
			f.submit();
			break;
	    case "E":
			f.action = "Renovacion_grupos_xls.php?opcion=H";
			f.submit();
			break;		
	}
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
							if ($i == $mes1)
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
							else
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}
						else
						{
							if ($i == date("n"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
							else
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}						
					}
				?>
                </select> <select name="ano1" size="1" id="select4">
        		<?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($ano1))
						{
							if ($i == $ano1)
								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						else
						{
							if ($i == date("Y"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
					}
				?>
                </select>&nbsp;&nbsp;<input name="buscar" type="button" value="buscar" onClick="Buscar()" ></td>
            </tr>
          </table>
</div>

        <div style="position:absolute; left: 10px; top: 93px; width: 744px; height: 30px;" id="div1"> 
          <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="17" height="20" align="left"><input type="hidden" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
                </td>
			  <td width="103" align="center">Fecha</td>
              <td width="95" align="center">TA</td>
              <td width="99" align="center">TB</td>
			  <td width="69" align="center">TC</td>
              <td width="129" align="center">Desc. Normal.</td>
              <td width="86" align="center">Desc. Parcial</td>
              <td width="129" align="center">Grupo 49 </td>
          </tr>
          </table>
 
 </div>
 
		
        <div style="position:absolute; left: 10px; top: 126px; width: 751px; height: 371px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php	
	
	if ($opcion=="H")
	  {
			if (strlen($mes1)==1)
			{
				//$mes1 = strval($mes1);
				$mes1 = "0".$mes1;
			}
			$fecha = $ano1."-".$mes1;
			$fecha2 = $fecha;
			$consulta_fecha = "SELECT distinct fecha_renovacion, dia_renovacion ";
			$consulta_fecha.= " from sec_web.renovacion_prog_prod ";
			$consulta_fecha.= " where dia_renovacion between '1' ";
			$consulta_fecha.= " and '31' and fecha_renovacion = '".$fecha."-01' ";
			//$consulta_fecha.= " and cod_grupo <> ''";
			$consulta_fecha.= " order by fecha_renovacion, dia_renovacion ";
			$rss = mysqli_query($link, $consulta_fecha);
            $datos = 'F';
			while ($rows = mysqli_fetch_array($rss))		  
				{
                  if ($rows["fecha_renovacion"]<>"")
					if (strlen($rows["dia_renovacion"])==1)
						$rows["dia_renovacion"]='0'.$rows["dia_renovacion"];
					$fecha=	substr($rows["fecha_renovacion"],0,8).$rows["dia_renovacion"];

					echo '<tr>';
					echo '<td width="55" height="25"><input type="hidden" name="checkbox" value="'.$rows["dia_renovacion"].'"></td>';
					echo '<td width="70" align="center">'.substr($fecha,0,7)."-".$rows["dia_renovacion"].'</td>';

                    $consulta="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta=$consulta."where dia_renovacion=".$rows["dia_renovacion"]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='A' order by dia_renovacion,fila_renovacion";
					//echo "con".$consulta;
                    $respuesta = mysqli_query($link, $consulta);
                    $i=0;
                    while($row = mysqli_fetch_array($respuesta))
                       {$arreglo[$i]=$row["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center"><input name="TxtTurnoAG1" type="text" value="'.$arreglo[0].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"><input name="TxtTurnoAG2" type="text" value="'.$arreglo[1].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"></td>';
                    $consulta2="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta2=$consulta2."where dia_renovacion=".$rows["dia_renovacion"]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='B' order by dia_renovacion,fila_renovacion";
                    $respuesta2 = mysqli_query($link, $consulta2);
                    $i=0;
                    while($row2 = mysqli_fetch_array($respuesta2))
                       {$arreglo2[$i]=$row2["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center"><input name="TxtTurnoBG1" type="text" value="'.$arreglo2[0].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"><input name="TxtTurnoBG2" type="text" value="'.$arreglo2[1].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"></td>';
				    //echo '<td width="70" align="center">'.$arreglo2[0].'-'.$arreglo2[1].'-'.$arreglo2[2].'&nbsp;</td>';
					//poly consulta turno C
					$consulta22="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta22=$consulta22."where dia_renovacion=".$rows["dia_renovacion"]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='C' order by dia_renovacion,fila_renovacion";
                    $respuesta22 = mysqli_query($link, $consulta22);
                    $i=0;
                    while($row22 = mysqli_fetch_array($respuesta22))
                       {$arreglo22[$i]=$row22["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center"><input name="TxtTurnoCG1" type="text" value="'.$arreglo22[0].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"><input name="TxtTurnoCG2" type="text" value="'.$arreglo22[1].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"></td>';
					//echo '<td width="70" align="center">'.$arreglo22[0].'-'.$arreglo22[1].'-'.$arreglo22[2].'&nbsp;</td>';

					
					//poly
                    $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta3=$consulta3."where dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%' and cod_concepto='D' order by dia_renovacion,fila_renovacion";
                    $respuesta3 = mysqli_query($link, $consulta3);
			//echo "hola".$consulta3;
                    $i=0;
					$arreglo3=array();
                    while($row3 = mysqli_fetch_array($respuesta3))
                       {
                           if  ($row3["cod_grupo"]=="")
                             {
							 $arreglo3[$i]=" ";
							 }
                            else $arreglo3[$i]=$row3["cod_grupo"];
                        	$i++;
						}
                    //echo '<td width="110" align="center">'.$arreglo3[0].' '.$arreglo3[1].' '.$arreglo3[2].' '.$arreglo3[3].' '.$arreglo3[4].' '.$arreglo3[5].'&nbsp;</td>';
                    echo '<td width="105" align="center"><input name="TxtDesc1" type="text" value="'.$arreglo3[0].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"><input name="TxtDesc2" type="text" value="'.$arreglo3[1].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"><input name="TxtDesc3" type="text" value="'.$arreglo3[2].'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"></td>';
					$consulta4="select distinct dia_renovacion,desc_parcial from sec_web.renovacion_prog_prod ";
                    $consulta4=$consulta4."where fila_renovacion='1' and dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta = mysqli_query($link, $consulta4);
                    $rowe = mysqli_fetch_array($respuesta);
					$DescParcial='';
                    if ($rowe["desc_parcial"]!="")
						$DescParcial=intval(substr($rowe["desc_parcial"],7));
						
				    echo '<td width="70" align="center"><input name="TxtParcial" type="text" value="'.$DescParcial.'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2"></td>';
                    $consulta5="select distinct dia_renovacion,electro_win from sec_web.renovacion_prog_prod ";
                    $consulta5=$consulta5."where fila_renovacion='1' and dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta5 = mysqli_query($link, $consulta5);
                    $rowe = mysqli_fetch_array($respuesta5);
					$EW='';
                    if ($rowe["electro_win"]!="")
						$EW=intval(substr($rowe["electro_win"],4));
                    echo '<td width="70" align="center"><input name="TxtEW" type="text" value="'.$EW.'" size="3" onKeyDown=TeclaPulsada2("S",false,this.form,"") maxlength="2">';
                   	echo '</tr>';
                    $datos='V';
				}
			//echo "aaaa".$datos."<br>"; 	
            if ($datos == "F")
            {
				$UltDiasMesAnt=date("Y-m-d", mktime(0,0,0,$mes1,1-1,$ano1));
				$DiasAnt=intval(substr($UltDiasMesAnt,8));
				$UltDiasMes=date("Y-m-d", mktime(0,0,0,$mes1+1,1-1,$ano1));
				$Dias=intval(substr($UltDiasMes,8));
				$DiasCons=($DiasAnt-7);
				//PARA OBTENER DESCOBRIZACION PARCIAL
				$FechaAnt=date("Y-m-d", mktime(0,0,0,$mes1-1,"01",$ano1));
				$Consulta="select max(desc_parcial) as DescParcial,dia_renovacion from sec_web.renovacion_prog_prod where fecha_renovacion ='".$FechaAnt."' and dia_renovacion between '".$DiasCons."' and '".$DiasAnt."' and fila_renovacion='1' and desc_parcial<>'' group by fecha_renovacion";
				//echo $Consulta."<br><br>";
				$RespDParcial=mysqli_query($link, $Consulta);
				if($FilaParcial=mysqli_fetch_array($RespDParcial))
				{
					$DiaParcial=intval(substr($FilaParcial["DescParcial"],7));
					if($DiaParcial==6)
						$DiaParcial=1;
					else
						$DiaParcial=$DiaParcial+1;
					$DifMesAnt=$DiasAnt-$FilaParcial["dia_renovacion"];
					$DiaIniDParcial=7-$DifMesAnt;	
				}
				//PARA OBTENER ELECTROWIN
				$FechaAnt=date("Y-m-d", mktime(0,0,0,$mes1-1,"01",$ano1));
				$Consulta="select max(ceiling(substr(electro_win,5))) as ElectroWin,dia_renovacion from sec_web.renovacion_prog_prod where fecha_renovacion ='".$FechaAnt."' and dia_renovacion between '".$DiasCons."' and '".$DiasAnt."' and fila_renovacion='1' and electro_win<>'' group by fecha_renovacion";
				//echo $Consulta."<br><br>";
				$RespElect=mysqli_query($link, $Consulta);
				if($FilaElect=mysqli_fetch_array($RespElect))
				{
					$DiaElectro=intval($FilaElect["ElectroWin"]);
					if($DiaElectro==14)
						$DiaElectro=1;
					else
						$DiaElectro=$DiaElectro+1;
					$DifMesAnt=$DiasAnt-$FilaElect["dia_renovacion"];
					$DiaIniElectro=7-$DifMesAnt;	
				}
				//echo "Dia Parcial:".$DiaElectro;
				//echo "Dia inicio parcial:".$DiaIniElectro;
				//echo "DIAS DEL MES:".$Dias;
				$i = 1;
				for ($i = 1; $i<=$Dias;$i++)
				{
					for ($j=1;$j<=12;$j++)
					{
						if($i<=8)
						{
							$DiasCons=($DiasAnt-8)+$i;
							$FechaAnt=date("Y-m-d", mktime(0,0,0,$mes1-1,"01",$ano1));
						}
						else
						{
							$DiasCons=$i-8;
							$FechaAnt=date("Y-m-d", mktime(0,0,0,$mes1,"01",$ano1));
						}	
						$Consulta="select * from sec_web.renovacion_prog_prod where fecha_renovacion ='".$FechaAnt."' and dia_renovacion='".$DiasCons."' and fila_renovacion='".$j."'";
						//echo $Consulta."<br><br>";
						$RespGrupo=mysqli_query($link, $Consulta);
						$Grupo1='';$Grupo2='';$Grupo3='';$Grupo4='';$Grupo5='';$Grupo6='';$Grupo7='';$Grupo8='';$Grupo9='';$Grupo10='';$Grupo11='';$Grupo12='';
						while($FilaGrupo=mysqli_fetch_array($RespGrupo))
						{
							switch($FilaGrupo["fila_renovacion"])
							{
								case "1":
									$Grupo=$FilaGrupo["cod_grupo"];
									if($i==$DiaIniDParcial)
									{
										$DesParcial="PARCIAL ".$DiaParcial;
										$DiaParcial=$DiaParcial+1;
										if($DiaParcial>6)
											$DiaParcial=1;
										$DiaIniDParcial=$DiaIniDParcial+7;
									}
									if($i==$DiaIniElectro)
									{
										$ElecWin="E.W. ".$DiaElectro;
										$DiaElectro=$DiaElectro+1;
										if($DiaElectro>14)
											$DiaElectro=1;
										$DiaIniElectro=$DiaIniElectro+7;
									}
									break;
								case "2":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "3":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "4":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "5":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "6":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "7":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "8":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "9":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "10":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "11":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;
								case "12":
									$Grupo=$FilaGrupo["cod_grupo"];
									$DesParcial=$FilaGrupo["desc_parcial"];
									$ElecWin=$FilaGrupo["electro_win"];
									break;

							}
						}	
						$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
						$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
						$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
						$Insertar.= " VALUES ('".$ano1."-".$mes1."-01', '".$i."', ";
						$Insertar.= " '".$j."',";
						/*poly turno a turno b y turno c con dos*/
						if (($j==1) || ($j==2) || ($j==3))
							$Insertar.= " 'A', '$Grupo', '$DesParcial', '$ElecWin')";
						if (($j==4) || ($j==5) || ($j==6))
							$Insertar.= " 'B', '$Grupo', '$DesParcial', '$ElecWin')";
						if (($j==7) || ($j==8) || ($j==9))
							$Insertar.= " 'C', '$Grupo', '$DesParcial', '$ElecWin')";
						if (($j==10) || ($j==11) || ($j==12))
							$Insertar.= " 'D', '$Grupo', '$DesParcial', '$ElecWin')";
						mysqli_query($link, $Insertar);
						//echo $Insertar."<br>";
					}
				}
				echo "<script languaje='JavaScript'>\n";
				echo "document.frmPrincipal.action = 'Renovacion_grupos2.php?opcion=H';";
				echo "document.frmPrincipal.submit();";
				echo "</script>\n";
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
                <input name="btnActualizar" type="button" id="btnActualizar" onClick="Proceso(this.form,'A')" value="Actualizar Pagina">
				
			<?php if ($permiso=='1')
			      {?>	
                     <input name="btnModificar" type="hidden" value="Modificar Ind." onClick="Proceso(this.form,'M')">
					 <input name="btnModificar" type="button" value="Modificar Todos" onClick="Proceso(this.form,'MT')">
				<?php } ?>	 
                <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="JavaScript:Salir()">
				<input name="Excel" type="button" value="Excel" onClick="Proceso(this.form,'E')" ></td>
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
