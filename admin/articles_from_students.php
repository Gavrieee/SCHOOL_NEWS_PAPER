<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="display-4">Pending Articles</div>
            <?php $articles = $articleObj->getArticles(); ?>
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
                        <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>"
                            class="article_id">
                        <input type="submit" class="btn btn-danger float-right mb-4 deleteArticleBtn" value="Delete">
                    </form>
                    <form class="updateArticleStatus">
                        <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>"
                            class="article_id">
                        <select name="is_active" class="form-control is_active_select"
                            article_id=<?php echo $article['article_id']; ?>>
                            <option value="">Select an option</option>
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                        </select>
                    </form>
                    <div class="updateArticleForm d-none">
                        <h4>Edit the article</h4>
                        <form action="core/handleForms.php" method="POST">
                            <div class="form-group mt-4">
                                <input type="text" class="form-control" name="title"
                                    value="<?php echo $article['title']; ?>">
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
    </div>
</div>
<script>
// $('.articleCard').on('dblclick', function (event) {
//   var updateArticleForm = $(this).find('.updateArticleForm');
//   updateArticleForm.toggleClass('d-none');
// });

// $('.deleteArticleForm').on('submit', function (event) {
//   event.preventDefault();
//   var formData = {
//     article_id: $(this).find('.article_id').val(),
//     deleteArticleBtn: 1
//   }
//   if (confirm("Are you sure you want to delete this article?")) {
//     $.ajax({
//       type:"POST",
//       url: "core/handleForms.php",
//       data:formData,
//       success: function (data) {
//         if (data) {
//           location.reload();
//         }
//         else{
//           alert("Deletion failed");
//         }
//       }
//     })
//   }
// })

$('.is_active_select').on('change', function(event) {
    event.preventDefault();
    var formData = {
        article_id: $(this).attr('article_id'),
        status: $(this).val(),
        updateArticleVisibility: 1
    }

    if (formData.article_id != "" && formData.status != "") {
        $.ajax({
            type: "POST",
            url: "core/handleForms.php",
            data: formData,
            success: function(data) {
                if (data) {
                    location.reload();
                } else {
                    alert("Visibility update failed");
                }
            }
        })
    }
})
</script>
<?php include 'includes/footer.php'; ?>