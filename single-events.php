<?php
get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
		<div class="singleEventContent">

			<?php
			while ( have_posts() ) :
				the_post();
				$category = rwmb_meta('category');
			?>

			<h1><?php echo rwmb_meta('title'); ?></h1>
			<?php if(rwmb_meta('category') != ''): ?>
				<span><strong>Categoria: </strong><?php echo $category->name;?><span>
			<?php endif; ?>
			<img class="eventFeaturedImage" src="<?php echo rwmb_meta('featuredimage') ?>">
			<p><?php echo rwmb_meta('description'); ?></p>
			<?php
			/*
			The goal of the code below is to minimaze the options of 
			date phrases for in each type of event (All Day Event, with Recurrence or not)
			*/


			if(rwmb_meta('allday') == '1') {
				$text = '';
				$text2 = '';
				$allday = '<strong>This is an all day event.</strong>';
				$start = '';
				$end = '';
			} else {
				$text = 'From ';
				$text2 = ' to ';
				$allday = '';
				$start = ', ' . date('H:i', strtotime(rwmb_meta('start')));
				if(date('D M Y', strtotime(rwmb_meta('start'))) == date('D M Y', strtotime(rwmb_meta('end')))) {
					$end = date('H:i', strtotime(rwmb_meta('end')));
				} else {
					$end = date('M d, Y, H:i', strtotime(rwmb_meta('end')));
				}
			}

			if(rwmb_meta('recurrence') == 'None') {
				echo '<li>' . $text . date('M d, Y', strtotime(rwmb_meta('start'))) . $start . $text2 . $end . ' ' . $allday . '</li>';
			}
			if(rwmb_meta('recurrence') == 'Daily') {
				echo '<li>' . $text . date('M d, Y', strtotime(rwmb_meta('start'))) . $start . $text2 . $end . '. Every day. ' . $allday . '</li>';
			}
			if(rwmb_meta('recurrence') == 'Monthly') {
				echo '<li>' . $text . date('M d, Y', strtotime(rwmb_meta('start'))) . $start . $text2 . $end . '. Every month.' . $allday . '</li>';
			}
			if(rwmb_meta('recurrence') == 'Yearly') {
				echo '<li>' . $text . date('M d, Y', strtotime(rwmb_meta('start'))) . $start . $text2 . $end . '. Every year.' . $allday . '</li>';
			}
			?>
			
			<?php if(rwmb_meta('costs') != ''): ?>
			<li><strong>Costs/Entrance Fee:</strong> $<?php echo rwmb_meta('costs'); ?></li>
			<?php 
			endif;
			if(rwmb_meta('address') != ''): ?>
				<li><strong>Address:</strong> <?php echo rwmb_meta('address'); ?></li>
			<?php 
			endif;
			if(rwmb_meta('externallink') != ''): ?>
				<li><strong><a href="<?php echo rwmb_meta('externallink'); ?>">Check more infos</a></strong></li>
			<?php endif;?>
			<?php
			endwhile;
			?>

		</div>

		</main>
	</section>

<?php
get_footer();
