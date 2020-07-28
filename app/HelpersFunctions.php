<?php

function get_controller($controller,string $method=''){
    if($method!=''){
        return '\\'.$controller.'@'.$method;
    }else{
        return '\\'.$controller;
    }
}