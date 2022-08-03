<?php

namespace Tests\Unit;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Tests\TestCase;

class calcTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public $Helpers;

    public function __construct()
    {
        parent::__construct();
        $this->Helpers = new Helpers();
    }

    public function test_example()
    {
        $max_random_range = 10000;
        $min_random_range = 1;
        $de = 1000;
        $sum = 0;
        $max = $min_random_range - 1;
        $min = $max_random_range + 1;
        $count = 0;
        $avg = 0;
        $samples = 120;

        $now = Carbon::now()->timestamp;
        for($i=0;$i<$samples;$i++)
        {
            $a = mt_rand($min_random_range, $max_random_range) / $de;

            $this->Helpers->add_entry([
                'amount' => $a,
                'timestamp' => $now - $i
            ]);

            if($i<60)
            {
                $sum += $a;
                $count++;
                $max = max($max, $a);
                $min = min($min, $a);
            }
        }

        $avg = $sum / $count;

        $response = $this->Helpers->calc_statistics();

        $this->assertTrue(
            $response['sum'] == $sum &&
            $response['avg'] == $avg &&
            $response['max'] == $max &&
            $response['min'] == $min &&
            $response['count'] == $count
        );
    }

    public function test_fail()
    {
        $max_random_range = 10000;
        $min_random_range = 1;
        $de = 1000;
        $sum = 0;
        $max = $min_random_range - 1;
        $min = $max_random_range + 1;
        $count = 0;
        $avg = 0;
        $samples = 120;

        $now = Carbon::now()->timestamp;
        for($i=0;$i<$samples;$i++)
        {
            $a = mt_rand($min_random_range, $max_random_range) / $de;

            $this->Helpers->add_entry([
                'amount' => $a,
                'timestamp' => $now - $i - 30
            ]);

            if($i<60)
            {
                $sum += $a;
                $count++;
                $max = max($max, $a);
                $min = min($min, $a);
            }
        }

        $avg = $sum / $count;

        $response = $this->Helpers->calc_statistics();

        $this->assertTrue(
            $response['sum'] != $sum ||
            $response['avg'] != $avg ||
            $response['max'] != $max ||
            $response['min'] != $min ||
            $response['count'] != $count
        );
    }
}
