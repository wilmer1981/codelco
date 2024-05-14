<?php 
$CodigoDeSistema = 1;
include("../principal/conectar_principal.php");

$SA      = isset($_REQUEST["SA"])?$_REQUEST["SA"]:"";
$Recargo = isset($_REQUEST["Recargo"])?$_REQUEST["Recargo"]:"";
$NombreF = isset($_REQUEST["NombreF"])?$_REQUEST["NombreF"]:"";
$TxtMuestra = isset($_REQUEST["TxtMuestra"])?$_REQUEST["TxtMuestra"]:"";
$TxtFechaMuestra = isset($_REQUEST["TxtFechaMuestra"])?$_REQUEST["TxtFechaMuestra"]:"";
$TxtProductos    = isset($_REQUEST["TxtProductos"])?$_REQUEST["TxtProductos"]:"";
$TxtLeyes  = isset($_REQUEST["TxtLeyes"])?$_REQUEST["TxtLeyes"]:"";
$TxtSALIMS = isset($_REQUEST["TxtSALIMS"])?$_REQUEST["TxtSALIMS"]:"";
$TxtSA     = isset($_REQUEST["TxtSA"])?$_REQUEST["TxtSA"]:"";
$TxtCCosto     = isset($_REQUEST["TxtCCosto"])?$_REQUEST["TxtCCosto"]:"";
$TxtAgrupacion     = isset($_REQUEST["TxtAgrupacion"])?$_REQUEST["TxtAgrupacion"]:"";
$TxtArea     = isset($_REQUEST["TxtArea"])?$_REQUEST["TxtArea"]:"";
$TxtAnalisis     = isset($_REQUEST["TxtAnalisis"])?$_REQUEST["TxtAnalisis"]:"";
$TxtTipo     = isset($_REQUEST["TxtTipo"])?$_REQUEST["TxtTipo"]:"";
$TxtFechaC     = isset($_REQUEST["TxtFechaC"])?$_REQUEST["TxtFechaC"]:"";
$TxtAnalisis     = isset($_REQUEST["TxtAnalisis"])?$_REQUEST["TxtAnalisis"]:"";
$TxtAnalisis     = isset($_REQUEST["TxtAnalisis"])?$_REQUEST["TxtAnalisis"]:"";




//CONSULTA DATOS BASE
$Consulta ="SELECT * ";
$Consulta = $Consulta." from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.centro_costo t2  ";
$Consulta = $Consulta." on t1.cod_ccosto = t2.centro_costo ";
$Consulta = $Consulta." left join proyecto_modernizacion.subproducto t3 on t1.cod_subproducto = t3.cod_subproducto ";
$Consulta = $Consulta." and t1.cod_producto = t3.cod_producto ";
if ($Recargo=='N')
{
	$Consulta = $Consulta." where t1.nro_solicitud ='".$SA."'  ";
}
else
{
	$Consulta = $Consulta." where t1.nro_solicitud ='".$SA."' and recargo ='".$Recargo."' ";
}
//echo $Consulta;

