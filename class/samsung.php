<?php 
require 'phone.php';

class Samsung extends Phone
{
	public $company;
	
	function __construct($name,$image,$color,$price,$company)
	{
		parent ::__construct($name,$image,$color,$price);
		$this->company = "Samsung";
	}

	public function saveToDatabase() {

		// check the connection 
        $connection = new mysqli('localhost', 'root', '', 'phone_store');

        if ($connection ->connect_error) {
        	echo $connection ->connect_error;die();
        }

        $new_client = $connection->query("INSERT INTO `phones` (`name`,`image`,`color`,`price`,`company`) VALUES (
            '{$this->name}',
            '{$this->image}',
            '{$this->color}',
            '{$this->price}',
            '{$this->company}'
            )"
        );

	}
	public function update($change , $newStr , $oldValue){

		// check the connection 
        $connection = new mysqli('localhost', 'root', '', 'phone_store');

        if ($connection ->connect_error) {
        	echo $connection ->connect_error;die();
        }

        $new_client = $connection->query("UPDATE `phones` SET '$change'='$newStr' WHERE '$change'='$oldValue')"
        );

	}
	public function talk() {
		echo $this->name;
		echo $this->image;
		echo $this->color;
		echo $this->price;
		echo $this->company;

	}
}

$name =  filter_var($_POST['name'],FILTER_SANITIZE_STRING);
$image = filter_var($_POST['image'],FILTER_SANITIZE_STRING);
$color = filter_var($_POST['color'],FILTER_SANITIZE_STRING);
$price = filter_var($_POST['price'],FILTER_SANITIZE_STRING);

try {
	
     $samsung = new Samsung ($name,$image,$color,$price,$company);
     $samsung->saveToDatabase();
     var_dump($samsung);

} catch (Exception $e) {
	
	file_put_contents('error.log', $e->getMessage() . ', ' . date('Y-m-d h:i:s') . "\n");

    echo "Enter valid price";
}