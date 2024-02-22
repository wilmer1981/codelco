<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Buscar"])){
		$Buscar=$_REQUEST["Buscar"];
	}else{
		$Buscar="";
	}
	if(isset($_REQUEST["CmbSubProducto"])){
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = "";
	}
	if(isset($_REQUEST["TxtDescripcion"])){
		$TxtDescripcion = $_REQUEST["TxtDescripcion"];
	}else{
		$TxtDescripcion = "";
	}
	if(isset($_REQUEST["TxtConjunto"])){
		$TxtConjunto = $_REQUEST["TxtConjunto"];
	}else{
		$TxtConjunto = "";
	}
	
	if(isset($_REQUEST["Valor"])){
		$Valor = $_REQUEST["Valor"];
	}else{
		$Valor = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	
	$NombreBoton='Grabar';
	$Habilitar='';	
	$EstConj='';
	switch($Proceso)
	{
		case "N":
			$Consulta="SELECT ifnull(max(cod_grupo)+1,1) as grupo_nuevo from sipa_web.grupos_conjunto";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodGrupo=$Fila["grupo_nuevo"];
			break;
		case "M":
			$EstConj='readonly';
			$NombreBoton='Modificar';
			$Habilitar='disabled';		
			$Datos2=explode('~~',$Valor);
			$TxtCodGrupo=$Datos2[0];
			$Consulta="SELECT distinct t2.cod_subproducto,t1.cod_grupo,t1.descripcion,t1.conjunto,t1.estado from sipa_web.grupos_conjunto t1 inner join  ";
			$Consulta.="sipa_web.grupos_prod_prv t2 on t1.cod_grupo=t2.cod_grupo where t1.cod_grupo='$TxtCodGrupo'";
			//echo $Consulta;
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtDescripcion=$Fila["descripcion"];
			$TxtConjunto=$Fila["conjunto"];
			$CmbSubProducto=$Fila["cod_subproducto"];
			switch($Fila["estado"])
			{
				case "A":
					$EstCheck1='checked';
					$EstCheck2='';
					break;
				case "C":
					$EstCheck1='';
					$EstCheck2='checked';
					break;
			}
			
			break;
	}
	if(!isset($EstCheck1))
	{	
		$EstCheck1='checked';
		$EstCheck2='';
	}	
?>
<html>
<head>
<title>Proceso</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Datos="";
	
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			//if(ValidarCampos())
			//{
			Datos=RecuperarValoresCheckeado();
			if(Datos!='')
			{
				//f.action='rec_grupos_conjunto_proceso01.php?Proceso=N&Valor='+Datos;
				f.action='rec_grupos_conjunto_proceso01.php?Proceso=N';
				f.submit();
			}	
			else
				alert('Debe Seleccionar Proveedores');
			break;
		case 'M'://MODIFICAR
			Datos=RecuperarValoresCheckeado();
			if(Datos!='')
			{
				//f.action='rec_grupos_conjunto_proceso01.php?Proceso=M&Valor='+Datos+'&CmbSubProducto='+f.CmbSubProducto.value;
				f.action='rec_grupos_conjunto_proceso01.php?Proceso=M&CmbSubProducto='+f.CmbSubProducto.value;
				f.submit();
			}
			else
				alert('Debe Seleccionar Proveedores');
			break;
		case 'S'://SALIR
			window.close();
			break;
	}
	
}
function ValidarCampos()
{
	var f = document.frmPrincipal;
	var Validado=true;
	var Valores="";
	
	if(f.TxtDescripcion.value=='')
	{
		alert('Debe Ingresar Descripcion');
		f.TxtDescripcion.focus();
		Validado=false;
		return;
	}
	if(f.TxtConjunto.value=='')
	{
		alert('Debe Ingresar Conjunto');
		f.TxtConjunto.focus();
		Validado=false;
		return;
	}
	Valores=RecuperarValoresCheckeado();
	if(Valores=='')
	{					
		alert('Debe Seleccionar Proveedor(s)');
		Validado=false;
		return;
	}	
}
function Recarga()
{
	var f = document.frmPrincipal;

	f.action='rec_grupos_conjunto_proceso.php?Buscar=S';
	f.submit();		
}
function RecuperarValoresCheckeado()
{
	var f = document.frmPrincipal;
	var Valores="";
	
	for (i=1;i<f.CheckPrv.length;i++)
	{
		if (f.CheckPrv[i].checked==true)
			Valores=Valores + f.CheckPrv[i].value+"//";
	}
	Valores=Valores.substr(0,Valores.length-2);
	f.Valor.value=Valores;
	//return(Valores);
}
function CheckearTodo()
{
	var f = document.frmPrincipal;
	try
	{
		f.CheckPrv[0];
		for (i=1;i<f.CheckPrv.length;i++)
		{
			if(f.CheckTodos.checked==true&&f.CheckPrv[i].disabled==false)
				f.CheckPrv[i].checked=true;
			else
				f.CheckPrv[i].checked=false;
		}
	}
	catch (e)
	{
	}
}
function AgregarPlanta(Grupo,SubProd,Prv)
{
	window.open("rec_grupos_conjunto_planta.php?Grupo="+Grupo+"&SubProd="+SubProd+"&Prv="+Prv,"","top=30,left=100,width=650,height=200,scrollbars=yes,resizable=yes");	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="Valores" value="<?php echo $Valores;?>">
<input type="hidden" name="Valor" value="<?php echo $Valor;?>">
	    <table width="461" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Cod.Grupo:</td>
			<td width="375"><div align="left">
			  <input type="text" name="TxtCodGrupo" size="10" value='<?php echo $TxtCodGrupo;?>' readonly="true" >
			</div></td> 
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td height="28" align="right">Descripcion:</td>
			<td><div align="left">
			  <input type="text" name="TxtDescripcion" size="40" value='<?php echo $TxtDescripcion;?>' onKeyDown="TeclaPulsada2('N',true,this.form,'TxtConjunto');">
			</div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Conjunto:</td>
            <td><div align="left">
              <input type="text" name="TxtConjunto" size="15" value='<?php echo $TxtConjunto;?>' onKeyDown="TeclaPulsada2('S',true,this.form,'CmbSubProducto');" maxlength="6" >
            </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">SubProducto:</td>
            <td align="left"><SELECT name="CmbSubProducto" onChange="Recarga()" style="width:300" <?php echo $Habilitar;?>>
              <option class="NoSelec" value="S">Seleccionar</option>
              <?php
				$Consulta = "SELECT cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
            </SELECT>
			</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td>Estado:</td>
            <td align="left">Abierto
              <input name="CheckEst" type="radio" value="A" <?php echo $EstCheck1;?>>
            Cerrado
            <input name="CheckEst" type="radio" value="C" <?php echo $EstCheck2;?>></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="2"><input name="BtnNuevo" type="button" style="width:70px;" value="<?php echo $NombreBoton;?>" onClick="Procesos('<?php echo $Proceso;?>')">
              <input name="BtnSalir" type="button" style="width:70px;" value="Salir" onClick="Procesos('S')"></td>
          </tr>
		 </table><br>
		 <table width="690" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
		 <tr class="ColorTabla01">
		 <td width="74" align="center"><input type="checkbox" name="CheckTodos" onClick="CheckearTodo()" value="checkbox"></td>
		 <td width="80" align="center" >Rut</td>
		 <td width="250" align="center" >Nombre Proveedor</td>
		 <td width="250" align="center" >Mina/Planta</td>
		 </tr>
		 <?php
		 	$Consulta="SELECT  distinct t1.rut_proveedor,t2.nombre_prv,t3.rut_prv,t5.cod_mina,t5.nombre_mina,t3.cod_grupo from age_web.relaciones t1 inner join sipa_web.proveedores t2 on t1.rut_proveedor =t2.rut_prv ";
			$Consulta.="left join sipa_web.grupos_prod_prv t3 on t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_prv and t3.cod_grupo='$TxtCodGrupo' ";
			//$Consulta.="left join sipa_web.prodprv_conjuntados t4 on t4.cod_producto='1' and t1.cod_subproducto=t4.cod_subproducto and t1.rut_proveedor=t4.rut_prv ";
			$Consulta.="left join sipa_web.minaprv t5 on t1.rut_proveedor=t5.rut_prv ";
			$Consulta.="where t1.cod_producto='1' and t1.cod_subproducto='$CmbSubProducto' order by t2.nombre_prv";
			//echo $Consulta;
			$RespPrv=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckPrv'>";
			while($FilaPrv=mysqli_fetch_array($RespPrv))
			{
				echo "<tr bgcolor='#FFFFFF'>";
				$Consulta="SELECT * from sipa_web.prodprv_conjuntados where cod_producto='1' and cod_subproducto='$CmbSubProducto' ";
				$Consulta.=" and rut_prv='".$FilaPrv["rut_proveedor"]."' and cod_mina='".$FilaPrv["cod_mina"]."'";
				//echo $Consulta."<br>";
				$RespConj=mysqli_query($link, $Consulta);
				$Asignado='N';
				if($FilaConj=mysqli_fetch_array($RespConj))
				{	
					$Asignado='S';
					$GrupoAsig=$FilaConj["cod_grupo"];
				}	
				//echo $Asignado."<br>";	
				if($FilaPrv["rut_prv"]==$FilaPrv["rut_proveedor"]&&$Asignado=='S'&&$FilaPrv["cod_grupo"]==$GrupoAsig)
					echo "<td align='center'><input type='checkbox' name='CheckPrv' value='".$FilaPrv["rut_proveedor"]."~".$FilaPrv["cod_mina"]."' checked></td>";
				else
					if($Asignado=='N')
						echo "<td align='center'><input type='checkbox' name='CheckPrv' value='".$FilaPrv["rut_proveedor"]."~".$FilaPrv["cod_mina"]."'></td>";
					else
						echo "<td align='center'><input type='checkbox' name='CheckPrv' value='".$FilaPrv["rut_proveedor"]."~".$FilaPrv["cod_mina"]."' disabled></td>";
				echo "<td align='right'>".str_pad($FilaPrv["rut_proveedor"],10,0,STR_PAD_LEFT)."&nbsp;</td>";
				echo "<td align='left'>".$FilaPrv["nombre_prv"]."</td>";
				echo "<td align='left'>".$FilaPrv["cod_mina"]." - ".$FilaPrv["nombre_mina"]."</td>";
				echo "</tr>";
			}
		 ?>
		 </table>
		 
		 
	    <br>
	    <br></td>
 </tr>
</table>
</form>
</body>
</html>
