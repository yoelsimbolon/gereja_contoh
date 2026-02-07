<?php
/**
 * models/UserModel.php
 * Model user sistem
 */

require_once __DIR__ . '/../config/database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = db();
    }

    /* =========================
       LOGIN
    ========================= */
    public function login($email, $password)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email LIMIT 1"
        );
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Jangan simpan password ke session
        unset($user['password']);

        return $user;
    }

    /* =========================
       GET ALL USERS
    ========================= */
    public function getAll()
    {
        return $this->db
            ->query("SELECT id, name, email, role, created_at FROM users")
            ->fetchAll();
    }

    /* =========================
       GET USER BY ID
    ========================= */
    public function getById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT id, name, email, role FROM users WHERE id = :id LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /* =========================
       INSERT USER
    ========================= */
    public function insert($data)
    {
        $sql = "INSERT INTO users
                (name, email, password, role)
                VALUES
                (:name, :email, :password, :role)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role']
        ]);
    }

    /* =========================
       UPDATE USER
    ========================= */
    public function update($id, $data)
    {
        $sql = "UPDATE users SET
                name = :name,
                email = :email,
                role = :role
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'    => $id,
            'name'  => $data['name'],
            'email' => $data['email'],
            'role'  => $data['role']
        ]);
    }

    /* =========================
       UPDATE PASSWORD
    ========================= */
    public function updatePassword($id, $password)
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET password = :password WHERE id = :id"
        );

        return $stmt->execute([
            'id'       => $id,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    /* =========================
       DELETE USER
    ========================= */
    public function delete($id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }

    /* =========================
       COUNT USER
    ========================= */
    public function count()
    {
        return $this->db
            ->query("SELECT COUNT(*) FROM users")
            ->fetchColumn();
    }
}
