<?php
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$output = exec("python save_user_test.py $name");

echo "<div class='alert alert-success' role='alert'>" . $output[1] . "</div>";
echo "<meta http-equiv='refresh' content='3;url=index.php' />";

?>