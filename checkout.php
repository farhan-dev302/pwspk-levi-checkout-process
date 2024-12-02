<?php
/**
 * Template: Checkout
 * Version: 3.2
 *
 * See documentation for how to override the PMPro templates.
 * @link https://www.paidmembershipspro.com/documentation/templates/
 *
 * @version 3.2
 *
 * @author Paid Memberships Pro
 */

global $gateway, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $wpdb, $current_user, $pmpro_msg, $pmpro_msgt, $pmpro_requirebilling, $pmpro_level, $pmpro_show_discount_code, $pmpro_error_fields, $pmpro_default_country;
global $discount_code, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth,$ExpirationYear;

$pmpro_levels = pmpro_getAllLevels();

/**
 * Filter to set if PMPro uses email or text as the type for email field inputs.
 *
 * @since 1.8.4.5
 *
 * @param bool $use_email_type, true to use email type, false to use text type
 */
$pmpro_email_field_type = apply_filters('pmpro_email_field_type', true);

// Set the wrapping class for the checkout div based on the default gateway;
$default_gateway = get_option( 'pmpro_gateway' );
if ( empty( $default_gateway ) ) {
	$pmpro_checkout_gateway_class = 'pmpro_section pmpro_checkout_gateway-none';
} else {
	$pmpro_checkout_gateway_class = 'pmpro_section pmpro_checkout_gateway-' . $default_gateway;
}
?>


<style type="text/css">
	
nav.page-navigation {
  display: none;
}

.registration_flow {
  /* margin-top: 150px; */
  max-width: 1140px;
  margin: 150px auto;
  background-color: #fafafa;
  border: 1px solid #e2e2e2;
  border-radius: 10px;
}

.dots-pagination {
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
  padding: 20px;
  border-bottom: 1px solid #d4d4d4;
}

.container {
  margin: 0 auto;
  max-width: 1140px;
}

.section-head {
  font-family: "DashiellFine";
  font-size: 46px;
  font-weight: 400;
  line-height: 50px;
}

.section-paragraph {
  font-family: "Avenir";
  font-size: 18px;
  color: #000;
  line-height: 30px;
  margin-bottom: 15px;
}

.form-block {
  display: grid;
  grid-gap: 50px;
  margin-top: 25px;
  margin-bottom: 25px;
  grid-template-columns: 1fr 1fr;
}

.form-block2 {
  display: flex;
  margin-top: 25px;
  margin-bottom: 25px;
  width: 75%;
  flex-direction: column;
}

.field-block {
  margin-bottom: 10px;
  width: 100%;
}

.form-block label,
.form-block2 label {
  display: block;
}

.form-block .formfield,
.form-block2 .formfield {
  width: 100%;
  margin-bottom: 10px;
  margin-top: 5px;
}

.gwilogo {
  width: 34%;
}

.btn_block {
  text-align: right;
}

.wellness_image {
  text-align: center;
  margin-top: 50px;
  margin-bottom: 50px;
}

.wellness_image img {
  width: 35%;
}

.qualifies ul {
  padding: 0px;
}

.qualifies ul li {
  list-style: none;
}

.membership-levels {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-gap: 30px;
  border-radius: 10px;
}

.membership-levels .level-block {
  display: flex;
  flex-direction: column;
  background-color: #ffffff;
  border: 1px solid #e7e7e7;
  padding: 20px;
  border-radius: 5px;
}

.membership-levels .l_image {
  width: 200px;
  margin: 20px auto;
}

.membership-levels .level-block {
  display: flex;
  flex-direction: column;
}

.membership-levels .l_button a {
  background-color: var(--memberlite-color-button);
  border: none;
  border-radius: 8px;
  box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.2);
  color: var(--memberlite-color-white);
  cursor: pointer;
  font-family: var(--memberlite-header-font);
  font-size: 1.8rem;
  font-style: normal;
  font-weight: 700;
  display: inline-block;
  line-height: 2.9rem;
  padding: 1.45rem 2.9rem;
  text-align: center;
  text-decoration: none;
  text-shadow: none;
  backface-visibility: hidden;
  overflow: hidden;
  margin-top: 20px;
}

.achievement-grid {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-gap: 30px;
  border-radius: 10px;
  margin-bottom: 30px;
}

.achievement-grid .achievement-level {
  display: flex;
  flex-direction: column;
  background-color: #ffffff;
  border: 1px solid #e7e7e7;
  padding: 20px;
  border-radius: 5px;
}

.achievement-grid .achievement-level .a_image {
  width: 200px;
  margin: 20px auto;
}

.checkout-form {
  display: flex;
  flex-direction: column;
  background-color: #f9f9f9;
  border-radius: 10px;
  margin-bottom: 35px;
}

.checkout-form input {
  margin-bottom: 10px;
}

.checkout-form .buy {
  margin-top: 10px;
}

.btn_block a {
  background-color: var(--memberlite-color-button);
  border: none;
  border-radius: 8px;
  box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.2);
  color: var(--memberlite-color-white);
  cursor: pointer;
  font-family: var(--memberlite-header-font);
  font-size: 1.8rem;
  font-style: normal;
  font-weight: 700;
  display: inline-block;
  line-height: 2.9rem;
  padding: 1.45rem 2.9rem;
  text-align: center;
  text-decoration: none;
  text-shadow: none;
  backface-visibility: hidden;
  overflow: hidden;
}

.thankyou .btn_block {
  text-align: center;
  margin-bottom: 15px;
}

.progress-bar {
  background: #f3f3f3;
  height: 10px;
  width: 100%;
  border-radius: 5px;
  margin-bottom: 20px;
  overflow: hidden;
}

.progress-bar .progress {
  background: #4caf50;
  height: 100%;
  width: 0;
  transition: width 0.3s ease-in-out;
}

.step {
  padding: 20px;
  display: none;
}

.step.active {
  display: block;
}

.dots-pagination {
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
}

.dot-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
}

.dot {
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background-color: #ccc;
  margin: 0 10px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  z-index: 999;
}

.dot.active {
  background-color: #007bff;
}

.step-description {
  font-size: 12px;
  margin-top: 5px;
  color: #666;
  transition: color 0.3s ease;
}

.dots-line {
  position: absolute;
  top: 25px;
  left: 0;
  width: 100%;
  height: 4px;
  background-color: #dbdbdb;
  z-index: 1;
}

.dots-line span {
  display: block;
  height: 100%;
  background-color: #007bff;
  width: 0%; 
  transition: width 0.3s ease;
}

@media (max-width: 600px) {
  .step-description {
    font-size: 10px;
  }
}
    
</style>



