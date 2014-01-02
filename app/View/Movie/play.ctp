<div class="row">
    <div class="twelve columns">
        <video preload="auto" controls="" autoplay=""  name="media">
            <source src="<?php echo $this->Html->url('../app/webroot/movies/', true).$movie['Movie']['file_name'] ?>" type="video/mp4">
        </video>
    </div>
</div>
<div class="row">
    <div class="twelve columns">
        <table>
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