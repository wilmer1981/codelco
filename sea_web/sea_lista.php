<?php
$CodigoDeSistema = 2;
$CodigoDePantalla = 13;

$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$listados      = isset($_REQUEST["listados"])?$_REQUEST["listados"]:"";
$cmbmovimiento = isset($_REQUEST["cmbmovimiento"])?$_REQUEST["cmbmovimiento"]:"";
$cmblistados   = isset($_REQUEST["cmblistados"])?$_REQUEST["cmblistados"]:"";
$cmborigen = isset($_REQUEST["cmborigen"])?$_REQUEST["cmborigen"]:"";
$cmbrestos = isset($_REQUEST["cmbrestos"])?$_REQUEST["cmbrestos"]:"";
$cmbanodos = isset($_REQUEST["cmbanodos"])?$_REQUEST["cmbanodos"]:"";
$radio = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
$radio2= isset($_REQUEST["radio2"])?$_REQUEST["radio2"]:"";

?>
<html>
<head>
<title>Listados SEA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function recarga_listados()
{
 var f=formulario; 

 f.action="sea_lista.php?listados=S";
 f.submit(); 
}
function recarga_productos()
{
 var f=formulario; 
 var LargoForm = f.elements.length;
 var radio;
     
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radio") && (f.elements[i].checked == true))
		{
			 radio =  f.elements[i].value;
			 
				if (f.cmborigen.value == -1)
				{
                  f.elements[i].value == '';
				  alert("Debe ingresar el origen de los anodos");
				  frm.cmborigen.focus(); 
				  return
				}			 
				 else
				 {
					f.action="sea_lista.php?listados=S&Proceso=R&radio="+radio;
					f.submit();
				 }
				

		}
	}
		 
		 
	
}

function ejecucion(opc)
{
 var f=formulario;

	if(f.radio[0].checked == false && f.radio[1].checked == false)
	{
		alert("Debe escoger si Listado es por Productos o por Flujos");
		return	
	}


	if (f.cmblistados.value != 6  && f.cmblistados.value != 9)
	{
		if(f.radio2[0].checked == false && f.radio2[1].checked == false && f.radio2[2].checked == false)
		{
			alert("Debe escoger si Listado es por Finos, Leyes ? Peso ");
			return	
		}
    }
	
	if (f.cmblistados.value != -1)
	{ 
		if (f.cmblistados.value==3)
		{
			if (opc == "W")
				f.action="sea_lst_carga_nave_electrolitica.php";
			else 
				f.action = "sea_xls_carga_nave_electrolitica.php";
			f.submit(); 
		}
		
		if (f.cmblistados.value==1)
		{   
			if (opc == "W")
				f.action = "sea_lst_recepcion.php";
			else 
				f.action = "sea_xls_recepcion.php";
		   f.submit(); 
		}
		
		if (f.cmblistados.value==12)
		{   
			if (opc == "W")
				f.action = "bli_lst_recep_blister.php";
			else 
				f.action = "bli_xls_recep_blister.php";
		   f.submit(); 		   
		}

		if (f.cmblistados.value==10)
		{   
			if (opc == "W")
				f.action = "sea_lst_recepcion_acumulado.php";
			else 
				f.action = "sea_xls_recepcion_acumulado.php";
		   f.submit(); 
		}
		
		if (f.cmblistados.value==2)
		{
			if (opc == "W")
				f.action = "sea_lst_beneficio_acumulados.php";
			else
				f.action = "sea_xls_beneficio_acumulados.php";
			f.submit();		
		}
		
		if (f.cmblistados.value==4)
		{
			if (opc == "W")
				f.action = "sea_lst_produccion_acumulada_restos.php";
			else 
				f.action = "sea_xls_produccion_acumulada_restos.php";
			f.submit();
		}
		
		if (f.cmblistados.value==6)
		{
			if (opc == "W")
				f.action = "sea_lst_produccion_diaria_restos.php";
			else
				f.action = "sea_xls_produccion_diaria_restos.php";
			f.submit();
		}
	
		if (f.cmblistados.value == 5)
		{
			if (opc == "W")			
				f.action = "sea_lst_produccion_restos.php";
			else
				f.action = "sea_xls_produccion_restos.php";
			f.submit();
		}

		if (f.cmblistados.value == 7)
		{
			if (f.radio[0].checked==true)
			{
				if (opc == "W")			
					f.action = "sea_lst_trasp_raf.php?cmbanodos="+f.cmbanodos.value+"&cmbrestos="+f.cmbrestos.value;
				else
					f.action = "sea_xls_trasp_raf.php?cmbanodos="+f.cmbanodos.value+"&cmbrestos="+f.cmbrestos.value;
			}
			else
			{
				if (opc == "W")			
					f.action = "sea_lst_trasp_raf.php";
				else
					f.action = "sea_xls_trasp_raf.php";
			}
			f.submit();
		}

		if (f.cmblistados.value == 8)
		{
			if (opc == "W")			
				f.action = "sea_lst_recha_raf.php";
			else
				f.action = "sea_xls_recha_raf.php";
			f.submit();
		}

		if (f.cmblistados.value == 9)
		{
			if (opc == "W")			
				f.action = "sea_lst_stock_piso.php";
			else
				f.action = "sea_xls_stock_piso.php";
			f.submit();
		}

		if (f.cmblistados.value == 11)
		{
			if (opc == "W")			
				f.action = "sea_lst_trasp_raf2.php";
			else
				f.action = "sea_xls_trasp_raf2.php";
			f.submit();
		}
		
		if (f.cmblistados.value == 13)
		{
			if (opc == "W")			
				f.action = "bli_lst_blister_raf.php";
			else
				f.action = "bli_xls_blister_raf.php";
			f.submit();
		}
		
		if (f.cmblistados.value == 14)
		{
			if (opc == "W")			
				f.action = "bli_lst_blister_nave.php";
			else
				f.action = "bli_xls_blister_nave.php";
			f.submit();
		}

	}	
	else 
	{
		alert("Debe Escoger Tipo de Listado")
		f.cmblistados.focus()
		return
	}	
		
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}


