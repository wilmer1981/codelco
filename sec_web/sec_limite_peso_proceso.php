<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;

if($Opc=='M')
{
	$Datos=explode('~',$Valores);
	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='3105' and cod_subclase='".$Datos[0]."' and valor_subclase2='".$Datos[1]."' and valor_subclase3='".$Datos[2]."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$CodSubclase=$Fila["cod_subclase"];
		$CmbProductos=$Fila[valor_subclase2];
		$CmbSubProducto=$Fila[valor_subclase3];
		$TxtPesoLimite=$Fila["valor_subclase1"];
	}
}
else
{
		$CmbProductos='-1';
		$CmbSubProducto='-1';
		$TxtPesoLimite='';
}
if($OP=='G')
{

	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='3105' and valor_subclase2='".$Prod."' and valor_subclase3='".$SubProd."'";
	$Resp=mysqli_query($link, $Consulta);
	if(!$Fila=mysqli_fetch_array($Resp))
	{
		$Consulta2="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='3105'";
		$Resp2=mysqli_query($link, $Consulta2);
		if($Fila2=mysqli_fetch_array($Resp2))
		{
			if($Fila2[maximo]=='')
				$CodSubClase='1';
			else		
				$CodSubClase=$Fila2[maximo];
		}	
		$Insertar="insert into proyecto_modernizacion.sub_clase(cod_subclase,cod_clase,valor_subclase1,valor_subclase2,valor_subclase3)";
		$Insertar.=" values('".$CodSubClase."','3105','".$Peso."','".$Prod."','".$SubProd."')";
		//echo $Insertar."<br>";
		mysqli_query($link, $Insertar);
		
		$Exis='N';
		$Opc='N';
		$CmbProductos='-1';
		$CmbSubProducto='-1';
		$TxtPesoLimite='';
	}
	else
	{
		$CodSubclase=$Fila["cod_subclase"];
		$Exis='S';
		$Opc='M';
	}
}
if($OP=='M')
{
	//echo $CodSubM."<br>";
	$DatoM=explode('~',$CodSubM);
	while(list($c,$CodSubclaseM)=each($DatoM))
	{
		//echo $CodSubclaseM;
		$Actualizar="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='$Peso' where cod_clase='3105' and cod_subclase='".$CodSubclaseM."'";
		//echo $Actualizar."<br>";
		mysqli_query($link, $Actualizar);
	}
	$TxtPesoLimite='';
}
//echo $Opc;
?>
<html>
<head>
<title>Mantenedor de Limite Peso</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(Opcion,Re)
{
	var popup=0;
	var frm=document.FrmPrincipal;
	switch (Opcion)
	{
		case "G": 
			if(frm.CmbProductos.value=='-1')
			{
				alert('Debe Seleccionar Producto');
				frm.CmbProductos.focus();
				return;
			}
			if(frm.CmbSubProducto.value=='-1')
			{
				alert('Debe Seleccionar SubProducto');
				frm.CmbSubProducto.focus();
				return;
			}
			if(frm.TxtPesoLimite.value=='')
			{
				alert('Debe Ingresar Peso Limite');
				frm.TxtPesoLimite.focus();
				return;
			}
			frm.action ="sec_limite_peso_proceso.php?OP=G&Prod="+frm.CmbProductos.value+"&SubProd="+frm.CmbSubProducto.value+"&Peso="+frm.TxtPesoLimite.value;  
			frm.submit();
		break;	
/*		case "M": 
			if(frm.TxtPesoLimite.value=='')
			{
				alert('Debe Ingresar Peso Limite');
				frm.TxtPesoLimite.focus();
				return;
			}
			alert(frm.CodLimite.value)
			//frm.action ="sec_limite_peso_proceso.php?OP=M&CodSub="+frm.CodSub.value+"&Prod="+frm.CmbProductos.value+"&SubProd="+frm.CmbSubProducto.value+"&Peso="+frm.TxtPesoLimite.value+"&CodLimite="f.CodLimite.value;  
			//frm.submit();
		break;	*/
		case "R"://recarga pagina
			frm.action ="sec_limite_peso_proceso.php?Opc="+Re;  
			frm.submit();
		break;
	
		
		case "S":
			window.opener.document.frmPrincipal.action="sec_limite_peso.php?Buscar=S";
			window.opener.document.frmPrincipal.submit();		
			window.close();	
			window.close();
		break;	
		
	}	

}
function Modifica(CodLimites)
{
	var frm=document.FrmPrincipal;
	if(frm.TxtPesoLimite.value=='')
	{
		alert('Debe Ingresar Peso Limite');
		frm.TxtPesoLimite.focus();
		return;
	}
	//alert(CodLimites)
	frm.action ="sec_limite_peso_proceso.php?Opc=N&OP=M&CodSubM="+CodLimites+"&Prod="+frm.CmbProductos.value+"&SubProd="+frm.CmbSubProducto.value+"&Peso="+frm.TxtPesoLimite.value;  
	frm.submit();
}
function SoloUnElemento(f,inputchk,Opc)
{
	var CantCheck=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			CantCheck++;
	}
	if (Opc=='M')
	{
		if (CantCheck > 1 ||CantCheck==0)
		{
			if(CantCheck==0)
				alert("Debe Seleccionar un Elemento");
			else
				alert("Debe Seleccionar solo un Elemento");
			return(false);
		}
		else
			return(true);
	}
	else
	{
		if(CantCheck==0)
			alert("Debe Seleccionar un Elemento");
		else
			return(true);			
	}
}
function Recuperar(f,inputchk,niv,rutc)
{
	var Valores="";
	var Encontro=false;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
		{
			if(niv=='4')
			{
				if(eval("document."+f+".elements["+i+2+"].value")==rutc)
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
//				alert(eval("document."+f+".elements["+i+2+"].value"));
				}
				else
				{
					alert("Ud No tiene Acceso a Modificar el Requerimiento");
					Valores="";
				}
			}
			else
			{
				if(niv=='AN')
				{
					if((eval("document."+f+"."+inputchk+"["+i+"].checked")) == true)
					{
						//Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) + "~"+ (eval("document."+f+"."+inputchk+"["+i+1+"].value")) + "//" ;
						Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))+ "~" + "A" + "//" ;
						Encontro=true;
					}
				}
				else
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
				}
			}
		}
		else
		{
			if(niv=='AN')
			{
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value"))  + "~" + "R" + "//" ;
				Encontro=true;
			}
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function CheckearTodo(f,nomchk,nomchkT)
{
	var Check=new Object();
	var CheckT=new Object();
	
	try
	{
		eval("document."+f.name+"."+nomchk+"[0]");
		Check=eval("document."+f.name+"."+nomchk);
		CheckT=eval("document."+f.name+"."+nomchkT);
		for (i=1;i<Check.length;i++)
		{
			if (CheckT.checked==true){
				if(Check[i].disabled==false)
					Check[i].checked=true;
			}
			else{
				if(Check[i].disabled==false)
					Check[i].checked=false;
			}
		}
	}
	catch (e)
	{
	}
}
</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="CodSub" value="<?php echo $CodSubclase;?>">
  <table border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="756" align="center" >
	  <table width="386" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
			<?php
			if($Opc=='N')	
			{
			?>
			  <tr bgcolor="#FFFFFF"> 
				<td>Producto</td>
				<td>
				  <select name="CmbProductos" style="width:280" onChange="Proceso('R','<?php echo $Opc;?>')">
					<option value='-1' selected>Seleccionar</option>
					<?php 					
						$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							if ($CmbProductos==$Fila["cod_producto"])
								echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
							else
								echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
					?>
				  </select>
			  </td>
			  </tr>
	 		  <tr bgcolor="#FFFFFF"> 
				<td>SubProducto</td>
				<td>
				  <select name="CmbSubProducto" style="width:280" onChange="Proceso('R','<?php echo $Opc;?>')">
					<option value="-1" selected>Seleccionar</option>
					<?php
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						else
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					?>
				  </select>
				</td>
			  </tr>
			 <?php
			 }
			 ?> 
			<?php
				if($Opc=='M')
				{
				?>
				  <tr class="ColorTabla01"> 
					<td width="200">Productos</td>
					<td>Sub-Productos</td>
				  </tr>					
				<?php
					$Valores=explode('//',$Valores);
					while(list($c,$v)=each($Valores))
					{
						$Dato=explode('~',$v);						
						$CodLimites=$CodLimites.$Dato[0]."~";						
					?>				
					  <tr bgcolor="#FFFFFF"> 
						<td>
							<?php	
							$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos where cod_producto='".$Dato[1]."'order by descripcion"; 
							$Respuesta = mysqli_query($link, $Consulta);
							if($Fila=mysqli_fetch_array($Respuesta))
								echo $Fila["descripcion"];
							echo "<input type='hidden' name='CmbProductos' value='".$CmbProductos."'>";	
							?>
						</td>
						<td>
							<?php
							$Consulta="select cod_producto,descripcion from proyecto_modernizacion.subproducto where cod_producto = '".$Dato[1]."' and cod_subproducto='".$Dato[2]."'order by descripcion"; 
							$Respuesta = mysqli_query($link, $Consulta);
							if($Fila=mysqli_fetch_array($Respuesta))
								echo $Fila["descripcion"];
							echo "<input type='hidden' name='CmbSubProducto' value='".$CmbSubProducto."'>";	
							?>
						</td>
					  </tr>
					<?php
					}
				 }
			 ?>
			 </table>
			<table width="386" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
			  <tr>
				<td align="right" width="200" bgcolor="#FFFFFF">Peso Limite:</td>
				<?php
					if($Opc=='N')
						echo "<td bgcolor='#FFFFFF'>";
					else
						echo "<td bgcolor='#FFFFFF' colspan='3'>";
				?>
				<input name="TxtPesoLimite" type="text" class="InputIzq" id="TxtPesoLimite" onKeyDown="TeclaPulsada2('S',false,this.form,'');" value="<?php echo $TxtPesoLimite; ?>" size="3" maxlength="2">
				</td>
			  </tr>
				<?php if($Opc=='N')
					{
				?>
				  <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
					<td colspan="2">
					<input name="BtnDetalle2" type="button" id="BtnDetalle2" style="width:80" value="Guardar" onClick="Proceso('G');">
				<?php
					}
					else
					{
						if($CodLimites !='')
							$CodLimites=substr($CodLimites,0,strlen($CodLimites)-1);		
				?>	
				  <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
					<td colspan="4">
					<input name="BtnDetalle2" type="button" id="BtnDetalle2" style="width:80" value="Modificar" onClick="Modifica('<?php echo $CodLimites;?>');">
				<?php
					}
				?>
				  <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:80" onClick="Proceso('S');"></td>
            </tr>
          </table>
 </td>
 </tr>
 </table>
		  
 </form>
</body>
</html>
<?php
	echo "<script languaje='JavaScript'>";
	if ($Exis=='S')
		echo "alert('Registro Exitosamente');";
	if ($Msj=='4')
		echo "alert('Registro(s) Eliminado(s) Exitosamente');";
	echo "</script>";
?>