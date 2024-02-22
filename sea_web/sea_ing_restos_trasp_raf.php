<?php 
$CodigoDeSistema = 2;
$CodigoDePantalla = 33;

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
}
if(isset($_REQUEST["cmbgrupo"])) {
	$cmbgrupo = $_REQUEST["cmbgrupo"];
}else{
	$cmbgrupo = "";
}
if(isset($_REQUEST["cmbfecha"])) {
	$cmbfecha = $_REQUEST["cmbfecha"];
}else{
	$cmbfecha = "";
}


if(isset($_REQUEST["dia_r"])) {
	$dia_r = $_REQUEST["dia_r"];
}else{
	$dia_r = date("d");
}
if(isset($_REQUEST["mes_r"])) {
	$mes_r = $_REQUEST["mes_r"];
}else{
	$mes_r =  date("m");
}
if(isset($_REQUEST["ano_r"])) {
	$ano_r = $_REQUEST["ano_r"];
}else{
	$ano_r =  date("Y");
}

?>

<html>
<head>
<title>Sistema de Anodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<script language="JavaScript">

/***********************/
function guardar_raf()
{
	var f = formulario;
	var Largo = f.elements.length;
	var Valores = "";
	if(f.cmbgrupo.value == -1)
	{  
	   alert("debe ingresar el grupo");
	   f.cmbgrupo.focus();
	   return
	}

   for (i=1;i<Largo;i++)
   {
		if (f.elements[i].name=="Checktrasp" && f.elements[i].checked==true)
		{
			Valores = Valores + f.elements[i - 6].value +","+ f.elements[i - 5].value +","+ f.elements[i - 4].value +","+ f.elements[i - 3].value +","+ f.elements[i - 2].value +"//";
		}
   }

   f.action="sea_ing_restos_trasp_raf01.php?Proceso=G&Valores=" + Valores;
   f.submit();
}
function guardar_sec()
{
	var f = formulario;
    var control = 0;
	var frm = document.formulario;
	var Largo = f.elements.length;
	var Valores = "";
	if(f.cmbgrupo.value == -1)
	 {  
	   alert("debe ingresar el grupo");
	   f.cmbgrupo.focus();
	   return
	 }
   	for (i=1;i<Largo;i++)
   	{
		if (f.elements[i].name=="Checktrasp" && f.elements[i].checked==true)
		{
            control = control + 1;
			Valores = Valores + f.elements[i - 6].value +","+ f.elements[i - 5].value +","+ f.elements[i - 4].value +","+ f.elements[i - 3].value +","+ f.elements[i - 2].value +','+ f.elements[i - 7].value +"//";
		}
   }
    if (control==0)
	{
          alert ("no hay  nada seleccionado para traspasar")
          return;
	}
    
	f.action="sea_ing_restos_trasp_sec01.php?Proceso=GE&Valores="+Valores;
    f.submit();
}

