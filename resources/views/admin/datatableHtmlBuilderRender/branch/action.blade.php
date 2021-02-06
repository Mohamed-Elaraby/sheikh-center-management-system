<a href="{{ route('dashboard', ['branch_id' => $query->id]) }}" class="btn btn-sm btn-info"> <i class="fa fa-line-chart"></i> {{ __('trans.branch statistic') }}</a>
@if (Auth::user()->hasPermission('read-check'))
    <a href="{{ route('admin.check.index', ['branch_id' => $query->id]) }}" class="btn btn-sm btn-warning"> <i class="fa fa-wrench"></i> {{ __('trans.branch checks') }}</a>
@endif
@if (Auth::user()->hasPermission('read-check'))
    <a href="{{ route('admin.check.index', ['branch_id' => $query->id, 'car_exists' => true]) }}" class="btn btn-sm btn-success"> <i class="fa fa-car"></i> {{ __('trans.branch exit car now') }}</a>
@endif
@if (Auth::user()->hasPermission('read-users'))
    <a href="{{ route('admin.users.index', ['branch_id' => $query->id]) }}" class="btn btn-sm btn-info"> <i class="fa fa-users"></i> {{ __('trans.branch users') }}</a>
@endif
@if (Auth::user()->hasPermission('read-technicals'))
    <a href="{{ route('admin.technicals.index', ['branch_id' => $query->id]) }}" class="btn btn-sm btn-warning"> <i class="fa fa-child"></i> {{ __('trans.branch technicals') }}</a>
@endif
@if (Auth::user()->hasPermission('read-engineers'))
    <a href="{{ route('admin.engineers.index', ['branch_id' => $query->id]) }}" class="btn btn-sm btn-info"> <i class="fa fa-child"></i> {{ __('trans.branch engineers') }}</a>
@endif
@if (Auth::user()->hasPermission('update-branches'))
    <a href="{{ route('admin.branches.edit', $query->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> {{ __('trans.edit') }}</a>
@endif
@if (Auth::user()->hasPermission('delete-branches'))
    {!! Form::open(['route' => ['admin.branches.destroy', $query->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
    <button class="btn btn-sm btn-danger" onclick="return showDeleteMessage()"> <i class="fa fa-remove"></i> {{ __('trans.delete') }}</button>
    {!! Form::close() !!}
@endif
