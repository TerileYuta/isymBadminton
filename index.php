<?php
    //header("Access-Control-Allow-Origin: *");

    use function PHPSTORM_META\map;

    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/api/Tool.php';
    require_once __DIR__ . '/api/User.php';
    require_once __DIR__ . '/api/Member.php';
    require_once __DIR__ . '/api/Score.php';
    require_once __DIR__ . '/api/Setting.php';
    require_once __DIR__ . '/api/Menu.php';
    require_once __DIR__ . '/api/Comment.php';
    require_once __DIR__ . '/api/TimeLine.php';
    require_once __DIR__ . '/api/Plan.php';
    require_once __DIR__ . '/api/Diary.php';
    require_once __DIR__ . '/api/Video.php';
    require_once __DIR__ . '/api/MySql.php';

    //ルーティングライブラリ
    $router = new AltoRouter();

    //.ENVファイル読み込み
    Dotenv\Dotenv::createImmutable(__DIR__)->load();

    //MySQLAPI設定
    MySql::$dbname = $_ENV["DB_NAME"];
    MySql::$host = $_ENV["DB_HOST"];
    MySql::$user = $_ENV["DB_USER"];
    MySql::$password = $_ENV["DB_PASSWORD"];
    MySql::CreatePDO();

        
    $router->map('GET | POST', '/', function(){
        require_once __DIR__. "/src/index.html";
    }, "index");

    //User
    $router->map('GET | POST', "/api/user/login", "User::Login", "login");
    $router->map('GET | POST', "/api/user/token/auth", "User::Auth", "auth");
    $router->map('GET | POST', "/api/user/add", "User::UserAdd", "userAdd");
    $router->map('GET | POST', "/api/user/password", "User::Password", "chnagePassword");


    //Setting
    $router->map('GET | POST', "/api/setting/get_school", "Setting::GetSchool", "getSchool");//OK
    $router->map('GET | POST', "/api/setting/get_tournament", "Setting::GetTournament", "getTournament");//OK
    $router->map('GET | POST', "/api/setting/get_route", "Setting::GetRoute", "getRoute");//OK
    $router->map('GET | POST', "/api/setting/route/action", "Setting::routeAction", "routeAction");//OK

    //Member
    $router->map('GET | POST', "/api/member/get", "Member::Get", "getMemeber");//OK
    $router->map('GET | POST', "/api/member/action", "Member::Action", "memberAction");
    
    //Score
    $router->map('GET | POST', "/api/score/get", "Score::Get", "getScore");//OK
    //$router->map('GET | POST', "/api/score/like_get", "Score::Get", "getScore");//OK
    $router->map('GET | POST', "/api/score/action", "Score::Action", "scoreAction");
    $router->map('GET | POST', "/api/score/delete", function(){echo Score::Delete($_POST["id"]);}, "delete");

    //Menu
    $router->map('GET | POST', "/api/menu/get", "Menu::Get", "getMenu");//OK
    $router->map('GET | POST', "/api/menu/action", "Menu::Action", "menuAction");

    //TimeLine
    $router->map('GET | POST', "/api/timeline/get", "TimeLine::Get", "getTimeline");
    $router->map('GET | POST', "/api/timeline/action", "TimeLine::Action", "timelineAdd");
    $router->map('GET | POST', "/api/timeline/good", "TimeLine::Good", "timelineGood");
    $router->map('GET | POST', "/api/timeline/comment", "TimeLine::Comment", "timelineComment");

    //Comment
    $router->map('GET | POST', "/api/comment/get", "Comment::Get", "getComment");
    $router->map('GET | POST', "/api/comment/add", "Comment::Add", "addComment");

    //Video
    $router->map('GET | POST', "/api/video/get", "Video::Get", "getVideo");
    $router->map('GET | POST', "/api/video/action", "Video::Action", "actionVideo");

    //Plan
    $router->map("GET | POST", "/api/plan/index", "Plan::Index", "indexPlan");
    $router->map("GET | POST", "/api/plan/get", "Plan::Get", "getPlan");
    $router->map("GET | POST", "/api/plan/get/latest", "Plan::GetLatest", "getPlanLatest");

    //Diary
    $router->map("GET | POST", "/api/diary/get", "Diary::Get", "getDiary");
    $router->map("GET | POST", "/api/diary/action", "Diary::Action", "actionDiary");
    
    $match = $router->match();
        
    if ($match !== false) {
        if (is_callable($match['target'])) {
            $match['target']();
        } else {
            $params = explode("::", $match['target']);
            //$action = new $params[0]();
            //call_user_func_array(array($action, $params[1]), $match['params']);
        }
    } else {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }
?>