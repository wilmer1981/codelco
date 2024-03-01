<?php 	
	include("../principal/conectar_sec_web.php");
	$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "OTROS PESAJES", 19=> "RESTOS ANODOS", 17=> "ANODOS");
	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 79;
	
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$cmbproducto  = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"-1";
	$cmbsubproducto  = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"-1";
	$EncontroRelacion  = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$reg_delete  = isset($_REQUEST["reg_delete"])?$_REQUEST["reg_delete"]:"";
	$Msj  = isset($_REQUEST["Msj"])?$_REQUEST["Msj"]:"";
	
?>
<html>
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
	
function Recargar()
{
	var f = document.FrmProducto;
	
		f.action = "sec_producto.php?cmbproducto="+f.cmbproducto.value+"&cmbsubproducto="+f.cmbsubproducto.value;
		
	f.submit();
}
function Salir()
{
	var Frm=document.FrmProducto;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
	Frm.submit();
}


function RecuperarValoresCheckeado()
{
	var Frm=document.FrmProducto;
	var Valores="";
	var paso=false;

	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
		{
			paso=true

			Valores=Valores +Frm.CheckCod[i].value+"//" ;

		}
	}
	if(paso==true)
	{

		Valores=Valores.substring(0,Valores.length -2);
	}
/*	alert(Valores);*/
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmProducto;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckCod[i].checked=true;
			}
			else
			{
				Frm.CheckCod[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmProducto;
	var CantCheck=0;
	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
		{
			CantCheck=CantCheck+1;
		}
	}
	if (CantCheck > 1)
	{
		alert("Debe Seleccionar solo un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}
function SeleccionoCheck()
{
	var Frm=document.FrmProducto;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
		{
			Encontro=true;
			break;
		}
	}
	if (Encontro==false)
	{
		alert("Debe Seleccionar un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmProducto;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("sec_producto_proceso.php?Proceso="+Proceso,"","top=110,left=180,width=650,height=250,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck())
			{
				if (SoloUnElementoCheck())
				{

					Valores=RecuperarValoresCheckeado();
					window.open("sec_producto_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=180,width=650,height=250,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("�Est� seguro de eliminar los datos seleccionados?");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();

					Frm.action="sec_producto_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}


</script>
<title>Ingreso de Producto</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProducto" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"> 
		<table border="0" >
		  <tr>
		    <td colspan="4" align="center"><input type="button" name="nuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');"/>
		    	&nbsp;&nbsp;<input type="button" name="modificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');"/>
		    	&nbsp;&nbsp;<input type="button" name="eliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');"/>
		    	&nbsp;&nbsp;<input type="button" name="salir" value="Salir" style="width:60" onClick="Salir();"/></td>
		     </tr>
              <tr>
		    <td>Producto</td>
		   
		    <td><select name="cmbproducto" onChange="Recargar()">
			<option value="-1">Todos</option>
			<?php
			
				foreach($productos as $clave => $valor)
				{
					if ($clave == $cmbproducto)
						echo '<option value="'.$clave.'" selected>'.$valor.'</option>';
					else 
						echo '<option value="'.$clave.'">'.$valor.'</option>';
				}	
			
			?>			
              </select></td>
		    
		    <td>Sub Producto</td>
		    
		    <td><select name="cmbsubproducto" onChange="Recargar()">
                <option value="-1">Todos</option>
                <?php	
					$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = ".$cmbproducto;
					//echo '<option value="-1">'.$consulta.'</option>';
					$var1 = $consulta;
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						$codigo = $row["cod_subproducto"];
						$descripcion = $row["descripcion"];
					//	if (($cmbmovimiento == 3) and ($cmbproducto == 48) and ($codigo == 1))	
					//		$descripcion = "LAMINAS";
					
						if ($codigo == $cmbsubproducto)
							echo '<option value="'.$codigo.'" selected>'.$descripcion.'</option>';
						else
							echo '<option value="'.$codigo.'">'.$descripcion.'</option>';
					}						
				?>
          			 </select>
       			</td>
		     </tr>
	    </table>
		<br><?php
		echo "<table width='100%' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='ColorTabla01'>"; 
			echo "<td ><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td  align='center'>Producto</td>";
			echo "<td  align='center'>Sub Producto</td>";
			echo "<td  align='center'>C&oacute;digo SAP </td>";
			echo "<td  align='center'>Denominaci&oacute;n SAP</td>";
			echo "<td  align='center'>Unidad SAP</td>";
		echo "</tr>";
		$Consulta="select t1.cod_producto_sec,t1.cod_subproducto_sec,t2.descripcion as DESC_PRODUCTO,t3.descripcion as DESC_SUBPRODUCTO,t1.denominacion_sap,t1.codigo_material,t1.COD_UNIDAD_SAP from sec_web.homologacion_producto_sap t1";
		$Consulta.=" left join  proyecto_modernizacion.productos t2 on t1.cod_producto_sec=t2.cod_producto ";
		$Consulta.=" left join  proyecto_modernizacion.subproducto t3 on t1.cod_producto_sec=t3.cod_producto and t1.cod_subproducto_sec=t3.cod_subproducto";
		if($cmbproducto!='-1')
			$Consulta.=" where  t1.cod_producto_sec='".$cmbproducto."' ";
		if($cmbsubproducto!='-1')
			$Consulta.=" and t1.cod_subproducto_sec='".$cmbsubproducto."'";
		$Resultado=mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckCod'>";
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckCod' value='".$Fila["cod_producto_sec"]."-".$Fila["cod_subproducto_sec"]."'></td>";
				echo "<td align='right'>".$Fila["DESC_PRODUCTO"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["DESC_SUBPRODUCTO"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["codigo_material"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["denominacion_sap"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["COD_UNIDAD_SAP"]."&nbsp;</td>";
			echo "</tr>";
		}
		echo "</table>"
		?>
      </td>
  </tr>
  </table>
 <?php  echo "<script languaje='JavaScript'>";
if($EncontroRelacion){

		echo "alert('No se puede eliminar el registro debido a que tiene datos relacionados.');";
		
}if($reg_delete){

		echo "alert('Registro eliminado correctamente.');";
		
}

if($Msg!=''){
		  echo "alert('".$Msg."');";
	
}
echo "</script>";
include("../principal/pie_pagina.php")



?>
</form>
</body>
</html>
