<div class="c4d-woo-category">
	
		<div id="<?php echo esc_attr($uid); ?>">
			<?php foreach ($items as $key => $item): ?>
				<div class="item">
					<a href="<?php echo esc_url($item->permalink); ?>">
						<div class="icon"><?php echo $item->content; ?></div>
						<h3 class="title"><?php echo $item->title; ?></h3>
						<div class="count">
							<?php echo sprintf( _n( '%s item', '%s items', $item->count, 'c4d-woo-cate-carousel' ), $item->count ); ?>
						</div>
					</a>
				</div>		
			<?php endforeach; ?>
		</div>
	</div>
</div>