<?

namespace App\Models\Back;

use App\Config\Database;
use PDO;

class AnonceModel {
    private $conn;

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->connect();
    }

    public function getAllAnnonces() {

        $query = "SELECT * FROM property";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validateAnonce($id) {
        $checkQuery = "SELECT is_validated FROM property WHERE id = :id";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['is_validated']) {
            return false;
        }
        $query = "UPDATE property 
                  SET is_validated = TRUE, updated_at = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}
?>

