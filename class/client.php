<?php 
class Client
{
	private $password;
	private $name;
	private $phone;
	private $address;
	
	public function __construct($password,$name,$phone,$address)
	{
		$this->password = $password;
		$this->name = $name;
		$this->phone = $phone;
		$this->address = $address;
		if (!$this->validation()) {

			throw new Exception("Phone can contain numbers only, password contain numbers and letters only");	
		}

	}

	public function saveToDatabase() {

		// check the connection 
        $connection = new mysqli('localhost', 'root', '', 'phone_store');

        if ($connection ->connect_error) {
        	echo $connection ->connect_error;die();
        }

        $new_client = $connection->query("INSERT INTO `clients` (`name`,`address`,`password`,`phone`) VALUES (
            '{$this->name}',
            '{$this->address}',
            '{$this->password}',
            '{$this->phone}')"
        );
	}

	public function update($change , $str){

		// check the connection 
        $connection = new mysqli('localhost', 'root', '', 'phone_store');

        if ($connection ->connect_error) {
        	echo $connection ->connect_error;die();
        }

        $new_client = $connection->query("INSERT INTO `clients` (`$change`) VALUES (
            '{$str}')"
        );
	}

	public function talk() {
		echo $this->name;
		echo $this->address;
		echo $this->password;
		echo $this->phone;
	}

	public function validation(){
		return preg_match('/^[0-9]+$/', $this->phone) &&
		       preg_match('/^[a-zA-Z0-9_.-]*$/', $this->password);	
	}
}
