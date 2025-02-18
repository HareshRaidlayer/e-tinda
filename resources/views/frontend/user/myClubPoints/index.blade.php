@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="aiz-user-panel">
        <a class="back-button" href="{{route('dashboard')}}"><i class="las la-angle-left fs-14"></i> Back</a>
        <div class="aiz-titlebar mt-2 mb-4 mt-2">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="fs-20 fw-700 text-dark">{{ translate('My Clubpoints') }}</h1>
                </div>
            </div>
        </div>
        <div class="bg-dark overflow-hidden">
            <div class="px-3 py-4">
                <div class="fs-14 fw-400 text-center text-secondary mb-1">{{ translate('Exchange rate') }}</div>
                <div class="fs-30 fw-700 text-center text-white">{{ $clubPoint->value ?? '' }} {{ translate(' Points') }} =
                    {{ single_price(1) }} {{ translate('PowerPay eWallet Money') }}</div>
            </div>
        </div>
        <br>

        <div class="p-4 bg-secondary-base">
            <div class="d-flex align-items-center pb-3 ">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                    <g id="Group_25000" data-name="Group 25000" transform="translate(-926 -614)">
                        <rect id="Rectangle_18646" data-name="Rectangle 18646" width="48" height="48" rx="24"
                            transform="translate(926 614)" fill="rgba(255,255,255,0.5)" />
                        <g id="Group_24786" data-name="Group 24786" transform="translate(701.466 93)">
                            <path id="Path_2961" data-name="Path 2961"
                                d="M221.069,0a8,8,0,1,0,8,8,8,8,0,0,0-8-8m0,15a7,7,0,1,1,7-7,7,7,0,0,1-7,7"
                                transform="translate(27.466 537)" fill="#fff" />
                            <path id="Union_11" data-name="Union 11"
                                d="M16425.393,420.226l-3.777-5.039a.42.42,0,0,1-.012-.482l1.662-2.515a.416.416,0,0,1,.313-.186l0,0h4.26a.41.41,0,0,1,.346.19l1.674,2.515a.414.414,0,0,1-.012.482l-3.777,5.039a.413.413,0,0,1-.338.169A.419.419,0,0,1,16425.393,420.226Zm-2.775-5.245,3.113,4.148,3.109-4.148-1.32-1.983h-3.592Z"
                                transform="translate(-16177.195 129)" fill="#fff" />
                        </g>
                    </g>
                </svg>
                <div class="ml-3 d-flex flex-column justify-content-between">
                    <span class="fs-16 fw-400 text-white mb-1">{{ translate('Total Club Points') }}</span>
                    <span class="fs-20 fw-700 text-white">{{ Auth::user()->earn_point }}</span>
                </div>
            </div>

            <a href="{{ route('convert_into_wallet') }}" class="fs-16 text-white btn btn-dark btn-block fs-14 fw-500 w-xl-50">
                {{ translate('Convert To PowerPay eWallet Money') }}
            </a>
        </div>

        {{-- <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('Clubpoint Earning History') }}</h5>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0 footable footable-1 breakpoint-xl" style="">
                    <thead class="text-gray fs-12">
                        <tr class="footable-header">






                            <th class="pl-0 footable-first-visible" style="display: table-cell;">#</th>
                            <th style="display: table-cell;">Code</th>
                            <th data-breakpoints="lg" style="display: table-cell;">Points</th>
                            <th data-breakpoints="lg" style="display: table-cell;">Converted</th>
                            <th data-breakpoints="lg" style="display: table-cell;">Date</th>
                            <th class="text-right pr-0 footable-last-visible" style="display: table-cell;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="fs-14">















                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">01
                            </td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220912-10085522
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                Refunded
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">12-09-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <span class="badge badge-inline text-white badge-warning p-3 fs-12"
                                    style="border-radius: 25px; min-width: 80px !important;">Refunded</span>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">02
                            </td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220828-12334652
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                Refunded
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">28-08-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <span class="badge badge-inline text-white badge-warning p-3 fs-12"
                                    style="border-radius: 25px; min-width: 80px !important;">Refunded</span>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">03
                            </td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220828-12334652
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                Refunded
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">28-08-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <span class="badge badge-inline text-white badge-warning p-3 fs-12"
                                    style="border-radius: 25px; min-width: 80px !important;">Refunded</span>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">04
                            </td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220726-08040637
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                175 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">25-07-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(36)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">05
                            </td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220602-13204496
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                400 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">11-06-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(35)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                06</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220605-10102737
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                Refunded
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">05-06-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <span class="badge badge-inline text-white badge-warning p-3 fs-12"
                                    style="border-radius: 25px; min-width: 80px !important;">Refunded</span>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                07</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20210520-10563650
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                250 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">27-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(33)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                08</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20210520-10560247
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                Refunded
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">27-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <span class="badge badge-inline text-white badge-warning p-3 fs-12"
                                    style="border-radius: 25px; min-width: 80px !important;">Refunded</span>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                09</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220421-06464117
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                Refunded
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">20-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <span class="badge badge-inline text-white badge-warning p-3 fs-12"
                                    style="border-radius: 25px; min-width: 80px !important;">Refunded</span>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                10</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220420-07493371
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                125 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">19-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(30)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                11</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220420-07435544
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                75 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">19-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(29)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                12</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220420-07253614
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                75 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">19-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(28)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                13</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220420-07224759
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                75 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">19-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(27)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                14</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220420-07194867
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                125 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">19-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(26)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                        <tr>








                            <td class="pl-0 footable-first-visible" style="vertical-align: middle; display: table-cell;">
                                15</td>
                            <td class="fw-700 text-primary" style="vertical-align: middle; display: table-cell;">
                                20220420-07073292
                            </td>
                            <td class="fw-700" style="vertical-align: middle; display: table-cell;">
                                475 pts
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">
                                <span class="badge badge-inline badge-info p-3 fs-12"
                                    style="border-radius: 25px;">No</span>
                            </td>
                            <td style="vertical-align: middle; display: table-cell;">19-04-2022</td>
                            <td class="text-right pr-0 footable-last-visible"
                                style="vertical-align: middle; display: table-cell;">

                                <button onclick="convert_point(25)" class="btn btn-sm btn-styled btn-primary"
                                    style="border-radius: 25px;">Convert Now</button>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="aiz-pagination mt-3">
                    <nav>
                        <ul class="pagination">

                            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                <span class="page-link" aria-hidden="true">‹</span>
                            </li>





                            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                            <li class="page-item"><a class="page-link"
                                    href="https://demo.activeitzone.com/ecommerce/earning-points?page=2">2</a></li>
                            <li class="page-item"><a class="page-link"
                                    href="https://demo.activeitzone.com/ecommerce/earning-points?page=3">3</a></li>


                            <li class="page-item">
                                <a class="page-link" href="https://demo.activeitzone.com/ecommerce/earning-points?page=2"
                                    rel="next" aria-label="Next »">›</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div> --}}
    </div>
@endsection
@section('script')
@endsection
