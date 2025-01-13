<?php
$CodigoDeSistema = 2;
$CodigoDePantalla = 52;

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Mostrar  = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
$ano   = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date('Y');
$mes   = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date('m');
$dia   = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date('d');
$proveedor = isset($_REQUEST["proveedor"])?$_REQUEST["proveedor"]:"";
$Est       = isset($_REQUEST["Est"])?$_REQUEST["Est"]:"";
$Hora      = isset($_REQUEST["Hora"])?$_REQUEST["Hora"]:date("H");
$Minutos   = isset($_REQUEST["Minutos"])?$_REQUEST["Minutos"]:date("i");

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
$ano2   = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:date('Y');
$mes2   = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:date('m');
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
var Valores='';

		if(f.proveedor.value='A-61704005-0')
		{
			for (i=9;i<=f.elements.length-2;i++)
			{
				if ((f.elements[i].name == "ValorTTE")&&(f.elements[i-1].value!=''||f.elements[i-1].value!=0))
				{
					Valores=Valores+f.elements[i].value+'~'+f.elements[i-2].value+'~'+f.elements[i-1].value+"//";
				}
			}
			Valores = Valores.substring(0,(Valores.length-2));
			f.action="sea_ing_recep_inter_tte01.php?Proceso=G&GrabarTTE=S&DatosRecep="+Valores;
		}
		else
			f.action="sea_ing_recep_inter_tte01.php?Proceso=G";
        f.submit();
  		
}

function Modificar_Datos()
{
var f = frmPrincipal;
  		f.action="sea_ing_recep_inter01.php?Proceso=M";
        f.submit();
  		
}
/*function CierreTTE()
{
	var f = frmPrincipal;
  	f.action="sea_ing_recep_inter01.php?Proceso=CT";
    f.submit();
}*/
function Recarga()
{
var f = frmPrincipal;
		f.action="sea_ing_recep_inter_tte.php?Proceso=V&Mostrar=S";
        f.submit();
  		
}

function Crear_Detalle()
{
var f = frmPrincipal;
var guia = '';
var patente = '';
var fecha = '';
var LargoForm = f.elements.length;
var Valores = "";
var valor=0;

	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radio") && (f.elements[i].checked == true))
		{
			    valor = f.elements[i].value.length;

				if(valor ==13)
				{
			 		guia = f.elements[i].value.substr(0,6); 
			 		patente = f.elements[i].value.substr(6,7); 
                }

				if(valor == 14)
				{
			 		guia = f.elements[i].value.substr(0,7); 
			 		patente = f.elements[i].value.substr(7,7); 
                }

            fecha=f.ano.value+"-"+f.mes.value+"-"+f.dia.value;
			
			Valores = "?mostrar2=S&guia_aux=" + guia + "&patente=" + patente  + "&fecha=" + fecha ;  
        	window.open("sea_ing_recep_ext.php"+ Valores, "","menubar=no resizable=no Top=50 Left=200 width=770 height=410 scrollbars=no");
		}
	}
	

}

function nueva_guia()
{
var f = frmPrincipal;
   	window.open("sea_ing_guia_tte.php", "","menubar=no resizable=no Top=50 Left=200 width=550 height=300 scrollbars=no");
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

	f.action="sea_ing_recep_inter_tte.php?Mostrar=S";
	f.submit();

}

function mostrar_guia2(Est)
{
var f = frmPrincipal;

	f.action="sea_ing_recep_inter_tte.php?Mostrar=S&Est="+Est;
	f.submit();

}

