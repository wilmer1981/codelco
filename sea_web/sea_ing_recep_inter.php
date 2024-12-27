<?php
 require("../principal/conectar_principal.php");
$CodigoDeSistema = 2;
$CodigoDePantalla = 3;

if(isset($_REQUEST["proveedor"])) {
	$proveedor = $_REQUEST["proveedor"];
}else{
	$proveedor = '';
}
if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}
if(isset($_REQUEST["mostrar"])) {
	$mostrar = $_REQUEST["mostrar"];
}else{
	$mostrar = '';
}

if(isset($_REQUEST["dia"])) {
	$dia = $_REQUEST["dia"];
}else{
	$dia = date("d");
}
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes =  date("m");
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano =  date("Y");
}
if(isset($_REQUEST["Hora"])) {
	$Hora = $_REQUEST["Hora"];
}else{
	$Hora = "";
}
if(isset($_REQUEST["Minutos"])) {
	$Minutos = $_REQUEST["Minutos"];
}else{
	$Minutos = date("i");
}
if(isset($_REQUEST["FechaMov"])) {
	$FechaMov = $_REQUEST["FechaMov"];
}else{
	$FechaMov = date("Y-m-d");
}

$HoraAux=date('G');
$MinAux=date('i');
if($Hora=="")
{
	if(intval($HoraAux)>=0&&intval($HoraAux)<8)
	{
		$Hora="07";
		$Minutos="59";
	}
	if(intval($HoraAux)>=8&&intval($HoraAux)<16)
	{
		$Hora="15";
		$Minutos="59";
	}
	if(intval($HoraAux)>=16&&intval($HoraAux)<=23)
	{
		$Hora="23";
		$Minutos="59";
	}
}	

?>
<html>
<head>
<title>Recepci&oacute;n Productos Intermedios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Traspasa_Lote(f,pos)
{
var posi = pos;

	f.elements[posi+2].value = f.elements[posi-6].value;
}	

function Traspasa_Lote1(f,pos)
{
var posi = pos;

	
	if(f.elements[posi-9].value == '')
		f.elements[posi+3].value = f.elements[posi-5].value;
	else
		f.elements[posi+3].value = f.elements[posi-9].value;
	
}	

function Buscar_Lote(f,pos)
{
var posi = pos;
	subproducto = f.elements[posi].value;
	valores = "&proveedor=" + f.proveedor.value + "&subproducto=" + subproducto + "&pos=" + posi;
//	f.action="sea_ing_recep_inter.php?mostrar=S" + valores;
//	f.submit();
	
//	alert(posi);
}	

