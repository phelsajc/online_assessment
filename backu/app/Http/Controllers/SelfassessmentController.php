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
use App\Selfassessment;
use App\Users;
use Session;

use Illuminate\Support\Facades\Auth;


class SelfassessmentController extends Controller
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
        $checkData = Users::where(['user_id'=>strtolower($request->user_id)])->first();  
        $checkSupervisor = Users::where(['is_supervisor'=>1,'department_id'=>$checkData->department_id])->get();  
        
        Selfassessment::where(['user_id'=>$request->user_id])->update([
            'row_status'=>0
        ]);      
        $EntryLog = new Selfassessment; 
        $EntryLog->user_id = $request->user_id;
        $EntryLog->assessment_datetime = date("m/d/Y H:i:s");
        $EntryLog->fever = $request->fever;
        $EntryLog->loss_of_smell = $request->loss_of_smell;
        
        $EntryLog->cough = $request->cough;
        $EntryLog->muscle_aches = $request->muscle_aches;
        $EntryLog->sore_throat = $request->sore_throat;
        $EntryLog->shortness_of_breath = $request->shortness_of_breath;
        $EntryLog->chills = $request->chills;
        
        $EntryLog->headache = $request->headache;
        $EntryLog->vomiting_diarrhea_loss_of_appetite = $request->vomiting_diarrhea_loss_of_appetite;
        $EntryLog->close_contact_with_covid_patient = $request->close_contact_with_covid_patient;
        $EntryLog->asked_to_self_isolate = $request->asked_to_self_isolate;
        $EntryLog->row_status = 1;
        $EntryLog->created_dt = date("m/d/Y H:i:s");
        $EntryLog->created_by = $request->user_id;
        $EntryLog->save();          

        if($request->fever==1||$request->loss_of_smell==1||$request->cough==1||$request->muscle_aches==1||$request->sore_throat==1||$request->shortness_of_breath==1||$request->chills==1||$request->headache==1||
        $request->vomiting_diarrhea_loss_of_appetite==1||$request->close_contact_with_covid_patient==1||$request->asked_to_self_isolate==1){
            $text_message =  $checkData->lastname.", ".$checkData->firstname." has a YES answer in 11 questions in selfassessment.";
            foreach ($checkSupervisor as $key) {
                $clean_mobile = preg_replace("/[^A-Za-z0-9\_ -']/", '',$key->contact_no);
                $emp_cell_no = array($clean_mobile);        
                foreach ($emp_cell_no as  $value) {
                   /*  $info_txt_msg = DB::connection('infotxt')
                                ->statement("DECLARE @date DATETIME = GETDATE()
                                                SET ANSI_NULLS ON; SET ANSI_WARNINGS ON; EXEC [sp_SaveToOutbox] '$value','$text_message',@date,3,'IOD',2,0"); */
                }
            }
        }
        
        /* $clean_mobilex = preg_replace("/[^A-Za-z0-9\_ -']/", '',"09263218740");
        $emp_cell_nox = array($clean_mobilex);     
        foreach ($emp_cell_nox as  $value) {
              $info_txt_msg = DB::connection('infotxt')
                            ->statement("DECLARE @date DATETIME = GETDATE()
                                            SET ANSI_NULLS ON; SET ANSI_WARNINGS ON; EXEC [sp_SaveToOutbox] '$value','$text_message',@date,3,'IOD',2,0");
        } */
        return json_encode($EntryLog);   
    }

    public function delete(Request $request)
    {
        # code...
    }     
}
