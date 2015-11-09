<?php
    $id = $params['id'];
    $form = $params['form'];
    $errors = $form->getError();
    $errorSettings = SCFP()->getSettings()->getErrorsSettings();
    $fieldsSettings = SCFP()->getSettings()->getFieldsSettings();
    $formSettings = SCFP()->getSettings()->getFormSettings();
    $styleSettings = SCFP()->getSettings()->getStyleSettings();
    $formData = $form->getData();   
    $notifications = $form->getNotifications();
    
    $button_position = !empty($formSettings['button_position']) ? $formSettings['button_position'] : 'left';
    $no_border = !empty($styleSettings['no_border']) ? $styleSettings['no_border'] : '';
    $no_background = !empty($styleSettings['no_background']) ? $styleSettings['no_background'] : '';    
    
    $content_classes = array() ;
    if (!empty($no_border)) {
        $content_classes[] = "scfp-form-noborder"; 
    }
    if (!empty($no_background)) {
        $content_classes[] = "scfp-form-nobackground"; 
    }
    $content_classes = !empty($content_classes) ? ' '.implode(' ', $content_classes) : '';
?>

<?php echo SCFP()->getFormDynamicStyle($id);?>

<?php if( !empty( $errors ) ): ?>
<div class="scfp-form-error scfp-notifications">
    <div class="scfp-form-notifications-content">
        <?php foreach( $errors as $errors_key => $errors_value ): ?>
            <div class="scfp-error-item"><span><?php echo $fieldsSettings[$errors_key]['name'];?>:</span> <?php  echo $errorSettings['errors'][$errors_value ] ; ?></div>
        <?php endforeach; ?>
    </div>
    <a class="scfp-form-notifications-close" title="Close" href="javascript:void(0);">x</a>
</div>
<?php endif; ?>

<?php if( !empty( $notifications ) ): ?>
<div class="scfp-form-notification scfp-notifications">
    <div class="scfp-form-notifications-content">
        <?php foreach( $notifications as $notification ): ?>
            <div class="scfp-notification-item"><?php echo $notification; ?></div>
        <?php endforeach; ?>
    </div>
    <a class="scfp-form-notifications-close" title="Close" href="#">x</a> 
</div>
<?php endif; ?>

<div class="scfp-form-content scfp-form-widget<?php echo $content_classes;?>">
    <form class="scfp-form" id="<?php echo $id;?>"  method="post" action=""<?php echo !empty($formSettings['html5_enabled']) ? '' : ' novalidate';?>>
        <input type="hidden" name="form_id" value="<?php echo $id;?>"/>
        <input type="hidden" name="action" value="scfp-form-submit"/>
        <?php 
        foreach( $fieldsSettings as $key => $field ): 
            if (!empty($field['visibility']) && !empty($field['field_type'])) :
                echo SCFP()->getTemplate("form/{$field['field_type']}", array('id' => $id, 'form' => $form, 'key' => $key, 'field' => $field, 'formSettings' => $formSettings, 'formData' => $formData));
            endif;
        endforeach;
        ?>
        <div class="scfp-form-action scfp-form-button-position-<?php echo $button_position;?>">
            <input class="scfp-form-submit" type="submit" value="<?php echo $formSettings['button_name']?>">
        </div>        
    </form>
</div>
