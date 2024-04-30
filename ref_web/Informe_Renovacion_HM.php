<?php 
	include("../principal/conectar_ref_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 27;

	$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	//$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";

	$fecha=ltrim($fecha);
    $ano1=substr($fecha,0,4);
	$mes1=substr($fecha,5,2);
	$dia1=substr($fecha,8,2);
	$opcion='H';
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
	document.location = "../ref_web/Renovacion_HM.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1;
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

function Excel(f)
{
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	f.action="Renovacion_HM_excel.php?opcion=H&ano1="+ano+"&mes1="+mes;
	f.submit();
}
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="742" height="500" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="736" align="center" valign="middle"> 
          <table width="730" border="2" cellspacing="0" cellpadding="0" bordercolor="white" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="124" height="20" align="center"> Fecha</td>
              <td width="127" align="center">Grupo</td>
              <td width="207" align="center">Cubas N&deg;</td>
              <td width="131" align="center">Anodos a Renovar</td>
              <td width="128" align="center">Inicio Renovacion</td>
            </tr>
          </table>
          <table width="730" border="2" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php	
	if ($opcion=="H")
	  {
	    if (strlen($mes1)==1)
		   {$mes1='0'.$mes1;}  
	    $fecha=$ano1.'-'.$mes1;
		$i=1;
		while ($i <= 31)
		      {
			   echo '<tr>';
			   if (strlen($i)==1)
			       {$i='0'.$i;}
			
			   $consultat="select count(cod_grupo) total_filas from ref_web.renovacion_hm where fecha ='".$fecha."-".$i."'";
			   $rsst = mysqli_query($link, $consultat);
			   $rowst = mysqli_fetch_array($rsst);
			   $consulta="select * from ref_web.renovacion_hm where fecha ='".$fecha."-".$i."' order by cod_grupo asc ";
			   $rss = mysqli_query($link, $consulta);
			   if ($rows = mysqli_fetch_array($rss))
			      {
				   if ($rows["fecha"]<>'')
			                  {
				               $dia=substr($rows["fecha"],8,2);
				               echo '<td width="137" align="center" rowspan="'.$rowst["total_filas"].'">'.$rows["fecha"].'</td>';
				              }
			               else {
			                      echo '<td width="137" align="center" rowspan="'.$rowst["total_filas"].'">'.$fecha.'-'.$i.'</td>';
					            } 
				   $rss = mysqli_query($link, $consulta);
			       while ($rows = mysqli_fetch_array($rss))
				          {
			               echo '<td width="146" align="center">'.$rows["cod_grupo"].'&nbsp;</td>';  
						   if ($rows["cubas_renovacion"]=='SIN RENOVACION')
						      {echo '<td width="234" align="center" class="detalle01"><font color="#FF0000"><strong>'.$rows["cubas_renovacion"].'&nbsp;</strong></font></td>';}
		                   else {echo '<td width="234" align="center">'.$rows["cubas_renovacion"].'&nbsp;</td>';}
						   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo= '".$rows["cod_grupo"]."'";
						   $rss_fecha = mysqli_query($link, $consulta_fecha);
						   $rows_fecha = mysqli_fetch_array($rss_fecha);
						   $consulta="select num_cubas_tot,hojas_madres, num_anodos_celdas from ref_web.grupo_electrolitico2 where cod_grupo='".$rows["cod_grupo"]."' and fecha='".$rows_fecha["fecha"]."'";
						   $rs = mysqli_query($link, $consulta);
						   $row = mysqli_fetch_array($rs);
						   if ($rows["cubas_renovacion"]<>'Renovacion Grupo 8 Comercial')
						      {
						       $arreglo = explode("-",$rows["cubas_renovacion"]);
						       $anodos_a_renovar= count($arreglo)*$row["num_anodos_celdas"];
							  } 
						   else { //echo '('.$row["num_cubas_tot"].'-'.$row["hojas_madres"].')*'.$row["num_anodos_celdas"].')';
						          $anodos_a_renovar=(($row["num_cubas_tot"]-$row["hojas_madres"])*$row["num_anodos_celdas"]);} 
						   echo '<td width="146" align="center">'.$anodos_a_renovar.'&nbsp;</td>';
                           echo '<td width="146" align="center">'.$rows["inicio_renovacion"].'&nbsp;</td>';
			              // $i=$i+1;
						  echo '<tr>';
						  }
					
                   }
				else {
					$fecharow = isset($rows["fecha"])?$rows["fecha"]:"";
				        if ($fecharow<>'')
			        	{
				               $dia=substr($rows["fecha"],8,2);
		                       echo '<td width="137" align="center" >'.$rows["fecha"].'</td>';
				        }else {
			                     echo '<td width="137" align="center" >'.$fecha.'-'.$i.'</td>';
					    }   
						$cod_grupo = isset($rows["cod_grupo"])?$rows["cod_grupo"]:"";
						echo '<td width="146" align="center">'.$cod_grupo.'&nbsp;</td>';  
						$cubas_renovacion = isset($rows["cubas_renovacion"])?$rows["cubas_renovacion"]:"";	
						$anodos_a_renovar = isset($rows["anodos_a_renovar"])?$rows["anodos_a_renovar"]:"";	
		                if ($cubas_renovacion=='SIN RENOVACION')
						{echo '<td width="234" align="center" class="detalle01"><font color="#FF0000"><strong>'.$cubas_renovacion.'&nbsp;</strong></font></td>';}
		                else {echo '<td width="234" align="center">'.$cubas_renovacion.'&nbsp;</td>';}
                        echo '<td width="146" align="center">'.$anodos_a_renovar.'&nbsp;</td>';
                        echo '<td width="146" align="center">&nbsp;</td>';
			               
				     } 
					 $i=$i+1;  
	           }
			   }
		
		/*echo "<script languaje='JavaScript'>\n";
		echo "document.frmPrincipal.action = 'Renovacion_HM.php?opcion=H';";
		echo "document.frmPrincipal.submit();";
		echo "</script>\n";*/
	
    
?>
</table> 

      </td>
</tr>
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
