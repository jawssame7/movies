<div class="row">
    <div class="twelve columns">
        <div class="eight columns centered">
            <video id="player" class="video-js vjs-default-skin"
                   controls preload="auto" width="640" height="264"
                   poster=""
                   data-setup='{"example_option":true}'>
                <source src="<?php echo $this->Html->url('../app/webroot/movies/', true).$movie['Movie']['file_name'] ?>" type="video/mp4"/>
            </video>
        </div>
    </div>
</div>
<div class="row">
    <div class="twelve columns">
        <table id="play-info">
            <tbody>
                <tr>
                    <td colspan="2"><?php echo $movie['Movie']['title'] ?></td>
                </tr>
                <tr>
                    <td><?php echo LABEL_CAST ?></td>
                    <td><?php echo $movie['Movie']['cast'] ?></td>
                </tr>
                <tr>
                    <td><?php echo LABEL_TAG ?></td>
                    <td><?php echo $movie['Movie']['tag'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>