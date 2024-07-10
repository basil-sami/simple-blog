<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content" class="row">
   
    <div class="col-md-3 sidebar">
        <div class="sticky-top">
            
            <!-- You can add more sidebar content as needed -->
            <div id="real-time-blog-posts">
                <!-- Real-time blog posts will be loaded here -->
            </div>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="col-md-9">
        <?php echo $content; ?>
    </div>
</div><!-- content -->

<?php $this->endContent(); ?>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function() {
        fetchRealTimeBlogPosts(); // Call function initially

        function fetchRealTimeBlogPosts() {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("blogPost/realTimeBlogPosts"); ?>',
                type: 'GET',
                success: function(response) {
                    $('#real-time-blog-posts').html(response); // Update content inside #real-time-blog-posts
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching real-time blog posts:', error);
                }
            });

            setTimeout(fetchRealTimeBlogPosts, 5000); // Fetch every 5 seconds (adjust as needed)
        }
    });
</script>

<style>
    /* Adjustments for sidebar and real-time blog posts */
    .sidebar {
        background-color: #f0f0f0;
        padding: 20px;
        min-height: 100vh; /* Ensure sidebar takes full height of viewport */
    }

    #real-time-blog-posts {
        margin-top: 20px; /* Adjust margin as needed */
    }
</style>
