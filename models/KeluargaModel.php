<?php
/**
 * models/KeluargaModel.php
 * Model data keluarga jemaat menggunakan MySQLi
 */

class KeluargaModel
{
    private $db;

    public function __construct()
    {
        // PERBAIKAN: Gunakan variabel global $conn dari database.php
        global $conn;
        $this->db = $conn;
    }

    /* =========================
       GET ALL KELUARGA
    ========================= */
    public function getAll()
    {
        // Perbaikan: Gunakan 'kepala_keluarga' sesuai struktur tabel
        $sql = "SELECT * FROM keluarga ORDER BY kepala_keluarga ASC";
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    /* =========================
       GET KELUARGA BY ID
    ========================= */
    public function getById($id)
    {
        // PERBAIKAN: MySQLi prepare menggunakan (?)
        $stmt = $this->db->prepare("SELECT * FROM keluarga WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /* =========================
       INSERT KELUARGA
    ========================= */
    public function insert($data)
    {
        // PERBAIKAN: Nama kolom disesuaikan menjadi 'kepala_keluarga'
        $sql = "INSERT INTO keluarga (no_kk_gereja, kepala_keluarga, wilayah_id, alamat) 
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        
        // "ssis" -> string (no_kk), string (kepala), integer (wilayah), string (alamat)
        $stmt->bind_param("ssis", 
            $data['no_kk_gereja'], 
            $data['kepala_keluarga'], 
            $data['wilayah_id'], 
            $data['alamat']
        );

        return $stmt->execute();
    }

    /* =========================
       UPDATE KELUARGA
    ========================= */
    public function update($id, $data)
    {
        // PERBAIKAN: Mengganti nama_kepala_keluarga menjadi kepala_keluarga
        $sql = "UPDATE keluarga SET 
                no_kk_gereja = ?, 
                kepala_keluarga = ?, 
                wilayah_id = ?, 
                alamat = ? 
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        
        // "ssisi" -> string, string, integer, string, integer (ID)
        $stmt->bind_param("ssisi", 
            $data['no_kk_gereja'], 
            $data['kepala_keluarga'], 
            $data['wilayah_id'], 
            $data['alamat'],
            $id
        );

        return $stmt->execute();
    }

    /* =========================
       DELETE KELUARGA
    ========================= */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM keluarga WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /* =========================
       HITUNG TOTAL KELUARGA
    ========================= */
    public function count()
    {
        // PERBAIKAN: fetchColumn diganti fetch_row
        $result = $this->db->query("SELECT COUNT(*) FROM keluarga");
        if ($result) {
            $row = $result->fetch_row();
            return $row[0];
        }
        return 0;
    }
    /* =========================
       GET REPORT KELUARGA
    ========================= */
    public function getReport($wilayah_id = null)
    {
        // Query dengan JOIN ke Wilayah dan COUNT anggota dari tabel jemaat
        $sql = "SELECT 
                    k.*, 
                    w.nama_wilayah, 
                    (SELECT COUNT(*) FROM jemaat WHERE keluarga_id = k.id) as jumlah_anggota
                FROM keluarga k
                LEFT JOIN wilayah w ON k.wilayah_id = w.id";

        if ($wilayah_id) {
            $sql .= " WHERE k.wilayah_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $wilayah_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        $sql .= " ORDER BY k.kepala_keluarga ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM keluarga";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc()['total'] : 0;
    }
}