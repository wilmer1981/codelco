<?php 
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");include("../principal/conectar_ref_web.php");
?>

<html>
<head>
<title>Programa de Renovacion</title>
</head>
<form name="frmPrincipal" action="" method="post">
  <table width="770" height="500" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <p> Programa de Cambio de Anodos Hojas Madres</p>
    <tr>
      <td width="762" align="center" valign="middle"> 
          <table width="730" border="2" cellspacing="0" cellpadding="0" bordercolor="white" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="116" align="center">Fecha</td>
              <td width="121" align="center">Grupo</td>
              <td width="191" align="center">Cubas N&deg;</td>
              <td width="122" align="center">Anodos a Renovar</td>
              <td width="116" align="center">Inicio Renovacion</td>
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
		                       echo '<td width="137" align="center" rowspan="'.$rowst[total_filas].'">'.$rows["fecha"].'</td>';
				              }
			               else {
			                      echo '<td width="137" align="center" rowspan="'.$rowst[total_filas].'">'.$fecha.'-'.$i.'</td>';
					            } 
				   $rss = mysqli_query($link, $consulta);
			       while ($rows = mysqli_fetch_array($rss))
				          {
			               echo '<td width="146" align="center">'.$rows["cod_grupo"].'</td>';  
						   if ($rows[cubas_renovacion]=='SIN RENOVACION')
						      {echo '<td width="234" align="center" class="detalle01"><font color="#FF0000"><strong>'.$rows[cubas_renovacion].'&nbsp;</strong></font></td>';}
		                   else {echo '<td width="234" align="center">'.$rows[cubas_renovacion].'</td>';}
						   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo= '".$rows["cod_grupo"]."'";
						   $rss_fecha = mysqli_query($link, $consulta_fecha);
						   $rows_fecha = mysqli_fetch_array($rss_fecha);
						   $consulta="select num_cubas_tot,hojas_madres, num_anodos_celdas from ref_web.grupo_electrolitico2 where cod_grupo='".$rows["cod_grupo"]."' and fecha='".$rows_fecha["fecha"]."'";
						   $rs = mysqli_query($link, $consulta);
						   $row = mysqli_fetch_array($rs);
						    if ($rows[cubas_renovacion]<>'Renovacion Grupo 8 Comercial')
						      {
						       $arreglo = explode("-",$rows[cubas_renovacion]);
						       $anodos_a_renovar= count($arreglo)*$row[num_anodos_celdas];
							  } 
						   else { //echo '('.$row[num_cubas_tot].'-'.$row[hojas_madres].')*'.$row[num_anodos_celdas].')';
						          $anodos_a_renovar=(($row[num_cubas_tot]-$row[hojas_madres])*$row[num_anodos_celdas]);} 
						   echo '<td width="146" align="center">'.$anodos_a_renovar.'</td>';
                           echo '<td width="146" align="center">'.$rows[inicio_renovacion].'</td>';
			              // $i=$i+1;
						  echo '<tr>';
						  }
                   }
				else {
				       if ($rows["fecha"]<>'')
			                  {
				               $dia=substr($rows["fecha"],8,2);
		                       echo '<td width="137" align="center" >'.$rows["fecha"].'</td>';
				              }
			               else {
			                      echo '<td width="137" align="center" >'.$fecha.'-'.$i.'</td>';
					            }   
							echo '<td width="146" align="center">'.$rows["cod_grupo"].'</td>';  	
		                    if ($rows[cubas_renovacion]=='SIN RENOVACION')
						      {echo '<td width="234" align="center" class="detalle01"><font color="#FF0000"><strong>'.$rows[cubas_renovacion].'&nbsp;</strong></font></td>';}
		                   else {echo '<td width="234" align="center">'.$rows[cubas_renovacion].'</td>';}
                           echo '<td width="146" align="center">'.$rows[anodos_a_renovar].'</td>';
                           echo '<td width="146" align="center"></td>';
			               
				     } 
					 $i=$i+1;  
	           }
			   }
    
?>
</table> 

<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  <tr>
              <td align="center"></td>
  </tr>
</table>
</td>
</tr>
</table>
</form>
</html>
<?php //include("../principal/cerrar_ref_web.php"); ?>
