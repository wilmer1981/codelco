<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 3;
	
function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4);
		return $fecha;
	}	
	
function BuscaDia($valor,$fecha)
   {
     /**********************************Selecciona dia de la consulta******************************************************/
	  $Dia="select subdate('".$fecha."',interval '".$valor."' day) as fecha_ant";
	  $rs_dia = mysqli_query($link, $Dia);
	  $row_f = mysqli_fetch_array($rs_dia);
	/**********************************************************************************************************************/
      return $row_f[fecha_ant];   
   }
   
function OcupadosEnRenovacion($fecha)
   {
     $Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	 $Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	 $Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."' group by t1.cod_grupo";
	 $Respuesta = mysqli_query($link, $Consulta);
	 $total_prod=0;
	 $total_rec=0;
	 $total_rech=0;
	 $total_cuba=0;
	 $cont=0;
	 $i=0;
	 while ($Fila = mysqli_fetch_array($Respuesta))
	   {  
		 $cont=$cont+1;
		 $grupos[$i]=$Fila["cod_grupo"];
		 $i=$i+1;
	   }
	 reset ($grupos);
	 $total_consumo_total=0;
	 $total_A=0;
	 $total_B=0;
	 $total_dp=0;
	 $total_ew=0;
	 $total_normal_grupo=0;	
	 while (list($a,$b)=each($grupos))
	   { $Dia_r=substr($fecha,8,2);
	 	 $Mes_r=substr($fecha,5,2);
		 $Ano_r=substr($fecha,0,4);
		 $fecha_renovacion=$Ano_r.'-'.$Mes_r.'-01';
		 $consulta_datos="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
		 $consulta_datos.="where fecha_renovacion='".$fecha_renovacion."' ";
		 $consulta_datos.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and (cod_concepto='A' or cod_concepto='B')";
		 $Resp_datos = mysqli_query($link, $consulta_datos);
		 if ( $row_datos = mysqli_fetch_array($Resp_datos))
		   {  
		     $consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='$b'";
			 $respuesta_fecha=mysqli_query($link, $consulta_fecha);
			 $row_fecha = mysqli_fetch_array($respuesta_fecha);
			 $consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
			 $consulta_datos_grupo.=" where fecha ='".$row_fecha["fecha"]."' and cod_grupo='$b'";
			 $respuesta_datos_grupo=mysqli_query($link, $consulta_datos_grupo);
			 $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
			 if ($row_datos[cod_concepto]=='A')
				{
				  $total_A=$total_A+((($row_datos_grupo[num_cubas_tot]-$row_datos_grupo[hojas_madres])-$row_datos_grupo[cubas_descobrizacion])*$row_datos_grupo[num_catodos_celdas]);
			    }
			 else if ($row_datos[cod_concepto]=='B')
				    {
						$total_B=$total_B + ((($row_datos_grupo[num_cubas_tot]-$row_datos_grupo[hojas_madres]) -$row_datos_grupo[cubas_descobrizacion])*$row_datos_grupo[num_catodos_celdas]);         
				    }
		  }
		$consulta_desc="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
		$consulta_desc.="where fecha_renovacion='".$fecha_renovacion."' ";
		$consulta_desc.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and desc_parcial<>'' ";
		$respuesta_desc=mysqli_query($link, $consulta_desc);
		if ($row_desc = mysqli_fetch_array($respuesta_desc))
			{
			  $consulta_dp="select num_celdas_grupos,num_catodos_celda from ref_web.circuitos_especiales where cod_circuito='DP'";
			  $respuesta_dp=mysqli_query($link, $consulta_dp);
			  $row_dp = mysqli_fetch_array($respuesta_dp);
			  $total_dp=$total_dp+($row_dp[num_celdas_grupos]*$row_dp[num_catodos_celda]);
			}
		$consulta_ew="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
		$consulta_ew.="where fecha_renovacion='".$fecha_renovacion."' ";
		$consulta_ew.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and electro_win<>'' ";
		$respuesta_ew=mysqli_query($link, $consulta_ew);
		if ($row_desc = mysqli_fetch_array($respuesta_ew))
		   {
			  $consulta_ew_d="select num_celdas_grupos,num_catodos_celda from ref_web.circuitos_especiales where cod_circuito='EW'";
			  $respuesta_ew_d=mysqli_query($link, $consulta_ew_d);
			  $row_ew_d = mysqli_fetch_array($respuesta_ew_d);
			  $total_ew=$total_ew+($row_ew_d[num_celdas_grupos]*$row_ew_d[num_catodos_celda]);
		   }
	}
	$consulta_desc="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
	$consulta_desc.="where fecha_renovacion='".$fecha_renovacion."' ";
	$consulta_desc.="and dia_renovacion='".$Dia_r."' and cod_concepto='D' and cod_grupo<>'' ";
	$respuesta_desc=mysqli_query($link, $consulta_desc);
	while ($row_desc = mysqli_fetch_array($respuesta_desc))
		{
		    $consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='".$row_desc["cod_grupo"]."'";
		    $respuesta_fecha=mysqli_query($link, $consulta_fecha);
		    $row_fecha = mysqli_fetch_array($respuesta_fecha);
			$consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
			$consulta_datos_grupo.=" where fecha<='".$row_fecha["fecha"]."' and cod_grupo='".$row_desc["cod_grupo"]."'";
			$respuesta_datos_grupo=mysqli_query($link, $consulta_datos_grupo);
			$row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
			$total_normal_grupo=$total_normal_grupo+($row_datos_grupo[cubas_descobrizacion] * $row_datos_grupo[num_catodos_celdas]);
		}
	$total_consumo_total=0;
	$total_consumo_total=$total_A + $total_B + $total_normal_grupo + $total_ew + $total_dp;
    return $total_consumo_total;   
 }   	
