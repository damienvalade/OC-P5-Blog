<h2>Dashboard</h2>

<p>
    <a href="?p=admin.posts.add" class="btn btn-success">Ajouter</a>
</p>

<table class="table">
    <thead>
    <tr>
        <td>ID</td>
        <td>Nom</td>
        <td>Action</td>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= $post->id ?></td>
            <td><?= $post->nomArticle ?></td>
            <td>
                <a class="btn btn-primary" href="?p=admin.posts.edit&id=<?= $post->id ?>">Edit</a>
                <form action="?p=admin.posts.delete" method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?= $post->id ?>">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>