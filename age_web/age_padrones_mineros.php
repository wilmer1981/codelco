<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 21;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$ChkOrden     = isset($_REQUEST['ChkOrden']) ? $_REQUEST['ChkOrden'] : 'R';
	$TxtFiltroPrv = isset($_REQUEST['TxtFiltroPrv']) ? $_REQUEST['TxtFiltroPrv'] : ''; 
	$CmbProveedor = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';
	$BtnMina      = isset($_REQUEST['BtnMina']) ? $_REQUEST['BtnMina'] : '';
	$BtnPropiet   = isset($_REQUEST['BtnPropiet']) ? $_REQUEST['BtnPropiet'] : '';
	$CmbMina      = isset($_REQUEST['CmbMina']) ? $_REQUEST['CmbMina'] : '';
	$TipoBusq     = isset($_REQUEST['TipoBusq']) ? $_REQUEST['TipoBusq'] : '0';
	$Recarga      = isset($_REQUEST['Recarga']) ? $_REQUEST['Recarga'] : '';
	$Mostrar      = isset($_REQUEST['Mostrar']) ? $_REQUEST['Mostrar'] : '';
	$EncontroRelacion = isset($_REQUEST['EncontroRelacion']) ? $_REQUEST['EncontroRelacion'] : '';

?>
<html>
<head>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaración del array Buffer 
var cadena="" 
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmPadronMinero;
	var Valores="";
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
			{
				Valores=Valores + Frm.CheckCod[i].value+"//";
			}
		}
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);
	}
	catch (e)
	{
	}
}
function CheckearTodo()
{
	var Frm=document.FrmPadronMinero;
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
	var Frm=document.FrmPadronMinero;
	var CantCheck=0;
	try
	{
		Frm.CheckCod[0];
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
	catch (e)
	{
	}
}
function SeleccionoCheck()
{
	var Frm=document.FrmPadronMinero;
	var Encontro="";
	
	Encontro=false; 
	try
	{
		Frm.CheckCod[0];
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
	catch (e)
	{}	
}

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmPadronMinero;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			//window.open("age_padrones_mineros_proceso.php?Proceso="+Proceso,"","top=110,left=120,width=550,height=300,scrollbars=no,resizable = no");
			window.open("age_minas_planta_proceso.php?Proceso="+Proceso,"","top=20,left=120,width=750,height=400,scrollbars=no,status=yes,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					//window.open("age_padrones_mineros_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=120,width=550,height=300,scrollbars=no,resizable = no");		
					window.open("age_minas_planta_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=20,left=120,width=750,height=400,scrollbars=no,resizable = no");
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de Eliminar los Datos Seleccionados");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action="age_padrones_mineros_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
		case "MIN":
			window.open("age_minas_proceso.php?Proceso="+Proceso,"","top=110,left=120,width=750,height=320,scrollbars=no,resizable = no");
			break;
		case "PRV":
			window.open("age_proveedores_proceso.php?Proceso="+Proceso,"","top=130,left=120,width=750,height=230,scrollbars=no,resizable = no");
			break;
		case "PRO":
			window.open("age_productores_mineros_proceso.php?Proceso="+Proceso,"","top=20,left=120,width=750,height=440,scrollbars=no,resizable = no");
			
			break;
		case "CON":
			window.open("age_consulta_multiple_mant.php","","top=5,left=0,width=960,height=440,scrollbars=yes,resizable = yes");
			break;
	} 
}
function Recarga(TipoBusq)
{
	var Frm=document.FrmPadronMinero;
	switch(TipoBusq)
	{
		case "1"://POR PROVEEDOR
			Frm.CmbMina.value='1';
			Frm.action="age_padrones_mineros.php?Recarga=S&Mostrar=S&TipoBusq=1";
			break;
		case "2"://POR MINA
			Frm.CmbProveedor.value='-1';
			Frm.action="age_padrones_mineros.php?Recarga=S&Mostrar=S&TipoBusq=2";
			break;
		case "3"://FILTRO PROVEEDOR
			Frm.CmbProveedor.value='-1';
			Frm.action="age_padrones_mineros.php?Recarga=S&TipoBusq=3";
			break;
		default:
			Frm.action="age_padrones_mineros.php?Recarga=S&TipoBusq=0";		
	}
	Frm.submit();
}
function Detalle(Valores)
{
	window.open("age_padrones_mineros.php?Valores="+Valores,"","top=5,left=5,width=750,height=430,scrollbars=yes,resizable = no");		
}
function Salir()
{
	var Frm=document.FrmPadronMinero;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=20&Nivel=1";
	Frm.submit();
}
function Recarga2()
{
	var Frm=document.FrmPadronMinero;
	Frm.action="age_padrones_mineros.php";
	Frm.submit();	
}
function buscar_op(obj,objfoco,InicioBusq,Recargar){ 
   var f = document.FrmRecepcion;
   var letra = String.fromCharCode(event.keyCode) 
   if(puntero >= digitos){ 
       cadena=""; 
       puntero=0; 
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto... 
   if (event.keyCode == 13||event.keyCode == 27)
   { 
       borrar_buffer(); 
       if(event.keyCode != 27&&objfoco!=0) //evita foco a otro objeto si objfoco=0 
		if(Recargar=='S')
			Recarga(objfoco);	   
		else
		   objfoco.focus(); 
    } 
   //sino busco la cadena tipeada dentro del combo... 
   else{ 
       buffer[puntero]=letra; 
       //guardo en la posicion puntero la letra tipeada 
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array 
       puntero++; 

       //barro todas las opciones que contiene el combo y las comparo la cadena... 
       for (var opcombo=0;opcombo < obj.length;opcombo++){ 
          if(obj[opcombo].text.substr(InicioBusq,puntero).toLowerCase()==cadena.toLowerCase()){ 
          obj.selectedIndex=opcombo; 
          } 
       } 
    } 
   event.returnValue = false; //invalida la acción de pulsado de tecla para evitar busqueda del primer caracter 

}
function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}
</script>
<title>AGE-Padrones Mineros</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmPadronMinero" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top">
	  <table width="750" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
            <td bgcolor="#FFFFFF">Ordenar Por </td>
            <td align="left">
			<?php
			switch (isset($ChkOrden))
			{
				case "R":
					echo '<input checked name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
					echo '<input name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
					break;
				case "N":
					echo '<input name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
					echo '<input checked name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
					break;
			}
			?>&nbsp;&nbsp;&nbsp;&nbsp;---> Filtro Prv&nbsp;<input type="text" name="TxtFiltroPrv" size="10"> 
			</td>
            <td align="center"><input name="BtnOkA2" type="button" value="Ok" onClick="Recarga('3')"></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td width="104" bgcolor="#FFFFFF">Buscar Por Prov</td>
            <td width="284" align="left">
			    <select name="CmbProveedor" style="width:280" onkeypress=buscar_op(this,BtnOkA,0,'N') onBlur="borrar_buffer()" onclick="borrar_buffer()">
                <option value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select * from sipa_web.proveedores ";
				if($TipoBusq=='3'&&$TxtFiltroPrv!='')
				   $Consulta.= " where nombre_prv like '%".$TxtFiltroPrv."%'";       
				switch (isset($ChkOrden))
				{
					case "R":
						$Consulta.= "order by lpad(rut_prv,10,'0')";
						break;
					case "N":
						$Consulta.= "order by trim(nombre_prv)";
						break;
				
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
				}
			    ?>
              </select></td>
            <td width="28" align="center"><input name="BtnOkA" type="button" value="Ok" onClick="Recarga('1')"></td>
            <td width="299" align="center">
              <input type="hidden" name="BtnMina" value="Minas" style="width:70" onClick="MostrarPopupProceso('MIN');" >
			  <input type="button" name="BtnPrv" value="Proveedor" style="width:70" onClick="MostrarPopupProceso('PRV');">
              <input type="hidden" name="BtnPropiet" value="Propietario" style="width:70" onClick="MostrarPopupProceso('PRO');">
              <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="MostrarPopupProceso('CON');">
			</td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF">Buscar Mina</td>
            <td><select name="CmbMina" style="width:280" onkeypress=buscar_op(this,BtnOkB,15,'N') onBlur="borrar_buffer()" onclick="borrar_buffer()">
                <option value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select distinct cod_mina,nombre_mina from sipa_web.minaprv ";
				switch (isset($ChkOrden))
				{
					case "R":
						$Consulta.= "order by trim(cod_mina)";
						break;
					case "N":
						$Consulta.= "order by trim(nombre_mina)";
						break;
				
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbMina == $Fila["cod_mina"])
						echo "<option selected value='".$Fila["cod_mina"]."'>".str_pad($Fila["cod_mina"],12,"0",STR_PAD_LEFT)." - ".$Fila["nombre_mina"]."</option>";
					else
						echo "<option value='".$Fila["cod_mina"]."'>".str_pad($Fila["cod_mina"],12,"0",STR_PAD_LEFT)." - ".$Fila["nombre_mina"]."</option>";
				}
			    ?>
              </select> </td>
            <td align="center"><input name="BtnOkB" type="button" value="Ok" onClick="Recarga('2')"></td>
            <td align="center">  
              <input type="button" name="BtnNuevo" value="Nuevo" style="width:70" onClick="MostrarPopupProceso('N');">
			  <input type="button" name="BtnModificar" value="Modificar" style="width:70" onClick="MostrarPopupProceso('M');">
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:70" onClick="MostrarPopupProceso('E');">
			  <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();"></td>
          </tr>
        </table>
        <br> 
        <table width="750" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr class="ColorTabla01">
		  <td align="center" width="8">&nbsp;</td>
		  <td align="center" width="60">Cod.Mina</td>
		  <td align="center" width="150">Mina/Planta</td>
		  <td align="center" width="150">Proveedor</td>	
		  <td align="center"  width="70">Sierra</td>
		  <td align="center"  width="70">Comuna</td>
		  <td align="center"  width="70">Venc.Padron</td>
		  </tr>
		  <?php
			if ($Mostrar=='S')	
			{
				$Consulta="select * from sipa_web.minaprv t1 inner join sipa_web.proveedores t2 on t1.rut_prv=t2.rut_prv ";
				//$Consulta.="left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='15002' and t1.tipo_recepcion=t4.cod_subclase";
				switch($TipoBusq)
				{
					case "1"://POR PROVEEDOR
						$Consulta.= " where t1.rut_prv='".$CmbProveedor."'";
						break;
					case "2"://POR FAENA
						$Consulta.= " where t1.cod_mina='".$CmbMina."'";
						break;
				}
				//echo $Consulta;
				$Resp = mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='CheckCod'>";
				while ($Fila = mysqli_fetch_array($Resp))
				{
					echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
					echo "<td align='center'><input type='checkbox' name='CheckCod' value='".$Fila["rut_prv"]."~".$Fila["cod_mina"]."'>";
					echo "<td align='center'>".$Fila["cod_mina"]."</td>\n";
					echo "<td align='right'>".$Fila["nombre_mina"]."</td>\n";
					echo "<td align='center'>".$Fila["rut_prv"]." - ".$Fila["nombre_prv"]."</td>\n";
					echo "<td align='left'>".$Fila["sierra"]."&nbsp;</td>\n";
					echo "<td align='left'>".$Fila["comuna"]."</td>\n";
					echo "<td align='right'>".$Fila["fecha_padron"]."&nbsp;</td>\n";
					echo "</tr>\n";
				}
			}
		  ?>
        </table>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
?>
