<?php 
namespace Calendar;
// permet d'éviter les conflits, on utilise les namespaces
/**
 * permet de gérer le calendrier gestion mois et année
 */
class Month
{
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
     'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
     public $days = ['Lundi', 'Mardi', 'Mercedi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

     public $month;
     public $year;

    /**
     * Contructeur du mois
     * @param int $month : le mois compris entre 1 et 12
     * @param int year l'année
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year= null){
        
        if($month === NULL || $month < 1 || $month > 12){
            $month = intval(date('m'));
        }
        if($year === NULL){
            $year = intval(date('Y'));
        }        
        $this->month = $month;
        $this->year = $year;
    }
    /**
     * Renvoi le premier jour du mois
     * @return \Datetime
     */
    public function getStartingDay():\Datetime{
        return new \Datetime("{$this->year}-{$this->month}-01");
    }
    /**
     * Renvoi le premier jour encour 
     * @return \Datetime
     */
    public function getCurrentDay():\Datetime{
        return new \Datetime();
    }
    /**
     * Permet de savoir si le jour est dans le mois en cour
     * @param \Datetime $sdate
     * @return bool
     */
     public function withingMonth(\Datetime $sdate):bool{
         return $this->getStartingDay()->format('Y-m') === $sdate->format('Y-m');
     }
     /**
      * permet de renvoyer le mois suivant
      *@return \Calendar\Month
      */
     public function nextMonth(): Month{
         $month = $this->month + 1;
         $year = $this->year;
         if($month > 12){
             $month = 1;
             $year = $year + 1;
         }

         return new Month($month, $year);
     }
      /**
      * permet de renvoyer le mois précedent
      *@return \Calendar\Month
      */
      public function prevMonth(): Month{
        $month = $this->month - 1;
        $year = $this->year;
        if($month < 1){
            $month = 12;
            $year = $this->year - 1;
        }

        return new Month($month, $year);
    }




    /**
     * Retourne le mois et l'année en toute lettre et en Français ex: Avril
     * @return string
     */
    public function toString():string{
        return $this->months[$this->month-1].' '.$this->year;
    }

    /**
     * permet de calculer le nombre de semaines par mois
     * @return int
     */
    public function getWeeks():int {

        $start = $this->getStartingDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        if($weeks < 0 ) {
            $weeks = intval($end->format('W')) +1;
        }
         return $weeks;
    }


}

?>