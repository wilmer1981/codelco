<?php 
	include("../principal/conectar_ref_web.php");
	$CodigoDeSistema = 10;

	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Dia    = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:"";
	$Mes    = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	$Ano    = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";

	$Dia = str_pad($Dia,2,0,STR_PAD_LEFT);
	$Mes = str_pad($Mes,2,0,STR_PAD_LEFT);
	$Fecha = $Ano."-".$Mes."-".$Dia;
	if ($Proceso=='N')
		{
			$i=0;
			$consulta="select max(fecha) as fecha from ref_web.renovacion_hm";
			$Respuesta = mysqli_query($link, $consulta);
			$Fila = mysqli_fetch_array($Respuesta);
			$Ano2=substr($Fila["fecha"],0,4);
			$Mes2=substr($Fila["fecha"],5,2);
			$cubas = array();
			$consulta="select distinct fecha,cod_grupo,cubas_renovacion from ref_web.renovacion_hm where fecha between '".$Ano2.'-'.$Mes2."-01' and  '".$Ano2.'-'.$Mes2."-31' and cubas_renovacion not in ('Renovacion Grupo 8 Comercial', 'SIN RENOVACION' ) order by fecha, cod_grupo asc";
			$Respuesta = mysqli_query($link, $consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
				{
				   $grupos[$i]=$Fila["cod_grupo"];
				   $cubas[$i]=$Fila["cubas_renovacion"];
				   $i=$i+1;
				}
			$Cubas1=$cubas[0];
			$Cubas2=$cubas[1];
			$Cubas3=$cubas[2];
			$Cubas4=$cubas[3];
			$Cubas5=$cubas[4];
			$Cubas6=$cubas[5];
			$Cubas7=$cubas[6];
			$Cubas8=$cubas[7];
			$Cubas9=$cubas[8];
			$Cubas10=$cubas[9];
			$Cubas11=$cubas[10];
			$Cubas12=$cubas[11];
			$Cubas13=$cubas[12];	
			$Cubas14=$cubas[13];	
			$Cubas15=$cubas[14];	
			$Cubas16=$cubas[15];	
			$Cubas17=$cubas[16];	
			$Cubas18=$cubas[17];	
			$Cubas19=$cubas[18];	
			$Cubas20=$cubas[19];
			$Cubas21=$cubas[20];
			$Cubas22=$cubas[21];		
			$modificar='N';
		}
	else if ($Proceso=='M')
			{
			  	$consulta="SELECT DISTINCT cubas_renovacion,cod_grupo,fecha from ref_web.renovacion_hm ";
				$consulta.="where fecha BETWEEN '".$Ano.'-'.$Mes."-01' and  '".$Ano.'-'.$Mes."-31' and ";
				$consulta.="cubas_renovacion not in ('Renovacion Grupo 8 Comercial','SIN RENOVACION' ) ";
				$consulta.="order by fecha asc LIMIT 22";
				//echo $consulta;
				$respuesta=mysqli_query($link, $consulta);
				$i=0;
				while ($Fila=mysqli_fetch_array($respuesta))
					{
					  $grupos[$i]=$Fila["cod_grupo"];
				      $cubas[$i]=$Fila["cubas_renovacion"];
				      $i=$i+1;
					}
				$Cubas1=$cubas[0];
				$Cubas2=$cubas[1];
				$Cubas3=$cubas[2];
				$Cubas4=$cubas[3];
				$Cubas5=$cubas[4];
				$Cubas6=$cubas[5];
				$Cubas7=$cubas[6];
				$Cubas8=$cubas[7];
				$Cubas9=$cubas[8];
				$Cubas10=$cubas[9];
				$Cubas11=$cubas[10];
				$Cubas12=$cubas[11];
				$Cubas13=$cubas[12];	
				$Cubas14=$cubas[13];	
				$Cubas15=$cubas[14];	
				$Cubas16=$cubas[15];	
				$Cubas17=$cubas[16];	
				$Cubas18=$cubas[17];	
				$Cubas19=$cubas[18];	
				$Cubas20=$cubas[19];
				$Cubas21=$cubas[20];
				$Cubas22=$cubas[21];			
				$i=0;
				if (!isset($filas2))
					{
						$j=1;
						$existe_fila2='N';
					}
				$consulta_fechas_sr="SELECT * from ref_web.renovacion_hm where fecha BETWEEN '".$Ano.'-'.$Mes."-01' and  '".$Ano.'-'.$Mes."-31' ";
				$consulta_fechas_sr.="and cubas_renovacion='SIN RENOVACION' order by fecha asc";			
				$respuesta_fechas_sr=mysqli_query($link, $consulta_fechas_sr);
				while ($row_fechas_sr=mysqli_fetch_array($respuesta_fechas_sr))
					{
						$arreglo_fechas_sr[$i]=$row_fechas_sr["fecha"];
						if ($existe_fila2=='N')
							{
								$filas2=$j;
								$j++;
							}
						$i++;
						
					}
				$i=0;
				if (!isset($filas1))
					{
						$j=1;
						$existe_fila1='N';
					}
				$consulta_fechas_rc="SELECT * from ref_web.renovacion_hm where fecha BETWEEN '".$Ano.'-'.$Mes."-01' and  '".$Ano.'-'.$Mes."-31' ";
				$consulta_fechas_rc.="and cubas_renovacion='Renovacion Grupo 8 Comercial' order by fecha asc";			
				$respuesta_fechas_rc=mysqli_query($link, $consulta_fechas_rc);
				while ($row_fechas_rc=mysqli_fetch_array($respuesta_fechas_rc))
					{
						$arreglo_fechas_rc[$i]=$row_fechas_rc["fecha"];
						if ($existe_fila1=='N')
							{
								$filas1=$j;
								$j++;
							}	
						$i++;
						
					}		
				$modificar='S';

				
			}
?>
<html>
<head>
<title>Programa de Renovacion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":
			f.action = "ref_ing_ren_HM01.php?Proceso=G";
			f.submit();
			break;
		case "S":
			window.opener.document.frmPrincipal.action = "Renovacion_HM.php?opcion=H";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
function Generar(valor1,valor2,valor3,valor4,valor5,valor6,valor7,valor8,valor9,valor10,valor11,valor12,valor13,valor14,valor15,valor16,valor17,valor18,valor19,valor20,valor21,valor22,fila)
{
   var f = document.frmPopUp;
   parametros1 = ValidaFilas1(f);
   parametros2 = ValidaFilas2(f);    
   //alert (parametros);
   var valor1=eval(valor1);
   var valor2=eval(valor2);
   var valor3=eval(valor3);
   var valor4=eval(valor4);
   var valor5=eval(valor5);
   var valor6=eval(valor6);
   var valor7=eval(valor7);
   var valor8=eval(valor8);
   var valor9=eval(valor9);
   var valor10=eval(valor10);
   var valor11=eval(valor11);
   var valor12=eval(valor12);
   var valor13=eval(valor13);
   var valor14=eval(valor14);
   var valor15=eval(valor15);
   var valor16=eval(valor16);
   var valor17=eval(valor17);
   var valor18=eval(valor18);
   var valor19=eval(valor19);
   var valor20=eval(valor20);
   var valor21=eval(valor21);
   var valor22=eval(valor22);
   
   var valores=valor1+'~'+valor2+'~'+valor3+'~'+valor4+'~'+valor5+'~'+valor6+'~'+valor7+'~'+valor8+'~'+valor9+'~'+valor10+'~'+valor11+'~'+valor12+'~'+valor13+'~'+valor14+'~'+valor15+'~'+valor16+'~'+valor17+'~'+valor18+'~'+valor19+'~'+valor20+'~'+valor21+'~'+valor22;
   if (fila==1)
      {
	    var valores2=f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value;
	    
	  }
	else if (fila==2)
	       {
		     var valores2=f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value;
		    }
		 else if (fila==3)
		        {
				  var valores2=f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value;
				}    
			 else if (fila==4)
			       {
				    var valores2=f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value;
				   }
				  else if (fila==5)
				        {
						 var valores2=f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value;
						}
					   else if (fila==6)	 
					           {
						         var valores2=f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value;
						       }
							 else if (fila==7)	 
					                {
						             var valores2=f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value;
						            }
								  else if (fila==8)
								          {
									        var valores2=f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value;
									      }
									   else if (fila==9)
									           {
											    var valores2=f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value;
											   }
											else if (fila==10)	     
											        {
											         var valores2=f.Grupo19.value+'~'+f.Grupo20.value+'~'+f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value;
											        }
												  else if (fila==11)
												          {
														    var valores2=f.Grupo21.value+'~'+f.Grupo22.value+'~'+f.Grupo1.value+'~'+f.Grupo2.value+'~'+f.Grupo3.value+'~'+f.Grupo4.value+'~'+f.Grupo5.value+'~'+f.Grupo6.value+'~'+f.Grupo7.value+'~'+f.Grupo8.value+'~'+f.Grupo9.value+'~'+f.Grupo10.value+'~'+f.Grupo11.value+'~'+f.Grupo12.value+'~'+f.Grupo13.value+'~'+f.Grupo14.value+'~'+f.Grupo15.value+'~'+f.Grupo16.value+'~'+f.Grupo17.value+'~'+f.Grupo18.value+'~'+f.Grupo19.value+'~'+f.Grupo20.value;
														  }
   Mensaje = confirm("�Esta Seguro de los datos ingresados?, ya que al presionar aceptar se generara el programa de renovacion");
    
   if (Mensaje==false)
   	 {
	  f.action="ref_ing_ren_HM2.php?Proceso=M"
	  f.submit();
	 }
   else
       {
         f.action = "ref_ing_ren_HM01.php?Proceso=C&cubas="+valores+"&grupos="+valores2+"&fechas_comercial="+parametros1+"&fechas_s_ren="+parametros2;
         f.submit();
	   }	 
}
/***********************************************/
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
			Valores = "v";
	}
	return Valores;
}
/*********************/

