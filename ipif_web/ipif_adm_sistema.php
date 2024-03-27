<?  session_start();  
	include("../principal/conectar_ipif_web.php");
	include("funciones/ipif_funciones.php");
	$FechaSist=date("d/m/Y");
	$Fecha_Sistema= date("Y-m-d");
	$Hora=date("G:i:s");
	if(!isset($CmbDivision))
	{
		$CmbDivision='FV01';
	}
	if($Op=='G')
	{
		$Insertar="Insert into ipif_ceco_asociacion(cod_cc,cod_tipo)values('".$CmbCC."','".$CmbTipoCeco."')";
		mysql_query($Insertar);
	}
	$CODIGOCLASE=CODIGOCLASE();
	if($Op=='GP')
	{
	
		$Valor = explode("//",$F);
		while (list($clave,$Codigo)=each($Valor))
		{
			InsertarFuncionario($Codigo,$Codigo.'@CODELCO.CL');
			$Insertar="Insert into ipif_ceco_solicitante(cod_ceco,cuenta_solicitante,cod_tipo)values('".$TxtCeco."','".$Codigo."','".$TxtTipo."')";
			mysql_query($Insertar);
		}
	
	}
	if($Op=='GTF')
	{
		$Valor = explode("|",$Valores);
		while (list($clave,$Codigo)=each($Valor))
		{
			if($Codigo!='')
			{
				$Datos=explode("~",$Codigo);
				InsertarFuncionario($Datos[0],$Datos[1]);	
				$Actualizar="UPDATE ipif_ceco_solicitante set cod_perfil='".$Datos[2]."' ";
				$Actualizar.="where cod_ceco='".$TxtCeco."' and cuenta_solicitante='".$Datos[0]."' and cod_tipo='".$TxtTipo."'";
				mysql_query($Actualizar);
			}	
		}
		$Valores='';
	}
	if($Op=='FE')
	{
	//	echo "valores_____".$Valores."<br>";
		$Valor = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Valor))
		{
			if($Codigo!='')
			{
				$Consulta = "select * from ipif_novedades_correos where  cod_cc='".$TxtCeco."' and cuenta='".$Codigo."'";
				$Resp=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if (!$FilaD=mysql_fetch_array($Resp))
				{
					$Eliminar="delete from ipif_ceco_solicitante where cod_ceco='".$TxtCeco."' and cuenta_solicitante='".$Codigo."' and cod_tipo='".$TxtTipo."' ";
					mysql_query($Eliminar);
				//	echo $Eliminar;
				}
			}	
		}
		$Valores='';
	}
	if($Op=='EC')
	{
				$Consulta = "select * from ipif_novedades_correos where  cod_cc='".$Cc."' and tipo='A'";
				$Resp=mysqli_query($link, $Consulta);
				if (!$FilaD=mysql_fetch_array($Resp))
				{
					$Eliminar="delete from ipif_ceco_asociacion where cod_cc='".$Cc."' and cod_tipo='".$Ti."' ";
					mysql_query($Eliminar);
					$Eliminar="delete from ipif_ceco_solicitante where cod_ceco='".$Cc."' and cod_tipo='".$Ti."' ";
					mysql_query($Eliminar);
				}
				else
					$MsjVal='S';
	}

