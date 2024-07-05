@extends('layout.main')
@section('style')
    <style>
        #myTab {
            display: inline-flex;
            justify-content: center;
        }

        #myTab.representative-wrapper {
            display: block;
        }

        #myTab .nav-item {
            font-size: 17px;
            background: #174084;
            color: white;
            transition: 0.2s ease-in-out;
        }

        #myTab .nav-item:hover {
            background: #D21B0F;
        }

        .university-logo-wrap:hover {
            box-shadow: 0 0 3px #000;
        }

        #myTab.representative-wrapper .nav-item {
            background: transparent;
            margin: 0 15px;
            text-align: center;
            margin-bottom: 30px;
        }

        .representative-wrapper .nav-item img {
            width: 200px;
            border-radius: 15px 15px 0 0;
        }

        .representative-wrapper .nav-item a {
            background: var(--primary);
            padding: 12px 20px;
            margin: 0 10px;
            border-radius: 15px;
            color: var(--white);
            text-align: center;
            width: 219px;
            margin: auto;
        }

        .representative-wrapper .nav-item a:hover {
            background: var(--red);
        }

        .university-country {
            font-weight: bold;
            margin-top: 30px;
        }

        .university-title-wrap {
            margin-bottom: 30px;
        }

        .university-title-wrap span {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: 15px;
            display: inline-block;
        }

        @media(max-width:1120px) {

            .representative-listing-wrapper,
            #myTab.representative-wrapper {
                width: 100%;
            }

            #myTab.representative-wrapper {
                /* display: inline-flex; */
            }
        }

        @media(max-width:900px) {
            #myTab.representative-wrapper .nav-item {
                margin: 0 2px 5px 2px;
            }

            #myTab.representative-wrapper {
                justify-content: left;
                /* overflow-x: scroll; */
                margin-bottom: 30px;
            }

            .university-title-wrap {
                font-size: 18px;
                letter-spacing: 1px;
            }

            #myTab.representative-wrapper::-webkit-scrollbar {
                width: 0;
                height: 4px;
            }

            .representative-wrapper .nav-item a {
                width: auto;
            }
        }

        .nav-tabs .nav-link {
            border-radius: 0;
        }

        .nav-tabs {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            /* background: var(--primary);
      border-radius:20px; */
            overflow: hidden;
            border: 0;
        }

        .nav-tabs li {
            background: var(--primary);
            overflow: hidden;
        }

        .nav-tabs li:first-child {
            border-radius: 15px 0 0 15px;
        }

        .nav-tabs li:last-child {
            border-radius: 0 15px 15px 0;
        }

        .nav-tabs .nav-link {
            padding: 10px 15px;
            color: var(--white);
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            background: var(--red);
            color: var(--white);
        }

        .nav-tabs .nav-item button span {
            font-size: 20px;
            font-weight: bold;
        }

        table th {
            font-size: 18px;
            background: rgba(23, 55, 110, 1);
            background: -moz-linear-gradient(top, rgba(23, 55, 110, 1) 0%, rgba(20, 114, 168, 1) 100%);
            background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(23, 55, 110, 1)), color-stop(100%, rgba(20, 114, 168, 1)));
            background: -webkit-linear-gradient(top, rgba(23, 55, 110, 1) 0%, rgba(20, 114, 168, 1) 100%);
            background: -o-linear-gradient(top, rgba(23, 55, 110, 1) 0%, rgba(20, 114, 168, 1) 100%);
            background: -ms-linear-gradient(top, rgba(23, 55, 110, 1) 0%, rgba(20, 114, 168, 1) 100%);
            background: linear-gradient(to bottom, rgba(23, 55, 110, 1) 0%, rgba(20, 114, 168, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#17376e', endColorstr='#1472a8', GradientType=0);
            color: #fff !important;
        }
    </style>
@endsection
@section('content')

    <div class="container">
        <h3 class="text-center py-4">
            <span class="label label-success">{{ $processing ? $processing->uni_name : '' }}</span>
        </h3>
        @if ($processing)
            <ul class="nav nav-tabs status-nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'offer') active @endif" id="offer-status"
                        data-bs-toggle="tab" data-bs-target="#offer-status-tab-pane" type="button" role="tab"
                        aria-controls="offer-status-tab-pane" aria-selected="true">Offer Status</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'noc') active @endif" id="noc-status"
                        data-bs-toggle="tab" data-bs-target="#noc-status-tab-pane" type="button" role="tab"
                        aria-controls="noc-status-tab-pane" aria-selected="false">NOC Status</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'tb') active @endif" id="tb-test"
                        data-bs-toggle="tab" data-bs-target="#tb-test-tab-pane" type="button" role="tab"
                        aria-controls="tb-test-tab-pane" aria-selected="false">TB Test</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'fund') active @endif" id="fund-management"
                        data-bs-toggle="tab" data-bs-target="#fund-management-tab-pane" type="button" role="tab"
                        aria-controls="fund-management-tab-pane" aria-selected="false">Fund Management</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'cas') active @endif" id="cas-status"
                        data-bs-toggle="tab" data-bs-target="#cas-status-tab-pane" type="button" role="tab"
                        aria-controls="cas-status-tab-pane" aria-selected="false">CAS Status</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'interview') active @endif" id="interview-status"
                        data-bs-toggle="tab" data-bs-target="#interview-status-tab-pane" type="button" role="tab"
                        aria-controls="interview-status-tab-pane" aria-selected="false">Interview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'visa') active @endif" id="visa-status"
                        data-bs-toggle="tab" data-bs-target="#visa-status-tab-pane" type="button" role="tab"
                        aria-controls="visa-status-tab-pane" aria-selected="false">VISA Status</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($processing->last_state == 'enroll') active @endif" id="enrollment-status"
                        data-bs-toggle="tab" data-bs-target="#enrollment-status-tab-pane" type="button" role="tab"
                        aria-controls="enrollment-status-tab-pane" aria-selected="false">Enrollment Status</button>
                </li>
            </ul>
            <!-- tab content start -->
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade @if ($processing->last_state == 'offer') show active @endif my-4"
                    id="offer-status-tab-pane" role="tabpanel" aria-labelledby="offer-status" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Offer Status</th>
                                <th>Updated Date</th>
                                <th>Receive Type</th>
                                <th>Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($processing->offer_status != 'noaction' && $processing->offer_status != '')
                                @if ($processing->offer_applied_date && $processing->offer_applied_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Offer Applied</td>
                                        <td>{{ $processing->offer_applied_date }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endif
                                @if ($processing->offer_received_date && $processing->offer_received_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Offer Received</td>
                                        <td>{{ $processing->offer_received_date }}</td>
                                        <td>{{ $processing->offer_received_type }}</td>
                                        <td>{{ $processing->offer_remarks }}</td>
                                    </tr>
                                @endif
                                @if ($processing->offer_rejected_date && $processing->offer_rejected_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Offer Rejected</td>
                                        <td>{{ $processing->offer_rejected_date }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endif
                                @if ($processing->offer_drop_date && $processing->offer_drop_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Offer Withdraw</td>
                                        <td>{{ $processing->offer_drop_date }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td>Offer (No action)</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade @if ($processing->last_state == 'noc') show active @endif my-4"
                    id="noc-status-tab-pane" role="tabpanel" aria-labelledby="noc-status" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NOC Status</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($processing->noc_letter != '')
                                @if ($processing->noc_applied_date && $processing->noc_applied_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>NOC Booked</td>
                                        <td>{{ $processing->noc_applied_date }}</td>
                                    </tr>
                                @endif

                                @if ($processing->noc_collected_date && $processing->noc_collected_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>NOC Received</td>
                                        <td>{{ $processing->noc_collected_date }}</td>
                                    </tr>
                                @endif
                                @if ($processing->noc_rejected_date && $processing->noc_rejected_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>NOC Rejected</td>
                                        <td>{{ $processing->noc_rejected_date }}</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td>Not Applied</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade @if ($processing->last_state == 'tb') show active @endif my-4"
                    id="tb-test-tab-pane" role="tabpanel" aria-labelledby="tb-test" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>TB Test</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($processing->tb_test != '')
                                @if ($processing->tb_applied_date && $processing->tb_applied_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>TB Test Booked</td>
                                        <td>{{ $processing->tb_applied_date }}</td>
                                    </tr>
                                @endif

                                @if ($processing->tb_collected_date && $processing->tb_collected_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>TB Test Received</td>
                                        <td>{{ $processing->tb_collected_date }}</td>
                                    </tr>
                                @endif
                                @if ($processing->tb_rejected_date && $processing->tb_rejected_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>TB Test Rejected</td>
                                        <td>{{ $processing->tb_rejected_date }}</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td>Not Applied</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade @if ($processing->last_state == 'fund') show active @endif my-4"
                    id="fund-management-tab-pane" role="tabpanel" aria-labelledby="fund-management" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fund Management</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($processing->fund_management == 'cash')
                                @if ($processing->cash_start_date != null)
                                    <tr>
                                        <td>Cash Start</td>
                                        <td>{{ $processing->cash_start_date }}</td>
                                    </tr>
                                @endif
                                @if ($processing->cash_matured_date != null)
                                    <tr>
                                        <td>Cash Matured</td>
                                        <td>{{ $processing->cash_matured_date }}</td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade @if ($processing->last_state == 'cas') show active @endif my-4"
                    id="cas-status-tab-pane" role="tabpanel" aria-labelledby="cas-status" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>CAS Status</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($processing->cas_status) && $processing->cas_status != 'noaction')
                                @if ($processing->cas_applied_date && $processing->cas_applied_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>CAS Applied</td>
                                        <td>{{ $processing->cas_applied_date }}</td>
                                    </tr>
                                @endif

                                @if ($processing->cas_received_date && $processing->cas_received_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>CAS Received</td>
                                        <td>{{ $processing->cas_received_date }}</td>
                                    </tr>
                                @endif
                                @if ($processing->cas_rejected_date && $processing->cas_rejected_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>CAS Rejected</td>
                                        <td>{{ $processing->cas_rejected_date }}</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td>Not Applied</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade @if ($processing->last_state == 'interview') show active @endif my-4"
                    id="interview-status-tab-pane" role="tabpanel" aria-labelledby="interview-status" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Booked At</th>
                                <th>Passed On</th>
                                <th>Failed On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visainterview as $visaint)
                                <tr>
                                    <td>{{ $visaint->booked_date ? $visaint->booked_date : '-' }}</td>
                                    <td>{{ $visaint->passed_on ? $visaint->passed_on : '-' }}</td>
                                    <td>{{ $visaint->failed_on ? $visaint->failed_on : '-' }}</td>
                                    <td>{{ $visaint->status ? $visaint->status : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade @if ($processing->last_state == 'visa') show active @endif my-4"
                    id="visa-status-tab-pane" role="tabpanel" aria-labelledby="visa-status" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Visa Status</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($processing->visa_status != 'no action' && $processing->visa_status != '')
                                @if ($processing->visa_lodged_date && $processing->visa_lodged_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Visa Lodged</td>
                                        <td>{{ $processing->visa_lodged_date }}</td>
                                    </tr>
                                @endif
                                @if ($processing->visa_appeal_date && $processing->visa_appeal_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Visa Appealed</td>
                                        <td>{{ $processing->visa_appeal_date }}</td>
                                    </tr>
                                @endif
                                @if ($processing->visa_response_date && $processing->visa_response_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Visa {{ $processing->visa_status == 'rejected' ? 'Rejected' : 'Received' }}</td>
                                        <td>{{ $processing->visa_response_date }}</td>
                                    </tr>
                                @endif
                                @if ($processing->visa_dropout_date && $processing->visa_dropout_date != '0000-00-00 00:00:00')
                                    <tr>
                                        <td>Visa withdraw</td>
                                        <td>{{ $processing->visa_dropout_date }}</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td>Visa (No action)</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade @if ($processing->last_state == 'enroll') show active @endif my-4"
                    id="enrollment-status-tab-pane" role="tabpanel" aria-labelledby="enrollment-status" tabindex="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Enrollment Status</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($processing->enrolled_status == 'yes')
                                <tr>
                                    <td>Enrolled</td>
                                    <td>{{ $processing->enrolled_date }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>Not Enrolled</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <h3>Apologies, your application is still <span style="color:var(--red);">pending,</span><span
                    style="color:#162667;"> or the processing has not yet commenced.</span></h3>
            <!-- <div class="p-2" style="background-color:#a61731;/*border-radius:20px;width: 350px;margin: 0px auto;margin-top:20px;*/"> -->
            <div class="p-2">
                <h3
                    style="background: var(--primary);padding: 10px;max-width: 455px;margin: auto;margin-bottom: auto;color: var(--white);border-radius: 15px 0;margin-bottom: 30px;">
                    Application is on Pending</h3>
            </div>
            <h3>Please return later.</h3>
            <div class="our_services_btn text-center">
                <a class="hvr-sweep-to-right back-home p-3 px-5" href="{{ route('home') }}" class="bttn"><i
                        class="fa-solid fa-arrow-left"></i> Back to Home</a>
            </div>
        @endif
    </div>

@endsection
