@extends('layouts.company')

@section('title', 'Add Catalogue')
@section('page-title', 'Catalogues')

@section('content')
@include('company.catalogues.catalogue-form', ['mode' => 'Create'])
@endsection
