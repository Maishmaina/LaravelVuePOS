<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Employee;
use Image;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employee= Employee::all();
        return response()->json($employee);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:employees|max:255',
            'email'=>'required|unique:employees',
            'phone'=>'required|unique:employees',
        ]); 

        // $validator = Validator::make($request->all(), [
        //     'name'=>'required|unique:employees|max:255',
        //     'email'=>'required|unique:employees',
        //     'phone'=>'required|unique:employees',
        // ]);
 
        // if ($validator->fails()) {
        //     return $validator->errors();
        // }else{}

        //Insert Data
        if ($request->photo){
            $position= strpos($request->photo, ';');
            $sub=substr($request->photo, 0,$position);
            $ext= explode('/', $sub)[1];

            $imgName=time().mt_rand(1000000, 9999999).".".$ext;
            $img= Image::make($request->photo);//->resize(null,null)
            $upload_path = 'backend/employee/';
            $image_url=$upload_path.$imgName;
            $img->save($image_url);


            $employee = new Employee;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->photo=$image_url;
            $employee->save();
        }else{
           $employee = new Employee;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->save(); 
        }

    

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee=DB::table('employees')->where('id',$id)->first();
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $data['salary']=$request->salary;
        $data['address']=$request->address;
        $data['nid']=$request->nid;
        $data['joining_date']=$request->joining_date;
        $image=$request->newphoto;

        if($image){

             $position= strpos($image, ';');
            $sub=substr($image, 0,$position);
            $ext= explode('/', $sub)[1];

            $imgName=time().mt_rand(1000000, 9999999).".".$ext;
            $img= Image::make($image);//->resize(null,null)
            $upload_path = 'backend/employee/';
            $image_url=$upload_path.$imgName;
            $success = $img->save($image_url);

            if ($success) {

     $data['photo'] =$image_url; 

      $employee= DB::table('employees')->where('id',$id)->first();
      $photo=$employee->photo;
      if($photo){

        if (file_exists($photo)) {
        unlink($photo);
        }
     } 

     $emply=DB::table('employees')->where('id',$id)->update($data);

        }

     }else{

        $oldphoto= $request->photo;
        $data['photo']=$oldphoto;
        $empl=DB::table('employees')->where('id',$id)->update($data);

     }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee= DB::table('employees')->where('id',$id)->first();
        $photo=$employee->photo;
        if ($photo) {

            if (file_exists($photo)) {
            unlink($photo);
            }

            DB::table('employees')->where('id',$id)->delete();
        }else{
            DB::table('employees')->where('id',$id)->delete();
        }
    }
}
