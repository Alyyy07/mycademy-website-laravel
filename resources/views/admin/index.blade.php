@extends('layouts.partials.admin.app')
@push('styles')
<link href="{{asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1
                        class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Store Analytics</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="../../demo1/dist/index.html"
                                class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Dashboards</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                        class="btn btn-sm fw-bold btn-secondary d-flex align-items-center px-4">
                        <div class="text-gray-600 fw-bold">Loading date range...</div>
                        <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                        </i>
                    </div>
                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html"
                        class="btn btn-sm fw-bold btn-primary">Show</a>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="row g-5 g-xl-10">
                    <div class="col-xxl-6 mb-md-5 mb-xl-10">
                        <div class="row g-5 g-xl-10">
                            <div class="col-md-6 col-xl-6 mb-xxl-10">
                                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                                    <div
                                        class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">
                                                <span
                                                    class="fs-4 fw-semibold text-gray-400 align-self-start me-1&gt;">$</span>
                                                <span
                                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">69,700</span>
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>2.2%</span>
                                            </div>
                                            <span class="fs-6 fw-semibold text-gray-400">Total Online
                                                Sales</span>
                                        </div>
                                        <div id="kt_card_widget_8_chart" class="min-h-auto"
                                            style="height: 125px"></div>
                                    </div>
                                </div>
                                <div class="card card-flush h-md-50 mb-xl-10">
                                    <div class="card-header pt-5">
                                        <div class="card-title d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">1,836</span>
                                                <span class="badge badge-light-danger fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>2.2%</span>
                                            </div>
                                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Total
                                                Sales</span>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex align-items-end pt-0">
                                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                                            <div
                                                class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                <span class="fw-bolder fs-6 text-dark">1,048 to
                                                    Goal</span>
                                                <span class="fw-bold fs-6 text-gray-400">62%</span>
                                            </div>
                                            <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                                <div class="bg-success rounded h-8px" role="progressbar"
                                                    style="width: 62%;" aria-valuenow="50"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6 mb-xxl-10">
                                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                                    <div
                                        class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                        <div class="mb-4 px-9">
                                            <div class="d-flex align-items-center mb-2">
                                                <span
                                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1">29,420</span>
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>2.6%</span>
                                            </div>
                                            <span class="fs-6 fw-semibold text-gray-400">Total Online
                                                Visitors</span>
                                        </div>
                                        <div id="kt_card_widget_9_chart" class="min-h-auto"
                                            style="height: 125px"></div>
                                    </div>
                                </div>
                                <div class="card card-flush h-md-50 mb-xl-10">
                                    <div class="card-header pt-5">
                                        <div class="card-title d-flex flex-column">
                                            <span
                                                class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">6.3k</span>
                                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Total New
                                                Customers</span>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-end pe-0">
                                        <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today’s
                                            Heroes</span>
                                        <div class="symbol-group symbol-hover flex-nowrap">
                                            <div class="symbol symbol-35px symbol-circle"
                                                data-bs-toggle="tooltip" title="Alan Warden">
                                                <span
                                                    class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle"
                                                data-bs-toggle="tooltip" title="Michael Eberon">
                                                <img alt="Pic" src="assets/media/avatars/300-11.jpg" />
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle"
                                                data-bs-toggle="tooltip" title="Susan Redwood">
                                                <span
                                                    class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle"
                                                data-bs-toggle="tooltip" title="Melody Macy">
                                                <img alt="Pic" src="assets/media/avatars/300-2.jpg" />
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle"
                                                data-bs-toggle="tooltip" title="Perry Matthew">
                                                <span
                                                    class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle"
                                                data-bs-toggle="tooltip" title="Barry Walter">
                                                <img alt="Pic" src="assets/media/avatars/300-12.jpg" />
                                            </div>
                                            <a href="#" class="symbol symbol-35px symbol-circle"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_view_users">
                                                <span
                                                    class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+42</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 mb-5 mb-xl-10">
                        <div class="card card-flush h-md-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">World Sales</span>
                                    <span class="text-gray-400 pt-2 fw-semibold fs-6">Top Selling
                                        Countries</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div
                                                class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                Payments</div>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Create Invoice</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link flex-stack px-3">Create Payment
                                                <span class="ms-2" data-bs-toggle="tooltip"
                                                    title="Specify a target name for future usage and reference">
                                                    <i class="ki-duotone ki-information fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span></a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Generate Bill</a>
                                        </div>
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                            data-kt-menu-placement="right-end">
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">Subscription</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Plans</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Billing</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Statements</a>
                                                </div>
                                                <div class="separator my-2"></div>
                                                <div class="menu-item px-3">
                                                    <div class="menu-content px-3">
                                                        <label
                                                            class="form-check form-switch form-check-custom form-check-solid">
                                                            <input
                                                                class="form-check-input w-30px h-20px"
                                                                type="checkbox" value="1"
                                                                checked="checked"
                                                                name="notifications" />
                                                            <span
                                                                class="form-check-label text-muted fs-6">Recuring</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-item px-3 my-1">
                                            <a href="#" class="menu-link px-3">Settings</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-center">
                                <div id="kt_maps_widget_1_map" class="w-100 h-350px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-10 g-xl-10">
                    <div class="col-xl-4 mb-xl-10">
                        <div class="card h-md-100" dir="ltr">
                            <div class="card-body d-flex flex-column flex-center">
                                <div class="mb-2">
                                    <h1 class="fw-semibold text-gray-800 text-center lh-lg">Have you
                                        tried
                                        <br />new
                                        <span class="fw-bolder">Invoice Manager ?</span>
                                    </h1>
                                    <div class="py-10 text-center">
                                        <img src="assets/media/svg/illustrations/easy/2.svg"
                                            class="theme-light-show w-200px" alt="" />
                                        <img src="assets/media/svg/illustrations/easy/2-dark.svg"
                                            class="theme-dark-show w-200px" alt="" />
                                    </div>
                                </div>
                                <div class="text-center mb-1">
                                    <a class="btn btn-sm btn-primary me-2"
                                        href="../../demo1/dist/apps/ecommerce/customers/listing.html">Try
                                        now</a>
                                    <a class="btn btn-sm btn-light"
                                        href="../../demo1/dist/apps/invoices/view/invoice-1.html">Learn
                                        more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-xl-10">
                        <div class="card card-flush h-md-100">
                            <div class="card-header flex-nowrap pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Top Selling
                                        Categories</span>
                                    <span class="text-gray-400 pt-2 fw-semibold fs-6">8k social
                                        visitors</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">
                                                Quick Actions</div>
                                        </div>
                                        <div class="separator mb-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Ticket</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Customer</a>
                                        </div>
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                            data-kt-menu-placement="right-start">
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Admin Group</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Staff Group</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Member Group</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Contact</a>
                                        </div>
                                        <div class="separator mt-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                    Reports</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-5 ps-6">
                                <div id="kt_charts_widget_5" class="min-h-auto"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-5 mb-xl-10">
                        <div class="card card-flush h-md-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Top Selling
                                        Products</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6">8k social
                                        visitors</span>
                                </h3>
                                <div class="card-toolbar">
                                    <a href="../../demo1/dist/apps/ecommerce/catalog/categories.html"
                                        class="btn btn-sm btn-light">View All</a>
                                </div>
                            </div>
                            <div class="card-body pt-4">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                <th class="p-0 w-50px pb-1">ITEM</th>
                                                <th class="ps-0 min-w-140px"></th>
                                                <th class="text-end min-w-140px p-0 pb-1">TOTAL PRICE
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img src="assets/media/stock/ecommerce/210.png"
                                                        class="w-50px" alt="" />
                                                </td>
                                                <td class="ps-0">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">Elephant
                                                        1802</a>
                                                    <span
                                                        class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Item:
                                                        #XDG-2347</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$72.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="assets/media/stock/ecommerce/215.png"
                                                        class="w-50px" alt="" />
                                                </td>
                                                <td class="ps-0">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">Red
                                                        Laga</a>
                                                    <span
                                                        class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Item:
                                                        #XDG-2347</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$45.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="assets/media/stock/ecommerce/209.png"
                                                        class="w-50px" alt="" />
                                                </td>
                                                <td class="ps-0">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">RiseUP</a>
                                                    <span
                                                        class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Item:
                                                        #XDG-2347</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$168.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="assets/media/stock/ecommerce/214.png"
                                                        class="w-50px" alt="" />
                                                </td>
                                                <td class="ps-0">
                                                    <a href="../../demo1/dist/apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">Yellow
                                                        Stone</a>
                                                    <span
                                                        class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Item:
                                                        #XDG-2347</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$72.00</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-10">
                    <div class="col-xxl-4 mb-xxl-10">
                        <div class="card card-flush h-md-100">
                            <div class="card-header py-7">
                                <div class="m-0">
                                    <div class="d-flex align-items-center mb-2">
                                        <span
                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">0.37%</span>
                                        <span class="badge badge-light-danger fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-danger ms-n1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>8.02%</span>
                                    </div>
                                    <span class="fs-6 fw-semibold text-gray-400">Online store convertion
                                        rate</span>
                                </div>
                                <div class="card-toolbar">
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">
                                                Quick Actions</div>
                                        </div>
                                        <div class="separator mb-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Ticket</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Customer</a>
                                        </div>
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                            data-kt-menu-placement="right-start">
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Admin Group</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Staff Group</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Member Group</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Contact</a>
                                        </div>
                                        <div class="separator mt-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                    Reports</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-0">
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex align-items-center me-5">
                                            <div class="symbol symbol-30px me-5">
                                                <span class="symbol-label">
                                                    <i
                                                        class="ki-duotone ki-magnifier fs-3 text-gray-600">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Search
                                                    Retargeting</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Direct
                                                    link clicks</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-6 me-3">0.24%</span>
                                            <div class="d-flex flex-center">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>2.4%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex align-items-center me-5">
                                            <div class="symbol symbol-30px me-5">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-tiktok fs-3 text-gray-600">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Social
                                                    Retargeting</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Direct
                                                    link clicks</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-6 me-3">0.94%</span>
                                            <div class="d-flex flex-center">
                                                <span class="badge badge-light-danger fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>9.4%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex align-items-center me-5">
                                            <div class="symbol symbol-30px me-5">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-sms fs-3 text-gray-600">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Email
                                                    Retargeting</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Direct
                                                    link clicks</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-6 me-3">1.23%</span>
                                            <div class="d-flex flex-center">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>0.2%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex align-items-center me-5">
                                            <div class="symbol symbol-30px me-5">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-icon fs-3 text-gray-600">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Referrals
                                                    Customers</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Direct
                                                    link clicks</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-6 me-3">0.08%</span>
                                            <div class="d-flex flex-center">
                                                <span class="badge badge-light-danger fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>0.4%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex align-items-center me-5">
                                            <div class="symbol symbol-30px me-5">
                                                <span class="symbol-label">
                                                    <i
                                                        class="ki-duotone ki-abstract-25 fs-3 text-gray-600">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Other</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Direct
                                                    link clicks</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-6 me-3">0.46%</span>
                                            <div class="d-flex flex-center">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>8.3%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 mb-5 mb-xl-10">
                        <div class="card card-flush h-md-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Sales Statistics</span>
                                    <span class="text-gray-400 pt-2 fw-semibold fs-6">Top Selling
                                        Products</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-100px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Remove</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Mute</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Settings</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div id="kt_charts_widget_13_chart" class="w-100 h-325px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-10 g-xl-10">
                    <div class="col-xl-4 mb-xl-10">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7 mb-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Visits by
                                        Country</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6">20 countries share
                                        97% visits</span>
                                </h3>
                                <div class="card-toolbar">
                                    <a href="../../demo1/dist/apps/ecommerce/sales/listing.html"
                                        class="btn btn-sm btn-light">View All</a>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="m-0">
                                    <div class="d-flex flex-stack">
                                        <img src="assets/media/flags/united-states.svg"
                                            class="me-4 w-25px" style="border-radius: 4px" alt="" />
                                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">United
                                                    States</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Direct
                                                    link clicks</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-6 me-3 d-block">9,763</span>
                                                <div class="m-0">
                                                    <span class="badge badge-light-success fs-base">
                                                        <i
                                                            class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>2.6%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <img src="assets/media/flags/brazil.svg" class="me-4 w-25px"
                                            style="border-radius: 4px" alt="" />
                                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Brasil</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">All
                                                    Social Channels</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-6 me-3 d-block">4,062</span>
                                                <div class="m-0">
                                                    <span class="badge badge-light-danger fs-base">
                                                        <i
                                                            class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>0.4%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <img src="assets/media/flags/turkey.svg" class="me-4 w-25px"
                                            style="border-radius: 4px" alt="" />
                                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Turkey</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Mailchimp
                                                    Campaigns</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-6 me-3 d-block">1,680</span>
                                                <div class="m-0">
                                                    <span class="badge badge-light-success fs-base">
                                                        <i
                                                            class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>0.2%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <img src="assets/media/flags/france.svg" class="me-4 w-25px"
                                            style="border-radius: 4px" alt="" />
                                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">France</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Impact
                                                    Radius visits</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-6 me-3 d-block">849</span>
                                                <div class="m-0">
                                                    <span class="badge badge-light-success fs-base">
                                                        <i
                                                            class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>4.1%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <img src="assets/media/flags/india.svg" class="me-4 w-25px"
                                            style="border-radius: 4px" alt="" />
                                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">India</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Many
                                                    Sources</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-6 me-3 d-block">604</span>
                                                <div class="m-0">
                                                    <span class="badge badge-light-danger fs-base">
                                                        <i
                                                            class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>8.3%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex flex-stack">
                                        <img src="assets/media/flags/sweden.svg" class="me-4 w-25px"
                                            style="border-radius: 4px" alt="" />
                                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Sweden</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Social
                                                    Network</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-6 me-3 d-block">237</span>
                                                <div class="m-0">
                                                    <span class="badge badge-light-success fs-base">
                                                        <i
                                                            class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>1.9%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-xl-10">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header py-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Social Network
                                        Visits</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6">8k social
                                        visitors</span>
                                </h3>
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-sm btn-light">View All</a>
                                </div>
                            </div>
                            <div
                                class="card-body card-body d-flex justify-content-between flex-column pt-3">
                                <div class="d-flex flex-stack">
                                    <img src="assets/media/svg/brand-logos/dribbble-icon-1.svg"
                                        class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                    <div
                                        class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                        <div class="me-5">
                                            <a href="#"
                                                class="text-gray-800 fw-bold text-hover-primary fs-6">Dribbble</a>
                                            <span
                                                class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Community</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-4 me-3">579</span>
                                            <div class="m-0">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>2.6%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <img src="assets/media/svg/brand-logos/linkedin-1.svg"
                                        class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                    <div
                                        class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                        <div class="me-5">
                                            <a href="#"
                                                class="text-gray-800 fw-bold text-hover-primary fs-6">Linked
                                                In</a>
                                            <span
                                                class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Social
                                                Media</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-4 me-3">2,588</span>
                                            <div class="m-0">
                                                <span class="badge badge-light-danger fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>0.4%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <img src="assets/media/svg/brand-logos/slack-icon.svg"
                                        class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                    <div
                                        class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                        <div class="me-5">
                                            <a href="#"
                                                class="text-gray-800 fw-bold text-hover-primary fs-6">Slack</a>
                                            <span
                                                class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Messanger</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-4 me-3">794</span>
                                            <div class="m-0">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>0.2%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <img src="assets/media/svg/brand-logos/youtube-3.svg"
                                        class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                    <div
                                        class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                        <div class="me-5">
                                            <a href="#"
                                                class="text-gray-800 fw-bold text-hover-primary fs-6">YouTube</a>
                                            <span
                                                class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Video
                                                Channel</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-4 me-3">1,578</span>
                                            <div class="m-0">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>4.1%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <img src="assets/media/svg/brand-logos/instagram-2-1.svg"
                                        class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                    <div
                                        class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                        <div class="me-5">
                                            <a href="#"
                                                class="text-gray-800 fw-bold text-hover-primary fs-6">Instagram</a>
                                            <span
                                                class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Social
                                                Network</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-4 me-3">3,458</span>
                                            <div class="m-0">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>8.3%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <img src="assets/media/svg/brand-logos/facebook-3.svg"
                                        class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                    <div
                                        class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                        <div class="me-5">
                                            <a href="#"
                                                class="text-gray-800 fw-bold text-hover-primary fs-6">Facebook</a>
                                            <span
                                                class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Social
                                                Network</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-800 fw-bold fs-4 me-3">2,047</span>
                                            <div class="m-0">
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>1.9%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-5 mb-xl-10">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Departments</span>
                                    <span class="text-gray-400 pt-2 fw-semibold fs-6">Performance &
                                        achievements</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div
                                                class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                Payments</div>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Create Invoice</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link flex-stack px-3">Create Payment
                                                <span class="ms-2" data-bs-toggle="tooltip"
                                                    title="Specify a target name for future usage and reference">
                                                    <i class="ki-duotone ki-information fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span></a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Generate Bill</a>
                                        </div>
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                            data-kt-menu-placement="right-end">
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">Subscription</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Plans</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Billing</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Statements</a>
                                                </div>
                                                <div class="separator my-2"></div>
                                                <div class="menu-item px-3">
                                                    <div class="menu-content px-3">
                                                        <label
                                                            class="form-check form-switch form-check-custom form-check-solid">
                                                            <input
                                                                class="form-check-input w-30px h-20px"
                                                                type="checkbox" value="1"
                                                                checked="checked"
                                                                name="notifications" />
                                                            <span
                                                                class="form-check-label text-muted fs-6">Recuring</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-item px-3 my-1">
                                            <a href="#" class="menu-link px-3">Settings</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div id="kt_charts_widget_14_chart" class="w-100 h-350px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-10 g-xl-10">
                    <div class="col-xl-4">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Visits by
                                        Source</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6">29.4k
                                        visitors</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">
                                                Quick Actions</div>
                                        </div>
                                        <div class="separator mb-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Ticket</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Customer</a>
                                        </div>
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                            data-kt-menu-placement="right-start">
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Admin Group</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Staff Group</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">Member Group</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">New Contact</a>
                                        </div>
                                        <div class="separator mt-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                    Reports</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-end">
                                <div class="w-100">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-5">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-rocket fs-3 text-gray-600">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Direct
                                                    Source</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Direct
                                                    link clicks</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-4 me-3">1,067</span>
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>2.6%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-5">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-tiktok fs-3 text-gray-600">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Social
                                                    Networks</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">All
                                                    Social Channels</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-4 me-3">24,588</span>
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>4.1%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-5">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-sms fs-3 text-gray-600">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Email
                                                    Newsletter</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Mailchimp
                                                    Campaigns</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="text-gray-800 fw-bold fs-4 me-3">794</span>
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>0.2%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-5">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-icon fs-3 text-gray-600">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Referrals</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Impact
                                                    Radius visits</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-4 me-3">6,578</span>
                                                <span class="badge badge-light-danger fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>0.4%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-5">
                                            <span class="symbol-label">
                                                <i class="ki-duotone ki-abstract-25 fs-3 text-gray-600">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                            <div class="me-5">
                                                <a href="#"
                                                    class="text-gray-800 fw-bold text-hover-primary fs-6">Other</a>
                                                <span
                                                    class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Many
                                                    Sources</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="text-gray-800 fw-bold fs-4 me-3">79,458</span>
                                                <span class="badge badge-light-success fs-base">
                                                    <i
                                                        class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>8.3%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pt-8 d-1">
                                        <a href="../../demo1/dist/apps/ecommerce/sales/details.html"
                                            class="text-primary opacity-75-hover fs-6 fw-bold">View
                                            Store Analytics
                                            <i class="ki-duotone ki-arrow-right fs-3 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Author Sales</span>
                                    <span class="text-gray-400 pt-2 fw-semibold fs-6">Statistics by
                                        Countries</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-100px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Remove</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Mute</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Settings</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div id="kt_charts_widget_15_chart"
                                    class="min-h-auto ps-4 pe-6 mb-3 h-350px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_app_footer" class="app-footer">
        <div
            class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
            <div class="text-dark order-2 order-md-1">
                <span class="text-muted fw-semibold me-1">2023&copy;</span>
                <a href="https://keenthemes.com" target="_blank"
                    class="text-gray-800 text-hover-primary">Keenthemes</a>
            </div>
            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                <li class="menu-item">
                    <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                </li>
                <li class="menu-item">
                    <a href="https://devs.keenthemes.com" target="_blank"
                        class="menu-link px-2">Support</a>
                </li>
                <li class="menu-item">
                    <a href="https://1.envato.market/EA4JP" target="_blank"
                        class="menu-link px-2">Purchase</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
@endpush