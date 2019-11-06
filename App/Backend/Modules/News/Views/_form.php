<form action="" method="post">
  <p>
    <?= $form ?>

<?php
if(isset($news) && !$news->isNew())
{
?>
    <input type="submit" value="Modifier" name="modifier" />
<?php
}
else
{
?>
    <input type="submit" value="Ajouter" />
<?php
}
?>
  </p>
</form>