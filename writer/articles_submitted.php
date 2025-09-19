<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>


<?php include 'includes/mainStart.php'; ?>

<div class="col-md-9">
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





        <div class="articleCard bg-white rounded-xl shadow-md overflow-hidden mt-6 border border-gray-200">
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

                    <?php if (empty($article['category_name'])) { ?>
                    <?php } else { ?>
                        <p class="text-sm font-semibold italic text-gray-500 border rounded-full w-fit px-3 py-1">
                            <strong class="text-gray-700"><?php echo htmlspecialchars($article['category_name']); ?></strong>
                        </p>
                    <?php } ?>



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

            <!-- EDIT FORM -->
            <div class="updateArticleForm d-none px-4 pb-1 bg-gray-50">
                <h4 class="font-bold text-lg">Edit this article</h4>
                <form action="core/handleForms.php" method="POST" class="flex flex-col space-y-5">
                    <input type="hidden" name="current_photo"
                        value="<?= htmlspecialchars($article['photo_url'] ?? '', ENT_QUOTES) ?>">

                    <?php if ($article['photo_url']): ?>
                        <img id="photoPreviewEdit" class="w-32 h-32 object-cover" src="<?= $article['photo_url'] ?>">
                    <?php endif; ?>

                    <div class="form-group flex flex-row items-center space-x-4">
                        <input type="text" class="form-control" name="title" value="<?php echo $article['title']; ?>">
                        <input type="file" name="photo" id="photoInputEdit" accept="image/png, image/jpeg"
                            class="text-sm  cursor-pointer <?= $formFile ?>" value="<?php echo $article['photo_url']; ?>">
                    </div>

                    <div class="form-group mt-4">
                        <?php $categories = $categoryObj->readAllCategory(); ?>

                        <select name="category_id" class="form-control">
                            <option value="" disabled <?= empty($article['category_id']) ? 'selected' : '' ?>>
                                Select a category
                            </option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category_id'] ?>"
                                    <?= ($article['category_id'] == $category['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="form-group bg-gray-50">
                        <textarea name="description" id=""
                            class="form-control"><?php echo $article['content']; ?></textarea>
                        <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                    </div>

                    <!-- Submit Button -->
                    <div class="my-3 flex justify-end">
                        <button type="submit" name="editArticleBtn"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>


        </div>









    <?php } ?>
</div>
<?php include 'includes/mainEnd.php'; ?>
<?php include 'includes/footer.php'; ?>