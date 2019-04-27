<div class="row">
    <div class="col-sm-8">
        <?php foreach ($posts as $post): ?>

            <h2><a href="<?= $post->url ?>"><?= $post->nomArticle ?></a></h2>

            <em><?= $post->categories ?></em>

            <p><?= $post->extrait ?></p>

        <?php endforeach; ?>
    </div>

    <div class="col-sm-4">
        <ul>
            <?php foreach ($categories as $categorie): ?>
                <li><a href="<?= $categorie->url ?>"><?= $categorie->titre ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
