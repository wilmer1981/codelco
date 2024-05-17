<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
 	$Ano=date('Y');

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		$Cod=explode('~',$Codigos);
		$Consulta="select t5.ult_version,t1.version,t5.ano as ano_version,t5.mes as mes_version,t5.fecha_creacion as fecha_version,t1.cod_asignacion,t1.cod_procedencia,t1.cod_negocio,t1.cod_titulo,t1.tipo as origen,t2.nom_asignacion as nom_asignacion,t3.nom_asignacion as prod,t4.nom_negocio,t6.nom_titulo,t1.ano ";
		$Consulta.="from pcip_ppc_detalle t1 ";
		$Consulta.="inner join pcip_svp_asignaciones_productos t2 on t1.cod_procedencia=t2.cod_producto inner join pcip_svp_asignacion t3 on t1.cod_asignacion=t3.cod_asignacion ";
		$Consulta.="left join pcip_svp_negocios t4 on t1.cod_negocio=t4.cod_negocio ";
		$Consulta.="inner join pcip_ppc_version t5 on t5.version=t1.version ";
		$Consulta.="left join pcip_svp_asignaciones_titulos t6 on t6.cod_titulo=t1.cod_titulo ";
		$Consulta.="where t1.version='".$Cod[0]."' and t1.ano='".$Cod[1]."' and t1.cod_asignacion='".$Cod[2]."' and t1.cod_procedencia='".$Cod[3]."' and t1.tipo='".$Cod[5]."' and t1.cod_negocio='".$Cod[4]."' and t1.cod_titulo='".$Cod[6]."'";
		$Consulta.="group by t1.version,t1.cod_asignacion,t1.cod_procedencia,t1.cod_negocio,t1.ano,t1.tipo,t1.cod_titulo";	
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysql_fetch_array($Resp);
		$Cod=$CmbVersion."~".$Ano."~".$CmbProd."~".$CmbAsig."~".$CmbOrigen."~".$CmbNegocio."~".$CmbTitulo;
		$CmbVersion=$Fila[version];
		$CmbProd=$Fila[cod_asignacion];
		$CmbAsig=$Fila[cod_procedencia];
		$CmbOrigen=$Fila[origen];
		$CmbNegocio=$Fila[cod_negocio];
		$CmbTitulo=$Fila[cod_titulo];
		$Ano=$Fila[ano];
	
		$NomVersion='N�: '.$Fila[version]."&nbsp;&nbsp;&nbsp;&nbsp;A�o: ".$Fila[ano_version]."&nbsp;&nbsp;&nbsp;&nbsp;Mes: ".$Meses[$Fila[mes_version]-1]."&nbsp;&nbsp;&nbsp;&nbsp;Fecha Creacion: ".$Fila[fecha_version];
		$NomProd=$Fila[prod];
		$Unidad=$Fila["cod_unidad"];
		//echo $Unidad."<br>";
		$NomAsig=$Fila[nom_asignacion];
		if($Fila[origen]=='S')
			$NomOrigen='CON ORIGEN';
		else
			$NomOrigen='SIN ORIGEN';
		$NomNegocio=$Fila[nom_negocio];
		$NomTitulo=$Fila[nom_titulo];
		$NomA�o=$Fila[num_orden];
		$UltVersion=$Fila[ult_version];
	}
	else
	{
		$TxtOrdenRel='';
		$TxtMaterial='';
		$TxtConsumo='';
	}
}	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nueva Ingreso PPC</title>";
	else	
		echo "<title>Modifica Ingreso PPC</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Adm="";
	var Check="";
	var i="";
	var Valores="";
	
	switch(Opcion)
	{	
		case "N":
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				for (i=0;i<f.TxtValorMes.length;i++)
				{
					Valores=Valores+f.TxtValorMes[i].value+"~~";
				}
				Valores=Valores.substr(0,Valores.length-2);
				f.action = "pcip_mantenedor_ppc_proceso01.php?Opcion="+Opcion+"&Valores="+Valores;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			for (i=0;i<f.TxtValorMes.length;i++)
			{
				Valores=Valores+f.TxtValorMes[i].value+"~~";
			}
			Valores=Valores.substr(0,Valores.length-2);
			f.action = "pcip_mantenedor_ppc_proceso01.php?Opcion="+Opcion+"&Valores="+Valores;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_ppc_proceso.php?Opcion=N";
			f.submit();
		break;

		case "R":	
			f.action = "pcip_mantenedor_ppc_proceso.php?Recarga=S";
			f.submit();
		break;
	}
}
function Salir()
{
	window.close();
}
/*function TeclaPulsada(tecla) 
{ 
	var Frm=document.FrmPopupProceso;
	var teclaCodigo = event.keyCode; 

		if(teclaCodigo != 189)
		{
			if ((teclaCodigo != 37)&&(teclaCodigo != 39))
			{
				if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
				{
				   if ((teclaCodigo < 96) || (teclaCodigo > 105))
				   {
						event.keyCode=46;
				   }		
				}   
			}
		}		
} */
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;

	if(f.CmbProd.value=='-1')
	{
		alert("Debe seleccionar Asignaci�n");
		f.CmbProd.focus();
		Res=false;
		return;
	}
	if(f.CmbAsig.value=='-1')
	{
		alert("Debe seleccionar Producto");
		f.CmbAsig.focus();
		Res=false;
		return;
	}
	if(f.CmbNegocio.value=='-1')
	{
		alert("Debe seleccionar Negocio");
		f.CmbNegocio.focus();
		Res=false;
		return;
	}
	if(f.CmbTitulo.value=='-1')
	{
		alert("Debe seleccionar Titulo");
		f.CmbTitulo.focus();
		Res=false;
		return;
	}

	return(Res);

}
</script>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #F9F9F9;
}
-->
</style></head>