</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td height="316" align="center" valign="top">
  <table width="88%" class="TablaInterior" cellpadding="3" cellspacing="0">
          <tr> 
            <td>Tipo Movimiento</td>
            <td width="34%"><font color="#FFFFFF"> 
              <SELECT name="cmbmovimiento" onChange="recarga_listados();">
                <?php
			include("../principal/conectar_principal.php");
          	
			echo '<option value="-1">SELECCIONAR</option>';
			$consulta1 = "SELECT * FROM sub_clase WHERE cod_clase = 2001";
			$rs1 = mysqli_query($link, $consulta1);
			while ($row = mysqli_fetch_array($rs1))
			{			
	          	if ($row["cod_subclase"] == $cmbmovimiento)	
					echo '<option value="'.$row["cod_subclase"].'" Selected>'.$row["nombre_subclase"].'</option>';
				else 
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}
		?>
              </SELECT>
              </font></td>
          </tr>
          <tr> 
            <td width="16%" height="27">Tipo Listado</td>
            <td><font color="#FFFFFF"> 
              <SELECT name="cmblistados" onChange="recarga_listados();">
                <?php
   		echo '<option value="-1" Selected>SELECCIONAR</option>';

    if($listados == 'S')       	
   {

		
		if($cmbmovimiento == 1)
		{	
			if($cmblistados == 1)
			echo '<option value="1" Selected>Producci&oacute;n/Recepci&oacute;n de &Aacute;nodos Diaria</option>';
			else
			echo '<option value="1">Producci&oacute;n/Recepci&oacute;n de &Aacute;nodos Diaria</option>';

			if($cmblistados == 10)
			echo '<option value="10" Selected>Producci&oacute;n/Recepci&oacute;n de &Aacute;nodos Acumulada</option>';
			else
			echo '<option value="10">Producci&oacute;n/Recepci&oacute;n de &Aacute;nodos Acumulada</option>';

			if($cmblistados == 12)
			echo '<option value="12" Selected>Recepci&oacute;n de Blister</option>';
			else
			echo '<option value="12">Recepci&oacute;n de Blister</option>';
        }  


		if($cmbmovimiento == 2)
		{	
			if($cmblistados == 2)
			echo '<option value="2"Selected>Beneficio Total Acumulado</option>';
			else
			echo '<option value="2">Beneficio Total Acumulado</option>';

			if($cmblistados == 3)
			echo '<option value="3" Selected>Carga A N.E. Acumulada</option>';
			else
			echo '<option value="3">Carga A N.E. Acumulada</option>';

			if($cmblistados == 14)
			echo '<option value="14" Selected>Blister A N.E. Acumulada</option>';
			else
			echo '<option value="14">Blister A N.E. Acumulada</option>';
        }
		
		
		if($cmbmovimiento == 3)
		{	
			if($cmblistados == 4)
			echo '<option value="4" Selected>Producci&oacute;n Acumulada por Grupos de Restos</option>';
			else
			echo '<option value="4">Producci&oacute;n Acumulada por Grupos de Restos</option>';

			if($cmblistados == 5)
			echo '<option value="5" Selected>Producci&oacute;n Acumulada de Restos</option>';
			else
			echo '<option value="5">Producci&oacute;n Acumulada de Restos</option>';

			if($cmblistados == 6)
			echo '<option value="6" Selected>Producci&oacute;n Diaria Acumulada de Restos</option>';
			else
			echo '<option value="6">Producci&oacute;n Diaria Acumulada de Restos</option>';

        }	


		if($cmbmovimiento == 4)
		{	
			if($cmblistados == 7)
			echo '<option value="7" Selected>Traspaso de Restos a Raf Por Grupo</option>';
			else
			echo '<option value="7">Traspaso de Restos a Raf Por Grupo</option>';

			if($cmblistados == 11)
			echo '<option value="11" Selected>Traspaso de Restos a Raf</option>';
			else
			echo '<option value="11">Traspaso de Restos a Raf</option>';

			if($cmblistados == 8)
			echo '<option value="8" Selected>Rechazados a Raf</option>';
			else
			echo '<option value="8">Rechazados a Raf</option>';

			if($cmblistados == 9)
			echo '<option value="9" Selected>Stock Piso Raf</option>';
			else
			echo '<option value="9">Stock Piso Raf</option>';

			if($cmblistados == 13)
			echo '<option value="13" Selected>Blister a Raf</option>';
			else
			echo '<option value="13">Blister a Raf</option>';
			
		}	
	
	}		
	?>
              </SELECT>
              </font></td>
          </tr>
          <tr> 
            <td>Origen &Aacute;nodos</td>
            <td><font color="#FFFFFF"> 
              <SELECT name="cmborigen" onChange="recarga_productos();">
                <?php
			include("../principal/conectar_principal.php");
          	
        	if (($cmborigen == 'T') and ($Proceso == 'R'))				
			echo '<option value="T" Selected>Todos</option>';
			else
			echo '<option value="T" Selected>Todos</option>';

			$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2002 ";
			$rs = mysqli_query($link, $consulta);

			while ($row = mysqli_fetch_array($rs))
			{			
	          	if (($row["cod_subclase"] == $cmborigen) and ($Proceso == 'R'))	
					echo '<option value="'.$row["cod_subclase"].'" Selected>'.$row["nombre_subclase"].'</option>';
				else 
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}
			

           					
		?>
              </SELECT>
              </font></td>
            <td width="14%">Listar por </td>
            <td width="15%"> 
              <?php
	  if($radio == 'P')
	  {
	  echo '<input type="radio" name="radio" value="P" checked onClick="recarga_productos();">';
	  }
	  else
	  {
	  echo '<input type="radio" name="radio" value="P" onClick="recarga_productos();">';
	  }
	  ?>
              Productos</td>
            <td width="14%"> 
              <?php
	  if ($radio == 'F')
	  {
      echo '<input type="radio" name="radio" value="F" checked onClick="recarga_productos();">';
	  }
	  else
      {
	  echo '<input type="radio" name="radio" value="F" onClick="recarga_productos();">';
	  }
	  ?>
              Flujos</td>
          </tr>
          <tr> 
            <td colspan="5">&nbsp;</td>
          </tr>
        </table>
  
        <?php
 if($Proceso =='R')
 {
include("../principal/conectar_principal.php");
/************************************** Productos ******************************/
	if($radio=='P' and $cmborigen!='T')
	{	
	   
		 $consulta2 = "SELECT * FROM sub_clase WHERE cod_clase=2002 and cod_subclase = '".$cmborigen."'";
		 $rs2 = mysqli_query($link, $consulta2);
			 if($row1 = mysqli_fetch_array($rs2))
			 {	
				$producto1=$row1['valor_subclase1'];
				$producto2=$row1['valor_subclase2'];
				$producto3=$row1['valor_subclase3'];
           	 } 
         
		 echo '<br><table width="88%" class="TablaInterior" cellpadding="3" cellspacing="0">';

/*********** anodos de cobre ********/
  		 if($cmbmovimiento == 1 || $cmbmovimiento == 10 || $cmbmovimiento == 2 || $cmbmovimiento == 4)
		 {
			echo'<tr><td width="100">&Aacute;nodos de Cobre</td>';
			echo "<td><SELECT name='cmbanodos'>";           

        	if (($cmbanodos == 'T') and ($Proceso == 'R'))				
			echo '<option value="T" Selected>Todos</option>';
			else
			echo '<option value="T" Selected>Todos</option>';

			$consulta3 = "SELECT * FROM subproducto WHERE cod_producto = '17' and cod_subproducto in('$producto1','$producto2','$producto3')";
			$rs3 = mysqli_query($link, $consulta3);
		   
			while($row3 = mysqli_fetch_array($rs3))						
			{			
			if ($row3['cod_subproducto'] == $cmbanodos and ($Proceso == 'R'))
				echo '<option value="'.$row3['cod_subproducto'].'" Selected>'.$row3['descripcion'].'</option>';
			else 
				echo '<option value="'.$row3['cod_subproducto'].'">'.$row3['descripcion'].'</option>';
			}

			 echo"</SELECT></td>";
		 }

			 
/***********  restos anodos ********/
		 if($cmbmovimiento == 2 || $cmbmovimiento == 3 || $cmbmovimiento == 4)
		 {
			echo '<td width="105">Restos de &Aacute;nodos</td>';
			
			echo "<td><SELECT name='cmbrestos'>";           

        	if (($cmbrestos == 'T') and ($Proceso == 'R'))				
			echo '<option value="T" Selected>Todos</option>';
			else
			echo '<option value="T" Selected>Todos</option>';

			$consulta4 = "SELECT * FROM subproducto WHERE cod_producto = '19' and cod_subproducto in('$producto1','$producto2','$producto3')";
			$rs4 = mysqli_query($link, $consulta4);

			while($row4 = mysqli_fetch_array($rs4))						
			{			
			if ($row4['cod_subproducto'] == $cmbanodos and ($Proceso == 'R'))
				echo '<option value="'.$row4['cod_subproducto'].'" Selected>'.$row4['descripcion'].'</option>';
			else 
				echo '<option value="'.$row4['cod_subproducto'].'">'.$row4['descripcion'].'</option>';
			}

			 echo"</SELECT></td>";
		  } 
			 echo "</tr></table>";        	
     }
	 
/********************** Flujos ********************************/
    if($radio == 'F' and $cmborigen!='T')
	{
		echo '<br><table width="88%" class="TablaInterior" cellpadding="3" cellspacing="0">';
		
/***********  flujos anodos ********/
		 if($cmbmovimiento == 1 || $cmbmovimiento == 10 || $cmbmovimiento == 2 || $cmbmovimiento == 4)
		 {
            echo'<tr><td width="100">&Aacute;nodos de Cobre</td>';
			echo "<td><SELECT name='cmbflujo'>";           
			
        	if (($cmbflujo == 'T') and ($Proceso == 'R'))				
			echo '<option value="T" Selected>Todos</option>';
			else
			echo '<option value="T" Selected>Todos</option>';

			$consulta5 = "SELECT distinct flujo, descripcion FROM relacion_prod_flujo_nodo AS t1 INNER JOIN flujos AS t2";
			$consulta5 = $consulta5." ON t1.flujo = t2.cod_flujo"; 
			$consulta5 = $consulta5." WHERE t1.cod_proceso = '".$cmbmovimiento."' and t1.cod_producto=17 and t1.cod_origen = '".$cmborigen."' order by t1.flujo";
			$rs5 = mysqli_query($link, $consulta5);
			while($row5 = mysqli_fetch_array($rs5))						
			{
			if ($row5["flujo"] == $cmbflujo and ($Proceso == 'R'))
				echo '<option value="'.$row5["flujo"].'" Selected>'.$row5['flujo'].' '.$row5["descripcion"].'</option>';
			else
				echo '<option value="'.$row5['flujo'].'">'.$row5['flujo'].' '.$row5["descripcion"].'</option>';
			}
	
			echo'</SELECT></td>';
	    }

/***********  flujos restos ********/
		 if($cmbmovimiento == 2 || $cmbmovimiento == 3 || $cmbmovimiento == 4)
		 {
            echo'<td width="110">Restos de &Aacute;nodos</td>';
			echo "<td><SELECT name='cmbflujorestos'>";           

        	if (($cmbflujorestos == 'T') and ($Proceso == 'R'))				
			echo '<option value="T" Selected>Todos</option>';
			else
			echo '<option value="T" Selected>Todos</option>';

			$consulta5 = "SELECT distinct flujo, descripcion FROM relacion_prod_flujo_nodo AS t1 INNER JOIN flujos AS t2";
			$consulta5 = $consulta5." ON t1.flujo = t2.cod_flujo"; 
			$consulta5 = $consulta5." WHERE t1.cod_proceso = '".$cmbmovimiento."' and t1.cod_producto=19 and t1.cod_origen = '".$cmborigen."' order by t1.flujo";
			$rs5 = mysqli_query($link, $consulta5);
			//echo $consulta5;
			while($row5 = mysqli_fetch_array($rs5))						
			{
			if ($row5["flujo"] == $cmbflujo and ($Proceso == 'R'))
				echo '<option value="'.$row5["flujo"].'" Selected>'.$row5['flujo'].' '.$row5["descripcion"].'</option>';
			else
				echo '<option value="'.$row5['flujo'].'">'.$row5['flujo'].' '.$row5["descripcion"].'</option>';
			}
	
			echo'</SELECT></td>';
	    }
	 echo '</tr><table>';
   }	 
}  	
?>
  
