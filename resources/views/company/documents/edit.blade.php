@extends('layouts.company')

@section('title', 'Edit Document')
@section('page-title', 'Documents')

@section('content')
@include('company.documents.form', ['mode' => 'Edit'])
@endsection
