<?php
// required headers
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: application/json;");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../common/dbcon.php");
$id = '';
$data = [];

$username = '';
$password = '';

//if (isset($_POST['username'])) {
//    $username = $_POST['username'];
//}
//
//if (isset($_POST['password'])) {
//    $password = $_POST['password'];
//}

$datax =file_get_contents("php://input"); // cannot us with form-data
//echo json_encode($datax);return;

$data_back = json_decode($datax);

echo json_encode($_POST);return;
//if (isset($_SERVER['CONTENT_TYPE'])
//    && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false
//) {
//    echo "ok";return;
//    $jsonEncoded = file_get_contents('php://input');
//    $jsonDecoded = json_decode($jsonEncoded, true);
//    if (is_array($jsonDecoded)) {
//        foreach ($jsonDecoded as $varName => $varValue) {
//            $_POST[$varName] = $varValue;
//        }
//    }
//}


if ($username != '') {
    echo json_encode($data);
//    $query = "SELECT * FROM patient_record WHERE patient_id='$id' ";
//    $statement = $connect->prepare($query);
//    $statement->execute();
//    $result = $statement->fetchAll();
//
//    $filtered_rows = $statement->rowCount();
//    foreach ($result as $row) {
//    }
}

//	$request_method=$_SERVER["REQUEST_METHOD"];
//    echo json_encode(['type'=>$request_method]);
//
//	switch($request_method)
//    {
//
//        case 'POST':
//            // Insert Product
//            login($connect);
//            break;
//        default:
//            // Invalid Request Method
//            header("HTTP/1.0 405 Method Not Allowed");
//            break;
//    }
//	function login($connect)
//    {
//        $username = $_POST['username'];
//        echo $username;return;
//        if($username!=''){
//            $query="SELECT * FROM user WHERE username='$username'";
//
//            $response=array();
//            $result=mysqli_query($connect, $query);
//            while($row=mysqli_fetch_array($result))
//            {
//                $response[]=$row;
//            }
//            header('Content-Type: application/json');
//            echo json_encode($response);
//        }
//
//    }

	// Close database connection
	//mysqli_close($connection);
