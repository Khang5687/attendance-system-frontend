<?php
require 'common.php';
require_once realpath(__DIR__ . '/vendor/autoload.php');
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
                <a href="members.php" class="nav-link">View Members</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h1 class="mb-3">Hello,</h1>
        <h3 class="mb-3">
            Enter your name to register.
        </h3>
        <form>
            <div class="form-group">
                <input style="min-width:50px;max-width:100px;" type="text" class="form-control" id="nameInput" onkeydown="if (event.keyCode == 13) { register(); return false}" placeholder="Name...">
            </div>
            <button type="button" class="btn btn-primary" onclick="register()">Register</button>
        </form>

        <label for="name"></label>
        <!-- The notification bar -->
        <div id="output"></div>

        <script>
            function register() {
                var name = document.getElementById("nameInput").value;
                if (!name) {
                    document.getElementById("output").innerHTML = "<div class='alert alert-danger' role='alert'>No name entered</div>";
                    return;
                }
                
                if (!name.match(/^[a-zA-Z\s]+$/)) {
                    document.getElementById("output").innerHTML = "<div class='alert alert-danger' role='alert'>Invalid characters found in the name</div>";
                    return;
                }
                console.log(JSON.stringify({
                    name: name
                }));
                fetch('scripts/addmember_scripts.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            name: name
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.text();
                        } else {
                            throw new Error('Error: ' + response.statusText);
                        }
                    })
                    .then(data => {
                        // Display the output from the PHP script in a div with id "output"
                        document.getElementById("output").innerHTML = data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
                document.getElementById("output").innerHTML = "<div class='alert alert-info' role='alert'>Tap your card</div>";
            }
        </script>
    </div>


</body>

</html>