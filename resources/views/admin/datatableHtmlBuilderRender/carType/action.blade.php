@if (Auth::user()->hasPermission('create-carSize'))
    <a href="{{ route('admin.carSize.create', ['car_type_id' => $query->id]) }}" class="btn btn-success btn-sm "><i class="fa fa-plus"></i> {{ __('trans.create car size') }}</a>
@endif
@if (Auth::user()->hasPermission('read-carSize'))
        <a href="{{ route('admin.carSize.index', ['car_type_id' => $query->id]) }}" class="btn btn-warning btn-sm "><i class="fa fa-eye"></i> {{ __('trans.show all sizes related by type') }}</a>
@endif
@if (Auth::user()->hasPermission('update-carType'))
    <a href="{{ route('admin.carType.edit', $query->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> {{ __('trans.edit') }}</a>
@endif
@if (Auth::user()->hasPermission('delete-carType'))
    {!! Form::open(['route' => ['admin.carType.destroy', $query->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
    <button class="btn btn-sm btn-danger" onclick="return showDeleteMessage()"> <i class="fa fa-remove"></i> {{ __('trans.delete') }}</button>
    {!! Form::close() !!}
@endif
