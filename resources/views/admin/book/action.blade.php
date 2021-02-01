<a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $id }}" title="{{ $title }}" class="show-button btn btn-success view-product">
    View <span class="fa fa-eye ml-2"></span>
</a>
<a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $id }}" title="Edit Data" class="edit btn btn-warning edit-product">
    Edit <span class="fa fa-pen ml-2"></span>
</a>

@if (Auth::user()->role_id == 1)
<a href="javascript:void(0);" data-toggle="tooltip" title="{{ $title }}" data-id="{{ $id }}" class="delete btn btn-danger">
    Delete <span class="fa fa-trash ml-2"></span>
</a>
@endif
