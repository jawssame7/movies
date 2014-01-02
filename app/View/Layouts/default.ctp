<?php
    $title_for_layout = '動画'
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');
    echo $this->fetch('meta');
    echo $this->Html->script('/bower_components/gumby/js/libs/modernizr-2.6.2.min');
    echo $this->Html->script('/bower_components/gumby/js/libs/jquery-1.10.1.min');
    echo $this->Html->script('/bower_components/jquery.ui/ui/jquery.ui.core');
    echo $this->Html->script('/bower_components/jquery.ui/ui/jquery.ui.widget');
    echo $this->Html->script('/bower_components/jquery.ui/ui/jquery.ui.position');
    echo $this->Html->script('/bower_components/jquery.ui/ui/jquery.ui.menu');
    echo $this->Html->script('/bower_components/jquery.ui/ui/jquery.ui.autocomplete');
    //echo $this->Html->script('/bower_components/gumby/js/libs/gumby.min');
    echo $this->Html->script('/bower_components/gumby/js/libs/gumby', ['gumby-touch' => 'js/libs', 'gumby-debug' => '']);
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.retina');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.fixed');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.skiplink');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.toggleswitch');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.checkbox');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.radiobtn');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.tabs');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/gumby.navbar');
    echo $this->Html->script('/bower_components/gumby/js/libs/ui/jquery.validation');
    echo $this->Html->script('/bower_components/gumby/js/libs/gumby.init');
    echo $this->Html->css('style');
    ?>
</head>
    <body id="<?php echo $this->fetch('id'); ?>" class="grid">
        <nav id="navbar-main-nav" class="navbar">
            <div class="row">
                <h1 id="top-logo" class="three columns logo">
                    <a href="<?php echo $this->Html->url('/', true); ?>" >
                        <?php echo $this->Html->image('logo.png', array('alt' => 'logo')); ?>
                    </a>
                </h1>
                <nav class="three columns push_six">
                    <ul id="main-nav">
                        <li>
                            <a href="<?php echo $this->Html->url('/movie/', true); ?>"><span>動画</span><i class="icon-doc-text" title="Documentation"></i></a>
                            <div class="dropdown">
                                <ul>
                                    <li><?php echo $this->Html->link('動画一覧', ['controller' => 'movie', 'action' => 'index']);?></li>
                                    <li><?php echo $this->Html->link('動画追加', ['controller' => 'movie', 'action' => 'add']);?></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/', true); ?>">
                                <span>管理</span><i class="icon-cog" title="Customize"></i>
                            </a>
                            <div class="dropdown">
                                <ul>
                                    <li><?php echo $this->Html->link('女優', ['controller' => 'cast', 'action' => 'index']);?></li>
                                    <li><?php echo $this->Html->link('タグ', ['controller' => 'tag', 'action' => 'index']);?></li>
                                </ul>
                            </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
        <div class="row">
            <div class="twelve columns">


                    <?php echo $this->Session->flash(); ?>


            </div>
        </div>
        <?php echo $this->fetch('content'); ?>

        <?php  echo $this->element('sql_dump'); ?>

    </body>
</html>