<?php
/*****************/
  if($cmblistados !='6' && $cmblistados !='9')
  {      

   echo '<br><table width="88%" class="TablaInterior" cellpadding="3" cellspacing="0">
          <tr>
            <td width="25%">&nbsp;</td>
            <td width="18%">';
				  if($radio2 == 'P')
				  {
				  echo '<input type="radio" name="radio2" value="P" checked >';
				  }
				  else
				  {
				  echo '<input type="radio" name="radio2" value="P" >';
				  }
			
				  echo'Pesos';
			
           echo' </td>
               <td width="15%">';
              
				  if ($radio2 == 'L')
				  {
				  echo '<input type="radio" name="radio2" value="L" checked >';
				  }
				  else
				  {
				  echo '<input type="radio" name="radio2" value="L" >';
				  }
			  
				echo'Leyes';
            echo '</td>
                  <td width="42%">';
		  if ($radio2 == 'F')
		  {
		  echo '<input type="radio" name="radio2" value="F" checked >';
		  }
		  else
		  {
		  echo '<input type="radio" name="radio2" value="F" >';
		  }
      
      	echo'Finos';
	  
		
      echo'   </td>
          </tr>
        </table>';
	}	
		
	?>	
   <br>	
  <table width="88%" class="TablaInterior" cellpadding="3" cellspacing="0">
          <tr> 
            <?php
