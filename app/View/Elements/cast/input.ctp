<?php
$btnName = isset($type) ? LABEL_EDIT : LABEL_ADD;
$btnId = isset($type) ? 'edit' : 'add';
?>
<div class="twelve columns">
    <fieldset>
        <legend><?php echo LABEL_CAST.LABEL_INFO ?></legend>
        <ul>
            <li class="field">
                <?php echo $this->Form->input('id', ['id' => 'id', 'type' => 'hidden', 'div' => false, 'label' => false]); ?>
                <?php echo $this->Html->tag('label', LABEL_NAME, ['class' => 'inline', 'for' => 'name']); ?>
                <?php echo $this->Form->input('name', ['id' => 'name', 'class' => 'wide text input', 'placeholder' => LABEL_NAME, 'div' => false, 'label' => false]); ?>
            </li>
        </ul>
    </fieldset>
    <div class="medium primary btn metro rounded ">
        <a id="<?php echo $btnId; ?>" href="javascript:void(0);"><?php echo $btnName; ?></a>
    </div>
</div>