<?php
$id = !empty($params['id']) ? $params['id'] : NULL;
$form = !empty($params['form']) ? $params['form'] : NULL;
$key = !empty($params['key']) ? $params['key'] : NULL;
$field = !empty($params['field']) ? $params['field'] : NULL;
$formSettings = !empty($params['formSettings']) ? $params['formSettings'] : NULL;
$formData = !empty($params['formData']) ? $params['formData'] : NULL;

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
    <div class="scfp-form-row">
        <label class="scfp-form-label" for="scfp-<?php echo $key; ?>"><?php echo $field['name'];?><?php if ( !empty( $field['required'] ) ) : ?> <span class="scfp-form-field-required">*</span><?php endif;?></label>
        <div class="scfp-captcha">                                
            <div class="scfp-captcha-image">
                <div class="scfp-captcha-image-wrapper">
                    <img src="data:image/png;base64,<?php echo $form->getCaptcha()->CreateImage($key, TRUE);?>" alt="" />
                </div>    
            </div>    
            <div class="scfp-captcha-field">
                <input <?php echo $atts;?> class="scfp-form-field" type="text" id="scfp-<?php echo $key; ?>" name="scfp-<?php echo $key; ?>" <?php if ( !empty( $field['required'] ) && !empty($formSettings['html5_enabled']) ) : ?> required <?php endif;?>>
                <a class="scfp-captcha-refresh" data-key="<?php echo $key; ?>" data-id="<?php echo $id;?>" href="javascript:void();">
                    <div class="scfp-captcha-refresh-inner">
                        <div class="scfp-captcha-refresh-inner-icon">
                            <span class="scfp-icon-refresh"></span>
                        </div>    
                    </div>    
                </a>
            </div>
        </div>                                    
    </div>
<?php 
endif;