?>

<html>
<head>
<title>Control Diario de Laminas Iniciales y Catodos Iniciales</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
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
			valores = valores + f.checkbox[i].value + '~';
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
//	linea = linea + "&dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value;
//	linea = linea + "&dia2=" + f.dia2.value + "&mes2=" + f.mes2.value + "&ano2=" + f.ano2.value;
	if (opc == 'M')
	{
		cantidad = CantidadChecheado(f);
		if (cantidad == 1)
		{
			valor = ValorCheckBox(f).split('/');
			
			linea = linea + "&fecha=" + valor[0];
			
		}
		else if (cantidad == 0)
		{
			alert("Debe Selecionar Una Casilla para Modificar");
			return;
		}
		else
		{
			alert("Hay m�s de Una Casilla Marcada");
			return;
		}
	}	
		
	window.open("Detalle_hojas_madres_rechazo_proceso.php?" + linea+"&checkbox=0","","top=80,left=180,width=500,height=600,scrollbars=no,resizable = no");
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
		if (confirm("Esta Seguro de Eliminar los detalles de rechazo seleccionados"))
		{
			f.action = "proceso01.php?proceso=E&parametros=" + valores;
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
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
/*****************/
function Recarga()
{
	
	document.frmPrincipal.action = "ref_control diario_laminas_inic.php";
	document.frmPrincipal.submit();
}
</script>
</head>
<BODY background="../principal/imagenes/fondo3.gif" >

<form name="frmPrincipal" action="" method="post">
         
  <p align="center"><font color="#0000FF"><strong><font size="-6">Control Diario 
    de Laminas Iniciales y Catodos Iniciales</font></strong></font>
  </p>
  <tr> 
    <td width="988" height="200" align="center" valign="top"><table width="988" height="67" border="0" class="TablaInterior">
        <tr> 
         
		  <?php
		  
          //aqui saque el dia a pedido de Luis Farias <td width="28%"><select name="DiaIni" style="width:50px;">?>
              <?php
			  /*
						for ($i = 1;$i <= 31; $i++)
						{
							if (isset($DiaIni))
							{
								if ($DiaIni == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("j"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
						*/
					  ?>
		  <td width="50%">Fecha a Consultar :&nbsp;
   
            </select> <select name="MesIni" style="width:90px;">
              <?php    
						for ($i = 1;$i <= 12; $i++)
						{$Meses=array('Enero','Febrero','Marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
							if (isset($MesIni))
							{
								if ($MesIni == $i)
									echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
							}
							else
							{
								if ($i == date("n"))
									echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
							}
						}
						?>
            </select> <select name="AnoIni" style="width:60px;">
              <?php
						for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
						{
							if (isset($AnoIni))
							{
								if ($AnoIni == $i)
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
		
           </select>
           <input name="BtnOK" type="button" id="BtnOK" value="Buscar" onClick="Recarga();"> </td>
          <td width="27%">&nbsp;   </td>
          <td width="28%">&nbsp;</td>
        </tr>
      </table> 
      <table width="988" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">
        <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
            <td width="82" height="20" rowspan="2" align="left"> Fecha</td>
            <td colspan="10" align="center"> Control Diario Laminas Iniciales</td>
        </tr>
          <tr class="ColorTabla01"> 
            <td width="82" align="center" bordercolor="#FFFFFF">Stock Dia</td>
            <td width="82" align="center" bordercolor="#FFFFFF">#cubas placas</td>
            <td width="82" align="center" bordercolor="#FFFFFF">Produccion Dia</td>
            <td width="82" align="center" bordercolor="#FFFFFF">Rechazo Dia</td>
            <td width="82" align="center" bordercolor="#FFFFFF">%Rechazo dia</td>
            <td width="82" align="center" bordercolor="#FFFFFF">Rechazo MFCI y MCO </td>
            <td width="82" align="center" bordercolor="#FFFFFF">Confeccion Cat. inicial </td>
            <td width="82" align="center" bordercolor="#FFFFFF">Confeccion Orejas</td>
            <td width="82" align="center" bordercolor="#FFFFFF">Peso Dia Produccion</td>
            <td width="82" align="center" bordercolor="#FFFFFF">Peso Promedio</td>
          </tr>
    </table>
        <table width="988" border="1" cellspacing="0" cellpadding="0" class="TablaInterior">
        <?php

    if (!isset($MesIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	$DiaIni = "01";
	/*if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
		echo "mes".$MesIni;*/
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	 	$FechaInicio = $AnoIni."-".$MesIni;

	
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
    $consulta_fecha="SELECT distinct fecha ";
	$consulta_fecha.=" FROM ref_web.detalle_iniciales "; 
	$consulta_fecha.=" where  substring(fecha,1,7) ='".$FechaInicio."' ";
	
	//$consulta_fecha.=" where fecha between '".$FechaInicio."' and '".$FechaTermino."' ";
	$rs = mysqli_query($link, $consulta_fecha);
	while ($row = mysqli_fetch_array($rs))
	      {
	 		echo '<tr>';
			echo '<td width="82" align="center" class="detalle01">'.FormatoFecha($row["fecha"]).'</td>';
			/**********************************Selecciona dia anterior al dia de inicio de la consulta*****************************/
			$fecha_anterior=BuscaDia(1,$row["fecha"]);
			/**********************************************************************************************************************/
			$consulta_grupo_hm="select valor_subclase1 as subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001'";
		    $rs_grupo_hm = mysqli_query($link, $consulta_grupo_hm);
			$produccion=0;
			$n_placas=0;
			$rechazo_hm=0;
			$produccion_actual=0;
			$n_placas_actual=0;
			$rechazo_hm_actual=0;
			while ($row_grupo_hm = mysqli_fetch_array($rs_grupo_hm))
			      {
   		   /**********************************consulta datos dia anterior****************************************************************************/
				    $consulta_fecha="select max(t1.fecha) as fecha from ref_web.grupo_electrolitico2 as t1 where t1.fecha <=  '".$fecha_anterior."' and t1.cod_grupo ='0".$row_grupo_hm[subclase1]."' group by t1.cod_grupo";
					$rs_fecha = mysqli_query($link, $consulta_fecha);
					$row_fecha = mysqli_fetch_array($rs_fecha);
		   /************************************consulta datos dia actual************************************************************************/	
					$consulta_fecha_actual="select max(t1.fecha) as fecha from ref_web.grupo_electrolitico2 as t1 where t1.fecha <=  '".$row["fecha"]."' and t1.cod_grupo ='0".$row_grupo_hm[subclase1]."' group by t1.cod_grupo";
					$rs_fecha_actual = mysqli_query($link, $consulta_fecha_actual);
					$row_fecha_actual = mysqli_fetch_array($rs_fecha_actual);
		   /************************************consulta datos dia anterior y calculo produccion dia anterior***************************************/	
				    $Consulta6 =  "select max(t1.fecha) as fecha,t1.cod_grupo,t1.cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 as t1 ";
					$Consulta6 = $Consulta6." where  t1.fecha = '".$row_fecha["fecha"]."' and t1.cod_grupo ='0".$row_grupo_hm[subclase1]."' group by t1.cod_grupo";
					$rs3 = mysqli_query($link, $Consulta6);
					$row3 = mysqli_fetch_array($rs3);
				    $produccion=$produccion+(($row3[hojas_madres]*$row3[num_catodos_celdas])*2); 
				    $n_placas=$n_placas+$row3[hojas_madres];
			/*************************************consulta datos dia actual y calculo produccion dia actual*************************************************************************/	
				    $Consulta6_actual =  "select max(t1.fecha) as fecha,t1.cod_grupo,t1.cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 as t1 ";
					$Consulta6_actual = $Consulta6_actual." where  t1.fecha = '".$row_fecha_actual["fecha"]."' and t1.cod_grupo ='0".$row_grupo_hm[subclase1]."' group by t1.cod_grupo";
					$rs3_actual = mysqli_query($link, $Consulta6_actual);
					$row3_actual = mysqli_fetch_array($rs3_actual);
				    $produccion_actual=$produccion_actual+(($row3_actual[hojas_madres]*$row3_actual[num_catodos_celdas])*2); 
				    $n_placas_actual=$n_placas_actual+$row3_actual[hojas_madres];
			/***************************************consulta y calcula el rechazo de hojas madres para el dia anterior**************************************************************/
					$consulta_rechazo_hm="select * from ref_web.produccion where fecha='".$fecha_anterior."' and cod_grupo='".$row_grupo_hm[subclase1]."'";
					$rs_rechazo_hm = mysqli_query($link, $consulta_rechazo_hm);
					$row_rechazo_hm = mysqli_fetch_array($rs_rechazo_hm);
					$rechazo_hm=$rechazo_hm+$row_rechazo_hm[rechazo_delgadas]+$row_rechazo_hm[rechazo_granuladas]+$row_rechazo_hm[rechazo_gruesas];
			/***************************************consulta y calcula el rechazo de hojas madres para el dia actual**************************************************************/					
				    $consulta_rechazo_hm_actual="select * from ref_web.produccion where fecha='".$row["fecha"]."' and cod_grupo='".$row_grupo_hm[subclase1]."'";
					$rs_rechazo_hm_actual = mysqli_query($link, $consulta_rechazo_hm_actual);
					$row_rechazo_hm_actual = mysqli_fetch_array($rs_rechazo_hm_actual);
					$rechazo_hm_actual=$rechazo_hm_actual+$row_rechazo_hm_actual[rechazo_delgadas]+$row_rechazo_hm_actual[rechazo_granuladas]+$row_rechazo_hm_actual[rechazo_gruesas];
				  }
			/************************************************calcula la produccion de maquinas mfci y mco para el dia anterior********************************************************/	  
			$consulta_mfci="select sum(produccion_mfci) as suma_mfci, sum(produccion_mco) as suma_mco from ref_web.iniciales where fecha='".$fecha_anterior."'";	  
			//echo $consulta_mfci;
			$rs_mfci = mysqli_query($link, $consulta_mfci);
			$row_mfci_ant = mysqli_fetch_array($rs_mfci);
			/************************************************calcula la produccion de maquinas mfci y mco para el dia actual********************************************************/	  
			$consulta_mfci_actual="select sum(produccion_mfci) as suma_mfci, sum(produccion_mco) as suma_mco from ref_web.iniciales where fecha='".$row["fecha"]."'";	  
			//echo $consulta_mfci_actual;
			$rs_mfci_actual = mysqli_query($link, $consulta_mfci_actual);
			$row_mfci_actual = mysqli_fetch_array($rs_mfci_actual);
		    /**********************************Consulta stock de catodos iniciales del dia anterior********************************/			
			$consulta_lam_ant="select * from ref_web.detalle_iniciales where fecha='".$fecha_anterior."' ";
			$rs_lam_ant = mysqli_query($link, $consulta_lam_ant);
			$row_lam_ant = mysqli_fetch_array($rs_lam_ant);
			if ($row_lam_ant[rechazo_lam_ini]=='')
			   { $row_lam_ant[rechazo_lam_ini]=0; }
			/**********************************Consulta stock de catodos iniciales del actual********************************/			
			$consulta_lam_actual="select * from ref_web.detalle_iniciales where fecha='".$row["fecha"]."' ";
			$rs_lam_actual = mysqli_query($link, $consulta_lam_actual);
			$row_lam_actual = mysqli_fetch_array($rs_lam_actual);
			if ($row_lam_actual[rechazo_lam_ini]=='')
			   { $row_lam_actual[rechazo_lam_ini]=0; }  
			/***********************************************************************************************************************/
			$consulta_stock_ant="select * from ref_web.stock_diario where fecha='".$fecha_anterior."' ";
			//echo $consulta_stock_ant;
			$rs_stock_ant = mysqli_query($link, $consulta_stock_ant);
			$row_stock_ant = mysqli_fetch_array($rs_stock_ant);
			//echo $stock_dia_ant.'='.$row_stock_ant[stock_dia].'+'.$produccion.'-'.$row_lam_ant[rechazo_lam_ini].'-'.$row_mfci_ant[suma_mfci].'-'.$row_mfci_ant[suma_mco].'-'.$rechazo_hm;
			$stock_dia_ant=$row_stock_ant[stock_dia]+$produccion-$row_lam_ant[rechazo_lam_ini]-$row_mfci_ant[suma_mfci]-$row_mfci_ant[suma_mco]-$rechazo_hm;
			$consulta_ajuste="select * from ref_web.ajustes where fecha='".$row["fecha"]."'";
			$rs_ajuste = mysqli_query($link, $consulta_ajuste);
			$row_ajuste = mysqli_fetch_array($rs_ajuste);
			if ($row_ajuste[ajuste] <>'')
			  {
                $stock_dia_ant=$stock_dia_ant-$row_ajuste[ajuste];
				$color='s';
			  }
			else {$color='n';} 
			$consulta_existe="select * from ref_web.stock_diario where fecha='".$row["fecha"]."'";
			//echo $consulta_existe;
			$rs_existe = mysqli_query($link, $consulta_existe);
		    if (!($row_existe = mysqli_fetch_array($rs_existe)))
			   {$insertar="insert into ref_web.stock_diario (fecha,stock_dia) values ('".$row["fecha"]."','".$stock_dia_ant."')";
			     mysqli_query($link, $insertar);}
			else {
			       $actualizar1 = "UPDATE ref_web.stock_diario SET stock_dia = '".$stock_dia_ant."'";
		           $actualizar1.= " WHERE fecha='".$row["fecha"]."'";
				   //echo $actualizar1;
		           mysqli_query($link, $actualizar1);
			     }	 
			if (($color=='s') and ($row_ajuste[ajuste] <>0))
			   {	 
		        echo '<td width="82"align="center" title="Ajuste de '.$row_ajuste[ajuste].' laminas a '.$row_ajuste["tipo"].'" class="detalle01"><font color="red">'.$stock_dia_ant.'&nbsp;</font></td>';
			   }
			else {echo '<td width="82"align="center"  >'.$stock_dia_ant.'&nbsp;</td>';}		
			//echo '<td width="82" align="center" >'.$n_placas_actual.'&nbsp;</td>';
			echo '<td width="82" align="center" >'.$n_placas_actual.'&nbsp;</td>';
			echo '<td width="82" align="center" >'.$produccion_actual.'&nbsp;</td>';
			echo '<td width="82" align="center" >'.$rechazo_hm_actual.'&nbsp;</td>';
			$rechazado_dia=number_format(($rechazo_hm_actual/$produccion_actual)*100,"2","","");
			echo '<td width="82" align="center" >'.$rechazado_dia.'&nbsp;</td>';
			echo '<td width="82" align="center" >'.$row_lam_actual[rechazo_lam_ini].'&nbsp;</td>';
			echo '<td width="82" align="center" >'.$row_mfci_actual[suma_mfci].'&nbsp;</td>';
			echo '<td width="82" align="center" >'.$row_mfci_actual[suma_mco].'&nbsp;</td>';
		    /**********laminas aprovadas NE hoy ********************************************************************************/

		    $consulta_lam_apro="select sum(peso_produccion) as aprobadas,sum(peso_tara) as tara_aprobadas ";
		    $consulta_lam_apro.="from sec_web.produccion_catodo ";
		    $consulta_lam_apro.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
		    $consulta_lam_apro.="and cod_subproducto='1'";
			//echo  $consulta_lam_apro;
		    $respuesta_lam_apro = mysqli_query($link, $consulta_lam_apro);
		    $row_lam_apro= mysqli_fetch_array($respuesta_lam_apro);
		    
		    /*********************************************************************************************************/


		    /**********laminas co hoy ********************************************************************************/
		    $consulta_lam_co="select sum(peso_produccion) as co,sum(peso_tara) as tara_co ";
		    $consulta_lam_co.="from sec_web.produccion_catodo ";
		    $consulta_lam_co.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
		    $consulta_lam_co.="and cod_subproducto='2'";
		    $respuesta_lam_co= mysqli_query($link, $consulta_lam_co);
		    $row_lam_co= mysqli_fetch_array($respuesta_lam_co);
		    /*************************************laminas venta*******************************************************************/
		    $consulta_lam_ven="select sum(peso_produccion) as venta, sum(peso_tara) as tara_venta ";
		    $consulta_lam_ven.="from sec_web.produccion_catodo ";
		    $consulta_lam_ven.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
		    $consulta_lam_ven.="and cod_subproducto='4'";
		    $respuesta_lam_ven= mysqli_query($link, $consulta_lam_ven);
		    $row_lam_ven= mysqli_fetch_array($respuesta_lam_ven);
		    $peso_hoja_buena=($row_lam_apro[aprobadas]-$row_lam_apro[tara_aprobadas])+($row_lam_co[co]-$row_lam_co[tara_co])+($row_lam_ven[venta]-$row_lam_ven[tara_venta]);
		    

		    /******************************peso hoja rechazada***********************************************************/
		    $consulta_sin_orejas="select sum(peso_produccion) as peso_rechazo_sin_orejas, sum(peso_tara) as tara_rechazo_s_orejas ";
		    $consulta_sin_orejas.="from sec_web.produccion_catodo ";
		    $consulta_sin_orejas.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
		    $consulta_sin_orejas.="and cod_subproducto='5'";
		    $respuesta_sin_orejas = mysqli_query($link, $consulta_sin_orejas);
		    $row_sin_orejas= mysqli_fetch_array($respuesta_sin_orejas);
		  
		    		
		    $peso_hoja_rech=$row_sin_orejas[peso_rechazo_sin_orejas]-$row_sin_orejas[tara_rechazo_s_orejas];
            $peso_produccion=$peso_hoja_buena;
			$resta_unidades = 0;
			//echo $peso_produccion.'='.$peso_hoja_buena.'-'.$peso_hoja_rech;
		    echo '<td width="82" align="center" >'.$peso_produccion.'&nbsp;</td>';
			/*poly 11-03-05 verificar esto
			
			$promedio_peso_lamina=$row_fci_actual[suma_mco]/produccion_actual-rechazo_hm_actual;*/
			
			
			$resta_unidades = ($produccion_actual - $rechazo_hm_actual);
			
			$promedio_peso_lamina = ($peso_produccion / $resta_unidades);
			
		    //poly $promedio_peso_lamina=$peso_produccion/$produccion_actual;
			
	        echo '<td width="82" align="center" >'.number_format($promedio_peso_lamina,"2",",","").'&nbsp;</td>';
			echo '</tr>';
		 }
		 echo '<tr>';
		 echo '<td colspan="11" class="detalle02">&nbsp;</td>';
		 echo '</tr>';
		 echo '<tr>';
		 echo '<td colspan="11" class="detalle01"><strong>Nota: El valor escrito en <font color="red">rojo</font> contiene ajuste.-</strong></td>';
		 echo '</tr>';
		 echo '<tr>';
		 echo '<td colspan="11" class="detalle02">&nbsp;</td>';
		 echo '</tr>';
?>
        
		
        <table width="988" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">
          <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
            <td width="118" height="20" rowspan="2" align="left"> Fecha</td>
            <td height="18" colspan="10" align="center"> Control Diario Catodos Iniciales</td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="118" align="center" bordercolor="#FFFFFF">Stock Dia</td>
            <td width="118" align="center" bordercolor="#FFFFFF">Produccion Dia</td>
            <td width="118" align="center" bordercolor="#FFFFFF">Ocupados en Renovacion</td>
            <td width="118" align="center" bordercolor="#FFFFFF">Rechazo Renovacion</td>
            <td width="118" align="center" bordercolor="#FFFFFF">Rechazo MFCI</td>
            <td width="118" align="center" bordercolor="#FFFFFF">Difer. c/r cont real </td>
            <td width="118" align="center" bordercolor="#FFFFFF">rechazo total hojas + catodos </td>
          </tr>
        </table>
      <table width="988" border="1" cellspacing="0" cellpadding="0" class="TablaInterior">
 <?php
       $consulta_fecha="SELECT distinct fecha ";
	   $consulta_fecha.=" FROM ref_web.detalle_iniciales "; 
	   	$consulta_fecha.=" where  substring(fecha,1,7) ='".$FechaInicio."' ";

	  // $consulta_fecha.=" where fecha between '".$FechaInicio."' and '".$FechaTermino."' ";
	   $rs = mysqli_query($link, $consulta_fecha);
	   $total_consumo_total=0;
	   while ($row = mysqli_fetch_array($rs))
	      {
	 		 echo '<tr>';
             echo '<td width="118" align="center" class="detalle01">'.FormatoFecha($row["fecha"]).'</td>';
			 $consulta_stock_c_i="select * from ref_web.detalle_iniciales where fecha='".$row["fecha"]."'";
			 $rs_stock_c_i = mysqli_query($link, $consulta_stock_c_i);
			 $row_stock_c_i = mysqli_fetch_array($rs_stock_c_i);
			 echo '<td width="118" align="center" >'.$row_stock_c_i[stock].'&nbsp;</td>';
			 $consulta_mfci_actual="select sum(produccion_mfci) as suma_mfci, sum(produccion_mco) as suma_mco from ref_web.iniciales where fecha='".$row["fecha"]."'";	  
			 $rs_mfci_actual = mysqli_query($link, $consulta_mfci_actual);
			 $row_mfci_actual = mysqli_fetch_array($rs_mfci_actual);
			 echo '<td width="118" align="center" >'.$row_mfci_actual[suma_mfci].'&nbsp;</td>';
			 //$total_consumo= OcupadosEnRenovacion($row["fecha"]);
             echo '<td width="118" align="center" >'.OcupadosEnRenovacion($row["fecha"]).'&nbsp;</td>';
			 $consulta_lam_actual="select * from ref_web.detalle_iniciales where fecha='".$row["fecha"]."' ";
			 $rs_lam_actual = mysqli_query($link, $consulta_lam_actual);
			 $row_lam_actual = mysqli_fetch_array($rs_lam_actual);
			 if ($row_lam_actual[catodos_en_renovacion]=='')
			    { $row_lam_actual[catodos_en_renovacion]=0; }  
			 echo '<td width="118" align="center" >'.$row_lam_actual[catodos_en_renovacion].'&nbsp;</td>';
			 echo '<td width="118" align="center" >'.$row_lam_actual[rechazo_cat_ini].'&nbsp;</td>';
			 $fecha_siguiente=buscadia(1,$row["fecha"]);//llama a funcion busca dia para buscar dia siguiente
			 $consulta_stock_c_anterior="select * from ref_web.detalle_iniciales where fecha='".$fecha_siguiente."'";
			 $rs_stock_c_anterior = mysqli_query($link, $consulta_stock_c_anterior);
			 $row_stock_c_anterior = mysqli_fetch_array($rs_stock_c_anterior);
			 $total_consumo_renovacion_anterior=OcupadosEnRenovacion($fecha_siguiente);
			 $consulta_mfci_anterior="select sum(produccion_mfci) as suma_mfci, sum(produccion_mco) as suma_mco from ref_web.iniciales where fecha='".$fecha_siguiente."'";	  
			 $rs_mfci_anterior = mysqli_query($link, $consulta_mfci_anterior);
			 $row_mfci_anterior = mysqli_fetch_array($rs_mfci_anterior);
			 $consulta_lam_actual="select * from ref_web.detalle_iniciales where fecha='".$fecha_siguiente."' ";
			 $rs_lam_actual = mysqli_query($link, $consulta_lam_actual);
			 $row_lam_actual = mysqli_fetch_array($rs_lam_actual);
			 if ($row_lam_actual[catodos_en_renovacion]=='')
			    { $row_lam_actual[catodos_en_renovacion]=0; }  	 
			 //echo $row_stock_c_i[stock].'-'.$row_stock_c_anterior[stock].'-'.$row_mfci_anterior[suma_mfci].'+'.$total_consumo_renovacion_anterior.'+'.$row_lam_actual[catodos_en_renovacion].'+'.$row_lam_actual[rechazo_cat_ini] ;	
		     $dif_cont_real=$row_stock_c_i[stock]-$row_stock_c_anterior[stock]-$row_mfci_anterior[suma_mfci]+$total_consumo_renovacion_anterior+$row_lam_actual[catodos_en_renovacion]+$row_lam_actual[rechazo_cat_ini] ;
			 echo '<td width="118" align="center" >'.$dif_cont_real.'&nbsp;</td>';
			$consulta_grupo_hm="select valor_subclase1 as subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001'";
		    $rs_grupo_hm = mysqli_query($link, $consulta_grupo_hm);
			$produccion=0;
			$n_placas=0;
			$rechazo_hm=0;
			$produccion_actual=0;
			$n_placas_actual=0;
			$rechazo_hm_actual=0;
			while ($row_grupo_hm = mysqli_fetch_array($rs_grupo_hm))
			      { 
				     $consulta_fecha_actual="select max(t1.fecha) as fecha from ref_web.grupo_electrolitico2 as t1 where t1.fecha <=  '".$row["fecha"]."' and t1.cod_grupo ='0".$row_grupo_hm[subclase1]."' group by t1.cod_grupo";
					 $rs_fecha_actual = mysqli_query($link, $consulta_fecha_actual);
					 $row_fecha_actual = mysqli_fetch_array($rs_fecha_actual);
			         $Consulta6_actual =  "select max(t1.fecha) as fecha,t1.cod_grupo,t1.cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 as t1 ";
					 $Consulta6_actual = $Consulta6_actual." where  t1.fecha = '".$row_fecha_actual["fecha"]."' and t1.cod_grupo ='0".$row_grupo_hm[subclase1]."' group by t1.cod_grupo";
					 $rs3_actual = mysqli_query($link, $Consulta6_actual);
					 $row3_actual = mysqli_fetch_array($rs3_actual);
					/***************************************consulta y calcula el rechazo de hojas madres para el dia actual**************************************************************/					
					 $consulta_rechazo_hm_actual="select * from ref_web.produccion where fecha='".$row["fecha"]."' and cod_grupo='".$row_grupo_hm[subclase1]."'";
					 $rs_rechazo_hm_actual = mysqli_query($link, $consulta_rechazo_hm_actual);
					 $row_rechazo_hm_actual = mysqli_fetch_array($rs_rechazo_hm_actual);
					 $rechazo_hm_actual=$rechazo_hm_actual+$row_rechazo_hm_actual[rechazo_delgadas]+$row_rechazo_hm_actual[rechazo_granuladas]+$row_rechazo_hm_actual[rechazo_gruesas];
					 $produccion_actual=$produccion_actual+(($row3_actual[hojas_madres]*$row3_actual[num_catodos_celdas])*2); 
					
				  }
			 $consulta_lam_actual="select * from ref_web.detalle_iniciales where fecha='".$row["fecha"]."' ";
			 $rs_lam_actual = mysqli_query($link, $consulta_lam_actual);
			 $row_lam_actual = mysqli_fetch_array($rs_lam_actual);
			 if ($row_lam_actual[rechazo_lam_ini]=='')
			   { $row_lam_actual[rechazo_lam_ini]=0; } 
			 $consulta_mfci_actual="select sum(produccion_mfci) as suma_mfci, sum(produccion_mco) as suma_mco from ref_web.iniciales where fecha='".$row["fecha"]."'";	  
			 $rs_mfci_actual = mysqli_query($link, $consulta_mfci_actual);
			 $row_mfci_actual = mysqli_fetch_array($rs_mfci_actual);  
			 $rechazo_total_en_porc=(($rechazo_hm_actual+$row_lam_actual[rechazo_lam_ini]+$row_lam_actual[catodos_en_renovacion]+$row_lam_actual[rechazo_cat_ini])/$produccion_actual)*100;
			 echo '<td width="118" align="center" >'.number_format($rechazo_total_en_porc,"2","","").'&nbsp;</td>';
			 echo '<tr>';
          }
		  
 
 ?>
</table> 
        <table width="988" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
               <td align="center">
               	<input name="btninprimir" type="button" id="btnimprimir" value="Imprimir"style="width:70"  onClick="JavaScript:Imprimir(this.form)">
				<input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="JavaScript:Salir()"></td>
		  </tr>
		</table>
        <td width="966"></td>
        <td width="16" height="39"></tr>
</table>
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
