<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>
<?php
$requests = $editRequestObj->getRequestsForOwner($_SESSION['user_id']);
?>

<?php include 'includes/mainStart.php'; ?>
<div class="col-md-9">

    <h2 class="text-2xl font-bold mb-4">Edit Requests</h2>

    <?php if (empty($requests)): ?>
        <p class="text-gray-500">No edit requests.</p>
    <?php else: ?>
        <?php foreach ($requests as $req): ?>
            <div class="p-4 bg-white rounded shadow mb-3">
                <p><strong><?= htmlspecialchars($req['requester_name']); ?></strong>
                    requested to edit your article
                    <em><?= htmlspecialchars($req['title']); ?></em>
                </p>
                <form action="core/handleForms.php" method="POST" class="flex space-x-2 mt-2">
                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($req['id']); ?>">
                    <input type="hidden" name="article_id" value="<?= htmlspecialchars($req['article_id']); ?>">
                    <input type="hidden" name="requester_id" value="<?= htmlspecialchars($req['requester_id']); ?>">

                    <button type="submit" name="acceptEditBtn" class="bg-green-500 text-white px-3 py-1 rounded">
                        <?= $req['status'] === 'accepted' ? 'Revert Access' : 'Accept' ?>
                    </button>
                    <button type="submit" name="rejectEditBtn" class="bg-red-500 text-white px-3 py-1 rounded">
                        Reject
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
<?php include 'includes/mainEnd.php'; ?>


<?php include 'includes/footer.php'; ?>