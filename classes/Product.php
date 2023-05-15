<?php

class product extends Service {

    public static function alls(){
        return [
            ['name' => 'Phone', 'price' => 500,],
            ['name' => 'Mouse', 'price' => 50,],
            ['name' => 'Keyboard', 'price' => 100,],
        ];
    }
}