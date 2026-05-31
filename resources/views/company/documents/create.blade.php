@extends('layouts.company')

@section('title', 'Add Document')
@section('page-title', 'Documents')

@section('content')
@include('company.documents.form', ['mode' => 'Create'])
@endsection
