{{-- ================================================================
     resources/views/admin/incidents/create.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Create Incident')
@section('page_title', 'Create Incident')

@section('content')
@include('admin.incidents._form', ['incident' => null, 'lgas' => collect(), 'action' => route('admin.incidents.store'), 'method' => 'POST'])
@endsection

{{-- ================================================================
     resources/views/admin/incidents/edit.blade.php
     ================================================================ --}}
{{--
@extends('layouts.admin')
@section('title', 'Edit: ' . Str::limit($incident->title, 40))
@section('page_title', 'Edit Incident')

@section('content')
@include('admin.incidents._form', ['incident' => $incident, 'lgas' => $lgas, 'action' => route('admin.incidents.update', $incident), 'method' => 'PUT'])
@endsection
--}}
