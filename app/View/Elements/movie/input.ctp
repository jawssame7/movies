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
                <div class="error-message hide title"></div>
            </li>
            <?php if (!isset($type)): ?>
            <li class="field">
                <?php echo $this->Html->tag('label', LABEL_FILE, ['class' => 'inline', 'for' => 'file']); ?>
<!--                --><?php //echo $this->Form->file('file', ['id' => 'fileupload', 'class' => 'wide text input', 'placeholder' => LABEL_FILE, 'div' => false, 'label' => false]); ?>
                <span class="medium success btn metro rounded fileinput-button">
                    <i class="icon-plus"></i>
                    <span>ファイルを追加...</span>
                    <input type="file" id="fileupload" name="file" >
                </span>
                <span class="default label filename">選択されていません</span>
                <div class="error-message hide file"></div>
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
    <div class="row">
        <div id="progress" class="progress">
            <div id="progress-bar" class="progress-bar progress-bar-success"></div>
        </div>
    </div>
    <div class="row spacer">
        <div class="medium primary btn metro rounded ">
            <a id="<?php echo $btnId; ?>" href="javascript:void(0);"><?php echo $btnName; ?></a>
        </div>
    </div>
</div>