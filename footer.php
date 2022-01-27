</main>
<footer class="pb-10 md:pb-0">
    <section class="main-container grid md:grid-cols-4 md:gap-10 gap-5">
		<?php for ( $i = 1; $i <= 4; $i++ ): ?>
      <div id="dynamic-footer-<?php echo $i ?>" class="prose">
			  <?php dynamic_sidebar( "footer_{$i}" ); ?>
      </div>
		<?php endfor; ?>
    </section>

	<?php echo FourEightTheme::footer_mobile_menu(); ?>
</footer>
</section>
<!-- /wrapper -->

<?php wp_footer(); ?>
</body>
</html>
