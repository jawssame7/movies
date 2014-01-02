<div id="modal-confirm" class="modal">
    <div class="content flash-success">
        <a class="close switch active" gumby-trigger="|#modal-confirm"><i class="icon-cancel"></i></a>
        <div class="row">
            <div class="ten columns centered text-center">
                <h3 class="title"><?php echo isset($page_title) ? $page_title : ''; ?></h3>
                <p class="confirm-message"><?php echo isset($message) ? $message : ''; ?></p>
                <div class="medium primary btn  metro rounded">
                    <a class="active ok" href="javascript:void(0);" data-base-url="<?php echo $this->Html->url('delete', true); ?>"><?php echo LABEL_YES ?></a>
                </div>
                <div class="medium primary btn  metro rounded">
                    <a class="close switch active" href="javascript:void(0);" gumby-trigger="|#modal-confirm"><?php echo LABEL_NO ?></a>
                </div>
            </div>
        </div>
    </div>
</div>