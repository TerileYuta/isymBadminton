<?php
    class Plan{
        private static $errorCode = "6000";
        private static $tableName = "plan";
        private static $columnList = array("year", "month", "day", "comment");

        public static function Index(){
            for($i = 0; $i < 3; $i++){
                $date = new DateTime("today +$i month");
                echo $i;
                $year = $date->format("Y");
                $month = $date->format("n");

                $url = "https://brmstar.net/sche/isymbad/aoyama.php?kageyama=$year$month&nagata=json";
                $html = file_get_contents($url);

                if($html != "No input yet. Or there is no data file because it is a year and month before the start of operation of this mechanism."){
                    preg_match_all('/\{.+?\}/', $html, $dataList);
    
                    foreach($dataList[0] as $a){                   
                        $data = json_decode($a, true);
    
                        $day = $data["day"];
    
    
                        $comment = "";
    
                        $data = mb_split("<br>", $data["comment"]);
    
                        foreach($data as $b){
                            $comment = $comment . "," . $b;
                        }
    
                        self::updatePlan($year, $month, $day, $comment);
                        
                    }
                }
            }
        }

        public static function updatePlan($year, $month, $day, $comment){
            $sql = "INSERT INTO plan (year, month, day, comment) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE comment = VALUES(comment)";

            Mysql::SQL($sql, array($year, $month, $day, $comment));
        }

        //0001
        public static function Get(){
            $postData = Tool::getPost(self::$columnList);
            $sqlResult = MySql::SELECT(self::$tableName, $postData, "and");
            $sqlResultType = Tool::typeOfsqlResult($sqlResult); 

            $output = array();
            
            if($sqlResultType == "success"){
                if(count($sqlResult) != 1){
                    foreach($sqlResult as $data){
                        $data["comment"] = mb_split(",", $data["comment"]);
                        $output[$data["day"]] = $data;
                    }
                }else{
                    $output = $sqlResult[0];
                    $output["comment"] = mb_split(",", $output["comment"]);
                } 
            }

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $output, self::$errorCode. "-0001");
        }

        //0001
        public static function GetLatest(){
            $postData = Tool::getPost(self::$columnList);
            
            $year = $postData["year"];
            $month = $postData["month"];
            $day = $postData["day"];

            $sql = "SELECT * FROM plan WHERE year = ? and month = ? and day >= ?";
            $sqlResult = Mysql::SQL($sql, array($year, $month, $day));
            $sqlResultType = Tool::typeOfsqlResult($sqlResult); 
            
            if($sqlResultType == "success"){
                if(count($sqlResult) != 1){
                    foreach($sqlResult as $data){
                        $data["comment"] = mb_split(",", $data["comment"]);
                    }

                }else{
                    $data = $sqlResult[0];
                    $data["comment"] = mb_split(",", $data["comment"]);
                } 
            }

            echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $data, self::$errorCode. "-0001");
        }
    }
?>