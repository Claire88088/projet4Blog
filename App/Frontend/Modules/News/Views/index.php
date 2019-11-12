<?php
foreach ($listeNews as $news)
{
?>
    <!-- Post -->
    <article class="post">
    <header>
      <div class="title">
        <h2><a href="single.html"><?= $news['titre'] ?></a></h2>
        <p></p>
      </div>
      <div class="meta">
        <time class="published" datetime="2015-11-01">Le <?= $news['dateAjout']->format('d/m/Y à H\hi') ?></time>
      </div>
    </header>

    <p><?= nl2br($news['contenu']) ?></p>
    
    <footer>
      <ul class="actions">
        <li><a href="single.html" class="button large">Lire la suite...</a></li>
      </ul>
    </footer>
  </article>
<?php
}