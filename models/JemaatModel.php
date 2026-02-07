<?php
/**
 * models/JemaatModel.php
 * Model data jemaat menggunakan MySQLi
 */

class JemaatModel
{
    private $db;

    public function __construct()
    {
        // Memanggil variabel koneksi $conn dari database.php
        global $conn;
        $this->db = $conn;
    }

    /* =========================
       GET ALL JEMAAT
    ========================= */
    public function getAll()
    {
        // MySQLi menggunakan fetch_all untuk mengambil semua data
        $sql = "SELECT * FROM jemaat ORDER BY nama_lengkap ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* =========================
       GET JEMAAT BY ID
    ========================= */
    public function getById($id)
    {
        // Menggunakan prepared statement MySQLi (?) bukan named placeholder (:id)
        $stmt = $this->db->prepare("SELECT * FROM jemaat WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /* =========================
       INSERT JEMAAT
    ========================= */
    public function insert($data)
    {
        $sql = "INSERT INTO jemaat 
                (nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, 
                 no_hp, keluarga_id) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        
        // "sssssi" berarti string, string, string, string, string, integer
        $stmt->bind_param("sssssi", 
            $data['nama_lengkap'], 
            $data['jenis_kelamin'], 
            $data['tempat_lahir'], 
            $data['tanggal_lahir'], 
            $data['no_hp'], 
            $data['keluarga_id']
        );

        return $stmt->execute();
    }

    /* =========================
       UPDATE JEMAAT
    ========================= */
    public function update($id, $data)
    {
        $sql = "UPDATE jemaat SET 
                nama_lengkap = ?, 
                jenis_kelamin = ?, 
                tempat_lahir = ?, 
                tanggal_lahir = ?, 
                no_hp = ?, 
                keluarga_id = ? 
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssii", 
            $data['nama_lengkap'], 
            $data['jenis_kelamin'], 
            $data['tempat_lahir'], 
            $data['tanggal_lahir'], 
            $data['no_hp'], 
            $data['keluarga_id'],
            $id
        );

        return $stmt->execute();
    }

    /* =========================
       DELETE JEMAAT
    ========================= */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM jemaat WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /* =========================
       HITUNG TOTAL JEMAAT
    ========================= */
    public function count()
    {
        $result = $this->db->query("SELECT COUNT(*) FROM jemaat");
        $row = $result->fetch_row();
        return $row[0];
    }
    public function getReport($wilayah_id = null)
    /* =========================
       GET REPORT jemaat
    ========================= */
    {
        // Query untuk menggabungkan data Jemaat, Keluarga, dan Wilayah
        $sql = "SELECT 
                    j.*, 
                    k.kepala_keluarga, 
                    w.nama_wilayah 
                FROM jemaat j
                LEFT JOIN keluarga k ON j.keluarga_id = k.id
                LEFT JOIN wilayah w ON k.wilayah_id = w.id";

        // Jika ada filter wilayah, tambahkan kondisi WHERE
        if ($wilayah_id) {
            $sql .= " WHERE k.wilayah_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $wilayah_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Jika tidak ada filter, ambil semua data
        $sql .= " ORDER BY j.nama_lengkap ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    /**
     * Menghitung total seluruh data jemaat
     */
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM jemaat";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc()['total'] : 0;
    }

    /**
     * Menghitung jemaat berdasarkan jenis kelamin (L/P)
     */
    public function countByGender($gender) {
        $sql = "SELECT COUNT(*) as total FROM jemaat WHERE jenis_kelamin = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $gender);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['total'] : 0;
    }
}