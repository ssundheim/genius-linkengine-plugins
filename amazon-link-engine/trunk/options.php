<?php
    $gr_image_path = plugins_url().'/amazon-link-engine/img/';
?>

<style>
  .gr-tsid-spinner {
    display: none;
    opacity: .5;
  }
  .gr-tsid-loaded {
    display: none;
  }
  .gr-status-loading-tsid .gr-tsid-spinner {
    display: block;
  }
  .gr-status-loaded-tsid .gr-tsid-loaded {
    display: block;
  }
  .gr-tsid-loaded {
    margin-top: 5px;
  }

  .gr-connected-success {
    font-weight: bold;
    color: #00b9ee;
  }

  .gr-my-tsid {
    font-weight: normal;
    color: #6f6f6f;
  }
  .gr-tiny {
    font-size: 10px;
  }

  #gr-tsid-error {
    display: none;
    color: #880000;
    margin-top: 5px;
  }
  .gr-status-error-tsid #gr-tsid-error {
    display: block;
  }

  #gr-tsid-mismatch-error {
    display: none;
    color: #880000;
    margin-top: 5px;
    width: 447px;
    padding: 20px;
    border: 1px solid #880000;
    border-radius: 6px;
  }

  #gr-tsid-mismatch-error strong {
    font-size: 140%;
  }

  #gr-affiliates-spinner {
    display: none;
    opacity: .5;
  }
  .gr-status-loading-affiliates #gr-affiliates-spinner {
    display: block;
  }
  .gr-status-loading-affiliates #gr-affiliates-loaded {
    display: none;
  }
  #gr-affiliates-loaded {
    margin-top: 5px;
    opacity: .6;
    display: none;
  }
  .gr-status-loaded-affiliates #gr-affiliates-loaded {
    display: block;
  }
  #gr-affiliates-error {
    display: none;
    color: #880000;
    margin-top: 5px;
  }
  .gr-status-error-affiliates #gr-affiliates-error {
    display: block;
  }


  /* CSS css-only-spinner */
  .css-only-spinner {
    margin: 5px 5px 0 0;
    text-align: left;
    display: inline-block;
  }

  .css-only-spinner > div {
    width: 10px;
    height: 10px;
    background-color: #333;

    border-radius: 100%;
    display: inline-block;
    -webkit-animation: bouncedelay 1.4s infinite ease-in-out;
    animation: bouncedelay 1.4s infinite ease-in-out;
    /* Prevent first frame from flickering when animation starts */
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
  }

  .css-only-spinner .bounce1 {
    -webkit-animation-delay: -0.32s;
    animation-delay: -0.32s;
  }

  .css-only-spinner .bounce2 {
    -webkit-animation-delay: -0.16s;
    animation-delay: -0.16s;
  }

  @-webkit-keyframes bouncedelay {
    0%, 80%, 100% { -webkit-transform: scale(0.0) }
    40% { -webkit-transform: scale(1.0) }
  }

  @keyframes bouncedelay {
    0%, 80%, 100% {
      transform: scale(0.0);
      -webkit-transform: scale(0.0);
    } 40% {
        transform: scale(1.0);
        -webkit-transform: scale(1.0);
      }
  }
  /* End CSS css-only-spinner. */


  .gr-step-area {
    width: 445px;
    border-radius: 3px;
    background: rgba(255,255,255,.5);
    border: 1px solid rgba(0,0,0,.1);
    padding: 10px 20px 10px 20px;
    min-height: 48px;
    margin-bottom: 3px;
  }
  .gr-step-area strong {
   font-size: 14px;
  }

  .gr-step-area a:link, .gr-step-area a:visited {
    text-decoration: none;
  }
  .gr-step-number {
    float: left;
    width: 40px;
    height: 40px;
    border-radius: 21px;
    border: 2px dashed #999999;
    color: #7a7a7a;
    line-height: 42px;
    text-align: center;
    font-size: 21px;
    font-weight: bold;
    position: relative;
  }

  .gr-step-complete .gr-step-number {
    border: 2px solid #00b9ee;
    color: #00b9ee;
    background-color: #ffffff;www;
  }

  .gr-step-info {
    margin: 5px 0 10px 65px;
  }

  #connect-gr-api-form {
    margin-top: 20px;
  }

  .gr-georiot-logo {
    vertical-align: -13%;
    border: none;
  }

  .gr-bygr {
    font-size: 55%;
  }

  .gr-checkmark {
    height: 20px;
    width: 20px;
    background: #00b9ee url('<?php print $gr_image_path ?>check.png') center center no-repeat;
    border-radius: 10px;
    position: absolute;
    left: 28px;
    top: 24px;
    display: none;
  }

  .gr-step-complete .gr-checkmark {
    display: block;
  }

  h3 {
    font-size: 22px;
    color: #999;
    margin-top: 30px;
    font-weight: normal;
  }

  .gr-intro {
    max-width: 500px;
  }

  #gr-advanced-options {
    position: relative;
    min-height: 0;
  }

  .gr-advanced-options-fields {
    overflow: hidden;
    transition: height .3s;
    height: 0;
  }

  .expanded .gr-advanced-options-fields {
    height: 120px;
    transition: height .3s;
  }

  .gr-expand, .gr-collapse {
    font-size: 18px;
    text-align: right;
    display: inline-block;
    width: 20px;
    font-style: normal;
    font-weight: bold;
    color: #444444;
  }

  .gr-expand, .gr-collapse, h5 {
    cursor: pointer;
  }

  .gr-collapse {
    display: none;
  }

  .expanded .gr-collapse {
    display: inline-block;
  }
  .expanded .gr-expand, .expanded .hidden-expanded {
    display: none;
  }


  #gr-advanced-options h5{
    font-size: 14px;
    margin: 0;
  }


  #georiot_tsid_select {
  }