$Respuesta =mysqli_query($link, $Consulta);
if ($Row = mysqli_fetch_array($Respuesta))
{
	$TxtSA = $SA;

	$TxtSALIMS = $Row["nro_sa_lims"];
	if ($TxtSALIMS=='') {
		$TxtSALIMS=$TxtSA;
	}
	//echo $TxtSALIMS;
	$TxtProductos = $Row["descripcion"];
	$RutOriginador=$Row["rut_funcionario"];
	$TxtMuestra   = $Row["id_muestra"];
	if(isset($Row["nro_lote"])){
		$TxtLotes = $Row["nro_lote"];
	}else{
		$TxtLotes = "";
	}
	

	$TxtCCosto = $Row["descripcion"];
	$Consulta = "SELECT * from sub_clase where cod_clase = 1002 and cod_subclase = ".$Row["estado_actual"];

	$Respuesta2 = mysqli_query($link, $Consulta);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$TxtEstado = ucwords(strtolower($Row2["nombre_subclase"]));
	else 	$TxtEstado = " ";	
	$TxtFechaC = substr($Row["fecha_hora"],8,2)."-".substr($Row["fecha_hora"],5,2)."-".substr($Row["fecha_hora"],0,4)." ".substr($Row["fecha_hora"],12);
	$Consulta = "SELECT * from proyecto_modernizacion.funcionarios where rut = '".$Row["rut_funcionario"]."'";
	$Respuesta2 = mysqli_query($link, $Consulta);
	//$NombreF = "";
	if ($Row2 = mysqli_fetch_array($Respuesta2))
	{
		$NombreF = ucwords(strtolower($Row2["apellido_paterno"]))." ".ucwords(strtolower($Row2["apellido_materno"]))." ".ucwords(strtolower($Row2["nombres"]));
	}
}
//Consulta leyes
$Consulta ="SELECT distinct(t2.cod_leyes), t3.tipo_leyes, t3.abreviatura ";
$Consulta = $Consulta."from cal_web.leyes_por_solicitud t2 left join proyecto_modernizacion.leyes t3  ";
$Consulta = $Consulta."on t2.cod_leyes = t3.cod_leyes ";
if ($Recargo=='N')
{
	$Consulta = $Consulta."where t2.nro_solicitud ='".$SA."'";
}
else
{
	$Consulta = $Consulta."where t2.nro_solicitud ='".$SA."'and recargo= '".$Recargo."' ";
}
//echo $Consulta; 
$Respuesta =mysqli_query($link, $Consulta);
$Ley ="";
$Impurezas ="";
while ($Fila =mysqli_fetch_array($Respuesta))
{
	//$CCosto=$Fila["centro_costo"].' '.$Fila["descripcion"];
	if(isset($Fila["centro_costo"]) and isset($Fila["descripcion"]) ){
		$CCosto=$Fila["centro_costo"].' '.$Fila["descripcion"];
	}else{
		$CCosto="";
	}
	
	if (($Fila["tipo_leyes"] == '0') || ($Fila["tipo_leyes"] == '3'))
	{
		$Ley = $Ley.$Fila ["abreviatura"].'-';
	}
	if ($Fila["tipo_leyes"] == '1') 
	{
		$Impurezas = $Impurezas.$Fila["abreviatura"].'-'; 
	}
}	
$TxtLeyes = $Ley;
$TxtImpurezas = $Impurezas;
//Consulta que devuelve la observacion asociada al numero de solicitud
$Consulta = "SELECT observacion,recargo,nro_solicitud from  cal_web.solicitud_analisis t1";
if ($Recargo=='N')
{
	$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
}
else
{
	$Consulta = $Consulta." where nro_solicitud ='".$SA."' and recargo ='".$Recargo."' "; 
}
$Respuesta3 = mysqli_query($link, $Consulta); 
if ($Fila3=mysqli_fetch_array($Respuesta3))
{
	
	$Observacion = $Fila3["observacion"];
}
 
 
  
