 <?php
 function dd(...$vars){
     foreach($vars as $var){

        echo '<pre>';
        print_r($var);
        echo '<pre>';
     }
 }
function get_pdo(){
    $pdo = new \PDO('mysql:host=localhost;dbname=calendarevents', 'root', '',[
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ]);

    return $pdo;
}


 ?>

