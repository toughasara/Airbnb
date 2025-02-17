<?

namespace App\Models\Back;

use App\Config\Database;
use PDO;

class UserModel
{

    private  $conn;
    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->connect();
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