?>
<title>
Administracion Sistema
</title>
<link href="estilos/ipif_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/ipif_funciones.js"></script>
<script language="javascript">
function ValidaIngreso()
{
	var Result=true;
	var f=document.FrmCeco;		
	
	if(f.CmbCC.value=='S')
	{
		alert("Debe seleccionar Centro Costo ");
		f.CmbCC.focus();
		Result=false;
		return ;
	}
		if(f.CmbTipoCeco.value=='S')
	{
		alert("Debe seleccionar Tipo ");
		f.CmbTipoCeco.focus();
		Result=false;
		return ;
	}
	return(Result);

}
function Muestra(Cc,t)
{
	var f=document.FrmCeco;
	f.TxtCeco.value=Cc;
	f.TxtTipo.value=t;
	
	f.action='ipif_adm_sistema.php';
	f.submit();
}
function EliminaArea(Cc,t)
{
	var f=document.FrmCeco;
	f.action="ipif_adm_sistema.php?Op=EC&Cc="+Cc+"&Ti="+t;
	f.submit();
}
function Proceso(Opt)
{
	var f=document.FrmCeco;
	switch (Opt)
	{
		case "GF":
			var Datos='';
			for(var i=1;i<f.CheckCC.length;i++)
			{
				Datos=Datos+f.CheckCC[i].value+"~"+f.TxtCorreo[i].value+"~"+f.CmbPerfil[i].value+"|";
			}
			f.Valores.value=Datos;
			f.action='ipif_adm_sistema.php?Op=GTF';
			f.submit();
			
		break;
		case "AG":
		
			URL='ipif_asociar_solicitante.php';
			opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=500,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "AGRE":
			if(ValidaIngreso())
			{
				f.action='ipif_adm_sistema.php?Op=G';
				f.submit();
			}
		break;
		case "S":
			window.close();
		break;
		case "R1":
			var f=document.FrmCeco;
			f.action='ipif_adm_sistema.php';
			f.submit();
		break;
		case "EF":
			if(SoloUnElemento(f.name,'CheckCC','E'))
			{
				Datos=Recuperar(f.name,'CheckCC');
				if(Datos!='')
				{
					f.Valores.value=Datos;
					f.action='ipif_adm_sistema.php?Op=FE';
					f.submit();
				}
			}
		break;
		case "EC":
			if(SoloUnElemento(f.name,'CheckC','E'))
			{
				Datos=Recuperar(f.name,'CheckC');
				if(Datos!='')
				{
					f.Valores.value=Datos;
					f.action='ipif_adm_sistema.php?Op=EC';
					f.submit();
				}
			}
		break;
	}
}

</script>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=180 scrolling=no height=180></IFRAME></DIV>
<form name="FrmCeco" action="" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" value="<? echo $TxtCeco;?>" name="TxtCeco"> 
<input type="hidden" value="<? echo $TxtTipo;?>" name="TxtTipo"> 
<input type="hidden" value="<? echo $Valores;?>" name="Valores"> 
				<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'adm_areas.png',$CookieRut)
 ?>
 <table width="945" align="center"  border="0" cellpadding="0"  cellspacing="0"  class="TablaPricipalColor" >
  <tr>
	<td height="15"><img src="archivos/images/interior/esq01.png" width="15" height="15"></td>
	<td width="933" height="15"background="archivos/images/interior/form_arriba0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq02.png" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq0.png">&nbsp;</td>
   	<td><table width="915" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
    
     <tr>
       <td width="72" align="center" >&nbsp;</td>
       <td width="142" align="left" >&nbsp;</td>
       <td width="41" align="left" >&nbsp;</td>
       <td width="412" align="left" >&nbsp;</td>
       <td width="238" align="right" >
	
	   <a href="JavaScript:Proceso('S')"><img src="archivos/close.png"  alt="Cerrar " border="0" align="absmiddle" /></a></td>
     </tr>
          <tr>
       <td height="16" colspan="6" class="TituloCabecera">ADMINISTRACI�N DE AREAS</td>
     </tr>
      </table>
	 <table width="910" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
      
		
		  
		  <tr  class="TituloCabeceraChica">
		    <td  width="40%" valign="top">
			  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >
   
    <tr>
      <td  class="formulario" >CeCo </td>
      
      <td width="83%" ><select name="CmbCC" style="width:200px "  id="CmbCC" >
        <option selected value="S"  class="NoSelec">Seleccionar</option>
        <?	
			$Consulta = "select * from proyecto_modernizacion.centro_costo order by CENTRO_COSTO ";
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaD=mysql_fetch_array($Resp))
			{
				if ($CmbCC==$FilaD["CENTRO_COSTO"])
					echo "<option selected value='".$FilaD["CENTRO_COSTO"]."'>[".$FilaD["CENTRO_COSTO"]."]&nbsp;".ucwords(strtolower($FilaD["DESCRIPCION"]))."</option>\n";
				else
					echo "<option value='".$FilaD["CENTRO_COSTO"]."'>[".$FilaD["CENTRO_COSTO"]."]&nbsp;".ucwords(strtolower($FilaD["DESCRIPCION"]))."</option>\n";
			}
			?>
      </select></td>
    </tr>
    <tr>
      <td  class="formulario" >Tipo</td>
      <td  colspan="2" ><select name="CmbTipoCeco"  id="CmbTipoCeco" >
          <option selected value="S"  class="NoSelec">Seleccionar</option>
      <?	
			$Consulta = "select * from ipif_tipo_ceco ";
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaD=mysql_fetch_array($Resp))
			{
				if ($CmbTipoCeco==$FilaD["cod_tipo"])
					echo "<option selected value='".$FilaD["cod_tipo"]."'>".ucwords(strtolower($FilaD["descripcion"]))."</option>\n";
				else
					echo "<option value='".$FilaD["cod_tipo"]."'>".ucfirst(strtolower($FilaD["descripcion"]))."</option>\n";
			}
			?>
      </select>&nbsp;&nbsp;&nbsp;&nbsp;<a href="JavaScript:Proceso('AGRE')"><img src="archivos/btn_agregar.png"  alt="Agregar " border="0" align="absmiddle" /></a>
	 <!-- <a href="JavaScript:Proceso('EC')"><img src="archivos/eliminar.png" alt="Elimina" border="0" align="absmiddle" /></a></td>-->
    </tr>
