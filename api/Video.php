<?php
    class Video{
        private static $errorCode = "12000";
        private static $tableName = "video";
        private static $columnList = array("id", "word", "title", "documents", "youtube_id", "tag");

        //0001
        public static function Get(){
            $postData = Tool::getPost(self::$columnList);

            if(isset($postData["id"])){
                $sqlResult = MySql::SELECT(self::$tableName, $postData);

                echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");

                return;
            }

            if(!isset($postData["word"])){
                $postData["word"] = "";
            }

            $sql = "SELECT * FROM video WHERE title LIKE ? or documents LIKE ? or tag LIKE ?";
            
            $word = "%". $postData['word']. "%";

            $sqlResult = MySql::SQL($sql, array($word,$word,$word));
            
            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0001");
        }

        //0002
        public static function Action(){
            $postData = Tool::getPost(self::$columnList);

            $sql = "INSERT INTO video (title, documents, youtube_id, tag) VALUES(?,?,?,?)";

            foreach(self::$columnList as $column){
                if(!isset($postData[$column])){
                    $postData[$column] = "";
                }
            }

            $sqlResult = MySql::SQL($sql, array($postData["title"], $postData["documents"], $postData["youtube_id"], $postData["tag"]));
            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0002");
        }
    }
?>