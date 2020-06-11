@extends('layouts.app')
@section('content')


<div class="search-sec">
    <div class="container">
        <div class="search-box">
            <form method="GET" action="/search">
                <input type="text" name="search" class="text-dark" placeholder="Search keywords">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</div>

<main>
    <div class="main-section">
        <div class="container">
            <div class="main-section-data">
                <div class="row">

                    @include('categories.index')
                    
                    <div class="col-lg-6 col-md-8 no-pd">
                        <div class="main-ws-sec">
                           
                            <div class="posts-section">
                                <div class="top-profiles">
                                    <div class="pf-hd">
                                        <h3>Top Professionals Rates</h3>
                                        <!--i class="la la-ellipsis-v"></i-->
                                    </div>
                                    <div class="profiles-slider">

                                        <!--- top professionals by rate -->
                                        {{-- <div class="user-profy">
                                            <img src="{{ url('design/style') }}/images/resources/user1.png" alt="">
                                            <h3>John Doe</h3>
                                            <span>Graphic Designer</span>
                                            <ul>
                                                <li><a href="#" title="" class="post-jb active follow">ASK</a></li>

                                                <li><a href="#" title="" class="hire">ZOOM</a></li>
                                            </ul>
                                            <a href="/style/profile" title="">View Profile</a>
                                        </div> --}}
                                        
                                    </div>
                                    <!--profiles-slider end-->
                                </div>
                                <!--top-profiles end-->
                                    @if($flag=='create')
                                        @include('questions.create')  
                                    @elseif($flag =='edit')   
                                        @include('questions.edit')
                                    @else
                                       @include('answers.show')    
                                    @endif            
                               
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 pd-right-none no-pd">
                        <div class="right-sidebar">

                            @guest
                            <div class="widget widget-about">
                            <h1 class="font-weight-bold text-capitalize mt-3" style="font-family: 'Gochi Hand', cursive; font-size:50px">Techvisor</h1>
                                {{-- <img src="{{ url('design/style') }}/images/wd-logo.png" alt=""> --}}
                                {{-- <h3>IT Workwise</h3> --}}
                                <div class="sign_link">
                                    <h3><a href="{{ route('login') }}">{{ __('Login') }} </a></h3>
                                </div>
                            </div>
                            @endguest
                            
                            <!--widget-about end-->
                            
                            <!--widget-jobs end-->


                        </div>
                        <!--right-sidebar end-->
                    </div>
                </div>
            </div><!-- main-section-data end-->
        </div>
    </div>
</main>






</div>
<!--theme-layout end-->
<!-- add the post Q -->

<div class="post-popup job_post">
    <div class="post-project">
        <h3>Post a Question</h3>
        <div class="post-project-fields">
            <form>
                <div class="row">
                    <div class="col-lg-12">
                        <textarea name="question" placeholder="Question"></textarea>
                    </div>
                    <div class="col-lg-12">
                        <ul>
                            <li><button class="active" type="submit" value="post">Post</button></li>
                            <li><a href="#" title="">Cancel</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        <!--post-project-fields end-->
        <a href="#" title=""><i class="la la-times-circle-o"></i></a>
    </div>
    <!--post-project end-->
</div>
<!--post-project-popup end-->

@endsection