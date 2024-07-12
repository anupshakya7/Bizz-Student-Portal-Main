@extends('layout.home-layout.main')
@section('content')

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
        <img src="{{asset('images/logo-uk.png')}}" alt="logo" class="full_logo">
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link nav-button" href="#">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="clearfix"></div>

<section class="banner">
    <div class="container">
        <div class="row g-sm-5 g-3 align-items-center">
            <div class="col-sm-6">
                <h4>Unlock Your Academic Potential</h4>
                <h1>Innovative Solutions for Students and Educators</h1>
                <p>At The UK Study, we offer a seamless platform for students and institutions to manage academic information. Our solution simplifies access to application statuses, university details, course information, and more.</p>
            </div>
            <div class="col-sm-6">
                <img src="{{asset('images/banner/study-abroad.png')}}" alt="study-abroad">
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>

<section class="login_signup bg_blue ptb-40">
    <div class="container">
        <div class="inner">
            <h2>Unlock Your Potential</h2>
            <p>Gain the access you need to achieve your strategic goals. Connect with us today to benefit from the rich collaboration between universities, education consultants, and students.</p>
            <div class="buttons">
                <a href="" class="btn btn-button btn-white">Join Us</a>
                <a href="" class="btn btn-button btn-white">Sign In</a>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<section class="testimonial-wrapper bg_grey ptb-40 text-center">
  <div class="container">
    <h2>Testimonials</h2>
    <p class="subtitle text-center">What our students say</p>
    <div class="clearfix"></div>
    <div class="row g-sm-4 g-3 mtb-30">
      <div class="item col-sm-6">
        <div class="testiomial-wrap equal_height d-flex" style="height: 241.125px;">
          <div class="col-md-8">
            <div class="testimonial-content-wrap">
              I found Bizz consultancy as the best consultancy for abroad study. Bizz consultancy provides best counselling and guidance to students. All the staffs...
              <p><b>Manisha Gurung</b> <br>Student</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="testimonial-img-wrap">
              <div class="testimonial-images" style="background-image: url(https://bizzeducation.com/storage/testimonials/March2024/SjCOrULZNEZUdLVQAWmj.png);">
                <img class="lozad" data-src="{{asset('images/testimonial-bg.jpg')}}" alt="Manisha Gurung">
              </div>
              <div class="comma"><img class="lozad" data-src="https://bizzeducation.com/images/comma.png" alt="" src="https://bizzeducation.com/images/comma.png"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="item col-sm-6">
        <div class="testiomial-wrap equal_height d-flex" style="height: 241.125px;">
          <div class="col-md-8">
            <div class="testimonial-content-wrap">
              Firstly, I would like to thank entire team of bizz education , specially kedar sir for your guidance and support. One of the best consultancy for abro...
              <p><b>Safalta Koirala</b> <br>Student</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="testimonial-img-wrap">
              <div class="testimonial-images" style="background-image: url(https://bizzeducation.com/storage/testimonials/March2024/RcwnNaEJjdmqfeoXHxmA.png);">
                <img class="lozad" data-src="{{asset('images/testimonial-bg.jpg')}}" alt="Safalta Koirala" src="{{asset('images/testimonial-bg.jpg')}}">
              </div>
              <div class="comma"><img class="lozad" data-src="https://bizzeducation.com/images/comma.png" alt="" src="https://bizzeducation.com/images/comma.png"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="item col-sm-6">
        <div class="testiomial-wrap equal_height d-flex" style="height: 268.312px;">
          <div class="col-md-8">
            <div class="testimonial-content-wrap">
              The UK Study is one of the best consultancy in Nepal. The Bizz education team gave you genuine counseling and brilliant work from university process...
              <p><b>Riju Gautam</b> <br>Student of  UWS | University of the West of Scotland</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="testimonial-img-wrap">
              <div class="testimonial-images" style="background-image: url(https://bizzeducation.com/storage/testimonials/January2024/HIYhvrSv9TWCGgsUbY7t.jpg);">
                <img class="lozad" data-src="{{asset('images/testimonial-bg.jpg')}}" alt="Riju Gautam" src="{{asset('images/testimonial-bg.jpg')}}">
              </div>
              <div class="comma"><img class="lozad" data-src="https://bizzeducation.com/images/comma.png" alt="" src="https://bizzeducation.com/images/comma.png"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="item col-sm-6">
        <div class="testiomial-wrap equal_height d-flex" style="height: 268.312px;">
          <div class="col-md-8">
            <div class="testimonial-content-wrap">
              Hi, I must say The UK Study is one of the best consultancy in Nepal. The dedication they show to all of their students is illustrious. It was great...
              <p><b>Sangita Dhakal</b> <br>Student of UCLan | University of Central Lancashire</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="testimonial-img-wrap">
              <div class="testimonial-images" style="background-image: url(https://bizzeducation.com/storage/testimonials/January2024/stq225hOEmj0JmszmKsr.jpg);">
                <img class="lozad" data-src="{{asset('images/testimonial-bg.jpg')}}" alt="Sangita Dhakal" src="{{asset('images/testimonial-bg.jpg')}}">
              </div>
              <div class="comma"><img class="lozad" data-src="https://bizzeducation.com/images/comma.png" alt="" src="https://bizzeducation.com/images/comma.png"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
