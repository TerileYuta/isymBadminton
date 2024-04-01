<?php
    //EroorCode:7000-

    class Score{
        public static $errorCode = "7000";
        public static $tableName = "score";
        public static $columnList = array("id", "season", "tournament", "gn", "a1", "a2", "b1", "b2", "memo", "link", "date", "winner", "loser");

        //0001-0001
        public static function Get() {
            $postData = Tool::getPost(self::$columnList);

            $sqlResult = MySql::SELECT(self::$tableName, $postData);
            $resultType = Tool::typeOfsqlResult($sqlResult);
            $returnData = array();

            if($resultType == "success"){
                foreach($sqlResult as $data){
                    list($winner, $loser, $a_game, $b_game) = self::Judge(array("a1" => $data["a1"], "a2" => $data["a2"] , "g1"=> intval($data["ag1"]), "g2" => intval($data["ag2"]), "g3" => intval($data["ag3"])), array("b1" => $data["b1"], "b2" => $data["b2"] , "g1" => intval($data["bg1"]), "g2" => intval($data["bg2"]), "g3" => intval($data["bg3"])));
    
                    $data["aGame"] = $a_game;
                    $data["bGame"] = $b_game;
                    
                    $data["a1"] = Member::GetInfoByID($data["a1"]);
                    $data["b1"] = Member::GetInfoByID($data["b1"]);
    
                    if($data["a2"] == 0){
                        $data["a2"] = "";
                    }else{
                        $data["a2"] = Member::GetInfoByID($data["a2"]);
                    }
                    if($data["b2"] == 0){
                        $data["b2"] = "";
                    }else{
                        $data["b2"] = Member::GetInfoByID($data["b2"]);
                    }
    
                    array_push($returnData, $data);
                }
            }

            echo Tool::Output($resultType, $returnData, self::$errorCode. "-0001");
        }

        //0002-0003
        public static function Action(){
            $postData = Tool::getPost(array("season", "tournament", "id", "a", "b", "memo"));

            $a = json_decode($postData["a"], true);
            $b = json_decode($postData["b"], true);

            list($winner, $loser, $a_game, $b_game) = self::Judge($a, $b);

            if(isset($postData["id"])){
                $sql = "UPDATE SET score (season, tournament, a1, a2, b1, b2, ag1, ag2, ag3, bg1, bg2, bg3, memo, winner,loser) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) WHERE id = ?";
            
                if(!isset($postData["memo"])){
                    $postData["memo"] = "";
                }

                $sqlResult = MySql::SQL($sql, array($postData["season"], $postData["tournament"], $a["a1"], $a["a2"], $b["b1"], $b["b2"], $a["g1"], $a["g2"], $a["g3"], $b["g1"], $b["g2"], $b["g3"], $postData["memo"], $winner, $loser, $postData["id"]));

                echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0002");
            }else{
                $sql = "INSERT INTO score (season, tournament, a1, a2, b1, b2, ag1, ag2, ag3, bg1, bg2, bg3, memo, winner,loser) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
                if(!isset($postData["memo"])){
                    $postData["memo"] = "";
                }
    
                $sqlResult = MySql::SQL($sql, array($postData["season"], $postData["tournament"], $a["a1"], $a["a2"], $b["b1"], $b["b2"], $a["g1"], $a["g2"], $a["g3"], $b["g1"], $b["g2"], $b["g3"], $postData["memo"], $winner, $loser));

                echo Tool::Output(Tool::typeOfsqlResult($sqlResult), $sqlResult, self::$errorCode. "-0003");
            }

        }

        public static function Delete($id){
            $sql = "DELETE from score WHERE id = ?";
            MySql::SQL($sql, array($id));
        }

        public static function Judge($a, $b){
            $a_game = 0;
            $b_game = 0;


            if(($a["g1"] == 21) || (($a["g1"] >= 22) && ($a["g1"] - $b["g1"] == 2))){
                $a_game ++;
            }else{
                $b_game ++;
            }

            if(($a["g2"] == 21) || (($a["g2"] >= 22) && ($a["g2"] - $b["g1"] == 2))){
                $a_game ++;
            }else{
                if($b["g2"] != 0){
                    $b_game ++;
                }
            }

            if(($a["g3"] == 21) || (($a["g3"] >= 22) && ($a["g3"] - $b["g3"] == 2))){
                $a_game ++;
            }else{
                if($b["g3"] != 0){
                    $b_game ++;
                }
            }

            if($a_game > $b_game){
                return array($a["a1"]. "-". $a["a2"], $b["b1"]. "-". $b["b2"], $a_game, $b_game);
            }else{
                return array($b["b1"]. "-". $b["b2"], $a["a1"]. "-". $a["a2"], $a_game, $b_game);
            }
        }
    }
?>