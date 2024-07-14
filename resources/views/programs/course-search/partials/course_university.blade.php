@if(count($search)>0)
<input type="hidden" value="{{$result_count}}" id="count_result">
@foreach($search as $searchdata)
<div class="search_result_inner">
	<div class="row g-0 p-0">
		<div class="col-sm-5 border-line equal_height d-flex align-items-end">
			<div style="display:inline-block; width:100%;">
				<div class="university_logo text-center">
					<img src="https://mis.bizzeducation.com/backend/web/{{$searchdata->university_logo}}" alt="">
				</div>
				<h5 class="uni_name d-none d-sm-flex">{{$searchdata->university_name}}</h5>
				<div class="location d-none d-sm-flex justify-content-center">
					<!--<img src="https://cdn.britannica.com/25/4825-004-F1975B92/Flag-United-Kingdom.jpg" alt="">-->
					<h4>{{$searchdata->country}}</h4>
				</div>
				<!--<div class="location d-flex d-sm-none justify-content-center">
					<h4>Intake</h4>
				</div>-->
			</div>
		</div>
		<div class="col-sm-7 border-line ">
			<div class="uni_details equal_height">
				<ul class="heading-top">
					<li class="red justify-content-center">{{$searchdata->intake}}</li>
					<li class="justify-content-center">{{$searchdata->level}}</li>
				</ul>
				<h3 class="text-center">{{$searchdata->courses_name}}</h3>
				<table>
					<thead>
						<tr>
							<th>Requirements</th>
							<th>IELTS</th>
							<th>PTE</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$searchdata->requirement}}</td>
							<td>{{$searchdata->ielts_requirement}}</td>
							<td>{{$searchdata->pte_requirement}}</td>
						</tr>
					</tbody>
				</table>
				<table>
					<thead>
						<tr>
							<th>Fees</th>
							<th>Scholarship</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{!empty($searchdata->fees) ? $searchdata->fees: '0'}}</td>
							<td>{{!empty($searchdata->scholarship) ? $searchdata->scholarship: '0'}}</td>
						</tr>
					</tbody>
				</table>
				<div class="button text-end">
					<form method="GET" action="{{route('applynow.index')}}">
						<input type="hidden" name="cname" value="{{$searchdata->country}}">
						<input type="hidden" name="uid" value="{{$searchdata->uni_id}}">
						<input type="hidden" name="couid" value="{{$searchdata->courses_id}}">
						<button type="submit" class="btn btn-button btn-primary">Apply</button>
					</form>
					<!--<a href="#" class="btn btn-button btn-primary">Apply</a>-->
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
<div class="d-flex justify-content-center">
	{!!$search->onEachSide(1)->links()!!}
</div>
@else
<h3 style="margin: 30px; text-align: center;">Data Not Found</h3>
@endif