<section class="get_in_touch bg_blue ptb-40">
  <div class="container">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6">
          <div class="about-title second-atitle">
            <h2> Get in Touch</h2>
            <p>If you have any business related questions, or concerns, please send us a message and a member of our team will get in touch with you.</p>
          </div>
        </div>
          <div class="col-lg-2 "> 
            <a href="" class="btn btn-button btn-white">Contact Us</a> 
          </div>
        </div>
  </div>
</section>
<div class="clearfix"></div>
<footer class="footer">
  <div class="container">
    <div class="row justify-content-between g-sm-5 g-3">
      <div class="col-sm-4">
        <div class="footer-link">
          <p>At The UK Study, we offer a seamless platform for students and institutions to manage academic information.</p>

        </div>
      </div>
      <div class="col-sm-3">
        <div class="footer-widget mt-25">
          <h4>Nepal Office</h4>
          <div class="f-contact">
            <ul>
              <li>
                <i class="fas fa-map-marker-alt"></i></i> Gatthaghar, Bhaktapur
              </li>
              <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:info@bizzeducation.co.uk">info@bizzeducation.co.uk</a>
              </li>
              <li>
                <i class="fa fa-phone footer-small-icon"></i>
                <a href="">01-5913733</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="footer-widget mt-25">
          <h4>UK Office</h4>
          <div class="f-contact">
            <ul>
              <li>
                <i class="fas fa-map-marker-alt"></i></i> 42 Plungington Road, PR1 7RB, Preston, UK
              </li>
              <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:info@bizzeducation.co.uk">info@bizzeducation.co.uk</a>
              </li>
              <li>
                <i class="fa fa-phone footer-small-icon"></i>
                <a href="">+44 7447 627889 </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="footer-widget mt-25">
          <h4>Join Us</h4>
          <ul class="footer-links">
            <li>
              <a href="/login">Sign In</a>
            </li>
            <li>
              <a href="">Register</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</footer>
<div class="copyright-wrapper p-20">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6"> © 2024 The UK Study. All rights reserved. </div>
      <div class="col-lg-6">
        <div class="footer-social-links">
          <a target="_blank" class="hvr-icon-bob" title="Facebook" href="https://www.facebook.com/BizzEducationConsultancy/">
            <i class="fa-brands fa-facebook-f hvr-icon"></i>
          </a>
          <a target="_blank" class="hvr-icon-bob" title="Instagram" href="https://www.instagram.com/bizzeducationalconsultancy/?utm_medium=copy_link">
            <i class="fa-brands fa-instagram hvr-icon"></i>
          </a>
          <a target="_blank" class="hvr-icon-bob" title="TikTok" href="https://www.tiktok.com/@bizz_education">
            <i class="fa-brands fa-tiktok hvr-icon"></i>
          </a>
          <a target="_blank" class="hvr-icon-bob" title="LinkedIn" href="https://www.linkedin.com/company/bizz-education/">
            <i class="fa-brands fa-linkedin-in hvr-icon"></i>
          </a>
          <a target="_blank" class="hvr-icon-bob" title="Youtube" href="https://www.youtube.com/@BizzEducation2023">
            <i class="fa-brands fa-youtube hvr-icon"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection