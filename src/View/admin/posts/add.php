<form method="post">
    <?= $form->input('nomArticle','Titre de l\'article') ?>
    <?= $form->input('auteurArticle','Auteur Article') ?>
    <?= $form->input('chapoArticle','Chapo Article') ?>
    <?= $form->input('contenueArticle','Contenue de l\'article', ['type' => 'textarea']) ?>
    <?= $form->select('id_categories','Categorie',$categories) ?>
    <?= $form->submit() ?>
</form>