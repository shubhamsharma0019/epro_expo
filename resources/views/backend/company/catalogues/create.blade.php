@extends('layouts.company')

@section('title', 'Add Catalogue')
@section('page-title', 'Catalogues')

@section('content')
@include('backend.company.catalogues.form', ['mode' => 'Create'])
@endsection
