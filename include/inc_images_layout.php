<?php

	function showFour() {
		echo '<div class="col-lg-2 col-xs-4">
				<div class="row">
					<div class="col-lg-6 image-sm image">
						<img src="images/pixel.gif" />
					</div>
					
					<div class="col-lg-6 image-sm image">
						<img src="images/pixel.gif" />
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 image-sm image">
						<img src="images/pixel.gif" />
					</div>
					
					<div class="col-lg-6 image-sm image">
						<img src="images/pixel.gif" />
					</div>
				</div>
			</div>';
	}
	
	function showTwelve() {
		echo '<div class="col-lg-12">				
				<div class="row">
					<div class="col-lg-2">
						<div class="row">
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row">
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row">
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row">
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row">
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row">
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="images/pixel.gif" />
							</div>
						</div>
					</div>
				</div>
			</div>
			';
	}
	
	function showOne() {
		echo '<div class="col-lg-2 col-xs-8">
				<div class="row">
					<div class="col-lg-12 image-lg image">
						<img src="images/pixel.gif" />
					</div>
				</div>
			</div>';
	}
	
?>
<div id="images" class="container-fluid">

		<!-- FIRST BIG ROW -->
		<div class="row">
			<?php
			showOne();
			showFour();
			showFour();
			showFour();
			showOne();
			showFour();
			?>	
		</div>
		<div class="clearfix visible-xs"></div>
		
		<!-- SECOND BIG ROW -->
		<div class="row">
			<?php			
			showFour();
			showFour();
			showOne();
			showFour();
			showFour();
			showOne();
			?>	
		</div>
		<div class="clearfix visible-xs"></div>
		
		<!-- THIRD BIG ROW -->
		<div class="row">
			<?php
			showFour();
			showOne();
			showFour();
			showOne();
			showFour();
			showFour();
			?>
		</div>
		<div class="clearfix visible-xs"></div>
		
		<!-- FOURTH CROPPED ROW -->
		<div class="row">
			<?php
			showTwelve();
			?>
		</div>
		<div class="clearfix visible-xs"></div>
		
</div>