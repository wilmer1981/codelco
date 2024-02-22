<?php
//header("Content-Type:application/json");
include("../bd_mysqli.php");
include("../functions.php");

//PROCESS CLIENT REQUEST (via url)
if($_SERVER["REQUEST_METHOD"] == 'GET')
{
  $method = $_GET["method"];
  switch($method)
  {
      case "sa_buscar":
        if(isset($_GET["numero_sa"]))
          echo json_encode(sa_buscar($_GET["numero_sa"]));
        else
        {
          response(400,"Bad Request",null);
        }
      break;
      case "sa_crear":
      break;
      case "sa_estados":
      break;
      case "sa_leyes":
      break;
      default:
        response(405,"Method Not Allowed",null);
      break;
  }
}
else if($_SERVER["REQUEST_METHOD"] == 'POST')
{
  $method = $_POST["method"];
  switch($method)
  {
      case "sa_buscar":
        if(isset($_POST["numero_sa"]))
          echo json_encode(sa_buscar($_POST["numero_sa"]));
        else
        {
          response(400,"Bad Request",null);
        }
      break;
      case "sa_crear":
      break;
      case "sa_estados":
      break;
      case "sa_leyes":
      break;
      default:
         response(405,"Method Not Allowed",null);
      break;
  }

}
else
     response(405,"Method Not Allowed",null);

function response($status,$status_message,$data)
{
  header("HTTP:/1.1 $status $status_message");

  $response['status'] = $status;
  $response['status_message'] = $status_message;
  $response['data'] = $data;

  $json_response = json_encode($response);
  echo $json_response;
}
?>