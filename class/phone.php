<?php 
class Phone
{
	protected $name;	
	protected $image;		
	protected $color;
	protected $price;

	function __construct($name,$image,$color,$price)
	{
		$this->name=$name;
		$this->image=$image;
		$this->color=$color;
		$this->price=$price;
		if (!$this->validation()) {

			throw new Exception("Price can contain numbers only");	
		}
	}
	
	public function saveToDatabase() {

		// check the connection 
        $connection = new mysqli('localhost', 'root', '', 'phone_store');

        if ($connection ->connect_error) {
        	echo $connection ->connect_error;die();
        }

        $new_client = $connection->query("INSERT INTO `phones` (`name`,`image`,`color`,`price`) VALUES (
            '{$this->name}',
            '{$this->image}',
            '{$this->color}',
            '{$this->price}')"
        );

        http_response_code(201);

	}
	public function update($change , $str , $oldStr){

		// check the connection 
        $connection = new mysqli('localhost', 'root', '', 'phone_store');

        if ($connection ->connect_error) {
        	echo $connection ->connect_error;die();
        }

        $new_client = $connection->query("UPDATE `phones` `$change`='$str' WHERE `$change`='$oldStr')"
        );

	}
	public function talk() {
		echo $this->name;
		echo $this->image;
		echo $this->color;
		echo $this->price;
	}
	public function validation(){
		return preg_match('/^[0-9]+$/', $this->price);
			
	}
}