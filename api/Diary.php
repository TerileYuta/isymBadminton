<?php
    class Diary{
        private static $errorCode = "2000";
        private static $tableName = "diary";
        private static $columnList = array("year", "month", "day", "name", "document");

        //0001
        public static function Get(){
            $postData = Tool::getPost(self::$columnList);
            $sqlData = MySql::SELECT(self::$tableName, $postData, "and");

            echo Tool::Output(Tool::typeOfsqlResult($sqlData), $sqlData, self::$errorCode. "-0001");
        }

        //0002
        public static function Action(){
            $postData = Tool::getPost(self::$columnList);
            $sql = "INSERT INTO diary (year, month, day, name, documents) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE documents = VALUES(documents)";
            $sqlResult = MySql::SQL($sql, array($postData["year"], $postData["month"], $postData["day"], $postData["name"], $postData["document"]));

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0002");
        }
    }
?>