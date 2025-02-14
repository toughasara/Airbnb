<?

namespace App\Models\Back;

use App\Config\Database;
use PDO;

class AnonceModel
{

    private  $conn;
    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->connect();
    }

    public function getAllAnnonces()
    {
        $query = "SELECT * FROM property";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

