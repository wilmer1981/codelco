<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");	
	
	if(isset($_REQUEST["Pag"])){
		$Pag = $_REQUEST["Pag"];
	}else{
		$Pag = "";
	}
	if(isset($_REQUEST["VisibleDivProceso"])){
		$VisibleDivProceso = $_REQUEST["VisibleDivProceso"];
	}else{
		$VisibleDivProceso = "";
	}
	if(isset($_REQUEST["FDesde"])){
		$FDesde = $_REQUEST["FDesde"];
	}else{
		$FDesde = "";
	}
	if(isset($_REQUEST["FHasta"])){
		$FHasta = $_REQUEST["FHasta"];
	}else{
		$FHasta = "";
	}
	if(isset($_REQUEST["NivelOrg"])){
		$NivelOrg = $_REQUEST["NivelOrg"];
	}else{
		$NivelOrg = "";
	}
	if(isset($_REQUEST["Buscar"])){
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date('Y');
		//$AnoActual=date('Y');
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date('m');
		//$MesActual=date('m');
	}


	if(isset($_REQUEST["Mensaje"])){
		$Mensaje = $_REQUEST["Mensaje"];
	}else{
		$Mensaje = "";
	}
	if(isset($_REQUEST["Datos"])){
		$Datos = $_REQUEST["Datos"];
	}else{
		$Datos = "";
	}
	if(isset($_REQUEST["Proc"])){
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = "";
	}


if($VisibleDivProceso=='S')
$VisibleDiv='hidden';

if(!isset($FDesde))
	$FDesde=date('Y-m-d');
if(!isset($FHasta))
	$FHasta=date('Y-m-d');
	
$SelTarea=$NivelOrg;
set_time_limit(1000);
?>
<html>
<head>
<title>Consultas</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function Proceso(Proc,Pag)
{
	var f=document.FrmPrincipal;
	switch(Proc)
	{
		case "B":
/*			if(Pag!='8'&&Pag!='1')
			{
				if(compare_dates(f.FDesde.value,f.FHasta.value)==false)			
				{
					f.action="pmn_consultas_principal.php?Pag="+Pag+"&Buscar=S";
					f.submit();
				}	
			}*/
			if(Pag=='3'||Pag=='5'||Pag=='6'||Pag=='7'||Pag=='10'||Pag=='9')
			{
				f.action="pmn_consultas_principal.php?Pag="+Pag+"&Buscar=S&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
				f.submit();
			}
			if(Pag=='1')
			{
				f.action="pmn_consultas_principal.php?Pag="+Pag+"&Buscar=S&AnoM="+f.AnoM.value+"&MesM="+f.MesM.value;
				f.submit();
			}
			if(Pag=='8')
			{
				f.action="pmn_consultas_principal.php?Pag="+Pag+"&Buscar=S&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&AInicial="+f.AInicial.value+"&PInicial="+f.PInicial.value;
				f.submit();
			}
		break
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=162";
			f.submit();
		break;
		case "IM":
		   window.print();
		break
		case "E":
				switch(Pag)
				{
					case "1":
							var URL = "pmn_consultas_principal_metal_dore_excel.php?AnoM="+f.AnoM.value+"&MesM="+f.MesM.value+"&Exist="+f.Exist.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
					case "2":
					break;
					case "3":
							var URL = "pmn_consultas_principal_produ_barro_anodo_desco_excel.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
					case "4":
					break;
					case "5":
							var URL = "pmn_consultas_principal_mov_calcina_excel.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&Exist="+f.Exist2.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
					case "6":
							var URL = "pmn_consultas_principal_prod_anodo_dore_excel.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
					case "7":
							var URL = "pmn_consultas_principal_elect_plata_mov_anodos_excel.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
					case "8":
							var URL = "pmn_consultas_principal_traspaso_anodos_excel.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&AInicial="+f.AInicial.value+"&PInicial="+f.PInicial.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
					case "9":
							var URL = "pmn_consultas_principal_prod_circ_excel.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
					case "10":
							var URL = "pmn_consultas_principal_prod_oxidos_excel.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value;
							window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
					break;
				}
		break
	}
}
function compare_dates(fecha, fecha2)   
{   
	//alert(fecha+"  -   "+fecha2)
    var xMonth=fecha.substring(5, 7);   
    var xDay=fecha.substring(8, 10);   
    var xYear=fecha.substring(0,4);   
    var yMonth=fecha2.substring(5, 7);   
    var yDay=fecha2.substring(8, 10);   
    var yYear=fecha2.substring(0,4); 
    if (xYear> yYear)   
    {   
        return(true)   
    }   
    else  
    {   
      if (xYear == yYear)   
      {  
        if (xMonth> yMonth)   
        {   
            return(true)   
        }   
        else  
        {    
          if (xMonth == yMonth)   
          {   
            if (xDay> yDay)
			{
              return(true);   
			}
            else  
              return(false);   
          }   
          else  
            return(false);   
        }   
      }   
      else  
	  {
        return(false);   
	  }
    }   
}  
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="">
<input name="Datos" type="hidden" value="<?php echo $Datos;?>">
<input name="Proc" type="hidden" value="<?php echo $Proc;?>">
<input type="hidden" size='100' value="<?php echo $SelTarea;?>" name="SelTarea">
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4">
		<?php
		switch($Pag)
		{
			case "1":
					include('pmn_consultas_principal_metal_dore.php');
			break;
/*			case "2":
					include('pmn_consultas_principal_bad_ventana.php');
			break;
*/			case "3":
					include('pmn_consultas_principal_produ_barro_anodo_desco.php');
			break;
			case "4":
					include('pmn_consultas_principal_4.php');
			break;
			case "5":
					include('pmn_consultas_principal_mov_calcina.php');
			break;
			case "6":
					include('pmn_consultas_principal_prod_anodo_dore.php');
			break;
			case "7":
					include('pmn_consultas_principal_elect_plata_mov_anodos.php');
			break;
			case "8":
					include('pmn_consultas_principal_traspaso_anodos.php');
			break;
			case "9":
					include('pmn_consultas_principal_prod_circ.php');
			break;
			case "10":
					include('pmn_consultas_principal_prod_oxidos.php');
			break;
		}
		?>
	  &nbsp;</td>
    </tr>
</table>
<BR>
<br>
<br>
</form>
</body>
</html>
<?php
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

