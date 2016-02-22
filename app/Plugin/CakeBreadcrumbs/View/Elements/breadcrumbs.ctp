<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $heading;?></h2>
        <ol class="breadcrumb" id="breadcrumbs">
            <?php foreach($breadcrumbs[$scope] as $title => $link): ?>
                <?php if(!empty($link)): ?>
                    <?php echo '<li>'.$this->Html->link($title, $link).'</li>'; ?>
                <?php else: ?>
                    <?php echo '<li class="active"><strong>'.$title.'</strong></li>' ?>
                <?php endif ?>
            <?php endforeach ?>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
