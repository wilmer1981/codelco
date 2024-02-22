<?
	switch($RValor)
	{
		case 'OpcionUno':
			$EstRad1='checked';
			$EstRad2='';
			break;			
		case 'OpcionDos':
			$EstRad1='';
			$EstRad2='checked';
			break;	

		default:
			$EstRad1='checked';
			$EstRad2='';
			break;
	}	
	
	switch($ValorRadio)
	{
		case 'FUNDICION':
			$EstRadio1='checked';
			$EstRadio2='';
			$EstRadio3='';
			break;			
		case 'RAF':
			$EstRadio1='';
			$EstRadio2='checked';
			$EstRadio3='';
			break;	
		case 'REF':
			$EstRadio1='';
			$EstRadio2='';
			$EstRadio3='checked';		
			break;
		default:
			$EstRadio1='checked';
			$EstRadio2='';
			$EstRadio3='';
			break;			
	}		

	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
</head>
<script language="javascript">

function VolverBalance()
{
	var f=document.form1;
	f.action='../met_web/BalanceDF.php';
	f.submit();
}

function Salir()
{
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}


function HabilitarNuevoItem()
{
	var f=document.form1;
	var RadioValor='';		
	
	//if(f.radiobutton[1].checked==true)
		RadioValor=f.radiobutton[1].value;		
	
	f.procesos.disabled=false;
	f.grupos.disabled=false;
	f.elradio.disabled=false;
	f.BtnActualizar.disabled=false;
	f.BtnActualizarEntSal.disabled=false;
	f.ButtonVer.disabled=true;
	f.Btnvolver.disabled=true;
	
	f.action="AgregarFlujos.php?RValor="+RadioValor ;
	//f.submit();		
}

function Mostrar() // function de apoyo para mostrar el cuadro de seleccion de procesos y luego visualizar sus Items asociados
{
	var f=document.form1;
	var RadioValor='';	
	if(f.radiobutton[0].checked==true)
	{
		RadioValor=f.radiobutton[0].value;	
		f.action="AgregarFlujos.php?AgregarFlujoOPT=S&RValor="+RadioValor ;
	}
	else
	{
		RadioValor=f.radiobutton[1].value;	
		f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor="+RadioValor ;
	}
	f.submit();		
}

function Ver() // function de apoyo que permite ver los Items existentes asociados al proceso seleccionado
{
	var f=document.form1;
	var VRadio='';
	
	if(f.elradio[0].checked==true)
		VRadio=f.elradio[0].value;
	else if(f.elradio[2].checked==true)
		VRadio=f.elradio[2].value;
	else if(f.elradio[1].checked==true)
		VRadio=f.elradio[1].value;
	
	f.action="AgregarFlujos.php?AgregarExistenteOPT=S&ValorRadio="+VRadio ;
	f.submit();	
}

function IngresarNuevoItem() // function de apoyo para ingresar flujo a un Item ya existente
{
	var f=document.form1;
	
	if(f.nuevoFlujo.value=='')
	{
		alert ("Debe Ingresar Numero de Flujo");
		f.nuevoFlujo.focus();
		return false;
	}
	if(isNaN(parseInt(f.nuevoFlujo.value)))
	{
		alert ("N�mero de Flujo s�lo acepta el ingreso de n�meros");
		return false;
	}		
		
	f.action="AgregarFlujos.php?IngresarItemOPT=S" ;
	f.submit();	
}

//----------------------------------------------------------

//----------------------------------------------------------

function ActualizarGrupos()
{
	var f=document.form1;
	var RadioValor='';
	var procesosN ='';
	procesosN=f.procesos.value;	

	if(f.radiobutton[0].checked==true){
		RadioValor=f.radiobutton[0].value;
		f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor=&procesos"+RadioValor+procesosN;
		//f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor="+RadioValor;	
		}
	else if(f.radiobutton[1].checked==true){
		RadioValor=f.radiobutton[1].value;
		f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor=&procesos"+RadioValor+procesosN;
		//f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor="+RadioValor;	
		}
	f.submit();	
}

