@extends('layout.main')
@section('style')
<style>

#myTab{
	display:inline-flex;
	justify-content: center;
}

#myTab.representative-wrapper{
  display: block;
}

#myTab .nav-item{
	font-size:17px;
	background:#174084;
	color:white;
	transition:0.2s ease-in-out;
}

#myTab .nav-item:hover{
	background:#D21B0F;
}

.university-logo-wrap:hover{
	box-shadow: 0 0 3px #000;
}

#myTab.representative-wrapper .nav-item{
  background: transparent;
  margin: 0 15px;
  text-align: center;
  margin-bottom: 30px;
}

.representative-wrapper .nav-item img{
  width: 200px;
  border-radius: 15px 15px 0 0;
}

.representative-wrapper .nav-item a{
  background: var(--primary);
  padding: 12px 20px;
  margin: 0 10px;
  border-radius: 15px;
  color: var(--white);
  text-align: center;
  width: 219px;
  margin: auto;
}

.representative-wrapper .nav-item a:hover{
  background: var(--red);
}

.university-country{
  font-weight:bold;
  margin-top:30px;
}
.university-title-wrap{
	margin-bottom:30px;
}
.university-title-wrap span{
  background: var(--primary);
  color: white;
  padding: 10px 20px;
  border-radius: 15px;
  display:inline-block;
}
@media(max-width:1120px){
  .representative-listing-wrapper,
  #myTab.representative-wrapper{
    width: 100%;
  }
  #myTab.representative-wrapper{
    /* display: inline-flex; */
  }
}
@media(max-width:900px){
  #myTab.representative-wrapper .nav-item{
    margin: 0 2px 5px 2px;
  }
  #myTab.representative-wrapper{
    justify-content: left;
    /* overflow-x: scroll; */
    margin-bottom: 30px;
  }
  .university-title-wrap{
    font-size: 18px;
    letter-spacing: 1px;
  }
  #myTab.representative-wrapper::-webkit-scrollbar {
    width: 0;
    height: 4px;
  }
  .representative-wrapper .nav-item a{
    width: auto;
  }
}
.nav-tabs .nav-link{
  border-radius: 0;
}
.nav-tabs{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  /* background: var(--primary);
  border-radius:20px; */
  overflow: hidden;
  border: 0;
}
.nav-tabs li{
  background: var(--primary);
  overflow: hidden;
}
.nav-tabs li:first-child{
  border-radius:15px 0 0 15px;
}
.nav-tabs li:last-child{
  border-radius:0 15px 15px 0;
}
.nav-tabs .nav-link{
  padding: 10px 15px;
  color: var(--white);
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
  background: var(--red);
  color: var(--white);
}
.nav-tabs .nav-item button span{
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
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#17376e', endColorstr='#1472a8', GradientType=0 );
    color: #fff !important;
}
</style>
@endsection
@section('content')

<div class="container">
  <h3 class="text-center py-4">
    <span class="label label-success">University of Central Lancashire - Preston</span>
  </h3>
  <ul class="nav nav-tabs status-nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="offer-status" data-bs-toggle="tab" data-bs-target="#offer-status-tab-pane" type="button" role="tab" aria-controls="offer-status-tab-pane" aria-selected="true">Offer Status</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="noc-status" data-bs-toggle="tab" data-bs-target="#noc-status-tab-pane" type="button" role="tab" aria-controls="noc-status-tab-pane" aria-selected="false" tabindex="-1">NOC Status</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tb-test" data-bs-toggle="tab" data-bs-target="#tb-test-tab-pane" type="button" role="tab" aria-controls="tb-test-tab-pane" aria-selected="false" tabindex="-1">TB Test</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="fund-management" data-bs-toggle="tab" data-bs-target="#fund-management-tab-pane" type="button" role="tab" aria-controls="fund-management-tab-pane" aria-selected="false" tabindex="-1">Fund Management</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="cas-status" data-bs-toggle="tab" data-bs-target="#cas-status-tab-pane" type="button" role="tab" aria-controls="cas-status-tab-pane" aria-selected="false" tabindex="-1">CAS Status</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="interview-status" data-bs-toggle="tab" data-bs-target="#interview-status-tab-pane" type="button" role="tab" aria-controls="interview-status-tab-pane" aria-selected="false" tabindex="-1">Interview</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="visa-status" data-bs-toggle="tab" data-bs-target="#visa-status-tab-pane" type="button" role="tab" aria-controls="visa-status-tab-pane" aria-selected="false" tabindex="-1">VISA Status</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="enrollment-status" data-bs-toggle="tab" data-bs-target="#enrollment-status-tab-pane" type="button" role="tab" aria-controls="enrollment-status-tab-pane" aria-selected="false" tabindex="-1">Enrollment Status</button>
    </li>
  </ul>
  <!-- tab content start -->
  <div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade my-4 active show" id="offer-status-tab-pane" role="tabpanel" aria-labelledby="offer-status" tabindex="0">
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
          <tr>
            <td>Offer Received</td>
            <td>2020-03-03 16:00:00</td>
            <td>UnConditional OR</td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade my-4" id="noc-status-tab-pane" role="tabpanel" aria-labelledby="noc-status" tabindex="0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>NOC Status</th>
            <th>Updated Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Not Applied</td>
            <td>-</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade my-4" id="tb-test-tab-pane" role="tabpanel" aria-labelledby="tb-test" tabindex="0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>TB Test</th>
            <th>Updated Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Not Applied</td>
            <td>-</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade my-4" id="fund-management-tab-pane" role="tabpanel" aria-labelledby="fund-management" tabindex="0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Fund Management</th>
            <th>Updated Date</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    <div class="tab-pane fade my-4" id="cas-status-tab-pane" role="tabpanel" aria-labelledby="cas-status" tabindex="0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>CAS Status</th>
            <th>Updated Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>CAS Received</td>
            <td>2020-07-30 04:00:59</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade my-4" id="interview-status-tab-pane" role="tabpanel" aria-labelledby="interview-status" tabindex="0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Booked At</th>
            <th>Passed On</th>
            <th>Failed On</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    <div class="tab-pane fade my-4" id="visa-status-tab-pane" role="tabpanel" aria-labelledby="visa-status" tabindex="0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Visa Status</th>
            <th>Updated Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Visa Received</td>
            <td>2020-10-07 06:09:03</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade my-4" id="enrollment-status-tab-pane" role="tabpanel" aria-labelledby="enrollment-status" tabindex="0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Enrollment Status</th>
            <th>Updated Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Not Enrolled</td>
            <td>-</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection