<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project PHP Server-Side dan API</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Calista</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">HandsOn 3</a>
                    </li>
                </ul>
                <?php
                if (!isset($_SESSION['username'])) {
                    echo '<a href="../auth/login.php" class="btn btn-primary">Sign In</a>';
                } else {
                    echo '<a href="../auth/logout.php" class="btn btn-primary">Sign Out</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-5">
            <h1>Data dari Dataset Movies Table</h1>
            <a href="add.php" class="btn btn-primary">Add Data</a>
        </div>
        <table id="my-table" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Overview</th>
                    <th>Release Date</th>
                    <th>Popularity</th>
                    <th>Vote Average</th>
                    <th>Vote Count</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        function deleteData(id) {
            $.ajax({
                url: "api/delete.php",
                type: "DELETE",
                data: JSON.stringify({
                    id: id
                }),
                success: function(data) {
                    alert('Data berhasil dihapus');
                    location.reload();
                }
            });
        }

        $(document).ready(function() {
            $table = $('#my-table').DataTable({
                "processing": true,
                "serverSide": true,
                "orderable": false,
                "ajax": {
                    "url": "api/get.php",
                    "type": "POST"
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "overview"
                    },
                    {
                        "data": "release_date"
                    },
                    {
                        "data": "popularity"
                    },
                    {
                        "data": "vote_average"
                    },
                    {
                        "data": "vote_count"
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            // return '<a href="edit.php?id=' + row.id + '">Edit</a> | <a href="delete.php?id=' + row.id + '">Delete</a>';
                            return `
                            <div class="d-flex gap-2">
                                <a href="edit.php?id=${row.id}" class="btn btn-sm btn-info">Edit</a>
                                <a href="javascript:void(0);" onClick="confirm('Apakah anda yakin ingin menghapus data ini?') ? deleteData(${row.id}) : ''" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                            `
                        }
                    }
                ],
            });
        });
    </script>
</body>

</html>
