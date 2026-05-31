@extends('layouts.company')

@section('title', 'Edit Media')
@section('page-title', 'Media Gallery')

@section('content')
@include('company.media.form', ['mode' => 'Edit'])
@endsection
