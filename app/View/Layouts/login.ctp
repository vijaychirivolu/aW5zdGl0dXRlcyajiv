<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>INSPINIA | Login 2</title>
        <?php 
            echo $this->Html->css('bootstrap.min');
            echo $this->Html->css('/font-awesome/css/font-awesome');
            echo $this->Html->css('animate');
            echo $this->Html->css('style');
        ?>
    </head>

    <body class="gray-bg">
        <div class="row">
                <div class="col-md-12">
                    <?php echo $this->Session->flash(); ?>
                </div>
            </div>
        <div class="loginColumns animated fadeInDown">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="font-bold">Welcome to IN+</h2>

                    <p>
                        Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                    </p>

                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                    </p>

                    <p>
                        When an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    </p>

                    <p>
                        <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
                    </p>

                </div>
                
                <?php echo $this->fetch('content'); ?>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    Copyright Example Company
                </div>
                <div class="col-md-6 text-right">
                    <small>© <?php echo date("Y");?></small>
                </div>
            </div>
        </div>

    </body>

</html>