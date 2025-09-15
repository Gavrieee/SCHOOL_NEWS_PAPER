<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>


<?php include 'includes/mainStart.php'; ?>

<div class="col-md-6">
    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">


        <!-- image preview -->
        <img id="photoPreview" class="hidden w-48 h-48 object-cover rounded-lg border border-gray-300 shadow"
            alt="Preview">
        <div class="form-group flex flex-row items-center space-x-4">
            <input type="text" class="form-control" name="title" placeholder="Input title here">
            <input type="file" name="photo" id="photoInput" accept="image/png, image/jpeg"
                class="text-sm  cursor-pointer">
        </div>
        <div class="form-group">
            <textarea name="description" class="form-control mt-4" placeholder="Submit an article!"></textarea>
        </div>
        <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertArticleBtn">
    </form>

    <div class="display-4">Double click to edit article</div>
    <?php $articles = $articleObj->getArticlesByUserID($_SESSION['user_id']); ?>
    <?php foreach ($articles as $article) { ?>
        <div class="card mt-4 shadow articleCard">
            <div class="card-body">
                <?php if ($article['photo_url']) { ?>
                    <img src="<?php echo $article['photo_url']; ?>" alt="Article Image"
                        class="w-48 h-48 object-cover rounded-lg border border-gray-300 shadow">

                <?php } ?>
                <h1><?php echo $article['title']; ?></h1>
                <small><?php echo $article['username'] ?> - <?php echo $article['created_at']; ?> </small>
                <?php if ($article['is_active'] == 0) { ?>
                    <p class="text-danger">Status: PENDING</p>
                <?php } ?>
                <?php if ($article['is_active'] == 1) { ?>
                    <p class="text-success">Status: ACTIVE</p>
                <?php } ?>
                <p><?php echo $article['content']; ?> </p>
                <form class="deleteArticleForm">
                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                    <input type="submit" class="btn btn-danger float-right mb-4 deleteArticleBtn" value="Delete">
                </form>



                <div class="updateArticleForm d-none">
                    <h4>Edit the article</h4>
                    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="current_photo"
                            value="<?= htmlspecialchars($article['photo_url'] ?? '', ENT_QUOTES) ?>">

                        <?php if ($article['photo_url']): ?>
                            <img id="photoPreviewEdit" class="w-32 h-32 object-cover" src="<?= $article['photo_url'] ?>">
                        <?php endif; ?>

                        <div class="form-group flex flex-row items-center space-x-4">
                            <input type="text" class="form-control" name="title" value="<?php echo $article['title']; ?>">
                            <input type="file" name="photo" id="photoInputEdit" accept="image/png, image/jpeg"
                                class="text-sm  cursor-pointer" value="<?php echo $article['photo_url']; ?>">
                        </div>
                        <div class="form-group">
                            <textarea name="description" id=""
                                class="form-control"><?php echo $article['content']; ?></textarea>
                            <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                            <input type="submit" class="btn btn-primary float-right mt-4" name="editArticleBtn">
                        </div>
                    </form>
                </div>



            </div>
        </div>
    <?php } ?>
</div>
<?php include 'includes/mainEnd.php'; ?>
<?php include 'includes/footer.php'; ?>