@section('title', '首页')
@extends('back.layout')
@section('content')


    <div class="row">
        <div class="col-lg-4">
            <div class="contact-box">
                <a href="profile.html">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/back/patterns/chan.jpg">
                            <div class="m-t-xs font-bold">欢迎小主 {{ Auth::user()->name }}</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>Alex Johnatan</strong></h3>
                        <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                        <address>
                            <strong>Twitter, Inc.</strong><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br>
                            <abbr title="Phone">P:</abbr> (123) 456-7890
                        </address>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-box">
                <a href="profile.html">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/back/a3.jpg">
                            <div class="m-t-xs font-bold">Marketing manager</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>Monica Smith</strong></h3>
                        <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                        <address>
                            <strong>Twitter, Inc.</strong><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br>
                            <abbr title="Phone">P:</abbr> (123) 456-7890
                        </address>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-box">
                <a href="profile.html">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/back/a4.jpg">
                            <div class="m-t-xs font-bold">Sales manager</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>Michael Zimber</strong></h3>
                        <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                        <address>
                            <strong>Twitter, Inc.</strong><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br>
                            <abbr title="Phone">P:</abbr> (123) 456-7890
                        </address>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-box">
                <a href="profile.html">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/back/a5.jpg">
                            <div class="m-t-xs font-bold">Graphics designer</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>Sandra Smith</strong></h3>
                        <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                        <address>
                            <strong>Twitter, Inc.</strong><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br>
                            <abbr title="Phone">P:</abbr> (123) 456-7890
                        </address>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-box">
                <a href="profile.html">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/back/a6.jpg">
                            <div class="m-t-xs font-bold">Graphics designer</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>Janet Carton</strong></h3>
                        <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                        <address>
                            <strong>Twitter, Inc.</strong><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br>
                            <abbr title="Phone">P:</abbr> (123) 456-7890
                        </address>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>

    </div>

@endsection