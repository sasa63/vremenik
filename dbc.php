<?php

class dbc extends PDO {
    var $pre='';
   
    public function query($sql){
        $patern='%PREFIKS%';
        $sql = str_replace($patern,$this->pre, $sql);
        
        return parent::query($sql);
    }
    public function pre($p){
        if($p!='') $this->pre=$p;
    }
}
