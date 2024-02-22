<?php

class Mysql{
 
  protected $Dbname,$userMysql,$passMysql,$Mysql;

  public function __construct($dbName,$UserMysql,$PassMysql)
  {
      $this->userMysql  = $UserMysql;  
      $this->passMysql  = $PassMysql;
      $this->Dbname     = $dbName;

    try {

            $urlMysql = "mysql:host=".$this->Server.";dbname=".$this->Dbname;

        //echo $urlMysql."<br>";
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::ATTR_PERSISTENT => true);
        $this->Mysql = new PDO($urlMysql,  $this->userMysql,  $this->passMysql , $options);
        $this->Mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      

    } catch (PDOException $e) {
        echo "¡Mysql Error!: " . $e->getMessage() . "<br/>";
    }      
  }

  protected function iniciar()
  {
      //iniciar la transaccion mysql y php
      $this->Mysql->beginTransaction();    
  }
  protected function finalizar()
  {
      $this->Mysql->commit();
  }
  protected function Preparar($Query,$Arreglo)
  {
      $Return["query"] = $Query;
      $Return["error"] = '';
      $query = $this->Mysql->prepare($Query);
      if (!$query) {
          $Return["error"] = $this->Mysql->errorInfo();
      }      
      else
      {
        if(count($Arreglo) > 0 && $Arreglo != '')
            $query->execute($Arreglo);
        else
            $query->execute();
      }
      return $query;
  }

  public function ConsultasMysql($Query,$Params)
  {
      $this->iniciar();
      $query = $this->Preparar($Query,$Params);      
      $rowConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->finalizar();

      return $rowConsulta;
  }

  public function InsertarUpdateMysql($Query,$Params)
  {
      $this->iniciar();
      $_insert = $this->Preparar($Query,$Params);      
      //$id = $_insert->Mysql->lastInsertId();
      //echo $id;
      $this->finalizar();

      //return $Retorno;
  }

  public function ConsultoCampoMysql($Query,$Params)
  {
      $this->iniciar();
      $this->Preparar($Query,$Params);
      $NumberofRow = $this->fetchColumn();
      return $NumberofRow;
  }

}



class Sql{
 
  protected $userSql,$passSql,$Sql;
  var $Dbname;

  public function __construct($dbName,$UserSql,$PassSql)
  {
      $this->userSql  = $UserSql;
      $this->passSql  = $PassSql;
      $this->Dbname   = $dbName;

    try {

        $env = strtoupper(getenv("ENVIRONMENT_TYPE"));
        switch ($env) 
        {
          case "DESA":
              $sqlDbServer = "DB_COCHA3-DESA;Database=".$this->Dbname;
              break;
          case "QA":
              $sqlDbServer = "DB_COCHA3-DESA;Database=".$this->Dbname;
              break;
          case "PROD":
              $sqlDbServer = "DB_COCHA3;Database=".$this->Dbname;
              break;
           default:
              $sqlDbServer = "DB_COCHA3-DESA;Database=".$this->Dbname;
              break;
        }

        //$options = array(PDO::ATTR_PERSISTENT => true);
        $this->Sql = new PDO("dblib:host=".$sqlDbServer,  $this->userSql,  $this->passSql);// , $options
        //$this->Sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      

    } catch (Exception $e) {
        echo "¡Sql Error!: " . $e->getMessage() . "<br/>";
    }      
  }
  protected function iniciar()
  {
      $this->Sql->beginTransaction();    
  }
  protected function finalizar()
  {
      $this->Sql->commit();
  }
  protected function Preparar($Query,$Arreglo)
  {
      $Return["query"] = $Query;
      $query = $this->Sql->prepare($Query);
      if (!$query) {
          $Return["error"] = $this->Sql->errorInfo();
      }      
      else
      {
        if(count($Arreglo) > 0 && $Arreglo != '')
            $query->execute($Arreglo);
        else
            $query->execute();
        $Return["error"] = "";
      }

      return $query;
  }

  public function ConsultasSql($Query,$Params)
  {
      $this->iniciar();
      $query = $this->Preparar($Query,$Params);      
      $rowConsulta = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->finalizar();

      return $rowConsulta;
  }

  public function InsertarSql($Query,$Params)
  {
      $this->iniciar();
      $_insert = $this->Preparar($Query,$Params);      
      $this->finalizar();

      //return $_insert;
  }

}

?>
