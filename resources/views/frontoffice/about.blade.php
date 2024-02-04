@extends('frontoffice.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="css/about.css">
@endsection

@section('content')
    <div class="head-title">
        <div class="my-5 px-4">
            <h1 class="fw-bold text-center">ABOUT US</h1>
            <div class="h-line bg-dark"></div>
            <p class="text-center mt-3">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                Odit provident ea facere maxime illum harum reprehenderit impedit est tempore accusamus!
                Lorem ipsum dolor, <br> sit amet consectetur adipisicing elit. Recusandae neque iure voluptas,
                possimus magni placeat necessitatibus exercitationem quisquam quis libero.
            </p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
                <p>Lorem ipsum dolor sit amet,
                    consectetur adipisicing elit.
                    Iusto vel perferendis, magnam sapiente sed enim eius similique quaerat dolorum tempore!
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <img src="images/about/about.jpg" class="w-100">
            </div>
        </div>

    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px">
                    <h3 class="mt-3">100+ ROOMS</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/customers.svg" width="70px">
                    <h3 class="mt-3">100+ CUSTOMERS</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/rating.svg" width="70px">
                    <h3 class="mt-3">100+ REVIEWS</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/staff.svg" width="70px">
                    <h3 class="mt-3">100+ STAFFS</h3>
                </div>
            </div>
        </div>
    </div>

    <h2 class="my-5 fw-bold text-center">MANAGEMENT TEAM</h2>
    <div class="container px-4  py-4">
        <div class="swiper manage-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/about/team.jpg" class="w-100 rounded">
                    <h4 class="mt-2">Random Name</h4>
                </div>
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/about/team.jpg" class="w-100 rounded">
                    <h4 class="mt-2">Random Name</h4>
                </div>
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/about/team.jpg" class="w-100 rounded">
                    <h4 class="mt-2">Random Name</h4>
                </div>
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/about/team.jpg" class="w-100 rounded">
                    <h4 class="mt-2">Random Name</h4>
                </div>
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/about/team.jpg" class="w-100 rounded">
                    <h4 class="mt-2">Random Name</h4>
                </div>
            </div>
            <div class="swiper-pagination position-relative mt-3"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var swiper = new Swiper(".manage-swiper", {
            spaceBetween: 40,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>
@endsection
