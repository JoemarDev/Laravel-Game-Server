<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basketball;

class BasketballController extends Controller
{
    //

	// Testing Database fetch connection 
    function index(){
    	return Basketball::All();
    }


    // Generate 10 Years Result
    function generate_result() 
    {
    	// Define the minute interval for each result
    	$minute_to_add = 1;

    	date_default_timezone_set("Asia/Seoul");


    	$latest = Basketball::latest()->limit(1)->get();
    	
    	if (count($latest) > 0) {
    		$DateStart = date('Y-m-d H:i',strtotime($latest[0]['created_at']));
    	} else {
    		$DateStart = null;
    	}

    	$result_holder = [];

    	$data = null;


    	for ($i = 1; $i <= 43800; $i++):

    		if ($DateStart != null):
    			$date = strtotime('+'. $i .' minutes', strtotime($DateStart));
    		else:
    			$date = strtotime('+'. $i .' minutes', strtotime(date('Y-m-d H:i')));
    			$DateStart = date('Y-m-d H:i');
    		endif;


    		$hourRound =  date("G", $date) * 60;
    		$minuteRound =  date("i", $date);
    		$round = $hourRound + $minuteRound;

    		$obj['date'] = date('Y-m-d H:i', $date);
    		
    		$predict = Rand(0,3);
    		switch ($predict) {
    			case 0:
    				$obj['result'] = ['left','Odd','4Lines'];
    				break;
    			case 1:
    				$obj['result'] = ['left','Even','3Lines'];
    				break;
    			case 2:
    				$obj['result'] = ['right','Odd','3Lines'];	
    			default:
    				$obj['result'] = ['right','Even','4Lines'];
    				break;
    		}

    		Basketball::insert(
    			[
    				'result_type_one' => $obj['result'][0],
    				'result_type_two' => $obj['result'][1],
    				'result_type_three' => $obj['result'][2],
    				'round' => $round,
    				'created_at' => $obj['date'],
    			]
    		);
    	endfor;

    }

}
