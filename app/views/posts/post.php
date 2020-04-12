
<?php require_once APPROOT.'/views/inc/header.php';?>
<?php flash('post_message');?>
<div class ="row">
    <div class = "col-md-6">
        <h1>Posts</h1>
</div>  
<div class = "col-md-6">
    <a href="<?php echo URLROOT;?>/posts/add" class="btn btn-primary pull-right">
<i class ="fa fa-pencil"></i>Add post</a>
</div>  
</div> 
<?php foreach ($data['posts'] as $posts): ?>
<div class = "card card-body mb-3 pd-2">
    <h4 class="card-title"><?php echo $posts->title ;?></h4>
    <div class="bg-light pd-2 mb-3">Written by :<?php echo  $posts->USER .'<br>'.  $posts->created_date ?> </div>
    <p class="card-text"><?php echo $posts ->BODY;?></p>
    <a href ="<?php echo URLROOT;?>/posts/showPost/<?php echo  $posts->PostId;?>" class ="btn btn-dark">More</a>
</div>   
<?php  endforeach;?>
<?php require_once APPROOT.'/views/inc/footer.php';?>