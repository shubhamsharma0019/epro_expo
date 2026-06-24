@extends('layouts.company')

@section('title', 'Edit Document')
@section('page-title', 'Documents')

@section('content')
@include('backend.company.documents.document-form', ['mode' => 'Edit'])
@endsection
