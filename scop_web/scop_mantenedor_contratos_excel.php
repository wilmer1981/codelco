<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

    include("../principal/conectar_scop_web.php");
    include("funciones/scop_funciones.php");
//	$KoolControlsFolder="KoolPHPSuite/KoolControls";
//	require $KoolControlsFolder."/KoolAjax/koolajax.php";
//	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
//		
//	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
//	$ds->SelectCommand = "select num_contrato as pk, descrip_contrato,cod_tipo,acuerdo_cu,acuerdo_ag,acuerdo_au,vigente from scop_contratos ";
//	//$ds->UpdateCommand = "UPDATE customers set customerNumber=@customerNumber, customerName='@customerName', phone='@phone', city='@city' where customerNumber=@pk";
//	//$ds->DeleteCommand = "delete from customers where customerNumber=@pk";
//	//$ds->InsertCommand = "INSERT INTO customers (customerNumber,customerName,phone,city) values (@customerNumber,'@customerName','@phone','@city');";
//
//	$grid = new KoolGrid("grid");
//	$grid->scriptFolder = $KoolControlsFolder."KoolGrid";
//	$grid->styleFolder="KoolGrid/styles/default";
//
//	$grid->AjaxEnabled = true;
//	$grid->AjaxLoadingImage =  $KoolControlsFolder."/KoolAjax/loading/5.gif";	
//	$grid->DataSource = $ds;
//	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
//	$grid->Width = "655px";
//	$grid->ColumnWrap = true;
//	$grid->AllowEditing = true;
//	$grid->AllowDeleting = true;
//
//	$grid->MasterTable->ShowFunctionPanel = true;	
//	$grid->MasterTable->InsertSettings->ColumnNumber = 2;	
//
//	$column = new GridBoundColumn();
//	$column->HeaderText = "Contrato";
//	$column->DataField = "num_contrato";
//	//Create regular expression validator to make sure the input is an integer.
//	$validator = new RegularExpressionValidator();
//	$validator->ValidationExpression = "/^([0-9])+$/";
//	$validator->ErrorMessage = "Please input an integer";
//	$column->AddValidator($validator);
//	$grid->MasterTable->AddColumn($column);
//
//	$column = new GridBoundColumn();
//	$column->HeaderText = "Descripcion";
//	$column->DataField = "descrip_contrato";
//	//Add required field validator to make sure the input is not empty.
//	$validator = new RequiredFieldValidator();
//	$column->AddValidator($validator);
//	$grid->MasterTable->AddColumn($column);
//
//	$column = new GridBoundColumn();
//	$column->HeaderText = "Tipo Contrato";
//	$column->DataField = "cod_tipo";
//	//Add required field validator to make sure the input is not empty.
//	$validator = new RequiredFieldValidator();
//	$column->AddValidator($validator);
//	$grid->MasterTable->AddColumn($column);
//
//	$column = new GridBoundColumn();
//	$column->HeaderText = "Acuerdo Cu";
//	$column->DataField = "acuerdo_cu";
//	//Add required field validator to make sure the input is not empty.
//	$validator = new RequiredFieldValidator();
//	$column->AddValidator($validator);
//	$grid->MasterTable->AddColumn($column);
//	$column = new GridEditDeleteColumn();
//	$grid->MasterTable->AddColumn($column);
//	
//	$grid->Process();


?>
<html>
<head>
<title>Mantenedor Contratos</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
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
			f.action="scop_mantenedor_contratos.php?Buscar=S";
			f.submit();
		break;
		case "N":
			URL="scop_mantenedor_contratos_proceso.php?Opc="+Opc;
			opciones='left=50,top=30,toolbar=0,resizable=0,menubar=0,status=1,width=1000,height=600,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 1024)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				URL="scop_mantenedor_contratos_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='left=50,top=30,toolbar=0,resizable=0,menubar=0,status=1,width=1000,height=600,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 1024)/2,0);
			}	
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
		case "EX"://GENERA EXCEL
			URL='scop_mantenedor_contratos_excel.php?&CmbContrato='+f.CmbContrato.value+'&CmbProveedor='+f.CmbProveedor.value+'&CmbTipoContrato='+f.CmbTipoContrato.value+'&CmbVig='+f.CmbVig.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "I"://IMPRIMIR
			window.print();
		break;			
		case "R":
			f.action = "scop_mantenedor_contratos.php";
			f.submit();
		break;		
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=32";
		break;
	}	
}
function Resumen(Dato)
{
	var popup=0;
	var f=document.FrmPrincipal;
	URL="scop_mantenedor_contratos_resumen_detalle.php?Datos="+Dato;
	opciones='left=50,top=30,toolbar=0,resizable=0,menubar=0,status=1,width=900,height=500,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 1024)/2,0);
}
</script>
<style type="text/css">
</style>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<table width="930" border="1" cellpadding="4" cellspacing="0" >
  <tr align="center">
    <td width="7%" >Contrato</td>
    <td width="11%" >Fecha Creaci&oacute;n</td>
    <td width="27%" >Descripcion</td>
    <td width="12%" >Tipo Contrato</td>
    <td width="10%" >Acuerdo Cu</td>
    <td width="11%" >Acuerdo Ag</td>
    <td width="10%" >Acuerdo Au</td>
    <td width="8%" >Vigente</td>
  </tr>
  <?
  $Buscar='S';
