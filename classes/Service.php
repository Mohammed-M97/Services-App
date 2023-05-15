<?php 

class Service {
    public $available = true;
    public $taxRate = 0;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function all(){
        return [
            ['name' => 'Consultation', 'price' => 500, 'days' => ['Sun', 'Mon'] ],
            ['name' => 'Training', 'price' => 200, 'days' => ['Tues', 'Wed'] ],
            ['name' => 'Design', 'price' => 100, 'days' => ['Thu', 'Fri'] ],
            ['name' => 'Coding', 'price' => 1000, 'days' => ['Sat', 'Mon'] ],
        ];
    }

    public function price($price) {
        if ($this->taxRate > 0) {
            return $price + ($price * $this->taxRate);
        }
        return $price;
    }
}
