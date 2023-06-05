CREATE TABLE pacientes (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    clave int NOT NULL,
    hora varchar(20) NOT NULL,
    nombre varchar(50),
    fecha varchar(10),
    edad int,
    peso varchar(10),
    sexo varchar(10),
    talla varchar(10),
    tensArt varchar(10),
    edoCivil varchar(100),
    frCard varchar(100),
    frResp varchar(100),
    imc varchar(100),
    temp varchar(100),
    ahf varchar(500),
    apnp varchar(500),
    app varchar(500),
    pActual varchar(500),
    eFisica varchar(100),
    fechaN varchar(20),
    puestoS varchar(100),
    escolaridad varchar(100),
    lugarOrigen varchar(100),
    analisisCovid varchar(500),
    indicaciones varchar(500),
    visitarUFM Varchar(10),
    observaciones varchar(500),
    cirugias varchar(500),
    traumatismos varchar(500),
    fracturas varchar(500),
    luxaciones varchar(500),
    alergias varchar(500),
    agudezaVisual varchar(20),
    licenciaLentes varchar(10),
    riesgoSalub varchar(20),
    envioOpto varchar(10),
    lentGraduadios varchar(10),
    perAbdominal varchar(10),
    examLab varchar(10),
    tipoSangre varchar(10),
    glucosaCapilar varchar(20),
    iras varchar(500),
    porcentajeOxigeno varchar(100),
    pruevaAplicada varchar(100),
    FechaAplicacion varchar(20),
    horaAplicacion varchar(20) NOT NULL,
    resultado varchar(500),
    diagnostico varchar(500),
    indicacionesFinales varchar(500)
);
/* patien manaje algo */
/* <?php
											$docid=$_SESSION['id'];
											$sql=mysqli_query($con,"select * from tblpatient where Docid='$docid' ");
											$cnt=1;
											while($row=mysqli_fetch_array($sql))
											{
											?>
											<tr>
												<td class="center"><?php echo $cnt;?>.</td>
												<td class="hidden-xs"><?php echo $row['PatientName'];?></td>
												<td><?php echo $row['PatientContno'];?></td>
												<td><?php echo $row['PatientGender'];?></td>
												<td><?php echo $row['CreationDate'];?></td>
												<td><?php echo $row['UpdationDate'];?></td>
												<td>
													<a href="edit-patient.php?editid=<?php echo $row['ID'];?>"><i class="fa fa-edit"></i></a> || <a href="view-patient.php?viewid=<?php echo $row['ID'];?>"><i class="fa fa-eye"></i></a>
												</td>
											</tr>
											<?php 
											$cnt=$cnt+1;
											}?>  */
/* add-patienda form */
-- <div class="form-group">
															/* <label for="doctorname">
																Patient Name
															</label>
															<input type="text" name="patname" class="form-control"  placeholder="Enter Patient Name" required="true">
														</div>
														<div class="form-group">
															<label for="fess">
																Patient Contact no
															</label>
															<input type="text" name="patcontact" class="form-control"  placeholder="Enter Patient Contact no" required="true" maxlength="10" pattern="[0-9]+">
														</div>
														<div class="form-group">
															<label for="fess">
																Patient Email
															</label>
															<input type="email" id="patemail" name="patemail" class="form-control"  placeholder="Enter Patient Email id" required="true" onBlur="userAvailability()">
															<span id="user-availability-status1" style="font-size:12px;"></span>
														</div>
														<div class="form-group">
															<label class="block">
																Gender
															</label>
															<div class="clip-radio radio-primary">
																<input type="radio" id="rg-female" name="gender" value="female" >
																<label for="rg-female">
																	Female
																</label>
																<input type="radio" id="rg-male" name="gender" value="male">
																<label for="rg-male">Male</label>
															</div>
														</div>
														<div class="form-group">
															<label for="address">
																Patient Address
															</label>
															<textarea name="pataddress" class="form-control"  placeholder="Enter Patient Address" required="true"></textarea>
														</div>
														<div class="form-group">
															<label for="fess">
																Patient Age
															</label>
															<input type="text" name="patage" class="form-control"  placeholder="Enter Patient Age" required="true">
														</div>
														<div class="form-group">
															<label for="fess">
																Medical History
															</label>
															<textarea type="text" name="medhis" class="form-control"  placeholder="Enter Patient Medical History(if any)" required="true"></textarea>
														</div>	
														<button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">
															Add
														</button>  */

/* add-patiend2 */
/* ANTIGUO */
			/* $docid=$_SESSION['id'];
			$patname=$_POST['patname'];
			$patcontact=$_POST['patcontact'];
			$patemail=$_POST['patemail'];
			$gender=$_POST['gender'];
			$pataddress=$_POST['pataddress'];
			$patage=$_POST['patage'];
			$medhis=$_POST['medhis'];
			$sql=mysqli_query($con,"insert into tblpatient(Docid,PatientName,PatientContno,PatientEmail,PatientGender,PatientAdd,PatientAge,PatientMedhis) values('$docid','$patname','$patcontact','$patemail','$gender','$pataddress','$patage','$medhis')");
			if($sql){
				echo "<script>alert('Patient info added Successfully');</script>";
				header('location:add-patient.php');
			} */