<?php
    class Tool{
        public static function getPost($postData) {
            $output = array();

            foreach($postData as $order){
                if(isset($_POST[$order])){
                    $postData = trim($_POST[$order]);
                    if($postData != ""){
                        $output[$order] = $postData;
                    }
                }
            }

            return $output;
        }

        public static function typeOfsqlResult($sqlResult){           
            if(gettype($sqlResult) == "array"){
                return "success";
            }else{
                return "error";
            }
        }

        public static function Output($type = "", $data, $errorCode){
            if($type == "success"){
                $output = array("type" => $type, "data" => $data);
                echo json_encode($output);
            }else{
                $sqlResult = Mysql::SELECT("error", array("code" => $errorCode))[0];
                $output = array("type" => "error", "data" => array("title" => $sqlResult["title"], "message" => $sqlResult["message"], "code" => $errorCode, "url" => $sqlResult["url"], "data" => $data));
                echo json_encode($output);
            }
        }
    }
?>