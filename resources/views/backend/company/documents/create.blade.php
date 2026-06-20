@extends('layouts.company')

@section('title', 'Add Document')
@section('page-title', 'Documents')

@section('content')
@include('backend.company.documents.form', ['mode' => 'Create'])
@endsection
