<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>
<div class="container-fluid">
  <div class="display-4 text-center">Hello there and welcome to the admin side! <span
      class="text-success"><?php echo $_SESSION['username']; ?></span>. Here are all the articles</div>
  <div class="row justify-content-center">
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
          <textarea name="description" class="form-control mt-4" placeholder="Message as admin"></textarea>
        </div>
        <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertAdminArticleBtn">
      </form>
      <?php $articles = $articleObj->getActiveArticles(); ?>
      <?php foreach ($articles as $article) { ?>
        <div class="bg-white rounded-xl shadow-md overflow-hidden mt-6 border border-gray-200">
          <div class="p-6 flex flex-col md:flex-row gap-6">

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
                    Admin Message
                  </span>
                <?php } ?>
              </div>

              <p class="text-sm text-gray-500">
                <strong class="text-gray-700"><?php echo htmlspecialchars($article['username']); ?></strong>
                · <?php echo date("M d, Y", strtotime($article['created_at'])); ?>
              </p>

              <p class="text-gray-700 leading-relaxed">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
              </p>
            </div>
          </div>

          <!-- Footer / Actions -->
          <div class="border-t bg-gray-50 px-6 py-3 flex justify-end">
            <form action="core/handleForms.php" method="POST" onsubmit="return confirm('Delete this article?');">
              <input type="hidden" name="article_id" value="<?= $article['article_id'] ?>">
              <button type="submit" name="deleteArticleBtn"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Delete
              </button>
            </form>
          </div>
        </div>
      <?php } ?>

    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>