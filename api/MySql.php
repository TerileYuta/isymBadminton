<?php
    class MySql{
        public static $dbname;
        public static $host;
        public static $user;
        public static $password;
        public static $dbh;

        private static $errorCode = "5000";

        //5000-0001
        //データベース接続エラー

        public static function CreatePDO(){
            $dsn = 'mysql:dbname='. self::$dbname .';host='. self::$host;

            try{
                self::$dbh = new PDO($dsn, self::$user, self::$password);
            }catch (PDOException $e){
                return 'Error:'.$e->getMessage();
            }
        }

        public static function SQL($sql, $data=null){
            try{
                if(preg_match('/SELECT/', $sql)){
                    $sql = $sql. " ORDER BY id DESC";
                }
                $stmt = self::$dbh->prepare($sql);
                $stmt->execute($data);
    
                $output = array();
    
                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                    array_push($output, $result);
                }

                if(count($output) == 0){
                    return array();
                }else{
                    return $output;        
                }
            }catch(Exception $e){
                return $e;
            }

        }

        public static function SELECT($table, $columnList = array(), $type = "and", $limit = null){
            list($SQLText, $dataList)= self::createColumnSQL($columnList, $type);

            if($limit != null){
                $SQLText = $SQLText. " LIMIT = ?";
                array_push($dataList, $limit);
            }

            $sql = "SELECT * FROM " . $table . $SQLText;

            $reutrnData =  self::SQL($sql, $dataList);

            return $reutrnData;
        }

        public static function createColumnSQL($columnList, $type){
            $SQLText = "";
            $dataList = array();
            $i = 0;

            foreach($columnList as $key => $column){
                array_push($dataList, $column);

                if($i == 0){
                    $SQLText = " WHERE $key = ?";
                }else{
                    $SQLText = "$SQLText $type  $key = ?";
                }

                $i++;
            }

            return array($SQLText, $dataList);
        }
    }
?>