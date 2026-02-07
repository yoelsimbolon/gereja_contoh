<?php
/**
 * models/WilayahModel.php
 * Model data wilayah gereja menggunakan MySQLi
 */

class WilayahModel
{
    private $db;

    public function __construct()
    {
        // Memanggil variabel koneksi $conn dari database.php
        global $conn;
        $this->db = $conn;
    }

    /* =========================
       GET ALL WILAYAH
    ========================= */
    public function getAll()
    {
        $sql = "SELECT * FROM wilayah ORDER BY nama_wilayah ASC";
        $result = $this->db->query($sql);
        // Menggunakan fetch_all (MySQLi style)
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /* =========================
       GET WILAYAH BY ID
    ========================= */
    public function getById($id)
    {
        // MySQLi prepare menggunakan (?) bukan (:id)
        $stmt = $this->db->prepare("SELECT * FROM wilayah WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /* =========================
       INSERT WILAYAH
    ========================= */
    public function insert($data)
    {
        $sql = "INSERT INTO wilayah (nama_wilayah, keterangan) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        
        $keterangan = $data['keterangan'] ?? null;
        $stmt->bind_param("ss", $data['nama_wilayah'], $keterangan);

        return $stmt->execute();
    }

    /* =========================
       UPDATE WILAYAH
    ========================= */
    public function update($id, $data)
    {
        $sql = "UPDATE wilayah SET nama_wilayah = ?, keterangan = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        $keterangan = $data['keterangan'] ?? null;
        $stmt->bind_param("ssi", $data['nama_wilayah'], $keterangan, $id);

        return $stmt->execute();
    }

    /* =========================
       DELETE WILAYAH
    ========================= */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM wilayah WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /* =========================
       COUNT WILAYAH
    ========================= */
    public function count()
    {
        // fetchColumn diganti dengan fetch_row
        $result = $this->db->query("SELECT COUNT(*) FROM wilayah");
        if ($result) {
            $row = $result->fetch_row();
            return $row[0];
        }
        return 0;
    }
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM wilayah";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc()['total'] : 0;
    }
}