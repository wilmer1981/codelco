<?php
include("../principal/conectar_principal.php");

if(isset($_REQUEST["ProSubPro"])) {
	$ProSubPro = $_REQUEST["ProSubPro"];
}else{
	$ProSubPro =  "";
}
if(isset($_REQUEST["Producto01"])) {
	$Producto01 = $_REQUEST["Producto01"];
}else{
	$Producto01 =  "";
}
if(isset($_REQUEST["SubProducto01"])) {
	$SubProducto01 = $_REQUEST["SubProducto01"];
}else{
	$SubProducto01 =  "";
}
if(isset($_REQUEST["Periodo"])) {
	$Periodo = $_REQUEST["Periodo"];
}else{
	$Periodo =  "";
}
if(isset($_REQUEST["Tipo"])) {
	$Tipo = $_REQUEST["Tipo"];
}else{
	$Tipo =  "";
}
if(isset($_REQUEST["Analisis"])) {
	$Analisis = $_REQUEST["Analisis"];
}else{
	$Analisis =  "";
}
if(isset($_REQUEST["FechaI"])) {
	$FechaI = $_REQUEST["FechaI"];
}else{
	$FechaI =  "";
}

if(isset($_REQUEST["FechaT"])) {
	$FechaT = $_REQUEST["FechaT"];
}else{
	$FechaT =  "";
}
if(isset($_REQUEST["Producto"])) {
	$Producto = $_REQUEST["Producto"];
}else{
	$Producto =  "";
}
if(isset($_REQUEST["SubProducto"])) {
	$SubProducto = $_REQUEST["SubProducto"];
}else{
	$SubProducto =  "";
}

if(isset($_REQUEST["Dia"])) {
	$Dia = $_REQUEST["Dia"];
}else{
	$Dia =  date("d");
}
if(isset($_REQUEST["Mes"])) {
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes =  date("m");
}
if(isset($_REQUEST["Ano"])) {
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano =  date("Y");
}


if(isset($_REQUEST["DiaT"])) {
	$DiaT = $_REQUEST["DiaT"];
}else{
	$DiaT =  date("d");
}
if(isset($_REQUEST["MesT"])) {
	$MesT = $_REQUEST["MesT"];
}else{
	$MesT =  date("m");
}
if(isset($_REQUEST["AnoT"])) {
	$AnoT = $_REQUEST["AnoT"];
}else{
	$AnoT =  date("Y");
}

if(isset($_REQUEST["Enabal"])) {
	$Enabal = $_REQUEST["Enabal"];
}else{
	$Enabal =  "";
}
	

?>
<html>
<head>
<script language="JavaScript">
function activar()
{
	var frm=document.FrmConsultaLeyes;
	var LargoForm = frm.elements.length;
	for (i=0;i < LargoForm;i++)
	{
		if (frm.elements[i].name == "checkLeyes") 
		{
			if (frm.checkTodos.checked == true)
			{
				frm.elements[i].checked = true;
			}
			else
			{
				frm.elements[i].checked = false;
			}
		}
	}
	////
	for (i=0; i< LargoForm; i++ )
	{
		if (frm.elements[i].name == "checkLeyes")
		{
			if (frm.checkTodos.checked == true)
			{
				frm.elements[i].checked = true;
			}
		}
	}
}

function Leyes(Enabal)
{
	var frm=document.FrmConsultaLeyes;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var ValoresLeyes="";
	var ValoresCodLeyes="";
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
			{
				checkeoLeyes= true;
				//Corresponde a las Abreviaturas de las leyes asociadas a los productos y subproductos
				ValoresLeyes = ValoresLeyes + frm.elements[i+1].value + "~~" ;
				ValoresCodLeyes=ValoresCodLeyes + frm.elements[i].value + "~" 
			}
	}
	if (checkeoLeyes == false)
	{
		alert("Seleccione una Ley")
	} 
	else
	{
		frm.action="cal_con_leyes_producto01.php?ValoresLeyes="+ValoresLeyes +  "&ValoresCodLeyes=" + ValoresCodLeyes + "&Salir=1&E="+Enabal; 
		frm.submit();
	}
}

</script>

<title>Seleccion de Leyes e Impurezas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<center>
<form name="FrmConsultaLeyes" method="post" action="">
<input name="Producto01" type="hidden" value="<?php echo $Producto01  ?>">
<input name="SubProducto01" type="hidden" value="<?php echo $SubProducto01  ?>">
<input name="FechaInicio" type="hidden" value="<?php echo $FechaI  ?>">
<input name="FechaTermino" type="hidden" value="<?php echo $FechaT  ?>">
<input name="Periodo" type="hidden" value="<?php echo $Periodo  ?>">
<input name="Tipo" type="hidden" value="<?php echo $Tipo  ?>">
<input name="Analisis" type="hidden" value="<?php echo $Analisis  ?>">
<input name="Producto" type="hidden" value="<?php echo $Productos  ?>">
<input name="SubProducto" type="hidden" value="<?php echo $SubProducto  ?>">
<input name="Dia" type="hidden" value="<?php echo $Dia  ?>">
<input name="Mes" type="hidden" value="<?php echo $Mes  ?>">
<input name="Ano" type="hidden" value="<?php echo $Ano  ?>">
<input name="DiaT" type="hidden" value="<?php echo $DiasT  ?>">
<input name="MesT" type="hidden" value="<?php echo $MesT  ?>">
<input name="AnoT" type="hidden" value="<?php echo $AnoT  ?>">


