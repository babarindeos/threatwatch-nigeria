{{-- ================================================================
     resources/views/admin/incidents/edit.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Edit: ' . Str::limit($incident->title, 40))
@section('page_title', 'Edit Incident')
@section('page_breadcrumb', 'Modify incident details')

@section('content')
@include('admin.incidents._form', [
    'incident'    => $incident,
    'lgas'        => $lgas,
    'action'      => route('admin.incidents.update', $incident),
    'method'      => 'PUT',
    'states'      => $states,
    'attackTypes' => $attackTypes,
    'severities'  => $severities,
])
@endsection
