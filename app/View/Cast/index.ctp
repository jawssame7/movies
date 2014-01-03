<?php
$idx = 0;
$count = 0;
?>
<div class="row">
    <h3 class="lead"><?php echo LABEL_CAST.LABEL_LIST ?></h3>
    <div class="row">
        <div class="twelve columns">
            <?php echo $this->Form->create('Cast'); ?>
                <fieldset>
                    <legend><?php echo LABEL_SEARCH.LABEL_SEARCH ?></legend>
                    <ul>
                        <li class="field">
                            <?php echo $this->Html->tag('label', LABEL_NAME, ['class' => 'inline', 'for' => 'name']); ?>
                            <?php echo $this->Form->input('name', ['id' => 'name', 'class' => 'wide text input', 'placeholder' => LABEL_CAST, 'div' => false, 'label' => false]); ?>
                        </li>
                    </ul>
                </fieldset>
                <div class="medium primary btn metro rounded ">
                    <a id="search" href="#"><?php echo LABEL_SEARCH ?></a>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    <div class="row btn-group">
        <div class="twelve columns">
            <div class="btn metro rounded secondary medium pull_right">
                <?php echo $this->Html->link(LABEL_ADD, ['controller' => 'cast', 'action' => 'add']); ?>
            </div>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <table class="striped rounded">
                <colgroup>
                    <col width="5%">
                    <col width="50%">
                    <col width="50%">
                </colgroup>
                <thead>
                <tr>
                    <th><?php echo LABEL_ID ?></th>
                    <th><?php echo LABEL_NAME ?></th>
                    <th><?php echo LABEL_CONTROL ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($casts as $cast): ?>
                    <tr>
                        <td><?php echo $cast['Cast']['id']; ?></td>
                        <td><?php echo $cast['Cast']['name']; ?></td>
                        <td>
                            &emsp;
                            <div class="btn success medium metro rounded ">
                                <?php echo $this->Html->link(LABEL_EDIT, ['controller' => 'cast', 'action' => 'edit', $cast['Cast']['id']]); ?>
                            </div>
                            &emsp;
                            <div class="btn danger medium metro rounded ">

                                <?php echo $this->Html->link(LABEL_DELETE, ['controller' => 'cast', 'action' => 'delete', $cast['Cast']['id']], ['class' => 'switch', 'gumby-trigger' => '#modal-confirm', 'data-id' => $cast['Cast']['id']]); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <?php
            echo $this->Paginator->prev(LABEL_PREV . __(''), ['tag' => 'div', 'class' => 'medium btn pill-left default'], null, ['tag' => 'div', 'class' => 'medium btn pill-left default disabled']);
            ?>
            <?php
            echo $this->Paginator->numbers(['tag' => 'div', 'separator' => false, 'class' => 'medium default btn', 'currentClass' => 'medium default btn primary', 'currentTag' => 'span']);
            ?>
            <?php
            echo $this->Paginator->next(LABEL_NEXT . __(''), ['tag' => 'div', 'class' => 'medium btn pill-right default'], null, ['tag' => 'div', 'class' => 'medium btn pill-right default disabled']);
            ?>
        </div>
    </div>
</div>
<?php echo $this->element('delete_modal', ['page_title' => LABEL_DELETE.LABEL_CONFIRM, 'message' => LABEL_DELETE.LABEL_CONFIRM_MESSAGE]); ?>
<?php echo $this->Html->script('indexBase'); ?>
<?php echo $this->Html->script('cast/index'); ?>