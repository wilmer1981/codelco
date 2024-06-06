<?php
$CodigoDeSistema = 1;
$CodigoDePantalla = 86;
include("../principal/conectar_principal.php");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$HoraActual = date("H");
$MinutoActual = date("i");


if($CmbProductos!='T' && $CmbProductos!='' )
{
	$Consulta="select t1.cod_leyes from cal_web.exclusion_leyes_electroplasma t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes where not isnull(t2.Homologacion_ley_GD) ";
		$Consulta.=" and cod_producto='".$CmbProductos."'";
	if($CmbSubProducto!='T')
		$Consulta.=" and cod_subproducto='".$CmbSubProducto."'";
	$Respuesta = mysqli_query($link, $Consulta);$i=0;
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		
		$Leyes[$i][0]=$Fila["cod_leyes"];
		$i=$i++;
	}
}
else
{
	
		$Consulta="select cod_leyes from cal_web.exclusion_leyes_electroplasma group by cod_leyes";
	$Respuesta = mysqli_query($link, $Consulta);$i=0;
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		
		$Leyes[$i][0]=$Fila["cod_leyes"];
		$i=$i++;
	}

	}

?>
<html>
<head>
<title>Administracion de Solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--LAYERS
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false


function activar(op){
	var frm=document.FrmIngLeyes;
  switch(op)
  {
  case "1":
    for (i=0;i<document.FrmIngLeyes.checkLeyes.length;i++) 
       if(document.FrmIngLeyes.checkLeyes[i].type == "checkbox") 
          document.FrmIngLeyes.checkLeyes[i].checked=1 
 	
	break;
	case "2":
	 for (i=0;i<document.FrmIngLeyes.checkImpurezas.length;i++) 
       if(document.FrmIngLeyes.checkImpurezas[i].type == "checkbox") 
          document.FrmIngLeyes.checkImpurezas[i].checked=1 
 	
	
	break;
	
	case "3":
		 for (i=0;i<document.FrmIngLeyes.checkFisicas.length;i++) 
       if(document.FrmIngLeyes.checkFisicas[i].type == "checkbox") 
          document.FrmIngLeyes.checkFisicas[i].checked=1 
 	
	break;
}

}
function muestra(numero) 
{
	//alert(numero);
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 130 ");
			//eval("Txt" + numero + ".style.top = document.checkTodos.top ");
			//eval("Txt" + numero + ".style.top = window.event.y ");
		}
	}
}

function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
// FIN LAYERS-->
function Proceso(Opcion)
{
	var frm=document.FrmIngLeyes;
	switch (Opcion)
	{
		case "R":
			frm.action="cal_mantenedor_exclusion_leyes_producto.php";
			frm.submit();
			break;
		
		case "S":
			Salir();
			break;	
	
	}	
}

function Guardar(Opcion)
{
	var frm=document.FrmIngLeyes;
	var Leyes=""
	for (i=0;i<document.FrmIngLeyes.elements.length;i++) 
	{
		 if(document.FrmIngLeyes.elements[i].type == "checkbox") 
       	 {
			if(document.FrmIngLeyes.elements[i].checked==true && document.FrmIngLeyes.elements[i].value!="")
		 	{
				Leyes=Leyes+document.FrmIngLeyes.elements[i].value+";"
			}
		}
	}
		

		frm.action="cal_mantenedor_exclusion_leyes_producto01.php?Leyes="+Leyes;
		frm.submit();
	
}
function Salir()
{
	var frm =document.FrmIngLeyes;
	frm.action="cal_adm_ingreso_leyes01.php?Opcion=S";
	frm.submit(); 
}
function Buscar()
{
	var frm=document.FrmIngLeyes;
	frm.action ="cal_adm_ingreso_leyes.php?Mostrar=S";  
	frm.submit();
		
}

