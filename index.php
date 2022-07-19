 <?php
 //permet d'afficher les érreurs php sur la page web
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
 //on définit la timezone
 date_default_timezone_set('UTC');
 require('src/Calendar/Month.php');
 require('src/Calendar/Events.php');
 require('src/Account/User.php');
 require('src/utility.php');
 $pdo = get_pdo(); 
 try{
    $month = new Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
 }catch(\Exception $e){
    $month = new Calendar\Month();
 }
 $events = new Calendar\Events($pdo);
 $start = $month->getStartingDay();
 
 $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
 $weeksPermonth = $month->getWeeks();
 $end = (clone $start)->modify("+" .(6 + 7* ($weeksPermonth - 1)). " days");
 if(!empty($_POST)){
     @$login = $_POST['login'];
     @$changeDate = $_POST['changeDate'];
     if(isset($login)){
         $username = $_POST['username'];
         $password = $_POST['password'];
         $userId = \Account\User::login($username,$password, $pdo);
         if($userId != 0){
            $eventsBymonth = $events->getEventsBetweenByDay($start, $end, $userId) ;
         }
     }if(isset($changeDate)){
        $month = new Calendar\Month($_POST['select-month'], $_POST['year']);
     }
     
 }
 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
     <title>Events Calendar</title>
 </head>
 <body>
     <div class="container">
         <div class="topnav" id="myTopnav"> 
            <a href="#home" class="active">Calendrier</a>        
            <a href=""><?= !empty($_POST['username']) && isset($login) && $userId != 0 ? 'connecté en tant que: ': 'Non connecté';?><strong><?= !empty($_POST['username']) && $userId != 0 ? $username : ''; ?></strong></a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
         </div>
         <div class="auth">
         <div class="gray asap m-l3">
             <p id ="error-login"><?= !empty($_POST) && isset($login) && $userId == 0 ? 'Identifiants incorrect': '';?></p>
            <form class="" method="POST">
                <div class="flex flex-column md-flex-row max-w-90pc mx-auto">
                <input type="text" required name="username" class="input m-2" placeholder="nom d'utilisateur">
                <input type="password" name="password"class="input m-2" required placeholder="mot de passe">
                <button type="submit" name="login" class="button m-2">Envoyer</button>
                </div>
            </form>
         </div>
         </div>
         <div >
             <div class="choose-month-years">
                <button class="btnGoTo"><a href="index.php?month=<?= $month->prevMonth()->month; ?>&&year=<?= $month->prevMonth()->year; ?>">&lt&lt</a></button>
                <h1><?php echo $month->toString(); ?></h1>
                <button class="btnGoTo"><a href="index.php?month=<?= $month->nextMonth()->month; ?>&&year=<?= $month->nextMonth()->year; ?>">&gt&gt</a></button>
             </div>
             <div class="select-text-ym">
                <form action="" method="POST">
                    <select name="select-month" required id="selectMo">                    
                        <option value="1" <?= $month->month == 1 ? 'selected' : '' ;?>>Janvier</option>
                        <option value="2" <?= $month->month == 2 ? 'selected' : '' ;?>>Février</option>
                        <option value="3" <?= $month->month == 3 ? 'selected' : '' ;?>>Mars</option>
                        <option value="4" <?= $month->month == 4 ? 'selected' : ''; ?>>Avril</option>
                        <option value="5" <?= $month->month == 5 ? 'selected' : '' ;?>>Mai</option>
                        <option value="6" <?= $month->month == 6 ? 'selected' : '' ;?>>Juin</option>
                        <option value="7" <?= $month->month == 7 ? 'selected' : '' ;?>>Juillet</option>
                        <option value="8" <?= $month->month == 8 ? 'selected' : '' ;?>>Août</option>
                        <option value="9" <?= $month->month == 9 ? 'selected' : '' ;?>>Septembre</option>
                        <option value="10"<?= $month->month == 10 ? 'selected' : '' ;?>>Octobre</option>
                        <option value="11"<?= $month->month == 11? 'selected' : '' ;?>>Novembre</option>
                        <option value="12"<?= $month->month == 12 ? 'selected' : '' ;?>>Décembre</option>
                    </select>
                    <input type="text" name="year" required placeholder="2022" value="<?= $month->year ; ?>">
                    <button type="submit" name="changeDate" class="button m-2">Afficher</button>
                </form>
             </div>
            <table class="calendar calendar-<?php $weeksPermonth; ?>weeks"  >
                <?php for ($i = 0; $i < $weeksPermonth; $i++): ?>
                <tr>
                    <?php foreach($month->days as $k => $day):  
                        $date = (clone $start)->modify("+" . ($k + $i*7) . " days");
                        $eventsForDay = $eventsBymonth[$date->format('Y-m-d')] ?? [];
                    ?>
                    <td id="<?= $month->getCurrentDay()->format('Y-m-d') === $date->format('Y-m-d') ? 'currentDay' : ''; ?>" 
                    class ="<?= $day === 'Samedi' ? 'weekendS' : ''; ?><?= $day === 'Dimanche' ? 'weekendD' : ''; ?>">
                        <?php if($i === 0): ?>
                        <div class="calenday-weekDay"><?= $day; ?></div>
                        <?php endif;?>  
                        <div class="<?= $month->withingMonth($date) ? 'calendar-day' : 'calendar-othermonth'; ?>"><?= $date->format('d'); ?></div>
                        <?php foreach($eventsForDay as $event): ?>
                        <div class="calendar-events">
                        <?= (new Datetime($event['start']))->format('H:i'); ?> - <a href="#oneEvent"><?= $event['name']; ?></a>
                        </div>
                        <?php endforeach; ?>
                    </td>
                     
                    <?php endforeach; ?>                    
                </tr>
                <?php endfor; ?>
            </table>
            <div class="containers">
                <div class="row">
                    <div class="col-4">
                        <h3>Mes prochains évènements.</h3>
                    </div>
                    <div class="col-8" id="oneEvent">
                        <h3>Evenement du jour XXXX</h3>                        
                    </div>
                </div>
            </div>
         </div>
     </div>
    <script src="index.js"></script>
 </body>
 </html>