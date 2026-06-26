@extends('layouts.company')

@section('title', 'Edit Catalogue')
@section('page-title', 'Catalogues')

@section('content')
@include('company.catalogues.catalogue-form', ['mode' => 'Edit'])
@endsection
