<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>

<table>
  <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
<?php
foreach ($listeNews as $news)
{
  echo '<tr><td>', $news['author'], '</td><td>', $news['title'], '</td><td>le ', $news['creationDate']->format('d/m/Y à H\hi'), '</td><td>', ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le '.$news['dateModif']->format('d/m/Y à H\hi')), '</td><td><a href="news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
}
?>
</table>

<p style="text-align: center">Il y a actuellement <?= $numberReportedComments ?> commentaires signalés. En voici la liste :</p>

<table>
  <tr><th>Auteur</th><th>Date d'ajout</th><th>Action</th></tr>
<?php
foreach ($listeReportedComments as $reportedComment)
{
  echo '<tr><td>', $reportedComment['author'], '</td><td>le ', $reportedComment['creationDate']->format('d/m/Y à H\hi'), '</td><td><a href="comment-moderate-' , $reportedComment['id'], '.html">modérer</a> <a href="comment-delete-', $reportedComment['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
}
?>
</table>