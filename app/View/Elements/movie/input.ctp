<?php
    $btnName = isset($type) ? LABEL_EDIT : LABEL_ADD;
    $btnId = isset($type) ? 'edit' : 'add';
?>
<div class="twelve columns">
    <fieldset>
        <legend><?php echo LABEL_MOVIE . LABEL_INFO ?></legend>
        <ul>
            <li class="field">
                <?php echo $this->Form->input('id', ['id' => 'id', 'type' => 'hidden', 'div' => false, 'label' => false]); ?>
                <?php echo $this->Html->tag('label', LABEL_TITLE, ['class' => 'inline', 'for' => 'title']); ?>
                <?php echo $this->Form->input('title', ['id' => 'title', 'class' => 'wide text input', 'placeholder' => LABEL_TITLE, 'div' => false, 'label' => false]); ?>
            </li>
            <?php if (!isset($type)): ?>
            <li class="field">
                <?php echo $this->Html->tag('label', LABEL_FILE, ['class' => 'inline', 'for' => 'file']); ?>
                <?php echo $this->Form->file('file', ['id' => 'file', 'class' => 'wide text input', 'placeholder' => LABEL_FILE, 'div' => false, 'label' => false]); ?>
                <?php echo $this->Form->error('file'); ?>
            </li>
            <?php endif; ?>
            <li class=" field">
                <?php echo $this->Html->tag('label', LABEL_CAST, ['class' => 'inline cast', 'for' => 'cast']); ?>
                <?php echo $this->Form->input('cast', ['id' => 'cast', 'type' => 'text', 'class' => 'wide text input', 'placeholder' => LABEL_CAST . LABEL_COMMA_SEPARATE_ADD_MESSAGE, 'div' => false, 'label' => false]); ?>
                <div class="medium default btn"><a id="cast-menu" href="#" tabindex="-1">▼</a></div>
            </li>
            <li class=" field">
                <?php echo $this->Html->tag('label', LABEL_TAG, ['class' => 'inline tag', 'for' => 'tag']); ?>
                <?php echo $this->Form->input('tag', ['id' => 'tag', 'type' => 'text', 'class' => 'wide text input', 'placeholder' => LABEL_TAG . LABEL_COMMA_SEPARATE_ADD_MESSAGE, 'div' => false, 'label' => false]); ?>
                <div class="medium default btn"><a id="tag-menu" href="#" tabindex="-1">▼</a></div>
            </li>
        </ul>
    </fieldset>
    <div class="medium primary btn metro rounded ">
        <a id="<?php echo $btnId; ?>" href="javascript:void(0);"><?php echo $btnName; ?></a>
    </div>
</div>