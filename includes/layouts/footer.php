		</div><!--outer-->
<?php mysqli_close($link); ?>
	<footer id="footer">Copyright <?php echo htmlentities( date('Y') )?> - &copy;</footer>
	<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	function showNav(){
		
			$('#navigation li:not(:first-child)').slideToggle();
		
	}
	</script>
</body>
</html>