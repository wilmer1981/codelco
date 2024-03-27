<?
include("../principal/conectar_scop_web.php");
include("funciones/scop_funciones.php");
	if(!isset($Ano))
		$Ano=date('Y');	
	if(!isset($CmbMes))
		$CmbMes=date('m');	

?>
<html>
<head>
<title>Validaci�n Cobertura</title>
<script language="javascript" src="../scop_web/funciones/scop_funciones.js"></script>
<script language="javascript">

var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			if(f.CmbTipoContr.value=='-1')
			{
				alert("Debe Seleccionar Tipo de Contrato");
				f.CmbTipoContr.focus();
				return;				
			}
			if(f.CmbContrato.value=='-1')
			{
				alert("Debe Seleccionar Contrato");
				f.CmbContrato.focus();
				return;				
			}
			f.action="scop_valida_inventario.php?Buscar=S";
			f.submit();
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='scop_mantenedor_contratos_proceso01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "R"://IMPRIMIR
			f.action='scop_valida_inventario.php'; //Datos; //+"&Pagina="+f.Pagina.value;
			f.submit();
		break;			
		case "I"://IMPRIMIR
			window.print();
		break;			
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=33";
		break;
	}	
}
function ProcesoValida(Opc,A,T)
{
	var f=document.FrmPrincipal;
	URL="scop_valida_inventario_proceso.php?Opc="+Opc+"&A="+A+"&T="+T;
	opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1024,height=400,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	//popup.moveTo((screen.width - 1024)/2,0);
}
function EliminarTodo(Datos)
{
	var f=document.FrmPrincipal;
	mensaje=confirm("�Est� Seguro de Eiliminar Los contratos Sin Carry Cost Ingresado?");
	if(mensaje==true)
	{	
		f.action='scop_valida_inventario01.php?Opcion=ET&Valores='+Datos; //Datos; //+"&Pagina="+f.Pagina.value;
		f.submit();
	}
}
function EliminarValidacion(Datos)
{
	var f=document.FrmPrincipal;
	mensaje=confirm("�Est� Seguro de Eiliminar la Validaci�n?");
	if(mensaje==true)
	{	
		mensaje=confirm("�Eliminar� Todo los Datos que Contengan Este A�o y Mes!");
		if(mensaje==true)
		{	
			f.action='scop_valida_inventario01.php?Opcion=E&Valores='+Datos; //Datos; //+"&Pagina="+f.Pagina.value;
			f.submit();
		}
	}
}
function Validacion(Datos)
{
	var f=document.FrmPrincipal;
	f.action='scop_valida_inventario01.php?Opcion=VPI&Valores='+Datos; //Datos; //+"&Pagina="+f.Pagina.value;
	f.submit();
}
function ProcesoDetalle(Datos)
{
	var f=document.FrmPrincipal;
	URL="scop_valida_inventario_detalle.php?Valores="+Datos;
	opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1100,height=600,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
}
</script>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'validacion_inventario.png')
 ?>
   <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="../scop_web/archivos/images/interior/form_arriba.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq2em.png" width="15" height="15" /></td>
      </tr>
    <tr>
      <td width="15" background="../scop_web/archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
				<td width="19%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	            <td align="right" class='formulario2' >
				<a href="JavaScript:Proceso('C')"><img src="archivos/buscar.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
				<a href="JavaScript:ProcesoValida('G','<? echo $Ano;?>','<? echo $CmbTipoContr;?>')"><img src="archivos/activo2.png"   alt="Valida/Envia Mail"  border="0" align="absmiddle" /></a>     
				<a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
				<a href="JavaScript:Proceso('S')"><img src="archivos/salir.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
		  </tr>
      <tr>
    	<td width="19%" height="17" class='formulario2'>Tipo Contrato </td>
    	<td colspan="3" class="formulario2" ><select name="CmbTipoContr" onChange="Proceso('R')">
            <option value="T" selected="selected">Todos</option>
            <?
				$Consulta = "select distinct t2.nombre_subclase,t1.cod_tipo_contr from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase order by t1.cod_tipo_contr ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					$NomTipoContrato=$Fila["nom_tipo_contr"];
						if ($CmbTipoContr==$Fila["cod_tipo_contr"])
							echo "<option selected value='".$Fila["cod_tipo_contr"]."'>".$Fila["nombre_subclase"]."</option>\n";
						else
							echo "<option value='".$Fila["cod_tipo_contr"]."'>".$Fila["nombre_subclase"]."</option>\n";
				}
			?>
          </select>
	  </tr>
      <tr>
    	<td width="19%" height="17" class='formulario2'>Contrato</td>
    	<td colspan="3" class="formulario2" ><select name="CmbContrato" onChange="Proceso('R')">
          <option value="T" selected="selected">Todos</option>
          <?
				$Consulta = "select cod_contrato,descrip_contrato,num_contrato from scop_contratos where cod_tipo_contr='".$CmbTipoContr."' and  vigente='1' order by cod_contrato ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbContrato==$FilaTC["cod_contrato"])
						echo "<option selected value='".$FilaTC["cod_contrato"]."'>".$FilaTC["num_contrato"]." - ".strtoupper($FilaTC["descrip_contrato"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_contrato"]."'>".$FilaTC["num_contrato"]." - ".strtoupper($FilaTC["descrip_contrato"])."</option>\n";
				}
 		  ?>
        </select>    
	  </tr>	 
      <tr>
    	<td width="19%" height="17" class='formulario2'>A&ntilde;o</td>
    	<td colspan="3" class="formulario2" >
		<select name="Ano" id="Ano">
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
    	  &nbsp;Mes 
    	  <select name="CmbMes" id="Mes">
		  <option value="T" selected="selected">Todos</option>
			<?
				for ($i=1;$i<=12;$i++)
				{
					if ($i==$CmbMes)
						echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
					else
						echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				}
			?>
	    </select>
      </tr>
	   </table>   
	</td>
      <td width="15" background="../scop_web/archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="../scop_web/archivos/images/interior/form_abajo.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
  <br>	
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
  <td><img src="../scop_web/archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="920" background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="../scop_web/archivos/images/interior/esq2em.gif" width="15" /></td>
   	</tr>
      <tr>
       <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td align="center"><table border="1" cellpadding="0" cellspacing="0">
          <tr height="24">
            <td width="93" rowspan="2" align="center" class="TituloTablaVerdeActiva"> Tipo Producto</td>
            <td height="24" colspan="4" align="center" class="TituloTablaVerdeActiva">Stock Inicial </td>
            <td colspan="3" align="center" class="TituloTablaVerdeActiva">Finos Inventario</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Recepcion</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Beneficio / embarque</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Stock Final </td>
			<td width="50" colspan="1" rowspan="2" align="center" class="TituloTablaVerdeActiva">Valid.</td>
			<td width="50" colspan="1" rowspan="2" align="center" class="TituloTablaVerdeActiva">Elim.</td>
          </tr>
          <tr height="24">
            <td width="48" height="24" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="48" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
            <td width="50" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
            <td width="60" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
            <td width="24" align="center" class="TituloTablaVerdeActiva">Cu (Kg)</td>
            <td width="24" align="center" class="TituloTablaVerdeActiva">Ag (grs)</td>
            <td width="24" align="center" class="TituloTablaVerdeActiva">Au (grs)</td>
            <td width="18" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="31" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
            <td width="41" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
            <td width="56" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
            <td width="28" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="31" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
            <td width="41" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
            <td width="56" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
            <td width="33" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="31" align="center" class="TituloTablaVerdeActiva">Cu (Kg)</td>
            <td width="28" align="center" class="TituloTablaVerdeActiva">Ag (grs)</td>
            <td width="57" align="center" class="TituloTablaVerdeActiva">Au (grs)</td>
		  </tr>
		  <?
		  	if($Buscar=='S')
			{
				//CONSULTO PARA SABER SI EXISTE VALORES PARA ESTE MES CONSULTADO
				$ConsultaMes="select distinct mes from scop_datos_enabal where ano='".$Ano."'";
				if($CmbMes!='T')
					$ConsultaMes.=" and mes='".$CmbMes."'";
				$RespMes=mysql_query($ConsultaMes);
				if($FilaMes=mysql_fetch_array($RespMes))
				{	
					$Cont=1;
					//LOS TIPOS DE CONTRATOS ARGUPADOS 								
					$Consulta="select t2.cod_subclase as cod_tipo_contr,t1.cod_contrato,t2.nombre_subclase as nom_tipo_contr,t1.descrip_contrato from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase ";
					$Consulta.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato where t1.cod_tipo_contr<>'' and t1.vigente='1'";
					if($CmbTipoContr!='T')
						$Consulta.=" and t1.cod_tipo_contr='".$CmbTipoContr."'";
					$Consulta.=" group by t1.cod_tipo_contr ";	
					$Resp1=mysqli_query($link, $Consulta);
					while ($Fila1=mysql_fetch_array($Resp1))
					{						
						$NomTipoContrato1=$Fila1[nom_tipo_contr];
						$CodTipoContrato1=$Fila1[cod_tipo_contr];
						$CodContrato1=$Fila1["cod_contrato"];
						
							$ConsultaContratos="select t1.cod_contrato,t1.descrip_contrato,t1.num_contrato,t2.nombre_subclase as nom_tipo_contr,t2.cod_subclase as cod_tipo_contr from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase ";
							$ConsultaContratos.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato inner join scop_inventario t4 on t1.cod_contrato=t4.cod_contrato ";
							$ConsultaContratos.=" where t1.cod_tipo_contr='".$CodTipoContrato1."' and t4.cod_estado='2' and t1.vigente='1'";
							if($CmbContrato!='T')
								$ConsultaContratos.=" and t1.cod_contrato='".$CmbContrato."'";
							$ConsultaContratos.=" group by cod_contrato ";
							$RespContratos=mysql_query($ConsultaContratos);$Contratos2='';
							while ($FilaContratos=mysql_fetch_array($RespContratos))
							{
								$Contratos2=$Contratos2.$FilaContratos["cod_contrato"]."~";
								if($CmbMes!='T')//MESES PARA SABER DE DONDE HASTA DONDE LLEGA LA CONSULTA POR EL RESULTADO DEL COMBO MESES.
								{
									$k=$CmbMes;
									$m=$CmbMes;
								}
								else
								{
									$k=1;
									//SACO EL ULTIMO MES CON DATOS EN LA TABLA
									$ConsultaMes="select distinct mes from scop_datos_enabal where ano='".$Ano."' order by mes desc";
									$RespMes=mysql_query($ConsultaMes);
									if($FilaMes=mysql_fetch_array($RespMes))
									{
										$m=$FilaMes["mes"];
									}
								}
								for($j=$k;$j<=$m;$j++)
								{								  
									$ConsultaCarrElim="select count(*) as cant from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato ";
									$ConsultaCarrElim.=" where t1.ano='".$Ano."' and t1.mes='".$j."' and t1.cod_estado in ('3')  and t2.cod_tipo_contr='".$FilaContratos[cod_tipo_contr]."' and t2.vigente='1' group by t2.cod_tipo_contr";
									$RespCarrElim=mysql_query($ConsultaCarrElim);$Cuenta=0;
									while($FilaCarrElim=mysql_fetch_array($RespCarrElim))
											$Cuenta=$Cuenta+$FilaCarrElim["cant"];
									$ConsultaCarrElim="select count(*) as cant from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato ";
									$ConsultaCarrElim.=" where t1.ano='".$Ano."' and t1.mes='".$j."' and t1.cod_estado in ('2')  and t2.cod_tipo_contr='".$FilaContratos[cod_tipo_contr]."' and t2.vigente='1' group by t2.cod_tipo_contr";
									$RespCarrElim=mysql_query($ConsultaCarrElim);$Cuenta2=0;
									while($FilaCarrElim=mysql_fetch_array($RespCarrElim))
											$Cuenta2=$Cuenta2+$FilaCarrElim["cant"];
								}
							}
							$CuentaTotal=$Cuenta2-$Cuenta;
							$ConsultaExiste="select * from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato ";
							$ConsultaExiste.=" where t1.ano='".$Ano."' and t1.mes='".$CmbMes."' and t1.cod_estado in ('2') and t2.cod_tipo_contr='".$CodTipoContrato1."' and t2.vigente='1' group by t2.cod_tipo_contr";
							$RespExiste=mysql_query($ConsultaExiste);$Existe=0;
							if($FilaExiste=mysql_fetch_array($RespExiste))
									$Existe=1;							
							if($Contratos2!='')
								$Contratos2=substr($Contratos2,0,strlen($Contratos2)-1);
						?>
						  <tr height="24">
							<td height="24" colspan="21" class="TituloTablaNaranja"><? echo $NomTipoContrato1;?></td><td class="TituloTablaNaranja" align="center"> <? if($CuentaTotal>1&&$Existe==1){echo "<a href=JavaScript:EliminarTodo('".$Contratos2."')><img src='archivos/eliminar3.png' alt='Eliminar Todo para ".$NomTipoContrato1."' width='19' height='19' border='0' align='absmiddle' /> </a>";}else echo "&nbsp;";?></td>
						  </tr>				  
						<?						
						$ArrFinos=array();
						//LOS CONTRATOS PARA LOS TIPOS DE CONTRATOS
						$Consulta1="select t1.cod_contrato,t1.descrip_contrato,t1.num_contrato,t2.nombre_subclase as nom_tipo_contr,t2.cod_subclase as cod_tipo_contr from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_tipo_contr=t2.cod_subclase ";
						$Consulta1.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato where t1.cod_tipo_contr='".$CodTipoContrato1."' and t1.vigente='1'";
						if($CmbContrato!='T')
							$Consulta1.=" and t1.cod_contrato='".$CmbContrato."'";
						$Consulta1.=" group by cod_contrato ";
						$Resp=mysql_query($Consulta1);$Datos=0;
						while ($Fila=mysql_fetch_array($Resp))
						{
							$Datos=1;
							$NomTipoContrato=$Fila[nom_tipo_contr];
							$CodTipoContrato=$Fila[cod_tipo_contr];
							$NumContrato=$Fila["num_contrato"];
							$CodContrato=$Fila["cod_contrato"];
							$NomContrato=$Fila[descrip_contrato];
							
							//$Cu=$Fila[acuerdo_cu];$Ag=$Fila[acuerdo_ag];$Au=$Fila[acuerdo_au];
						  ?>			  	
							  <tr height="24">
								<td height="24" colspan="24" class="cab_tabla">								
								<? echo $NumContrato." - ".$NomContrato;?></td>
							  </tr>
						  <?
								if($CmbMes!='T')//MESES PARA SABER DE DONDE HASTA DONDE LLEGA LA CONSULTA POR EL RESULTADO DEL COMBO MESES.
								{
									$k=$CmbMes;
									$m=$CmbMes;
								}
								else
								{
									$k=1;
									//SACO EL ULTIMO MES CON DATOS EN LA TABLA
									$ConsultaMes="select distinct mes from scop_datos_enabal where ano='".$Ano."' order by mes desc";
									$RespMes=mysql_query($ConsultaMes);
									if($FilaMes=mysql_fetch_array($RespMes))
									{
										$m=$FilaMes["mes"];
									}
								}
								for($j=$k;$j<=$m;$j++)
								{								  
									   $Validacion=$Ano."~".$j."~".$CodContrato;
									   reset($ArrFinos);
									   for($i=1;$i<=4;$i++)
									   {
											$ArrFinos[$i]["peso"]='';$ArrFinos[$i][Cu]='';$ArrFinos[$i][Au]='';$ArrFinos[$i][Ag]='';
									   }						   					 
									   for($i=1;$i<=4;$i++)
									   {
											$ConsultaFlujo=" select * from scop_contratos_flujos where cod_contrato='".$CodContrato."' and tipo_inventario='".$i."'";
											$RespFlujo=mysql_query($ConsultaFlujo);
											while($FilaFlujo=mysql_fetch_array($RespFlujo))
											{
												$TipoInventario=$FilaFlujo[tipo_inventario];
												$TipoFlujo=$FilaFlujo[tipo_flujo];
												$CodFlujo=$FilaFlujo["flujo"];
												$Contrato=$FilaFlujo["cod_contrato"];
												  //A LA FUNCION LA CUAL ENTREGAR� LOS VALORES CONSULTADOS										
												  $ValorPeso=DatosEnabalFlujos2($Ano,$j,$Contrato,$TipoFlujo,$CodFlujo,&$ArrFinos,$i);
											}
										}
											$Det=$CodContrato."~".$Ano."~".$j."~".$CodTipoContrato;
										?>
										   <tr bgcolor="#FFFFFF" class="formulario">
												<td><a href="JavaScript:ProcesoDetalle('<? echo $Det;?>')"><? echo $Meses[$j-1];?></a></td>
												<? reset($ArrFinos);
												   for($i=1;$i<=1;$i++)
												   {
												   		$InventarioInicial=$ArrFinos[$i]["peso"];
														if($InventarioInicial==0)
															$InventarioInicial=0;
												   }	
												   for($i=2;$i<=2;$i++)
												   {
												   		$InventarioRecepcion=$ArrFinos[$i]["peso"];
														if($InventarioRecepcion==0)
															$InventarioRecepcion=0;
												   }	
												   for($i=3;$i<=3;$i++)
												   {
												   		$InventarioBeneficio=$ArrFinos[$i]["peso"];
														if($InventarioBeneficio==0)
															$InventarioBeneficio=0;
												   }	
												   for($i=4;$i<=4;$i++)
												   {
												   		$InventarioStockFinal=$ArrFinos[$i]["peso"];
														if($InventarioStockFinal==0)
															$InventarioStockFinal=0;
												   }
												   $ResultadoCero=$InventarioInicial+$InventarioRecepcion-$InventarioBeneficio-$InventarioStockFinal;
												   for($i=1;$i<=4;$i++)
												   {	
														if($i!=4)
														{	
															if($ArrFinos[$i]["peso"]>0)
															{																
														?>																					
															<td align="right"><? echo number_format($ArrFinos[$i]["peso"],0,',','.');?>&nbsp;</td>
															<td align="right"><? echo number_format(($ArrFinos[$i][Cu]/$ArrFinos[$i]["peso"])*100,2,',','.');?>&nbsp;</td>
															<td align="right"><? echo number_format(($ArrFinos[$i][Ag]/$ArrFinos[$i]["peso"])*1000,2,',','.');?>&nbsp;</td>
															<td align="right"><? echo number_format(($ArrFinos[$i][Au]/$ArrFinos[$i]["peso"])*1000,2,',','.');?>&nbsp;</td>
														<?
															}
															else
															{
																?>																					
																	<td align="right">0</td>
																	<td align="right">0</td>
																	<td align="right">0</td>
																	<td align="right">0</td>
																<?
															}
														}
														if($i==1)
														{
														?>
															<td align="right" class="texto_bold"><? echo number_format($ArrFinos[$i][Cu],0,',','.');?>&nbsp;</td>
															<td align="right" class="texto_bold"><? echo number_format($ArrFinos[$i][Ag],0,',','.');?>&nbsp;</td>
															<td align="right" class="texto_bold"><? echo number_format($ArrFinos[$i][Au],0,',','.');?>&nbsp;</td>
														<?
														}
														if($i==4)
														{
														?>
															<td align="right"><? echo number_format($ArrFinos[$i]["peso"],0,',','.');?>&nbsp;</td>
															<td align="right"><? echo number_format($ArrFinos[$i][Cu],0,',','.');?>&nbsp;</td>
															<td align="right"><? echo number_format($ArrFinos[$i][Ag],0,',','.');?>&nbsp;</td>
															<td align="right"><? echo number_format($ArrFinos[$i][Au],0,',','.');?>&nbsp;</td>
														<?
														}				
												   }
												   $ConsultaEstado="select t1.ano,t1.mes,t1.cod_estado,t1.cod_contrato,t2.nombre_subclase as nom_estado from scop_inventario t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33000' and t1.cod_estado=t2.cod_subclase";
												   $ConsultaEstado.=" where t1.cod_contrato='".$CodContrato."' and t1.ano='".$Ano."' and t1.mes='".$j."'";		
												   $RespEstado=mysql_query($ConsultaEstado);
												   if($FilaEstado=mysql_fetch_array($RespEstado))
												   {	
												   		$Vuelta=$Vuelta+1;												   		
												   		if($FilaEstado["cod_estado"]=='1')//creado
														{
															echo "<td align='center'><img src='archivos/acepta.png' alt='".$FilaEstado[nom_estado]."'  border='0' align='absmiddle' /></td>";
															echo "<td align='center'>&nbsp;</td>";
														}
														if($FilaEstado["cod_estado"]=='2')//validado
														{
															$Cod=$FilaEstado["cod_contrato"]."~".$Ano."~".$j;
															echo "<td align='center'><img src='archivos/acepta.png' alt='".$FilaEstado[nom_estado]."'  border='0' align='absmiddle' /></td>";
															//CONSULTA SI PARA ESTE ANO Y MES EXISTE UN ESTADO EN 3 SI ES ASI NO SE PODRA ELIMINAR LA VALIDACION.
															$ConsultaCarrElim="select * from scop_inventario t1";
															$ConsultaCarrElim.=" where t1.ano='".$FilaEstado["ano"]."' and t1.mes='".$FilaEstado["mes"]."' and t1.cod_estado='3' and cod_contrato='".$FilaEstado["cod_contrato"]."'";
															//echo $ConsultaCarrElim."<br>";
															$RespCarrElim=mysql_query($ConsultaCarrElim);
														    if($FilaCarrElim=mysql_fetch_array($RespCarrElim))
																echo "<td align='center'><img src='archivos/btn_distribucion_cecos.png' alt='Carry Cost Ingresado' width='19' height='19'  border='0' align='absmiddle' /> </a></td>";
															else																
																echo "<td align='center'><a href=JavaScript:EliminarValidacion('".$Cod."')><img src='archivos/eliminar2.png' alt='Eliminar' width='19' height='19'  border='0' align='absmiddle' /> </a></td>";
														}	
												   }	
												   else
												   {
														if($ResultadoCero==0)
														{
															echo "<td align='center'>".number_format($ResultadoCero,0,',','.')."<a href=JavaScript:Validacion('".$Validacion."')><img src='archivos/acepta_final6.png' alt='".$FilaEstado[nom_estado]."' alt='Crear para Validar'  border='0' align='absmiddle'/></a></td>";
															echo "<td align='center'>&nbsp;</td>";	
														}
														else
														{
															echo "<td align='center'>".number_format($ResultadoCero,0,',','.')."</td>";
															echo "<td align='center'>&nbsp;</td>";	
														}	
												   }	
												?> 												
		  </tr>
										<?
								 }//FOR DE MESES PARA LA CONSULTA
						 }//FIN CONTRATO
						?>
						<tr  class="glosa_tablas_blanco">
							<td colspan="24">&nbsp;</td>
						</tr>
						<?
					}//tipo de inventarios
				}//FIN BUSCAR	
			}//FIN DE CONSULTA SI EXISTE VALORES PARA EL MES CONSULTADO	
			else
				$Cont=0;
		  ?>
        </table></td>
 </td>
   <td width="10" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
   </tr>
    <tr>
      <td width="15"><img src="../scop_web/archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="../scop_web/archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>	
</form>
<?
CierreEncabezado()
?>
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? }
	if($Buscar=='S'&&$Cont==0)
   {
?>
	<script language="javascript">
	alert("No Existen valores para el Mes consultado")
	</script>
<? }
	if($MEli=='S')
   {
?>
	<script language="javascript">
	alert("Validaci�n Eliminada con Exito")
	</script>
<? }
	if($Val=='S')
   {
?>
	<script language="javascript">
	alert("Validado Exitosamente")
	</script>
<? }

