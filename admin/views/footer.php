			</div>
			<footer>
				<div class="container-fluid">
					<p class="copyright">Designed and Created by X-Toria Caca Play.</p>
				</div>
			</footer>
		</div>
	</div>
</body>

</html>
<script>
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
  $('.dropdown-menu a').click(function(e){
    e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
     $(this).find('.submenu').hide();
  })
  });
}
</script>