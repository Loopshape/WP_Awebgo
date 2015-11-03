<?php 
    $args = new stdClass();
    $args->settings = $params;
    $args->key = isset( $_GET['tab'] ) ? $_GET['tab'] : 'scfp_form_settings';
    $args->tabs = $args->settings->getTabs();
    $args->fieldSet = $args->settings->getFieldSet();
    $args->data = $args->settings->getSettings($args->key);
    $args->fields = $args->settings->getFields($args->key);
    $title = !empty($args->settings->getConfig()->admin->options->title) ? $args->settings->getConfig()->admin->options->title : '';
?>
<?php if (!empty($title)) :?>
<div style="width: 100%; padding: 20px 0 0;">
    <table>
        <tr style="vertical-align: middle;">
            <td style="padding: 0 20px 0 0;">                                                                                               
                <img src="<?php echo SCFP()->getAssetUrl( 'images/icons/icon-128x128.png' )?>" width="100" height="100" />    
            </td>
            <td>
                <h1 style="margin: 0px; padding: 0 0 10px;"><?php echo $title;?></h1>
                <p style="margin: 0px; padding: 0 0 5px;">More information about the plugin you can find on the <a href="https://wordpress.org/plugins/wcp-contact-form/" target="_blank" title="">plugin page</a> in the <a href="https://wordpress.org/plugins/wcp-contact-form/faq/" target="_blank" title="FAQ">FAQ</a> and <a href="http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/" target="_blank" title="Check Plugin Documentation">plugin documentation</a> on our site. Check <strong>live demo</strong> or ask a question you can on <a href="http://wpdemo.webcodin.com/stay-in-touch/" target="_blank" title="FAQ">our site</a>.<br />If you really like our plugin, please <a href="https://wordpress.org/support/view/plugin-reviews/wcp-contact-form?rate=5#postform" target="blank" title="Rate Our Plugin">rate us</a>!</p> 
                <p style="margin: 0px; padding: 0;">To start using our contact form on your site, please <strong>check settings</strong> on the tabs below and <strong>add to a page shortcode</strong> of the contact form via <strong>button in the TinyMCE toolbar</strong> (should be activated in tab "Form" --> "TinyMCE Support") or <strong>copy &amp; paste following shortcode</strong>: [wcp_contactform id="wcpform_1"]</p>   
            </td>
        </tr>
    </table>
</div>
<?php endif;?>



<div class="wrap">
    <?php 
        screen_icon();
        settings_errors();
        
        echo $args->settings->getParentModule()->getTemplate('admin/options/render-tabs', $args);
    ?>
    <form method="post" action="options.php">
        <?php wp_nonce_field( 'update-options' ); ?>
        <?php settings_fields( $args->key ); ?>
        
        <?php echo $args->settings->getParentModule()->getTemplate('admin/options/render-page', $args); ?>
        
        <p class="submit">
            <input id="submit" class="button button-primary" type="submit" value="Save Changes" name="submit">
            <a class="button button-primary" href="?page=<?php echo $args->settings->getPage();?>&tab=<?php echo $args->key;?>&reset-settings=true" >Reset to Default</a>
        </p>
    </form>
</div>