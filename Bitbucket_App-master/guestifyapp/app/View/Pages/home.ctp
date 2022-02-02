<?php
    $title_for_layout = __('Guestify - simple and valuable customer feedback & ratings for your restaurant');
    $this->set('title_for_layout', $title_for_layout);

    // Set specific meta tags
    $meta_keywords = __('customer rating, ratings, feedback, voting, criticism, compliment, valuable information, constructive');
    $meta_description = __('With guestify.net restaurants, bistros or bars get easy and valuable feedback from their customers through a QR-code via smartphone.');
    echo $this->Html->meta(array('name' => 'keywords', 'content' => $meta_keywords), null, array('inline' => false));
    echo $this->Html->meta(array('name' => 'description', 'content' => $meta_description), null, array('inline' => false));


    // Facebook OpenGraph
    $seo_image = Configure::read('NON_SSL_HOST').'/graphics/logos/300/guestify_logo_word_brand_regular_square_300.jpg';
    echo $this->Html->meta(array('property' => 'og:title', 'content' => $title_for_layout), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:description', 'content' => $meta_description), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:image', 'content' => $seo_image), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:url', 'content' => Configure::read('NON_SSL_HOST') . $this->here), null, array('inline' => false));

?>

<?php // ******************** MASTHEAD SECTION ******************** // ?>
<main id="top" class="masthead">

    <div class="container">
        <div class="logo">
            <a href="/"><img src="graphics/logos/800/guestify_logo_word_brand_inverse_dark_800.png" alt="Guestify" class="img-responsive" /></a>
        </div>

        <h1><?php echo __('The'); ?> <strong><?php echo __('easiest and most powerful way'); ?></strong> <br>
        <?php echo __('to get'); ?> <strong><?php echo __('customer feedback'); ?></strong> <?php echo __('in your restaurant.'); ?></h1>

        <?php /*
        <?php $check = $this->Session->read('EaryAccess'); ?>
        <div class="row">
            <div class="col-xs-6 col-sm-12 col-xs-offset-3 subscribe">
                <?php if($check != 1) { ?>
                    <?php $display = 'display: none;'; ?>
                    <form class="form-horizontal" role="form" action="/early_accesses/validateEmail" id="subscribeForm" method="POST">
                        <div class="form-group">
                            <div class="col-xs-7 col-sm-6 col-sm-offset-1 col-xs-offset-0">
                                <input class="form-control input-lg" name="data[EarlyAccess][email]" type="email" id="address" placeholder="<?php echo __('Enter your email'); ?>" required="false">
                            </div>
                            <div class="col-xs-5 col-sm-4">
                                <button id="submit-early-access" type="submit" class="btn btn-success btn-lg"><?php echo __('GET ACCESS'); ?></button>
                            </div>
                        </div>
                    </form>

                    <div id="error-container" class="alert alert-danger" style="opacity: 0;"></div>
                <?php } else { ?>
                    <?php $display = ''; ?>
                <?php } ?>

                <div id="success-container" class="alert alert-success" style="<?php echo $display; ?>">
                    <?php echo __('Thank you! We will contact you as soon as possible!'); ?>
                </div>

            </div>
        </div>
        */ ?>
        <div class="row">
            <div class="col-lg-3 col-xs-12"></div>
            <div class="col-lg-6 col-xs-12">
                <div class="clearfix">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <a href="/login" class="btn btn-primary btn-lg btn-block"><strong><?php echo __('Login'); ?></strong></a>&nbsp;
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/register" class="btn btn-danger btn-lg btn-block"><strong><?php echo __('Sign Up for FREE'); ?></strong></a>
                    </div>
                </div>

                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
            </div>
            <div class="col-lg-3 col-xs-12"></div>
        </div>


        <a href="/#explore" class="scrollto">
        <p><?php echo __('SCROLL DOWN TO EXPLORE'); ?></p>
        <p class="scrollto--arrow"><img src="images/scroll_down.png" alt="scroll down arrow"></p>
        </a>
    </div><?php // --/container -- ?>
</main><?php // --/main -- ?>



