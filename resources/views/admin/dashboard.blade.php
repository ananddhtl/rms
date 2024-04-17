@extends('admin.layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-md-4 ">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="me-auto">
                            <span class="fs-18">Categories</span>
                            <h2 class=" font-weight-bolder">1</h2>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-4 ">
                <div class="card ">
                    <div class="card-body  d-flex justify-content-around align-items-center">
                        <div class="me-auto">
                            <span class="fs-18">Product</span>
                            <h2 class=" font-weight-bolder">2</h2>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-4 ">
                <div class="card ">
                    <div class="card-body  d-flex justify-content-around align-items-center">
                        <div class="me-auto">
                            <span class="fs-18">Tables</span>
                            <h2 class=" font-weight-bolder">5</h2>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-4 ">
                <div class="card">
                    <div class="card-body  d-flex justify-content-around align-items-center">
                        <div class="me-auto">
                            <span class="fs-18">Total Orders</span>
                            <h2 class=" font-weight-bolder">4</h2>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-3 col-sm-6 col-md-4 ">
                <div class="card ">
                    <div class="card-body d-flex justify-content-around align-items-center">
                        <div class="me-auto">
                            <span class="fs-18">Today's Orders</span>
                            <h2 class=" font-weight-bolder">2</h2>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
