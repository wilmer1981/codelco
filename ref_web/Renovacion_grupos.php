<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 10;

	$CookieRut = $_COOKIE["CookieRut"];
	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";

	$consulta="select * from ref_web.usuarios_autorizados where rut='".$CookieRut."'";
	//echo $consulta;
	$rss     = mysqli_query($link, $consulta);
    $rows    = mysqli_fetch_array($rss);
	$permiso = isset($rows["ren_comercial"])?$rows["ren_comercial"]:"";
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
	document.location = "../ref_web/Renovacion_grupos.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1;
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
              <td width="71" height="20" align="left"><input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
                Todo</td>
			  <td width="85" align="center">Fecha</td>
              <td width="101" align="center">TA</td>
              <td width="98" align="center">TB</td>
			  <td width="98" align="center">TC</td>
              <td width="140" align="center">Desc. Normal.</td>
              <td width="93" align="center">Desc. Parcial</td>
              <td width="139" align="center">Exper.</td>
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
					echo '<td width="55" height="25"><input type="checkbox" name="checkbox" value="'.$rows["dia_renovacion"].'"></td>';
					echo '<td width="70" align="center">'.substr($fecha,0,7)."-".$rows["dia_renovacion"].'</td>';

                    $consulta="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta=$consulta."where dia_renovacion=".$rows["dia_renovacion"]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='A' order by dia_renovacion,cod_grupo";
					//echo "con".$consulta;
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
					//poly consulta turno C
					$consulta22="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta22=$consulta22."where dia_renovacion=".$rows["dia_renovacion"]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='C' order by dia_renovacion,cod_grupo";
                    $respuesta22 = mysqli_query($link, $consulta22);
                    $i=0;
                    while($row22 = mysqli_fetch_array($respuesta22))
                       {$arreglo22[$i]=$row22["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center">'.$arreglo22[0].'-'.$arreglo22[1].'-'.$arreglo22[2].'&nbsp;</td>';

					
					//poly
                    $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta3=$consulta3."where dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%' and cod_concepto='D' order by dia_renovacion,cod_grupo";
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
					$arreglo30 = isset($arreglo3[0])?$arreglo3[0]:"";
					$arreglo31 = isset($arreglo3[1])?$arreglo3[1]:"";
					$arreglo32 = isset($arreglo3[2])?$arreglo3[2]:"";
					$arreglo33 = isset($arreglo3[3])?$arreglo3[3]:"";
					$arreglo34 = isset($arreglo3[4])?$arreglo3[4]:"";
					$arreglo35 = isset($arreglo3[5])?$arreglo3[5]:"";

                    echo '<td width="110" align="center">'.$arreglo30.' '.$arreglo31.' '.$arreglo32.' '.$arreglo33.' '.$arreglo34.' '.$arreglo35.'&nbsp;</td>';
                    $consulta4="select distinct dia_renovacion,desc_parcial from sec_web.renovacion_prog_prod ";
                    $consulta4=$consulta4."where fila_renovacion='1' and dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta = mysqli_query($link, $consulta4);
                    $rowe = mysqli_fetch_array($respuesta);
                    if ($rowe["desc_parcial"]=="")
                       {$rowe["desc_parcial"]='-';}
				    echo '<td width="70" align="center">'.$rowe["desc_parcial"].'&nbsp;</td>';
                    $consulta5="select distinct dia_renovacion,electro_win from sec_web.renovacion_prog_prod ";
                    $consulta5=$consulta5."where fila_renovacion='1' and dia_renovacion='".$rows["dia_renovacion"]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta5 = mysqli_query($link, $consulta5);
                    $rowe = mysqli_fetch_array($respuesta5);
                    if ($rowe["electro_win"]=="")
                       {$rowe["electro_win"]='-';}
                    echo '<td width="70" align="center">'.$rowe["electro_win"].'&nbsp;</td>';
                   	echo '</tr>';
                    $datos='V';
				}
            if ($datos == "F")
            {
				$i = 1;
				for ($i = 1; $i<=31;$i++)
				{
					for ($j=1;$j<=12;$j++)
					{
						$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
						$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
						$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
						$Insertar.= " VALUES ('".$ano1."-".$mes1."-01', '".$i."', ";
						$Insertar.= " '".$j."',";
						/*poly turno a turno b y turno c con dos*/
						if (($j==1) || ($j==2) || ($j==3))
							$Insertar.= " 'A', '', '', '')";
						if (($j==4) || ($j==5) || ($j==6))
							$Insertar.= " 'B', '', '', '')";
						if (($j==7) || ($j==8) || ($j==9))
							$Insertar.= " 'C', '', '', '')";

						if (($j==10) || ($j==11) || ($j==12))
							$Insertar.= " 'D', '', '', '')";
						mysqli_query($link, $Insertar);
					}
				}
				echo "<script languaje='JavaScript'>\n";
				echo "document.frmPrincipal.action = 'Renovacion_grupos.php?opcion=H';";
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
                     <input name="btnModificar" type="button" value="Modificar" onClick="Proceso(this.form,'M')">
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
