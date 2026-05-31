@extends('layouts.company')

@section('title', 'Add Product')
@section('page-title', 'Products')

@section('content')
@include('company.products.form', ['mode' => 'Create'])
@endsection
