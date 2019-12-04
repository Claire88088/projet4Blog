<p>Le <?= $news['creationDate']->format('d/m/Y à H\hi') ?></p>
<h2><?= $news['title'] ?></h2>
<p><?= nl2br($news['content']) ?></p>

<?php if ($news['creationDate'] != $news['updateDate']) { ?>
  <p style="text-align: right;"><small><em>Modifié le <?= $news['updateDate']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>

<?php
if (empty($comments))
{
?>
<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php
}

foreach ($comments as $comment)
{
?>
<fieldset>
  <legend>
    Posté par <strong><?= $comment['author'] ?></strong> le <?= $comment['creationDate']->format('d/m/Y à H\hi') ?> 
    
    <?php if ($comment['isReported'] === '1') { ?>
      - <em>Commentaire signalé</em>
    <?php 
    }
    else 
    { 
      if (!isset($comment['moderationDate'])) {
    ?>
      - <a href="/signaler-<?= $comment['id'] ?>-news-<?= $news['id'] ?>.html">Signaler</a>
    <?php 
      }
    } 
    ?>
    <?php if ($user->isAuthenticated()) { ?>
      | <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
      <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
    <?php } ?>
  </legend>
  
  <?php 
  if (isset($comment['moderationDate'])) { ?>
    <p><em>Commentaire modéré</em></p>
  <?php  } 
  else { 
  ?>
    <p><?= nl2br($comment['content']) ?></p>
  <?php
  }
  ?>
</fieldset>
<?php
}
?>

<p><a href="commenter-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p>