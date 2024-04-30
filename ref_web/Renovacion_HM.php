<?php 
	include("../principal/conectar_ref_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 27;
	$CookieRut = $_COOKIE["CookieRut"];
	$consulta="select * from ref_web.usuarios_autorizados where rut='".$CookieRut."'";
	//echo $consulta;
	$rss = mysqli_query($link, $consulta);
    $rows = mysqli_fetch_array($rss);
	$permiso = isset($rows["ren_hm"])?$rows["ren_hm"]:"";

	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";

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
function ValorCheckBox(f)
{
	for(i=0; i<f.checkbox.length; i++)	
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
	for(i=0; i<f.checkbox.length; i++)	
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
		case "N":
				window.open("ref_ing_ren_HM2.php?Proceso=N&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value + "","","top=70,left=100,width=800,height=550,scrollbars=yes,resizable = yes,toolbar=no,menubar=no");
				break;
		case "A":
			f.action = "Renovacion_HM.php?opcion=H";
			f.submit();
			break;
		case "E":
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
		     alert("Se eliminara el registro para el dia seleccionado");
		     f.action = "ref_ing_ren_HM01.php?Proceso=E&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value ;
			 f.submit();
			 break;
			} 
		case "M":
		    window.open("ref_ing_ren_HM2.php?Proceso=M&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value + "","","top=70,left=100,width=800,height=550,scrollbars=yes,resizable = yes,toolbar=no,menubar=no");
		  	break;		
	}
}
/*****************/
function Modificar(f)
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
	  window.open("ref_ing_ren_HM.php?parametros=" + valores+ "","","top=70,left=100,width=380,height=450,scrollbars=no,resizable = no");
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

function Excel(f)
{
	//var  f=document.form1;
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
              <td width="49" height="20" align="left">modif. diaria</td>
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
		                       echo '<td width="50" height="25" rowspan="'.$rowst["total_filas"].'"><input type="checkbox" name="checkbox" value="'.$rows["fecha"].'"></td>';
				               echo '<td width="137" align="center" rowspan="'.$rowst["total_filas"].'">'.$rows["fecha"].'</td>';
				              }
			               else {
			                      echo '<td width="50" height="25" rowspan="'.$rowst["total_filas"].'"><input type="checkbox" name="checkbox" value="'.$fecha."-".$i.'"></td>';
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
							   $nacelda=isset($rows["num_anodos_celdas"])?$rows["num_anodos_celdas"]:0;
						       $anodos_a_renovar= count($arreglo)*$nacelda;
							   //$anodos_a_renovar= count($arreglo)*$row["num_anodos_celdas"];
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
					 	$fecha     = isset($rows["fecha"])?$rows["fecha"]:"";
						$cod_grupo = isset($rows["cod_grupo"])?$rows["cod_grupo"]:"";
						$cubas_renovacion = isset($rows["cubas_renovacion"])?$rows["cubas_renovacion"]:"";
						$anodos_a_renovar = isset($rows["anodos_a_renovar"])?$rows["anodos_a_renovar"]:"";
				        if ($fecha<>'')
			                  {
				               $dia=substr($rows["fecha"],8,2);
		                       echo '<td width="50" height="25" ><input type="checkbox" name="checkbox" value=""'.$fecha.'""></td>';
				               echo '<td width="137" align="center" >'.$fecha.'</td>';
				              }
			               else {
			                      echo '<td width="50" height="25" ><input type="checkbox" name="checkbox" value="'.$fecha."-".$i.'"></td>';
			                      echo '<td width="137" align="center" >'.$fecha.'-'.$i.'</td>';
					            }   
							echo '<td width="146" align="center">'.$cod_grupo.'&nbsp;</td>';  	
		                    if ($cubas_renovacion == 'SIN RENOVACION')
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
                <?php if ($permiso=='1')
	           {?>
                <input name="btnModificar" type="button" value="Nuevo " onClick="Proceso(this.form,'N')">
                <input name="btnModificar1" type="button" value="Modificar" onClick="Proceso(this.form,'M')"> 
                <?php } ?>
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
