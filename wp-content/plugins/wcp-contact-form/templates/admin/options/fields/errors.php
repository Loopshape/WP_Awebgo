<?php 
    $key = $_REQUEST['tab'];
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
    
    $data = SCFP()->getSettings()->getErrorsSettings();
    $settings = SCFP()->getSettings()->getErrorsConfig();
?>

<?php if (!empty($note)): ?><tr><p class="description"><?php echo $note;?></p></tr><?php endif;?>

<?php foreach( $settings as $error_config_key => $error_config_value): ?>
    <tr>
        <th scope="row"><?php echo $error_config_value['label']; ?></th>
        <td>
            <input class="widefat" type="text" name="<?php echo $key.'[errors][' . $error_config_key . ']'; ?>" value="<?php echo esc_attr( $data['errors'][$error_config_key] ); ?>"/>
            <?php if (!empty($error_config_value['note'])): ?><p class="description"><?php echo $error_config_value['note'];?></p><?php endif;?>
        </td>
    </tr>
<?php endforeach;
