<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?= $titre ?>
    </title>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/bootstrap.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#"><small><?= $titre; ?></small></a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../controller/create.php">Create</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../controller/list.php">List</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END NAVBAR -->
    <p></p>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-secondary">
                    <?= $titre; ?>
                </h4>
                <br>
                <!-- ERRORS -->
                <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $key => $error) :
                        echo "<h5 class='text-center text-black'>•  $error</h5>";
                    endforeach; ?>
                </div>
                <br>
                <?php endif; ?>
                <!-- END ERRORS -->
                <?= $content; ?>
            </div>
        </div>
    </div>

    <!-- SCRIPT / JAVASCRIPT -->
    <script src="../assets/jquery.js"></script>
    <script src="../assets/popper.js"></script>
    <script src="../assets/bootstrap.js"></script>
    <!-- END SCRIPT / JAVASCRIPT -->
</body>

</html>