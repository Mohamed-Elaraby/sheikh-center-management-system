<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\Http\Requests\client\AddClientRequest;
use App\Http\Requests\client\UpdateClientRequest;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-clients')->only('index');
        $this->middleware('permission:create-clients')->only('create');
        $this->middleware('permission:update-clients')->only('edit');
        $this->middleware('permission:delete-clients')->only('destroy');
    }

    public function index(ClientDatatable $clientDatatable,Request $request)
    {
        $monthName = '';
        if ($request -> month){
            $monthName = Carbon::now()->monthName;
        }
        return $clientDatatable -> render('admin.clients.index', compact('monthName'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(AddClientRequest $request)
    {
        Client::create($request -> all());
        return redirect() -> route('admin.clients.index') -> with('success', __('trans.client added successfully'));
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit',compact('client'));
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request -> all());
        return redirect() -> route('admin.clients.index') -> with('success', __('trans.client edit successfully'));
    }


    public function destroy($id)
    {
        Client::findOrFail($id) -> delete();
        return redirect()->back()->with('delete', __('trans.client delete successfully'));
    }
}
