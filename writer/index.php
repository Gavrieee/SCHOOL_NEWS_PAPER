<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<?php include 'includes/mainStart.php'; ?>

<div class="col-md-6">
    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <!-- image preview -->
        <div class="<?= $centerDIV ?>">
            <img id="photoPreview" class="<?= $imgPreview ?>" alt="Preview">
        </div>

        <div class="form-group flex flex-col md:flex-row items-center md:space-x-4 space-y-3 md:space-y-0 w-full">
            <input type="text" class="form-control flex-1" name="title" placeholder="Input title here">

            <input type="file" name="photo" id="photoInput" accept="image/png, image/jpeg"
                class="<?= $formFile ?> flex-1">
        </div>

        <div class="form-group">
            <textarea name="description" class="form-control mt-4" placeholder="Submit an article!"></textarea>
        </div>
        <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertArticleBtn">
    </form>

    <?php $articles = $articleObj->getActiveArticles(); ?>
    <?php foreach ($articles as $article) { ?>
        <div class="card mt-4 shadow">
            <div class="card-body">

                <?php if ($article['photo_url']) { ?>
                    <img src="<?php echo $article['photo_url']; ?>" alt="Article Image"
                        class="w-48 h-48 object-cover rounded-lg border border-gray-300 shadow">

                <?php } ?>

                <?php
                $alreadyRequested = $editRequestObj->hasActiveOrAcceptedRequest($article['article_id'], $_SESSION['user_id']);
                ?>

                <h1><?php echo $article['title']; ?></h1>
                <?php if ($article['is_admin'] == 1) { ?>
                    <p><small class="bg-primary text-white p-1">
                            Message From Admin
                        </small></p>
                <?php } ?>

                <small><strong><?php echo $article['username'] ?></strong> -
                    <?php echo $article['created_at']; ?> </small>
                <p><?php echo $article['content']; ?> </p>

                <?php if ($article['author_id'] != $_SESSION['user_id'] && $article['is_admin'] == 0): ?>
                    <?php if (!$alreadyRequested): ?>
                        <form action="core/handleForms.php" method="POST">
                            <input type="hidden" name="article_id" value="<?= $article['article_id'] ?>">
                            <input type="hidden" name="owner_id" value="<?= $article['author_id'] ?>">
                            <button type="submit" name="requestEditBtn" class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Request Edit
                            </button>
                        </form>
                    <?php else: ?>
                        <p class="text-gray-500 italic text-sm">
                            Edit request already sent or approved
                        </p>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    <?php } ?>
</div>
<?php include 'includes/mainEnd.php'; ?>

<?php include 'includes/footer.php'; ?>