<?php
/**
 * Created by PhpStorm.
 * User: Akshat
 * Date: 7/16/2017
 * Time: 1:04 PM
 */?>
<div class="container">
    <div class="row">
        <p style="font-size: 20px; margin-top:0px;" class="text-info">Enter Class to be Added</p>
    <div class="col-lg-4">
        <?php echo form_open('admin/masters_class', ['class' => 'form-horizontal']); ?>
        <div class="form-group">
            <label for="inputText" class="col-lg-2 control-label">Class</label>
            <div class="col-lg-10">
                <?php echo form_input(['name' => 'class', 'class' => 'form-control',
                    'placeholder' => 'Enter Class',
                    'value' => set_value('class')]);
                ?>
                <?php echo form_error('class'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputText" class="col-lg-2 control-label">Prefix</label>
            <div class="col-lg-10">
                <?php echo form_input(['name' => 'prefix', 'class' => 'form-control',
                    'placeholder' => 'Enter Prefix',
                    'value' => set_value('prefix')]);
                ?>

            </div>
        </div>
        <div class="form-group">
            <label for="inputText" class="col-lg-2 control-label">Start From</label>
            <div class="col-lg-10">
                <input type="date" class="form-control" name="start_from">
            </div>
        </div>
        <div class="form-group">
            <label for="inputText" class="col-lg-2 control-label">Incharge</label>
            <div class="col-lg-10">
                <?php echo form_input(['name' => 'incharge', 'class' => 'form-control',
                    'placeholder' => 'Enter Incharge',
                    'value' => set_value('incharge')]);
                ?>

            </div>
        </div>
        <?php echo form_submit(['name' => 'submit', 'value' => 'Save', 'class' => 'btn btn-info',
            'style' => 'margin-left:45px; margin-top:20px;']),
        form_reset(['name' => 'reset', 'value' => 'reset', 'class' => 'btn btn-warning',
            'style' => 'margin-top:20px;']); ?>
        <?php echo form_close();?>

        <p style="font-size: 20px; margin-top: 40px;" class="text-info">Enter Class to be deletd</p>
        <?php echo form_open('admin/masters_class_del', ['class' => 'form-horizontal']); ?>
        <div class="form-group">
            <label for="inputText" class="col-lg-2 control-label">Class</label>
            <div class="col-lg-10">
            <?php  echo form_input(['name' => 'class_delete', 'class' => 'form-control',
                    'placeholder' => 'Enter Class to be deleted',
                    'value' => set_value('class_delete')]);
                ?>
            <?php echo form_error('class_delete'); ?>
            </div>
            <input type="submit" name="del_class" class="btn btn-danger" value="DELETE" style="margin-left: 50px; margin-top: 20px;">
                <?php  form_close(); ?>
        </div>

    </div>


        <div class="col-lg-8">
            <table class="table table-hover ">
                <thead>
                <tr class="info">
                    <th>Class</th>
                    <th>Prefix</th>
                    <th>Start from</th>
                    <th>Incharge</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($det_class)): ?>
                    <?php foreach($det_class as $class_det): ?>
                        <tr class="success">
                            <td><?php echo $class_det->class?></td>
                            <td><?php echo $class_det->prefix?></td>
                            <td><?php echo $class_det->start_from?></td>
                            <td><?php echo $class_det->incharge ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td>No Records Found</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>








