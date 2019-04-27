<h2>Dashboard</h2>

<p>
    <a href="?p=admin.categories.add" class="btn btn-success">Ajouter</a>
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

    <?php foreach ($items as $category): ?>
        <tr>
            <td><?= $category->id ?></td>
            <td><?= $category->titre ?></td>
            <td>
                <a class="btn btn-primary" href="?p=admin.categories.edit&id=<?= $category->id ?>">Edit</a>
                <form action="?p=admin.categories.delete" method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?= $category->id ?>">
                    <button type="submit" class="btn btn-danger" >Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>