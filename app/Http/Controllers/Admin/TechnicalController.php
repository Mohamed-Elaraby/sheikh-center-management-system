<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TechnicalDatatable;
use App\Http\Requests\Technical\AddAndUpdateTechnicalRequest;
use App\Models\Branch;
use App\Models\Technical;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TechnicalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-technicals')->only('index');
        $this->middleware('permission:create-technicals')->only('create');
        $this->middleware('permission:update-technicals')->only('edit');
        $this->middleware('permission:delete-technicals')->only('destroy');
    }

    public function index(TechnicalDatatable $technicalDatatable)
    {
        $branchName = '';
        if (request('branch_id')) {
            $branchName = Branch::findOrFail(request('branch_id'))->name; // Get [ branch name ] to send into view
        }
        return $technicalDatatable -> render('admin.technicals.index', compact('branchName'));
    }

    public function create()
    {
        $branches = Branch::pluck('name', 'id') -> toArray();
        return view('admin.technicals.create', compact('branches'));
    }

    public function store(AddAndUpdateTechnicalRequest $request)
    {
        Technical::create($request -> all());
        return redirect() -> route('admin.technicals.index') -> with('success', __('trans.technical added successfully'));
    }

    public function show($id)
    {
        $technical = Technical::findOrFail($id);
        return view('admin.technicals.show', compact('technical'));
    }

    public function edit($id)
    {
        $technical = Technical::findOrFail($id);
        $branches = Branch::pluck('name', 'id') -> toArray();
        return view('admin.technicals.edit',compact('technical', 'branches'));
    }

    public function update(AddAndUpdateTechnicalRequest $request, $id)
    {
        $technical = Technical::findOrFail($id);
        $technical->update($request -> all());
        return redirect() -> route('admin.technicals.index') -> with('success', __('trans.technical edit successfully'));
    }


    public function destroy($id)
    {
        Technical::findOrFail($id) -> delete();
        return redirect()->back()->with('delete', __('trans.technical delete successfully'));
    }
}