<div class="registration_flow">
    
    <div class="container">
        
        <div class="dots-pagination">
          <div class="dot-wrapper">
            <span class="dot active" onclick="goToStep(0)"></span>
            <span class="step-description">Welcome</span>
          </div>
          <div class="dot-wrapper">
            <span class="dot" onclick="goToStep(1)"></span>
            <span class="step-description">Business Info</span>
          </div>
          <div class="dot-wrapper">
            <span class="dot" onclick="goToStep(2)"></span>
            <span class="step-description">Qualification</span>
          </div>
          <div class="dot-wrapper">
            <span class="dot" onclick="goToStep(3)"></span>
            <span class="step-description">Awards</span>
          </div>

          <div class="dot-wrapper">
            <span class="dot" onclick="goToStep(4)"></span>
            <span class="step-description">Checkout</span>
          </div>
          <div class="dot-wrapper">
            <span class="dot" onclick="goToStep(5)"></span>
            <span class="step-description">Thank You</span>
          </div>
        
          <!-- Line connecting dots -->
          <div class="dots-line">
            <span></span>
          </div>
        </div>

    </div>

	<!-----Step One-------->
	<div id="stepone" class="step welcome" style="display: block;">

		<div class="container">

			<div class="inner-block">
				
				<h2 class="section-head">Welcome to the Global Wellness Industry.</h2>

				<p class="section-paragraph">Create your account to access your Free Participation Badge and explore exclusive acknowledgments and awards for your business.</p>

				<p class="section-paragraph">By registering, you’re joining a global community dedicated to wellness, balance, and quality of life. Your free account gives you immediate access to your Global Wellness Participation Badge—recognizing your business’s commitment to a better world.</p>

				<div class="form-block">
					
					<div class="left-block">
						
						<div class="field-block">
							<label>Email Address</label>
							<input type="text" name="email_address" id="email_address" value="" class="formfield">
						</div>

						<div class="field-block">
							<label>Password</label>
							<input type="password" name="pass" value="" id="pass" class="formfield">
						</div>

					</div>

					<div class="left-block" style="text-align: center;">
						
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gwi.png" alt="Logo" class="gwilogo">
						<p class="section-paragraph">Your Free Participation Badge is waiting!</p>

					</div>

				</div>

				<div class="btn_block" >
					<input type="button" name="stepone" value="Next: My Business" class="formbtn">
				</div>

				<p class="section-paragraph" style="text-align: center;">Start your journey to global wellness recognition immediately after signing up!”</p>


			</div>

		</div>
		
	</div>


	<!-----Step Two-------->
	<div id="steptwo" class="step businessinformation" style="display: none;">
		
		<div class="container">
			
			<div class="inner-block">
				
				<h2 class="section-head">Tell us about your business.</h2>

				<p class="section-paragraph2" style="margin-bottom: 12px;">Help us personalize your Global Wellness Participation Badge and potential acknowledgments. </p>

				<p class="section-paragraph">The Global Wellness Industry acknowledges businesses making a positive impact on wellness and quality of life. Provide your information, and we’ll determine if your business qualifies for tailored acknowledgments and awards.</p>


				<div class="form-block2">
					
						<div class="field-block">
							<label>Business Name</label>
							<input type="text" name="business_name" id="business_name" value="" class="formfield">
						</div>

						<div class="field-block">
							<label>Business Website or Listing</label>
							<input type="text" name="business_website_listing" id="business_website_listing" value="" class="formfield">
						</div>

				</div>

				<div class="btn_block" >
					<input type="button" name="steptwo" value="Next: Check My Eligibility" class="formbtn">
				</div>


			</div>	

		</div>	

	</div>


	<!-----Step Three-------->
	<div id="stepthree" class="step qualificationresults" style="display: none;">
		
		<div class="container">
			
			<div class="inner-block">
				
				<h2 class="section-head">Congratulations! Your Business Qualifies for Recognition</h2>

				<p class="section-paragraph">Your business has been acknowledged as a contributor to the Global Wellness Industry and qualifies for additional awards and acknowledgments</p>

				<p class="section-paragraph">As a qualified participant, you are eligible for the Global Wellness Participation Badge—an acknowledgment of your positive impact on wellness and quality of life. You’re also invited to explore exclusive awards tailored to your business.</p>

				<div class="wellness_image">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gwi.png" alt="logo">
				</div>

				
				<p class="section-paragraph" style="text-align:center;">This badge is yours to display proudly on your website.</p>


				<div class="">
					
					<p class="section-paragraph">You qualify for <u>additional awards and acknowledgments</u> in the following categories. Click ‘Next’ to explore your options and learn how to showcase them.</p>

					<div class="qualifies">
						
						<ul>
							
							<li><input type="radio" name="award_category" value="Therapeutic Massage"> Therapeutic Massage</li>
		          <li><input type="radio" name="award_category" value="Wellness Spa"> Wellness Spa</li>
		          <li><input type="radio" name="award_category" value="Acupuncture"> Acupuncture</li>
		          <li><input type="radio" name="award_category" value="Other"> Other</li>

						</ul>

					</div>

					<div class="btn_block" >
						<input type="button" name="stepthree" value="Next: See my Acknowledgements" class="formbtn">
					</div>

				</div>


			</div>	

		</div>	

	</div>


	<!-----Step four-------->
	<div id="stepfour" class="step awards" style="display: none;">
		
		<div class="container awards-div">
			
			<div class="inner-block">

				<h2 class="section-head">{business_name} Awards</h2>

				<p class="section-paragraph2" style="margin-bottom: 12px;">Choose from our exclusive awards and membership tiers to showcase your contributions to the Global Wellness Industry.</p>

				<p class="section-paragraph">As a qualified participant, you have access to a variety of awards and memberships designed to highlight your business’s unique impact. Select the option that best suits your goals and start showcasing your achievements today.</p>


				<div class="membership-levels">
					
					<div class="level-block">
						
						<div class="l_title">Level 1</div>
						<div class="l_desc">Member Badge | $50</div>
						<div class="l_image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/diamondmember-lvl1.png" alt="">
						</div>
						<div class="l_content">
							<p><strong>Level (1)</strong></p>
							<p>- Member Badge $50 USD p/a</p>
							<br/>
							<p><strong>Included:</strong></p>
							<p>- 1 x ACK Participation Badge Official Certification</p>	
						</div>
						<div class="l_button">
							<button onclick="selectMemberLevel(this, 2)" class="member-button">Member</button>
        		</div>
					</div>



					<div class="level-block">
						
						<div class="l_title">Level 2</div>
						<div class="l_desc">Gold Member Badge | $150</div>
						<div class="l_image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/goldmember-lvl2.png" alt="">
						</div>
						<div class="l_content">
							<p><strong>Level (2)</strong></p>
							<p>- Gold Member Badge $150 USD p/a</p>
							<br/>
							<p><strong>Included:</strong></p>
							<p>- Participation Badge</p>  
							<p>- Choice of Badge or Trophy</p>  
							<p>- Official Certification (3 x ACK)</p>	
						</div>
						<div class="l_button">
							<button onclick="selectMemberLevel(this, 3)" class="member-button">Gold Member</button>
						</div>

					</div>



					<div class="level-block">
						
						<div class="l_title">Level 3</div>
						<div class="l_desc">Platinum Member Badge | $500</div>
						<div class="l_image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/platinummember-lvl3.png" alt="">
						</div>
						<div class="l_content">
							<p><strong>Level (3)</strong></p>
							<p>- Platinum Award Member</p>  
							<p>- $500 USD p/a</p>
							<br/>
							<p><strong>Included:</strong></p>
							<p>- Participation Badge</p>
							<p>- Choice of Badge or Trophy or Medal</p>
							<p>&nbsp;&nbsp;2 x Awards </p>
							<p>&nbsp;&nbsp;Official Certification (3 x ACK)</p>	
						</div>
						<div class="l_button">
							<button onclick="selectMemberLevel(this, 4)" class="member-button">Platinum Member</button>
						</div>

					</div>


					<div class="level-block">
						
						<div class="l_title">Level 4</div>
						<div class="l_desc">Diamond Member Plus | $1500</div>
						<div class="l_desc">Invitation to Award Ceremonies</div>
						<div class="l_image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/diamondmember-lvl4.png" alt="">
						</div>
						<div class="l_content">
							<p><strong>Level (4)</strong></p>
							<p>- Diamond Award Member</p>
							<p>- $1500 USD p/a</p>
							<br /><br />
							<p><Strong>Included:</Strong></p>
							<p>Participation Badge</p>
							<p>3 x ACK choice of  Badge or Trophy or Medal</p>
							<p>3 x Awards  Official Certification</p>
							<p>Online Awards Recognition Company Profile Promotion (manual)</p>
							<p>Official Invitation to Gala Event (manual)</p>
						</div>
						<div class="l_button">
							<button onclick="selectMemberLevel(this, 5)" class="member-button">Diamond Member</button>
						</div>

					</div>


					<div class="level-block">
						
						<div class="l_title">Level 1</div>
						<div class="l_desc">Lifetime Member | $2500</div>
						<div class="l_desc">Tailored to Business</div>
						<div class="l_image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lifetimemember-lvl5.png" alt="">
						</div>
						<div class="l_content">
							<p>The Lifetime Membership is the ultimate acknowledgment of your unwavering commitment to wellness. By joining as a Lifetime Member, your business gains permanent recognition within the Global Wellness Industry, along with unparalleled access to exclusive awards, promotions, and networking opportunities. This one-time investment ensures that your contributions to wellness are celebrated forever.</p>	
						</div>
						<div class="l_button">
							<button onclick="selectMemberLevel(this, 6)" class="member-button">Lifetime Member</button>
						</div>

					</div>

				</div>
				
				<div class="btn_block">
					<input type="button" id="participationBadgeButton" name="stepachivement" value="Next: Continue with only the Participation Badge" class="formbtn">
				</div>

			</div>

		</div>	

		<div class="achievement-badges achievements-div" style="display: none;">
	    
	    <div class="container">
	        
	        <div class="inner-">
	            
	            <h2 class="section-head">Celebrate Your Achievements with Exclusive Awards</h2>

				<p class="section-paragraph2" style="margin-bottom: 12px;">Even without a membership package, you can still showcase your contributions with these distinguished digital assets.</p>

				<p class="section-paragraph">Choose from our Badge, Trophy, or Medal to elevate your business’s recognition within the Global Wellness Industry. These high-quality digital assets are perfect for embedding on your website, sharing on social media, and displaying in your marketing materials.</p>
	            
	            <div class="achievement-grid">
	                
	                <div class="achievement-level">
	                    
	                    <div class="a_title">Badge</div>
	                    
	                    <div class="a_image"><img src="https://globalwellnessindustry.perfectwebsoldev.com/wp-content/themes/memberlite/images/2025-GWI_Badge.png"></div>
	                    
	                    <div class="a_content">
	                        
	                        <p><strong>For Purchase: 35$ USD</strong></p>
	                        </br>
	                        <p>- 1 x ACK Participation Badge Official Certification</p>
	                        
	                    </div>

	                    <div class="l_button">
												<input type="button" value="Badge" onclick="nextStep('stepfour', 'stepfive', 4)">
											</div>
	                    
	                </div>
	                
	                <div class="achievement-level">
	                    
	                    <div class="a_title">Trophy</div>
	                    
	                    <div class="a_image"><img src="https://globalwellnessindustry.perfectwebsoldev.com/wp-content/themes/memberlite/images/2025-GWI_Trophy.png"></div>
	                    
	                    <div class="a_content">
	                        
	                        <p><strong>For Purchase: 50$ USD</strong></p>
	                        </br>
	                        <p>- 1 x ACK Participation Badge Official Certification</p>
	                        
	                    </div>


	                    <div class="l_button">
												<input type="button" value="Trophy" onclick="nextStep('stepfour', 'stepfive', 4)">
											</div>
	                    
	                </div>
	                
	                <div class="achievement-level">
	                    
	                    <div class="a_title">Medal</div>
	                    
	                    <div class="a_image"><img src="https://globalwellnessindustry.perfectwebsoldev.com/wp-content/themes/memberlite/images/2025-GWI_Medal.png"></div>
	                    
	                    <div class="a_content">
	                        
	                        <p><strong>For Purchase: 100$ USD</strong></p>
	                        </br>
	                        <p>- 1 x ACK Participation Badge Official Certification</p>
	                        
	                        
	                    </div>


	                    <div class="l_button">
							<input type="button" value="Medal" onclick="nextStep('stepfour', 'stepfive', 4)">
						</div>
	                    
	                </div>
	                
	            </div>
	            
	            <div class="btn_block" >
								<a>Continue without upgrades</a>
							</div>
	            
	        </div>
	        
	    </div>
	    
		</div>	

	</div>
	
	<!-----Step Six-------->
	<div id="stepfive" class="step checkout" style="display: none;">
	    <div class="container">
	        <div class="inner-">
				<h2 class="section-head">Secure Your Membership</h2>
				<p class="section-paragraph2" style="margin-bottom: 12px;">Complete your payment to unlock your badges, certificates, and exclusive benefits.</p>
				<p class="section-paragraph">Your payment is 100% secure, and you’ll gain immediate access to your Global Wellness Industry assets once it’s complete.</p>
	            <div class="checkout-form">
                    <div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro' ) ); ?>">
						<?php do_action( 'pmpro_checkout_before_form' ); ?>
						<section id="pmpro_level-<?php echo intval( $pmpro_level->id ); ?>" class="<?php echo esc_attr( pmpro_get_element_class( $pmpro_checkout_gateway_class, 'pmpro_level-' . $pmpro_level->id ) ); ?>">
							<form id="pmpro_form" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form' ) ); ?>" action="<?php if(!empty($_REQUEST['review'])) echo esc_url( pmpro_url("checkout", "?pmpro_level=" . $pmpro_level->id) ); ?>" method="post">
								<input type="hidden" id="pmpro_level" name="pmpro_level" value="<?php echo esc_attr($pmpro_level->id) ?>" />
								<input type="hidden" id="checkjavascript" name="checkjavascript" value="1" />
								<?php if ($discount_code && $pmpro_review) { ?>
									<input class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_alter_price', 'pmpro_discount_code' ) ); ?>" id="pmpro_discount_code" name="pmpro_discount_code" type="hidden" value="<?php echo esc_attr($discount_code) ?>" />
								<?php } ?>

								<?php if($pmpro_msg) { ?>
									<div role="alert" id="pmpro_message" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ) ); ?>">
										<?php echo wp_kses_post( apply_filters( 'pmpro_checkout_message', $pmpro_msg, $pmpro_msgt ) ); ?>
									</div>
								<?php } else { ?>
									<div id="pmpro_message" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_message' ) ); ?>" style="display: none;"></div>
								<?php } ?>

								<?php if ( $pmpro_review ) { ?>
									<p><?php echo wp_kses( __( 'Almost done. Review the membership information and pricing below then <strong>click the "Complete Payment" button</strong> to finish your order.', 'paid-memberships-pro' ), array( 'strong' => array() ) ); ?></p>
								<?php } ?>

								<?php
									$include_pricing_fields = apply_filters( 'pmpro_include_pricing_fields', true );
									if ( $include_pricing_fields ) {
									?>
									<div id="pmpro_pricing_fields" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card', 'pmpro_pricing_fields' ) ); ?>">

										<h2 class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_title pmpro_font-large' ) ); ?>"><?php esc_html_e( 'Membership Information', 'paid-memberships-pro' ); ?></h2>

										<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_content' ) ); ?>">

											<p class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_level_name_text' ) );?>">
												<?php
												// Tell the user which level they are signing up for.
												printf( esc_html__('You have selected the %s membership level.', 'paid-memberships-pro' ), '<strong>' . esc_html( $pmpro_level->name ) . '</strong>' );

												// If a level will be removed with this purchase, let them know that too.
												// First off, get the group for this level and check if it allows a user to have multiple levels.
												$group_id = pmpro_get_group_id_for_level( $pmpro_level->id );
												$group    = pmpro_get_level_group( $group_id );
												if ( ! empty( $group ) && empty( $group->allow_multiple_selections ) ) {
													// Get all of the user's current membership levels.
													$levels = pmpro_getMembershipLevelsForUser( $current_user->ID );

													// Loop through the levels and see if any are in the same group as the level being purchased.
													if ( ! empty( $levels ) ) {
														foreach ( $levels as $level ) {
															// If this is the level that the user is purchasing, continue.
															if ( $level->id == $pmpro_level->id ) {
																continue;
															}

															// If this level is not in the same group, continue.
															if ( pmpro_get_group_id_for_level( $level->id ) != $group_id ) {
																continue;
															}

															// If we made it this far, the user is going to lose this level after checkout.
															printf( ' ' . esc_html__( 'Your current membership level of %s will be removed when you complete your purchase.', 'paid-memberships-pro' ), '<strong>' . esc_html( $level->name ) . '</strong>' );
														}
													}
												}
												?>
											</p> <!-- end pmpro_level_name_text -->

											<?php
												/**
													* Allow devs to filter the level description at checkout.
													* We also have a function in includes/filters.php that applies the the_content filters to this description.
													* @param string $description The level description.
													* @param object $pmpro_level The PMPro Level object.
													*/
												$level_description = apply_filters('pmpro_level_description', $pmpro_level->description, $pmpro_level);
												if ( ! empty( $level_description ) ) { ?>
													<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_level_description_text' ) );?>">
														<?php echo wp_kses_post( $level_description ); ?>
													</div> <!-- end pmpro_level_description_text -->
													<?php
												}
											?>

											<div id="pmpro_level_cost">
												<?php if($discount_code && pmpro_checkDiscountCode($discount_code)) { ?>
													<?php
														echo '<p class="' . esc_attr( pmpro_get_element_class( 'pmpro_level_discount_applied' ) ) . '">';
														echo sprintf( esc_html__( 'The %s code has been applied to your order.', 'paid-memberships-pro' ), '<span class="' . esc_attr( pmpro_get_element_class( "pmpro_tag pmpro_tag-discount-code", "pmpro_tag-discount-code" ) ) . '">' . esc_html( $discount_code ) . '</span>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
														echo '</p> <!-- end pmpro_level_discount_applied -->';
													?>
												<?php } ?>

												<?php
													$level_cost_text = pmpro_getLevelCost( $pmpro_level );
													if ( ! empty( $level_cost_text ) ) { ?>
														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_level_cost_text' ) );?>">
															<?php echo wp_kses_post( wpautop( $level_cost_text ) ); ?>
														</div> <!-- end pmpro_level_cost_text -->
													<?php }
												?>

												<?php
													$level_expiration_text = pmpro_getLevelExpiration( $pmpro_level );
													if ( ! empty( $level_expiration_text ) ) { ?>
														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_level_expiration_text' ) );?>">
															<?php echo wp_kses_post( wpautop( $level_expiration_text ) ); ?>
														</div> <!-- end pmpro_level_expiration_text -->
													<?php }
												?>
											</div> <!-- end #pmpro_level_cost -->

											<?php do_action( 'pmpro_checkout_after_level_cost' ); ?>

										</div> <!-- end pmpro_card_content -->
										<?php if ( $pmpro_show_discount_code ) { ?>
											<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_actions' ) ); ?>">
												<?php if($discount_code && !$pmpro_review) { ?>
													<span id="other_discount_code_p"><button type="button" id="other_discount_code_toggle"><?php esc_html_e('Click here to change your discount code', 'paid-memberships-pro' );?></button></span>
												<?php } elseif(!$pmpro_review) { ?>
													<span id="other_discount_code_p"><?php esc_html_e('Do you have a discount code?', 'paid-memberships-pro' );?> <button type="button" id="other_discount_code_toggle"><?php esc_html_e('Click here to enter your discount code', 'paid-memberships-pro' );?></button></span>
												<?php } elseif($pmpro_review && $discount_code) { ?>
													<span><strong><?php esc_html_e('Discount Code', 'paid-memberships-pro' );?>:</strong> <?php echo esc_html( $discount_code ); ?></span>
												<?php } ?>
												<div id="other_discount_code_fields" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text' ) ); ?>" style="display: none;">
													<label for="pmpro_other_discount_code" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Discount Code', 'paid-memberships-pro' );?></label>
													<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields-inline' ) ); ?>">
														<input id="pmpro_other_discount_code" name="pmpro_other_discount_code" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text pmpro_alter_price', 'other_discount_code' ) ); ?>" value="<?php echo esc_attr($discount_code); ?>" />
														<input aria-label="<?php esc_html_e( 'Apply discount code', 'paid-memberships-pro' ); ?>" type="button" name="other_discount_code_button" id="other_discount_code_button" value="<?php esc_attr_e('Apply', 'paid-memberships-pro' );?>" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_btn pmpro_btn-submit-discount-code', 'other_discount_code_button' ) ); ?>" />
													</div>
												</div>
											</div> <!-- end pmpro_card_actions -->
										<?php } ?>
									</div> <!-- end pmpro_pricing_fields -->
									<?php
									} // if ( $include_pricing_fields )
								?>

								<?php do_action( 'pmpro_checkout_after_pricing_fields' ); ?>

								<?php
								// Define whether we should show the Account Information box.
								$show_pmpro_user_fields_fieldset = true;

								// If $pmpro_review is set, skip.
								if ( $pmpro_review ) {
									$show_pmpro_user_fields_fieldset = false;
								}

								// If we are skipping the account fields and the user is logged out, skip the entire fieldset.
								// The logged out check is important since if the user is logged in, we will show a logged in message.
								if ( $skip_account_fields && ! $current_user->ID ) {
									$show_pmpro_user_fields_fieldset = false;
								}

								if ( $show_pmpro_user_fields_fieldset ) {
									?>
									<fieldset id="pmpro_user_fields" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fieldset', 'pmpro_user_fields' ) ); ?>">
										<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card' ) ); ?>">
											<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_content' ) ); ?>">
												<legend class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_legend' ) ); ?>">
													<h2 class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_heading pmpro_font-large' ) ); ?>"><?php esc_html_e( 'Account Information', 'paid-memberships-pro' ); ?></h2>
												</legend>
												<?php if ( ! $skip_account_fields ) { ?>
													<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields' ) ); ?>">
														<?php
															// Get discount code from URL parameter, so if the user logs in it will keep it applied.
															$discount_code_link = ! empty( $discount_code) ? '&pmpro_discount_code=' . $discount_code : '';
														?>

														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-username pmpro_form_field-required', 'pmpro_form_field-username' ) ); ?>">
															<label for="username" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Username', 'paid-memberships-pro' );?></label>
															<input id="username" name="username" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text pmpro_form_input-required', 'username' ) ); ?>" autocomplete="username" value="<?php echo esc_attr($username); ?>" />
														</div> <!-- end pmpro_form_field-username -->

														<?php do_action( 'pmpro_checkout_after_username' ); ?>

														<?php
															/**
																* Filter to require confirmed password at checkout.
																*
																* @param bool $pmpro_checkout_confirm_password, true to require a password confirm field, false to hide.
																*/
															$pmpro_checkout_confirm_password = apply_filters( 'pmpro_checkout_confirm_password', true );

															echo $pmpro_checkout_confirm_password ? '<div class="' . esc_attr( pmpro_get_element_class( 'pmpro_cols-2' ) ) . '">' : '';
														?>

														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-password pmpro_form_field-required' ) ); ?>">
															<label for="password" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>">
																<?php esc_html_e( 'Password', 'paid-memberships-pro' );?>
															</label>
															<input type="password" name="password" id="password" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-password pmpro_form_input-required', 'password' ) ); ?>" autocomplete="new-password" spellcheck="false" value="<?php echo esc_attr($password); ?>" />
															<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field-password-toggle' ) ); ?>">
																<button type="button" class="pmpro_btn pmpro_btn-plain pmpro_btn-password-toggle hide-if-no-js" data-toggle="0">
																	<span class="pmpro_icon pmpro_icon-eye" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--pmpro--color--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
																		<span class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field-password-toggle-state' ) ); ?>"><?php esc_html_e( 'Show Password', 'paid-memberships-pro' ); ?></span>
																</button>
															</div> <!-- end pmpro_form_field-password-toggle -->
														</div> <!-- end pmpro_form_field-password -->

														<?php
															if ( $pmpro_checkout_confirm_password ) {
																?>
																<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-password pmpro_form_field-required', 'pmpro_form_field-password2' ) ); ?>">
																	<label for="password2" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Confirm Password', 'paid-memberships-pro' );?></label>
																	<input type="password" name="password2" id="password2" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-password pmpro_form_input-required', 'password2' ) ); ?>" autocomplete="new-password" spellcheck="false" value="<?php echo esc_attr($password2); ?>" />
																</div> <!-- end pmpro_form_field-password2 -->
																<?php
															} else {
																?>
																<input type="hidden" name="password2_copy" value="1" />
																<?php
															}
														?>

														<?php echo $pmpro_checkout_confirm_password ? '</div>' : ''; ?>

														<?php do_action( 'pmpro_checkout_after_password' ); ?>

														<?php
															/**
																* Filter to require confirmed email at checkout.
																*
																* @param bool $pmpro_checkout_confirm_email, true to require a email confirm field, false to hide.
																*/
															$pmpro_checkout_confirm_email = apply_filters( 'pmpro_checkout_confirm_email', true );

															echo $pmpro_checkout_confirm_email ? '<div class="' . esc_attr( pmpro_get_element_class( 'pmpro_cols-2' ) ) . '">' : '';
														?>

														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-email pmpro_form_field-bemail pmpro_form_field-required', 'pmpro_form_field-bemail' ) ); ?>">
															<label for="bemail" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Email Address', 'paid-memberships-pro' );?></label>
															<input id="bemail" name="bemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-email pmpro_form_input-required', 'bemail' ) ); ?>" value="<?php echo esc_attr($bemail); ?>" />
														</div> <!-- end pmpro_form_field-bemail -->

														<?php
															if ( $pmpro_checkout_confirm_email ) {
																?>
																<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-email pmpro_form_field-bconfirmemail pmpro_form_field-required', 'pmpro_form_field-bconfirmemail' ) ); ?>">
																	<label for="bconfirmemail" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Confirm Email Address', 'paid-memberships-pro' );?></label>
																	<input id="bconfirmemail" name="bconfirmemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-email pmpro_form_input-required', 'bconfirmemail' ) ); ?>" value="<?php echo esc_attr($bconfirmemail); ?>" />
																</div> <!-- end pmpro_form_field-bconfirmemail -->
																<?php
															} else {
																?>
																<input type="hidden" name="bconfirmemail_copy" value="1" />
																<?php
															}
														?>

														<?php echo $pmpro_checkout_confirm_email ? '</div>' : ''; ?>

														<?php do_action( 'pmpro_checkout_after_email' ); ?>

														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_hidden' ) ); ?>">
															<label for="fullname"><?php esc_html_e('Full Name', 'paid-memberships-pro' );?></label>
															<input id="fullname" name="fullname" type="text" value="" autocomplete="off"/> <strong><?php esc_html_e('LEAVE THIS BLANK', 'paid-memberships-pro' );?></strong>
														</div> <!-- end pmpro_hidden -->
													</div>  <!-- end pmpro_form_fields -->
												<?php } else { ?>
													<div id="pmpro_account_loggedin">
														<?php
															$allowed_html = array(
																'a' => array(
																	'href' => array(),
																	'title' => array(),
																	'target' => array(),
																),
																'strong' => array(),
															);
															echo wp_kses( sprintf( __('You are logged in as <strong>%s</strong>. If you would like to use a different account for this membership, <a href="%s">log out now</a>.', 'paid-memberships-pro' ), $current_user->user_login, wp_logout_url( esc_url_raw( $_SERVER['REQUEST_URI'] ) ) ), $allowed_html );
														?>
													</div> <!-- end pmpro_account_loggedin -->
												<?php } ?>
											</div> <!-- end pmpro_card_content -->
											<?php if ( ! $skip_account_fields ) { ?>
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_actions' ) ); ?>">
													<?php esc_html_e('Already have an account?', 'paid-memberships-pro' );?> <a href="<?php echo esc_url( wp_login_url( apply_filters( 'pmpro_checkout_login_redirect', pmpro_url("checkout", "?pmpro_level=" . $pmpro_level->id . $discount_code_link) ) ) ); ?>"><?php esc_html_e('Log in here', 'paid-memberships-pro' ); ?></a>
												</div> <!-- end pmpro_card_actions -->
											<?php } ?>
										</div> <!-- end pmpro_card -->
									</fieldset> <!-- end pmpro_user_fields -->
								<?php } ?>

								<?php do_action( 'pmpro_checkout_after_user_fields' ); ?>

								<?php do_action( 'pmpro_checkout_boxes' ); ?>

								<?php
									$pmpro_include_billing_address_fields = apply_filters('pmpro_include_billing_address_fields', true);
									if ( $pmpro_include_billing_address_fields ) { ?>
								<fieldset id="pmpro_billing_address_fields" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fieldset', 'pmpro_billing_address_fields' ) ); ?>" <?php if ( ! $pmpro_requirebilling || apply_filters("pmpro_hide_billing_address_fields", false) ) { ?>style="display: none;"<?php } ?>>
									<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card' ) ); ?>">
										<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_content' ) ); ?>">
											<legend class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_legend' ) ); ?>">
												<h2 class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_heading pmpro_font-large' ) ); ?>"><?php esc_html_e( 'Billing Address', 'paid-memberships-pro' ); ?></h2>
											</legend>
											<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields pmpro_cols-2' ) ); ?>">
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-bfirstname', 'pmpro_form_field-bfirstname' ) ); ?>">
													<label for="bfirstname" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('First Name', 'paid-memberships-pro' );?></label>
													<input id="bfirstname" name="bfirstname" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'bfirstname' ) ); ?>" value="<?php echo esc_attr($bfirstname); ?>" autocomplete="given-name" />
												</div> <!-- end pmpro_form_field-bfirstname -->
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-blastname', 'pmpro_form_field-blastname' ) ); ?>">
													<label for="blastname" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Last Name', 'paid-memberships-pro' );?></label>
													<input id="blastname" name="blastname" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'blastname' ) ); ?>" value="<?php echo esc_attr($blastname); ?>" autocomplete="family-name" />
												</div> <!-- end pmpro_form_field-blastname -->
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-baddress1', 'pmpro_form_field-baddress1' ) ); ?>">
													<label for="baddress1" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Address 1', 'paid-memberships-pro' );?></label>
													<input id="baddress1" name="baddress1" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'baddress1' ) ); ?>" value="<?php echo esc_attr($baddress1); ?>" autocomplete="billing street-address" />
												</div> <!-- end pmpro_form_field-baddress1 -->
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-baddress2', 'pmpro_form_field-baddress2' ) ); ?>">
													<label for="baddress2" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Address 2', 'paid-memberships-pro' );?></label>
													<input id="baddress2" name="baddress2" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'baddress2' ) ); ?>" value="<?php echo esc_attr($baddress2); ?>" />
												</div> <!-- end pmpro_form_field-baddress2 -->
													<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-bcity', 'pmpro_form_field-bcity' ) ); ?>">
														<label for="bcity" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('City', 'paid-memberships-pro' );?></label>
														<input id="bcity" name="bcity" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'bcity' ) ); ?>" value="<?php echo esc_attr($bcity); ?>" />
													</div> <!-- end pmpro_form_field-bcity -->
													<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-bstate', 'pmpro_form_field-bstate' ) ); ?>">
														<label for="bstate" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('State', 'paid-memberships-pro' );?></label>
														<input id="bstate" name="bstate" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'bstate' ) ); ?>" value="<?php echo esc_attr($bstate); ?>" />
													</div> <!-- end pmpro_form_field-bstate -->
													<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-bzipcode', 'pmpro_form_field-bzipcode' ) ); ?>">
														<label for="bzipcode" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Postal Code', 'paid-memberships-pro' );?></label>
														<input id="bzipcode" name="bzipcode" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'bzipcode' ) ); ?>" value="<?php echo esc_attr($bzipcode); ?>" autocomplete="billing postal-code" />
													</div> <!-- end pmpro_form_field-bzipcode -->
												<?php
													$show_country = apply_filters("pmpro_international_addresses", true);
													if($show_country) { ?>
														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-select pmpro_form_field-bcountry', 'pmpro_form_field-bcountry' ) ); ?>">
															<label for="bcountry" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Country', 'paid-memberships-pro' );?></label>
															<select name="bcountry" id="bcountry" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-select', 'bcountry' ) ); ?>" autocomplete="billing country">
															<?php
																global $pmpro_countries, $pmpro_default_country;
																if(!$bcountry) {
																	$bcountry = $pmpro_default_country;
																}
																foreach($pmpro_countries as $abbr => $country) { ?>
																	<option value="<?php echo esc_attr( $abbr ) ?>" <?php if($abbr == $bcountry) { ?>selected="selected"<?php } ?>><?php echo esc_html( $country )?></option>
																<?php } ?>
															</select>
														</div> <!-- end pmpro_form_field-bcountry -->
													<?php } else { ?>
														<input type="hidden" name="bcountry" id="bcountry" value="<?php echo esc_attr( $pmpro_default_country ); ?>" />
													<?php } ?>
												<?php if($skip_account_fields) { ?>
												<?php
													if($current_user->ID) {
														if(!$bemail && $current_user->user_email) {
															$bemail = $current_user->user_email;
														}
														if(!$bconfirmemail && $current_user->user_email) {
															$bconfirmemail = $current_user->user_email;
														}
													}
												?>
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-email pmpro_form_field-bemail', 'pmpro_form_field-bemail' ) ); ?>">
													<label for="bemail" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Email Address', 'paid-memberships-pro' );?></label>
													<input id="bemail" name="bemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-email', 'bemail' ) ); ?>" value="<?php echo esc_attr($bemail); ?>" autocomplete="email" />
												</div> <!-- end pmpro_form_field-bemail -->
												<?php
													$pmpro_checkout_confirm_email = apply_filters("pmpro_checkout_confirm_email", true);
													if($pmpro_checkout_confirm_email) { ?>
														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-email pmpro_form_field-bconfirmemail', 'pmpro_form_field-bconfirmemail' ) ); ?>">
															<label for="bconfirmemail" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Confirm Email', 'paid-memberships-pro' );?></label>
															<input id="bconfirmemail" name="bconfirmemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-email', 'bconfirmemail' ) ); ?>" value="<?php echo esc_attr($bconfirmemail); ?>" autocomplete="email" />
														</div> <!-- end pmpro_form_field-bconfirmemail -->
													<?php } else { ?>
														<input type="hidden" name="bconfirmemail_copy" value="1" />
													<?php } ?>
												<?php } ?>
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-bphone', 'pmpro_form_field-bphone' ) ); ?>">
													<label for="bphone" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Phone', 'paid-memberships-pro' );?></label>
													<input id="bphone" name="bphone" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'bphone' ) ); ?>" value="<?php echo esc_attr(formatPhone($bphone)); ?>" autocomplete="tel" />
												</div> <!-- end pmpro_form_field-bphone -->
											</div> <!-- end pmpro_form_fields -->
										</div> <!-- end pmpro_card_content -->
									</div> <!-- end pmpro_card -->
								</fieldset> <!-- end pmpro_billing_address_fields -->
								<?php } ?>

								<?php do_action( 'pmpro_checkout_after_billing_fields' ); ?>

								<?php
									/**
										* Filter to set if the payment information fields should be shown.
										*
										* @param bool $include_payment_information_fields
										* @return bool
										*/
									$pmpro_include_payment_information_fields = apply_filters( 'pmpro_include_payment_information_fields', true );
									if ( $pmpro_include_payment_information_fields ) {
										?>
										<fieldset id="pmpro_payment_information_fields" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fieldset', 'pmpro_payment_information_fields' ) ); ?>" <?php if ( ! $pmpro_requirebilling || apply_filters( 'pmpro_hide_payment_information_fields', false ) ) { ?>style="display: none;"<?php } ?>>
											<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card' ) ); ?>">
												<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_content' ) ); ?>">
													<legend class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_legend' ) ); ?>">
														<h2 class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_heading pmpro_font-large' ) ); ?>"><?php esc_html_e( 'Payment Information', 'paid-memberships-pro' ); ?></h2>
													</legend>
													<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields' ) ); ?>">
														<input type="hidden" id="CardType" name="CardType" value="<?php echo esc_attr($CardType);?>" />
														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_payment-account-number', 'pmpro_payment-account-number' ) ); ?>">
															<label for="AccountNumber" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Card Number', 'paid-memberships-pro' );?></label>
															<input id="AccountNumber" name="AccountNumber" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'AccountNumber' ) ); ?>" type="text" value="<?php echo esc_attr($AccountNumber); ?>" data-encrypted-name="number" autocomplete="off" />
														</div>
														<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_cols-2' ) ); ?>">
															<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-select pmpro_payment-expiration', 'pmpro_payment-expiration' ) ); ?>">
																<label for="ExpirationMonth" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Expiration Date', 'paid-memberships-pro' );?></label>
																<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields-inline' ) ); ?>">
																	<select id="ExpirationMonth" name="ExpirationMonth" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-select', 'ExpirationMonth' ) ); ?>">
																		<option value="01" <?php if($ExpirationMonth == "01") { ?>selected="selected"<?php } ?>>01</option>
																		<option value="02" <?php if($ExpirationMonth == "02") { ?>selected="selected"<?php } ?>>02</option>
																		<option value="03" <?php if($ExpirationMonth == "03") { ?>selected="selected"<?php } ?>>03</option>
																		<option value="04" <?php if($ExpirationMonth == "04") { ?>selected="selected"<?php } ?>>04</option>
																		<option value="05" <?php if($ExpirationMonth == "05") { ?>selected="selected"<?php } ?>>05</option>
																		<option value="06" <?php if($ExpirationMonth == "06") { ?>selected="selected"<?php } ?>>06</option>
																		<option value="07" <?php if($ExpirationMonth == "07") { ?>selected="selected"<?php } ?>>07</option>
																		<option value="08" <?php if($ExpirationMonth == "08") { ?>selected="selected"<?php } ?>>08</option>
																		<option value="09" <?php if($ExpirationMonth == "09") { ?>selected="selected"<?php } ?>>09</option>
																		<option value="10" <?php if($ExpirationMonth == "10") { ?>selected="selected"<?php } ?>>10</option>
																		<option value="11" <?php if($ExpirationMonth == "11") { ?>selected="selected"<?php } ?>>11</option>
																		<option value="12" <?php if($ExpirationMonth == "12") { ?>selected="selected"<?php } ?>>12</option>
																	</select>/<select id="ExpirationYear" name="ExpirationYear" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-select', 'ExpirationYear' ) ); ?>">
																	<?php
																		$num_years = apply_filters( 'pmpro_num_expiration_years', 10 );

																		for ( $i = date_i18n( 'Y' ); $i < intval( date_i18n( 'Y' ) ) + intval( $num_years ); $i++ )
																		{
																			?>
																			<option value="<?php echo esc_attr( $i ) ?>" <?php if($ExpirationYear == $i) { ?>selected="selected"<?php } elseif($i == date_i18n( 'Y' ) + 1) { ?>selected="selected"<?php } ?>><?php echo esc_html( $i )?></option>
																			<?php
																		}
																	?>
																	</select>
																</div> <!-- end pmpro_form_fields-inline -->
															</div>
															<?php
																$pmpro_show_cvv = apply_filters("pmpro_show_cvv", true);
																if($pmpro_show_cvv) { ?>
																<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_payment-cvv', 'pmpro_payment-cvv' ) ); ?>">
																	<label for="CVV" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Security Code (CVC)', 'paid-memberships-pro' );?></label>
																	<input id="CVV" name="CVV" type="text" size="4" value="<?php if(!empty($_REQUEST['CVV'])) { echo esc_attr( sanitize_text_field( $_REQUEST['CVV'] ) ); }?>" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'CVV' ) ); ?>" />
																</div>
															<?php } ?>
														</div> <!-- end pmpro_cols-2 -->
														<?php if($pmpro_show_discount_code) { ?>
															<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_cols-2' ) ); ?>">
																<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_payment-discount-code', 'pmpro_payment-discount-code' ) ); ?>">
																	<label for="pmpro_discount_code" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>"><?php esc_html_e('Discount Code', 'paid-memberships-pro' );?></label>
																	<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields-inline' ) ); ?>">
																		<input class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text pmpro_alter_price', 'discount_code' ) ); ?>" id="pmpro_discount_code" name="pmpro_discount_code" type="text" size="10" value="<?php echo esc_attr($discount_code); ?>" />
																		<input aria-label="<?php esc_html_e( 'Apply discount code', 'paid-memberships-pro' ); ?>" type="button" id="discount_code_button" name="discount_code_button" value="<?php esc_attr_e('Apply', 'paid-memberships-pro' );?>" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_btn pmpro_btn-submit-discount-code', 'other_discount_code_button' ) ); ?>" />
																	</div> <!-- end pmpro_form_fields-inline -->
																	<div id="discount_code_message" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_message', 'discount_code_message' ) ); ?>" style="display: none;"></div>
																</div>
															</div> <!-- end pmpro_cols-2 -->
														<?php } ?>
													</div> <!-- end pmpro_form_fields -->
												</div> <!-- end pmpro_card_content -->
											</div> <!-- end pmpro_card -->
										</fieldset> <!-- end pmpro_payment_information_fields -->
										<?php
									}
								?>

								<?php
							do_action( 'pmpro_checkout_after_payment_information_fields' );
								do_action( 'pmpro_checkout_before_submit_button' );

								// Add nonce.
								wp_nonce_field( 'pmpro_checkout_nonce', 'pmpro_checkout_nonce' );
								?>

								<?php if ( $pmpro_msg ) { ?>
									<div id="pmpro_message_bottom" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ) ); ?>"><?php echo wp_kses_post( apply_filters( 'pmpro_checkout_message', $pmpro_msg, $pmpro_msgt ) ); ?></div>
								<?php } else { ?>
									<div id="pmpro_message_bottom" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_message' ) ); ?>" style="display: none;"></div>
								<?php } ?>

								<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_submit' ) ); ?>">

									<?php if ( $pmpro_review ) { ?>
										<span id="pmpro_submit_span">
											<input type="hidden" name="confirm" value="1" />
											<input type="hidden" name="token" value="<?php echo esc_attr($pmpro_paypal_token); ?>" />
											<input type="hidden" name="gateway" value="<?php echo esc_attr($gateway); ?>" />
											<input type="hidden" name="submit-checkout" value="1" />
											<input type="submit" id="pmpro_btn-submit" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_btn pmpro_btn-submit-checkout', 'pmpro_btn-submit-checkout' ) ); ?>" value="<?php esc_attr_e('Complete Payment', 'paid-memberships-pro' );?>" />
										</span>

									<?php } else { ?>

										<?php
											/**
												* Filter to set the default submit button on the checkout page.
												*
												* @param bool $pmpro_checkout_default_submit_button Default is true.
												* @return bool
												*/
											$pmpro_checkout_default_submit_button = apply_filters('pmpro_checkout_default_submit_button', true);
											if ( $pmpro_checkout_default_submit_button ) {
												?>
												<span id="pmpro_submit_span">
													<input type="hidden" name="submit-checkout" value="1" />
													<input type="submit" id="pmpro_btn-submit" class="<?php echo esc_attr( pmpro_get_element_class(  'pmpro_btn pmpro_btn-submit-checkout', 'pmpro_btn-submit-checkout' ) ); ?>" value="<?php if($pmpro_requirebilling) { esc_html_e('Submit and Check Out', 'paid-memberships-pro' ); } else { esc_html_e('Submit and Confirm', 'paid-memberships-pro' );}?>" />
												</span>
												<?php
												}
											?>

									<?php } ?>

									<div id="pmpro_processing_message" style="visibility: hidden;">
										<?php
											$processing_message = apply_filters("pmpro_processing_message", __("Processing...", 'paid-memberships-pro' ));
											echo wp_kses_post( $processing_message );
										?>
									</div>

								</div> <!-- end pmpro_form_submit -->

							</form> <!-- end pmpro_form -->

							<?php do_action( 'pmpro_checkout_after_form' ); ?>

						</section> <!-- end pmpro_level-ID -->
					</div> 
	            </div>
	        </div> 
	    </div>
	</div>

	<!-----Step Six-------->
	<div id="stepsix" class="step thankyou" style="display: none;">
	    <div class="container">
			<div class="inner-block">
				<h2 class="section-head">Payment Success</h2>
				<p class="section-paragraph">Thank you for your contribution to the Global Wellness Industry! Your membership is now active, and your recognitions are ready to be used.</p>
				<p class="section-paragraph"><strong>Next Steps: </strong></p>
				<ol>
					<li>Download your participation badge and any other assets from your dashboard</li>
					<li>Showcase your awards on your website and marketing materials</li>
					<li>Explore your exclusive member benefits and acknowledgements</li>
				</ol>
				<div class="btn_block">
					<a href="#">Go to my Dashboard</a>
				</div>
				<p>Need help? Contact us anytime at support@globalwellnessindustry.com. We’re here to ensure your recognition process is seamless!</p>
			</div>
	    </div>
	</div>
