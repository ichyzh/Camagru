<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="#" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--w3-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!--style-->
    <link rel="stylesheet" href="/<?php echo ROOT ?>/public/css/index.css">
    <link rel="stylesheet" href="/<?php echo ROOT ?>/public/css/reset.css">
    <!--font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <!--icons-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">




    <title><?=$title?></title>
</head>
<body>
<div class="container nav-mar">
    <nav class="navbar fixed-top navbar-expand-sm navbar-light bg-light">
        <div class="container navb ">
            <a class="navbar-brand" href="http://localhost:8100/camaphp/">OTLICHNIY SITE</a>
            <div id="c">
                <ul class="navbar-nav" style="width: 100%">
                    <?php if($logged['is_logged']): ?>
                        <li class="nav-item m-auto">
                            <a class="nav-link" href="http://localhost:8100/camaphp/create_photo">Create Photo</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ml-auto">
                            <p class="nav-link" id="logbtn" onclick="logining();">Login</p>
                        </li>
                        <li class="nav-item">
                            <p class="nav-link" id="regbtn" onclick="registration();">Registration</p>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php if($logged['is_logged']): ?>
            <div class="dropdown" onclick="drop();">
                <div class="usrimgp dropbtn" id="dropacc" style="background-image: url(/camaphp/<?php echo $_COOKIE['avatar'] ?>);"></div>
                <div class="dropdown-content w3-animate-top hidden" id="drop_cont">
                    <a href="http://localhost:8100/camaphp/profile/<?php echo $_COOKIE['login'] ?>" class="accdrop">My Profile</a>
                    <a href="http://localhost:8100/camaphp/logout" class="accdrop">Log out</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </nav>
</div>

<?php echo $content ?>

<div class="footer reset-footer">This footer will always be positioned at the bottom of the page, but <strong>not fixed</strong>.</div>

</body>
</html>
