<div class="row">
    <h3 class="lead"><?php echo LABEL_CAST.LABEL_EDIT; ?></h3>
    <div class="row">
        <?php echo $this->Form->create('Cast'); ?>
        <?php echo $this->element('cast/input', ['type' => 'edit']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php echo $this->Html->script('cast/edit'); ?>