function salir_menu()
{
	
var f=frmPrincipal;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}	
function CalculaPeso(Valor,u,NumElemt,PiezasTot,PiezasRecep,PesoTot,PesoRecep,UnidIng,PesoIng)
{

	var f=frmPrincipal;
	var Dif=0;
	
	//alert(parseInt(PiezasRecep));
	//alert(parseInt(u.value));
	Dif=parseInt(PiezasRecep)+parseInt(u.value);
	if(Dif>PiezasTot)
	{	
		alert('Unidades Ingresadas no pueden ser Mayor a Unidades Totales');
		f.elements[NumElemt].value='';
		u.value='';
		u.focus();
		return;
	}
	if(u.value==PiezasTot)
	{
		f.elements[NumElemt].value=PesoTot;
		return;
	}
	if((parseInt(u.value)+parseInt(UnidIng))==PiezasTot)
	{
		f.elements[NumElemt].value=PesoTot-PesoIng;
		return;
	}

	//alert(Valor);
	/*alert(u.value);
	alert(Valor*parseInt(u.value)+parseInt(PesoRecep));
	alert(parseInt(PesoTot));*/
	
	if(u.value!='' && u.value!='0')
		if(Valor*parseInt(u.value)+parseInt(PesoRecep)>parseInt(PesoTot))
			f.elements[NumElemt].value=parseInt(PesoTot)-parseInt(PesoRecep);
		else
			f.elements[NumElemt].value=Valor*parseInt(u.value);
	else
	{
		f.elements[NumElemt].value='';
		u.value='';
	}

}
function CerraRecep(Ck,SP,Lote,Guia)
{
	var f=frmPrincipal;
	
	if(Ck.checked==true)
	{
		if(confirm('Esta Seguro de Cerrar el Lote'))
		{
			f.action="sea_ing_recep_inter_tte01.php?Proceso=CL&SubProducto="+SP+"&LoteVentana="+Lote+"&Guia="+Guia;
	        f.submit();
		}
	}	
}	
function CierreTTE(Ck,SP,Lote,Rec,Guia,UnidR,PesoR,Origen,UnidO,PesoO,FechaGuia,Marca)
{
	var f=frmPrincipal;
	
	if(Ck.checked==true)
	{
		//alert(parseInt(UnidR));
		if(parseInt(UnidR)>0)
		{
			if(confirm('Esta Seguro de Cerra Lote y Traspasar lo Pendiente al Mes Siguiente'))
			{
				//alert(Guia+' - '+PesoO+' - '+UnidO+' - '+PesoR+' - '+UnidR+' - '+Origen+' - '+FechaGuia+' - '+Marca);
				f.action="sea_ing_recep_inter_tte01.php?Proceso=CT&SubProducto="+SP+"&LoteVentana="+Lote+"&Rec="+Rec+"&Guia="+Guia+"&UnidR="+UnidR+"&PesoR="+PesoR+"&LoteOrigen="+Origen+"&PesoO="+PesoO+"&UnidO="+UnidO+"&FechaGuia="+FechaGuia+"&Marca="+Marca;
				f.submit();
			}
		}	
		else
		{
			if(confirm('Esta Seguro de Eliminar Lote y Traspasar sus Unidades al Mes Siguiente'))
			{
				f.action="sea_ing_recep_inter_tte01.php?Proceso=EL&SubProducto="+SP+"&LoteVentana="+Lote+"&Rec="+Rec+"&Guia="+Guia+"&UnidR="+UnidR+"&PesoR="+PesoR+"&LoteOrigen="+Origen+"&PesoO="+PesoO+"&UnidO="+UnidO+"&FechaGuia="+FechaGuia+"&Marca="+Marca;
				f.submit();
			}
		}	
	}	
}	

