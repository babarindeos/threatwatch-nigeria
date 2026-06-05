{{-- ================================================================
     resources/views/admin/helplines/create.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Add Helpline')
@section('page_title', 'Add Helpline')

@section('content')
<div class="max-w-2xl">
    @include('admin.helplines._form', ['helpline' => null, 'lgas' => collect(), 'action' => route('admin.helplines.store'), 'method' => 'POST'])
</div>
@endsection

{{-- ================================================================
     resources/views/admin/helplines/edit.blade.php
     ================================================================ --}}
{{--
@extends('layouts.admin')
@section('title', 'Edit Helpline')
@section('page_title', 'Edit Helpline')

@section('content')
<div class="max-w-2xl">
    @include('admin.helplines._form', ['helpline' => $helpline, 'lgas' => $lgas, 'action' => route('admin.helplines.update', $helpline), 'method' => 'PUT'])
</div>
@endsection
--}}
