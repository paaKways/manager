<aside id="sidebar" class="column col-2 sidebar">
					<ul>
					<?php
						if ( $layout_context == 'admin' ){
						echo '<li><a href="manage_content.php">Manage Site Content</a></li>
						<li><a href="admin.php">Visit Main Menu</a></li>
						<li><a href="logout.php">Logout</a></li>';	
						}else{
							echo '<li><a href="index.php">Home Page</a></li>
						<li><a href="login.php">Login to Admin</a></li>';
						}?>
					</ul>
				</aside><!--sidebar-->