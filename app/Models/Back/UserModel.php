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
        $query = 'SELECT role.title, "user".id, "user".first_name, "user".last_name, "user".status, 
       "user".email, "user".profile_picture, "user".is_connected 
       FROM "user" INNER JOIN role ON "user".role_id = role.id;
';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}