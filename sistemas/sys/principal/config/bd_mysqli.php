<?php

class MySQL{
 private $conexion;
 private $total_consultas;
 
	public function MySQL($HostName,$dbName,$UserMysql,$PassMysql){

		/*$Host     = "localhost" ;
		$Database = "centrodeestudios_kimen" ;
		$User     = "centrodeestudios" ;
		$Password = "7unSst@r4amF9Jdi" ;	*/

		$Host     = $HostName ;
		$Database = $dbName ;
		$User     = $UserMysql;
		$Password = $PassMysql ;	


		$this->mysqli = new mysqli($Host, $User, $Password, $Database);
		if ($this->mysqli->connect_errno) {
		    echo "Fallo al conectar a MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
		}

	}
	public function consulta($consulta){
	  $this->total_consultas++;
	  $resultado = mysqli_query($this->mysqli,$consulta);
	  if(!$resultado){
	  echo 'MySQL Error: ' . mysqli_error($this->mysqli);
	  exit;
	  }
	  return $resultado; 
	}
	public function QueryAction($Query)
	{
	  $error = '';
	  $resultado = mysqli_query($this->mysqli,$Query);
	  if(!$resultado){
	  	$error = 'MySQL Error: ' .mysqli_error($this->mysqli);
	  }
	  return $error;		
	}
	public function ultimoIdInsertado($Query){
		return mysqli_insert_id($Query);
	}
	public function fetch_array($consulta){ 
	  return mysqli_fetch_array($consulta);
	}
	public function num_rows($consulta){ 
	  return mysqli_num_rows($consulta);
	}
	public function getTotalConsultas(){
	  return $this->total_consultas;
	}
}
?>