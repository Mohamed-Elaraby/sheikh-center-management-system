@if (Auth::user()->hasPermission('create-check'))

    @if (auth()->user()->hasRole(['owner', 'general_manager']))
        <a href="{{ route('admin.selectBranch', ['client_id' => $query->id]) }}" class="btn btn-success btn-sm "><i class="fa fa-plus"></i> {{ __('trans.create check') }}</a>
    @else
        <a href="{{ route('admin.check.create', ['client_id' => $query->id]) }}" class="btn btn-success btn-sm "><i class="fa fa-plus"></i> {{ __('trans.create check') }}</a>
    @endif

@endif
{{--                                    @if (Auth::user()->hasPermission('create-check'))--}}
<a href="{{ route('admin.check.index', ['client_id' => $query->id]) }}" class="btn btn-sm btn-warning"> <i class="fa fa-eye"></i> {{ __('trans.client check') }}</a>
{{--                                    @endif--}}
@if (Auth::user()->hasPermission('update-clients'))
    <a href="{{ route('admin.clients.edit', $query->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> {{ __('trans.edit') }}</a>
@endif
@if (Auth::user()->hasPermission('delete-clients'))
    {!! Form::open(['route' => ['admin.clients.destroy', $query->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
    <button class="btn btn-sm btn-danger" onclick="return showDeleteMessage()"> <i class="fa fa-remove"></i> {{ __('trans.delete') }}</button>
    {!! Form::close() !!}
@endif
