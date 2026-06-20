@extends('layouts.company')

@section('title', 'Edit Catalogue')
@section('page-title', 'Catalogues')

@section('content')
@include('backend.company.catalogues.form', ['mode' => 'Edit'])
@endsection
