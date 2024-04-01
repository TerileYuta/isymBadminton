<?php
    class Menu{
        private static $errorCode = "4000";
        private static $tableName = "menu";
        private static $columnList = array("id", "word", "title", "documents", "points", "focus", "set", "video", "tag");

        //0001
        public static function Get(){
            $postData = Tool::getPost(self::$columnList);

            if(isset($postData["id"])){
                $sqlResult = MySql::SELECT(self::$tableName, array("id" => $postData["id"]));

                echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");

                return;
            }
                      
            if(!isset($postData["word"])){
                $postData["word"] = "";
            }

            $sql = "SELECT * FROM menu WHERE title LIKE ? or documents LIKE ? or focus LIKE ? or tag LIKE ?";
            
            $word = "%". $postData['word']. "%";

            $sqlResult =  MySql::SQL($sql, array($word,$word,$word,$word));

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");
        }

        //0002-0003
        public static function Action(){
            $postData = Tool::getPost(self::$columnList);

            foreach(self::$columnList as $column){
                if(!isset($postData[$column])){
                    $postData[$column] = "";
                }
            }


            if($postData["id"] != ""){
                $sql = "UPDATE menu SET title = ?, documents = ?, points = ?, focus = ?, set_count = ?, video = ?, tag = ? WHERE id = ?";
                $sqlResult = MySql::SQL($sql, array($postData["title"], $postData["documents"], $postData["points"], $postData["focus"], $postData["set"], $postData["video"], $postData["tag"], $postData["id"]));
            
                echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0002");
            }else{
                $sql = "INSERT INTO menu (title, documents, points, focus, set_count, video, tag) VALUES(?,?,?,?,?,?,?)";
    
                $sqlResult =  MySql::SQL($sql, array($postData["title"], $postData["documents"], $postData["points"], $postData["focus"], $postData["set"], $postData["video"], $postData["tag"]));

                echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0003");
            }

        }
    }
?>