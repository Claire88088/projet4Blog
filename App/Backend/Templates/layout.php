<!DOCTYPE html>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="fr">

<head>
  <title>
    <?= isset($title) ? $title : 'Blog Admin' ?>
  </title>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="/css/main.css" type="text/css" />
</head>



<body class="is-preload">
  <div id="wrapper">

    <!-- Header -->
    <header id="header">
      <h1><a href="/">Zone admin</a></h1>
      
    </header>


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