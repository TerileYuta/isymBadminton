<?php
    class Member{
        private static $errorCode = "3000";
        private static $tableName = "member";
        private static $columnList = array("id", "name", "school", "ey", "type");

        //0001-0003
        public static function Get() {
            $postData = Tool::getPost(self::$columnList);

            if(!isset($postData["name"])){
                $sqlResult = MySql::SELECT(self::$tableName, $postData);
                echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");
            }else{
                if(!isset($postData["school"])){
                    $sql = "SELECT * FROM member WHERE name LIKE ?";
                    $sqlResult = mysql::SQL($sql, array('%'. $postData["name"]. '%'));

                    echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");
                }else{
                    $sql = "SELECT * FROM member WHERE name LIKE ? AND school = ?";
                    $sqlResult = mysql::SQL($sql, array('%'. $postData["name"]. '%', $postData["school"]));

                    echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");
                }
            }

        }

        public static function Action(){
            $postData = Tool::getPost(self::$columnList);

            if($postData['name']){
                $sql = "INSERT INTO member (name, school, ey, type) VALUES(?,?,?,?)";

                mysql::SQL($sql, array($postData['name'], $postData['school'], $postData['ey'], $postData['type']));

                echo true;
            }


            //Update
            /*
            $sql = "UPDATE member SET name = ?, school = ?, ey = ?, type = ? WHERE id = ?";
            mysql::SQL($sql, array($info->name, $info->school, $info->ey,$info->type, $info->id));
        
            */
        }

        public static function GetInfoByID($id){
            $sqlData = MySql::SELECT(self::$tableName, array("id" => $id), "and");
            return $sqlData[0];
        }
    }
?>