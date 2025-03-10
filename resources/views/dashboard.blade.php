@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="row">
                <!-- Customer Ratings -->
                <div class="col-md-6 col-xxl-4 mb-6">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Customer Ratings</h5>
                      <div class="dropdown">
                        <button
                          class="btn p-0"
                          type="button"
                          id="customerRatings"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="customerRatings">
                          <a class="dropdown-item" href="javascript:void(0);">Featured Ratings</a>
                          <a class="dropdown-item" href="javascript:void(0);">Based on Task</a>
                          <a class="dropdown-item" href="javascript:void(0);">See All</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pb-0">
                      <div class="d-flex align-items-center gap-2 mb-1">
                        <h2 class="mb-0">4.0</h2>
                        <div class="ratings">
                          <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                          <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                          <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                          <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                          <i class="icon-base bx bxs-star icon-lg text-lighter"></i>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <span class="badge bg-label-primary me-2">+5.0</span>
                        <span>Points from last month</span>
                      </div>
                    </div>
                    <div id="customerRatingsChart"></div>
                  </div>
                </div>
                <!--/ Customer Ratings -->
                <!-- Overview & Sales Activity -->
                <div class="col-md-6 col-xxl-4 mb-6">
                  <div class="card h-100 gap-12">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title me-2">
                        <h5 class="mb-1">Overview & Sales Activity</h5>
                        <p class="card-subtitle">Check out each column for more details</p>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn p-0"
                          type="button"
                          id="salesActivity"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesActivity">
                          <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body px-1 pb-0">
                      <div id="salesActivityChart"></div>
                    </div>
                  </div>
                </div>
                <!--/ Overview & Sales Activity -->
                <div class="col-12 col-md-12 col-xxl-4">
                  <div class="row">
                    <div class="col-6 col-md-3 col-xxl-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body pb-4">
                          <span class="d-block fw-medium mb-1">Sessions</span>
                          <h4 class="card-title mb-0">2,845</h4>
                        </div>
                        <div id="sessionsChart" class="mb-0"></div>
                      </div>
                    </div>
                    <div class="col-6 col-md-3 col-xxl-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img src="../../assets/img/icons/unicons/cube-secondary.png" alt="cube" class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt2"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <p class="mb-1">Order</p>
                          <h4 class="card-title mb-3">$1,286</h4>
                          <small class="text-danger fw-medium"
                            ><i class="icon-base bx bx-down-arrow-alt"></i> -13.24%</small
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-12 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                              <div class="card-title mb-auto">
                                <h5 class="mb-0">Generated Leads</h5>
                                <p class="mb-0">Monthly Report</p>
                              </div>
                              <div class="chart-statistics">
                                <h4 class="card-title mb-0">4,230</h4>
                                <p class="text-success text-nowrap mb-0">
                                  <i class="icon-base bx bx-chevron-up icon-lg"></i> +12.8%
                                </p>
                              </div>
                            </div>
                            <div id="leadsReportChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
</div>
@endsection