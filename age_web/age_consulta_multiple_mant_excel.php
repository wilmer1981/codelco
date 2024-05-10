<?php
        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
include("../principal/conectar_principal.php");


$TipoBusq = isset($_REQUEST['TipoBusq']) ? $_REQUEST['TipoBusq'] : '0';
$Recarga  = isset($_REQUEST['Recarga']) ? $_REQUEST['Recarga'] : '';
$Mostrar  = isset($_REQUEST['Mostrar']) ? $_REQUEST['Mostrar'] : '';
$Opcion   = isset($_REQUEST['Opcion']) ? $_REQUEST['Opcion'] : '';
$CmbOpcion = isset($_REQUEST['CmbOpcion']) ? $_REQUEST['CmbOpcion'] : ''; 
$OpcionCodigo = isset($_REQUEST['OpcionCodigo']) ? $_REQUEST['OpcionCodigo'] : ''; 
$OpcionDescripcion = isset($_REQUEST['OpcionDescripcion']) ? $_REQUEST['OpcionDescripcion'] : ''; 
$TxtCodigo = isset($_REQUEST['TxtCodigo']) ? $_REQUEST['TxtCodigo'] : ''; 
$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : ''; 

?>
<html>
<head>
<title>Consulta Empadronamiento Minero Excel</title>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaMultMant" method="post" action="">
	  <table width="730" border="1" cellspacing="0" cellpadding="3" class="tablainterior" align="center">
          <tr class="ColorTabla01">
		  <?php
		  switch($CmbOpcion)
		  {
			case "2":
				echo "<td align='center' width='100'>Rut</td>";
				echo "<td align='center' width='650'>Apellidos,Nombres</td>";
				break;				  
			case "4":
				echo "<td align='center' width='60'>Cod.Mina</td>";
				echo "<td align='center' width='150'>Mina/Planta</td>";
				echo "<td align='center' width='150'>Proveedor</td>";
				echo "<td align='center'  width='70'>Sierra</td>";
				echo "<td align='center'  width='70'>Comuna</td>";
				echo "<td align='center'  width='70'>Fec.Padron</td>";
				break;					  
		  }	
		  ?>	  
		  </tr>
		  <?php
			if ($Mostrar=='S')	
			{
				switch($CmbOpcion)
				{
					case "2"://POR PROVEEDOR
						if ($Opcion=='C')
							$Consulta= "select * from sipa_web.proveedores where rut_prv = '".$TxtCodigo."'";
						else		
							$Consulta= "select * from sipa_web.proveedores where nombre_prv like '%".$TxtDescripcion."%'";	
						break;
					case "4"://POR EMPADRONAMIENTO MINERO
						switch($Opcion)
						{
							case "C"://POR CODIGO DE MINA
								$Consulta="select * from sipa_web.minaprv where cod_mina like '%".$TxtCodigo."%'";
								break;
							case "D"://POR DESCRIPCION
								$Consulta="select * from sipa_web.minaprv where nombre_mina like '%".$TxtDescripcion."%'";								
								break;
						}	
						break;
					default:
						break;	
				}
				//echo $Consulta;
				$Resp = mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='CheckCod'>";
				while ($Fila = mysqli_fetch_array($Resp))
				{
				  switch($CmbOpcion)
				  {
					case "2"://PROVEEDOR
						echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
						echo "<td align='center'>".$Fila["rut_prv"]."</td>\n";
						echo "<td align='Left'>".$Fila["nombre_prv"]."</td>\n";
						echo "</tr>\n";
						break;
					case "4"://MINA
						echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
						echo "<td align='center'>".$Fila["cod_mina"]."</td>\n";
						echo "<td align='left'>".$Fila["nombre_mina"]."</td>\n";
						echo "<td align='center'>".$Fila["rut_prv"]." - ".$Fila["NOMPRV_A"]."</td>\n";
						echo "<td align='left'>".$Fila["sierra"]."</td>\n";
						echo "<td align='left'>".$Fila["comuna"]."</td>\n";
						echo "<td align='center'>".$Fila["fecha_padron"]."</td>\n";
						echo "</tr>\n";
						break;
					}	
				}
			}
		  ?>
  </table>
</form>
</body>
</html>