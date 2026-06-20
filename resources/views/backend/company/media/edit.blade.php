@extends('layouts.company')

@section('title', 'Edit Media')
@section('page-title', 'Media Gallery')

@section('content')
@include('backend.company.media.form', ['mode' => 'Edit'])
@endsection