function ver_raf()
{

	var f = formulario;
       		window.open("sea_ing_restos_trasp_raf02.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
}
function ver_sec()
{
	var f = formulario;
	       	window.open("sea_ing_restos_trasp_sec022.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
}

/**************************/
function mostrar_datos()
{
	var f = formulario;

var fecha_t;
	 
	  f.action="sea_ing_restos_trasp_raf.php?Proceso=B&Proceso=V";
	
      f.submit();

}

function mostrar_grupos()
{
var f = formulario;
var fecha_t;
	 
	  f.action="sea_ing_restos_trasp_raf.php?Proceso=B";
      f.submit();

}



function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}

</script>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>

<body>
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
      <tr>
      <td width="502" align="center" valign="top"><td align="center" valign="middle">
  <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2">Fecha Reproceso</td>
            <td width="203"><SELECT name="dia_r" size="1" style="font-face:verdana;font-size:10">
                <?php    
			if($Proceso == 'V' || $Proceso == 'B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia_r)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }
		
		 ?>
              </SELECT> <SELECT  name="mes_r" size="1" id="SELECT5" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php       
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $Proceso == 'B')
		{
		
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes_r)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
    ?>
              </SELECT> <SELECT name="ano_r" size="1" id="SELECT6"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php            
	if($Proceso=='V' || $Proceso == 'B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano_r)
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }
	?>
              </SELECT></td>
            <td colspan="3">Ver Restos Ingresados</td>
            <td width="150"><font color="#000000">
             
			  <input type="button" name="Ver" value="Traspasados RAF" onClick="ver_raf();">
                <td width="150"><font color="#000000">
             
			 	 <input type="button" name="VerS" value="Traspasados SEC" onClick="ver_sec();">
              </font></td>
          </font></td>
			  
          </tr>
        </table>
		<br>

     <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 

		    <td width="69">Grupo</td>
                
            <td width="71"><font color="#000000"> 
              <SELECT name="cmbgrupo" onChange="mostrar_grupos();">
         <?php
			include("../principal/conectar_principal.php");
			echo '<option value="-1">Grupo</option>';
			$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2004 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if ($row["cod_subclase"] == $cmbgrupo)
					echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}
		?>
              </SELECT>
              </font> </td> 
            <td><font color="#000000">Peso/Fecha</font> </td>
		    <td width="512"><font color="#000000">
		 
      		<SELECT name="cmbfecha" onChange="mostrar_datos();">
            <option value="-1">Seleccionar</option>
			 
		
        <?php
		 if($Proceso == "B" || $Proceso == "V")		 
		 {		
		 	$consulta = "SELECT YEAR(NOW()) AS  ano, MONTH(NOW()) AS mes";
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			
			$arreglo = array(); //0: hornada, 1: campo1, 2: fecha_benef, 3:cod_subproducto.
			
			//Para hornadas de restos ctte
			$consulta = "SELECT * FROM sea_web.stock WHERE cod_producto = 19 AND cod_subproducto <> 30 and unid_fin <> 0 AND ano = ".$row["ano"]." AND mes = ".$row["mes"] ; 	
			$X1 = $consulta;
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
			
				//consulta el grupo y fecha de produccion.
				$consulta = "SELECT * FROM sea_web.movimientos";
				$consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = ".$row1["cod_producto"]." AND cod_subproducto = ".$row1["cod_subproducto"];
				$consulta.= "  AND hornada = ".$row1["hornada"];
				$consulta.= " GROUP BY hornada";
				$X2 = $consulta;
				$rs2 = mysqli_query($link, $consulta);
				while ($row2 = mysqli_fetch_array($rs2))
				{
					if ($row2["campo2"] == $cmbgrupo)
					{
						if ($arreglo[$row2["fecha_movimiento"]][0] == "")
							$arreglo[$row2["fecha_movimiento"]][0] = $row2["hornada"];
						else
							$arreglo[$row2["fecha_movimiento"]][0] = $arreglo[$row2["fecha_movimiento"]][0].','.$row2["hornada"];						
							$arreglo[$row2["fecha_movimiento"]][1] = $row2["campo1"];
							$arreglo[$row2["fecha_movimiento"]][2] = $row2["fecha_benef"];
							$arreglo[$row2["fecha_movimiento"]][3] = $arreglo[$row2["fecha_movimiento"]][3].','.$row2["cod_subproducto"];
					}
				}
			}
			
			//Para hornadas de restos de restos.
			$consulta = "SELECT * FROM sea_web.stock WHERE cod_producto = 19 AND cod_subproducto = 30 AND ano = ".$row["ano"]." AND mes = ".$row["mes"] ; 
			$X3 = $consulta;
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
				//consulta el grupo y fecha de produccion.
				$consulta = "SELECT * FROM sea_web.movimientos";
				$consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = ".$row1["cod_producto"]." AND cod_subproducto = ".$row1["cod_subproducto"];
				$consulta.= "  AND hornada = ".$row1["hornada"];
				$consulta.= " LIMIT 0,1";
				$X4 = $consulta;
				$rs2 = mysqli_query($link, $consulta);
				while ($row2 = mysqli_fetch_array($rs2))
				{
				
					if ($row2["campo2"] == $cmbgrupo)
					{
					
						if ($arreglo[$row2["fecha_movimiento"]][0] == "")
						{						
						
							$arreglo[$row2["fecha_movimiento"]][0] = $row2["hornada"];
							$arreglo[$row2["fecha_movimiento"]][1] = $row2["campo1"];
							$arreglo[$row2["fecha_movimiento"]][2] = $row2["fecha_benef"];
							
						}
						else if (($arreglo[$row2["fecha_movimiento"]][3] != 8) and ($row2["fecha_benef"] == $arreglo[$row2["fecha_movimiento"]][2]))  //Distinto de HM. no tiene resto de resto.
						{						
							$arreglo[$row2["fecha_movimiento"]][0] = $arreglo[$row2["fecha_movimiento"]][0].','.$row2["hornada"];
							$arreglo[$row2["fecha_movimiento"]][1] = $row2["campo1"];
							
						}
							
					}
				}
			}			

			reset($arreglo);
			//while (list($c,$v) = each($arreglo))
			foreach ($arreglo as $c=>$v)
			{	
				echo $v[0]."<br>";
				
			}

			//Escribe Combo.
			reset($arreglo);
			//while (list($c,$v) = each($arreglo))
			foreach ($arreglo as $c=>$v)
			{	
					if ($cmbgrupo != '8')
					{
						$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
						$consulta.= " WHERE tipo_movimiento = 3  AND cod_producto = 19  and hornada IN (".$v[0].")";
						$X5= $consulta;
						/* lo puse para ver si divide las HM de los Ctes. echo $consulta."<br>";*/
						$rs3 = mysqli_query($link, $consulta);
						$row3 = mysqli_fetch_array($rs3);
						$unidades = $row3["unidades"];
						$peso = $row3["peso"];
						
						// esto es para descontar lo pasado a sec pero no embarcado
						$cons_sec = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso from sea_web.restos_a_sec";
						$cons_sec.=" where tipo_movimiento = '1' and cod_producto = '19' and hornada IN (".$v[0].")";
						$X6 = $cons_sec;
						$rsec=mysqli_query($link, $cons_sec);
						$row_sec = mysqli_fetch_array($rsec);

						$unidades 	= $unidades - $row_sec["unidades"];
						$peso 		= $peso - $row_sec["peso"];
					}
					else
					{
							$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
							$consulta.= " WHERE tipo_movimiento = 3  AND cod_producto = 19 AND hornada IN (".$v[0].")";
							$consulta.= " AND cod_subproducto IN ('1','2','3','4','30')";
							$X7 = $consulta;

							$rs33 = mysqli_query($link, $consulta);
							$row33 = mysqli_fetch_array($rs33);
							$unidades_cte = $row33["unidades"];
							$peso_cte = $row33["peso"];
							// esto es para descontar lo pasado a sec pero no embarcado
							$cons_sec1 = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso from sea_web.restos_a_sec";
							$cons_sec1.=" where tipo_movimiento = '1' and cod_producto = '19' and hornada IN (".$v[0].")";
							$cons_sec1.=" and cod_subproducto IN ('1','2','3','4','30')";
							$X8 = $consulta;

							$rsec1=mysqli_query($link, $cons_sec1);

							$row_sec1 = mysqli_fetch_array($rsec1);
							$unidades_cte = $unidades_cte - $row_sec1["unidades"];
							$peso_cte = $peso_cte - $row_sec1["peso"];

							
							$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
							$consulta.= " WHERE tipo_movimiento = 3  AND cod_producto = 19 AND hornada IN (".$v[0].")";
							$consulta.= " AND cod_subproducto IN ('5','6','8','14')";
							$X9 = $consulta;

							/* lo puse para ver si divide las HM de los Ctes. echo $consulta."<br>";*/
							$rs333 = mysqli_query($link, $consulta);
							$row333 = mysqli_fetch_array($rs333);
							$unidades = $row333["unidades"];
							$peso = $row333["peso"];
							// esto es solo si existen ajuste por sobrante de planchas
										
							$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
							$consulta.= " WHERE tipo_movimiento = 1  AND cod_producto = 19 AND hornada IN (".$v[0].")";
							$consulta.= " AND cod_subproducto IN ('5','6','8','14')";
							$X9B = $consulta;
							$rs333b = mysqli_query($link, $consulta);
							$row333b = mysqli_fetch_array($rs333b);
							$unidades =  $unidades + $row333b["unidades"];
							$peso =  $peso + $row333b["peso"];
				
							// esto es para descontar lo pasado a sec pero no embarcado
							$cons_sec2 = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso from sea_web.restos_a_sec";
							$cons_sec2.=" where tipo_movimiento = '1' and cod_producto = '19' and hornada IN (".$v[0].")";
							$cons_sec2.=" and cod_subproducto IN ('5','6','8','14')";
							$X10 =$cons_sec2;
							$rsec2=mysqli_query($link, $cons_sec2);
							$row_sec2 = mysqli_fetch_array($rsec2);
							$unidades = $unidades - $row_sec2["unidades"];
							$peso = $peso - $row_sec2["peso"];
					}	
				if ($cmbgrupo != '8')
				{
					$consulta = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento IN (2,4,10) AND cod_producto = 19 AND hornada IN (".$v[0].")";
					$X11 = $consulta;
					$rs4 = mysqli_query($link, $consulta);
					$row4 = mysqli_fetch_array($rs4);
					$unidades = $unidades - $row4["unidades"];
					$peso = $peso - $row4["peso"];
				}
				else
				{
					$consulta = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento IN (2,4,10) AND cod_producto = 19 AND hornada IN (".$v[0].")";
					$consulta.= " AND cod_subproducto IN ('1','2','3','4','30')";
					$X12 = $consulta;
	
					$rs44 = mysqli_query($link, $consulta);
					$row44 = mysqli_fetch_array($rs44);
					$unidades_cte = $unidades_cte - $row44["unidades"];
					$peso_cte = $peso_cte - $row44["peso"];
					
					$consulta = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento IN (2,4,10) AND cod_producto = 19 AND hornada IN (".$v[0].")";
					$consulta.= " AND cod_subproducto IN ('5','6','8','14','30')";
					$X13 = $consulta;
					$rs444 = mysqli_query($link, $consulta);
					$row444 = mysqli_fetch_array($rs444);
					$unidades = $unidades - $row444["unidades"];
					$peso    = $peso - $row444["peso"];
				}
				

				if ($unidades > 0||$unidades_cte > 0)
				
				
				{
					if ($c == $cmbfecha||$c."H" == $cmbfecha||$c."C" == $cmbfecha)
					{
						if ($cmbgrupo == '8')
						{
						
						
							if(substr($cmbfecha,strlen($cmbfecha)-1,1)=='H'&&$peso>0)
							{
								echo '<option value="'.$c.'H" SELECTed>'.$peso.' - '.$c.'</option>';	
								$Hornadas_Aux = $v[0];
								$Lado_Aux = $v[1];
								$subprod_aux = $v[3];
								$peso_aux = $peso;
								$unidades_aux = $unidades;
								if($peso_cte>0)
									echo '<option value="'.$c.'C">'.$peso_cte.' - '.$c.'</option>';	
							}
							else
							{	if(substr($cmbfecha,strlen($cmbfecha)-1,1)=='C'&&$peso_cte>0)
								{
									echo '<option value="'.$c.'C" SELECTed>'.$peso_cte.' - '.$c.'</option>';	
									$Hornadas_Aux = $v[0];
									$Lado_Aux = $v[1];
									$subprod_aux = $v[3];
									$peso_aux = $peso_cte;
									$unidades_aux = $unidades_cte;
									if($peso>0)									
										echo '<option value="'.$c.'H">'.$peso.' - '.$c.'</option>';	
								}
							}	
						}
						else
						{	
						
							echo '<option value="'.$c.'" SELECTed>'.$peso.' - '.$c.'</option>';
							$Hornadas_Aux = $v[0];
							$Lado_Aux = $v[1];
							$subprod_aux = $v[3];
							$peso_aux = $peso;
							$unidades_aux = $unidades;
						}
					}
					else
					{
					
					
					
						if ($cmbgrupo == '8')
						{
							if ($peso > 0) 
								echo '<option value="'.$c.'H">'.$peso.' - '.$c.'</option>';	
							if ($peso_cte > 0)
							
								echo '<option value="'.$c.'C">'.$peso_cte.' - '.$c.'</option>';	
						}
						else
						
							echo '<option value="'.$c.'">'.$peso.' - '.$c.'</option>';		
					}
				}
			}
         }
		 ?>
            </SELECT>
			<?php
			
			//echo $X1."<BR>";
			//echo $X2."<BR>";
			// echo $var1; // WSO
			
			?>
              </font></td>
		</tr>
		<?php

		 if ($Proceso =='V' && $cmbfecha != -1)
		 {
		 	$i = 0;
            //echo "HORNADAS: ".$Hornadas_Aux."<BR>";
			$vector = explode(',',$Hornadas_Aux);
			
			//echo "SUBPROD: ".$subprod_aux."<BR>";
			$subprod_aux=substr($subprod_aux,1);
			$veogr  = explode(',',$subprod_aux);
			
			$j7 = $veogr[1];
            $Subpro =  $veogr[1];
			while (list($a,$b) = each($vector))
			{
				$Subpro =  $veogr[$a];
				if ($cmbgrupo != '8')
				{
					$consulta = "SELECT cod_subproducto,IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento = 3  AND cod_producto = 19 and hornada = '".$b."' and fecha_movimiento = '".$cmbfecha."' group by cod_subproducto";
					$rsp1 = mysqli_query($link, $consulta);
					$fila1= mysqli_fetch_array($rsp1);
					$Unidad = $fila1["unidades"];
					$Peso   = $fila1["peso"];
					$Subpro = $fila1["cod_subproducto"];
						
					// esto es para descontar lo pasado a sec pero no embarcado
					$cons_sec = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso from sea_web.restos_a_sec";
					$cons_sec.=" where tipo_movimiento = '1' and cod_producto = '19' and hornada = '".$b."' and cod_subproducto = '".$Subpro."'";
					$rsp2=mysqli_query($link, $cons_sec);
					$fila2= mysqli_fetch_array($rsp2);

                    $Unidad 	= $Unidad - $fila2["unidades"];
                    $Peso 		= $Peso - $fila2["peso"];
				}
				else
				{
					$consulta = "SELECT cod_subproducto,IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento = 3  AND cod_producto = 19 AND hornada = '".$b."' ";
					$consulta.= " AND cod_subproducto = '".$Subpro."' group by cod_subproducto ";
					$j1 = $consulta;
					$rsp3 = mysqli_query($link, $consulta);
					$fila3 = mysqli_fetch_array($rsp3);
					$Unidad_cte = $fila3["unidades"];
					$Peso_cte = $fila3["peso"];
					// esto es para descontar lo pasado a sec pero no embarcado
					$cons_sec1 = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso from sea_web.restos_a_sec";
					$cons_sec1.=" where tipo_movimiento = '1' and cod_producto = '19' and hornada = '".$b."' ";
					$cons_sec1.=" and cod_subproducto = '".$Subpro."'";
					$j2 = $cons_sec1;
					$resp4=mysqli_query($link, $cons_sec1);
					$fila4 = mysqli_fetch_array($resp4);
					$Unidad_cte = $Unidad_cte - $fila4["unidades"];
					$Peso_cte = $Peso_cte     - $fila4["peso"];
							
					$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento = 3  AND cod_producto = 19 AND hornada = '".$b."' ";
					$consulta.= " AND cod_subproducto = '".$Subpro."'";
					$j3 = $consulta;
					$rsp5 = mysqli_query($link, $consulta);
					$fila5 = mysqli_fetch_array($rsp5);
					$Unidad = $fila5["unidades"];
					$Peso = $fila5["peso"];
					$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento = 1  AND cod_producto = 19 AND hornada = '".$b."'";
					$consulta.= " AND cod_subproducto = '".$Subpro."'";
					$j4 = $consulta;
					$rsp6 = mysqli_query($link, $consulta);
					$fila6 = mysqli_fetch_array($rsp6);
					$Unidad =  $Unidad + $fila6["unidades"];
					$Peso =  $Peso + $fila6["peso"];
					$cons_sec2 = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso from sea_web.restos_a_sec";
					$cons_sec2.=" where tipo_movimiento = '1' and cod_producto = '19' and hornada = '".$b."' ";
					$cons_sec2.=" and cod_subproducto = '".$Subpro."'";
					$j5 = $cons_sec2;
					$rsp7=mysqli_query($link, $cons_sec2);
					$fila7 = mysqli_fetch_array($rsp7);
					$Unidad = $Unidad - $fila7["unidades"];
					$Peso = $Peso - $fila7["peso"];
				}	
				if ($cmbgrupo != '8')
				{
					$consulta = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento IN (2,4,10) AND cod_producto = 19 AND hornada = '".$b."' and cod_subproducto = '".$Subpro."' ";
					$rsp8= mysqli_query($link, $consulta);
					$fila8= mysqli_fetch_array($rsp8);
					$Unidad = $Unidad - $fila8["unidades"];
					$Peso = $Peso - $fila8["peso"];
				}
				else
				{
					$consulta = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento IN (2,4,10) AND cod_producto = 19 AND hornada = '".$b."' ";
					$consulta.= " AND cod_subproducto = '".$Subpro."'";
					$rsp9 = mysqli_query($link, $consulta);
					$fila9 = mysqli_fetch_array($rsp9);
					$Unidad_cte = $Unidad_cte - $fila9["unidades"];
					$Peso_cte = $Peso_cte - $fila9["peso"];
					
					$consulta = "SELECT IFNULL(SUM(unidades),0) as unidades, IFNULL(SUM(peso),0) as peso FROM sea_web.movimientos";
					$consulta.= " WHERE tipo_movimiento IN (2,4,10) AND cod_producto = 19 AND hornada = '".$b."' ";
					$consulta.= " AND cod_subproducto = '".$Subpro."'";
					$rsp10 = mysqli_query($link, $consulta);
					$fila10= mysqli_fetch_array($rsp10);
					$Unidad = $Unidad - $fila10["unidades"];
					$Peso    = $Peso - $fila10["peso"];
				}
				
				if ($Unidad > 0||$Unidad_cte > 0)
				{
					$descri = "SELECT abreviatura as abrevia from proyecto_modernizacion.subproducto where cod_producto = '19' ";
					$descri.="and cod_subproducto = '".$Subpro."'";
					$respue = mysqli_query($link, $descri);
					$filad = mysqli_fetch_array($respue);
					
		?>
			   		<tr>
					<td>Unidades</td>
		<?php 		
					echo '<input name="Hornadas" type="hidden" value="'.$b.'">';
					echo '<input name="subprod" type="hidden" value="'.$Subpro.'">';
					echo '<input name="Lado" type="hidden" value="'.$Lado_Aux.'">';
					if ($Proceso == 'V' && $cmbfecha != -1)
                    {
						echo '<td><input name="unidades" value="'.$Unidad.'" size="10" readonly></td>';
                        echo '<td >Peso</td>';
                        echo '<td><input name="peso" value="'.$Peso.'" size="10" readonly>&nbsp;&nbsp;';
						echo '<input name="abrevia" value="'.$filad["abrevia"].'" size="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
 						echo'<input type="checkbox" name="Checktrasp"></td>';

                     }
                     else
                     {
						echo '<td><input name="unidades" value="" size="10" readonly></td>';
                        echo '<td width = "71">Peso</td>';
						echo '<td><input name="peso" value="" size="10" readonly></td>';
					}
		?>
	  		</tr>
		<?php
			}
		}
	}
	?>
      </table>
      <br>  
      <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><div align="center"><font color="#000000"> 
             <?php  
  
             if ($Proceso == 'V' && $cmbfecha != -1)
			 {			 
			   echo'<input name="guardar"  type="button" style="width:100" value="Trasp. A RAF" onClick="guardar_raf();">&nbsp;';
			   echo'<input name="guardars" type="button" style="width:100" value="Trasp. A SEC" onClick="guardar_sec();">&nbsp;';
             }
			 ?>
             <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
            
			
             </font></div></td>
          </tr>
      </table>
  <br>
  
  <?php
/*
  echo "1-".$X1."</br>";
  echo "2-".$X2."</br>";
  echo "3-".$X3."</br>";
  echo "4-".$X4."</br>";
  echo "5-".$X5."</br>";
  echo "6-".$X6."</br>"; 
  echo "7-".$X7."</br>"; 
  echo "8-".$X8."</br>";
  echo "9-".$X9."</br>";
  echo "9b-".$X9B."</br>";
  echo "10-".$X10."</br>";
  echo "12-".$X12."</br>";
  echo "13-".$X13."</br>";
  echo "13b-".$j7."</br>";
  echo "14-".$j1."</br>";
  echo "15-".$j2."</br>";
  echo "16-".$j3."</br>";
  echo "17-".$j4."</br>";
  echo "18-".$j5."</br>";
*/

?>

    <td width="264" align="center" valign="top"></td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
