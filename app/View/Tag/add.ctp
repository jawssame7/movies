<div class="row">
    <h3 class="lead"><?php echo LABEL_TAG.LABEL_ADD ?></h3>
    <div class="row">
        <?php echo $this->Form->create('Tag'); ?>
            <?php echo $this->element('tag/input'); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php echo $this->Html->script('tag/add'); ?>