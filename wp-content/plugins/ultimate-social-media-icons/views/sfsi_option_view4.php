<?php
  /* unserialize all saved option for  section 4 options */
    $option4 =  unserialize(get_option('sfsi_section4_options',false));
	if(!isset($option4['sfsi_facebook_mypageCounts']))
	{
		$option4['sfsi_facebook_mypageCounts'] = '';
	}
    $option2 =  unserialize(get_option('sfsi_section2_options',false));
    $counts = sfsi_getCounts(); /* fetch counts for admin sections */
    /* check for email icon display */
    $email_image="email.png";
    if($option2['sfsi_rss_icons']=="sfsi")
    {
        $email_image="sf_arow_icn.png";
    }    
    $hide="display:none;";
?>
<!-- Section 4 "Do you want to display "counts" next to your icons?" main div Start -->
<div class="tab4">
  <p>
  	It’s a psychological fact that people like to follow other people (as explained well in Robert Cialdini’s book “<a href="http://www.amazon.com/Influence-Psychology-Persuasion-Revised-Edition/dp/006124189X" target="_blank" class="lit_txt">Influence</a>”), so when they see that your site has already a good number of Facebook likes, it’s more likely that they will subscribe/like/share your site than if it had 0.
  </p>
  <p>Therefore, you can select to display the count next to your main icons, which will look like this:</p>
	
  <!-- sample icons -->
  <ul class="like_icon">
    <li class="rss_section">
    	<a href="#" title="RSS">
        	<img src="<?php echo SFSI_PLUGURL ?>images/rss.png" alt="RSS" />
        </a>
        <span>12k</span>
    </li>
    <li class="email_section">
    	<a href="#" title="Email">
        	<img src="<?php echo SFSI_PLUGURL ?>images/<?php echo $email_image; ?>" alt="Email" class="icon_img" />
        </a>
        <span>12k</span>
    </li>
    <li class="facebook_section">
    	<a href="#" title="Facebook">
        	<img src="<?php echo SFSI_PLUGURL ?>images/facebook.png" alt="Facebook" />
        </a>
        <span>12k</span>
    </li>
    <li class="google_section">
    	<a href="#" title="Google Plus">
        	<img src="<?php echo SFSI_PLUGURL ?>images/google_plus.png" alt="Google Plus" />
        </a>
        <span>12k</span>
    </li>
    <li class="twitter_section">
    	<a href="#" title="Twitter">
        	<img src="<?php echo SFSI_PLUGURL ?>images/twitter.png" alt="Twitter" />
        </a>
        <span>12k</span>
    </li>
    <li class="share_section">
    	<a href="#" title="Share">
        	<img src="<?php echo SFSI_PLUGURL ?>images/share.png" alt="Share" />
        </a>
        <span>12k</span>
    </li>
    <li class="youtube_section">
    	<a href="#" title="YouTube">
        	<img src="<?php echo SFSI_PLUGURL ?>images/youtube.png" alt="YouTube" />
        </a>
        <span>12k</span>
    </li>
    <li class="pinterest_section">
    	<a href="#" title="Pinterest">
        	<img src="<?php echo SFSI_PLUGURL ?>images/pinterest.png" alt="Pinterest" />
        </a>
        <span>12k</span>
    </li>
    <li class="linkedin_section">
    	<a href="#" title="Linked In">
        	<img src="<?php echo SFSI_PLUGURL ?>images/linked_in.png" alt="Linked In" />
        </a>
        <span>12k</span>
    </li>
    <li class="instagram_section">
    	<a href="#" title="Instagram">
        	<img src="<?php echo SFSI_PLUGURL ?>images/instagram.png" alt="instagram" />
        </a>
        <span>12k</span>
    </li>
  </ul>  <!-- END sample icons -->
    
  <p>
  	Of course, if you start at 0, you shoot yourself in the foot with that. So we suggest that you only turn this feature on once you have a good number of followers/likes/shares (min. of 20 – no worries if it’s not too many, it should just not be 0).
  </p>
  <h4>Enough waffling. So do you want to display counts?</h4>
  
  <!-- show/hide counts for icons section  START --> 
  <ul class="enough_waffling">
  	<li><input name="sfsi_display_counts" <?php echo ($option4['sfsi_display_counts']=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  /><label>Yes</label></li>
    <li><input name="sfsi_display_counts" <?php echo ($option4['sfsi_display_counts']=='no') ?  'checked="true"' : '' ;?> type="radio" value="no" class="styled"  /><label>No</label></li>
  </ul>
  <!-- END  show/hide counts for icons section --> 
  
  <!-- show/hide counts for all icons section  START --> 
  <div class="count_sections" style="display:none">
  	<h4>Please specify which counts should be shown:</h4>
   	
    <!-- RSS ICON COUNT SECTION-->
  	<div class="specify_counts rss_section">
		<div class="radio_section">
        	<input name="sfsi_rss_countsDisplay" <?php echo ($option4['sfsi_rss_countsDisplay']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
        </div>
		<div class="social_icon_like">
	    	<ul class="like_icon">
	    		<li>
                	<a title="RSS">
                    	<img src="<?php echo SFSI_PLUGURL ?>images/rss.png" alt="RSS" />
                    	<span><?php echo $counts['rss_count']; ?></span>
                    </a>
                </li>
            </ul>
        </div>
		<div class="listing">
	    	<ul>
				<li>We cannot track this. So enter the figure here: <input name="sfsi_rss_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_rss_manualCounts']!='') ?  $option4['sfsi_rss_manualCounts'] : '' ;?>" /></li>
	   	 	</ul>
		</div>    
  	</div>
    <!-- END RSS ICON COUNT SECTION-->
  
  	<!-- EMAIL ICON COUNT SECTION-->
  	<div class="specify_counts email_section">
		<div class="radio_section">
        	<input name="sfsi_email_countsDisplay" <?php echo ($option4['sfsi_email_countsDisplay']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
        </div>
		<div class="social_icon_like">
	    	<ul class="like_icon">
	    		<li>
                	<a title="Email">
                    	<img src="<?php echo SFSI_PLUGURL ?>images/<?php echo $email_image; ?>" alt="Email" />
                        <span><?php echo $counts['email_count']; ?></span>
                    </a>
                </li>
			</ul>
		</div>
		<div class="listing">
	    	<ul>
	     		<li><input name="sfsi_email_countsFrom" <?php echo ($option4['sfsi_email_countsFrom']=='source') ?  'checked="true"' : '' ;?>  type="radio" value="source" class="styled"  />Retrieve the number of subscribers automatically</li>
	     		<li><input name="sfsi_email_countsFrom" <?php echo ($option4['sfsi_email_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" />Enter the figure manually<input name="sfsi_email_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_email_manualCounts']!='') ?  $option4['sfsi_email_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_email_countsFrom']=='source') ?  'display:none;' : '' ;?>" /></li>
	    	</ul>
		</div>    
  	</div>
    <!--END  EMAIL  ICON COUNT SECTION--> 
  
  	<!-- FACEBOOK ICON COUNT SECTION-->
  	<div class="specify_counts facebook_section">
  		<div class="radio_section">
        	<input name="sfsi_facebook_countsDisplay" <?php echo ($option4['sfsi_facebook_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
        </div>
    	<div class="social_icon_like">
    		<ul class="like_icon">
        		<li><a title="Facebook"><img src="<?php echo SFSI_PLUGURL ?>images/facebook.png" alt="Facebook" /><span><?php echo $counts['fb_count']; ?></span></a></li>
    		</ul>
    	</div>
    	<div class="listing">
    		<ul>
            	<li>
                	<input name="sfsi_facebook_countsFrom" <?php echo ($option4['sfsi_facebook_countsFrom']=='likes') ?  'checked="true"' : '' ;?>  type="radio" value="likes" class="styled"  />Retrieve the number of likes <strong>of your blog</strong>				
                </li>
            	<li>
            		<input name="sfsi_facebook_countsFrom" <?php echo ($option4['sfsi_facebook_countsFrom']=='mypage') ?  'checked="true"' : '' ;?>  type="radio" value="mypage" class="styled"  />
                    Retrieve the number of likes <strong>of your facebook page</strong><br>
                    <div class="sfsi_fbpgiddesc">	
                        <div class="sfsi_fbpgidwpr" style="<?php echo ($option4['sfsi_facebook_countsFrom']=='likes' || $option4['sfsi_facebook_countsFrom']=='followers' || $option4['sfsi_facebook_countsFrom']=='manual') ?  'display:none;' : '' ;?>">Facebook page ID:</div>
                        <input name="sfsi_facebook_mypageCounts" type="text" class="input mypginpt" value="<?php echo ($option4['sfsi_facebook_mypageCounts']!='') ?  $option4['sfsi_facebook_mypageCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_facebook_countsFrom']=='likes' || $option4['sfsi_facebook_countsFrom']=='followers' || $option4['sfsi_facebook_countsFrom']=='manual') ?  'display:none;' : '' ;?>" />
                    </div>
                	<div class="sfsi_fbpgidwpr sfsi_fbpgiddesc" style="<?php echo ($option4['sfsi_facebook_countsFrom']=='likes' || $option4['sfsi_facebook_countsFrom']=='followers' || $option4['sfsi_facebook_countsFrom']=='manual') ?  'display:none;' : '' ;?>">(You'll find it at the bottom of the <code><<</code>About<code>>></code>-tab on your facebook page)</div>
                </li>
            	<li>
                	<input name="sfsi_facebook_countsFrom" <?php echo ($option4['sfsi_facebook_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" />Enter the figure manually<input name="sfsi_facebook_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_facebook_manualCounts']!='') ?  $option4['sfsi_facebook_manualCounts'] : '' ;?>"  style="<?php echo ($option4['sfsi_facebook_countsFrom']=='likes' || $option4['sfsi_facebook_countsFrom']=='followers' || $option4['sfsi_facebook_countsFrom']=='mypage') ?  'display:none;' : '' ;?>" />
                </li>
        	</ul>
    	</div>    
  	</div>
    <!-- END FACEBOOK ICON COUNT SECTION-->
  
  	<!-- TWITTER ICON COUNT SECTION-->
  	<div class="specify_counts twitter_section">
  		<div class="radio_section">
        	<input name="sfsi_twitter_countsDisplay" <?php echo ($option4['sfsi_twitter_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
        </div>
    	<div class="social_icon_like">
    		<ul class="like_icon">
    			<li>
                	<a title="Twitter">
                    	<img src="<?php echo SFSI_PLUGURL ?>images/twitter.png" alt="Twitter" />
                        <span><?php echo $counts['twitter_count']; ?></span>
                    </a>
                </li>
    		</ul>
    	</div>
    	<div class="listing">
    		<ul>
        		<li>
                	<input name="sfsi_twitter_countsFrom" <?php echo ($option4['sfsi_twitter_countsFrom']=='source') ?  'checked="true"' : '' ;?>  type="radio" value="source" class="styled" />Retrieve the number of Twitter followers
                </li>
            	
                <li class="SFSI_tglli">
                	<ul class="SFSI_lsngfrm">
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">
                        	<label>Enter Consumer Key</label>
                        	<input name="tw_consumer_key" class="input_facebook" type="text" value="<?php echo (isset($option4['tw_consumer_key']) && $option4['tw_consumer_key']!='') ?  $option4['tw_consumer_key'] : '' ;?>"  />
                       	</li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">
                        	<label>Enter Consumer Secret</label>
                            <input name="tw_consumer_secret" class="input_facebook" type="text" value="<?php echo (isset($option4['tw_consumer_secret']) && $option4['tw_consumer_secret']!='') ?  $option4['tw_consumer_secret'] : '' ;?>"  />
                        </li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">
                        	<label>Enter Access Token</label>
                            <input name="tw_oauth_access_token" class="input_facebook" type="text" value="<?php echo (isset($option4['tw_oauth_access_token']) && $option4['tw_oauth_access_token']!='') ?  $option4['tw_oauth_access_token'] : '' ;?>"/>
                        </li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">
                        	<label>Enter Access Token Secret</label>
                            <input name="tw_oauth_access_token_secret" class="input_facebook" type="text" value="<?php echo (isset($option4['tw_oauth_access_token_secret']) && $option4['tw_oauth_access_token_secret']!='') ?  $option4['tw_oauth_access_token_secret'] : '' ;?>"  />
                        </li>
                	</ul>
                	<ul class="SFSI_instructions">
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">Please make sure you have entered the <b>Username</b> for <b>"Follow me on Twitter:"</b> in twitter settings under question number 2.</li>
                		<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><h3>To get this information : </h3></li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">1: Go to <a href="http://apps.twitter.com" target="_blank">apps.twitter.com</a></li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">2: Click on "Create new app"</li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">3: Enter a random Name , Descriptions and Website URL (including the "http://", e.g. http://dummysitename.com)</li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">4: Go to "Keys and Access Tokens" tab and click on "Generate Token" in the "Token actions" section at the bottom</li>
                    	<li class="tw_follow_options" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">5: Then click on "Test OAuth" at the top right and you will see the 4 token key</li>
                	</ul>
            </li>
            
            	<li>
                	<input name="sfsi_twitter_countsFrom" <?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" />Enter the figure manually<input name="sfsi_twitter_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_twitter_manualCounts']!='') ?  $option4['sfsi_twitter_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='source') ?  'display:none;' : '' ;?>" />
                </li>
            
        	</ul>
    	</div>    
  	</div>
  	<!--END TWITTER ICON COUNT SECTION-->
  
  	<!-- GOOGLE ICON COUNT SECTION-->
  	<div class="specify_counts google_section">
  		<div class="radio_section">
        	<input name="sfsi_google_countsDisplay" <?php echo ($option4['sfsi_google_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
        </div>
    	<div class="social_icon_like">
    		<ul class="like_icon">
    			<li>
                	<a title="Google Plus">
                    	<img src="<?php echo SFSI_PLUGURL ?>images/google_plus.png" alt="Google Plus" />
                        <span><?php echo $counts['google_count']; ?></span>
                    </a>
               	</li>
    		</ul>
    	</div>
    	<div class="listing">
    	<ul>
            <li>
            	<input name="sfsi_google_countsFrom" <?php echo ($option4['sfsi_google_countsFrom']=='likes') ?  'checked="true"' : '' ;?>  type="radio" value="likes" class="styled" />Retrieve the number of Google +1 (on your blog)</li>
            <li>
            	<input name="sfsi_google_countsFrom" <?php echo ($option4['sfsi_google_countsFrom']=='follower') ?  'checked="true"' : '' ;?>  type="radio" value="follower" class="styled" />Retrieve the number of google+ followers</li>
            <li>
            	<ul class="SFSI_lsngfrm">
            		<li class="google_option" style="<?php echo ($option4['sfsi_google_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><label>Enter Google API Key </label><input name="sfsi_google_api_key" class="input_facebook" type="url" value="<?php echo (isset($option4['sfsi_google_api_key']) && $option4['sfsi_google_api_key']!='') ?  $option4['sfsi_google_api_key'] : '' ;?>"  />
                    </li>
                </ul>
                <ul class="SFSI_instructions">
                	<li class="google_option" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">Please make sure you have entered the <b>URL</b> for <b>Visit my Google+ page at:</b> like <b>https://plus.google.com/u/0/b/[pageid]</b> in Google+ settings under question number 2.	
                    </li>
                    <li class="google_option" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><h3>To get the API key for G+:</h3></li>
					<li class="google_option" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">1: Login to your 					Goolge account, go to <a href="http://console.developers.google.com" target="_blank">console.developers.google.com</a> and create a new project</li>
					<li class="google_option" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">2: Then on the left menu bar go to “APIs & auth”, “Credentials” and click “Create new key” in the “Public API access” section</li>
					<li class="google_option" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">3: There you select “browser key” and click “Create”. You will then be shown your API key. </li>
					<li class="google_option" style="<?php echo ($option4['sfsi_twitter_countsFrom']=='manual') ?  'display:none;' : '' ;?>">When you enter this key into the plugin for the first time, it may take some time until the correct follower count is displayed on your website.</li>
                </ul>
            </li>        
            <li>
            	<input name="sfsi_google_countsFrom" <?php echo ($option4['sfsi_google_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" />Enter the figure manually<input name="sfsi_google_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_google_manualCounts']!='') ?  $option4['sfsi_google_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_google_countsFrom']=='follower' || $option4['sfsi_google_countsFrom']=='likes') ?  'display:none;' : '' ;?>"  />
            </li>
        </ul>
    	</div>    
  	</div>
  	<!-- END GOOGLE ICON COUNT SECTION-->
  
  <!-- LINKEDIN ICON COUNT SECTION-->
  <div class="specify_counts linkedin_section">
  	<div class="radio_section"><input name="sfsi_linkedIn_countsDisplay" <?php echo ($option4['sfsi_linkedIn_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  /></div>
    <div class="social_icon_like">
    	<ul class="like_icon">
    	<li><a title="Linked in"><img src="<?php echo SFSI_PLUGURL ?>images/linked_in.png" alt="Linked in" /><span><?php echo $counts['linkedIn_count']; ?></span></a></li>
    </ul>
    </div>
    <div class="listing">
    	<ul>
        	<li><input name="sfsi_linkedIn_countsFrom" <?php echo ($option4['sfsi_linkedIn_countsFrom']=='follower') ?  'checked="true"' : '' ;?>  type="radio" value="follower" class="styled"  />Retrieve the number of Linkedin followers</li>
            <li class="SFSI_tglli">
                <ul class="SFSI_lsngfrm">
                    
                    <li class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><label>Enter Company Name </label><input name="ln_company" class="input_facebook" type="text" value="<?php echo (isset($option4['ln_company']) && $option4['ln_company']!='') ?  $option4['ln_company'] : '' ;?>"  /> </li>
                    <li  class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><label>Enter API Key </label><input name="ln_api_key" class="input_facebook" type="text" value="<?php echo (isset($option4['ln_api_key']) && $option4['ln_api_key']!='') ?  $option4['ln_api_key'] : '' ;?>"  /> </li>
                    <li  class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><label>Enter Secret Key </label><input name="ln_secret_key" class="input_facebook" type="text" value="<?php echo (isset($option4['ln_secret_key']) && $option4['ln_secret_key']!='') ?  $option4['ln_secret_key'] : '' ;?>"  /> </li>
                    <li  class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>" ><label>Enter OAuth User Token</label> <input name="ln_oAuth_user_token" class="input_facebook" type="text" value="<?php echo (isset($option4['ln_oAuth_user_token']) && $option4['ln_oAuth_user_token']!='') ?  $option4['ln_oAuth_user_token'] : '' ;?>"  /> </li>
           		</ul>
                <ul class="SFSI_instructions">
                	<li class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><h3>To get the API key for LinkedIn:</h3></li>
                    <li class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>">1: Go to <a href="https://developer.linkedin.com/" target="_blank">www.developer.linkedin.com</a>, mouse over “Support” and select “API keys”</li>
                    <li class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>">2: Then login with your Linkedin account and create a new application</li>
                    <li class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>">3: Fill the required boxes in the form with random data, accept the Terms and add the application</li>
					<li class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>">4: In the next step you will see the required API information</li>
                    <li class="linkedIn_options" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'display:none;' : '' ;?>">When you enter this key into the plugin for the first time, it may take some time until the correct follower count is displayed on your website.</li>
                </ul>    
             </li>   	
           
           
           <li><input name="sfsi_linkedIn_countsFrom" <?php echo ($option4['sfsi_linkedIn_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" />Enter the figure manually<input name="sfsi_linkedIn_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_linkedIn_manualCounts']!='') ?  $option4['sfsi_linkedIn_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_linkedIn_countsFrom']=='follower') ?  'display:none;' : '' ;?>" /></li>
        </ul>
    </div>    
  </div> <!-- END LINKEDIN ICON COUNT SECTION-->
  
   <!-- YOUTUBE ICON COUNT SECTION-->
  <div class="specify_counts youtube_section">
  	<div class="radio_section"><input name="sfsi_youtube_countsDisplay" <?php echo ($option4['sfsi_youtube_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  /></div>
    <div class="social_icon_like">
    	<ul class="like_icon">
    	<li><a title="YouTube"><img src="<?php echo SFSI_PLUGURL ?>images/youtube.png" alt="YouTube" /><span><?php echo $counts['youtube_count']; ?></span></a></li>
    </ul>
    </div>
    <div class="listing">
    	<ul>
        	<li><input name="sfsi_youtube_countsFrom" type="radio" value="subscriber" <?php echo ($option4['sfsi_youtube_countsFrom']=='subscriber') ?  'checked="true"' : '' ;?>  class="styled"  />Retrieve the number of Subscribers</li>
                <li class="youtube_options" style="<?php echo ($option4['sfsi_youtube_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><label>Enter Youtube User name</label><input name="sfsi_youtube_user" class="input_facebook" type="text" value="<?php echo (isset($option4['sfsi_youtube_user']) && $option4['sfsi_youtube_user']!='') ?  $option4['sfsi_youtube_user'] : '' ;?>"  /> </li>
                <li><input name="sfsi_youtube_countsFrom" type="radio" value="manual" <?php echo ($option4['sfsi_youtube_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  class="styled" />Enter the figure manually<input name="sfsi_youtube_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_youtube_manualCounts']!='') ?  $option4['sfsi_youtube_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_youtube_countsFrom']=='subscriber') ?  'display:none;' : '' ;?>" /></li>
        </ul>
    </div>    
  </div><!-- END YOUTUBE ICON COUNT SECTION-->
  
  <!-- PINIT ICON COUNT SECTION-->
  <div class="specify_counts pinterest_section">
  	<div class="radio_section"><input name="sfsi_pinterest_countsDisplay" <?php echo ($option4['sfsi_pinterest_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  /></div>
    <div class="social_icon_like">
    	<ul class="like_icon">
    	<li><a title="Pinterest"><img src="<?php echo SFSI_PLUGURL ?>images/pinterest.png" alt="Pinterest" /><span><?php echo $counts['pin_count']; ?></span></a></li>
    </ul>
    </div>
    <div class="listing">
    	<ul>
        	<li><input name="sfsi_pinterest_countsFrom" <?php echo ($option4['sfsi_pinterest_countsFrom']=='pins') ?  'checked="true"' : '' ;?>  type="radio" value="pins" class="styled"  />Retrieve the number of Pins</li>
                <li><input name="sfsi_pinterest_countsFrom" <?php echo ($option4['sfsi_pinterest_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" /><label class="high_prb">Enter the figure manually</label><input name="sfsi_pinterest_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_pinterest_manualCounts']!='') ?  $option4['sfsi_pinterest_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_pinterest_countsFrom']=='pins') ?  'display:none;' : '' ;?>" /></li>
        </ul>
    </div>    
  </div> <!-- END PINIT ICON COUNT SECTION-->
  
   <!-- INSTAGRAM ICON COUNT SECTION-->
  <div class="specify_counts instagram_section">
  	<div class="radio_section"><input name="sfsi_instagram_countsDisplay" <?php echo ($option4['sfsi_instagram_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  /></div>
    <div class="social_icon_like">
    	<ul class="like_icon">
    	<li><a title="Instagram"><img src="<?php echo SFSI_PLUGURL ?>images/instagram.png" alt="instagram" /><span><?php echo $counts['instagram_count']; ?></span></a></li>
    </ul>
    </div>
    <div class="listing">
    	<ul>
        	<li><input name="sfsi_instagram_countsFrom" <?php echo ($option4['sfsi_instagram_countsFrom']=='followers') ?  'checked="true"' : '' ;?>  type="radio" value="followers" class="styled"  />Retrieve the number of Instagram followers</li>
                <li class="instagram_userLi" style="<?php echo ($option4['sfsi_instagram_countsFrom']=='manual') ?  'display:none;' : '' ;?>"><label>Enter Instagram User name </label><input name="sfsi_instagram_User" class="input_facebook" type="text" value="<?php echo (isset($option4['sfsi_instagram_User']) && $option4['sfsi_instagram_User']!='') ?  $option4['sfsi_instagram_User'] : '' ;?>"  /> </li>
		<li><input name="sfsi_instagram_countsFrom" <?php echo ($option4['sfsi_instagram_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" /><label class="high_prb">Enter the figure manually</label><input name="sfsi_instagram_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_instagram_manualCounts']!='') ?  $option4['sfsi_instagram_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_instagram_countsFrom']=='followers') ?  'display:none;' : '' ;?>" /></li>
        </ul>
    </div>    
  </div>  <!-- END INSTAGRAM ICON COUNT SECTION-->
  
    <!-- ADDTHIS ICON COUNT SECTION-->
  <div class="specify_counts share_section">
  	<div class="radio_section"><input name="sfsi_shares_countsDisplay" <?php echo ($option4['sfsi_shares_countsDisplay']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  /></div>
    <div class="social_icon_like">
    	<ul class="like_icon">
    	<li><a title="Share"><img src="<?php echo SFSI_PLUGURL ?>images/share.png" alt="Share" /><span><?php echo $counts['share_count']; ?></span></a></li>
    </ul>
    </div>
    <div class="listing">
    	<ul>
            <li><input name="sfsi_shares_countsFrom" <?php echo ($option4['sfsi_shares_countsFrom']=='shares') ?  'checked="true"' : '' ;?>  type="radio" value="shares" class="styled" />Retrieve the number of shares</li>
            <li><input name="sfsi_shares_countsFrom" <?php echo ($option4['sfsi_shares_countsFrom']=='manual') ?  'checked="true"' : '' ;?>  type="radio" value="manual" class="styled" /><label class="high_prb">Enter the figure manually</label><input name="sfsi_shares_manualCounts" type="text" class="input" value="<?php echo ($option4['sfsi_shares_manualCounts']!='') ?  $option4['sfsi_shares_manualCounts'] : '' ;?>" style="<?php echo ($option4['sfsi_shares_countsFrom']=='shares') ?  'display:none;' : '' ;?>" /></li>
        </ul>
    </div>    
  </div>  <!-- END ADDTHIS ICON COUNT SECTION-->
  
  </div>  <!-- END show/hide counts for all icons section -->
  
   <!-- SAVE BUTTON SECTION   --> 
  <div class="save_button">
       <img src="<?php echo SFSI_PLUGURL ?>images/ajax-loader.gif" class="loader-img" />
       <?php  $nonce = wp_create_nonce("update_step4"); ?>
      <a href="javascript:;" id="sfsi_save4" title="Save" data-nonce="<?php echo $nonce;?>">Save</a>
  </div><!-- END SAVE BUTTON SECTION   -->
  <a class="sfsiColbtn closeSec" href="javascript:;" class="closeSec">Collapse area</a>
  <label class="closeSec"></label>
  <!-- ERROR AND SUCCESS MESSAGE AREA-->
  <p class="red_txt errorMsg" style="display:none"> </p>
  <p class="green_txt sucMsg" style="display:none"> </p>
  <div class="clear"></div>
</div><!-- END Section 4 "Do you want to display "counts" next to your icons?"  -->