</style>

<script>
  jQuery(document).ready(function($) {

    var pluginPageInitializing = true;

    //Update the affiliates section and load groups on page load, if the API keys are filled
    if ( $('#georiot_api_key').val().length == 32 && $('#georiot_api_secret').val().length == 32 ) {
      getGeoriotAffiliates();
      connectGeoriotApi();
    }


    $('.gr-expand, .gr-collapse, #gr-advanced-options h5').click( function() {
      $('#gr-advanced-options').toggleClass('expanded');;
    });


    //Auto highlight the API fields on focus
    $('#georiot_api_key').click( function() {
      $(this).select();
    });
    $('#georiot_api_secret').click( function() {
      $(this).select();
    });

    //Clear API fields and TSID if user clicks disconnect button
    $('#gr-disconnect-api').click( function() {
      $('#georiot_api_key').val('');
      $('#georiot_api_secret').val('');
      $('#georiot_tsid').val('');
      $('#gr-step-2').removeClass('gr-step-complete');
      $('#connect-gr-api-form').removeClass('gr-status-loaded-tsid');
      $('#gr-step-3').removeClass('gr-step-complete');
      $('#connect-gr-api-form').removeClass('gr-status-loaded-affiliates');

      alert('Your API values have been cleared. To finish, remember to click "Save Changes".');

    });

    //Detect paste into the api key or secret fields.
    $('#georiot_api_key, #georiot_api_secret').on('paste', function () {
      var element = this;
      setTimeout(function () {
        getGeniusLinkTSID();
      }, 500);
    });

    // Re-submit button can also trigger api connect
    $('.gr-resubmit').click( function(e) {
      getGeniusLinkTSID();
      e.preventDefault();
    });

    // Refresh button for the affiliates section
    $('.gr-refresh-affiliates').click( function(e) {
      getGeoriotAffiliates();
      e.preventDefault();
    });

    function getGeniusLinkTSID() {
      // Validate fields and then send request
      // If both api fields are correct, check the API
      if ( $('#georiot_api_key').val().length == 32 && $('#georiot_api_secret').val().length == 32 ) {
        connectGeoriotApi();
      } else if( $('#georiot_api_key').val().length > 0 && $('#georiot_api_secret').val().length > 0 ) {
        //if both fields have values, but are not the right length, tell the user
        if($('#georiot_api_key').val().length != 32) alert('The API Key field appears to be invalid. Please copy and paste it again');
        if($('#georiot_api_secret').val().length != 32) alert('The API Secret field appears to be invalid. Please copy and paste it again');
      }
    }


    function connectGeoriotApi() {
      // Show loading indicators and disable submit button while we wait for a response
      $('#connect-gr-api-form').addClass('gr-status-loading-tsid');
      $('#connect-gr-api-form').removeClass('gr-status-loaded-tsid');
      $('#connect-gr-api-form').removeClass('gr-status-error-tsid');
      $('.button-primary').prop("disabled",true);

      var georiotApiKey = $('#georiot_api_key').val();
      var georiotApiSecret = $('#georiot_api_secret').val();
      var georiotApiUrlGroups = "https://api.geni.us/v1/groups/get-all-with-details?apiKey="+georiotApiKey+"&apiSecret="+georiotApiSecret;

      var requestGeniusLinkGroups = $.ajax({
        url : georiotApiUrlGroups,
        dataType : "json",
        timeout : 10000
      })
        .done(function( data ) {
          grGroups = data.Groups;
          grNumGroups = grGroups.length;
          existingTsid = $('#georiot_tsid').val(); //This is the previous selected tsid in the <select>
          sameAccount = false;

          // We want to know the group ID with the lowest value use it, by default
          //Initial default value:
          var gr_low_tsid = 999999999;


          // Sort the JSON data by Id, ascending
          prop = 'Name'; //Sort by this key in Groups
          grGroups = grGroups.sort(function(a, b) {
            return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
            //Descending: return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
          });


          //Iterate over each group to find the "default" (lowest ID), and populate the select option
          // First, clear out the select field first in case it already has options
          $('#georiot_tsid_select').html('');

          $.each(grGroups, function( key, value ) {
            //Append this group to the select field
            $('#georiot_tsid_select').append('<option value="'+value.Id+'">'+value.Name+'</option>');

            if(value.Id == existingTsid) {
              sameAccount = true;
              // If the list contains a group with the same TSID as was loaded initially, we know we are looking at the same Account info
              // and we will not auto select the default group (lowest tsid) for the user ( because we only do that the first time API creds are entered)
              //console.log('list contains a group with the same TSID');
            }

            // Look at the TSID for each one. If it is lower than the last, save it.
            //console.log(value.Name +' '+ value.Id); //debug
            if(value.Id < gr_low_tsid) {
              gr_low_tsid = value.Id;
            }

          });

           // Add a default field
           //$('#georiot_tsid_select').prepend('<option value="'+gr_low_tsid+'">(No preference)</option>');


          // Select default group
          //Mark the oldest/lowest group tsid value as selected, only if they don't already have a valid group chosen

          if ( !sameAccount ) {
            // User entered keys for a different account, so let's auto select the default group for them
            //Mark group as selected in the select field
            $("#georiot_tsid_select option[value="+gr_low_tsid+"]").attr('selected', 'selected');
            //Show user which tsid they are using
            $('#gr-my-tsid-value').html( gr_low_tsid );
            //Set the group to be used by the plugin
            $('#georiot_tsid').val( gr_low_tsid );

            if(pluginPageInitializing) {
              // User just loaded or refreshed the plugin page, and the TSID stored in WP is not included in their Genius account
              // Let's show an alert to describe this problem. This could be  asign that the DB table is not writable.
              $('#gr-tsid-mismatch-error').show();
            }

          } else {
            //Preserve the previously selected group
            existingTsid = $('#georiot_tsid').val();
            $("#georiot_tsid_select option[value="+existingTsid+"]").attr('selected', 'selected');
          }

          //Show completion in UI
          $('#connect-gr-api-form').addClass('gr-status-loaded-tsid');
          $('#gr-step-2').addClass('gr-step-complete');

          pluginPageInitializing = false;


        })
        .fail(function() {
          $('#connect-gr-api-form').addClass('gr-status-error-tsid');
          $('#gr-step-2, #gr-step-3').removeClass('gr-step-complete');
        })
        .always(function() {
          $('#connect-gr-api-form').removeClass('gr-status-loading-tsid');
          $('.button-primary').prop("disabled",false);
        })
      ;

      getGeoriotAffiliates('suppressError');
      // We don't want to inundate the user with errors, so suppress the affiliate one in this case.

    }

    function getGeoriotAffiliates(suppressError) {
      //Loading effects
      $('#connect-gr-api-form').addClass('gr-status-loading-affiliates');
      $('#connect-gr-api-form').removeClass('gr-status-loaded-affiliates');
      $('#connect-gr-api-form').removeClass('gr-status-error-affiliates');


      var georiotApiKey = $('#georiot_api_key').val();
      var georiotApiSecret = $('#georiot_api_secret').val();
      var georiotApiUrlAffiliates = "https://api.geni.us/v1/affiliate/stats?apiKey="+georiotApiKey+"&apiSecret="+georiotApiSecret;


      var requestGeniusLinkAffiliates = $.ajax({
          url : georiotApiUrlAffiliates,
          dataType : "json",
          timeout : 10000
        })
          .done(function( data ) {
            var grAmazonEnrolled =  0;
            var grAmazonAvailable =  0;

            //Iterate over the enrolled programs and add up how many Amazon programs there are.
            $.each(data.ProgramsEnrolled, function( key, value ) {
              if(value.indexOf("Amazon") > -1) { grAmazonEnrolled++; }
            });
            //Iterate over the available programs and add up how many Amazon programs there are.
            $.each(data.AvailablePrograms, function( key, value ) {
              if(value.indexOf("Amazon") > -1) { grAmazonAvailable++; }
            });

            //Print out these values
            $('#gr-aff-enrolled').html(grAmazonEnrolled)
            $('#gr-aff-available').html(grAmazonAvailable)

            if (grAmazonEnrolled >= 1) {
              $('#gr-step-3').addClass('gr-step-complete');
            }
            //Show completion in UI
            $('#connect-gr-api-form').addClass('gr-status-loaded-affiliates');
          })
          .fail(function() {
            if(suppressError != 'suppressError') {
              $('#connect-gr-api-form').addClass('gr-status-error-affiliates');
            }
          })
          .always(function() {
            $('#connect-gr-api-form').removeClass('gr-status-loading-affiliates');
          })
        ;
    }


    //Group Selection
    $( "#georiot_tsid_select" ).change(function() {
      newgroup = $(this).val();
      $('#georiot_tsid').val(newgroup);
    });

  });

