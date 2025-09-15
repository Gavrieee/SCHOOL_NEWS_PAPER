</div>
</div>

<sidebar class="<?= $sidebar ?>">
    <?php
    $notifications = $notificationObj->getNotifications($_SESSION['user_id']);
    ?>

    <h1 class="text-2xl font-bold mb-4">Notifications</h1>
    <main class="p-6 overflow-y-auto">
        <?php if (empty($notifications)): ?>
            <p class="text-gray-500">No notifications yet.</p>
        <?php else: ?>
            <ul class="space-y-3">
                <?php foreach ($notifications as $notif): ?>
                    <li class="p-4 bg-white rounded shadow flex justify-between items-center">
                        <div>
                            <p><?= htmlspecialchars($notif['message']) ?></p>
                            <small class="text-gray-400"><?= $notif['created_at'] ?></small>
                        </div>
                        <?php if (!$notif['is_read']): ?>
                            <a href="core/handleForms.php?markNotificationRead=<?= $notif['id'] ?>"
                                class="text-blue-600 hover:underline">
                                Mark as read
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </main>
</sidebar>
</main>