<form method="post">
    <?= $form->input('nomArticle','Titre de l\'article') ?>
    <?= $form->input('contenueArticle','Contenue de l\'article', ['type' => 'textarea']) ?>
    <?= $form->select('id_categories','Categorie',$categories) ?>
    <?= $form->submit() ?>
</form>