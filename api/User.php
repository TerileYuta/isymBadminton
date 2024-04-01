<?php

    class User{
        private static $tokenList = array(
            "player" => "7MyDEBXyHwsBkzQVajrB",
            "manager" => "a4rEQskHpHDxSfsSCDGa",
            "directer" => "jM7KP5s2x3M3mX7eL3t4",
        );

        private static $tableName = "member";

        public static function Login(){
            $postData = Tool::getPost(array('password', 'id'));

            $data = array(
                "ey" => substr($postData["id"], 0, 4),
                "id" => substr($postData["id"], 4),
            );

            $result =  MySql::SELECT(self::$tableName, $data)[0];

            if($result != "NoArray"){
                if(password_verify($postData['password'], $result["password"])){
                    $token = self::createToken($result["type"]);
                    echo  json_encode(array("login" => true, "name" => $result["name"], "id" => $result["id"], "token" => $token, "type" => $result["type"]));
                    return;
                }else{
                    echo json_encode(array("login" => false));
                    return;
                }

            }else{
                echo json_encode(array("login" => false));
            }

            
        }

        public static function Auth(){
            $postData = Tool::getPost(array('token', 'url'));
            $result =  MySql::SELECT("route", array("url" => $postData["url"]))[0];

            if(isset($result)){
                if($result == "N"){
                    echo 0;
                    return;
                }

    
                if($result["guest"] == 1){
                    echo 1;
                    return;
                }
                
                foreach(array("player", "manager", "directer") as $type){
                    if($result[$type] == 1){
                        if(password_verify(self::$tokenList[$type], $postData["token"])){
                            echo 1;
                            return;
                        }
                    }
                }
            }


            echo 0;
        }

        public static function UserAdd(){
            $postData = Tool::getPost(array('name', 'type', 'ey', 'password'));

            $sql = "INSERT INTO member (ey, name, type, password, school) VALUES(?,?,?,?,?)";
            echo MySql::SQL($sql, array($postData['ey'], $postData['name'], $postData['type'], password_hash($postData['password'], PASSWORD_DEFAULT), "石山"));
        }

        public static function Password(){
            $postData = Tool::getPost(array('id', 'password'));

            $sql = "UPDATE member SET password = ? WHERE id = ?";
            echo MySql::SQL($sql, array(password_hash($postData['password'], PASSWORD_DEFAULT), $postData['id']));
        }

        private static function createToken($type){
            $token = password_hash(self::$tokenList[$type], PASSWORD_DEFAULT);

            return $token;
        }
    }
?>