<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Class List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic-icons.css">
</head>

<body>
<nav></nav>
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <div class="container-fluid"><a class="navbar-brand" href="index.php">Home</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link " href="classlist.php">Class List</a></li>
                <li class="nav-item"><a class="nav-link active" href="attendance.php">Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="notes.php">Notes</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container py-4 py-xl-5">
    <div class="row mb-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
            <h2>Attendance</h2>
            <p>Mark students abscent or present for the class</p>
        </div>
    </div>
    <div class="input-group w-50">
        <div class="input-group-prepend">
            <span class="input-group-text">Lesson Name</span>
        </div>
        <input type="text" id= "studentNameInput" class="form-control" placeholder="Type lesson name here e.g WK5L3" aria-label="Username" aria-describedby="basic-addon1">

        <button type="button" class="btn btn-success" onclick="addStudent()"> Add Lesson </button>
    </div>



    <script>
        function addStudent() {

            var studentName = document.getElementById('studentNameInput').value;


            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'class_operations.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    // Handle the response
                    if (xhr.status === 200) {

                        var response = JSON.parse(xhr.responseText);
                        location.reload()

                        if (response.error) {
                            console.error(response.error);
                        } else {

                            console.log(response.message);
                        }
                    } else {

                        console.error('Request failed with status: ' + xhr.status);
                    }
                }
            };

            xhr.send('action=addstudent&studentName=' + encodeURIComponent(studentName));
        }
    </script>




    <br>
    <?php

    require_once 'dbconnection.php';
    require_once 'class_operations.php';

    $classOperations = new ClassOperations($conn);

    $studentRecords = $classOperations->getAllStudentsRecords();
    ?>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <?php
            // Output table header with column names
            foreach (array_keys($studentRecords[0]) as $columnName) {
                echo '<th scope="col">' . $columnName . '</th>';
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($studentRecords as $index => $record) {
            echo '<tr>';
            echo '<th scope="row">' . ($index + 1) . '</th>';

            // Output table data dynamically based on column names
            foreach ($record as $value) {
                echo '<td>' . $value . '</td>';
            }

            echo '</tr>';
        }
        ?>
        </tbody>
    </table>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>