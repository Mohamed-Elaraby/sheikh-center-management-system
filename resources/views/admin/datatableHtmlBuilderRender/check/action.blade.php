<div class="btn-group convert_to_display_flex">
    <button type="button" class="btn btn-warning">{{ __('trans.action') }}</button>
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu button_custom_style" role="menu" style="background-color: #ffa500;">
        <li><a href="{{ route('admin.check.show', $query->id) }}">عرض تفاصيل الفحص</a></li>

        <li><a href="{{ route('admin.check.images', [$query->id, 1]) }}">عرض صور السيارة</a></li>

        <li><a href="{{ route('admin.check.createDeviceReport', [$query->id, $query->check_number]) }}">رفع تقرير حالة
                السيارة</a></li>

        <li><a href="{{ route('admin.check.images', [$query->id, 2]) }}">عرض تقرير حالة السيارة</a></li>

        <li><a href="{{ route('admin.check.clientSignature', [$query->id, $query->check_number,'exit=true']) }}">تسجيل
                خروج السيارة من المركز</a></li>

        @if (Auth::user()->hasPermission('create-managementNotes'))
            <li><a href="{{ route('admin.check.managementNotes', $query->id) }}">ملاحظات الإدارة</a></li>
        @endif

        <li><a target="_blank" href="{{ route('admin.check.receipt', $query->id) }}">ايصال استلام السيارة</a></li>

    </ul>
</div>

@if (Auth::user()->hasRole('branch_manager') && $query->branch_id == Auth::user()->branch_id)
    <a href="{{ route('admin.check.edit', $query->id) }}" class="btn btn-primary">تعديل</a>
@elseif(!Auth::user()->hasRole('branch_manager') && Auth::user()->hasPermission('update-check'))
    <a href="{{ route('admin.check.edit', $query->id) }}" class="btn btn-primary">تعديل</a>
@endif

@if (Auth::user()->hasPermission('delete-check'))
    {!! Form::open(['route' => ['admin.check.destroy', $query->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
    <button onclick="return showDeleteMessage()" class="btn btn-danger">حذف</button>
    {!! Form::close() !!}
@endif
