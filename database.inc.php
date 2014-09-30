<?php

class Database {
	private $host;
	private $userName;
	private $password;
	private $database;
	private $conn;

	/**
	 * Constructs a database object for the specified user.
	 */
	public function __construct($host, $userName, $password, $database) {
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->database = $database;
	}

	/**
	 * Opens a connection to the database, using the earlier specified user
	 * name and password.
	 *
	 * @return true if the connection succeeded, false if the connection
	 * couldn't be opened or the supplied user name and password were not
	 * recognized.
	 */
	public function openConnection() {
		try {
			$this->conn = new PDO("mysql:host=$this->host;dbname=$this->database",
					$this->userName,  $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$error = "Connection error: " . $e->getMessage();
			print $error . "<p>";
			unset($this->conn);
			return false;
		}
		return true;
	}

	/**
	 * Closes the connection to the database.
	 */
	public function closeConnection() {
		$this->conn = null;
		unset($this->conn);
	}

	/**
	 * Checks if the connection to the database has been established.
	 *
	 * @return true if the connection has been established
	 */
	public function isConnected() {
		return isset($this->conn);
	}

	/**
	 * Execute a database query (select).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The result set
	 */
	private function executeQuery($query, $param = null) {
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll();
		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}

	/**
	 * Execute a database update (insert/delete/update).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The number of affected rows
	 */
	private function executeUpdate($query, $param = null) {
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$result = $stmt->rowCount();
		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}

  /**
   * TODO: Define SQL queries.
   *
   */


  public function getProductWithId($id) {
    $result = $this->executeQuery("SELECT id, name, image, price FROM products WHERE id = ?", array($id));
    return $result;
  }

  public function getProductReviews($id) {
    $result = $this->executeQuery("SELECT username, message FROM reviews INNER JOIN customers ON customer_id = id WHERE product_id = ?", array($id));
    return $result;
  }

  public function addReview($message, $username, $productId) {
    $customer = $this->executeQuery("SELECT id FROM customers WHERE username = ?", array($username));
    $this->executeUpdate("INSERT INTO reviews VALUES (?, ?, ?)", array($message, $customer[0]['id'], $productId));
  }


  /**
   * Retrieves all products from the database
   *
   * @return The products
   */
  public function getProducts() {
    $result = $this->executeQuery("SELECT id, name, image, price FROM products");
    return $result;
  }
  public function getNameOfProduct($id){
    $result = $this->executeQuery("SELECT name FROM products WHERE id = ".$id);
    return $result[0][0];
  }
  public function getPriceOfProduct($id){
    $result = $this->executeQuery("SELECT price FROM products WHERE id = ".$id);
    return $result[0][0];
  }


public function loginCustomer($username, $password){
	if(!$this->isConnected()){
		$this->openConnection();
	}
	$query = "
            SELECT
                id,
                username,
                password,
                salt,
                address
            FROM customers
            WHERE
                username = :username
        ";
        $query_params = array(
            ':username' => $username
        );

        try{
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        $login_ok = false;
        $row = $stmt->fetch();
        if($row){
            $check_password = hash('sha256', $_POST['password'] . $row['salt']);
            for($round = 0; $round < 65536; $round++){
                $check_password = hash('sha256', $check_password . $row['salt']);
            }
            if($check_password === $row['password']){
                $login_ok = true;
            }
        }

        if($login_ok){
            unset($row['salt']);
            unset($row['password']);
            $_SESSION['customer'] = $row['username'];
            return true;
            //header("Location: secret.php");
            //die("Redirecting to: secret.php");
        }
        else{
            print("Login Failed.");
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
            return false;
        }
}

public function registerCustomer($username, $password, $address){
	if(!$this->isConnected()){
		$this->openConnection();
	}

	// Check if the username is already taken
        $query = "
            SELECT
                1
            FROM customers
            WHERE
                username = :username
        ";
        $query_params = array( ':username' => $username );
        try {
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        $row = $stmt->fetch();
        if($row){ die("This username is already in use"); }
        $query = "
            SELECT
                1
            FROM customers
            WHERE
                address = :address
        ";
        $query_params = array(
            ':address' => $address
        );
        try {
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());}
        $row = $stmt->fetch();
        if($row){ die("This address is already registered"); }

        // Add row to database
        $query = "
            INSERT INTO customers (
                username,
                password,
                salt,
                address
            ) VALUES (
                :username,
                :password,
                :salt,
                :address
            )
        ";

        // Security measures
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $salted_password = hash('sha256', $password . $salt);
        for($round = 0; $round < 65536; $round++){ $salted_password = hash('sha256', $salted_password . $salt); }
        $query_params = array(
            ':username' => $username,
            ':password' => $salted_password,
            ':salt' => $salt,
            ':address' => $address
        );
        try {
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        header("Location: index.php");
        die("Redirecting to index.php");
    }


}

?>