<table width="600" height="228" border="0" cellpadding="5" class="tablaprincipal">
        <td> 
          <table width="600" border="0" cellpadding="0" class="ColorTabla01">
  	<tr>
              <td><div align="center"><strong>INGRESO DE LEYES</strong></div></td>
  	</tr>
	</table><br>
          <table width="600" border="0" cellpadding="0" class="TablaInterior">
            <tr> 
              <td width="215"><div align="right">
                  <input name="BtnOk" type="button" style="width:60" value="Ok" onClick="Leyes('<?php echo $Enabal;  ?>');">
                </div></td>
              <td width="99"> <div align="center"> 
                  <input name="BtnBorrar" type="submit" style="width:60" value="Borrar" onClick="Borrar('<?php echo $Enabal;  ?>')"  >
                </div></td>
              <td width="275"><input name="BtnSalir" type="Button"  value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
            </tr>
          </table>
          <br>

	      <table width="600" height="23" border="0" class="ColorTabla01" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="29" ><div align="left"><strong> 
                  <input name="checkTodos" type="checkbox" id="checkTodos" onClick="JavaScript:activar();" value="">
                  </strong>Todos</div></td>
              <td width="251" ><div align="center">Leyes</div></td>
              <td width="163" >&nbsp;</td>
            </tr>
          </table>
          <table width="600" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <?php
			for ($j = 0;$j <= strlen($ProSubPro); $j++)
			{
				if (substr($ProSubPro,$j,2) == "//")
					{
						$ProSPro = substr($ProSubPro,0,$j);
						for ($x=0;$x<=strlen($ProSPro);$x++)
						{
							if (substr($ProSPro,$x,2) == "~~")
							{
								$Producto = substr($ProSubPro,0,$x);			
								$SubProducto = substr($ProSPro,$x+2,strlen($ProSPro));
								//concatena los productos y subproductos que se concatenaran para la consulta
								// de las leyes asociadas a los productos y subproductos  

								//$Var= $Var."(t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."') or"; 
								$Var= "(t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."') or"; 									
							}
						}		
					$ProSubPro = substr($ProSubPro,$j + 2);
					$j = 0;
					}
				}			
			$Pregunta=substr($Var,0,strlen($Var)-2);
			echo "<tr>";
			$FechaI = $FechaI.' 00:01';
			$FechaT = $FechaT.' 23:59';
			//Pregunta por la variable var que contine parte de la consulta  
			if ((!is_null($Var))||($Var!=""))
			{
				$Consulta ="select STRAIGHT_JOIN distinct (t2.cod_leyes),t3.abreviatura from cal_web.solicitud_analisis t1 "; 
				$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t2 ";
				$Consulta = $Consulta." on (t1.nro_solicitud = t2.nro_solicitud  and t2.candado='1' and t1.recargo = t2.recargo and t1.rut_funcionario = t2.rut_funcionario and t1.fecha_hora = t2.fecha_hora) "; 
				$Consulta = $Consulta." and (t1.estado_actual = 5 or t1.estado_actual = 6 or t1.estado_actual = '31' or t1.estado_actual = '32') inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes  ";
				$Consulta = $Consulta." where (t1.fecha_muestra between  '".$FechaI."' and '".$FechaT."') and ";
				$Consulta = $Consulta." (".$Pregunta.")  and (t1.cod_periodo='".$Periodo."') ";
				if ($Enabal =='S')
				{
					$Consulta = $Consulta." and enabal='S'"; 
				}
				if ($Tipo != '-1')
				{
					$Consulta = $Consulta." and t1.tipo='".$Tipo."'"; 
				}
				if ($Analisis != '-1')
				{
					$Consulta = $Consulta." and t1.cod_analisis='".$Analisis."'"; 
				}
				$Consulta = $Consulta." order by t3.cod_leyes"; 
				$cont=1;	 
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array($Resultado))
				{
					if($cont==5) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
					}
					echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."<input  type='hidden' value=".$Fila["abreviatura"]."></td>";
					$cont =$cont+ 1;
				}
			}
				?>
          </table><br>
       </td>		  
</tr>
</table>

	<p>&nbsp; </p>

</form></center>
</body>
</html>
