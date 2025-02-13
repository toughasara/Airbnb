<?
namespace App\Models\Back;
use App\Config\Database;
use PDO;
class UserModel
{
    private PDO $db;
    public function __construct() {
        $this->db=Database::getInstance();
    }
  
    public function getAllUsers(): array
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