function ActualizarEntSal()
{
	var f=document.form1;
	f.action="AgregarFlujos.php?ActualizarEntSalOPT=S" ;
	var RadioValor='';
	var procesosN ='';
	var txtEA='';
	txtEA=f.oculto.value;
	procesosN=f.procesos.value;	

	if(f.radiobutton[0].checked==true)
	{
		RadioValor=f.radiobutton[0].value;
		f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor=&procesos=&TxtEntSal"+RadioValor+procesosN+txtEA;
		//f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor="+RadioValor;	
	}
	else if(f.radiobutton[1].checked==true)
	{
		RadioValor=f.radiobutton[1].value;
		f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor=&procesos=&TxtEntSal"+RadioValor+procesosN+txtEA;
		//f.action="AgregarFlujos.php?AgregarFlujoNuevoItemOPT=S&RValor="+RadioValor;	
	}
	f.submit();
}

function HabilitarGrupoPropio()
{
	var f=document.form1;
	f.txtEntradaPropia.disabled=false;	
	f.txtgrupoPropio.disabled=false;	
	f.grupos.disabled=true;
	f.Txtproceso.disabled=true;	
}

function DesahilitaGrupoPropio()
{
	var f=document.form1;
	f.txtEntradaPropia.disabled=true;
	f.txtgrupoPropio.disabled=true;
	f.grupos.disabled=false;
	f.Txtproceso.disabled=false;
}

function IngresarNuevoFlujoItem()
{
	var f=document.form1;
	
	if(f.txtgrupoPropio.disabled==false)
	{
		if(f.txtgrupoPropio.value=='')
		{
			alert ("No ha indicado el grupo del nuevo Item");
			f.txtgrupoPropio.focus();
			return false;
		}	
	}
	
	if(f.TxtEntSalExistente.value=='')
	{
		alert ("No ha indicado si el nuevo Item es de Entrada o Salida");
		return false;
	}	
	if(f.NomNuevoItem.value=='')
	{
		alert ("Debe Ingresar Nombre del nuevo Item");
		f.NomNuevoItem.focus();
		return false;
	}
	if(f.FlujoNuevoItem.value=='')
	{
		alert ("Debe Ingresar N�mero de Flujo");
		f.FlujoNuevoItem.focus();
		return false;
	}	
	if(isNaN(parseInt(f.FlujoNuevoItem.value)))
	{
		alert ("N�mero de Flujo s�lo acepta el ingreso de n�meros");
		return false;
	}			
	
	f.action="AgregarFlujos.php?IngresarNuevoFlujoItemOPT=S" ;
	f.submit();	

}



</script>


<body>
<form name="form1" method="post" action="">
<?
	include("../principal/encabezado.php");
	include("conectar.php");
