@if(count($search)>0)
<input type="hidden" value="{{$result_count}}" id="count_result">
@foreach($search as $searchdata)
<div class="col-md-12">
	<div class="search_result_inner">
		<div class="row g-0 p-0">
			<div class="col-sm-7 border-line equal_height d-flex align-items-end">
				<div style="display:inline-block; width:100%;">
					<div class="university_logo text-center">
						<a onClick="universitySelect({{$searchdata->id}})" style="cursor: pointer !important;">
							<img src="https://mis.bizzeducation.com/backend/web/{{$searchdata->university_logo}}"
								alt="">
						</a>
					</div>

					<h5 class="uni_name">{{$searchdata->university_name}}</h5>
					<div class="location justify-content-center">
						<!--<img src="https://cdn.britannica.com/25/4825-004-F1975B92/Flag-United-Kingdom.jpg" alt="">-->
						<h4>{{$searchdata->country}}</h4>
					</div>
				</div>
			</div>
			<div class="col-sm-5 border-line ">
				<div class="uni_details equal_height">
					<ul class="heading-top">
						<li class="red">Available Intake</li>
					</ul>
					@if(!empty($searchdata->intake))
					<h3>{{$searchdata->intake}}</h3>
					@else
					<h3>Intake Month Not Found</h3>
					@endif
					<div class="button text-end">
						<form method="GET" action="{{route('applynow.index')}}">
							<input type="hidden" name="cname" value="{{$searchdata->country}}">
							<input type="hidden" name="uid" value="{{$searchdata->id}}">
							<button type="submit" class="btn btn-button btn-primary" style="border:none;">Apply</button>
						</form>
						<!--<a href="#" class="btn btn-button btn-primary">Apply</a>-->
					</div>
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