<?php

namespace App\Helpers;

use App\Helpers\Bucket;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class Helpers
{
    public function add_entry($input)
    {
        $second = $input['timestamp'];

        $now = Carbon::now()->timestamp;

        if($now - $input['timestamp'] > 60)
        {
            return false;
        }

        $b = Session::get("second_".$second);
        if($b == null)
        {
            $b = new Bucket();
        }
        $b->update($input['amount']);

        Session::put("second_".$second, $b);

        return true;
    }

    public function calc_statistics()
    {
        $now = Carbon::now()->timestamp;
        $B = new Bucket();

        $buckets = [];

        for($i=0;$i<60;$i++)
        {
            $b = Session::get("second_".($now - $i));
            if($b == null)continue;
            $buckets["second_".($now - $i)] = $b;
            $B->combine($b);
        }

        Session::flush();

        foreach($buckets as $key=>$value)
        {
            Session::put($key, $value);
        }

        if($B->max == -1)
        {
            $B->max = $B->min = 0;
        }

        return ['sum' => $B->sum, 'avg' => $B->avg, 'max' => $B->max, 'min' => $B->min, 'count' => $B->count];

    }
}

?>
