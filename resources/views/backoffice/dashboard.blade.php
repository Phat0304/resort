@extends('backoffice.layouts.main-layout')

@section('style')
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <h2 class="fs-5">แผงควบคุม</h2>
        <!-- Content Row 1 -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    <h4>รายการจองทั้งหมด</h4>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($bookingAll) }} รายการ <span
                                        style="color: #4e73df; font-size: 14px;">Online : {{ $bookingOnline }}, Walk-in :
                                        {{ $bookingWalkin }}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    <h4>รายได้ทั้งหมด</h4>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $income }} บาท</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-currency-bitcoin fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    <h4>จำนวนลูกค้า</h4>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($allCustomer) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people-fill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    <h4>จำนวนห้องทั้งหมด</h4>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $allRoom }}</div>

                                {{-- <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-hospital-fill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row 2 -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">จำนวนครั้งที่เข้าพัก</h6>
                        <h6 class="year m-0 font-weight-bold text-primary"></h6>

                        {{-- <div class="">
                            @foreach ($rooms as $room)
                                <span class="mr-3">
                                    <i class="bi bi-circle-fill" style="color: {{ $room->color_code }}; font-size: 12px;"></i> {{ $room->name }}
                                </span>
                            @endforeach
                        </div> --}}

                        {{-- <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical fa-sm fa-fw text-gray-600"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="barChartDate"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4" style="height: 414.19px;">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">สัดส่วนการเข้าพักทั้งหมด</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="pieChartDate"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row 3 -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">เปรียบเทียบรายได้</h6>
                        <h6 class="year m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="barChartMonth"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4" style="height: 414.19px;">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">สัดส่วนรายได้ทั้งหมด</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="pieChartMonth"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="data" roomsData="{{ json_encode($rooms) }}" bookingsData="{{ json_encode($bookingComplete) }}"
            bookingCompleteAll="{{ json_encode($bookingCompleteAll) }}"></div>
    </div>
@endsection

@section('script')
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area.js"></script>

    <script>
        const year = document.querySelectorAll('.year');
        const currentYear = dayjs().year();
        const buddhistYear = dayjs().year(currentYear).add(543, 'year').year();

        year.forEach(y => {
            y.innerText = `พ.ศ. ${buddhistYear}`;
        });
    </script>
@endsection