function buscar_guia()
{
	window.open("sea_ing_recep_ext03.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
}	

function Datos_Ingresados()
{
var f = frmPrincipal;

       	window.open("sea_ing_recep_ext04.php", "","menubar=no resizable=no Top=10 Left=200 width=590 height=700 scrollbars=no");

}

function Guardar_Datos2(f,i)
{
var f = frmPrincipal;
var posi = 17;
var posi2 = 25;
var tope = i;
	if(i != '')	
	{
		for(j = 0; j < tope; j++)
		{   
			if(f.elements[posi].value == -1)
			{ 
				alert("Debe Seleccionar El Subproducto");
				f.elements[posi].focus()
				return
			}
			posi = posi + 18;
		}

		for(j = 0; j < tope; j++)
		{   
			if(f.elements[posi2].value == '')
			{ 
				alert("Debe Ingresar las Unidades");
				f.elements[posi2].focus()
				return
			}
			posi2 = posi2 + 18;
		}
	}
		f.action="sea_ing_recep_inter01.php?Proceso=G";
        f.submit();
  		
}

function Guardar_Datos()
{
var f = frmPrincipal;

		f.action="sea_ing_recep_inter01.php?Proceso=G";
        f.submit();  		
}

function Modificar_Datos()
{
var f = frmPrincipal;
  		f.action="sea_ing_recep_inter01.php?Proceso=M";
        f.submit();  		
}

function Recarga()
{
var f = frmPrincipal;
		f.action="sea_ing_recep_inter.php?Proceso=V";
        f.submit();
  		
}

function Crear_Detalle(i)
{

	var f = frmPrincipal;
	var guia = '';
	var patente = '';
	var fecha = '';
	var LargoForm = f.elements.length;
	var Valores = "";
	var valor=0;
    guia = eval("f.guia_"+i+".value");
    patente = eval("f.patente_"+i+".value");
	fecha=f.ano.value+"-"+f.mes.value+"-"+f.dia.value;
	Valores = "?mostrar2=S&guia_aux=" + guia + "&patente=" + patente + "&fecha=" + fecha ;  
	window.open("sea_ing_recep_ext.php"+ Valores, "","menubar=no resizable=no Top=50 Left=200 width=770 height=410 scrollbars=no");
	

}

function nueva_guia()
{
var f = frmPrincipal;
   	window.open("sea_ing_guia.php", "","menubar=no resizable=no Top=50 Left=200 width=550 height=300 scrollbars=no");
}

function Agregar(f,p)
{
	
var valor = f.elements[p-1].value;

	if (valor == -1)
	{
		alert("Debe Seleccionar un Color");
		return;
	}
	
	if (valor == -2) 
		document.formulario.elements[p-2].value = "";
	else
		document.formulario.elements[p-2].value = f.elements[p-2].value + valor;				 
}

function mostrar_guia()
{
var f = frmPrincipal;

	f.action="sea_ing_recep_inter.php?mostrar=S";
	f.submit();

}

function salir_menu()
{
	
var f=frmPrincipal;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}	
</script>

<style type="text/css">

body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head> 

<body>
<form name="frmPrincipal" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <input name="PProveedor" type="hidden" value="PProveedor">
<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="800" align="center" valign="top" >
	  <table width="760" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td>Origen Anodo-Blister</td>
            <td>
              <?php
			   echo'<select name="proveedor" onChange="Recarga()">';
			   echo'<option value="-1" seleted>Seleccionar</option>';

               if($proveedor == "A-00001100-2")
			   	echo'<option value="A-00001100-2" selected>ANODOS HVL</option>';		   
               else
			   	echo'<option value="A-00001100-2">ANODOS HVL</option>';		   

              /* if($proveedor == "A-61704005-0")
			   	echo'<option value="A-61704005-0" selected>ANODOS TENIENTE</option>';		   
               else
			   	echo'<option value="A-61704005-0">ANODOS TENIENTE</option>';		   

			    if($proveedor == "A-90132000-4")
			   	echo'<option value="A-90132000-4" selected>ANODOS SUR ANDES</option>';		   
			   else
			   	echo'<option value="A-90132000-4">ANODOS SUR ANDES</option>';		*/
				
				
				 if($proveedor == "A-77762940-9")
			   	echo'<option value="A-77762940-9" selected>ANODOS ANGLO AMERICAN SUR SA</option>';		   
			   else
			   	echo'<option value="A-77762940-9">ANODOS ANGLO AMERICAN SUR SA</option>';		

				
				 
				
				echo '<option value="0">--------------------</option>';
			//BLISTER
			
			
			
			
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 16 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);		
			while ($row = mysqli_fetch_array($rs))
			{				
				if ('B-'.$row["cod_subclase"] == $proveedor)					
					echo '<option value="B-'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else 
					echo '<option value="B-'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}														   
		    ?>
            </td>
            <td>Fecha</td>
            <td><font color="#000000" size="2">
              <select name="dia" size="1" style="font-face:verdana;font-size:10">
                <?php
			if($mostrar=='S' || $Proceso == 'V')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
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
	   				   if ($i==date("d"))
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
              </select>
              </font> <font color="#000000" size="2"> 
              <select name="mes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($mostrar=='S' || $Proceso == 'V')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
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
                if ($i==date("m"))
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
              </select>
    <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($mostrar=='S' || $Proceso == 'V')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
			{
			echo "<option selected value ='$i'>$i</option>";
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
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
              </select>
              </font></td>
            <td><input name="mostrar" type="button" value="Ok" onClick="mostrar_guia();">              
              <input name="nuevo" type="button" value="Ingreso Manual" style="width:100" onClick="nueva_guia();">            </td></tr>
          <tr> 
            <td width="125">&nbsp;</td>
            <td width="206">&nbsp;</td>
            <td width="37">Hora</td>
            <td width="201"><font size="1"><font size="2">
              <select name="Hora">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </select>
              <strong>:</strong>
              <select name="Minutos">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos))
					{	
						if ($Minutos == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </select>
            </font></font></td>
            <td width="171">
              <input name="ver datos" type="button" value="Datos Ingresados" style="width:130" onClick="Datos_Ingresados();">
              <font color="#333333" size="2">
              <input name="buscar_g" type="button"  value="Modificar Gu&iacute;a" style="width:130" onClick="buscar_guia();">
              </font></td>
          </tr>
        </table>
	  <br>

        <table width="760" height="22" border="1" cellpadding="1" cellspacing="0" class="TablaDetalle">
<?php //Anodos HVL

$prov="";
echo "Mostrar:".$mostrar."<br>";
echo "proveedor:".$proveedor."<br>";
 if ($mostrar=="S" && $proveedor == "A-00001100-2")	
 {
	 echo "Ingreso 1";
	  $prov = substr($proveedor,2,10);
	  $prov=intval(substr($prov,0,8))."-".substr($prov,9,1);
	  echo'<tr class="ColorTabla01"> 
		<td width="43" height="20">Distrib.</td>
		<td width="48"><div align="center">Guia</div></td>
		<td width="58"><div align="center">Patente</div></td>
		<td width="57"><div align="center">Lote V.</div></td>
		<td width="54"><div align="center">Recargo</div></td>
		<td width="67"><div align="center">Peso Recep</div></td>
		<td width="53"><div align="center">Hornada</div></td>
		<td width="60"><div align="center">Unidades</div></td>
		<td width="66"><div align="center">Lote O.</div></td>
		<td width="186"><div align="center">Marca</div></td>
	  </tr>';

		$fecha = $ano.'-'.$mes.'-'.$dia;
		$unidades = '';
		$cont = 20;
	  if($proveedor != "-1")
	  {
			$consulta = "SELECT distinct guia_despacho as GUIADP_A, patente as PATENT_A, lote as LOTE_A, hora_entrada as HORA_A ";
			$consulta.= " FROM sipa_web.recepciones ";
			$consulta.= " WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND RUT_PRV = '".$prov."' and peso_neto <> '0' ";
			$consulta.=" ORDER BY HORA_ENTRADA";
			//require("../principal/conectar_rec_web.php");
			
			$rs = mysqli_query($link, $consulta);
      }
	  else
	  {
			$consulta = "SELECT distinct GUIA_DESPACHO AS GUIADP_A, PATENTE AS PATENT_A, LOTE AS LOTE_A ";
			$consulta.= " FROM sipa_web.recepciones WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' ";
			$consulta.=" ORDER BY GUIA_DESPACHO ";
			//require("../principal/conectar_rec_web.php");
			
			$rs = mysqli_query($link, $consulta);
	  }	
	  $i =0;
	  while($row = mysqli_fetch_array($rs))
 	  {
			$i = $i + 1;
			$unidades = '';
	
			//require("../principal/conectar_rec_web.php");
			$consulta = "SELECT GUIA_DESPACHO AS GUIADP_A, FECHA AS FECHA_A, PATENTE AS PATENT_A, LOTE AS LOTE_A, RECARGO AS RECARG_A, PESO_NETO AS PESONT_A ";
			$consulta.= " FROM SIPA_WEB.recepciones WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND GUIA_DESPACHO = ".$row["GUIADP_A"]." ";
			$consulta.= " AND LOTE = '".$row["LOTE_A"]."' AND PATENTE = '".$row["PATENT_A"]."' and estado <>'A'";
			//echo $consulta;
			$result = mysqli_query($link, $consulta);
			if($row1 = mysqli_fetch_array($result))
			{	$hornada = '';
				 $lote_origen = '';
				 $marca = '';
				 $guia = $row1['GUIADP_A'];
				 $patente = $row1['PATENT_A'];
				 $recargo = $row1["RECARG_A"];
				 $lote_ventana = $row1['LOTE_A'];
	
				 $consulta_s = "SELECT SUM(PESO_NETO) AS peso_t ";
				 $consulta_s.= " FROM SIPA_WEB.recepciones WHERE GUIA_DESPACHO = '".$row["GUIADP_A"]."' ";
				 $consulta_s.= " AND PATENTE = '".$row["PATENT_A"]."' and estado <>'A' ";
				 $consulta_s.= " AND LOTE = '".$row["LOTE_A"]."' AND FECHA ='".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' ";
				 $result_s = mysqli_query($link, $consulta_s);
					
				 if ($row_s = mysqli_fetch_array($result_s))
				 {
						$peso_recepcion = $row_s["peso_t"];
				 }
				$fecha2=date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano));		
				$FechaInicio =date("Y-m-d", mktime(1,0,0,$mes,$dia,$ano))." 08:00:00";		
				$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano))." 07:59:59";
				

				 //$consulta_u = "SELECT SUM(unidades) AS unid FROM movimientos WHERE fecha_movimiento between '$fecha' and '$fecha2' and hora between '$FechaInicio' and '$FechaTermino' AND campo1 = '$row["GUIADP_A"]' AND campo2 = '$row["PATENT_A"]'";
				 $consulta_u = "SELECT SUM(unidades) AS unid FROM sea_web.movimientos WHERE fecha_movimiento between '".$fecha."' and '".$fecha2."' AND campo1 = '".$row["GUIADP_A"]."' AND campo2 = '".$row["PATENT_A"]."'";
				 //echo $consulta_u."<br>";
				//require("../principal/conectar_sea_web.php"); 
				 $result_u = mysqli_query($link, $consulta_u);
						
					
				 if ($row_u = mysqli_fetch_array($result_u))
				 {
						$unidades = $row_u["unid"];
				 }
															 
 				 if($lote_ventana != '')
				 {
					   $consulta = "SELECT * FROM sea_web.relaciones WHERE lote_ventana = $lote_ventana";
					  // require("../principal/conectar_sea_web.php");
					   $rs2 = mysqli_query($link, $consulta);
					   $producto="";
					   if ($row2 = mysqli_fetch_array($rs2))
					   {
							$producto = $row2["cod_origen"];
							$hornada = $row2["hornada_ventana"];		 
							$lote_origen = $row2["lote_origen"];
							$marca = $row2['marca'];		 
					   } 	
				 } 	
			}			
		    echo'<tr> ';
			echo'<input name="a['.$i.']" type="hidden" size="8">';
			echo'<td><input type="radio" name="radio" value="'.$guia.$patente.'" onClick="Crear_Detalle('.$i.');"></td>';
			echo'<input name="producto['.$i.']" type="hidden" size="8" value="'.$producto.'">';
			echo'<td><div align="center"><input name="guia_'.$i.'" type="hidden" size="8" value="'.$guia.'"><input name="guia['.$i.']" type="hidden" size="8" value="'.$guia.'">'.$guia.'</div></td>';					
			echo'<td><div align="center"><input name="patente_'.$i.'" type="hidden" size="8" value="'.$patente.'"><input name="patente['.$i.']" type="hidden" size="8" value="'.$patente.'">'.$patente.'</div></td>';
			echo'<td><div align="center"><input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$lote_ventana.'">'.$lote_ventana.'</div></td>';
			echo'<td><div align="center"><input name="recargo['.$i.']" type="hidden" size="8" value="'.$recargo.'">'.$recargo.'</div></td>';
			echo'<td><div align="center"><input name="peso_recepcion['.$i.']" type="text" value="'.$peso_recepcion.'" size="8"></div></td>';
			echo'<input name="hornada_aux['.$i.']" type="hidden" size="5" value="'.$hornada.'">';
			echo'<td><div align="center"><input name="hornada['.$i.']" type="text" size="5" value="'.substr($hornada,6,6).'"></div></td>';
			echo'<td><div align="center"><input name="unidades['.$i.']" type="text" size="5" value="'.$unidades.'"></div></td>';					
			echo'<td><div align="center"><input name="lote_origen['.$i.']" type="hidden" size="8" value="'.$lote_origen.'">&nbsp;'.$lote_origen.'</div></td>';
			echo'<td><div align="center"><input name="marca['.$i.']" type="hidden" size="8" value="'.$marca.'">&nbsp;'.$marca.'</div>';
			echo'</td>';
			echo'</tr>';
      }		

 }  
