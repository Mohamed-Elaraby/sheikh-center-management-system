<a href="{{ route('admin.check.show', $query->id) }}" class="btn btn-sm btn-success" title="عرض تفاصيل الفحص"> <i class="fa fa-info-circle"></i></a>

<a href="{{ route('admin.check.images', [$query->id, 1]) }}" class="btn btn-sm btn-info" title="عرض صور السيارة"> <i class="fa fa-image"></i></a>

<a href="{{ route('admin.check.createDeviceReport', [$query->id, $query->check_number]) }}" class="btn btn-sm btn-warning" title="رفع تقرير حالة السيارة"> <i class="fa fa-upload"></i></a>

<a href="{{ route('admin.check.images', [$query->id, 2]) }}" class="btn btn-sm btn-warning" title="عرض تقرير حالة السيارة"> <i class="fa fa-image"></i></a>

<a href="{{ route('admin.check.clientSignature', [$query->id, $query->check_number,'exit=true']) }}" class="btn btn-sm btn-danger" title="تسجيل خروج السيارة من المركز"> <i class="fa fa-car"></i></a>

@if (Auth::user()->hasPermission('create-managementNotes'))
<a href="{{ route('admin.check.managementNotes', $query->id) }}" class="btn btn-sm btn-danger" title="ملاحظات الإدارة"> <i class="fa fa-star"></i></a>
@endif

<a target="_blank" href="{{ route('admin.check.receipt', $query->id) }}" class="btn btn-sm btn-success" title="ايصال استلام السيارة"> <i class="fa fa-paperclip"></i></a>

@if (Auth::user()->hasRole('branch_manager') && $query->branch_id == Auth::user()->branch_id)
    <a href="{{ route('admin.check.edit', $query->id) }}" class="btn btn-sm btn-primary" title="تعديل بيانات الفحص"> <i class="fa fa-edit"></i></a>
@elseif(!Auth::user()->hasRole('branch_manager') && Auth::user()->hasPermission('update-check'))
    <a href="{{ route('admin.check.edit', $query->id) }}" class="btn btn-sm btn-primary" title="تعديل بيانات الفحص"> <i class="fa fa-edit"></i></a>
@endif

@if (Auth::user()->hasPermission('delete-check'))
    {!! Form::open(['route' => ['admin.check.destroy', $query->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
        <button title="حذف الفحص" class="btn btn-sm btn-danger" onclick="return showDeleteMessage()"> <i class="fa fa-remove"></i></button>
    {!! Form::close() !!}
@endif