</table>
		<BR>	
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<input type="hidden" name="CheckC">
<tr class="TituloTablaNaranja">
<td width="60">&nbsp;</td>
<td width="43" align="center">Ceco</td>
<td width="316" align="center">Descripci�n</td>
<td width="20" align="center">&nbsp;</td>
</tr>
<? 
	$Consulta = "select t1.*,t2.DESCRIPCION,t4.imagen,t4.descripcion as des from ipif_ceco_asociacion t1 inner join ";
	$Consulta.= " proyecto_modernizacion.centro_costo  t2 on t1.cod_cc=t2.CENTRO_COSTO ";
	$Consulta.=" inner join ipif_tipo_ceco t4 on t1.cod_tipo=t4.cod_tipo ";
	$Resp=mysqli_query($link, $Consulta);

	while ($FilaD=mysql_fetch_array($Resp))
	{?>
		<tr>
		<td width="60">   <input type="checkbox" name="CheckC" value="<? echo $FilaD[cod_cc];?>" class="SinBorde">
		 <a href="JavaScript:EliminaArea('<? echo $FilaD[cod_cc]; ?>','<? echo $FilaD[cod_tipo];?>')"><img src="archivos/elim2.png" alt="Eliminar" border="0" align="absmiddle" /></a>
		</td>
		<td><? echo $FilaD[cod_cc];?>&nbsp;</td>
		<td><a href="JavaScript:Muestra('<? echo $FilaD[cod_cc];?>','<? echo $FilaD[cod_tipo];?>')"><span class="SinLinea"><? echo ucwords($FilaD["descripcion"]);?></span></a>&nbsp;</td>
		<td align="center"><img src="<? echo $FilaD[imagen];?>" alt="<? echo $FilaD[des];?>" border="0" align="absmiddle" /></td>
</tr>
	
	
	
	<?
	}