?>
  <table width="770" height="353" border="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="top">
	  
	  <table width="649" border="1" align="center">
        <tr class="Detalle03">
          <td colspan="4"><div align="center"><strong>Agregar Flujos </strong></div></td>
          </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
          </tr>
        
        <tr>
          <td width="88" align="left">&nbsp;</td>
          <td width="217" align="left"><input name="radiobutton" type="radio"  value="OpcionUno"  <? echo $EstRad1?> >
  Agregar Flujo a un Item ya existente </td>
          <td width="237" align="left"><input name="radiobutton" type="radio" value="OpcionDos" <? echo $EstRad2?> >
            Ingresar Flujo junto a un nuevo Item </td>
          <td width="79" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left"><div align="center">
                <input name="BtnSeleccionar" type="button" id="BtnSeleccionar" onClick="Mostrar()" value="Seleccionar">
                <input type="button" name="BtnVolver" value="Ir a Balance" onClick="VolverBalance()">            
                <input type="button" name="BtnSalir" value="Salir" onClick="Salir()">
          </div></td>
          </tr>
	  </table>	  
	  <p>&nbsp;</p>
	  
	  <?php
	  
	  // Codigo para ingresar un flujo asociado a un Item ya existente 
	  
	  if($AgregarFlujoOPT=="S")
	  {
			  echo "<table width='435' border='1' align='center'>";
			  echo "<tr class='Detalle03'>";
	          echo "<td colspan='3' align='center'><strong>Seleccione Proceso<strong></strong></td>";
     		  echo "</tr>";
			  echo "<tr>";
			  echo "<td width='112' align='center'><input name='elradio' type='radio' value='FUNDICION' echo $EstRadio1; checked> <strong>Fundicion</strong></td>";
			  echo "<td width='146'><div align='center'><input name='elradio' type='radio' value='RAF' echo $EstRadio2; ><strong>Refino A Fuego </strong></div></td>";
			  echo "<td width='199' align='center'><input name='elradio' type='radio' value='REF' echo $EstRadio3; ><strong>Refineria Electrolitica</strong></td>";
			  echo "</tr>";
			  echo "<tr>";
			  echo "<td colspan='3' align='center'><input name='ButtonVer' type='button' id='Button' value='Ver Items' onClick='Ver()'></td>";
			  echo "</tr>";
			  echo "</table>";
	  }
	  
	  if($AgregarExistenteOPT=="S")
	  {
	  	echo "<table width='600' border='1'>";
        echo "<tr>";
          echo "<td colspan='5' class='Detalle03'><div align='center'><strong>Agregar Flujo a un Item ya existente - Proceso ".$elradio."</strong></div></td>";
          echo "</tr>";
        echo "<tr>";
          echo "<td colspan='5'>".$tr."</td>";
          echo "</tr>";
        echo "<tr>";
          echo "<td width='135' rowspan='2'>&nbsp;</td>";//width='86'
          echo "<td width='80' align='right'><strong>Seleccione Item</strong> </td>";
          echo "<td colspan='3' align='left'><select name='items'>";          
		  
		  $consulta1 = "Select nom_item from item where proceso='$elradio' ";		  
		  $resultado = mysql_query($consulta1);
	  	  while($fila = mysql_fetch_array($resultado))
		  {
			echo "<option value='".$fila[nom_item]."' >".$fila[nom_item]."</option>";
		  }
			echo "</select>";echo "</td>";		  
		  
		  echo "</select></td>";
          echo "</tr>";
        echo "<tr>";
        echo  "<td width='80' align='right'><strong>Ingrese Flujo </strong></td>";
          echo "<td width='36' align='left'><input width='50' type='text' name='nuevoFlujo'></td>";
          echo "<td width='198' align='left'><input type='button' name='BtnIngresar' value='Ingresar' onclick='IngresarNuevoItem()'></td>";
        echo "</tr>";
      echo "</table>";
	 }	  
	
	 if($IngresarItemOPT=="S")
	 {
	  	$consulta="Select count(*) as flujo from item, flujoitem where item.nom_item='$items' and item.cod_item=flujoitem.cod_item and flujoitem.flujo='$nuevoFlujo' ";
	  	$resultado=mysql_query($consulta); $aux=0;
	  	while($fila=mysql_fetch_array($resultado)) 
		{
			if($fila["flujo"]>=1)
				$aux=1;
		}
		if($aux==0)
		{
			$consulta2="Select cod_item from item where item.nom_item='$items'";
	  		$resultado2=mysql_query($consulta2);
			if($fila2=mysql_fetch_array($resultado2))
			{
				$consulta3="Insert into flujoitem(cod_item,flujo) values ('$fila2[cod_item]','$nuevoFlujo') ";
				$resultado3=mysql_query($consulta3);
			}
			echo "<table width='400' border='1' class='TablaPrincipal'>";
			echo "<tr class='Detalle03'>";
			echo "<td><strong>Flujo Ingresado Correctamente</strong></td>";
	    	echo "</tr>";
			echo "</table>";
		}else{				
			echo "<table width='400' border='1' class='TablaPrincipal'>";
			echo "<tr class='Detalle03'>";
			echo "<td><strong>El item seleccionado ya tiene asociado el n�mero de flujo indicado</strong></td>";
			echo "</tr>";
			echo "</table>";
		}
	  } 	  
	  
	 // Fin de codigo para ingresar un flujo asociado a un Item ya existente
	  
	 // ------------------------------------------------------------------- 
	  
	 // Codigo para ingresar un flujo asociado a un Item nuevo
	  
	  if($AgregarFlujoNuevoItemOPT=="S")
	  {
			echo "<table width='688' border='1' align='center'>";
			echo "<tr class='Detalle03'>";
			echo "<td colspan='6' align='center'><strong>Ingresando Nuevo item y Flujo Asociado</strong></td>";
			echo "</tr>";
			echo "<tr class='ColorTabla01'>";
			echo "<td colspan='2'><div align='center'>Seleccione Proceso del nuevo Item </div></td>
				  <td colspan='2'><div align='center'>Seleccione Grupo del nuevo Item </div></td>
				  <td colspan='2'><div align='center'>Indique si el item es de Entrada o Salida </div></td>";
			 echo "</tr>";
				echo "<tr>";
				//echo "<td colspan='2'><input width='70' type='text' name='procesos' id='procesos2' value='".$procesos."' disabled>";
				echo "<td colspan='2'><select name='procesos' id='procesos2' onChange='ActualizarGrupos()' >";  
				$consulta="Select distinct proceso from item";
				$resultado=mysql_query($consulta);
				while($fila=mysql_fetch_array($resultado))
				{
					if($procesos==$fila[proceso])
						echo "<option selected value='".$fila[proceso]."' >".$fila[proceso]."</option>";						
					else
						echo "<option value='".$fila[proceso]."' >".$fila[proceso]."</option>";
				}
				echo "</select>"; 
				
				echo "</td>";															
				
				echo "<td colspan='2' align='left'><input name='radiogrupos' type='radio' value='GrupoExiste' checked onClick='DesahilitaGrupoPropio()' >";
			    
				echo "<select name='grupos' onChange='ActualizarEntSal()'>";				  
				$consulta1='Select distinct grupo, ent_sal from item';				
				if ($procesos!='')
				{
					$consulta1.= ' where proceso="'.$procesos.'" ';
					/*echo "<table>";
					echo "<tr>";echo "<td>".$consulta1."</td>";echo "<td>""</td>";
					echo "<tr>";
					echo "</table>";
					*/
				}
						
				$resultados=mysql_query($consulta1);
				while($fila2=mysql_fetch_array($resultados))
				{
					if($grupos==$fila2["grupo"]."~".$fila2[ent_sal])
					{
						echo "<option value='".$fila2["grupo"]."~".$fila2[ent_sal]."'selected>".$fila2["grupo"]."</option>";
						$TxtEntSal=$fila2[ent_sal];						
					}	
					else
						echo "<option value='".$fila2["grupo"]."~".$fila2[ent_sal]."'>".$fila2["grupo"]."</option>";
						//echo '<option value=''.$fila["grupo"].'' >'.$fila["grupo"].'</option>';			
				}
							
				echo "</select>";echo "<input name='oculto' type='hidden' value='$TxtEntSal' >";
				echo "<input name='Txtproceso' type='hidden' value=' echo $Txtproceso; '>";
				echo "</td>";
			    echo "<td colspan='2' align='left'><input size='2' type='text' name='TxtEntSalExistente' value='$TxtEntSal' disabled></td>";
			    echo "</tr>";
				echo "<tr>";
				echo "<td colspan='2'>&nbsp;</td>";
				echo "<td colspan='2' align='left'><input name='radiogrupos' type='radio' value='GrupoNuevo' onClick='HabilitarGrupoPropio()' >
				<input width='70' type='text' name='txtgrupoPropio' disabled></td>";
				echo "<td colspan='2' align='left'><select name='txtEntradaPropia' disabled>
				<option value='E'>Entrada</option> <option value='S'>Salida</option> </td>";
			    echo "</tr>";
				echo "<tr>";
				  echo "<td colspan='2' class='ColorTabla01' align='center'>Ingrese Nombre del Nuevo Item</td>";
				  echo "<td colspan='2' class='ColorTabla01' align='center'>Ingrese Numero de Flujo Asociado</td>";
				  echo "<td colspan='2'>&nbsp;</td>";
				echo "</tr>";
				echo "<tr>";
				  echo "<td colspan='2'><input name='NomNuevoItem' type='text' value='' Size='36' ></td>";
				  echo "<td colspan='2'><input name='FlujoNuevoItem' type='text' value='' Size='6' ></td>";
				  echo "<td colspan='2' align='left'><input name='BtnIbgresarNuevoFlujoItem' type='button' value='Ingresar' onClick='IngresarNuevoFlujoItem()' ></td>";
				echo "</tr>";
		echo "</table>";  
	  }
	  
 
	  if(ActualizargruposOPT=="S")
	  {
	  	$consulta="Select distinct grupo from item where proceso='$procesos' ";
	  	$resultado=mysql_query($consulta);
	  }
	  
	  if($ActualizarEntSalOPT=="S")
	  {	
	  	$consulta="Select ent_sal from item where proceso='$procesos' and grupo='$grupos'";
		$resultado=mysql_query($consulta);
		if($variable=mysql_fetch_array($resultado))
			echo "<input width='70' type='hidden' name='txtAuxiliar' value='$variable[ent_sal]'>";
	  }
	  
	  if($IngresarNuevoFlujoItemOPT=="S")
	  {
	    $totalItems=0;
	  	$consulta="Select count(*) as contador from item ";
		$resultado=mysql_query($consulta);
		if($fila=mysql_fetch_array($resultado))
		{
		$totalItems=$fila[contador]+1;
		}
		if($radiogrupos=='GrupoExiste')
		{
			$Datos=explode('~',$grupos);
			$varGrupo=$Datos[0];
			$varEntSal=$Datos[1];			
		}else{
			$varGrupo=$txtgrupoPropio;
			$varEntSal=$txtEntradaPropia;
		}
		
		$consultaAux="Select count(*) as contador from item where ( nom_item='$NomNuevoItem' and proceso='$procesos' and grupo='$varGrupo' and ent_sal='$varEntSal' )";
		$nuevoresultado=mysql_query($consultaAux);
		//echo $consultaAux; echo " fila contador: ".$Nuevafila[contador];
		if($Nuevafila=mysql_fetch_array($nuevoresultado))
		{
		
			if($Nuevafila[contador]==0)
			{
			// INGRESA LOS DATOS EN LA TABLA ITEM//
				$consulta1="Insert into item(cod_item,nom_item,proceso,grupo,ent_sal) values ('$totalItems','$NomNuevoItem','$procesos','$varGrupo','$varEntSal')";
				$resultado=mysql_query($consulta1);
				$consulta2="Insert into flujoitem(cod_item,flujo) values ('$totalItems','$FlujoNuevoItem')";
				// INGRESA LOS DATOS EN LA FLUJOITEM //
				$resultados=mysql_query($consulta2);
				echo "<table width='400' border='1' align='center' >";
				echo "<tr class='Detalle03'>";
				echo "<td><strong>Datos Ingresados Correctamente</strong></td>";
				echo "<tr>";
				echo "</table>";		
			}
			else
			{
				echo "<table width='400' border='1' align='center' >";
				echo "<tr class='Detalle03'>";
				echo "<td><strong>El Item que intenta ingresar ya existe</strong></td>";
				echo "<tr>";
				echo "</table>";				
			}
	  	}
	  }
	  	  
	  ?>	  
	  <p>&nbsp;</p></td>
    </tr>

 
  </table> 
<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>  
</form>
</body>
</html>
