<?php
    class Setting{
        public static $errorCode = "8000";

        //0001
        public static function GetSchool(){
            $sqlResult = MySql::SELECT("school");

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");
        }

        //0002
        public static function GetTournament(){
            $sqlResult = MySql::SELECT("tournament");

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0002");
        }

        public static function GetRoute(){
            $sqlData = MySql::SELECT("route");
            echo json_encode($sqlData);
        }

        public static function routeAction(){
            $postData = Tool::getPost(array("id", "type"));
            $type = $postData['type'];

            $sql = "UPDATE route SET $type = IF($type=1,0,1) WHERE id = ?";

            mysql::SQL($sql, array($postData['id']));
        }
    }
?>