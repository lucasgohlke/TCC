<?php
header('Content-Type: application/json; charset=utf-8');

$response = array();
$response ["erro"] = true;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    include 'dbConnection.php';

    $conn = new mysqli($HostName, $HostUser,
    	 $HostPass, $DatabaseName);
    	 
    mysqli_set_charset($conn, "utf8");

    if ($conn->connect_error) { // Será que é uma boa?

         die("Ops, falhou....: " . $conn->connect_error);
    }

	$login = "'".$_POST['login']."'";
	$senha = "'".$_POST['senha']."'";

    $sql = "SELECT * FROM usuario WHERE login = $login
		AND senha = $senha";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

	$registro = mysqli_fetch_array($result);

        $response["registro"] = $result->num_rows;
	$response["erro"] = false;
	$response["login"] = $registro['login'];
	$response["senha"] = $registro['senha'];
	$response["perfil"] = $registro['fk_id_perfil'];
	$response["datainc"] = $registro['datainc'];
        
    } else {
    
        $response["mensagem"] = "Dados incorretos. Tente novamente!";
    }
    

    $conn->close();
}
echo json_encode($response);    
?>