<div class="container" id="explore">

    <div class="clearfix">&nbsp;</div>
    <div class="pull-left">
        <a href="/login" class="btn btn-default"><?php echo __('Login'); ?></a>
        <a href="/register" class="btn btn-default"><?php echo __('Sign Up'); ?></a>
    </div>
    <?php /* ACTIVATE LANGUAGE SELECTOR
    <div class="btn-group pull-right">
        <?php $codes = Configure::read('Locales'); ?>
        <?php foreach($codes as $locale => $name) { ?>
            <?php
                $langname = '';
                if($locale == 'deu') {
                    $langname = __('German');
                } else {
                    $langname = __('English');
                }
                echo $this->Html->link(
                    $this->Html->image('/img/flags/'.substr($locale, 0, 2).'.png', array('alt' => $langname)),
                    '/' . substr($locale, 0, 2),
                    array(
                        'class' => 'btn btn-link', 'title' => __('Guestify in').' '.$langname, 'escape' => false
                    )
                );
            ?>
        <?php } ?>
    </div>
    */ ?>

    <?php // -- ******************** FEATURES SECTION ******************** -- ?>


    <section class=" heroimg breath">
        <div class="section-title">
            <h2><?php echo __('Customer ratings with style.'); ?></h2>
            <h4><?php echo __('Invite your clients to rate your restaurant their smartphones.'); ?></h4>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <img src="images/smartphones.jpg" class="hands-on-mobile" alt="<?php __('Process of Guestify'); ?>" />
                <div class="screen_slider">
                    <div class="slideshow">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <?php //-- Indicators -- ?>
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>

                            <?php //-- Wrapper for slides -- ?>
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <img src="images/gs_slide_001.png" alt="Slide 1" />
                                </div>
                                <div class="item">
                                    <img src="images/gs_slide_002.png" alt="Slide 2" />
                                </div>
                                <div class="item">
                                    <img src="images/gs_slide_003.png" alt="Slide 3" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><?php // --/section -- ?>


    <section class="row features">
        <div class="section-title">
            <h2><?php echo __('More information about our product.'); ?></h2>
            <p class="lead text-center"><?php echo __('In less then 5 minutes you can offer your guests a direct and easy way to rate your restaurant, bar or cafe. '); ?> <?php echo __('Via QR-Code or direct link over their smartphone your guest can access your individual score sheet to rate your food, atmosphere or service.'); ?> <?php echo __('Have a look at our important features.'); ?></p>
        </div>

        <div class="row">

            <div class="col-sm-3 col-xs-6">
                <div class="thumbnail">
                    <img src="images/icon_rate.svg" alt="analytics-icon">
                    <div class="caption">
                        <h3><?php echo __('Rate'); ?></h3>
                        <p><?php echo __('Simple and fast rating on mobile web browsers of any smartphones.'); ?></p>
                    </div>
                </div><?php // --/thumbnail -- ?>
            </div><?php // --/col-sm-6-- ?>

            <div class="col-sm-3 col-xs-6">
                <div class="thumbnail">
                    <img src="images/icon_gather.svg" alt="analytics-icon">
                    <div class="caption">
                        <h3><?php echo __('Gather'); ?></h3>
                        <p><?php echo __('Track and record ratings, get valuable insights and beautiful charts.'); ?></p>
                    </div>
                </div><?php // --/thumbnail -- ?>
            </div><?php // --/col-sm-6-- ?>

            <div class="col-sm-3 col-xs-6">
                <div class="thumbnail">
                    <img src="images/icon_analyze.svg" alt="analytics-icon">
                    <div class="caption">
                        <h3><?php echo __('Analyze'); ?></h3>
                        <p><?php echo __('Evaluate customer feedbacks by identifying good and bad days.'); ?></p>
                    </div>
                </div><?php // --/thumbnail -- ?>
            </div><?php // --/col-sm-6-- ?>

            <div class="col-sm-3 col-xs-6">
                <div class="thumbnail">
                    <img src="images/icon_improve.svg" alt="analytics-icon">
                    <div class="caption">
                        <h3><?php echo __('Improve'); ?></h3>
                        <p><?php echo __('Make decision based on real customer feedbacks'); ?></p>
                    </div>
                </div><?php // --/thumbnail --?>
            </div><?php // --/col-sm-6-- ?>
        </div>
    </section><?php // --/section -- ?>

    <section class=" features">
        <div class="section-title">
            <h2><?php echo __('Features'); ?></h2>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="thumbnail">
                    <p class="lead text-right">
                        <?php echo __('Customer survey on site'); ?><br />
                        <?php echo __('Unlimited surveys'); ?><br />
                        <?php echo __('Simple survey catalog'); ?><br />
                        <?php echo __('Custom scaling setting'); ?><br />
                        <?php echo __('Individual QR code for each survey'); ?><br />
                        <?php echo __('PIN secured'); ?><br />
                        <?php echo __('Simple analysis and usage with beautiful charts'); ?><br />
                        <?php echo __('Daily, weekly, monthly and yearly statistics'); ?><br />
                        <?php echo __('Customization of Look`n`Feel'); ?><br />
                        <?php echo __('Widget for your website or app'); ?><br />
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="thumbnail">
                    <p class="lead text-left">
                        <?php echo __('E-Mail notification'); ?><br />
                        <?php echo __('Excel export'); ?><br />
                        <?php echo __('Responsive smartphone support (no app needed!)'); ?><br />
                        <?php echo __('Multi-Restaurants management'); ?><br />
                        <?php echo __('Multilingual'); ?><br />
                        <?php echo __('URL matching and redirection'); ?><br />
                        <?php echo __('Table card templates ready for printing'); ?><br />
                        <?php echo __('Ready for gastronomy chains'); ?><br />
                        <?php echo __('API support'); ?><br />
                        <?php echo __('and much more...'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class=" features">
        <div class="section-title">
            <h2><?php echo __('You want to try? Here is our demo!'); ?></h2>
        </div>
        <div class="row">
            <div class="hidden-xs hidden-sm col-md-3 col-xs-12"></div>
            <div class="col-sm-6 col-md-3 col-xs-12">
                <p class="text-center">
                    <img src="/graphics/demo/demo-iPhone-6.png" alt="Demo Pizzeria Luigi" class="img-responsive" /><br />
                </p>
            </div>
            <div class="col-sm-6 col-md-3 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="text-center  hidden-xs">
                            <img src="/graphics/demo/qr-pizzeria-luigi_300.png" alt="QR Code Pizzeria Luigi" class="img-responsive" />

                            <img src="/graphics/demo/arrows.png" alt="arrows" class="" /><br />
                            <span class="lead"><?php echo __('Scan me'); ?></span><br />
                            <?php echo __('Scan the QR code, type in the PIN 12345 and try the survey'); ?>
                            <a href="http://demo.guestify.net" class="btn btn-link btn-block">Or click here to try Demo</a>
                        </p>
                        <p class="text-center hidden-sm hidden-md hidden-lg">
                            <a href="http://demo.guestify.net" class="btn btn-primary btn-lg btn-block">Try Demo</a>
                            <img src="/graphics/demo/arrows.png" alt="arrows" class="" /><br />
                            <span class="lead"><?php echo __('Open the survey'); ?></span><br />
                            <?php echo __('Click on the link above, type in the PIN 12345 and try the survey'); ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <?php // -- ******************** CLIENTS SECTION ******************** -- ?>
    <?php /*
    <div class="section-title">
        <h2>Some of our clients</h2>
        <h4>We work with different kind of brands</h4>
    </div>

    <section class="row clientlogo breath">
        <div class="col-xs-12 text-center">
            <img src="images/client-logos.png" alt="client-logos">
        </div>
    </section><?php // --/section -- ?>
    */ ?>


</div><?php // --/container -- ?>


<?php // -- ******************** TESTIMONIALS SECTION ******************** -- ?>
<?php /*
<div class="highlight testimonials">
    <div class="container">
        <div class="section-title">
            <h2>What our customers said</h2>
            <h4>Don't take our word. See our testimonials </h4>
        </div>

        <section class="row breath">
            <div class="col-xs-6">
                <div class="testblock">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </div>
                <div class="clientblock">
                    <img src="images/customer-img-1.jpg" alt=".">
                    <p><strong>John Doe</strong> <br>
                        Founder of <a href="index.html#">Blacktie.co</a>
                    </p>
                </div>
            </div><?php // --/col-xs-6 -- ?>

            <div class="col-xs-6">
                <div class="testblock">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </div>
                <div class="clientblock">
                    <img src="images/customer-img-2.jpg" alt=".">
                    <p><strong>Richard Sommer</strong> <br>
                        CEO of <a href="index.html#">Blacktie.co</a>
                    </p>
                </div>
            </div><?php // --/col-xs-6 -- ?>
        </section><?php // --/section -- ?>

    </div><?php // --/container -- ?>
</div><?php // --/highlight Testimonials -- ?>
*/ ?>

<?php // -- ******************** PRICING LIST ******************** -- ?>
<div class="container">

    <div class="section-title">
        <h2><?php echo __('Honest pricing. No surprises.'); ?></h2>
        <h4><?php echo __('No contract. No risk. No credit card required. 30-Day-Money-Back-Guarantee.'); ?> </h4>

    </div>

    <section class="row breath planpricing">


        <div class="col-lg-4 col-xs-12">
            <div class="pricing color4">
                <div class="planname"><?php echo __('Free'); ?></div>
                <div class="price"> <span class="curr">$</span>0</div>
                <div class="billing"><?php echo __('50 ratings free'); ?></div>
            </div><?php // --/pricing -- ?>
        </div><?php // --/col-xs-3-- ?>


        <div class="col-lg-4 col-xs-12">
            <div class="pricing color1">
                <div class="planname"><?php echo __('Monthly'); ?></div>
                <div class="price">  <span class="curr">$</span><?php echo $config['prices']['m']; ?><span class="per">/<?php echo __('MO'); ?></span></div>
                <div class="billing"><?php echo __('Billed at start'); ?></div>
            </div><?php // --/pricing -- ?>
        </div><?php // --/col-xs-3-- ?>

        <div class="col-lg-4 col-xs-12">
            <div class="pricing color3">
                <div class="planname"><?php echo __('Yearly'); ?></div>
                <div class="price">  <span class="curr">$</span><?php echo $config['prices']['y']; ?><span class="per">/<?php echo __('Y'); ?></span></div>
                <div class="billing"><?php echo __('Billed at start'); ?></div>
            </div><?php // --/pricing -- ?>
        </div><?php // --/col-xs-3-- ?>
    </section><?php //-- /section planpricing -- ?>

    <?php /*
    <div class="text-center">
        <section class="row prices breath">
            <h3 class="text-info"><strong><?php echo __('Pssst. This is a promotion - get your limited offer now!'); ?> </strong></h3>
            <small><?php echo __('Limited to the next 100 accounts. First come, frist serve!'); ?></small><br />
            <small><?php echo __('All prices are per poll and are excluded local taxes.'); ?></small>
        </div>
        <div class="col-sm-4 col-sm-offset-4 col-xs-12">
            <div class="pricing color1">
                <div class="planname"><?php echo __('Free for 3 months!'); ?></div>
                <div class="price"> <span class="curr">$</span>0</div>
                <div class="billing"><?php echo __('Limited offer'); ?></div>
            </div>
        </div>
    </section>

    */ ?>


</div>

<div class="container">
    <?php // -- ******************** FAQ ******************** -- ?>
    <div class="section-title">
        <h5><?php echo __('Frequently Asked Questions'); ?></h5>
    </div>

    <div class="container">
        <section class="row faq breath">

            <div class="col-sm-4 col-xs-12">
                <h6><?php echo __('For whom is Guestify interesting?'); ?></h6>
                <p><?php echo __('Everyone who runs a restaurant, bar, cafer or similar. If you care about what your guest thinks about your gastronomy, with Guestify you get real-time ratings with ease.'); ?></p>
                <h6><?php echo __('How does the free version work?'); ?></h6>
                <p><?php echo __('Our free version is 100% free and does not require credit card information to start. This version is limited to 100 ratings and if you would like to upgrade, great. If not, no problem you can use it as long as you want.'); ?></p>
            </div><?php // --/col-sm-6 -- ?>
            <div class="col-sm-4 col-xs-12">
                <h6><?php echo __('Free, Pro? Pay as you go!');?></h6>
                <p><?php echo __('If you decide to go PRO, you just choose the period that fits to you the most. You will get access to very useful report features such day, week month and year overviews, XLS export and email notifications.'); ?></p>
                <h6><?php echo __('Can I switch plans later?'); ?></h6>
                <p><?php echo __('Absolutely. You can switch between free and our paid plans, whenever you like. The system will append the period automatically to your running PRO plan.'); ?></p>
            </div>
            <div class="col-sm-4 col-xs-12">
                <h6><?php echo __('Do I need to choose a plan now?'); ?></h6>
                <p><?php echo __('No. You get the full featured, but to 100 ratings limited version of our service completely. Once you are ready to upgrade, you may choose a plan which suits your needs.'); ?></p>
                <h6><?php echo __('What payment types do you accept?'); ?></h6>
                <p><?php echo __('We accept payments from PayPal and on account. MasterCard, Visa and Bank Transfer will be accepted soon. Remember, you do not need to supply card details to start your free version.'); ?></p>
            </div><?php // --/col-xs-6 -- ?>
        </section><?php // --/section faq -- ?>

    </div>
</div><?php // --/container -- ?>

<?php // -- ******************** FOOTER ******************** -- ?>
<div class="footercta" >
    <div class="container">
        <h2><?php echo __('Get started in less then'); ?> <strong><?php echo __('5 minutes'); ?></strong> <br>
            <?php echo __('to get'); ?> <strong><?php echo __('customer feedback'); ?></strong> <?php echo __('in your restaurant.'); ?></h2>

        <div class="row">
            <div class="col-xs-12 breath text-center">
                <a href="/register" class="btn btn-danger btn-lg gototop"><?php echo __('Sign Up for FREE'); ?></a>
            </div>
        </div>
    </div><?php // --/container -- ?>
</div><?php // --/main -- ?>


<div id="footer" class="container">
    <section class="row breath">
        <div class="col-sm-4 col-xs-12">
            <a href="https://www.facebook.com/guestifyapp" target="_blank" title="<?php echo __('Follow us on Facebook'); ?>"><img src="/graphics/own-social/48-facebook.png" alt="facebook" /></a>&nbsp;
            <a href="https://twitter.com/guestifyapp" target="_blank" title="<?php echo __('Follow us on twitter'); ?>"><img src="/graphics/own-social/48-twitter.png" alt="twitter" /></a>
        </div>
        <div class="col-sm-8 col-xs-12">
            <div class="pull-right">
                <a href="/" class="btn btn-default"><?php echo __('Home'); ?></a>
                <a href="/login" class="btn btn-default"><?php echo __('Login'); ?></a>
                <a href="/register" class="btn btn-default"><?php echo __('Sign Up'); ?></a>
                <a href="/privacy" class="btn btn-default"><?php echo __('Privacy Policy'); ?></a>
            </div>
        </div>
    </section>
    <section class="row breath">
        <div class="col-sm-4 col-xs-12">
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="footerlinks">
                <h4>"<?php echo __('Love your guests!'); ?>"</h4>
                <p>&copy; <?php echo date('Y'); ?> GUESTIFY.NET. <?php echo __('All Rights Reserved'); ?></p>
                <p><small><?php echo __(''); ?></small></p>
            </div>

        </div>
        <div class="col-sm-4 col-xs-12">
            <small class="spacer"></small>
            <p class="made-in-germany text-right ">

            </p>
        </div>
    </section>
    <hr />
    <section class="row breath">
        <!--<div class="col-xs-12"><h4><?php //echo __('Legal'); ?> </h4></div>-->
        <div class="col-sm-4 col-xs-12">
            <h4><?php echo __('Contact'); ?></h4>

            <p><?php echo __('E-Mail: info [at] guestify.net'); ?></p>

            <!--<p><?php //echo __('Telefon'); ?>: <?php //echo __('012345678'); ?></p>-->



        </div>
        <!--<div class="col-sm-4 col-xs-12">
            <h4><?php echo __('Address'); ?></h4>
            <p>
                <?php //echo __('Guestify.net'); ?><br />
                <?php //echo __('4030 Wake Forest Road STE 439'); ?><br />
                <?php //echo __('Raleigh'); ?>, <?php //echo __('NC, 27609'); ?>
            </p>
        </div>-->
        <div class="col-sm-4 col-xs-12">

        </div>

    </section>
</div>


<?php /*
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/easing.js"></script>
<script src="js/nicescroll.js"></script>
*/ ?>


<script>

    $(document).ready(function() {

        $(document).on('click', '#submit-early-access', function() {

            $('#error-container').fadeTo('fast', 0, function() {

                var email = encodeURIComponent($('#address').val());

                $.ajax({
                    url: '/early_accesses/validateEmail',
                    data: {
                        "email" : email
                    },
                    dataType: 'json',
                    complete: function(){
                        return false;
                    },
                    success: function(result) {
                        if(result == 1) {

                            $('#subscribeForm').slideUp('fast', function() {
                                $('#success-container').fadeTo('fast', 1, function() {
                                    return false;
                                });
                            });


                        } else {
                            $('#error-container').html(result);
                            $('#error-container').fadeTo('fast', 1, function() {
                                return false;
                            });
                        }

                        return false;
                    }
                });
                return false;
            });

            return false;
        });

    });


 $(function() {
    $('.scrollto, .gototop').bind('click',function(event){
         var $anchor = $(this);
         $('html, body').stop().animate({
         scrollTop: $($anchor.attr('href')).offset().top
          }, 1500,'easeInOutExpo');
     event.preventDefault();
      });
  });


</script>