?>


<?php //Proveedores TTE y Disputada
 $codigo = substr($proveedor,0,1); 
 $prv2="77762940-9";
 $Encontrado="";
 if ($mostrar=="S" && $proveedor != "A-00001100-2" && $codigo != "B")	
 {
	  echo "Ingreso 2<br>";
	  $prov = substr($proveedor,2,10);
	  echo'<tr class="ColorTabla01"> 
		<td width="8%"><div align="center">Lote V.</div></td>
		<td width="12%"><div align="center">Fecha Hora</div></td>
		<td width="8%"><div align="center">Recargo</div></td>
		<td width="12%"><div align="center">Peso Recep</div></td>
		<td width="12%"><div align="center">Hornada</div></td>
		<td width="12%"><div align="center">Peso Origen</div></td>
		<td width="15%"><div align="center">Unidades</div></td>
		<td width="15%"><div align="center">Lote O.</div></td>
		<td width="15%"><div align="center">Marca</div></td>
	  </tr>';
         $l = strlen($mes);
		 if ($l==1)
		     $mes = "0$mes";
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$cont = 20;
        $Fecha2 = date("Y-m-d", mktime(1,0,0,intval(substr($fecha, 5, 2)) ,intval(substr($fecha, 8, 2)) + 1,intval(substr($fecha, 0, 4))));
		$consulta = "SELECT distinct LOTE AS LOTE_A FROM sipa_web.recepciones WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND (RUT_PRV = '".$prov."' or RUT_PRV = '".$prv2."') and tipo<>'A' and tipo <>'C'";
		//require("../principal/conectar_rec_web.php");
		$rs = mysqli_query($link, $consulta);
		$i =0;
		$Total_peso=0;$Total_origen=0;$Total_unid=0;
		while($row = mysqli_fetch_array($rs))
		{

			$Encontrado = "S";
			$i = $i + 1;
			$unidades = 0;
			$peso=0;
			//require("../principal/conectar_rec_web.php");
			$consulta = "SELECT MAX(ceiling(RECARGO)) as recargo FROM SIPA_WEB.recepciones ";
			$consulta.= " WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND LOTE = '".$row["LOTE_A"]."' AND (RUT_PRV = '".$prov."' or RUT_PRV = '".$prv2."')";
			$result = mysqli_query($link, $consulta);
			if($row1 = mysqli_fetch_array($result))
			{
				$recargo = $row1["recargo"];
				$lote_ventana = $row["LOTE_A"];
				
				//echo $lote_ventana;

				$consulta_s = "SELECT SUM(PESO_NETO) AS peso_t FROM SIPA_WEB.recepciones WHERE LOTE = '".$row["LOTE_A"]."' AND FECHA ='".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = 17 AND (RUT_PRV = '".$prov."'or RUT_PRV = '".$prv2."')";
				echo "Con".$consulta_s;
				$result_s = mysqli_query($link, $consulta_s);
				     
				 if ($row_s = mysqli_fetch_array($result_s))
				 {
					  $peso_recepcion = $row_s["peso_t"];
				 }
														                 
				if($lote_ventana != '')
				{
					  $consulta = "SELECT * FROM sea_web.relaciones WHERE lote_ventana = '".$row["LOTE_A"]."' ";
					  echo "<br>".$consulta."<br>";
					 // require("../principal/conectar_sea_web.php");
					  $rs2 = mysqli_query($link, $consulta);
					  if ($row2 = mysqli_fetch_array($rs2))
					  {
						   $producto    = $row2["cod_origen"];
						   $hornada     = $row2["hornada_ventana"];		 
						   $lote_origen = $row2["lote_origen"];
						   $marca       = $row2['marca'];		 
					  } 
					  else 
					  {
						   $producto = '';
						   $hornada = '';		 
						   $lote_origen = '';
						   $marca = '';		                      
					  }	
					  echo  "<br>lote_origen:".$lote_origen;

					  if($hornada != '')
					  {
							$fecha2=date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano));		
							$FechaInicio =date("Y-m-d", mktime(0,0,0,$mes,$dia,$ano))." 08:00:00";		
							$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano))." 07:59:59";
						   //$consulta_u = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso, SUM(peso_origen) AS peso_origen,hora,fecha_movimiento FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '$fecha' and '$Fecha2' and hora between '$FechaInicio' and '$FechaTermino' AND hornada = $hornada group by hornada, fecha_movimiento";						   
						   $consulta_u = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso, SUM(peso_origen) AS peso_origen,hora,fecha_movimiento FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '$fecha' and '$Fecha2' AND hornada = $hornada group by hornada, fecha_movimiento";
						   //require("../principal/conectar_sea_web.php"); 
						   $result_u = mysqli_query($link, $consulta_u);
							//echo $consulta_u;	
						   if ($row_u = mysqli_fetch_array($result_u))
						   {
								$Hora=$row_u["hora"];
								$FechaMov=$row_u["fecha_movimiento"];
								$unidades = $row_u["unid"];
								$peso = $row_u["peso"];
								$peso_origen = $row_u["peso_origen"];
								 if($peso_origen == '')
									$peso_origen = 0;
						   }
					  } 
					  else 
					  {
					   	    $unidades = 0;
							$peso_origen = 0;
					  }
				
				 }	
		    
			}			
		   echo'<tr> ';
			echo'<input name="a['.$i.']" type="hidden" size="8">';
			echo'<input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$lote_ventana.'">';
			echo'<input name="producto['.$i.']" type="hidden" size="8" value="'.$producto.'">';
			echo'<td><div align="center"><input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$row["LOTE_A"].'">'.$row["LOTE_A"].'</div></td>';
			echo'<td><div align="center"><input name="Fecha_Mov['.$i.']" type="hidden" size="8" value="'.$FechaMov.'">'.$Hora.'</td>';
			echo'<td><div align="center"><input name="recargo['.$i.']" type="hidden" size="8" value="'.$recargo.'">'.$recargo.'</div></td>';
			
			echo'<input name="peso_ant['.$i.']" type="hidden" size="7" value="'.number_format($peso,0,'','').'">';
			echo'<td><div align="center"><input name="peso_recepcion['.$i.']" type="text" value="'.$peso_recepcion.'" size="8"></div></td>';

			echo'<input name="hornada_aux['.$i.']" type="hidden" size="5" value="'.$hornada.'">';
			echo'<td><div align="center"><input name="hornada['.$i.']" type="text" size="5" value="'.substr($hornada,6,6).'"></div></td>';
			
			echo'<td><div align="center"><input name="peso_origen['.$i.']" type="text" value="'.$peso_origen.'" size="8"></div></td>';

			echo'<input name="unidades_ant['.$i.']" type="hidden" size="5" value="'.$unidades.'">';
			echo'<td><div align="center"><input name="unidades['.$i.']" type="text" size="5" value="'.$unidades.'"></div></td>';					
					
			echo'<td><div align="center"><input name="lote_origen['.$i.']" type="hidden" size="8" value="'.$lote_origen.'">&nbsp;'.$lote_origen.'</div></td>';
			echo'<td><div align="center"><input name="marca['.$i.']" type="hidden" size="8" value="'.$marca.'">&nbsp;'.$marca.'</div>';
			echo'</td>
			 </tr>';

			$Total_peso = $Total_peso + $peso_recepcion; 
			$Total_origen = $Total_origen + $peso_origen; 
			$Total_unid = $Total_unid + $unidades;					
		}
			echo'<tr class="Detalle02">';
				echo'<td colspan="3">Totales</td>';
				echo'<td align="center">&nbsp;'.$Total_peso.'</td>';
				echo'<td align="center">&nbsp;</td>';
				echo'<td align="center">&nbsp;'.$Total_origen.'</td>';
				echo'<td align="center">&nbsp;'.$Total_unid.'</td>';
				echo'<td align="center" colspan="2">&nbsp;</td>';
			echo'</tr>';
 }  
