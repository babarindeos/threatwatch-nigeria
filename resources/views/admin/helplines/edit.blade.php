{{-- resources/views/admin/helplines/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Helpline')
@section('page_title', 'Edit Helpline')
@section('page_breadcrumb', $helpline->agency_name)

@section('content')
<div class="max-w-2xl">
    @include('admin.helplines._form', [
        'helpline'   => $helpline,
        'lgas'       => $lgas,
        'action'     => route('admin.helplines.update', $helpline),
        'method'     => 'PUT',
        'states'     => $states,
        'categories' => $categories,
    ])
</div>
@endsection
