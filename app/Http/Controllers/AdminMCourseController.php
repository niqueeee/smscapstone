<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Course;
use Response;
use Datatables;
use Input;
class AdminMCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function data()
    {   
        $course = Course::all();
        return Datatables::of($course)
        ->addColumn('action', function ($data) {
            return "<button class='btn btn-warning btn-xs btn-detail open-modal' value='$data->id'><i class='fa fa-edit'></i> Edit</button> <button class='btn btn-danger btn-xs btn-delete' value='$data->id'><i class='fa fa-trash-o'></i> Delete</button>";
        })
        ->editColumn('isActive', function ($data) {
            $checked = '';
            if($data->is_active==1){
                $checked = 'checked';
            }
            return "<input type='checkbox' id='isActive' name='isActive' value='$data->id' data-toggle='toggle' data-style='android' data-onstyle='success' data-offstyle='danger' data-on=\"<i class='fa fa-check-circle'></i> Active\" data-off=\"<i class='fa fa-times-circle'></i> Inactive\" $checked data-size='mini'><script>
            $('[data-toggle=\'toggle\']').bootstrapToggle('destroy');   
            $('[data-toggle=\'toggle\']').bootstrapToggle();</script>";
        })
        ->setRowId(function ($data) {
            return $data = 'id'.$data->id;
        })
        ->rawColumns(['isActive','action'])
        ->make(true);
    }
    public function checkbox($id)
    {
        try
        {
            $course = Course::findorfail($id);
            if ($course->is_active) {
                $course->is_active=0;
            }
            else{
                $course->is_active=1;
            }
            $course->save();
        }
        catch(\Exception $e) {
            try{
                if($e->errorInfo[1]==1062)
                    return "This Data Already Exists";
                else
                    return var_dump($e->errorInfo[1]);
            }
            catch(\Exception $e){
                return "Deleted";
            }
        } 
    }
    public function index()
    {
        return view('SMS.Admin.Maintenance.AdminMCourse');
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        Input::merge(array_map('trim', Input::all()));
        try
        {
            $course = new Course;
            $course->description=$request->strCourDesc;
            $course->save();
            return Response::json($course);
        }
        catch(\Exception $e) {
            if($e->errorInfo[1]==1062)
                return "This Data Already Exists";
            else
                return var_dump($e->errorInfo[1]);
        } 
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        try
        {
            $course = Course::findorfail($id);
            return Response::json($course);
        }
        catch(\Exception $e)
        {
            return "Deleted";
        }
    }
    public function update(Request $request, $id)
    {
        Input::merge(array_map('trim', Input::all()));
        try
        {
            try
            {
                $course = Course::findorfail($id);
                $course->description = $request->strCourDesc;
                $course->save();
                return Response::json($course);
            }
            catch(\Exception $e) {
                if($e->errorInfo[1]==1062)
                    return "This Data Already Exists";
                else
                    return var_dump($e->errorInfo[1]);
            } 
        } 
        catch(\Exception $e) {
            return "Deleted";
        }
    }
    public function destroy($id)
    {
        try
        {
            $course = Course::findorfail($id);
            try
            {
                $course->delete();
                return Response::json($course);
            }
            catch(\Exception $e) {
                if($e->errorInfo[1]==1451)
                    return Response::json(['true',$course]);
                else
                    return Response::json(['true',$course,$e->errorInfo[1]]);
            }
        } 
        catch(\Exception $e) {
            return "Deleted";
        }
    }
}