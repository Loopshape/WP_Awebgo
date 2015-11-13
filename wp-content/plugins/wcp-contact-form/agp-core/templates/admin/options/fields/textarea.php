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
    
    $value = esc_attr($args->data[$args->field]);
?>
<tr>
    <th scope="row"><?php echo $label;?></th>
    <td>
        <textarea <?php echo $atts;?> rows="6" <?php echo !empty($class) ? ' class="'.$class.'"': '';?> id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>"><?php echo $value;?></textarea>        
        <?php if (!empty($note)): ?><p class="description"><?php echo $note;?></p><?php endif;?>
    </td>
</tr>    
