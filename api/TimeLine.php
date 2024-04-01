<?php
    class TimeLine{
        private static $errorCode = "9000";
        private static $tableName = "timeline";
        private static $columnList = array("id", "title", "documents");

        //0001
        public static function Get() {
            $postData = Tool::getPost(self::$columnList,);
            $sqlResult = MySql::SELECT(self::$tableName, $postData);
            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");
        }

        //0002
        public static function Action(){
            $postData = Tool::getPost(self::$columnList,);

            $sql = "INSERT INTO timeline (title, documents) VALUES(?,?)";
            $sqlResult = MySql::SQL($sql, array($postData["title"], $postData["documents"]));

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0002");
        }

        //0003
        public static function Good(){
            $postData = Tool::getPost(array("id"));

            $sql = "UPDATE timeline SET good = good + 1 WHERE id = ?";
            
            $sqlResult = MySql::SQL($sql, array($postData["id"]));
            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0003");
        }
    }
?>