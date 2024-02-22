<?php 	
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 37;
	include("../principal/conectar_sec_web.php");
	$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

?>
<html>
<head>

<title>Consulta Peso Patr&oacute;n</title>
  
<?php
	 		 if (strlen($MesIni)==1)
			{
				$MesIni="0".$MesIni;
			}
			if (strlen($DiaIni)==1)
			{
				$DiaIni="0".$DiaIni;
			}
			if (strlen($MesFin)==1)
			{
				$MesFin="0".$MesFin;
			}
			if (strlen($DiaFin)==1)
			{
				$DiaFin="0".$DiaFin;
			}
			$Fechainiturno=$AnoIni."-".$MesIni."-".$DiaIni." 08:00:00";
			$Fechafturno=$AnoFin."-".$MesFin."-".$DiaFin." 23:59:59";
	  ?>
        <table  border="1" >
         <tr> 
             <td colspan="5" align="center">Periodo: Desde :<?php echo $Fechainiturno;?>  Hasta :<?php echo $Fechafturno;?></div></td>
 
          </tr>
          <tr > 
             <td width="26">&nbsp;</td>
             <td width="141">Fecha/Hora Registro</td>
            <td width="164">B&aacute;scula</td>
            <td width="131">Peso</td>
            <td width="299">Funcionario</td>
            </tr>
         
			<?php  
			$cont = 1;			
			$Consulta1=" SELECT t1.*,t2.nombres,t2.apellido_paterno,t2.apellido_materno from sec_web.sec_registro_peso_patron t1 left join proyecto_modernizacion.funcionarios t2 on t1.usuario=t2.rut ";
			$Consulta1.=" where (t1.fecha_registro  BETWEEN  '".$Fechainiturno."' and  '".$Fechafturno."' )";
			if($CmbBascula!='T')
				$Consulta1.=" and id_bascula = '".$CmbBascula."'";	
			$Consulta1.=" ORDER BY fecha_registro ASC ";
		   $Respuesta=mysqli_query($link, $Consulta1);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
					
				$PrimerNombre=$Fila["nombres"];
				for ($i=0;$i<=strlen($PrimerNombre);$i++)
				{
					if (substr($PrimerNombre,$i,1)==" ")
					{
						$PrimerNombre=trim(substr($PrimerNombre,0,$i));
						break;
					}
				}
				$NombreUser = ucwords(strtolower($PrimerNombre))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".strtoupper(substr($Fila["apellido_materno"],0,1)).".";
				?>
                <tr>
				<td><?php echo $cont;?></td>
				<td><?php echo $Fila[fecha_registro];?></td>
				<td><?php echo $Fila["descripcion"];?></td>
				<td align="right"><?php echo number_format($Fila["peso"],1,',','.');?></td>
				<td><?php echo $NombreUser;?></td>
				</tr>
				<?php	
				$cont++;
			}
			
			?>
        </table> 
        
</body>
</html>