?>

<?php //Proveedores TTE
 $codigo = substr($proveedor,0,1); 
 if ($mostrar=="NOS" && $proveedor == "61704005-0" && $codigo != "B")	
 {
	  $prov = substr($proveedor,2,10);
	  echo'<tr class="ColorTabla01"> 
		<td width="8%"><div align="center">Lote V.</div></td>
		<td width="8%"><div align="center">Recargo</div></td>
		<td width="15%"><div align="center">Peso Recep</div></td>
		<td width="15%"><div align="center">Hornada</div></td>
		<td width="15%"><div align="center">Peso Origen</div></td>
		<td width="15%"><div align="center">Unidades</div></td>
		<td width="15%"><div align="center">Lote O.</div></td>
		<td width="15%"><div align="center">Marca</div></td>
	  </tr>';
         $l = strlen($mes);
		 if ($l==1)
		     $mes = "0$mes";
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$cont = 20;
        $Fecha2 = date("Y-m-d", mktime(1,0,0,intval(substr($fecha, 5, 2)) ,intval(substr($fecha, 8, 2)) + 1,intval(substr($fecha, 0, 4))));
		$consulta = "select lote_ventana AS LOTE_A from sea_web.recepcion_externas where fecha = '".$fecha."' and cod_producto='17' and cod_subproducto = '2' and rut_prv = '".$prov."' and piezas_recep<piezas";
		$rs = mysqli_query($link, $consulta);
		$i =0;
		while($row = mysqli_fetch_array($rs))
		{
			$Encontrado = "S";
			$i = $i + 1;
			$unidades = '';
			$recargo = 1;
			$lote_ventana = $row["LOTE_A"];
		    $peso_recepcion = $row["peso"];
			$consulta = "SELECT * FROM sea_web.relaciones WHERE lote_ventana = '".$row["LOTE_A"]."' ";
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2))
			{
			   $producto = $row2["cod_origen"];
			   $hornada = $row2["hornada_ventana"];		 
			   $lote_origen = $row2["lote_origen"];
			   $marca = $row2['marca'];		 
			} 
			else 
			{
			   $producto = '';
			   $hornada = '';		 
			   $lote_origen = '';
			   $marca = '';		                      
			}	
			if($hornada != '')
			{
			   $consulta_u = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso, SUM(peso_origen) AS peso_origen FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento ='".$fecha."' AND hornada = '".$hornada."' ";
			   $result_u = mysqli_query($link, $consulta_u);
			
			   if ($row_u = mysqli_fetch_array($result_u))
			   {
					$unidades = $row_u["unid"];
					$peso = $row_u["peso"];
					$peso_origen = $row_u["peso_origen"];
					 if($peso_origen == '')
						$peso_origen = 0;
			   }
			} 
			else 
			{
				$unidades = '';
				$peso_origen = 0;
			}
		    echo'<tr> ';
			echo'<input name="a['.$i.']" type="hidden" size="8">';
			echo'<input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$lote_ventana.'">';
			echo'<input name="producto['.$i.']" type="hidden" size="8" value="'.$producto.'">';
			echo'<td><div align="center"><input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$row["LOTE_A"].'">'.$row["LOTE_A"].'</div></td>';
			echo'<td><div align="center"><input name="recargo['.$i.']" type="hidden" size="8" value="'.$recargo.'">'.$recargo.'</div></td>';
			echo'<input name="peso_ant['.$i.']" type="hidden" size="7" value="'.number_format($peso,0,'','').'">';
			echo'<td><div align="center"><input name="peso_recepcion['.$i.']" type="text" value="'.$peso_recepcion.'" size="8"></div></td>';
			echo'<input name="hornada_aux['.$i.']" type="hidden" size="5" value="'.$hornada.'">';
			echo'<td><div align="center"><input name="hornada['.$i.']" type="text" size="5" value="'.substr($hornada,6,6).'"></div></td>';
			echo'<td><div align="center"><input name="peso_origen['.$i.']" type="text" value="'.$peso_origen.'" size="8"></div></td>';
			echo'<input name="unidades_ant['.$i.']" type="hidden" size="5" value="'.$unidades.'">';
			echo'<td><div align="center"><input name="unidades['.$i.']" type="text" size="5" value="'.$unidades.'"></div></td>';					
			echo'<td><div align="center"><input name="lote_origen['.$i.']" type="hidden" size="8" value="'.$lote_origen.'">&nbsp;'.$lote_origen.'</div></td>';
			echo'<td><div align="center"><input name="marca['.$i.']" type="hidden" size="8" value="'.$marca.'">&nbsp;'.$marca.'</div>';
			echo'</td>
			 </tr>';
			$Total_peso = $Total_peso + $peso_recepcion; 
			$Total_origen = $Total_origen + $peso_origen; 
			$Total_unid = $Total_unid + $unidades;					
		}
			echo'<tr class="Detalle02">';
				echo'<td colspan="2">Totales</td>';
				echo'<td align="center">&nbsp;'.$Total_peso.'</td>';
				echo'<td align="center">&nbsp;</td>';
				echo'<td align="center">&nbsp;'.$Total_origen.'</td>';
				echo'<td align="center">&nbsp;'.$Total_unid.'</td>';
				echo'<td align="center" colspan="2">&nbsp;</td>';
			echo'</tr>';
 }  
