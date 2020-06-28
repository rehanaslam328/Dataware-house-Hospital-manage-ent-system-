<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dataware house view</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<br>
    <a href="htmlview.php" class="btn btn-primary">Home</a>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-8">
				<h3>Welcome To Dataware House</h3>
			</div>
		</div>
		
	</div>
	<div class="container-fluid">
		<form action="" method="post">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="sel1">Select Factor:</label>
						<select class="form-control" id="sel1" name="option1">
							<option>Total Admit Charges Revenue</option>
							<option>Total service Charges Revenue</option>
							<option>Total no of patients in wards</option>
							<option>Total no of patients check by doctors</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="sel1">Select Year:</label>
						<select class="form-control" id="sel1" name="option2">
							<option>All Years</option>
							<option>1998</option>
							<option>1999</option>
							<option>2000</option>
							<option>2001</option>
							<option>2002</option>
							<option>2003</option>
							<option>2004</option>
							<option>2005</option>
							<option>2006</option>
							<option>2007</option>
							<option>2008</option>
							<option>2009</option>
							<option>2010</option>
							<option>2011</option>
							<option>2012</option>
							<option>2013</option>
							<option>2014</option>
							<option>2015</option>
							<option>2016</option>
							<option>2017</option>
							<option>2018</option>
						</select>
					</div>
				</div>
				<?php
				include 'connection.php';
				if (isset($_POST['submit'])) {
                      	# code...
					$option1= $_POST['option1'];
					$option2= $_POST['option2'];
					if ($option1=="Total no of patients in wards") {
                      	# code...
						?>
						<div class="col-md-3">
							<div class="form-group">
								<label for="">Select Wards</label>
								<select class="form-control" id="sel1" name="option3">
									<option>Cardiology</option>
									<option>Children</option>
									<option>Neurology</option>
									<option>Oncology</option>
									<option>gynaecology</option>
									<option>maternity</option>
									<option>Orthopatic</option>
									<option>PhysioTherapy</option>
									<option>heart</option>
									<option>Eye/year/Nose</option>
									<option>Emergency</option>
									<option>Etymology</option>
								</select>

							</div> 
						</div>
						<?php	
					}elseif ($option1=="Total no of patients check by doctors") {

						$query1="SELECT id,DoctorName FROM faker.doctors"; 
						$Results= sqlsrv_query($con,$query1); 
						?>
						<div class="col-md-3">
							<div class="form-group">
								<label for="sel1">Select Doctors:</label>
								<select class="form-control" id="sel1">
									<?php
									while ($row = sqlsrv_fetch_array($Results, SQLSRV_FETCH_ASSOC)) {
										?>
										<option value="<?php echo $row['id'] ?>"><?php echo $row['DoctorName']; ?></option>
										<?php
									}
									?>

								</select>
							</div>
						</div>

						<?php		 
					}
				}
				?>
			</div>

			<button type="submit" class="btn btn-primary buttonsubmit" name="submit">Submit</button> 
		</form>
		
	</div>

	<div class="container">
		<table  class="table table-bordered table-responsive  table-striped table-hover">

			<?php
			include ('connection.php');
			if (isset($_POST['submit'])) {
				$option1= $_POST['option1'];
				$option2= $_POST['option2'];
				if ($option1=="Total Admit Charges Revenue") {
					if ($option2=="All Years") {

						$query= "SELECT SUM(dbo.facttable.TotalAdmitCharges) as Charges ,faker.times.tyear as year FROM dbo.facttable join faker.times ON faker.times.Tid=dbo.facttable.Tid GROUP BY faker.times.tyear ORDER BY faker.times.tyear"; 
						$getResults= sqlsrv_query($con,$query);
						?>

						<tr>
							<th>Total Charges</th>
							<th>Year</th>


						</tr>

						<?php    
						while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

							?>

							<tr>
								<td><?php echo $row['Charges']; ?></td>
								<td><?php echo $row['year']; ?></td>
							</tr>



							<?php
						}            	  	
					}
					else {
						$query= "SELECT SUM(dbo.facttable.TotalAdmitCharges) as Charges ,faker.times.tyear as year FROM dbo.facttable join faker.times ON faker.times.Tid=dbo.facttable.Tid AND faker.times.tyear='$option2' GROUP BY faker.times.tyear   ORDER BY faker.times.tyear"; 
						$getResults= sqlsrv_query($con,$query);

						?>

						<tr>
							<th>Total Charges</th>
							<th>Year</th>


						</tr>
						<?php
						while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
							?>
							<tr>
								<td><?php echo $row['Charges']; ?></td>
								<td><?php echo $row['year']; ?></td>
							</tr>

							<?php
						}
					}  

				}
				else if ($option1=="Total no of patients in wards"){
					if ($option2=="All Years" ) {
						if (!isset($_POST['option3'])) {
							$query="SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.wards.wardname AS WardName,
							faker.times.tyear AS ByYear FROM dbo.facttable JOIN
							faker.wards ON  dbo.facttable.Wid=faker.wards.id 
							JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid GROUP BY faker.times.tyear,
							faker.wards.wardname 
							ORDER BY faker.times.tyear ";	

							$getResults= sqlsrv_query($con,$query);
							?>
							<tr>
								<th>noOfPatients</th>
								<th>WardName</th>
								<th>ByYear</th>


							</tr>
							<?php
							while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
								?>
								<tr>
									<td><?php echo $row['noOfPatients']; ?></td>
									<td><?php echo $row['WardName']; ?></td>
									<td><?php echo $row['ByYear']; ?></td>
								</tr>

								<?php

							}
						}
						else{
							$option1= $_POST['option1'];
							$option2= $_POST['option2'];
							$option3=$_POST['option3'];
							if (isset($_POST['option3']) && $option2=="All Years"&&
								$option1=="Total no of patients in wards" ) {



								$query="SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.wards.wardname AS WardName,
							faker.times.tyear AS ByYear FROM dbo.facttable JOIN
							faker.wards ON  dbo.facttable.Wid=faker.wards.id AND
							faker.wards.wardname='$option3' 
							JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid GROUP BY faker.times.tyear,
							faker.wards.wardname 
							ORDER BY faker.times.tyear";
							$getResults= sqlsrv_query($con,$query);

							?>
							<tr>
								<th>noOfPatients</th>
								<th>WardName</th>
								<th>ByYear</th>


							</tr>

							<?php
							while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
								
								?>
								<tr>
									<td><?php echo $row['noOfPatients']; ?></td>
									<td><?php echo $row['WardName']; ?></td>
									<td><?php echo $row['ByYear']; ?></td>
								</tr>

								<?php
							}

						}
					}
				}
			        else{
                            $option1= $_POST['option1'];
                            $option2= $_POST['option2'];
                            $option3=$_POST['option3'];
                            if (!isset($_POST['option3']) ) {
                                    # code...
                                $query="SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.wards.wardname AS WardName,
                                faker.times.tyear AS ByYear FROM dbo.facttable JOIN
                                faker.wards ON  dbo.facttable.Wid=faker.wards.id 
                                JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid AND
                                faker.times.tyear='$option2'
                                GROUP BY faker.times.tyear,
                                faker.wards.wardname 
                                ORDER BY faker.times.tyear";
                                $getResults= sqlsrv_query($con,$query);
                                ?>
                                <tr>
                                    <th>noOfPatients</th>
                                    <th>Year</th>
                                    <th>WardName</th>


                                </tr>


                                <?php
                                while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                                            # code...
                                    ?>
                                    <tr>
                                        <td><?php echo $row['noOfPatients']; ?></td>
                                        <td><?php echo $row['ByYear']; ?></td>
                                        <td><?php echo $row['WardName']; ?></td>
                                    </tr>

                                    <?php
                                }

                            }
                            else
                            {
                                $option1= $_POST['option1'];
                                $option2= $_POST['option2'];
                                $option3=$_POST['option3'];

                                    $query="SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.wards.wardname AS WardName,
                                faker.times.tyear AS ByYear FROM dbo.facttable JOIN
                                faker.wards ON  dbo.facttable.Wid=faker.wards.id AND
                                faker.wards.wardname='$option3'
                                JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid AND
                                faker.times.tyear='$option2'
                                GROUP BY faker.times.tyear,
                                faker.wards.wardname 
                                ORDER BY faker.times.tyear";
                                $getResults= sqlsrv_query($con,$query);

                            ?>
                            <tr>
                                <th>noOfPatients</th>
                                <th>WardName</th>
                                <th>Year</th>


                            </tr>

                            <?php
                            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                                            # code...
                                ?>
                                <tr>
                                    <td><?php echo $row['noOfPatients']; ?></td>
                                    <td><?php echo $row['WardName']; ?></td>
                                    <td><?php echo $row['ByYear']; ?></td>
                                </tr>

                                <?php
                            }

                        }
                        }
				}
				else if($option1=="Total service Charges Revenue"){
                    if ($option2=="All Years") {

                        $query= "SELECT SUM(faker.services.serviceCharges) AS TotalServiceCharges,faker.times.tyear AS yearOfCharges
                                  FROM faker.services JOIN dbo.facttable ON faker.services.id=dbo.facttable.serviceid
                                  JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid GROUP BY faker.times.tyear
                                  ORDER BY faker.times.tyear";
                        $getResults= sqlsrv_query($con,$query);
                        ?>

                        <tr>
                            <th>Total Service Charges</th>
                            <th>Year</th>


                        </tr>

                        <?php
                        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

                            ?>

                            <tr>
                                <td><?php echo $row['TotalServiceCharges']; ?></td>
                                <td><?php echo $row['yearOfCharges']; ?></td>
                            </tr>



                            <?php
                        }
                    }
                    else {
                        $query= "SELECT SUM(faker.services.serviceCharges) AS TotalServiceCharges,faker.times.tyear AS yearOfCharges
                                  FROM faker.services JOIN dbo.facttable ON faker.services.id=dbo.facttable.serviceid
                                  JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid AND faker.times.tyear='$option2' GROUP BY faker.times.tyear
                                  ORDER BY faker.times.tyear";
                        $getResults= sqlsrv_query($con,$query);

                        ?>

                        <tr>
                            <th>Total Service Charges</th>
                            <th>Year</th>


                        </tr>
                        <?php
                        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo $row['TotalServiceCharges']; ?></td>
                                <td><?php echo $row['yearOfCharges']; ?></td>
                            </tr>

                            <?php
                        }
                    }
                }
                else if($option1=="Total no of patients check by doctors"){
                    if ($option2=="All Years" ) {
                        if (!isset($_POST['option3'])) {
                            $query="  SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.doctors.id AS DoctorId, 
                                        faker.times.tyear AS ByYear FROM dbo.facttable JOIN
                                        faker.doctors ON  dbo.facttable.Did=faker.doctors.id  JOIN faker.times
                                         ON faker.times.Tid=dbo.facttable.Tid
                                           GROUP BY faker.times.tyear, faker.doctors.id ORDER BY faker.times.tyear";

                            $getResults= sqlsrv_query($con,$query);
                            ?>
                            <tr>
                                <th>noOfPatients</th>
                                <th>Doctor ID</th>
                                <th>Year</th>


                            </tr>
                            <?php
                            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['noOfPatients']; ?></td>
                                    <td><?php echo $row['DoctorId']; ?></td>
                                    <td><?php echo $row['ByYear']; ?></td>
                                </tr>

                                <?php

                            }
                        }
                        else{
                            $option1= $_POST['option1'];
                            $option2= $_POST['option2'];
                            $option3=$_POST['option3'];
                            if (isset($_POST['option3'])) {



                                $query=" SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.doctors.id AS DoctorId, 
                                        faker.times.tyear AS ByYear FROM dbo.facttable JOIN
                                        faker.doctors ON  dbo.facttable.Did=faker.doctors.id  JOIN faker.times
                                         ON faker.times.Tid=dbo.facttable.Tid AND faker.times.tyear='$option2'
                                           GROUP BY faker.times.tyear, faker.doctors.id ORDER BY faker.times.tyear";
                                $getResults= sqlsrv_query($con,$query);

                                ?>
                                <tr>
                                    <th>noOfPatients</th>
                                    <th>Doctor Id</th>
                                    <th>Year</th>


                                </tr>

                                <?php
                                while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

                                    ?>
                                    <tr>
                                        <td><?php echo $row['noOfPatients']; ?></td>
                                        <td><?php echo $row['DoctorId']; ?></td>
                                        <td><?php echo $row['ByYear']; ?></td>
                                    </tr>

                                    <?php
                                }

                            }
                        }
                    }
                    else{
                        $option1= $_POST['option1'];
                        $option2= $_POST['option2'];
                        $option3=$_POST['option3'];
                        if (!isset($_POST['option3']) ) {
                            # code...
                            $query="SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.wards.wardname AS WardName,
                                faker.times.tyear AS ByYear FROM dbo.facttable JOIN
                                faker.wards ON  dbo.facttable.Wid=faker.wards.id 
                                JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid AND
                                faker.times.tyear='$option2'
                                GROUP BY faker.times.tyear,
                                faker.wards.wardname 
                                ORDER BY faker.times.tyear";
                            $getResults= sqlsrv_query($con,$query);
                            ?>
                            <tr>
                                <th>noOfPatients</th>
                                <th>Year</th>
                                <th>WardName</th>


                            </tr>


                            <?php
                            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                                # code...
                                ?>
                                <tr>
                                    <td><?php echo $row['noOfPatients']; ?></td>
                                    <td><?php echo $row['ByYear']; ?></td>
                                    <td><?php echo $row['WardName']; ?></td>
                                </tr>

                                <?php
                            }

                        }
                        else
                        {
                            $option1= $_POST['option1'];
                            $option2= $_POST['option2'];
                            $option3=$_POST['option3'];

                            $query="SELECT COUNT(dbo.facttable.Pid) AS noOfPatients,faker.wards.wardname AS WardName,
                                faker.times.tyear AS ByYear FROM dbo.facttable JOIN
                                faker.wards ON  dbo.facttable.Wid=faker.wards.id AND
                                faker.wards.wardname='$option3'
                                JOIN faker.times ON faker.times.Tid=dbo.facttable.Tid AND
                                faker.times.tyear='$option2'
                                GROUP BY faker.times.tyear,
                                faker.wards.wardname 
                                ORDER BY faker.times.tyear";
                            $getResults= sqlsrv_query($con,$query);

                            ?>
                            <tr>
                                <th>noOfPatients</th>
                                <th>WardName</th>
                                <th>Year</th>


                            </tr>

                            <?php
                            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                                # code...
                                ?>
                                <tr>
                                    <td><?php echo $row['noOfPatients']; ?></td>
                                    <td><?php echo $row['WardName']; ?></td>
                                    <td><?php echo $row['ByYear']; ?></td>
                                </tr>

                                <?php
                            }

                        }
                    }
                }
			}


// sqlsrv_close( $con)
?>





</table>
</div>



</body>
</html>