<?php
namespace DataBase;

use PDO;
use PDOException;

class DataBase
{
    
    private $connection;
    
    private $option = array(PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

   

   
    private $dbHost= "localhost";
    
    private $dbName= "uni";
    
    private $dbUsername="root";

    private $dbPassword = "";


  
    function __construct()
    {
        try{
            
            $this->connection = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName,$this->dbUsername,
                $this->dbPassword,$this->option);
        }
        
        catch (PDOException $e){
            echo "<div> style='color:red;'> There is some problem in connection :</div>". $e->getMessage();
        }
    } 

    public function select($sql, $values=NULL)
    {
        try{
             
            if ($values==null){ 
                
                return $this->connection->query($sql);
            }
    
            else{
                $stmt= $this->connection->prepare($sql);
                $stmt->execute($values);
                $result=$stmt;
                return $result;
            }
        }
    
        catch (PDOException $e){
            echo "<div> style='color:red;'> There is some problem in connection :</div>". $e->getMessage();
            return false;
        }
    }


    public function insert($tableName,$fields,$values)
    {
        try{
         
            $stmt= $this->connection->prepare("INSERT INTO ".$tableName."(".implode(', ',$fields)." , created_at) VALUES ( :" . implode(', :',$fields) . " , now() );");

            $stmt->execute(array_combine($fields,$values));
            return true;
        }
        catch (PDOException $e){
            echo "<div> style='color:red;'> There is some problem in connection :</div>". $e->getMessage();
            return false;
        }
    }


}










