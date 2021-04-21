<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\DatabaseManager;
use Yajra\Datatables\Datatables;
use App\PsPHICCF4;
use App\stations;
use App\EntryLog;
use App\Entrances;
use Session;

use Illuminate\Support\Facades\Auth;


class EntryController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index() {

    }  

    public function update(Request $request,$id)
    {
              
    }

    public function store(Request $request)
    {        
        date_default_timezone_set('Asia/Manila');
        $getEntrance = Entrances::where(['ent_code'=>strtolower($request->code)])->first();        
        $EntryLog = new EntryLog; 
        $EntryLog->created_by = $request->name;
        $EntryLog->user_id = $request->user_id;
        $EntryLog->entrance_id = $getEntrance->entrance_id;
        $EntryLog->entrance_datetime = date("m/d/Y H:i:s");
        $EntryLog->created_dt = date("m/d/Y H:i:s");
        $EntryLog->save();
        return json_encode($EntryLog);   
    }

    public function delete(Request $request)
    {
        # code...
    }

    public function getTodaysLog($id)
    {
        date_default_timezone_set('Asia/Manila');
        $gdate = date("Y-m-d");
        $data = 'SELECT * from visited_entrance where date(created_dt) ='. "'".$gdate."'" .'and user_id = '.$id.' order by visited_entrance_id desc';
        $getEntrance = DB::connection('pgsql')->select($data); 
        $data = array();
        foreach ($getEntrance as $value) {
            $arr = array();
            $getEntrances = Entrances::where(['entrance_id'=>strtolower($value->entrance_id)])->first();  
            $arr['datetime'] = $value->entrance_datetime;
            $arr['entrance'] = $getEntrances->ent_description;
            $data[] = $arr;
        }  
        return json_encode($data);     
    }

    public function entry_log2(Request $request)
    {
        //decode the json data passe by pwa cf4
        //$data = json_decode($request->get('data'), true);          
        return json_encode($request->asked_to_self_isolate);     
  
    }
    
    public function getHistory(Request $request){  
        $data = json_decode($request->get('data'), true);
        //SELECT * from visited_entrance where date(created_dt) >= '2020-07-27' and date(created_dt) <= '2020-07-27' order by visited_entrance_id desc
        $data = 'SELECT * from visited_entrance where date(created_dt) >='. "'".$request->fdate."' and date(created_dt) <=". "'".$request->tdate."'".' and user_id = '.$request->user_id.' order by visited_entrance_id desc';
        $getEntrance = DB::connection('pgsql')->select($data); 
        $data = array();
        foreach ($getEntrance as $value) {
            $arr = array();
            $getEntrances = Entrances::where(['entrance_id'=>strtolower($value->entrance_id)])->first();  
            $arr['datetime'] = $value->entrance_datetime;
            $arr['entrance'] = $getEntrances->ent_description;
            $data[] = $arr;
        }  
        return json_encode($data); 
    }
}
