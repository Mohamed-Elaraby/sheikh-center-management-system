{{--<div class="btn-group convert_to_display_flex">--}}
{{--    <button type="button" class="btn btn-warning">{{ __('trans.action') }}</button>--}}
{{--    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">--}}
{{--        <span class="caret"></span>--}}
{{--        <span class="sr-only">Toggle Dropdown</span>--}}
{{--    </button>--}}
{{--    <ul class="dropdown-menu button_custom_style" role="menu" style="background-color: #ffa500;">--}}
{{--        @if (Auth::user()->hasPermission('create-check'))--}}

{{--            @if (auth()->user()->hasRole(['owner', 'general_manager']))--}}
{{--                <li><a href="{{ route('admin.selectBranch', ['client_id' => $query->id]) }}">{{ __('trans.create check') }}</a></li>--}}
{{--            @else--}}
{{--                <li><a href="{{ route('admin.check.create', ['client_id' => $query->id]) }}">{{ __('trans.create check') }}</a></li>--}}
{{--            @endif--}}

{{--        @endif--}}
{{--            <li><a href="{{ route('admin.check.index', ['client_id' => $query->id]) }}" >{{ __('trans.client check') . ' ' .$query->name}}</a></li>--}}

{{--    </ul>--}}
{{--</div>--}}


<select id="selectAction" class="form-control">
    <option value="" disabled selected>{{ __('trans.action') }}</option>
{{--    @if (Auth::user()->hasPermission('create-check'))--}}

{{--        @if (auth()->user()->hasRole(['owner', 'general_manager']))--}}
{{--           <option value="{{ route('admin.selectBranch', ['client_id' => $query->id]) }}">{{ __('trans.create check') }}</option>--}}
{{--        @else--}}
{{--           <option value="{{ route('admin.check.create', ['client_id' => $query->id]) }}">{{ __('trans.create check') }}</option>--}}
{{--        @endif--}}

{{--    @endif--}}
    <option value="{{ route('admin.cars.index', ['client_id' => $query->id]) }}" >{{ __('trans.client cars') . ' ' .$query->name}}</option>
    <option value="{{ route('admin.check.index', ['client_id' => $query->id]) }}" >{{ __('trans.client check') . ' ' .$query->name}}</option>

</select>

@if (Auth::user()->hasPermission('update-clients'))
    <a href="{{ route('admin.clients.edit', $query->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> {{ __('trans.edit') }}</a>
@endif
@if (Auth::user()->hasPermission('delete-clients'))
    {!! Form::open(['route' => ['admin.clients.destroy', $query->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
    <button class="btn btn-sm btn-danger" onclick="return showDeleteMessage()"> <i class="fa fa-remove"></i> {{ __('trans.delete') }}</button>
    {!! Form::close() !!}
@endif