</div>


<script>

document.addEventListener('DOMContentLoaded', function() {

    const steps = [
        'stepone', 
        'steptwo', 
        'stepthree', 
        'stepfour', 
        'stepfive', 
        'stepsix'
    ];

    window.selectMemberLevel = function(button, level) {
        try {

            document.querySelectorAll(".member-button").forEach((btn) => {
                btn.classList.remove("selected");
            });
            button.classList.add("selected");


            const membershipLevel = parseInt(level, 10);


            localStorage.setItem("selectedMembershipLevelAfterReload", membershipLevel);
            localStorage.setItem("currentStep", "stepfive");
            

            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("pmpro_level", membershipLevel);
            

            window.location.href = currentUrl.toString();
        } catch (error) {
            console.error("Error in selectMemberLevel:", error);
            alert("There was an error selecting the membership level. Please try again.");
        }
    };

    steps.forEach((stepId, index) => {
        const currentStep = document.getElementById(stepId);
        if (!currentStep) return;

        let nextButton = currentStep.querySelector('.formbtn');

        if (stepId === 'stepfour') {
            const participationBadgeButton = document.getElementById('participationBadgeButton');
            if (participationBadgeButton) {
                participationBadgeButton.addEventListener('click', function() {

                    const awardDiv = document.getElementById('award-div');
                    if (awardDiv) awardDiv.style.display = 'none';

                    const achievementDiv = document.getElementById('achievement-div');
                    if (achievementDiv) achievementDiv.style.display = 'block';
                });
            }
        }

        if (!nextButton) return;

        nextButton.addEventListener('click', function() {

            if (!validateStep(stepId)) return;

            currentStep.style.display = 'none';


            if (index < steps.length - 1) {
                const nextStepId = steps[index + 1];
                const nextStep = document.getElementById(nextStepId);
                if (nextStep) {
                    nextStep.style.display = 'block';

                    localStorage.setItem("currentStep", nextStepId);
                }
            }
        });
    });


    function validateStep(stepId) {
        switch(stepId) {
            case 'stepone':

                const email = document.getElementById('email_address');
                const password = document.getElementById('pass');
                
                if (!email.value.trim()) {
                    alert('Please enter your email address');
                    return false;
                }
                
                if (!password.value.trim()) {
                    alert('Please enter your password');
                    return false;
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value)) {
                    alert('Please enter a valid email address');
                    return false;
                }
                
                if (password.value.length < 8) {
                    alert('Password must be at least 8 characters long');
                    return false;
                }
                
                return true;
            
            default:
                return true;
        }
    }

    function restorePageState() {

        const storedStep = localStorage.getItem("currentStep");
        const storedLevel = localStorage.getItem("selectedMembershipLevelAfterReload");

        steps.forEach(stepId => {
            const step = document.getElementById(stepId);
            if (step) step.style.display = 'none';
        });

        if (storedStep) {
            const stepToShow = document.getElementById(storedStep);
            if (stepToShow) {
                stepToShow.style.display = 'block';
            }

            if (storedStep === 'stepfive' && storedLevel) {
                const levelButtons = document.querySelectorAll(".member-button");
                levelButtons.forEach(button => {
                    if (button.getAttribute('data-level') === storedLevel) {
                        button.classList.add('selected');
                    } else {
                        button.classList.remove('selected');
                    }
                });
            }


            localStorage.removeItem("selectedMembershipLevelAfterReload");
        } else {

            const firstStep = document.getElementById('stepone');
            if (firstStep) firstStep.style.display = 'block';
        }
    }

    restorePageState();
});




