<?php

require_once 'Database.php';
require_once 'User.php';
require_once 'Notification.php';

class Category extends Database
{

    public function createCategory($name)
    {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        return $this->executeNonQuery($sql, [$name]);
    }

    public function readAllCategory()
    {
        $sql = "SELECT * FROM categories ORDER BY created_at DESC";
        return $this->executeQuery($sql); // use executeQuery since this is SELECT
    }

    public function readCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        return $this->executeQuery($sql, [$id]);
    }

    public function updateCategory($id, $name)
    {
        $sql = "UPDATE categories SET name = ? WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$name, $id]);
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM  categories WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }

}