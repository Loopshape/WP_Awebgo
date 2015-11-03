<?php
$obj = !empty($params['obj']) ? $params['obj'] : NULL;
$post_id = !empty($params['post_id']) ? $params['post_id'] : NULL;

if ( !empty($obj) && !empty($post_id) ) :

    $data = SCFP()->getSettings()->getFieldsSettings();
    $id = $obj->getId();
    $index = uniqid();
    $num = 1;
?>
<div class="agp-repeater" id="agp-repeater-<?php echo $id?>" data-id="<?php echo $id?>">
    <div class="scfp-settings-table-mobile-scroll">
        <div class="scfp-settings-table" id="scfp-sortable">
            <div class="scfp-settings-table-header">
                <?php echo $obj->getHeaderTemplateAdmin(); ?>
            </div>        

            <div class="scfp-settings-table-list">
                <?php
                if (!empty($data)):
                    foreach ($data as $key => $value) :
                        $rowClass = !empty($value['no_delete']) ? ' alternate' : '';
                ?>
                    <div class="agp-row<?php echo $rowClass?> scfp-field-row">
                        <?php echo $obj->getRowTemplateAdmin(array('id' => $id, 'row' => $key, 'data' => $value, 'num' => $num )); ?>
                    </div>
                <?php
                    $num++; endforeach;
                else:
                ?>
                    <div class="agp-row scfp-field-row">                    
                        <?php echo $obj->getRowTemplateAdmin(array('id' => $id, 'row' => $index, 'num' => $num)); ?>
                    </div>
                <?php
                endif; 
                ?>
                <div class="agp-row agp-row-template scfp-field-row" style="display: none;">
                    <?php echo $obj->getRowTemplateAdmin(array('id' => $id, 'row' => 0, 'data' => $data, 'num' => 0)); ?>                    
                </div>
            </div>
        </div>
    </div>
    <div class="agp-actions">
        <a class="button agp-add-row" href="javascript:void(0);">Add New</a>
    </div>    
</div>
<?php
endif;