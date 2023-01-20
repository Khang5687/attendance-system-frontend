<?php
require 'common.php';

//Grab all the users from our database
$members = $database->select("members", [
    'id',
    'name',
    'rfid_uid',
    "membership_expiry",
]);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Imaginery Gym Check-in</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>

    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="/attendance">Imaginery Gym Check-in System</a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="attendance.php" class="nav-link">View Attendance</a>
            </li>
            <li class="nav-item">
                <a href="members.php" class="nav-link active">View Members</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div class="row">
            <h2>Members</h2>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">RFID UID</th>
                    <th scope="col">Membership Expiration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Loop through and list all the information of each user including their RFID UID
                foreach($members as $member) {
                    echo '<tr>';
                    echo '<td scope="row">' . $member['id'] . '</td>';
                    echo '<td>' . $member['name'] . '</td>';
                    echo '<td>' . $member['rfid_uid'] . '</td>';
                    echo '<td>' . $member['membership_expiry'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</html>