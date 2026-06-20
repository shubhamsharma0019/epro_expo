@extends('layouts.company')

@section('title', 'Edit Document')
@section('page-title', 'Documents')

@section('content')
@include('backend.company.documents.form', ['mode' => 'Edit'])
@endsection
