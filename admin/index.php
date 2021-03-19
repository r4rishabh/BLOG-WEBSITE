<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

      <?php
  
     
      ?>


        
     

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            WELCOME TO ADMIN <?php echo strtoupper(get_user_name());?>


                             
                        </h1>

                        
                    </div>
                </div>
                <!-- /.row -->



                        
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">


                    <?php
                    
                    $post_counts = count_records(get_user_post());

                    echo "<div class='huge'>{$post_counts}</div>";
                    ?>



                    <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                     <?php
                    
                    
                    $comments_counts = count_records(get_user_comment());

                    echo "<div class='huge'>{$comments_counts}</div>";
                    ?>

            

                  <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
       <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">


                     <?php
                    
                    
                    $category_counts = count_records(get_user_category());

                    echo "<div class='huge'>{$category_counts}</div>";
                    ?>





                <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->

                <?php


                  
                    $post_published_counts = count_records(get_user_published_post());


                    
                    $post_draft_counts = count_records(get_user_draft_post());

                   
                    $approved_comments_counts = count_records(get_user_appproved_comments());


                    $unapproved_comments_counts = count_records(get_user_unappproved_comments());
                   




                ?>

              


                <div class="row">

                   <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

          <?php

          $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Aprroved comments', 'Pending comments',  'Categories'];
          $element_count = [$post_counts, $post_published_counts, $post_draft_counts, $comments_counts, $approved_comments_counts, $unapproved_comments_counts,  $category_counts];

          for($i =0;$i < 7; $i++)
          {
            echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
          }

          ?>

          
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

       <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>



                    
    </div>






            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
