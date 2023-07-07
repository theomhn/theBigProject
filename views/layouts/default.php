<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="<?= APP; ?>">
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="...">

    <!-- SEO -->
    <meta name="keywords" content="Portfolio">
    <meta name="author" content="Theo Menchon">
    <meta name="copyright" content="© <?php echo date('Y'); ?> Theo MENCHON, Tous droits réservés.">

    <!-- Localisation -->
    <meta name="location" content="Montpellier, France">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="public/favicon/favicon-16x16.png">
    <link rel="manifest" href="public/favicon/site.webmanifest">
    <link rel="mask-icon" href="public/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Liens CSS -->
    <link rel="stylesheet" href="public/css/base.css">
    <link rel="stylesheet" href="public/css/menu.css">
    <link rel="stylesheet" href="public/css/footer.css">

    <!-- CSS dynamique -->
    <?php if (!empty($styles)) : ?>
        <?php foreach ($styles as $style) : ?>
            <link rel="stylesheet" href="public/css/<?= $style ?>.css">
        <?php endforeach; ?>
    <?php endif; ?>

    <title>TheBigProject</title>
</head>

<body>
    <header>
        <a href="/" class="logo">TheBig<span>Project</span></a>
        <div class="btnHeader" onclick="toggleMenu();">
            <div class="ligne"></div>
        </div>
        <ul class="menu">
            <li style="--i:1;"><a href="./" class="allLinks" onclick="toggleMenu();">
                    <i class="fas fa-home"></i> Home</a></li>
            <?php if (USER !== false) {
            ?>
                <li style="--i:2;"><a href="les-tournois" class="allLinks" onclick="toggleMenu();">
                        <i class="fa-solid fa-gamepad"></i> Les tournois</a></li>
                <li style="--i:3;"><a class="allLinks" onclick="toggleMenu();">
                        <i class="fa-solid fa-user"></i> Bonjour, <?= USER['pseudo']; ?></a></li>
                <li style="--i:4;"><a href="" class="allLinks" onclick="toggleMenu();" onmousedown="logout();">
                        <i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a></li>
            <?php
            } else {
            ?>
                <li style="--i:3;"><a href="connexion" class="allLinks" onclick="toggleMenu();">
                        <i class="fa-solid fa-user"></i> Connexion</a></li>
            <?php
            } ?>
            <li class="dark-mode-box">
                <input type="checkbox" class="dark-mode" id="dark-mode">
                <label for="dark-mode" class="label">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                    <span class="ball"></span>
                </label>
            </li>

        </ul>
    </header>

    <main>
        <?= $content ?>
    </main>

    <!-- DEBUT Footer (Bas de Page)-->
    <footer>
        <div class="container">
            <ul class="social-links">
                <li>
                    <a href="https://www.linkedin.com/in/theomenchon/" target="_blank"><i class="fa fa-linkedin"></i>
                    </a>
                </li>
                <li>
                    <a href="https://github.com/theomhn/theBigProject" target="_blank"><i class="fa-brands fa-github"></i>
                    </a>
                </li>
                <li>
                    <a href="mailto:theo.menchon@hotmail.fr"><i class="fa-regular fa-envelope"></i>
                    </a>
                </li>
            </ul>
            <p class="copyright">&copy;
                <?php echo date('Y'); ?>
                Theo MENCHON, Tous droits réservés.
            </p>
        </div>

    </footer>
    <!-- Responsive Menu -->
    <script src="public/script/responsiveMenu.js"></script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/263a91419d.js" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"></script>
    <script>
        async function logout() {
            const response = await fetch('ws/logout');
        }
    </script>
    <!-- Scripts dynamique si besoin -->
    <?php if (!empty($scripts)) : ?>
        <?php foreach ($scripts as $script) : ?>
            <script src="public/scripts/<?= $script ?>.js"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>