?>
<html>
<head>
<title>Detalle de Solicitudes Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script language="JavaScript">
function Salir()
{
	var f = document.FrmDetalle;
	frm.action="cal_adm_ingreso_leyes01.php?Opcion=S";
	frm.submit(); 
}
function ImprimirEtiqueta(Rut)
{
	var frm=document.FrmDetalle;
	var ValoresSA="";
	var Recargo ="";
	
	if (frm.TxtRecargo.value=="")
	{
		Recargo="N";
	}
	else
	{
		Recargo="M";
	}
	ValoresSA=frm.TxtSA.value + "~~" + Rut + "||" + Recargo + "//" ;
	window.open("cal_imprimir_etiqueta.php?SA="+ ValoresSA,"","top=50px,left=50px,width=500px,height=400px,scrollbars=yes,resizable = yes");					

}
function Imprimir()
{
	var f =document.FrmDetalle;
	window.print();
}
</script>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmDetalle" method="post" action="">
<?php  include("../principal/encabezado.php");?>
  <table width="774"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="762" align="center"><table width="744"  border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr> 
            <td width="738"><div align="center"><strong>DETALLE SOLICITUDES Y 
                REGISTRO DE MOVIMIENTOS DE LEYES</strong></div></td>
          </tr>
        </table>
        <br>
        <table width="751"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="84"><strong>Originador </strong></td>
            <td><strong> 
              <?php
		
		echo "<div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:250' maxlength='120' value ='".$NombreF."'></div>";
	  ?>
              </strong></td>
            <td><strong>N&deg; SA Lims</strong></td>
            <td><input name='TxtSALIMS' type='text' readonly    style='width:105' value='<?php  echo $TxtSALIMS  ?>'>
            	<strong>N&deg; CAL</strong>
            	<input name='TxtSA' type='text' readonly    style='width:104' value='<?php  echo $TxtSA  ?>'>
            </td>

             
          </tr>

          <tr> 
            <td><strong>Id Muestra</strong></td>
            <td width="268"><input name="TxtMuestra" type="text" readonly style='width:250' id="TxtMuestra" value="<?php  echo $TxtMuestra ?>"> 
            </td>
            <td width="97"><strong> Recargo</strong></td>
            <?php
	  		if ($Recargo =='N')
	  		{
	  			$Rec=' ';	
	  		}
			else
			{
				$Rec=$Recargo;
			}
	  		?>
            <td width="275"><input name="TxtRecargo" type="text" readonly style='width:250' id="TxtRecargo" value="<?php echo $Rec ?>"></td>
          </tr>

          <tr> 
            <td><strong>Fecha Muestra</strong></td>
            <td><strong> 
              <?php
	     	  $Consulta = "SELECT * from cal_web.solicitud_analisis ";
			  if ($Recargo=='N')
			  {
			  	$Consulta.=" where nro_solicitud = '".$SA."' ";
			  }
			  else
			  {
			  	$Consulta.=" where nro_solicitud = '".$SA."' and recargo= '".$Recargo."' ";
			  }
			  $Respuesta41 = mysqli_query($link, $Consulta);
			  if ($Fila41=mysqli_fetch_array($Respuesta41))
			  {
			  	$TxtFechaMuestra = $Fila41["fecha_muestra"];
			  }
			  ?>
              <input name="TxtFechaMuestra" type="text" id="TxtProductos3" readonly style='width:250' value="<?php echo $TxtFechaMuestra ?>">
              </strong></td>
            <td><strong>Agrupacion</strong></td>
            <?php
			 /*	if($TxtRecargo =='1')
				{
					$TxtRecargo='';
				} */
			 ?>
            <td><strong> 
              <?php
				$Consulta ="SELECT distinct t2.nombre_subclase from cal_web.solicitud_analisis t1";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.agrupacion = t2.cod_subclase and t2.cod_clase = '1004'  ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud ='".$SA."' and recargo = '".$Recargo."'"; 
				}
				$Resp = mysqli_query($link, $Consulta); 
				$Fila25=mysqli_fetch_array($Resp);
				$TxtAgrupacion = isset($Fila25["nombre_subclase"])?$Fila25["nombre_subclase"]:"";

			
			?>
              <input name="TxtAgrupacion" type="text" readonly style="width:250" value="<?php  echo $TxtAgrupacion  ?>">
              </strong></td>
          </tr>
          <tr> 
            <td><strong>Sub Producto</strong></td>
            <td><strong> 
              <input name="TxtProductos" type="text" id="TxtProductos2" readonly style='width:250' value="<?php echo $TxtProductos ?>">
              </strong></td>
            <td><strong>CentroCosto</strong></td>
            <td><strong> 
              <input name="TxtCCosto" type="text" style='width:250'  readonly id="TxtCCosto3" value="<?php echo $TxtCCosto?>">
              </strong></td>
          </tr>
          <tr> 
            <td><strong>Leyes</strong></td>
            <td><strong> 
              <input name="TxtLeyes" type="text" id="TxtLeyes2" readonly style='width:250' value="<?php echo $TxtLeyes ?>">
              </strong></td>
            <td><strong>Area</strong></td>
            <td><strong> 
              <?php
			$Consulta="SELECT t2.nombre_subclase from cal_web.solicitud_analisis t1 ";
			$Consulta= $Consulta." inner join  proyecto_modernizacion.sub_clase t2   ";
			$Consulta= $Consulta." on t1.cod_area = t2.cod_subclase and cod_clase ='3' ";
			$Consulta= $Consulta."  where nro_solicitud ='".$SA."'  ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila50=mysqli_fetch_array($Respuesta);
			$TxtArea=isset($Fila50["nombre_subclase"])?$Fila50["nombre_subclase"]:"";
			?>
              <input name="TxtArea" type="text" style='width:250'  readonly id="TxtArea3" value="<?php echo $TxtArea;?>">
              </strong></td>
          </tr>
          <tr> 
            <td height="24"><strong>Impurezas</strong></td>
            <td><strong> 
              <input name="TxtImpurezas" type="text" style='width:250' readonly value="<?php echo $TxtImpurezas?>">
              </strong></td>
            <td><strong>Tipo Analisis</strong></td>
            <td><strong> 
              <?php
				$Consulta ="SELECT distinct t2.nombre_subclase from cal_web.solicitud_analisis t1";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.cod_analisis = t2.cod_subclase and t2.cod_clase = '1000'  ";
				$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
				$Respuesta3 = mysqli_query($link, $Consulta); 
				$Fila3=mysqli_fetch_array($Respuesta3);
				$TxtAnalisis = isset($Fila3["nombre_subclase"])?$Fila3["nombre_subclase"]:"";			
			?>
              <input name="TxtAnalisis" type="text" readonly style="width:250" value="<?php  echo $TxtAnalisis  ?>">
              </strong></td>
          </tr>
          <tr> 
            <td height="26"><strong>Periodo</strong></td>
            <td><strong> 
              <?php
			$Consulta ="SELECT t1.cod_periodo,t1.fecha_muestra,t1.año,t1.mes,t1.nro_semana,t2.nombre_subclase as estado from cal_web.solicitud_analisis t1 ";
			$Consulta =$Consulta." inner join proyecto_modernizacion.sub_clase t2 on t1.cod_periodo = t2.cod_subclase and cod_clase = 2  "; 
			$Consulta =$Consulta. " where t1.nro_solicitud = '".$SA."' ";
			//echo $Consulta."<br>";
			$Respuesta40 =mysqli_query($link, $Consulta);
			if ($Fila40=mysqli_fetch_array($Respuesta40))  
			{
				switch ($Fila40["cod_periodo"])
				{
				//HOY
				case "1":
					$PeriodoH= $Fila40["estado"];
					echo "<input name='TxtPeriodoSemanal' type='text' readonly style='width:250' value='".$PeriodoH."' >";
					break;	
				//Semanal
				case "2":
					$PeriodoS=$Fila40["estado"].','."N� Semana"." ".$Fila40["nro_semana"];
					echo "<input name='TxtPeriodoSemanal' type='text' readonly style='width:250' value='".$PeriodoS."' >";
					break;
				//Mensual
				case "3":
					$PeriodoM=$Fila40["estado"].','."Mes ".$Fila40["mes"]; 		
					echo "<input name='TxtMensual' type='text' readonly style='width:250' value='".$PeriodoM."' >";
					break;
				case "4":
				 	$PeriodoT=$Fila40["estado"];
					echo "<input name='TxtMensual' type='text' readonly style='width:250' value='".$PeriodoT."' >";
					break;
				case "5":
					$PeriodoQ=$Fila40["estado"];
					echo "<input name='TxtMensual' type='text' readonly style='width:250' value='".$PeriodoQ."' >";
					break;
				}
			}
			?>
              </strong></td>
            <td><strong>Tipo</strong></td>
            <td><strong> 
              <?php
				$Consulta ="SELECT distinct t2.nombre_subclase from cal_web.solicitud_analisis t1";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.tipo = t2.cod_subclase and t2.cod_clase = '1005'  ";
				$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
				$Res = mysqli_query($link, $Consulta); 
				$Fil26=mysqli_fetch_array($Res);
				$TxtTipo = isset($Fil26["nombre_subclase"])?$Fil26["nombre_subclase"]:"";			
			?>
              <input name="TxtTipo" type="text" id="TxtTipo" style="width:250" value="<?php  echo $TxtTipo; ?>" readonly>
              </strong></td>
          </tr>
          <tr>
            <td height="30"><strong>Fecha At Mues</strong></td>
            <td><strong> 
              <?php
		   	$Consulta = "SELECT fecha_hora from cal_web.estados_por_solicitud t1 ";
		   	if ($Recargo=='N')
		   	{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."'  and cod_estado = '13' "; 
				
			}
		  	else
			{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and cod_estado = '13'"; 
			}
			$Respuesta =mysqli_query($link, $Consulta);
			$TxtFechaAt="";
			if ($Fila1=mysqli_fetch_array($Respuesta))
			{
				$TxtFechaAt = $Fila1["fecha_hora"];
			}
		  
		   ?>
              <input name="TxtFechaAt" type="text" style='width:250' id="TxtFechaAt2" value="<?php echo $TxtFechaAt ?>">
              </strong></td>
            <td><strong>Fecha Recep Lab</strong></td>
            <td><strong> 
              <?php
		   	$Consulta = "SELECT fecha_hora from cal_web.estados_por_solicitud t1 ";
		   	if ($Recargo=='N')
		   	{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and cod_estado = '4' "; 
				
			}
		  	else
			{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and cod_estado = '4'"; 
			}
			$Respuesta =mysqli_query($link, $Consulta);
			$TxtFechaRe="";
			if ($Fila1=mysqli_fetch_array($Respuesta))
			{
				$TxtFechaRe = $Fila1["fecha_hora"];
			}
		  
		   ?>
              <input name="TxtFechaC" type="text" style='width:250' value="<?php echo $TxtFechaRe ?>">
              </strong></td>
          </tr>
          <?php
			$Consulta = "SELECT * from cal_web.solicitud_analisis where nro_solicitud = '".$SA."' ";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($Fila["recargo"]=='R')
				{
					$TxtRetalla=$Fila["peso_muestra"]; 
					$TxtTamiz=$Fila["peso_retalla"];
					echo "<tr>";
           			 	echo "<td height='24'><strong>Peso Retalla</strong></td>";
            			echo "<td><strong>";
          				echo "<input name='TxtRetalla' type='text' readonly  style='width:250' value=' $TxtRetalla'>";
              			echo "</strong></td>";
            			echo "<td><strong>Peso Tamiz</strong></td>";
            			echo "<td><strong>";
              			echo "<input name='TxtTamiz' type='text' readonly  style='width:250' value='$TxtTamiz'>";
              			echo "</strong> </td>";
          			echo "</tr>";
				}
			}
			?>
        </table>
        <br>
        <table width="746" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="79"><div align="center">FUNCIONARIO</div></td>
            <td width="54"><div align="center">RECARGO</div></td>
            <td width="136"><div align="center">ESTADO</div></td>
            <td width="167"><div align="center">FECHA</div></td>
            <td width="277"><div align="center">Observacion</div></td>
          </tr>
          <?php
	   		//Consulta para los estados creados
	   		$Consulta =" SELECT distinct t1.recargo,t1.fecha_hora,t1.nro_solicitud, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
	   		$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;		
			if ($Recargo=='N')
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = '1') "; 
			}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = '1') and t1.recargo='".$Recargo."' "; 
			}
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			while($Fila= mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila["nombres"],0,1).".".$Fila["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila["recargo"]."'  ";
				}
				
				$Respuesta9 = mysqli_query($link, $Consulta); 	
				$Fila9 = mysqli_fetch_array($Respuesta9);
					echo "<td width = '277'><center>".$Fila9["observacion"]."</center></td>";
					echo "</tr>";
			}
			//Consulta para los estados directos a calidad
			$Consulta =" SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
			if ($Recargo=='N')
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = '12') "; 
			}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = '12') and (t1.recargo='".$Recargo."') "; 
			}
	   		$Respuesta2 = mysqli_query($link, $Consulta);
			while($Fila2= mysqli_fetch_array($Respuesta2))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila2["nombres"],0,1).".".$Fila2["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila2["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila2["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila2["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'  ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila2["recargo"]."'  ";
				}
				$Respuesta10 = mysqli_query($link, $Consulta); 	
				$Fila10 = mysqli_fetch_array($Respuesta10);
				echo "<td width = '277'><center>".$Fila10["observacion"]."</center></td>";
				echo "</tr>";
			}
			//consulta para los estados recepcionados en control de calidad
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
			if ($Recargo=='N')
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 2  "; 
			}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 2) and t1.recargo = '".$Recargo."'  "; 
			}
	   		$Respuesta1 = mysqli_query($link, $Consulta);
			while($Fila1= mysqli_fetch_array($Respuesta1))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila1["nombres"],0,1).".".$Fila1["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila1["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila1["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila1["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila1["recargo"]."'  ";
				}
				$Respuesta11 = mysqli_query($link, $Consulta); 	
				$Fila11 = mysqli_fetch_array($Respuesta11);
				echo "<td width = '277'><center>".$Fila11["observacion"]."</center></td>";
				echo "</tr>";
			} 
			//consulta para los estados atendidos en muestrera
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
			if ($Recargo=='N')
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 13  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 13) and (t1.recargo='".$Recargo."')  "; 
			}
			$Respuesta3 = mysqli_query($link, $Consulta);
			while($Fila3= mysqli_fetch_array($Respuesta3))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila3["nombres"],0,1).".".$Fila3["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila3["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila3["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila3["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'  ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila3["recargo"]."'  ";
				}
				$Respuesta12 = mysqli_query($link, $Consulta); 	
				$Fila12 = mysqli_fetch_array($Respuesta12);
				echo "<td width = '277'><center>".$Fila12["observacion"]."</center></td>";
				echo "</tr>";
			} 
			//consulta para los estados pendientes
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{				
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 8  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 8) and (t1.recargo='".$Recargo."')  "; 
			}		
			$Respuesta5 = mysqli_query($link, $Consulta);
			while($Fila5= mysqli_fetch_array($Respuesta5))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila5["nombres"],0,1).".".$Fila5["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila5["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila5["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila5["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila5["recargo"]."'  ";
				}
				$Respuesta13 = mysqli_query($link, $Consulta); 	
				$Fila13 = mysqli_fetch_array($Respuesta13);
				echo "<td width = '277'><center>".$Fila13["observacion"]."</center></td>";
				echo "</tr>";
			} 
			//consulta para los estados activados
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 14  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 14) and t1.recargo='".$Recargo."'  "; 
			}		
			$Respuesta9 = mysqli_query($link, $Consulta);
			while($Fila9= mysqli_fetch_array($Respuesta9))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila9["nombres"],0,1).".".$Fila9["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila9["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila9["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila9["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila9["recargo"]."'  ";
				}	
				$Respuesta14 = mysqli_query($link, $Consulta); 	
				$Fila14 = mysqli_fetch_array($Respuesta14);
				echo "<td width = '277'><center>".$Fila14["observacion"]."</center></td>";
				echo "</tr>";
			} 
			
			//consulta para los estados salidad de muestreara o enviado al laboratoriuo
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 3  "; 
			}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 3) and (t1.recargo='".$Recargo."') "; 
			}
			$Respuesta4 = mysqli_query($link, $Consulta);
			while($Fila4= mysqli_fetch_array($Respuesta4))
			{
				echo "<tr>";
				$SubClase=$Fila4["nombre_subclase"]." a Laboratorio";
				echo "<td width = '79'><center>".substr($Fila4["nombres"],0,1).".".$Fila4["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila4["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$SubClase."</center></td>";
				echo "<td width = '160'><center>".$Fila4["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila4["recargo"]."'  ";
				}
				$Respuesta15 = mysqli_query($link, $Consulta); 	
				$Fila15 = mysqli_fetch_array($Respuesta15);
				echo "<td width = '277'><center>".$Fila15["observacion"]."</center></td>";
				echo "</tr>";
			} 
			//Consulta para los estados Elimnada
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 7  "; 
			}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 7)and t1.recargo='".$Recargo."'  "; 
			}
			//echo $Consulta;
			$Respuesta30 = mysqli_query($link, $Consulta);
			while($Fila30= mysqli_fetch_array($Respuesta30))
			{
				echo "<tr>";
				$SubClase=$Fila30["nombre_subclase"];
				echo "<td width = '79'><center>".substr($Fila30["nombres"],0,1).".".$Fila30["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila30["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$SubClase."</center></td>";
				echo "<td width = '160'><center>".$Fila30["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'  ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila4["recargo"]."'  ";
				}
				$Respuesta31 = mysqli_query($link, $Consulta); 	
				$Fila31 = mysqli_fetch_array($Respuesta31);
				echo "<td width = '277'><center>".$Fila31["observacion"]."</center></td>";
				echo "</tr>";
			} 
			//consulta para cuando se recibe en control de calidad
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 4  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 4) and t1.recargo='".$Recargo."'  "; 
			}		
			$Respuesta6 = mysqli_query($link, $Consulta);
			while($Fila6= mysqli_fetch_array($Respuesta6))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila6["nombres"],0,1).".".$Fila6["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila6["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila6["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila6["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila6["recargo"]."'  ";
				}
				$Respuesta16 = mysqli_query($link, $Consulta); 	
				$Fila16 = mysqli_fetch_array($Respuesta16);
				echo "<td width = '277'><center>".$Fila16["observacion"]."</center></td>";
				echo "</tr>";
			}			
			//consulta para cuando se atiende por el quimico
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 5  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 5)and t1.recargo ='".$Recargo."'  "; 
			}		
			//echo $Consulta."<br>";		
			$Respuesta7 = mysqli_query($link, $Consulta);
			while($Fila7= mysqli_fetch_array($Respuesta7))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila7["nombres"],0,1).".".$Fila7["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila7["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila7["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila7["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila7["recargo"]."'  ";
				}
				//echo $Consulta."<br>";
				$Respuesta17 = mysqli_query($link, $Consulta); 	
				$Fila17 = mysqli_fetch_array($Respuesta17);
				
				echo "<td width = '277'><center>".$Fila17["observacion"]."</center></td>";
				echo "</tr>";
			}	
			//consulta para cuando se encuentra finalizada
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 6  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 6) and t1.recargo='".$Recargo."' "; 
			}		
			//echo $Consulta."<br>";		
			$Respuesta8 = mysqli_query($link, $Consulta);
			while($Fila8= mysqli_fetch_array($Respuesta8))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila8["nombres"],0,1).".".$Fila8["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila8["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila8["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila8["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila8["recargo"]."'  ";
				}
				$Respuesta18 = mysqli_query($link, $Consulta); 	
				$Fila18 = mysqli_fetch_array($Respuesta18);
				echo "<td width = '277'><center>".$Fila18["observacion"]."</center></td>";
				echo "</tr>";
			}
			//consulta para los estados anulados
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = 16  "; 
			}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = 16)and t1.recargo='".$Recargo."'  "; 
			}
			$Respuesta4 = mysqli_query($link, $Consulta);
			while($Fila4= mysqli_fetch_array($Respuesta4))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila4["nombres"],0,1).".".$Fila4["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila4["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila4["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila4["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila4["recargo"]."'  ";
				}
				$Respuesta19 = mysqli_query($link, $Consulta); 	
				$Fila19 = mysqli_fetch_array($Respuesta19);
				echo "<td width = '277'><center>".$Fila19["observacion"]."</center></td>";
				echo "</tr>";
			}
			//consulta para los estados creados por el laboratirio frx 
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = '31'  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = '31') and t1.recargo='".$Recargo."' "; 
			}		
			$Respuesta30 = mysqli_query($link, $Consulta);
			while($Fila30= mysqli_fetch_array($Respuesta30))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila30["nombres"],0,1).".".$Fila30["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila30["recargo"]."</center></td>";
				echo "<td width = '130'><center>Creada</center></td>";
				echo "<td width = '160'><center>".$Fila30["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{	
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'  ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila30["recargo"]."'  ";
				}
				$Respuesta31 = mysqli_query($link, $Consulta); 	
				$Fila31 = mysqli_fetch_array($Respuesta31);
				echo "<td width = '277'><center>".$Fila31["observacion"]."</center></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila30["nombres"],0,1).".".$Fila30["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila30["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila30["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila30["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'  ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila30["recargo"]."'  ";
				}
				$Respuesta32 = mysqli_query($link, $Consulta); 	
				$Fila32 = mysqli_fetch_array($Respuesta32);
				echo "<td width = '277'><center>".$Fila32["observacion"]."</center></td>";
				echo "</tr>";
			}
			//consulta para los estados atendidos por el laboratirio frx 
			$Consulta ="SELECT distinct t1.recargo,t1.fecha_hora, t1.cod_estado,t2.apellido_paterno,t2.nombres,t3.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			$Consulta = $Consulta." left join proyecto_modernizacion.funcionarios t2  on t1.rut_proceso = t2.rut ";
			$Consulta = $Consulta."  inner join proyecto_modernizacion.sub_clase t3 on t1.cod_estado = t3.cod_subclase and t3.cod_clase = '1002'";		
			$Consulta = $Consulta."  inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud " ;				
	   		if ($Recargo=='N')
			{		
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and t1.cod_estado = '32'  "; 
	   		}
			else
			{
				$Consulta = $Consulta."  where (t1.nro_solicitud = '".$SA."') and (t1.cod_estado = '32')and t1.recargo='".$Recargo."'  "; 
			}		
			$Respuesta30 = mysqli_query($link, $Consulta);
			while($Fila30= mysqli_fetch_array($Respuesta30))
			{
				echo "<tr>";
				echo "<td width = '79'><center>".substr($Fila30["nombres"],0,1).".".$Fila30["apellido_paterno"]."</center></td>";
				echo "<td width = '60'><center>".$Fila30["recargo"]."</center></td>";
				echo "<td width = '130'><center>".$Fila30["nombre_subclase"]."</center></td>";
				echo "<td width = '160'><center>".$Fila30["fecha_hora"]."</center></td>";
				$Consulta ="SELECT  observacion  from cal_web.solicitud_analisis ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."'   ";
				}
				else
				{
					$Consulta = $Consulta." where nro_solicitud = '".$SA."' and recargo = '".$Fila30["recargo"]."'  ";
				}
				$Respuesta31 = mysqli_query($link, $Consulta); 	
				$Fila31 = mysqli_fetch_array($Respuesta31);
				echo "<td width = '277'><center>".$Fila31["observacion"]."</center></td>";
				echo "</tr>";
			}
			?>
        </table>
        <br>
        <br>
        <table width="746" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="100"><div align="center"><strong>FUNCIONARIO</strong></div></td>
            <td width="104"><div align="center"><strong>FECHA</strong></div></td>
            <td width="74"><div align="center"><strong>RECARGO</strong></div></td>
            <td width="34"><div align="center"><strong>LEY</strong></div></td>
            <td width="63"><div align="center"><strong>VALOR</strong></div></td>
            <td width="69"><strong>P. HUM.</strong></td>
            <td width="71"><div align="center"><strong>P. SECO</strong></div></td>
            <td width="77"><div align="center"><strong>UNIDAD</strong></div></td>
            <td width="97"><div align="center"><strong>CANDADO</strong></div></td>
          </tr>
          <?php	
	$Consulta = "SELECT * from cal_web.registro_leyes ";
	if($Recargo == 'N')
	{
		$Consulta.=" where nro_solicitud = ".$SA." ORDER BY fecha_hora, recargo, cod_leyes";
	}
	else
	{
		$Consulta.=" where nro_solicitud = ".$SA." and recargo =".$Recargo." ORDER BY fecha_hora, recargo, cod_leyes";
	}
	echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		if ($Row["rut_funcionario"] == "00000000-1")
		{
			echo "<td>Espectrografo Num. 1</td>\n";
		}
		else
		{
			if ($Row["rut_funcionario"] == "00000000-2")
			{
				echo "<td>Espectrografo Num. 2</td>\n";
			}
			else
			{
				$Consulta = "SELECT concat(left(nombres,1),'. ',apellido_paterno) as nombre from proyecto_modernizacion.funcionarios where rut = '".$Row["rut_proceso"]."'";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Row2 = mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='center'>".ucwords(strtolower($Row2["nombre"]))."&nbsp;</td>\n";
				}	
				else
				{
					echo "<td>".$Row["rut_proceso"]."&nbsp;</td>\n";
				}
			}
		}
		echo "<td align='left'>".$Row["fecha_hora"]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row["recargo"]."&nbsp;</td>\n";
		$Consulta = "SELECT * from proyecto_modernizacion.leyes where cod_leyes = '".$Row["cod_leyes"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Respuesta2))
			echo "<td align='center'>".$Row2["abreviatura"]."</td>\n";
		else
			if($Row["cod_leyes"]=='PES.RET'||$Row["cod_leyes"]=='PES.TAM')//PESO RETALLA O PESO TAMIZ
				echo "<td align='center'>".$Row["cod_leyes"]."</td>\n";
			else
				echo "<td align='right'>&nbsp;</td>\n";
		/////////////////////////
		switch($Row["signo"])
		{
			case "N":
				$Valor = 'ND';
				$Signo = "";
				break;
			case "A":	
				$Valor = 'Nueva';
				$Signo = "";
				break;
			case "M":	
				$Valor = 'Modif.';
				$Signo = "";
				break;
			case "E":	
				$Valor = 'Elim.';
				$Signo = "";
				break;
			default:
				if ((is_null($Row["valor"]))|| ($Row["valor"] ==''))
				{
					$Valor = "";
					$Signo = "";
				}	
				else
				{
					if ($Row["signo"]=='=')
					{
						$Signo="";	
					}
					else
					{
						$Signo=$Row["signo"];
					}
					$Valor=$Signo." ".$Row["valor"];
				}
				break;
		}
		echo "<td align='center'>".$Valor."&nbsp;</td>\n";
		//echo "<td align='center'>".$Row["valor"]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row["peso_humedo"]."</td>\n";
		echo "<td align='center'>".$Row["peso_seco"]."</td>\n";
		$Consulta = "SELECT * from proyecto_modernizacion.unidades where cod_unidad = '".$Row["cod_unidad"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Respuesta2))
			echo "<td align='center'>".$Row2["abreviatura"]."</td>\n";
		else	echo "<td align='center'>&nbsp;</td>\n";
		if ($Row["candado"] == '0')
			echo "<td align='center'><img src='../principal/imagenes/cand_abierto.gif'></td>\n";
		else	
			if($Row["candado"] == '1')
				echo "<td align='center'><img src='../principal/imagenes/cand_cerrado.gif'></td>\n";	
			else
				echo "<td align='center'>&nbsp;</td>\n";	
		echo "</tr>\n";
	}
?>
        </table>
        <br>
        <table width="745"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="736" height="26"><div align="center">
                <input name="BtnImprimir" type="button" id="BtnImprimir2" value="Imprimir" onClick='JavaScript:Imprimir();'>
                &nbsp;<font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="BtnImprimir2" type="button" id="BtnImprimir23" value="Etiqueta" onClick="ImprimirEtiqueta('<?php echo $RutOriginador;?>');">
                </font></font> &nbsp; 
                <input name="BtnSalir" type="button" value="Cerrar" style="width:70" onClick="window.close()">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
