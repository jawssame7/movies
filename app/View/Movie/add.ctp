<div class="row">
    <h3 class="lead"><?php echo LABEL_MOVIE . LABEL_ADD ?></h3>
    <div class="row">
        <?php echo $this->Form->create(null, ['type' => 'file']); ?>
            <?php echo $this->element('movie/input'); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script id="casts" type="text/template">
    <?php echo json_encode($casts); ?>
</script>
<script id="tags" type="text/template">
    <?php echo json_encode($tags); ?>
</script>
<?php echo $this->Html->script('movie/base'); ?>
<?php echo $this->Html->script('movie/add'); ?>