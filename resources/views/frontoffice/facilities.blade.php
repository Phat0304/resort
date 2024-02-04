@extends('frontoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/facilities.css">
@endsection

@section('content')
    <div class="my-5 px-4">
        <h1 class="fw-bold text-center">สิ่งอำนวยความสะดวกทั้งหมด</h1>
        <div class="h-line bg-dark" style="width: 355px !important;"></div>
    </div>
    <div class="container">
        <div class="row">
            @foreach ($facilities as $fac)
                <div class="col-lg-4 col-md-6 mb-5 px-4">
                    <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                        <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                            <img src="{{ $fac->icon }}" width="80px">
                            <h4 class="m-0">{{ $fac->name }}</h4>
                        </div>
                        <p>{{ $fac->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('scripts')
    <script>

    </script>
@endsection


