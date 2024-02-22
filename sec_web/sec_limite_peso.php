<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla=60;
	$Mensaje='';
	include("../principal/conectar_principal.php");


	if($Eliminar=='S')
	{
		$Dato=explode('//',$Valores);
		while(list($c,$v)=each($Dato))
		{
			$Datos=explode('~',$v);
			$Elimina="delete from proyecto_modernizacion.sub_clase where cod_clase='3105' and cod_subclase='".$Datos[0]."'";
			//echo $Elimina."<br>";
			mysqli_query($link, $Elimina);
		}		
		$Eli='S';
	}

?>	
<html><head>
<title>Limite Peso Camiones</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
<!--
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaraci�n del array Buffer 
var cadena="" 
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 450 ");
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
function Proceso(Opcion)
{
	var popup=0;
	var frm=document.frmPrincipal;
	switch (Opcion)
	{
		case "B": 
			frm.action ="sec_limite_peso.php?Buscar=S";  
			frm.submit();
		break;	
		case "R"://recarga pagina
			frm.action ="sec_limite_peso.php";  
			frm.submit();
		break;
		case "N"://nuevo
			URL="sec_limite_peso_proceso.php?Opc=N";
			opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=300,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			//popup.moveTo((screen.width - 1024)/2,0);
		break;
		case "M"://modifica
		 	Valores=Recuperar(frm.name,'CheckTipo','','');
			if(Valores=='')
			{
				alert('Debe Seleccionar Dato a Modificar');
				return;
			}
			//alert(Valores)
			URL="sec_limite_peso_proceso.php?Opc=M&Valores="+Valores;
			opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=300,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			//popup.moveTo((screen.width - 1024)/2,0);
		break;
		
		case "E":
		var Valores='';
		 	Valores=Recuperar(frm.name,'CheckTipo','','');
			if(confirm("Esta seguro de Eliminar los registros Selecionados"))
			{
				//alert(Valores)
				frm.action ="sec_limite_peso.php?Buscar=S&Eliminar=S&Valores="+Valores;  
				frm.submit();
			}	//popup.moveTo((screen.width - 1024)/2,0);
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=3";
		break;	
		
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form action="" method="post" name="frmPrincipal" >
<?php include("../principal/encabezado.php") ?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="756" align="center" valign="top"><table width="761" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">

          <tr bgcolor="#FFFFFF">
            <td width="87"> Producto</td>
            <td><font size="1"><font size="1"><font size="2"><strong>
              <select name="CmbProductos" style="width:280" onChange="Proceso('R')">
                <option value='T' selected>Todos</option>
                <?php 					
					$Consulta="select cod_producto,descripcion from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.valor_subclase2 where t1.cod_clase='3105'  group by t2.cod_producto order by t2.descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						else
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				?>
              </select><?php //echo $Consulta;?>
            </strong></font></font></font></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>SubProducto</td>
            <td><font size="1"><font size="2"><strong>
              <select name="CmbSubProducto" style="width:280" onChange="Proceso('R')">
                <option value="T" selected>Todos</option>
                <?php
					$Consulta="select cod_subproducto,descripcion from subproducto t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_subproducto=t2.valor_subclase3 where cod_producto = '".$CmbProductos."' and t2.cod_clase='3105'  group by t1.cod_subproducto order by descripcion"; 
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
            </strong></font></font></td>
          </tr>

          <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
            <td colspan="2"><input name="BtnDetalle3" type="button" id="BtnDetalle3" style="width:80" value="Buscar" onClick="Proceso('B');">
                <input name="BtnDetalle2" type="button" id="BtnDetalle2" style="width:80" value="Nuevo" onClick="Proceso('N');">
                <input name="BtnDetalle22" type="button" id="BtnDetalle22" style="width:80" value="Modificar" onClick="Proceso('M');">
                <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:80"value="Eliminar" onClick="Proceso('E');">
                <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:80" onClick="Proceso('S');"></td>
          </tr>
        </table>
          <br>
          <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaDetalle" >
            <tr align="center" class="ColorTabla01">
              <td width="45" height="34">Todos<br>
                  <input name="ChkTodos" type="checkbox" onClick="CheckearTodo(this.form,'CheckTipo','ChkTodos');"></td>
              <td width="273" >Producto</td>
              <td width="349" >Subproducto</td>
              <td width="70" >Peso Limite</td>
            </tr>
            <?php		
				if($Buscar=='S')
				{
					$Consulta="select t1.*,t2.descripcion as Prod,t3.descripcion as SubProd from proyecto_modernizacion.sub_clase t1 ";
					$Consulta.=" left join proyecto_modernizacion.productos t2 on t1.valor_subclase2=t2.cod_producto";
					$Consulta.=" left join proyecto_modernizacion.subproducto t3 on t1.valor_subclase2=t3.cod_producto and t1.valor_subclase3=t3.cod_subproducto";
					$Consulta.=" where t1.cod_clase='3105' and t1.valor_subclase2<>''";
					if($CmbProductos!='T')
						$Consulta.=" and t1.valor_subclase2='".$CmbProductos."'";
					if($CmbSubProducto!='T')
						$Consulta.=" and t1.valor_subclase3='".$CmbSubProducto."'";
					$Consulta.=" order by t2.cod_producto,t3.cod_subproducto";
					//echo 	$Consulta."<br>";
					echo "<input name='CheckTipo' type='hidden'  value=''>";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						$Clave=$Fila["cod_subclase"]."~".$Fila[valor_subclase2]."~".$Fila[valor_subclase3];
						
						?>
            <tr bgcolor="#FFFFFF">
              <td align="center"><input name='CheckTipo'  type='checkbox'  value='<?php echo $Clave;?>'></td>
              <td align='left'><?php echo ucwords(strtolower($Fila[Prod]));?></td>
              <td align='left'><?php echo ucwords(strtolower($Fila[SubProd]));?></td>
              <td align='right'><?php echo $Fila["valor_subclase1"];?></td>
            </tr>
            <?php
					}					
				}	
			?>
          </table></td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
<?php
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje');";
	echo "var f = document.frmPrincipal;";
	echo "</script>";
}
?>