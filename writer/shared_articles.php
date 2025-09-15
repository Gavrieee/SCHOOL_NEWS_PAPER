<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>
<?php $sharedArticles = $editRequestObj->getSharedArticles($_SESSION['user_id']); ?>
<?php include 'includes/mainStart.php'; ?>
<main class="p-6">
    <h1 class="text-2xl font-bold mb-4">Shared Articles</h1>
    <?php if (empty($sharedArticles)): ?>
        <p>No shared articles yet.</p>
    <?php else: ?>
        <ul class="space-y-4">
            <?php foreach ($sharedArticles as $article): ?>
                <div class="articleCard p-4 bg-white rounded shadow mb-4 cursor-pointer">
                    <h3 class="font-bold"><?= htmlspecialchars($article['title']) ?></h3>
                    <p><?= htmlspecialchars(substr($article['content'], 0, 150)) ?>...</p>

                    <!-- Hidden Inline Edit Form -->
                    <div class="updateArticleForm d-none mt-4">
                        <h4 class="font-semibold">Edit the article</h4>
                        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">

                            <!-- Keep current photo -->
                            <input type="hidden" name="current_photo"
                                value="<?= htmlspecialchars($article['photo_url'] ?? '', ENT_QUOTES) ?>">

                            <!-- Show preview if photo exists -->
                            <?php if (!empty($article['photo_url'])): ?>
                                <img id="photoPreviewEdit_<?= $article['article_id'] ?>" class="w-32 h-32 object-cover my-2"
                                    src="<?= htmlspecialchars($article['photo_url']) ?>">
                            <?php endif; ?>

                            <div class="form-group flex flex-row items-center space-x-4">
                                <input type="text" class="form-control border rounded p-2" name="title"
                                    value="<?= htmlspecialchars($article['title']) ?>">

                                <input type="file" name="photo" id="photoInputEdit_<?= $article['article_id'] ?>"
                                    accept="image/png, image/jpeg" class="text-sm cursor-pointer">
                            </div>

                            <div class="form-group mt-3">
                                <textarea name="description"
                                    class="form-control border rounded p-2 w-full"><?= htmlspecialchars($article['content']) ?></textarea>
                                <input type="hidden" name="article_id" value="<?= $article['article_id'] ?>">
                                <input type="submit" class="btn btn-primary mt-3" name="editArticleBtn" value="Save Changes">
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

        </ul>
    <?php endif; ?>
</main>
<?php include 'includes/mainEnd.php'; ?>
<?php include 'includes/footer.php'; ?>