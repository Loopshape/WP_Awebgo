<?php
    $id = isset($params['id']) ? $params['id'] : NULL;
    if (!empty($id)) :
        $row = isset($params['row']) ? $params['row'] : 0;
        $num = isset($params['num']) ? $params['num'] : '';
        $data = !empty($params['data']) ? $params['data'] : NULL;
        $btnClass = empty($data['no_delete']) ? 'button agp-del-row' : 'button disabled';        
        $fieldTypes = SCFP()->getSettings()->getFieldSet('fieldTypes');
        
        if (empty($data['field_type'])) {
            $data['visibility'] = 1;
        }
        
        $selectedType = !empty($data['field_type']) ? $data['field_type'] : 'text';
        
?>
<div class="scfp-field scfp-field-num"><span class="priority scfp-order"><?php echo $num;?></span></div>
<div class="scfp-field scfp-field-type">
    <select class="widefat" id="<?php echo "{$id}_{$row}_field_type";?>" name="<?php echo "{$id}[field_settings][{$row}][field_type]";?>"<?php echo !empty($data['no_delete']) ? ' disabled="disabled" readonly="readonly"' : ''; ?> >
        <?php 
            foreach( $fieldTypes as $k => $v ):
                $selected = (trim($selectedType) === trim($k)); 
        ?>
                <option value="<?php echo $k; ?>"<?php selected( $selected );?>><?php echo $v;?></option>
        <?php 
            endforeach; 
        ?>
    </select>    
</div>
<div class="scfp-field scfp-field-name">
    <input class="widefat" type="text" value="<?php echo !empty($data['name']) && !is_array($data['name']) ? $data['name'] : '' ;?>" id="<?php echo "{$id}_{$row}_name";?>" name="<?php echo "{$id}[field_settings][{$row}][name]";?>" />    
</div>
<div class="scfp-field scfp-field-visibility">
    <input class="widefat" type="checkbox"<?php checked(!empty($data['visibility']) && !is_array($data['visibility'])); ?> id="<?php echo "{$id}_{$row}_visibility";?>" name="<?php echo "{$id}[field_settings][{$row}][visibility]";?>"<?php echo !empty($data['visibility_readonly']) ? ' disabled="disabled" readonly="readonly"' : ''; ?>/>    
</div>
<div class="scfp-field scfp-field-required">
    <input class="widefat" type="checkbox"<?php checked(!empty($data['required']) && !is_array($data['required'])); ?> id="<?php echo "{$id}_{$row}_required";?>" name="<?php echo "{$id}[field_settings][{$row}][required]";?>"<?php echo !empty($data['required_readonly']) ? ' disabled="disabled" readonly="readonly"' : ''; ?>/>    
</div>
<div class="scfp-field scfp-field-export">
    <input class="widefat" type="checkbox"<?php checked(!empty($data['exportCSV']) && !is_array($data['exportCSV'])); ?> id="<?php echo "{$id}_{$row}_exportCSV";?>" name="<?php echo "{$id}[field_settings][{$row}][exportCSV]";?>"<?php echo !empty($data['required_readonly']) ? ' disabled="disabled" readonly="readonly"' : ''; ?>/>    
</div>
<div class="scfp-field scfp-field-actions">    
<!--    <a class="button agp-settings-row" href="javascript:void(0);" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>    -->
    <a class="button agp-up-row" href="javascript:void(0);" title="Up"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
    <a class="button agp-down-row" href="javascript:void(0);" title="Down"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
    <a class="<?php echo $btnClass;?>" href="javascript:void(0);" title="Delete"><span class="dashicons dashicons-trash"></span></a>
</div>                
<?php 
    endif;
