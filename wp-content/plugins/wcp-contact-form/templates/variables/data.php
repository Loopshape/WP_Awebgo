<?php
    $post_id = $params;
    $data = SCFP()->getSettings()->getFieldsSettings();
?>
<table width="100%" style="border: 1px solid #dfdfdf; border-collapse: collapse;">
    <?php $i=0; foreach( $data as $datakey => $datavalue ): ?>
        <?php if ( !empty( $datavalue['visibility'] ) && $datavalue['field_type'] !== 'captcha' && $datavalue['field_type'] !== 'captcha-recaptcha' ) : ?>
            <tr<?php echo (($i % 2 == 0)) ? ' style="background: #f5f5f5;"' : ''; ?>>
                <td style="padding: 10px 5px; border: 1px solid #dfdfdf; width: 15%;">
                    <strong><?php echo $datavalue['name']; ?></strong>
                </td>
                <td style="padding: 10px 5px; border: 1px solid #dfdfdf; width: 85%;">
                    <?php
                        if( $datavalue['field_type'] == 'checkbox' ){
                            $data = get_post_meta( $post_id, 'scfp_'.$datakey, true ); 
                            $value = !empty( $data )? 'Yes' : 'No'; 
                        }
                        else{
                            $value = get_post_meta( $post_id, 'scfp_'.$datakey, true );
                        }
                        echo !empty($value) ? $value : '&nbsp;';
                    ?>
                </td>
            </tr>
        <?php endif;?>
    <?php $i++; endforeach; ?>
</table>