/********************/
function ValidaFilas1(f,Nombre)
{
 var Parametros1="";
 for (i=1;i<f.elements.length;i++)
  {
   //alert (f.elements[i].type);
	if (f.elements[i].type=="select-one" && f.elements[i].name.substring(0,4)=="dia1")
		{
		 Parametros1 = Parametros1 + f.elements[i+0].value + "//" + f.elements[i+1].value + "//" + f.elements[i+2].value + "~~";
		}
  }
  return(Parametros1);
}  
/*******************/
function ValidaFilas2(f,Nombre)
{
 var Parametros2="";
 for (i=1;i<f.elements.length;i++)
  {
   //alert (f.elements[i].type);
	if (f.elements[i].type=="select-one" && f.elements[i].name.substring(0,4)=="dia2")
		{
		 Parametros2 = Parametros2 + f.elements[i+0].value + "//" + f.elements[i+1].value + "//" + f.elements[i+2].value + "~~";
		}
  }
  return(Parametros2);
}  

/********************/
function Agregar(num_col, f, fecha,Proceso)
{
	switch (num_col)
	{
		case 1:
			f.filas1.value = parseInt(f.filas1.value) + 1;
			/*for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].type=="checkbox" && f.elements[i].name=="checkbox")
					Parametros = Parametros + f.elements[i+1].value + "//" + f.elements[i+2].value + "//" + f.elements[i+3].value + "~~";
			}*/
			break;
		case 2:
			f.filas2.value = parseInt(f.filas2.value) + 1;
			break;
	}
	linea = "filas1=" + f.filas1.value + "&filas2=" + f.filas2.value;
	//alert(Proceso);
	f.action = "ref_ing_ren_HM2.php?" + linea+"&Proceso="+Proceso;
	f.submit();
}
/*******************/
/*******************/
function Borrar(num_col,f,fecha,Proceso)
{
	switch (num_col)
	{
		case 1:
			if (f.filas1.value==0)
				f.filas1.value = 0;			
			else
				f.filas1.value = parseInt(f.filas1.value) - 1;			
			break;
		case 2:
			if (f.filas2.value==0)
				f.filas2.value = 0;			
			else
				f.filas2.value = parseInt(f.filas2.value) - 1;
			break;
	}
	linea = "filas1=" + f.filas1.value + "&filas2=" + f.filas2.value;
	f.action = "ref_ing_ren_HM2.php?" + linea+"&Proceso="+Proceso;
	f.submit();
}
/*************************/