function DatosEnabalFlujos2($AnoFlujo,$MesFlujo,$Contrato,$TipoFlujo,$CodFlujo,$ArrFinos,$i)
{
	$Consulta="select * from scop_contratos_flujos where cod_contrato='".$Contrato."' and  tipo_inventario='".$i."' and flujo='".$CodFlujo."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila[tipo_inventario]=='1')
		{
			if($MesFlujo==1)
			{
				$AnoFlujo=$AnoFlujo-1;
				$MesFlujo=12;
			}
			else
				$MesFlujo=$MesFlujo-1;
		}
		if($Fila[tipo_inventario]=='1'||$Fila[tipo_inventario]=='4')
			$TipoMovimiento=3;
		else
			$TipoMovimiento=2;		
		$Flujo= $Fila["flujo"];
		$Consulta="select peso,cobre,plata,oro from scop_datos_enabal where ano='".$AnoFlujo."' and cod_flujo='".$Flujo."' and origen='".$TipoFlujo."' and tipo_mov='".$TipoMovimiento."'";		
		if($MesFlujo!='T')
			$Consulta.=" and mes='".$MesFlujo."'";
		$RespValor=mysqli_query($link, $Consulta);
		while($FilaValor=mysql_fetch_array($RespValor))
		{
			$Peso=$FilaValor["peso"];
			$Cu=$FilaValor[cobre];
			$Ag=$FilaValor[plata];
			$Au=$FilaValor[oro];
			if($Fila["signo"]==1)
			{
				$ArrFinos[$i]["peso"]=$ArrFinos[$i]["peso"]+$Peso;
				$ArrFinos[$i][Cu]=$ArrFinos[$i][Cu]+$Cu;
				$ArrFinos[$i][Ag]=$ArrFinos[$i][Ag]+$Ag;
				$ArrFinos[$i][Au]=$ArrFinos[$i][Au]+$Au;
			}
			else
			{
				$ArrFinos[$i]["peso"]=$ArrFinos[$i]["peso"]-$Peso;
				$ArrFinos[$i][Cu]=$ArrFinos[$i][Cu]-$Cu;
				$ArrFinos[$i][Ag]=$ArrFinos[$i][Ag]-$Ag;
				$ArrFinos[$i][Au]=$ArrFinos[$i][Au]-$Au;
			}
		}		
	}
	
}
?>