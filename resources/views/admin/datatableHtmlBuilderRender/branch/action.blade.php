<div class="btn-group">
    <button type="button" class="btn btn-warning">{{ __('trans.action') }}</button>
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu button_custom_style" role="menu" style="background-color: #ffa500;">
        <li><a href="{{ route('dashboard', ['branch_id' => $query->id]) }}">{{ __('trans.branch statistic') }}</a></li>
        @if (Auth::user()->hasPermission('read-check'))
            <li>
                <a href="{{ route('admin.check.index', ['branch_id' => $query->id]) }}">{{ __('trans.branch checks') }}</a>
            </li>
        @endif
        @if (Auth::user()->hasPermission('read-check'))
            <li>
                <a href="{{ route('admin.check.index', ['branch_id' => $query->id, 'car_exists' => true]) }}">{{ __('trans.branch exit car now') }}</a>
            </li>
        @endif
        @if (Auth::user()->hasPermission('read-users'))
            <li>
                <a href="{{ route('admin.users.index', ['branch_id' => $query->id]) }}">{{ __('trans.branch users') }}</a>
            </li>
        @endif
        @if (Auth::user()->hasPermission('read-technicals'))
            <li>
                <a href="{{ route('admin.technicals.index', ['branch_id' => $query->id]) }}">{{ __('trans.branch technicals') }}</a>
            </li>
        @endif
        @if (Auth::user()->hasPermission('read-engineers'))
            <li>
                <a href="{{ route('admin.engineers.index', ['branch_id' => $query->id]) }}">{{ __('trans.branch engineers') }}</a>
            </li>
        @endif
    </ul>
</div>

@if (Auth::user()->hasPermission('update-branches'))
    <a href="{{ route('admin.branches.edit', $query->id) }}" class="btn btn-sm btn-primary"><i
            class="fa fa-edit"></i>{{ __('trans.edit') }}</a>
@endif
@if (Auth::user()->hasPermission('delete-branches'))
    {!! Form::open(['route' => ['admin.branches.destroy', $query->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
    <button class="btn btn-sm btn-danger" onclick="return showDeleteMessage()"><i
            class="fa fa-remove"></i>{{ __('trans.delete') }}</button>
    {!! Form::close() !!}
@endif
