<?php 

class SQL{

    //Backing Fields
    protected $db; //The actual database variable being wrapped.
    protected $statement; //For making statements.
    public $status; //The status of the connection.

    //Constructor that will call the connect method.
    public function __construct($host, $dbname, $user, $pass)
    {
        $this->status = $this->connect($host, $dbname, $user, $pass);
        
    }

    //The connect method will assign the pdo connection to the db variable.
    //It uses a try catch in the event that the connection fails and will
    //return the connection status to the user.
    protected function connect($host, $dbname, $user, $pass){

        try{
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        }
        catch(Exception $e){
            return $e->getMessage(); //Returns error message.
        }
        return "Success"; //Returns success message.

    }

    //For using SQL Commands to directly edit the database.
    public function direct_edit($sql){
        $this->statement = $this->db->prepare($sql);
        $this->execute();
    }

    //Retrieving database info and returning it as a class.  Must always be returned to a
    //class.
    public function retrieve($sql, $class = ""){
        $this->direct_edit($sql);
        return $this->statement->fetchAll(PDO::FETCH_CLASS, $class);
    }


    //This is called to execute the pdo prepared statement.
    protected function execute(){
        $this->statement->execute();
    }

}


?>