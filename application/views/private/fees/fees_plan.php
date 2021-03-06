<?php
/**
 * Created by PhpStorm.
 * User: Akshat
 * Date: 7/21/2017
 * Time: 10:55 PM
 */?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <p style="font-size: 20px;" class="text-info">Fees Plan</p>
            <?php echo form_open('fees/fees_plan', ['class' => 'form-horizontal']); ?>
            <div class="form-group">
                <label for="inputText" class="col-lg-3 control-label">Fees Heading</label>
                <div class="col-lg-9">
                <?php
                $drop=array();
                foreach($fhl as $r){
                    $drop[$r['fees_heading']]=$r['fees_heading'];
                }
                $attribute_class = [
                    'class' => 'form-control',
                    'id' => 'select',
                ];
                echo form_dropdown('fees_heading', $drop,'', $attribute_class);
                ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputText" class="col-lg-3 control-label">Value</label>
                <div class="col-lg-9">
                    <?php echo form_input(['name' => 'fees_value', 'class' => 'form-control',
                        'placeholder' => 'Enter Fees Value',
                        'value' => set_value('fees_value')]);
                    ?>
                    <?php echo form_error('fees_value'); ?>
                </div>
            </div>

            <div class="col-lg-6">
                <?php
                echo '<p class="text-info" style="font-size: 17px;">Category</p>'.'<br>';
                $drop=array();
                foreach($category as $r){
                    $drop[$r['category_name']]=$r['category_name'];
                }
                $ara=$drop;
                if(!empty($ara)){
                    foreach ($ara as $hb){
                        $checked = (in_array($hb,$ara))?'':'';
                ?>
                        <input type="checkbox" name="hb[]" value="<?php echo $hb?>" size="17" <?php echo $checked;
                        ?>><?php echo $hb.'<br>'; ?>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-lg-6">
                <?php
                echo '<p class="text-info" style="font-size: 17px;">Class</p>'.'<br>';
                $drop=array();
                foreach($class as $r){
                    $drop[$r['class']]=$r['class'];
                }
                $ara=$drop;

                if(!empty($ara)){
                    foreach ($ara as $hb){
                        $checked = (in_array($hb,$ara))?'':'';
                        ?>
                        <input type="checkbox" name="hb[]" value="<?php echo $hb?>" size="17" <?php echo $checked;
                        ?>><?php echo $hb.'<br>'; ?>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-lg-6">
            <table class="table table-hover ">
                <thead>
                <tr class="info">
                    <th>Class</th>
                    <th>Category</th>
                    <th>Fees Head</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
    <?php echo form_submit(['name' => 'submit', 'value' => 'Save', 'class' => 'btn btn-info',
        'style' => 'margin-top:20px;']) ?>
    </div>
</div>
