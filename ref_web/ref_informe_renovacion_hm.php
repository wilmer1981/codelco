<?php 
	include("../principal/conectar_principal.php");
	// $link = mysql_connect('10.56.11.7','adm_bd','672312');
 //mysql_select_db("ref_web",$link);
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 27;
	
	$opcion = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:date("Y-m");
	$ano1   = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$mes1   = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$mensaje= isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
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
	//alert("ano1:"+ano1);
	//f.action = "ref_informe_renovacion_hm.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1;
	//f.submit();	
					
	document.location = "../ref_web/ref_informe_renovacion_hm.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1;
}
/*****************/

function Imprimir(f)
{
	window.print();
}

/*****************/
function Salir()
{
history.back();
}

function Excel(f)
{
	var  f=document.frmPrincipal;
	var ano=f.ano1.value;
	var mes=f.mes1.value;

	//document.location = "../ref_web/Renovacion_HM_excel.php?opcion=H&ano1="+ano+"&mes1="+mes;
	f.action="Renovacion_HM_excel.php?opcion=H&ano1="+ano+"&mes1="+mes;
	f.submit();
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
                </select> <select name="ano1" size="1" id="ano1">
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
                </select>&nbsp;&nbsp;<input name="buscar" type="button" value="buscar" onClick="Buscar()" >
              </td>
            </tr>
          </table>
</div>
        <div style="position:absolute; left: 10px; top: 93px; width: 730px; height: 30px;" id="div1"> 
          <table width="730" border="2" cellspacing="0" cellpadding="0" bordercolor="white" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="116" align="center">Fecha</td>
              <td width="121" align="center">Grupo</td>
              <td width="191" align="center">Cubas N&deg;</td>
              <td width="122" align="center">Anodos a Renovar</td>
              <td width="116" align="center">Inicio Renovacion</td>
            </tr>
          </table>
 </div>
         <div style="position:absolute; left: 10px; top: 126px; width: 751px; height: 371px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="2" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php	
	// $link = mysql_connect('10.56.11.7','adm_bd','672312');
 //mysql_select_db("ref_web",$link);
	if ($opcion=="H")
	{
	    if (strlen($mes1)==1)
		   {$mes1='0'.$mes1;}  
	    $fecha=$ano1.'-'.$mes1;
		if($mes1=='01' || $mes1=='03' || $mes1=='05' || $mes1=='07' || $mes1=='08' || $mes1=='10' || $mes1=='12'){
		 $dias=31;
		}
		if($mes1=='04' || $mes1=='06' || $mes1=='09' || $mes1=='11'){
		 $dias=30;
		}
		if($mes1=='02'){
		 $dias=29;
		}
		$i=1;
		while ($i <= $dias)
		{
			   echo '<tr>';
			    if (strlen($i)==1)
			    {$i='0'.$i;}
			   //echo "<br><br>fechassss:".$fecha;
			   $consultat="select count(cod_grupo) total_filas from ref_web.renovacion_hm where fecha ='".$fecha."-".$i."'";
			   //echo "<br>".$consultat;
			   $rsst = mysqli_query($link,$consultat);
			   $rowst = mysqli_fetch_array($rsst);
			   $consulta="select * from ref_web.renovacion_hm where fecha ='".$fecha."-".$i."' order by cod_grupo asc ";
			   $rss  = mysqli_query($link,$consulta);
			   $row_cnt = $rss->num_rows;
			   $fechas ="";
			   $cod_grupo="";
			   $cubas_renovacion = "";
			   $anodos_a_renovar = "";
			    if($row_cnt>0)
			    {
					$rows = mysqli_fetch_array($rss);			   
					$fechas = $rows["fecha"];
					$cod_grupo = $rows["cod_grupo"];
					$cubas_renovacion = $rows["cubas_renovacion"];
					$anodos_a_renovar = $rows["anodos_a_renovar"];
			    }
			    if ($rows = mysqli_fetch_array($rss))
			    {
					
				    if ($fechas<>'')
			        {
				               $dia=substr($rows["fecha"],8,2);
				               echo '<td width="137" align="center" rowspan="'.$rowst["total_filas"].'">'.$rows["fecha"].'</td>';
				    }
			        else{
			                      echo '<td width="137" align="center" rowspan="'.$rowst["total_filas"].'">'.$fecha.'-'.$i.'</td>';
					} 
				   $rss = mysqli_query($link,$consulta);
			        while ($rows = mysqli_fetch_array($rss))
				    {
			               echo '<td width="146" align="center">'.$rows["cod_grupo"].'&nbsp;</td>';  
						   if ($rows["cubas_renovacion"]=='SIN RENOVACION')
						      {echo '<td width="234" align="center" class="detalle01"><font color="#FF0000"><strong>'.$rows["cubas_renovacion"].'&nbsp;</strong></font></td>';}
		                   else {echo '<td width="234" align="center">'.$rows["cubas_renovacion"].'&nbsp;</td>';}
						   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo= '".$rows["cod_grupo"]."'";
						   $rss_fecha = mysqli_query($link,$consulta_fecha);
						   $rows_fecha = mysqli_fetch_array($rss_fecha);
						   $consulta="select num_cubas_tot,hojas_madres, num_anodos_celdas from ref_web.grupo_electrolitico2 where cod_grupo='".$rows["cod_grupo"]."' and fecha='".$rows_fecha["fecha"]."'";
						   $rs = mysqli_query($link,$consulta);
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
				else
				{
				    if ($fechas<>'')
			        {
				               $dia=substr($fechas,8,2);
				               echo '<td width="137" align="center" >'.$fecha.'</td>';
					}
				    else {
						  echo '<td width="137" align="center" >'.$fecha.'-'.$i.'</td>';
					}   
				    echo '<td width="146" align="center">'.$cod_grupo.'&nbsp;</td>';  	
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
</div>       

<div style="position:absolute; left: 8px; width: 765px; height: 26px; top: 500px;" id="div3">
<table width="760" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  <tr>
    <td width="743" align="center"><input name="btnExcel" type="button" id="btnexcel" value="Excel"style="width:70"  onClick="JavaScript:Excel(this.form)"> 
                <input name="btninprimir" type="button" id="btnimprimir" value="Imprimir"style="width:70"  onClick="JavaScript:Imprimir(this.form)">
                <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="JavaScript:Salir()">
              </td>
  </tr>
</table>
</div>

</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
<?php
	if ($mensaje!="")
	{
		echo '<script language="JavaScript">';		
		echo 'alert("'.$mensaje.'");';			
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>
