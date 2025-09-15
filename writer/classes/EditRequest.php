<?php

require_once 'Database.php';
require_once 'Article.php';

class EditRequest extends Database
{
    public function createRequest($article_id, $requester_id, $owner_id)
    {
        $sql = "INSERT INTO edit_requests (article_id, requester_id, owner_id) VALUES (?, ?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $requester_id, $owner_id]);
    }

    public function getRequestsForOwner($owner_id)
    {
        $sql = "SELECT er.*, a.title, u.username AS requester_name
            FROM edit_requests er
            JOIN articles a ON er.article_id = a.article_id
            JOIN school_publication_users u ON er.requester_id = u.user_id
            WHERE er.owner_id = ? AND er.status IN ('pending', 'accepted')
            ORDER BY er.created_at DESC";
        return $this->executeQuery($sql, [$owner_id]);
    }

    public function updateRequestStatus($request_id, $status)
    {
        $sql = "UPDATE edit_requests SET status = ? WHERE id = ?";
        return $this->executeNonQuery($sql, [$status, $request_id]);
    }

    public function getSharedArticles($user_id)
    {
        $sql = "SELECT a.*
            FROM articles a
            JOIN edit_requests er ON a.article_id = er.article_id
            WHERE er.requester_id = ? AND er.status = 'accepted'";
        return $this->executeQuery($sql, [$user_id]);
    }

    public function hasActiveOrAcceptedRequest($article_id, $requester_id)
    {
        $sql = "SELECT COUNT(*) as cnt 
            FROM edit_requests 
            WHERE article_id = ? 
              AND requester_id = ? 
              AND status IN ('pending', 'accepted')";
        $row = $this->executeQuerySingle($sql, [$article_id, $requester_id]);
        return $row && $row['cnt'] > 0;
    }

    public function acceptRequest($request_id, $article_id, $requester_id)
    {
        // Update request status
        $sql = "UPDATE edit_requests SET status = 'accepted' WHERE id = ?";
        $result = $this->executeNonQuery($sql, [$request_id]);

        if ($result) {
            // Grant access to shared articles
            $sql2 = "INSERT INTO shared_articles (article_id, user_id) VALUES (?, ?)";
            $this->executeNonQuery($sql2, [$article_id, $requester_id]);
        }

        return $result;
    }

    public function rejectRequest($request_id)
    {
        $sql = "UPDATE edit_requests SET status = 'rejected' WHERE id = ?";
        return $this->executeNonQuery($sql, [$request_id]);
    }

    public function getRequestById($id)
    {
        $sql = "SELECT * FROM edit_requests WHERE id = ?";
        $rows = $this->executeQuery($sql, [$id]);
        return $rows ? $rows[0] : null;
    }

    public function removeSharedAccess($article_id, $user_id)
    {
        $sql = "DELETE FROM shared_articles WHERE article_id = ? AND user_id = ?";
        return $this->executeNonQuery($sql, [$article_id, $user_id]);
    }


}