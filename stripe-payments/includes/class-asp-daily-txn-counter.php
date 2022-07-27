<?php
class ASP_Daily_Txn_Counter{

    private $txn_counter_option_name;
    private $txn_counter_limit;
    private $today;

    public function __construct() {
        $this->txn_counter_option_name='asp_daily_txn_count_args';
        $this->txn_counter_limit=20;
        $this->today=date("Y-m-d");        
	}

    //Resets or get the current counter
    public function asp_get_daily_txn_counter()
    {
        $txn_counter_args = get_option( $this->txn_counter_option_name );

        if (!$txn_counter_args){            
            
            //If txn_counter don't exists , create and return new as zero
            return $this->asp_reset_daily_txn_counter();
        }
        else{

            if($this->today!=$txn_counter_args["counter_date"])
            {
                return $this->asp_reset_daily_txn_counter();
            }            
        }

        return $txn_counter_args;

    }

    public function asp_increment_daily_txn_counter()
    {
            $txn_counter_args = $this->asp_get_daily_txn_counter();
                
            $txn_counter_args["counter"]++;            
            update_option($this->txn_counter_option_name, $txn_counter_args);

            return $txn_counter_args;        
    }

    public function asp_is_daily_txn_limit_reached()
    {
        $txn_counter_args = $this->asp_get_daily_txn_counter();
        if($txn_counter_args["counter"] >= $this->txn_counter_limit) 
        {
            return true;
        }
        return false;

    }
    
    private function asp_reset_daily_txn_counter()
    {                    
            $txn_counter_args = array('counter_date' => $this->today, 'counter' => 0 );
            update_option($this->txn_counter_option_name, $txn_counter_args);     
            
            return $txn_counter_args;
    }


}