<?
namespace App\Models\Back;
use App\Config\Database;
use PDO;
class AdminModel{
    private PDO $db;
    public function __construct() {
        $this->db=Database::getInstance();
    }
  
}