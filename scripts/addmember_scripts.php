<?php
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$output = shell_exec("python save_user.py $name");

echo "<div class='alert alert-success' role='alert'>" . $output . "</div>";
echo "<meta http-equiv='refresh' content='3;url=index.php' />";

?>