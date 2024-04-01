<?php
    class Comment{
        private static $errorCode = "1000";
        private static $tableName = "comment";

        //0001
        public static function Get(){
            $postData = Tool::getPost(array("post_id"));
            $sqlResult = MySql::SELECT(self::$tableName, $postData);

            $output = array();

            if(gettype($sqlResult) == "array"){
                foreach($sqlResult as $data){
                    $name = Member::GetInfoByID($data["name"]);
    
                    array_push($output, array("comment" => $data["comment"], "name" => $name["name"], "update" => $data["update_at"]));
                }
            }

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $output, self::$errorCode. "-0001");
        }

        //0002
        public static function Add(){
            $postData = Tool::getPost(array("id", "name", "comment"));

            $sql = "INSERT INTO comment (post_id, name, comment) VALUES(?,?,?)";

            $sqlResult = MySql::SQL($sql, array($postData["id"], $postData["name"], $postData["comment"]));
            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0002");
        }
    }
?>