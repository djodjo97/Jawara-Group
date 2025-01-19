<?php
include_once 'layout/header.php';
require 'functions/function_home.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Content Row -->
	<div class="row">

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">
								Total Agen 2025</div>
							<div class="h5 mb-0 font-weight-bold text-primary">
								<?php $totalAgents = getTotalAgents();
								echo  $totalAgents;
								?>
							</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-boxes fa-3x text-primary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">
								Total User 2025</div>
							<div class="h5 mb-0 font-weight-bold text-info">
								<?php
								$totalUsers = getTotalUsers();
								echo $totalUsers; ?>
							</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-boxes fa-3x text-info"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Page Heading -->
	<div class="card">
		<center><img src="img/business.jpg" class="card-img" alt="..."></center>
	</div>
</div>

<?php
include_once 'layout/footer.php';
if (isset($_SESSION['message']) == 'logfail') {
	echo "
	        <script>
	            $.toast({
                    heading: 'Login Berhasil!',
					text: 'Welcome',
					position: 'top-right',
					hideAfter: 3500,
					textAlign: 'center',
					icon: 'success'
                });
	        </script>
	    ";
}
unset($_SESSION['message']);
?>