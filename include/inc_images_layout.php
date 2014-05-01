<?php

	function showFour() {
		echo '<div class="col-lg-2">
				<div class="row-fluid">
					<div class="col-lg-6 image-sm image">
						<img src="" border="0" />
					</div>
					
					<div class="col-lg-6 image-sm image">
						<img src="" border="0" />
					</div>
				</div>
				<div class="row-fluid">
					<div class="col-lg-6 image-sm image">
						<img src="" border="0" />
					</div>
					
					<div class="col-lg-6 image-sm image">
						<img src="" border="0" />
					</div>
				</div>
			</div>';
	}
	
	function showTwelve() {
		echo '<div class="col-lg-12">				
				<div class="row-fluid">
					<div class="col-lg-2">
						<div class="row-fluid">
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row-fluid">
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row-fluid">
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row-fluid">
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row-fluid">
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="row-fluid">
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
							
							<div class="col-lg-6 image-sm image">
								<img src="" border="0" />
							</div>
						</div>
					</div>
				</div>
			</div>
			';
	}
	
	function showOne() {
		echo '<div class="col-lg-2">
				<div class="row-fluid">
					<div class="col-lg-12 image-lg image">
						<img src="" border="0" />
					</div>
				</div>
			</div>';
	}
	
	
?>
<div id="images" class="container-fluid">

		<!-- FIRST BIG ROW -->
		<div class="row-fluid">
			
			<?php
			showFour();
			
			showOne();
			
			showFour();
			
			showFour();
			
			showFour();
			
			showOne();
			?>	
		
		</div>
		<div class="clearfix visible-xs"></div>
		
		<!-- SECOND BIG ROW -->
		<div class="row-fluid">
			
			<?php			
			showOne();
			
			showFour();
			
			showFour();
			
			showOne();
			
			showFour();
			
			showFour();
			?>	
		
		</div>
		<div class="clearfix visible-xs"></div>
		
		<!-- THIRD BIG ROW -->
		<div class="row-fluid">
			
			<?php
			showFour();
			
			showFour();
			
			showOne();
			
			showFour();
			
			showOne();
			
			showFour();
			?>
		
		</div>
		<div class="clearfix visible-xs"></div>
		
		<!-- FOURTH CROPPED ROW -->
		<div class="row-fluid">
			
			<?php
			showTwelve();
			?>
		
		</div>
		<div class="clearfix visible-xs"></div>
		
</div>