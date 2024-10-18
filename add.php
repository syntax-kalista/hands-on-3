<?php

include 'includes/db_config.php';

if (isset($_POST['create'])) {
    // using api add to add data
    $title = $_POST['title'];
    $overview = $_POST['overview'];
    $release_date = $_POST['release_date'];
    $popularity = $_POST['popularity'];
    $vote_average = $_POST['vote_average'];
    $vote_count = $_POST['vote_count'];

    $curl = curl_init();
    // post data to localhost/pwb-dua/api/add.php
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost/pwb-dua/api/add.php",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'title' => $title,
            'overview' => $overview,
            'release_date' => $release_date,
            'popularity' => $popularity,
            'vote_average' => $vote_average,
            'vote_count' => $vote_count
        ]),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    if (json_decode($response)->code == 200) {
        echo "<script>alert('Data added successfully!')</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Failed to add data!')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-3">Create Data</h1>
        <div class="card">
            <div class="card-header">
                Create Data
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="overview" class="form-label">Overview</label>
                        <input type="text" class="form-control" id="overview" name="overview">
                    </div>
                    <div class="mb-3">
                        <label for="release_date" class="form-label">Release Date</label>
                        <input type="date" class="form-control" id="release_date" name="release_date">
                    </div>
                    <div class="mb-3">
                        <label for="popularity" class="form-label">Popularity</label>
                        <input type="number" class="form-control" id="popularity" name="popularity">
                    </div>
                    <div class="mb-3">
                        <label for="vote_average" class="form-label">Vote Average</label>
                        <input type="number" class="form-control" id="vote_average" name="vote_average">
                    </div>
                    <div class="mb-3">
                        <label for="vote_count" class="form-label">Vote Count</label>
                        <input type="number" class="form-control" id="vote_count" name="vote_count">
                    </div>
                    <button type="submit" class="btn btn-primary" name="create">Create</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
