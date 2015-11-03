<?php
$id = !empty($params['id']) ? $params['id'] : NULL;
$form = !empty($params['form']) ? $params['form'] : NULL;
$key = !empty($params['key']) ? $params['key'] : NULL;
$field = !empty($params['field']) ? $params['field'] : NULL;
$formSettings = !empty($params['formSettings']) ? $params['formSettings'] : NULL;
$formData = !empty($params['formData']) ? $params['formData'] : NULL;

$recaptcha = SCFP()->getSettings()->getRecaptchaSettings();
$recaptchaId = str_replace('-','_',$id) . '_' .str_replace('-','_',$key);

$atts = !empty($field['atts']) ? $field['atts'] : NULL;
if (!empty($atts) && is_array($atts)) {
    $atts_s = '';
    foreach ($atts as $k => $value) {
        $atts_s .= $k . '="' . $value . '"';
    }
    $atts = $atts_s;
}
if (!empty($key)) :
?>
<?php if (!empty($recaptcha['rc_key'])) :?>
    <script type="text/javascript">
        if (typeof scfp_rcwidget == 'undefined') {
            var scfp_rcwidget = {};
        }
        
        scfp_rcwidget.rcwidget_<?php echo $recaptchaId; ?> = {
            sitekey : '<?php echo $recaptcha['rc_key'];?>',
            theme : '<?php echo $recaptcha['rc_theme'];?>',
            type : '<?php echo $recaptcha['rc_type'];?>',
            size : '<?php echo $recaptcha['rc_size'];?>',
            callback : function(response) {
                var el = '#rcwidget_row_<?php echo $recaptchaId; ?> #scfp-<?php echo $key; ?>';
                jQuery(el).val(response);
            }
        };
    </script>
<?php endif; ?>    
    <div class="scfp-form-row" id="rcwidget_row_<?php echo $recaptchaId; ?>">
        <label class="scfp-form-label" for="scfp-<?php echo $key; ?>"><?php echo $field['name'];?><?php if ( !empty( $field['required'] ) ) : ?> <span class="scfp-form-field-required">*</span><?php endif;?></label>
        <div class="scfp-recaptcha scfp-theme-<?php echo $recaptcha['rc_theme'];?> scfp-type-<?php echo $recaptcha['rc_type'];?> scfp-size-<?php echo $recaptcha['rc_size'];?>">                                
            <?php if (!empty($recaptcha['rc_key'])) :?>
            <div id="rcwidget_<?php echo $recaptchaId; ?>" class="scfp-recaptcha-container"></div>
            <input id="scfp-<?php echo $key; ?>" name="scfp-<?php echo $key; ?>" type="hidden" class="scfp-rcwidget-response">
            <?php else:?>
            <div class="rcwidget-noconfig">
                reCAPTCHA is not properly configured. You need to configure reCAPTCHA settings on the plugin <a href="<?php echo admin_url('admin.php?page=scfp_plugin_options&tab=scfp_recaptcha_settings');?>" title="reCAPTCHA Settings" target="_blank">settings page</a>
            </div>            
            <?php endif;?>
        </div>                                    
    </div>
<?php 
endif;
