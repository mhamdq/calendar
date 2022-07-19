<?php

namespace Calendar;

class Events{
    private $pdo;
    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }
    /**
     * retourne les une liste d'évènements entre deux dates
     * @param \Datetime
     * @param \Datetime
     * @param int
     * @return array
     */
    public function getEventsBetween(\Datetime $start, \DateTime $end,$id):array{

        $req = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' AND createdBy = $id";

        $statement = $this->pdo->query($req);
        $result = $statement->fetchall();
        return $result;
        
    }
        /**
     * retourne les une liste d'évènements entre deux dates et renvoi par jour
     * @param \Datetime
     * @param \Datetime
     * @param int
     * @return array
     */
    public function getEventsBetweenByDay(\Datetime $start, \DateTime $end, $id):array{

       $events = $this->getEventsBetween($start, $end,$id);
       $days = [];
       foreach($events as $event){
        $date =explode(' ', $event['start'])[0];

        if(!isset($days[$date])){
            $days[$date] = [$event];

        }else{
            $days[$date][] = $event;
        }

       }
        return $days;
        
    }

}

?>