function VerGuias()
{
  	window.open("sea_ing_recep_ext_guias.php", "","menubar=no resizable=yes Top=10 Left=200 width=630 height=700 scrollbars=yes");
}
function MostrarLotes(Lote,Guia,LoteOrigen)
{
  	//alert(Lote +"-"+ Guia + "-" +LoteOrigen);
	window.open("sea_ing_recep_ext_lotes_guias.php?Lote="+Lote+"&Guia="+Guia+"&LoteOrigen="+LoteOrigen, "","menubar=no resizable=yes Top=10 Left=200 width=630 height=350 scrollbars=yes");
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
  <?php include("../principal/conectar_principal.php") ?> 
  <input name="PProveedor" type="hidden" value="PProveedor">
<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="800" align="center" valign="top" >
	  <table width="760" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="73">Origen Anodo</td>
            <td width="269">
              <?php
			   echo'<select name="proveedor" onChange="Recarga()">';
			   echo'<option value="-1" seleted>Seleccionar</option>';

               /*if($proveedor == "A-00001100-2")
			   	echo'<option value="A-00001100-2" selected>ANODOS HVL</option>';		   
               else
			   	echo'<option value="A-00001100-2">ANODOS HVL</option>';		 */  

               if($proveedor == "A-61704005-0")
					echo'<option value="A-61704005-0" selected>ANODOS TENIENTE</option>';		   
               else
					echo'<option value="A-61704005-0">ANODOS TENIENTE</option>';		   

               /*if($proveedor == "A-90132000-4")
			   	echo'<option value="A-90132000-4" selected>ANODOS SUR ANDES</option>';		   
			   else
			   	echo'<option value="A-90132000-4">ANODOS SUR ANDES</option>';		   

				echo '<option value="0">--------------------</option>';
			//BLISTER
			/*consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 16 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);		
			while ($row = mysqli_fetch_array($rs))
			{				
				if ('B-'.$row["cod_subclase"] == $proveedor)					
					echo '<option value="B-'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else 
					echo '<option value="B-'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}			*/											   
		    ?>
              <font color="#000000" size="2">&nbsp;            </font> </td>
            <td><font color="#000000" size="2">Fecha Mov.
              <select name="dia" size="1" style="font-face:verdana;font-size:10">
                <?php
			if($Mostrar=='S' || $Proceso == 'V')
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
	   				   if ($i==date("j"))
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
		if ($Mostrar=='S' || $Proceso == 'V')
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
                if ($i==date("n"))
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
	if($Mostrar=='S' || $Proceso == 'V')
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
            <td><input name="mostrar" type="hidden" value="Ok" onClick="mostrar_guia();">              
              <input name="nuevo" type="button" value="Ingreso Manual" style="width:100" onClick="nueva_guia();">
              <?php
			if($proveedor == "A-61704005-0")
			{
				echo "<input name='ver datos' type='button' value='Guias TTE' style='width:80' onClick='VerGuias();'>&nbsp;";
				
			}
			?></td>
          </tr>
          <tr> 
            <td colspan="2">
			
			<?php 
			if($proveedor == "A-61704005-0")
			{

				if($Est=="")
					$Est='A';
				if($Est=='A')
				{  
					$Opt1='checked';
					$Opt2='';		
				}
				else
				{  
					$Opt1='';
					$Opt2='checked';		
				}
				echo "Abierto<input name='radiobutton' type='radio' value='radiobutton' onClick=mostrar_guia2('A') $Opt1>";
				echo "Cerrado<input name='radiobutton' type='radio' value='radiobutton' onClick=mostrar_guia2('C') $Opt2>";
			}	
			?>            <font color="#000000" size="2">
			<?php
			if($Est=='C')
			{
			?>
            <select name="mes2" size="1"style="FONT-FACE:verdana;FONT-SIZE:10" onChange="mostrar_guia2('C')">
            <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
			if ($Mostrar=='S' || $Proceso == 'V')
			{
				for($i=1;$i<13;$i++)
				{
					if ($i==$mes2)
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}		
			}
			else
			{
				for($i=1;$i<13;$i++)
				{
					if ($i==date("n"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}  			 
			} 	  
		    ?>
            </select>
            <select name="ano2" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10" onChange="mostrar_guia2('C')">
              <?php
			if($Mostrar=='S' || $Proceso == 'V')
			{
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
				{
					if ($i==$ano2)
						echo "<option selected value ='$i'>$i</option>";
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}
			}
			else
			{
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
				{
					if ($i==date("Y"))
						echo "<option selected value ='$i'>$i</option>";
					else	
						echo "<option value='".$i."'>".$i."</option>";
				 }   
			}	
			?>
            </select>			
            <?php
			}
			?>
</font> </td>
            <td width="273"><font size="1"><font size="2">Hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
            <td width="118">
              <input name="ver datos" type="button" value="Datos Ingres." style="width:90" onClick="Datos_Ingresados();">
              <font color="#333333" size="2">
              <input name="buscar_g" type="hidden"  value="Modificar Gu&iacute;a" style="width:130" onClick="buscar_guia();">
              </font></td>
          </tr>
        </table>
	  <br>

        <table width="760" height="22" border="1" cellpadding="1" cellspacing="0" class="TablaDetalle">

<?php 
//PROVEEDOR TTE
 $codigo = substr($proveedor,0,1); 
 $Encontrado="";
 if($Mostrar=="S"&& $proveedor == "A-61704005-0")
 {
  if($Est=='A')
  {
  	  $prov = substr($proveedor,2,10);
	  echo'<tr class="ColorTabla01"> 
		<td width="14%"><div align="center">Guia</div></td>
		<td width="8%"><div align="center">Lote V.</div></td>
		<td width="8%"><div align="center">Recargo</div></td>
		<td width="15%"><div align="center">Peso Recep</div></td>
		<td width="15%"><div align="center">Hornada</div></td>
		<td width="12%"><div align="center">Peso Origen</div></td>
		<td width="15%"><div align="center">Unidades</div></td>
		<td width="15%"><div align="center">Lote O.</div></td>
		<td width="15%"><div align="center">Marca</div></td>
		<td width="10%"><div align="center">Unid.Tot</div></td>
		<td width="10%"><div align="center">Peso Ing</div></td>
		<td width="10%"><div align="center">Unid.Recep</div></td>
		<td width="5%"><div align="center">Cerrar</div></td>
		<td width="8%"><div align="center">Cierre TTE</div></td>
	  </tr>';
         $l = strlen($mes);
		 if ($l==1)
		     $mes = "0$mes";
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$cont = 20;$NumElemt=22;
        $Fecha2 = date("Y-m-d", mktime(0,0,0,intval(substr($fecha, 5, 2)) ,intval(substr($fecha, 8, 2)) + 1,intval(substr($fecha, 0, 4))));
		$Consulta="SELECT distinct guia,count(*) as cant,fecha_guia FROM sea_web.recepcion_externa where ";
		if($Est=='A')
		  $Consulta.="(estado not in ('C') and peso <> peso_recep) and (estado not in ('X'))";  //X---->GUIAS ANULADAS
		else
		  $Consulta.="estado ='C' or peso = peso_recep ";
		$Consulta.="group by guia";
		//echo "Consulta uno: <BR>".$Consulta;
		$RespGuia=mysqli_query($link, $Consulta);
		while($FilaGuia=mysqli_fetch_array($RespGuia))
		{
			$FechaGuiaTTE = $FilaGuia["fecha_guia"];
			$Consulta = "SELECT count(*) as cant_guias FROM sea_web.recepcion_externa WHERE guia='".$FilaGuia["guia"]."'";
			$RespCant = mysqli_query($link, $Consulta);
			$FilaCant = mysqli_fetch_array($RespCant);
			//echo "MM".$Est."<br>";
			//echo $FilaGuia["cant"]."<br>";
			//echo $FilaCant["cant_guias"]."<br><br>";
			if($Est=='A'||$Est=='C' && $FilaGuia["cant"]==$FilaCant["cant_guias"])
			{
			echo'<tr class="ColorTabla02">';
			echo '<td>'.$FilaGuia["guia"].'</td>';
			echo '<td colspan="13">&nbsp;</td>';
			echo '</tr>'; 
			$Consulta="SELECT guia,lote_ventana, lote_origen from sea_web.recepcion_externa where ";
			if($Est=='A')
			  $Consulta.="estado <>'C' and peso <> peso_recep ";
			else
			  $Consulta.="estado ='C' or peso = peso_recep ";
			$Consulta.=" and guia='".$FilaGuia["guia"]."'";
			//echo "<BR> CONSULTA dos:<BR>".$Consulta."<br>";

			$RespGuia2=mysqli_query($link, $Consulta);
			while($FilaGuia2=mysqli_fetch_array($RespGuia2))
			{

				$LoteOrigen= $FilaGuia2["lote_origen"]; //agregado por WSO
				//echo $FilaGuia2["lote_ventana"]."<br>";
				//echo $Est."<br>";
				if($Est=='A')
					//poly 25-01-07 $consulta = "SELECT lote as LOTE_A,guia_despacho,fecha,recargo FROM SIPA_WEB.recepciones WHERE guia_despacho='".$FilaGuia2["guia"]."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND RUT_PRV = '".$prov."' and peso_neto=0 and lote='".$FilaGuia2["lote_ventana"]."' order by lote";				
					$consulta = "SELECT lote as LOTE_A,guia_despacho,fecha,recargo FROM SIPA_WEB.recepciones WHERE guia_despacho='".$FilaGuia2["guia"]."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND RUT_PRV = '".$prov."' and peso_neto =0 and lote='".$FilaGuia2["lote_ventana"]."' order by lote";				
				else
					$consulta = "SELECT lote as LOTE_A,guia_despacho,fecha,recargo FROM SIPA_WEB.recepciones WHERE guia_despacho='".$FilaGuia2["guia"]."' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17' AND RUT_PRV = '".$prov."' and peso_neto!=0 and lote='".$FilaGuia2["lote_ventana"]."' order by lote";
				
					$rs = mysqli_query($link, $consulta);
				//echo "<br>consulta Tres:<br>".$consulta."<br>";
				$Total_origen=0;
				$Total_peso=0;
				$Total_unid=0;
				//$row = mysqli_fetch_array($rs);
				//var_dump($row);

				while($row = mysqli_fetch_array($rs))
				{
					$FechaRec=$row["fecha"];
					$Encontrado = "S";
					$i = $i + 1;
					$unidades =0;$peso_recepcion=0;$producto = '';$hornada = '';$lote_origen = '';$marca = '';		                      
					$lote_ventana = $row["LOTE_A"];
					$recargo  = $row["recargo"];
					$Guia     = $row["guia_despacho"];
				  	$consulta = "SELECT lote_ventana AS LOTE_A,peso,peso_recep,piezas,piezas_recep FROM sea_web.recepcion_externa where guia='".$FilaGuia["guia"]."' and cod_producto='17' and cod_subproducto = '2' and lote_ventana='".$lote_ventana."'";
					//echo "cero".$consulta;
					$RespRecep = mysqli_query($link, $consulta);
					if($FilaRecep= mysqli_fetch_array($RespRecep))
					{
						$peso_origen = $FilaRecep["peso"];
						$Unid=$FilaRecep["piezas"];
						$PesoPieza=0;
						if($FilaRecep["piezas"]!=0)
							$PesoPieza= round($FilaRecep["peso"]/$FilaRecep["piezas"]);
						//echo $PesoPieza."<br>";	
						//if($FilaRecep["peso_recep"]>=0)
						//{
							$peso_recepcion = $FilaRecep["peso_recep"];
							$PesoRecep=$FilaRecep["peso_recep"];
							$UnidRecep=$FilaRecep["piezas_recep"];
							$unidades=$FilaRecep["piezas_recep"];
						//}	
					}
					$consulta = "SELECT * from  sea_web.relaciones WHERE lote_ventana = '".$row["LOTE_A"]."' ";
					//echo "<br>cnsulta unooooo<br>".$consulta."<br>";
					$rs2 = mysqli_query($link, $consulta);
					//$row2 = mysqli_fetch_array($rs2);
					//var_dump($row2);
					if ($row2 = mysqli_fetch_array($rs2))
					{
					   $producto = $row2["cod_origen"];
					   $hornada = $row2["hornada_ventana"];		 
					   $lote_origen = $row2["lote_origen"];
					   $marca = $row2['marca'];		 
					} 
					$Disable='';
					if(intval(substr($row["LOTE_A"],2,2))==intval(date('m')))
					{
						$Disable='disabled';
					}
					
					echo'<tr> ';
					echo'<input name="a['.$i.']" type="hidden" size="8">';
					echo'<input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$lote_ventana.'">';
					echo'<input name="producto['.$i.']" type="hidden" size="8" value="'.$producto.'">';
					echo'<input name="FechaRec['.$i.']" type="hidden" size="8" value="'.$FechaRec.'">';
					echo'<td><input name="guia['.$i.']" type="hidden" size="8" value="'.$Guia.'">'.$FechaGuiaTTE.'</td>';
					echo'<td><div align="center"><input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$row["LOTE_A"].'"><a href=JavaScript:MostrarLotes("'.$row["LOTE_A"].'","'.$Guia.'","'.$LoteOrigen.'")>'.$row["LOTE_A"].'</a></div></td>';
					//echo'<td><div align="center"><input name="lote_ventana['.$i.']" type="hidden" size="8" value="'.$row["LOTE_A"].'"><a href=JavaScript:MostrarLotes("'.$row["LOTE_A"].'","'.$Guia.'","'.$lote_origen.'")>'.$row["LOTE_A"].'</a></div></td>';
					echo'<td><div align="center"><input name="recargo['.$i.']" type="hidden" size="8" value="'.$recargo.'">'.$recargo.'</div></td>';
					echo'<input name="peso_ant['.$i.']" type="hidden" size="7" value="'.number_format($peso_origen,0,'','').'">'; //$peso
					echo'<td><div align="center"><input name="peso_recepcion['.$i.']" type="text" value="" size="8" readonly></div></td>';
					echo'<input name="hornada_aux['.$i.']" type="hidden" size="5" value="'.$hornada.'">';
					echo'<td><div align="center"><input name="hornada['.$i.']" type="text" size="5" value="'.substr($hornada,6,6).'" readonly></div></td>';
					echo'<td><div align="center"><input name="peso_origen['.$i.']" type="text" value="'.$peso_origen.'" size="8" readonly></div></td>';
					echo'<input name="unidades_ant['.$i.']" type="hidden" size="5" value="'.$unidades.'">';
					echo'<td align="center"><input name="unidades['.$i.']" type="text" size="5" value="" onblur=CalculaPeso('.$PesoPieza.',this,'.$NumElemt.','.$Unid.','.$UnidRecep.','.$peso_origen.','.$PesoRecep.','.intval($unidades).','.intval($peso_recepcion).')></td>';
					echo'<td><div align="center"><input name="lote_origen['.$i.']" type="hidden" size="8" value="'.$lote_origen.'">&nbsp;'.$lote_origen.'</div></td>';
					echo'<td><div align="center"><input name="marca['.$i.']" type="hidden" size="8" value="'.$marca.'">&nbsp;'.$marca.'</div>';
					echo'<td>'.$Unid.'</td>';
					echo'<td align="right">'.$PesoRecep.'</td>';
					echo'<td align="right">'.$unidades.'</td>';
					echo'<td align="center"><input type="checkbox" name="CheckCerra" onclick=CerraRecep(this,"'.$producto.'","'.$lote_ventana.'","'.$Guia.'")></td>';
					echo'<td align="center"><input type="checkbox" '.$Disable.' name="CheckElimina" onclick=CierreTTE(this,"'.$producto.'","'.$lote_ventana.'","'.$recargo.'","'.$Guia.'","'.$unidades.'","'.$PesoRecep.'","'.$LoteOrigen.'","'.$Unid.'","'.$peso_origen.'","'.$FechaGuiaTTE.'","'.$marca.'")></td>';
					echo'</td>
					 </tr>';
					$Total_peso = $Total_peso + $peso_recepcion; 
					$Total_origen = $Total_origen + $peso_origen; 
					$Total_unid = $Total_unid + $unidades;	
					$NumElemt=$NumElemt+18;	
				}
			}
			echo'<tr class="Detalle02">';
			echo'<td colspan="5">Totales</td>';
			echo'<td align="center">&nbsp;'.$Total_origen.'</td>';
			echo'<td align="center">&nbsp;</td>';
			echo'<td align="center" colspan="3">&nbsp;</td>';
			echo'<td align="right">'.$Total_peso.'</td>';
			echo'<td align="right">'.$Total_unid.'</td>';
			echo'<td align="center">&nbsp;</td>';
			echo'<td align="center">&nbsp;</td>';
			echo'</tr>';
			$Total_peso=0;$Total_origen=0;$Total_unid=0;
			}
	}
 }
 else
 {
  	    $prov = substr($proveedor,2,10);
	    echo'<tr class="ColorTabla01"> 
		<td width="10%"><div align="center">Guia</div></td>
		<td width="12%"><div align="center">Fecha</div></td>
		<td width="12%"><div align="center">Lote V.</div></td>
		<td width="8%"><div align="center">Lote O.</div></td>
		<td width="12%"><div align="center">Hornada</div></td>
		<td width="8%"><div align="center">Marca</div></td>
		<td width="12%"><div align="center">Peso Origen</div></td>
		<td width="12%"><div align="center">Peso Recep</div></td>
		<td width="12%"><div align="center">Unid Origen</div></td>
		<td width="12%"><div align="center">Unid Recep.</div></td>
	    </tr>';
		$FechaIniCon=$ano2."-".$mes2."-"."01";
		$FechaFinCon=$ano2."-".$mes2."-"."31";
		$TotalPeso=0;$TotalPesoR=0;$TotalPiezas=0;$TotalPiezasR=0;
		$Consulta="select t1.guia,t1.fecha_guia,t1.lote_ventana,t2.lote_origen,t1.marca,t2.hornada_ventana,t1.peso,t1.peso_recep,t1.piezas,t1.piezas_recep,t1.estado ";
		$Consulta.="from sea_web.recepcion_externa t1 left join sea_web.relaciones t2 on t1.lote_ventana=t2.lote_ventana ";
		$Consulta.="where (fecha between '".$FechaIniCon."' and '".$FechaFinCon."') and (t1.estado in('C','X') or t1.peso = t1.peso_recep) order by t1.guia";
		//echo $Consulta."<br>";
		$RespGuia=mysqli_query($link, $Consulta);
		while($FilaGuia=mysqli_fetch_array($RespGuia))
		{
			if($FilaGuia["estado"]=='X')
				echo "<tr class='Detalle03'>";
			else
				echo "<tr>";	
			echo "<td align='center'>".$FilaGuia["guia"]."</td>";
			echo "<td align='center'>".$FilaGuia["fecha_guia"]."</td>";		
			echo "<td align='center'><a href=JavaScript:MostrarLotes('".$FilaGuia["lote_ventana"]."','".$FilaGuia["guia"]."','".$FilaGuia["lote_origen"]."')>".$FilaGuia["lote_ventana"]."</a></td>";		
			echo "<td align='center'>".$FilaGuia["lote_origen"]."</td>";		
			echo "<td align='center'>".$FilaGuia["hornada_ventana"]."</td>";		
			echo "<td align='center'>".$FilaGuia["marca"]."</td>";		
			echo "<td align='right'>".number_format($FilaGuia["peso"],0,'','.')."</td>";
			echo "<td align='right'>".number_format($FilaGuia["peso_recep"],0,'','.')."</td>";		
			echo "<td align='right'>".number_format($FilaGuia["piezas"],0,'','.')."</td>";
			echo "<td align='right'>".number_format($FilaGuia["piezas_recep"],0,'','.')."</td>";
			echo "</tr>";
			$TotalPeso=$TotalPeso+$FilaGuia["peso"];
			$TotalPesoR=$TotalPesoR+$FilaGuia["peso_recep"];
			$TotalPiezas=$TotalPiezas+$FilaGuia["piezas"];
			$TotalPiezasR=$TotalPiezasR+$FilaGuia["piezas_recep"];
		}
		echo "<tr class='Detalle01'>";
		echo "<td colspan='6'>&nbsp;</td>";
		echo "<td align='right'>".number_format($TotalPeso,0,'','.')."</td>";
		echo "<td align='right'>".number_format($TotalPesoR,0,'','.')."</td>";
		echo "<td align='right'>".number_format($TotalPiezas,0,'','.')."</td>";
		echo "<td align='right'>".number_format($TotalPiezasR,0,'','.')."</td>";
		echo "</tr>";	
 }
}  
?>
        </table>
		<br>
        <table width="760" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="766"><div align="center"><font color="#000000" size="2">&nbsp; 
                <?php
				 if($Est=='A')
					echo'<input name="grabar" type="button" style="width:70" value="Grabar" onClick="Guardar_Datos();">';
				 if($Encontrado == "S" && $proveedor != "00001100-2" && $unidades == '' && $codigo == "B")
					echo'<input name="grabar2" type="button" style="width:70" value="xxxGrabar" onClick="Guardar_Datos2(this.form,'.($cont).');">';
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
