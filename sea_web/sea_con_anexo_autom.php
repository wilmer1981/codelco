<?php 
include("../principal/conectar_sea_web.php");
set_time_limit(2000);
 ?>

<html>
<head>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">

function Salir()
{
	window.history.back();
}

function Imprimir()
{
	window.print();
}

</script>

</head>
<SCRIPT LANGUAGE="JavaScript">
function cerrar_sin()
{  
 window.open('','_parent','');
 window.close(); 
} 
</script> 

<body class="TablaPrincipal">



<?php
	 // Obtener el día operacional 
        // 229 4-03-2016
	  //  $cons_fech = "SELECT year(DATE_ADD(now(),INTERVAL -230 DAY) )AS aa, month(DATE_ADD(now(),INTERVAL -230 DAY) )AS mm, day(DATE_ADD(now(),INTERVAL -230 DAY) )AS dd from dual";
          $cons_fech = "SELECT year(DATE_ADD(now(),INTERVAL-1 DAY) )AS aa,month(DATE_ADD(now(),INTERVAL-1 DAY) )AS mm,day(DATE_ADD(now(),INTERVAL-1 DAY) )AS dd from dual";
	      $Respuesta = mysqli_query($link, $cons_fech);
		if ($Fila = mysqli_fetch_array($Respuesta))	
		   { 				
	  		  $Anoi = $Fila["aa"];
			  $Mesi = $Fila["mm"];
			  $Diai = $Fila["dd"];
		   }

		   
           if (strlen($Mesi) == 1)
	        	$Mesi = "0".$Mesi;
	       if (strlen($Diai) == 1)
		        $Diai = "0".$Diai;
	

       //    echo "AÑO In".$Anoi.'<br>';
		//   echo "MES In".$Mesi.'<br>';
		//   echo "DIA In".$Diai.'<br>';

            
           $fecha_ini = $Anoi.'-'.$Mesi.'-'.$Diai;

           // Obtener el dia de Termino.
         //  $cons_fech = "SELECT year(DATE_ADD(now(),INTERVAL -229 DAY) )AS aa, month(DATE_ADD(now(),INTERVAL -229 DAY) )AS mm, day(DATE_ADD(now(),INTERVAL -229 DAY) )AS dd from dual";
	       $cons_fech =  "SELECT year(now()) aa, month(now()) mm, day(now()) dd from dual";

	       $Respuesta = mysqli_query($link, $cons_fech);
		  if ($Fila = mysqli_fetch_array($Respuesta))	
		   { 				
	  		  $Anot = $Fila["aa"];
			  $Mest = $Fila["mm"];
			  $Diat = $Fila["dd"];
		   }

		    if (strlen($Mest) == 1)
	        	$Mest = "0".$Mest;
	       if (strlen($Diat) == 1)
		        $Diat = "0".$Diat;

        //   echo "AÑO Ter".$Anot.'<br>';
		//   echo "MES Ter".$Mest.'<br>';
		//   echo "DIA Ter".$Diat.'<br>';

            $fecha_ter = $Anot.'-'.$Mest.'-'.$Diat;


          // $fecha_ini  = '2016-08-29';
          // $fecha_ter  = '2016-08-30';
          
	
        //   echo "Fecha Ini: ".$fecha_ini.'<br>';
        //   echo " Fecha Ter :".$fecha_ter.'<br>';
           $Fecha_Ini_Hora = $fecha_ini." 08:00:00";
		   $Fecha_Ter_Hora = $fecha_ter." 07:59:59";

		//   echo "FFecha_Ini_Hora: ".$Fecha_Ini_Hora.'<br>';
        //   echo " Fecha_Ter_Hora :".$Fecha_Ter_Hora.'<br>';

		//Obtiene los todos flujos
		$ConsultaFlujo = "SELECT distinct cod_flujo FROM proyecto_modernizacion.flujos WHERE sistema = 'SEA' and esflujo<>'N' and cod_flujo in (92,93,129,131)";
		$ConsultaFlujo.= " ORDER BY cod_flujo";
		$Resp = mysqli_query($link, $ConsultaFlujo);
       // echo $Consulta."<br><br>";      
        while ($FilaFlujo = mysqli_fetch_array($Resp)) // WHILE 1
		{
			$cod_flujo = $FilaFlujo["cod_flujo"];
			$PesoFlujo = 0;
			$ley_as = 0;
            $ley_s = 0;
			$Codigos = array('08'=>0, '26'=>0);
            $Pesos = array('08'=>0, '26'=>0);

          //  echo " CODIGO FLUJO ".$FilaFlujo["cod_flujo"].'<br>';
			
			$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
			$Consulta.= " sum(t1.peso) AS peso_hornada";
			$Consulta.= " FROM sea_web.movimientos AS t1";
			$Consulta.= " WHERE t1.flujo = '".$FilaFlujo["cod_flujo"]."'";
			$Consulta.= " AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora' ";
			$Consulta.= " GROUP BY t1.hornada";
            $Resp7 = mysqli_query($link, $Consulta);//$PesoFlujoPisoTot=0;
			echo $Consulta."<br><br>";    

			while ($FilaHornada = mysqli_fetch_array($Resp7))		
			{

			   echo "produ: ".$FilaHornada["cod_producto"]."<br><br>";
		       echo "subpro: ".$FilaHornada["cod_subproducto"]."<br><br>";
               echo "hornada: ".$FilaHornada["hornada"]."<br><br>"; 

                $PesoFlujo = $PesoFlujo + $FilaHornada["peso_hornada"]; 
                echo "PesoFlujo ".$PesoFlujo."<br>";

               // saca las leyes por hornada
				$Consulta = "select * from sea_web.leyes_por_hornada ";
				$Consulta.= " where cod_producto='".$FilaHornada["cod_producto"]."' ";
				$Consulta.= " and cod_subproducto='".$FilaHornada["cod_subproducto"]."' ";
				$Consulta.= " and hornada='".$FilaHornada["hornada"]."'";
				$Consulta.= " and cod_leyes in('08','26')";
				$RespLeyes = mysqli_query($link, $Consulta);
				echo $Consulta."<br><br>";  

				while ($FilaLeyes = mysqli_fetch_array($RespLeyes))  //recorre las leyes de As y S por hornada
	            {
		          // guardo la ley
		          echo "hornada: ".$FilaHornada["hornada"]."<br>";
			      echo "leyes: ". $FilaLeyes["cod_leyes"]."<br>"; 
	              $Codigos[$FilaLeyes["cod_leyes"]] = $Codigos[$FilaLeyes["cod_leyes"]] + ($FilaHornada["peso_hornada"] * $FilaLeyes["valor"] );					
	              $Pesos[$FilaLeyes["cod_leyes"]] = $Pesos[$FilaLeyes["cod_leyes"]] + ($FilaHornada["peso_hornada"]);
			
	            } //
               
			 
			 }  

			   If ($PesoFlujo == 0 )
			   {
			   	// echo "ENTRO AL IF ".$PseoFlujo."<br>";

			   	$ley_as = 0;
			   	$ley_s = 0;
			   	
			   }

			   else
			   {

			 //      echo " PESOS 08 : ".$Pesos["08"]."<br>";
             //      echo " PESOS 26 : ".$Pesos["26"]."<br>";

              //     echo " Codigo 08 : ".$Codigos["08"]."<br>";
              //     echo " Codigo 26 : ".$Codigos["26"]."<br>";

				  If ($Pesos["08"] > 0 && $Codigos["08"]>0 )
                  // $ley_as = number_format(($Codigos["08"]/$Pesos["08"]) ,0,",","");
                   $ley_as = ($Codigos["08"]/$Pesos["08"]);

                  If ($Pesos["26"] > 0  && $Codigos["26"]>0)
                  //  $ley_s = number_format(($Codigos["26"]/$Pesos["26"]) ,0,",","");

                     $ley_s = ($Codigos["26"]/$Pesos["26"]);
                 
                }

                  // insertar los flujos
                $insertar = "INSERT INTO sea_web.flujos_anodos (fecha,cod_flujo,peso_ton,ley_as,ley_s)";
		        $insertar.= " VALUES('".$fecha_ini."',".$cod_flujo.",".$PesoFlujo.",".$ley_as.",".$ley_s.")";
		        mysqli_query($link, $insertar);
		        //echo $insertar."<br><br>";


		}   
	
?>	

  </tr>
</table>
<br>

</body>
<script language="javascript"> 
cerrar_sin(); 
</script>

</html>
<?php include("../principal/cerrar_sea_web.php") ?>
