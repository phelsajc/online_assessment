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
use Session;



use Illuminate\Support\Facades\Auth;


class PatientController extends Controller
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
       $db = app('db');
        $outpatients="     SELECT    b.PK_psPatRegisters,
        e.patid as PatientID,
        d.fullname AS PatientFullname,
        b.PK_psPatRegisters,
        b.registrystatus,
        CONVERT(date, birthdate) AS birthdate,
        gender,
        b.pattrantype,
        b.registrystatus AS RegStatus,
        CASE WHEN a.newbornstatus = 'W' AND isnull(a.FK_mscNrstation, '') = ''
        THEN
        (SELECT bb.description FROM psAdmissions as aa LEFT OUTER JOIN mscNrstation as bb ON aa.FK_mscNrstation = bb.PK_mscNrstation WHERE aa.FK_psPatRegisters = a.FK_psPatRegisters_OB)
        ELSE
            h.description END AS [NurseStation],
        a.FK_psRooms AS RoomNo,
        dbo.udf_getfullname(f.FK_emdDoctors) AS DoctorName,
        f.FK_emdDoctors,
        ISNULL(g.description, '') AS Role,
        registrydate AS AdmissionDate
        FROM dbo.psAdmissions AS a INNER JOIN
        dbo.emdPatients AS e ON a.FK_emdPatients = e.PK_emdPatients INNER JOIN
        dbo.psPersonaldata AS c ON e.PK_emdPatients = c.PK_psPersonalData INNER JOIN
        dbo.psDatacenter AS d ON e.PK_emdPatients = d.PK_psDatacenter INNER JOIN
        dbo.psPatRegisters AS b ON b.PK_psPatRegisters = a.FK_psPatRegisters LEFT JOIN
        dbo.psDctrLedgers AS f ON f.FK_psPatRegisters = b.PK_psPatRegisters LEFT JOIN
        dbo.emdDoctors AS j ON j.PK_emdDoctors = f.FK_emdDoctors LEFT JOIN
        dbo.emdTempConsultantTypes AS g ON f.FK_emdConsultantTypes = g.PK_emdTempConsultantTypes LEFT JOIN
        dbo.mscNrstation h ON a.FK_mscNrstation = h.PK_mscNrstation
        WHERE    (b.pattrantype in ('I')) AND (b.registrystatus NOT IN ('D', 'X'))
        AND        dbo.udf_getfullname(f.FK_emdDoctors) ='JARDINICO, M.D., JEANETTE M. '";

        $bizboxPatients = $db->connection('bizbox');
        $patients = $bizboxPatients->select($outpatients);
        $object = (object) ['Avatar' => 'Here we go','CustomerId' => 'Here we go','DisplayName' => 'Here we go','Email' => 'Here we go','FirstName' => 'Here we go'
        ,'Id' => 'Here we go','IsSuper' => 'Here we go','LastName' => 'Here we go','Thumbnail' => 'Here we go','Token' => 'Here we go','UserId' => 'Here we go','UserType' => 'Here we go'];
        return json_encode($patients);
    }

    public function getPatientDetail($id){
        $data = "SELECT * from patients where pk_pspatregisters ='$id'";
        $query = DB::connection('pgsql')->select($data);

        $data2 = 'SELECT * FROM public."psPHICCF4" where "FK_psPatRegisters" = '.$id;
        $query2 = DB::connection('pgsql')->select($data2);

        $data3 = 'SELECT PK_psPHICCF4DctrOrder as "Id",remarks as "Remarks", "orderDate" FROM public."psPHICCF4DctrOrder" where "FK_psPatRegisters" ='.$id;
        $query3 = DB::connection('pgsql')->select($data3);

        /* $output = array("data" => $data,'code'=>$code );
        echo json_encode($output); */
        $output = array("data" => $query, "cf4" => $query2, "Collections" => $query3 );
        return json_encode($output);
    }

    public function store(Request $request)
    {
        //decode the json data passe by pwa cf4
        $data = json_decode($request->get('data'), true);
        $filter = array();
        foreach ($data['Collections'] as $value) {
            $arr = array();
            $arr['remarks'] = $value['Remarks'];
            $filter[] = $arr;
        }
        return json_encode($data);        
    }

    public function update(Request $request,$id)
    {
        //decode the json data passe by pwa cf4
        $data = json_decode($request->get('data'), true);
        /* $filter = array();
        foreach ($data['Collections'] as $value) {
            $arr = array();
            $arr['remarks'] = $value['Remarks'];
            $filter[] = $arr;
        } */
        return json_encode($data);         
    }

    public function entry_log(Request $request)
    {
        //decode the json data passe by pwa cf4
        //$data = json_decode($request->get('data'), true);
        /* $filter = array();
        foreach ($data['Collections'] as $value) {
            $arr = array();
            $arr['remarks'] = $value['Remarks'];
            $filter[] = $arr;
        } */    
        //return json_encode($data);     
        
        $getEntrance = Entrances::where(['ent_code'=>strtolower($request->code)])->first();
        
        $EntryLog = new EntryLog; 
        $EntryLog->created_by = $request->name;
        $EntryLog->user_id = $request->user_id;
        $EntryLog->entrance_id = $getEntrance->entrance_id;
        $EntryLog->entrance_datetime = date("Y-m-d H:i:s");
        $EntryLog->created_dt = date("Y-m-d");
        $EntryLog->save();
        return json_encode($EntryLog);   
    }
}
