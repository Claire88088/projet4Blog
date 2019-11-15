<!DOCTYPE html>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="fr">

<head>
  <title>
    <?= isset($title) ? $title : 'Blog' ?>
  </title>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/css/main.css" type="text/css" />
</head>



<body class="is-preload">
  <div id="wrapper">

    <!-- Header -->
    <header id="header">
      <h1><a href="/">Blog de écrivain</a></h1>
      <nav class="links">
        <ul>
          <li><a href="/">Accueil</a></li>
          <?php if ($user->isAuthenticated()) { ?>
            <li><a href="/admin/">Admin</a></li>
            <li><a href="/admin/news-insert.html">Ajouter une news</a></li>
          <?php } ?>
        </ul>
      </nav>
      <nav class="main">
        <ul>
          <li class="search">
            <a class="fa-search" href="#search">Search</a>
            <form id="search" method="get" action="#">
              <input type="text" name="query" placeholder="Search" />
            </form>
          </li>
          <li class="menu">
            <a class="fa-bars" href="#menu">Menu</a>
          </li>
        </ul>
      </nav>
    </header>

    <!-- Menu -->
    <section id="menu">

      <!-- Search -->
      <section>
        <form class="search" method="get" action="#">
          <input type="text" name="query" placeholder="Search" />
        </form>
      </section>

      <!-- Links -->
      <section>
        <ul class="links">
          <li>
            <a href="/">
              <h3>Accueil</h3>
              <p>Bienvenue sur mon blog</p>
            </a>
          </li>
          <?php if ($user->isAuthenticated()) { ?>
          <li>
            <a href="/admin/">
              <h3>Accueil de l'administration du site</h3>
              <p>Administration du blog</p>
            </a>
          </li>
          <li>
            <a href="/admin/news-insert.html">
              <h3>Ajouter une news</h3>
              <p>No comment</p>
            </a>
          </li>
          <?php } ?>
        </ul>
      </section>

      <!-- Actions -->
      <section>
        <ul class="actions stacked">
          <li><a href="/admin/" class="button large fit">Accès à l'administration</a></li>
        </ul>
      </section>

    </section>

    <!-- Main -->
    <div id="main">
      <section id="main">
        <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>

        <?= $content ?>
      </section>

      <!-- Pagination -->
      <ul class="actions pagination">
        <li><a href="" class="disabled button large previous">Page précédente</a></li>
        <li><a href="#" class="button large next">Page suivante</a></li>
      </ul>
    </div>
  </div>

  <!-- Scripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/browser.min.js"></script>
  <script src="js/breakpoints.min.js"></script>
  <script src="js/util.js"></script>
  <script src="js/main.js"></script>
</body>

</html>