<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
  <input type="hidden" name="Opcion" value="<? echo $Opcion;?>">
 <input name="Form" type="hidden" value="<? echo $Form; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">
<input name="Codigos" type="hidden" value="<? echo $Codigos; ?>">

  <table align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="955" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_ppc_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_ppc_m.png" width="450" height="40"><? }?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opcion;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
          <tr>
           <td height="25" class="formulario2">A&ntilde;o</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
			<select name="Ano" onChange="Proceso('R')">
			  <?
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
			?>
			</select>
			<span class="InputRojo">(*)</span>		   </span>		   
			<?
		    }
		   	else
				echo "<span class='formulario2'>".$Ano."</span>";	
		   ?>		   </td>
         </tr>

         <tr>
           <td width="180" class="formulario2">Version</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <select name="CmbVersion">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_ppc_version where ano='".$Ano."' order by version ";			
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($Fila["ult_version"]=='S')
					$Color="#339900";
				else
					$Color="";
	
				if ($CmbVersion==$Fila["version"])
					echo "<option style='background:".$Color."' selected value='".$Fila["version"]."'>Version:".$Fila["version"]." A�o:".$Fila["ano"]." Mes:".$Meses[$Fila["mes"]-1]."</option>\n";
				else
					echo "<option style='background:".$Color."' value='".$Fila["version"]."'>Version:".$Fila["version"]." A�o:".$Fila["ano"]." Mes:".$Meses[$Fila["mes"]-1]."</option>\n";
			}
			?>
           </select>
		   <span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$NomVersion."</span>";	
		   ?>		   &nbsp;&nbsp;Ultima Versi�n
        </span>&nbsp;&nbsp;<? echo $UltVersion; ?></td>
         </tr>
         <tr>
           <td width="180" class="formulario2">Asignacion</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <select name="CmbProd" onChange="Proceso('R')">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_svp_asignacion where mostrar_ppc='1'order by nom_asignacion ";			
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbProd==$Fila["cod_asignacion"])
				{
					echo "<option selected value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
					//$Unidad=$Fila["cod_unidad"];
				}
				else
					echo "<option value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			}
			?>
           </select>
		   <span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$NomProd."</span>";
		   ?>		   </td>
         </tr>
		 
         <tr>
           <td height="33" class="formulario2">Producto</td>
           <td width="387" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbAsig" onChange="Proceso('R')">
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and mostrar_ppc='1' order by nom_asignacion";			
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbAsig==$Fila["cod_producto"])
				{
					echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
					$Unidad=$Fila["cod_unidad"];
				}
				else
					echo "<option value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			}
			?>
           </select>
		   </span>		   
		   <span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   {
		   		echo "<span class='formulario2'>".$NomAsig."</span>";	
				$Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and cod_producto='".$CmbAsig."' order by nom_asignacion ";			
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$Unidad=$Fila["cod_unidad"];
				}	
		   }
		   ?>		   </td>
           <td width="462" colspan="2" class="FilaAbeja2" >&nbsp;</td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Negocio</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbNegocio" onChange="Proceso('R')">
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_svp_negocios ";			
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbNegocio==$Fila["cod_negocio"])
					echo "<option selected value='".$Fila["cod_negocio"]."'>".ucfirst($Fila["nom_negocio"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_negocio"]."'>".ucfirst($Fila["nom_negocio"])."</option>\n";
			}			  
			?>
           </select>
           <span class="InputRojo">(*)</span>		   </span>		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$NomNegocio."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Titulos</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbTitulo" >
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_svp_asignaciones_titulos where cod_asignacion='".$CmbProd."' and cod_negocio='".$CmbNegocio."' and mostrar_ppc='1' order by orden";						
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbTitulo==$Fila["cod_titulo"])
					echo "<option selected value='".$Fila["cod_titulo"]."'>".ucfirst($Fila["nom_titulo"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_titulo"]."'>".ucfirst($Fila["nom_titulo"])."</option>\n";
			}			  
			?>
           </select><? //echo $Consulta."<br>";?>
           <span class="InputRojo">(*)</span>		   </span>		   
		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$NomTitulo."</span>";	
		   ?>		   </td>
         </tr>
	 <tr>
           <td height="25" colspan="4" align="center" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr>
               <td colspan="13" align="center" class="TituloTablaNaranja">Valores a Ingresar [<? echo $Unidad;?>]</td>
             </tr>
             <tr align="center">
               <td width="7%" class="TituloCabecera">Enero</td>
               <td width="7%" class="TituloCabecera">Febrero</td>
               <td width="7%" class="TituloCabecera">Marzo</td>
               <td width="7%" class="TituloCabecera">Abril</td>
               <td width="7%" class="TituloCabecera">Mayo</td>
               <td width="7%" class="TituloCabecera">Junio</td>
               <td width="7%" class="TituloCabecera">Julio</td>
               <td width="7%" class="TituloCabecera">Agosto</td>
               <td width="7%" class="TituloCabecera">Septiembre</td>
               <td width="7%" class="TituloCabecera">Octubre</td>
               <td width="7%" class="TituloCabecera">Noviembre</td>
               <td width="7%" class="TituloCabecera">Diciembre</td>
             </tr>
             <?
				if($Opcion=='M')
				{
					 $Cod=explode('~',$Codigos);
					 for($i=1;$i<=12;$i++)
					 {
						$Consulta="select valor from pcip_ppc_detalle t1 "; 
						$Consulta.="where t1.version='".$Cod[0]."' and t1.ano='".$Cod[1]."' and t1.cod_asignacion='".$Cod[2]."' and t1.cod_procedencia='".$Cod[3]."' and t1.tipo='".$Cod[5]."' and t1.cod_negocio='".$Cod[4]."' and t1.cod_titulo='".$Cod[6]."' and t1.mes='".$i."'";
						//echo $Consulta."<br>";
						$RespMes=mysqli_query($link, $Consulta);
						if($FilaMes=mysql_fetch_array($RespMes))
						{
						?>
  <td align="right"><input type='text' name='TxtValorMes' value='<? echo number_format($FilaMes[valor],2,',','');?>' size='6' onkeydown='TeclaPulsada(true)' maxlength="10"></td>
      <?
						}else{		
						?>
      <td><input type='text' name='TxtValorMes' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength="10"></td>
    <?
						}	
					 }
			   }
			   else
			   {
			   		echo "<tr>";
					for($i=1;$i<=12;$i++)
					{
						echo "<td align='center'><input type='text' name='TxtValorMes' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength='10'></td>";
					}
			   		echo "</tr>";
			   }
			   ?>
           </table></td>
           </tr>		 

         <tr>
           <td height="14" colspan="4" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>		
<? 
echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Sumistro Ingresado Correctamente');";
	echo "</script>";
?>
</body>
</html>
