<?php

namespace App\Helpers;

class Bucket
{
    public $sum, $avg, $count, $max, $min;

    function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->sum = 0;
        $this->avg = 0;
        $this->count = 0;
        $this->max = -1;
        $this->min = -1;
    }

    public function update($amount)
    {
        $this->sum += $amount;
        $this->count++;
        $this->avg = $this->sum / $this->count;
        $this->max = max($this->max, $amount);
        if($this->min == -1)
        {
            $this->min = $amount;
        }
        else
        {
            $this->min = min($this->min, $amount);
        }
    }

    public function combine(Bucket $bucket)
    {
        $this->sum += $bucket->sum;
        $this->count += $bucket->count;
        $this->avg = $this->sum / $this->count;
        $this->max = max($this->max, $bucket->max);
        if($this->min != -1 && $bucket->min != -1)
        {
            $this->min = min($this->min, $bucket->min);
        }
        else
        {
            $this->min = max($this->min, $bucket->min);
        }
    }
}

?>
