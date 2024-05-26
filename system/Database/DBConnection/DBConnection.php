<?php
namespace System\Database\DBConnection;
class DBConnection
{
    private static $object=null;
    private function __construct(){}
    public static function getInstanceDBConnection()
    {
        if (self::$object==null)
        {
            self::$object=(new DBConnection())->dbConnection();
        }
        return self::$object;
    }
    private function dbConnection()
    {
        $option=[\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION,\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC];
        try {
            return new \PDO("mysql:host=".DBHOST.";dbname=".DBNAME,DBUSER,DBPASSWORD,$option);
        }catch (\Exception $exception)
        {
            exit($exception->getMessage());
        }
    }
    public function newInsertID()
    {
        return self::getInstanceDBConnection()->lastInsertId();
    }

}