</script></head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmIngLeyes" method="post" action="">
  <?php 	 include("../principal/encabezado.php")?>
  <?php
			echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			echo"<tr>";
			$cont=1;	 
			$Consulta= "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes where not isnull(t3.Homologacion_ley_GD) and  t1.tipo_leyes =3 order by t1.abreviatura";
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==7) 
				{
					echo '</tr>';
					echo '<tr>';
					$cont=1;
				}
				echo "<td width='150' align='left'><input type='checkbox' name ='checkFisicas' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];		
				echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
				
				echo "</td>";
				$cont =$cont+ 1;
			}
    		echo"</table>";
		 ?>
  <table width="770"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="759"> <table width="756"border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
                
          <tr> 
            <td height="29">Producto: </td>
            <td height="29"><select name="CmbProductos" style="width:220" onChange="Proceso('R');">
                <option value='T' selected>Todos</option>
                <?php
				$Consulta="select cod_producto,descripcion from productos order by descripcion"; 
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos==$Fila["cod_producto"])
					{
						echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				}
			?>
              </select></td>
            <td height="29">Sub Producto: </td>
            <td height="29"><select name="CmbSubProducto" style="width:220" onChange="Proceso('R');">
                <option value="T" selected>Todos</option>;
                <?php
			$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbSubProducto == $Fila["cod_subproducto"])
				{
					echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
				}
				else
				{
					echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}	
			}
		?>
              </select></td>
          </tr>
          <tr><td colspan="4">
          
             <table width="100%" height="23" border="0" class="ColorTabla01" cellpadding="3" cellspacing="0">
            <tr> 
              <td width="164" height="29" ><div align="left"><strong> 
                  <input name="checkLey" type="checkbox" id="checkLey" onClick="JavaScript:activar('1');" value="">
                  </strong>Todos</div></td>
              <td width="251" ><div align="center">Leyes</div></td>
              <td width="163" >&nbsp;</td>
            </tr>
          </table>
          
            <?php
	  			echo "<table width='100%' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
				echo "<tr>";
				$cont=1;	 
				$Consulta= "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad ";
				$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes where not isnull(t3.Homologacion_ley_GD) and  t1.tipo_leyes = 0  order by t1.abreviatura";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array($Resultado))
				{
			 		if($cont==7) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
			    	}
					$Encontro=false;
					if(!is_null($Leyes))
						reset($Leyes);
					for ($i=0;$i<count($Leyes);$i++)
					{
						if ($Fila["cod_leyes"]== $Leyes[$i][0])
						{
							$Ley=$Leyes[$i][0];
							$Unidad=$Leyes[$i][1];
							$Encontro=true;
							break;
						}					
					}
					if ($Encontro== false)
     				{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];
						echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";					
					}
					else
					{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."' checked>".$Fila["abrev"];
						echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
					}
					echo '</td>';
					$cont =$cont+ 1;
				}
				echo "</table>";
				?>
          <br>
          <table width="100%" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0">
            <tr> 
              <td width="164" height="23"><div align="left"><strong> 
                  <input name="checkImp" type="checkbox" id="checkImp" onClick="JavaScript:activar('2');" value="">
                  </strong>Todos<strong></strong></div></td>
              <td width="252"><div align="center">Impurezas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>
		  
   		  <?php
			echo "<table width='100%' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			echo"<tr>";
			$cont=1;	 
			$Consulta= "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes where not isnull(t3.Homologacion_ley_GD) and  t1.tipo_leyes = 1 order by t1.abreviatura";
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==20) 
				{
					echo '</tr>';
					echo '<tr>';
					$cont=1;
				}
				$Encontro=false;
				if(!is_null($Leyes))
						reset($Leyes);
				for ($i=0;$i<count($Leyes);$i++)
				{
					if ($Fila["cod_leyes"]== $Leyes[$i][0])
					{
						$Encontro=true;
						break;
					}					
				}
				if ($Encontro == false)
   				{
					echo "<td width='150' align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];		
					echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
				}
				else
				{
					echo "<td width='150' align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."' checked>".$Fila["abrev"];						
					echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
				}	
				echo "</td>";

				$cont =$cont+ 1;
			}
    		echo"</table>";
          ?>
          
          </td></tr>
          <tr> 
            <td height="26" colspan="4"> <table width="759" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
              <tr> 
                <td align="center"><input name="BtnGuardar" type="button" value="Guardar" style="width:70" onClick="Guardar();">
                  &nbsp; 
                  <input name="BtnSalir" type="button" value="Salir" style="width:70" onClick="Proceso('S');">
                  </td>
                </tr>
            </table></td>
          </tr>
        </table>
	



 
  <table  width="100%" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
   <tr>
  <td colspan="3" align="center"  class="ColorTabla01">LISTADO EXCLUIDOS EN GDPLUS <!--<span class="InputRojo">(Estos Productos con leyes NO se procesan )</span>--></td>
 </tr>
  <tr  class="ColorTabla01">
  <td>Producto</td>
  <td>SubProducto</td>
  <td>Ley</td>
 </tr>
  <?php
  $Consulta="select t2.abreviatura as LEY,t3.descripcion as PRODUCTO,t4.descripcion as SUBPRODUCTO,t1.cod_leyes from cal_web.exclusion_leyes_electroplasma t1 ";
  $Consulta.=" inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
  
  $Consulta.=" inner join proyecto_modernizacion.productos t3 on t1.cod_producto=t3.cod_producto ";
  
  $Consulta.=" inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto=t4.cod_producto and  t1.cod_subproducto=t4.cod_subproducto ";
  $Consulta.=" where not isnull(t2.Homologacion_ley_GD) ";
 	if($CmbProductos!='T' && $CmbProductos!='')
		$Consulta.=" and t1.cod_producto='".$CmbProductos."'";
	if($CmbSubProducto!='T'  && $CmbSubProducto!='')
		$Consulta.=" and t1.cod_subproducto='".$CmbSubProducto."'";
	$Respuesta = mysqli_query($link, $Consulta);$i=0;
	//echo $Consulta."<br>";
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		
		?>
		 <tr>
  <td><?php echo $Fila[PRODUCTO];?></td>
   <td><?php echo $Fila[SUBPRODUCTO];?></td>
   <td><?php echo $Fila[LEY];?></td>
 </tr>
		
		<?php
	}
  ?>
  </table>
       </td>
    </tr>
  </table>
 
          </td>		  
</tr>
</table>
  
  
  
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
