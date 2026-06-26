@extends('layouts.company')

@section('title', 'Add Media')
@section('page-title', 'Media Gallery')

@section('content')
@include('company.media.media-form', ['mode' => 'Create'])
@endsection
