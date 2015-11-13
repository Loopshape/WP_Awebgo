<?php
    $args = $params;
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';
    $atts = !empty($args->fields['fields'][$args->field]['atts']) ? $args->fields['fields'][$args->field]['atts'] : '';
    if (is_array($atts)) {
        $atts_s = '';
        foreach ($atts as $key => $value) {
            $atts_s .= $key . '="' . $value . '"';
        }
        $atts = $atts_s;
    }

    $obj = new stdClass();
    $obj->ID = 'scfp_form_settings';
?>
    </tbody>        
</table>     

    <?php if (!empty($note)): ?><p class="description"><?php echo $note;?></p><?php endif;?>
    
    <?php echo SCFP()->getFormSettings()->viewMetabox($obj); ?>

<table class="form-table">
    <tbody>

    
    