(function() {

	  function generateUsernameFromEmail(email) {

	    const username = email.split('@')[0]

	      .replace(/[^a-zA-Z0-9]/g, '_')

	      .toLowerCase()

	      .replace(/^[^a-z]+/, '');
	    
	    return username;
	  }

	  function setupSync(primaryId, primarySelector, secondarySelectors, storageKey, usernameSelector = null) {
	    console.log(`Setting up sync for ${primaryId}`);
	    
	    const primaryField = document.getElementById(primaryId);
	    
	    if (!primaryField) {
	      console.error(`Primary field with ID ${primaryId} not found!`);
	      return;
	    }


	    const secondaryFieldSelectors = Array.isArray(secondarySelectors) 
	      ? secondarySelectors 
	      : [secondarySelectors];

	    const secondaryFields = secondaryFieldSelectors
	      .map(selector => document.querySelector(selector))
	      .filter(field => field !== null);

	    const usernameField = usernameSelector 
	      ? document.querySelector(usernameSelector) 
	      : null;

	    const savedValue = localStorage.getItem(storageKey);
	    if (savedValue) {
	      console.log(`Restoring ${storageKey} from localStorage:`, savedValue);
	      primaryField.value = savedValue;
	      
	      secondaryFields.forEach(field => {
	        field.value = savedValue;
	        console.log('Secondary field updated:', field);
	      });

	      if (storageKey === 'email_address' && usernameField) {
	        const generatedUsername = generateUsernameFromEmail(savedValue);
	        usernameField.value = generatedUsername;
	        console.log('Username generated from email:', generatedUsername);
	      }
	    }

	    primaryField.addEventListener('input', function(event) {
	      const currentValue = event.target.value;
	      console.log(`Input event on ${primaryId}. Current value:`, currentValue);
	      
	      secondaryFields.forEach(field => {
	        field.value = currentValue;
	        console.log('Secondary field updated:', field);
	      });


	      if (storageKey === 'email_address' && usernameField) {
	        const generatedUsername = generateUsernameFromEmail(currentValue);
	        usernameField.value = generatedUsername;
	        console.log('Username generated from email:', generatedUsername);
	      }
	    });

	    primaryField.addEventListener('blur', function(event) {
	      const currentValue = event.target.value;
	      console.log(`Blur event on ${primaryId}. Saving to localStorage:`, currentValue);
	      
	      try {
	        localStorage.setItem(storageKey, currentValue);
	        console.log(`Successfully saved ${storageKey} to localStorage`);
	      } catch (error) {
	        console.error('Error saving to localStorage:', error);
	      }
	    });
	  }

	  function initializeSync() {
	    console.log('Initializing form synchronization...');
	    
	    setupSync(
	      'email_address', 
	      '#email_address', 
	      [
	        '.pmpro_form_field input#bemail', 
	        '.pmpro_form_field input#bconfirmemail'
	      ],
	      'email_address',
	      '#username'  
	    );

	    setupSync(
	      'pass', 
	      '#pass', 
	      [
	        '.pmpro_form_field input#password', 
	        '.pmpro_form_field input#password2'
	      ],
	      'password'
	    );

	    console.log('Form synchronization initialization complete.');
	  }

	  window.addEventListener('load', initializeSync);
	  document.addEventListener('DOMContentLoaded', initializeSync);

	  initializeSync();
	})();


</script>