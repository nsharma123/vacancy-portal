				</div>
			</main>
			<!-- MAIN : end -->

			<?php if ( lsvr_townpress_has_page_sidebar_left() || lsvr_townpress_has_page_sidebar_right() ) : ?>

					</div>

				<?php if ( lsvr_townpress_has_page_sidebar_left() && lsvr_townpress_has_page_sidebar_right() ) : ?>
					<div class="columns__sidebar columns__sidebar--left lsvr-grid__col lsvr-grid__col--span-3 lsvr-grid__col--pull-6">

						<?php // Left sidebar
						get_sidebar(); ?>

					</div>
				<?php elseif ( lsvr_townpress_has_page_sidebar_left() ) : ?>
					<div class="columns__sidebar columns__sidebar--left lsvr-grid__col lsvr-grid__col--span-3 lsvr-grid__col--pull-9">

						<?php // Left sidebar
						get_sidebar(); ?>

					</div>
				<?php endif; ?>

				<?php if ( lsvr_townpress_has_page_sidebar_right() ) : ?>
					<div class="columns__sidebar columns__sidebar--right lsvr-grid__col lsvr-grid__col--span-3">

						<?php // Right sidebar
						get_sidebar( 'right' ); ?>

					</div>
				<?php endif; ?>

				</div>

			<?php endif; ?>

		</div>
	</div>
</div>
<!-- COLUMNS : end -->