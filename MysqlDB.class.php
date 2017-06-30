<?php
class MysqlDB
{
    protected static $_instance = null;
    protected $dsn;
    protected $pdo;
    

    private function __construct($dbHost, $dbName,$dbUser, $dbPasswd, $dbCharset)
    {
        try {
            $this->dsn = 'mysql:host='.$dbHost.';dbname='.$dbName;
            $this->pdo = new PDO($this->dsn, $dbUser, $dbPasswd);
            $this->pdo->exec('SET character_set_connection='.$dbCharset.', character_set_results='.$dbCharset.', character_set_client=binary');
        } catch (PDOException $e) {
            echo '数据库连接失败：'.$e->getMessage();
            exit;
        }
    }
    
    //防止PDO类被克隆
    private function __clone() {}
    
   
    public static function getInstance($dbHost='127.0.0.1', $dbName='test',$dbUser='root', $dbPasswd='', $dbCharset='utf8')
    {
        if (self::$_instance === null) {
            self::$_instance = new self($dbHost, $dbName,$dbUser, $dbPasswd, $dbCharset);
        }
        return self::$_instance;
    }
    
  
    public function fetch($table, $where="",$queryMode = 'All')
    {
        if(!empty($where)){
            $strSql='select * from '.$table.' '.$where;
        }else{
            $strSql='select * from '.$table;
        }
        
        $recordset = $this->pdo->query( $strSql);
       
        if ($recordset) {
            $recordset->setFetchMode(PDO::FETCH_ASSOC);
            if ($queryMode == 'All') {
                $result = $recordset->fetchAll();
            } elseif ($queryMode == 'Row') {
                $result = $recordset->fetch();
            }
        } else {
            $result = null;
        }
        return $result;
    }
    
    
    public function update($table, $arrayDataValue, $where = '')
    {
       
        if ($where) {
            $strSql = '';
            foreach ($arrayDataValue as $key => $value) {
                $strSql .= ", '$key'='$value'";
            }
            $strSql = substr($strSql, 1);
            $strSql = "UPDATE $table SET $strSql WHERE $where";
        } else {
            $strSql = "REPLACE INTO $table (".implode(',', array_keys($arrayDataValue)).") VALUES ('".implode("','", $arrayDataValue)."')";
        }
       
        $result = $this->pdo->exec($strSql);
        
        return $result;
    }
    
  
    public function insert($table, $arrayDataValue)
    {
       
        $strSql = "INSERT INTO $table (".implode(',', array_keys($arrayDataValue)).") VALUES ('".implode("','", $arrayDataValue)."')";
      
        $result = $this->pdo->exec($strSql);
        return $result;
    }
    

    public function delete($table, $where = '')
    {
        if ($where == '') {
            echo "'WHERE' is Null";
        } else {
            $strSql = "DELETE FROM $table WHERE $where";
           
            $result = $this->pdo->exec($strSql);
            
            return $result;
        }
    }
   
    public function exec($strSql)
    {
        $result = $this->pdo->exec($strSql);
        return $result;
    }
    public function query($strSql)
    {
        $result = $this->pdo->query($strSql);
        return $result;
    }

    public function close()
    {
        $this->pdo = null;
    }
}



?>


