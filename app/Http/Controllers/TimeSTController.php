<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeSTController extends Controller
{
    public $Helpers;

    public function __construct()
    {
        $this->Helpers = new Helpers();
    }

    public function addEntryForm()
    {
        return view('addEntryForm', ['now' => Carbon::now()->timestamp]);
    }

    public function addEntry(Request $request)
    {
        $input = $request->all();

        if(!$this->Helpers->add_entry($input))
        {
            return response('the time is older than 60 second', 204);

        }

        return response('success', 201);
    }

    public function calcStatistics()
    {
        $result = $this->Helpers->calc_statistics();

        return response(json_encode($result), 200);

    }
}
