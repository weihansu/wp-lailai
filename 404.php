<?php 
get_header();
?>
<div id="sns_content" class="is-notfound">
	<div class="container sns-notfound-page">
		<div class="sns-notfound-content">
            <?php $bg_404 = dsk_getoption('bg_404', DSK_THEME_URI.'/assets/img/404.png', 'image'); ?>
            <img src="<?php echo esc_attr($bg_404); ?>" alt="<?php echo dsk_themeoption('notfound_title', esc_attr__('Opps! This Page Could Not Be Found!', 'dsk')); ?>"/>
            <h1 class="notfound-title">
                <?php echo dsk_themeoption('notfound_title', esc_html__('Opps! This Page Could Not Be Found!', 'dsk')); ?>
            </h1>
            <p>
            	<?php echo dsk_themeoption('notfound_content', esc_html__('Sorry bit the page you are looking for does not exist, have been removed or name changed', 'dsk')); ?>
            </p>
            <div class="home-back">
                <a class="btn btn-home" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr__('Return to the Home page', 'dsk'); ?>">
                    <?php echo esc_html__('Return to the Home page', 'dsk'); ?>
                </a>
            </div>
        </div>
	</div>
</div>
<?php get_footer(); ?>