if($Buscar=='S')
{
	$Consulta="select t1.tipo_cu,t1.tipo_ag,t1.tipo_au,t1.acuerdo_cu,t1.acuerdo_ag,t1.acuerdo_au,t1.descrip_contrato,t1.fecha_contrato,t2.nombre_subclase as nom_tipo_contr,t1.num_contrato,t1.cod_contrato,t3.nombre_subclase as nom_vig from scop_contratos t1";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31007' and t1.vigente=t3.cod_subclase where t1.num_contrato<>''";
	if($CmbContrato!='T')
		$Consulta.=" and t1.num_contrato='".$CmbContrato."'";
	if($CmbTipoContrato!='T')
		$Consulta.=" and t1.cod_tipo_contr='".$CmbTipoContrato."'";	
	if($CmbVig!='T')
		$Consulta.=" and t1.vigente='".$CmbVig."'";	
	$Consulta.=" order by t1.cod_contrato";	
	$Resp=mysqli_query($link, $Consulta);
	//echo $Consulta."<br>";
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		$NumContrato=$FilaTC["num_contrato"];
		$Contrato=$FilaTC["cod_contrato"];
		if($FilaTC[tipo_cu]==1)
		{
			if($FilaTC[acuerdo_cu]=='-1')
				$MESCU="Mes ".$FilaTC[acuerdo_cu];
			else
				$MESCU="Mes +".$FilaTC[acuerdo_cu];
			if($FilaTC[acuerdo_cu]=='N')
				$MESCU='';		
		}
		else
			$MESCU="PF&nbsp;".number_format($FilaTC[acuerdo_cu],3,',','.');
		if($FilaTC[tipo_ag]==1)
		{
			if($FilaTC[acuerdo_ag]=='-1')
				$MESAG="Mes ".$FilaTC[acuerdo_ag];
			else
				$MESAG="Mes +".$FilaTC[acuerdo_ag];	
			if($FilaTC[acuerdo_ag]=='N')
				$MESAG='';		
		}
		else
			$MESAG="PF&nbsp;".number_format($FilaTC[acuerdo_ag],3,',','.');
		if($FilaTC[tipo_ag]==1)
		{
			if($FilaTC[acuerdo_au]=='-1')
				$MESAU="Mes ".$FilaTC[acuerdo_au];
			else
				$MESAU="Mes +".$FilaTC[acuerdo_au];	
			if($FilaTC[acuerdo_au]=='N')
				$MESAU='';		
		}
		else
			$MESAU="PF&nbsp;".number_format($FilaTC[acuerdo_au],3,',','.');
?>
  <tr>
    <td align="center"><? echo $NumContrato; ?></td>
	<td align="center"><? echo $FilaTC[fecha_contrato]; ?></td>
	<td align="left"><? echo $FilaTC[descrip_contrato]; ?>&nbsp;</td>
	<td align="center"><? echo $FilaTC[nom_tipo_contr]; ?>&nbsp;</td>		
	<td align="center"><? echo $MESCU; ?>&nbsp;</td>		
	<td align="center"><? echo $MESAG; ?>&nbsp;</td>
	<td align="center">&nbsp;<? echo $MESAU; ?></td>
	<td align="center">&nbsp;<? echo $FilaTC[nom_vig]; ?></td>
  </tr>
  <?
	}
}	
?>
  <?php //echo $koolajax->Render();?>
  <!--<div style='padding-bottom:5px;width:655px;'>	
		<i>*Note:</i> When editing or inserting row, you may test putting non-integer to CustomerNumber field or leave other input fields empty.
	</div>-->
  <?php //echo $grid->Render();?>
</table>
</tr>
</table>
</form>
</body>
</html>
<?
	echo "<script languaje='JavaScript'>";
	if ($Mensaje=='E')
		echo "alert('No se puede Eliminar, Existen Flujos Asociados');";
	if ($Mensaje=='S')
		echo "alert('Contrato Eliminado Exitosamente');";
	echo "</script>";
?>