if($cmblistados != 6)
{			
			echo '<td width="95">Fecha Inicio</td>';
            echo '<td><SELECT name="dia_i" size="1" style="font-face:verdana;font-size:10">';
                
    			for ($i=1;$i<=31;$i++)
				{
					if (isset($dia_i))
					{
						if ($i == $dia_i)
							echo "<option Selected value='".$i."'>".$i."</option>";
						else	echo "<option value='".$i."'>".$i."</option>";
					}
					else
					{
						if ($i == date("j"))
							echo "<option Selected value='".$i."'>".$i."</option>";
						else	echo "<option  value='".$i."'>".$i."</option>";
					}								    		
 				}
		
	       echo '</SELECT> <SELECT  name="mes_i" size="1" id="SELECT" style="FONT-FACE:verdana;FONT-SIZE:10">';
       
	           
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $listados =='S')
		{
		
		    for($i=1;$i<13;$i++)
		    {
				if (isset($mes_i))
				{
					if ($i==$mes_i)	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i==date("n"))	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
               if (isset($mes_i))
				{
					if ($i==$mes_i)	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i==date("n"))	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
    
              echo '</SELECT> <SELECT name="ano_i" size="1" id="SELECT2"  style="FONT-FACE:verdana;FONT-SIZE:10">';
                
	if($Proceso=='V' || $listados =='S')
	{
	    for ($i=date("Y")-2;$i<=date("Y")+1;$i++)	
	    {
			if (isset($ano_i))
			{
				if ($i==$ano_i)
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-2;$i<=date("Y")+1;$i++)	
	    {
            if (isset($ano_i))
			{
				if ($i==$ano_i)
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	

        echo '</SELECT></td>';
		
}
?>
            <?php  
           if($cmblistados != 6) 
		      echo '<td colspan="2">Fecha T&eacute;rmino</td>';
		   else
              echo '<td colspan="2">Fecha</td>';
?>
            <td width="214"><SELECT name="dia_t" size="1" id="SELECT3" style="font-face:verdana;font-size:10">
                <?php
			if($Proceso=='V' || $listados =='S')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if (isset($dia_t))
					{
						if ($i == $dia_t)
							echo "<option Selected value='".$i."'>".$i."</option>";
						else	echo "<option value='".$i."'>".$i."</option>";
					}
					else
					{
						if ($i == date("j"))
							echo "<option Selected value='".$i."'>".$i."</option>";
						else	echo "<option  value='".$i."'>".$i."</option>";
					}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				if (isset($dia_t))
					{
						if ($i == $dia_t)
							echo "<option Selected value='".$i."'>".$i."</option>";
						else	echo "<option value='".$i."'>".$i."</option>";
					}
					else
					{
						if ($i == date("j"))
							echo "<option Selected value='".$i."'>".$i."</option>";
						else	echo "<option  value='".$i."'>".$i."</option>";
					}		    		
 				}
		   }			
	?>
              </SELECT> <SELECT name="mes_t" size="1" id="SELECT4" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $listados =='S')
		{
		
		    for($i=1;$i<13;$i++)
		    {
                if (isset($mes_t))
				{
					if ($i==$mes_t)	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i==date("n"))	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if (isset($mes_t))
				{
					if ($i==$mes_t)	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i==date("n"))	
						echo "<option Selected value ='".$i."'>".$meses[$i-1]." </option>";			
					else	echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
              </SELECT> <SELECT name="ano_t" size="1" id="SELECT7"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($Proceso=='V' || $listados =='S')
	{
	    for ($i=date("Y")-2;$i<=date("Y")+1;$i++)	
	    {
            if (isset($ano_t))
			{
				if ($i==$ano_t)
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-2;$i<=date("Y")+1;$i++)	
	    {
            if (isset($ano_t))
			{
				if ($i==$ano_t)
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option Selected value ='$i'>$i</option>";
				else	echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
              </SELECT></td>
          </tr>
          <tr> 
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="7"><div align="center"> 
                <input name="ejecutarweb" type="button" value="Ejecutar Web" onClick="ejecucion('W');">
                <input name="ejecutarexcel" type="button" value="Ejecutar Excel" onClick="ejecucion('E');">
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>
  </td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>  
  
</form>
</body>
</html>
