<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Application;
use App\District;
use App\Councilor;
use App\Barangay;
use App\Course;
use App\School;
use App\Batch;
use Response;
use Datatables;
class CoordinatorStudentsListController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
    }
    public function index()
    {
        $district = District::where('is_active',1)->get();
        $councilor = Councilor::where('is_active',1)->get();
        $barangay = Barangay::where('is_active',1)->get();
        $school = School::where('is_active',1)->get();
        $course = Course::where('is_active',1)->get();
        $batch = Batch::where('is_active',1)->get();
        return view('SMS.Coordinator.Scholar.CoordinatorStudentsList')->withDistrict($district)->withCouncilor($councilor)->withBarangay($barangay)->withSchool($school)->withCourse($course)->withBatch($batch);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $application = Application::join('users','student_details.user_id','users.id')
        ->select([DB::raw("CONCAT(users.last_name,', ',users.first_name,' ',users.middle_name) as strStudName"),'student_details.*','users.*'])
        ->where('users.type','Student')
        ->where('student_details.application_status','Accepted');
        $datatables = Datatables::of($application)
        ->addColumn('checkbox', function ($data) {
            $checked = '';
            if($data->is_active==1){
                $checked = 'checked';
            }
            return "<input type='checkbox' id='isActive' name='isActive' value='$data->user_id' data-toggle='toggle' data-style='android' data-onstyle='success' data-offstyle='danger' data-on=\"<i class='fa fa-check-circle'></i> Active\" data-off=\"<i class='fa fa-times-circle'></i> Inactive\" $checked data-size='mini'><script>
            $('[data-toggle=\'toggle\']').bootstrapToggle('destroy');   
            $('[data-toggle=\'toggle\']').bootstrapToggle();</script>";
        })
        ->addColumn('forfeit', function ($data) {
            return "<small style='margin-top: 10px;' class='label bg-red'>Yeah</small>";
        })
        ->addColumn('graduated', function ($data) {
            return "<small style='margin-top: 10px;'' class='label bg-green'>Something</small>";
        })
        ->addColumn('action', function ($data) {
            return "<button style='margin-top: 10px;' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i> Edit</button> <button style='margin-top: 10px;' class='btn btn-info btn-sm open-modal'><i class='fa fa-eye'></i> View</button>";
        })
        ->editColumn('strStudName', function ($data) {
            $images = url('images/'.$data->picture);
            return "<table><tr><td><div class='col-md-2'><img src='$images' class='img-circle' alt='User Image' height='60'></div></td><td>$data->last_name, $data->first_name $data->middle_name</td></tr></table>";
        })
        ->setRowId(function ($data) {
            return $data = 'id'.$data->user_id;
        })->rawColumns(['strStudName','forfeit','graduated','checkbox','action']);
        if ($strUserFirstName = $request->get('strUserFirstName')) {
            $datatables->where('users.first_name', 'like', '%'.$strUserFirstName.'%');
        }
        if ($strUserMiddleName = $request->get('strUserMiddleName')) {
            $datatables->where('users.middle_name', 'like', '%'.$strUserMiddleName.'%');
        }
        if ($strUserLastName = $request->get('strUserLastName')) {
            $datatables->where('users.last_name', 'like', '%'.$strUserLastName.'%');
        }
        if ($intDistID = $request->get('intDistID')) {
            $datatables->where('student_details.district_id', 'like', '%'.$intDistID.'%');
        }
        if ($intBaraID = $request->get('intBaraID')) {
            $datatables->where('student_details.barangay_id', 'like', '%'.$intBaraID.'%');
        }
        if ($intBatcID = $request->get('intBatcID')) {
            $datatables->where('student_details.batch_id', 'like', '%'.$intBatcID.'%');
        }
        if ($strPersStreet = $request->get('strPersStreet')) {
            $datatables->where('student_details.street', 'like', '%'.$strPersStreet.'%');
        }
        if ($strPersReligion = $request->get('strPersReligion')) {
            $datatables->where('student_details.religion', 'like', '%'.$strPersReligion.'%');
        }
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('user_id', 'where', 'like', "$keyword%");
            $datatables->filterColumn('strStudName', 'whereRaw', "CONCAT(users.last_name,', ',users.first_name,' ',users.middle_name) like ? ", ["%$keyword%"]);
        }
        return $datatables->make(true);
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}