?>
		

<?php
 //Blister
 $codigo = substr($proveedor,0,1);
 if ($mostrar=="S" && $codigo =="B" )	
 {
	  if(strlen($mes) == 1)
	  	$mes = "0".$mes;	

	  $rango = $ano.$mes;	
	  $consulta = "SELECT MAX(hornada_ventana) AS lote_mes FROM sea_web.relaciones WHERE left(hornada_ventana,6) = '".$rango."' AND hornada_externa = 16 AND estado_lote = 0";
	  $rs8 = mysqli_query($link, $consulta);

	  if ($row8 = mysqli_fetch_array($rs8))
	  {
		   $lote_mes = substr($row8["lote_mes"],3,6);
	  }	

	  $ap_subproducto = substr($proveedor,2,2);
	  $Consulta = "SELECT rut_prov FROM proyecto_modernizacion.subproducto WHERE rut_prov != '' AND cod_producto = 16 AND ap_subproducto = '".$ap_subproducto."' ";
	  //echo $Consulta;
	  $rs = mysqli_query($link, $Consulta);

	  if($row = mysqli_fetch_array($rs))
	  {
		   $prov = $row["rut_prov"];
	  }
        
	  $Total_peso = 0; 
	  $Total_origen = 0; 
	  $Total_zuncho = 0; 
	  $Total_unid = 0;			 

	   echo'<tr class="ColorTabla01"> 
			<td width="7%"><div align="center">Guia.</div></td>
			<td width="10%"><div align="center">Patente</div></td>
			<td width="6%"><div align="center">Lote V.</div></td>
			<td width="5%"><div align="center">Rcgo.</div></td>
			<td width="7%"><div align="center">Peso Recep</div></td>
			<td width="21%"><div align="center">Subproducto</div></td>
			<td width="16%"><div align="center">Lote Rel.</div></td>
			<td width="7%"><div align="center">Horn/Lote</div></td>
			<td width="7%"><div align="center">Peso Origen</div></td>
			<td width="7%"><div align="center">Embalaje</div></td>
			<td width="7%"><div align="center">Unidades</div></td>
		  </tr>';

		$fecha = $ano.'-'.$mes.'-'.$dia;
		$pos = 7;
		$consulta = "SELECT GUIA_DESPACHO AS GUIADP_A, PATENTE AS PATENT_A, LOTE AS LOTE_A, RECARGO AS RECARG_A ";
		$consulta.= " FROM sipa_web.recepciones WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '16' AND RUT_PRV= '".$prov."' ORDER by HORA_ENTRADA";
		//echo $consulta;
		//require("../principal/conectar_rec_web.php");
		$rs = mysqli_query($link, $consulta);

		while($row = mysqli_fetch_array($rs))
		{	

				$pos = $pos + 10;
				$Encontrado = "S";
                $i = $i + 1;
				$cont = $cont + 1;
				$unidades = '';
				$radio = 3;

				//require("../principal/conectar_rec_web.php");
				$consulta = "SELECT RECARGO as recargo FROM SIPA_WEB.recepciones ";
				$consulta.= " WHERE FECHA = '".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = 16 AND LOTE = '".$row["LOTE_A"]."' AND RECARGO = '".$row["RECARG_A"]."' AND RUT_PRV = '".$prov."' ";
                $result = mysqli_query($link, $consulta);

				if($row1 = mysqli_fetch_array($result))
				{
					 $recargo = $row1["recargo"];
					 $lote_ventana = $row["LOTE_A"];

					//peso sipa
					 $consulta_s = "SELECT SUM(PESO_NETO) AS peso_t FROM SIPA_WEB.recepciones ";
					 $consulta_s.= " WHERE LOTE = '".$row["LOTE_A"]."' AND RECARGO = '".$row["RECARG_A"]."' AND FECHA ='".$fecha."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '16' AND RUT_PRV = '".$prov."' ";
                     $result_s = mysqli_query($link, $consulta_s);
					 if ($row_s = mysqli_fetch_array($result_s))
					 {
							$peso_recepcion = $row_s["peso_t"];
					 }
														                 
					 //busca lote relacionado
					 if($lote_ventana != '')
					 {
						  $consulta = "SELECT * FROM sea_web.relaciones WHERE lote_ventana = '".$row["LOTE_A"]."' ";
						  $rs2 = mysqli_query($link, $consulta);
						  if ($row2 = mysqli_fetch_array($rs2))
						  {
							  $hornada = $row2["hornada_ventana"];		 
							  $lote_origen = $row2["lote_origen"];
							  $marca = $row2['marca'];
							  $radio = $row2["estado_lote"];
                              $subproducto = $row2["cod_origen"];
							  //consulta zuncho
							  $consulta = "SELECT * FROM sea_web.relacion_zuncho WHERE cod_subproducto = '".$subproducto."' ";
							  $rs7 = mysqli_query($link, $consulta);
							  if ($row7 = mysqli_fetch_array($rs7))
							  		$zuncho = $row7["zuncho"];
							  else
							  		$zuncho = 2;
					  	  } 
					      else 
					      {
							  $subproducto = '';
							  $hornada = '';		 
							  $lote_origen = '';
							  $marca = '';
							  $zuncho = 2;						  
					      }	


					  	  if($hornada != '')
					      {
						       //consulta movimientos hechos	
							   $consulta_u = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso, SUM(peso_origen) AS peso_origen, SUM(zuncho) AS zuncho FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento ='".$fecha."' AND hornada = '".$hornada."' AND numero_recarga = '".$recargo."' AND lote_ventana = '".$lote_ventana."'";
							  // include("../principal/conectar_sea_web.php"); 
							   $result_u = mysqli_query($link, $consulta_u);
					
							   if ($row_u = mysqli_fetch_array($result_u))
							   {
								 	 $unidades = $row_u["unid"];
									 $peso = $row_u["peso"];
									 $peso_origen = $row_u["peso_origen"];
									 if($row_u["zuncho"] != '')
									 	$zuncho = $row_u["zuncho"];
									 if($peso_origen == '')
										$peso_origen = 0;
							   }
					      } 
					      else 
					      {
							    $unidades = '';
							    $peso_origen = 0;
							    $zuncho = 2;
					      }
			
				     }	
			
			    }			
			    echo'<tr> ';
	
				echo'<input name="a['.$i.']" type="hidden" size="8">';
				echo'<input name="lote_mes['.$i.']" type="hidden" size="8" value="'.$lote_mes.'">';
				echo'<input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$lote_ventana.'">';
		
				echo'<td><div align="center"><input name="guia['.$i.']" type="hidden" size="8" value="'.$row["GUIADP_A"].'">'.$row["GUIADP_A"].'</div></td>';
				echo'<td><div align="center"><input name="patente['.$i.']" type="hidden" size="8" value="'.$row["PATENT_A"].'">'.$row["PATENT_A"].'</div></td>';
				echo'<td><div align="center"><input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$row["LOTE_A"].'">'.$row["LOTE_A"].'</div></td>';
				echo'<td><div align="center"><input name="recargo['.$i.']" type="hidden" size="8" value="'.$recargo.'">'.$recargo.'</div></td>';
				echo'<input name="peso_ant['.$i.']" type="hidden" size="7" value="'.number_format($peso,0,'','').'">';
				echo'<td><div align="center"><input name="peso_recepcion['.$i.']" type="text" value="'.$peso_recepcion.'" size="8" readonly></div></td>';

				echo'<td>';					
				//echo'<SELECT name="subproducto['.$i.']" onChange="Buscar_Lote(this.form,'.($pos).')">';
				echo'<SELECT name="subproducto['.$i.']">';
				echo'<option value="-1" selected>Seleccionar</option>';
	
				$Consulta="select * from proyecto_modernizacion.subproducto where cod_producto = 16 and ap_subproducto = '".$ap_subproducto."'"; 
				$rs7 = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($rs7))
				{
					if ($subproducto == $Fila["cod_subproducto"])
					//	echo "<option value = '".$Fila[ap_subproducto]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					else
					//	echo "<option value = '".$Fila[ap_subproducto]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}					
				echo'</SELECT>';					
				echo'</td>';

				echo'<td>';
				if($radio == 0)
					echo'MES&nbsp;<input name="radio['.$i.']" type="radio" value="0" checked onClick="Traspasa_Lote1(this.form,'.($pos + 1).')" disabled>';
				elseif($radio == 1)
					echo'MES&nbsp;<input name="radio['.$i.']" type="radio" value="0" onClick="Traspasa_Lote1(this.form,'.($pos + 1).')" disabled>';
				else
					echo'MES&nbsp;<input name="radio['.$i.']" type="radio" value="0" onClick="Traspasa_Lote1(this.form,'.($pos + 1).')">';

				if($radio == 1)
					echo'LOTE&nbsp;<input name="radio['.$i.']" type="radio" value="1" checked  onClick="Traspasa_Lote(this.form,'.($pos + 2).')" disabled>';
				elseif($radio == 0)
					echo'LOTE&nbsp;<input name="radio['.$i.']" type="radio" value="1" onClick="Traspasa_Lote(this.form,'.($pos + 2).')" disabled>';					
				else
					echo'LOTE&nbsp;<input name="radio['.$i.']" type="radio" value="1" onClick="Traspasa_Lote(this.form,'.($pos + 2).')">';					
				echo'</td>';

				echo'<input name="hornada_aux['.$i.']" type="hidden" size="7" value="'.$hornada.'">';
				//*MF echo'<td><div align="center"><input name="hornada['.$i.']" type="text" size="7" value="'.substr($hornada,3,6).'"></div></td>';
				echo'<td><div align="center"><input name="hornada['.$i.']" type="text" size="7" value="'.substr($hornada,3,7).'"></div></td>';
				
				echo'<td><div align="center"><input name="peso_origen['.$i.']" type="text" value="'.$peso_origen.'" size="8"></div></td>';

				echo'<td><div align="center"><input name="zuncho['.$i.']" type="text" size="6" value="'.$zuncho.'"></div></td>';					

				echo'<input name="unidades_ant['.$i.']" type="hidden" size="5" value="'.$unidades.'">';
				echo'<td><div align="center"><input name="unidades['.$i.']" type="text" size="5" value="'.$unidades.'"></div></td>';					
				echo'</tr>';
				
				$Total_peso = $Total_peso + $peso_recepcion; 
				$Total_origen = $Total_origen + $peso_origen; 
				$Total_zuncho = $Total_zuncho + $zuncho; 
				$Total_unid = $Total_unid + $unidades;
				
				$pos = $pos + 8;
	    }//fin while		

		echo'<tr class="Detalle02">';
			echo'<td colspan="4">Totales</td>';
			echo'<td align="center">&nbsp;'.$Total_peso.'</td>';
			echo'<td align="center" colspan="3">&nbsp;</td>';
			echo'<td align="center">&nbsp;'.$Total_origen.'</td>';
			echo'<td align="center">&nbsp;'.$Total_zuncho.'</td>';
			echo'<td align="center">&nbsp;'.$Total_unid.'</td>';
		echo'</tr>';
 }  
?>

        </table>
		<br>
        <table width="760" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="766"><div align="center"><font color="#000000" size="2">&nbsp; 
                <?php
				
				 if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades == '' && $codigo != "B")
					echo'<input name="grabar" type="button" style="width:70" value="Grabar" onClick="Guardar_Datos();">';
				 if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades == '' && $codigo == "B")
					echo'<input name="grabar2" type="button" style="width:70" value="Grabar" onClick="Guardar_Datos2(this.form,'.($cont).');">';
				 if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades != '')
					echo'<input name="modificar" type="button" style="width:70" value="Modificar" onClick="Modificar_Datos();">';
                ?>
				<input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
                </font></div></td>
          </tr>
      </table></td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
