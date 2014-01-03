<?php
    $idx = 0;
    $count = 0;
?>
<div class="row">
    <h3 class="lead"><?php echo LABEL_MOVIE . LABEL_LIST ?></h3>
    <div class="row">
        <div class="twelve columns">
            <?php echo $this->Form->create(); ?>
                <fieldset>
                    <legend><?php echo LABEL_SEARCH . LABEL_FORM ?></legend>
                    <ul>
                        <li class="field">
                            <?php echo $this->Html->tag('label', LABEL_TITLE, ['class' => 'inline', 'for' => 'title']); ?>
                            <?php echo $this->Form->input('title', ['id' => 'title', 'class' => 'wide text input', 'placeholder' => 'あいまい検索', 'div' => false, 'label' => false]); ?>
                        </li>
                        <li class="field">
                            <?php echo $this->Html->tag('label', LABEL_CAST. '&emsp;&emsp;&emsp;&emsp;&emsp;', ['class' => 'inline', 'for' => 'cast']); ?>
                            <?php echo $this->Form->input('cast', ['id' => 'cast', 'class' => 'wide text input', 'placeholder' => LABEL_COMMA_SEPARATE_SEARCH_MESSAGE, 'div' => false, 'label' => false]); ?>
                        </li>
                        <li class="field">
                            <?php echo $this->Html->tag('label', LABEL_TAG . '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;', ['class' => 'inline', 'for' => 'tag']); ?>
                            <?php echo $this->Form->input('tag', ['id' => 'tag', 'class' => 'wide text input', 'placeholder' => LABEL_COMMA_SEPARATE_SEARCH_MESSAGE, 'div' => false, 'label' => false]); ?>
                        </li>
                    </ul>
                </fieldset>
                <div class="medium primary btn metro rounded ">
                    <a id="search" href="#"><?php echo LABEL_SEARCH ?></a>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <table class="striped rounded">
                <colgroup>
                    <col width="50%">
                    <col width="15%">
                    <col width="10%">
                    <col width="30%">
                </colgroup>
                <thead>
                    <tr>
                        <th><?php echo LABEL_TITLE ?></th>
                        <th><?php echo LABEL_CAST ?></th>
                        <th><?php echo LABEL_TAG ?></th>
                        <th><?php echo LABEL_CONTROL ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($movies as $movie): ?>
                        <tr>
                            <td><?php echo $this->Html->link($movie['Movie']['title'], ['controller' => 'movie', 'action' => 'play', $movie['Movie']['id']]); ?></td>
                            <td>
                                <?php echo $movie['Movie']['cast'] ?>
                            </td>
                            <td>
                                <?php echo $movie['Movie']['tag'] ?>
                            </td>
                            <td>
                                <div class="btn success medium metro rounded td-btn">
                                    <?php echo $this->Html->link(LABEL_EDIT, ['controller' => 'movie', 'action' => 'edit', $movie['Movie']['id']]); ?>
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
<?php echo $this->Html->script('indexBase'); ?>
<?php echo $this->Html->script('movie/index'); ?>