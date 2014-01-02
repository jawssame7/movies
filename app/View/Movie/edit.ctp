<div class="row">
    <h3 class="lead"><?php echo LABEL_MOVIE . LABEL_EDIT ?></h3>
    <div class="row">
        <?php echo $this->Form->create('Movie'); ?>
        <?php echo $this->element('movie/input', ['type' => 'edit']); ?>
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
<?php echo $this->Html->script('movie/edit'); ?>