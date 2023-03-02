<!doctype html>
<html lang="en">
<head>
<!--	Works-->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
            crossorigin="anonymous"
    >
    <link rel="stylesheet" href="styles/styles.css">

	<!-- Jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

	<title>Education Plan</title>
</head>

<body>
	<!--NAVBAR-->
	<?php include "includes/navbar.php"; ?>

	<div class="container mt-2 mb-5 pb-5 grfont">
		<div class="row justify-content-center mb-5 pb-5">
			<div class="col text-center">
				<h1 class="pt-5">Educational Planning Worksheet</h1>

				<form class="col-lg-8 offset-lg-2" method="post">
					<div class="form-group text-center mb-2">
						<h4>Student Token: <?php echo $_SESSION['token'] ?></h4>
						<!-- Token Input -->
                        <input id="tokenInput" type="hidden" name="token"
                               value="<?php echo $_SESSION['token'] ?? 'default_value'; ?>">
                    </div>

                    <!--If advisor is present, the value will be the advisor name, else empty String-->
					<label for="advisor">
						Advisor:
						<input
							id="advisor"
							type="text"
							class="form-control text-center m-2 mx-auto w-100 shadow-sm"
							name="advisor"
                            value="<?php echo $_SESSION['advisor'] ?? ''; ?>"
							placeholder="Enter advisor"
						>
					</label>

					<hr class="shadow-sm">

					<div class="float-centered mt-5">
						<button
							id="prevYearBtn"
							class="btn btn-lg bg-secondary text-white shadow-sm"
							type="button"
						>Add Year</button>
					</div>

					<div id="schoolYears">
						<repeat group="{{ @schoolYears }}" key="{{ @year }}"
                                value="<?php echo $_SESSION['schoolYear'] ?? ''; ?>">
						<check if="<?php echo $_SESSION['schoolYear']['2023']['render'] ?? ''; ?>">
							<div id="{{ @year }}" class="container p-0">

								<!-- Year Separator -->
								<div class="col-sm">
									<h3 class="text-end text-secondary mb-0">
                                        <?php echo implode($_SESSION['schoolYears']['2023']['winter']) ?? ''; ?></h3>
									<input
										type="hidden"
										value="{{ @year }}"
										name="schoolYears[{{ @year }}][schoolYear]"
									>
								</div>
								<hr class="shadow-sm mt-0">

								<div class="row">
									<!-- Fall Quarter -->
									<div class="col-sm">
										<div>
											<h4 class="d-inline">Fall Quarter</h4>
											<h5>
                                                <?php echo implode($_SESSION['schoolYears']['2023']['fall']) ?? ''; ?>
                                            </h5>
										</div>

										<div class="input-group m-2">
											<div class="input-group m-2 mb-0">
												<!-- declaration for first field -->
												<textarea
													class="form-control w-50 inputlg shadow-sm"
													rows="8"
													name="schoolYears[{{ @year }}][fall][notes]"
													placeholder="Enter classes"
												>{{ @schoolYear['fall']['notes'] }}</textarea>
											</div>
										</div>
									</div>
									<!-- Winter Quarter -->
									<div class="col-sm">
										<div>
											<h4 class="d-inline">Winter Quarter</h4>
                                            <h5>
                                                <?php echo implode($_SESSION['schoolYears']['2023']['winter']) ?? ''; ?>
                                            </h5>
										</div>

										<div class="input-group m-2">
											<div class="input-group m-2 mb-0">
												<!-- declaration for first field -->
												<textarea
													class="form-control w-50 inputlg shadow-sm"
													rows="8"
													name="schoolYears[{{ @year }}][winter][notes]"
													placeholder="Enter classes"
												>{{ @schoolYear['winter']['notes'] }}</textarea>
											</div>
										</div>
									</div>
								</div>

								<div class="row mt-5">
									<!-- Spring Quarter -->
									<div class="col-sm">
										<div>
											<h4 class="d-inline">Spring Quarter</h4>
                                            <h5>
                                                <?php echo implode($_SESSION['schoolYears']['2023']['spring']) ?? ''; ?>
                                            </h5>
										</div>

										<div class="input-group m-2">
											<div class="input-group m-2 mb-0">
												<!-- declaration for first field -->
												<textarea
													class="form-control w-50 inputlg shadow-sm"
													rows="8"
													name="schoolYears[{{ @year }}][spring][notes]"
													placeholder="Enter classes"
												>{{ @schoolYear['spring']['notes'] }}</textarea>
											</div>
										</div>
									</div>
									<div class="col-sm">
										<div>
											<h4 class="d-inline">Summer Quarter</h4>
                                            <h5>
                                                <?php echo implode($_SESSION['schoolYears']['2023']['summer']) ?? ''; ?>
                                            </h5>
										</div>

										<div class="input-group m-2 mb-4">
											<div class="input-group m-2 mb-0">
												<!-- declaration for first field -->
												<textarea class="form-control w-50 inputlg shadow-sm"
													rows="8"
													name="schoolYears[{{ @year }}][summer][notes]"
													placeholder="Enter classes"
												>{{ @schoolYear['summer']['notes'] }}</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</check>
						</repeat>
					</div>

					<div class="float-centered mt-5">
						<button
							id="nextYearBtn"
							class="btn btn-lg bg-secondary text-white shadow-sm"
							type="button"
						>Add Year</button>
					</div>

					<div class="float-centered mt-3">
						<button class="btn btn-lg bg-grcgreen text-white shadow-sm" type="submit">
							SAVE EDUCATION PLAN
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Save Notification -->
	<check if="{{ @formSubmitted }}">
		<check if="{{ @saveSuccess }}">
			<true>
				<!-- Success -->
				<div class="toast-container position-fixed bottom-0 end-0 p-3">
					<div id="saveNotification" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
						<div class="toast-header text-success">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill me-2" viewBox="0 0 16 16">
								<path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
							</svg>
							<strong class="me-auto">Success!</strong>
							<small>{{ @lastUpdated }}</small>
							<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
						</div>
						<div class="toast-body">
							Plan successfully saved.
						</div>
					</div>
				</div>
			</true>
			<false>
				<!-- Error -->
				<div class="toast-container position-fixed bottom-0 end-0 p-3">
					<div id="saveNotification" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
						<div class="toast-header text-danger">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill me-2" viewBox="0 0 16 16">
								<path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
							</svg>
							<strong class="me-auto">Error!</strong>
							<small>{{ @lastUpdated }}</small>
							<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
						</div>
						<div class="toast-body">
							There was an error saving plan data.
						</div>
					</div>
				</div>
			</false>
		</check>
	</check>

	<!--Including the JS for the file-->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
			integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
			crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
			integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
			crossorigin="anonymous"></script>
	<!-- Script to add years to form -->
	<script src="../scripts/addYearsToForm.js"></script>

	<check if="{{ @formSubmitted }}">
		<script src="../scripts/saveNotification.js"></script>
	</check>
</body>
</html>