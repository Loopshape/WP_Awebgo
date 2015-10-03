<?php
     /* unserialize all saved option for first options */
    $option1=  unserialize(get_option('sfsi_section1_options',false));
?>
<!-- Section 1 "Which icons do you want to show on your site? " main div Start -->
<div class="tab1" >
<p class="top_txt">In general, <span>the more icons you offer the better</span> because people have different preferences, and more options means that there’s something for everybody, increasing the chances that you get followed and/or shared.</p> 
 <ul class="icn_listing">
     <!-- RSS ICON -->
    <li class="gary_bg">
	<div class="radio_section tb_4_ck"><input name="sfsi_rss_display" <?php echo ($option1['sfsi_rss_display']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_rss_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_rs_s">RSS</span> 
        <div class="right_info">
	    <p><span>"Mandatory":</span> RSS is still popular, esp. among the tech-savvy crowd.
            <label class="expanded-area" >RSS stands for Really Simply Syndication and is an easy way for people to read your content. You can learn more about it <a href="http://en.wikipedia.org/wiki/RSS" target="_new" title="Syndication">here</a>. </label></p>
            <a href="javascript:;" class="expand-area" >Read more</a>
        </div>
    </li><!-- END RSS ICON -->
    
     <!-- EMAIL ICON -->
    <li class="gary_bg">
    <div class="radio_section tb_4_ck">
	<input name="sfsi_email_display" <?php echo ($option1['sfsi_email_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_email_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_email">Email</span> 
        <div class="right_info">
        <p><span>"Mandatory":</span> Email is the most effective tool to build up a followership.
	    <span style="float: right;margin-right: 13px; margin-top: -3px;"><?php if(get_option('sfsi_footer_sec')=="yes") { $nonce = wp_create_nonce("remove_footer"); ?> <a style="font-size:13px;margin-left:30px;color:#777777;" href="javascript:;" class="sfsi_removeFooter" data-nonce="<?php echo $nonce;?>">Remove credit link</a> <?php } ?></span>
            <label class="expanded-area" >Everybody uses email – that’s why it’s <a href="http://www.entrepreneur.com/article/230949" target="_new">much more effective than social media </a> to make people follow you. Not offering an email subscription option means losing out on future traffic to your site.</label>
        </p>
         <a href="javascript:;" class="expand-area" >Read more</a>	 
        </div>
    </li><!-- EMAIL ICON -->
    
     <!-- FACEBOOK ICON -->
    <li class="gary_bg">
    <div class="radio_section tb_4_ck"><input name="sfsi_facebook_display" <?php echo ($option1['sfsi_facebook_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_facebook_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_facebook">Facebook</span> 
        <div class="right_info">
        <p><span>Strongly recommended:</span> Facebook is crucial, esp. for sharing.
        
        <label class="expanded-area" >Facebook is the giant in the social media world, and even if you don’t have a Facebook account yourself you should display this icon, so that Facebook users can share your site on Facebook. </label>
        </p>
        <a href="javascript:;" class="expand-area" >Read more</a>
        </div>
    </li><!-- END FACEBOOK ICON -->
    
   <!-- TWITTER ICON -->
    <li class="gary_bg">
	<div class="radio_section tb_4_ck"><input name="sfsi_twitter_display" <?php echo ($option1['sfsi_twitter_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_twitter_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_twt">Twitter</span> 
        <div class="right_info">
        <p><span>Strongly recommended:</span> Can have a strong promotional effect.
        <label class="expanded-area" >If you have a Twitter-account then adding this icon is a no-brainer. However, similar as with facebook, even if you don’t have one you should still show this icon so that Twitter-users can share your site.</label>
        </p>
        <a href="javascript:;" class="expand-area" >Read more</a>
        </div>
    </li> <!-- END TWITTER ICON -->
   
     <!-- GOOGLE ICON -->
    <li class="gary_bg">
        <div class="radio_section tb_4_ck"><input name="sfsi_google_display" <?php echo ($option1['sfsi_google_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_google_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_ggle_pls">Google+</span> 
        <div class="right_info">
        <p><span>Strongly recommended:</span> Increasingly important and beneficial for SEO.
            <label class="expanded-area" ></label>
        </p>
        </div>
    </li><!-- END GOOGLE ICON -->

   <!-- SHARE ICON --> 
   <li class="gary_bg">
        <div class="radio_section tb_4_ck"><input name="sfsi_share_display" <?php echo ($option1['sfsi_share_display']=='yes') ?  'checked="true"' : '' ;?> id=="sfsi_share_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_share">Share</span> 
        <div class="right_info">
        <p><span>Recommended:</span> With this button you can allow your visitors to share your site via «all the other» social media sites.
            <label class="expanded-area" >Everybody uses email – that’s why it’s <a href="http://www.entrepreneur.com/article/230949" target="_new">much more effective than social media </a> to make people follow you. Not offering an email subscription option means losing out on future traffic to your site.</label>
        </p>
        <a href="javascript:;" class="pop-up" data-id="athis-s1" >See Example</a>
        </div>
   </li> <!-- END SHARE ICON -->
   
   <!-- YOUTUBE ICON -->
   <li>
        <div class="radio_section tb_4_ck"><input name="sfsi_youtube_display" <?php echo ($option1['sfsi_youtube_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_youtube_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_utube">Youtube</span> 
        <div class="right_info">
        <p><span>It depends:</span> Show this icon if you have a youtube account (and you should set up one if you have video content – that can increase your traffic significantly). </p>
        </div>
   </li><!-- END YOUTUBE ICON -->
   
   <!-- LINKEDIN ICON -->
   <li>
        <div class="radio_section tb_4_ck"><input name="sfsi_linkedin_display" <?php echo ($option1['sfsi_linkedin_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_linkedin_display" type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_linkdin">LinkedIn</span> 
        <div class="right_info">
	    <p><span>It depends:</span> No.1 network for business purposes. Use this icon if you’re a LinkedInner.</p>
        </div>
   </li><!-- END LINKEDIN ICON -->
   
   <!-- PINTEREST ICON -->
   <li>
	<div class="radio_section tb_4_ck"><input name="sfsi_pinterest_display" <?php echo ($option1['sfsi_pinterest_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_pinterest_display"  type="checkbox" value="yes" class="styled"  /></div>
	<span class="sfsicls_pinterest">Pinterest</span> 
	<div class="right_info">
	    <p><span>It depends:</span> Show this icon if you have a Pinterest account (and you should set up one if you have publish new pictures regularly – that can increase your traffic significantly).</p>
	</div>
   </li> <!-- END PINTEREST ICON -->
   
   <!-- INSTAGRAM ICON -->
   <li>
        <div class="radio_section tb_4_ck"><input name="sfsi_instagram_display" <?php echo ($option1['sfsi_instagram_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_instagram_display"  type="checkbox" value="yes" class="styled"  /></div>
        <span class="sfsicls_instagram">Instagram</span> 
        <div class="right_info">
	    <p><span>It depends:</span> Show this icon if you have a Instagram account.</p>
        </div>
    </li> <!-- END INSTAGRAM ICON -->
    
     <!-- Custom icon section start here -->
    <?php
      $icons= ($option1['sfsi_custom_files']) ? unserialize($option1['sfsi_custom_files']) : array() ;
      $total_icons=count($icons);
      end($icons);
      $endkey=key($icons);
      $endkey = (isset($endkey)) ? $endkey :0;
      reset($icons);
      $first_key = key($icons);  
      $first_key = (isset($first_key)) ? $first_key :0;
      $new_element=0;
      if($total_icons>0){
        $new_element=$endkey+1;
      }     
    ?>
   <!-- Display all custom icons  -->
   <?php $count=1; for($i=$first_key;$i<=$endkey;$i++) : ?> 
    <?php if(!empty( $icons[$i])) : ?>
    <li id="c<?php echo $i; ?>" class="custom">
        <div class="radio_section tb_4_ck"><input name="sfsiICON_<?php echo $i; ?>"  checked="true" type="checkbox" value="yes" class="styled" element-type="cusotm-icon"  /></div>
        <span class="custom-img"><img class="sfcm" src="<?php echo (!empty($icons[$i])) ?  $icons[$i] : SFSI_PLUGURL.'images/custom.png';?>" id="CImg_<?php echo $i; ?>"  /> </span> 
         <span class="custom custom-txt">Custom <?php echo $count;?> </span> 
        <div class="right_info">
        <p><span>It depends:</span> Upload a custom icon if you have other accounts/websites you want to link to. </p>
	</div>
    </li>
    <?php $count++; endif;    endfor; ?>
     <!-- Create a custom icon if total uploaded icons are less than 5 -->
    <?php if($count <=5) : ?>
    <li id="c<?php echo $new_element; ?>" class="custom bdr_btm_non">
        <div class="radio_section tb_4_ck"><input name="sfsiICON_<?php echo$new_element;?>"  type="checkbox" value="yes" class="styled" element-type="cusotm-icon" ele-type='new'  /></div>
        <span class="custom-img"><img   src="<?php echo SFSI_PLUGURL.'images/custom.png';?>" id="CImg_<?php echo $new_element; ?>"  /> </span> 
         <span class="custom custom-txt">Custom<?php echo $count; ?> </span> 
        <div class="right_info">
        <p><span>It depends:</span> Upload a custom icon if you have other accounts/websites you want to link to. </p>
	</div>
    </li>
   <?php endif; ?>
    <!-- END Custom icon section here -->
 </ul>
 <input type="hidden" value="<?php echo SFSI_PLUGURL ?>" id="plugin_url" />
 <input type="hidden" value=""  id="upload_id" />
  <!-- SAVE BUTTON SECTION   -->
 <div class="save_button tab_1_sav">
   <img src="<?php echo SFSI_PLUGURL ?>images/ajax-loader.gif" class="loader-img" />
   <?php  $nonce = wp_create_nonce("update_step1"); ?>
   <a href="javascript:;" id="sfsi_save1" title="Save" data-nonce="<?php echo $nonce;?>">Save</a>
 </div><!-- END SAVE BUTTON SECTION   -->
 <a class="sfsiColbtn closeSec" href="javascript:;" >Collapse area</a>
 <!-- ERROR AND SUCCESS MESSAGE AREA-->
 <p class="red_txt errorMsg" style="display:none"> </p>
 <p class="green_txt sucMsg" style="display:none"> </p>
    
</div> <!-- END Section 1 "Which icons do you want to show on your site? " main div-->