@extends("layouts.app")

@section("title","Pharmacies")

@section("style")

@endsection

@section("header","Pharmacies")

@section("breadcrumb")

    <li class="breadcrumb-item"><a href="{{route("index")}}">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Pharmacies</a></li>

@endsection

@section("content")

    {{ $dataTable->table() }}

@endsection



@section('scripts')
   
    {{ $dataTable->scripts() }}
@endsection
