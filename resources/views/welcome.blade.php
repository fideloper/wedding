@extends('layout')

@section('content')
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">&nbsp;</a>
            </div>
            {{--<div class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Username</a></li>
              </ul>
            </div><!--/.nav-collapse -->--}}
        </div>
    </div>
    <div class="wide">
        <div class="col-xs-4 line"><hr></div>
        <div class="col-xs-4 logo fancy">Chris &amp; Natalie's Wedding 2016</div>
        <div class="col-xs-4 line"><hr></div>
    </div>

    <div class="container main-body">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h1 class="title fancy">May 14<sup>th</sup>, 2016</h1>
                    <img width="450" height="413" src="/img/chris_natalie2.jpg" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2 class="fancy subtitle">Where?</h2>
                <p>From May 12<sup>th</sup> through May 15<sup>th</sup>, we're having an intimate family wedding at Baron's Creekside (<a href="https://www.google.com/maps/dir/San+Antonio+International+Airport,+Airport+Boulevard,+San+Antonio,+TX/316+Goehmann+Ln,+Fredericksburg,+TX+78624/@29.8836862,-98.9463567,10z/data=!3m1!4b1!4m13!4m12!1m5!1m1!1s0x865c8abbb1cb8027:0xfa6173ab1a2fcc52!2m2!1d-98.4683484!2d29.5311973!1m5!1m1!1s0x865bc06f79756037:0x8aa2de6e5157aa36!2m2!1d-98.8502299!2d30.2619927" target="_blank">directions from SAT</a> | <a href="http://www.baronscreekside.com/" target="_blank">website</a>)
                    in Fredericksburg, TX.</p>
                <p>There are a lot of fun things to do in Fredericksburg! Here are some sites with more information on the city:</p>
                <ul>
                    <li><a href="http://www.fredericksburgtexas-online.com/">fredericksburgtexas-online.com</a></li>
                    <li><a href="http://www.visitfredericksburgtx.com/">visitfredericksburgtx.com</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="fancy subtitle">Honeymoon</h2>
                <p>We will be honey mooning over 12 days, split between Barcelona and Seville, Spain.</p>
                <ul>
                    <li>Barcelona - <a href="http://www.oliviabalmeshotel.es/en/">Olivia Balmes Hotel</a></li>
                    <li>Seville - <a href="http://casadelpoeta.es/">Casa del Poeta</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="fancy title">Registry</h1>
            </div>
            <div class="col-md-6">
                <p>In lieu of traditional gifts (since we don't have a house to fill yet!), we're asking that people contribute towards our honeymoon!</p>
                <form action="/charge" method="POST" id="donate_form">
                    <div class="form-group form-inline">
                        <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="00.00" />
                        </div>
                        <button class="btn btn-primary" id="customButton">contribute!</button>
                    </div>
                    <input type="hidden" name="token" id="token" value="" />
                    <input type="hidden" name="email" id="email" value="" />
                    <input type="hidden" name="created" id="created" value="" />
                    <input type="hidden" name="cents" id="cents" value="" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </form>
            </div>
            <div class="col-md-6">
                <p>We are also registered for gift cards at West Elm and Target (see links below).</p>
                <ul>
                    <li><a href="https://secure.westelm.com/registry/phxv5r78sr/registry-list.html" target="_blank">West Elm</a></li>
                    <li><a href="https://www-secure.target.com/gift-registry/giftgiver?registryId=zfA3vNBKLA5VCU3GwLoguQ&lnk=copiedLink" target="_blank">Target</a></li>
                </ul>
            </div>
        </div>
    </div><!-- /.container -->
@endsection

@section('javascript')
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script src="{{ elixir('js/app.js') }}"></script>
    <script>
        var dollarAmount = 0;
        var handler = StripeCheckout.configure({
            key: '{{ env("STRIPE_PUBLIC") }}',
            image: '/img/chris_natalie.png',
            locale: 'auto',
            token: function(token) {
                // Use the token to create the charge with a server-side script.
                // You can access the token ID with `token.id`
                $('#token').val(token.id);
                $('#email').val(token.email);
                $('#created').val(token.created);
                $('#cents').val(dollarAmount);
                $('#donate_form').submit();
            }
        });

        $('#customButton').on('click', function(e) {
            dollarAmount = parseFloat($('#amount').val()) * 100;

            handler.open({
                name: 'Wedding!',
                description: 'Chris & Natalie 2016',
                amount: dollarAmount
            });
            e.preventDefault();
        });

        // Close Checkout on page navigation
        $(window).on('popstate', function() {
            handler.close();
        });
    </script>
@endsection