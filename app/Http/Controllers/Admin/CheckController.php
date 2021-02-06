<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CheckDatatable;
use App\Http\Requests\Check\AddAndUpdateCheckRequest;
use App\Models\Branch;
use App\Models\CarDevelopmentCode;
use App\Models\CarEngine;
use App\Models\CarModel;
use App\Models\CarSize;
use App\Models\CarType;
use App\Models\Check;
use App\Models\CheckStatus;
use App\Models\Client;
use App\Models\Engineer;
use App\Models\Images;
use App\Models\Technical;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class CheckController extends Controller
{
    use HelperTrait;
    public function __construct()
    {
        $this->middleware('permission:read-check')->only('index');
        $this->middleware('permission:create-check')->only('create');
        $this->middleware('permission:update-check')->only('edit');
        $this->middleware('permission:delete-check')->only('destroy');
        $this->middleware('permission:read-managementNotes')->only('managementNotes');
        $this->middleware('permission:update-checkStatus')->only('onlyEditCheckStatus');
    }

    public function index(Request $request, CheckDatatable $checkDatatable)
    {
        $checkStatusName = '';
        $branchName = '';
        $clientName = '';
        $carExists = '';
        if ($request->check_status_id) // Get all check with [ check status id ] from request url
            $checkStatusName = CheckStatus::findOrFail($request->check_status_id)->name; // Get [ check status name ] to send into view

        if ($request->branch_id) { // Get all check with [ branch id ] from request url
            $branchName = Branch::findOrFail($request->branch_id)->name; // Get [ branch name ] to send into view
            if ($request -> car_exists == true)
            {
                $carExists = 'السيارات الموجودة حالياً بالفرع';
            }
        }
        if ($request->client_id) // Get all check with [ client id ] from request url
            $clientName = Client::findOrFail($request->client_id)->name; // Get [ client name ] to send into view

        return $checkDatatable->render('admin.check.index', compact('checkStatusName', 'branchName', 'clientName', 'carExists'));
    }

    public function create(Request $request)
    {
//        dd($request -> all());
        $targetBranch = '';
        if ($request ->get('branch_id')) {
            $branch_id = $request ->get('branch_id');
            $targetBranch = Branch::findOrFail($branch_id);
        }
        $client_id = $request ->get('client_id');
        $targetClient = Client::findOrFail($client_id);
        $technicals = Technical::where('branch_id', Auth::user()->branch_id) -> pluck('name', 'id') -> toArray();
        $engineers = Engineer::where('branch_id', Auth::user()->branch_id) -> pluck('name', 'id') -> toArray();
        $carTypes = CarType::pluck('name', 'id') -> toArray();
        $carModels = CarModel::orderBy('name', 'DESC') -> pluck('name', 'id') -> toArray();
        return view('admin.check.create', compact('technicals', 'targetClient', 'targetBranch', 'engineers', 'carTypes', 'carModels'));
    }

    public function store(AddAndUpdateCheckRequest $request)
    {

        if ($request -> branch_id && $request -> branch_id != null) {
            $branch_id =  $request -> branch_id;
        }else{
            $branch_id = Auth::user()->branch_id;
        }
//        dd($request -> all() );
        $check_number = rand();
        $check_data = $request -> except('car_images'); // Get All Column Without [car_images]
        $allData = $check_data+ ['user_id' => Auth::user()->id] + ['check_number' => $check_number] + ['branch_id' => $branch_id];
        $check = Check::create($allData); // Create New check From [check_data] Request And [image_data] Coming With Trait
        $check_id = $check->id;
        if ($request -> has('car_images')) {
            $image_data = $this->uploadImageProcessing($request -> car_images, 'check_cars', 'shocks', $check_number, 'public', 500, 500); // Upload Image With Trait
            foreach ($image_data  as $image)
            {
                // Type => 1 [ 1 For car_images ]
                $check -> images() -> create($image + ['type'=>1]);
            }
        }
        return redirect() -> route('admin.check.clientSignature', [$check_id, $check_number]) -> with('success', __('trans.check added successfully'));
    }

    public function show($id)
    {
        $check = Check::findOrFail($id);
        return view('admin.check.show', compact('check'));
    }

    public function edit($id)
    {
        $check = Check::findOrFail($id);
        if (Auth::user()->hasRole('branch_manager') && $check->branch_id != Auth::user()->branch_id)
            abort(403);
        $checkStatus = CheckStatus::pluck('name', 'id')->toArray();
        $technicals = Technical::where('branch_id', $check -> branch_id) -> pluck('name', 'id') -> toArray();
        $engineers = Engineer::where('branch_id', Auth::user()->branch_id) -> pluck('name', 'id') -> toArray();
        $carTypes = CarType::pluck('name', 'id') -> toArray();
        $carSizes = CarSize::where('car_type_id', $check -> car_type_id)->pluck('name', 'id') -> toArray();
        $carModels = CarModel::orderBy('name', 'DESC') -> pluck('name', 'id') -> toArray();
        $carEngines = CarEngine::where('car_size_id', $check -> car_size_id)->pluck('name', 'id') -> toArray();
        $carDevelopmentCode = CarDevelopmentCode::where('car_size_id', $check -> car_size_id)->pluck('name', 'id') -> toArray();
//dd($carSizes);

        // Send to view if need disabled check status item from select box option
/*        $option_attributes = collect(CheckStatus::all())
            ->mapWithKeys(function ($item) use ($check) {
                if ($check -> client_approved == 0) {
                    if ($item->name == 'تم التعميد من قبل العميل') {
                        return [$item->id => ['disabled' => true, 'value' => '']];
                    }
                }else {
                    if ($item->name == 'تم التعميد من قبل العميل') {
                        return [$item->id => ['disabled' => false]];
                    }
                }
                return [];
            })->all();*/

        return view('admin.check.edit',compact('check', 'checkStatus', 'technicals', 'engineers', 'carTypes', 'carSizes', 'carModels', 'carEngines', 'carDevelopmentCode'));
    }

    public function update(AddAndUpdateCheckRequest $request, $id)
    {
        $check = Check::findOrFail($id);
        $check -> update($request -> all());
        return redirect() -> route('admin.check.index') -> with('success', __('trans.check edit successfully'));
    }

    public function destroy($id)
    {
        $check = Check::findOrFail($id);
        $this -> deleteImageHandel('public', $check -> images); // Check If check Have Directory Profile Picture Delete It
        $check -> delete(); // Delete check From check Table
        return redirect()->back()->with('delete', __('trans.check delete successfully'));
    }

    // Custom Function images
    public function images($check_id,$type)
    {
        $images = Images::where('check_id',$check_id)->where('type',$type) -> get();
        return view('admin.check.images', compact('images'));
    }

    // Custom Function create_device_report
    public function create_device_report($check_id, $check_number)
    {
        return view('admin.check.createDeviceReport', compact('check_id', 'check_number'));
    }

    // Custom Function store_device_report
    public function store_device_report(Request $request)
    {
        if ($request -> has('report_device')) {
            $check_id = $request -> check_id;
            $check_number = $request -> check_number;
            // Type => 2 [ 2 For Device Report ]
            $allCheckData = ['type' => 2, 'check_id' => $check_id];
            $image_data = $this->uploadImageProcessing($request -> report_device, 'check_cars', 'reports', $check_number, 'public', 500, 500); // Upload Image With Trait
            foreach ($image_data  as $image)
            {
                Images::create($image + $allCheckData);
            }
        }
        return redirect() -> route('admin.check.index') -> with('success', __('trans.device report added successfully'));
    }

    // Custom Function client_signature
    public function client_signature($check_id ,$check_number)
    {
        return view('admin.check.signature', compact('check_id', 'check_number'));
    }

    // Custom Function signature
    public function signature(Request $request)
    {
        if ($request -> ajax()) {
            if ($request -> car_status) {
                // If the car gets exit
                $check_status = CheckStatus::where('name', 'تم تسليم السيارة الى العميل')->select('id')->first();
                $check = Check::findOrFail($request -> check_id);
                $check -> update(['check_status_id' => $check_status -> id, 'car_exit_date' => now()]);
                $image_data = $this -> uploadSVGImage($request -> check_id,$request -> image_data,'check_cars', 'signature_exit',$request -> check_number,'public');
                // Type => 4 [ 4 For client signature exit]
                Images::create($image_data+ ['type' => 4]+ ['check_id' => $request -> check_id]);
            }else {
                // In the event car of entry
                $image_data = $this -> uploadSVGImage($request -> check_id,$request -> image_data,'check_cars', 'signature_entry',$request -> check_number,'public');
                // Type => 3 [ 3 For client signature entry]
                Images::create($image_data+ ['type' => 3]+ ['check_id' => $request -> check_id]);
            }
        }
        return redirect() -> route('admin.check.index') -> with('success', __('trans.client signature added successfully'));
    }

    // Custom Function onlyEditCheckStatus
    public function onlyEditCheckStatus(Request $request)
    {
        if ($request -> ajax()) {
            $check = Check::findOrFail($request -> check_id);
            $check -> update(['check_status_id' => $request -> check_status_id]);
            return response(session()->flash('status_success', __('trans.check status edit successfully')));
        }
    }

    // Custom Function receipt
    public function receipt($check_id)
    {
        $check = Check::findOrFail($check_id);
        $client_signature_entry = Images::where('check_id',$check_id)->where('type',3) -> latest() -> first();
        $client_signature_exit = Images::where('check_id',$check_id)->where('type',4) -> latest() -> first();
        return view('admin.check.receipt', compact('check', 'client_signature_entry', 'client_signature_exit'));
    }

    // Custom Function getCarSizesByAjax
    public function getCarSizesByAjax(Request $request)
    {
        if ($request -> ajax())
        {
            $car_type_id = $request -> car_type_id;
            $carSizes = CarSize::where('car_type_id', $car_type_id)->select('id', 'name')->get();
            return response() -> json($carSizes, 200);
        }
    }

    // Custom Function getCarDevCodeAndEnginesByAjax
    public function getCarDevCodeAndEnginesByAjax(Request $request)
    {
        if ($request -> ajax())
        {
            $car_size_id = $request -> car_size_id;
            $carEngines = CarEngine::where('car_size_id', $car_size_id)->select('id', 'name')->get();
            $carDevelopmentCodes = CarDevelopmentCode::where('car_size_id', $car_size_id)->select('id', 'name')->get();
            return response() -> json(['carEngines' => $carEngines, 'carDevelopmentCodes' => $carDevelopmentCodes], 200);
        }
    }

    // Custom function managementNotes
    public function managementNotes($check_id, Request $request)
    {
        $check = Check::findOrFail($check_id);
        return view('admin.check.managementNotes', compact('check'));
    }

    // Custom function managementNotes
    public function managementNotesUpdate($check_id, Request $request)
    {
        $check = Check::findOrFail($check_id);
        $check -> update(['management_notes' => $request -> management_notes]);
        return redirect() -> route('admin.check.index') -> with('success', __('trans.management notes edit successfully'));
    }

    public function selectBranch()
    {
        $branches = Branch::pluck('name', 'id');
        return view('admin.check.selectBranch', compact('branches'));
    }
}