</script>
<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPopUp" action="" method="post">
  <table width="350" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="109"><strong>Fecha:</strong></td>
      <td width="226"> 
        <?php
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	if ((isset($Dia)) && (isset($Mes)) && (isset($Ano)))
	{
		echo "<input type='hidden' name='Mes' value='".$Mes."'>";
		echo "<input type='hidden' name='Ano' value='".$Ano."'>";
		echo $Meses[intval($Mes) - 1]." / ".$Ano;
	}
	else
	{
		echo "<input type='hidden' name='Mes' value=''>";
		echo "<input type='hidden' name='Ano' value=''>";
	}
?>
      </td>
    </tr>
    <tr align="center"> 
      <td colspan="2"> <!-- <input type="button" name="Grabar" value="Grabar" style="width:70px;" onClick="Proceso('G')"> -->
        <input type="button" name="Submit2" value="Salir" style="width:70px;" onClick="Proceso('S')"> 
      </td>
    </tr>
  </table>
  <br>
  <table width="73%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
	<td width="57%" valign="top">
		<table width="344" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
			<tr align="center" class="ColorTabla01"> 
			<td width="458"><strong>FECHA RENOVACION GRUPO 8 COMERCIAL</strong></td>
		</tr>
		<tr align="center" class="ColorTabla01">
			<td><font face="Arial, Helvetica, sans-serif">
			<input name="btnagregar2" type="button" value="Agregar " style="width:100" onClick="JavaScript:Agregar(1,this.form,'<?php echo $fecha; ?>','<?php echo $Proceso;?>')">
			<input name="btnborrar2" type="button" value="Eliminar " style="width:100" onClick="JavaScript:Borrar(1,this.form,'<?php echo $fecha; ?>','<?php echo $Proceso;?>')">
			</font></td>
		</tr>        
 <?php 
  	if ($filas1 > 0)
	{   
	    if ($modificar=='S')
		   {
	    	reset($arreglo_fechas_rc);
			$x=0;	
		   }	
		
		for ($j=1;$j<=$filas1;$j++)
		{
		    if ($modificar=='S')
			   {
				$dia1[$j]=intval(substr($arreglo_fechas_rc[$x],8,2));
				$mes1[$j]=intval(substr($arreglo_fechas_rc[$x],5,2));
				$ano1[$j]=intval(substr($arreglo_fechas_rc[$x],0,4));
			   }	
			echo '<tr align="center">';
			echo '<td><select name="dia1['.$j.']" style="width:50px;">';
			for ($i = 1;$i <= 31; $i++)
			{
				if (isset($dia1[$j]))
				{
					if ($dia1[$j] == $i)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("j"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
			echo '</select>';
			echo '<select name="mes1['.$j.']" id="Mes_com1" style="width:100px">';
			$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=12;$i++)
			{
				if (isset($mes1[$j]))
				{
					if ($i == $mes1[$j])
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i == date("n"))
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
			}					
			echo '</select> ';
			echo '<select name="ano1['.$j.']" style="width:100px">';
			for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
			{
				if (isset($ano1[$j]))
				{
					if ($i == $ano1[$j])
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
			echo '</select></td>';
			echo '</tr>';
			if ($modificar=='S')
			   {
				$x++;
			   }	
		}							
	}   
  ?>
  	</table>
	</td>
	<td valign="top">
	<table width="385" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
		<tr align="center" class="ColorTabla01"> 
			<td width="374"><strong>DIAS SIN RENOVACION</strong></td>
		</tr>
		<tr align="center" class="ColorTabla01">
			<td><font face="Arial, Helvetica, sans-serif">
			<input name="btnagregar22" type="button" value="Agregar " style="width:100" onClick="JavaScript:Agregar(2,this.form,'<?php echo $fecha; ?>','<?php echo $Proceso?>')">
			<input name="btnborrar22" type="button" value="Eliminar " style="width:100" onClick="JavaScript:Borrar(2,this.form,'<?php echo $fecha; ?>','<?php echo $Proceso?>')">
			</font></td>
		</tr>
 <?php 
	if ($filas2 > 0)
	{
	    if ($modificar=='S')
		  {	
	    	reset($arreglo_fechas_sr);
			$x=0;
		  }		  	
		for ($j=1;$j<=$filas2;$j++)
		{
		    if ($modificar=='S')
		      {
				$dia2[$j]=intval(substr($arreglo_fechas_sr[$x],8,2));
				$mes2[$j]=intval(substr($arreglo_fechas_sr[$x],5,2));
				$ano2[$j]=intval(substr($arreglo_fechas_sr[$x],0,4));			
			  }	
			//Genera las filas que ya fueron ingresadas.
			echo '<tr align="center">';
			echo '<td><select name="dia2['.$j.']" style="width:50px;">';
			for ($i = 1;$i <= 31; $i++)
			{
				if (isset($dia2[$j]))
				{
					if ($dia2[$j] == $i)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("j"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
			echo '</select>';
			echo '<select name="mes2['.$j.']" id="Mes_com1" style="width:100px">';
			$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=12;$i++)
			{
				if (isset($mes2[$j]))
				{
					if ($i == $mes2[$j])
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i == date("n"))
						echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
			}			
			echo '</select> ';
			echo '<select name="ano2['.$j.']" style="width:100px">';
			for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
			{
				if (isset($ano2[$j]))
				{
					if ($i == $ano2[$j])
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option value='".$i."' selected>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
			echo '</select></td>';
			echo '</tr>';
			if ($modificar=='S')
				{
					$x++;
				}	
		}						
   }   
?>
</table>
</td></tr>
</table>
  <br>
  <table width="782" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center" class="ColorTabla01" > 
      <td><strong>N&deg; de Cubas</strong></td>
      <td colspan="3"><strong>Renovacion de Cubas</strong><strong></strong></td>
      <td>Generacion</td>
    </tr>
    <tr align="center"> 
      <td width="105"><strong>Grupo</strong> :<strong> 
        <select name="Grupo1">
          <option value="">&nbsp;</option>
          <?php
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[0] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[0],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[0],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td width="214"><input name="Cubas1" type="text"  value="<?php echo $Cubas1 ?>" size="40"> 
      </td>
      <td width="90"><strong>Grupo</strong> :<strong> 
        <select name="Grupo2" id="Grupo2">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[1] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[1],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[1],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td width="268"><input name="Cubas2" type="text"  value="<?php echo $Cubas2 ?>" size="40"> 
      </td>
      <td width="62"><input type="checkbox" name="pareja1" value="<?php echo $Cubas1 ?>" onClick="Generar('<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','1')"></td>
    </tr> 
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo3" id="Grupo3">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[2] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[2],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[2],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas3" type="text"  value="<?php echo $Cubas3 ?>" size="40"> 
      </td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo4" id="Grupo4">
          <option value="">&nbsp;</option>
          <?php		
	$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[3] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[3],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[3],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas4" type="text"  value="<?php echo $Cubas4 ?>" size="40"> 
      </td>
      <td><input type="checkbox" name="pareja2" value="<?php echo $Cubas3 ?>" onClick="Generar('<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','2')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo5" id="Grupo5">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[4] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[4],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[4],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas5" type="text"  value="<?php echo $Cubas5 ?>" size="40"> 
      </td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo6" id="Grupo6">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[5] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[5],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[5],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas6" type="text"  value="<?php echo $Cubas6 ?>" size="40"> 
      </td>
      <td><input type="checkbox" name="pareja3" value="<?php echo $Cubas5 ?>" onClick="Generar('<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','3')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo7" id="Grupo7">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[6] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[6],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[6],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas7" type="text"  value="<?php echo $Cubas7 ?>" size="40"> 
      </td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo8" id="Grupo8">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[7] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[7],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[7],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas8" type="text"  value="<?php echo $Cubas8 ?>" size="40"> 
      </td>
      <td><input type="checkbox" name="pareja4" value="<?php echo $Cubas7 ?>" onClick="Generar('<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','4')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo9" id="Grupo9">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[8] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[8],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[8],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas9" type="text"  value="<?php echo $Cubas9 ?>" size="40"> 
      </td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo10" id="Grupo10">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[9] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[9],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[9],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas10" type="text"  value="<?php echo $Cubas10 ?>" size="40"> 
      </td>
      <td><input type="checkbox" name="pareja5" value="<?php echo $Cubas9 ?>" onClick="Generar('<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','5')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo11" id="Grupo11">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[10] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[10],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[10],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas11" type="text"  value="<?php echo $Cubas11 ?>" size="40"> 
      </td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo12" id="Grupo12">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[11] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[11],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[11],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas12" type="text" value="<?php echo $Cubas12 ?>" size="40"> 
      </td>
      <td><input type="checkbox" name="pareja6" value="<?php echo $Cubas11 ?>" onClick="Generar('<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','6')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo13" id="Grupo13">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[12] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[12],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[12],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas13" type="text"  value="<?php echo $Cubas13 ?>" size="40"> 
      </td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo14" id="Grupo14">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[13] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[13],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[13],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas14" type="text"  value="<?php echo $Cubas14 ?>" size="40"> 
      </td>
      <td><input type="checkbox" name="pareja7" value="<?php echo $Cubas13 ?>" onClick="Generar('<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','7')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo15" id="Grupo15">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[14] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[14],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[14],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas15" type="text"  value="<?php echo $Cubas15 ?>" size="40"> 
      </td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo16" id="Grupo16">
          <option value="">&nbsp;</option>
          <?php		
	    $consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[15] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[15],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[15],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas16" type="text"  value="<?php echo $Cubas16 ?>" size="40"> 
      </td>
      <td><input type="checkbox" name="pareja8" value="<?php echo $Cubas15 ?>" onClick="Generar('<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','8')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo17" id="Grupo17">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[16] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[16],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[16],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas17" type="text" value="<?php echo $Cubas17 ?>" size="40"></td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo18" id="Grupo18">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[17] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[17],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[17],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas18" type="text" value="<?php echo $Cubas18 ?>" size="40"></td>
      <td><input type="checkbox" name="pareja9" value="<?php echo $Cubas17 ?>" onClick="Generar('<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','9')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo19" id="Grupo19">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[18] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[18],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[18],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas19" type="text" value="<?php echo $Cubas19 ?>" size="40"></td>
      <td><strong>Grupo</strong> :<strong> 
        <select name="Grupo20" id="Grupo20">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[19] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[19],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[19],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas20" type="text" value="<?php echo $Cubas20 ?>" size="40"></td>
      <td><input type="checkbox" name="pareja10" value="<?php echo $Cubas19 ?>" onClick="Generar('<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','10')"></td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo</strong> :<strong>
        <select name="Grupo21" id="Grupo21">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[20] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[20],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[20],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas21" type="text" value="<?php echo $Cubas21 ?>" size="40"></td>
      <td><strong>Grupo</strong> :<strong>
        <select name="Grupo22" id="Grupo22">
          <option value="">&nbsp;</option>
          <?php		
		$consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='10001' ";
		$Respuesta = mysqli_query($link, $consulta);
	    while ($Fila = mysqli_fetch_array($Respuesta))  		
		{
			if ($grupos[21] == str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($grupos[21],2,0,STR_PAD_LEFT)."'>".str_pad($grupos[21],2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."'>".str_pad($Fila["valor_subclase1"],2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas22" type="text"  value="<?php echo $Cubas22 ?>" size="40"></td>
      <td><input name="pareja11" type="checkbox" id="pareja11" value="<?php echo $Cubas21 ?>" onClick="Generar('<?php echo "f.Cubas21.value"; ?>','<?php echo "f.Cubas22.value"; ?>','<?php echo "f.Cubas1.value"; ?>','<?php echo "f.Cubas2.value"; ?>','<?php echo "f.Cubas3.value"; ?>','<?php echo "f.Cubas4.value"; ?>','<?php echo "f.Cubas5.value"; ?>','<?php echo "f.Cubas6.value"; ?>','<?php echo "f.Cubas7.value"; ?>','<?php echo "f.Cubas8.value"; ?>','<?php echo "f.Cubas9.value"; ?>','<?php echo "f.Cubas10.value"; ?>','<?php echo "f.Cubas11.value" ?>','<?php echo "f.Cubas12.value" ?>','<?php echo "f.Cubas13.value" ?>','<?php echo "f.Cubas14.value"; ?>','<?php echo "f.Cubas15.value"; ?>','<?php echo "f.Cubas16.value"; ?>','<?php echo "f.Cubas17.value"; ?>','<?php echo "f.Cubas18.value"; ?>','<?php echo "f.Cubas19.value"; ?>','<?php echo "f.Cubas20.value"; ?>','11')"></td>
    </tr>
  </table>

  <?php
	//Campo Oculto.
	//Guarda la cantidas de filas.
	if (!isset($filas1))
		$filas1 = 0;
	if (!isset($filas2))
		$filas2 = 0;
	echo '<input type="hidden" name="filas1" value="'.$filas1.'">';
	echo '<input type="hidden" name="filas2" value="'.$filas2.'">';
?>
</form>
</body>
</html>