?>
</table>			</td>
		
		    <td colspan="3" class="formulario" valign="top" >
		
	 <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
        <tr >
		    <td  width="77%" class="titulo_cafe_bold" valign="top">
			<? 
				$Consulta = "select t1.*,t2.DESCRIPCION,t3.descripcion as DESP from ipif_ceco_asociacion t1 inner join  proyecto_modernizacion.centro_costo t2 on t1.cod_cc=t2.centro_costo   ";
				$Consulta.= " left join ipif_tipo_ceco t3 on t1.cod_tipo=t3.cod_tipo where t1.cod_cc='".$TxtCeco."' and t1.cod_tipo='".$TxtTipo."'";
			$Resp=mysqli_query($link, $Consulta);
			if ($FilaD=mysql_fetch_array($Resp))
			{	
				echo $FilaD[cod_cc]."&nbsp;&nbsp;-&nbsp;&nbsp;".$FilaD["descripcion"]."&nbsp;&nbsp;-&nbsp;&nbsp;".$FilaD[DESP];
				$TIPO=$FilaD[cod_tipo];
			}
			?>			</td>
		    <td  width="23%" class="titulo_azul" align="right" valign="top">
						
						  <a href="JavaScript:Proceso('GF')"><img src="archivos/btn_guardar.png"  alt="Guardar Registros" border="0" align="absmiddle" /></a>  <a href="JavaScript:Proceso('AG')"><img src="archivos/btn_visualizador.png"  alt="Asociar Funcionario" border="0" align="absmiddle" /></a>	
			   <a href="JavaScript:Proceso('EF')"><img src="archivos/eliminar.png" alt="Eliminar" border="0" align="absmiddle" /></a>			</td>
        </tr>
		  
		  <tr  class="TituloCabeceraChica">
		    <td colspan="2" valign="top">
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	
<tr class="TituloTablaNaranja">
<td width="1" >&nbsp;</td>
<td align="center" >Nombre</td>
<td align="center">Correo</td>
<td align="center">Perfil</td>
</tr><input type="hidden" name="TxtCorreo">
<input type="hidden" name="CmbPerfil">
<input type="hidden" name="CheckCC">

<? 
	$Consulta = "select t1.* from ipif_ceco_solicitante t1 where t1.cod_ceco='".$TxtCeco."' and cod_tipo='".$TxtTipo."' ";
	$Resp=mysqli_query($link, $Consulta);
	while ($FilaD=mysql_fetch_array($Resp))
	{
		
		$CmbPerfil=$FilaD[cod_perfil];
		$DatosF=Funcionario($FilaD[cuenta_solicitante]);
		$MDatosF=explode('~',$DatosF);
		
		
	?>
	<tr>
	<td >   <input type="checkbox" name="CheckCC" value="<? echo $FilaD[cuenta_solicitante];?>" class="SinBorde"></td>
		  
<td ><? echo $MDatosF[0];?>&nbsp;</td>
<td> <input type="Text" size="30" maxlength="60" name="TxtCorreo" value="<? echo $MDatosF[1];?>" ></td>
<td><select name="select" id="CmbPerfil" >
  <option value="-1" class="InputRojo">Seleccionar</option>
  <?
				$Consulta = "select t1.descripcion as DESCRIP,t2.* from ipif_tipo_ceco t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_tipo=t2.valor_subclase1 where t2.cod_clase='".$CODIGOCLASE."' and t1.cod_tipo='".$TxtTipo."'  ";			
				
				$Respp=mysqli_query($link, $Consulta);
				while ($FilaCrit=mysql_fetch_array($Respp))
				{
					if ($CmbPerfil==$FilaCrit["cod_subclase"])
						echo "<option selected value='".$FilaCrit["cod_subclase"]."'>".ucfirst($FilaCrit["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaCrit["cod_subclase"]."'>".ucfirst($FilaCrit["nombre_subclase"])."</option>\n";
				}
				?>
</select>
<? // echo $Consulta;?>

</td>
</tr>
	
	
	
	<?
	}

?>
</table>			</td>
		  </tr>
     </table>
 
			
			
			
			
			
			
			
			
			
			
			
			
			
						</td>
	      </tr>
		
     </table></td>
   <td  width="15" background="archivos/images/interior/form_der0.png">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq03.png" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq04.png" width="15" height="15" /></td>
  </tr>
  </table>
 
  <?
  CierreEncabezado()
  ?>
<?  
if($MsjVal=='S')
{
	?>
	<script language="javascript">
	alert('Algunas �reas seleccionadas no pueden eliminarse,debido a que tienen Novedades Asociadas');
	</script>
	<?
}
?>
  
  
</form>
<body>