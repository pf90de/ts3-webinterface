<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>TeamSpeak Webinterface | netzhost24.de</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <script type="text/javascript">
		function myFunction() {
			var x = document.getElementById("edit_password");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
	</script>

    <link href="css/custom.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <?php

        #REQUIREMENTS/INCLUDES
        date_default_timezone_set("Europe/Berlin"); // Timezone
        require("lib/ts3admin.class.php"); // TS3 PHP Library
        
        #INITIALIZE VARS
        ob_start();
        session_start();
        $site = $_GET["site"];

        if($_SESSION['loggedin'] == 1) {
            $tsAdmin = new ts3admin($_SESSION['ts3ip'], $_SESSION['ts3queryport']);
            $tsAdmin->connect();
            $tsAdmin->login($_SESSION['username'],$_SESSION['password']);
        }
        
    ?>

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">netzhost24.de</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?site=home">Home</a>
                </li>
                <?php
				if($_SESSION['loggedin'] == 1) {
				?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?site=instanz">Instanz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?site=server">Serverliste</a>
                    </li>
                    <?php
                    if(isset($_SESSION['vserver_port'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?site=vserver">vServer (#<?php echo $_SESSION['vserver_id']; ?> - P: <?php echo $_SESSION['vserver_port']; ?>)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?site=viewer">Viewer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?site=token">Token</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?site=banlist">Bans</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Gruppen
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php?site=servergroups">Server</a></li>
                                <li><a class="dropdown-item" href="index.php?site=channelgroups">Channel</a></li>
                            </ul>
                        </li>
                <?php
                    }
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?site=imprint">Impressum</a>
                </li>
                </ul>
                <?php
					if($_SESSION['loggedin'] == 1) {
				?>
                    <form class="d-flex">
                        <button type="button" class="btn btn-primary" onClick="window.location.href=window.location.href;"><i class="bi bi-arrow-repeat"></i></button>&nbsp;
                        <a class="btn btn-primary" href="index.php?site=logout" role="button">Logout</a>
                    </form>
                <?php
                    }
                ?>
            </div>
            </div>
        </nav>
    </header>

    <!-- Begin page content -->
    <main>
        <div class="container bg-light rounded">

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>

            <?php
                if(isset($site) && file_exists($site.".php")) {
                    include($site.".php");
                } elseif($site == "") {
                    $site = "home";
                    include($site.".php");
                } else {
                    $site = "error";
                    include($site.".php");
                }
                if($_SESSION['loggedin'] == 1) {
                    $version = $tsAdmin->version();
                    ?>
                    <div class="bg-light p-3 rounded">
                    <?php
                        echo "Teamspeak Server Version ".$version['data']['version']." (Build: ".$version['data']['build'].") unter ".$version['data']['platform'];
                    ?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">Built with Bootstrap 5 - &copy; <?php echo date("Y"); ?> - netzhost24.de <i class="bi bi-heart-fill"></i></span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>