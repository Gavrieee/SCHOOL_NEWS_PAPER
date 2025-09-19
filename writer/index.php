<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<?php include 'includes/mainStart.php'; ?>

<div class="col-md-9">
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
        <div class="bg-white rounded-xl shadow-md overflow-hidden mt-6 border border-gray-200">
            <div class="p-6 flex flex-col md:flex-row gap-6">

                <?php $alreadyRequested = $editRequestObj->hasActiveOrAcceptedRequest($article['article_id'], $_SESSION['user_id']); ?>

                <!-- Article Image -->
                <?php if ($article['photo_url']) { ?>
                    <img src="<?php echo $article['photo_url']; ?>" alt="Article Image"
                        class="w-full md:w-48 h-48 object-cover rounded-lg shadow-sm">
                <?php } ?>

                <!-- Article Content -->
                <div class="flex-1 space-y-3">
                    <div class="flex items-center justify-between">
                        <h1 class="text-xl font-semibold text-gray-800">
                            <?php echo htmlspecialchars($article['title']); ?>
                        </h1>

                        <!-- Admin Badge -->
                        <?php if ($article['is_admin'] == 1) { ?>
                            <span class="bg-blue-600 text-white text-xs font-medium px-2 py-1 rounded">
                                Message From Admin
                            </span>
                        <?php } ?>
                    </div>

                    <!-- Author & Date -->
                    <p class="text-sm text-gray-500">
                        <strong class="text-gray-700"><?php echo htmlspecialchars($article['username']); ?></strong>
                        · <?php echo date("M d, Y", strtotime($article['created_at'])); ?>
                    </p>

                    <!-- Category -->
                    <?php if (!empty($article['category_name'])) { ?>
                        <p class="text-sm font-semibold italic text-gray-500 border rounded-full w-fit px-3 py-1">
                            <strong class="text-gray-700"><?php echo htmlspecialchars($article['category_name']); ?></strong>
                        </p>
                    <?php } ?>

                    <!-- Content -->
                    <p class="text-gray-700 leading-relaxed">
                        <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                    </p>

                    <!-- Edit Request -->
                    <div class="mt-auto">
                        <?php if ($article['author_id'] != $_SESSION['user_id'] && $article['is_admin'] == 0): ?>
                            <?php if (!$alreadyRequested): ?>
                                <form action="core/handleForms.php" method="POST" class="mt-3">
                                    <input type="hidden" name="article_id" value="<?= $article['article_id'] ?>">
                                    <input type="hidden" name="owner_id" value="<?= $article['author_id'] ?>">
                                    <button type="submit" name="requestEditBtn"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                        Request Edit
                                    </button>
                                </form>
                            <?php else: ?>
                                <p class="text-gray-500 italic text-sm mt-2">
                                    Edit request already sent or approved
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>

    <?php } ?>
</div>
<?php include 'includes/mainEnd.php'; ?>

<?php include 'includes/footer.php'; ?>