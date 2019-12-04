<section class=".row.aln-left">
  <h2>Liste des épisodes :</h2>
  <p>Il y a actuellement <?= $newsNumber ?> épisodes de publiés.</p>

  <table>
    <tr><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
  <?php
  foreach ($newsList as $news)
  {
    echo '<tr><td>', $news['title'], '</td><td>le ', $news['creationDate']->format('d/m/Y à H\hi'), '</td><td>', ($news['creationDate'] == $news['updateDate'] ? '-' : 'le '.$news['updateDate']->format('d/m/Y à H\hi')), '</td><td><a href="news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
  }
  ?>
  </table>
</section>

<section class=".row.aln-left">
  <h2>Liste des commentaires signalés :</h2>
  <p>Il y a actuellement <?= $reportedCommentsNumber ?> commentaire(s) signalé(s).</p>

  <table>
    <tr><th>Auteur</th><th>Date d'ajout</th><th>Action</th></tr>
  <?php
  foreach ($reportedCommentsList as $reportedComment)
  {
    echo '<tr><td>', $reportedComment['author'], '</td><td>le ', $reportedComment['creationDate']->format('d/m/Y à H\hi'), '</td><td><a href="comment-moderate-' , $reportedComment['id'], '.html">modérer</a> <a href="comment-delete-', $reportedComment['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
  }
  ?>
  </table>
</section>