</script>


<div class="wrap">
  <h2>Amazon Link Engine <span class="gr-bygr">by </span>
    <a href="http://geni.us" target="_blank"><img class='gr-georiot-logo' src="<?php print $gr_image_path ?>georiot_logo.png" width="66" height="16" /></a></h2>
  <p class="gr-intro">This plugin has added JavaScript that converts all Amazon product
    URLs on your site to global-friendly GeniusLink links. <a href="#faq-whatisgeoriot">Learn more...</a>
  </p>

  <h3>Get the most from this plugin</h3>

  <div id="gr-tsid-mismatch-error">
    <strong>Problem detected</strong><br>
    <p>
    The GeniusLink group ID stored in your Wordpress database is not found in your GeniusLink account.
      Until this is resolved, you may not receive commissions and clicks will not show in your GeniusLink reports.</p>
    <p>Try choosing a group again under step 2 below and click "Save Changes".
    If you continue to see this error, there is likely a problem with your DB write permissions.</p>
  </div>


  <form method="post" action="options.php" id="connect-gr-api-form" class="<?php if (get_option('georiot_tsid') != '') print 'gr-status-loaded-tsid'; ?>">
    <?php settings_fields('amazon-link-engine'); ?>

    <div id="gr-step-1" class="gr-step-area gr-step-complete">
      <div class="gr-step-number">
        <span class="gr-checkmark"></span>
        1
      </div>
      <div class="gr-step-info">
        <strong>Improve sales and user experience:</strong> Your readers will now get to the right stores and products for their regions.
      </div>
    </div>

    <div id="gr-step-2" class="gr-step-area <?php if (get_option('georiot_tsid') != '') print 'gr-step-complete'; ?>">
      <div class="gr-step-number">
        <span class="gr-checkmark"></span>
        2
      </div>
      <div class="gr-step-info">
          <strong>Gain Insight with traffic reports.</strong> <a target="_blank" href="http://social.geni.us/ALEGenius">Create a GeniusLink account</a> and enter your API keys here.
          <a href="#faq-apikeys">Learn how...</a>

          <br><br>
        API Key: <br>
        <input maxlength="32" size="33" type="text" placeholder="Paste your api key" id="georiot_api_key" name="georiot_api_key" value="<?php echo get_option('georiot_api_key'); ?>" /></td>

        <br><br>
        API Secret:<br>
        <input maxlength="32" size="33" type="text" placeholder="Paste your api secret" id="georiot_api_secret" name="georiot_api_secret" value="<?php echo get_option('georiot_api_secret'); ?>" />

        <div class="gr-tsid-spinner">
          <div class="css-only-spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
          </div>
          Connecting...
        </div>
        <div class="gr-tsid-loaded">
          <span class="gr-connected-success">Connected!</span> &nbsp;
          <span class="gr-my-tsid gr-tiny">
            &nbsp; <a href="#" id="gr-disconnect-api">Disconnect</a>
          </span>
          <br><br>
          Using Link Group:<br>
          <select name="georiot_tsid_select" id="georiot_tsid_select"><option>--Error: No groups loaded--</option></select>
          <br><br>
        </div>
        <div id="gr-tsid-error"><strong>Oops.</strong> Please double-check your API key and secret.
          <button class="gr-resubmit">Re-submit</button>
        </div>
      </div>
    </div>

    <div id="gr-step-3" class="gr-step-area">
      <div class="gr-step-number">
        <span class="gr-checkmark"></span>
        3
      </div>
      <div class="gr-step-info">
        <strong>Monetize your traffic:</strong> Earn commissions for every sale by <a target="_blank" href="http://my.geni.us/Affiliate">connecting affiliate programs</a>.
        <br>

        <span id="gr-affiliates-loaded"><span id="gr-aff-enrolled">0</span> of <span id="gr-aff-available">0</span>
          Amazon programs connected. <a class="gr-refresh-affiliates gr-tiny" href="#">Refresh</a>
        </span>
        <div id="gr-affiliates-error"><strong>Sorry,</strong> there was a problem connecting to the GeniusLink API.
        </div>
      </div>
    </div>
    <div id="gr-advanced-options" class="gr-step-area">
      <h5>
        <em class="gr-expand">+</em>
        <em class="gr-collapse">--</em>
        Advanced Options<span class="hidden-expanded">...</span>
      </h5>
      <div class="gr-advanced-options-fields">
        <br>
        <div class="gr-tsid-spinner">
          <div class="css-only-spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
          </div>
          Loading your groups...
        </div>
        <br>
        <input type="checkbox" name="georiot_preserve_tracking" value="yes"
            <?php if (get_option('georiot_preserve_tracking') == 'yes') print "checked" ?> />Honor existing Associate IDs
        <a href="#faq-honor-tracking">(?)</a>
        <br><br>
        <input type="checkbox" name="georiot_api_remind" value="yes" <?php if (get_option('georiot_api_remind') == 'yes') print "checked" ?> />
        Show Wordpress alert on dashboard if commissions are not enabled
        <br><br>
      </div>
    </div>


    <br><br>
    <input size="10" type="hidden" name="georiot_tsid" id="georiot_tsid" value="<?php echo get_option('georiot_tsid'); ?>" />
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
  </form>
  <style>
    .faq {
      border-top: 1px solid #cccccc;
      margin-top: 80px;
      padding-top: 0px;
      max-width: 500px;
      margin-bottom: 400px;
    }

    .faq h4 {
      margin: 30px 5px 0 0;
      font-size: 16px;
    }
  </style>

  <div class="faq">
    <h3>Frequently asked questions</h3>

    <h4 id="faq-whatisgeoriot">What is GeniusLink</h4>
    <p>GeniusLink is an intelligent link management platform that allows you to build the world’s most intelligent links to improve user experience, and maximize your marketing efforts. For marketers promoting content within the Amazon ecosystem, GeniusLink allows you to build intelligent links that automatically route customers to the correct product within their own local storefront. In addition, with a GeniusLink account, you can enter your affiliate parameters to earn international commissions from all of your clicks.
    </p>

    <h4 id="faq-whatisgeoriot">Do I need a GeniusLink Account to use this plugin?</h4>
    <p><strong>No,</strong> you do NOT need a GeniusLink account to use the Amazon Link Engine plugin.  As soon as you install and activate the free plugin, all of your links will be automatically localized, and your customers will be routed to the product in their local storefront.  However, if you want to add your affiliate parameters, you will need a GeniusLink account.
    </p>

    <h4 id="faq-apikeys">How do I get my API keys?</h4>
    <p>To get your GeniusLink API Keys, follow these simple steps:
    </p>
    <ol>
      <li>If you do not have a GeniusLink account, <a target="_blank" href="http://social.geni.us/ALEGenius">create an account</a>.</li>

      <li>Log into your GeniusLink Dashboard, and navigate to the to the Account Tab.</li>

      <li>Click the “plus” sign to get your API keys.</li>

      <li>Next, simply copy and paste the “Key” and “Secret” codes into the “Enable Reporting and Commissions” area of the plugin.<br>
        <strong>Please note:</strong> It may take up to 3 minutes for new keys to become available for use after adding them to your dashboard.</li>
      <li>Once pasted, your GeniusLink account will be automatically connected.</li>

    </ol>


    <h4 id="faq-international">How do I earn International Commissions?</h4>
    <p>
      First, connect the plugin to your GeniusLink account (see “How do I get my API keys?”).  Then, follow the steps below:</p>
    <ol>
      <li>Add your Amazon Affiliate parameters to your GeniusLink dashboard.  Instructions on how to do this can be found
        <a target="_blank" href="http://help.geni.us/support/solutions/articles/3000034942">here</a>.
      <br><strong>Note:</strong> If you’ve already done this within your existing GeniusLink account, you do not need to add your parameters again.
      </li>
      <li> You’re all set!  You’ll start earning international commissions from anything purchased in Amazon’s international storefronts.</li>
    </ol>


    <h4 id="faq-pay">Do I have to pay for GeniusLink?</h4>
    <p>If you’re only interested in giving your international audience a better experience by redirecting them to their local storefront, the Amazon Link Engine is completely free.
    </p>
    <p>However, if you would like access to advanced reporting features and be able to affiliate all of your links, you will need to
      <a target="_blank" href="http://social.geni.us/ALEGenius">sign up for a GeniusLink account</a>.
    </p>
    <p><strong>Please note: By default, GeniusLink's affiliate parameters will be used until
        you have added your own via the GeniusLink dashboard.</strong>
      Please <a href="mailto:hi@geni.us">contact GeniusLink</a> if you have any questions.
    </p>

    <h4 id="faq-groups">How do I change the default group?</h4>
    <p>In order to change the group that the plugin syncs with, you must first connect your
      Geniuslink account using your API keys. Once you have done this, you can simply select
      the group you would like to use from the drop down menu under “Using Link Group” in the
      Amazon Link Engine Settings.
    </p>

    <h4 id="faq-honor-tracking">Will the ALE honor existing Associate IDs?</h4>
    <p>Yes. To honor existing Associates IDs, simply select the “Honor Existing Associate IDs”
      checkbox in Amazon Link Engine settings  under "Advanced Settings".
    </p>
    <p>This is great for blogs that have multiple editors with multiple Amazon Associates
      IDs to keep track of clicks, commissions, etc. per editor. By selecting this option the ALE
      will honor any existing Associates IDs already within links on the site, ensuring those
      editors continue to get the credit they deserve for helping you earn those affiliate commissions.
    </p>
    <p>Please note: By default the plugin will overwrite any IDs within your site with the
      ones you’ve added in your GeoRiot account. You must select the “Honor Existing Associate
      IDs” checkbox in order to honor existing IDs.
    </p>
  </div>
</div>