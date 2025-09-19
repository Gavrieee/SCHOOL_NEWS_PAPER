<?php
require_once '../classloader.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = htmlspecialchars(trim($_POST['username']));
	$email = htmlspecialchars(trim($_POST['email']));
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (!$userObj->usernameExists($username)) {

				if ($userObj->registerUser($username, $email, $password)) {
					header("Location: ../login.php");
				} else {
					$_SESSION['message'] = "An error occured with the query!";
					$_SESSION['status'] = '400';
					header("Location: ../register.php");
				}
			} else {
				$_SESSION['message'] = $username . " as username is already taken";
				$_SESSION['status'] = '400';
				header("Location: ../register.php");
			}
		} else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}
	} else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if (!empty($email) && !empty($password)) {

		if ($userObj->loginUser($email, $password)) {
			header("Location: ../index.php");
		} else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	} else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../login.php");
	}

}

if (isset($_GET['logoutUserBtn'])) {
	$userObj->logout();
	header("Location: ../index.php");
}

if (isset($_POST['insertArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$category = $_POST['category_id'];
	$author_id = $_SESSION['user_id'];

	// Handle file upload
	$photo_url = null;
	if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
		$uploadDir = '../../uploads/';

		// make sure uploads folder exists
		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0777, true);
		}

		// generate unique filename
		$filename = uniqid() . '_' . basename($_FILES['photo']['name']);
		$targetPath = $uploadDir . $filename;

		if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
			// save relative path or URL for database
			$photo_url = '/oop_school_news_paper/uploads/' . $filename;
		}
	}

	// Insert into DB
	if ($articleObj->createArticle($title, $description, $category, $photo_url, $author_id)) {
		header("Location: ../index.php");
		exit;
	}
}


if (isset($_POST['editArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$category = $_POST['category_id'];
	$article_id = $_POST['article_id'];

	// Default: keep old photo
	$photo_url = $_POST['current_photo'] ?? null;

	// If user uploaded a new one
	if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
		$uploadDir = '../../uploads/';

		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0777, true);
		}

		$filename = uniqid() . '_' . basename($_FILES['photo']['name']);
		$targetPath = $uploadDir . $filename;

		if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
			$photo_url = '/oop_school_news_paper/uploads/' . $filename;
		}
	}

	if ($articleObj->updateArticle($article_id, $title, $description, $category, $photo_url)) {
		header("Location: ../articles_submitted.php");
	}
}

if (isset($_POST['deleteArticleBtn'])) {
	$article_id = $_POST['article_id'];
	echo $articleObj->deleteArticle($article_id);
}

if (isset($_GET['markNotificationRead'])) {
	$notifId = intval($_GET['markNotificationRead']);
	$notificationObj->markAsRead($notifId);

	header("Location: ../index.php");
	exit();
}

if (isset($_POST['requestEditBtn'])) {
	$article_id = $_POST['article_id'];
	$requester_id = $_SESSION['user_id'];
	$owner_id = $_POST['owner_id']; // hidden input in the form

	if ($editRequestObj->createRequest($article_id, $requester_id, $owner_id)) {
		$notificationObj->createNotification($owner_id, "A user requested to edit your article.");
		header("Location: ../index.php");
	}
}

if (isset($_POST['acceptEditBtn'])) {
	$request_id = $_POST['request_id'];
	$article_id = $_POST['article_id'];
	$requester_id = $_POST['requester_id'];

	// Get the current request details
	$req = $editRequestObj->getRequestById($request_id);

	if ($req) {
		if ($req['status'] === 'pending') {
			// Accept the request
			if ($editRequestObj->acceptRequest($request_id, $article_id, $requester_id)) {
				$notificationObj->createNotification(
					$requester_id,
					"Your edit request for article ID {$article_id} was accepted."
				);
			}
		} elseif ($req['status'] === 'accepted') {
			// Revert back to pending
			if ($editRequestObj->updateRequestStatus($request_id, 'pending')) {
				// Remove from shared_articles since access is revoked
				$editRequestObj->removeSharedAccess($article_id, $requester_id);

				$notificationObj->createNotification(
					$requester_id,
					"Your edit access for article ID {$article_id} was revoked (back to pending)."
				);
			}
		}
	}

	header("Location: ../edit_request.php");
	exit;
}


if (isset($_POST['rejectEditBtn'])) {
	$request_id = $_POST['request_id'];
	$requester_id = $_POST['requester_id'];

	if ($editRequestObj->rejectRequest($request_id)) {
		// Notify requester
		$notificationObj->createNotification(
			$requester_id,
			"Your edit request was rejected."
		);

		header("Location: ../edit_request.php");
		exit;
	}
}