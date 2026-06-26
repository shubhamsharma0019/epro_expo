@extends('layouts.company')

@section('title', 'Add Document')
@section('page-title', 'Documents')

@section('content')
@include('company.documents.document-form', ['mode' => 'Create'])
@endsection
