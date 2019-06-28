<?php
$theme_color = dsk_themeoption('theme_color', '#f89b72');

// Get page meta data
if (function_exists('rwmb_meta') && rwmb_meta('dsk_page_themecolor') == 1) {
	$theme_color = rwmb_meta('dsk_theme_color') != '' ? rwmb_meta('dsk_theme_color') : $theme_color;
}

$theme_color = str_replace('#', '', $theme_color);
$stickymenu = dsk_themeoption('use_stickmenu');

?>
<div id="sns_cpanel">
    <div class="cpanel-head">
    	<a class="button btn-buy" href="#" title="<?php echo esc_attr__('Buy Theme Now', 'dsk'); ?>"><?php echo esc_html__('Buy Theme Now', 'dsk'); ?></a>
    </div>
    <div class="cpanel-set">
    	<div class="form-group">
		<?php
		$scss_compile = dsk_themeoption('advance_scss_compile');
		?>
		<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo esc_html__('Always Compile SCSS', 'dsk'); ?></label>
				<div class="content scss_compile">
					<a class="<?php echo (esc_attr($scss_compile) == 2)?'active menu':'menu'; ?>" href="#" data-scsscompile="2">Yes</a>
					<a class="<?php echo (esc_attr($scss_compile) == 1)?'active menu':'menu'; ?>" href="#" data-scsscompile="1">No</a>
					<input type="hidden" name="scss_compile" value="<?php echo esc_attr($scss_compile); ?>"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo esc_html__('Enable sticky menu', 'dsk'); ?></label>
				<div class="content sticky_menu">
					<a class="<?php echo (esc_attr($stickymenu) == 1)?'active menu':'menu'; ?>" href="#" data-sticky="1">Yes</a>
					<a class="<?php echo (esc_attr($stickymenu) == 0)?'active menu':'menu'; ?>" href="#" data-sticky="0">No</a>
					<input type="hidden" name="sticky_menu" value="<?php echo esc_attr($stickymenu); ?>"/>
				</div>
			</div>
		</div>
		
    </div>
    <div class="cpanel-bottom">
    	<div class="form-group">
			<div class="col-xs-12">
				<div class="button-action">
					<a class="button btn-reset" href="#" data-url="<?php echo site_url('/'); ?>"><?php echo esc_html__('Reset Options', 'dsk'); ?></a>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				<p><?php echo esc_html__('That is some options to demo for you.', 'dsk'); ?></p>
			</div>
		</div>
	</div>
    <div id="sns_cpanel_btn">
        <i class="fa fa-cog fa-spin"></i>
    </div>
</div>